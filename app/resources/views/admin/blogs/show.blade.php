@extends('admin.layouts.app')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Blog Details</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">
                <a href="{{ route('admin.blogs.index') }}" class="hover-text-primary">Blogs</a>
            </li>
            <li>-</li>
            <li class="fw-medium">View Blog</li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col-lg-8">
            <!-- Blog Content Card -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="card-title mb-0">Blog Content</h6>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-{{ $blog->status === 'published' ? 'success' : 'warning' }}">
                            {{ ucfirst($blog->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <h2 class="h4 mb-3 text-secondary-light">{{ $blog->title }}</h2>
                    
                    @if($blog->image)
                    <div class="featured-image mb-4">
                        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" 
                             class="img-fluid rounded-12 w-100" style="max-height: 400px; object-fit: cover;"
                             onerror="this.src='{{ asset('images/default-blog.jpg') }}'">
                    </div>
                    @endif

                    <div class="blog-content">
                        {!! nl2br(e($blog->content)) !!}
                    </div>
                </div>
            </div>

            <!-- SEO Information Card -->
            @if($blog->meta_description || $blog->meta_keywords)
            <div class="card mt-24">
                <div class="card-header">
                    <h6 class="card-title mb-0">SEO Information</h6>
                </div>
                <div class="card-body">
                    <div class="row gy-3">
                        @if($blog->meta_description)
                        <div class="col-12">
                            <label class="form-label fw-medium">Meta Description</label>
                            <p class="text-muted mb-0">{{ $blog->meta_description }}</p>
                        </div>
                        @endif

                        @if($blog->meta_keywords)
                        <div class="col-12">
                            <label class="form-label fw-medium">Meta Keywords</label>
                            <p class="text-muted mb-0">{{ $blog->meta_keywords }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- Blog Information Card -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Blog Information</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Status:</span>
                            <span class="badge bg-{{ $blog->status === 'published' ? 'success' : 'warning' }}">
                                {{ ucfirst($blog->status) }}
                            </span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Author:</span>
                            <span class="fw-medium">{{ $blog->user->name ?? 'Unknown' }}</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Created:</span>
                            <span class="fw-medium">{{ $blog->created_at->format('M d, Y') }}</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Last Updated:</span>
                            <span class="fw-medium">{{ $blog->updated_at->format('M d, Y') }}</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Reading Time:</span>
                            <span class="fw-medium">{{ $blog->reading_time }}</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Slug:</span>
                            <span class="fw-medium text-end">{{ $blog->slug }}</span>
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
                        <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-primary d-flex align-items-center justify-content-center gap-2">
                            <iconify-icon icon="lucide:edit" class="icon"></iconify-icon>
                            Edit Blog
                        </a>
                        
                        <form action="{{ route('admin.blogs.toggle-status', $blog) }}" method="POST" class="d-grid">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-{{ $blog->status === 'published' ? 'warning' : 'success' }} d-flex align-items-center justify-content-center gap-2">
                                <iconify-icon icon="{{ $blog->status === 'published' ? 'mdi:archive' : 'mdi:publish' }}" class="icon"></iconify-icon>
                                {{ $blog->status === 'published' ? 'Move to Draft' : 'Publish' }}
                            </button>
                        </form>

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary flex-grow-1">
                                Back to List
                            </a>
                            <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="flex-grow-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100" 
                                        onclick="return confirm('Are you sure you want to delete this blog? This action cannot be undone.')">
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
                    <h6 class="card-title mb-0">Content Stats</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Words:</span>
                            <span class="fw-medium">{{ str_word_count(strip_tags($blog->content)) }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Characters:</span>
                            <span class="fw-medium">{{ strlen(strip_tags($blog->content)) }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Paragraphs:</span>
                            <span class="fw-medium">{{ substr_count(strip_tags($blog->content), "\n") + 1 }}</span>
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
.blog-content {
    line-height: 1.7;
    font-size: 1.05rem;
    color: #374151;
}

.blog-content p {
    margin-bottom: 1.2rem;
}

.blog-content h1, .blog-content h2, .blog-content h3, .blog-content h4, .blog-content h5, .blog-content h6 {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
    color: #1f2937;
    font-weight: 600;
}

.blog-content ul, .blog-content ol {
    margin-bottom: 1.2rem;
    padding-left: 1.5rem;
}

.blog-content li {
    margin-bottom: 0.5rem;
}

.blog-content blockquote {
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
</style>
@endpush