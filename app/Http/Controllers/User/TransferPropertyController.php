<?php

namespace App\Http\Controllers\User;
use App\Notifications\TransferNotification; 
use App\Notifications\SenderTransferNotification; 
use App\Notifications\RecipientSubmittedNotification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use DB; 
use Auth;
use Log; 
use App\Models\Transfer;
use App\Models\Sell;
use App\Models\Buy;
use App\Models\User;
use App\Models\Property;
use App\Models\Wallet;
use Illuminate\Support\Str;
use App\Models\VirtualAccount;
use App\Services\PaystackService;
 
class TransferPropertyController extends Controller
{
    
    public function index(){ 
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
        $request->validate([
            'remaining_size' => 'required',
            'property_slug' => 'required',
            'quantity' => 'required',
            'total_price' => 'required|numeric|min:1',
        ]);
        $user = Auth::user();
        $propertySlug  = $request->input('property_slug');
        $property = Property::where('slug', $propertySlug)->first();
        // Check if the property exists
        if (!$property) {
            return back()->with('error', 'Property not found.');
        } 
        $reference = 'PRO-TRANSFER-REF-' . time() . '-' . strtoupper(Str::random(8));
        $selectedSizeLand  = $request->input('quantity');
        $remainingSize  = $request->input('remaining_size');
        $amount  = $request->input('total_price');
        $propertySlug = $request->input('property_slug');
        $propertyId  = $property->id;
        $propertyName  =  $property->name;
        $propertyData = Property::where('id', $propertyId)->where('name', $propertyName)->first();
        $data = [
            'amount' => $amount * 100, 
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
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ]);
        }

        return view('user.pages.properties.transfer.recipient', compact('data')); 
    }

    public function verifyRecipient(Request $request){
        
        $request->validate([
            'property_id' => 'required',
            'property_name' => 'required',
            'amount' => 'required',
            'selected_size_land' => 'required',
            'recipient_id' => 'required',
            'property_image' => 'required',
            'property_slug' => 'required',
        ]);
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
        try {
            // Validate the request
            $request->validate([
                'selected_size_land' => 'required',
                'property_slug' => 'required',
                'property_id' => 'required',
                'recipient_id' => 'required',
                'amount' => 'required|numeric|min:1',
            ]);

            $user = Auth::user();
            $amount = $request->input('amount');
            $propertyId = $request->input('property_id');
            $recipientId = $request->input('recipient_id');
            $propertySlug = $request->input('property_slug');
            $landSize = $request->input('selected_size_land');

            // Check if the recipient exists
            $customerCheck = User::where('id', $recipientId)->first();
            if (!$customerCheck) {
                return $this->sendResponse($request, 'error', 'This recipient does not exist.', false);
            }

            // Check if the recipient is the same as the current user
            if ($recipientId === $user->id) {
                return $this->sendResponse($request, 'error', 'You cannot transfer the property to yourself.', false);
            }

            // Fetch property data
            $propertyData = Property::where('id', $propertyId)->where('slug', $propertySlug)->first();
            if (!$propertyData) {
                return $this->sendResponse($request, 'error', 'Property not found.', false);
            }

            // Generate a unique reference
            $reference = 'TRANS-' . strtoupper(Str::random(10));

            // Check available land size for transfer
            $buy = Buy::select(
                'property_id', 'status',
                DB::raw('SUM(selected_size_land) as total_selected_size_land'),
                DB::raw('MAX(created_at) as latest_created_at')
            )
                ->with('property')
                ->where('user_id', $user->id)
                ->where('user_email', $user->email)
                ->groupBy('property_id', 'status')
                ->get();

            if ($buy->isEmpty()) {
                return $this->sendResponse($request, 'error', 'Property not available for sale.', false);
            }

            foreach ($buy as $item) {
                if ($item->total_selected_size_land < $landSize) {
                    return $this->sendResponse($request, 'error', 'Insufficient land size available for transfer.', false);
                }
            }

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

            // Prepare transfer details for notifications
            $transferDetails = [
                'property_id' => $propertyData->id,
                'property_slug' => $propertyData->slug,
                'property_name' => $propertyData->name,
                'property_image' => $propertyData->property_images,
                'land_size' => $landSize,
                'total_price' => $amount,
                'reference' => $reference,
                'sender_id' => $user->id,
                'recipient_id' => $recipientId,
                'property_mode' => 'transfer',
                'status' => 'pending',
            ];

            // Notify the recipient
            $recipient = User::where('id', $recipientId)->first();
            if ($recipient) {
                $recipient->notify(new RecipientSubmittedNotification($transferDetails));
            }

            // Notify the sender
            $user->notify(new SenderTransferNotification($transferDetails));

            // Return success response
            return $this->sendResponse($request, 'success', 'We have received your request to transfer the Property. The recipient has been notified.', true, [
                'redirect' => route('user.transfer.history'),
                'transfer_details' => $transferDetails,
            ]);
        } catch (\Exception $e) {
            return $this->sendResponse($request,'error', 'Something went wrong: ' . $e->getMessage(), false);
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
       
        $data['transferProperty'] = Transfer::select(
            'property_id', 'status', 'land_size',
            DB::raw('SUM(land_size) as total_land_size'),
            DB::raw('MAX(created_at) as latest_created_at'), 
        )
        ->with('property') 
        ->with('valuationSummary')
        ->where('user_id', $user->id)
        ->where('user_email', $user->email)
        ->groupBy('property_id','status','land_size') 
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

    public function submitConfirmation(Request $request, $slug){
        // The authenticated user is the recipient
        $recipient = auth()->user();

        $request->validate([
            'land_size' => 'required|numeric|min:1',
            'recipient_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id',
            'amount' => 'required|numeric|min:1',
        ]);

        // The sender ID comes from the request
        $landSize = $request->input('land_size');
        $senderId = $request->input('recipient_id');
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
            ->where('payment_method', 'card')
            ->sum('amount');

        $recipientWalletBalance = Transaction::where('user_id', $recipient->id)
            ->where('email', $recipient->email) // Fixed email issue
            ->where('status', 'success')
            ->where('payment_method', 'card')
            ->sum('amount');
         // Ensure sender has enough balance
        // if ($sendWalletBalance < $amount) {
        //     return response()->json(['error' => 'Insufficient funds'], 400);
        // }
        // $sendWallet = Wallet::where('user_id', $sender->id)->first();
        // $recipientWallet = Wallet::where('user_id', $recipient->id)->first();
        
        // Check sender's wallet balance
        // if ($sendWallet->balance < $amount) {
        //     if ($request->wantsJson()) {
        //         return response()->json(['error' => 'You do not has insufficient funds'], 404);
        //     }
        //     return redirect()->back()->with(['error' => 'You do not has insufficient funds']);
        // }
        
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
        // if ($totalLandSize < $landSize) {
        //     return response()->json(['error' => 'Insufficient land size'], 400);
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

        // Create a transaction to deduct from sender
        Transaction::create([
            'user_id' => $sender->id,
            'email' => $sender->email,
            'property_id' => $propertyId,
            'property_name' => $propertyData->name,
            'status' => 'success',
            'payment_method' => 'card',
            'amount' => -$amount / 100, // Deduct amount
            'description' => 'Transfer to ' . $recipient->email,
            'reference' => null,
            'transaction_state' => 'sucess',
        ]);

        // Create a transaction to credit recipient
        Transaction::create([
            'user_id' => $recipient->id,
            'email' => $recipient->email,
            'property_id' => $propertyId,
            'property_name' => $propertyData->name,
            'status' => 'success',
            'payment_method' => 'card',
            'amount' => $amount / 100, // Credit recipient
            'description' => 'Received from ' . $sender->email,
            'reference' => null,
            'transaction_state' =>null,
        ]);

        // Credit to recipient's wallet
        // $recipientWallet->balance += $amount;
        // $recipientWallet->save();

        // Send Confirmation Messages to Sender and Recipient
        $sender->notify(new TransferNotification($recipient, $amount, 'Sender'));
        $recipient->notify(new TransferNotification($sender, $amount, 'Recipient'));

        if ($request->wantsJson()) {
            return response()->json(['success' => 'Amount transferred successfully!'], 200);
        }

        return redirect()->route('user.dashboard')->with('success', 'Amount transferred successfully!');

    }
 
}
 