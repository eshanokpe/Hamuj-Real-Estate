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
                        <h4 class="page-title">Transactions</h4>
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="las la-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="las la-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Search Box -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <form id="searchForm" action="{{ route('admin.transactions.index') }}" method="GET" class="row g-3">
                                <div class="col-lg-10 col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="las la-search"></i>
                                        </span>
                                        <input type="text" 
                                               name="search" 
                                               id="searchInput"
                                               class="form-control border-start-0" 
                                               placeholder="Search by user name, email, reference, property, amount, status..." 
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
                                            <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline-secondary">
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
                                        <span class="badge bg-primary ms-2">{{ $transactions->total() }} result(s) found</span>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions List -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Transaction List</h4>
                            <div class="d-flex align-items-center">
                                @if($search)
                                    <span class="badge bg-primary me-2">{{ $transactions->total() }} results</span>
                                @endif
                                <span class="badge bg-secondary">Total: {{ $transactions->total() }} records</span>
                            </div>
                        </div><!--end card-header-->

                        <div class="card-body">
                            <div id="searchResults">
                                @include('admin.home.transactions.search-results')
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

<!-- Bulk Delete Modal -->
<div class="modal fade" id="bulkDeleteModal" tabindex="-1" aria-labelledby="bulkDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="bulkDeleteModalLabel">
                    <i class="las la-exclamation-triangle text-warning me-2"></i>
                    Delete Multiple Transactions
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Are you sure you want to delete the selected transactions?</p>
                <div class="alert alert-danger">
                    <h6 class="alert-heading mb-2">This action will permanently delete all selected transactions.</h6>
                    <p class="mb-0"><strong>Warning:</strong> This action cannot be undone!</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="bulkDeleteForm" action="{{ route('admin.transactions.destroy-multiple') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="las la-trash-alt me-1"></i> Delete Selected
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
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
.checkbox-column {
    width: 40px;
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
            return;
        }

        // Show loading indicator
        searchLoading.removeClass('d-none');

        // Set new timeout for search
        searchTimeout = setTimeout(() => {
            performSearch(searchTerm);
        }, 500); // 500ms delay
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
                window.location.href = "{{ route('admin.transactions.index') }}";
            }
            return;
        }

        $.ajax({
            url: "{{ route('admin.transactions.search') }}",
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
            }
        });
    }

    // Handle bulk delete
    $(document).on('click', '#bulkDeleteBtn', function() {
        const selectedCount = $('input[name="transaction_ids[]"]:checked').length;
        if (selectedCount > 0) {
            $('#bulkDeleteModal').modal('show');
        } else {
            alert('Please select at least one transaction to delete.');
        }
    });

    // Handle select all checkbox
    $(document).on('change', '#selectAll', function() {
        $('input[name="transaction_ids[]"]').prop('checked', this.checked);
        toggleBulkDeleteButton();
    });

    // Handle individual checkbox changes
    $(document).on('change', 'input[name="transaction_ids[]"]', function() {
        toggleBulkDeleteButton();
        updateSelectAllCheckbox();
    });

    function toggleBulkDeleteButton() {
        const selectedCount = $('input[name="transaction_ids[]"]:checked').length;
        const bulkDeleteBtn = $('#bulkDeleteBtn');
        
        if (selectedCount > 0) {
            bulkDeleteBtn.removeClass('d-none').text(`Delete Selected (${selectedCount})`);
        } else {
            bulkDeleteBtn.addClass('d-none');
        }
    }

    function updateSelectAllCheckbox() {
        const totalCheckboxes = $('input[name="transaction_ids[]"]').length;
        const checkedCheckboxes = $('input[name="transaction_ids[]"]:checked').length;
        $('#selectAll').prop('checked', totalCheckboxes === checkedCheckboxes);
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
