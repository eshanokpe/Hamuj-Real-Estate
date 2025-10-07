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
                        <h4 class="page-title">User Assets (Property)</h4>
                    </div>
                </div>
            </div>

            <!-- Search Box -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('admin.userAssets.index') }}" method="GET" class="row g-3">
                                <div class="col-lg-10 col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="las la-search"></i>
                                        </span>
                                        <input type="text" 
                                               name="search" 
                                               class="form-control border-start-0" 
                                               placeholder="Search by user name, email, property name, size, price, or status..." 
                                               value="{{ $search ?? '' }}">
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

            <!-- Property Buy List -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">List of Purchased Assets</h5>
                            <div class="d-flex align-items-center">
                                @if($search)
                                    <span class="badge bg-primary me-2">{{ $buys->total() }} results</span>
                                @endif
                                <span class="badge bg-secondary">Total: {{ $buys->total() }} records</span>
                            </div>
                        </div>

                        <div class="card-body">
                            @if($buys->total() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>User Full Name</th>
                                            <th>User Email</th>
                                            <th>Total Assets</th>
                                            <th>Property Name</th>
                                            <th>Selected Size</th>
                                            <th>Remaining Size</th>
                                            <th>Total Price</th>
                                            <th>Date</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $buy)
                                            @php 
                                                $index = ($buys->currentPage() - 1) * $buys->perPage() + $loop->index + 1; 
                                            @endphp
  
                                            <tr>
                                                <td><strong>{{ $index }}</strong></td>
                                                <td class="text-uppercase">
                                                    {{ $buy->user->first_name . ' ' . $buy->user->last_name }}
                                                    @if($search && stripos($buy->user->first_name . ' ' . $buy->user->last_name, $search) !== false)
                                                        <i class="las la-search text-success ms-1" title="Match found in name"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $buy->user_email }}
                                                    @if($search && stripos($buy->user_email, $search) !== false)
                                                        <i class="las la-search text-success ms-1" title="Match found in email"></i>
                                                    @endif
                                                </td> 
                                                <td>
                                                    <span class="badge bg-success fs-6">
                                                        ₦{{ number_format($buy->user->total_assets ?? 0, 2) }}
                                                    </span>
                                                    <!-- Temporary debug -->
                                                    {{-- <small class="text-muted d-block">User ID: {{ $buy->user->id }}</small> --}}
                                                </td>
                                                <td>
                                                    {{ $buy->property->name }}
                                                    @if($search && stripos($buy->property->name, $search) !== false)
                                                        <i class="las la-search text-success ms-1" title="Match found in property name"></i>
                                                    @endif
                                                </td>
                                                <td>{{ $buy->selected_size_land }} SQM</td>
                                                <td>
                                                    @if($buy->remaining_size > 0)
                                                        <span class="badge bg-success">{{ $buy->remaining_size }} SQM</span>
                                                    @else
                                                        <span class="badge bg-danger">Sold Out</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    ₦{{ number_format($buy->total_price, 2) }}
                                                    @if($search && stripos($buy->total_price, $search) !== false)
                                                        <i class="las la-search text-success ms-1" title="Match found in price"></i>
                                                    @endif
                                                </td>
                                                <td>{{ $buy->created_at ? $buy->created_at->format('d M Y') : 'N/A' }}</td>
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route('admin.buy.edit', encrypt($buy->id)) }}" class="btn btn-sm btn-outline-primary me-2" title="Edit">
                                                            <i class="las la-pen"></i>
                                                        </a>

                                                        <form action="{{ route('admin.buy.destroy', encrypt($buy->id)) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this property?');" title="Delete">
                                                                <i class="las la-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="mt-4 d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Showing {{ $buys->firstItem() }} to {{ $buys->lastItem() }} of {{ $buys->total() }} entries
                                </div>
                                <div>
                                    {{ $buys->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="mb-4">
                                        <i class="las la-search la-4x text-muted"></i>
                                    </div>
                                    <h5 class="text-muted">No purchases found</h5>
                                    @if($search)
                                        <p class="text-muted">No results found for your search "{{ $search }}"</p>
                                        <a href="{{ route('admin.buy.index') }}" class="btn btn-primary mt-2">
                                            <i class="las la-list me-1"></i> View All Purchases
                                        </a>
                                    @else
                                        <p class="text-muted">There are no property purchases in the system yet.</p>
                                    @endif
                                </div>
                            @endif
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
</style>
@endpush