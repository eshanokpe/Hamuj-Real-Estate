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

    
</header>