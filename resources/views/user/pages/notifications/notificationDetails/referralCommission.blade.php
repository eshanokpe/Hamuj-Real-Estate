<div class="card-body">
    <h3 class="card-title mb-3">{{ $notification['data']['subject'] ?? '🎉  Referral Commission!' }}</h3>
 
    <p>Dear {{ auth()->user()->first_name }} {{ auth()->user()->last_name }},</p>
    {{-- {{ $notification }} --}}
   
    <div class="mt-4">
        <div class="alert alert-info">
            {{ $notification['data']['subject'] ?? '🎉 Referral Commission!' }}
        </div>
        <h3 class="mb-2">Transaction Details</h3>

        <div class="notification-meta mt-3">
            {{$notification['data']['message']}}

        </div>

    <p class="mt-3">
    </p>
    <a class="btn btn-primary btn-large" href="{{route('user.referral.index') }}">
        View Your Referrals
    </a>
   
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