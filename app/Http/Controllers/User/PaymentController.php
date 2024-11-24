<?php

namespace App\Http\Controllers\User;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
        // Validate the incoming data
        $request->validate([
            'property_name' => 'required',
            'property_id' => 'required',
            'email' => 'required|email',
            'amount' => 'required|numeric|min:1',
        ]);

        // Generate a unique transaction reference
        $reference = 'PROREF-' . time() . '-' . strtoupper(Str::random(8));
        $propertyId  = $request->input('property_id');
        $propertyName  = $request->input('property_name');
        $propertyData = Property::where('id', $propertyId)->where('name', $propertyName)->first();
       
        // Prepare the data to send to Paystack
        $data = [
            'amount' => $request->amount * 100, 
            'email' => $request->email,
            'property_id' => $propertyData->id,
            'property_name' => $propertyData->name,
            'reference' => $reference,
            'callback_url' => route('user.payment.callback'),
        ];

        $transaction = Transaction::create([
            'property_id' => $propertyData->id,
            'property_name' => $propertyData->name,
            'user_id' => Auth::id(),
            'email' => Auth::user()->email,
            'amount' => $request->amount,
            'status' => 'pending',
            'payment_method' => '',
            'reference' => $reference,
        ]);
        
        try {
            $response = $this->paystack->transaction->initialize($data);

            return redirect($response->data->authorization_url);
        } catch (\Exception $e) {
            return back()->with('error', 'Unable to initiate payment: ' . $e->getMessage());
        }
    }

    /**
     * Handle payment callback from Paystack
     */
    public function paymentCallback(Request $request)
    {
        try {
            $paymentDetails = $this->paystack->transaction->verify([
                'reference' => $request->get('reference'),
                'trxref' => $request->get('trxref'),
            ]);
            $transaction = Transaction::where('reference', $paymentDetails->data->reference)->first();
            $property = Property::where('id', $transaction->property_id)->first();
            if (!$transaction) {
                return redirect()->back()->with('error', 'Transaction not found.');
            }
            if ($paymentDetails->data->status === 'success') {
                $amount = $paymentDetails->data->amount / 100; 
                $reference = $paymentDetails->data->reference;
                $channel = $paymentDetails->data->channel;

                $transaction->update([
                    'payment_method' => $channel,
                    'status' => 'completed',
                ]);
                $property->update([
                    'status' => 'sold',
                ]);
                
               

                return redirect()->route('user.dashboard')->with('success', 'Payment successful!');
            }

            return redirect()->route('user.dashboard')->with('error', 'Payment verification failed.');
        } catch (\Exception $e) {
            return redirect()->route('user.dashboard')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
