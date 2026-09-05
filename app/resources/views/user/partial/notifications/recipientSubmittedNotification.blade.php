@php
    $sender = \App\Models\User::find($notification['data']['sender_id'] ?? null);
    $senderName = $sender ? trim($sender->first_name . ' ' . $sender->last_name) : 'A user';
@endphp
<div class="p-2 notification__type--wallet">
    <h4>Accept Your Asset Transfer</h4>
    <p>
        {{ $senderName }} sent you an asset transfer of
        ₦{{ number_format(($notification['data']['total_price'] ?? 0) / 100, 2) }}.
        Review it to complete the transfer.
    </p>
</div>
