@extends('layouts.app')

@section('content')

<!--======  Start Page Hero Section  ======-->
<section class="page-hero event-hero mt-100" style="background-image: url({{ $event->image_url }}); background-size: cover; background-repeat: no-repeat; background-position: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="page-content text-center">
                    <p class="text-white">{{ $event->event_date }}</p>
                    <h1 class="text-white">{{ $event->title }}</h1>
                    <p class="text-white mb-0">{{ $event->venue ?: $event->location }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End Page Hero Section  ======-->
                   
<!--======  Start Service Details Section  ======-->
<section class="service-details-sec pt-120 pb-95">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <!--=== Service Details Wrapper ===-->
                <div class="service-details-wrapper">
                    <!-- Event Status and Details -->
                    <div class="row mb-40">
                        <div class="col-md-8">
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                @if($event->is_upcoming)
                                    <span class="badge bg-info">Upcoming</span>
                                @elseif($event->is_ongoing)
                                    <span class="badge bg-success">Ongoing</span>
                                @else
                                    <span class="badge bg-secondary">Past Event</span>
                                @endif
                                
                                @if($event->is_featured)
                                    <span class="badge bg-primary">Featured</span>
                                @endif
                                
                                @if($event->registration_status == 'sold_out')
                                    <span class="badge bg-danger">Sold Out</span>
                                @elseif($event->registration_status == 'few_seats')
                                    <span class="badge bg-warning">Few Seats Left</span>
                                @endif
                                
                                {!! $event->status_badge !!}
                            </div>
                            
                            <div class="event-details-card mb-30">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="far fa-calendar-alt me-3 text-primary"></i>
                                            <div>
                                                <small class="text-muted d-block">Date</small>
                                                <strong>{{ $event->event_date }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="far fa-clock me-3 text-primary"></i>
                                            <div>
                                                <small class="text-muted d-block">Time</small>
                                                <strong>{{ $event->event_time }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="fas fa-map-marker-alt me-3 text-primary"></i>
                                            <div>
                                                <small class="text-muted d-block">Location</small>
                                                <strong>{{ $event->venue }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="fas fa-users me-3 text-primary"></i>
                                            <div>
                                                <small class="text-muted d-block">Seats Available</small>
                                                <strong>{{ $event->available_seats }} / {{ $event->capacity }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($event->address)
                                    <div class="mt-3">
                                        <small class="text-muted d-block">Address</small>
                                        <p class="mb-0">{{ $event->address }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            @if($event->is_upcoming && $event->registration_status != 'sold_out')
                                <div class="card border-primary shadow-sm">
                                    <div class="card-body text-center">
                                        <h5 class="card-title text-primary">Register Now</h5>
                                        <p class="text-muted mb-4">Secure your spot for this event</p>
                                        <a href="{{ route('register', ['event' => $event->slug]) }}" class="btn btn-primary btn-lg w-100">
                                            Book Your Seat
                                        </a>
                                        <small class="text-muted mt-2 d-block">Only {{ $event->available_seats }} seats remaining</small>
                                    </div>
                                </div>
                            @elseif($event->registration_status == 'sold_out')
                                <div class="card border-danger shadow-sm">
                                    <div class="card-body text-center">
                                        <h5 class="card-title text-danger">Sold Out</h5>
                                        <p class="text-muted">All seats have been booked</p>
                                        <button class="btn btn-secondary btn-lg w-100" disabled>
                                            Registration Closed
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!--=== Service Main ===-->
                    <div class="service-item-main mb-60">
                        <!-- Short Description -->
                        @if($event->short_description)
                            <div class="alert alert-info mb-40" data-aos="fade-up" data-aos-duration="800">
                                <p class="lead mb-0">{{ $event->short_description }}</p>
                            </div>
                        @endif
                        
                        <!-- Event Image -->
                        <div class="service-thumbnail mb-40" data-aos="fade-up" data-aos-duration="800">
                            <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="img-fluid rounded">
                        </div>
                        
                        <!-- Main Content -->
                        <div class="service-content" data-aos="fade-up" data-aos-duration="800">
                            <!-- Event Description -->
                            <div class="mb-50">
                                <h4 class="title mb-4">Event Details</h4>
                                <div class="event-description">
                                    {!! $event->description !!}
                                </div>
                            </div>
                            
                            <!-- Additional Information -->
                            @if($event->meta_description || $event->meta_keywords)
                                <div class="mb-50">
                                    <h4 class="title mb-4">Additional Information</h4>
                                    
                                    @if($event->meta_description)
                                        <div class="mb-3">
                                            <h6>Event Overview</h6>
                                            <p>{{ $event->meta_description }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($event->meta_keywords)
                                        <div>
                                            <h6>Topics Covered</h6>
                                            <div class="d-flex flex-wrap gap-2">
                                                @php
                                                    $keywords = explode(',', $event->meta_keywords);
                                                @endphp
                                                @foreach($keywords as $keyword)
                                                    <span class="badge bg-light text-dark border">{{ trim($keyword) }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            
                         
                        </div>
                    </div>
                    
                    <!-- Share Section -->
                    <div class="row justify-content-center text-center">
                        <div class="col-auto">
                            <h6>Share this event</h6>
                            <div class="blog-details-wrapper">
                                <div class="blog-post-main mb-70">
                                    <div class="entry-footer mt-30">
                                        <div class="social-share d-flex justify-content-center gap-3">
                                            @php
                                                $shareUrl = url()->current();
                                                $shareTitle = urlencode($event->title);
                                                $shareDescription = urlencode($event->short_description ?? $event->excerpt);
                                            @endphp
                                            
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                            <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ $shareUrl }}&title={{ $shareTitle }}&summary={{ $shareDescription }}" target="_blank">
                                                <i class="fab fa-linkedin-in"></i>
                                            </a>
                                            <a href="https://api.whatsapp.com/send?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End Service Details Section  ======-->

<!--======  Start Related Events Section  ======-->
@if($relatedEvents && $relatedEvents->count() > 0)
<section class="bizzen-testimonial_three pt-50 pb-120">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <!--=== Section Title ===-->
                <div class="section-title mb-60">
                    <span class="sub-title" data-aos="fade-up" data-aos-duration="800">Events</span>
                    <h2 class="text-anm">Related Events</h2>
                    <p>Check out other events you might be interested in.</p>
                </div>
            </div>
            <div class="col-lg-3"></div>
            <div class="col-lg-3">
                <!--=== View More Button ===-->
                <div class="bizzen-button">
                    <a href="{{ route('events.index') }}" class="theme-btn style-one">View All Events</a>
                </div>
            </div>
        </div>
        
        <!-- Related Events Grid -->
        <div class="row" data-aos="fade-up" data-aos-duration="1000">
            @foreach($relatedEvents as $relatedEvent)
                <div class="col-xl-4 col-md-6 col-sm-12">
                    <!--=== Bizzen Blog Post ===-->
                    <div class="bizzen-blog-post-item style-two mb-35" data-aos="fade-up" data-aos-duration="1000">
                        <div class="post-thumbnail">
                            <img src="{{ $relatedEvent->image_url }}" alt="{{ $relatedEvent->title }}">
                        </div>
                        <div class="post-content">
                            <div class="post-meta">
                                <span>{{ $relatedEvent->event_date }}</span>
                            </div>
                            <h4 class="title">
                                <a href="{{ route('events.show', $relatedEvent->slug) }}">
                                    {{ Str::limit($relatedEvent->title, 50) }}
                                </a>
                            </h4>
                            <p>{{ Str::limit($relatedEvent->short_description ?? $relatedEvent->excerpt, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="badge {{ $relatedEvent->is_upcoming ? 'bg-info' : 'bg-secondary' }}">
                                    {{ $relatedEvent->is_upcoming ? 'Upcoming' : 'Past' }}
                                </span>
                                <a href="{{ route('events.show', $relatedEvent->slug) }}" class="text-primary small">
                                    Learn More <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!--======  End Related Events Section  ======-->

@endsection

@push('styles')
<style>
    /* Event Hero Styles - Scoped to event-hero class only */
    .page-hero.event-hero {
        position: relative;
        min-height: 400px;
        display: flex;
        align-items: center;
    }
    
    .page-hero.event-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.4));
        z-index: 1;
    }
    
    .page-hero.event-hero .container {
        position: relative;
        z-index: 2;
    }
    
    /* Event Details Card */
    .event-details-card {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        border-left: 4px solid #007bff;
    }
    
    /* Organizer Avatar */
    .avatar-placeholder {
        width: 60px;
        height: 60px;
        background: #007bff;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: bold;
    }
    
    /* Social Share Buttons */
    .social-share a {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        color: #333;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .social-share a:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .social-share a:nth-child(1):hover {
        background: #1877f2;
        color: white;
    }
    
    .social-share a:nth-child(2):hover {
        background: #1da1f2;
        color: white;
    }
    
    .social-share a:nth-child(3):hover {
        background: #0077b5;
        color: white;
    }
    
    .social-share a:nth-child(4):hover {
        background: #25d366;
        color: white;
    }
    
    /* Image Styling */
    .service-thumbnail img {
        width: 100%;
        height: auto;
        max-height: 500px;
        object-fit: cover;
    }
    
    /* Badge Styling */
    .badge {
        font-size: 0.8rem;
        padding: 0.35em 0.65em;
    }
    
    .bg-success {
        background-color: #28a745 !important;
    }
    
    .bg-warning {
        background-color: #ffc107 !important;
        color: #212529 !important;
    }
    
    .bg-danger {
        background-color: #dc3545 !important;
    }
    
    .bg-info {
        background-color: #17a2b8 !important;
    }
    
    .bg-primary {
        background-color: #007bff !important;
    }
    
    .bg-secondary {
        background-color: #6c757d !important;
    }
    
    /* Button Styling */
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .page-hero.event-hero {
            min-height: 300px;
        }
        
        .page-hero.event-hero h1 {
            font-size: 1.8rem;
        }
        
        .event-details-card {
            padding: 15px;
        }
        
        .row.mb-40 {
            margin-bottom: 20px !important;
        }
    }
    
    @media (max-width: 576px) {
        .page-hero.event-hero {
            min-height: 250px;
        }
        
        .page-hero.event-hero h1 {
            font-size: 1.5rem;
        }
        
        .d-flex.flex-wrap.gap-2.mb-3 {
            gap: 5px !important;
        }
        
        .badge {
            font-size: 0.7rem;
            padding: 0.25em 0.5em;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add any JavaScript you need here
        console.log('Event page loaded');
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Share button enhancements
        document.querySelectorAll('.social-share a').forEach(link => {
            link.addEventListener('click', function(e) {
                // Open share links in a popup window
                e.preventDefault();
                const url = this.href;
                const width = 600;
                const height = 400;
                const left = (window.innerWidth - width) / 2;
                const top = (window.innerHeight - height) / 2;
                
                window.open(url, 'share', 
                    `width=${width},height=${height},left=${left},top=${top},toolbar=0,location=0,menubar=0,scrollbars=0,status=0`
                );
            });
        });
    });
</script>
@endpush