<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head> 
  <meta charset="utf-8">
  <title>{{  $contactDetials->company_name }}</title>
  <meta name="description" content="">
  @auth
      <meta name="user-id" content="{{ auth()->id() }}">
  @endauth
  
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset($contactDetials->favicon) }}">
     
   <!-- ======= All CSS Plugins here ======== -->
  <link rel="stylesheet" href="{{ asset('assets/css/plugins/swiper-bundle.min.css')}}">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Plugin css -->
  <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/css/plugins/swiper-bundle.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/css/plugins/glightbox.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/css/plugins/aos.css')}}">
 
  <!-- Custom Style CSS --> 
  <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/css/rtl.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/css/chatWidget.css')}}">

  <!-- Scripts -->
  @viteReactRefresh
  @vite('resources/js/app.jsx')
  <!-- Add Toastr CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-E9JFRZR724"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-E9JFRZR724');
  </script>
  <style>
    /* Add to your CSS */
    input:disabled {
        background-color: #f8f9fa;
        cursor: not-allowed;
    }
  </style>
</head>

<body>
    
    @include('home.partial.navbar')

    @yield('content')
   
    @include('home.partial.footer')
    
    {{-- @include('chattle::chat')  --}}
    
    
</body>
</html>