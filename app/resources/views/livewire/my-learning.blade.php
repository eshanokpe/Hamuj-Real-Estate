<!-- resources/views/livewire/my-learning.blade.php -->
<div>
    <!--======  Start My Learning  ======-->
    <section class="bizzen-blog-sec pt-115 pb-0" style="background-color: #F5F7FD">
        <div class="container bg-white rounded pt-30">
            <div class="row justify-content-left">
                <div class="col-xl-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="section-title mb-60">
                            <h6 class="text-anm" data-aos="fade-down" data-aos-duration="1000">Learning Center</h6>
                            <p data-aos="fade-down" data-aos-duration="1200">
                                Advance your GRCFP expertise with industry-leading courses and certifications.
                            </p>
                        </div>
                        {{-- <div class="section-title text-left mb-0">
                            <h4 class="text-anm" data-aos="fade-up" data-aos-duration="500">My Learning</h4>
                        </div> --}}
                        
                        <!-- Simple Refresh Button -->
                        <button wire:click="$refresh" class="btn btn-sm btn-outline-primary">
                            <iconify-icon icon="mdi:refresh" class="icon"></iconify-icon>
                            Refresh
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Statistics Row -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-0 mb-3 bg-success bg-opacity-10">
                        <div class="card-body text-center py-4">
                            <i class="fas fa-check-circle fa-2x mb-3 text-success"></i>
                            <h3 class="mb-2 fw-normal text-success">{{ $stats['completed_courses'] }}</h3>
                            <h6 class="card-title mb-0 text-success" style="font-weight: 400">Courses Completed</h6>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 mb-3 bg-primary bg-opacity-10">
                        <div class="card-body text-center py-4">
                            <i class="fas fa-spinner fa-2x mb-3 text-primary"></i>
                            <h3 class="mb-2 fw-normal text-primary">{{ $stats['ongoing_courses'] }}</h3>
                            <h6 class="card-title mb-0 text-primary"  style="font-weight: 400">Ongoing Courses</h6>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 mb-3 bg-warning bg-opacity-10">
                        <div class="card-body text-center py-4">
                            <i class="fas fa-clock fa-2x mb-3 text-warning"></i>
                            <h3 class="mb-2 text-warning fw-normal">{{ round($stats['total_hours']) }}</h3>
                            <h6 class="card-title mb-0 text-warning"  style="font-weight: 400">Hours Learned</h6>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 mb-3 bg-info bg-opacity-10">
                        <div class="card-body text-center py-4">
                            <i class="fas fa-award fa-2x mb-3 text-info"></i>
                            <h3 class="mb-2 text-info fw-normal">{{ $stats['completed_courses'] }}</h3>
                            <h6 class="card-title mb-0 text-info"  style="font-weight: 400">Certificates Earned</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--======  End My Learning  ======-->


     <!--======  Start My Learning  ======-->
    <section class="bizzen-blog-sec pt-5 pb-0" style="background-color: #F5F7FD">
        <div class="container bg-white rounded pt-30">
            <div class="row justify-content-left">
                <div class="col-xl-12">
                    <!--=== Section Title ===-->
                    <div class="section-title text-left mb-60">
                        <h4 class="text-anm" data-aos="fade-up" data-aos-duration="500">My Learning</h4>
                    </div>
                </div>
            </div>
            
            @if($courses->count() > 0)
                <div class="row">
                    @foreach($courses as $course)
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-4">
                        <!-- Course Card -->
                        <div style="border-radius: 10px" class="bg-white bizzen-blog-post-item style-three mb-0" 
                            data-aos="fade-up" data-aos-duration="1000">
                            <div class="post-thumbnail position-relative">
                                <img src="{{ $course->image_url }}" alt="{{ $course->title }}" 
                                    style="width: 100%; height: 200px; object-fit: cover;">
                                
                                <!-- Course Status Badge -->
                                @php
                                    $progress = $course->modules_count > 0 
                                        ? round(($course->completed_modules / $course->modules_count) * 100) 
                                        : 0;
                                @endphp
                                
                                @if($progress >= 100)
                                    <span class="position-absolute top-0 end-0 m-2 badge bg-success">
                                        <iconify-icon icon="mdi:check-circle" class="icon"></iconify-icon>
                                        Completed
                                    </span>
                                @elseif($progress > 0)
                                    <span class="position-absolute top-0 end-0 m-2 badge bg-warning">
                                        <iconify-icon icon="mdi:progress-clock" class="icon"></iconify-icon>
                                        In Progress
                                    </span>
                                @endif
                            </div>
                            
                            <div class="post-content" style="margin-top: -20px; margin-bottom: -20px;">
                                <!-- Badges -->
                                <div class="d-flex mb-2">
                                    <span class="badge me-1" 
                                        style="font-size: 0.7rem; padding: 4px 8px; font-weight:200; background-color:#F1F5FF; color:#0A1F44">
                                        {{ ucfirst($course->level) }}
                                    </span>
                                    <span class="badge me-1" 
                                        style="font-size: 0.7rem; padding: 4px 8px; font-weight:200; background-color:#EAF9F5; color:#1DAC85">
                                        {{ $course->format === 'self_paced' ? 'Self-Paced' : 'Instructor-Led' }}
                                    </span>
                                </div>
                                
                                <!-- Title -->
                                <p class="pt-10 mb-2" style="font-weight: 400; font-size:16px; color:#000000">
                                    <a href="{{ route('learner.courses.show', $course->slug) }}" class="text-dark">
                                        {{ Str::limit($course->title, 50) }}
                                    </a>
                                </p>
                                
                                <!-- Description -->
                                <p style="font-weight: 300; font-size:14px; min-height: 60px;">
                                    {{ Str::limit($course->short_description, 100) }}
                                </p>
                                
                                <!-- Progress -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small class="text-muted">Progress</small>
                                        <small class="text-muted">{{ $progress }}%</small>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar" role="progressbar" 
                                            style="width: {{ $progress }}%; background-color: #0A1F44;" 
                                            aria-valuenow="{{ $progress }}" 
                                            aria-valuemin="0" 
                                            aria-valuemax="100">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-1">
                                        <small class="text-muted fw-light">
                                            {{ $course->completed_modules }} of {{ $course->modules_count }} modules
                                        </small>
                                        @if($progress < 100)
                                            <small class="text-muted fw-light">
                                                {{ ceil(($course->modules_count - $course->completed_modules) * 0.5) }}h left
                                            </small>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Action Button -->
                                <a href="{{ route('learner.courses.learn', $course->slug) }}" 
                                class="theme-btn style-one me-3 mb-10 rounded-3 w-100 d-block text-center">
                                    @if($progress >= 100)
                                        Review Course
                                    @elseif($progress > 0)
                                        Continue Learning
                                    @else
                                        Start Learning
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- View All Link -->
                @if($courses->count() >= $limit)
                    <div class="text-center mt-4">
                        <a href="{{ route('my-courses') }}" class="btn btn-outline-primary">
                            View All My Courses
                        </a>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <iconify-icon icon="mdi:book-education-outline" class="icon-4x text-muted"></iconify-icon>
                    </div>
                    <h5 class="text-muted mb-3">No Courses Yet</h5>
                    <p class="text-muted mb-4">You haven't enrolled in any courses yet.</p>
                    <a href="{{ route('learner.dashboard') }}" class="btn btn-primary" style="background-color: #0A1F44; border:#0A1F44 ">
                        Browse Courses
                    </a>
                </div>
            @endif

        </div>
    </section>
    <!--======  End My Learning  ======-->


</div>