@extends('layouts.app')

@section('content')
<!-- Breadcrumb section -->
<section class="breadcrumb__section section--padding">
    <div class="container">
        <div class="breadcrumb__content text-center">
            <h1 class="breadcrumb__title h2">
                <span> </span>Registration
            </h1>
            <ul class="breadcrumb__menu d-flex justify-content-center">
                <li class="breadcrumb__menu--items">
                    <a class="breadcrumb__menu--link" href="{{ url('/')}}">Home</a>
                </li>
                <li> 
                    <span>
                        <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.22321 4.65179C5.28274 4.71131 5.3125 4.77976 5.3125 4.85714C5.3125 4.93452 5.28274 5.00298 5.22321 5.0625L1.0625 9.22321C1.00298 9.28274 0.934524 9.3125 0.857143 9.3125C0.779762 9.3125 0.71131 9.28274 0.651786 9.22321L0.205357 8.77679C0.145833 8.71726 0.116071 8.64881 0.116071 8.57143C0.116071 8.49405 0.145833 8.4256 0.205357 8.36607L3.71429 4.85714L0.205357 1.34821C0.145833 1.28869 0.116071 1.22024 0.116071 1.14286C0.116071 1.06548 0.145833 0.997023 0.205357 0.9375L0.651786 0.491071C0.71131 0.431547 0.779762 0.401785 0.857143 0.401785C0.934524 0.401785 1.00298 0.431547 1.0625 0.491071L5.22321 4.65179Z" fill="#706C6C"/>
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

<!-- Account Page section -->
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
                    <h2 class="account__title">Secure  Registration</h2>
                    <p class="account__desc">Complete your profile with facial recognition for enhanced security</p>
                </div>
                
                <!-- Registration Steps -->
                <div class="registration-steps mb-30">
                    <div class="steps-progress">
                        <div class="step active" data-step="1">
                            <span>1</span>
                            <p>Basic Info</p>
                        </div>
                        <div class="step" data-step="2">
                            <span>2</span>
                            <p>Face Verification</p>
                        </div>
                        <div class="step" data-step="3">
                            <span>3</span>
                            <p>Complete</p>
                        </div>
                    </div>
                </div>
                
                <!-- Step 1: Basic Information -->
                <div class="account__form step-content active" id="step-1">
                    <form id="registrationForm" method="POST" action="{{ route('post.register') }}">
                        @csrf
                        <input type="hidden" name="face_descriptor" id="faceDescriptor">
                        
                        <div class="row">
                            <div class="col-md-6 mb-20">
                                <label class="account__form--input__label mb-12" for="first_name">First Name</label>
                                <input id="first_name" type="text" class="account__form--input__field @error('first_name') is-invalid @enderror" 
                                       name="first_name" value="{{ old('first_name') }}" placeholder="Enter your first name*" required autocomplete="given-name">
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-20">
                                <label class="account__form--input__label mb-12" for="last_name">Last Name</label>
                                <input id="last_name" type="text" class="account__form--input__field @error('last_name') is-invalid @enderror" 
                                       name="last_name" value="{{ old('last_name') }}" placeholder="Enter your last name*" required autocomplete="family-name">
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="account__form--input mb-20">
                            <label class="account__form--input__label mb-12" for="email">Email Address / Phone number</label>
                            <input id="email" placeholder="Email Address / Phone number" type="email" 
                                   class="account__form--input__field @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email">
                            <input type="hidden" name="registration_source" value="web">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-20">
                                <label class="account__form--input__label mb-12" for="password">Password</label>
                                <div class="account__form--create__password position-relative">
                                    <input class="account__form--input__field @error('password') is-invalid @enderror" 
                                           name="password" id="password" placeholder="Create password" 
                                           type="password" required autocomplete="new-password">
                                    <button type="button" class="account__form--password__show--icon" onclick="togglePasswordVisibility('password')">
                                        <svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8 10C2.76587 10 0.170875 5.437 0.063 5.24288C-0.021 5.09175 -0.021 4.90812 0.063 4.757C0.170875 4.563 2.76587 0 8 0C13.2341 0 15.8291 4.563 15.937 4.75712C16.021 4.90825 16.021 5.09188 15.937 5.243C15.8291 5.437 13.2341 10 8 10ZM1.08837 4.99925C1.68313 5.90062 4.01825 9 8 9C11.9944 9 14.3191 5.90312 14.9116 5.00075C14.3169 4.09937 11.9818 1 8 1C4.00562 1 1.68087 4.09688 1.08837 4.99925ZM8 8C6.34575 8 5 6.65425 5 5C5 3.34575 6.34575 2 8 2C9.65425 2 11 3.34575 11 5C11 6.65425 9.65425 8 8 8ZM8 3C6.89725 3 6 3.89725 6 5C6 6.10275 6.89725 7 8 7C9.10275 7 10 6.10275 10 5C10 3.89725 9.10275 3 8 3Z" fill="#817F7E"></path>
                                        </svg>
                                    </button>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-20">
                                <label class="account__form--input__label mb-12" for="password-confirm">Confirm Password</label>
                                <div class="account__form--create__password position-relative">
                                    <input class="account__form--input__field" name="password_confirmation" 
                                           id="password-confirm" placeholder="Confirm password" 
                                           type="password" required autocomplete="new-password">
                                    <button type="button" class="account__form--password__show--icon" onclick="togglePasswordVisibility('password-confirm')">
                                        <svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8 10C2.76587 10 0.170875 5.437 0.063 5.24288C-0.021 5.09175 -0.021 4.90812 0.063 4.757C0.170875 4.563 2.76587 0 8 0C13.2341 0 15.8291 4.563 15.937 4.75712C16.021 4.90825 16.021 5.09188 15.937 5.243C15.8291 5.437 13.2341 10 8 10ZM1.08837 4.99925C1.68313 5.90062 4.01825 9 8 9C11.9944 9 14.3191 5.90312 14.9116 5.00075C14.3169 4.09937 11.9818 1 8 1C4.00562 1 1.68087 4.09688 1.08837 4.99925ZM8 8C6.34575 8 5 6.65425 5 5C5 3.34575 6.34575 2 8 2C9.65425 2 11 3.34575 11 5C11 6.65425 9.65425 8 8 8ZM8 3C6.89725 3 6 3.89725 6 5C6 6.10275 6.89725 7 8 7C9.10275 7 10 6.10275 10 5C10 3.89725 9.10275 3 8 3Z" fill="#817F7E"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="account__form--input mb-20">
                            <label class="account__form--input__label mb-12" for="referral_code">Referral Code (Optional)</label>
                            <input id="referral_code" type="text" class="account__form--input__field @error('referral_code') is-invalid @enderror" 
                                   name="referral_code" value="{{ old('referral_code', $referralCode) }}" placeholder="Enter referral code">
                            @error('referral_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="account__form--input mb-20">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>, 
                                    including the use of biometric data for authentication purposes.
                                </label>
                            </div>
                        </div>
                        
                        <button type="button" class="account__form--btn solid__btn next-step" data-next="2">Continue to Face Verification</button>
                    </form>
                </div>
                
                <!-- Step 2: Face Verification -->
                <div class="account__form step-content" id="step-2">
                    <div class="face-verification-container mb-30 text-center">
                        <div class="verification-instructions mb-20">
                            <h3 class="verification-title mb-12">Face Verification</h3>
                            <p class="verification-desc">Please position your face in the frame below for identity verification</p>
                            <ul class="verification-tips text-left" style="display: inline-block;">
                                <li>Ensure good lighting</li>
                                <li>Remove glasses or hats</li>
                                <li>Look directly at the camera</li>
                            </ul>
                        </div>
                        
                        <div class="face-capture-wrapper">
                            <div class="camera-feed mb-20">
                                <video id="video" width="320" height="240" autoplay playsinline></video>
                                <canvas id="canvas" width="320" height="240" style="display: none;"></canvas>
                            </div>
                            
                            <div class="capture-actions">
                                <button id="captureBtn" class="account__form--btn outline__btn mr-15">
                                    <i class="fas fa-camera mr-5"></i> Capture
                                </button>
                                <button id="retryBtn" class="account__form--btn outline__btn" style="display: none;">
                                    <i class="fas fa-redo mr-5"></i> Retry
                                </button>
                            </div>
                            
                            <div id="captureResult" class="mt-20" style="display: none;">
                                <div class="result-icon success">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <p class="result-message">Face verified successfully!</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="navigation-buttons">
                        <button type="button" class="account__form--btn outline__btn prev-step mr-15" data-prev="1">
                            <i class="fas fa-arrow-left mr-5"></i> Back
                        </button>
                        <button type="button" id="completeRegistration" class="account__form--btn solid__btn" disabled>
                            Complete Registration
                        </button>
                    </div>
                </div>
                
                <!-- Step 3: Completion -->
                <div class="account__form step-content text-center" id="step-3">
                    <div class="registration-complete">
                        <div class="complete-icon mb-20">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3 class="complete-title mb-12">Registration Complete!</h3>
                        <p class="complete-desc mb-20">Your account has been successfully created with biometric verification.</p>
                        <p class="complete-note">You can now login using your email and password or facial recognition.</p>
                        
                        <div class="complete-actions mt-30">
                            <a href="{{ route('login') }}" class="account__form--btn solid__btn">
                                Proceed to Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Required Libraries -->
<script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
    // Password visibility toggle
    function togglePasswordVisibility(fieldId) {
        const inputField = document.getElementById(fieldId);
        if (inputField.type === "password") {
            inputField.type = "text";
        } else {
            inputField.type = "password";
        }
    }
    
    // Step navigation
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize steps
        document.querySelectorAll('.step-content').forEach((step, index) => {
            step.style.display = index === 0 ? 'block' : 'none';
        });
        
        // Next step handler
        document.querySelectorAll('.next-step').forEach(button => {
            button.addEventListener('click', function() {
                const currentStep = this.closest('.step-content');
                const nextStepId = this.getAttribute('data-next');
                
                // Validate before proceeding to face verification
                if (nextStepId === '2' && !document.getElementById('registrationForm').checkValidity()) {
                    document.getElementById('registrationForm').reportValidity();
                    return;
                }
                
                // Hide current step
                currentStep.style.display = 'none';
                
                // Show next step
                document.getElementById(`step-${nextStepId}`).style.display = 'block';
                
                // Update step indicators
                document.querySelectorAll('.step').forEach(step => {
                    step.classList.remove('active');
                    if (parseInt(step.getAttribute('data-step')) <= parseInt(nextStepId)) {
                        step.classList.add('active');
                    }
                });
                
                // Initialize face detection if going to step 2
                if (nextStepId === '2') {
                    initializeFaceDetection();
                }
            });
        });
        
        // Previous step handler
        document.querySelectorAll('.prev-step').forEach(button => {
            button.addEventListener('click', function() {
                const currentStep = this.closest('.step-content');
                const prevStepId = this.getAttribute('data-prev');
                
                currentStep.style.display = 'none';
                document.getElementById(`step-${prevStepId}`).style.display = 'block';
                
                // Update step indicators
                document.querySelectorAll('.step').forEach(step => {
                    step.classList.remove('active');
                    if (parseInt(step.getAttribute('data-step')) <= parseInt(prevStepId)) {
                        step.classList.add('active');
                    }
                });
                
                // Stop camera if going back from face verification
                if (prevStepId === '1') {
                    const video = document.getElementById('video');
                    if (video.srcObject) {
                        video.srcObject.getTracks().forEach(track => track.stop());
                    }
                }
            });
        });
    });
    
    // Face Detection Variables
    let faceDescriptor = null;
    let faceDetectionInterval = null;
    
    // Initialize Face Detection
    async function initializeFaceDetection() {
        try {
            // Load models (fallback to CDN if local fails)
            try {
                await faceapi.nets.tinyFaceDetector.loadFromUri('/models');
                await faceapi.nets.faceLandmark68Net.loadFromUri('/models');
                await faceapi.nets.faceRecognitionNet.loadFromUri('/models');
            } catch (e) {
                console.warn('Local models failed, loading from CDN');
                await faceapi.nets.tinyFaceDetector.loadFromUri(
                    'https://justadudewhohacks.github.io/face-api.js/models'
                );
                await faceapi.nets.faceLandmark68Net.loadFromUri(
                    'https://justadudewhohacks.github.io/face-api.js/models'
                );
                await faceapi.nets.faceRecognitionNet.loadFromUri(
                    'https://justadudewhohacks.github.io/face-api.js/models'
                );
            }
            
            // Start camera
            const video = document.getElementById('video');
            const stream = await navigator.mediaDevices.getUserMedia({ 
                video: { 
                    width: 640,
                    height: 480,
                    facingMode: 'user' 
                } 
            });
            
            video.srcObject = stream;
            video.onloadedmetadata = () => video.play();
            
            // Set up capture button
            document.getElementById('captureBtn').addEventListener('click', captureFace);
            document.getElementById('retryBtn').addEventListener('click', resetFaceCapture);
            
        } catch (err) {
            console.error('Face detection initialization failed:', err);
            
            let errorMessage = 'Could not initialize camera: ';
            if (err.name === 'NotAllowedError') {
                errorMessage += 'Please allow camera access to continue.';
            } else if (err.name === 'NotFoundError') {
                errorMessage += 'No camera found. Please check your device.';
            } else {
                errorMessage += err.message;
            }
            
            alert(errorMessage);
            document.querySelector('.prev-step[data-prev="1"]').click();
        }
    }
    
    // Capture Face Function
    async function captureFace() {
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const context = canvas.getContext('2d');
        
        try {
            // Show loading state
            const captureBtn = document.getElementById('captureBtn');
            captureBtn.disabled = true;
            captureBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing';
            
            // Draw current frame to canvas
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // Detect faces with timeout
            const detections = await Promise.race([
                faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions())
                    .withFaceLandmarks()
                    .withFaceDescriptors(),
                new Promise((_, reject) => setTimeout(() => reject(new Error('Detection timed out')), 10000))
            ]);
            
            if (detections.length === 0) {
                throw new Error('No face detected. Please center your face in the frame.');
            }
            
            if (detections.length > 1) {
                throw new Error('Multiple faces detected. Only one person should be visible.');
            }
            
            // Store face descriptor
            faceDescriptor = detections[0].descriptor;
            document.getElementById('faceDescriptor').value = JSON.stringify(Array.from(faceDescriptor));
            
            // Show success UI
            document.getElementById('captureBtn').style.display = 'none';
            document.getElementById('retryBtn').style.display = 'inline-block';
            document.getElementById('captureResult').style.display = 'block';
            document.getElementById('completeRegistration').disabled = false;
            
            // Stop video stream
            video.srcObject.getTracks().forEach(track => track.stop());
            
        } catch (err) {
            console.error('Face capture failed:', err);
            alert(err.message);
            
            // Reset button
            const captureBtn = document.getElementById('captureBtn');
            captureBtn.disabled = false;
            captureBtn.innerHTML = '<i class="fas fa-camera"></i> Capture';
        }
    }
    
    // Reset Face Capture
    function resetFaceCapture() {
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const context = canvas.getContext('2d');
        
        // Clear canvas
        context.clearRect(0, 0, canvas.width, canvas.height);
        
        // Reset UI
        document.getElementById('captureBtn').style.display = 'inline-block';
        document.getElementById('retryBtn').style.display = 'none';
        document.getElementById('captureResult').style.display = 'none';
        document.getElementById('completeRegistration').disabled = true;
        
        // Restart camera
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
                video.onloadedmetadata = () => video.play();
            })
            .catch(err => {
                console.error('Error restarting camera:', err);
                alert('Could not restart camera: ' + err.message);
            });
    }
    
    // Complete Registration
    document.getElementById('completeRegistration').addEventListener('click', function() {
        if (!faceDescriptor) {
            alert('Please complete face verification first.');
            return;
        }
        
        // Show loading state
        const completeBtn = document.getElementById('completeRegistration');
        completeBtn.disabled = true;
        completeBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing';
        
        // Submit form via AJAX
        const form = document.getElementById('registrationForm');
        const formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show completion step
                document.getElementById('step-2').style.display = 'none';
                document.getElementById('step-3').style.display = 'block';
                
                // Update all steps to active
                document.querySelectorAll('.step').forEach(step => {
                    step.classList.add('active');
                });
            } else {
                throw new Error(data.message || 'Registration failed');
            }
        })
        .catch(error => {
            console.error('Registration error:', error);
            alert('Registration failed: ' + error.message);
            
            // Reset button
            completeBtn.disabled = false;
            completeBtn.innerHTML = 'Complete Registration';
        });
    });
</script>

<style>
    /* Step Indicators */
    .registration-steps {
        max-width: 600px;
        margin: 0 auto 30px;
    }
    
    .steps-progress {
        display: flex;
        justify-content: space-between;
        position: relative;
    }
    
    .steps-progress:before {
        content: '';
        position: absolute;
        top: 15px;
        left: 0;
        right: 0;
        height: 2px;
        background: #e0e0e0;
        z-index: 1;
    }
    
    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
    }
    
    .step span {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #e0e0e0;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 8px;
        font-weight: bold;
    }
    
    .step.active span {
        background: #3d6def;
    }
    
    .step p {
        font-size: 12px;
        color: #777;
        margin: 0;
    }
    
    .step.active p {
        color: #333;
        font-weight: 500;
    }
    
    /* Face Verification Styles */
    .face-verification-container {
        max-width: 500px;
        margin: 0 auto;
    }
    
    .camera-feed {
        position: relative;
        margin: 0 auto;
        border: 2px solid #eee;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .verification-tips {
        list-style-type: none;
        padding: 0;
        margin: 20px auto;
        max-width: 300px;
    }
    
    .verification-tips li {
        padding: 8px 0;
        position: relative;
        padding-left: 25px;
    }
    
    .verification-tips li:before {
        content: '•';
        position: absolute;
        left: 10px;
        color: #3d6def;
    }
    
    .result-icon {
        font-size: 50px;
        margin-bottom: 15px;
    }
    
    .result-icon.success {
        color: #4CAF50;
    }
    
    /* Completion Screen */
    .registration-complete {
        padding: 30px 0;
    }
    
    .complete-icon {
        font-size: 60px;
        color: #4CAF50;
    }
    
    .complete-title {
        color: #333;
        font-size: 24px;
    }
    
    .complete-desc {
        color: #555;
        font-size: 16px;
    }
    
    .complete-note {
        color: #777;
        font-size: 14px;
    }
    
    /* Utility Classes */
    .navigation-buttons {
        display: flex;
        justify-content: center;
        margin-top: 30px;
    }
    
    .mr-15 {
        margin-right: 15px;
    }
    
    .mr-5 {
        margin-right: 5px;
    }
    
    .outline__btn {
        background: transparent;
        border: 1px solid #3d6def;
        color: #3d6def;
    }
    
    .outline__btn:hover {
        background: #3d6def;
        color: #fff;
    }
    
    /* Form Checkbox */
    .form-check {
        text-align: left;
        padding-left: 1.25rem;
    }
    
    .form-check-input {
        margin-top: 0.2rem;
    }
    
    .form-check-label {
        font-size: 0.9rem;
    }
    
    .form-check-label a {
        color: #3d6def;
        text-decoration: underline;
    }
</style>
@endsection