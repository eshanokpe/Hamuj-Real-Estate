<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{  $contactDetials->company_name }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token --> 
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset($contactDetials->favicon) }}">
    
    <!-- ======= All CSS Plugins here ======== -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/plugins/swiper-bundle.min.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    
    <!-- Plugin css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/plugins/swiper-bundle.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/plugins/glightbox.min.css')}}">

    <!-- Custom Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/dashboard.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/dark.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/admin//css/rtl.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/table.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/creat-listing.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/chat.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Scripts --> 
    @viteReactRefresh
    @vite('resources/js/app.jsx')
    <!-- Add Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem("theme-color") === "dark" || (!("theme-color" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches)) {
        document.documentElement.classList.add("dark");
        } 
        if (localStorage.getItem("theme-color") === "light") {
        document.documentElement.classList.remove("dark");
        } 
    </script>
    <script src="https://merchant.revolut.com/checkout.js"></script>

    <style>
        .dashboard__chart--box__inner {
            height: 317px;
            padding-left: 0px;
        }
        .sold-out__progress-bar__field {
            max-width: 200px;
            width: 100%;
        }
        html, body {
            height: 100%;
            margin: 0;
        }
        .dashboard__page--wrapper {
        display: flex;
        flex-direction: column;
        min-height: 100%;
        }

        footer {
            margin-top: auto; /* Pushes the footer to the bottom */
        }

        .copy-success {
            font-size: 14px;
            color: #28a745;
            margin-left: 8px;
            animation: fadeInOut 3s forwards;
        }

        .copy-fail {
            font-size: 14px;
            color: #dc3545;
            margin-left: 8px;
            animation: fadeInOut 3s forwards;
        }
        .referral-code {
            word-break: break-word; /* Ensure long text breaks into the next line */
            overflow-wrap: break-word; /* Allow content to wrap within the container */
        }

        .referral_code {
            display: block; /* Force the referral code to start on a new line */
            margin-bottom: 10px; /* Add space below the referral code */
            font-size: 14px; /* Adjust font size if needed */
            color: #333; /* Optional: Set a text color */
            max-width: 100%; /* Prevent it from exceeding the container width */
        }


        @keyframes fadeInOut {
            0% { opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { opacity: 0; }
        }
        .toast {
            font-size: 16px; /* Adjust the font size as needed */
        }

        /* Ensure the main page remains scrollable when chat widget is present */
        body, html {
            overflow-y: auto !important; 
        }
    </style>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-E9JFRZR724"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-E9JFRZR724');
    </script>

</head>

<body>
   
    <!-- Preloader end -->
    <div class="dashboard__page--wrapper">
        @include('user.partial.sidebar')
        @include('user.partial.navbar')
       
        @yield('content') 
    
        @include('user.partial.footer')
        
       
        
    </div>
  

</body>

</html>
