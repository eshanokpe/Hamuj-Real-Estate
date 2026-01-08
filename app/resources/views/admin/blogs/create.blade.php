@extends('admin.layouts.app')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Create New Blog</h6>
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
            <li class="fw-medium">Create Blog</li>
        </ul>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row gy-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Blog Content</h6>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-12">
                                <label class="form-label">Blog Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                       placeholder="Enter blog title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Blog Content <span class="text-danger">*</span></label>
                                <textarea name="content" class="form-control @error('content') is-invalid @enderror" 
                                          rows="12" placeholder="Write your blog content here..." required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Featured Image</label>
                                <div class="file-upload-container">
                                    <input class="form-control @error('image') is-invalid @enderror" 
                                           type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                                    <p class="text-sm mt-1 mb-0 text-muted">
                                        Recommended size: 1200x630px. Supported formats: JPG, PNG, GIF, WEBP. Max size: 2MB
                                    </p>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-24">
                    <div class="card-header">
                        <h6 class="card-title mb-0">SEO Settings</h6>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-12">
                                <label class="form-label">Meta Description</label>
                                <textarea name="meta_description" class="form-control @error('meta_description') is-invalid @enderror" 
                                          rows="3" placeholder="Brief description for search engines (max 160 characters)">{{ old('meta_description') }}</textarea>
                                <div class="d-flex justify-content-between mt-1">
                                    <small class="text-muted">Recommended: 150-160 characters</small>
                                    <small class="character-count" data-target="meta_description">0/160</small>
                                </div>
                                @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" name="meta_keywords" class="form-control @error('meta_keywords') is-invalid @enderror" 
                                       placeholder="keyword1, keyword2, keyword3" value="{{ old('meta_keywords') }}">
                                <p class="text-sm mt-1 mb-0 text-muted">Separate keywords with commas</p>
                                @error('meta_keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Publish Settings</h6>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-12">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="border-top pt-3 mt-3">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary flex-grow-1">
                                            <iconify-icon icon="ic:baseline-save" class="icon me-2"></iconify-icon>
                                            Save Blog
                                        </button>
                                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary">
                                            Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-24">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Featured Image Preview</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <div id="imagePreview" class="mb-3" style="display: none;">
                                <img id="previewImage" src="#" alt="Featured image preview" 
                                     class="img-fluid rounded-8 border" style="max-height: 200px;">
                            </div>
                            <div id="noImagePlaceholder" class="text-muted py-4">
                                <iconify-icon icon="mdi:image-outline" class="icon-3x mb-2"></iconify-icon>
                                <p class="mb-0">No image selected</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-24">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Quick Tips</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex align-items-start gap-2">
                                <iconify-icon icon="mdi:lightbulb-on-outline" class="icon text-warning mt-1"></iconify-icon>
                                <small class="text-muted">Write compelling titles that attract readers</small>
                            </div>
                            <div class="d-flex align-items-start gap-2">
                                <iconify-icon icon="mdi:lightbulb-on-outline" class="icon text-warning mt-1"></iconify-icon>
                                <small class="text-muted">Use high-quality images for better engagement</small>
                            </div>
                            <div class="d-flex align-items-start gap-2">
                                <iconify-icon icon="mdi:lightbulb-on-outline" class="icon text-warning mt-1"></iconify-icon>
                                <small class="text-muted">Optimize meta description for SEO</small>
                            </div>
                            <div class="d-flex align-items-start gap-2">
                                <iconify-icon icon="mdi:lightbulb-on-outline" class="icon text-warning mt-1"></iconify-icon>
                                <small class="text-muted">Save as draft to review before publishing</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
.file-upload-container {
    position: relative;
}
.character-count {
    font-size: 0.75rem;
    color: #6c757d;
}
#imagePreview {
    transition: all 0.3s ease;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview functionality
    const imageInput = document.querySelector('input[name="image"]');
    const imagePreview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    const noImagePlaceholder = document.getElementById('noImagePlaceholder');

    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    imagePreview.style.display = 'block';
                    noImagePlaceholder.style.display = 'none';
                }
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
                noImagePlaceholder.style.display = 'block';
            }
        });
    }

    // Character count for meta description
    const metaDescription = document.querySelector('textarea[name="meta_description"]');
    const characterCount = document.querySelector('.character-count[data-target="meta_description"]');

    if (metaDescription && characterCount) {
        metaDescription.addEventListener('input', function() {
            const length = this.value.length;
            characterCount.textContent = length + '/160';
            
            if (length > 160) {
                characterCount.style.color = '#dc3545';
            } else if (length > 140) {
                characterCount.style.color = '#ffc107';
            } else {
                characterCount.style.color = '#6c757d';
            }
        });

        // Initialize count on page load
        metaDescription.dispatchEvent(new Event('input'));
    }

    // Auto-generate slug from title
    const titleInput = document.querySelector('input[name="title"]');
    
    if (titleInput) {
        titleInput.addEventListener('blur', function() {
            // You can add auto-slug generation here if needed
            // This is where you'd make an AJAX call to check slug availability
        });
    }

    // Form submission confirmation for draft
    const form = document.querySelector('form');
    const statusSelect = document.querySelector('select[name="status"]');

    if (form && statusSelect) {
        form.addEventListener('submit', function(e) {
            const title = document.querySelector('input[name="title"]').value;
            const content = document.querySelector('textarea[name="content"]').value;
            
            if (!title.trim() || !content.trim()) {
                e.preventDefault();
                alert('Please fill in all required fields (Title and Content).');
                return false;
            }

            if (statusSelect.value === 'published') {
                if (!confirm('Are you sure you want to publish this blog? It will be visible to the public.')) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    }
});
</script>
@endpush