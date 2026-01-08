@extends('admin.layouts.app')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Edit Event: {{ $event->title }}</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">
                <a href="{{ route('admin.events.index') }}" class="hover-text-primary">Events</a>
            </li>
            <li>-</li>
            <li class="fw-medium">Edit Event</li>
        </ul>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

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

    <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row gy-4">
            <div class="col-lg-8">
                <!-- Event Basic Information -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Event Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-12">
                                <label class="form-label">Event Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                       placeholder="Enter event title" value="{{ old('title', $event->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Short Description <span class="text-danger">*</span></label>
                                <textarea name="short_description" class="form-control @error('short_description') is-invalid @enderror" 
                                          rows="3" placeholder="Brief description of the event (max 500 characters)" required>{{ old('short_description', $event->short_description) }}</textarea>
                                @error('short_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Full Description <span class="text-danger">*</span></label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                          rows="8" placeholder="Detailed description of the event..." required>{{ old('description', $event->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Event Image</label>
                                <input class="form-control @error('image') is-invalid @enderror" 
                                       type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                                @if($event->image)
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" name="remove_image" id="removeImage">
                                        <label class="form-check-label text-danger" for="removeImage">
                                            Remove current image
                                        </label>
                                    </div>
                                @endif
                                <p class="text-sm mt-1 mb-0 text-muted">
                                    Recommended size: 1200x630px. Supported formats: JPG, PNG, GIF, WEBP. Max size: 2MB
                                </p>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Event Date & Time -->
                <div class="card mt-24">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Date & Time</h6>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <label class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" 
                                       value="{{ old('start_date', $event->start_date->format('Y-m-d')) }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">End Date <span class="text-danger">*</span></label>
                                <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" 
                                       value="{{ old('end_date', $event->end_date->format('Y-m-d')) }}" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Start Time <span class="text-danger">*</span></label>
                                <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror" 
                                       value="{{ old('start_time', $event->start_time) }}" required>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">End Time <span class="text-danger">*</span></label>
                                <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror" 
                                       value="{{ old('end_time', $event->end_time) }}" required>
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Event Location -->
                <div class="card mt-24">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Location Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-12">
                                <label class="form-label">Location <span class="text-danger">*</span></label>
                                <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" 
                                       placeholder="e.g., New York, NY" value="{{ old('location', $event->location) }}" required>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Venue Name</label>
                                <input type="text" name="venue" class="form-control @error('venue') is-invalid @enderror" 
                                       placeholder="e.g., Convention Center" value="{{ old('venue', $event->venue) }}">
                                @error('venue')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Full Address</label>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror" 
                                          rows="3" placeholder="Full street address">{{ old('address', $event->address) }}</textarea>
                                @error('address')
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
                                          rows="3" placeholder="Brief description for search engines (max 160 characters)">{{ old('meta_description', $event->meta_description) }}</textarea>
                                <div class="d-flex justify-content-between mt-1">
                                    <small class="text-muted">Recommended: 150-160 characters</small>
                                    <small class="character-count" data-target="meta_description">{{ strlen(old('meta_description', $event->meta_description)) }}/160</small>
                                </div>
                                @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" name="meta_keywords" class="form-control @error('meta_keywords') is-invalid @enderror" 
                                       placeholder="keyword1, keyword2, keyword3" value="{{ old('meta_keywords', $event->meta_keywords) }}">
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
                <!-- Event Settings -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Event Settings</h6>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-12">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="draft" {{ old('status', $event->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status', $event->status) == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                           
                            <div class="col-12">
                                <label class="form-label">Capacity <span class="text-danger">*</span></label>
                                <input type="number" name="capacity" class="form-control @error('capacity') is-invalid @enderror" 
                                       placeholder="100" value="{{ old('capacity', $event->capacity) }}" min="{{ $event->capacity - $event->available_seats }}" required>
                                <p class="text-sm mt-1 mb-0 text-muted">
                                    Currently booked: {{ $event->capacity - $event->available_seats }} seats
                                </p>
                                @error('capacity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $event->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        Feature this event
                                    </label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="border-top pt-3 mt-3">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary flex-grow-1">
                                            <iconify-icon icon="ic:baseline-save" class="icon me-2"></iconify-icon>
                                            Update Event
                                        </button>
                                        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
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
                        <h6 class="card-title mb-0">Event Image</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            @if($event->image)
                                <div id="currentImage" class="mb-3">
                                    <img src="{{ asset('storage/' . $event->image) }}" alt="Current event image" 
                                         class="img-fluid rounded-8 border" style="max-height: 200px;">
                                    <div class="mt-2">
                                        <small class="text-muted">Current image</small>
                                    </div>
                                </div>
                            @endif
                            <div id="imagePreview" class="mb-3" style="display: none;">
                                <img id="previewImage" src="#" alt="New image preview" 
                                     class="img-fluid rounded-8 border" style="max-height: 200px;">
                                <div class="mt-2">
                                    <small class="text-muted">New image preview</small>
                                </div>
                            </div>
                            @if(!$event->image)
                                <div id="noImagePlaceholder" class="text-muted py-4">
                                    <iconify-icon icon="mdi:image-outline" class="icon-3x mb-2"></iconify-icon>
                                    <p class="mb-0">No image available</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Event Information -->
                <div class="card mt-24">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Event Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">Created:</small>
                                <small class="fw-medium">{{ $event->created_at->format('M d, Y') }}</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">Last Updated:</small>
                                <small class="fw-medium">{{ $event->updated_at->format('M d, Y') }}</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">Author:</small>
                                <small class="fw-medium">{{ $event->user->name ?? 'Unknown' }}</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">Available Seats:</small>
                                <small class="fw-medium">{{ $event->available_seats }}/{{ $event->capacity }}</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">Registration:</small>
                                <small class="badge bg-{{ $event->registration_status === 'sold_out' ? 'danger' : ($event->registration_status === 'few_seats' ? 'warning' : 'success') }}">
                                    {{ $event->registration_status === 'sold_out' ? 'Sold Out' : ($event->registration_status === 'few_seats' ? 'Few Seats' : 'Available') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview functionality
    const imageInput = document.querySelector('input[name="image"]');
    const imagePreview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    const noImagePlaceholder = document.getElementById('noImagePlaceholder');
    const currentImage = document.getElementById('currentImage');
    const removeImageCheckbox = document.getElementById('removeImage');

    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    imagePreview.style.display = 'block';
                    if (noImagePlaceholder) noImagePlaceholder.style.display = 'none';
                    if (currentImage) currentImage.style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        });
    }

    if (removeImageCheckbox && currentImage) {
        removeImageCheckbox.addEventListener('change', function() {
            if (this.checked) {
                currentImage.style.opacity = '0.5';
            } else {
                currentImage.style.opacity = '1';
            }
        });
    }

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
    }

    // Date validation
    const startDate = document.querySelector('input[name="start_date"]');
    const endDate = document.querySelector('input[name="end_date"]');

    if (startDate && endDate) {
        startDate.addEventListener('change', function() {
            endDate.min = this.value;
        });
    }
});
</script>
@endpush