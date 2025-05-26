<div class="card-body">
    @if ($notification->data['notification_status'] === 'recipientSubmittedNotification' || $notification['data']['notification_status'] == 'Recipient Submitted Notification')

        <h3 class="card-title mb-3">Accept Your Asset Transfer</h3>
 
        <p>Dear {{ auth()->user()->first_name }} {{ auth()->user()->last_name}},</p>

        <p>
            You have received an asset transfer of 
            <strong>&#x20A6;{{ number_format($notification->data['total_price']/100, 2) }}</strong> from 
            <strong>{{ \App\Models\User::find($notification->data['sender_id'])->first_name .' '. \App\Models\User::find($notification->data['sender_id'])->last_name   ?? 'Sender\'s Name' }}</strong> via 
            <strong>{{ config('app.name') }}</strong>. 
            To complete the transaction, please follow the steps below to accept the transfer:
        </p>

        

        <p>
            If you have any questions or need assistance, feel free to contact our support team.
        </p>

        <p>Thank you for using {{ config('app.name') }}!</p>

       

        <div class="mt-4">
            <h3 class="mb-2">Property Details</h3>

            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset($notification->data['property_image']) }}" alt="{{ $notification->data['property_name'] }}" class="img-fluid">
                </div>
                <div class="col-md-8">
                    <p><strong>Property Name:</strong> {{ $notification->data['property_name'] }}</p>
                    <p><strong>Property Mode:</strong> {{ ucfirst($notification->data['property_mode']) }}</p>
                    <p><strong>Land Size:</strong> {{ $notification->data['land_size'] }} SQM</p>
                    <p><strong>Total Price:</strong> &#x20A6;{{ number_format($notification->data['total_price']/100, 2) }}</p>
                </div>
            </div> 
        </div> 

        {{-- Accept Transfer Button --}}
        @if($notification->data['status'] == 'pending')
            <form action="{{ route('user.confirm.transfer.submit', $notification->id) }}" method="POST" class="mt-4">
                @csrf
               
                <input type="hidden" name="land_size" value="{{ $notification->data['land_size'] }}">
                <input type="hidden" name="sender_id" value="{{ $notification->data['sender_id'] }}">
                <input type="hidden" name="property_id" value="{{ $notification->data['property_id'] }}">
                <input type="hidden" name="amount" value="{{ $notification->data['total_price'] }}">
            
                <button type="submit" class="btn btn-primary btn-lg">
                    ✅ Accept Transfer
                </button>
            </form>
        @else
            <button class="btn btn-success btn-lg">
                ✅ This transfer has been approved
            </button>
        @endif
         
        <br><br>
        <br>
        <div class="card-footer text-muted">
            Received: {{ \Carbon\Carbon::parse($notification->created_at)->format('F j, Y - g:i A') }}
        </div>
        <br>
    @else
        <p class="text-muted">This notification is not applicable for display.</p>
    @endif
</div>