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
       
        $data['sellProperty'] = Buy::select(
            'property_id', 
            DB::raw('SUM(selected_size_land) as total_selected_size_land'),
            DB::raw('MAX(created_at) as latest_created_at') 
        )
        ->with('property')
        ->with('valuationSummary')
        ->where('user_id', $user->id)
        ->where('user_email', $user->email)
        ->groupBy('property_id') 
        ->paginate(10);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' =>  $data['sellProperty']
            ]);
        }

        return view('user.pages.properties.transfer.index', $data); 
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
        // dd('coorect');
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

    public function verifyRecipient(Request $request){
        
        if(!Auth::user()){
            return redirect()->route('login');
        }
        // $request->validate([
        //     'property_id' => 'required',
        //     'property_name' => 'required',
        //     'amount' => 'required',
        //     'selected_size_land' => 'required',
        //     'recipient_id' => 'required',
        //     'property_image' => 'string',
        //     'property_slug' => 'string',
        // ]);
        $data['amount'] = $request->input('amount');
        $data['propertyImage']  = $request->input('property_image');
        $data['propertyName']  = $request->input('property_name');
        $recipientId = $request->input('recipient_id');
        $data['landSize'] = $request->input('selected_size_land');
        $data['propertySlug'] = $request->input('property_slug');
        $data['propertyId'] = $request->input('property_id');

        $recipientId = $request->input('recipient_id');
        $data['recipientData'] = User::where('recipient_id', $recipientId)->first();
            
        if (!$data['recipientData']) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'This recipient does not exist.'], 404);
            }
            return back()->with('error', 'This recipient does not exist.');
        } 

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'data' => $data]);
        }
        
        return view('user.pages.properties.transfer.verifyRecipient', $data); 

    }
   
    public function checkRecipientTransfer(Request $request)
    {
        if(!Auth::user()){
            return redirect()->route('login');
        }
            // dd( $request);
        try {
            // Validate the request
            $validated = $request->validate([
                // 'remaining_size' => 'required',
                'selected_size_land' => 'required',
                'property_slug' => 'required',
                'property_id' => 'required|integer',
                'recipient_id' => 'required|integer',
                'amount' => 'required|numeric|min:0.01',
                'transaction_pin' => 'required|digits:4'
            ], [
                // Custom error messages
                // 'remaining_size.required' => 'The remaining size is required',
                'selected_size_land.required' => 'Please select a land size',
                'property_slug.required' => 'Property identifier is missing',
                'property_id.required' => 'Property ID is required',
                'property_id.integer' => 'Invalid property ID format',
                'recipient_id.required' => 'Recipient ID is required',
                'recipient_id.integer' => 'Invalid recipient ID format',
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

            $remainingAttempts = max(0, 3 - $user->failed_pin_attempts);

            if ($remainingAttempts <= 0) {
                $lockoutTime = now()->addMinutes(15);
                $user->update(['pin_locked_until' => $lockoutTime]);

                return $this->errorResponse($propertyId, $request, 'Too many failed attempts. Try again after 15 minutes.', 429, [
                    'lockout_time' => $lockoutTime->toDateTimeString()
                ]);
            }
            
            return $this->errorResponse($propertyId, $request, 'Invalid transaction PIN', 401, [
                'attempts_remaining' => $remainingAttempts
            ]);
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
            // Check if recipient exists and isn't the user
            $recipient = User::find($recipientId);
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

            // Check total available land size
            $totalLand = Buy::where('user_id', $user->id)
                ->where('user_email', $user->email)
                ->where('property_id', $propertyId)
                ->sum('selected_size_land');

            if ($totalLand < $landSize) {
                return $this->sendResponse($request, 'error', 'Insufficient land size available for transfer.', false);
            }

            // Generate a unique reference
            $reference = 'TRANS-' . strtoupper(Str::random(10));

            // Create the transfer record
            $transfer = Transfer::create([
                'property_id' => $propertyData->id,
                'property_name' => $propertyData->name,
                'land_size' => $landSize,
                'user_id' => $user->id,
                'user_email' => $user->email,
                'reference' => $reference,
                'recipient_id' => $recipientId,
                'total_price' => $amount,
                'status' => 'pending',
                'confirmation_status' => 'pending',
            ]);

            // Prepare transfer details
            $transferDetails = [
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
            ];

            // Notify recipient and sender
            $recipient->notify(new RecipientSubmittedNotification($transferDetails));
            $user->notify(new SenderTransferNotification($transferDetails)); 
 
            return $this->sendResponse($request, 'success', 'We have received your request to transfer ₦' . number_format($amount) . ' worth of property. The recipient has been notified.', true, [
                'redirect' => route('user.transfer.history'),
                'transfer_details' => $transferDetails,
            ]);
        } catch (\Exception $e) {
            return $this->sendResponse($request, 'error', 'Something went wrong: ' . $e->getMessage(), false);
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
        if ($propertyId) {
            return redirect()->route('user.cart.transfer.index', ['id' => encrypt($propertyId) ])
                ->with('error', $message);
        }
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
       
        // $data['transferProperty'] = Transfer::select(
        //     'property_id', 'status', 'land_size',
        //     DB::raw('SUM(land_size) as total_land_size'),
        //     DB::raw('MAX(created_at) as latest_created_at'), 
        // )
        // ->with('property') 
        // ->with('valuationSummary')
        // ->where('user_id', $user->id)
        // ->where('user_email', $user->email)
        // ->groupBy('property_id','status','land_size') 
        // ->paginate(10);
        $data['transferProperty'] = Transfer::select(
            'id', 'property_id', 'status', 'land_size', 'created_at', 'updated_at'
        )
        ->with('property') 
        ->with('valuationSummary')
        ->where('user_id', $user->id) 
        ->where('user_email', $user->email) 
        ->orderBy('created_at', 'desc') // Show most recent first
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


    public function submitConfirmationn(Request $request, $id){
        
        $recipient = auth()->user();

        $request->validate([
            'land_size' => 'required|numeric|min:1',
            'sender_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id',
            'amount' => 'required|numeric|min:1',
        ]);


        // The sender ID comes from the request
        $landSize = $request->input('land_size');
        $senderId = $request->input('sender_id'); 
        $propertyId = $request->input('property_id');
        $amount = $request->input('amount');
      
        // Validate sender existence
        $sender = User::where('id', $senderId)->first();
        if (!$sender) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Sender not found'], 404);
            }
            return redirect()->back()->withErrors(['error' => 'Sender not found']);
        }

        // Validate transfer amount
        if ($amount <= 0) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Invalid transfer amount'], 404);
            }
            return redirect()->back()->withErrors(['error' => 'Invalid transfer amount']);
        }
       
        $sendWalletBalance = Transaction::where('user_id', $sender->id)
            ->where('email', $sender->email)
            ->where('status', 'success')
            ->where('payment_method', 'transfer_property')
            ->sum('amount');

        $recipientWalletBalance = Transaction::where('user_id', $recipient->id)
            ->where('email', $recipient->email) // Fixed email issue
            ->where('status', 'success')
            ->where('payment_method', 'wallet')
            ->sum('amount');

        // Fetch or create sender and recipient wallets
        // dd($sender->id);

        $sendWallet = Wallet::where('user_id', $sender->id)->first();
        $recipientWallet =  Wallet::where('user_id', $recipient->id)->first();
       
        // Ensure sender has enough balance
        // if ($sendWallet->balance < ($amount / 100)) {
        //     if ($request->wantsJson()) {
        //         return response()->json(['error' => 'You do not has insufficient funds'], 404);
        //     }
        //     return redirect()->back()->with(['error' => 'Insufficient wallet balance']);

        // }
        // dd('Assets transferred');

        // Check sender's wallet balance
        // if ($sendWallet->balance < $amount) {
        
        //     return redirect()->back()->with(['error' => 'You do not has insufficient funds']);
        // }

        $notification = CustomNotification::find($id);
        // dd($notification);
        if (!$notification) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Notification not found'], 404);
            }
            return redirect()->back()->with('error', 'Notification not found');
        }

        if ($notification->data['status'] == 'approved') {
            return redirect()->back()->with('error', 'Transfer already approved.');
        }
        
        $buy = Buy::select(
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
        $totalLandSize = $buy->sum('selected_size_land');
        // dd($landSize);
        // if ($landSize < $totalLandSize) {
        //     if ($request->wantsJson()) {
        //         return response()->json(['error' => 'Insufficient land size'], 400);
        //     }
        //     return redirect()->back()->with(['error' => 'Insufficient land size']);
        // }
        // Deduct land size from sender's purchases
        foreach ($buy as $item) {
            if ($item->selected_size_land >= $landSize) {
                $item->selected_size_land -= $landSize;
                $item->save();
                break;

            }
        }
        // foreach ($buy as $item) {
        //     $item->selected_size_land -= $landSize;
        //     $item->save();
        // }
        $buy = Buy::create([ 
            'property_id' => $propertyId,
            'transaction_id' => null,
            'selected_size_land' => $landSize,
            'remaining_size' => $totalLandSize - $landSize, 
            'user_id' => $recipient->id,
            'user_email' => $recipient->email,
            'total_price' => $amount / 100,
            'status' => 'transfer',
        ]);
        // Deduct from sender's wallet
        // $sendWallet->balance -= $amount;
        // $sendWallet->save();
        $propertyData = Property::where('id', $propertyId)->first();
 
        // Deduct from sender's wallet
        $sendWallet->balance += $amount / 100;
        $sendWallet->save();

        // Credit recipient's wallet
        $recipientWallet->balance -= $amount / 100;
        $recipientWallet->save();

        $reference = 'TRXDOHREF-' . strtoupper(Str::random(8));

        // Debit a transaction to credit recipient
        Transaction::create([
            'user_id' => $sender->id,
            'email' => $sender->email,
            'property_id' => $propertyId,
            'property_name' => $propertyData->name,
            'status' => 'success',
            'payment_method' => 'wallet',
            'amount' => -$amount / 100,
            'description' => 'Transfer to ' . $recipient->email,
            'reference' => $reference.'-D',
            'transaction_state' => 'success',
        ]);

        // Credit transaction
        Transaction::create([
            'user_id' => $recipient->id,
            'email' => $recipient->email,
            'property_id' => $propertyId,
            'property_name' => $propertyData->name,
            'status' => 'success',
            'payment_method' => 'card',
            'amount' => $amount / 100,
            'description' => 'Received from ' . $sender->email,
            'reference' => $reference.'-C',
            'transaction_state' => null,
        ]);

        // Credit to recipient's wallet
        // $recipientWallet->balance += $amount;
        // $recipientWallet->save(); 
        // Now notify
        $sender->property_id = $propertyId;
        $sender->property_name = $propertyData->name;
        $sender->reference = $reference;

        $recipient->property_id = $propertyId;
        $recipient->property_name = $propertyData->name;
        $recipient->reference = $reference;
        // After successful transfer, update the notification status to 'approved'

        // Ensure the notification data is an array
        $notificationData = $notification->data; 
        $notificationData['status'] = 'approved';
        $notification->update([
            'data' => $notificationData,
        ]);

        $transfer = Transfer::where('reference', $notificationData['reference'])
        ->where('user_id', $sender->id)
        ->where('recipient_id', $recipient->id)
        ->where('property_id', $propertyId)
        ->first();
        if ($transfer) {
            $transfer->status = 'approved';
            $transfer->confirmation_status = 'confirmed';
            $transfer->confirmation_date = now();
            $transfer->confirmed_by = auth()->id(); // recipient who approved
            $transfer->save();
        }

        $sender = User::find($notification->data['sender_id']);
    
        // Send Confirmation Messages to Sender and Recipient
        $sender->notify(new TransferNotification($recipient, $amount, 'Sender', $propertyData));
        $recipient->notify(new TransferNotification($sender, $amount, 'Recipient', $propertyData));
       

        if ($request->wantsJson()) {
            return response()->json(['success' => 'Amount transferred successfully!'], 200);
        }

        return redirect()->route('user.dashboard')->with('success', 'Assets transferred successfully!');

    }

    public function submitConfirmation(Request $request, $id)
    {
        DB::beginTransaction();
        
        try {
            $recipient = auth()->user();
            
            // Validate request data
            $validatedData = $request->validate([
                'land_size' => 'required|numeric|min:1',
                'sender_id' => 'required|exists:users,id',
                'property_id' => 'required|exists:properties,id',
                'amount' => 'required|numeric|min:1',
            ]);

            // Extract validated data
            $landSize = $validatedData['land_size'];
            $senderId = $validatedData['sender_id'];
            $propertyId = $validatedData['property_id'];
            $amount = $validatedData['amount'];

            // Find sender
            $sender = User::find($senderId);
            if (!$sender) {
                throw new \Exception('Sender not found', 404);
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
            // dd($recipientWallet->balance);


            // Find notification
            $notification = CustomNotification::find($id);
            if (!$notification) {
                throw new \Exception('Notification not found', 404);
            }

            // Check notification status
            if (!isset($notification->data['status'])) {
                throw new \Exception('Invalid notification data', 400);
            }

            if ($notification->data['status'] == 'approved') {
                throw new \Exception('Transfer already approved', 400);
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

            // Deduct land size from sender's purchases
            $landDeducted = false;
            foreach ($buyRecords as $item) {
                if ($item->selected_size_land >= $landSize) {
                    $item->selected_size_land -= $landSize;
                    $item->save();
                    $landDeducted = true;
                    break;
                }
                // dd([
                //     'selected_size_land' => $item->selected_size_land,
                //     'landSize' => $landSize
                // ]);
            }
           

            // dd($landDeducted);

            // if (!$landDeducted) {
            //     throw new \Exception('Insufficient land size available for transfer', 400);
            // }

            // Create new buy record for recipient
            Buy::create([
                'property_id' => $propertyId,
                'transaction_id' => null,
                'selected_size_land' => $landSize,
                'remaining_size' => $totalLandSize - $landSize,
                'user_id' => $recipient->id,
                'user_email' => $recipient->email,
                'total_price' => $requiredAmountInNaira,
                'status' => 'transfer',
            ]);

            // Process wallet transactions
            $propertyData = Property::find($propertyId);
            if (!$propertyData) {
                throw new \Exception('Property not found', 404);
            }

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
            $notificationData = $notification->data;
            $notificationData['status'] = 'approved';
            $notification->update(['data' => $notificationData]);

            // Update transfer record if exists
            $transfer = Transfer::where('reference', $notificationData['reference'])
                ->where('user_id', $sender->id)
                ->where('recipient_id', $recipient->id)
                ->where('property_id', $propertyId)
                ->first();

            if ($transfer) {
                $transfer->update([
                    'status' => 'approved',
                    'confirmation_status' => 'confirmed',
                    'confirmation_date' => now(),
                    'confirmed_by' => auth()->id(),
                ]);
            }

            // Send notifications
            $sender->notify(new TransferNotification($recipient, $amount, 'Sender', $propertyData));
            $recipient->notify(new TransferNotification($sender, $amount, 'Recipient', $propertyData));

            DB::commit();

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
 