@extends('layouts.app')

@section('content')

<!--======  Start Who We Section  ======-->
<section class="bizzen-we_one pb-100 pt-110">
    <div class="container">
        <div class="row">
           
            <div class="col-xl-6 d-flex align-items-center">
                <!--=== Bizzen Content Box ===-->
                <div class="bizzen-content-box text-justify-content">
                     <div class="section-title">
                        <h6 class="mb-10" style="font-size: 18px; color: #0A1F44; font-weight:500" data-aos="fade-up" data-aos-duration="1000">
                            At IGRCFP, we bring together global leaders, regulators, industry practitioners, and innovators through events and summits that shape the future of governance, risk, compliance, and financial crime prevention.
                            Our events provide knowledge-sharing, networking, and thought leadership opportunities for professionals at all levels.
                        </h6>
                         <a href="{{ route('register') }}" class="theme-btn style-one me-3 mb-10" >
                            Know More About Our Events
                        </a>
                    </div>
                     
                </div>
            </div>
             <div class="col-xl-6">
                <!--=== Bizzen Image ===-->
                <div class="bizzen-image mb-5 mb-xl-0" data-aos="fade-up" data-aos-duration="1200">
                    <img src="{{ asset('assets/images/home-three/gallery/event.png')}}" alt="who we">
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End Who We Section  ======-->

<!--======  Start Service Details Section  ======-->
<section class="service-details-sec pt-50 pb-20">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <!--=== Section Title ===-->
                <div class="section-title text-center mb-60">
                   
                    <div class="content-wrap mb-10">
                        <p data-aos="fade-up" data-aos-duration="1200">
                            Events & Summits
                        </p>
                        <h2 class="title" data-aos="fade-up" data-aos-duration="1000">
                            Our Upcoming Events
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <!--=== Service Details Wrapper ===-->
        

      
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-10">
                <!--=== Bizzen Blog List ===-->
                <div class="bizzen-blog-list">
                    @foreach($events as $event)
                    <!--=== Bizzen Blog Item ===-->
                    <div class="bizzen-blog-post-item style-one mb-30 d-flex justify-content-between" data-aos="fade-up" data-aos-duration="1000">
                        <div class="post-thumbnail">
                            <img src="{{ $event->image_url }}" alt="{{ $event->title }}">
                        </div>
                        <div class="post-content">
                            <div class="post-meta">
                                <span>{{ $event->event_date }}</span>
                            </div>
                            <h4 class="title">
                                <a href="{{ route('events.show', $event->slug) }}">
                                    {{ $event->title }}
                                </a>
                            </h4>
                            <p>{{ $event->venue ?: $event->location }}</p>
                            <p>{{ $event->event_time }}</p>
                            
                            <!-- Display registration status badges -->
                            @if($event->registration_status == 'sold_out')
                                <span class="badge bg-danger">Sold Out</span>
                            @elseif($event->registration_status == 'few_seats')
                                <span class="badge bg-warning">Few Seats Left</span>
                            @else
                                <span class="badge bg-success">Available </span>
                            @endif
                            <!-- Display featured badge -->
                            @if($event->is_featured)
                                <span class="badge bg-primary">Featured</span>
                            @endif
                        </div>
                        <a href="{{ route('events.show', $event->slug) }}" class="theme-btn style-one me-3 mb-10 rounded-5">
                            Read more
                        </a>
                    </div>
                    <!--=== Bizzen Blog Item ===-->
                    @endforeach
                    
                    <!-- Display message if no events -->
                    @if($events->isEmpty())
                        <div class="text-center py-5">
                            <p class="text-muted">No events available at the moment.</p>
                        </div>
                    @endif
                </div>
                
                <!-- Pagination (if you have many events) -->
                @if($events instanceof \Illuminate\Pagination\LengthAwarePaginator && $events->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $events->links() }}
                    </div>
                @endif
            </div>
        </div>
           



    </div>
</section>
<!--======  End Service Details Section  ======-->
                




  

@endsection