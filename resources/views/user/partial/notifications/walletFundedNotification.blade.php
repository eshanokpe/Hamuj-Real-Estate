<div class="notification__type--wallet">
    <h4>{{ $notification['data']['subject'] ?? 'Your Wallet Has Been Credited' }}</h4>
    <p>
        ₦{{ number_format((float) ($notification['data']['amount'] ?? 0), 2) }} received<br>
        <small>New balance: ₦{{ number_format((float) ($notification['data']['balance'] ?? 0), 2) }}</small>
    </p> 
</div>
