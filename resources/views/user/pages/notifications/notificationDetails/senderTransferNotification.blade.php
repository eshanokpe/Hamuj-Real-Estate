<div class="card-body">
    <h3 class="card-title mb-3">Asset Transfer Pending</h3>

    <p>Dear {{ auth()->user()->first_name }} {{ auth()->user()->last_name }},</p>
    <p class="mb-2">
        Thank you for choosing Dohmayn to sell your asset! You have successfully initiated an assets transfer 
        of ₦{{ number_format($notification->data['total_price']/100, 2) }} to 
        <b>{{ $notification->data['recipient_name'] ?? 'the recipient' }}</b>.
    </p>

    <div class="mt-4">
        <h3 class="mb-2">Request Details</h3>
         
        <div class="alert alert-info">
            Please note that the transfer is currently pending acceptance by the recipient. 
            <p class="mb-0">{{ $notification->data['message'] ?? 'Asset Transfer Pending: Action Required by Receiver' }}</p>
        </div>
        
        <div class="notification-meta mt-3">
            <p>Here are the details of your transfer</p>
            <p><strong>Amount:</strong> ₦{{ number_format($notification->data['total_price'], 2) }}</p>
            <p><strong>Receiver:</strong> {{ $notification->data['recipient_name'] ?? 'Unknown recipient' }}</p>
            <p><strong>Transfer ID:</strong> {{ $notification->data['reference'] }}</p>
            <p><strong>Submitted:</strong> {{ \Carbon\Carbon::parse($notification->created_at)->format('F j, Y \a\t g:i A') }}</p>
            <p><strong>Status:</strong> 
                @if(($notification->data['status'] ?? null) === 'completed' || 'approved')
                    <span class="badge bg-success">Approved</span>
                @else
                    <span class="badge bg-warning">Pending</span>
                @endif
            </p>
        </div>
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