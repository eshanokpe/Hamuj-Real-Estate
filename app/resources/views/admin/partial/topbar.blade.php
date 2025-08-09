
 <!-- Top Bar Start -->
        <!-- Top Bar Start -->
        <div class="topbar">            
            <!-- Navbar -->
            <nav class="navbar-custom" id="navbar-custom">    
                <ul class="list-unstyled topbar-nav float-end mb-0">
                   
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
        <!-- Top Bar End -->
