<div class="card-body">
    <h3 class="card-title mb-3">{{ $notification['data']['title'] }}</h3>
 
    <p>Dear {{ auth()->user()->first_name }} {{ auth()->user()->last_name }},</p>
    
    <p>
        I hope you're doing well! <br/>
    </p>
    
    <div class="mt-4">
        
        <div class="alert alert-info">
            Congratulations on your recent purchase of {{$notification->data['property_name']}}! We are thrilled to have assisted you in acquiring this fantastic asset and are confident that it will bring you joy and investment success.
        </div>
       

    <p class="mt-3">
        If you have any questions, please don’t hesitate to reach out. We're here to help!
    </p>
    <p>
        Additionally, if you could take a moment to share your experience with us, we would greatly appreciate your feedback. It helps us enhance our services for future users.
    </p>
    <p>
        Thank you once again for choosing Dohmayn. We look forward to staying in touch!
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