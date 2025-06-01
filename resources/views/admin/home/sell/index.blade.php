@extends('layouts.admin')

@section('content')

<div class="page-wrapper">
    <div class="page-content-tab">
        <div class="container-fluid">

            <!-- Page Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Property Sales</h4>
                    </div>
                </div>
            </div>
            <!-- End Page Title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">List of Sold Properties</h4>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>User Name</th>
                                            <th>User Email</th>
                                            <th>Property</th>
                                            <th>Transaction ID</th>
                                            <th>Selected Land Size</th>
                                            <th>Remaining Land Size</th>
                                            <th>Total Price</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($sells as $sell)
                                            <tr>
                                                <td><strong>{{ $loop->iteration }}</strong></td>
                                                <td class="text-uppercase">
                                                    {{ $sell->user->first_name }} {{ $sell->user->last_name }}
                                                </td>
                                                <td>{{ $sell->user_email }}</td>
                                                <td>{{ $sell->property->name }}</td>
                                                <td>{{ $sell->transaction_id }}</td>
                                                <td>{{ $sell->selected_size_land }}</td>
                                                <td>{{ $sell->remaining_size }}</td>
                                                <td>₦{{ number_format($sell->total_price, 2) }}</td>
                                                <td>{{ ucfirst($sell->status) }}</td>
                                                <td>{{ $sell->created_at ? $sell->created_at->format('d M Y') : 'N/A' }}</td>
                                                <td class="text-end">
                                                    <a href="{{ route('admin.sell.edit', encrypt($sell->id)) }}" class="text-secondary me-2">
                                                        <i class="las la-pen font-16"></i>
                                                    </a>

                                                    <form action="{{ route('admin.sell.destroy', encrypt($sell->id)) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link text-danger p-0 m-0">
                                                            <i class="las la-trash-alt font-16"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11" class="text-center">No records found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="mt-4 d-flex justify-content-center">
                                    {{ $sells->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
