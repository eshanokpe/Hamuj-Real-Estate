<div>
    <!--====== Start Most Popular ======-->
    <section class="bizzen-blog-sec pt-25 pb-50" style="background-color: #F5F7FD">
        <div class="container bg-white rounded pt-30 pb-20">
            <div class="row justify-content-left">
                <div class="col-xl-12">
                    <!--=== Section Title ===-->
                    <div class="section-title text-left mb-40 d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="text-anm" data-aos="fade-up" data-aos-duration="500">Course Catalog</h4>
                            <p class="text-muted mb-0">
                                Browse our collection of {{ $totalCourses }} courses
                                @if($activeFiltersCount > 0)
                                    <span class="badge bg-primary ms-2">{{ $activeFiltersCount }} filter(s) active</span>
                                @endif
                            </p>
                        </div>
                        <!-- Sort Dropdown -->
                        <div class="sort-checkbox-group d-flex flex-wrap gap-3">
                            <!-- Course Delivery Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary border-0 dropdown-toggle d-flex align-items-center" 
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-play-circle me-2"></i>
                                    <span>Course Delivery:</span>
                                    <span class="ms-2 fw-medium">
                                        @php
                                            $deliveryLabels = [
                                                'latest' => 'All',
                                                'video_series' => 'Video Series',
                                                'reading_materials' => 'Reading Materials',
                                                'interactive_workshops' => 'Interactive Workshops',
                                            ];
                                            echo $deliveryLabels[$delivery] ?? 'All';
                                        @endphp
                                    </span>
                                </button>
                                <div class="dropdown-menu p-3" style="min-width: 250px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            wire:model="delivery" id="delivery_all" value="latest"
                                            wire:click="$set('delivery', 'latest')">
                                        <label class="form-check-label w-100" for="delivery_all">
                                            All
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            wire:model="delivery" id="delivery_video_series" value="video_series"
                                            wire:click="$set('delivery', 'video_series')">
                                        <label class="form-check-label w-100" for="delivery_video_series">
                                            Video Series
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            wire:model="delivery" id="delivery_reading_materials" value="reading_materials"
                                            wire:click="$set('delivery', 'reading_materials')">
                                        <label class="form-check-label w-100" for="delivery_reading_materials">
                                            Reading Materials
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            wire:model="delivery" id="delivery_interactive_workshops" value="interactive_workshops"
                                            wire:click="$set('delivery', 'interactive_workshops')">
                                        <label class="form-check-label w-100" for="delivery_interactive_workshops">
                                            Interactive Workshops
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Level Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary border-0 dropdown-toggle d-flex align-items-center" 
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-chart-line me-2"></i>
                                    <span>Level:</span>
                                    <span class="ms-2 fw-medium">
                                        @php
                                            $levelLabels = [
                                                'latest' => 'All',
                                                'beginner' => 'Beginner',
                                                'intermediate' => 'Intermediate',
                                                'advanced' => 'Advanced',
                                            ];
                                            echo $levelLabels[$level] ?? 'All';
                                        @endphp
                                    </span>
                                </button>
                                <div class="dropdown-menu p-3" style="min-width: 250px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            wire:model="level" id="level_all" value="latest"
                                            wire:click="$set('level', 'latest')">
                                        <label class="form-check-label w-100" for="level_all">
                                            All
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            wire:model="level" id="level_beginner" value="beginner"
                                            wire:click="$set('level', 'beginner')">
                                        <label class="form-check-label w-100" for="level_beginner">
                                            Beginner
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            wire:model="level" id="level_intermediate" value="intermediate"
                                            wire:click="$set('level', 'intermediate')">
                                        <label class="form-check-label w-100" for="level_intermediate">
                                            Intermediate
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            wire:model="level" id="level_advanced" value="advanced"
                                            wire:click="$set('level', 'advanced')">
                                        <label class="form-check-label w-100" for="level_advanced">
                                            Advanced
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Course Category Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary border-0 dropdown-toggle d-flex align-items-center" 
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-folder me-2"></i>
                                    <span>Category:</span>
                                    <span class="ms-2 fw-medium">
                                        @php
                                            $categoryLabels = [
                                                'latest' => 'All',
                                                'ESG Governance' => 'ESG Governance',
                                                'Risk Management' => 'Risk Management',
                                                'Compliance Frameworks' => 'Compliance Frameworks',
                                                'Risk Management Strategies' => 'Risk Management Strategies',
                                                'Regulatory Requirements' => 'Regulatory Requirements',
                                                'Data Protection Policies' => 'Data Protection Policies',
                                                'Incident Response Plans' => 'Incident Response Plans',
                                                'Audit Procedures' => 'Audit Procedures',
                                                'Leadership Development' => 'Leadership Development',
                                            ];
                                            echo $categoryLabels[$category] ?? 'All';
                                        @endphp
                                    </span>
                                </button>
                                <div class="dropdown-menu p-3" style="min-width: 250px; max-height: 400px; overflow-y: auto;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            wire:model="category" id="category_all" value="latest"
                                            wire:click="$set('category', 'latest')">
                                        <label class="form-check-label w-100" for="category_all">
                                            All
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            wire:model="category" id="category_esg" value="ESG Governance"
                                            wire:click="$set('category', 'ESG Governance')">
                                        <label class="form-check-label w-100" for="category_esg">
                                            ESG Governance
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            wire:model="category" id="category_risk" value="Risk Management"
                                            wire:click="$set('category', 'Risk Management')">
                                        <label class="form-check-label w-100" for="category_risk">
                                            Risk Management
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            wire:model="category" id="category_compliance" value="Compliance Frameworks"
                                            wire:click="$set('category', 'Compliance Frameworks')">
                                        <label class="form-check-label w-100" for="category_compliance">
                                            Compliance Frameworks
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            wire:model="category" id="category_risk_strategies" value="Risk Management Strategies"
                                            wire:click="$set('category', 'Risk Management Strategies')">
                                        <label class="form-check-label w-100" for="category_risk_strategies">
                                            Risk Management Strategies
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            wire:model="category" id="category_regulatory" value="Regulatory Requirements"
                                            wire:click="$set('category', 'Regulatory Requirements')">
                                        <label class="form-check-label w-100" for="category_regulatory">
                                            Regulatory Requirements
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            wire:model="category" id="category_data_protection" value="Data Protection Policies"
                                            wire:click="$set('category', 'Data Protection Policies')">
                                        <label class="form-check-label w-100" for="category_data_protection">
                                            Data Protection Policies
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            wire:model="category" id="category_incident" value="Incident Response Plans"
                                            wire:click="$set('category', 'Incident Response Plans')">
                                        <label class="form-check-label w-100" for="category_incident">
                                            Incident Response Plans
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            wire:model="category" id="category_audit" value="Audit Procedures"
                                            wire:click="$set('category', 'Audit Procedures')">
                                        <label class="form-check-label w-100" for="category_audit">
                                            Audit Procedures
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            wire:model="category" id="category_leadership" value="Leadership Development"
                                            wire:click="$set('category', 'Leadership Development')">
                                        <label class="form-check-label w-100" for="category_leadership">
                                            Leadership Development
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
            <!-- Courses Grid -->
            @if($courses->isEmpty())
                <!-- Empty State -->
                <div class="row">
                    <div class="col-12 text-center py-5">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center py-5">
                                <div class="empty-state-icon mb-3">
                                    <i class="fas fa-graduation-cap fa-4x text-muted"></i>
                                </div>
                                <h5 class="text-muted mb-3">No courses found</h5>
                                <p class="text-muted mb-4">
                                    @if($activeFiltersCount > 0)
                                        Try adjusting your filters or search terms.
                                    @else
                                        No courses are available at the moment.
                                    @endif
                                </p>
                                @if($activeFiltersCount > 0)
                                    <button wire:click="resetFilters" class="btn btn-primary">
                                        <i class="fas fa-times me-1"></i> Clear All Filters
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Courses Grid -->
                <div class="row">
                    @foreach($courses as $course)
                    <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                        <!-- Course Card -->
                        <div class="card course-card border-0 shadow-sm h-100">
                            <!-- Course Image -->
                            <div class="position-relative">
                                <a href="{{ route('learner.courses.show', $course->slug) }}" class="text-decoration-none">
                                    @if($course->image)
                                        <img src="{{ Storage::url($course->image) }}" 
                                            alt="{{ $course->title }}"
                                            class="card-img-top"
                                            style="height: 180px; object-fit: cover; border-radius: 10px 10px 0 0;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center"
                                            style="height: 180px; border-radius: 10px 10px 0 0;">
                                            <i class="fas fa-graduation-cap fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                </a>
                                
                                <!-- Course Badges -->
                                <div class="position-absolute top-0 start-0 m-2">
                                    @if($course->is_featured)
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-star me-1"></i>Featured
                                        </span>
                                    @endif
                                    @if($course->is_popular)
                                        <span class="badge bg-danger">
                                            <i class="fas fa-fire me-1"></i>Popular
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Course Body -->
                            <div class="card-body">
                                <!-- Course Level & Type Badges -->
                                <div class="d-flex mb-2">
                                    <span class="badge me-1" 
                                        style="font-size: 0.7rem; padding: 4px 8px; font-weight: 200; 
                                               background-color: {{ $course->level === 'beginner' ? '#F1F5FF' : 
                                                                   ($course->level === 'intermediate' ? '#FFF3E0' : 
                                                                   ($course->level === 'advanced' ? '#FCE4EC' : '#E8F5E9')) }}; 
                                               color: {{ $course->level === 'beginner' ? '#0A1F44' : 
                                                        ($course->level === 'intermediate' ? '#E65100' : 
                                                        ($course->level === 'advanced' ? '#C2185B' : '#2E7D32')) }};">
                                        {{ ucfirst($course->level) }}
                                    </span>
                                    
                                    @if($course->certification)
                                    <span class="badge ms-1" 
                                        style="font-size: 0.7rem; padding: 4px 8px; font-weight: 200; 
                                               background-color: #EAF9F5; color: #1DAC85;">
                                        Reading Materials
                                    </span>
                                    @endif
                                </div>
                                
                                <!-- Course Title -->
                                <h6 class=" mb-2" style="font-weight: 600; color: #000000;">
                                    <a href="{{ route('learner.courses.show', $course->slug) }}" 
                                    class="text-decoration-none text-dark hover-primary">
                                        {{ Str::limit($course->title, 60) }}
                                    </a>
                                </h6>
                                
                                <!-- Course Description -->
                                <p class="card-text text-muted mb-3" style="font-size: 0.875rem;">
                                    {{ Str::limit($course->short_description, 100) }}
                                </p>
                                
                                <!-- Rating and Duration -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <!-- Rating -->
                                    <div class="d-flex align-items-center">
                                        @php
                                            $avgRating = $course->reviews_avg_rating ?? 0;
                                            $fullStars = floor($avgRating);
                                            $hasHalfStar = $avgRating - $fullStars >= 0.5;
                                        @endphp
                                        
                                        <div class="me-2" style="color: #FCD53F;">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $fullStars)
                                                    <i class="fas fa-star fa-xs me-0"></i>
                                                @elseif($i == $fullStars + 1 && $hasHalfStar)
                                                    <i class="fas fa-star-half-alt fa-xs me-0"></i>
                                                @else
                                                    <i class="far fa-star fa-xs me-0"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <small class="text-muted">
                                            ({{ number_format($avgRating, 1) }})
                                        </small>
                                    </div>
                                    
                                    <!-- Duration -->
                                    <small class="text-muted">
                                        {{ $course->duration ?? 'Self-paced' }}
                                    </small>
                                </div>
                                
                                <!-- Price and Action -->
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    <!-- Action Button -->
                                    @if($course->in_cart)
                                        <!-- Already in cart - show remove button -->
                                        <button wire:click="removeFromCart({{ $course->id }})" 
                                                class="theme-btn style-two me-3 rounded-3 flex-grow-1"
                                                style="min-width: 120px; background-color: #dc3545;"
                                                wire:loading.attr="disabled"
                                                wire:target="removeFromCart({{ $course->id }})">
                                            <span wire:loading.remove wire:target="removeFromCart({{ $course->id }})">
                                                Remove from Cart
                                            </span>
                                            <span wire:loading wire:target="removeFromCart({{ $course->id }})">
                                                <i class="fas fa-spinner fa-spin"></i>
                                            </span>
                                        </button>
                                    @else
                                        <!-- Add to cart button -->
                                        <button wire:click="addToCart({{ $course->id }})" 
                                                class="theme-btn style-one me-4 rounded-3 flex-grow-1"
                                                style="min-width: 100px;"
                                                wire:loading.attr="disabled"
                                                wire:target="addToCart({{ $course->id }})">
                                             <span wire:loading.remove wire:target="addToCart({{ $course->id }})">
                                                Add to Cart
                                            </span>
                                            <span wire:loading wire:target="addToCart({{ $course->id }})">
                                                <i class="fas fa-spinner fa-spin"></i>
                                            </span>
                                        </button>
                                    @endif
                                    <!-- Price -->
                                    <div>
                                        @if($course->has_discount)
                                            <div>
                                                <span class="fs-5 text-dark" 
                                                    style="font-size: 20px; color:#000000; font-weight: 400;">
                                                    ${{ number_format($course->price, 2) }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="fs-5 text-dark" 
                                                    style="font-size: 20px; color:#000000; font-weight: 400;">
                                                ${{ number_format($course->price, 2) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($courses->hasPages())
                <div class="mt-4">
                    {{ $courses->links() }}
                </div>
                @endif
                
                <!-- Results Count -->
                <div class="text-center text-muted mt-3">
                    <small>
                        Showing {{ $courses->firstItem() ?? 0 }} to {{ $courses->lastItem() ?? 0 }} 
                        of {{ $courses->total() }} courses
                    </small>
                </div>
            @endif
        </div>
    </section>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', function() {
        console.log('Livewire CourseCatalog component loaded');
    });
    
    // Listen for cart updates
    Livewire.on('cartUpdated', () => {
        console.log('Cart updated');
    });
    
    // Listen for notifications from Livewire
    Livewire.on('notify', (data) => {
        console.log('Notification:', data);
        showNotification(data.message, data.type);
    });
    
    // Show login modal if not authenticated
    Livewire.on('show-login-modal', () => {
        console.log('Show login modal triggered');
        window.location.href = '{{ route("login") }}';
    });
    
    function showNotification(message, type = 'success') {
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
        
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 3000);
    }
</script>
@endpush