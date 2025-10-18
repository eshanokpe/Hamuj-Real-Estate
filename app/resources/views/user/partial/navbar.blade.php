<!-- Start header area -->
<header class="header__section" style="background-color: #fff">
    <div>
    {{-- <div class="header__left d-flex align-items-cente p-2"> --}}
        <div class="d-flex justify-content-between">
            <!-- Left side - Hamburger menu and logo -->
            <div class="d-flex align-items-center">
                <a class="collaps__menu " href="javascript:void(0)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon offcanvas__header--menu__open--svg" viewBox="0 0 512 512"><path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 160h352M80 256h352M80 352h352"/></svg>
                </a>
                <div class=" main__logo logo-desktop-block">
                    <a class="main__logo--link" href="{{ route('user.dashboard') }}">
                        <img class="main__logo--img desktop light__logo" src="{{ asset('assets/img/logo/nav-log.png')}}" alt="logo-img" style="padding-top:8px; width:130px">
                        <img class="main__logo--img desktop dark__logo" src="{{ asset('assets/img/logo/nav-log.png')}}" alt="logo-img">
                        <img class="main__logo--img mobile" src="{{ asset('assets/img/logo/logo-mobile.png')}}" alt="logo-img" >
                    </a>
                </div>
            </div>
       
            <div>
                @include('user.partial.walletNav')
            </div>
        </div>
    </div>

    {{-- <div class="main__header d-flex justify-content-between align-items-center">
        <div class="header__right d-flex align-items-center">
            <div class="header__nav-bar__wrapper d-flex align-items-center">
                
                <div class="header__user--profile ">
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
                        
                        <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        
                    </div>
                </div>

            </div>
        </div>
    </div> --}}
</header>