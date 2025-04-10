 <!-- Start header area -->
 <header class="header__section">
    <div class="main__header d-flex justify-content-between align-items-center">
        <div class="header__left d-flex align-items-center">
           
            <div class="offcanvas__header--menu__open ">
                <a class="offcanvas__header--menu__open--btn" href="javascript:void(0)" data-offcanvas>
                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon offcanvas__header--menu__open--svg" viewBox="0 0 512 512"><path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 160h352M80 256h352M80 352h352"/></svg>
                    <span class="visually-hidden">Offcanvas Menu Open</span>
                </a>
            </div> 
            <div class="search__box">
                <form class="search__box--form laptop__hidden" action="#">
                    <input class="search__box--input__field" placeholder="Search for ...." type="text">
                    <span class="search__box--icon"><svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.79171 8.74992C6.97783 8.74992 8.75004 6.97771 8.75004 4.79159C8.75004 2.60546 6.97783 0.833252 4.79171 0.833252C2.60558 0.833252 0.833374 2.60546 0.833374 4.79159C0.833374 6.97771 2.60558 8.74992 4.79171 8.74992Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9.16671 9.16659L8.33337 8.33325" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </form>
                <button class="search__btn--field hidden__btn" type="submit"><svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_46_1375)">
                    <path d="M8.80758 0C3.95121 0 0 3.95121 0 8.80758C0 13.6642 3.95121 17.6152 8.80758 17.6152C13.6642 17.6152 17.6152 13.6642 17.6152 8.80758C17.6152 3.95121 13.6642 0 8.80758 0ZM8.80758 15.9892C4.84769 15.9892 1.62602 12.7675 1.62602 8.80762C1.62602 4.84773 4.84769 1.62602 8.80758 1.62602C12.7675 1.62602 15.9891 4.84769 15.9891 8.80758C15.9891 12.7675 12.7675 15.9892 8.80758 15.9892Z" fill="currentColor"></path>
                    <path d="M19.762 18.6124L15.1007 13.9511C14.7831 13.6335 14.2687 13.6335 13.9511 13.9511C13.6335 14.2684 13.6335 14.7834 13.9511 15.1007L18.6124 19.762C18.7711 19.9208 18.979 20.0002 19.1872 20.0002C19.395 20.0002 19.6031 19.9208 19.762 19.762C20.0796 19.4446 20.0796 18.9297 19.762 18.6124Z" fill="currentColor"></path>
                    </g>
                    <defs>
                    <clipPath id="clip0_46_1375">
                    <rect width="20" height="20" fill="currentColor"></rect>
                    </clipPath>
                    </defs>
                    </svg>
                </button>
            </div>
            <div class="main__logo logo-desktop-block">
                <a class="main__logo--link" href="./dashboard.html">
                    <img class="main__logo--img desktop light__logo" src="{{ asset( $contactDetials->site_logo )}}" alt="logo-img">
                    <img class="main__logo--img desktop dark__logo" src="{{ asset('assets/admin/img/logo/nav-log-white.jpg')}}" alt="logo-img">
                    <img class="main__logo--img mobile" src="{{ asset('assets/admin/img/logo/logo-mobilee.jpg')}}" alt="logo-img">
                </a>
            </div>
        </div>
        <div class="header__right d-flex align-items-center">
            <div class="main__menu d-none d-xl-block">
                <nav class="main__menu--navigation">
                    <ul class="main__menu--wrapper d-flex align-items-center">
                        <li class="main__menu--items">
                            <a href="{{ route('user.wallet.index') }}" class="main__menu--link d-flex align-items-center justify-content-between" style="gap: 10px;">
                                
                                <div class="form-check form-switch">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        role="switch" 
                                        id="flexSwitchCheckDefault" 
                                        {{ Auth::user()->hide_balance ? 'checked' : '' }}
                                        onchange="toggleHideBalance(this)">
                                </div>
                                
                                {{-- <span>
                                    @if(Auth::user()->hide_balance)
                                        Wallet Balance: ****
                                    @else
                                        Wallet Balance: <span class="wallet-balance">{{ $wallet->currency}}{{ number_format($wallet->balance,  2) }}</span>
                                    @endif
                                </span> --}}
                            </a>
                            
                        </li>
                        
                        {{-- <li class="main__menu--items">
                            <a class="main__menu--link" href="{{ route('user.properties')}}">
                                <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.5 0L0 4.125V11H3.72581V8.59381C3.72581 7.64165 4.51713 6.87506 5.5 6.87506C6.48287 6.87506 7.27419 7.64165 7.27419 8.59381V11H11V4.125L5.5 0Z" fill="#16A34A"/>
                                </svg>
                               Buy Properties
                            </a>
                        </li> --}}
                       
                    </ul>
                </nav>
            </div>
            <div class="header__nav-bar__wrapper d-flex align-items-center">
                <div class="header__user--profile">
                    <a class="header__user--profile__link d-flex align-items-center" href="#">
                       
                        <svg style="margin-right: 5px" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.8333 4.66667H11.6667V3.5C11.6667 2.5335 10.8662 1.75 9.91667 1.75H2.33333C1.38383 1.75 0.583333 2.5335 0.583333 3.5V10.5C0.583333 11.4665 1.38383 12.25 2.33333 12.25H12.8333C13.7828 12.25 14.5833 11.4665 14.5833 10.5V6.41667C14.5833 5.45 13.7828 4.66667 12.8333 4.66667ZM2.33333 2.91667H9.91667C10.3993 2.91667 10.8333 3.35067 10.8333 3.83333V4.66667H2.33333C1.85067 4.66667 1.41667 4.23267 1.41667 3.75C1.41667 3.26733 1.85067 2.91667 2.33333 2.91667ZM12.8333 10.5C12.8333 10.983 12.3993 11.4167 11.9167 11.4167H2.33333C1.85067 11.4167 1.41667 10.983 1.41667 10.5V6.41667H12.8333C13.316 6.41667 13.75 6.85067 13.75 7.33333V10.5ZM10.0833 8.16667C9.60067 8.16667 9.16667 8.60067 9.16667 9.08333C9.16667 9.566 9.60067 10 10.0833 10C10.566 10 11 9.566 11 9.08333C11 8.60067 10.566 8.16667 10.0833 8.16667Z" fill="#16A34A"/>
                        </svg> 
                        <span>
                            @if(Auth::user()->hide_balance)
                                ****
                            @else
                                <span class="wallet-balance">{{ $wallet->currency}}{{ number_format($wallet->balance,  2) }}</span>
                            @endif
                        </span>
                    </a>
                </div>
                <ul class="nav-bar__menu d-flex">
                   
                    <li class="nav-bar__menu--items header__apps--menu position-relative">
                        <a class="nav-bar__menu--icon apps__menu--icon active" href="#">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.0167 2.42505C7.25841 2.42505 5.01674 4.66672 5.01674 7.42505V9.83338C5.01674 10.3417 4.80007 11.1167 4.54174 11.55L3.58341 13.1417C2.99174 14.125 3.40007 15.2167 4.48341 15.5834C8.07507 16.7834 11.9501 16.7834 15.5417 15.5834C16.5501 15.2501 16.9917 14.0584 16.4417 13.1417L15.4834 11.55C15.2334 11.1167 15.0167 10.3417 15.0167 9.83338V7.42505C15.0167 4.67505 12.7667 2.42505 10.0167 2.42505Z" stroke="currentColor" stroke-miterlimit="10" stroke-linecap="round"/>
                                <path d="M11.5584 2.6667C11.3001 2.5917 11.0334 2.53337 10.7584 2.50003C9.95843 2.40003 9.19176 2.45837 8.4751 2.6667C8.71676 2.05003 9.31676 1.6167 10.0168 1.6167C10.7168 1.6167 11.3168 2.05003 11.5584 2.6667Z" stroke="currentColor" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12.5166 15.8833C12.5166 17.2583 11.3916 18.3833 10.0166 18.3833C9.33327 18.3833 8.69993 18.1 8.24993 17.65C7.79993 17.2 7.5166 16.5666 7.5166 15.8833" stroke="currentColor" stroke-miterlimit="10"/>
                            </svg> 
                            <span class="nav-bar__notification--badge" id="notificationCount">{{ $notificationCount }}</span>
                            <span class="visually-hidden">Notification</span>                                         
                        </a>
                        <script>
                            // Example JavaScript to update the counter dynamically
                            document.addEventListener('DOMContentLoaded', function() {
                                setInterval(function() {
                                    fetch('/api/notifications/count') // An API route to fetch unread notification count
                                        .then(response => response.json())
                                        .then(data => {
                                            document.getElementById('notificationCount').textContent = data.count; // Update counter
                                        });
                                }, 60000); // Update every 60 seconds
                            });

                        </script>
                       <div class="dropdown__related--apps">
                        <h3 class="dropdown__apps--title">Notification</h3>
                        <ul class="dropdown__apps--menu">
                            <div class="chat__inbox">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="chat">
                                        <div class="chat__inbox--content">
                                            <div class="chat__inbox--wrapper">
                                                <ul class="chat__inbox--menu">
                                                   
                                                    @foreach (auth()->user()->unreadNotifications as $notification)
                                                        <li class="chat__inbox--menu__list mb-2" >
                                                            <a class="mb-10 chat__inbox--menu__link active mark-as-read" href="{{ route('user.notifications.show', $notification->id) }}">
                                                                @if( $notification->data['notification_status'] == 'PropertyValuationNotification' || $notification->data['notification_status'] == 'PropertyValuationPredictionNotification') 
                                                                    {{ $notification->data['property_name'] }}: 
                                                                    Market Value ₦{{ number_format($notification->data['market_value'] ?? 0.0, 2) }}, 
                                                                    Increase {{ $notification->data['percentage_increase'] ?? 'N/A' }}%
                                                                @endif
                                                                @if( $notification->data['notification_status'] == 'WalletFundedNotification') 
                                                                    {{-- Display the wallet funded notification message --}}
                                                                    You have received ₦{{ number_format($notification->data['amount'], 2) }} in your wallet. 
                                                                    Your new balance is ₦{{ number_format($notification->data['balance'], 2) }}.
                                                                @endif
                                                                @if( $notification->data['notification_status'] == 'WalletTransferNotification') 
                                                                    <div class="list-group-item {{ $notification->read_at ? '' : 'list-group-item-warning' }}">
                                                                        <h5 class="mb-1">{{ $notification->data['message'] ?? 'Notification' }}</h5>
                                                                        <p class="mb-1">Amount: NGN {{ number_format($notification->data['amount'], 2) }}</p>
                                                                        <p class="mb-1">New Balance: NGN {{ number_format($notification->data['new_balance'], 2) }}</p>
                                                                        <small>Sent at: {{ $notification->created_at->format('M d, Y h:i A') }}</small>
                                                        
                                                                        @if (is_null($notification->read_at))
                                                                            <form action="{{ route('user.notifications.read', $notification->id) }}" method="POST" style="display: inline;">
                                                                                @csrf
                                                                                <button class="btn btn-sm btn-success mt-2">Mark as Read</button>
                                                                            </form>
                                                                        @else
                                                                            <span class="badge bg-secondary mt-2">Read</span>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                                {{$notification->data['notification_status']}}
                                                            </a>
                                                        </li>
                                                    @endforeach

                                                    @foreach ($notificationsBar as $notification)
                                                        <li class="chat__inbox--menu__list mb-2">
                                                            <snap class="sales__report--status pending2"> {{ $notification->data['message'] }}</snap>
                                                            <a class="chat__inbox--menu__link active mark-as-read" href="#" 
                                                               data-notification-id="{{ $notification->id }}" 
                                                               data-property-mode="{{ $notification->data['property_mode'] }}" 
                                                               >
                                                                <div class="chat__inbox--menu__wrapper d-flex justify-content-between">
                                                                    <div class="chat__inbox--author d-flex align-items-center">
                                                                        <div class="chat__inbox--author__content">
                                                                            <h3 class="chat__inbox--author--name">{{ $notification->data['property_name'] }}</h3>
                                                                            <p class="chat__inbox--author__desc">Land Size: {{ $notification->data['land_size'] }}</p>

                                                                        </div>
                                                                    </div>
                                                                    <span class="chat__inbox--date-time">{{ $notification->created_at->diffForHumans() }}</span>
                                                                </div>
                                                            </a>
                                                        </li>
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
                                                </ul> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </ul>
                        <div class="dropdown__apps__footer">
                            <a class="solid__btn dropdown__apps--view__all" href="{{ route('user.notifications.index') }}">View All Notifications</a>
                        </div>
                    
                        </div>
                    
                    </li>
                    
                    
                    <li class="nav-bar__menu--items">
                        <a class="nav-bar__menu--icon" href="#" id="light__to--dark">
                            <svg class="light--mode__icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.99992 15.4166C12.9915 15.4166 15.4166 12.9915 15.4166 9.99992C15.4166 7.00838 12.9915 4.58325 9.99992 4.58325C7.00838 4.58325 4.58325 7.00838 4.58325 9.99992C4.58325 12.9915 7.00838 15.4166 9.99992 15.4166Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M15.9501 15.9501L15.8417 15.8417M15.8417 4.15841L15.9501 4.05008L15.8417 4.15841ZM4.05008 15.9501L4.15841 15.8417L4.05008 15.9501ZM10.0001 1.73341V1.66675V1.73341ZM10.0001 18.3334V18.2667V18.3334ZM1.73341 10.0001H1.66675H1.73341ZM18.3334 10.0001H18.2667H18.3334ZM4.15841 4.15841L4.05008 4.05008L4.15841 4.15841Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <svg  class="dark--mode__icon"  xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="20" height="20" viewBox="0 0 512 512"><title>Moon</title><path d="M264 480A232 232 0 0132 248c0-94 54-178.28 137.61-214.67a16 16 0 0121.06 21.06C181.07 76.43 176 104.66 176 136c0 110.28 89.72 200 200 200 31.34 0 59.57-5.07 81.61-14.67a16 16 0 0121.06 21.06C442.28 426 358 480 264 480z"></path></svg>
                            <span class="visually-hidden">Dark Light</span> 
                        </a>
                    </li>
                </ul> 
                <div class="header__user--profile">
                    <a class="header__user--profile__link d-flex align-items-center" href="#">
                        <img class="header__user--profile__thumbnail" 
                        style="border-radius:50px; max-height: 100%; max-width:100%; width:30px; height:30px;  object-fit: cover;"
                        src="{{ Auth::user()->profile_image ? asset(Auth::user()->profile_image) : asset('assets/admin/img/dashboard/avater.jpg') }}" 
                        alt="img">

                        <span class="header__user--profile__name">{{ Auth::user()->name}}</span>
                        <span class="header__user--profile__arrow"><svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.9994 4.97656L10.1244 0.851563L11.3027 2.0299L5.9994 7.33323L0.696067 2.0299L1.8744 0.851563L5.9994 4.97656Z" fill="currentColor" fill-opacity="0.5"/>
                            </svg>
                        </span>
                    </a>
                    <div class="dropdown__user--profile">
                        <ul class="user__profile--menu">
                            <li class="user__profile--menu__items">
                                <a class="user__profile--menu__link" href="{{ route('user.sell.history') }}">
                                    <svg class="sidebar__menu--icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3 12L9 18L15 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M3 6L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M19 4H5C3.89543 4 3 4.89543 3 6V18C3 19.1046 3.89543 20 5 20H19C20.1046 20 21 19.1046 21 18V6C21 4.89543 20.1046 4 19 4Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg> 
                                    Sell History
                                </a>
                            </li>
                            <li class="user__profile--menu__items">
                                <a class="user__profile--menu__link" href="{{ route('user.transfer.history') }}">
                                    <svg class="sidebar__menu--icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3 12L9 18L15 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M3 6L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M19 4H5C3.89543 4 3 4.89543 3 6V18C3 19.1046 3.89543 20 5 20H19C20.1046 20 21 19.1046 21 18V6C21 4.89543 20.1046 4 19 4Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg> 
                                    Transfer History
                                </a>
                            </li>
                            <li class="user__profile--menu__items"><a class="user__profile--menu__link" href="{{ route('user.profile.index')}}"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="user-2" class="lucide lucide-user-2 inline-block size-4 ltr:mr-2 rtl:ml-2"><circle cx="12" cy="8" r="5"></circle><path d="M20 21a8 8 0 0 0-16 0"></path></svg> My Profile</a></li>

                            {{-- <li class="user__profile--menu__items"><a class="user__profile--menu__link position-relative" href="./chat.html"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="mail" class="lucide lucide-mail inline-block size-4 ltr:mr-2 rtl:ml-2"><rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path></svg> Inbox <span class="profile__messages--count">12</span> </a></li> --}}

                        </ul>
                        <div class="dropdown__user--profile__footer">
                            <a class="user__profile--log-out__btn" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="log-out" class="lucide lucide-log-out inline-block size-4 ltr:mr-2 rtl:ml-2">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" x2="9" y1="12" y2="12"></line>
                                </svg>
                                Log Out
                            </a>
                        </div>
                        
                        <!-- Hidden Logout Form -->
                        <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>



<div class="offcanvas__header">
    <div class="offcanvas__inner">
        <div class="offcanvas__logo">
            <a class="offcanvas__logo_link" href="{{ route('user.dashboard')}}">
                <img class="light__logo" src="{{ asset( $contactDetials->site_logo )}}" alt="Logo-img" width="158" height="36">
                <img class="dark__logo" src="{{ asset('assets/admin/img/logo/nav-log-white.jpg')}}" alt="Logo-img" width="158" height="36">
            </a>
            <button class="offcanvas__close--btn" data-offcanvas>close</button>
        </div>
        
        <nav class="offcanvas__menu">
            <ul class="offcanvas__menu_ul">
                <li class="offcanvas__menu_li">
                    <a class="offcanvas__menu_item" href="{{ route('user.dashboard')}}">Dashboard</a>
                </li>
                <li class="sidebar__menu--items">
                    <label class="sidebar__menu--title">Manage Asset</label>
                </li>
                <li class="offcanvas__menu_li">
                    <a class="offcanvas__menu_item" href="{{ route('user.buy')}}">My Assets</a>
                </li>

                <li class="offcanvas__menu_li">
                    <a class="offcanvas__menu_item" href="{{ route('user.properties') }}">Properties</a>
                    <ul class="offcanvas__sub_menu">
                        <li class="offcanvas__sub_menu_li"><a href="{{ route('user.properties') }}" class="offcanvas__sub_menu_item">Buy Properties</a></li>
                        <li class="offcanvas__sub_menu_li"><a href="{{ route('user.sell') }}" class="offcanvas__sub_menu_item">Sell Property</a></li>
                        <li class="offcanvas__sub_menu_li"><a href="{{ route('user.transfer') }}" class="offcanvas__sub_menu_item">Transfer Properties</a></li>
                    </ul>
                </li>
                
             
                <li class="offcanvas__menu_li"><a class="offcanvas__menu_item" href="{{ route('user.wallet.index') }}">Wallet</a></li>
                <li class="offcanvas__menu_li"><a class="offcanvas__menu_item" href="{{ route('user.transactions.index') }}">Transaction</a></li>
               
               
                <li class="offcanvas__menu_li"><a class="offcanvas__menu_item" href="{{ route('user.notifications.index') }}">Notification</a></li>
               
                <li class="offcanvas__menu_li"><a class="offcanvas__menu_item" href="{{ route('user.referral.index') }}">Referral</a></li>
                <li class="sidebar__menu--items">
                    <label class="sidebar__menu--title">Manage Account</label>
                </li>

                <li class="offcanvas__menu_li"><a class="offcanvas__menu_item" href="{{ route('user.profile.index') }}"> My Profile</a></li>
                <li class="offcanvas__menu_li"><a class="offcanvas__menu_item" href="{{ route('user.support') }}">  Help and Support</a></li>
                <li class="offcanvas__menu_li"><a class="offcanvas__menu_item " href="{{ route('user.login.security') }}"> Login and security </a></li>
                <li class="offcanvas__menu_li">
                    <a class="offcanvas__menu_item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> 
                        <snap class="text-danger">   
                            <svg class="sidebar__menu--icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.41663 6.29995C7.67496 3.29995 9.21663 2.07495 12.5916 2.07495H12.7C16.425 2.07495 17.9166 3.56662 17.9166 7.29162V12.725C17.9166 16.45 16.425 17.9416 12.7 17.9416H12.5916C9.24163 17.9416 7.69996 16.7333 7.42496 13.7833" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12.5001 10H3.01672" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M4.87504 7.20825L2.08337 9.99992L4.87504 12.7916" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>  
                             Logout  
                            </snap>
                    </a>
                    <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

               
               
            </ul>
        </nav>
        <div class="side__menu--footer mobile__menu--footer">
            <div class="side__menu--info">
                <div class="side__menu--info__list">
                    <h3 class="side__menu--info__title">Customer Care Phone</h3>
                    <p><a class="side__menu--info__text" href="tel:{{$contactDetials->first_phone}}">: {{$contactDetials->first_phone}}  
                        @if( $contactDetials->second_phone == null)
                        , {{$contactDetials->second_phone}}
                        @endif
                    </a></p>
                </div>
                <div class="side__menu--info__list">
                    <h3 class="side__menu--info__title">Need Live Support?</h3>
                    <p><a class="side__menu--info__text" href="mailto:{{$contactDetials->first_email}}">
                        {{$contactDetials->first_email}} 
                        @if( $contactDetials->second_email == null)
                        , {{$contactDetials->second_email}}
                        @endif    
                        </a>
                    </p>
                </div>
            </div>
            <div class="side__menu--share d-flex align-items-center">
                <h3 class="side__menu--share__title">Follow us :</h3>
                <ul class=" side__menu--share__wrapper d-flex align-items-center">
                    <li class="side__menu--share__list">
                        <a class="side__menu--share__icon" target="_blank" href="{{$sociallink->facebook}}">
                            <svg width="10" height="17" viewBox="0 0 9 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.62891 8.625L8.01172 6.10938H5.57812V4.46875C5.57812 3.75781 5.90625 3.10156 7 3.10156H8.12109V0.941406C8.12109 0.941406 7.10938 0.75 6.15234 0.75C4.15625 0.75 2.84375 1.98047 2.84375 4.16797V6.10938H0.601562V8.625H2.84375V14.75H5.57812V8.625H7.62891Z" fill="currentColor"></path>
                            </svg>
                            <span class="visually-hidden">Facebook</span>
                        </a>
                    </li>
                    <li class="side__menu--share__list">
                        <a class="side__menu--share__icon" target="_blank" href="{{$sociallink->twitter}}">
                            <svg width="16" height="14" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.5508 2.90625C13.0977 2.49609 13.5898 2.00391 13.9727 1.42969C13.4805 1.64844 12.9062 1.8125 12.332 1.86719C12.9336 1.51172 13.3711 0.964844 13.5898 0.28125C13.043 0.609375 12.4141 0.855469 11.7852 0.992188C11.2383 0.417969 10.5 0.0898438 9.67969 0.0898438C8.09375 0.0898438 6.80859 1.375 6.80859 2.96094C6.80859 3.17969 6.83594 3.39844 6.89062 3.61719C4.51172 3.48047 2.37891 2.33203 0.957031 0.609375C0.710938 1.01953 0.574219 1.51172 0.574219 2.05859C0.574219 3.04297 1.06641 3.91797 1.85938 4.4375C1.39453 4.41016 0.929688 4.30078 0.546875 4.08203V4.10938C0.546875 5.50391 1.53125 6.65234 2.84375 6.92578C2.625 6.98047 2.35156 7.03516 2.10547 7.03516C1.91406 7.03516 1.75 7.00781 1.55859 6.98047C1.91406 8.12891 2.98047 8.94922 4.23828 8.97656C3.25391 9.74219 2.02344 10.207 0.683594 10.207C0.4375 10.207 0.21875 10.1797 0 10.1523C1.25781 10.9727 2.76172 11.4375 4.40234 11.4375C9.67969 11.4375 12.5508 7.08984 12.5508 3.28906C12.5508 3.15234 12.5508 3.04297 12.5508 2.90625Z" fill="currentColor"></path>
                            </svg>
                            <span class="visually-hidden">Twitter</span>
                        </a>
                    </li>
                    <li class="side__menu--share__list">
                        <a class="side__menu--share__icon" target="_blank" href="{{$sociallink->instagram}}">
                            <svg width="16" height="16" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.125 3.60547C5.375 3.60547 3.98047 5.02734 3.98047 6.75C3.98047 8.5 5.375 9.89453 7.125 9.89453C8.84766 9.89453 10.2695 8.5 10.2695 6.75C10.2695 5.02734 8.84766 3.60547 7.125 3.60547ZM7.125 8.80078C6.00391 8.80078 5.07422 7.89844 5.07422 6.75C5.07422 5.62891 5.97656 4.72656 7.125 4.72656C8.24609 4.72656 9.14844 5.62891 9.14844 6.75C9.14844 7.89844 8.24609 8.80078 7.125 8.80078ZM11.1172 3.49609C11.1172 3.08594 10.7891 2.75781 10.3789 2.75781C9.96875 2.75781 9.64062 3.08594 9.64062 3.49609C9.64062 3.90625 9.96875 4.23438 10.3789 4.23438C10.7891 4.23438 11.1172 3.90625 11.1172 3.49609ZM13.1953 4.23438C13.1406 3.25 12.9219 2.375 12.2109 1.66406C11.5 0.953125 10.625 0.734375 9.64062 0.679688C8.62891 0.625 5.59375 0.625 4.58203 0.679688C3.59766 0.734375 2.75 0.953125 2.01172 1.66406C1.30078 2.375 1.08203 3.25 1.02734 4.23438C0.972656 5.24609 0.972656 8.28125 1.02734 9.29297C1.08203 10.2773 1.30078 11.125 2.01172 11.8633C2.75 12.5742 3.59766 12.793 4.58203 12.8477C5.59375 12.9023 8.62891 12.9023 9.64062 12.8477C10.625 12.793 11.5 12.5742 12.2109 11.8633C12.9219 11.125 13.1406 10.2773 13.1953 9.29297C13.25 8.28125 13.25 5.24609 13.1953 4.23438ZM11.8828 10.3594C11.6914 10.9062 11.2539 11.3164 10.7344 11.5352C9.91406 11.8633 8 11.7812 7.125 11.7812C6.22266 11.7812 4.30859 11.8633 3.51562 11.5352C2.96875 11.3164 2.55859 10.9062 2.33984 10.3594C2.01172 9.56641 2.09375 7.65234 2.09375 6.75C2.09375 5.875 2.01172 3.96094 2.33984 3.14062C2.55859 2.62109 2.96875 2.21094 3.51562 1.99219C4.30859 1.66406 6.22266 1.74609 7.125 1.74609C8 1.74609 9.91406 1.66406 10.7344 1.99219C11.2539 2.18359 11.6641 2.62109 11.8828 3.14062C12.2109 3.96094 12.1289 5.875 12.1289 6.75C12.1289 7.65234 12.2109 9.56641 11.8828 10.3594Z" fill="currentColor"></path>
                            </svg>  
                            <span class="visually-hidden">Instagram</span>
                        </a>
                    </li>
                    <li class="side__menu--share__list">
                        <a class="side__menu--share__icon" target="_blank" href="{{$sociallink->whatsapp}}">
                            {{-- <svg width="14" height="16" viewBox="0 0 15 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.6713 6.71093C14.6764 7.71873 14.5406 8.65694 14.2638 9.52555C14.0104 10.394 13.6393 11.146 13.1503 11.7813C12.6612 12.3932 12.0778 12.8883 11.4001 13.2668C10.7222 13.6218 9.97304 13.7897 9.15262 13.7705C8.87149 13.7954 8.59012 13.7734 8.30852 13.7045C8.05023 13.6121 7.80366 13.5196 7.56881 13.427C7.35727 13.3109 7.16906 13.1713 7.00416 13.008C6.83926 12.8448 6.70957 12.6931 6.61511 12.553C6.47736 13.1162 6.36257 13.5856 6.27074 13.961C6.17891 14.3365 6.09838 14.6299 6.02915 14.8412C5.98323 15.0289 5.94879 15.1697 5.92584 15.2636C5.9262 15.3339 5.92632 15.3573 5.9262 15.3339C5.85696 15.5452 5.78767 15.7448 5.71832 15.9326C5.64897 16.1205 5.56796 16.3201 5.47529 16.5315C5.3825 16.7195 5.27793 16.8958 5.16158 17.0605C5.06867 17.225 4.97576 17.3896 4.88285 17.5541C4.60256 17.743 4.38033 17.8262 4.21615 17.8036C4.07553 17.8043 3.95804 17.7463 3.86369 17.6296C3.79278 17.5128 3.74531 17.3959 3.72127 17.2788C3.69736 17.1852 3.68534 17.1266 3.68522 17.1032C3.66094 16.9393 3.64832 16.7635 3.64736 16.576C3.64629 16.3651 3.64527 16.1659 3.64431 15.9784C3.66667 15.7673 3.68902 15.5563 3.71138 15.3452C3.75718 15.1341 3.80309 14.9463 3.84913 14.782C3.84901 14.7586 3.86037 14.6882 3.8832 14.5709C3.92936 14.43 3.99829 14.1602 4.09 13.7612C4.18159 13.3389 4.30756 12.764 4.46791 12.0366C4.62825 11.3092 4.84599 10.3472 5.12112 9.15044C5.05009 9.01017 4.9906 8.8347 4.94264 8.624C4.89469 8.41331 4.85863 8.23771 4.83448 8.0972C4.8102 7.93326 4.79776 7.7927 4.79716 7.67551C4.79657 7.55833 4.79633 7.51145 4.79645 7.53489C4.79441 7.13646 4.83948 6.78466 4.93167 6.4795C5.04718 6.15078 5.18637 5.86881 5.34923 5.6336C5.53541 5.37483 5.74538 5.18626 5.97915 5.06787C6.23624 4.92593 6.49363 4.84258 6.75132 4.81782C6.98581 4.84006 7.18527 4.88592 7.34969 4.95539C7.53755 5.02474 7.69049 5.14115 7.80851 5.30461C7.92654 5.46807 8.00947 5.64343 8.0573 5.83069C8.12845 5.99439 8.16463 6.19342 8.16583 6.4278C8.16691 6.63873 8.13307 6.89672 8.06432 7.20176C7.99544 7.48337 7.91491 7.77675 7.82272 8.08192C7.73053 8.38708 7.62674 8.71574 7.51135 9.0679C7.41928 9.3965 7.33887 9.71332 7.27012 10.0184C7.20137 10.3234 7.19103 10.593 7.2391 10.8271C7.31049 11.0377 7.41704 11.2481 7.55874 11.4583C7.72376 11.645 7.92369 11.7846 8.15854 11.8771C8.3934 11.9697 8.63979 12.027 8.89771 12.0491C9.38978 12.0232 9.8343 11.8686 10.2313 11.5853C10.6283 11.302 10.9661 10.9018 11.2447 10.3848C11.5467 9.86758 11.7665 9.29223 11.9038 8.65871C12.0646 8.00163 12.1429 7.28637 12.139 6.51294C12.1362 5.97389 12.0398 5.45875 11.8498 4.96753C11.6598 4.47631 11.3765 4.06759 10.9998 3.74139C10.6464 3.39163 10.1997 3.11266 9.65954 2.90449C9.14285 2.69619 8.533 2.60556 7.83 2.63259C7.05646 2.61311 6.354 2.74561 5.72263 3.03009C5.11471 3.31446 4.58923 3.68043 4.1462 4.12802C3.70317 4.5756 3.36603 5.10467 3.13477 5.71524C2.9034 6.30237 2.78933 6.91234 2.79257 7.54514C2.79388 7.80295 2.80674 8.02554 2.83114 8.21292C2.87885 8.37674 2.92662 8.55228 2.97446 8.73954C3.04561 8.90324 3.1167 9.05522 3.18773 9.19548C3.28208 9.31219 3.38827 9.45227 3.50629 9.61574C3.55329 9.63893 3.58868 9.68563 3.61248 9.75582C3.63615 9.80257 3.64805 9.83767 3.64817 9.86111C3.67173 9.88442 3.68369 9.93124 3.68405 10.0015C3.68429 10.0484 3.67281 10.0954 3.64961 10.1424C3.62653 10.2128 3.60346 10.2832 3.58038 10.3536C3.58062 10.4005 3.56926 10.4709 3.5463 10.5648C3.52334 10.6586 3.50033 10.7408 3.47725 10.8112C3.45405 10.8582 3.44263 10.9169 3.44299 10.9872C3.4198 11.0342 3.38494 11.0929 3.33842 11.1635C3.31523 11.2105 3.28025 11.2458 3.2335 11.2695C3.18662 11.2697 3.13981 11.2817 3.09305 11.3054C3.04618 11.3056 2.98747 11.2825 2.91691 11.236C2.56464 11.0971 2.24722 10.8995 1.96465 10.6432C1.7054 10.3632 1.49291 10.0596 1.32717 9.73235C1.16143 9.40507 1.03061 9.03073 0.934703 8.60934C0.838796 8.18795 0.789764 7.76633 0.787606 7.34446C0.78377 6.59447 0.932275 5.8437 1.23312 5.09215C1.55741 4.34048 2.02261 3.64668 2.62874 3.01076C3.23487 2.37484 3.99401 1.86705 4.90614 1.48737C5.81815 1.08427 6.88346 0.867877 8.10208 0.838206C9.08656 0.856608 9.97807 1.02783 10.7766 1.35188C11.5985 1.65236 12.2921 2.08241 12.8575 2.64203C13.4228 3.20165 13.8597 3.83223 14.1679 4.53379C14.4995 5.21179 14.6673 5.9375 14.6713 6.71093Z" fill="currentColor"/>
                            </svg> --}}
                            <svg width="14" height="16"  viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.5 10C18.5 5.71875 15.0312 2.25 10.75 2.25C6.46875 2.25 3 5.71875 3 10C3 13.3125 5.03125 16.0938 7.90625 17.2188C7.84375 16.625 7.78125 15.6875 7.9375 15C8.09375 14.4062 8.84375 11.1562 8.84375 11.1562C8.84375 11.1562 8.625 10.6875 8.625 10C8.625 8.9375 9.25 8.125 10.0312 8.125C10.6875 8.125 11 8.625 11 9.21875C11 9.875 10.5625 10.875 10.3438 11.8125C10.1875 12.5625 10.75 13.1875 11.5 13.1875C12.875 13.1875 13.9375 11.75 13.9375 9.65625C13.9375 7.78125 12.5938 6.5 10.7188 6.5C8.5 6.5 7.21875 8.15625 7.21875 9.84375C7.21875 10.5312 7.46875 11.25 7.78125 11.625C7.84375 11.6875 7.84375 11.7812 7.84375 11.8438C7.78125 12.0938 7.625 12.625 7.625 12.7188C7.59375 12.875 7.5 12.9062 7.34375 12.8438C6.375 12.375 5.78125 10.9688 5.78125 9.8125C5.78125 7.375 7.5625 5.125 10.9062 5.125C13.5938 5.125 15.6875 7.0625 15.6875 9.625C15.6875 12.2812 14 14.4375 11.6562 14.4375C10.875 14.4375 10.125 14.0312 9.875 13.5312C9.875 13.5312 9.5 15.0312 9.40625 15.375C9.21875 16.0625 8.75 16.9062 8.4375 17.4062C9.15625 17.6562 9.9375 17.75 10.75 17.75C15.0312 17.75 18.5 14.2812 18.5 10Z" fill="currentColor"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.5 22H5.5C4.04133 21.9999 2.64242 21.4205 1.61098 20.389C0.579547 19.3576 6.38127e-05 17.9587 0 16.5L0 5.5C6.38127e-05 4.04133 0.579547 2.64242 1.61098 1.61098C2.64242 0.579547 4.04133 6.38127e-05 5.5 0L16.5 0C17.9587 0 19.3576 0.579463 20.3891 1.61091C21.4205 2.64236 22 4.04131 22 5.5V16.5C22 17.9587 21.4205 19.3576 20.3891 20.3891C19.3576 21.4205 17.9587 22 16.5 22Z" fill="currentColor"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.3125 6.1875H16.5C17.2931 6.18745 18.0559 5.88282 18.6309 5.33652C19.2059 4.79021 19.5491 4.04396 19.5897 3.25188C19.6303 2.45979 19.3652 1.68237 18.849 1.08015C18.3329 0.47794 17.6052 0.0969313 16.8163 0.0158125C16.7111 0.00996875 16.6069 0 16.5 0H5.5C4.04133 6.38127e-05 2.64242 0.579547 1.61098 1.61098C0.579547 2.64242 6.38127e-05 4.04133 0 5.5L0 16.5C6.3815e-05 13.765 1.08658 11.142 3.02053 9.20803C4.95449 7.27408 7.57748 6.18757 10.3125 6.1875Z" fill="currentColor"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.5 11C15.4122 11 14.3488 11.3226 13.4444 11.9269C12.5399 12.5313 11.8349 13.3902 11.4187 14.3952C11.0024 15.4002 10.8935 16.5061 11.1057 17.573C11.3179 18.6399 11.8417 19.6199 12.6109 20.3891C13.3801 21.1583 14.3601 21.6821 15.427 21.8943C16.4939 22.1065 17.5998 21.9976 18.6048 21.5813C19.6098 21.1651 20.4687 20.4601 21.0731 19.5556C21.6774 18.6512 22 17.5878 22 16.5V5.5C22 6.95869 21.4205 8.35764 20.3891 9.38909C19.3576 10.4205 17.9587 11 16.5 11Z" fill="currentColor"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.45011 16.1883C7.54161 16.1623 7.63751 16.1555 7.73176 16.1684C7.82601 16.1813 7.91656 16.2136 7.99771 16.2632C9.36447 17.0775 10.9817 17.3644 12.5451 17.0698C14.1086 16.7753 15.5105 15.9197 16.4874 14.6639C17.4642 13.4082 17.9485 11.8387 17.8492 10.2509C17.75 8.66304 17.074 7.16616 15.9485 6.04178C14.8229 4.91741 13.3253 4.24302 11.7373 4.14547C10.1494 4.04791 8.58047 4.53391 7.32574 5.51206C6.071 6.4902 5.21688 7.89308 4.92402 9.45685C4.63116 11.0206 4.91974 12.6375 5.73549 14.0034C5.78495 14.0843 5.81709 14.1746 5.82987 14.2686C5.84265 14.3625 5.8358 14.4581 5.80974 14.5493C5.61827 15.2268 5.15627 16.8438 5.15627 16.8438C5.15627 16.8438 6.77327 16.3818 7.45011 16.1883ZM4.54405 14.6899C3.56124 13.0332 3.21704 11.0746 3.57607 9.1821C3.9351 7.28956 4.97267 5.59318 6.49394 4.41151C8.01522 3.22984 9.91554 2.64416 11.8381 2.76447C13.7606 2.88477 15.5731 3.70277 16.9352 5.06487C18.2973 6.42697 19.1153 8.23946 19.2356 10.162C19.3559 12.0845 18.7702 13.9849 17.5886 15.5061C16.4069 17.0274 14.7105 18.065 12.818 18.424C10.9254 18.783 8.96692 18.4388 7.31021 17.456C7.31021 17.456 5.11811 18.0823 4.03255 18.3927C3.97358 18.4095 3.91119 18.4102 3.85185 18.3948C3.7925 18.3794 3.73835 18.3484 3.69499 18.3051C3.65164 18.2617 3.62065 18.2076 3.60524 18.1482C3.58983 18.0889 3.59055 18.0265 3.60733 17.9675C3.91774 16.882 4.54405 14.6899 4.54405 14.6899Z" fill="white"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.55649 8.5207C7.66343 10.0599 8.32036 11.5094 9.40733 12.6044C10.4943 13.6995 11.9388 14.3671 13.4772 14.4855H13.4779C13.7235 14.5045 13.9704 14.4701 14.2014 14.3846C14.4325 14.2992 14.6423 14.1647 14.8165 13.9905L15.0564 13.7505C15.1697 13.6372 15.2334 13.4835 15.2335 13.3232V12.8138C15.2334 12.7499 15.2157 12.6873 15.1821 12.633C15.1485 12.5787 15.1005 12.5347 15.0434 12.5061C14.6814 12.3253 13.8956 11.9324 13.5106 11.7399C13.446 11.7076 13.3729 11.6965 13.3017 11.708C13.2304 11.7195 13.1646 11.7532 13.1135 11.8042C12.9217 11.996 12.6185 12.2995 12.4467 12.4711C12.4067 12.5111 12.3574 12.5406 12.3033 12.557C12.2491 12.5735 12.1918 12.5763 12.1363 12.5653L12.1332 12.5646C11.4677 12.4315 10.8565 12.1044 10.3766 11.6245C9.89667 11.1446 9.56956 10.5334 9.43646 9.86786L9.43577 9.86477C9.42474 9.80927 9.42756 9.75191 9.44399 9.69777C9.46042 9.64362 9.48995 9.59437 9.52996 9.55436C9.70149 9.38248 10.005 9.0793 10.1968 8.88748C10.2478 8.83641 10.2815 8.77059 10.293 8.69934C10.3046 8.62809 10.2934 8.55501 10.2611 8.49045C10.0686 8.10545 9.67571 7.31964 9.49489 6.95767C9.46631 6.90056 9.42239 6.85252 9.36805 6.81895C9.31371 6.78538 9.25111 6.76759 9.18724 6.76758H8.75411C8.65126 6.76761 8.54957 6.78923 8.45559 6.83103C8.36162 6.87284 8.27747 6.9339 8.20858 7.01027C8.13949 7.08727 8.06008 7.17527 7.98033 7.26395C7.83024 7.43051 7.71521 7.62558 7.6421 7.83754C7.56899 8.04949 7.53929 8.274 7.55477 8.49767C7.55546 8.50523 7.5558 8.5128 7.55649 8.5207Z" fill="white"/>
                            </svg>
                            <span class="visually-hidden">Whatsapp</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>