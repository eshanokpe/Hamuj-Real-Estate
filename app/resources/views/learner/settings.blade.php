@extends('layouts.app')

@section('content')
<!--====== Start My Learning ======-->
<section class="bizzen-blog-sec pt-115 pb-40" style="background-color: #F5F7FD">
    <div class="container bg-white rounded pt-30 pb-50 px-4">
        <div class="row justify-content-left">
            <div class="col-xl-12">
                <div class="align-items-center mb-4">
                    <div class="section-title mb-60">
                        <h6 class="text-anm">ACCOUNT SETTING</h6>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
         <!-- Display success/error messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <!-- Account Settings Row -->
        <div class="row mb-4">
            <!-- Profile Picture Column -->
            <div class="col-xl-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body text-center p-4">
                        <!-- Profile Picture -->
                        <div class="profile-picture-container mb-3">
                            <div class="position-relative d-inline-block">
                                <img id="profile-preview" 
                                     src="{{ Auth::user()->profile_picture ? Storage::url(Auth::user()->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=0A1F44&color=fff&size=200' }}" 
                                     alt="Profile Picture" 
                                     class="rounded-circle border border-3 border-primary"
                                     style="width: 200px; height: 200px; object-fit: cover;">
                                
                                <!-- Upload Overlay -->
                                <div class="profile-upload-overlay rounded-circle position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" 
                                     style="background-color: rgba(0,0,0,0.5); opacity: 0; transition: opacity 0.3s; cursor: pointer;"
                                     onclick="document.getElementById('profile-picture-input').click()">
                                    <div class="text-white text-center">
                                        <i class="fas fa-camera fa-2x mb-2"></i>
                                        <p class="mb-0 fw-medium">Change Photo</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Upload Form -->
                        <form id="profile-picture-form" action="{{ route('profile.picture.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="file" 
                                   id="profile-picture-input" 
                                   name="profile_picture" 
                                   accept="image/*" 
                                   class="d-none"
                                   onchange="previewImage(this)">
                            <div class="d-grid gap-2">
                                <button type="button" 
                                        class="btn btn-outline-primary btn-sm"
                                        onclick="document.getElementById('profile-picture-input').click()">
                                    <i class="fas fa-upload me-2"></i>Upload Photo
                                </button>
                                @if(Auth::user()->profile_picture)
                                <button type="button" 
                                        class="btn btn-outline-danger btn-sm"
                                        onclick="removeProfilePicture()">
                                    <i class="fas fa-trash me-2"></i>Remove Photo
                                </button>
                                @endif
                            </div>
                        </form>
                        
                        <!-- Upload Progress -->
                        <div id="upload-progress" class="progress mt-3 d-none" style="height: 6px;">
                            <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        
                        <!-- Upload Message -->
                        <div id="upload-message" class="mt-2"></div>
                        
                        <!-- User Info -->
                        <div class="mt-4">
                            <h5 class="fw-bold mb-1">{{ Auth::user()->name }}</h5>
                            <p class="text-muted mb-2">{{ Auth::user()->email }}</p>
                            <p class="text-muted mb-0">
                                <small>Member since {{ Auth::user()->created_at->format('F Y') }}</small>
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Account Stats -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Account Stats</h6>
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="text-primary fw-bold fs-4">
                                    {{ Auth::user()->courses()->count() ?? 0 }}
                                </div>
                                <small class="text-muted">Courses</small>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="text-success fw-bold fs-4">
                                    {{ Auth::user()->completedCourses()->count() ?? 0 }}
                                </div>
                                <small class="text-muted">Completed</small>
                            </div>
                            <div class="col-6">
                                <div class="text-warning fw-bold fs-4">
                                    {{ Auth::user()->enrolled_at ? now()->diffInDays(Auth::user()->enrolled_at) : 0 }}
                                </div>
                                <small class="text-muted">Days Active</small>
                            </div>
                            <div class="col-6">
                                <div class="text-info fw-bold fs-4">
                                    {{ Auth::user()->last_login_at ? now()->diffForHumans(Auth::user()->last_login_at, true) : 'Never' }}
                                </div>
                                <small class="text-muted">Last Login</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Account Details Column -->
            <div class="col-xl-8">
                <form id="account-settings-form" action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-4">Personal Information</h5>
                            
                            <!-- Full Name -->
                            <div class="row mb-3">
                                <div class="col-lg-7">
                                    <label for="name" class="form-label fw-medium">Full Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-user text-muted"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               id="name" 
                                               name="name" 
                                               value="{{ old('name', Auth::user()->name) }}" 
                                               placeholder="Enter Your Full Name"
                                               required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Email Address -->
                            <div class="row mb-3">
                                <div class="col-lg-7">
                                    <label for="email" class="form-label fw-medium">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-envelope text-muted"></i>
                                        </span>
                                        <input type="disabled" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               id="email" 
                                               name="email" 
                                               value="{{ old('email', Auth::user()->email) }}" 
                                               placeholder="Email"
                                               required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Phone Number -->
                            <div class="row mb-3">
                                <div class="col-lg-7">
                                    <label for="phone" class="form-label fw-medium">Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-phone text-muted"></i>
                                        </span>
                                        <input type="tel" 
                                               class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" 
                                               name="phone" 
                                               value="{{ old('phone', Auth::user()->phone) }}" 
                                               placeholder="+1 (123) 456-7890">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Bio/Description -->
                            <div class="row mb-4">
                                <div class="col-lg-10">
                                    <label for="bio" class="form-label fw-medium">Bio/Description</label>
                                    <textarea class="form-control @error('bio') is-invalid @enderror" 
                                              id="bio" 
                                              name="bio" 
                                              rows="3" 
                                              placeholder="Tell us about yourself...">{{ old('bio', Auth::user()->bio) }}</textarea>
                                    <small class="text-muted">Maximum 500 characters</small>
                                    @error('bio')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="row">
                                <div class="col-lg-7">
                                    <button type="submit" 
                                            class="theme-btn style-one w-100 d-flex justify-content-between align-items-center"
                                            style="border-radius: 8px">
                                        <span>Save Changes</span>
                                        <i class="fas fa-save"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

               

                
                <!-- Additional Account Settings -->
                <div class="row">
                    <!-- Password Change -->
                    <div class="col-lg-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-3">Change Password</h5>
                                <form id="password-change-form" action="{{ route('profile.password.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Current Password</label>
                                        <input type="password" 
                                               class="form-control @error('current_password') is-invalid @enderror" 
                                               id="current_password" 
                                               name="current_password"
                                               placeholder="Enter current password">
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">New Password</label>
                                        <input type="password" 
                                               class="form-control @error('new_password') is-invalid @enderror" 
                                               id="new_password" 
                                               name="new_password"
                                               placeholder="Enter new password">
                                        @error('new_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                        <input type="password" 
                                               class="form-control" 
                                               id="new_password_confirmation" 
                                               name="new_password_confirmation"
                                               placeholder="Confirm new password">
                                    </div>
                                    
                                    <button type="submit" class="theme-btn style-one w-100" style="border-radius: 10px">
                                        <i class="fas fa-key me-2"></i>Update Password
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Account Preferences -->
                    <div class="col-lg-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-3">Preferences</h5>
                                
                                <form id="preferences-form" action="{{ route('preferences.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="email_notifications" 
                                               name="email_notifications"
                                               {{ Auth::user()->email_notifications ? 'checked' : '' }}>
                                        <label class="form-check-label" for="email_notifications">
                                            Email Notifications
                                        </label>
                                        <small class="text-muted d-block">Receive updates about new courses and promotions</small>
                                    </div>
                                    
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="sms_notifications" 
                                               name="sms_notifications"
                                               {{ Auth::user()->sms_notifications ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sms_notifications">
                                            SMS Notifications
                                        </label>
                                        <small class="text-muted d-block">Receive text message updates</small>
                                    </div>
                                    
                                    <div class="form-check form-switch mb-4">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="newsletter_subscription" 
                                               name="newsletter_subscription"
                                               {{ Auth::user()->newsletter_subscription ? 'checked' : '' }}>
                                        <label class="form-check-label" for="newsletter_subscription">
                                            Newsletter Subscription
                                        </label>
                                        <small class="text-muted d-block">Receive our weekly newsletter</small>
                                    </div>
                                    
                                    <button type="submit" class="theme-btn style-two w-100" style="border-radius: 10px; background-color: #fff;" >
                                        <i class="fas fa-cog me-2"></i>Save Preferences
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--====== End My Learning ======-->
@endsection

@push('styles')
<style>
    /* Profile Picture Hover Effect */
    .profile-picture-container:hover .profile-upload-overlay {
        opacity: 1 !important;
    }
    
    /* Custom Card Styles */
    .card {
        border-radius: 12px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }
    
    /* Form Control Focus */
    .form-control:focus {
        border-color: #0A1F44;
        box-shadow: 0 0 0 0.25rem rgba(10, 31, 68, 0.25);
    }
    
    /* Theme Button Custom */
    .theme-btn.style-one {
        background: linear-gradient(135deg, #0A1F44 0%, #1a3a7a 100%);
        border: none;
        padding: 12px 24px;
        transition: all 0.3s ease;
    }
    
    .theme-btn.style-one:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(10, 31, 68, 0.3);
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .profile-picture-container img {
            width: 150px !important;
            height: 150px !important;
        }
    }
    
    @media (max-width: 576px) {
        .profile-picture-container img {
            width: 120px !important;
            height: 120px !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Upload profile picture via AJAX
    async function uploadProfilePicture(file) {
        console.log('Starting upload for file:', file.name, 'Size:', file.size);
        
        const formData = new FormData();
        formData.append('profile_picture', file);
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'PUT');
        
        // Show progress
        const progressBar = document.getElementById('progress-bar');
        const uploadProgress = document.getElementById('upload-progress');
        const messageDiv = document.getElementById('upload-message');
        
        uploadProgress.classList.remove('d-none');
        progressBar.style.width = '0%';
        
        try {
            const response = await fetch('{{ route("profile.picture.update") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            
            // Hide progress
            uploadProgress.classList.add('d-none');
            progressBar.style.width = '0%';
            
            // Get response text first to see what we're getting
            const responseText = await response.text();
            console.log('Raw response:', responseText);
            
            let data;
            try {
                data = JSON.parse(responseText);
                console.log('Parsed JSON:', data);
            } catch (parseError) {
                console.error('Failed to parse JSON:', parseError);
                
                // Check if it's HTML or other content
                if (responseText.includes('<!DOCTYPE html>') || responseText.includes('<html')) {
                    // It's HTML, probably a redirect or error page
                    messageDiv.innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            Server returned HTML instead of JSON. Check Laravel logs.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    `;
                } else {
                    // Some other text
                    messageDiv.innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            Invalid server response format. Received: ${responseText.substring(0, 100)}...
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    `;
                }
                revertToOriginalImage();
                return;
            }
            
            // Handle the response
            if (data.success) {
                messageDiv.innerHTML = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        ${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
                
                // Update image URL
                if (data.image_url) {
                    document.getElementById('profile-preview').src = data.image_url;
                }
                
                // Show remove button if hidden
                const removeBtn = document.querySelector('button[onclick="removeProfilePicture()"]');
                if (removeBtn) {
                    removeBtn.style.display = 'block';
                }
                
            } else {
                // Handle error
                let errorMessage = data.message || 'Upload failed';
                if (data.errors) {
                    errorMessage += ': ' + (typeof data.errors === 'string' ? data.errors : Object.values(data.errors).join(', '));
                }
                
                messageDiv.innerHTML = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        ${errorMessage}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
                
                revertToOriginalImage();
            }
            
        } catch (error) {
            console.error('Network error:', error);
            
            uploadProgress.classList.add('d-none');
            progressBar.style.width = '0%';
            
            messageDiv.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    Network error: ${error.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            revertToOriginalImage();
        }
        
        // Auto-remove alerts after 5 seconds
        setTimeout(() => {
            messageDiv.innerHTML = '';
        }, 5000);
    }
    
    // Preview selected profile image
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            
            // Validate file size (5MB = 5 * 1024 * 1024 bytes)
            const maxSize = 5 * 1024 * 1024;
            if (file.size > maxSize) {
                alert('File is too large. Maximum size is 5MB.');
                input.value = ''; // Clear the input
                return;
            }
            
            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                alert('Invalid file type. Only JPEG, PNG, JPG, GIF, and WEBP are allowed.');
                input.value = ''; // Clear the input
                return;
            }
            
            // Show preview
            const reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById('profile-preview').src = e.target.result;
                uploadProfilePicture(file);
            };
            
            reader.onerror = function(e) {
                alert('Error reading the image file. Please try another image.');
                input.value = ''; // Clear the input
            };
            
            reader.readAsDataURL(file);
        }
    }
    
    function revertToOriginalImage() {
        const originalImage = '{{ Auth::user()->profile_picture ? Storage::url(Auth::user()->profile_picture) : "https://ui-avatars.com/api/?name=" . urlencode(Auth::user()->name) . "&background=0A1F44&color=fff&size=200" }}';
        document.getElementById('profile-preview').src = originalImage;
    }
    
    // Remove profile picture
    async function removeProfilePicture() {
        if (confirm('Are you sure you want to remove your profile picture?')) {
            try {
                const response = await fetch('/profile/picture', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                });
                
                const responseText = await response.text();
                let data;
                
                try {
                    data = JSON.parse(responseText);
                } catch (e) {
                    console.error('Failed to parse remove response:', e);
                    alert('Invalid server response when removing picture.');
                    return;
                }
                
                if (data.success) {
                    // Update to default image
                    const defaultImage = `https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0A1F44&color=fff&size=200`;
                    document.getElementById('profile-preview').src = defaultImage;
                    
                    // Show success message
                    document.getElementById('upload-message').innerHTML = `
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            ${data.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    `;
                    
                    // Hide remove button
                    const removeBtn = document.querySelector('button[onclick="removeProfilePicture()"]');
                    if (removeBtn) {
                        removeBtn.style.display = 'none';
                    }
                } else {
                    alert(data.message || 'Failed to remove profile picture');
                }
                
            } catch (error) {
                console.error('Remove error:', error);
                alert('Network error when removing picture.');
            }
        }
    }
    
    // Debug: Log when scripts load
    console.log('Profile page scripts loaded successfully');
</script>
@endpush