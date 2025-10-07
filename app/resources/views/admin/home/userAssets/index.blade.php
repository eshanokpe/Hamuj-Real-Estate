@extends('layouts.admin')

@section('content')
<div class="page-wrapper">
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
                                               placeholder="Search by user name, email, or phone..." 
                                               value="{{ $search ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3">
                                    <div class="d-grid gap-2 d-md-flex">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="las la-search me-1"></i> Search
                                        </button>
                                        @if($search)
                                            <a href="{{ route('admin.userAssets.index') }}" class="btn btn-outline-secondary">
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
                                        <span class="badge bg-primary ms-2">{{ $users->total() }} user(s) found</span>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users List -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">All Users with Property Assets</h5>
                            <div class="d-flex align-items-center">
                                @if($search)
                                    <span class="badge bg-primary me-2">{{ $users->total() }} results</span>
                                @endif
                                <span class="badge bg-secondary">Total: {{ $users->total() }} users</span>
                            </div>
                        </div>

                        <div class="card-body">
                            @if($users->total() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>User Full Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Total Property Assets</th>
                                            <th>Properties Owned</th>
                                            <th>Registration Date</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            @php 
                                                $index = ($users->currentPage() - 1) * $users->perPage() + $loop->index + 1; 
                                            @endphp
  
                                            <tr>
                                                <td><strong>{{ $index }}</strong></td>
                                                <td class="text-uppercase">
                                                    {{ $user->first_name . ' ' . $user->last_name }}
                                                    @if($search && stripos($user->first_name . ' ' . $user->last_name, $search) !== false)
                                                        <i class="las la-search text-success ms-1" title="Match found in name"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $user->email }}
                                                    @if($search && stripos($user->email, $search) !== false)
                                                        <i class="las la-search text-success ms-1" title="Match found in email"></i>
                                                    @endif
                                                </td>
                                                <td>{{ $user->phone ?? 'N/A' }}</td>
                                                <td>
                                                    <span class="badge bg-success fs-6">
                                                        ₦{{ number_format($user->total_assets ?? 0, 2) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($user->properties_count > 0)
                                                        <span class="badge bg-info">{{ $user->properties_count }} properties</span>
                                                    @else
                                                        <span class="badge bg-secondary">No properties</span>
                                                    @endif
                                                </td>
                                                <td>{{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}</td>
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route('admin.users.show', encrypt($user->id)) }}" class="btn btn-sm btn-outline-primary me-2" title="View Details">
                                                            <i class="las la-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.users.edit', encrypt($user->id)) }}" class="btn btn-sm btn-outline-warning me-2" title="Edit">
                                                            <i class="las la-pen"></i>
                                                        </a>
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
                                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
                                </div>
                                <div>
                                    {{ $users->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="mb-4">
                                        <i class="las la-users la-4x text-muted"></i>
                                    </div>
                                    <h5 class="text-muted">No users found</h5>
                                    @if($search)
                                        <p class="text-muted">No users found for your search "{{ $search }}"</p>
                                        <a href="{{ route('admin.userAssets.index') }}" class="btn btn-primary mt-2">
                                            <i class="las la-list me-1"></i> View All Users
                                        </a>
                                    @else
                                        <p class="text-muted">There are no users in the system yet.</p>
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