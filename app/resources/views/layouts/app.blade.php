<!DOCTYPE html>
<html lang="zxx">
    <head> 
        <!--====== Required meta tags ======-->
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="Institute of Governance, Risk & Compliance & Financial Crime Prevention (IGRCFP), Finance">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--====== Title ======--> 
        <title>IGRCFP</title>  
        <!--====== Favicon Icon ======-->
        <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" type="image/png">
        <!--====== Google Fonts ======--> 
        <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
        <!--====== FontAwesome css ======-->
        <link rel="stylesheet" href="{{asset('assets/fonts/fontawesome/css/all.min.css')}}">
        <!--====== Bootstrap css ======-->
        <link rel="stylesheet" href="{{asset('assets/css/plugins/bootstrap.min.css')}}">
        <!--====== Slick-popup css ======-->
        <link rel="stylesheet" href="{{asset('assets/css/plugins/slick.css')}}">
        <!--====== Magnific-popup css ======-->
        <link rel="stylesheet" href="{{asset('assets/css/plugins/magnific-popup.css')}}">
        <!--====== Aos css ======-->
        <link rel="stylesheet" href="{{asset('assets/css/plugins/aos.css')}}">
        <!--====== Default css ======-->
        <link rel="stylesheet" href="{{asset('assets/css/spacings.css')}}">
        <!--====== Default css ======-->
        <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        
        <!-- Livewire Styles - MUST be in head -->
        @livewireStyles
        
        <!-- Page-specific styles -->
        @stack('styles')
    </head>
    <body>
        {{-- <!--====== Start Preloader ======-->
        <div class="preloader">
            <div class="loading-wrapper">
                <div class="loading"></div>
                <div id="loading-icon">
                    <img src="{{ asset('assets/images/loader.png')}}" alt="loader"  ></div>
            </div>
        </div>
        <!--====== End Preloader ======--> --}}

        <!--====== Start Overlay ======-->
        <div class="offcanvas__overlay"></div>

        @include('layouts.navbar')

        <!--======  Smooth Wrapper  ======-->
        <div id="smooth-wrapper">
            <div id="smooth-content">
                <main>
                    @yield('content')
                </main>
               
                @include('layouts.footer')
            </div>
        </div>

        <!-- jQuery (optional, but good for AJAX) -->
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        
        <!-- AOS Animation -->
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        
        <!-- Livewire Scripts - MUST be before closing body tag -->
        @livewireScripts
        <!-- For Livewire v3 -->
        @livewireScriptConfig
        
        <!-- Alpine.js - Required for Livewire v3 -->
        <script src="//unpkg.com/alpinejs" defer></script>
        
       
        <!-- Page-specific scripts -->
        @stack('scripts')
    </body>
</html>