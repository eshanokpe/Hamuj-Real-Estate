@extends('admin.layouts.app')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Edit Course: {{ $course->title }}</h6>
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
            <li class="fw-medium">Edit Course</li>
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

    <form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
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
                                       placeholder="Enter course title" value="{{ old('title', $course->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Short Title <span class="text-danger">*</span></label>
                                <input type="text" name="short_title" class="form-control @error('short_title') is-invalid @enderror" 
                                       placeholder="e.g., CGFCS" value="{{ old('short_title', $course->short_title) }}" required>
                                @error('short_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Short Description <span class="text-danger">*</span></label>
                                <textarea name="short_description" class="form-control @error('short_description') is-invalid @enderror" 
                                          rows="3" placeholder="Brief description of the course (max 500 characters)" required>{{ old('short_description', $course->short_description) }}</textarea>
                                @error('short_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Full Description <span class="text-danger">*</span></label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                          rows="8" placeholder="Detailed description of the course..." required>{{ old('description', $course->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Course Image</label>
                                @if($course->image)
                                    <div class="mb-3">
                                        <img src="{{ $course->image_url }}" alt="Current image" 
                                             class="img-fluid rounded-8 mb-2" style="max-height: 150px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image" value="1">
                                            <label class="form-check-label" for="remove_image">
                                                Remove current image
                                            </label>
                                        </div>
                                    </div>
                                @endif
                                <input class="form-control @error('image') is-invalid @enderror" 
                                       type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                                <p class="text-sm mt-1 mb-0 text-muted">
                                    Recommended size: 400x300px. Supported formats: JPG, PNG, GIF, WEBP. Max size: 2MB
                                </p>
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
                                                <option value="none" {{ old('video_type', $course->video_type) == 'none' ? 'selected' : '' }}>No Video</option>
                                                <option value="upload" {{ old('video_type', $course->video_type) == 'upload' ? 'selected' : '' }}>Upload Video</option>
                                                <option value="youtube" {{ old('video_type', $course->video_type) == 'youtube' ? 'selected' : '' }}>YouTube Video</option>
                                                <option value="vimeo" {{ old('video_type', $course->video_type) == 'vimeo' ? 'selected' : '' }}>Vimeo Video</option>
                                            </select>
                                            @error('video_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Current Video Preview -->
                                        @if($course->video_type !== 'none' && ($course->video_url || $course->video))
                                            <div class="col-12">
                                                <div class="current-video mb-3">
                                                    <label class="form-label">Current Video:</label>
                                                    @if($course->video_type === 'upload' && $course->video)
                                                        <video controls class="w-100 rounded-8" style="max-height: 200px;">
                                                            <source src="{{ $course->video_url }}" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    @elseif($course->video_embed_code)
                                                        <iframe src="{{ $course->video_embed_code }}" 
                                                                width="100%" 
                                                                height="200" 
                                                                frameborder="0" 
                                                                allowfullscreen 
                                                                class="rounded-8"></iframe>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Upload Video Field -->
                                        <div class="col-12 video-upload-field" style="display: {{ old('video_type', $course->video_type) == 'upload' ? 'block' : 'none' }};">
                                            <label class="form-label">Upload Video File</label>
                                            <input class="form-control @error('video') is-invalid @enderror" 
                                                type="file" name="video" accept="video/mp4,video/mov,video/avi,video/wmv,video/mkv">
                                            <p class="text-sm mt-1 mb-0 text-muted">
                                                Supported formats: MP4, MOV, AVI, WMV, MKV. Max size: 50MB
                                            </p>
                                            @error('video')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- YouTube/Vimeo URL Field -->
                                        <div class="col-12 video-url-field" style="display: {{ in_array(old('video_type', $course->video_type), ['youtube', 'vimeo']) ? 'block' : 'none' }};">
                                            <label class="form-label">Video URL</label>
                                            <input type="url" name="video_url" class="form-control @error('video_url') is-invalid @enderror" 
                                                placeholder="https://www.youtube.com/watch?v=..." value="{{ old('video_url', $course->video_url) }}">
                                            <p class="text-sm mt-1 mb-0 text-muted" id="videoUrlHelp">
                                                Enter the full YouTube or Vimeo video URL
                                            </p>
                                            @error('video_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
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
                                    <option value="beginner" {{ old('level', $course->level) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="intermediate" {{ old('level', $course->level) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="advanced" {{ old('level', $course->level) == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                    <option value="expert" {{ old('level', $course->level) == 'expert' ? 'selected' : '' }}>Expert</option>
                                </select>
                                @error('level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Format <span class="text-danger">*</span></label>
                                <select name="format" class="form-select @error('format') is-invalid @enderror" required>
                                    <option value="self_paced" {{ old('format', $course->format) == 'self_paced' ? 'selected' : '' }}>Self-Paced</option>
                                    <option value="instructor_led" {{ old('format', $course->format) == 'instructor_led' ? 'selected' : '' }}>Instructor-Led</option>
                                    <option value="hybrid" {{ old('format', $course->format) == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                </select>
                                @error('format')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Duration <span class="text-danger">*</span></label>
                                <input type="text" name="duration" class="form-control @error('duration') is-invalid @enderror" 
                                       placeholder="e.g., 6 weeks, 40 hours" value="{{ old('duration', $course->duration) }}" required>
                                @error('duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Total Modules <span class="text-danger">*</span></label>
                                <input type="number" name="modules_count" class="form-control @error('modules_count') is-invalid @enderror" 
                                       placeholder="18" value="{{ old('modules_count', $course->modules_count) }}" min="1" required>
                                @error('modules_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Completed Modules</label>
                                <input type="number" name="completed_modules" class="form-control @error('completed_modules') is-invalid @enderror" 
                                       placeholder="12" value="{{ old('completed_modules', $course->completed_modules) }}" min="0">
                                @error('completed_modules')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Certification</label>
                                <input type="text" name="certification" class="form-control @error('certification') is-invalid @enderror" 
                                       placeholder="e.g., Certified GRC & Financial Crime Specialist" value="{{ old('certification', $course->certification) }}">
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
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                                       placeholder="0.00" value="{{ old('price', $course->price) }}" step="0.01" min="0">
                                <p class="text-sm mt-1 mb-0 text-muted">Leave as 0 for free courses</p>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Discount Price ($)</label>
                                <input type="number" name="discount_price" class="form-control @error('discount_price') is-invalid @enderror" 
                                       placeholder="0.00" value="{{ old('discount_price', $course->discount_price) }}" step="0.01" min="0">
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
                                          rows="4" placeholder="What will students learn from this course?">{{ old('learning_outcomes', $course->learning_outcomes) }}</textarea>
                                @error('learning_outcomes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Prerequisites</label>
                                <textarea name="prerequisites" class="form-control @error('prerequisites') is-invalid @enderror" 
                                          rows="3" placeholder="Requirements before taking this course">{{ old('prerequisites', $course->prerequisites) }}</textarea>
                                @error('prerequisites')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Target Audience</label>
                                <textarea name="target_audience" class="form-control @error('target_audience') is-invalid @enderror" 
                                          rows="3" placeholder="Who is this course for?">{{ old('target_audience', $course->target_audience) }}</textarea>
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
                                <textarea name="meta_description" class="form-control @error('meta_description') is-invalid @enderror" 
                                          rows="3" placeholder="Brief description for search engines (max 160 characters)">{{ old('meta_description', $course->meta_description) }}</textarea>
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
                                       placeholder="keyword1, keyword2, keyword3" value="{{ old('meta_keywords', $course->meta_keywords) }}">
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
                                    <option value="draft" {{ old('status', $course->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status', $course->status) == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="archived" {{ old('status', $course->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $course->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        Feature this course
                                    </label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_popular" id="is_popular" value="1" {{ old('is_popular', $course->is_popular) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_popular">
                                        Mark as popular course
                                    </label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="border-top pt-3 mt-3">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary flex-grow-1">
                                            Update Course
                                        </button>
                                        <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-outline-secondary">
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
                        <h6 class="card-title mb-0">Current Image</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            @if($course->image)
                                <img src="{{ $course->image_url }}" alt="Current course image" 
                                     class="img-fluid rounded-8 border mb-3" style="max-height: 200px;">
                                <p class="text-sm text-muted mb-0">Current course image</p>
                            @else
                                <div class="text-muted py-4">
                                    <iconify-icon icon="mdi:image-outline" class="icon-3x mb-2"></iconify-icon>
                                    <p class="mb-0">No image uploaded</p>
                                </div>
                            @endif
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
                                <small class="text-muted">Keep descriptions updated with current course content</small>
                            </div>
                            <div class="d-flex align-items-start gap-2">
                                <iconify-icon icon="mdi:lightbulb-on-outline" class="icon text-warning mt-1"></iconify-icon>
                                <small class="text-muted">Regularly update progress and modules count</small>
                            </div>
                            <div class="d-flex align-items-start gap-2">
                                <iconify-icon icon="mdi:lightbulb-on-outline" class="icon text-warning mt-1"></iconify-icon>
                                <small class="text-muted">Update pricing and discounts to attract learners</small>
                            </div>
                            <div class="d-flex align-items-start gap-2">
                                <iconify-icon icon="mdi:lightbulb-on-outline" class="icon text-warning mt-1"></iconify-icon>
                                <small class="text-muted">Refresh SEO settings periodically</small>
                            </div>
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
.current-video video {
    max-height: 200px;
    width: 100%;
    object-fit: contain;
    background: #000;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character count for meta description
    const metaDescription = document.querySelector('textarea[name="meta_description"]');
    const characterCount = document.querySelector('.character-count[data-target="meta_description"]');

    if (metaDescription && characterCount) {
        metaDescription.addEventListener('input', function() {
            const length = this.value.length;
            characterCount.textContent = length + '/160';
            
            if (length > 160) {
                characterCount.style.color = '#dc3545';
            } else if (length > 140) {
                characterCount.style.color = '#ffc107';
            } else {
                characterCount.style.color = '#6c757d';
            }
        });

        // Initialize count on page load
        metaDescription.dispatchEvent(new Event('input'));
    }

    // Video type toggle
    const videoTypeSelect = document.getElementById('videoTypeSelect');
    const videoUploadField = document.querySelector('.video-upload-field');
    const videoUrlField = document.querySelector('.video-url-field');
    const videoUrlHelp = document.getElementById('videoUrlHelp');

    if (videoTypeSelect) {
        videoTypeSelect.addEventListener('change', function() {
            const selectedType = this.value;
            
            // Show/hide fields based on selection
            if (selectedType === 'upload') {
                videoUploadField.style.display = 'block';
                videoUrlField.style.display = 'none';
            } else if (selectedType === 'youtube' || selectedType === 'vimeo') {
                videoUploadField.style.display = 'none';
                videoUrlField.style.display = 'block';
                
                // Update help text
                if (selectedType === 'youtube') {
                    videoUrlHelp.textContent = 'Enter the full YouTube video URL (e.g., https://www.youtube.com/watch?v=VIDEO_ID)';
                } else {
                    videoUrlHelp.textContent = 'Enter the full Vimeo video URL (e.g., https://vimeo.com/VIDEO_ID)';
                }
            } else {
                videoUploadField.style.display = 'none';
                videoUrlField.style.display = 'none';
            }
        });
    }

    // Price validation
    const priceInput = document.querySelector('input[name="price"]');
    const discountInput = document.querySelector('input[name="discount_price"]');

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
    const modulesCountInput = document.querySelector('input[name="modules_count"]');
    const completedModulesInput = document.querySelector('input[name="completed_modules"]');

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
});
</script>
@endpush