
<div wire:id="{{ $this->getId() }}">
    <!--====== Start Most Popular ======-->
    <section class="bizzen-blog-sec pt-25 pb-50" style="background-color: #F5F7FD">
        <div class="container bg-white rounded pt-30 pb-20">
            <div class="row justify-content-left">
                <div class="col-xl-12">
                    <!--=== Section Title ===-->
                    <div class="section-title text-left mb-40 d-flex justify-content-between align-items-center">
                        <h4 class="text-anm" data-aos="fade-up" data-aos-duration="500">Most Popular</h4>
                        <!-- Navigation arrows -->
                        <div class="slider-nav d-none d-md-flex">
                            <button class="slider-prev btn btn-light rounded-circle mx-1" style="width: 40px; height: 40px;">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="slider-next btn btn-light rounded-circle mx-1" style="width: 40px; height: 40px;">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            @if(empty($courses))
                <div class="row">
                    <div class="col-12 text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No popular courses available at the moment.</p>
                        </div>
                    </div>
                </div>
            @else
                <!-- Horizontal Slider Container -->
                <div class="position-relative">
                    <!-- Courses Slider -->
                    <div class="courses-slider" style="overflow-x: auto; overflow-y: hidden;">
                        <div class="d-flex flex-nowrap pb-3" style="gap: 1.5rem;">
                            @foreach($courses as $course)
                            <div class="course-slide" style="min-width: 280px; max-width: 280px;" wire:key="course-{{ $course['id'] }}">
                                <!--=== Course Card ===-->
                                <div style="border-radius: 10px" class="bg-white bizzen-blog-post-item style-three mb-0 h-100" 
                                    data-aos="fade-up" data-aos-duration="1000" data-aos-delay="{{ $loop->index * 100 }}">
                                    <div class="post-thumbnail position-relative">
                                        @if($course['image'])
                                            <img src="{{ Storage::url($course['image']) }}" 
                                                alt="{{ $course['title'] }}" 
                                                class="img-fluid w-100" 
                                                style="height: 180px; object-fit: cover; border-radius: 10px 10px 0 0;">
                                        @else
                                            <div class="placeholder-image bg-light d-flex align-items-center justify-content-center" 
                                                style="height: 180px; border-radius: 10px 10px 0 0;">
                                                <i class="fas fa-graduation-cap fa-3x text-muted"></i>
                                            </div>
                                        @endif
                                        
                                        <!-- Popular Badge -->
                                        <div class="position-absolute top-0 start-0 m-3">
                                            <span class="badge bg-warning text-dark px-2 py-1" style="font-size: 0.7rem;">
                                                <i class="fas fa-fire me-1"></i>Popular
                                            </span>
                                        </div>
                                        
                                        <!-- Format Badge -->
                                        @if($course['format'])
                                        <div class="position-absolute top-0 end-0 m-3">
                                            <span class="badge bg-info text-white px-2 py-1" style="font-size: 0.7rem;">
                                                {{ ucfirst(str_replace('_', ' ', $course['format'])) }}
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <div class="post-content p-3">
                                        <!-- Course Level & Type Badges -->
                                        <div class="d-flex mb-2">
                                            <span class="badge me-1"  
                                                style="font-size: 0.7rem; padding: 4px 8px; font-weight: 200; 
                                                    background-color: {{ $course['level'] === 'beginner' ? '#F1F5FF' : 
                                                                        ($course['level'] === 'intermediate' ? '#FFF3E0' : 
                                                                        ($course['level'] === 'advanced' ? '#FCE4EC' : '#E8F5E9')) }}; 
                                                    color: {{ $course['level'] === 'beginner' ? '#0A1F44' : 
                                                                ($course['level'] === 'intermediate' ? '#E65100' : 
                                                                ($course['level'] === 'advanced' ? '#C2185B' : '#2E7D32')) }};">
                                                {{ ucfirst($course['level']) }}
                                            </span>
                                            
                                            @if($course['certification'])
                                            <span class="badge ms-1" 
                                                style="font-size: 0.7rem; padding: 4px 8px; font-weight: 200; 
                                                    background-color: #EAF9F5; color: #1DAC85;">
                                                <i class="fas fa-certificate me-1"></i>Certified
                                            </span>
                                            @endif
                                        </div> 
                                        
                                        <!-- Course Title -->
                                        <h5 class="course-title mb-2" style="font-weight: 600; font-size: 16px; color: #000000;">
                                            <a href="{{ route('learner.courses.show', $course['slug']) }}" 
                                            class="text-decoration-none text-dark hover-primary">
                                                {{ Str::limit($course['title'], 60) }}
                                            </a>
                                        </h5>
                                        
                                        <!-- Course Description -->
                                        <p class="course-description mb-3" style="font-weight: 300; font-size: 14px; color: #6c757d;">
                                            {{ Str::limit($course['short_description'], 90) }}
                                        </p>
                                        
                                        <!-- Star Rating & Duration -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <!-- Rating -->
                                            <div class="d-flex align-items-center">
                                                <div class="me-2" style="color: #FCD53F;">
                                                    @php
                                                        $avgRating = $course['reviews_avg_rating'] ?? 0;
                                                        $fullStars = floor($avgRating);
                                                        $hasHalfStar = $avgRating - $fullStars >= 0.5;
                                                    @endphp
                                                    
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $fullStars)
                                                            <i class="fas fa-star fa-xs me-0" aria-hidden="true"></i>
                                                        @elseif($i == $fullStars + 1 && $hasHalfStar)
                                                            <i class="fas fa-star-half-alt fa-xs me-0" aria-hidden="true"></i>
                                                        @else
                                                            <i class="far fa-star fa-xs me-0" aria-hidden="true"></i>
                                                        @endif
                                                    @endfor
                                                    
                                                    <small class="text-muted " style="font-size: 12px">
                                                        ({{ number_format($avgRating, 1) }})
                                                    </small>
                                                </div>
                                            </div>
                                            
                                            <!-- Duration -->
                                            <div>
                                                <small class="text-muted fw-light" style="font-size: 12px">
                                                    {{ $course['duration'] ?? 'Self-paced' }}
                                                </small>
                                            </div>
                                        </div>
                                        
                                        <!-- Price & Add to Cart -->
                                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                            @if($course['in_cart'])
                                                <!-- Already in cart - show remove button -->
                                                <button wire:click.prevent="removeFromCart({{ $course['id'] }})" 
                                                        class="theme-btn style-two btn-sm me-5 rounded-3 flex-grow-1 text-white fs-0 px-0 py-2 "
                                                        style=" background-color: #dc3545;"
                                                        wire:loading.attr="disabled"
                                                        wire:target="removeFromCart">
                                                    <span wire:loading.remove wire:target="removeFromCart" style="font-size: 12px;">
                                                        Remove from Cart
                                                    </span>
                                                    <span wire:loading wire:target="removeFromCart">
                                                        <i class="fas fa-spinner fa-spin"></i>
                                                    </span>
                                                </button> 
                                            @else
                                                <!-- Add to cart button -->
                                                <button wire:click.prevent="addToCart({{ $course['id'] }})" 
                                                        class="theme-btn style-one btn-sm me-5 rounded-3 flex-grow-1 text-white fs-0 px-0 py-2"
                                                       
                                                        wire:loading.attr="disabled"
                                                        wire:target="addToCart">
                                                    <span wire:loading.remove wire:target="addToCart"  style="font-size: 14px;">
                                                        Add to Cart
                                                    </span>
                                                    <span wire:loading wire:target="addToCart">
                                                        <i class="fas fa-spinner fa-spin"></i>
                                                    </span>
                                                </button>
                                            @endif
                                            
                                            <div class="text-end">
                                                @if($course['has_discount'])
                                                    <div class="d-flex flex-column align-items-end">
                                                        <span class="fs-5 text-dark" 
                                                            style="font-size: 20px; color:#000000; font-weight: 400;">
                                                            ${{ number_format($course['price'], 2) }}
                                                        </span>
                                                    </div>
                                                @else
                                                    <span class="fs-5 text-dark" 
                                                            style="font-size: 20px; color:#000000; font-weight: 400;">
                                                        ${{ number_format($course['price'], 2) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Scrollbar -->
                    <div class="slider-scrollbar mt-3 d-none d-md-block">
                        <div class="scrollbar-track" style="height: 4px; background-color: #e9ecef; border-radius: 2px;">
                            <div class="scrollbar-thumb" style="height: 100%; background-color: #0A1F44; border-radius: 2px; width: 30%;"></div>
                        </div>
                    </div>
                </div>
                
                <!-- View All Link -->
                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <a href="{{ route('learner.courses') }}" style="color:#0A1F44"
                        class="btn btn-link text-decoration-none hover-primary">
                            View All Courses <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!--====== End Most Popular ======-->
</div>

   
@push('scripts')
<script>
    console.log('🚀 PopularCourses script loaded');

    // Debug Livewire initialization
    console.log('🔍 Checking Livewire availability:');
    console.log('- Livewire:', typeof Livewire !== 'undefined' ? '✅ Available' : '❌ Not found');
    console.log('- Alpine:', typeof Alpine !== 'undefined' ? '✅ Available' : '❌ Not found');
    
    // Check if component exists
    const component = document.querySelector('[wire\\:id]');
    console.log('- Component found:', component ? '✅' : '❌');
    if (component) {
        console.log('- Component ID:', component.getAttribute('wire:id'));
    }

    // Track button clicks
    document.addEventListener('click', function(e) {
        const cartButton = e.target.closest('[wire\\:click*="addToCart"], [wire\\:click*="removeFromCart"]');
        if (cartButton) {
            console.log('🖱️ Cart button clicked!');
            console.log('Button:', cartButton);
            console.log('Action:', cartButton.getAttribute('wire:click'));
            console.log('Component parent:', cartButton.closest('[wire\\:id]'));
            
            // Check if Livewire is handling it
            setTimeout(() => {
                console.log('⏳ After click - check if Livewire processed');
            }, 100);
        }
    });

    // Simple slider initialization
    function initializeSlider() {
        const slider = document.querySelector('.courses-slider');
        const prevBtn = document.querySelector('.slider-prev');
        const nextBtn = document.querySelector('.slider-next');

        if (!slider || !prevBtn || !nextBtn) {
            console.log('❌ Slider elements not found');
            return;
        }
        
        const slideWidth = 280;
        const gap = 24;
        const scrollAmount = slideWidth + gap;
        
        prevBtn.addEventListener('click', () => {
            slider.scrollLeft -= scrollAmount;
        });
        
        nextBtn.addEventListener('click', () => {
            slider.scrollLeft += scrollAmount;
        });
        
        console.log('✅ Slider initialized');
    }

    // Initialize when Livewire is ready
    document.addEventListener('livewire:initialized', () => {
        console.log('✅ Livewire initialized for PopularCourses');
        initializeSlider();
        
        // Test that events are working
        window.dispatchEvent(new Event('test-livewire'));
    });

    // Listen for Livewire events
    Livewire.on('notify', (event) => {
        console.log('📢 Livewire notify event:', event);
        showNotification(event.message, event.type);
    });
    
    Livewire.on('show-login-modal', () => {
        console.log('🔒 Redirecting to login');
        window.location.href = '{{ route("login") }}';
    });

    // Show notification function
    window.showNotification = function(message, type = 'success') {
        console.log('💬 Showing notification:', { message, type });
        
        // Remove existing notifications
        const existing = document.querySelectorAll('.alert.position-fixed');
        existing.forEach(n => n.remove());
        
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} position-fixed top-0 end-0 m-3`;
        notification.style.zIndex = '9999';
        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                <span>${message}</span>
                <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()"></button>
            </div>
        `;
        document.body.appendChild(notification);
        
        setTimeout(() => notification.remove(), 3000);
    };

    // Test if Livewire is working
    window.testLivewire = function() {
        console.log('🧪 Testing Livewire...');
        const testBtn = document.createElement('button');
        testBtn.textContent = 'Test Livewire';
        testBtn.className = 'btn btn-primary m-3';
        testBtn.onclick = () => {
            console.log('Test button clicked');
            if (window.Livewire) {
                console.log('Livewire found, testing dispatch...');
                Livewire.dispatch('test-event', { test: 'data' });
            }
        };
        document.body.appendChild(testBtn);
    };

    // Run test on load
    setTimeout(testLivewire, 1000);
</script>
@endpush

@push('styles')
<style>
    /* Hide scrollbar but keep functionality */
    .courses-slider::-webkit-scrollbar {
        height: 6px;
    }
    
    .courses-slider::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    .courses-slider::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }
    
    .courses-slider::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    
    /* Smooth hover effects */
    .course-slide {
        transition: transform 0.3s ease;
    }
    
    .course-slide:hover {
        transform: translateY(-5px);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .course-slide {
            min-width: 260px;
            max-width: 260px;
        }
        
        .courses-slider {
            padding-bottom: 10px;
        }
    }
    
    @media (max-width: 576px) {
        .course-slide {
            min-width: 240px;
            max-width: 240px;
        }
        
        .slider-nav {
            display: none !important;
        }
    }
</style>
@endpush