<div class="card-body">
    <h3 class="card-title mb-3">{{ $notification['data']['subject'] ?? 'Your Wallet Has Been Credited' }}</h3>

    <p>Dear {{ auth()->user()->first_name }} {{ auth()->user()->last_name }},</p>

    <div class="mt-4">
        <div class="alert alert-info">
            We are excited to inform you that your wallet has been credited with funds, ready for you to use on Dohmayn!
        </div>

        <h3 class="mb-2">Transaction Details</h3>

        <div class="notification-meta mt-3">
            <p>Here are the details of your transfer</p>

            @php
                $rawAmount = $notification->data['amount'] ?? 0;
                $amount = is_numeric($rawAmount) ? ((float) $rawAmount / 100) : 0;
            @endphp

            <p><strong>Amount Received:</strong> ₦{{ number_format($amount, 2) }}</p>

            <p><strong>Transfer Date:</strong> {{ \Carbon\Carbon::parse($notification->created_at)->format('F j, Y \a\t g:i A') }}</p>
        </div>

        <p class="mt-3">
            You can now utilize these funds to purchase assets listed on our platform. Explore our latest offerings and make your next investment today!
        </p>

        <p class="mt-3">
            If you have any questions or require assistance, please don't hesitate to reach out to our support team.
        </p>

        <p class="mt-3">
            If you have any questions about this transfer, please contact our support team at 
            {{ $contactDetials->first_email }}
            @if(!empty($contactDetials->second_email))
                , {{ $contactDetials->second_email }}
            @endif 
            or call 
            {{ $contactDetials->first_phone }}
            @if(!empty($contactDetials->second_phone))
                , {{ $contactDetials->second_phone }}
            @endif
        </p> 

        <p>Thank you for using {{ config('app.name') }}!</p>
    </div>
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
