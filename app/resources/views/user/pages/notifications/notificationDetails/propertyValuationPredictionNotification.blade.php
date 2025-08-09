<div class="card-body">
    <h3 class="card-title mb-3">Upward Revision: Asset Valuation Update for {{ $notification->data['property_name'] }}</h3>

    <p>Dear {{ auth()->user()->first_name }} {{ auth()->user()->last_name }},</p>
    <p class="mb-2">
        We are pleased to inform you that the valuation for your property located at has increased! This exciting news reflects the current market trends and enhanced demand in your area.
      
    </p>

    <div class="mt-4">
        
        <div class="alert alert-info">
           <p> 
            I trust this email finds you well. I am writing to inform you about a positive adjustment to our valuation forecast for {{ $notification->data['property_name'] }}.

           </p>
         

        </div>
        <h3 class="mb-2">New Valuation Prediction Details</h3>

        
     <div class="notification-meta mt-3">
            <p>Here are the details of your transfer</p>
            <p>Based on our latest analysis, we have revised the projected valuation upward 
                from ₦{{ number_format($notification->data['current_market_value'], 2) }} 
                to ₦ {{ number_format($notification->data['future_market_value'], 2) }}, 
                representing a {{ ceil($notification->data['percentage_increase'])}}% increase. This revision reflects:
            </p>
            <br>
            <p><strong> ⁠Strong market performance:</strong></p>
            <p><strong> ⁠Improved operational metrics:</strong></p>
            <p><strong> Favorable industry conditions:</strong></p>

        </div> 
    </div>

    <p class="mt-4">
        Our team remains available to discuss these updates in detail. You may schedule a call to review the underlying assumptions and implications.

    </p>

    <p>Thank you for using {{ config('app.name') }}!</p>
</div>

<style>
    .card-body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .alert-info {
        background-color: #e7f8ff;
        border-left: 4px solid #17a2b8;
    }
    .notification-meta {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
    }
</style>