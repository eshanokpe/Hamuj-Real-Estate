<div class="course-catalog">
    <!-- Catalog Header -->
    <div class="catalog-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3 mb-2" style="color: #0A1F44;">Course Catalog</h1>
                <p class="text-muted mb-0">
                    Browse our collection of {{ $totalCourses }} courses
                    @if($activeFiltersCount > 0)
                        <span class="badge bg-primary ms-2">{{ $activeFiltersCount }} filter(s) active</span>
                    @endif
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="d-flex align-items-center justify-content-md-end gap-2">
                    <!-- Search Box -->
                    <div class="search-box" style="max-width: 300px;">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input 
                                type="text" 
                                wire:model.debounce.500ms="search"
                                class="form-control border-start-0"
                                placeholder="Search courses..."
                                aria-label="Search courses"
                            >
                            @if($search)
                                <button 
                                    class="btn btn-outline-secondary" 
                                    type="button"
                                    wire:click="$set('search', '')"
                                >
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Sort Dropdown -->
                    <div class="sort-dropdown">
                        <select wire:model="sortBy" class="form-select">
                            <option value="latest">Sort by: Latest</option>
                            <option value="newest">Newest First</option>
                            <option value="oldest">Oldest First</option>
                            <option value="price_low">Price: Low to High</option>
                            <option value="price_high">Price: High to Low</option>
                            <option value="popular">Most Popular</option>
                            <option value="rating">Highest Rated</option>
                            <option value="title_asc">Title: A-Z</option>
                            <option value="title_desc">Title: Z-A</option>
                        </select>
                    </div>
                    
                    <!-- View Toggle (Optional) -->
                    <div class="view-toggle d-none d-md-flex">
                        <button class="btn btn-outline-secondary" title="Grid View">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button class="btn btn-outline-secondary" title="List View">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <!-- Filters Header -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0" style="color: #0A1F44;">
                            <i class="fas fa-filter me-2"></i>Filters
                        </h5>
                        @if($activeFiltersCount > 0)
                            <button 
                                wire:click="resetFilters"
                                class="btn btn-sm btn-link text-danger"
                                style="text-decoration: none;"
                            >
                                Clear All
                            </button>
                        @endif
                    </div>
                    
                    <!-- Level Filter -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">
                            <i class="fas fa-chart-line me-1"></i> Level
                        </h6>
                        <div class="list-group list-group-flush">
                            <button 
                                type="button"
                                wire:click="applyFilter('level', '')"
                                class="list-group-item list-group-item-action border-0 px-0 py-1 {{ !$level ? 'active fw-bold' : '' }}"
                            >
                                All Levels
                                <span class="badge bg-light text-dark float-end">{{ $totalCourses }}</span>
                            </button>
                            @foreach(['beginner', 'intermediate', 'advanced', 'expert'] as $lvl)
                                @if($filterCounts[$lvl] ?? 0 > 0)
                                    <button 
                                        type="button"
                                        wire:click="applyFilter('level', '{{ $lvl }}')"
                                        class="list-group-item list-group-item-action border-0 px-0 py-1 {{ $level === $lvl ? 'active fw-bold' : '' }}"
                                    >
                                        {{ ucfirst($lvl) }}
                                        <span class="badge bg-light text-dark float-end">{{ $filterCounts[$lvl] ?? 0 }}</span>
                                    </button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Format Filter -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">
                            <i class="fas fa-play-circle me-1"></i> Format
                        </h6>
                        <div class="list-group list-group-flush">
                            <button 
                                type="button"
                                wire:click="applyFilter('format', '')"
                                class="list-group-item list-group-item-action border-0 px-0 py-1 {{ !$format ? 'active fw-bold' : '' }}"
                            >
                                All Formats
                                <span class="badge bg-light text-dark float-end">{{ $totalCourses }}</span>
                            </button>
                            @foreach(['self_paced', 'instructor_led', 'hybrid'] as $fmt)
                                @if($filterCounts[$fmt] ?? 0 > 0)
                                    <button 
                                        type="button"
                                        wire:click="applyFilter('format', '{{ $fmt }}')"
                                        class="list-group-item list-group-item-action border-0 px-0 py-1 {{ $format === $fmt ? 'active fw-bold' : '' }}"
                                    >
                                        {{ ucfirst(str_replace('_', ' ', $fmt)) }}
                                        <span class="badge bg-light text-dark float-end">{{ $filterCounts[$fmt] ?? 0 }}</span>
                                    </button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Features Filter -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">
                            <i class="fas fa-star me-1"></i> Features
                        </h6>
                        <div class="list-group list-group-flush">
                            <div class="list-group-item border-0 px-0 py-1">
                                <div class="form-check">
                                    <input 
                                        type="checkbox" 
                                        class="form-check-input"
                                        id="filter-featured"
                                        wire:model="featured"
                                    >
                                    <label class="form-check-label d-flex justify-content-between w-100" for="filter-featured">
                                        <span>Featured Courses</span>
                                        <span class="badge bg-light text-dark">{{ $filterCounts['featured'] ?? 0 }}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="list-group-item border-0 px-0 py-1">
                                <div class="form-check">
                                    <input 
                                        type="checkbox" 
                                        class="form-check-input"
                                        id="filter-popular"
                                        wire:model="popular"
                                    >
                                    <label class="form-check-label d-flex justify-content-between w-100" for="filter-popular">
                                        <span>Popular Courses</span>
                                        <span class="badge bg-light text-dark">{{ $filterCounts['popular'] ?? 0 }}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="list-group-item border-0 px-0 py-1">
                                <div class="form-check">
                                    <input 
                                        type="checkbox" 
                                        class="form-check-input"
                                        id="filter-certification"
                                        wire:model="certification"
                                    >
                                    <label class="form-check-label d-flex justify-content-between w-100" for="filter-certification">
                                        <span>With Certification</span>
                                        <span class="badge bg-light text-dark">{{ $filterCounts['certified'] ?? 0 }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Price Range Filter -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">
                            <i class="fas fa-tag me-1"></i> Price
                        </h6>
                        <div class="list-group list-group-flush">
                            <button 
                                type="button"
                                wire:click="applyFilter('price', 'free')"
                                class="list-group-item list-group-item-action border-0 px-0 py-1"
                            >
                                Free Courses
                                <span class="badge bg-light text-dark float-end">{{ $filterCounts['free'] ?? 0 }}</span>
                            </button>
                            <div class="list-group-item border-0 px-0 py-2">
                                <small class="text-muted d-block mb-2">Custom Price Range</small>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input 
                                            type="number" 
                                            wire:model.debounce.500ms="minPrice"
                                            class="form-control form-control-sm"
                                            placeholder="Min"
                                            min="0"
                                        >
                                    </div>
                                    <div class="col-6">
                                        <input 
                                            type="number" 
                                            wire:model.debounce.500ms="maxPrice"
                                            class="form-control form-control-sm"
                                            placeholder="Max"
                                            min="0"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Results Per Page -->
                    <div class="mb-3">
                        <h6 class="text-muted mb-2">
                            <i class="fas fa-list-ol me-1"></i> Results
                        </h6>
                        <select wire:model="perPage" class="form-select form-select-sm">
                            <option value="6">6 per page</option>
                            <option value="12">12 per page</option>
                            <option value="24">24 per page</option>
                            <option value="48">48 per page</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Quick Stats -->
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body">
                    <h6 class="text-muted mb-3">
                        <i class="fas fa-chart-bar me-1"></i> Quick Stats
                    </h6>
                    <div class="row text-center">
                        <div class="col-6 mb-2">
                            <div class="text-primary fw-bold">{{ $filterCounts['beginner'] ?? 0 }}</div>
                            <small class="text-muted">Beginner</small>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="text-success fw-bold">{{ $filterCounts['intermediate'] ?? 0 }}</div>
                            <small class="text-muted">Intermediate</small>
                        </div>
                        <div class="col-6">
                            <div class="text-warning fw-bold">{{ $filterCounts['advanced'] ?? 0 }}</div>
                            <small class="text-muted">Advanced</small>
                        </div>
                        <div class="col-6">
                            <div class="text-danger fw-bold">{{ $filterCounts['expert'] ?? 0 }}</div>
                            <small class="text-muted">Expert</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Courses Grid -->
        <div class="col-lg-9 col-md-8">
            @if($courses->isEmpty())
                <!-- Empty State -->
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
            @else
                <!-- Courses Grid -->
                <div class="row">
                    @foreach($courses as $course)
                    <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
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
                                
                                <!-- Level Badge -->
                                <div class="position-absolute bottom-0 start-0 m-2">
                                    <span class="badge" 
                                          style="background-color: {{ $course->level === 'beginner' ? '#F1F5FF' : 
                                                                    ($course->level === 'intermediate' ? '#FFF3E0' : 
                                                                    ($course->level === 'advanced' ? '#FCE4EC' : '#E8F5E9')) }}; 
                                                 color: {{ $course->level === 'beginner' ? '#0A1F44' : 
                                                          ($course->level === 'intermediate' ? '#E65100' : 
                                                          ($course->level === 'advanced' ? '#C2185B' : '#2E7D32')) }};">
                                        {{ ucfirst($course->level) }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Course Body -->
                            <div class="card-body">
                                <!-- Format Badge -->
                                @if($course->format)
                                <div class="mb-2">
                                    <span class="badge bg-info text-white">
                                        {{ ucfirst(str_replace('_', ' ', $course->format)) }}
                                    </span>
                                </div>
                                @endif
                                
                                <!-- Course Title -->
                                <h5 class="card-title mb-2" style="font-weight: 600; color: #000000;">
                                    <a href="{{ route('learner.courses.show', $course->slug) }}" 
                                       class="text-decoration-none text-dark hover-primary">
                                        {{ Str::limit($course->title, 60) }}
                                    </a>
                                </h5>
                                
                                <!-- Course Description -->
                                <p class="card-text text-muted mb-3" style="font-size: 0.875rem;">
                                    {{ Str::limit($course->short_description, 100) }}
                                </p>
                                
                                <!-- Instructor -->
                                @if($course->user)
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-user-circle text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <small class="text-muted">Instructor:</small>
                                        <small class="fw-medium">{{ $course->user->name }}</small>
                                    </div>
                                </div>
                                @endif
                                
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
                                                    <i class="fas fa-star fa-xs"></i>
                                                @elseif($i == $fullStars + 1 && $hasHalfStar)
                                                    <i class="fas fa-star-half-alt fa-xs"></i>
                                                @else
                                                    <i class="far fa-star fa-xs"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <small class="text-muted">
                                            ({{ number_format($avgRating, 1) }})
                                        </small>
                                    </div>
                                    
                                    <!-- Duration -->
                                    <small class="text-muted">
                                        <i class="far fa-clock me-1"></i>
                                        {{ $course->duration ?? 'Self-paced' }}
                                    </small>
                                </div>
                                
                                <!-- Enrollment Count -->
                                <div class="mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-users me-1"></i>
                                        {{ $course->enrollments_count ?? 0 }} enrolled
                                    </small>
                                </div>
                                
                                <!-- Price and Action -->
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    <!-- Price -->
                                    <div>
                                        @if($course->has_discount)
                                            <div>
                                                <span class="text-decoration-line-through text-muted me-2">
                                                    ${{ number_format($course->price, 2) }}
                                                </span>
                                                <span class="fw-bold text-primary fs-5">
                                                    ${{ number_format($course->discount_price, 2) }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="fw-bold fs-5 {{ $course->price == 0 ? 'text-success' : 'text-dark' }}">
                                                {{ $course->price == 0 ? 'Free' : '$' . number_format($course->price, 2) }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Action Button -->
                                    <div>
                                        <a href="{{ route('learner.courses.show', $course->slug) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye me-1"></i> View Details
                                        </a>
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
        
    </div>
</div>

@push('styles')
<style>
    .course-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 10px;
    }
    
    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    .hover-primary:hover {
        color: #0A1F44 !important;
    }
    
    .list-group-item.active {
        background-color: #F1F5FF;
        border-color: #0A1F44;
        color: #0A1F44;
    }
    
    .catalog-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.5rem;
        border-radius: 10px;
        margin-top: 1rem;
    }
    
    .course-card .card-img-top {
        transition: opacity 0.3s ease;
    }
    
    .course-card:hover .card-img-top {
        opacity: 0.9;
    }
    
    /* Custom pagination styling */
    .pagination .page-link {
        color: #0A1F44;
        border: 1px solid #dee2e6;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #0A1F44;
        border-color: #0A1F44;
    }
    
    /* Mobile responsive adjustments */
    @media (max-width: 768px) {
        .catalog-header .row > div {
            margin-bottom: 1rem;
        }
        
        .search-box {
            max-width: 100% !important;
        }
        
        .course-card .card-title {
            font-size: 1rem;
        }
    }
    
    /* Loading indicator */
    [wire\:loading] {
        opacity: 0.6;
        pointer-events: none;
    }
    
    [wire\:loading] .card-img-top {
        filter: grayscale(50%);
    }
</style>
@endpush

@push('scripts')
<script>
    // Debounce for search and filters
    let timer;
    
    document.addEventListener('livewire:load', function() {
        // Auto-collapse filters on mobile
        if (window.innerWidth < 768) {
            const filters = document.querySelector('.col-lg-3');
            if (filters) {
                filters.classList.add('collapse');
            }
        }
        
        // Price range validation
        const minPriceInput = document.querySelector('input[wire\\:model="minPrice"]');
        const maxPriceInput = document.querySelector('input[wire\\:model="maxPrice"]');
        
        if (minPriceInput && maxPriceInput) {
            minPriceInput.addEventListener('change', function() {
                if (this.value && maxPriceInput.value && parseFloat(this.value) > parseFloat(maxPriceInput.value)) {
                    alert('Minimum price cannot be greater than maximum price');
                    this.value = '';
                    @this.set('minPrice', null);
                }
            });
            
            maxPriceInput.addEventListener('change', function() {
                if (this.value && minPriceInput.value && parseFloat(this.value) < parseFloat(minPriceInput.value)) {
                    alert('Maximum price cannot be less than minimum price');
                    this.value = '';
                    @this.set('maxPrice', null);
                }
            });
        }
    });
    
    // Listen for Livewire events
    Livewire.on('filterApplied', () => {
        // Smooth scroll to top on filter change
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
</script>
@endpush