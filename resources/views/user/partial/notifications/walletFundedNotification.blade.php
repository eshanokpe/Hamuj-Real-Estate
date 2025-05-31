


<div class="notification__type--wallet">
    <h4>{{ $notification['data']['subject'] ?? 'Your Wallet Has Been Credited' }}</h4>
    <p>
        ₦{{ number_format($notification['data']['amount'], 2) }} received
        <small>New balance: ₦{{ number_format((float) $notification['data']['balance'], 2) }}</small>
    </p> 
</div>