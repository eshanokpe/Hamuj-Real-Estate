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
                <th>Selected Size</th>
                <th>Remaining Size</th>
                <th>Total Price</th>
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
                        @if($search && stripos($sell->user->first_name . ' ' . $sell->user->last_name, $search) !== false)
                            <i class="las la-search text-success ms-1" title="Match found in name"></i>
                        @endif
                    </td>
                    <td>
                        {{ $sell->user_email }}
                        @if($search && stripos($sell->user_email, $search) !== false)
                            <i class="las la-search text-success ms-1" title="Match found in email"></i>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-success fs-6">
                            ₦{{ number_format($sell->user->total_assets ?? 0, 2) }}
                        </span>
                    </td>
                    <td>
                        {{ $sell->property->name }}
                        @if($search && stripos($sell->property->name, $search) !== false)
                            <i class="las la-search text-success ms-1" title="Match found in property name"></i>
                        @endif
                    </td>
                    <td>{{ $sell->selected_size_land }} SQM</td>
                    <td>
                        @if($sell->remaining_size > 0)
                            <span class="badge bg-success">{{ $sell->remaining_size }} SQM</span>
                        @else
                            <span class="badge bg-danger">Sold Out</span>
                        @endif
                    </td>
                    <td>
                        ₦{{ number_format($sell->total_price, 2) }}
                        @if($search && stripos($sell->total_price, $search) !== false)
                            <i class="las la-search text-success ms-1" title="Match found in price"></i>
                        @endif
                    </td>
                    <td>
                        <span class="badge 
                            @if($sell->status == 'completed') bg-success
                            @elseif($sell->status == 'pending') bg-warning
                            @elseif($sell->status == 'failed') bg-danger
                            @else bg-secondary
                            @endif">
                            {{ ucfirst($sell->status) }}
                            @if($search && stripos($sell->status, $search) !== false)
                                <i class="las la-search text-white ms-1" title="Match found in status"></i>
                            @endif
                        </span>
                    </td> 
                    <td>{{ $sell->created_at ? $sell->created_at->format('d M Y') : 'N/A' }}</td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.sell.edit', encrypt($sell->id)) }}" class="btn btn-sm btn-outline-primary me-2" title="Edit">
                                <i class="las la-pen"></i>
                            </a>

                            <form action="{{ route('admin.sell.destroy', encrypt($sell->id)) }}" method="POST" class="d-inline">
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
        <h5 class="text-muted">No purchases found</h5>
        @if($search)
            <p class="text-muted">No results found for your search "{{ $search }}"</p>
            <a href="{{ route('admin.sell.index') }}" class="btn btn-primary mt-2">
                <i class="las la-list me-1"></i> View All Purchases
            </a>
        @else
            <p class="text-muted">There are no property purchases in the system yet.</p>
        @endif
    </div>
@endif