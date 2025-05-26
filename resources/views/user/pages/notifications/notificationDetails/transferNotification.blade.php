<div class="card-body">
    <h3 class="card-title mb-3"> Transfer Successful - Property Asset Transaction Confirmation</h3>
 
    <p>Dear {{ auth()->user()->first_name }} {{ auth()->user()->last_name }},</p>
    {{-- {{ $notification }} --}}
   <p class="mb-2">
       This email confirms that the transfer of assets for property <b> {{ $notification->data['property_name'] ?? ' ' }} </b> has been successfully completed
     
    </p> 
    <div class="mt-4">
        <h3 class="mb-2">Transaction Details</h3>
        
        <div class="alert alert-info">
            The funds have been securely processed and will be reflected in your wallet
            {{-- <p class="mb-0">{{ $notification->data['message'] }}</p> --}}
        </div>

        <div class="notification-meta mt-3">
            <p>Here are the details of your transfer</p>
            <p><strong>Property:</strong> {{ $notification->data['property_name'] ?? '' }}</p>
            <p><strong>Transaction Reference:</strong> {{ $notification->data['reference'] ?? 'Unknown reference' }}</p>
            <p><strong>Amount:</strong> ₦{{ ($notification->data['amount'] ?? '0.00') }}</p>
            <p><strong>Transfer Date:</strong> {{ \Carbon\Carbon::parse($notification->created_at)->format('F j, Y \a\t g:i A') }}</p>
           
        </div>
{{--
        
   
    </div>   --}}

    <p class="mt-3">
        For your records, please retien this confirmation. 
        You can view the complete transaction details by logging into your account dashbaord.
    </p>
    <p class="mt-3">
        If you have any questions about this transfer, please contact our support team at 
        {{$contactDetials->first_email}} 
        @if( $contactDetials->second_email == null)
        , {{$contactDetials->second_email}}
        @endif or call
        {{$contactDetials->first_phone}}  
        @if( $contactDetials->second_phone == null)
       , {{$contactDetials->second_phone}}
       @endif
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