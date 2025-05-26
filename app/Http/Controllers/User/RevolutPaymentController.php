<?php

namespace App\Http\Controllers\User;

use Auth;
use Hash;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Buy;  
use App\Models\Wallet;
use App\Models\Property;  
use App\Models\Transaction;   
use App\Models\ReferralLog;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RevolutPaymentController extends Controller
{
    public function createOrder(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'name' => 'required|string',
        ]);

        try {
            $revolutConfig = config('services.revolut');
            $secretKey = $revolutConfig['secret_key'] ?? null;
            $mode = $revolutConfig['mode'] ?? 'sandbox';

            $baseApiUrl = ($mode === 'production')
                ? ($revolutConfig['production_url'] ?? null)
                : ($revolutConfig['sandbox_url'] ?? null);

            if (!$secretKey) {
                return response()->json(['error' => 'Revolut secret key not configured'], 400);
            }
            if (!$baseApiUrl) {
                return response()->json(['error' => 'Revolut API URL not configured'], 500);
            }

            // Ensure the baseApiUrl ends with a single slash
            $baseApiUrl = rtrim($baseApiUrl, '/') . '/';
            $fullApiUrl = $baseApiUrl . 'orders'; 

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $secretKey,
                'Content-Type' => 'application/json',
                'Revolut-Api-Version' => '2024-09-01', // As seen in your createOrder22 method
            ])->post($fullApiUrl, [
                'description' => $request->name,
                'amount' => (int) ($request->amount), // Convert to minor units (e.g., pence/cents)
                'currency' => $request->currency, // Use currency from the request
            ]);

            if (!$response->successful()) {
                return response()->json([
                    'error' => 'Failed to create order at Revolut',
                    'details' => $response->body(),
                ], $response->status());
            }

            $revolutOrder = $response->json();

            return response()->json([
                'baseApiUrl' => $baseApiUrl,
                'fullApiUrl' => $fullApiUrl,
                'secretKey' => $secretKey,
                'amount' => $request->amount,
                'currency' => $request->currency,
                'name' => $request->name,
                'orderId' => $revolutOrder['id'] ?? null,
                'description' => $revolutOrder['description'] ?? null,
                'revolutPublicOrderId' => $revolutOrder['public_id'] ?? null,
                'state' => $revolutOrder['state'] ?? null,
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Order creation failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function success(Request $request){
        $RPOid = $request->_rp_oid ?? null;
        if (!$request->has('_rp_oid')) {
            return redirect()->route('payment.failed')->with('error', 'Payment failed. Order ID not found.');
        }
        // dd($request->_rp_oid);
        return view('user.pages.success.index');
    }

    public function failed(){
        return view('user.pages.failed.index'); 
    }

    
    public function makePayment(Request $request)
    {
        // Log the incoming request
        \Log::debug('Payment Request Data:', [
            'headers' => $request->headers->all(),
            'input' => $request->all(),
            'content' => $request->getContent()
        ]);

        try{
            // dd($request->all()); 
            $validated = $request->validate([
                'property_slug' => 'required|exists:properties,slug',
                'quantity' => 'required|numeric|min:1',
                'total_price' => 'required|numeric|min:0',
                'transaction_pin' => 'required|digits:4',
                'commission_check' => 'nullable|boolean',
                'commission_applied_amount' => 'nullable|numeric|min:0'
            ]);

            

            // Verify transaction PIN
            // if (auth()->user()->transaction_pin !== $validated['transaction_pin']) {
            //     return back()->with('error', 'Invalid transaction PIN');
            // }
            

            $property = Property::where('slug', $validated['property_slug'])->first();
            $user = auth()->user();

            

            // Check available size
            if ($property->available_size < $validated['quantity']) {
                return back()->with('error', 'Requested size exceeds available land size');
            }

           

            // Calculate final amount after commission
            $finalAmount = $validated['total_price'];
            $commissionApplied = 0;

            if ($request->has('commission_check') && $user->commission_balance > 0) {
                $commissionApplied = min($validated['commission_applied_amount'], $user->commission_balance, $finalAmount);
                $finalAmount -= $commissionApplied;
            }
            

            // Create transaction record
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'property_id' => $property->id,
                'amount' => $finalAmount,
                'commission_used' => $commissionApplied,
                'quantity' => $validated['quantity'],
                'status' => 'pending',
                'payment_method' => 'revolut',
                'reference' => 'REV-' . uniqid()
            ]);

            

            // Prepare payload for Revolut
            $payload = [
                'amount' => $finalAmount * 100, // in cents
                'currency' => 'NGN',
                'customer_email' => $user->email,
                'description' => "Purchase of {$validated['quantity']} SQM at {$property->name}",
                'metadata' => [
                    'transaction_id' => $transaction->id,
                    'property_id' => $property->id,
                    'user_id' => $user->id
                ]
            ];

             // Return a structured response
            // return response()->json([
            //     'status' => 'success',
            //     'received_data' => $request->all(),
            //     'headers' => $request->headers->all(),
            //     'server' => $_SERVER
            // ]);

            return response()->json([
                'public_id' => $this->createRevolutOrder($payload),
                'transaction_id' => $transaction->id
            ]);
         } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    protected function createRevolutOrder(array $data)
    {
        // Implement Revolut API call here
        // This is a mock implementation - replace with actual API call
        return 'mock_public_id_' . uniqid();
        
        /*
        // Real implementation would look something like:
        $client = new \GuzzleHttp\Client();
        $response = $client->post('https://merchant.revolut.com/api/1.0/orders', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('REVOLUT_API_KEY'),
                'Content-Type' => 'application/json'
            ],
            'json' => $data
        ]);
        
        return json_decode($response->getBody(), true)['public_id'];
        */
    }

    public function paymentSuccess(Request $request)
    {
        $transactionId = $request->query('transaction_id');
        $transaction = Transaction::findOrFail($transactionId);
        
        // Verify payment with Revolut
        if ($this->verifyRevolutPayment($transaction)) {
            $transaction->update(['status' => 'completed']);
            
            // Update property available size
            $property = $transaction->property;
            $property->available_size -= $transaction->quantity;
            $property->save();
            
            // Deduct commission if used
            if ($transaction->commission_used > 0) {
                $user = $transaction->user;
                $user->commission_balance -= $transaction->commission_used;
                $user->save();
            }
            
            return view('dashboard.payment-success', compact('transaction'));
        }
        
        return redirect()->route('payment.failed');
    }

    protected function verifyRevolutPayment(Transaction $transaction)
    {
        // Implement actual Revolut verification
        // This is a mock - always return true for demo
        return true;
        
        /*
        // Real implementation would look something like:
        $client = new \GuzzleHttp\Client();
        $response = $client->get("https://merchant.revolut.com/api/1.0/orders/{$transaction->reference}", [
            'headers' => [
                'Authorization' => 'Bearer ' . env('REVOLUT_API_KEY')
            ]
        ]);
        
        $order = json_decode($response->getBody(), true);
        return $order['state'] === 'COMPLETED';
        */
    }
}