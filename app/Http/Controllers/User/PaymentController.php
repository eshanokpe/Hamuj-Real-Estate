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
            'remaining_size' => $remainingSize,
            'selected_size_land' => $selectedSizeLand,
            'reference' => $reference,
            'property_state' => $property->property_state,
            'callback_url' => route('user.payment.callback'),
        ];
       
        try {
            $response = $this->paystack->transaction->initialize($data);

            return redirect($response->data->authorization_url);
        } catch (\Exception $e) {
            return back()->with('error', 'Unable to initiate payment: ' . $e->getMessage());
        }
    }
   
    public function paymentCallback(Request $request)
    {
        try {
            $user = Auth::user();
            $paymentDetails = $this->paystack->transaction->verify([
                'reference' => $request->get('reference'),
                'trxref' => $request->get('trxref'),
            ]);

            $property = Property::find($paymentDetails->data->property_id);
            if (!$property) {
                return redirect()->back()->with('error', 'Property not found.');
            }

            if ($paymentDetails->data->status === 'success') {
                $amount = $paymentDetails->data->amount / 100;
                $reference = $paymentDetails->data->reference;
                $channel = $paymentDetails->data->channel;
                // Create the transaction record
                $transaction = Transaction::create([
                    'property_id' => $property->id,
                    'property_name' => $property->name,
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'amount' => $amount,
                    'status' =>  $paymentDetails->data->status,
                    'payment_method' => $channel,
                    'reference' => $reference,
                    'transaction_state' => $paymentDetails->data->status,
                ]);
                // Create the buy record
                $buy = Buy::create([
                    'property_id' => $property->id,
                    'transaction_id' => $transaction->id,
                    'selected_size_land' => $paymentDetails->data->selected_size_land,
                    'remaining_size' => $paymentDetails->data->remaining_size,
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'total_price' => $amount,
                    'status' => 'sold',
                ]);
                
                if (is_numeric($property->available_size) && is_numeric($property->available_size) == 1) {
                    $property->update([
                        'status' => 'sold out',
                    ]);
                }
            
                if (is_numeric($buy->remaining_size) && ($property->available_size) == 1) {
                    $buy->update([
                        'status' => 'sold out',
                    ]);
                }

                return redirect()->route('user.dashboard')->with('success', 'Payment successful!');
            }

            if ($paymentDetails->data->status !== 'success') {
                $transaction->update([
                    'status' => $paymentDetails->data->status,
                    'property_state' => 'failed',
                ]);

                return redirect()->route('user.dashboard')->with('error', 'Payment failed. Please try again.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    
}
