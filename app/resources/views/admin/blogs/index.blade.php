@extends('admin.layouts.app')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Blog Management</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Blogs</li>
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
                    <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="Search blogs..." value="{{ request('search') }}">
                    <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                </form>
                
                <form method="GET" class="d-inline d-flex">
                    <select name="status" class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                    @if(request('search') || request('status') || request('per_page') != 10)
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-sm btn-outline-secondary ms-2">Clear</a>
                    @endif
                </form>
            </div>
            <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2"> 
                <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                Add New Blog
            </a>
        </div>

        <form id="bulk-action-form" action="{{ route('admin.blogs.bulk-action') }}" method="POST">
            @csrf
            <div class="card-body p-24">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <select name="action" class="form-select form-select-sm w-auto" required>
                        <option value="">Bulk Actions</option>
                        <option value="publish">Publish</option>
                        <option value="draft">Move to Draft</option>
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
                                <th scope="col">Featured Image</th>
                                <th scope="col">Title</th>
                                <th scope="col">Author</th>
                                <th scope="col">Created Date</th>
                                <th scope="col" class="text-center">Reading Time</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($blogs as $blog)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-10">
                                        <div class="form-check style-check d-flex align-items-center">
                                            <input class="form-check-input radius-4 border border-neutral-400 blog-checkbox" type="checkbox" name="blog_ids[]" value="{{ $blog->id }}">
                                        </div>
                                        {{ $loop->iteration + ($blogs->currentPage() - 1) * $blogs->perPage() }}
                                    </div> 
                                </td>
                                <td>
                                    <div class="featured-image-container">
                                        <img src="{{ asset('storage/' . $blog->image) }}" style="max-height: 20px;" alt="{{ $blog->title }}" 
                                             class="featured-image rounded-8"  
                                             onerror="this.src='{{ asset('images/default-blog.jpg') }}'">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-md fw-medium text-secondary-light mb-1">{{ Str::limit($blog->title, 50) }}</span>
                                        <small class="text-muted">{{ Str::limit($blog->excerpt, 70) }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <span class="text-sm fw-normal text-secondary-light">{{ $blog->user->name ?? 'Unknown' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $blog->created_at->format('M d, Y') }}</td>
                                <td class="text-center">
                                    <span class="badge bg-info">{{ $blog->reading_time }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $blog->status === 'published' ? 'success' : 'warning' }}">
                                        {{ ucfirst($blog->status) }}
                                    </span>
                                </td>
                                <td class="text-center"> 
                                    <div class="d-flex align-items-center gap-10 justify-content-center">
                                        <a href="{{ route('admin.blogs.show', $blog) }}" 
                                           class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle text-decoration-none" 
                                           title="View">
                                            <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                                        </a>
                                        <a href="{{ route('admin.blogs.edit', $blog) }}" 
                                           class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle text-decoration-none" 
                                           title="Edit">
                                            <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                        </a>
                                        <form action="{{ route('admin.blogs.toggle-status', $blog) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="bg-{{ $blog->status === 'published' ? 'warning' : 'primary' }}-focus bg-hover-{{ $blog->status === 'published' ? 'warning' : 'primary' }}-200 text-{{ $blog->status === 'published' ? 'warning' : 'primary' }}-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle border-0" 
                                                    title="{{ $blog->status === 'published' ? 'Move to Draft' : 'Publish' }}">
                                                <iconify-icon icon="{{ $blog->status === 'published' ? 'mdi:archive' : 'mdi:publish' }}" class="menu-icon"></iconify-icon>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle border-0" 
                                                    onclick="return confirm('Are you sure you want to delete this blog?')" 
                                                    title="Delete">
                                                <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">
                                        <iconify-icon icon="mdi:file-document-outline" class="icon-3x mb-2"></iconify-icon>
                                        <p>No blogs found.</p>
                                        @if(request('search') || request('status'))
                                            <a href="{{ route('admin.blogs.index') }}" class="btn btn-sm btn-primary">Clear Filters</a>
                                        @else
                                            <a href="{{ route('admin.blogs.create') }}" class="btn btn-sm btn-primary">Create Your First Blog</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
                    <span>Showing {{ $blogs->firstItem() }} to {{ $blogs->lastItem() }} of {{ $blogs->total() }} entries</span>
                    {{ $blogs->links('vendor.pagination.custom') }}
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
    const blogCheckboxes = document.querySelectorAll('.blog-checkbox');
    
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            blogCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
        });
    }

    // Bulk action form validation
    const bulkForm = document.getElementById('bulk-action-form');
    if (bulkForm) {
        bulkForm.addEventListener('submit', function(e) {
            const checkedBoxes = document.querySelectorAll('.blog-checkbox:checked');
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Please select at least one blog.');
                return false;
            }
        });
    }
});
</script>
@endpush