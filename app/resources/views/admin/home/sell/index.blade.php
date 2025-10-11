@extends('layouts.admin')

@section('content')
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="page-content-tab">
        <div class="container-fluid">
            
            <!-- Page Title -->
            <div class="row mb-4">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Sell (Property)</h4>
                    </div>
                </div>
            </div>

            <!-- Search Box -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <form id="searchForm" action="{{ route('admin.sell.index') }}" method="GET" class="row g-3">
                                <div class="col-lg-10 col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="las la-search"></i>
                                        </span>
                                        <input type="text" 
                                               name="search" 
                                               id="searchInput"
                                               class="form-control border-start-0" 
                                               placeholder="Search by user name, email, property name, size, price, or status..." 
                                               value="{{ $search ?? '' }}"
                                               autocomplete="off">
                                        <span id="searchLoading" class="input-group-text d-none">
                                            <div class="spinner-border spinner-border-sm" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </span>
                                    </div> 
                                    <div id="searchSuggestions" class="dropdown-menu w-100 mt-1" style="display: none;">
                                        <!-- Suggestions will appear here -->
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3">
                                    <div class="d-grid gap-2 d-md-flex">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="las la-search me-1"></i> Search
                                        </button>
                                        @if($search)
                                            <a href="{{ route('admin.sell.index') }}" class="btn btn-outline-secondary">
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
                                        <span class="badge bg-primary ms-2">{{ $sells->total() }} result(s) found</span>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Property sell List -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">List of Purchased Properties</h5>
                            <div class="d-flex align-items-center">
                                @if($search)
                                    <span class="badge bg-primary me-2">{{ $sells->total() }} results</span>
                                @endif
                                <span class="badge bg-secondary">Total: {{ $sells->total() }} records</span>
                            </div>
                        </div>

                        <div class="card-body">
                            <div id="searchResults">
                                @include('admin.home.sell.search-results')
                            </div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div>
            </div> <!-- end row -->

        </div> <!-- end container -->
    </div> <!-- end page-content-tab -->
</div> <!-- end page-wrapper -->
@endsection

@push('styles')
<style>
.badge.bg-success {
    font-size: 0.75rem;
    padding: 0.35em 0.65em;
}
.table td {
    vertical-align: middle;
}
.input-group-text {
    background-color: #f8f9fa;
    border-color: #dee2e6;
}
.dropdown-item:hover {
    background-color: #f8f9fa;
    cursor: pointer;
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
    const searchSuggestions = $('#searchSuggestions');

    // Real-time search with debouncing
    searchInput.on('input', function() {
        const searchTerm = $(this).val().trim();
        
        // Clear previous timeout
        clearTimeout(searchTimeout);
        
        // Hide suggestions if empty
        if (searchTerm.length === 0) {
            searchSuggestions.hide();
            return;
        }

        // Show loading indicator
        searchLoading.removeClass('d-none');

        // Set new timeout for search
        searchTimeout = setTimeout(() => {
            performSearch(searchTerm);
        }, 500); // 500ms delay

        // Show suggestions for quick terms
        if (searchTerm.length > 2) {
            fetchSuggestions(searchTerm);
        } else {
            searchSuggestions.hide();
        }
    });

    // Handle form submission
    searchForm.on('submit', function(e) {
        e.preventDefault();
        const searchTerm = searchInput.val().trim();
        performSearch(searchTerm, true);
    });

    // Click outside to close suggestions
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#searchInput, #searchSuggestions').length) {
            searchSuggestions.hide();
        }
    });

    // Function to perform search
    function performSearch(searchTerm, updateUrl = false) {
        if (searchTerm.length === 0) {
            // If search is empty, reload the page without search
            if (updateUrl) {
                window.location.href = "{{ route('admin.sell.index') }}";
            }
            return;
        }

        $.ajax({
            url: "{{ route('admin.sell.search') }}",
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
                searchSuggestions.hide();
                
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
                searchSuggestions.hide();
            }
        });
    }

    // Function to fetch search suggestions
    function fetchSuggestions(searchTerm) {
        $.ajax({
            url: "{{ route('admin.sell.suggestions') }}",
            type: "GET",
            data: {
                search: searchTerm,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.suggestions && response.suggestions.length > 0) {
                    let suggestionsHtml = '';
                    
                    response.suggestions.forEach(suggestion => {
                        suggestionsHtml += `
                            <a class="dropdown-item suggestion-item" href="#" data-search="${suggestion.text}">
                                <div class="d-flex align-items-center">
                                    <i class="las la-${suggestion.icon} text-muted me-2"></i>
                                    <div>
                                        <div class="fw-medium">${suggestion.text}</div>
                                        <small class="text-muted">${suggestion.type}</small>
                                    </div>
                                </div>
                            </a>
                        `;
                    });

                    searchSuggestions.html(suggestionsHtml).show();
                    
                    // Handle suggestion click
                    $('.suggestion-item').on('click', function(e) {
                        e.preventDefault();
                        const searchText = $(this).data('search');
                        searchInput.val(searchText);
                        performSearch(searchText, true);
                    });
                } else {
                    searchSuggestions.hide();
                }
            },
            error: function(xhr) {
                console.error('Suggestions error:', xhr);
                searchSuggestions.hide();
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
});
</script>
@endpush
