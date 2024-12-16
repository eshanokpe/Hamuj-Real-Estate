<?php

namespace App\Http\Controllers\User;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Buy;  
use Yabacon\Paystack;  
use App\Models\Property;  
use App\Models\Transaction;  

class PaymentController extends Controller
{
    protected $paystack;

    public function __construct()
    {
        $this->middleware('auth'); 
        $this->paystack = new Paystack(env('PAYSTACK_SECRET_KEY')); // Initialize Paystack
    }

    public function initializePayment(Request $request)
    {
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
        // Check if the user has enough balance
        $userBalance = $user->wallet->first()->balance; 
        $amount = $request->input('total_price');
        if ($userBalance < $amount) {
            return back()->with('error', 'Insufficient funds in your wallet. Please add funds to proceed.');
        }

        // Generate a unique transaction reference
        $reference = 'PROREF-' . time() . '-' . strtoupper(Str::random(8));

        $selectedSizeLand  = $request->input('quantity');
        $remainingSize  = $request->input('remaining_size');
        $amount  = $request->input('total_price');

        $propertyId  = $property->id;
        $propertyName  =  $property->name;
        $propertyData = Property::where('id', $propertyId)->where('name', $propertyName)->first();
        // Prepare the data to send to Paystack
        $data = [
            'amount' => $amount * 100, 
            'email' => $user->email,
            'property_id' => $propertyData->id,
            'property_name' => $propertyData->name,
            'reference' => $reference,
            'property_state' => $property->property_state,
            'callback_url' => route('user.payment.callback'),
        ];

        $propertyData->update([
            'available_size' => $remainingSize,
            'selected_size_land' => $selectedSizeLand,
        ]);

        
        try {
            $response = $this->paystack->transaction->initialize($data);

            return redirect($response->data->authorization_url);
        } catch (\Exception $e) {
            return back()->with('error', 'Unable to initiate payment: ' . $e->getMessage());
        }
    }
   
    public function paymentCallback(Request $request)
    {
        $reference = $request->query('reference');
        try {
            $user = Auth::user();
            $paymentDetails = $this->paystack->transaction->verify(['reference' => $reference]);
            if ($paymentDetails->data->status === 'success') {
                return $this->processSuccessfulPayment($paymentDetails);
            } else {
                return back()->with('error', 'Payment failed or was not completed.');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    private function processSuccessfulPayment($paymentDetails)
    {
        $user = auth()->user();
        $reference = $paymentDetails->data->reference;
        $amount = $paymentDetails->data->amount / 100; // Convert back from kobo
        $propertyId = $paymentDetails->data->metadata->property_id; // Ensure metadata contains property_id
        $selectedSizeLand = $paymentDetails->data->metadata->selected_size_land;
        $channel = $paymentDetails->data->channel;

        $property = Property::findOrFail($propertyId);
        $remainingSize = $property->available_size - $selectedSizeLand;

        if ($remainingSize < 0) {
            return back()->with('error', 'Selected size exceeds available size.');
        }

        // Create Transaction
        $transaction = Transaction::create([
            'property_id' => $property->id,
            'property_name' => $property->name,
            'user_id' => $user->id,
            'email' => $user->email,
            'amount' => $amount,
            'status' => 'success',
            'payment_method' => $paymentDetails->data->channel,
            'reference' => $reference,
            'transaction_state' => $property->property_state,
        ]);

        // Create Buy
        $buy = Buy::create([
            'property_id' => $property->id,
            'transaction_id' => $transaction->id,
            'selected_size_land' => $selectedSizeLand,
            'remaining_size' => $remainingSize,
            'user_id' => $user->id,
            'user_email' => $user->email,
            'total_price' => $amount,
            'status' => $remainingSize == 0 ? 'sold out' : 'available',
        ]);
        $transaction->update([
            'payment_method' => $channel,
            'status' => $paymentDetails->data->status,
            'transaction_state' => $paymentDetails->data->status,
        ]);
        // Update Property
        $property->update([
            'available_size' => $remainingSize,
            'selected_size_land' => $selectedSizeLand,  // Ensure this value is updated
            'status' => $remainingSize == 0 ? 'sold out' : $property->status,
        ]);

        // Handle Property and Buy Status Updates
        if (is_numeric($property->available_size) && $property->available_size == 0) {
            $property->update(['status' => 'sold out']);
        }

        if (is_numeric($buy->remaining_size) && $buy->remaining_size == 0) {
            $buy->update(['status' => 'sold out']);
        }

        // Deduct from Wallet
        $wallet = Wallet::where('user_id', $user->id)->first();
        if ($wallet) {
            $wallet->update(['balance' => $wallet->balance - $amount]);
        }

        return redirect()->route('user.dashboard')->with('success', 'Payment successful!');
    }

}
