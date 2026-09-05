<?php

namespace App\Http\Controllers\User;
use App\Notifications\TransferNotification; 
use App\Notifications\SenderTransferNotification; 
use App\Notifications\RecipientSubmittedNotification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Validation\ValidationException; 
use DB; 
use Auth; 
use Log;  
use Hash;
use App\Models\Transfer;
use App\Models\Sell;
use App\Models\Buy;
use App\Models\User;
use App\Models\Property;
use App\Models\Wallet;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use App\Models\VirtualAccount;
use App\Models\CustomNotification;
use App\Services\PaystackService;
 
class TransferPropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    public function index(){ 
        if(!Auth::user()){
            return redirect()->route('login');
        } 
        $user = Auth::user();

        $data['sellProperty'] = Buy::select('*')
        ->with('property') 
        ->where('user_id', $user->id)
        ->where('user_email', $user->email)
        ->orderBy('created_at', 'desc') 
        ->paginate(10);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' =>  $data['sellProperty']
            ]);
        }

        return view('user.pages.properties.transfer.index', $data); 
    } 


    public function verifyRecipient(Request $request){

        if(!Auth::user()){
            return redirect()->route('login');
        }

        $data['amount']        = $request->input('amount');
        $data['propertyImage'] = $request->input('property_image');
        $data['propertyName']  = $request->input('property_name');
        $data['landSize']      = $request->input('selected_size_land');
        $data['propertySlug']  = $request->input('property_slug');
        $data['propertyId']    = $request->input('property_id');
        $data['buyId']         = $request->input('buy_id');

        $recipientId = $request->input('recipient_id');
        $data['recipientData'] = User::where('recipient_id', $recipientId)->first();

        if (!$data['recipientData']) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'This recipient does not exist.'], 404);
            }
            return redirect()->route('user.transfer')->with('error', 'This recipient does not exist.');
        }

        $buy = Buy::find($data['buyId']);

        if ($buy) {
            $purchaseDate = \Carbon\Carbon::parse($buy->created_at);
            $totalDays    = 365;
            $roiDueDate   = $purchaseDate->copy()->addDays($totalDays);

            $daysElapsed  = \Carbon\Carbon::today()->diffInDays($purchaseDate) + 1;
            $daysElapsed  = min($totalDays, max(1, $daysElapsed));
            $isMatured    = \Carbon\Carbon::today()->greaterThanOrEqualTo($roiDueDate);

            $avgMonthLength = $totalDays / 12;
            $monthsElapsed   = $isMatured ? 12 : (int) floor(($daysElapsed - 1) / $avgMonthLength);
            $daysIntoMonth   = $isMatured ? 0  : $daysElapsed - (int) floor($monthsElapsed * $avgMonthLength);

            $roiPercentage = $buy->roi_percentage ?? 0;
            $totalROI      = $buy->total_price * ($roiPercentage / 100);
            $monthlyROI    = $totalROI / 12;

            $data['purchaseDate']  = $purchaseDate;
            $data['roiDueDate']    = $roiDueDate;
            $data['daysElapsed']   = $daysElapsed;
            $data['isMatured']     = $isMatured;
            $data['monthsElapsed'] = $monthsElapsed;
            $data['daysIntoMonth'] = $daysIntoMonth;
            $data['roiPercentage'] = $roiPercentage;
            $data['totalROI']      = $totalROI;
            $data['monthlyROI']    = $monthlyROI;
        }
        // dd($data);
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'data' => $data]);
        }

        return view('user.pages.properties.transfer.verifyRecipient', $data); 
    }
      
    
    public function submitTransferRequest(Request $request)
    { 
        if(!Auth::user()){
            return redirect()->route('login');
        }
        try {
            // Validate the request
            $validated = $request->validate([
                'property_slug' => 'required',
                'property_id' => 'required|integer',
                'buy_id' => 'required|integer|exists:buys,id',
                'recipient_id' => 'required',
                'amount' => 'required|numeric|min:0.01',
                'transaction_pin' => 'required|digits:4'
            ], [
                'property_slug.required' => 'Property identifier is missing',
                'property_id.required' => 'Property ID is required',
                'property_id.integer' => 'Invalid property ID format',
                'buy_id.required' => 'The source asset reference is missing',
                'buy_id.exists' => 'The source asset could not be found',
                'recipient_id.required' => 'Recipient ID is required',
                'amount.required' => 'Amount is required',
                'amount.numeric' => 'Amount must be a number',
                'amount.min' => 'Amount must be at least 0.01',
                'transaction_pin.required' => 'Transaction PIN is required',
                'transaction_pin.digits' => 'PIN must be exactly 4 digits'
            ]);
        } catch (ValidationException $e) {
            return $this->errorResponse(
                $request->input('property_id'), // propertyId
                $request,                // request data
                $e->getMessage(),                   // validation errors (not as string)
                422                             // HTTP status code
            );
        }
        
        $user = Auth::user();

        $sendWallet = Wallet::where('user_id', $user->id)->first();
        // Ensure sender has enough balance
        if ($sendWallet->balance < ($request->input('amount') / 100)) {
            return redirect()->back()->with(['error' => 'Insufficient wallet balance']);
        }

        $propertyId = $request->input('property_id');

        // Check if PIN is required and set
        if (config('app.enable_transaction_pin')) {
            if (empty($user->transaction_pin)) {
                return $this->errorResponse($propertyId, $request, 'Please set your transaction PIN first.', 403, [
                    'redirect_url' => route('user.transaction.pin'),
                    'requires_pin_setup' => true
                ]);
            }

            // Check if PIN is locked
            if ($user->pin_locked_until && now()->lessThan($user->pin_locked_until)) {
                return $this->errorResponse($propertyId, $request, 'Your PIN is locked. Try again after ' . $user->pin_locked_until->diffForHumans(), 423);
            }
        }

        // Verify the provided PIN
        if (!Hash::check($request->transaction_pin, $user->transaction_pin)) {
            $user->increment('failed_pin_attempts');
            $user->update(['last_failed_pin_attempt' => now()]);

            $maxAttempts = 3;
            $remainingAttempts = max(0, $maxAttempts - $user->failed_pin_attempts);

            if ($remainingAttempts <= 0) {
                $lockoutTime = now()->addMinutes(1);
                $user->update(['pin_locked_until' => $lockoutTime]);

                return $this->pinErrorResponse($request, 'Too many failed attempts. Try again after 1 minute.', 429);
            }

            return $this->pinErrorResponse($request, "Invalid transaction PIN. {$remainingAttempts} attempt(s) remaining.", 401);
        }

        // Reset failed attempts on success
        $user->update([
            'failed_pin_attempts' => 0,
            'last_failed_pin_attempt' => null,
            'pin_locked_until' => null
        ]);

        try {
            $amount = $request->input('amount');
            $recipientId = $request->input('recipient_id');
            $propertySlug = $request->input('property_slug');
            $landSize = $request->input('selected_size_land');
            $buyId = $request->input('buy_id');

            // Check if recipient exists and isn't the user
            $recipient = User::where('recipient_id', $recipientId)->first();
    
            if (!$recipient) {
                return $this->errorResponse($propertyId, $request, 'This recipient does not exist.', 423);
            }

            if ($recipientId == $user->id) {
                return $this->errorResponse($propertyId, $request, 'You cannot transfer the property to yourself.', 423);
            }

            // Check if the property exists
            $propertyData = Property::where('id', $propertyId)
                ->where('slug', $propertySlug)
                ->first();

            if (!$propertyData) {
                return $this->sendResponse($request, 'error', 'Property not found.', false);
            }
            $totalAmount =  Transaction::where('user_id', $user->id)
                                    ->where('email', $user->email)
                                    ->sum('amount');

            if($totalAmount < $amount){
                return $this->sendResponse($request, 'error', 'Insufficient Assets available for transfer.', false);
            }

            // Prevent submitting a transfer request for an asset that already has one pending
            $buy = Buy::where('id', $buyId)
                ->where('user_id', $user->id)
                ->first();

            if (!$buy) {
                return $this->sendResponse($request, 'error', 'This asset does not belong to you.', false);
            }

            if ($buy->status === 'transfer_pending') {
                return $this->sendResponse($request, 'error', 'This property already has a transfer pending recipient acceptance.', false);
            }

            // Rebuild the displayed details from the sender's owned Buy record
            // instead of trusting editable hidden financial values.
            $purchaseDate = \Carbon\Carbon::parse($buy->created_at);
            $totalDays = 365;
            $roiDueDate = $purchaseDate->copy()->addDays($totalDays);
            $daysElapsed = min($totalDays, max(1, \Carbon\Carbon::today()->diffInDays($purchaseDate) + 1));
            $isMatured = \Carbon\Carbon::today()->greaterThanOrEqualTo($roiDueDate);
            $avgMonthLength = $totalDays / 12;
            $monthsElapsed = $isMatured ? 12 : (int) floor(($daysElapsed - 1) / $avgMonthLength);
            $daysIntoMonth = $isMatured ? 0 : $daysElapsed - (int) floor($monthsElapsed * $avgMonthLength);
            $roiPercentage = (float) ($buy->roi_percentage ?? 0);
            $totalROI = (float) $buy->total_price * ($roiPercentage / 100);
            $monthlyROI = $totalROI / 12;

            $propertyDetails = [
                'purchase_date' => $purchaseDate,
                'roi_percentage' => $roiPercentage,
                'total_roi' => $totalROI,
                'monthly_roi' => $monthlyROI,
                'roi_due_date' => $roiDueDate,
                'is_matured' => $isMatured,
                'months_elapsed' => $monthsElapsed,
                'days_into_month' => $daysIntoMonth,
            ];

            // Generate a unique reference
            $reference = 'TRANS-' . strtoupper(Str::random(10));

            // Create the transfer record and lock the source Buy row together,
            // so index() never shows a live Transfer button on an asset whose lock failed
            $transfer = DB::transaction(function () use ($propertyData, $propertyDetails, $landSize, $user, $reference, $recipientId, $amount, $buyId) {
                $transfer = Transfer::create(array_merge([
                    'property_id' => $propertyData->id,
                    'buy_id' => $buyId,
                    'property_name' => $propertyData->name,
                    'land_size' => $landSize,
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'reference' => $reference,
                    'recipient_id' => $recipientId,
                    'total_price' => $amount,
                    'status' => 'pending',
                    'confirmation_status' => 'pending',
                ], $propertyDetails));

                Buy::where('id', $buyId)->update(['status' => 'transfer_pending']);

                return $transfer;
            });

            // Prepare transfer details
            $transferDetails = [
                'transfer_id' => $transfer->id,
                'buy_id' => $buyId,
                'property_id' => $propertyData->id,
                'property_slug' => $propertyData->slug,
                'property_name' => $propertyData->name,
                'property_image' => $propertyData->property_images,
                'land_size' => $landSize,
                'total_price' => $amount * 100,
                'reference' => $reference,
                'sender_id' => $user->id,
                'recipient_id' => $recipientId,
                'property_mode' => 'transfer',
                'status' => 'pending',
                'purchase_date' => $purchaseDate->toIso8601String(),
                'roi_percentage' => $roiPercentage,
                'total_roi' => $totalROI,
                'monthly_roi' => $monthlyROI,
                'roi_due_date' => $roiDueDate->toIso8601String(),
                'is_matured' => $isMatured,
                'months_elapsed' => $monthsElapsed,
                'days_into_month' => $daysIntoMonth,
            ];

            // Save in-app notifications immediately so they appear on the
            // notifications page and bell independently of email delivery.
            try {
                Notification::sendNow(
                    $recipient,
                    new RecipientSubmittedNotification($transferDetails, ['database'])
                );
                Notification::sendNow(
                    $user,
                    new SenderTransferNotification($transferDetails, ['database'])
                );
            } catch (\Exception $e) {
                Log::error('In-app transfer notification error: ' . $e->getMessage());
            }

            // Email is handled separately so a mail failure cannot prevent the
            // database notifications above from reaching the user interface.
            try {
                $recipient->notify(new RecipientSubmittedNotification($transferDetails, ['mail']));
                $user->notify(new SenderTransferNotification($transferDetails, ['mail']));
            } catch (\Exception $e) {
                Log::error('Transfer email notification error: ' . $e->getMessage());
            }
 
            return $this->sendResponse($request, 'success', 'We have received your request to transfer ₦' . number_format($amount) . ' worth of property. The recipient has been notified.', true, [
                'redirect' => route('user.transfer.history'),
                'transfer_details' => $transferDetails,
            ]);
        } catch (\Exception $e) {
            return $this->sendResponse($request, 'error', 'Something went wrong: ' . $e->getMessage(), false);
        }
    }

    protected function pinErrorResponse(Request $request, $message, $statusCode)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => 'error',
                'message' => $message,
            ], $statusCode);
        }

        return redirect()->route('user.transfer.checkRecipient', [
            'property_id'        => $request->input('property_id'),
            'property_slug'      => $request->input('property_slug'),
            'property_name'      => $request->input('property_name'),
            'property_image'     => $request->input('property_image'),
            'recipient_id'       => $request->input('recipient_id'),
            'amount'             => $request->input('amount'),
            'selected_size_land' => $request->input('selected_size_land'),
            'buy_id'             => $request->input('buy_id'),
        ])->with('error', $message);
    }

    public function transferRecipient(Request $request){
        if(!Auth::user()){
            return redirect()->route('login');
        }
       
        $request->validate([
            'remaining_size' => 'required|numeric|min:0',
            'property_slug' => 'required|string',
            'calculated_size' => 'required|numeric|min:0.0001', // Minimum 0.0001 SQM
            'amount' => 'required|numeric|min:1000', // Minimum ₦1000
            'total_price' => 'required|numeric|min:1',
        ], [
            'remaining_size.required' => 'Remaining size is required',
            'remaining_size.numeric' => 'Remaining size must be a number',
            'remaining_size.min' => 'Remaining size cannot be negative',
            
            'property_slug.required' => 'Property slug is required',
            'property_slug.string' => 'Property slug must be a string',
            
            'calculated_size.required' => 'Calculated land size is required',
            'calculated_size.numeric' => 'Calculated land size must be a number',
            'calculated_size.min' => 'Calculated land size must be at least 0.0001 SQM',
            
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount must be a number',
            'amount.min' => 'Minimum transfer amount is ₦1,000',
            
            'total_price.required' => 'Total price is required',
            'total_price.numeric' => 'Total price must be a number',
            'total_price.min' => 'Total price must be at least ₦1',
        ]);
        try {
        $user = Auth::user();
        $propertySlug  = $request->input('property_slug');

        $property = Property::where('slug', $propertySlug)->first();
        // Check if the property exists
        if (!$property) {
            return back()->with('error', 'Property not found.');
        } 
        $reference = 'PRO-TRANSFER-REF-' . time() . '-' . strtoupper(Str::random(8));
        $selectedSizeLand  = $request->input('calculated_size');
        $remainingSize  = $request->input('remaining_size');
        $amount  = $request->input('total_price');
        $propertySlug = $request->input('property_slug');
        $propertyId  = $property->id;
        $propertyName  =  $property->name;

        $propertyData = Property::where('id', $propertyId)->where('name', $propertyName)->first();
        $data = [
            'amount' => $amount , 
            'property_id' => $propertyData->id,
            'property_name' => $propertyData->name,
            'email' => $user->email,
            'metadata' => [
                'property_id' => $propertyData->id,
                'property_name' => $propertyData->name,
                'property_image' => $propertyData->property_images,
                'remaining_size' => $remainingSize,
                'selected_size_land' => $selectedSizeLand,
                'property_slug' => $propertySlug,
            ],
            'reference' => $reference,
            'property_state' => $property->property_state,
        ];
        // dd($data);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ]);
        } 

            return view('user.pages.properties.transfer.recipient', compact('data')); 
        } catch (\Exception $e) {
            return back()->with('error', 'Transfer failed: ' . $e->getMessage());
        }
    }

    
    protected function errorResponse($propertyId, Request $request, $message, $statusCode)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => 'error',
                'message' => $message,
                // 'data' => $data,
            ], $statusCode);
        }

        return redirect()->route('user.transfer')
            ->with('error', $message);
    }

    private function sendResponse(Request $request, $status, $message, $success, $additionalData = [])
    {
        if ($request->wantsJson() || $request->is('api/*')) {
            // For API/mobile requests
            return response()->json([
                'success' => $success,
                'status' => $status,
                'message' => $message,
                'data' => $additionalData,
            ], $success ? 200 : 400);
        } else {
            // For web requests
            if ($success) {
                return redirect()->route('user.transfer.history')->with($status, $message);
            } else {
                return back()->with($status, $message);
            }
        }
    }

    public function transferHistory(Request $request){ 
        $user = Auth::user();
       
        $data['transferProperty'] = Transfer::select(
            '*'
        )
        ->with('property') 
        ->with('valuationSummary')
        ->where('user_id', $user->id) 
        ->where('user_email', $user->email) 
        ->orderBy('created_at', 'desc')
        ->paginate(10);
 
         // Check if request expects JSON (API/mobile)
         if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Transfer Property History retrieved successfully',
                'data' => $data['transferProperty'],
            ]);
        }

        return view('user.pages.properties.transfer.history', $data); 
    }
    
    
    public function confirmTransfer(Request $request, $propertyMode, $slug)
    {
        
        $user = Auth::user();

        $property = Property::where('slug', $slug)->first();
        if (!$property) {
            return $this->handleResponse($request, 'Property not found', 404);
        }

        $senderNotification = $user->notifications()
            ->whereJsonContains('data->property_mode', $propertyMode)
            ->whereJsonContains('data->recipient_id', $user->id)
            ->whereJsonContains('data->property_slug', $slug)
            ->first();

        if (!$senderNotification) {
            return $this->handleResponse($request, 'No transfer notification found', 404);
        }
    
        $sender = User::find($senderNotification['data']['sender_id']);
    
        $responseData = [
            'property' => $property,
            'transferData' => $senderNotification['data'],
            'sender' => $sender,
        ];
    
        // Return JSON for mobile, Blade view for web
        return $this->handleResponse($request, $responseData);
    }

    private function handleResponse(Request $request, $data, $status = 200)
    {
        if ($request->expectsJson()) {
            return response()->json(['success' => $status === 200, 'data' => $data], $status);
        }

        if (is_string($data)) {
            return redirect()->back()->with('error', $data);
        }

        return view('user.pages.properties.transfer.property_confirmation', $data);
    }

    public function viewTransferProperty(Request $request, $recipentId){

    }



    public function submitConfirmation(Request $request, $id)
    {
        DB::beginTransaction();
        
        try {
            $recipient = auth()->user();
            
            // Validate request data
            $validatedData = $request->validate([
                'sender_id' => 'required|exists:users,id',
                'property_id' => 'required|exists:properties,id',
                'property_slug' => 'required',
                'amount' => 'required|numeric|min:1000',
            ]);

            // Extract validated data
            $senderId = $validatedData['sender_id'];
            $propertyId = $validatedData['property_id'];
            $amount = $validatedData['amount'];

            // The notification is the trusted source for the transfer details.
            $notification = CustomNotification::where('id', $id)
                ->where('notifiable_id', $recipient->id)
                ->first();
            if (!$notification) {
                throw new \Exception('Notification not found', 404);
            }

            $notificationData = $notification->data;
            $senderId = $notificationData['sender_id'] ?? $senderId;
            $propertyId = $notificationData['property_id'] ?? $propertyId;
            $propertySlug = $notificationData['property_slug'] ?? $validatedData['property_slug'];
            $landSize = $notificationData['land_size'] ?? $request->input('land_size');
            $amount = $notificationData['total_price'] ?? $amount;
            $transferRecipientId = $notificationData['recipient_id'] ?? $recipient->recipient_id;

            $transfer = Transfer::where('id', $notificationData['transfer_id'] ?? 0)
                ->where('reference', $notificationData['reference'] ?? '')
                ->where('user_id', $senderId)
                ->where('recipient_id', $transferRecipientId)
                ->where('property_id', $propertyId)
                ->where('status', 'pending')
                ->lockForUpdate()
                ->first();
            if (!$transfer) {
                throw new \Exception('Pending transfer not found', 404);
            }

            // Find sender
            $sender = User::find($senderId);
            if (!$sender) {
                throw new \Exception('Sender not found', 404);
            }
            // Process wallet transactions
            $propertyData = Property::where('id', $propertyId)
                ->where('slug', $propertySlug)
                ->first();
            if (!$propertyData) {
                throw new \Exception('Property not found', 404);
            }

            // Validate amount
            if ($amount <= 0) {
                throw new \Exception('Invalid transfer amount', 400);
            }

            // Find wallets
            $sendWallet = Wallet::where('user_id', $sender->id)->first();
            $recipientWallet = Wallet::where('user_id', $recipient->id)->first();
            
            if (!$sendWallet || !$recipientWallet) {
                throw new \Exception('Wallet configuration error', 400);
            }
            $recipientWallet =  Wallet::where('user_id', $recipient->id)->first();
            $requiredAmountInNaira = $amount / 100; // Convert amount to the same unit as balance
            // Ensure recipientWallet has enough balance
            if ($recipientWallet->balance < $requiredAmountInNaira) {
                if ($request->wantsJson()) {
                    return response()->json(['error' => 'You do not has insufficient funds, Please fund your wallet'], 404);
                }
                return redirect()->back()->with(['error' => 'Insufficient wallet balance, Please fund your wallet']);
            }
            
            // Check notification status
            if (($notificationData['status'] ?? null) !== 'pending') {
                throw new \Exception('Invalid notification data', 400);
            }
            
            // Check sender's wallet balance
            if ($recipientWallet->balance < $requiredAmountInNaira) {
            
                return redirect()->back()->with(['error' => 'You do not has insufficient funds']);
            }

            // Process land transfer
            $buyRecords = Buy::select(
                    'id',
                    'property_id',
                    'status',
                    'selected_size_land',
                    DB::raw('SUM(selected_size_land) as total_selected_size_land'),
                    DB::raw('MAX(created_at) as latest_created_at')
                )
                ->with('property')
                ->where('user_id', $sender->id)
                ->where('user_email', $sender->email)
                ->groupBy('id', 'property_id', 'status', 'selected_size_land')
                ->get();

            $totalLandSize = $buyRecords->sum('selected_size_land');

            
            // Create new buy record for recipient
            Buy::create([
                'property_id' => $propertyId,
                'transaction_id' => null,
                'selected_size_land' => $landSize,
                // 'remaining_size' => $totalLandSize - $landSize,
                'user_id' => $recipient->id,
                'user_email' => $recipient->email,
                'total_price' => $requiredAmountInNaira,
                'total_amount' => $requiredAmountInNaira,
                'roi_percentage' => $notificationData['roi_percentage'] ?? $transfer->roi_percentage,
                'totalROI' =>  $notificationData['total_roi'] ?? $transfer->total_roi,
                'status' => 'transfer',
            ]);

            

            // Update wallet balances
            $sendWallet->balance += $requiredAmountInNaira;
            $sendWallet->save();

            $recipientWallet->balance -= $requiredAmountInNaira;
            $recipientWallet->save();

            // Create transaction records
            $reference = 'TRXDOHREF-' . strtoupper(Str::random(8));

            Transaction::create([
                'user_id' => $sender->id,
                'email' => $sender->email,
                'transaction_type' => 'buy',
                'property_id' => $propertyId,
                'property_name' => $propertyData->name,
                'status' => 'success',
                'payment_method' => 'wallet',
                'amount' => -$requiredAmountInNaira,
                'description' => 'Transfer to ' . $recipient->email,
                'reference' => $reference.'-D',
                'transaction_state' => 'success',
            ]);

            Transaction::create([
                'user_id' => $recipient->id,
                'email' => $recipient->email,
                'transaction_type' => 'buy',
                'property_id' => $propertyId,
                'property_name' => $propertyData->name,
                'status' => 'success',
                'payment_method' => 'card',
                'amount' => $requiredAmountInNaira,
                'description' => 'Received from ' . $sender->email,
                'reference' => $reference.'-C',
                'transaction_state' => null,
            ]);

            // Update notification
            $notificationData['status'] = 'approved';
            $notification->update(['data' => $notificationData]);

            // Persist the property details that were shown in the notification.
            $transfer->update([
                'property_id' => $propertyId,
                'buy_id' => $notificationData['buy_id'] ?? $transfer->buy_id,
                'property_name' => $notificationData['property_name'] ?? $propertyData->name,
                'land_size' => $landSize,
                'purchase_date' => $notificationData['purchase_date'] ?? $transfer->purchase_date,
                'roi_percentage' => $notificationData['roi_percentage'] ?? $transfer->roi_percentage,
                'total_roi' => $notificationData['total_roi'] ?? $transfer->total_roi,
                'monthly_roi' => $notificationData['monthly_roi'] ?? $transfer->monthly_roi,
                'roi_due_date' => $notificationData['roi_due_date'] ?? $transfer->roi_due_date,
                'is_matured' => $notificationData['is_matured'] ?? $transfer->is_matured,
                'months_elapsed' => $notificationData['months_elapsed'] ?? $transfer->months_elapsed,
                'days_into_month' => $notificationData['days_into_month'] ?? $transfer->days_into_month,
                'status' => 'approved',
                'confirmation_status' => 'confirmed',
                'confirmation_date' => now(),
                'confirmed_by' => auth()->id(),
            ]);

            DB::commit(); 

            // Notifications must not prevent a completed transfer from being saved.
            try {
                $sender->notify(new TransferNotification($recipient, $amount, 'Sender', $propertyData));
                $recipient->notify(new TransferNotification($sender, $amount, 'Recipient', $propertyData));
            } catch (\Throwable $notificationException) {
                Log::warning('Transfer completion notification failed: ' . $notificationException->getMessage());
            }

            // Return appropriate response
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Amount transferred successfully!',
                    'data' => [
                        'reference' => $reference,
                        'amount' => $amount,
                        'land_size' => $landSize,
                    ]
                ], 200);
            }

            return redirect()->route('user.dashboard')->with('success', 'Assets transferred successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::warning("Error: {$e->getMessage()}");
            $statusCode = is_int($e->getCode()) && $e->getCode() >= 400 && $e->getCode() < 600 
                ? $e->getCode() 
                : 400;

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'error_code' => $statusCode
                ], $statusCode);
            }

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
 
    
}
 
