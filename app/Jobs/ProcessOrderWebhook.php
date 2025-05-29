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
         
        if (!$orderId) return;

        $order = Order::where('revolut_order_id', $orderId)->first();

        if (!$order) return; 

        switch ($this->event) {
            case 'ORDER_COMPLETED':
                $order->update(['state' => 'COMPLETED']);
                // Send confirmation email, etc.
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