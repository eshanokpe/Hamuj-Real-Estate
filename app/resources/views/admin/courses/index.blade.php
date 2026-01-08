@extends('admin.layouts.app')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Course Management</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Courses</li>
        </ul>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card h-100 p-0 radius-12">
        <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="d-flex align-items-center flex-wrap gap-3">
                <span class="text-md fw-medium text-secondary-light mb-0">Show</span>
                <form method="GET" class="d-inline">
                    <select name="per_page" class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px" onchange="this.form.submit()">
                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request('per_page') == 10 || !request('per_page') ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </form>
                
                <form class="navbar-search" method="GET">
                    <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="Search courses..." value="{{ request('search') }}">
                    <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                </form>
                
                <form method="GET" class="d-inline d-flex">
                    <select name="status" class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </form>

                <form method="GET" class="d-inline d-flex">
                    <select name="level" class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px" onchange="this.form.submit()">
                        <option value="">All Levels</option>
                        <option value="beginner" {{ request('level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                        <option value="intermediate" {{ request('level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="advanced" {{ request('level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                        <option value="expert" {{ request('level') == 'expert' ? 'selected' : '' }}>Expert</option>
                    </select>
                    @if(request('search') || request('status') || request('level') || request('per_page') != 10)
                        <a href="{{ route('admin.courses.index') }}" class="btn btn-sm btn-outline-secondary ms-2">Clear</a>
                    @endif
                </form>
            </div>
            <a href="{{ route('admin.courses.create') }}" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2"> 
                <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                Add New Course
            </a>
        </div>

        <form id="bulk-action-form" action="{{ route('admin.courses.bulk-action') }}" method="POST">
            @csrf
            <div class="card-body p-24">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <select name="action" class="form-select form-select-sm w-auto" required>
                        <option value="">Bulk Actions</option>
                        <option value="publish">Publish</option>
                        <option value="draft">Move to Draft</option>
                        <option value="archive">Archive</option>
                        <option value="delete">Delete</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-outline-primary">Apply</button>
                </div>

                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table sm-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col" width="50">
                                    <div class="d-flex align-items-center gap-10">
                                        <div class="form-check style-check d-flex align-items-center">
                                            <input class="form-check-input radius-4 border input-form-dark" type="checkbox" id="selectAll">
                                        </div>
                                        S.L
                                    </div>
                                </th>
                                <th scope="col">Course Image</th>
                                <th scope="col">Course Title</th>
                                <th scope="col">Short Title</th>
                                <th scope="col">Level</th>
                                <th scope="col" class="text-center">Modules</th>
                                <th scope="col" class="text-center">Price</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Featured</th>
                                <th scope="col" class="text-center">Popular</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($courses as $course)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-10">
                                        <div class="form-check style-check d-flex align-items-center">
                                            <input class="form-check-input radius-4 border border-neutral-400 course-checkbox" type="checkbox" name="course_ids[]" value="{{ $course->id }}">
                                        </div>
                                        {{ $loop->iteration + ($courses->currentPage() - 1) * $courses->perPage() }}
                                    </div>
                                </td> 
                                <td>
                                    <div class="featured-image-container">
                                        <img src="{{ $course->image_url }}" alt="{{ $course->title }}"  style="max-height: 80px;"
                                             class="featured-image rounded-8" 
                                             onerror="this.src='{{ asset('images/default-course.jpg') }}'">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-md fw-medium text-secondary-light mb-1">{{ Str::limit($course->title, 40) }}</span>
                                        <small class="text-muted">{{ Str::limit($course->short_description, 60) }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $course->short_title }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $course->level === 'beginner' ? 'primary' : ($course->level === 'intermediate' ? 'info' : ($course->level === 'advanced' ? 'warning' : 'danger')) }}">
                                        {{ ucfirst($course->level) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex flex-column">
                                        <small class="fw-medium">{{ $course->completed_modules }}/{{ $course->modules_count }}</small>
                                        <div class="progress" style="height: 4px; width: 60px; margin: 0 auto;">
                                            <div class="progress-bar" role="progressbar" 
                                                 style="width: {{ $course->progress_percentage }}%; background-color: #0A1F44;" 
                                                 aria-valuenow="{{ $course->progress_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($course->has_discount)
                                        <div>
                                            <small class="text-decoration-line-through text-muted">${{ number_format($course->price, 2) }}</small>
                                            <br>
                                            <span class="badge bg-success">${{ number_format($course->current_price, 2) }}</span>
                                        </div>
                                    @else
                                        @if($course->price > 0)
                                            <span class="badge bg-info">${{ number_format($course->price, 2) }}</span>
                                        @else
                                            <span class="badge bg-success">Free</span>
                                        @endif
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $course->status === 'published' ? 'success' : ($course->status === 'archived' ? 'secondary' : 'warning') }}">
                                        {{ ucfirst($course->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($course->is_featured)
                                        <iconify-icon icon="mdi:star" class="icon text-warning"></iconify-icon>
                                    @else
                                        <iconify-icon icon="mdi:star-outline" class="icon text-muted"></iconify-icon>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($course->is_popular)
                                        <iconify-icon icon="mdi:fire" class="icon text-danger"></iconify-icon>
                                    @else
                                        <iconify-icon icon="mdi:fire-outline" class="icon text-muted"></iconify-icon>
                                    @endif
                                </td>
                                <td class="text-center"> 
                                    <div class="d-flex align-items-center gap-10 justify-content-center">
                                        <a href="{{ route('admin.courses.show', $course) }}" 
                                           class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle text-decoration-none" 
                                           title="View">
                                            <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                                        </a>
                                        <a href="{{ route('admin.courses.edit', $course) }}" 
                                           class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle text-decoration-none" 
                                           title="Edit">
                                            <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                        </a>
                                        
                                        <!-- Toggle Featured Form -->
                                        <form action="{{ route('admin.courses.toggle-featured', $course) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="bg-{{ $course->is_featured ? 'warning' : 'secondary' }}-focus bg-hover-{{ $course->is_featured ? 'warning' : 'secondary' }}-200 text-{{ $course->is_featured ? 'warning' : 'secondary' }}-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle border-0" 
                                                    title="{{ $course->is_featured ? 'Remove Featured' : 'Mark as Featured' }}">
                                                <iconify-icon icon="mdi:star" class="menu-icon"></iconify-icon>
                                            </button>
                                        </form>

                                        <!-- Toggle Popular Form -->
                                        <form action="{{ route('admin.courses.toggle-popular', $course) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="bg-{{ $course->is_popular ? 'danger' : 'secondary' }}-focus bg-hover-{{ $course->is_popular ? 'danger' : 'secondary' }}-200 text-{{ $course->is_popular ? 'danger' : 'secondary' }}-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle border-0" 
                                                    title="{{ $course->is_popular ? 'Remove Popular' : 'Mark as Popular' }}">
                                                <iconify-icon icon="mdi:fire" class="menu-icon"></iconify-icon>
                                            </button>
                                        </form>
                                        
                                        <!-- Delete Form -->
                                        <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle border-0" 
                                                    onclick="return confirm('Are you sure you want to delete this course?')" 
                                                    title="Delete">
                                                <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center py-4">
                                    <div class="text-muted">
                                        <iconify-icon icon="mdi:book-education-outline" class="icon-3x mb-2"></iconify-icon>
                                        <p>No courses found.</p>
                                        @if(request('search') || request('status') || request('level'))
                                            <a href="{{ route('admin.courses.index') }}" class="btn btn-sm btn-primary">Clear Filters</a>
                                        @else
                                            <a href="{{ route('admin.courses.create') }}" class="btn btn-sm btn-primary">Create Your First Course</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
                    <span>Showing {{ $courses->firstItem() }} to {{ $courses->lastItem() }} of {{ $courses->total() }} entries</span>
                    {{ $courses->links('vendor.pagination.custom') }}
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.featured-image-container {
    width: 60px;
    height: 40px;
    border-radius: 8px;
    overflow: hidden;
}
.featured-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkboxes
    const selectAll = document.getElementById('selectAll');
    const courseCheckboxes = document.querySelectorAll('.course-checkbox');
    
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            courseCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
        });
    }

    // Bulk action form validation
    const bulkForm = document.getElementById('bulk-action-form');
    if (bulkForm) {
        bulkForm.addEventListener('submit', function(e) {
            const checkedBoxes = document.querySelectorAll('.course-checkbox:checked');
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Please select at least one course.');
                return false;
            }
        });
    }
});
</script>
@endpush