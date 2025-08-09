@extends('layouts.app')

@section('content')
<!-- Breadcrumb section (keeping your original classes) -->
<section class="breadcrumb__section section--padding">
    <div class="container">
        <div class="breadcrumb__content text-center">
            <h1 class="breadcrumb__title h2">Registration</h1>
            <ul class="breadcrumb__menu d-flex justify-content-center">
                <li class="breadcrumb__menu--items">
                    <a class="breadcrumb__menu--link" href="{{ url('/')}}">Home</a>
                </li>
                <li> 
                    <span class="breadcrumb__separator">
                        <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.22321 4.65179C5.28274 4.71131 5.3125 4.77976 5.3125 4.85714C5.3125 4.93452 5.28274 5.00298 5.22321 5.0625L1.0625 9.22321C1.00298 9.28274 0.934524 9.3125 0.857143 9.3125C0.779762 9.3125 0.71131 9.28274 0.651786 9.22321L0.205357 8.77679C0.145833 8.71726 0.116071 8.64881 0.116071 8.57143C0.116071 8.49405 0.145833 8.4256 0.205357 8.36607/L3.71429 4.85714L0.205357 1.34821C0.145833 1.28869 0.116071 1.22024 0.116071 1.14286C0.116071 1.06548 0.145833 0.997023 0.205357 0.9375/L0.651786 0.491071C0.71131 0.431547 0.779762 0.401785 0.857143 0.401785C0.934524 0.401785 1.00298 0.431547 1.0625 0.491071/L5.22321 4.65179Z" fill="#706C6C"/>
                        </svg>
                    </span>
                </li>
                <li>
                    <span class="breadcrumb__menu--text">Register</span>
                </li>
            </ul>
        </div>
    </div>
</section>

<!-- Registration Section -->
<section class="account__page--section section--padding">
    <div class="container">
        <div class="account__section--inner">
            <div class="account__tab--btn">
                <ul class="account__tab--btn__wrapper d-flex justify-content-center">
                    <li class="account__tab--btn__items">
                        <span class="account__tab--btn__field active">Register</span>
                    </li>
                    <li class="account__tab--btn__items">
                        <a class="account__tab--btn__field" href="{{ route('login') }}">Login</a>
                    </li>
                </ul>
            </div>
            
           <div class="account__form--wrapper">
                <div class="account__header text-center mb-30">
                    <h2 class="account__title">Secure Registration</h2>
                    <p class="account__desc">Complete your registration with our secure verification process</p>
                </div>
                
                <!-- Progress Indicator -->
                <div class="registration-progress mb-4">
                    <div class="progress-steps">
                        <div class="progress-step active" data-step="1">
                            <div class="step-number">1</div>
                            <div class="step-label">Basic Info</div>
                        </div>
                        <div class="progress-step" data-step="2">
                            <div class="step-number">2</div>
                            <div class="step-label">ID Verification</div>
                        </div>
                        <div class="progress-step" data-step="3">
                            <div class="step-number">3</div>
                            <div class="step-label">Password</div>
                        </div>
                    </div>
                </div>

                <form id="registrationForm" method="POST" action="{{ route('post.register') }}">
                    @csrf
                    <!-- Step 1: Basic Information -->
                    <div class="registration-step active" id="step-1">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="first_name">First Name</label>
                                <input id="firstname" type="text" class="account__form--input__field @error('first_name') is-invalid @enderror" 
                                        name="firstname" value="{{ old('first_name') }}" placeholder="Enter your first name" required>
                                @error('firstname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="last_name">Last Name</label>
                                <input id="lastname" type="text" class="account__form--input__field @error('last_name') is-invalid @enderror" 
                                        name="lastname" value="{{ old('last_name') }}" placeholder="Enter your last name" required>
                                @error('lastname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Email Field -->
                        <div class="mb-3">
                            <label class="form-label" for="email">Email Address</label>
                            <input id="email" type="email" class="account__form--input__field @error('email') is-invalid @enderror" 
                                    name="email" value="{{ old('email') }}" placeholder="your@email.com" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Phone Field -->
                        <div class="mb-3">
                            <label class="form-label" for="phone">Phone Number</label>
                            <input id="phone" type="tel" class="account__form--input__field @error('phone') is-invalid @enderror" 
                                   name="phone" value="{{ old('phone') }}" placeholder="0800 000 0000" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <input type="hidden" name="registration_source" value="web">
                        
                        <div class="d-grid gap-2">
                            <button type="button" class="account__form--btn solid__btn" id="sendVerificationCode">
                                Send Verification Code
                            </button>
                        </div>
                        
                        <!-- OTP Verification --> 
                        <div id="otpVerification" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label" for="verification_code">Verification Code</label>
                                <input id="verification_code" type="text" class="account__form--input__field" 
                                       name="otp" placeholder="Enter 6-digit code" required maxlength="6" pattern="\d{6}" placeholder="123456">
                                <div class="d-flex justify-content-between mt-2">
                                    <small class="text-muted" id="otpTimer">Code expires in: 03:00</small>
                                    <button type="button" class="btn btn-link p-0 text-decoration-none" id="resendCodeBtn" disabled>
                                        Resend Code
                                    </button>
                                </div>
                            </div>
                            <div class="success_message"></div>
                            <div class="d-grid gap-2">
                                <button type="button" class="account__form--btn solid__btn" id="verifyCodeBtn">
                                    Verify Code
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: ID Verification -->
                    <div class="registration-step" id="step-2">
                        <div class="id-verification">
                            <div class="verification-method mb-3">
                                <label class="form-label">ID Verification Method</label>
                                <div class="verification-toggle btn-group" role="group">
                                    <button type="button" class="btn btn-outline-primary active" data-id-method="bvn">BVN</button>
                                    <button type="button" class="btn btn-outline-primary" data-id-method="nin">NIN</button>
                                </div>
                                <input type="hidden" name="verification_method" id="idVerificationMethod" value="bvn">
                            </div>
                            
                            <!-- BVN Field -->
                            <div class="mb-3 id-verification-field" id="bvnField">
                                <label class="form-label" for="bvn">Bank Verification Number</label>
                                <input id="bvn" type="text" class="account__form--input__field @error('bvn') is-invalid @enderror" 
                                    name="bvn" value="{{ old('bvn') }}" placeholder="Enter 11-digit BVN" maxlength="11" >
                                @error('bvn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Your BVN will be used for identity verification</small>
                            </div>
                            <!-- NIN Field -->
                            <div class="mb-3 id-verification-field" id="ninField" style="display: none;">
                                <label class="form-label" for="nin">National Identity Number</label>
                                <input id="nin" type="text" class="account__form--input__field @error('nin') is-invalid @enderror" 
                                    name="nin" value="{{ old('nin') }}" placeholder="Enter 11-digit NIN" maxlength="11" >
                                @error('nin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Your NIN will be used for identity verification</small>
                            </div>
                            <div class="success_message"></div>
                            
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary prev-step" data-prev="1">
                                    <i class="fas fa-arrow-left me-2"></i>Back
                                </button>
                                <button type="button"  class="btn btn-primary  next-step" data-next="3" id="verifyBvnBtn">
                                    Continue<i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 3: Password Setup -->
                    <div class="registration-step" id="step-3">
                        <div class="password-setup">
                            <div class="mb-3">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                        name="password" placeholder="Create password" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="password-strength mt-2">
                                    <div class="progress mb-2" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <div class="password-requirements">
                                        <small class="d-block mb-1">Password Requirements:</small>
                                        <ul class="list-unstyled">
                                            <li class="requirement" data-requirement="length">
                                                <i class="fas fa-circle me-2" style="font-size: 6px; vertical-align: middle;"></i>
                                                At least 8 characters
                                            </li>
                                            <li class="requirement" data-requirement="uppercase">
                                                <i class="fas fa-circle me-2" style="font-size: 6px; vertical-align: middle;"></i>
                                                1 uppercase letter
                                            </li>
                                            <li class="requirement" data-requirement="lowercase">
                                                <i class="fas fa-circle me-2" style="font-size: 6px; vertical-align: middle;"></i>
                                                1 lowercase letter
                                            </li>
                                            <li class="requirement" data-requirement="number">
                                                <i class="fas fa-circle me-2" style="font-size: 6px; vertical-align: middle;"></i>
                                                1 number
                                            </li>
                                            <li class="requirement" data-requirement="special">
                                                <i class="fas fa-circle me-2" style="font-size: 6px; vertical-align: middle;"></i>
                                                1 special character
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label" for="password-confirm">Confirm Password</label>
                                <div class="input-group">
                                    <input id="password-confirm" type="password" class="form-control" 
                                        name="password_confirmation" placeholder="Confirm password" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div id="passwordMatch" class="mt-1"></div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label" for="referral_code">Referral Code (Optional)</label>
                                <input id="referral_code" type="text" class="form-control @error('referral_code') is-invalid @enderror" 
                                    name="referral_code" value="{{ old('referral_code', $referralCode) }}" placeholder="Enter referral code">
                                @error('referral_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="#" class="text-decoration-none">Terms of Service</a> and 
                                        <a href="#" class="text-decoration-none">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary prev-step" data-prev="2">
                                    <i class="fas fa-arrow-left me-2"></i>Back
                                </button>
                                <button type="submit" class="btn btn-primary" id="completeRegistration">
                                    Complete Registration
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            
                    
                <script>
                $(document).ready(function() {
                    // Initialize steps
                    $('.registration-step').hide();
                    $('#step-1').show();
                    
                    // Toggle password visibility
                    $('.toggle-password').click(function() {
                        const input = $(this).siblings('input');
                        const icon = $(this).find('i');
                        if (input.attr('type') === 'password') {
                            input.attr('type', 'text');
                            icon.removeClass('fa-eye').addClass('fa-eye-slash');
                        } else {
                            input.attr('type', 'password');
                            icon.removeClass('fa-eye-slash').addClass('fa-eye');
                        }
                    });
                    
                    // ID verification method toggle
                    $('.verification-toggle button[data-id-method]').click(function() {
                        const method = $(this).data('id-method');
                        $('.verification-toggle button').removeClass('active');
                        $(this).addClass('active');
                        $('#idVerificationMethod').val(method);
                        
                        $('.id-verification-field').hide();
                        $(`#${method}Field`).show();
                    });
                    
                    // Function to mask email
                    function maskEmail(email) {
                        const [name, domain] = email.split('@');
                        const maskedName = name.substring(0, 2) + '*'.repeat(name.length - 2);
                        return maskedName + '@' + domain;
                    }
                    
                    // Function to mask phone
                    function maskPhone(phone) {
                        return phone.substring(0, 4) + '****' + phone.substring(phone.length - 3);
                    }
                    
                    // Function to send OTP
                    function sendOtp(email, phone) {
                        $('#sendVerificationCode').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status"></span>Sending...');
                        
                        // Disable the input fields
                        $('#email').prop('disabled', true);
                        $('#phone').prop('disabled', true);

                        $.ajax({
                            url: '{{ route("send-otp") }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                email: email,
                                phone: phone
                            },
                           success: function(response) {
                                console.log(response.message);
                                if (response.success) {
                                    $('#sendVerificationCode').hide();
                                    $('#otpVerification').show();
                                    startOtpTimer();
                                    const message = 'Verification code sent to your email and phone';
                                    toastr.success(message, 'Success');
                                    showAlert('success', message);
                                } else {
                                    $('#email').prop('disabled', false);
                                    $('#phone').prop('disabled', false);
                                    toastr.error(response.message || 'Failed to send OTP', 'Error');
                                    showAlert('danger', response.message || 'Failed to send OTP');
                                }
                            },
                            error: function(xhr) {
                                console.log(xhr);
                                $('#email').prop('disabled', false);
                                $('#phone').prop('disabled', false);

                                let errorMessage = 'Error sending OTP';

                                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                                    // Extract first error message
                                    const errors = xhr.responseJSON.errors;
                                    const firstKey = Object.keys(errors)[0];
                                    errorMessage = errors[firstKey][0];
                                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }

                                toastr.error(errorMessage, 'Error');
                                showAlert('danger', errorMessage);
                            },

                            complete: function() {
                                $('#sendVerificationCode').prop('disabled', false).html('Send Verification Code');
                            }
                        });
                    }
                    
                    // Function to verify OTP
                    function verifyOtp(otp) {
                        $('#verifyCodeBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status"></span>Verifying...');
                        
                        // Get the email and phone values from the form
                        const email = $('#email').val().trim();
                        const phone = $('#phone').val().trim();

                        $.ajax({
                            url: '{{ route("verify-otp") }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                otp: otp,
                                email: email,
                                phone: phone
                            },
                            success: function(response) {
                                if (response.success) {
                                    // On successful verification
                                    $('.registration-step').hide();
                                    $('#step-2').show();
                                    updateProgress(2);
                                    clearOtpTimer();
                                    toastr.success('Verification successful!', 'Success');
                                    showAlert('success', 'Verification successful!');
                                } else {
                                    // Set the error message once
                                    const errorMessage = response.message || 'The verification code you entered is invalid. Please try again.';

                                    // Show toast notification (floating message)
                                    toastr.error(errorMessage, 'Verification Failed', {
                                        timeOut: 5000,
                                        closeButton: true,
                                        progressBar: true
                                    });
                                    showAlert('danger', response.message || 'Invalid verification code');
                                }
                            },
                            error: function(xhr) {
                                let errorMessage = 'Error verifying OTP';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                showAlert('danger', errorMessage);
                            },
                            complete: function() {
                                $('#verifyCodeBtn').prop('disabled', false).text('Verify Code');
                            }
                        });
                    }
                    
                    // Function to verify BVN
                    function verifyBvn(bvn, firstName, lastName) {
                        $('#verifyBvnBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status"></span>Verifying...');
                        
                        $.ajax({
                            url: '{{ route("verify-bvn") }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                bvn: bvn,
                                firstname: firstName,
                                lastname: lastName
                            },
                            success: function(response) {
                                if (response.status === true && response.data) {
                                    const userData = response.data;
                                    console.log('BVN Verification Success:', userData);
                                    
                                    // Extract verified data
                                    const verifiedData = {
                                        firstName: userData.firstName || firstName,
                                        lastName: userData.lastName || lastName,
                                        middleName: userData.middleName || '',
                                        dob: userData.dateOfBirth || '',
                                        phone: userData.phoneNumber || ''
                                    };

                                    // Update form fields
                                    $('#firstname').val(verifiedData.firstName);
                                    $('#lastname').val(verifiedData.lastName);
                                    
                                    // Build modal content
                                    const modalContent = `
                                        <div class="text-center mb-4">
                                            <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                                            <h4 class="mt-3">BVN Verified Successfully</h4>
                                        </div>
                                        <div class="verification-details">
                                            ${buildDetailRow('First Name', verifiedData.firstName)}
                                            ${verifiedData.middleName ? buildDetailRow('Middle Name', verifiedData.middleName) : ''}
                                            ${buildDetailRow('Last Name', verifiedData.lastName)}
                                        </div>
                                    `;

                                    // Safely handle modal
                                    const modalElement = document.getElementById('verificationSuccessModal');
                                    if (!modalElement) {
                                        console.error('Modal element not found - creating fallback');
                                        // Fallback: proceed to next step
                                        proceedToPasswordStep();
                                        return;
                                    }

                                    // Update modal content
                                    $('#verificationSuccessModal .modal-body').html(modalContent);
                                    
                                    // Initialize or get existing modal instance
                                    const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                                    modal.show();
                                    
                                    // Store verification data
                                    $('input[name="bvn_verified"]').val('true');
                                    $('input[name="verified_data"]').val(JSON.stringify(verifiedData));

                                    toastr.success('BVN verification successful!', 'Success');
                                    
                                } else {
                                    handleVerificationError(response);
                                }
                            },
                            error: function(xhr) {
                                handleVerificationError(xhr.responseJSON || { 
                                    message: xhr.statusText || 'Network error occurred' 
                                });
                            },
                            complete: function() {
                                $('#verifyBvnBtn').prop('disabled', false).html('Continue<i class="fas fa-arrow-right ms-2"></i>');
                            }
                        });
                    }

                    // Error handling function
                    function handleVerificationError(errorResponse) {
                        let errorMessage = errorResponse.message || 'BVN verification failed';
                        
                        if (errorResponse.errors) {
                            errorMessage = Object.values(errorResponse.errors)[0][0];
                        } else if (errorResponse.data && errorResponse.data.message) {
                            errorMessage = errorResponse.data.message;
                        }
                        
                        showAlert('danger', errorMessage);
                        $('#bvn').addClass('is-invalid').focus();
                        toastr.error(errorMessage, 'Verification Failed');
                    }

                    // Format date for display (12-Oct-1994 → Oct 12, 1994)
                    function formatDobDisplay(dobString) {
                        if (!dobString) return '';
                        try {
                            const parts = dobString.split('-');
                            if (parts.length === 3) {
                                return `${parts[1]} ${parts[0]}, ${parts[2]}`;
                            }
                            return dobString;
                        } catch (e) {
                            return dobString;
                        }
                    }

                    // Format phone number for display (08139267960 → 0813 926 7960)
                    function formatPhoneDisplay(phone) {
                        if (!phone) return '';
                        return phone.replace(/(\d{4})(\d{3})(\d{4})/, '$1 $2 $3');
                    }

                    // Format date for form input (12-Oct-1994 → 1994-10-12)
                    function formatDate(dobString) {
                        if (!dobString) return '';
                        try {
                            const months = {
                                'Jan': '01', 'Feb': '02', 'Mar': '03', 'Apr': '04',
                                'May': '05', 'Jun': '06', 'Jul': '07', 'Aug': '08',
                                'Sep': '09', 'Oct': '10', 'Nov': '11', 'Dec': '12'
                            };
                            
                            const parts = dobString.split('-');
                            if (parts.length === 3) {
                                const day = parts[0].padStart(2, '0');
                                const month = months[parts[1]] || '01';
                                const year = parts[2];
                                return `${year}-${month}-${day}`;
                            }
                            return dobString;
                        } catch (e) {
                            return dobString;
                        }
                    }

                    // Helper function to build detail rows
                    function buildDetailRow(label, value) {
                        return `
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-bold">${label}:</span>
                                <span>${value}</span>
                            </div>
                        `;
                    }

                    // Proceed to password step
                    function proceedToPasswordStep() {
                        $('.registration-step').hide();
                        $('#step-3').show();
                        updateProgress(3);
                        $('#password').focus();
                    }

                    // Modal next button handler
                    $(document).on('click', '#proceedToNextStep', function() {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('verificationSuccessModal'));
                        if (modal) {
                            modal.hide();
                        }
                        proceedToPasswordStep();
                    });

                    // Updated modal next button handler
                    $(document).on('click', '#proceedToNextStep', function() {
                        const modalElement = document.getElementById('verificationSuccessModal');
                        if (modalElement) {
                            const modal = bootstrap.Modal.getInstance(modalElement);
                            if (modal) {
                                modal.hide();
                            }
                        }
                        $('.registration-step').hide();
                        $('#step-3').show();
                        updateProgress(3);
                        $('#password').focus();
                    });

                    // Add this event handler for the modal's next button
                    $(document).on('click', '#proceedToNextStep', function() {
                        // Hide the modal
                        const successModal = bootstrap.Modal.getInstance(document.getElementById('verificationSuccessModal'));
                        successModal.hide();
                        
                        // Proceed to next step
                        $('.registration-step').hide();
                        $('#step-3').show();
                        updateProgress(3);
                        
                        // Focus on password field for better UX
                        $('#password').focus();
                    });

                    // Function to verify NIN
                    function verifyNin(bvn, firstName, lastName) {
                        $('#verifyBvnBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status"></span>Verifying...');
                        
                        $.ajax({
                            url: '{{ route("verify-nin") }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                nin: bvn,
                                firstname: firstName,
                                lastname: lastName
                            },
                            success: function(response) {
                                if (response.success === true || response.status === true) {
                                    const userData = response.data;
                                    console.log('NIN Verification Success:', userData);
                                    // Check if data is masked (contains ***)
                                    if (isDataMasked(userData)) {
                                        showSuspendedNinModal();
                                        return;
                                    }
                                    // Extract verified data
                                    const verifiedData = {
                                        firstName: userData.firstname || firstName,
                                        lastName: userData.surname || lastName,
                                        middleName: userData.middlename || '',
                                    };

                                     // Update form fields
                                    $('#firstname').val(verifiedData.firstName);
                                    $('#lastname').val(verifiedData.lastName);
                                    
                                    // Build modal content
                                    const modalContent = `
                                        <div class="text-center mb-4">
                                            <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                                            <h4 class="mt-3">NIN Verified Successfully</h4>
                                        </div>
                                        <div class="verification-details">
                                            ${buildDetailRow('First Name', verifiedData.firstName)}
                                            ${verifiedData.middleName ? buildDetailRow('Middle Name', verifiedData.middleName) : ''}
                                            ${buildDetailRow('Last Name', verifiedData.lastName)}
                                        </div>
                                    `;

                                    // Safely handle modal
                                    const modalElement = document.getElementById('verificationSuccessModal');
                                    if (!modalElement) {
                                        console.error('Modal element not found - creating fallback');
                                        // Fallback: proceed to next step
                                        proceedToPasswordStep();
                                        return;
                                    }

                                    // Update modal content
                                    $('#verificationSuccessModal .modal-body').html(modalContent);
                                    
                                    // Initialize or get existing modal instance
                                    const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                                    modal.show();
                                    
                                    // Store verification data
                                    $('input[name="bvn_verified"]').val('true');
                                    $('input[name="verified_data"]').val(JSON.stringify(verifiedData));


                                    toastr.success(response.message || 'NIN verification successful!', 'Success');
                                    
                                    showAlert('success', response.message || 'BVN verification successful!');
                                } else {
                                    showAlert('danger', response.message || 'BVN verification failed');
                                }
                            },
                            error: function(xhr) {
                                let errorMessage = 'Error verifying BVN';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                showAlert('danger', errorMessage);
                            },
                            complete: function() {
                                $('#verifyBvnBtn').prop('disabled', false).html('Continue<i class="fas fa-arrow-right ms-2"></i>');
                            }
                        });
                    }
                    
                    // Send verification code
                    $('#sendVerificationCode').click(function() {
                        const email = $('#email').val().trim();
                        const phone = $('#phone').val().trim();
                        
                        if (!email || !phone) {
                            showAlert('error', 'Please enter both email and phone number');
                            return;
                        }
                        
                        if (!validateEmail(email)) {
                            showAlert('error', 'Please enter a valid email address');
                            return;
                        }
                        
                        if (!validatePhone(phone)) {
                            showAlert('error', 'Please enter a valid phone number');
                            return;
                        }
                        
                        sendOtp(email, phone);
                    });
                    
                    // Verify code
                    $('#verifyCodeBtn').click(function() {
                        const code = $('#verification_code').val().trim();
                        
                        if (!code || code.length !== 6) {
                            showAlert('error', 'Please enter a valid 6-digit verification code');
                            return;
                        }
                        
                        verifyOtp(code);
                    });
                    
                    // Resend code
                    $('#resendCodeBtn').click(function() {
                        const email = $('#email').val().trim();
                        const phone = $('#phone').val().trim();
                        
                        $(this).prop('disabled', true);
                        clearOtpTimer();
                        startOtpTimer();
                        
                        sendOtp(email, phone);
                    });
                    
                    // Next step handler for BVN verification
                    $('#verifyBvnBtn').click(function() {
                        const method = $('#idVerificationMethod').val();
                        const value = $(`#${method}`).val().trim();
                        const firstName = $('#firstname').val().trim();
                        const lastName = $('#lastname').val().trim();
                        if (!value) {
                            showAlert('error', `Please enter your ${method.toUpperCase()}`);
                            return;
                        }
                        
                        if (value.length !== 11) {
                            showAlert('error', `${method.toUpperCase()} must be 11 digits`);
                            return;
                        }
                        
                        if (method === 'bvn') {
                            verifyBvn(value, firstName, lastName);
                        } else if(method == 'nin') {
                            verifyNin(value, firstName, lastName);
                        }
                    });
                    
                    // Previous step handler
                    $('.prev-step').click(function() {
                        const prevStep = $(this).data('prev');
                        $('.registration-step').hide();
                        $(`#step-${prevStep}`).show();
                        updateProgress(prevStep);
                    });
                    
                    // Password strength checker
                    $('#password').on('input', function() {
                        const password = $(this).val();
                        checkPasswordStrength(password);
                    });
                    
                    // Password match checker
                    $('#password-confirm').on('input', function() {
                        const password = $('#password').val();
                        const confirmPassword = $(this).val();
                        
                        if (!confirmPassword) {
                            $('#passwordMatch').html('');
                            return;
                        }
                        
                        if (password === confirmPassword) {
                            $('#passwordMatch').html('<small class="text-success"><i class="fas fa-check-circle me-1"></i>Passwords match</small>');
                        } else {
                            $('#passwordMatch').html('<small class="text-danger"><i class="fas fa-times-circle me-1"></i>Passwords do not match</small>');
                        }
                    });
                    
                    // Form submission
                    $('#registrationForm').submit(function(e) {
                        e.preventDefault();
                        
                        // Validate all required fields
                        const email = $('#email').val().trim();
                        const phone = $('#phone').val().trim();
                        
                        if (!email || !phone) {
                            showAlert('error', 'Email and phone are required');
                            return;
                        }

                        if (!$('#terms').is(':checked')) {
                            showAlert('error', 'Please agree to the Terms of Service and Privacy Policy');
                            return;
                        }
                        
                        const password = $('#password').val();
                        const confirmPassword = $('#password-confirm').val();
                        
                        if (password !== confirmPassword) {
                            showAlert('error', 'Passwords do not match');
                            return;
                        }

                        // Collect ALL form data including hidden fields
                        const formData = new FormData(this);
                        
                        // Manually append fields that might be missing
                        formData.append('email', email);
                        formData.append('phone', phone);
                        
                        $('#completeRegistration').prop('disabled', true)
                            .html('<span class="spinner-border spinner-border-sm me-2" role="status"></span>Processing...');

                        $.ajax({
                            url: $(this).attr('action'),
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                console.log('Registration success:', response);
                                
                                // Always enable the button first
                                $('#completeRegistration').prop('disabled', false).text('Complete Registration');
                                
                                // Handle success response
                                if (response.success) {
                                    // Show success message (from response or default)
                                    // const successMsg = response.message || 'Registration successful! Redirecting to dashboard...';
                                    // toastr.success(successMsg, 'Success');
                                    
                                    // Store any important data in localStorage if needed
                                    // if (response.token) {
                                    //     localStorage.setItem('authToken', response.token);
                                    // }
                                     
                                    // Clear form if needed
                                    $('form')[0].reset();
                                    
                                    // Redirect after delay
                                    setTimeout(function() {
                                        // Check if user data exists in response for redirection
                                        window.location.href = 'dashboard';
                                    }, 2000);
                                    
                                } else if (response.error) {
                                    // Handle success response that contains warnings/errors
                                    showAlert('error', response.error);
                                } else {
                                    // Fallback for unexpected success responses
                                    toastr.success('Registration completed successfully', 'Success');
                                    setTimeout(() => window.location.href = 'dashboard', 2000);
                                }
                            },
                            
                            error: function(xhr) {
                                // console.error('Registration error:', xhr);
                                $('#completeRegistration').prop('disabled', false).text('Complete Registration');
                                
                                let errorMessage = 'Registration failed. Please try again.';
                                
                                if (xhr.responseJSON) {
                                    // 1. Check for field-specific errors first
                                    if (xhr.responseJSON.errors) {
                                        // Get the first error message from the errors object
                                        const firstErrorField = Object.keys(xhr.responseJSON.errors)[0];
                                        errorMessage = xhr.responseJSON.errors[firstErrorField][0];
                                        
                                        // Highlight the problematic field
                                        $(`#${firstErrorField}`).addClass('is-invalid');
                                    } 
                                    // 2. Fall back to general message
                                    else if (xhr.responseJSON.message) {
                                        errorMessage = xhr.responseJSON.message;
                                    }
                                }

                                toastr.error(errorMessage, 'Error', {
                                    timeOut: 5000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: 'toast-top-right'
                                });
                                
                                if (errorMessage.toLowerCase().includes('email') && errorMessage.toLowerCase().includes('taken')) {
                                    $('#email').val('').focus();
                                }
                            }
                        });
                    });

                    // Check if NIN data is masked/suspended
                    function isDataMasked(userData) {
                        return (
                            userData.firstname === '***' || 
                            userData.surname === '***' || 
                            userData.title === '***'
                        );
                    }
                    // Show suspended NIN modal
                    function showSuspendedNinModal() {
                        const modalContent = `
                            <div class="text-center mb-4">
                                <i class="fas fa-exclamation-triangle text-warning" style="font-size: 4rem;"></i>
                                <h4 class="mt-3">NIN Suspended</h4>
                            </div>
                            <div class="alert alert-warning">
                                <p>Your NIN has been suspended. Please visit the nearest NIMC Enrollment Center for resolution.</p>
                                <p class="mb-0">Alternatively, you may use your BVN for verification.</p>
                            </div>
                            <div class="d-grid gap-2 mt-3">
                                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                                    Use BVN Instead
                                </button>
                            </div>
                        `;

                        const modalElement = document.getElementById('verificationSuccessModal');
                        if (modalElement) {
                            $('#verificationSuccessModal .modal-body').html(modalContent);
                            const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                            modal.show();
                        } else {
                            // Fallback alert if modal doesn't exist
                            alert('Your NIN has been suspended. Please visit the nearest NIMC Enrollment Center or use BVN instead.');
                            // Optionally switch to BVN verification
                            $('.verification-toggle button[data-id-method="bvn"]').click();
                        }
                    }

                    // Helper functions
                    function validateEmail(email) {
                        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        return re.test(email);
                    }
                    
                    function validatePhone(phone) {
                        const re = /^\+?[\d\s-]{10,15}$/;
                        return re.test(phone);
                    }
                    
                    function startOtpTimer() {
                        let timeLeft = 180;
                        $('#resendCodeBtn').prop('disabled', true);
                        
                        window.otpTimer = setInterval(function() {
                            timeLeft--;
                            
                            const minutes = Math.floor(timeLeft / 60);
                            const seconds = timeLeft % 180;
                            
                            $('#otpTimer').text(`Code expires in: ${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`);
                            
                            if (timeLeft <= 0) {
                                clearInterval(window.otpTimer);
                                $('#resendCodeBtn').prop('disabled', false);
                            }
                        }, 1000);
                    }
                    
                    function clearOtpTimer() {
                        clearInterval(window.otpTimer);
                        $('#otpTimer').text('Code expires in: 01:00');
                    }
                    
                    function updateProgress(step) {
                        $('.progress-step').removeClass('active');
                        $(`.progress-step[data-step="${step}"]`).addClass('active');
                        
                        if (step > 1) {
                            $(`.progress-step[data-step="${step - 1}"]`).addClass('completed');
                        }
                    }
                    
                    function checkPasswordStrength(password) {
                        const requirements = {
                            length: password.length >= 8,
                            uppercase: /[A-Z]/.test(password),
                            lowercase: /[a-z]/.test(password),
                            number: /[0-9]/.test(password),
                            special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
                        };
                        
                        // Update requirement indicators
                        Object.keys(requirements).forEach(key => {
                            const element = $(`.requirement[data-requirement="${key}"] i`);
                            if (requirements[key]) {
                                element.css('color', '#28a745');
                            } else {
                                element.css('color', '#dc3545');
                            }
                        });
                        
                        // Calculate strength
                        const strength = Object.values(requirements).filter(Boolean).length;
                        const percentage = (strength / 5) * 100;
                        
                        // Update progress bar
                        const $progressBar = $('.progress-bar');
                        $progressBar.css('width', `${percentage}%`);
                        
                        if (percentage <= 40) {
                            $progressBar.removeClass('bg-warning bg-success').addClass('bg-danger');
                        } else if (percentage <= 80) {
                            $progressBar.removeClass('bg-danger bg-success').addClass('bg-warning');
                        } else {
                            $progressBar.removeClass('bg-danger bg-warning').addClass('bg-success');
                        }
                    }
                    
                    function showAlert(type, message) {
                        const alertClass = type === 'error' ? 'alert-danger' : 
                                        type === 'success' ? 'alert-success' : 'alert-info';
                        
                        const $alert = $(`
                            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                                ${message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                        
                        $('.success_message').empty();
                        $('.success_message').prepend($alert);
                        
                        setTimeout(() => {
                            $alert.alert('close');
                        }, 5000);
                    }
                });
                </script>
            </div>
            <!-- Verification Success Modal -->
            <div class="modal fade" id="verificationSuccessModal" tabindex="-1" aria-labelledby="verificationSuccessModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title">Verification Successful</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Dynamic content will be inserted here -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" id="proceedToNextStep">Next</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Include necessary JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<!-- jQuery first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Then Bootstrap bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Other dependencies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<style>
/* Registration Section Styles */
.registration-section {
    background-color: #f8f9fa;
}

.registration-wrapper {
    max-width: 800px;
    margin: 0 auto;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    padding: 2rem;
}

.registration-tabs {
    margin-bottom: 2rem;
}

.registration-tab-list {
    list-style: none;
    padding: 0;
    border-bottom: 1px solid #dee2e6;
}

.registration-tab-item {
    margin-right: 1rem;
}

.registration-tab-link {
    display: block;
    padding: 0.5rem 1rem;
    color: #6c757d;
    text-decoration: none;
    border: 1px solid transparent;
    border-bottom: none;
    border-radius: 4px 4px 0 0;
}

.registration-tab-item.active .registration-tab-link {
    color: #0d6efd;
    background-color: #fff;
    border-color: #dee2e6 #dee2e6 #fff;
}

.registration-header {
    margin-bottom: 2rem;
}

.registration-title {
    font-weight: 600;
    color: #212529;
}

.registration-subtitle {
    color: #6c757d;
}

/* Progress Indicator */
.registration-progress {
    margin-bottom: 2rem;
}

.progress-steps {
    display: flex;
    justify-content: space-between;
    position: relative;
}

.progress-steps::before {
    content: '';
    position: absolute;
    top: 15px;
    left: 0;
    right: 0;
    height: 2px;
    background-color: #e9ecef;
    z-index: 1;
}

.progress-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    z-index: 2;
    flex: 1;
}

.step-number {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: #e9ecef;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.progress-step.active .step-number {
    background-color: #0d6efd;
    color: #fff;
}

.progress-step.completed .step-number {
    background-color: #198754;
    color: #fff;
}

.step-label {
    font-size: 0.875rem;
    color: #6c757d;
    text-align: center;
}

.progress-step.active .step-label {
    color: #0d6efd;
    font-weight: 500;
}

/* Form Styles */
.registration-step {
    display: none;
}

.registration-step.active {
    display: block;
}

.form-label {
    font-weight: 500;
    margin-bottom: 0.5rem;
    color: #495057;
}

.form-control {
    padding: 0.75rem 1rem;
    border-radius: 6px;
    border: 1px solid #ced4da;
}

.form-control:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

/* Verification Toggle */
.verification-toggle {
    display: flex;
    border-radius: 6px;
    overflow: hidden;
    margin-bottom: 1rem;
}

.verification-toggle .btn {
    flex: 1;
    padding: 0.5rem;
    border-radius: 0;
}

.verification-toggle .btn:first-child {
    border-radius: 6px 0 0 6px;
}

.verification-toggle .btn:last-child {
    border-radius: 0 6px 6px 0;
}

/* Password Strength */
.password-strength .progress {
    background-color: #e9ecef;
}

.password-requirements {
    margin-top: 0.5rem;
}

.password-requirements ul {
    padding-left: 1.5rem;
}

.password-requirements li {
    margin-bottom: 0.25rem;
    font-size: 0.875rem;
    color: #6c757d;
}

/* Responsive Adjustments */
@media (max-width: 767.98px) {
    .registration-wrapper {
        padding: 1.5rem;
    }
    
    .progress-step {
        padding: 0 0.5rem;
    }
    
    .step-label {
        font-size: 0.75rem;
    }
}
</style>
@endsection