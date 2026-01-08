@extends('admin.layouts.app')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">View Course: {{ $course->title }}</h6>
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
            <li class="fw-medium">{{ Str::limit($course->title, 30) }}</li>
        </ul>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Course Details Card -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Course Details</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="course-image-container mb-3">
                                @if($course->image)
                                    <img src="{{ $course->image_url }}" alt="{{ $course->title }}" 
                                         class="img-fluid rounded-8 border">
                                @else
                                    <div class="text-center py-4 bg-light rounded-8">
                                        <iconify-icon icon="mdi:image-outline" class="icon-3x text-muted mb-2"></iconify-icon>
                                        <p class="text-muted mb-0">No image</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h4 class="mb-2">{{ $course->title }}</h4>
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="badge bg-primary">{{ $course->short_title }}</span>
                                {!! $course->level_badge !!}
                                {!! $course->format_badge !!}
                                {!! $course->status_badge !!}
                            </div>
                            <p class="text-muted mb-3">{{ $course->short_description }}</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Duration:</strong> {{ $course->duration }}</p>
                                    <p class="mb-1"><strong>Modules:</strong> {{ $course->completed_modules }}/{{ $course->modules_count }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Price:</strong> 
                                        @if($course->has_discount)
                                            <span class="text-decoration-line-through text-muted">${{ number_format($course->price, 2) }}</span>
                                            <span class="text-success">${{ number_format($course->current_price, 2) }}</span>
                                            <span class="badge bg-success ms-1">{{ $course->discount_percentage }}% OFF</span>
                                        @elseif($course->price > 0)
                                            <span>${{ number_format($course->price, 2) }}</span>
                                        @else
                                            <span class="badge bg-success">Free</span>
                                        @endif
                                    </p>
                                    @if($course->certification)
                                        <p class="mb-1"><strong>Certification:</strong> {{ $course->certification }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Video Section -->
                    @if($course->video_type !== 'none' && ($course->video_url || $course->video))
                        <div class="mb-4">
                            <h6 class="mb-2">Course Video</h6>
                            @if($course->video_type === 'upload' && $course->video)
                                <div class="video-container">
                                    <video controls class="w-100 rounded-8" style="max-height: 400px;">
                                        <source src="{{ $course->video_url }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            @elseif($course->video_embed_code)
                                <div class="video-container">
                                    <iframe src="{{ $course->video_embed_code }}" 
                                            width="100%" 
                                            height="400" 
                                            frameborder="0" 
                                            allowfullscreen 
                                            class="rounded-8"></iframe>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Description -->
                    <div class="mb-4">
                        <h6 class="mb-2">Description</h6>
                        <div class="bg-light p-3 rounded-8">
                            {!! nl2br(e($course->description)) !!}
                        </div>
                    </div>

                    <!-- Additional Details -->
                    <div class="row">
                        @if($course->learning_outcomes)
                            <div class="col-md-6 mb-3">
                                <h6 class="mb-2">Learning Outcomes</h6>
                                <div class="bg-light p-3 rounded-8">
                                    {!! nl2br(e($course->learning_outcomes)) !!}
                                </div>
                            </div>
                        @endif
                        
                        @if($course->prerequisites)
                            <div class="col-md-6 mb-3">
                                <h6 class="mb-2">Prerequisites</h6>
                                <div class="bg-light p-3 rounded-8">
                                    {!! nl2br(e($course->prerequisites)) !!}
                                </div>
                            </div>
                        @endif
                        
                        @if($course->target_audience)
                            <div class="col-12 mb-3">
                                <h6 class="mb-2">Target Audience</h6>
                                <div class="bg-light p-3 rounded-8">
                                    {!! nl2br(e($course->target_audience)) !!}
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- SEO Information -->
                    @if($course->meta_description || $course->meta_keywords)
                        <div class="border-top pt-3 mt-3">
                            <h6 class="mb-2">SEO Information</h6>
                            @if($course->meta_description)
                                <p><strong>Meta Description:</strong> {{ $course->meta_description }}</p>
                            @endif
                            @if($course->meta_keywords)
                                <p><strong>Meta Keywords:</strong> {{ $course->meta_keywords }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Course Information Sidebar -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">Course Information</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Status:</span>
                            <span>{!! $course->status_badge !!}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Featured:</span>
                            <span>
                                @if($course->is_featured)
                                    <iconify-icon icon="mdi:star" class="icon text-warning"></iconify-icon>
                                @else
                                    <iconify-icon icon="mdi:star-outline" class="icon text-muted"></iconify-icon>
                                @endif
                            </span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Popular:</span>
                            <span>
                                @if($course->is_popular)
                                    <iconify-icon icon="mdi:fire" class="icon text-danger"></iconify-icon>
                                @else
                                    <iconify-icon icon="mdi:fire-outline" class="icon text-muted"></iconify-icon>
                                @endif
                            </span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Created:</span>
                            <span>{{ $course->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Updated:</span>
                            <span>{{ $course->updated_at->format('M d, Y') }}</span>
                        </div>
                        @if($course->user)
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Created By:</span>
                                <span>{{ $course->user->name }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Progress Overview -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">Progress Overview</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="progress mb-2" style="height: 10px;">
                            <div class="progress-bar" role="progressbar" 
                                 style="width: {{ $course->progress_percentage }}%; background-color: #0A1F44;" 
                                 aria-valuenow="{{ $course->progress_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="text-lg fw-bold">{{ $course->progress_percentage }}% Complete</div>
                        <div class="text-sm text-muted">{{ $course->completed_modules }} of {{ $course->modules_count }} modules</div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-primary">
                            <iconify-icon icon="lucide:edit" class="icon me-2"></iconify-icon>
                            Edit Course
                        </a>
                        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">
                            <iconify-icon icon="mdi:arrow-left" class="icon me-2"></iconify-icon>
                            Back to Courses
                        </a>
                        
                        <div class="d-flex gap-2 mt-2">
                            <!-- Toggle Status -->
                            <form action="{{ route('admin.courses.toggle-status', $course) }}" method="POST" class="flex-grow-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-warning w-100">
                                    <iconify-icon icon="mdi:swap-horizontal" class="icon me-2"></iconify-icon>
                                    Toggle Status
                                </button>
                            </form>
                            
                            <!-- Delete Form -->
                            <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="flex-grow-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100" 
                                        onclick="return confirm('Are you sure you want to delete this course?')">
                                    <iconify-icon icon="fluent:delete-24-regular" class="icon me-2"></iconify-icon>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.course-image-container {
    max-height: 300px;
    overflow: hidden;
    border-radius: 8px;
}
.course-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.video-container {
    position: relative;
    width: 100%;
    padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
    height: 0;
    overflow: hidden;
    border-radius: 8px;
}
.video-container iframe,
.video-container video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
}
</style>
@endpush