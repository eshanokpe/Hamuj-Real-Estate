@extends('layouts.app')
 
@section('content')
<!--====== Start Contact Section ======-->
<section class="bizzen-contact_two pt-100 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Image Section - Only visible on lg screens and up -->
            <div class="col-xl-6 col-lg-6 d-none d-lg-block">
                <div class="auth-center">
                    <div class="d-flex align-items-center flex-column h-100 justify-content-center">
                        <img src="{{ asset('assets/admin/images/auth/auth-img.png')}}" alt="Authentication" class="img-fluid">
                    </div>
                </div>
            </div>
            
            <!-- Form Section - Full width on mobile, half on desktop -->
            <div class="col-xl-6 col-lg-8 col-md-10">
                <!--=== Contact Wrapper ===-->
                <div class="contact-wrapper" data-aos="fade-left" data-aos-duration="1400">
                  
                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Error Messages -->
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <!--=== Section Title ===-->
                            <div class="section-title text-center mb-50">
                                <div class="site-branding">
                                    <a href="{{ route('index') }}" class="brand-logo">
                                        <img src="{{ asset('assets/images/home-three/logo/logo-main.png')}}" style="width:60px" alt="Brand Logo">
                                    </a>
                                </div>
                                <h2>Welcome Back!</h2>
                                <p>Login to your account</p>
                            </div>
                        </div>
                    </div>

                    <form id="login-form" class="contact-form" action="{{ route('login') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="far fa-envelope"></i>
                                    </span>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           placeholder="Enter your email"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-lg-12 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="far fa-lock"></i>
                                    </span>
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Enter your password"
                                           required>
                                    <span class="input-group-text toggle-password" data-target="password">
                                        <i class="far fa-eye"></i>
                                    </span>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Remember Me -->
                            <div class="col-lg-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="remember" 
                                           name="remember" 
                                           {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Remember me
                                    </label>
                                </div>
                            </div>

                            <!-- Forgot Password -->
                            <div class="col-lg-12 mb-4">
                                <div class="d-flex justify-content-end">
                                    <a style="color: #293567; font-weight:300" href="{{ route('password.request') }}" class=" text-decoration-none" >
                                        Forgot Password?
                                    </a>
                                </div>
                            </div>
                            
                            <div class="col-lg-12 mb-3">
                                <button type="submit" class="theme-btn style-one w-100 d-flex justify-content-center align-items-center" style="border-radius: 8px">
                                    <span>Login</span>
                                    <i class="far fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                            
                            <!-- Register Link -->
                            <div class="col-lg-12 text-center mt-3">
                                <p class="text-muted">
                                    Don't have an account? 
                                    <a style="color: #293567; font-weight:300" href="{{ route('register') }}" class=" text-decoration-underline">Register</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section><!--====== End Contact Section ======-->

<style>
    .toggle-password {
        cursor: pointer;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-left: none;
    }

    .toggle-password:hover {
        background-color: #f8f9fa;
    }

    .input-group .form-control:not(:last-child) {
        border-right: 0;
    }

    .input-group .toggle-password {
        border-left: 0;
    }

    .input-group-text {
        background-color: #fff;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password toggle functionality
    const toggleButtons = document.querySelectorAll('.toggle-password');
    
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const passwordInput = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
});
</script>
@endsection