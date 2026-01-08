<div>
   

    <!-- Course Hero Section -->
    <section class="page-hero pb-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Video Player Section -->
                    <div class="video-player-section mb-4">
                        @if($course->video_type === 'youtube' && $course->video_embed_code)
                            <!-- YouTube Video -->
                            <div class="ratio ratio-16x9">
                                <iframe 
                                    src="{{ $course->video_embed_code }}" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen
                                    class="rounded"
                                    style="border: none;">
                                </iframe>
                            </div>
                        @elseif($course->video_type === 'vimeo' && $course->video_embed_code)
                            <!-- Vimeo Video -->
                            <div class="ratio ratio-16x9">
                                <iframe 
                                    src="{{ $course->video_embed_code }}" 
                                    frameborder="0" 
                                    allow="autoplay; fullscreen; picture-in-picture" 
                                    allowfullscreen
                                    class="rounded"
                                    style="border: none;">
                                </iframe>
                            </div>
                        @elseif($course->video_type === 'upload' && $course->video_url)
                            <!-- Uploaded Video -->
                            <div class="ratio ratio-16x9">
                                <video 
                                    controls 
                                    class="rounded w-100"
                                    poster="{{ $course->image_url }}"
                                    style="background-color: #000;">
                                    <source src="{{ $course->video_url }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @elseif($course->video_url)
                            <!-- Generic video URL -->
                            <div class="ratio ratio-16x9">
                                <video 
                                    controls 
                                    class="rounded w-100"
                                    poster="{{ $course->image_url }}"
                                    style="background-color: #000;">
                                    <source src="{{ $course->video_url }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @else
                            <!-- Placeholder with course image -->
                            <div class="ratio ratio-16x9 bg-dark rounded position-relative">
                                <img 
                                    src="{{ $course->image_url }}" 
                                    alt="{{ $course->title }}"
                                    class="w-100 h-100 object-fit-cover opacity-50">
                                <div class="position-absolute top-50 start-50 translate-middle text-center">
                                    <i class="fas fa-play-circle " style="font-size: 4rem;"></i>
                                    <p class=" mt-2">Course Preview</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb ">
                        <ol class="breadcrumb bg-transparent p-0 mb-3">
                            <li class="breadcrumb-item "><a href="{{ route('learner.courses') }}" class="text-black text-decoration-underline">Courses</a></li>
                            <li class="breadcrumb-item active text-black" aria-current="page">{{ $course->title }}</li>
                        </ol>
                    </nav>
                    
                    <!-- Course Title -->
                    <h1 class=" mb-3" style="font-weight: 700; font-size: 2.5rem;">{{ $course->title }}</h1>
                    
                    <!-- Course Short Description -->
                    <p class="mb-4" style="font-size: 1.1rem; opacity: 0.9;">{{ $course->short_description }}</p>
                    
                    <!-- Course Stats -->
                    <div class="d-flex flex-wrap gap-4 mb-4">
                        <!-- Rating -->
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($averageRating))
                                        <i class="fas fa-star text-warning"></i>
                                    @elseif($i == ceil($averageRating) && ($averageRating - floor($averageRating)) >= 0.5)
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="fw-bold me-1">{{ number_format($averageRating, 1) }}</span>
                            <span class="">({{ $totalReviews }} reviews)</span>
                        </div>
                        
                        <!-- Students -->
                        <div class="d-flex align-items-center">
                            <i class="fas fa-users text-light me-2"></i>
                            <span class="text-black">{{ number_format($course->enrollments_count) }} students enrolled</span>
                        </div>
                        
                        <!-- Level -->
                        <div class="d-flex align-items-center">
                            <i class="fas fa-signal text-black me-2"></i>
                            <span class="text-black text-capitalize">{{ $course->level }}</span>
                        </div>
                    </div>
                    
                    <!-- Instructor -->
                    @if($course->instructor)
                    <div class="d-flex align-items-center mb-4">
                        <div class="instructor-avatar me-3">
                            @if($course->instructor->profile_picture)
                                <img src="{{ Storage::url($course->instructor->profile_picture) }}" 
                                    alt="{{ $course->instructor->name }}" 
                                    class="rounded-circle" 
                                    style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" 
                                    style="width: 50px; height: 50px;">
                                    <span class="text-black fw-bold">{{ strtoupper(substr($course->instructor->name, 0, 1)) }}</span>
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="text-light mb-0">Created by</p>
                            <h6 class="text-black mb-0">{{ $course->instructor->name }}</h6>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>


    <!-- Course Details Tabs -->
    <section class="py-5">
        <div class="container">
            <!-- Tab Navigation -->
            <ul class="nav nav-tabs border-0 mb-4" id="courseTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $selectedTab == 'overview' ? 'active' : '' }}" 
                            wire:click="toggleTab('overview')"
                            style="font-weight: 500; padding: 1rem 1.5rem;">
                        <i class="fas fa-info-circle me-2"></i>Overview
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $selectedTab == 'curriculum' ? 'active' : '' }}" 
                            wire:click="toggleTab('curriculum')"
                            style="font-weight: 500; padding: 1rem 1.5rem;">
                        <i class="fas fa-list-ol me-2"></i>Curriculum
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $selectedTab == 'instructor' ? 'active' : '' }}" 
                            wire:click="toggleTab('instructor')"
                            style="font-weight: 500; padding: 1rem 1.5rem;">
                        <i class="fas fa-chalkboard-teacher me-2"></i>Instructor
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $selectedTab == 'reviews' ? 'active' : '' }}" 
                            wire:click="toggleTab('reviews')"
                            style="font-weight: 500; padding: 1rem 1.5rem;">
                        <i class="fas fa-star me-2"></i>Reviews
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content">
                <!-- Overview Tab -->
                @if($selectedTab == 'overview')
                <div class="tab-pane fade show active">
                    <div class="row">
                        <div class="col-lg-8">
                            <!-- Course Description -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body p-4">
                                    <h4 class="mb-3">About This Course</h4>
                                    <div class="course-description">
                                        @if($showFullDescription)
                                            {!! $course->description !!}
                                            <button wire:click="$set('showFullDescription', false)" 
                                                    class="btn btn-link p-0 mt-2">
                                                Show less
                                            </button>
                                        @else
                                            <div class="text-truncate-4">
                                                {!! Str::limit(strip_tags($course->description), 500) !!}
                                            </div>
                                            @if(strlen(strip_tags($course->description)) > 500)
                                                <button wire:click="$set('showFullDescription', true)" 
                                                        class="btn btn-link p-0 mt-2">
                                                    Read more
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Learning Outcomes -->
                            @if($course->outcomes && $course->outcomes->count() > 0)
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body p-4">
                                    <h4 class="mb-4">What You'll Learn</h4>
                                    <div class="row">
                                        @foreach($course->outcomes as $outcome)
                                        <div class="col-md-6 mb-3">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-check-circle text-success mt-1 me-3"></i>
                                                <span>{{ $outcome->description }}</span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Course Requirements -->
                            {{-- @if($course->prerequisites && $course->prerequisites->count() > 0)
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body p-4">
                                    <h4 class="mb-4">Requirements</h4>
                                    <ul class="list-unstyled">
                                        @foreach($course->prerequisites as $prerequisite)
                                        <li class="mb-2">
                                            <i class="fas fa-circle text-primary me-2" style="font-size: 0.5rem;"></i>
                                            {{ $prerequisite->description }}
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif --}}
                        </div>

                        <div class="col-lg-4">
                            <!-- Course Details Card -->
                            <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                                <div class="card-body p-4">
                                    <h5 class="mb-4">Course Details</h5>
                                    <div class="course-details-list">
                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                            <span class="text-muted">Level</span>
                                            <span class="fw-medium text-capitalize">{{ $course->level }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                            <span class="text-muted">Duration</span>
                                            <span class="fw-medium">{{ $course->duration ?? 'Self-paced' }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                            <span class="text-muted">Format</span>
                                            <span class="fw-medium">{{ ucfirst(str_replace('_', ' ', $course->format)) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                            <span class="text-muted">Language</span>
                                            <span class="fw-medium">English</span>
                                        </div>
                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                            <span class="text-muted">Updated</span>
                                            <span class="fw-medium">{{ $course->updated_at->format('M d, Y') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between py-2">
                                            <span class="text-muted">Category</span>
                                            <span class="fw-medium">{{ $course->category->name ?? 'General' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Curriculum Tab -->
                @if($selectedTab == 'curriculum')
                <div class="tab-pane fade show active">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">Course Curriculum</h4>
                                <button class="btn btn-outline-primary" wire:click="toggleCurriculum">
                                    <i class="fas fa-{{ $showCurriculum ? 'minus' : 'plus' }} me-2"></i>
                                    {{ $showCurriculum ? 'Collapse All' : 'Expand All' }}
                                </button>
                            </div>
                            
                            <div class="accordion" id="courseCurriculum">
                                @foreach($course->modules as $moduleIndex => $module)
                                <div class="accordion-item border-0 mb-3">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button {{ $showCurriculum ? '' : 'collapsed' }}" 
                                                type="button" 
                                                data-bs-toggle="collapse" 
                                                data-bs-target="#module{{ $module->id }}"
                                                aria-expanded="{{ $showCurriculum ? 'true' : 'false' }}">
                                            <div class="d-flex justify-content-between w-100 me-3">
                                                <div>
                                                    <span class="fw-bold">Module {{ $moduleIndex + 1 }}:</span> {{ $module->title }}
                                                </div>
                                                <div class="text-muted">
                                                    {{ $module->lessons_count }} lessons • {{ $module->duration ?? '30 min' }}
                                                </div>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="module{{ $module->id }}" 
                                         class="accordion-collapse collapse {{ $showCurriculum ? 'show' : '' }}" 
                                         data-bs-parent="#courseCurriculum">
                                        <div class="accordion-body p-0">
                                            <div class="list-group list-group-flush">
                                                @foreach($module->lessons as $lessonIndex => $lesson)
                                                <div class="list-group-item border-0 py-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-play-circle text-primary me-3" style="font-size: 1.2rem;"></i>
                                                            <div>
                                                                <h6 class="mb-0">{{ $lesson->title }}</h6>
                                                                <small class="text-muted">{{ $lesson->duration ?? '5 min' }}</small>
                                                            </div>
                                                        </div>
                                                        @if($enrolled)
                                                        <a href="{{ route('learner.courses.lesson', [$course->slug, $lesson->id]) }}" 
                                                           class="btn btn-sm btn-outline-primary">
                                                            View Lesson
                                                        </a>
                                                        @else
                                                        <span class="badge bg-light text-dark">Preview</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Instructor Tab -->
                @if($selectedTab == 'instructor' && $course->instructor)
                <div class="tab-pane fade show active">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="text-center mb-4">
                                        @if($course->instructor->profile_picture)
                                            <img src="{{ Storage::url($course->instructor->profile_picture) }}" 
                                                 alt="{{ $course->instructor->name }}" 
                                                 class="rounded-circle mb-3" 
                                                 style="width: 150px; height: 150px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto mb-3" 
                                                 style="width: 150px; height: 150px;">
                                                <span class=" fw-bold" style="font-size: 3rem;">
                                                    {{ strtoupper(substr($course->instructor->name, 0, 1)) }}
                                                </span>
                                            </div>
                                        @endif
                                        <h4>{{ $course->instructor->name }}</h4>
                                        <p class="text-muted">{{ $course->instructor->title ?? 'Senior Instructor' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="instructor-bio">
                                        <h4 class="mb-3">About the Instructor</h4>
                                        <p class="mb-4">{{ $course->instructor->bio ?? 'Experienced professional with extensive knowledge in GRC and Financial Crime Prevention.' }}</p>
                                        
                                        <!-- Instructor Stats -->
                                        <div class="row mb-4">
                                            <div class="col-md-4">
                                                <div class="text-center p-3 bg-light rounded">
                                                    <h3 class="text-primary mb-0">{{ $course->instructor->courses_count ?? 5 }}</h3>
                                                    <p class="mb-0 text-muted">Courses</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="text-center p-3 bg-light rounded">
                                                    <h3 class="text-primary mb-0">{{ number_format($course->instructor->total_students ?? 1000) }}</h3>
                                                    <p class="mb-0 text-muted">Students</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="text-center p-3 bg-light rounded">
                                                    <h3 class="text-primary mb-0">4.8</h3>
                                                    <p class="mb-0 text-muted">Rating</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Instructor Expertise -->
                                        <h5 class="mb-3">Expertise Areas</h5>
                                        <div class="d-flex flex-wrap gap-2 mb-4">
                                            @foreach(['GRC', 'Compliance', 'Risk Management', 'Financial Crime', 'AML', 'Regulations'] as $skill)
                                            <span class="badge bg-primary bg-opacity-10 text-primary py-2 px-3">{{ $skill }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Reviews Tab -->
                @if($selectedTab == 'reviews')
                <div class="tab-pane fade show active">
                    <div class="row">
                        <div class="col-lg-4">
                            <!-- Rating Summary -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body p-4 text-center">
                                    <h1 class="display-4 text-primary mb-2">{{ number_format($averageRating, 1) }}</h1>
                                    <div class="mb-3">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($averageRating))
                                                <i class="fas fa-star text-warning" style="font-size: 1.5rem;"></i>
                                            @elseif($i == ceil($averageRating) && ($averageRating - floor($averageRating)) >= 0.5)
                                                <i class="fas fa-star-half-alt text-warning" style="font-size: 1.5rem;"></i>
                                            @else
                                                <i class="far fa-star text-warning" style="font-size: 1.5rem;"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <p class="text-muted mb-0">Based on {{ $totalReviews }} reviews</p>
                                </div>
                            </div>
                            
                            <!-- Write Review Button -->
                            @auth
                            @if(!$showReviewForm)
                            <button wire:click="$set('showReviewForm', true)" 
                                    class="btn btn-primary w-100 mb-4">
                                <i class="fas fa-edit me-2"></i>Write a Review
                            </button>
                            @endif
                            @endauth
                        </div>
                        
                        <div class="col-lg-8">
                            <!-- Review Form -->
                            @if($showReviewForm)
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body p-4">
                                    <h5 class="mb-3">Write a Review</h5>
                                    <form wire:submit.prevent="submitReview">
                                        <!-- Rating Stars -->
                                        <div class="mb-3">
                                            <label class="form-label">Rating</label>
                                            <div class="rating-stars">
                                                @for($i = 5; $i >= 1; $i--)
                                                    <input type="radio" id="star{{ $i }}" wire:model="rating" value="{{ $i }}" class="d-none">
                                                    <label for="star{{ $i }}" class="star-label">
                                                        <i class="{{ $rating >= $i ? 'fas' : 'far' }} fa-star"></i>
                                                    </label>
                                                @endfor
                                            </div>
                                        </div>
                                        
                                        <!-- Review Text -->
                                        <div class="mb-3">
                                            <label class="form-label">Your Review</label>
                                            <textarea wire:model="reviewText" 
                                                      class="form-control" 
                                                      rows="5" 
                                                      placeholder="Share your experience with this course..."
                                                      required></textarea>
                                        </div>
                                        
                                        <!-- Buttons -->
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="button" 
                                                    wire:click="$set('showReviewForm', false)" 
                                                    class="btn btn-outline-secondary">
                                                Cancel
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                Submit Review
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Reviews List -->
                            <div class="reviews-list">
                                @forelse($reviews as $review)
                                <div class="card border-0 shadow-sm mb-3">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between mb-3">
                                            <div class="d-flex align-items-center">
                                                @if($review->user->profile_picture)
                                                    <img src="{{ Storage::url($review->user->profile_picture) }}" 
                                                         alt="{{ $review->user->name }}" 
                                                         class="rounded-circle me-3" 
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3" 
                                                         style="width: 50px; height: 50px;">
                                                        <span class="fw-bold">
                                                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $review->user->name }}</h6>
                                                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                            <div class="text-warning">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="mb-0">{{ $review->comment }}</p>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-5">
                                    <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No reviews yet</h5>
                                    <p class="text-muted">Be the first to review this course</p>
                                </div>
                                @endforelse
                                
                                @if($totalReviews > 5)
                                <div class="text-center mt-4">
                                    <a href="{{ route('course.reviews', $course->slug) }}" 
                                       class="btn btn-outline-primary">
                                        View All Reviews
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Related Courses -->
    @if($relatedCourses->count() > 0)
    <section class="py-5 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">Related Courses</h3>
                <a href="{{ route('learner.courses.category', $course->category->slug ?? 'all') }}" 
                   class="btn btn-link text-decoration-none">
                    View All <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
            
            <div class="row">
                @foreach($relatedCourses as $relatedCourse)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="position-relative">
                            <img src="{{ Storage::url($relatedCourse->image) }}" 
                                 alt="{{ $relatedCourse->title }}" 
                                 class="card-img-top" 
                                 style="height: 200px; object-fit: cover;">
                            <span class="position-absolute top-0 end-0 m-3 badge bg-primary">
                                {{ ucfirst($relatedCourse->level) }}
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('learner.courses.show', $relatedCourse->slug) }}" 
                                   class="text-dark text-decoration-none">
                                    {{ Str::limit($relatedCourse->title, 50) }}
                                </a>
                            </h5>
                            <p class="card-text text-muted small">
                                {{ Str::limit($relatedCourse->short_description, 100) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fw-bold text-primary">${{ number_format($relatedCourse->current_price, 2) }}</span>
                                    @if($relatedCourse->has_discount)
                                    <small class="text-muted text-decoration-line-through ms-2">${{ number_format($relatedCourse->price, 2) }}</small>
                                    @endif
                                </div>
                                @if($relatedCourse->in_cart)
                                <button wire:click="removeFromCartRelated({{ $relatedCourse->id }})" 
                                        class="btn btn-sm btn-danger">
                                    Remove
                                </button>
                                @else
                                <button wire:click="addToCartRelated({{ $relatedCourse->id }})" 
                                        class="btn btn-sm btn-primary">
                                    Add to Cart
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif


    <!-- Add some CSS for better video display -->
    <style>
        .video-player-section {
            margin-top: -30px;
            position: relative;
            z-index: 1;
        }
        
        .video-player-section .ratio-16x9 {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 3px solid rgba(255, 255, 255, 0.1);
        }
        
        .video-player-section video {
            background-color: #000;
        }
        
        /* Make the play button more prominent */
        .video-player-section .fa-play-circle {
            transition: transform 0.3s ease;
        }
        
        .video-player-section .fa-play-circle:hover {
            transform: scale(1.1);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .video-player-section {
                margin-top: 0;
            }
            
            .video-player-section .ratio-16x9 {
                border-radius: 8px;
            }
        }
    </style>


    <!-- Add methods for related courses actions -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-play video on hover (optional)
            const videoPlayers = document.querySelectorAll('video');
            
            videoPlayers.forEach(video => {
                video.addEventListener('mouseenter', function() {
                    if (video.paused) {
                        // video.play().catch(e => console.log('Auto-play prevented:', e));
                    }
                });
                
                video.addEventListener('mouseleave', function() {
                    if (!video.paused) {
                        // video.pause();
                    }
                });
            });
            
            // Add video time tracking (optional)
            const videoIframes = document.querySelectorAll('iframe');
            
            videoIframes.forEach(iframe => {
                iframe.addEventListener('load', function() {
                    // You can add tracking for iframe videos here
                    console.log('Video iframe loaded:', iframe.src);
                });
            });
        });
    </script>

    <style>
        .course-hero-section {
            color: white;
        }
        
        .text-truncate-4 {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
        }
        
        .rating-stars {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }
        
        .star-label {
            cursor: pointer;
            font-size: 2rem;
            color: #ddd;
            transition: color 0.2s;
        }
        
        .star-label:hover,
        .star-label:hover ~ .star-label,
        input:checked ~ .star-label {
            color: #ffc107;
        }
        
        .nav-tabs .nav-link {
            color: #6c757d;
            border: none;
        }
        
        .nav-tabs .nav-link.active {
            color: #0A1F44;
            border-bottom: 3px solid #0A1F44;
            background: transparent;
        }
        
        .sticky-top {
            position: sticky;
            z-index: 100;
        }
        
        .accordion-button:not(.collapsed) {
            background-color: #f8f9fa;
            color: #0A1F44;
            box-shadow: none;
        }
        
        .accordion-button:focus {
            box-shadow: none;
            border-color: rgba(0,0,0,.125);
        }
    </style>
</div>