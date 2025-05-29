<?php

namespace App\Http\Controllers\User;

use Auth;
use Hash;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Services\RevolutService;

class OrderController extends Controller
{
    protected $revolutService;

    public function __construct(RevolutService $revolutService)
    {
        $this->revolutService = $revolutService;
    }

    public function createOrder(Request $request)
    {

        // dd($request->all());
        // $request->validate([
        //     'amount' => 'required|numeric',
        //     'currency' => 'required|string',
        //     'name' => 'required|string',
        // ]);
        $validated = $request->validate([
            'amount' => 'required|integer',
            'currency' => 'required|string|size:3',
            'name' => 'required|string'
        ]);

        try {
            $response = $this->revolutService->createOrder(
                $validated['amount'],
                $validated['currency'],
                $validated['name']
            );
            // $revolutConfig = config('services.revolut');
            // $secretKey = $revolutConfig['secret_key'] ?? null;
            // $mode = $revolutConfig['mode'] ?? 'sandbox';

            // $baseApiUrl = ($mode === 'production')
            //     ? ($revolutConfig['production_url'] ?? null)
            //     : ($revolutConfig['sandbox_url'] ?? null);

            // if (!$secretKey) {
            //     return response()->json(['error' => 'Revolut secret key not configured'], 400);
            // }
            // if (!$baseApiUrl) {
            //     return response()->json(['error' => 'Revolut API URL not configured'], 500);
            // }

            // $fullApiUrl = $baseApiUrl . 'orders';  
            // $orderData = json_decode($response->getBody(), true);

            // $response = Http::withHeaders([
            //     'Authorization' => 'Bearer ' . $secretKey,
            //     'Content-Type' => 'application/json',
            //     'Revolut-Api-Version' => '2024-09-01', // As seen in your createOrder22 method
            // ])->post($fullApiUrl, [
            //     'description' => $request->name,
            //     'amount' => (int) ($request->amount), // Convert to minor units (e.g., pence/cents)
            //     'currency' => $request->currency, // Use currency from the request
            // ]);

            // if (!$response->successful()) {
            //     return response()->json([
            //         'error' => 'Failed to create order at Revolut',
            //         'details' => $response->body(),
            //     ], $response->status());
            // }

            // $revolutOrder = $response->json();
            $user = Auth::user();
            $orderData = json_decode($response->getBody(), true);
            $order = Order::create([
                'user_id' => $user->id,
                'description' => $validated['name'],
                'revolut_order_id' => $orderData['id'],
                'revolut_public_id' => $orderData['public_id'],
                'amount' => $validated['amount'],
                'currency' => $validated['currency'],
                'state' => $orderData['state']
            ]);
            return response()->json([
                'description' => $order->description,
                'revolutPublicOrderId' => $order->revolut_public_id,
                'state' => $order->state
            ]);
            // return response()->json([
            //     'amount' => $request->amount,
            //     'currency' => $request->currency,
            //     'name' => $request->name,
            //     'orderId' => $revolutOrder['id'] ?? null,
            //     'description' => $revolutOrder['description'] ?? null,
            //     'revolutPublicOrderId' => $revolutOrder['public_id'] ?? null,
            //     'state' => $revolutOrder['state'] ?? null,
            // ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Order creation failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function success(Request $request)
    {
        $id = $request->input('_rp_oid');
        try {
            $order = Order::where('revolut_public_id', $id)->firstOrFail();
            
            $response = $this->revolutService->getOrder($order->revolut_order_id);
            $orderData = json_decode($response->getBody(), true);
            
            $amount = $orderData['order_amount']['value'];
            $currency = $orderData['order_amount']['currency'];
            $amountInPounds = $amount / 100;
            $order->user->wallet->increment('gbp_balance', $amountInPounds);
            $order->update(['state' => 'COMPLETED']);
 
            return view('user.pages.success.index', [
                'success' => true,
                'order' => $orderData, 
                'message' => 'Payment completed successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to get order',
                'message' => $e->getMessage(),
            ], 500);
        }
    } 

    public function failed(){
        return view('user.pages.payment.failed'); 
    }

    
}