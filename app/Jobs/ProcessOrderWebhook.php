<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class ProcessOrderWebhook implements ShouldQueue
{ 
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $event;
    protected $orderData;

    public function __construct($event, $orderData)
    {
        $this->event = $event;
        $this->orderData = $orderData;
    }

    public function handle()
    {
        $orderId = $this->orderData['order_id'] ?? null;
        $amount = $this->orderData['order_amount']['value']; // in minor units (pence)
        $currency = $this->orderData['order_amount']['currency'];

        // Only process GBP payments
        if (strtoupper($currency) !== 'GBP') return;
        $order = Order::with('user.wallet')
            ->where('revolut_order_id', $orderId)
            ->first();

        if (!$order) {
            Log::error("Revolut Webhook: Order {$orderId} not found");
            return;
        }

         
        // if (!$orderId) return;

        // $order = Order::where('revolut_order_id', $orderId)->first();

        // if (!$order) return; 
 
        switch ($this->event) {
            case 'ORDER_COMPLETED': 
                $order->update(['state' => 'COMPLETED']);
                // Send confirmation email, etc.
                break;
            case 'PAYMENT_CAPTURED':
                // Convert from pence to pounds
                $amountInPounds = $amount / 100;
                
                $order->user->wallet->increment('gbp_balance', $amountInPounds);
                $order->update(['status' => 'completed']);
                
                Log::info("Wallet credited with £{$amountInPounds} for order {$orderId}");
                break;
            case 'ORDER_AUTHORISED':
                $order->update(['state' => 'AUTHORISED']);
                break;
            default:
                $order->update(['state' => $this->event]);
                break;
        }

        Log::info("Processed {$this->event} for order {$orderId}");
    }
}