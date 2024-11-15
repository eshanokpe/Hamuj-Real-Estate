<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token --> 
    <meta name="csrf-token" content="{{ csrf_token() }}">
 
    <title>{{  $contactDetials->company_name }}</title>

    <!-- Scripts -->
    @viteReactRefresh
    @vite(['resources/js/app.js'])
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ $contactDetials->favicon }}">
    <!-- App css -->
    <link href="{{ asset('admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css/app.min.css')}}" rel="stylesheet" type="text/css" />

</head>
<body id="body" class="dark-sidebar">
    @include('admin.partial.sidebar')
    @include('admin.partial.topbar')
 
    @yield('content')
    


    @include('admin.partial.footer')

 </body> 
</html>
