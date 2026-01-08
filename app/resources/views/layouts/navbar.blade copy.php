<!--=== Start Header Area ===-->
<header class="header-area header-three">
    <!--==== Header Navigation ===-->
    <div class="header-navigation">
        <div class="container-fluid">
            <!--==== Primary Menu ===-->
            <div class="primary-menu">
                <!--==== Site Branding ===-->
                <div class="site-branding">
                    <a href="{{ route('index') }}" class="brand-logo">
                        <img src="{{ asset('assets/images/home-three/logo/logo-main.png')}}" style="width:60px" alt="Brand Logo">
                    </a>
                </div>
                <!--=== Main Menu ===-->
                <div class="theme-nav-menu">
                    <!--=== Menu Top ===-->
                    <div class="theme-menu-top d-block d-xl-none">
                        <div class="site-branding">
                            <a href="{{ route('index') }}" class="brand-logo">
                                <img src="{{ asset('assets/images/home-three/logo/logo-main.png')}}" style="width:60px" alt="Brand Logo">
                            </a>
                        </div>
                    </div>
                    <!--=== Main Menu ===-->
                    <nav class="main-menu">
                        <ul>
                            <li class="menu-item"><a href="{{ route('index') }}">Home</a></li>

                            <li class="menu-item has-children">
                                <a href="{{ route('about-us') }}">About us</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('igrcfp') }}">Welcome to IGRCFP</a></li>
                                    <li><a href="{{ route('structure') }}">Our Structure</a></li>
                                </ul>
                            </li>
                            <li class="menu-item has-children">
                                <a href="{{ route('membership') }}">Membership</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('get-involved') }}">Get Involved</a></li>
                                </ul>
                            </li>
                            <li class="menu-item has-children">
                                <a href="{{ route('certification') }}">Certifications & Training</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('cgfcs') }}">Certified GRC & Financial Crime Specialist (CGFCS)</a></li>
                                </ul>
                            </li>
                            <li class="menu-item"><a href="{{ route('event') }}">Event</a></li>
                            <li class="menu-item"><a href="{{ route('blog') }}">Blog</a></li>
                            <li class="menu-item"><a href="{{ route('contact') }}">Contact</a></li>
                        </ul>
                    </nav>
                    <!--=== Nav Button ===-->
                    <div class="theme-nav-button mt-20 d-block d-md-none">
                        <a href="contact.html" class="theme-btn style-one">Get Involved<i class="far fa-arrow-right"></i></a>
                    </div>
                    <!--=== Menu Bottom ===-->
                    <div class="theme-menu-bottom mt-50 d-block d-xl-none">
                        <h5>Follow Us</h5>
                        <ul class="social-link">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!--=== Header Nav Right ===-->
                <div class="nav-right-item">
                    @guest
                        <div class="nav-button d-none d-md-block">
                            <a href="{{ route('register') }}" class="theme-btn style-one">Join the Institute<i class="far fa-arrow-right"></i></a>
                        </div>
                    @else
                        <!-- User Profile Section -->
                        <div class="user-profile-section d-flex align-items-center">
                            <!-- Notification Bell -->
                            <div class="notification-dropdown me-3 position-relative">
                                <a href="#" class="notification-icon" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="far fa-bell fa-lg"></i>
                                    <span class="notification-count badge bg-danger">3</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end notification-menu" aria-labelledby="notificationDropdown">
                                    <div class="notification-header">
                                        <h6 class="mb-0">Notifications</h6>
                                        <a href="#" class="text-primary small">Mark all as read</a>
                                    </div>
                                    <div class="notification-body">
                                        <a href="#" class="notification-item unread">
                                            <div class="notification-icon bg-primary">
                                                <i class="fas fa-calendar-check"></i>
                                            </div>
                                            <div class="notification-content">
                                                <p class="mb-0">New session booked for tomorrow</p>
                                                <small class="text-muted">2 hours ago</small>
                                            </div>
                                        </a>
                                        <a href="#" class="notification-item">
                                            <div class="notification-icon bg-success">
                                                <i class="fas fa-user-check"></i>
                                            </div>
                                            <div class="notification-content">
                                                <p class="mb-0">Your profile has been verified</p>
                                                <small class="text-muted">1 day ago</small>
                                            </div>
                                        </a>
                                        <a href="#" class="notification-item">
                                            <div class="notification-icon bg-warning">
                                                <i class="fas fa-exclamation-circle"></i>
                                            </div>
                                            <div class="notification-content">
                                                <p class="mb-0">Complete your profile to get more visibility</p>
                                                <small class="text-muted">2 days ago</small>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="notification-footer text-center">
                                        <a href="#" class="text-primary">View all notifications</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Shopping Cart Icon with Cart Count -->
                            <div class="cart-dropdown me-3 position-relative">
                                <a href="{{ route('learner.cart.index') }}" 
                                class="cart-icon position-relative" 
                                id="cartDropdown" 
                                role="button" 
                                data-bs-toggle="dropdown" 
                                aria-expanded="false">
                                    {{-- <i class="far fa-shopping-cart fa-lg"></i> --}}
                                    <span class="notification-count badge bg-danger">3</span>
                                    {{-- Livewire cart count --}}
                                    @auth
                                        <livewire:cart-count />
                                    @endauth
                                </a>
    
                                {{-- Livewire cart dropdown --}}
                                @auth
                                    <livewire:cart-dropdown />
                                @endauth
                            </div>

                            <!-- Profile Dropdown -->
                            <div class="profile-dropdown position-relative">
                                <a href="#" class="profile-toggle d-flex align-items-center" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <!-- Profile Picture -->
                                    <div class="profile-pic me-2">
                                        @if(Auth::user()->profile_picture)
                                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="{{ Auth::user()->name }}" class="rounded-circle" style="width: 36px; height: 36px; object-fit: cover;">
                                        @else
                                            <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #293567; color: white;">
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <!-- Username -->
                                    <div class="profile-info d-none d-lg-block">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column me-2">
                                                <span class="fw-semibold" style="font-size: 0.9rem; line-height: 1.2;">
                                                    {{ Auth::user()->name }}
                                                </span>
                                                <small  style="margin-top: -5px" class="text-muted text-truncate" style="max-width: 150px; font-size: 0.75rem;">
                                                    {{ Auth::user()->email }}
                                                </small>
                                            </div>
                                            <i class="fas fa-chevron-down text-muted" style="font-size: 0.8rem;"></i>
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end profile-menu" aria-labelledby="profileDropdown">
                                    <!-- Profile Header -->
                                    <div class="profile-header text-center p-3">
                                        <a href="#" class="profile-toggle d-flex align-items-center justify-content-center" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <!-- Profile Picture -->
                                            <div class="profile-pic mb-2">
                                                @if(Auth::user()->profile_picture)
                                                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="{{ Auth::user()->name }}" 
                                                    class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
                                                @else
                                                    <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center" 
                                                        style="width: 30px; height: 30px; background-color: #293567; color: white; font-size: 20px;">
                                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <!-- User Info -->
                                            <div class="profile-info  text-start">
                                                <h7 class=" mb-1 text-start fw-semibold" style="margin-left: 5px">{{ Auth::user()->name }}</h7>
                                                <div class="d-flex align-items-center justify-content-center" style="margin-top: -10px; margin-left: 5px">
                                                    <small class="text-muted text-truncate" style="max-width: 200px; font-size: 0.85rem;">
                                                        {{ Auth::user()->email }}
                                                    </small>
                                                     <span class="badge {{ Auth::user()->role === 'tutor' ? 'bg-warning' : 'bg-info' }} me-1" 
                                                        style="font-size: 0.7rem; padding: 0.25em 0.6em; font-weight:400">
                                                        {{ ucfirst(Auth::user()->role) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <hr class="my-0"> 
                                    <!-- Menu Items -->
                                    <a href="{{ Auth::user()->role === 'tutor' ? route('tutor.settings') : route('learner.settings') }}" class="dropdown-item">
                                        <i class="far fa-cog me-2"></i>Account Settings
                                    </a>
                                    <a href="{{ Auth::user()->role === 'tutor' ? route('tutor.profile') : route('learner.profile') }}" class="dropdown-item">
                                        <i class="far fa-user me-2"></i>My Profile
                                    </a>
                                    <a href="{{ Auth::user()->role === 'tutor' ? route('tutor.dashboard') : route('learner.dashboard') }}" class="dropdown-item">
                                        <i class="far fa-tachometer-alt me-2"></i>Dashboard
                                    </a>
                                    <a href="#" class="dropdown-item">
                                        <i class="fas fa-shopping-cart me-2"></i>My Cart
                                        <span class="badge bg-success float-end">
                                            {{-- Livewire cart count --}}
                                            @auth
                                                <livewire:cart-count />
                                            @endauth
                                        </span>
                                    </a>
                                    
                                    <hr class="my-0">
                                    <a href="{{ route('logout') }}" 
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                       class="dropdown-item text-danger">
                                        <i class="far fa-sign-out-alt me-2"></i>Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endguest
                    <div class="navbar-toggler">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</header>
<!--=== End Header Area ===-->

<!-- Add CSS Styles -->
<style>
    .user-profile-section {
        gap: 15px;
    }

    .notification-dropdown, .cart-dropdown {
        position: relative;
    }

    .notification-icon, .cart-icon {
        position: relative;
        color: #333;
        text-decoration: none;
        display: inline-block;
        padding: 5px;
    }

    .notification-icon:hover, .cart-icon:hover {
        color: #293567;
    }

    .notification-count, .cart-count {
        position: absolute;
        top: -5px;
        right: -5px;
        font-size: 10px;
        padding: 3px 6px;
        border-radius: 50%;
    }

    .notification-menu, .cart-menu {
        min-width: 320px;
        padding: 0;
        border: 1px solid #e0e0e0;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .cart-menu {
        min-width: 350px;
    }

    .notification-header, .cart-header {
        padding: 15px;
        border-bottom: 1px solid #e0e0e0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #f8f9fa;
    }

    .notification-body, .cart-body {
        max-height: 300px;
        overflow-y: auto;
    }

    .cart-body {
        padding: 15px;
    }

    .cart-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .cart-item-image {
        width: 60px;
        height: 60px;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .cart-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .cart-item-details {
        flex-grow: 1;
    }

    .cart-item-details h6 {
        font-size: 14px;
        margin-bottom: 5px;
    }

    .cart-item-details small {
        font-size: 12px;
        display: block;
        margin-bottom: 5px;
    }

    .cart-item-remove {
        padding: 0;
        font-size: 14px;
    }

    .cart-footer {
        padding: 15px;
        border-top: 1px solid #e0e0e0;
        background-color: #f8f9fa;
    }

    .cart-total {
        font-size: 16px;
    }

    .cart-actions .btn {
        padding: 8px 12px;
        font-size: 14px;
    }

    .notification-item {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        text-decoration: none;
        color: #333;
        border-bottom: 1px solid #f0f0f0;
        transition: background-color 0.2s;
    }

    .notification-item:hover {
        background-color: #f8f9fa;
        text-decoration: none;
    }

    .notification-item.unread {
        background-color: #f0f7ff;
    }


    .notification-content {
        flex: 1;
    }

    .notification-content p {
        margin-bottom: 3px;
        font-size: 14px;
    }

    .notification-content small {
        font-size: 12px;
    }

    .notification-footer {
        padding: 10px;
        border-top: 1px solid #e0e0e0;
        background-color: #f8f9fa;
    }

    .profile-dropdown .profile-toggle {
        text-decoration: none;
        color: #333;
        transition: color 0.2s;
    }

    .profile-dropdown .profile-toggle:hover {
        color: #293567;
    }

    .avatar-placeholder {
        font-weight: 600;
    }

    .profile-menu {
        min-width: 240px;
        border: 1px solid #e0e0e0;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .profile-header {
        background-color: #f8f9fa;
        border-radius: 5px 5px 0 0;
    }

    .profile-menu .dropdown-item {
        padding: 10px 15px;
        font-size: 14px;
        transition: background-color 0.2s;
    }

    .profile-menu .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    .profile-menu .dropdown-item i {
        width: 20px;
        text-align: center;
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .user-profile-section {
            gap: 10px;
        }
        
        .notification-menu, .cart-menu {
            min-width: 280px;
        }
        
        .cart-menu {
            min-width: 300px;
        }
        
        .profile-info {
            display: none !important;
        }
    }

    @media (max-width: 576px) {
        .cart-menu {
            min-width: 280px;
            right: 0 !important;
            left: auto !important;
        }
    }
</style>

<!-- Add JavaScript for Cart and Notification Functionality -->
<script>
    // Listen for Livewire events
Livewire.on('cartUpdated', () => {
    console.log('Cart updated event received');
    // Refresh cart dropdown if it's open
    refreshCartDropdown();
});

Livewire.on('cart-item-added', (event) => {
    console.log('Cart item added:', event);
    showNotification('Item added to cart!', 'success');
});

Livewire.on('cart-item-removed', (event) => {
    console.log('Cart item removed:', event);
    showNotification('Item removed from cart', 'info');
});

Livewire.on('notify', (event) => {
    console.log('Notification:', event);
    showNotification(event.message, event.type);
});

// JavaScript function to dispatch events
function dispatchCartUpdate() {
    if (typeof Livewire !== 'undefined') {
        Livewire.dispatch('cartUpdated');
    }
}

// Example: Refresh cart when dropdown opens
document.addEventListener('show.bs.dropdown', function(event) {
    if (event.target.id === 'cartDropdown') {
        dispatchCartUpdate();
    }
});
</script>