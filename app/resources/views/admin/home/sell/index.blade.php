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
                        <h4 class="page-title">Sold Properties</h4>
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

            <!-- Search Box and other existing content -->
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

            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Total Selected</h6>
                                    <h3 class="text-primary mb-0">{{ number_format($totalSelectedSize ?? 0, 2) }} SQM</h3>
                                </div>
                                <div class="avatar-sm">
                                    <div class="avatar-title bg-primary-subtle rounded-circle">
                                        <i class="las la-ruler-combined text-primary fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"> 
                    <div class="card border-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Total Available</h6>
                                    <h3 class="text-success mb-0">{{ number_format($totalAvailableSize ?? 11057, 0) }} SQM</h3>
                                </div>
                                <div class="avatar-sm">
                                    <div class="avatar-title bg-success-subtle rounded-circle">
                                        <i class="las la-vector-square text-success fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div> 
                                    <h6 class="text-muted mb-1">Remaining</h6>
                                    <h3 class="text-info mb-0">{{ number_format($remainingAvailableSize, 1) }} SQM</h3>
                                </div> 
                                <div class="avatar-sm"> 
                                    <div class="avatar-title bg-info-subtle rounded-circle">
                                        <i class="las la-layer-group text-info fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sold Properties List -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">List of Sold Properties</h5>
                            <div class="d-flex align-items-center">
                                @if($search)
                                    <span class="badge bg-primary me-2">{{ $sells->total() }} results</span>
                                @endif
                                <span class="badge bg-secondary">Total: {{ $sells->total() }} records</span>
                            </div>
                        </div>

                        <div class="card-body">
                            @if($sells->total() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped align-middle mb-0">
                                    <thead class="table-light">
                                        <tr> 
                                            <th>#</th> 
                                            <th>User Full Name</th>
                                            <th>User Email</th>
                                            <th>Total Assets</th>
                                            <th>Property Name</th>
                                            <th>Sold Size</th>
                                            <th>Available Size</th>
                                            <th>Sale Price</th>
                                            {{-- <th>Wallet Impact</th> --}}
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sells as $sell)
                                            @php 
                                                $index = ($sells->currentPage() - 1) * $sells->perPage() + $loop->index + 1; 
                                            @endphp
  
                                            <tr>
                                                <td><strong>{{ $index }}</strong></td>
                                                <td class="text-uppercase">
                                                    {{ $sell->user->first_name . ' ' . $sell->user->last_name }}
                                                </td>
                                                <td>{{ $sell->user_email }}</td>
                                                <td>
                                                    <span class="badge bg-success fs-6">
                                                        ₦{{ number_format($sell->user->total_assets ?? 0, 2) }}
                                                    </span>
                                                </td>
                                                <td>{{ $sell->property->name }}</td>
                                                <td>{{ number_format($sell->selected_size_land, 2) }} SQM</td>
                                                <td>{{ number_format($sell->available_size ?? 'N/A', 2) }} SQM</td>
                                                {{-- <td>₦{{ number_format($sell->total_price, 2) }}</td> --}}
                                                <td>
                                                    <span class="badge bg-danger">
                                                        <i class="las la-minus-circle me-1"></i>
                                                        ₦{{ number_format($sell->total_price, 2) }}
                                                    </span>
                                                </td>  
                                                <td>
                                                    <span class="badge 
                                                        @if($sell->status == 'completed') bg-success
                                                        @elseif($sell->status == 'pending') bg-warning
                                                        @elseif($sell->status == 'failed') bg-danger
                                                        @else bg-secondary
                                                        @endif">
                                                        {{ ucfirst($sell->status) }}
                                                    </span>
                                                </td> 
                                                <td>{{ $sell->created_at ? $sell->created_at->format('d M Y') : 'N/A' }}</td>
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route('admin.sell.edit', encrypt($sell->id)) }}" class="btn btn-sm btn-outline-primary me-2" title="Edit">
                                                            <i class="las la-pen"></i>
                                                        </a>

                                                        <!-- Delete Button -->
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-danger" 
                                                                title="Delete Sale Record"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#deleteModal{{ $sell->id }}">
                                                            <i class="las la-trash-alt"></i>
                                                        </button>
                                                    </div>

                                                    <!-- Delete Confirmation Modal -->
                                                    <div class="modal fade" id="deleteModal{{ $sell->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $sell->id }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title text-danger" id="deleteModalLabel{{ $sell->id }}">
                                                                        <i class="las la-exclamation-triangle text-warning me-2"></i>
                                                                        Delete Sale Record
                                                                    </h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p class="mb-3">Are you sure you want to delete this sale record?</p>
                                                                    
                                                                    <div class="card border-warning">
                                                                        <div class="card-body">
                                                                            <h6 class="card-title">Sale Details:</h6>
                                                                            <ul class="list-unstyled mb-0">
                                                                                <li><strong>User:</strong> {{ $sell->user->first_name . ' ' . $sell->user->last_name }}</li>
                                                                                <li><strong>Property:</strong> {{ $sell->property->name }}</li>
                                                                                <li><strong>Sold Size:</strong> {{ $sell->selected_size_land }} SQM</li>
                                                                                <li><strong>Sale Price:</strong> ₦{{ number_format($sell->total_price, 2) }}</li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="alert alert-danger mt-3">
                                                                        <h6 class="alert-heading mb-2">This action will:</h6>
                                                                        <ul class="mb-0">
                                                                            <li>Deduct ₦{{ number_format($sell->total_price, 2) }} from user's wallet</li>
                                                                            <li>Add {{ $sell->selected_size_land }} SQM back to property available size</li>
                                                                            <li>Permanently delete this sale record</li>
                                                                        </ul>
                                                                        <p class="mb-0 mt-2"><strong>Warning:</strong> This action cannot be undone!</p>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <form action="{{ route('admin.sell.destroy', encrypt($sell->id)) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger">
                                                                            <i class="las la-trash-alt me-1"></i> Delete & Reverse
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="w-100">
                                            <div class="card border-purple">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h4 class="text-purple mb-0">₦{{ number_format($totalAssetsSum, 2) }}</h4>
                                                        </div>
                                                    </div>
                                                    <small class="text-muted mb-1">Total Assets</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td class="w-100">
                                            <div class="card border-purple">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h4 class="text-purple mb-0">{{ number_format($totalSelectedSize, 2) }} SQM</h4>
                                                        </div>
                                                    </div>
                                                    <small class="text-muted mb-1">Sold Size</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td></td>
                                        {{-- <td class="w-100">
                                            <div class="card border-purple">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h4 class="text-purple mb-0">₦{{ number_format($totalPriceSum, 2) }}</h4>
                                                        </div>
                                                    </div>
                                                    <small class="text-muted mb-1">Total Price</small>
                                                </div>
                                            </div>
                                        </td> --}}
                                        <td class="w-100">
                                            <div class="card border-purple">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h4 class="text-purple mb-0">₦{{ number_format($totalPriceSum, 2) }}</h4>
                                                        </div>
                                                    </div>
                                                    <small class="text-muted mb-1">Total Wallet </small>
                                                </div>
                                            </div>
                                        </td>

                                    </tfoot>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="mt-4 d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Showing {{ $sells->firstItem() }} to {{ $sells->lastItem() }} of {{ $sells->total() }} entries
                                </div>
                                <div>
                                    {{ $sells->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="mb-4">
                                        <i class="las la-search la-4x text-muted"></i>
                                    </div>
                                    <h5 class="text-muted">No sales found</h5>
                                    @if($search)
                                        <p class="text-muted">No results found for your search "{{ $search }}"</p>
                                        <a href="{{ route('admin.sell.index') }}" class="btn btn-primary mt-2">
                                            <i class="las la-list me-1"></i> View All Sales
                                        </a>
                                    @else
                                        <p class="text-muted">There are no property sales in the system yet.</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection