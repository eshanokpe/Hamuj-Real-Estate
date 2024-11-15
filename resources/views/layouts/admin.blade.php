<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token --> 
    <meta name="csrf-token" content="{{ csrf_token() }}">
 
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @viteReactRefresh
    @vite(['resources/js/app.js'])
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png')}}">
    <!-- App css -->
    <link href="{{ asset('admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css/app.min.css')}}" rel="stylesheet" type="text/css" />

</head>
<body id="body" class="dark-sidebar">
    @include('admin.partial.sidebar')
    @include('admin.partial.topbar')
 
    @yield('content')
    <!-- Javascript  -->   
    <script src="{{ asset('admin/plugins/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{ asset('admin/pages/analytics-index.init.js')}}"></script>
    <script src="{{ asset('admin/plugins/datatables/simple-datatables.js')}}"></script>
    <script src="{{ asset('admin/pages/datatable.init.js')}}"></script>


    <!--Start Footer-->
        <!-- Footer Start -->
        <footer class="footer text-center text-sm-start">
            &copy; <script>
                document.write(new Date().getFullYear())
            </script> Powered By  <span class="text-muted d-none d-sm-inline-block float-end">Dohmayn</span>
        </footer>
        <!-- end Footer -->                
        <!--end footer-->
    <!-- App js -->
    <script src="{{ asset('admin/js/app.js')}}"></script>
     
 </body>
</html>
