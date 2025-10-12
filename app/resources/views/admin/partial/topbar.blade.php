<style>
    /* Property Stats Styles */
    .property-stats-item {
        padding: 8px 12px;
        border-bottom: 1px solid #f8f9fa;
    }

    .property-stats-item:last-child {
        border-bottom: none;
    }

    .property-stats-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }

    /* Tooltip enhancements */
    .tooltip {
        font-size: 0.875rem;
    }
</style>

<!-- Top Bar Start -->
<div class="topbar">            
    <!-- Navbar -->
    <nav class="navbar-custom" id="navbar-custom">    
        <ul class="list-unstyled topbar-nav float-end mb-0">
           
            <li class="dropdown notification-list me-3">
                <a class="nav-link dropdown-toggle nav-icon" data-bs-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <div class="d-flex align-items-center text-success">
                        <i class="ti ti-layout-grid me-2"></i>
                        <div class="d-flex flex-column" style="padding-right: 30px">
                            <small class="fw-semibold font-11">Available Size</small>
                            <span class="fw-bold font-12">{{ number_format(\App\Models\Property::sum('available_size'), 2) }} SQM</span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-lg pt-0">
                    <h6 class="dropdown-item-text font-15 m-0 py-3 border-bottom d-flex justify-content-between align-items-center">
                        Property Statistics
                    </h6>
                    <div class="notification-menu" data-simplebar style="max-height: 300px;">
                        @php
                            $totalProperties = \App\Models\Property::count();
                            $totalAvailableSize = \App\Models\Property::sum('available_size');
                            $properties = \App\Models\Property::select('name', 'available_size')->get();
                        @endphp
                        
                        <!-- Summary -->
                        <div class="dropdown-item py-2">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">Total Properties:</small>
                                <span class="badge bg-primary">{{ $totalProperties }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Available Size:</small>
                                <span class="badge bg-success">{{ number_format($totalAvailableSize, 2) }} SQM</span>
                            </div>
                        </div>
                        
                        <div class="dropdown-divider"></div>
                        
                        <!-- Individual Properties -->
                        <h6 class="dropdown-item-text font-14 m-0 py-2">Individual Properties</h6>
                        @foreach($properties as $property)
                        <div class="dropdown-item py-2 property-stats-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-truncate" style="max-width: 150px;" title="{{ $property->name }}">
                                    {{ $property->name }}
                                </small>
                                <span class="badge bg-soft-{{ $property->available_size > 0 ? 'success' : 'danger' }}">
                                    {{ number_format($property->available_size, 2) }} SQM
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </li>
            <!-- Email Notifications -->
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <i class="ti ti-mail"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-lg pt-0">
        
                    <h6 class="dropdown-item-text font-15 m-0 py-3 border-bottom d-flex justify-content-between align-items-center">
                        Emails <span class="badge bg-soft-primary badge-pill">3</span>
                    </h6> 
                    <div class="notification-menu" data-simplebar>
                        <!-- item-->
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-end text-muted ps-2">2 min ago</small>
                            <div class="media">
                                <div class="avatar-md bg-soft-primary">
                                    <img src="{{ asset('admin/images/users/user-1.jpg')}}" alt="" class="thumb-sm rounded-circle">
                                </div>
                                <div class="media-body align-self-center ms-2 text-truncate">
                                    <h6 class="my-0 fw-normal text-dark">Your order is placed</h6>
                                    <small class="text-muted mb-0">Dummy text of the printing and industry.</small>
                                </div><!--end media-body-->
                            </div><!--end media-->
                        </a><!--end-item-->
                    </div>
                    <!-- All-->
                    <a href="javascript:void(0);" class="dropdown-item text-center text-primary">
                        View all <i class="fi-arrow-right"></i>
                    </a>
                </div>
            </li>

            <!-- Notifications -->
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <i class="ti ti-bell"></i>
                    <span class="alert-badge"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-lg pt-0">
        
                    <h6 class="dropdown-item-text font-15 m-0 py-3 border-bottom d-flex justify-content-between align-items-center">
                        Notifications <span class="badge bg-soft-primary badge-pill">{{ $unreadAdminCount }}</span>
                    </h6>

                    <div class="notification-menu" data-simplebar>
                       
                        @foreach ($notificationsAdminBar as $notification)
                            <!-- item-->
                            <a href="{{ route('admin.notifications.show', $notification->id) }}" class="dropdown-item py-3">
                            @php
                                $status = $notification['data']['notification_status'] ?? null;
                                $notificationTitle = match ($status) {
                                    'walletFundedNotification' => 'Wallet Funded',
                                    'propertyValuationNotification' => 'Property Valuation',
                                    'buyProperty' => 'Buy Property',
                                    'sellPropertyUserNotification' => 'Sell Property By User',
                                    'recipientSubmittedNotification' => 'Property Transfer From User',
                                    'senderTransferNotification' => 'Property Transfer To User',
                                    'transferNotification' => 'Property Transfer Update',
                                    default => 'Notification',
                                };
                            @endphp

                            <span class="sales__report--status pending2">{{ $notificationTitle }}</span>

                                
                                <div class="media">
                                    <div class="avatar-md bg-soft-primary">
                                        <i class="ti ti-mail"></i>
                                    </div>
                                    <div class="media-body align-self-center ms-2 text-truncate">
                                        <h6 class="my-0 fw-normal text-dark">{{-- $notification->data['notification_status'] --}}</h6>
                                        <small class="text-muted mb-0">{{ $notification->data['message'] ?? 'No message content available.' }}</small>
                                        <br>
                                        <small>{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small>
                                    </div><!--end media-body-->
                                </div><!--end media-->
                            </a>
                            <!--end-item-->
                            <script>
                                $(document).on('click', '.mark-as-read', function(e) {
                                
                                    e.preventDefault();
                        
                                    var notificationId = $(this).data('notification-id');
                                    var propertyMode = $(this).data('property-mode');

                                    var notificationElement = $(this); 
                                    $.ajax({
                                        url: 'notifications/' + notificationId + '/read',
                                        method: 'POST',
                                        data: {
                                            _token: '{{ csrf_token() }}',
                                            property_mode:propertyMode,
                                        }, 
                                        success: function(response) {
                                            if (response.success) {
                                                notificationElement.find('.sales__report--status').removeClass('pending2');
                                                // window.location.href = 'property/' + response.slug ; 
                                                // Redirect based on the property_mode or slug returned
                                                if (response.property_mode === 'transfer') {
                                                    window.location.href = response.property_mode + '/confirm/' + response.slug;
                                                } else if (response.property_mode === 'seller') {
                                                    window.location.href = 'user/seller/details/' + response.slug;  // Redirect to seller page
                                                } else if (response.property_mode === 'deposit') {
                                                    window.location.href = '/deposit/details/' + response.slug;  // Redirect to deposit page
                                                } else {
                                                    // Handle case if there is no matching property mode
                                                    window.location.href = '/property/' + response.slug;  // Default redirect to property page
                                                }
                                            } else {
                                                // alert('Failed to mark as read');
                                                console.error('Failed to mark as read');
                                            }
                                        },
                                        error: function() {
                                            // Handle errors if necessary
                                            // alert('There was an error with the request');
                                            console.error('There was an error with the request');
                                        }
                                    });
                                });
                            </script>
                        @endforeach
                        
                    </div>
                    <!-- All-->
                    <a href="javascript:void(0);" class="dropdown-item text-center text-primary">
                        View all <i class="fi-arrow-right"></i>
                    </a>
                </div>
            </li>

            <!-- User Profile -->
            <li class="dropdown">
                <a class="nav-link dropdown-toggle nav-user" data-bs-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset( $contactDetials->favicon )}}" alt="profile-user" class="rounded-circle me-2 thumb-sm" />
                        <div>
                            <small class="d-none d-md-block font-11">{{ Auth::guard('admin')->user()->name }}</small>
                            <span class="d-none d-md-block fw-semibold font-12">{{ Auth::guard('admin')->user()->email }}<i
                                    class="mdi mdi-chevron-down"></i></span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="pages-profile.html"><i class="ti ti-user font-16 me-1 align-text-bottom"></i> Profile</a>
                    <a class="dropdown-item" href="crypto-settings.html"><i class="ti ti-settings font-16 me-1 align-text-bottom"></i> Settings</a>
                    <div class="dropdown-divider mb-0"></div>
                    <a class="dropdown-item" href="auth-login.html"><i class="ti ti-power font-16 me-1 align-text-bottom"></i> Logout</a>
                </div>
            </li><!--end topbar-profile-->
            
            <!-- Settings -->
            <li class="notification-list">
                <a class="nav-link arrow-none nav-icon offcanvas-btn" href="#" data-bs-toggle="offcanvas" data-bs-target="#Appearance" role="button" aria-controls="Rightbar">
                    <i class="ti ti-settings ti-spin"></i>
                </a>
            </li>   
        </ul><!--end topbar-nav-->

        <ul class="list-unstyled topbar-nav mb-0">                        
            <li>
                <button class="nav-link button-menu-mobile nav-icon" id="togglemenu">
                    <i class="ti ti-menu-2"></i>
                </button>
            </li> 
            <li class="hide-phone app-search">
                <form role="search" action="#" method="get">
                    <input type="search" name="search" class="form-control top-search mb-0" placeholder="Type text...">
                    <button type="submit"><i class="ti ti-search"></i></button>
                </form>
            </li>                       
        </ul>
    </nav>
    <!-- end navbar-->
</div>
<!-- Top Bar End -->