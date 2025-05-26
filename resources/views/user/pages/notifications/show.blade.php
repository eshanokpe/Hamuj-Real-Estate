@extends('layouts.dashboard')

@section('content')

<div class="dashboard__page--wrapper">
    <div class="page__body--wrapper" id="dashbody__page--body__wrapper">
        
        <main class="main__content_wrapper">
            <div class="dashboard__container dashboard__reviews--container">
                <div class="reviews__heading mb-30">
                    <h2 class="reviews__heading--title">Notification Details</h2>
                </div>
                
                <div class="properties__wrapper">
                    
         
                    <div class="container mt-4">
                        <div class=" shadow-sm">
                            
                            {{-- {{$notification->data['notification_status']}} --}}
                            @if ($notification->data['notification_status'] === 'recipientSubmittedNotification' || $notification['data']['notification_status'] == 'Recipient Submitted Notification')
                                @include('.user/pages/notifications/notificationDetails/recipientSubmittedNotification')
                            @elseif ($notification->data['notification_status'] === 'sellPropertyUserNotification')
                                @include('.user/pages/notifications/notificationDetails/sellPropertyUserNotification')
                            @elseif ($notification->data['notification_status'] === 'senderTransferNotification' || $notification->data['notification_status'] === 'Sender Transfer Notification')
                                @include('.user/pages/notifications/notificationDetails/senderTransferNotification')
                            @elseif ($notification->data['notification_status'] === 'transferNotification' )
                                @include('.user/pages/notifications/notificationDetails/transferNotification')
                            @elseif ($notification->data['notification_status'] === 'propertyValuationNotification' || $notification->data['notification_status'] === 'Property Valuation Notification' || $notification->data['notification_status'] === 'PropertyValuationNotification' )
                                @include('.user/pages/notifications/notificationDetails/propertyValuationNotification')
                            @elseif ($notification->data['notification_status'] === 'PropertyValuationPredictionNotification' || $notification->data['notification_status'] === 'propertyValuationPredictionNotification' )
                                @include('.user/pages/notifications/notificationDetails/propertyValuationPredictionNotification')
                            @elseif ($notification->data['notification_status'] === 'PropertyValuationPredictionNotification' || $notification->data['notification_status'] === 'propertyValuationPredictionNotification' )
                                @include('.user/pages/notifications/notificationDetails/propertyValuationPredictionNotification')
                            @elseif ($notification->data['notification_status'] === 'WalletFundedNotification' || $notification->data['notification_status'] === 'Wallet Funded Notification'  || $notification->data['notification_status'] === 'walletFundedNotification' )
                                @include('.user/pages/notifications/notificationDetails/walletFundedNotification')
                            @elseif ($notification->data['notification_status'] === 'new_referral'  )
                                @include('.user/pages/notifications/notificationDetails/newReferral')
                            @elseif ($notification->data['notification_status'] === 'buyProperty'  )
                                @include('.user/pages/notifications/notificationDetails/buyProperty')
                            @else 
                                <p class="text-muted">This notification is not applicable for display.</p>
                            @endif
                    
                            
                            
                        </div>
                    </div>
                    
                    
                
                 

                </div>
                
            </div>
        </main>
    </div>
</div>

@endsection
