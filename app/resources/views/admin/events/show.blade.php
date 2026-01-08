@extends('admin.layouts.app')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Event Details: {{ $event->title }}</h6>
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
            <li class="fw-medium">View Event</li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col-lg-8">
            <!-- Event Content Card -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="card-title mb-0">Event Details</h6>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-{{ $event->status === 'published' ? 'success' : ($event->status === 'cancelled' ? 'danger' : 'warning') }}">
                            {{ ucfirst($event->status) }}
                        </span>
                        @if($event->is_featured)
                            <span class="badge bg-warning">
                                <iconify-icon icon="mdi:star" class="icon me-1"></iconify-icon>
                                Featured
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <h2 class="h4 mb-3 text-secondary-light">{{ $event->title }}</h2>
                    
                    @if($event->image)
                    <div class="featured-image mb-4">
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" 
                             class="img-fluid rounded-12 w-100" style="max-height: 400px; object-fit: cover;"
                             onerror="this.src='{{ asset('images/default-event.jpg') }}'">
                    </div>
                    @endif

                    <div class="event-short-description mb-4">
                        <p class="lead text-muted">{{ $event->short_description }}</p>
                    </div>

                    <div class="event-content">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>
            </div>

            <!-- Event Date & Location -->
            <div class="card mt-24">
                <div class="card-header">
                    <h6 class="card-title mb-0">Event Schedule & Location</h6>
                </div>
                <div class="card-body">
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-primary-50 rounded-8 p-3 text-center" style="width: 60px;">
                                    <iconify-icon icon="mdi:calendar" class="icon text-primary-600 text-xl"></iconify-icon>
                                </div>
                                <div>
                                    <h6 class="fw-medium mb-1">Date & Time</h6>
                                    <p class="mb-1">{{ $event->event_date }}</p>
                                    <small class="text-muted">{{ $event->event_time }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-success-50 rounded-8 p-3 text-center" style="width: 60px;">
                                    <iconify-icon icon="mdi:map-marker" class="icon text-success-600 text-xl"></iconify-icon>
                                </div>
                                <div>
                                    <h6 class="fw-medium mb-1">Location</h6>
                                    <p class="mb-1">{{ $event->location }}</p>
                                    @if($event->venue)
                                        <small class="text-muted">{{ $event->venue }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($event->address)
                        <div class="col-12">
                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-info-50 rounded-8 p-3 text-center" style="width: 60px;">
                                    <iconify-icon icon="mdi:home-map-marker" class="icon text-info-600 text-xl"></iconify-icon>
                                </div>
                                <div>
                                    <h6 class="fw-medium mb-1">Address</h6>
                                    <p class="mb-0 text-muted">{{ $event->address }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- SEO Information -->
            @if($event->meta_description || $event->meta_keywords)
            <div class="card mt-24">
                <div class="card-header">
                    <h6 class="card-title mb-0">SEO Information</h6>
                </div>
                <div class="card-body">
                    <div class="row gy-3">
                        @if($event->meta_description)
                        <div class="col-12">
                            <label class="form-label fw-medium">Meta Description</label>
                            <p class="text-muted mb-0">{{ $event->meta_description }}</p>
                        </div>
                        @endif

                        @if($event->meta_keywords)
                        <div class="col-12">
                            <label class="form-label fw-medium">Meta Keywords</label>
                            <p class="text-muted mb-0">{{ $event->meta_keywords }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- Event Information Card -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Event Information</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Status:</span>
                            <span class="badge bg-{{ $event->status === 'published' ? 'success' : ($event->status === 'cancelled' ? 'danger' : 'warning') }}">
                                {{ ucfirst($event->status) }}
                            </span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Capacity:</span>
                            <span class="fw-medium">{{ $event->capacity }} seats</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Available Seats:</span>
                            <span class="fw-medium">{{ $event->available_seats }} seats</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Booked Seats:</span>
                            <span class="fw-medium">{{ $event->capacity - $event->available_seats }} seats</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Registration:</span>
                            <span class="badge bg-{{ $event->registration_status === 'sold_out' ? 'danger' : ($event->registration_status === 'few_seats' ? 'warning' : 'success') }}">
                                {{ $event->registration_status === 'sold_out' ? 'Sold Out' : ($event->registration_status === 'few_seats' ? 'Few Seats Left' : 'Available') }}
                            </span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Featured:</span>
                            <span class="fw-medium">
                                @if($event->is_featured)
                                    <iconify-icon icon="mdi:star" class="icon text-warning"></iconify-icon> Yes
                                @else
                                    <iconify-icon icon="mdi:star-outline" class="icon text-muted"></iconify-icon> No
                                @endif
                            </span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Event Type:</span>
                            <span class="fw-medium">
                                @if($event->is_upcoming)
                                    <span class="badge bg-info">Upcoming</span>
                                @elseif($event->is_ongoing)
                                    <span class="badge bg-success">Ongoing</span>
                                @else
                                    <span class="badge bg-secondary">Past</span>
                                @endif
                            </span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Author:</span>
                            <span class="fw-medium">{{ $event->user->name ?? 'Unknown' }}</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Created:</span>
                            <span class="fw-medium">{{ $event->created_at->format('M d, Y') }}</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Last Updated:</span>
                            <span class="fw-medium">{{ $event->updated_at->format('M d, Y') }}</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Slug:</span>
                            <span class="fw-medium text-end">{{ $event->slug }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons Card -->
            <div class="card mt-24">
                <div class="card-header">
                    <h6 class="card-title mb-0">Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-primary d-flex align-items-center justify-content-center gap-2">
                            <iconify-icon icon="lucide:edit" class="icon"></iconify-icon>
                            Edit Event
                        </a>
                        
                        <form action="{{ route('admin.events.toggle-featured', $event) }}" method="POST" class="d-grid">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-{{ $event->is_featured ? 'warning' : 'secondary' }} d-flex align-items-center justify-content-center gap-2">
                                <iconify-icon icon="mdi:star" class="icon"></iconify-icon>
                                {{ $event->is_featured ? 'Remove Featured' : 'Mark as Featured' }}
                            </button>
                        </form>

                        <form action="{{ route('admin.events.toggle-status', $event) }}" method="POST" class="d-grid">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-{{ $event->status === 'published' ? 'warning' : ($event->status === 'cancelled' ? 'info' : 'success') }} d-flex align-items-center justify-content-center gap-2">
                                <iconify-icon icon="{{ $event->status === 'published' ? 'mdi:archive' : ($event->status === 'cancelled' ? 'mdi:refresh' : 'mdi:publish') }}" class="icon"></iconify-icon>
                                {{ $event->status === 'published' ? 'Move to Draft' : ($event->status === 'cancelled' ? 'Reactivate' : 'Publish') }}
                            </button>
                        </form>

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary flex-grow-1">
                                Back to List
                            </a>
                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="flex-grow-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100" 
                                        onclick="return confirm('Are you sure you want to delete this event? This action cannot be undone.')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats Card -->
            <div class="card mt-24">
                <div class="card-header">
                    <h6 class="card-title mb-0">Event Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Registration Rate:</span>
                            <span class="fw-medium">{{ number_format(($event->capacity - $event->available_seats) / $event->capacity * 100, 1) }}%</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Days Until Event:</span>
                            <span class="fw-medium">
                                @php
                                    $daysUntil = now()->diffInDays($event->start_date, false);
                                @endphp
                                @if($daysUntil > 0)
                                    {{ $daysUntil }} days
                                @elseif($daysUntil == 0)
                                    Today
                                @else
                                    {{ abs($daysUntil) }} days ago
                                @endif
                            </span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Event Duration:</span>
                            <span class="fw-medium">{{ $event->start_date->diffInDays($event->end_date) + 1 }} days</span>
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
.event-content {
    line-height: 1.7;
    font-size: 1.05rem;
    color: #374151;
}

.event-content p {
    margin-bottom: 1.2rem;
}

.event-content h1, .event-content h2, .event-content h3, .event-content h4, .event-content h5, .event-content h6 {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
    color: #1f2937;
    font-weight: 600;
}

.event-content ul, .event-content ol {
    margin-bottom: 1.2rem;
    padding-left: 1.5rem;
}

.event-content li {
    margin-bottom: 0.5rem;
}

.event-content blockquote {
    border-left: 4px solid #3b82f6;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #6b7280;
}

.featured-image {
    border-radius: 12px;
    overflow: hidden;
}

.event-short-description {
    font-size: 1.1rem;
    color: #6b7280;
    border-left: 4px solid #10b981;
    padding-left: 1rem;
    background-color: #f0fdf4;
    padding: 1rem;
    border-radius: 8px;
}
</style>
@endpush