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
                                <h2>Join Us!</h2>
                                <p>Please provide your details</p>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Steps -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="progress-steps d-flex justify-content-center">
                                <div class="step active" data-step="1">
                                    <div class="step-circle">1</div>
                                    <div class="step-label">Role</div>
                                </div>
                                <div class="step" data-step="2">
                                    <div class="step-circle">2</div>
                                    <div class="step-label">Personal Info</div>
                                </div>
                                <div class="step" data-step="3">
                                    <div class="step-circle">3</div>
                                    <div class="step-label">Password</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form id="contact-form" class="contact-form" action="{{ route('register') }}" method="POST">
                        @csrf
                        
                        <!-- Step 1: Role Selection -->
                        <div class="form-step active" id="step-1">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <label for="role" class="form-label">Signing up as?</label>
                                    <div class="input-group">
                                        <select class="form-select @error('role') is-invalid @enderror" 
                                                id="role" 
                                                name="role" 
                                                required>
                                            <option value="" disabled selected>Select</option>
                                            <option value="tutor" {{ old('role') == 'tutor' ? 'selected' : '' }}>Tutor</option>
                                            <option value="learner" {{ old('role') == 'learner' ? 'selected' : '' }}>Learner</option>
                                        </select>
                                        @error('role')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-lg-12">
                                    <button type="button" class="theme-btn style-one w-100 d-flex justify-content-between align-items-center next-step" style="border-radius: 8px">
                                        <span>Next</span>
                                        <i class="far fa-arrow-right"></i>
                                    </button>
                                </div>

                                <!-- Login Link -->
                                <div class="col-lg-12 text-center mt-3">
                                    <p class="text-muted">
                                        Already have an account? 
                                        <a href="{{ route('login') }}" class=" text-decoration-underline" style="color: #293567;">Login</a>
                                    </p>
                                </div>
                                
                            </div>
                        </div>

                        <!-- Step 2: Personal Information -->
                        <div class="form-step" id="step-2">
                            <div class="row">
                                <div style="color: #293567" class="w-100 d-flex justify-content-between align-items-center prev-step mb-3">
                                    <i class="far fa-arrow-left"></i>
                                    <span>1/2</span>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <div class="input-group">
                                        <input type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               id="name" 
                                               name="name" 
                                               value="{{ old('name') }}" 
                                               placeholder="Enter Your Full Name"
                                               required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-lg-12 mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <div class="input-group">
                                        <input type="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               id="email" 
                                               name="email" 
                                               value="{{ old('email') }}" 
                                               placeholder="Email"
                                               required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- LinkedIn URL -->
                                <div class="col-lg-12 mb-3">
                                    <label for="linkedin_url" class="form-label">LinkedIn</label>
                                    <div class="input-group">
                                        <input type="url" 
                                            class="form-control @error('linkedin_url') is-invalid @enderror" 
                                            id="linkedin_url"
                                            placeholder="Enter your LinkedIn URL" 
                                            name="linkedin_url" 
                                            value="{{ old('linkedin_url') }}" 
                                            required>
                                        @error('linkedin_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            
                                <div class="col-lg-6">
                                    <button type="button" class="theme-btn style-two w-100 d-flex justify-content-between align-items-center prev-step" style="border-radius: 8px">
                                        <i class="far fa-arrow-left"></i>
                                        <span>Back</span>
                                    </button>
                                </div>
                                <div class="col-lg-6">
                                    <button type="button" class="theme-btn style-one w-100 d-flex justify-content-between align-items-center next-step" style="border-radius: 8px">
                                        <span>Next</span>
                                        <i class="far fa-arrow-right"></i>
                                    </button>
                                </div>
                                
                                <!-- Login Link -->
                                <div class="col-lg-12 text-center mt-3">
                                    <p class="text-muted">
                                        Already have an account? 
                                        <a href="{{ route('login') }}" class="text-primary text-decoration-underline">Login</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Password -->
                        <div class="form-step" id="step-3">
                            <div class="row">
                                <div style="color: #293567" class="w-100 d-flex justify-content-between align-items-center prev-step mb-3">
                                    <i class="far fa-arrow-left"></i>
                                    <span>2/2</span>
                                </div>
                                
                               <div class="col-lg-12 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" 
                                            class="form-control @error('password') is-invalid @enderror" 
                                            id="password" 
                                            name="password" 
                                            placeholder="Enter Password"
                                            required>
                                        <span class="input-group-text toggle-password" data-target="password">
                                            <i class="far fa-eye"></i>
                                        </span>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <div class="input-group">
                                        <input type="password" 
                                            class="form-control" 
                                            id="password_confirmation" 
                                            placeholder="Enter Confirm Password"
                                            name="password_confirmation" 
                                            required>
                                        <span class="input-group-text toggle-password" data-target="password_confirmation">
                                            <i class="far fa-eye"></i>
                                        </span>
                                    </div>
                                </div>

                                <!-- Tutor Agreement Checkbox -->
                                <div class="col-lg-12 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input @error('tutor_agreement') is-invalid @enderror" 
                                            type="checkbox" 
                                            id="tutor_agreement" 
                                            name="tutor_agreement"
                                            {{ old('tutor_agreement') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tutor_agreement">
                                            I agree to the <a href="#" style="color: #293567; text-decoration: underline;">Tutor Agreement</a>
                                        </label>
                                        @error('tutor_agreement')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <button type="button" class="theme-btn style-two w-100 d-flex justify-content-between align-items-center prev-step" style="border-radius: 8px">
                                        <i class="far fa-arrow-left"></i>
                                        <span>Back</span>
                                    </button>
                                </div>
                                <div class="col-lg-6">
                                    <button type="submit" class="theme-btn style-one w-100 d-flex justify-content-between align-items-center" style="border-radius: 8px">
                                        <span>Register</span>
                                        <i class="far fa-check"></i>
                                    </button>
                                </div>
                                
                                <!-- Login Link -->
                                <div class="col-lg-12 text-center mt-3">
                                    <p class="text-muted">
                                        Already have an account? 
                                        <a href="{{ route('login') }}" class="text-primary text-decoration-underline">Login</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section><!--====== End Contact Section ======-->

<style>
    /* Add to your existing CSS */
    .form-check-input:checked {
        background-color: #293567;
        border-color: #293567;
    }

    .form-check-input.is-invalid {
        border-color: #dc3545;
    }

    .form-check {
        margin-bottom: 1rem;
    }

    .form-check-label a:hover {
        color: #1a2550;
    }
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

    .progress-steps {
        margin-bottom: 30px;
    }

    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 0 15px;
        position: relative;
    }

    .step:not(:last-child):after {
        content: '';
        position: absolute;
        top: 20px;
        left: 50%;
        width: 100%;
        height: 2px;
        background-color: #e9ecef;
        z-index: 1;
    }

    .step-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-bottom: 8px;
        position: relative;
        z-index: 2;
    }

    .step.active .step-circle {
        background-color: #293567;
        color: white;
    }

    .step-label {
        font-size: 14px;
        color: #6c757d;
    }

    .step.active .step-label {
        color: #293567;
        font-weight: 500;
    }

    .form-step {
        display: none;
    }

    .form-step.active {
        display: block;
    }

    .auth-center img {
        max-width: 80%;
        height: auto;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const formSteps = document.querySelectorAll('.form-step');
    const progressSteps = document.querySelectorAll('.step');
    const nextButtons = document.querySelectorAll('.next-step');
    const prevButtons = document.querySelectorAll('.prev-step');
    const toggleButtons = document.querySelectorAll('.toggle-password');
    let currentStep = 1;

    // Function to show a specific step
    function showStep(stepNumber) {
        formSteps.forEach(step => step.classList.remove('active'));
        document.getElementById(`step-${stepNumber}`).classList.add('active');
        
        progressSteps.forEach((step, index) => {
            if (index + 1 <= stepNumber) {
                step.classList.add('active');
            } else {
                step.classList.remove('active');
            }
        });
        
        currentStep = stepNumber;
    }

    // Next button event listeners
    nextButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (validateStep(currentStep)) {
                showStep(currentStep + 1);
            }
        });
    });

    // Previous button event listeners
    prevButtons.forEach(button => {
        button.addEventListener('click', function() {
            showStep(currentStep - 1);
        });
    });
    
    // Password toggle functionality
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

    // Function to validate each step
    function validateStep(step) {
        let isValid = true;
        
        if (step === 1) {
            const role = document.getElementById('role');
            if (!role.value) {
                role.classList.add('is-invalid');
                isValid = false;
            } else {
                role.classList.remove('is-invalid');
            }
        } else if (step === 2) {
            const fullName = document.getElementById('name');
            const linkedinUrl = document.getElementById('linkedin_url');
            const email = document.getElementById('email');
            
            // Reset previous errors
            [fullName, linkedinUrl, email].forEach(field => field.classList.remove('is-invalid'));
            
            if (!fullName.value) {
                fullName.classList.add('is-invalid');
                isValid = false;
            }
            
            if (!linkedinUrl.value) {
                linkedinUrl.classList.add('is-invalid');
                isValid = false;
            }
            
            if (!email.value || !isValidEmail(email.value)) {
                email.classList.add('is-invalid');
                isValid = false;
            }
        } else if (step === 3) {
            const password = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');
            const tutorAgreement = document.getElementById('tutor_agreement');
            const role = document.getElementById('role');
            
            // Reset previous errors
            [password, passwordConfirmation, tutorAgreement].forEach(field => {
                if (field) field.classList.remove('is-invalid');
            });
            
            if (!password.value) {
                password.classList.add('is-invalid');
                isValid = false;
            }
            
            if (!passwordConfirmation.value || password.value !== passwordConfirmation.value) {
                passwordConfirmation.classList.add('is-invalid');
                isValid = false;
            }
            
            if (role && role.value === 'tutor' && !tutorAgreement.checked) {
                tutorAgreement.classList.add('is-invalid');
                isValid = false;
            }
        }
        
        return isValid;
    }

    // Email validation function
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Initialize the form with step 1
    showStep(1);
});
</script>
@endsection