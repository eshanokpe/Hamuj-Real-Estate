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

class TransactionController extends Controller
{
    protected $paystack;

    public function __construct()
    {
        $this->middleware('auth'); 
        $this->paystack = new Paystack(env('PAYSTACK_SECRET_KEY')); // Initialize Paystack
    }

    public function index(){ 
        $user = Auth::user();
       
        $data['transactions'] = Transaction::with('user')->latest()
        ->paginate(10);

        return view('user.pages.transactions.index', $data); 
    }
    
   
    public function paymentCallback(Request $request)
    {
        try {
            $user = Auth::user();
            $paymentDetails = $this->paystack->transaction->verify([
                'reference' => $request->get('reference'),
                'trxref' => $request->get('trxref'),
            ]);
            dd($paymentDetails->data);
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
