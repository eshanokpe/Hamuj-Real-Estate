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

    /**
     * Initialize payment with Paystack
     */ 
    public function initializePayment(Request $request)
    {
        // dd($request->all());
        // Validate the incoming data
        $request->validate([
            'remaining_size' => 'required',
            'property_slug' => 'required',
            'quantity' => 'required',
            'total_price' => 'required|numeric|min:1',
        ]);
        $user = Auth::user();
        $propertySlug  = $request->input('property_slug');
        $properties = Property::where('slug', $propertySlug)->first();
  
        // Generate a unique transaction reference
        $reference = 'PROREF-' . time() . '-' . strtoupper(Str::random(8));
        $selectedSizeLand  = $request->input('quantity');
        $remainingSize  = $request->input('remaining_size');
        $amount  = $request->input('total_price');

        $propertyId  = $properties->id;
        $propertyName  =  $properties->name;
        $propertyState  =  $properties->property_state;
        $propertyData = Property::where('id', $propertyId)->where('name', $propertyName)->first();
        // Prepare the data to send to Paystack
        $data = [
            'amount' => $amount * 100, 
            'email' => $user->email,
            'property_id' => $propertyData->id,
            'property_name' => $propertyData->name,
            'reference' => $reference,
            'property_state' => $propertyState,
            'callback_url' => route('user.payment.callback'),
        ];
        $transaction = Transaction::create([
            'property_id' => $propertyData->id,
            'property_name' => $propertyData->name,
            'user_id' => $user->id,
            'email' => $user->email,
            'amount' => $amount,
            'status' => 'pending',
            'payment_method' => '',
            'reference' => $reference,
            'transaction_state' => $propertyState
        ]);
        $buy = Buy::create([
            'property_id' => $propertyData->id,
            'transaction_id' => $transaction->id,
            'selected_size_land' => $selectedSizeLand,
            'remaining_size' => $remainingSize,
            'user_id' => $user->id,
            'user_email' => $user->email,
            'total_price' => $amount,
            'status' => 'available',
        ]);
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
        try {
            $user = Auth::user();
            $paymentDetails = $this->paystack->transaction->verify([
                'reference' => $request->get('reference'),
                'trxref' => $request->get('trxref'),
            ]);

            $transaction = Transaction::where('reference', $paymentDetails->data->reference)->first();

            if (!$transaction) {
                return redirect()->back()->with('error', 'Transaction not found.');
            }

            $property = Property::find($transaction->property_id);
            $buy = Buy::where('property_id', $transaction->property_id)
                    ->where('user_id', $user->id)
                    ->first();

            if (!$property) {
                return redirect()->back()->with('error', 'Property not found.');
            }

            if (!$buy) {
                return redirect()->back()->with('error', 'Purchase record not found.');
            }

            if ($paymentDetails->data->status === 'success') {
                $amount = $paymentDetails->data->amount / 100;
                $reference = $paymentDetails->data->reference;
                $channel = $paymentDetails->data->channel;

                $transaction->update([
                    'payment_method' => $channel,
                    'status' => $paymentDetails->data->status,
                    'transaction_state' => $transaction->transaction_state,
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
