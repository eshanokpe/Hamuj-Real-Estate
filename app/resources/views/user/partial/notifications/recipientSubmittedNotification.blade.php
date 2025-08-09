
<div class="p-2 notification__type--wallet">
    <h4> Accept Your Asset Transfer</h4>
    <p>
        You have received an asset transfer 
        of ₦{{ number_format($notification['data']['total_price']/100 ?? '', 2) }} from
        {{\App\Models\User::find( $notification['data']['sender_id'] ?? '' )->first_name }} {{\App\Models\User::find( $notification['data']['sender_id'] ?? '' )->last_name }}. 
        To complete the transaction.
    </p>

    {{-- <p>{{ $notification['data']['message'] ?? '' }}</p> --}}
</div>