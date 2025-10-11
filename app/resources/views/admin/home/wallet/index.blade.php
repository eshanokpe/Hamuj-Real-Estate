@extends('layouts.admin')

@section('content')
<div class="page-wrapper">
    <!-- Page Content-->
    <div class="page-content-tab">
        <div class="container-fluid">
            
            <!-- Page Title -->
            <div class="row mb-4">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Wallets</h4>
                    </div>
                </div>
            </div>

            <!-- Search Box -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <form id="searchForm" action="{{ route('admin.wallet.index') }}" method="GET" class="row g-3">
                                <div class="col-lg-10 col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="las la-search"></i>
                                        </span>
                                        <input type="text" 
                                               name="search" 
                                               id="searchInput"
                                               class="form-control border-start-0" 
                                               placeholder="Search by name, email, or balance..." 
                                               value="{{ $search ?? '' }}"
                                               autocomplete="off">
                                        <span id="searchLoading" class="input-group-text d-none">
                                            <div class="spinner-border spinner-border-sm" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3">
                                    <div class="d-grid gap-2 d-md-flex">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="las la-search me-1"></i> Search
                                        </button>
                                        @if($search)
                                            <a href="{{ route('admin.wallet.index') }}" class="btn btn-outline-secondary">
                                                <i class="las la-times me-1"></i> Clear
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                            
                            @if($search)
                                <div class="mt-3">
                                    <p class="text-muted mb-0">
                                        Search results for: <strong>"{{ $search }}"</strong>
                                        <span class="badge bg-primary ms-2">{{ $wallets->total() }} result(s) found</span>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Wallets List -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Wallet List</h4>
                            <div class="d-flex align-items-center">
                                @if($search)
                                    <span class="badge bg-primary me-2">{{ $wallets->total() }} results</span>
                                @endif
                                <span class="badge bg-secondary">Total: {{ $wallets->total() }} wallets</span>
                            </div>
                        </div><!--end card-header-->
                        
                        <div class="card-body">
                            <div id="searchResults">
                                @include('admin.home.wallet.search-results')
                            </div>
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div><!-- container -->
    </div>
    <!-- end page content -->
</div>
<!-- end page-wrapper -->
@endsection

@push('styles')
<style>
.table td {
    vertical-align: middle;
}
.input-group-text {
    background-color: #f8f9fa;
    border-color: #dee2e6;
}
#searchLoading .spinner-border {
    width: 1rem;
    height: 1rem;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let searchTimeout;
    const searchInput = $('#searchInput');
    const searchForm = $('#searchForm');
    const searchResults = $('#searchResults');
    const searchLoading = $('#searchLoading');

    // Real-time search with debouncing
    searchInput.on('input', function() {
        const searchTerm = $(this).val().trim();
        
        // Clear previous timeout
        clearTimeout(searchTimeout);
        
        // Hide loading if empty
        if (searchTerm.length === 0) {
            // If search is empty and we have search results, reload the page
            if (window.location.search.includes('search=')) {
                window.location.href = "{{ route('admin.wallet.index') }}";
            }
            return;
        }

        // Show loading indicator
        searchLoading.removeClass('d-none');

        // Set new timeout for search (300ms for instant feel)
        searchTimeout = setTimeout(() => {
            performSearch(searchTerm);
        }, 300);
    });

    // Handle form submission
    searchForm.on('submit', function(e) {
        e.preventDefault();
        const searchTerm = searchInput.val().trim();
        performSearch(searchTerm, true);
    });

    // Function to perform search
    function performSearch(searchTerm, updateUrl = false) {
        if (searchTerm.length === 0) {
            // If search is empty, reload the page without search
            if (updateUrl) {
                window.location.href = "{{ route('admin.wallet.index') }}";
            }
            return;
        }

        $.ajax({
            url: "{{ route('admin.wallet.search') }}",
            type: "GET",
            data: {
                search: searchTerm,
                _token: "{{ csrf_token() }}"
            },
            beforeSend: function() {
                searchLoading.removeClass('d-none');
            },
            success: function(response) {
                searchResults.html(response.html);
                searchLoading.addClass('d-none');
                
                // Update URL without page reload if not form submission
                if (updateUrl && history.pushState) {
                    const newUrl = new URL(window.location.href);
                    newUrl.searchParams.set('search', searchTerm);
                    history.pushState({}, '', newUrl);
                }
            },
            error: function(xhr) {
                console.error('Search error:', xhr);
                searchLoading.addClass('d-none');
                searchResults.html('<div class="alert alert-danger">Error loading search results. Please try again.</div>');
            }
        });
    }

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const searchParam = urlParams.get('search');
        searchInput.val(searchParam || '');
        
        if (searchParam) {
            performSearch(searchParam);
        } else {
            // Reload the page to show all records
            window.location.reload();
        }
    });

    // Focus on search input on page load
    searchInput.focus();
});
</script>
@endpush