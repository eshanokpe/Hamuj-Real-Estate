@extends('layouts.dashboard')

@section('content')

<div class="dashboard__page--wrapper">
    <div class="page__body--wrapper" id="dashbody__page--body__wrapper">
        
        <main class="main__content_wrapper">
            <div class="dashboard__container dashboard__reviews--container">
                <div class="reviews__heading mb-30">
                    <h2 class="reviews__heading--title">Notification</h2>
                </div>
                
                <div class="properties__wrapper">
                    <div class="properties__table table-responsive p-3">
                        
                        @forelse ($notifications as $notification)
                        <div class="card notification-card mb-3">
                            <div class=" d-flex flex-column flex-md-row">
                                
                
                                <!-- Notification Details -->
                                <div class="notification-details flex-grow-1 ms-md-3">
                                    {{-- {{$notification['data']['notification_status']}} --}}
                                    @if($notification['data']['notification_status'] == 'WalletFundedNotification' || $notification['data']['notification_status'] == 'walletFundedNotification' || $notification['data']['notification_status'] == 'Wallet Funded Notification')
                                        <div class="">
                                            <div class="card-body">
                                                <div class="row "> 
                                                    <div class="col-9">
                                                        <h3 class="card-title">{{ $notification['data']['subject'] ?? 'Your Wallet Has Been Credited' }}</h3>
                                                        @php
                                                            $amountRaw = $notification['data']['amount'] ?? '0';
                                                            $balanceRaw = $notification['data']['balance'] ?? '0';

                                                            $amount = (float) str_replace(',', '', $amountRaw);
                                                            $balance = (float) str_replace(',', '', $balanceRaw);
                                                        @endphp

                                                        <p>
                                                            ₦{{ number_format($amount, 2) }} received
                                                            <small>New balance: ₦{{ number_format($balance, 2) }}</small>
                                                        </p>

                                                    </div>
                                    
                                                <div class="col-3">
                                                        <div class="text-end">
                                                            <a href="{{ route('user.notifications.show', encrypt($notification->id)) }}" class="btn btn-success btn-large">
                                                                View More
                                                            </a>
                                                            
                                                        </div> 
                                                    </div>
                                            
                                                </div>
                                            </div>
                                        </div>
                                       
                                    @endif
                                    @if($notification['data']['notification_status'] == 'new_referral')
                                        <div class="">
                                            <div class="card-body">
                                                <div class="row "> 
                                                    <div class="col-9">
                                                        <h3 class="card-title">{{ $notification['data']['subject'] ?? '🎉 New Referral Signup!' }}</h3>
                                                        <p> 
                                                            Congratulations! {{ $notification['data']['message'] }}.
                                                            
                                                        </p>
                                        
                                                        <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
                                                            <small class="text-muted">Received {{ $notification->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    </div>
                                    
                                                <div class="col-3">
                                                        <div class="text-end">
                                                            <a href="{{ route('user.notifications.show', encrypt($notification->id)) }}" class="btn btn-success btn-large">
                                                                View More
                                                            </a>
                                                            
                                                        </div> 
                                                    </div>
                                            
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                        
                                    
                                    @if($notification['data']['notification_status'] == 'recipientSubmittedNotification' || $notification['data']['notification_status'] == 'Recipient Submitted Notification')
                                        <div class="">
                                            <div class="card-body">
                                                <div class="row "> 
                                                    <div class="col-9">
                                                        <h3 class="card-title">{{ $notification['data']['message'] }}</h3>
                                                        <h4 class="card-title text-primary">{{ $notification['data']['property_name'] }}</h4>
                                        
                                                        <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
                                                            <small class="text-muted">Received {{ $notification->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    </div>
                                     
                                                @if($notification['data']['status'] === 'pending' && isset($notification['data']['property_mode'], $notification['data']['property_slug']))
                                                    <div class="col-3">
                                                        <div class="text-end">
                                                            <a href="{{ route('user.notifications.show', encrypt($notification->id)) }}" class="btn btn-warning btn-md">
                                                                Click here to confirm your transfer
                                                            </a>
                                                             
                                                        </div> 
                                                    </div>
                                                @else
                                                    <div class="col-3">
                                                        <div class="text-end">
                                                            <a href="{{ route('user.notifications.show', encrypt($notification->id)) }}" class="btn btn-success btn-md">
                                                                The Assets have ben accepted
                                                            </a>
                                                            
                                                        </div>
                                                    </div>
                                                @endif
                                                </div>
                                            </div>
                                            
                                        </div>
                                    @endif
                                    @if($notification['data']['notification_status'] == 'PropertyValuationNotification' || $notification['data']['notification_status'] == 'Property Valuation Notification')
                                        <div class="">
                                            <div class="card-body">
                                                <div class="row ">
                                                    <div class="col-9">
                                                        <h3 class="card-title">Property Valuation Notification</h3>
                                                        <h4 class="card-title text-primary">{{ $notification['data']['property_name'] }}</h4>
                                                    
                                                        <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
                                                            <small class="text-muted">Received {{ $notification->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    </div>
                                    
                                                    <div class="col-3">
                                                        <div class="text-end">
                                                            <p> <strong>Market Value:</strong> ₦{{ number_format( $notification['data']['market_value'] ) }} </p>
                                                            <a href="{{ route('user.notifications.show', encrypt($notification->id)) }}" class="btn btn-success btn-md">
                                                                View more
                                                            </a>
                                                        </div>
                                                    </div>
                                            
                                                </div>
                                            </div>
                                        
                                        </div>
                                    @endif

                                    @if($notification['data']['notification_status'] == 'senderTransferNotification' || $notification['data']['notification_status'] == 'Sender Transfer Notification' )
                                        <div class="">
                                            <div class="card-body">
                                                <div class="row ">
                                                    <div class="col-9">
                                                        <h3 class="card-title">Sender Transfer Notification</h3>
                                                        <h4 class="card-title text-primary">{{ $notification['data']['property_name'] }}</h4>
                                                        <h5 class="card-title text-secondary"><b>Land Size:</b>{{ $notification['data']['land_size'] }} SQM</h5>
                                                    
                                                        <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
                                                            <small class="text-muted">Received {{ $notification->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    </div>
                                    
                                                    <div class="col-3">
                                                        <div class="text-end">
                                                            <p> <strong>Total Amount:</strong> ₦{{ number_format( $notification['data']['total_price'] ) }} </p>
                                                            <a href="{{ route('user.notifications.show', encrypt($notification->id)) }}" class="btn btn-success btn-md">
                                                                View more
                                                            </a>
                                                            @if($notification['data']['status'] == "pending")
                                                                <div  class="btn btn-warning btn-md">
                                                                    Pending
                                                                </div>
                                                            @else
                                                                <div  class="btn btn-success btn-md">
                                                                    Accept
                                                                </div>
                                                            @endforelse
                                                        </div>
                                                    </div>
                                            
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($notification['data']['notification_status'] == 'sellPropertyUserNotification' )
                                        <div class="">
                                            <div class="card-body">
                                                <div class="row ">
                                                    <div class="col-9">
                                                        <h3 class="card-title">New Asset Sell Request</h3>
                                                        <p>
                                                            Thank you for choosing Dohmayn to sell your asset! We're excited to help you through this process.
                                                        </p>
                                                        <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
                                                            <small class="text-muted">Received {{ $notification->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    </div>
                                    
                                                    <div class="col-3">
                                                        <div class="text-end">
                                                            {{-- <p> <strong>Total Amount:</strong> ₦{{ number_format( $notification['data']['total_price'] ) }} </p> --}}
                                                            <a href="{{ route('user.notifications.show', encrypt($notification->id)) }}" class="btn btn-success btn-md">
                                                                View more
                                                            </a>
                                                           
                                                        </div>
                                                    </div>
                                            
                                                </div>
                                            </div>
                                        
                                        </div>
                                    @endif

                                    @if($notification['data']['notification_status'] == 'transferNotification')
                                        <div class="">
                                            <div class="card-body">
                                                <div class="row ">
                                                    <div class="col-9">
                                                        <h3 class="card-title"> Transfer Successful - Property Asset Transaction Confirmation</h3>
                                                        <p>
                                                            This email confirms that the transfer of assets for property ID has been successfully completed
                                                        </p>
                                                        <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
                                                            <small class="text-muted">Received {{ $notification->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    </div>
                                    
                                                    <div class="col-3">
                                                        <div class="text-end">
                                                            {{-- <p> <strong>Total Amount:</strong> ₦{{ number_format( $notification['data']['total_price'] ) }} </p> --}}
                                                            <a href="{{ route('user.notifications.show', encrypt($notification->id)) }}" class="btn btn-success btn-md">
                                                                View more
                                                            </a>
                                                        
                                                        </div>
                                                    </div>
                                            
                                                </div>
                                            </div>
                                        
                                        </div>
                                    @endif
                                    @if($notification['data']['notification_status'] == 'PropertyValuationPredictionNotification' || $notification['data']['notification_status'] == 'propertyValuationPredictionNotification')
                                        <div class="">
                                            <div class="card-body">
                                                <div class="row ">
                                                    <div class="col-9">
                                                        <h3 class="card-title"> Exciting update: Your property valuation has increased!</h3>
                                                        <p>
                                                            Upward Revision: Asset Valuation Update for  {{ $notification['data']['property_name'] }}
                                                        </p>
                                                        <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
                                                            <small class="text-muted">Received {{ $notification->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    </div>
                                    
                                                    <div class="col-3">
                                                        <div class="text-end">
                                                            {{-- <p> <strong>Total Amount:</strong> ₦{{ number_format( $notification['data']['total_price'] ) }} </p> --}}
                                                            <a href="{{ route('user.notifications.show', encrypt($notification->id)) }}" class="btn btn-success btn-md">
                                                                View more
                                                            </a>
                                                        
                                                        </div>
                                                    </div>
                                            
                                                </div>
                                            </div>
                                        
                                        </div>
                                    @endif

                                    @if($notification['data']['notification_status'] == 'buyProperty')
                                        <div class="">
                                            <div class="card-body">
                                                <div class="row "> 
                                                    <div class="col-9">
                                                        <h3 class="card-title">{{ $notification['data']['title']}}</h3>
                                                        <p> 
                                                             {{ $notification['data']['message'] }}.
                                                             
                                                        </p>
                                        
                                                        <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
                                                            <small class="text-muted">Received {{ $notification->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    </div>
                                    
                                                <div class="col-3">
                                                        <div class="text-end">
                                                            <a href="{{ route('user.notifications.show', encrypt($notification->id)) }}" class="btn btn-success btn-large">
                                                                View More
                                                            </a>
                                                            
                                                        </div> 
                                                    </div>
                                            
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                

                                    
                
                                    
                                </div>
                            </div>
                        </div>
                        @empty
                            <p>No notifications available</p>
                        @endforelse
                            
                    </div>
                
                    <!-- Pagination -->
                    <div class="pagination__area">
                        <nav class="pagination justify-content-center">
                            <ul class="pagination__menu d-flex align-items-center justify-content-center">
                                <!-- Render pagination links dynamically -->
                                @if ($notifications->onFirstPage())
                                    <li class="pagination__menu--items pagination__arrow disabled">
                                        <span class="pagination__arrow-icon">
                                            <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10.583 20.5832L0.999675 10.9998L10.583 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                    </li>
                                @else
                                    <li class="pagination__menu--items pagination__arrow">
                                        <a href="{{ $notifications->previousPageUrl() }}" class="pagination__arrow-icon link">
                                            <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10.583 20.5832L0.999675 10.9998L10.583 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>
                                    </li>
                                @endif

                                <!-- Page numbers -->
                                @foreach ($notifications->links()->elements[0] as $page => $url)
                                    <li class="pagination__menu--items">
                                        <a href="{{ $url }}" class="pagination__menu--link {{ $page == $notifications->currentPage() ? 'active color-accent-1' : '' }}">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endforeach

                                @if ($notifications->hasMorePages())
                                    <li class="pagination__menu--items pagination__arrow">
                                        <a href="{{ $notifications->nextPageUrl() }}" class="pagination__arrow-icon link">
                                            <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1.00098 20.5832L10.5843 10.9998L1.00098 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>
                                    </li>
                                @else
                                    <li class="pagination__menu--items pagination__arrow disabled">
                                        <span class="pagination__arrow-icon">
                                            <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1.00098 20.5832L10.5843 10.9998L1.00098 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div> 

                </div>
                
            </div>
        </main>
    </div>
</div>

@endsection
