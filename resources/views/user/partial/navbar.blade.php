<!-- Start header area -->
<header class="header__section">
    <div class="main__header d-flex justify-content-between align-items-center">
        <div class="header__left d-flex align-items-center">
            <a class="collaps__menu" href="javascript:void(0)"><svg width="26" height="20" viewBox="0 0 26 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.5 16.5999L7.0667 11.1666C6.42503 10.5249 6.42503 9.4749 7.0667 8.83324L12.5 3.3999" stroke="currentColor" stroke-width="1.3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M18.5 16.5999L13.0667 11.1666C12.425 10.5249 12.425 9.4749 13.0667 8.83324L18.5 3.3999" stroke="currentColor" stroke-width="1.3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
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
                    <img class="main__logo--img desktop light__logo" src="assets/img/logo/nav-log.png" alt="logo-img">
                    <img class="main__logo--img desktop dark__logo" src="assets/img/logo/nav-log-white.png" alt="logo-img">
                    <img class="main__logo--img mobile" src="assets/img/logo/logo-mobile.png" alt="logo-img">
                </a>
            </div>
        </div>

        <div class="header__right d-flex align-items-center">
          

            <div class="header__nav-bar__wrapper d-flex align-items-center">
                <div class="header__user--profile d-flex">
                    <a href="#" class="main__menu--link d-flex align-items-center justify-content-between" style="gap: 10px;">
                        <div class="form-check form-switch">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                role="switch" 
                                id="flexSwitchCheckDefault" 
                                {{ Auth::user()->hide_balance ? 'checked' : '' }}
                                onchange="toggleHideBalance(this)"
                                >
                        </div>
                    </a>
                    <a class="" href="#">
                    {{-- <a class="header__user--profile__link d-flex align-items-center" href="#"> --}}
                       
                        <svg style="margin-right: 5px" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.8333 4.66667H11.6667V3.5C11.6667 2.5335 10.8662 1.75 9.91667 1.75H2.33333C1.38383 1.75 0.583333 2.5335 0.583333 3.5V10.5C0.583333 11.4665 1.38383 12.25 2.33333 12.25H12.8333C13.7828 12.25 14.5833 11.4665 14.5833 10.5V6.41667C14.5833 5.45 13.7828 4.66667 12.8333 4.66667ZM2.33333 2.91667H9.91667C10.3993 2.91667 10.8333 3.35067 10.8333 3.83333V4.66667H2.33333C1.85067 4.66667 1.41667 4.23267 1.41667 3.75C1.41667 3.26733 1.85067 2.91667 2.33333 2.91667ZM12.8333 10.5C12.8333 10.983 12.3993 11.4167 11.9167 11.4167H2.33333C1.85067 11.4167 1.41667 10.983 1.41667 10.5V6.41667H12.8333C13.316 6.41667 13.75 6.85067 13.75 7.33333V10.5ZM10.0833 8.16667C9.60067 8.16667 9.16667 8.60067 9.16667 9.08333C9.16667 9.566 9.60067 10 10.0833 10C10.566 10 11 9.566 11 9.08333C11 8.60067 10.566 8.16667 10.0833 8.16667Z" fill="#16A34A"/>
                        </svg> 
                        <span>
                            @if(Auth::user()->hide_balance)
                                ****
                            @else
                                <span class="wallet-balance">{{ $wallet->currency ?? 'N'}}{{ number_format($wallet->balance ?? 0.00,  2) }}</span>
                            @endif
                        </span>
                    </a>
                </div> 
                <ul class="nav-bar__menu d-flex">
                    
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
                    <li class="nav-bar__menu--items header__apps--menu position-relative">
                        <a class="nav-bar__menu--icon apps__menu--icon active" href="#" aria-label="Notifications">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.0167 2.42505C7.25841 2.42505 5.01674 4.66672 5.01674 7.42505V9.83338C5.01674 10.3417 4.80007 11.1167 4.54174 11.55L3.58341 13.1417C2.99174 14.125 3.40007 15.2167 4.48341 15.5834C8.07507 16.7834 11.9501 16.7834 15.5417 15.5834C16.5501 15.2501 16.9917 14.0584 16.4417 13.1417L15.4834 11.55C15.2334 11.1167 15.0167 10.3417 15.0167 9.83338V7.42505C15.0167 4.67505 12.7667 2.42505 10.0167 2.42505Z" stroke="currentColor" stroke-miterlimit="10" stroke-linecap="round"/>
                                <path d="M11.5584 2.6667C11.3001 2.5917 11.0334 2.53337 10.7584 2.50003C9.95843 2.40003 9.19176 2.45837 8.4751 2.6667C8.71676 2.05003 9.31676 1.6167 10.0168 1.6167C10.7168 1.6167 11.3168 2.05003 11.5584 2.6667Z" stroke="currentColor" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12.5166 15.8833C12.5166 17.2583 11.3916 18.3833 10.0166 18.3833C9.33327 18.3833 8.69993 18.1 8.24993 17.65C7.79993 17.2 7.5166 16.5666 7.5166 15.8833" stroke="currentColor" stroke-miterlimit="10"/>
                            </svg> 
                            <span class="nav-bar__notification--badge" id="notificationCount">{{ $notificationCount }}</span>
                            <span class="visually-hidden">Notification</span>                                         
                        </a>
                        
                        <div class="dropdown__related--apps">
                            <div class="dropdown__apps--header">
                                <h3 class="dropdown__apps--title">Notifications ({{ $notificationCount }})</h3>
                            </div>
                            
                            <div class="notification__list p-3">
                                @forelse ($notificationsBar as $notification)
                                    <div class="notification__item {{ $notification->read_at ? 'unread' : '' }}">
                                        <a href="{{ route('user.notifications.show', encrypt($notification->id)) }}" 
                                            class="notification__link mark-as-read" 
                                            onclick="markNotificationAsRead(event, this)"
                                            data-notification-id="{{ $notification->id }}"
                                            data-property-mode="{{ $notification->data['property_mode'] ?? '' }}">
            
                                            <div class="notification__content">
                                                {{-- {{$notification['data']['notification_status']}} --}}
                                                @if(in_array($notification['data']['notification_status'], ['PropertyValuationNotification', 'PropertyValuationPredictionNotification','propertyValuationPredictionNotification']))
                                                    @include('.user/partial/notifications/propertyValuationPredictionNotification')
 
                                                @elseif($notification['data']['notification_status'] == 'sellPropertyUserNotification')
                                                    @include('.user/partial/notifications/sellPropertyUserNotification')
                                                @elseif($notification['data']['notification_status'] == 'senderTransferNotification' || $notification['data']['notification_status'] == 'Sender Transfer Notification')
                                                    @include('.user/partial/notifications/senderTransferNotification')
                                                @elseif($notification['data']['notification_status'] == 'transferNotification')
                                                    @include('.user/partial/notifications/transferNotification')
                                                @elseif($notification['data']['notification_status'] == 'propertyValuationNotification' || $notification['data']['notification_status'] == 'Property Valuation Notification')
                                                    @include('.user/partial/notifications/propertyValuationNotification')
                                                @elseif($notification['data']['notification_status'] == 'referral_connection')
                                                    @include('.user/partial/notifications/referralConnection')
                                                @elseif($notification['data']['notification_status'] == 'recipientSubmittedNotification' || $notification['data']['notification_status'] == 'Recipient Submitted Notification')
                                                    @include('.user/partial/notifications/recipientSubmittedNotification')
                                                @elseif($notification['data']['notification_status'] == 'new_referral')
                                                    @include('.user/partial/notifications/new_referral')
                                                @elseif($notification['data']['notification_status'] == 'WalletFundedNotification' || $notification['data']['notification_status'] == 'walletFundedNotification' || $notification['data']['notification_status'] == 'Wallet Funded Notification')
                                                    @include('.user/partial/notifications/walletFundedNotification')
                                                @elseif($notification['data']['notification_status'] == 'buyProperty' )
                                                    @include('.user/partial/notifications/buyProperty')
                                                  
                                                @elseif($notification['data']['notification_status'] == 'WalletTransferNotification')
                                                    <div class="notification__type--transfer">
                                                        <h4>{{ $notification['data']['message'] ?? 'Transfer Notification' }}</h4>
                                                        <p>
                                                            Amount: ₦{{ number_format($notification['data']['amount'], 2) }}
                                                            <small>New balance: ₦{{ number_format($notification['data']['new_balance'], 2) }}</small>
                                                        </p>
                                                    </div>
                                                @else
                                                    {{-- <div class="notification__type--generic">
                                                        <h4>{{ $notification['data']['property_name'] ?? 'Notification' }}</h4>
                                                        <p>{{ $notification['data']['message'] ?? '' }}</p>
                                                        @isset($notification['data']['land_size'])
                                                            <small>Land Size: {{ $notification['data']['land_size'] }}</small>
                                                        @endisset
                                                    </div> --}}
                                                @endif
                                                
                                                <div class="notification__meta">
                                                    {{-- <time datetime="{{ $notification['created_at'] }}">{{ \Carbon\Carbon::parse($notification['created_at'])->diffForHumans() }}</time>
                                                    @empty($notification['read_at'])
                                                        <span class="notification__status--unread">Unread</span>
                                                    @else
                                                        <span class="notification__status--read">Read</span>
                                                    @endempty --}}
                                                </div>
                                            </div>
                                            
                                            {{-- <a href="{{ route('user.notifications.show', $notification['id']) }}" 
                                            class="notification__action mark-as-read"
                                            data-notification-id="{{ $notification['id'] }}"
                                            data-property-mode="{{ $notification['data']['property_mode'] ?? '' }}">
                                                View Details
                                            </a> --}}
                                        </a>
                                    </div>
                                @empty
                                    <div class="notification__empty">
                                        <p>No new notifications</p>
                                    </div>
                                @endforelse
                            </div>
                            
                            <div class="dropdown__apps__footer">
                                <a class="solid__btn dropdown__apps--view__all" href="{{ route('user.notifications.index') }}">
                                    View All Notifications
                                </a>
                            </div>
                        </div>
                    </li>
                    
                    @push('scripts')
                        <script>
                            function markNotificationAsRead(event, element) {
                                event.preventDefault();
                                
                                const notificationId = element.dataset.notificationId;
                                const notificationElement = element.closest('.notification__item');
                                
                                // Immediately remove from UI
                                notificationElement.style.display = 'none';
                                
                                // Update counter
                                const counterElement = document.getElementById('notificationCount');
                                if (counterElement) {
                                    const currentCount = parseInt(counterElement.textContent);
                                    counterElement.textContent = Math.max(0, currentCount - 1);
                                }
                                
                                // Update unread count
                                const unreadCountElement = document.querySelector('.dropdown__apps--count');
                                if (unreadCountElement) {
                                    const newCount = parseInt(unreadCountElement.textContent) - 1;
                                    unreadCountElement.textContent = newCount > 0 ? newCount : '';
                                }
                                
                                // Mark as read via AJAX
                                fetch(`/notifications/${notificationId}/read`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        property_mode: element.dataset.propertyMode
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.redirect_url) {
                                        window.location.href = data.redirect_url;
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    window.location.href = element.href;
                                });
                            }

                            // Real-time updates
                            document.addEventListener('DOMContentLoaded', function() {
                                const updateCounts = () => {
                                    fetch('{{ route('user.notifications.count') }}')
                                        .then(response => response.json())
                                        .then(data => {
                                            document.getElementById('notificationCount').textContent = data.count;
                                            const countElement = document.querySelector('.dropdown__apps--count');
                                            if (countElement) {
                                                countElement.textContent = data.count > 0 ? data.count : '';
                                            }
                                        });
                                };
                                
                                setInterval(updateCounts, 60000);
                            });
                        </script>
                    @endpush
                   
                   
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