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
                        <h4 class="page-title">Property Purchases</h4>
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
                            <form id="searchForm" action="{{ route('admin.buy.index') }}" method="GET" class="row g-3">
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
                                </div>
                                <div class="col-lg-2 col-md-3">
                                    <div class="d-grid gap-2 d-md-flex">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="las la-search me-1"></i> Search
                                        </button>
                                        @if($search)
                                            <a href="{{ route('admin.buy.index') }}" class="btn btn-outline-secondary">
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
                                        <span class="badge bg-primary ms-2">{{ $buys->total() }} result(s) found</span>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Property Purchases List -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Property Purchase Records</h5>
                            <div class="d-flex align-items-center">
                                @if($search)
                                    <span class="badge bg-primary me-2">{{ $buys->total() }} results</span>
                                @endif
                                <span class="badge bg-secondary">Total: {{ $buys->total() }} records</span>
                            </div>
                        </div>

                        <div class="card-body">
                            <div id="searchResults">
                                @include('admin.home.buy.search-results')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer Table - Total Land Usage Summary -->
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">Land Usage Summary</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">Total Available Size</th>
                                <th class="text-center">Total Selected Size</th>
                                <th class="text-center">Remaining Size</th>
                                <th class="text-center">Percentage Used</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center fw-bold" style="font-size: 1.1rem;">
                                    <span class="badge bg-primary rounded-pill p-2">
                                        11,057 units
                                    </span>
                                </td>
                                <td class="text-center fw-bold" style="font-size: 1.1rem;">
                                    <span class="badge bg-success rounded-pill p-2">
                                        {{ number_format($totalSelectedSize, 2) }} units
                                    </span>
                                </td>
                                <td class="text-center fw-bold" style="font-size: 1.1rem;">
                                    <span class="badge bg-{{ $remainingSize >= 0 ? 'warning' : 'danger' }} rounded-pill p-2">
                                        {{ number_format($remainingSize, 2) }} units
                                    </span>
                                </td>
                                <td class="text-center fw-bold" style="font-size: 1.1rem;">
                                    <div class="progress" style="height: 30px;">
                                        <div class="progress-bar 
                                            @if($percentageUsed <= 50) bg-success
                                            @elseif($percentageUsed <= 80) bg-warning
                                            @else bg-danger
                                            @endif" 
                                            role="progressbar" 
                                            style="width: {{ min($percentageUsed, 100) }}%"
                                            aria-valuenow="{{ $percentageUsed }}" 
                                            aria-valuemin="0" 
                                            aria-valuemax="100">
                                            {{ number_format($percentageUsed, 2) }}%
                                        </div>
                                    </div>
                                    <small class="text-muted mt-1 d-block">
                                        {{ number_format($percentageUsed, 2) }}% of total land used
                                    </small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Additional Stats Row -->
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="card border-primary border">
                            <div class="card-body text-center">
                                <h6 class="card-title text-primary">Total Properties Purchased</h6>
                                <h3 class="text-primary">{{ $buys->total() }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-success border">
                            <div class="card-body text-center">
                                <h6 class="card-title text-success">Avg. Size per Purchase</h6>
                                <h3 class="text-success">
                                    {{ $buys->total() > 0 ? number_format($totalSelectedSize / $buys->total(), 2) : 0 }} units
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-warning border">
                            <div class="card-body text-center">
                                <h6 class="card-title text-warning">Available Capacity</h6>
                                <h3 class="text-warning">
                                    @if($remainingSize > 0)
                                        {{ number_format($remainingSize, 2) }} units
                                    @else
                                        <span class="text-danger">Over Capacity</span>
                                    @endif
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-info border">
                            <div class="card-body text-center">
                                <h6 class="card-title text-info">Utilization Rate</h6>
                                <h3 class="text-info">{{ number_format($percentageUsed, 2) }}%</h3>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Usage Distribution Pie Chart (if you want visual representation) -->
                @if($percentageUsed > 0)
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Land Distribution</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <canvas id="landDistributionChart" height="200"></canvas>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Category</th>
                                                        <th class="text-end">Size (units)</th>
                                                        <th class="text-end">Percentage</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><span class="badge bg-success me-2">●</span> Used Land</td>
                                                        <td class="text-end">{{ number_format($totalSelectedSize, 2) }}</td>
                                                        <td class="text-end">{{ number_format($percentageUsed, 2) }}%</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge bg-warning me-2">●</span> Available Land</td>
                                                        <td class="text-end">{{ number_format(max(0, $remainingSize), 2) }}</td>
                                                        <td class="text-end">{{ number_format(max(0, 100 - $percentageUsed), 2) }}%</td>
                                                    </tr>
                                                    <tr class="table-light">
                                                        <td><strong>Total Land</strong></td>
                                                        <td class="text-end"><strong>{{ number_format($totalAvailableSize, 2) }}</strong></td>
                                                        <td class="text-end"><strong>100%</strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

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
                    Delete Multiple Purchases
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Are you sure you want to delete the selected purchase records?</p>
                <div class="alert alert-danger">
                    <h6 class="alert-heading mb-2">This action will permanently delete:</h6>
                    <ul class="mb-0">
                        <li>Selected purchase records</li>
                        <li>Associated transaction records</li>
                    </ul>
                    <p class="mb-0 mt-2"><strong>Warning:</strong> This action cannot be undone!</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="bulkDeleteForm" action="{{ route('admin.buy.destroy-multiple') }}" method="POST">
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
        
        clearTimeout(searchTimeout);
        
        if (searchTerm.length === 0) {
            return;
        }

        searchLoading.removeClass('d-none');

        searchTimeout = setTimeout(() => {
            performSearch(searchTerm);
        }, 500);
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
            if (updateUrl) {
                window.location.href = "{{ route('admin.buy.index') }}";
            }
            return;
        }

        $.ajax({
            url: "{{ route('admin.buy.search') }}",
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
        const selectedCount = $('input[name="buy_ids[]"]:checked').length;
        if (selectedCount > 0) {
            $('#bulkDeleteModal').modal('show');
        } else {
            alert('Please select at least one purchase record to delete.');
        }
    });

    // Handle select all checkbox
    $(document).on('change', '#selectAll', function() {
        $('input[name="buy_ids[]"]').prop('checked', this.checked);
        toggleBulkDeleteButton();
    });

    // Handle individual checkbox changes
    $(document).on('change', 'input[name="buy_ids[]"]', function() {
        toggleBulkDeleteButton();
        updateSelectAllCheckbox();
    });

    function toggleBulkDeleteButton() {
        const selectedCount = $('input[name="buy_ids[]"]:checked').length;
        const bulkDeleteBtn = $('#bulkDeleteBtn');
        
        if (selectedCount > 0) {
            bulkDeleteBtn.removeClass('d-none').text(`Delete Selected (${selectedCount})`);
        } else {
            bulkDeleteBtn.addClass('d-none');
        }
    }

    function updateSelectAllCheckbox() {
        const totalCheckboxes = $('input[name="buy_ids[]"]').length;
        const checkedCheckboxes = $('input[name="buy_ids[]"]:checked').length;
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
            window.location.reload();
        }
    });
});
</script>
@endpush