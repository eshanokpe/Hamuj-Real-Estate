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
                        <h4 class="page-title">Buy (Property)</h4>
                    </div>
                </div>
            </div>

            <!-- Property Buy List -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">List of Purchased Properties</h5>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped  align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>User Full Name</th>
                                            <th>User Email</th>
                                            <th>Property Name</th>
                                            {{-- <th>Transaction ID</th> --}}
                                            <th>Selected Size</th>
                                            <th>Remaining Size</th>
                                            <th>Total Price</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($buys as $buy)
                                            @php $index = ($buys->currentPage() - 1) * $buys->perPage() + $loop->index + 1; @endphp

                                            <tr>
                                                <td><strong>{{ $index }}</strong></td>
                                                <td class="text-uppercase">
                                                    {{ $buy->user->first_name . ' ' . $buy->user->last_name }}
                                                </td>
                                                <td>{{ $buy->user_email }}</td>
                                                <td>{{ $buy->property->name }}</td>
                                                {{-- <td>{{ $buy->transaction_id }}</td> --}}
                                                <td>{{ $buy->selected_size_land }} per/sqm</td>
                                                <td>{{ $buy->remaining_size }} sqm</td>
                                                <td>₦{{ number_format($buy->total_price, 2) }}</td>
                                                <td>{{ ucfirst($buy->status) }}</td>
                                                <td>{{ $buy->created_at ? $buy->created_at->format('d F Y') : 'N/A' }}</td>
                                                <td class="text-end d-flex justify-content-end">
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
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11" class="text-center text-muted">No purchases found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <!-- Pagination -->
                                <div class="mt-4 d-flex justify-content-center">
                                    {{ $buys->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div>
            </div> <!-- end row -->

        </div> <!-- end container -->
    </div> <!-- end page-content-tab -->
</div> <!-- end page-wrapper -->
@endsection
