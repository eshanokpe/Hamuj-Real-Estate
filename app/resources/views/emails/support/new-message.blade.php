@component('mail::layout')
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }} Support
        @endcomponent
    @endslot

    # New Support Message Received

    **Hello {{ $adminName }}**,  
    A new support message has been received from a {{ $userType }} user.

    @component('mail::panel')
        {{ $messageContent }}
    @endcomponent

    **Received at:** {{ $receivedAt }}  
    **Conversation ID:** {{ $conversationId }}

    @component('mail::button', ['url' => route('admin.conversations.show', $conversationId)])
        View Conversation
    @endcomponent

    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent