<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png')}}">
    <!-- App css -->
    <link href="{{ asset('admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css/app.min.css')}}" rel="stylesheet" type="text/css" />

</head>

<body id="body" class="auth-page" style="background-image: url('{{ asset('admin/images/p-1.png')}}'); background-size: cover; background-position: center center;">
   <!-- Log In page -->
    <div class="container-md">
        <div class="row vh-100 d-flex justify-content-center">
            <div class="col-12 align-self-center">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mx-auto">
                            <div class="card">
                                <a href="{{ route('admin.login') }}" class="logo logo-admin text-center">
                                    <img src="{{ asset('assets/img/logo/nav-log.png')}}" height="50" alt="logo" class="auth-logo">
                                </a>
                                <div class="card-body p-0 auth-header-box">
                                    <div class="text-center p-3">
                                        
                                        <h4 class="mt-3 mb-1 fw-semibold text-white font-18"> Dohmayn Admin</h4>   
                                        <p class="text-muted  mb-0">Log in to access to Admin.</p>  
                                    </div>
                                </div>
                                @if(session('success'))
                                    <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <div class="card-body pt-0"> 
                                    <form class="my-4" action="{{route('admin.login.submit')}}" method="POST">
                                        @csrf           
                                        <div class="form-group mb-2">
                                            <label class="form-label" for="username">Email</label>
                                            <input type="email" class="form-control " id="email" name="email" placeholder="Enter email" autocomplete="email" autofocus required>                               
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div><!--end form-group--> 
                                        
                                        <div class="form-group">
                                            <label class="form-label" for="userpassword">Password</label>                                            
                                            <input type="password" class="form-control" name="password" id="userpassword" placeholder="Enter password" autocomplete="password" autofocus required>                           
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div><!--end form-group--> 
            
                                        
                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <div class="d-grid mt-3">
                                                    <button class="btn btn-primary" style="background-color: #47008E" type="submit">Log In <i class="fas fa-sign-in-alt ms-1"></i></button>
                                                </div>
                                            </div><!--end col--> 
                                        </div> <!--end form-group-->                           
                                    </form><!--end form-->
                                    
                                    <hr class="hr-dashed mt-4">
                                  
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end card-body-->
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->

    <!-- App js -->
    <script src="{{ asset('admin/js/app.js')}}"></script>
    
</body>


<!-- Mirrored from themes.getappui.com/collab/unikit/default/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 09 Nov 2024 16:03:15 GMT -->
</html>