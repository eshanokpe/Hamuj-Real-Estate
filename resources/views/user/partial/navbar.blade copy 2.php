<!-- Start header area -->
<header class="header__section">
    <div class="main__header d-flex justify-content-between align-items-center">
        <!-- Left Header Section -->
        <div class="header__left d-flex align-items-center">
            <!-- Collapse Menu Button -->
            <button class="collaps__menu btn btn-link p-0" aria-label="Toggle menu">
                <svg width="26" height="20" viewBox="0 0 26 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.5 16.5999L7.0667 11.1666C6.42503 10.5249 6.42503 9.4749 7.0667 8.83324L12.5 3.3999" stroke="currentColor" stroke-width="1.3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M18.5 16.5999L13.0667 11.1666C12.425 10.5249 12.425 9.4749 13.0667 8.83324L18.5 3.3999" stroke="currentColor" stroke-width="1.3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <!-- Offcanvas Menu Button -->
            <div class="offcanvas__header--menu__open">
                <button class="offcanvas__header--menu__open--btn btn btn-link p-0" data-offcanvas aria-label="Open offcanvas menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon offcanvas__header--menu__open--svg" viewBox="0 0 512 512">
                        <path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 160h352M80 256h352M80 352h352"/>
                    </svg>
                    <span class="visually-hidden">Offcanvas Menu</span>
                </button>
            </div>

            <!-- Search Box -->
            <div class="search__box">
                <form class="search__box--form laptop__hidden" action="#" role="search">
                    <label for="search-input" class="visually-hidden">Search</label>
                    <input id="search-input" class="search__box--input__field" placeholder="Search for..." type="search">
                    <button class="search__box--icon btn btn-link p-0" type="submit" aria-label="Search">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.79171 8.74992C6.97783 8.74992 8.75004 6.97771 8.75004 4.79159C8.75004 2.60546 6.97783 0.833252 4.79171 0.833252C2.60558 0.833252 0.833374 2.60546 0.833374 4.79159C0.833374 6.97771 2.60558 8.74992 4.79171 8.74992Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9.16671 9.16659L8.33337 8.33325" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Logo -->
            <div class="main__logo logo-desktop-block">
                <a class="main__logo--link" href="{{ route('user.dashboard') }}" aria-label="Home">
                    <img class="main__logo--img desktop light__logo" src="{{ asset('assets/img/logo/nav-log.png') }}" alt="Company logo">
                    <img class="main__logo--img desktop dark__logo" src="{{ asset('assets/img/logo/nav-log-white.png') }}" alt="Company logo - dark">
                    <img class="main__logo--img mobile" src="{{ asset('assets/img/logo/logo-mobile.png') }}" alt="Company logo - mobile">
                </a>
            </div>
        </div>

        <!-- Right Header Section -->
        <div class="header__right d-flex align-items-center">
            <!-- Wallet Balance Section -->
            <div class="header__user--profile d-flex align-items-center">
                <!-- Hide Balance Toggle -->
                <div class="form-check form-switch me-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" 
                        {{ Auth::user()->hide_balance ? 'checked' : '' }}
                        onchange="toggleHideBalance(this)">
                    <label class="form-check-label visually-hidden" for="flexSwitchCheckDefault">Hide Balance</label>
                </div>

                <!-- Wallet Display -->
                <div class="wallet-dropdown-container position-relative">
                    <button class="wallet-balance-display d-flex align-items-center bg-transparent border-0 p-0" 
                            id="activeBalanceDisplay" 
                            aria-expanded="false" 
                            aria-controls="walletOptionsDropdown">
                        <span id="activeBalanceText" class="me-1">
                            @if(Auth::user()->hide_balance)
                                ****
                            @else
                                @php
                                    $wallet = Auth::user()->wallet ?? null;
                                    $balance = $wallet ? ($wallet->gbp_balance ?? $wallet->balance ?? 0) : 0;
                                    $currency = $wallet ? ($wallet->currency ?? 'GBP') : 'GBP';
                                @endphp
                                {{ $currency }} {{ number_format($balance, 2) }}
                            @endif
                        </span>
                        <svg class="dropdown-indicator" width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>

                    <!-- Wallet Options Dropdown -->
                    <div class="wallet-options-dropdown shadow-sm" id="walletOptionsDropdown" style="display: none;">
                        @php
                            $wallet = Auth::user()->wallet ?? null;
                            $hasWallet = $wallet !== null;
                            $gbpBalance = $wallet->gbp_balance ?? 0;
                            $usdBalance = $wallet->usd_balance ?? 0;
                            $primaryBalance = $wallet->balance ?? 0;
                            $primaryCurrency = $wallet->currency ?? 'GBP';
                        @endphp

                        @if($hasWallet)
                            @if($primaryBalance > 0)
                                <button class="dropdown-item wallet-select-option px-3 py-2 d-block text-start w-100"
                                    data-currency-symbol="{{ $primaryCurrency }} "
                                    data-balance-value="{{ $primaryBalance }}"
                                    data-label="{{ $primaryCurrency }}">
                                    {{ $primaryCurrency }}: {{ number_format($primaryBalance, 2) }}
                                </button>
                            @endif
                            
                            @if($gbpBalance > 0)
                                <button class="dropdown-item wallet-select-option px-3 py-2 d-block text-start w-100"
                                    data-currency-symbol="GBP "
                                    data-balance-value="{{ $gbpBalance }}"
                                    data-label="GBP">
                                    GBP: {{ number_format($gbpBalance, 2) }}
                                </button>
                            @endif
                            
                            @if($usdBalance > 0)
                                <button class="dropdown-item wallet-select-option px-3 py-2 d-block text-start w-100"
                                    data-currency-symbol="USD "
                                    data-balance-value="{{ $usdBalance }}"
                                    data-label="USD">
                                    USD: {{ number_format($usdBalance, 2) }}
                                </button>
                            @endif
                        @else
                            <div class="dropdown-item px-3 py-2 text-muted">Wallet not available</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <ul class="nav-bar__menu d-flex list-unstyled mb-0">
                <!-- Dark/Light Mode Toggle -->
                <li class="nav-bar__menu--items">
                    <button class="nav-bar__menu--icon btn btn-link p-0" id="light__to--dark" aria-label="Toggle dark mode">
                        <svg class="light--mode__icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.99992 15.4166C12.9915 15.4166 15.4166 12.9915 15.4166 9.99992C15.4166 7.00838 12.9915 4.58325 9.99992 4.58325C7.00838 4.58325 4.58325 7.00838 4.58325 9.99992C4.58325 12.9915 7.00838 15.4166 9.99992 15.4166Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M15.9501 15.9501L15.8417 15.8417M15.8417 4.15841L15.9501 4.05008L15.8417 4.15841ZM4.05008 15.9501L4.15841 15.8417L4.05008 15.9501ZM10.0001 1.73341V1.66675V1.73341ZM10.0001 18.3334V18.2667V18.3334ZM1.73341 10.0001H1.66675H1.73341ZM18.3334 10.0001H18.2667H18.3334ZM4.15841 4.15841L4.05008 4.05008L4.15841 4.15841Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <svg class="dark--mode__icon" xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="20" height="20" viewBox="0 0 512 512">
                            <path d="M264 480A232 232 0 0132 248c0-94 54-178.28 137.61-214.67a16 16 0 0121.06 21.06C181.07 76.43 176 104.66 176 136c0 110.28 89.72 200 200 200 31.34 0 59.57-5.07 81.61-14.67a16 16 0 0121.06 21.06C442.28 426 358 480 264 480z"/>
                        </svg>
                        <span class="visually-hidden">Toggle dark mode</span>
                    </button>
                </li>

                <!-- Notifications -->
                <li class="nav-bar__menu--items header__apps--menu position-relative">
                    <button class="nav-bar__menu--icon apps__menu--icon active btn btn-link p-0 position-relative" 
                            aria-label="Notifications" 
                            aria-expanded="false" 
                            aria-controls="notificationsDropdown">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.0167 2.42505C7.25841 2.42505 5.01674 4.66672 5.01674 7.42505V9.83338C5.01674 10.3417 4.80007 11.1167 4.54174 11.55L3.58341 13.1417C2.99174 14.125 3.40007 15.2167 4.48341 15.5834C8.07507 16.7834 11.9501 16.7834 15.5417 15.5834C16.5501 15.2501 16.9917 14.0584 16.4417 13.1417L15.4834 11.55C15.2334 11.1167 15.0167 10.3417 15.0167 9.83338V7.42505C15.0167 4.67505 12.7667 2.42505 10.0167 2.42505Z" stroke="currentColor" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M11.5584 2.6667C11.3001 2.5917 11.0334 2.53337 10.7584 2.50003C9.95843 2.40003 9.19176 2.45837 8.4751 2.6667C8.71676 2.05003 9.31676 2.05003 10.0168 1.6167C10.7168 1.6167 11.3168 2.05003 11.5584 2.6667Z" stroke="currentColor" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12.5166 15.8833C12.5166 17.2583 11.3916 18.3833 10.0166 18.3833C9.33327 18.3833 8.69993 18.1 8.24993 17.65C7.79993 17.2 7.5166 16.5666 7.5166 15.8833" stroke="currentColor" stroke-miterlimit="10"/>
                        </svg>
                        <span class="nav-bar__notification--badge" id="notificationCount">{{ $notificationCount ?? 0 }}</span>
                    </button>

                    <!-- Notifications Dropdown -->
                    <div class="dropdown__related--apps" id="notificationsDropdown">
                        <div class="dropdown__apps--header">
                            <h3 class="dropdown__apps--title">Notifications ({{ $notificationCount ?? 0 }})</h3>
                        </div>
                        
                        <div class="notification__list p-3">
                            @forelse ($notificationsBar ?? [] as $notification)
                                <div class="notification__item {{ $notification->read_at ? 'unread' : '' }}">
                                    <a href="{{ route('user.notifications.show', encrypt($notification->id)) }}" 
                                        class="notification__link mark-as-read" 
                                        onclick="markNotificationAsRead(event, this)"
                                        data-notification-id="{{ $notification->id }}">
                                        
                                        <div class="notification__content">
                                            @if(in_array($notification['data']['notification_status'], ['PropertyValuationNotification', 'PropertyValuationPredictionNotification']))
                                                @include('user.partial.notifications.propertyValuationPredictionNotification')
                                            @elseif($notification['data']['notification_status'] == 'sellPropertyUserNotification')
                                                @include('user.partial.notifications.sellPropertyUserNotification')
                                            @elseif(in_array($notification['data']['notification_status'], ['senderTransferNotification', 'Sender Transfer Notification']))
                                                @include('user.partial.notifications.senderTransferNotification')
                                            @elseif($notification['data']['notification_status'] == 'transferNotification')
                                                @include('user.partial.notifications.transferNotification')
                                            @elseif(in_array($notification['data']['notification_status'], ['propertyValuationNotification', 'Property Valuation Notification']))
                                                @include('user.partial.notifications.propertyValuationNotification')
                                            @elseif($notification['data']['notification_status'] == 'referral_connection')
                                                @include('user.partial.notifications.referralConnection')
                                            @elseif(in_array($notification['data']['notification_status'], ['recipientSubmittedNotification', 'Recipient Submitted Notification']))
                                                @include('user.partial.notifications.recipientSubmittedNotification')
                                            @elseif($notification['data']['notification_status'] == 'new_referral')
                                                @include('user.partial.notifications.new_referral')
                                            @elseif(in_array($notification['data']['notification_status'], ['WalletFundedNotification', 'walletFundedNotification', 'Wallet Funded Notification']))
                                                @include('user.partial.notifications.walletFundedNotification')
                                            @elseif($notification['data']['notification_status'] == 'buyProperty')
                                                @include('user.partial.notifications.buyProperty')
                                            @elseif($notification['data']['notification_status'] == 'WalletTransferNotification')
                                                <div class="notification__type--transfer">
                                                    <h4>{{ $notification['data']['message'] ?? 'Transfer Notification' }}</h4>
                                                    <p>
                                                        Amount: ₦{{ number_format($notification['data']['amount'], 2) }}
                                                        <small>New balance: ₦{{ number_format($notification['data']['new_balance'], 2) }}</small>
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
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
            </ul>

            <!-- User Profile Dropdown -->
            <div class="header__user--profile">
                <button class="header__user--profile__link d-flex align-items-center bg-transparent border-0 p-0" 
                        id="userProfileDropdown" 
                        aria-expanded="false" 
                        aria-controls="userDropdownMenu">
                    <img class="header__user--profile__thumbnail rounded-circle" 
                         src="{{ Auth::user()->profile_image ? asset(Auth::user()->profile_image) : asset('assets/admin/img/dashboard/avater.jpg') }}" 
                         alt="{{ Auth::user()->name }}'s profile picture"
                         width="30"
                         height="30">
                    <span class="header__user--profile__name ms-2">{{ Auth::user()->name }}</span>
                    <span class="header__user--profile__arrow">
                        <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.9994 4.97656L10.1244 0.851563L11.3027 2.0299L5.9994 7.33323L0.696067 2.0299L1.8744 0.851563L5.9994 4.97656Z" fill="currentColor" fill-opacity="0.5"/>
                        </svg>
                    </span>
                </button>

                <!-- User Dropdown Menu -->
                <div class="dropdown__user--profile" id="userDropdownMenu">
                    <ul class="user__profile--menu list-unstyled mb-0">
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
                        <li class="user__profile--menu__items">
                            <a class="user__profile--menu__link" href="{{ route('user.profile.index')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="8" r="5"></circle>
                                    <path d="M20 21a8 8 0 0 0-16 0"></path>
                                </svg>
                                My Profile
                            </a>
                        </li>
                    </ul>
                    <div class="dropdown__user--profile__footer">
                        <form id="logout-form" action="{{ route('user.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="user__profile--log-out__btn btn btn-link text-start w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" x2="9" y1="12" y2="12"></line>
                                </svg>
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle hide balance
    const hideBalanceCheckbox = document.getElementById('flexSwitchCheckDefault');
    if (hideBalanceCheckbox) {
        hideBalanceCheckbox.addEventListener('change', function() {
            const isHidden = this.checked;
            const balanceText = document.getElementById('activeBalanceText');
            
            if (isHidden) {
                balanceText.textContent = '****';
            } else {
                // Get the selected wallet balance
                const selectedLabel = localStorage.getItem('selectedWalletCurrencyLabel') || 'GBP';
                const selectedOption = document.querySelector(`.wallet-select-option[data-label="${selectedLabel}"]`);
                
                if (selectedOption) {
                    const currency = selectedOption.dataset.currencySymbol;
                    const balance = selectedOption.dataset.balanceValue;
                    balanceText.textContent = `${currency}${parseFloat(balance).toFixed(2)}`;
                } else {
                    balanceText.textContent = 'GBP 0.00'; // Default
                }
            }
            
            
        });
    }

    // Wallet dropdown functionality
    const walletDropdown = document.querySelector('.wallet-dropdown-container');
    if (walletDropdown) {
        const balanceDisplay = walletDropdown.querySelector('#activeBalanceDisplay');
        const dropdown = walletDropdown.querySelector('.wallet-options-dropdown');
        const options = walletDropdown.querySelectorAll('.wallet-select-option');

        balanceDisplay.addEventListener('click', function(e) {
            if (!hideBalanceCheckbox.checked) {
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                balanceDisplay.setAttribute('aria-expanded', dropdown.style.display === 'block');
            }
        });

        options.forEach(option => {
            option.addEventListener('click', function() {
                const currency = this.dataset.currencySymbol;
                const balance = this.dataset.balanceValue;
                document.getElementById('activeBalanceText').textContent = `${currency}${parseFloat(balance).toFixed(2)}`;
                localStorage.setItem('selectedWalletCurrencyLabel', this.dataset.label);
                dropdown.style.display = 'none';
                balanceDisplay.setAttribute('aria-expanded', false);
            });
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!walletDropdown.contains(e.target)) {
                dropdown.style.display = 'none';
                balanceDisplay.setAttribute('aria-expanded', false);
            }
        });
    }

    // Notifications dropdown
    const notificationsButton = document.querySelector('.apps__menu--icon');
    const notificationsDropdown = document.getElementById('notificationsDropdown');
    
    if (notificationsButton && notificationsDropdown) {
        notificationsButton.addEventListener('click', function(e) {
            e.preventDefault();
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);
            notificationsDropdown.style.display = isExpanded ? 'none' : 'block';
        });

        // Close when clicking outside
        document.addEventListener('click', function(e) {
            if (!notificationsButton.contains(e.target) && !notificationsDropdown.contains(e.target)) {
                notificationsDropdown.style.display = 'none';
                notificationsButton.setAttribute('aria-expanded', false);
            }
        });
    }

    // User profile dropdown
    const profileButton = document.getElementById('userProfileDropdown');
    const profileDropdown = document.getElementById('userDropdownMenu');
    
    if (profileButton && profileDropdown) {
        profileButton.addEventListener('click', function(e) {
            e.preventDefault();
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);
            profileDropdown.style.display = isExpanded ? 'none' : 'block';
        });

        // Close when clicking outside
        document.addEventListener('click', function(e) {
            if (!profileButton.contains(e.target) && !profileDropdown.contains(e.target)) {
                profileDropdown.style.display = 'none';
                profileButton.setAttribute('aria-expanded', false);
            }
        });
    }

    // Mark notification as read
    window.markNotificationAsRead = function(event, element) {
        event.preventDefault();
        const notificationId = element.dataset.notificationId;
        const notificationElement = element.closest('.notification__item');
        
        // Hide immediately
        notificationElement.style.display = 'none';
        
        // Update counter
        const counter = document.getElementById('notificationCount');
        if (counter) {
            const currentCount = parseInt(counter.textContent);
            counter.textContent = Math.max(0, currentCount - 1);
        }
        
        // Mark as read on server
        fetch(`/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => {
            if (response.ok) {
                window.location.href = element.href;
            }
        });
    };
});
</script>
@endpush