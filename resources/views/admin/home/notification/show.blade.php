@extends('layouts.admin')

@section('content')

<div class="page-wrapper">

    <!-- Page Content-->
    <div class="page-content-tab">

        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="float-end">
                            <ol class="breadcrumb">
                                <a href="{{ route('admin.users')}}" class="btn btn-dark">Back</a>
                            </ol>
                        </div>
                        <h4 class="page-title">Notification</h4>
                    </div>
                    <!--end page-title-box-->
                </div>
                <!--end col-->
            </div>
            <!-- end page title end breadcrumb -->
            
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">View Notification</h4>
                         </div><!--end card-header-->
                        <div class="card-body">
                     
                        <div class="card notification-card mb-3">
                            <div class=" d-flex flex-column flex-md-row">
                                
                                <!-- Notification Details -->
                                <div class="notification-details flex-grow-1 ms-md-3">

                                    @if($notification->data['notification_status'] == 'WalletFundedNotification')
                                        <h3 class="card-title">Wallet Funded</h3>
                                        <div class="property-details">
                                            <p><strong>Funded Amount:</strong> ₦{{ number_format($notification['data']['amount'], 2) }}</p>
                                            <p><strong>New Balance:</strong> ₦{{ number_format($notification['data']['balance'], 2) }}</p>
                                        </div>
                                    @endif
                                    @if(($notification['data']['notification_status'] ?? '') === 'PropertyValuationNotification')
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h3 class="card-title">Property Valuation Notification</h3>
                                                        <h4 class="card-title text-primary">
                                                            {{ $notification['data']['property_name'] ?? 'No Property Name' }}
                                                        </h4>

                                                        <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
                                                            <small class="text-muted">
                                                                Received {{ $notification->created_at?->diffForHumans() ?? 'Unknown time' }}
                                                            </small>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="text-end">
                                                            <p>
                                                                <strong>Market Value:</strong>
                                                                ₦{{ isset($notification['data']['market_value']) ? number_format($notification['data']['market_value']) : '0.00' }}
                                                            </p>
                                                            <a href="{{ route('user.properties.show', encrypt($notification['data']['property_id'] ?? 1)) }}"
                                                            class="btn btn-success btn-md">
                                                                View more
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($notification['data']['notification_status'] == 'buyProperty')
                                        <div class="card">
                                            <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <h3 class="card-title">{{$notification['data']['title']}}</h3>
                                                    <h4 class="card-title text-primary">
                                                        {{ $notification['data']['property_name'] ?? 'No Property Name Provided' }}
                                                    </h4>
                                                    <h5 class="card-title text-secondary">
                                                        <b>Land Size:</b> {{ $notification['data']['land_size'] ?? 'N/A' }} SQM
                                                    </h5>
                                                    <p>
                                                        {{ $notification['data']['message'] ?? 'No Message Provided' }}
                                                    </p>

                                                    <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
                                                        <small class="text-muted">
                                                            Received {{ $notification->created_at?->diffForHumans() ?? 'Unknown Time' }}
                                                        </small>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="text-end">
                                                        <p>
                                                            <strong>Total Amount:</strong>
                                                            ₦{{ isset($notification['data']['amount']) ? number_format($notification['data']['amount']) : '0.00' }}
                                                        </p>

                                                        <a href="{{ route('user.properties.show', encrypt($notification['data']['property_id'] ?? 1)) }}"
                                                        class="btn btn-success btn-md">
                                                            View more
                                                        </a>

                                                    </div>
                                                </div>
                                            </div>

                                            </div>
                                        
                                        </div>
                                    @endif

                                    @if($notification['data']['notification_status'] == 'sellPropertyUserNotification')
                                        <div class="card">
                                            <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <h3 class="card-title">{{$notification['data']['title']}}</h3>
                                                    
                                                    
                                                    <p>
                                                        {{ $notification['data']['message'] ?? 'No Message Provided' }}
                                                    </p>

                                                    <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
                                                        <small class="text-muted">
                                                            Received {{ $notification->created_at?->diffForHumans() ?? 'Unknown Time' }}
                                                        </small>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="text-end">
                                                        

                                                        <a href="{{ route('user.properties.show', encrypt($notification['data']['property_id'] ?? 1)) }}"
                                                        class="btn btn-success btn-md">
                                                            View more
                                                        </a>

                                                    </div>
                                                </div>
                                            </div>

                                            </div>
                                        
                                        </div>
                                    @endif

                                    @if(($notification['data']['notification_status'] ?? '') === 'recipientSubmittedNotification')
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h3 class="card-title">
                                                            Property Transfer From 
                                                        </h3>
                                                        <p class="">
                                                            {{ $notification['data']['message'] ?? 'No message available' }}
                                                        </p>
                                                        

                                                        <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
                                                            <small class="text-muted">
                                                                Received {{ $notification->created_at?->diffForHumans() ?? 'Unknown time' }}
                                                            </small>
                                                        </div>
                                                    </div>

                                                        <div class="col-6">
                                                            <div class="text-end">
                                                                <h5 class="card-title text-primary">
                                                                    {{ $notification['data']['property_name'] ?? 'No Property Name' }}
                                                                </h5>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($notification['data']['notification_status'] == 'senderTransferNotification')
                                        <div class="card">
                                            <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <h3 class="card-title">Property Transfer To</h3>
                                                    <h4 class="card-title text-primary">
                                                        {{ $notification['data']['property_name'] ?? 'No Property Name Provided' }}
                                                    </h4>
                                                    <h5 class="card-title text-secondary">
                                                        <b>Land Size:</b> {{ $notification['data']['land_size'] ?? 'N/A' }} SQM
                                                    </h5>
                                                    <p>
                                                        Transfer to {{ $notification['data']['recipientName'] ?? 'No Recipient Name Provided' }}
                                                    </p>

                                                    <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
                                                        <small class="text-muted">
                                                            Received {{ $notification->created_at?->diffForHumans() ?? 'Unknown Time' }}
                                                        </small>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="text-end">
                                                        <p>
                                                            <strong>Total Amount:</strong>
                                                            ₦{{ isset($notification['data']['total_price']) ? number_format($notification['data']['total_price']) : '0.00' }}
                                                        </p>

                                                        <a href="{{ route('user.properties.show', encrypt($notification['data']['property_id'] ?? 1)) }}"
                                                        class="btn btn-success btn-md">
                                                            View more
                                                        </a>

                                                        @if(($notification['data']['status'] ?? '') === 'pending')
                                                            <div class="btn btn-warning btn-md">
                                                                Pending
                                                            </div>
                                                        @else
                                                            <div class="btn btn-success btn-md">
                                                                Accept
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            </div>
                                        
                                        </div>
                                    @endif

                                    @if($notification['data']['notification_status'] == 'transferNotification')
                                        <div class="card">
                                            <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <h3 class="card-title">{{$notification['data']['subject']}}</h3>
                                                                                                        
                                                    <p style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                                        {{ $notification['data']['message'] ?? 'No Message Provided' }}
                                                    </p>


                                                    <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
                                                        <small class="text-muted">
                                                            Received {{ $notification->created_at?->diffForHumans() ?? 'Unknown Time' }}
                                                        </small>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="text-end">
                                                        

                                                        <a href="{{ route('user.properties.show', encrypt($notification['data']['property_id'] ?? 1)) }}"
                                                        class="btn btn-success btn-md">
                                                            View more
                                                        </a>
                                                        @if(($notification['data']['status'] ?? '') === 'pending')
                                                            <div class="btn btn-warning btn-md">
                                                                Pending
                                                            </div>
                                                        @else
                                                            <div class="btn btn-success btn-md">
                                                                Accept
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>

                                            </div>
                                        
                                        </div>
                                    @endif

                                    
                
                                    
                                </div>
                            </div>
                        </div>
                        
                                                                 
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div><!--end col-->
                <div class="col-lg-3"></div>
            </div><!--end row-->

           
           
        </div><!-- container -->

        <!--Start Rightbar-->
        <!--Start Rightbar/offcanvas-->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="Appearance" aria-labelledby="AppearanceLabel">
            <div class="offcanvas-header border-bottom">
              <h5 class="m-0 font-14" id="AppearanceLabel">Appearance</h5>
              <button type="button" class="btn-close text-reset p-0 m-0 align-self-center" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">  
                <h6>Account Settings</h6>
                <div class="p-2 text-start mt-3">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch1">
                        <label class="form-check-label" for="settings-switch1">Auto updates</label>
                    </div><!--end form-switch-->
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch2" checked>
                        <label class="form-check-label" for="settings-switch2">Location Permission</label>
                    </div><!--end form-switch-->
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="settings-switch3">
                        <label class="form-check-label" for="settings-switch3">Show offline Contacts</label>
                    </div><!--end form-switch-->
                </div><!--end /div-->
                <h6>General Settings</h6>
                <div class="p-2 text-start mt-3">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch4">
                        <label class="form-check-label" for="settings-switch4">Show me Online</label>
                    </div><!--end form-switch-->
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch5" checked>
                        <label class="form-check-label" for="settings-switch5">Status visible to all</label>
                    </div><!--end form-switch-->
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="settings-switch6">
                        <label class="form-check-label" for="settings-switch6">Notifications Popup</label>
                    </div><!--end form-switch-->
                </div><!--end /div-->               
            </div><!--end offcanvas-body-->
        </div>
        <!--end Rightbar/offcanvas-->
        <!--end Rightbar-->
        
      
    </div>
    <!-- end page content -->
</div>
<!-- end page-wrapper -->


@endsection