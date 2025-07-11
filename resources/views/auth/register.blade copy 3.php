@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <div class="text-center">
                        <h3 class="font-weight-bold text-primary mb-1">{{ __('Create Your Account') }}</h3>
                        <p class="text-muted small mb-0">Complete your registration in just a few steps</p>
                    </div>
                    <div class="progress mt-4" style="height: 8px;">
                        <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 20%" id="registrationProgress"></div>
                    </div>
                </div>

                <div class="card-body px-4 py-4">
                    <form method="POST" action="{{ route('post.register') }}" id="registrationForm" enctype="multipart/form-data" novalidate>
                        @csrf

                        <!-- Step 1: Personal Information -->
                        <div class="registration-step" id="step1">
                            <h5 class="text-muted mb-4 d-flex align-items-center">
                                <span class="step-badge badge badge-primary mr-2">1</span>
                                <span>Personal Information</span>
                            </h5>
                            
                            <div class="form-group row">
                                <label for="firstname" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }} <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required autocomplete="given-name" maxlength="50" pattern="[A-Za-z\s]+">
                                    </div>
                                    @error('firstname')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="lastname" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }} <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="family-name" maxlength="50" pattern="[A-Za-z\s]+">
                                    </div>
                                    @error('lastname')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Verification Method') }} <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                        <label class="btn btn-outline-primary active">
                                            <input type="radio" name="otp_method" value="email" autocomplete="off" checked> <i class="fas fa-envelope mr-1"></i> Email
                                        </label>
                                        <label class="btn btn-outline-primary">
                                            <input type="radio" name="otp_method" value="phone" autocomplete="off"> <i class="fas fa-mobile-alt mr-1"></i> Phone
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">We'll send a verification code to this contact</small>
                                </div>
                            </div>

                            <div class="form-group row" id="emailField">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="your@email.com">
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row d-none" id="phoneField">
                                <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }} <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="08012345678">
                                    </div>
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0 mt-4">
                                <div class="col-md-6 offset-md-4">
                                    <button type="button" class="btn btn-primary btn-block py-2" id="nextStep1">
                                        <span class="font-weight-bold">Continue</span> <i class="fas fa-arrow-right ml-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: OTP Verification -->
                        <div class="registration-step d-none" id="step2">
                            <h5 class="text-muted mb-4 d-flex align-items-center">
                                <span class="step-badge badge badge-primary mr-2">2</span>
                                <span>Verify Your Identity</span>
                            </h5>
                            
                            <div class="alert alert-info d-flex align-items-center">
                                <i class="fas fa-info-circle mr-2"></i>
                                <div>
                                    We've sent a 6-digit verification code to your <span id="contactMethod" class="font-weight-bold"></span>.
                                    <div class="small mt-1" id="otpCountdown"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="otp" class="col-md-4 col-form-label text-md-right">{{ __('Verification Code') }} <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        </div>
                                        <input id="otp" type="text" class="form-control @error('otp') is-invalid @enderror" name="otp" required maxlength="6" pattern="\d{6}" placeholder="123456">
                                    </div>
                                    <div class="text-right">
                                        <button type="button" id="resendOtpBtn" class="btn btn-link p-0 mt-2 small" disabled>
                                            <span id="resendCountdown">60</span>s to resend code
                                        </button>
                                    </div>
                                    @error('otp')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0 mt-4">
                                <div class="col-md-6 offset-md-4 d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary" id="backStep2">
                                        <i class="fas fa-arrow-left mr-2"></i> Back
                                    </button>
                                    <button type="button" class="btn btn-primary" id="nextStep2">
                                        Verify & Continue <i class="fas fa-arrow-right ml-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: ID Verification -->
                        <div class="registration-step d-none" id="step3">
                            <h5 class="text-muted mb-4 d-flex align-items-center">
                                <span class="step-badge badge badge-primary mr-2">3</span>
                                <span>Identity Verification</span>
                            </h5>
                            
                            <div class="form-group row">
                                <label for="bvn" class="col-md-4 col-form-label text-md-right">{{ __('BVN') }} <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        </div>
                                        <input id="bvn" type="text" class="form-control @error('bvn') is-invalid @enderror" name="bvn" value="{{ old('bvn') }}" maxlength="11" pattern="\d{11}" required placeholder="12345678901">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="button" id="verifyBvnBtn">
                                                Verify
                                            </button>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">11-digit Bank Verification Number</small>
                                    <div id="bvnVerificationResult" class="mt-2"></div>
                                    @error('bvn')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                           

                            <div class="form-group row mb-0 mt-4">
                                <div class="col-md-6 offset-md-4 d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary" id="backStep3">
                                        <i class="fas fa-arrow-left mr-2"></i> Back
                                    </button>
                                    <button type="button" class="btn btn-primary" id="nextStep3" disabled>
                                        Continue <i class="fas fa-arrow-right ml-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Password Setup -->
                        <div class="registration-step d-none" id="step4">
                            <h5 class="text-muted mb-4 d-flex align-items-center">
                                <span class="step-badge badge badge-primary mr-2">4</span>
                                <span>Account Security</span>
                            </h5>
                            
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }} <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        </div>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" minlength="8" placeholder="••••••••">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="password-strength mt-2">
                                        <div class="progress" style="height: 4px;">
                                            <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                                        </div>
                                        <small class="form-text text-muted" id="passwordHelp">
                                            Password strength: <span id="strengthText">Weak</span>
                                        </small>
                                    </div>
                                    <ul class="list-unstyled small text-muted mt-2">
                                        <li id="lengthRequirement" class="text-danger"><i class="fas fa-circle-notch fa-xs mr-1"></i> Minimum 8 characters</li>
                                        <li id="numberRequirement" class="text-danger"><i class="fas fa-circle-notch fa-xs mr-1"></i> At least one number</li>
                                        <li id="letterRequirement" class="text-danger"><i class="fas fa-circle-notch fa-xs mr-1"></i> At least one letter</li>
                                    </ul>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }} <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        </div>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div id="passwordMatch" class="small mt-2"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" name="terms" id="terms" required>
                                        <label class="form-check-label" for="terms">
                                            I agree to the <a href="{{ route('terms') }}" target="_blank" class="font-weight-bold">Terms and Conditions</a> and <a href="{{ route('privacy') }}" target="_blank" class="font-weight-bold">Privacy Policy</a>
                                        </label>
                                        @error('terms')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0 mt-4">
                                <div class="col-md-6 offset-md-4 d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary" id="backStep4">
                                        <i class="fas fa-arrow-left mr-2"></i> Back
                                    </button>
                                    <button type="submit" class="btn btn-success" id="completeRegistration">
                                        <i class="fas fa-check-circle mr-2"></i> Complete Registration
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <script>
                    $(document).ready(function() {
                        // Initialize variables
                        let resendTimer;
                        let otpCountdown;
                        let resendTimeLeft = 60;
                        let otpTimeLeft = 300; // 5 minutes
                        let faceVerificationComplete = false;
                        
                        // Toggle password visibility
                        $('.toggle-password').click(function() {
                            const input = $(this).closest('.input-group').find('input');
                            const icon = $(this).find('i');
                            const type = input.attr('type') === 'password' ? 'text' : 'password';
                            input.attr('type', type);
                            icon.toggleClass('fa-eye fa-eye-slash');
                        });

                        // Password strength checker
                        $('#password').on('input', function() {
                            const password = $(this).val();
                            const strength = checkPasswordStrength(password);
                            
                            // Update progress bar
                            $('#passwordStrength').css('width', strength.percentage + '%')
                                .removeClass('bg-danger bg-warning bg-success')
                                .addClass(strength.class);
                            
                            // Update text
                            $('#strengthText').text(strength.text).removeClass('text-danger text-warning text-success').addClass(strength.textClass);
                            
                            // Update requirements
                            $('#lengthRequirement').toggleClass('text-danger text-success', password.length >= 8);
                            $('#numberRequirement').toggleClass('text-danger text-success', /\d/.test(password));
                            $('#letterRequirement').toggleClass('text-danger text-success', /[a-zA-Z]/.test(password));
                        });

                        // Confirm password match
                        $('#password-confirm').on('input', function() {
                            const password = $('#password').val();
                            const confirmPassword = $(this).val();
                            
                            if (confirmPassword.length === 0) {
                                $('#passwordMatch').html('');
                            } else if (password === confirmPassword) {
                                $('#passwordMatch').html('<span class="text-success"><i class="fas fa-check-circle mr-1"></i> Passwords match</span>');
                            } else {
                                $('#passwordMatch').html('<span class="text-danger"><i class="fas fa-times-circle mr-1"></i> Passwords do not match</span>');
                            }
                        });

                        // Toggle between email and phone fields
                        $('input[name="otp_method"]').change(function() {
                            if ($(this).val() === 'email') {
                                $('#emailField').removeClass('d-none');
                                $('#phoneField').addClass('d-none');
                                $('#email').prop('required', true);
                                $('#phone').prop('required', false);
                            } else {
                                $('#phoneField').removeClass('d-none');
                                $('#emailField').addClass('d-none');
                                $('#phone').prop('required', true);
                                $('#email').prop('required', false);
                            }
                        });

                        // Step 1: Next button
                        $('#nextStep1').click(function() {
                            const method = $('input[name="otp_method"]:checked').val();
                            const contact = method === 'email' ? $('#email').val() : $('#phone').val();
                            
                            if (!contact) {
                                const fieldName = method === 'email' ? 'email' : 'phone number';
                                showAlert('danger', `Please enter your ${fieldName}`);
                                return;
                            }

                            // Validate email format if email method
                            if (method === 'email' && !validateEmail(contact)) {
                                showAlert('danger', 'Please enter a valid email address');
                                return;
                            }

                            // Validate phone format if phone method
                            if (method === 'phone' && !validatePhone(contact)) {
                                showAlert('danger', 'Please enter a valid phone number (e.g., 08012345678)');
                                return;
                            }

                            // Send OTP
                            sendOtp(method, contact);
                        });

                        // Step 2: Back button
                        $('#backStep2').click(function() {
                            $('#step1').removeClass('d-none');
                            $('#step2').addClass('d-none');
                            updateProgressBar(20);
                            clearResendCountdown();
                            clearOtpCountdown();
                        });

                        // Step 2: Next button (Verify OTP)
                        $('#nextStep2').click(function() {
                            const otp = $('#otp').val();
                            const method = $('input[name="otp_method"]:checked').val();
                            const contact = method === 'email' ? $('#email').val() : $('#phone').val();

                            if (!otp || otp.length !== 6) {
                                showAlert('danger', 'Please enter a valid 6-digit code');
                                return;
                            }

                            verifyOtp(otp, method, contact);
                        });

                        // Step 3: Back button
                        $('#backStep3').click(function() {
                            $('#step2').removeClass('d-none');
                            $('#step3').addClass('d-none');
                            updateProgressBar(50);
                        });

                        // Step 3: Next button
                        $('#nextStep3').click(function() {
                            // Check both the verification status and the completion flag
                            if ($('#faceVerificationStatus').val() !== '1' || !faceVerificationComplete) {
                                $('#faceVerificationResult').html(`
                                    <div class="alert alert-danger">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        Please complete facial verification first
                                    </div>
                                `);
                                return;
                            }

                            $('#step3').addClass('d-none');
                            $('#step4').removeClass('d-none');
                            updateProgressBar(80);
                        });

                        // Step 4: Back button
                        $('#backStep4').click(function() {
                            $('#step3').removeClass('d-none');
                            $('#step4').addClass('d-none');
                            updateProgressBar(60);
                        });

                        // Face capture buttons
                        $('#openCameraBtn').click(function() {
                            $('#faceImage').click();
                        });

                        $('#uploadPhotoBtn').click(function() {
                            $('#faceImage').removeAttr('capture').click();
                        });

                        // Face image preview
                        $('#faceImage').change(function() {
                            if (this.files && this.files[0]) {
                                const file = this.files[0];
                                if (!file.type.match('image.*')) {
                                    showAlert('danger', 'Please select an image file');
                                    return;
                                }
                                
                                if (file.size > 2 * 1024 * 1024) { // 2MB
                                    showAlert('danger', 'Image size should be less than 2MB');
                                    return;
                                }

                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    $('#facePreview').attr('src', e.target.result);
                                    $('#faceCapturePreview').removeClass('d-none');
                                    $('#faceVerificationResult').html('<div class="alert alert-info">Ready for verification</div>');
                                    $('#verifyFaceBtn').prop('disabled', false);
                                }
                                reader.readAsDataURL(file);
                            }
                        });

                        // Face verification
                        $('#verifyFaceBtn').click(function() {
                            const btn = $(this);
                            const originalHtml = btn.html();
                            
                            // Show loading state
                            btn.prop('disabled', true)
                            .html('<span class="spinner-border spinner-border-sm mr-2"></span> Verifying...');

                            // Validate image exists
                            if (!$('#faceImage').val() || !$('#faceImage')[0].files.length) {
                                $('#faceVerificationResult').html(`
                                    <div class="alert alert-danger">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        Please capture or upload your face image first
                                    </div>
                                `);
                                btn.prop('disabled', false).html(originalHtml);
                                return;
                            }

                            // Prepare form data
                            const formData = new FormData();
                            formData.append('face_image', $('#faceImage')[0].files[0]);
                            formData.append('bvn', $('#bvn').val());
                            formData.append('_token', '{{ csrf_token() }}');

                            // Make AJAX request
                            $.ajax({
                                url: '{{ route("verify-face") }}',
                                method: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    if (response.status) {
                                        // Successful verification
                                        $('#faceVerificationResult').html(`
                                            <div class="alert alert-success">
                                                <i class="fas fa-check-circle mr-2"></i>
                                                ${response.face_data.message || 'Face verification successful!'}
                                                ${response.face_data.confidence ? `(Confidence: ${response.face_data.confidence}%)` : ''}
                                            </div>
                                        `);
                                        
                                        $('#faceVerificationStatus').val('1');
                                        faceVerificationComplete = true;

                                        $('#nextStep3').prop('disabled', false);
                                        
                                    } else {
                                        // Failed verification
                                        let errorMessage = response.message || 'Face verification failed';
                                        if (response.image_received === false) {
                                            errorMessage = 'No face image was received by the server';
                                        }
                                        
                                        $('#faceVerificationResult').html(`
                                            <div class="alert alert-danger">
                                                <i class="fas fa-times-circle mr-2"></i>
                                                ${errorMessage}
                                                ${response.bvn ? `<br>BVN: ${response.bvn}` : ''}
                                            </div>
                                        `);
                                        // Ensure these are reset on failure
                                        $('#faceVerificationStatus').val('0');
                                        faceVerificationComplete = false;
                                    }
                                },
                                error: function(xhr) {
                                    let errorMessage = 'Error connecting to verification service';
                                    if (xhr.responseJSON && xhr.responseJSON.message) {
                                        errorMessage = xhr.responseJSON.message;
                                    }
                                    $('#faceVerificationResult').html(`
                                        <div class="alert alert-danger">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>
                                            ${errorMessage}
                                        </div>
                                    `);
                                    // Ensure these are reset on error
                                    $('#faceVerificationStatus').val('0');
                                    faceVerificationComplete = false;
                                },
                                complete: function() {
                                    btn.html(originalHtml).prop('disabled', false);
                                }
                            });
                        });

                        // Resend OTP button
                        $('#resendOtpBtn').click(function() {
                            const method = $('input[name="otp_method"]:checked').val();
                            const contact = method === 'email' ? $('#email').val() : $('#phone').val();
                            
                            if (!contact) {
                                showAlert('danger', 'Contact information not found');
                                return;
                            }

                            sendOtp(method, contact);
                        });

                        // BVN Verification
                        $('#verifyBvnBtn').click(function() {
                            const btn = $(this);
                            const originalText = btn.html();
                            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Verifying...');
                            
                            const bvn = $('#bvn').val();
                            const firstName = $('#firstname').val();
                            const lastName = $('#lastname').val();

                            if (!bvn || bvn.length !== 11) {
                                $('#bvnVerificationResult').html('<div class="alert alert-danger">Please enter a valid 11-digit BVN</div>');
                                btn.prop('disabled', false).html(originalText);
                                return;
                            }

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
                                    if (response.status) {
                                        $('#bvnVerificationResult').html('<div class="alert alert-success">BVN verified successfully</div>');
                                        // Auto-fill names if empty and available in response
                                        if (!$('#firstname').val() && response.data.firstName) {
                                            $('#firstname').val(response.data.firstName);
                                        }
                                        if (!$('#lastname').val() && response.data.lastName) {
                                            $('#lastname').val(response.data.lastName);
                                        }
                                        // Show face verification section
                                        $('#faceVerificationSection').removeClass('d-none');
                                    } else {
                                        $('#bvnVerificationResult').html('<div class="alert alert-danger">BVN verification failed: ' + (response.detail || 'Invalid BVN') + '</div>');
                                    }
                                },
                                error: function(xhr) {
                                    let errorMessage = 'Error verifying BVN';
                                    if (xhr.responseJSON && xhr.responseJSON.message) {
                                        errorMessage = xhr.responseJSON.message;
                                    }
                                    $('#bvnVerificationResult').html('<div class="alert alert-danger">' + errorMessage + '</div>');
                                },
                                complete: function() {
                                    btn.prop('disabled', false).html(originalText);
                                }
                            });
                        });

                        // Form submission validation
                        $('#registrationForm').submit(function(e) {
                            if (!faceVerificationComplete) {
                                e.preventDefault();
                                showAlert('danger', 'Please complete facial verification first');
                                return false;
                            }

                            const password = $('#password').val();
                            const confirmPassword = $('#password-confirm').val();
                            
                            if (password !== confirmPassword) {
                                e.preventDefault();
                                showAlert('danger', 'Passwords do not match');
                                return false;
                            }

                            if (!$('#terms').is(':checked')) {
                                e.preventDefault();
                                showAlert('danger', 'You must agree to the terms and conditions');
                                return false;
                            }

                            // Show loading state
                            $('#completeRegistration').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...');
                            return true;
                        });

                        // Function to send OTP
                        function sendOtp(method, contact) {
                            $('#nextStep1').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...');

                            $.ajax({
                                url: '{{ route("send-otp") }}',
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    otp_method: method,
                                    contact: contact
                                },
                                success: function(response) {
                                    if (response.success) {
                                        // Show step 2
                                        $('#step1').addClass('d-none');
                                        $('#step2').removeClass('d-none');
                                        updateProgressBar(40);
                                        
                                        // Update contact method display
                                        const displayContact = method === 'email' ? 
                                            `email (${maskEmail(contact)})` : 
                                            `phone (${maskPhone(contact)})`;
                                        $('#contactMethod').text(displayContact);
                                        
                                        // Start countdown timers
                                        startResendCountdown();
                                        startOtpCountdown();
                                        
                                        // Focus on OTP input
                                        $('#otp').focus();
                                    } else {
                                        showAlert('danger', response.message || 'Failed to send OTP');
                                    }
                                },
                                error: function(xhr) {
                                    let errorMessage = 'Error sending OTP';
                                    if (xhr.responseJSON && xhr.responseJSON.message) {
                                        errorMessage = xhr.responseJSON.message;
                                    }
                                    showAlert('danger', errorMessage);
                                },
                                complete: function() {
                                    $('#nextStep1').prop('disabled', false).html('<span class="font-weight-bold">Continue</span> <i class="fas fa-arrow-right ml-2"></i>');
                                }
                            });
                        }

                        // Function to verify OTP
                        function verifyOtp(otp, method, contact) {
                            $('#nextStep2').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Verifying...');

                            $.ajax({
                                url: '{{ route("verify-otp") }}',
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    otp: otp,
                                    method: method,
                                    contact: contact
                                },
                                success: function(response) {
                                    if (response.success) {
                                        // Show step 3
                                        $('#step2').addClass('d-none');
                                        $('#step3').removeClass('d-none');
                                        updateProgressBar(60);
                                        
                                        // Clear timers
                                        clearResendCountdown();
                                        clearOtpCountdown();
                                        
                                        // Focus on BVN input
                                        $('#bvn').focus();
                                    } else {
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
                                    $('#nextStep2').prop('disabled', false).text('Verify & Continue');
                                }
                            });
                        }

                        // Helper functions
                        function maskEmail(email) {
                            const parts = email.split('@');
                            const username = parts[0];
                            const domain = parts[1];
                            return username.substring(0, 2) + '***' + username.slice(-1) + '@' + domain;
                        }

                        function maskPhone(phone) {
                            return phone.substring(0, 4) + '****' + phone.slice(-2);
                        }

                        function showAlert(type, message) {
                            // Remove any existing alerts first
                            $('.alert-dismissible').remove();
                            
                            const alert = `<div class="alert alert-${type} alert-dismissible fade show mb-4" role="alert">
                                            <div class="d-flex align-items-center">
                                                <i class="fas ${type === 'danger' ? 'fa-exclamation-circle' : 'fa-info-circle'} mr-2"></i>
                                                <div>${message}</div>
                                            </div>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>`;
                            $('#registrationForm').prepend(alert);
                            
                            // Auto-dismiss after 5 seconds
                            setTimeout(() => {
                                $('.alert-dismissible').alert('close');
                            }, 5000);
                        }

                        function validateEmail(email) {
                            const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                            return re.test(String(email).toLowerCase());
                        }

                        function validatePhone(phone) {
                            const re = /^[0-9]{11}$/;
                            return re.test(phone);
                        }

                        function checkPasswordStrength(password) {
                            let strength = 0;
                            let text = 'Weak';
                            let className = 'bg-danger';
                            let textClass = 'text-danger';
                            
                            // Check length
                            if (password.length >= 8) strength += 1;
                            if (password.length >= 12) strength += 1;
                            
                            // Check for numbers
                            if (/\d/.test(password)) strength += 1;
                            
                            // Check for letters
                            if (/[a-zA-Z]/.test(password)) strength += 1;
                            
                            // Check for special chars
                            if (/[^a-zA-Z0-9]/.test(password)) strength += 1;
                            
                            // Determine strength level
                            if (strength > 4) {
                                text = 'Very Strong';
                                className = 'bg-success';
                                textClass = 'text-success';
                            } else if (strength > 3) {
                                text = 'Strong';
                                className = 'bg-success';
                                textClass = 'text-success';
                            } else if (strength > 2) {
                                text = 'Good';
                                className = 'bg-warning';
                                textClass = 'text-warning';
                            } else if (strength > 1) {
                                text = 'Fair';
                                className = 'bg-warning';
                                textClass = 'text-warning';
                            }
                            
                            // Calculate percentage
                            const percentage = Math.min(100, strength * 25);
                            
                            return {
                                text: text,
                                class: className,
                                textClass: textClass,
                                percentage: percentage
                            };
                        }

                        function updateProgressBar(percentage) {
                            $('#registrationProgress').css('width', percentage + '%');
                        }

                        // Countdown functions
                        function startResendCountdown() {
                            clearInterval(resendTimer);
                            resendTimeLeft = 60;
                            $('#resendOtpBtn').prop('disabled', true);
                            
                            resendTimer = setInterval(function() {
                                $('#resendCountdown').text(resendTimeLeft);
                                
                                if (resendTimeLeft <= 0) {
                                    clearInterval(resendTimer);
                                    $('#resendOtpBtn').prop('disabled', false).html('Resend code now');
                                }
                                
                                resendTimeLeft--;
                            }, 1000);
                        }

                        function clearResendCountdown() {
                            clearInterval(resendTimer);
                            $('#resendOtpBtn').prop('disabled', false).html('Resend code now');
                        }

                        function startOtpCountdown() {
                            clearInterval(otpCountdown);
                            otpTimeLeft = 300;
                            
                            otpCountdown = setInterval(function() {
                                const minutes = Math.floor(otpTimeLeft / 60);
                                const seconds = otpTimeLeft % 60;
                                
                                $('#otpCountdown').text(`Code expires in ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`);
                                
                                if (otpTimeLeft <= 0) {
                                    clearInterval(otpCountdown);
                                    $('#otpCountdown').text('Code has expired. Please request a new one.');
                                    $('#nextStep2').prop('disabled', true);
                                }
                                
                                otpTimeLeft--;
                            }, 1000);
                        }

                        function clearOtpCountdown() {
                            clearInterval(otpCountdown);
                            $('#otpCountdown').text('');
                        }
                    });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection