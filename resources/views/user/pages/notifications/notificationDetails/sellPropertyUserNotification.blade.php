<div class="card-body">
    <h3 class="card-title mb-3">New Asset Sell Request</h3>

    <p>Dear {{ auth()->user()->first_name }} {{ auth()->user()->last_name }},</p>
    <p>
        Thank you for choosing Dohmayn to sell your asset! We're excited to help you through this process.
    </p>
    
    <div class="mt-4">
        <h3 class="mb-2">Request Details</h3>
        
        <div class="alert alert-info">
            <h4>{{ $notification->data['title'] }}</h4>
            <p class="mb-0">{{ $notification->data['message'] }}</p>
        </div>
        
        <div class="notification-meta mt-3">
            <p><strong>Request ID:</strong> {{ $notification->id }}</p>
            <p><strong>Submitted:</strong> {{ \Carbon\Carbon::parse($notification->created_at)->format('F j, Y \a\t g:i A') }}</p>
            <p><strong>Status:</strong> 
                @if($notification->status)
                    <span class="badge bg-success">Reviewed</span>
                @else
                    <span class="badge bg-warning">Pending Review</span>
                @endif
            </p>
        </div>
    </div>

    <div class="mt-4">
        <h4>Next Steps:</h4>
        <ul>
            <li>Our team will review your request within 24-48 hours</li>
            <li>You'll receive an email with further instructions</li>
            <li>Check your dashboard for updates</li>
        </ul>
    </div>

    <p class="mt-4">
        If you have any questions or need assistance, feel free to contact our support team.
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