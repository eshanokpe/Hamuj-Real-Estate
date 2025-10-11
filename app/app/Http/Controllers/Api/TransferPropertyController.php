<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Models\Buy;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Neighborhood;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\Property;
use App\Models\Wallet;
use App\Notifications\TransferNotification; 
use App\Notifications\SenderTransferNotification; 
use App\Notifications\RecipientSubmittedNotification;
use Illuminate\Validation\ValidationException; 
 
class TransferPropertyController extends Controller
{
  

    public function transferDetails($id){ 
        $user = Auth::user();  
       
        $data['property'] = Property::with(['buys' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])
        ->with('valuationSummary')
        ->where('id', $id)
        ->firstOrFail(); 

        if (request()->wantsJson()) {
            // Return JSON response for mobile
            return response()->json([
                'success' => true,
                'data' => $data['property'],
            ]);
        } 

    }

    public function checkRecipientTransfer(Request $request)
    {
        if(!Auth::user()){
            return redirect()->route('login');
        } 
        try {
            // Validate the request
            $validated = $request->validate([
                'selected_size_land' => 'required',
                'property_slug' => 'required',
                'property_id' => 'required|integer',
                'recipient_id' => 'required|integer',
                'amount' => 'required|numeric|min:0.01',
            ], [
                // Custom error messages
                'selected_size_land.required' => 'Please select a land size',
                'property_slug.required' => 'Property identifier is missing',
                'property_id.required' => 'Property ID is required',
                'property_id.integer' => 'Invalid property ID format',
                'recipient_id.required' => 'Recipient ID is required',
                'recipient_id.integer' => 'Invalid recipient ID format',
                'amount.required' => 'Amount is required',
                'amount.numeric' => 'Amount must be a number',
                'amount.min' => 'Amount must be at least 0.01',
            ]);
        } catch (ValidationException $e) {
            return $this->errorResponse(
                $request->input('property_id'), 
                $request,                
                $e->getMessage(),  
                // '',                 
                422                             
            );
        }
        
      

        $user = Auth::user();

        $sendWallet = Wallet::where('user_id', $user->id)->first();
        // Ensure sender has enough balance
        if ($sendWallet->balance < ($request->input('amount') / 100)) {

            return redirect()->back()->with(['error' => 'Insufficient wallet balance']);

        }

        $propertyId = $request->input('property_id');

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
            ], $statusCode);
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

    

}