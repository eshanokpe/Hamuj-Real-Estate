<div class="card-body">
    <h3 class="card-title mb-3">Exciting update: Your property valuation has increased!</h3>

    <p>Dear {{ auth()->user()->first_name }} {{ auth()->user()->last_name }},</p>
    <p class="mb-2">
        We are pleased to inform you that the valuation for your property located at has increased! This exciting news reflects the current market trends and enhanced demand in your area.
      
    </p>

    <div class="mt-4">
        
        <div class="alert alert-info">
           <p> 
            This increase is a great opportunity for you if you’re considering selling your asset. Our team is here to assist you with any questions or to discuss next steps.
           </p>
         

        </div>
        <h3 class="mb-2">New Valuation Details</h3>

        
     <div class="notification-meta mt-3">
            <p>Here are the details </p>
            {{-- <p><strong>Previous Valuation:</strong> ₦{{ number_format($notification->data['total_price'], 2) }}</p> --}}
            <p><strong>New Valuation:</strong> ₦{{ number_format($notification->data['market_value'] ?? 'Unknown value', 2) }}</p>
            <p><strong>Percentage Increase:</strong> {{ $notification->data['percentage_increase'] }}%</p>
           
        </div> 
    </div>

    <p class="mt-4">
        Thank you for being a valued member of our community. We look forward to supporting you in maximizing the potential of your asset!
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