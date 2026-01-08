@extends('admin.layouts.app')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Create New Course</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">
                <a href="{{ route('admin.courses.index') }}" class="hover-text-primary">Courses</a>
            </li>
            <li>-</li>
            <li class="fw-medium">Create Course</li>
        </ul>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <!-- Add this section before the form -->
    @if($errors->has('video'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <h5>Video Upload Debug Info:</h5>
            <ul>
                <li><strong>Max Upload Size:</strong> {{ ini_get('upload_max_filesize') }}</li>
                <li><strong>Max Post Size:</strong> {{ ini_get('post_max_size') }}</li>
                <li><strong>Memory Limit:</strong> {{ ini_get('memory_limit') }}</li>
                <li><strong>Error:</strong> {{ $errors->first('video') }}</li>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- In the video upload section, add: -->
    <div class="alert alert-info">
        <iconify-icon icon="mdi:information" class="icon me-2"></iconify-icon>
        <strong>Upload Limits:</strong>
        <ul class="mb-0 mt-2">
            <li>Maximum video size: 20MB</li>
            <li>Allowed formats: MP4, MOV, AVI, WMV, MKV</li>
            <li>Server limit: {{ ini_get('upload_max_filesize') }}</li>
        </ul>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data" id="courseForm">
        @csrf
        <div class="row gy-4">
            <div class="col-lg-8">
                <!-- Course Basic Information -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Course Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-12">
                                <label class="form-label">Course Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                       placeholder="Enter course title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Short Title <span class="text-danger">*</span></label>
                                <input type="text" name="short_title" class="form-control @error('short_title') is-invalid @enderror" 
                                       placeholder="e.g., CGFCS" value="{{ old('short_title') }}" required>
                                @error('short_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Short Description <span class="text-danger">*</span></label>
                                <textarea name="short_description" class="form-control @error('short_description') is-invalid @enderror" 
                                          rows="3" placeholder="Brief description of the course (max 500 characters)" required maxlength="500">{{ old('short_description') }}</textarea>
                                <div class="d-flex justify-content-between mt-1">
                                    <small class="text-muted">Maximum 500 characters</small>
                                    <small class="character-count" data-target="short_description">0/500</small>
                                </div>
                                @error('short_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Full Description <span class="text-danger">*</span></label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                          rows="8" placeholder="Detailed description of the course..." required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Course Image</label>
                                <div class="file-upload-container">
                                    <input class="form-control @error('image') is-invalid @enderror" 
                                           type="file" name="image" id="imageInput" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                                    <p class="text-sm mt-1 mb-0 text-muted">
                                        Recommended size: 400x300px. Supported formats: JPG, PNG, GIF, WEBP. Max size: 2MB
                                    </p>
                                </div>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Video Upload Section -->
                            <div class="card mt-24">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">Course Video</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row gy-3">
                                        <div class="col-12">
                                            <label class="form-label">Video Type</label>
                                            <select name="video_type" class="form-select @error('video_type') is-invalid @enderror" id="videoTypeSelect">
                                                <option value="none" {{ old('video_type') == 'none' ? 'selected' : '' }}>No Video</option>
                                                <option value="upload" {{ old('video_type') == 'upload' ? 'selected' : '' }}>Upload Video</option>
                                                <option value="youtube" {{ old('video_type') == 'youtube' ? 'selected' : '' }}>YouTube Video</option>
                                                <option value="vimeo" {{ old('video_type') == 'vimeo' ? 'selected' : '' }}>Vimeo Video</option>
                                            </select>
                                            @error('video_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Upload Video Field -->
                                        <div class="col-12 video-upload-field" style="display: {{ old('video_type') == 'upload' ? 'block' : 'none' }};">
                                            <label class="form-label">Upload Video File</label>
                                            <input class="form-control @error('video') is-invalid @enderror" 
                                                type="file" name="video" id="videoFileInput" accept="video/mp4,video/mov,video/avi,video/wmv,video/mkv">
                                            <p class="text-sm mt-1 mb-0 text-muted">
                                                Supported formats: MP4, MOV, AVI, WMV, MKV. Max size: 20MB
                                            </p>
                                            @error('video')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- YouTube/Vimeo URL Field -->
                                        <div class="col-12 video-url-field" style="display: {{ in_array(old('video_type'), ['youtube', 'vimeo']) ? 'block' : 'none' }};">
                                            <label class="form-label">Video URL</label>
                                            <input type="url" name="video_url" id="videoUrlInput" class="form-control @error('video_url') is-invalid @enderror" 
                                                placeholder="https://www.youtube.com/watch?v=..." value="{{ old('video_url') }}">
                                            <p class="text-sm mt-1 mb-0 text-muted" id="videoUrlHelp">
                                                Enter the full YouTube or Vimeo video URL
                                            </p>
                                            @error('video_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Video Preview -->
                                        <div class="col-12">
                                            <div id="videoPreview" class="mt-3" style="display: none;">
                                                <div class="video-preview-container">
                                                    <div id="videoPlayer"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course Details -->
                <div class="card mt-24">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Course Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <label class="form-label">Level <span class="text-danger">*</span></label>
                                <select name="level" class="form-select @error('level') is-invalid @enderror" required>
                                    <option value="beginner" {{ old('level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="intermediate" {{ old('level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="advanced" {{ old('level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                    <option value="expert" {{ old('level') == 'expert' ? 'selected' : '' }}>Expert</option>
                                </select>
                                @error('level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Format <span class="text-danger">*</span></label>
                                <select name="format" class="form-select @error('format') is-invalid @enderror" required>
                                    <option value="self_paced" {{ old('format') == 'self_paced' ? 'selected' : '' }}>Self-Paced</option>
                                    <option value="instructor_led" {{ old('format') == 'instructor_led' ? 'selected' : '' }}>Instructor-Led</option>
                                    <option value="hybrid" {{ old('format') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                </select>
                                @error('format')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Duration <span class="text-danger">*</span></label>
                                <input type="text" name="duration" class="form-control @error('duration') is-invalid @enderror" 
                                       placeholder="e.g., 6 weeks, 40 hours" value="{{ old('duration') }}" required>
                                @error('duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Total Modules <span class="text-danger">*</span></label>
                                <input type="number" name="modules_count" id="modulesCount" class="form-control @error('modules_count') is-invalid @enderror" 
                                       placeholder="18" value="{{ old('modules_count') }}" min="1" required>
                                @error('modules_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Completed Modules</label>
                                <input type="number" name="completed_modules" id="completedModules" class="form-control @error('completed_modules') is-invalid @enderror" 
                                       placeholder="12" value="{{ old('completed_modules', 0) }}" min="0">
                                @error('completed_modules')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Certification</label>
                                <input type="text" name="certification" class="form-control @error('certification') is-invalid @enderror" 
                                       placeholder="e.g., Certified GRC & Financial Crime Specialist" value="{{ old('certification') }}">
                                @error('certification')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing Information -->
                <div class="card mt-24">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Pricing Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <label class="form-label">Regular Price ($)</label>
                                <input type="number" name="price" id="priceInput" class="form-control @error('price') is-invalid @enderror" 
                                       placeholder="0.00" value="{{ old('price') }}" step="0.01" min="0">
                                <p class="text-sm mt-1 mb-0 text-muted">Leave as 0 for free courses</p>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Discount Price ($)</label>
                                <input type="number" name="discount_price" id="discountPrice" class="form-control @error('discount_price') is-invalid @enderror" 
                                       placeholder="0.00" value="{{ old('discount_price') }}" step="0.01" min="0">
                                <p class="text-sm mt-1 mb-0 text-muted">Leave as 0 for no discount</p>
                                @error('discount_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course Content Details -->
                <div class="card mt-24">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Course Content Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-12">
                                <label class="form-label">Learning Outcomes</label>
                                <textarea name="learning_outcomes" class="form-control @error('learning_outcomes') is-invalid @enderror" 
                                          rows="4" placeholder="What will students learn from this course?">{{ old('learning_outcomes') }}</textarea>
                                @error('learning_outcomes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Prerequisites</label>
                                <textarea name="prerequisites" class="form-control @error('prerequisites') is-invalid @enderror" 
                                          rows="3" placeholder="Requirements before taking this course">{{ old('prerequisites') }}</textarea>
                                @error('prerequisites')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Target Audience</label>
                                <textarea name="target_audience" class="form-control @error('target_audience') is-invalid @enderror" 
                                          rows="3" placeholder="Who is this course for?">{{ old('target_audience') }}</textarea>
                                @error('target_audience')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="card mt-24">
                    <div class="card-header">
                        <h6 class="card-title mb-0">SEO Settings</h6>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-12">
                                <label class="form-label">Meta Description</label>
                                <textarea name="meta_description" id="metaDescription" class="form-control @error('meta_description') is-invalid @enderror" 
                                          rows="3" placeholder="Brief description for search engines (max 160 characters)" maxlength="160">{{ old('meta_description') }}</textarea>
                                <div class="d-flex justify-content-between mt-1">
                                    <small class="text-muted">Recommended: 150-160 characters</small>
                                    <small class="character-count" data-target="meta_description">0/160</small>
                                </div>
                                @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" name="meta_keywords" class="form-control @error('meta_keywords') is-invalid @enderror" 
                                       placeholder="keyword1, keyword2, keyword3" value="{{ old('meta_keywords') }}">
                                <p class="text-sm mt-1 mb-0 text-muted">Separate keywords with commas</p>
                                @error('meta_keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Course Settings -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Course Settings</h6>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-12">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        Feature this course
                                    </label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_popular" id="is_popular" value="1" {{ old('is_popular') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_popular">
                                        Mark as popular course
                                    </label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="border-top pt-3 mt-3">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary flex-grow-1">
                                            Create Course
                                        </button>
                                        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">
                                            Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Preview -->
                <div class="card mt-24">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Course Image Preview</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <div id="imagePreview" class="mb-3" style="display: none;">
                                <img id="previewImage" src="#" alt="Course image preview" 
                                     class="img-fluid rounded-8 border" style="max-height: 200px;">
                            </div>
                            <div id="noImagePlaceholder" class="text-muted py-4">
                                <iconify-icon icon="mdi:image-outline" class="icon-3x mb-2"></iconify-icon>
                                <p class="mb-0">No image selected</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Tips -->
                <div class="card mt-24">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Quick Tips</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex align-items-start gap-2">
                                <iconify-icon icon="mdi:lightbulb-on-outline" class="icon text-warning mt-1"></iconify-icon>
                                <small class="text-muted">Use clear, descriptive titles that explain the course value</small>
                            </div>
                            <div class="d-flex align-items-start gap-2">
                                <iconify-icon icon="mdi:lightbulb-on-outline" class="icon text-warning mt-1"></iconify-icon>
                                <small class="text-muted">Add high-quality images to attract learners</small>
                            </div>
                            <div class="d-flex align-items-start gap-2">
                                <iconify-icon icon="mdi:lightbulb-on-outline" class="icon text-warning mt-1"></iconify-icon>
                                <small class="text-muted">Clearly define learning outcomes and prerequisites</small>
                            </div>
                            <div class="d-flex align-items-start gap-2">
                                <iconify-icon icon="mdi:lightbulb-on-outline" class="icon text-warning mt-1"></iconify-icon>
                                <small class="text-muted">Feature popular courses for better visibility</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress Preview -->
                <div class="card mt-24">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Progress Preview</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <div class="progress mb-2" style="height: 8px;">
                                <div id="progressBar" class="progress-bar" role="progressbar" 
                                     style="width: 0%; background-color: #0A1F44;" 
                                     aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div id="progressText" class="text-sm text-muted">0 of 0 modules (0%)</div>
                            <div id="progressTime" class="text-xs text-muted mt-1">0 hours left</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .file-upload-container {
        position: relative;
    }
    .character-count {
        font-size: 0.75rem;
        color: #6c757d;
    }
    #imagePreview {
        transition: all 0.3s ease;
    }
    .video-preview-container {
        position: relative;
        width: 100%;
        padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
        height: 0;
        overflow: hidden;
        border-radius: 8px;
        background: #f8f9fa;
    }

    .video-preview-container iframe,
    .video-preview-container video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }

    .current-video video {
        max-height: 200px;
        width: 100%;
        object-fit: contain;
        background: #000;
    }

    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #dc3545;
    }

    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #dc3545;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Document loaded - initializing course form');

    // Image preview functionality
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    const noImagePlaceholder = document.getElementById('noImagePlaceholder');

    if (imageInput) {
        console.log('Image input found');
        imageInput.addEventListener('change', function(e) {
            console.log('Image input changed');
            const file = e.target.files[0];
            if (file) {
                // Validate file size (2MB max)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Image size should be less than 2MB');
                    this.value = '';
                    return;
                }
                
                // Validate file type
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPG, PNG, GIF, WEBP)');
                    this.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    imagePreview.style.display = 'block';
                    noImagePlaceholder.style.display = 'none';
                }
                reader.onerror = function() {
                    alert('Error reading the image file');
                    imagePreview.style.display = 'none';
                    noImagePlaceholder.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
                noImagePlaceholder.style.display = 'block';
            }
        });
    }

    // Character count functionality
    function setupCharacterCount(textareaSelector, counterSelector) {
        const textarea = document.querySelector(textareaSelector);
        const counter = document.querySelector(counterSelector);
        
        if (textarea && counter) {
            const maxLength = textarea.getAttribute('maxlength') || 160;
            
            function updateCount() {
                const length = textarea.value.length;
                counter.textContent = `${length}/${maxLength}`;
                
                if (length > maxLength) {
                    counter.style.color = '#dc3545';
                } else if (length > (maxLength * 0.9)) {
                    counter.style.color = '#ffc107';
                } else {
                    counter.style.color = '#6c757d';
                }
            }
            
            textarea.addEventListener('input', updateCount);
            updateCount(); // Initial count
        }
    }

    // Set up character counters
    setupCharacterCount('textarea[name="short_description"]', '.character-count[data-target="short_description"]');
    setupCharacterCount('#metaDescription', '.character-count[data-target="meta_description"]');

    // Progress calculation
    const modulesCountInput = document.getElementById('modulesCount');
    const completedModulesInput = document.getElementById('completedModules');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    const progressTime = document.getElementById('progressTime');

    function updateProgress() {
        const modulesCount = parseInt(modulesCountInput.value) || 0;
        const completedModules = parseInt(completedModulesInput.value) || 0;
        
        if (modulesCount > 0) {
            const percentage = Math.round((completedModules / modulesCount) * 100);
            progressBar.style.width = percentage + '%';
            progressBar.setAttribute('aria-valuenow', percentage);
            progressText.textContent = `${completedModules} of ${modulesCount} modules (${percentage}%)`;
            
            // Calculate estimated time left (assuming 30 minutes per module)
            const remainingModules = modulesCount - completedModules;
            const hoursLeft = Math.round(remainingModules * 0.5);
            progressTime.textContent = hoursLeft > 0 ? `${hoursLeft} hours left` : 'Course completed';
        } else {
            progressBar.style.width = '0%';
            progressText.textContent = '0 of 0 modules (0%)';
            progressTime.textContent = 'Set module count';
        }
    }

    if (modulesCountInput && completedModulesInput) {
        modulesCountInput.addEventListener('input', updateProgress);
        completedModulesInput.addEventListener('input', updateProgress);
        updateProgress(); // Initial calculation
    }

    // Price validation
    const priceInput = document.getElementById('priceInput');
    const discountInput = document.getElementById('discountPrice');

    if (priceInput && discountInput) {
        discountInput.addEventListener('input', function() {
            const price = parseFloat(priceInput.value) || 0;
            const discount = parseFloat(this.value) || 0;
            
            if (discount > price) {
                this.setCustomValidity('Discount price cannot be higher than regular price');
            } else {
                this.setCustomValidity('');
            }
        });
    }

    // Modules validation
    if (modulesCountInput && completedModulesInput) {
        completedModulesInput.addEventListener('input', function() {
            const modulesCount = parseInt(modulesCountInput.value) || 0;
            const completed = parseInt(this.value) || 0;
            
            if (completed > modulesCount) {
                this.setCustomValidity('Completed modules cannot exceed total modules');
            } else {
                this.setCustomValidity('');
            }
        });
    }

    // VIDEO FUNCTIONALITY - This is the main fix
    const videoTypeSelect = document.getElementById('videoTypeSelect');
    const videoUploadField = document.querySelector('.video-upload-field');
    const videoUrlField = document.querySelector('.video-url-field');
    const videoUrlHelp = document.getElementById('videoUrlHelp');
    const videoPreview = document.getElementById('videoPreview');
    const videoPlayer = document.getElementById('videoPlayer');
    const videoFileInput = document.getElementById('videoFileInput');
    const videoUrlInput = document.getElementById('videoUrlInput');

    console.log('Video elements:', {
        videoTypeSelect: !!videoTypeSelect,
        videoUploadField: !!videoUploadField,
        videoUrlField: !!videoUrlField,
        videoPreview: !!videoPreview,
        videoPlayer: !!videoPlayer,
        videoFileInput: !!videoFileInput,
        videoUrlInput: !!videoUrlInput
    });

    // Function to show/hide video fields based on selection
    function updateVideoFields() {
        if (!videoTypeSelect) return;
        
        const selectedType = videoTypeSelect.value;
        console.log('Video type selected:', selectedType);
        
        // Always hide both fields first
        if (videoUploadField) videoUploadField.style.display = 'none';
        if (videoUrlField) videoUrlField.style.display = 'none';
        if (videoPreview) videoPreview.style.display = 'none';
        if (videoPlayer) videoPlayer.innerHTML = '';
        
        // Show appropriate field based on selection
        if (selectedType === 'upload') {
            if (videoUploadField) {
                videoUploadField.style.display = 'block';
                console.log('Showing upload field');
            }
        } else if (selectedType === 'youtube' || selectedType === 'vimeo') {
            if (videoUrlField) {
                videoUrlField.style.display = 'block';
                console.log('Showing URL field');
            }
            
            // Update help text
            if (videoUrlHelp) {
                if (selectedType === 'youtube') {
                    videoUrlHelp.textContent = 'Enter the full YouTube video URL (e.g., https://www.youtube.com/watch?v=VIDEO_ID)';
                } else {
                    videoUrlHelp.textContent = 'Enter the full Vimeo video URL (e.g., https://vimeo.com/VIDEO_ID)';
                }
            }
        }
    }

    // Initialize video fields on page load
    updateVideoFields();

    // Handle video type change
    if (videoTypeSelect) {
        videoTypeSelect.addEventListener('change', function() {
            console.log('Video type changed to:', this.value);
            updateVideoFields();
            
            // Clear any existing preview
            if (videoPlayer) {
                videoPlayer.innerHTML = '';
            }
        });
    }

    // Handle video URL input for YouTube/Vimeo
    if (videoUrlInput) {
        videoUrlInput.addEventListener('input', function() {
            const url = this.value.trim();
            const videoType = videoTypeSelect ? videoTypeSelect.value : 'none';
            
            if (!url || videoType === 'none' || videoType === 'upload') {
                if (videoPlayer) videoPlayer.innerHTML = '';
                if (videoPreview) videoPreview.style.display = 'none';
                return;
            }
            
            // Wait a bit before processing to avoid too many updates
            setTimeout(() => {
                updateVideoPreview(url, videoType);
            }, 500);
        });
        
        // Also handle blur event for immediate update
        videoUrlInput.addEventListener('blur', function() {
            const url = this.value.trim();
            const videoType = videoTypeSelect ? videoTypeSelect.value : 'none';
            
            if (url && (videoType === 'youtube' || videoType === 'vimeo')) {
                updateVideoPreview(url, videoType);
            }
        });
    }

    // Replace your video file input event listener with this:
    if (videoFileInput) {
        videoFileInput.addEventListener('change', function(e) {
            console.log('Video file selected');
            const file = e.target.files[0];
            
            if (!file) {
                if (videoPlayer) videoPlayer.innerHTML = '';
                if (videoPreview) videoPreview.style.display = 'none';
                return;
            }
            
            // Show file info
            const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
            console.log(`File: ${file.name}, Size: ${fileSizeMB}MB, Type: ${file.type}`);
            
            // Validate file size (20MB max)
            if (file.size > 20 * 1024 * 1024) {
                alert(`File is too large (${fileSizeMB}MB). Maximum size is 20MB.`);
                this.value = '';
                return;
            }
            
            // Validate file type
            const validTypes = ['video/mp4', 'video/quicktime', 'video/x-msvideo', 'video/x-ms-wmv', 'video/x-matroska'];
            if (!validTypes.includes(file.type)) {
                alert('Please select a valid video file (MP4, MOV, AVI, WMV, MKV)');
                this.value = '';
                return;
            }
            
            // Show preview
            try {
                const url = URL.createObjectURL(file);
                if (videoPlayer) {
                    videoPlayer.innerHTML = `
                        <div class="text-center p-3">
                            <div class="mb-2">
                                <iconify-icon icon="mdi:video" class="icon-2x text-primary"></iconify-icon>
                            </div>
                            <div class="mb-2">
                                <strong>${file.name}</strong>
                            </div>
                            <div class="text-muted small mb-3">
                                ${fileSizeMB} MB • ${file.type}
                            </div>
                            <video controls style="width: 100%; max-height: 200px; border-radius: 8px;">
                                <source src="${url}" type="${file.type}">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    `;
                }
                
                if (videoPreview) {
                    videoPreview.style.display = 'block';
                }
                
                console.log('Video preview created successfully');
                
            } catch (error) {
                console.error('Error creating preview:', error);
                alert('Error previewing video. Please try a different file.');
                this.value = '';
            }
        });
    }

    // Function to update video preview
    function updateVideoPreview(url, videoType) {
        if (!videoPlayer) return;
        
        let embedUrl = null;
        
        if (videoType === 'youtube') {
            const videoId = extractYouTubeId(url);
            if (videoId) {
                embedUrl = `https://www.youtube.com/embed/${videoId}`;
            }
        } else if (videoType === 'vimeo') {
            const videoId = extractVimeoId(url);
            if (videoId) {
                embedUrl = `https://player.vimeo.com/video/${videoId}`;
            }
        }
        
        if (embedUrl) {
            videoPlayer.innerHTML = `
                <iframe src="${embedUrl}" 
                        width="100%" 
                        height="100%" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen 
                        style="border-radius: 8px;">
                </iframe>
            `;
            
            // Show preview container
            if (videoPreview) {
                videoPreview.style.display = 'block';
            }
            
            console.log('Video preview updated:', embedUrl);
        } else {
            videoPlayer.innerHTML = '<p class="text-center text-muted py-4">Enter a valid video URL to see preview</p>';
            if (videoPreview) {
                videoPreview.style.display = 'block';
            }
        }
    }

    // Helper functions to extract video IDs
    function extractYouTubeId(url) {
        // Handle various YouTube URL formats
        const patterns = [
            /(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&?\/]+)/,
            /youtube\.com\/.*[?&]v=([^&]+)/,
            /youtu\.be\/([^?]+)/
        ];
        
        for (const pattern of patterns) {
            const match = url.match(pattern);
            if (match && match[1]) {
                return match[1];
            }
        }
        return null;
    }

    function extractVimeoId(url) {
        const pattern = /vimeo\.com\/(?:video\/)?(\d+)/;
        const match = url.match(pattern);
        return match ? match[1] : null;
    }

    // Form validation
    const courseForm = document.getElementById('courseForm');
    if (courseForm) {
        courseForm.addEventListener('submit', function(e) {
            console.log('Form submitted');
            
            // Clear previous custom validity messages
            const inputs = this.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.setCustomValidity('');
            });

            // Validate discount price
            if (discountInput && priceInput) {
                const price = parseFloat(priceInput.value) || 0;
                const discount = parseFloat(discountInput.value) || 0;
                if (discount > price) {
                    discountInput.setCustomValidity('Discount price cannot be higher than regular price');
                    e.preventDefault();
                    discountInput.reportValidity();
                    return;
                }
            }

            // Validate completed modules
            if (completedModulesInput && modulesCountInput) {
                const modulesCount = parseInt(modulesCountInput.value) || 0;
                const completed = parseInt(completedModulesInput.value) || 0;
                if (completed > modulesCount) {
                    completedModulesInput.setCustomValidity('Completed modules cannot exceed total modules');
                    e.preventDefault();
                    completedModulesInput.reportValidity();
                    return;
                }
            }

            // Validate video fields
            const videoType = videoTypeSelect ? videoTypeSelect.value : 'none';
            if (videoType === 'youtube' || videoType === 'vimeo') {
                if (!videoUrlInput || !videoUrlInput.value.trim()) {
                    e.preventDefault();
                    alert('Please enter a video URL for the selected video type');
                    if (videoUrlInput) videoUrlInput.focus();
                    return;
                }
            }
            
            console.log('Form validation passed');
        });
    }

    // Add some debug logging to help troubleshoot
    console.log('All event listeners attached');
});
</script>
@endpush