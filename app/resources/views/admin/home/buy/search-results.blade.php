@if($buys->total() > 0)
<div class="table-responsive">
    <table class="table table-striped align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th class="checkbox-column">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="selectAll">
                    </div>
                </th>
                <th>#</th>
                <th>User Full Name</th>
                <th>User Email</th>
                <th>Total Assets</th>
                <th>Property Name</th>
                <th>Selected Size</th>
                <th>Available Size</th>
                <th>Total Price</th>
                <th>Transaction</th>
                <th>Status</th>
                <th>Date</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($buys as $buy)
                @php 
                    $index = ($buys->currentPage() - 1) * $buys->perPage() + $loop->index + 1; 
                @endphp

                <tr>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input buy-checkbox" type="checkbox" name="buy_ids[]" value="{{ encrypt($buy->id) }}">
                        </div>
                    </td>
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
                    </td>
                    <td>
                        {{ $buy->property->name }}
                        @if($search && stripos($buy->property->name, $search) !== false)
                            <i class="las la-search text-success ms-1" title="Match found in property name"></i>
                        @endif
                    </td>
                    <td>{{ number_format($buy->selected_size_land, 2) }} SQM</td>
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
                    <td>
                        @if($buy->transaction_id && $buy->transaction_count > 0)
                            <span class="badge bg-info" title="Transaction ID: {{ $buy->transaction_id }}">
                                <i class="las la-check-circle me-1"></i> Linked
                            </span>
                        @else
                            <span class="badge bg-warning">No Transaction</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge 
                            @if($buy->status == 'completed') bg-success
                            @elseif($buy->status == 'pending') bg-warning
                            @elseif($buy->status == 'failed') bg-danger
                            @else bg-secondary
                            @endif">
                            {{ ucfirst($buy->status) }}
                            @if($search && stripos($buy->status, $search) !== false)
                                <i class="las la-search text-white ms-1" title="Match found in status"></i>
                            @endif
                        </span>
                    </td> 
                    <td>{{ $buy->created_at ? $buy->created_at->format('d M Y') : 'N/A' }}</td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.buy.edit', encrypt($buy->id)) }}" class="btn btn-sm btn-outline-primary me-2" title="Edit">
                                <i class="las la-pen"></i>
                            </a>

                            <!-- Delete Button -->
                            <button type="button" 
                                    class="btn btn-sm btn-outline-danger" 
                                    title="Delete Purchase Record"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal{{ $buy->id }}">
                                <i class="las la-trash-alt"></i>
                            </button>
                        </div>

                        <!-- Delete Confirmation Modal -->
                        <div class="modal fade" id="deleteModal{{ $buy->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $buy->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-danger" id="deleteModalLabel{{ $buy->id }}">
                                            <i class="las la-exclamation-triangle text-warning me-2"></i>
                                            Delete Purchase Record
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="mb-3">Are you sure you want to delete this purchase record?</p>
                                        
                                        <div class="card border-warning">
                                            <div class="card-body">
                                                <h6 class="card-title">Record Details:</h6>
                                                <ul class="list-unstyled mb-0">
                                                    <li><strong>User:</strong> {{ $buy->user->first_name . ' ' . $buy->user->last_name }}</li>
                                                    <li><strong>Property:</strong> {{ $buy->property->name }}</li>
                                                    <li><strong>Size:</strong> {{ $buy->selected_size_land }} SQM</li>
                                                    <li><strong>Price:</strong> ₦{{ number_format($buy->total_price, 2) }}</li>
                                                    <li><strong>Status:</strong> 
                                                        <span class="badge bg-{{ $buy->status == 'completed' ? 'success' : ($buy->status == 'pending' ? 'warning' : 'danger') }}">
                                                            {{ ucfirst($buy->status) }}
                                                        </span>
                                                    </li>
                                                    <li><strong>Transaction:</strong>    
                                                        @if($buy->transaction_id && $buy->transaction_count > 0)
                                                            <span class="text-success">Linked (ID: {{ $buy->transaction_id }})</span>
                                                        @else
                                                            <span class="text-warning">Not Linked</span>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                        <div class="alert alert-info mt-3">
                                            <h6 class="alert-heading mb-2">This action will:</h6>
                                            <ul class="mb-0">
                                                <li>Add <strong>{{ $buy->selected_size_land }} SQM</strong> back to property available size</li>
                                                @if($buy->status === 'completed')
                                                <li>Refund <strong>₦{{ number_format($buy->total_price, 2) }}</strong> to user's wallet</li>
                                                @endif
                                                <li>Delete this purchase record</li>
                                                @if($buy->transaction_id && $buy->transaction_count > 0)
                                                <li>Delete the associated transaction record</li>
                                                @endif
                                            </ul>
                                        </div>

                                        <div class="alert alert-danger mt-3">
                                            <p class="mb-0"><strong>Warning:</strong> This action cannot be undone!</p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('admin.buy.destroy', encrypt($buy->id)) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="las la-trash-alt me-1"></i> Delete & Restore
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
        
        <!-- Table Footer with Totals -->
        <tfoot class="table-light fw-bold">
            <tr>
                <td colspan="0" class="text-end">
                    <strong>TOTALS:</strong>
                </td>
                <td class="text-primary">
                </td>
                <td class="text-primary">
                </td>
                <td class="text-primary">
                </td>
                <td class="text-primary">
                    <!-- Add this card to your summary cards row -->
                    <div class="card border-purple">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Total Assets</h6>
                                    <h3 class="text-purple mb-0">₦{{ number_format($totalAssetsSum, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="text-primary">
                </td>
                <td class="text-primary w-100">
                    <span class="d-flex align-items-center w-100">
                        {{-- <i class="las la-calculator me-2"></i> --}}
                        {{ number_format($totalSelectedSize, 2) }} SQM
                    </span>
                </td>
                <td></td>
                <td class="text-primary">
                    <!-- Add this card to your summary cards row -->
                    <div class="card border-purple">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Total Price</h6>
                                    <h3 class="text-purple mb-0">₦{{ number_format($totalPriceSum, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="progress mb-2" style="height: 8px;">
                        <div class="progress-bar bg-success" role="progressbar" 
                             style="width: {{ $percentageUsed }}%" 
                             aria-valuenow="{{ $percentageUsed }}" 
                             aria-valuemin="0" 
                             aria-valuemax="100"
                             title="{{ $percentageUsed }}% Used">
                        </div>
                    </div>
                    
                    <span class="d-flex align-items-center justify-content-between">
                        <span class="text-success">
                            <i class="las la-chart-pie me-1"></i>
                            {{ number_format($remainingAvailableSize, 0) }} SQM
                        </span>
                        <span class="badge bg-info">
                            {{ 100 - $percentageUsed }}%
                        </span>
                    </span>
                    <small class="text-muted d-block">Remaining from {{ number_format($totalAvailableSize, 0) }} SQM</small>
                </td>
                <td colspan="5"> 
                    <div class="d-flex flex-column">
                        {{-- <div class="mb-1">
                            <span class="text-primary">
                                <i class="las la-percentage me-1"></i>
                                Utilization: {{ $percentageUsed }}%
                            </span>
                        </div> --}}  
                    </div>
                </td>
                <td>
                   
                </td>
            </tr>
        </tfoot>
    </table>
</div>

<!-- Bulk Actions -->
<div class="mt-3 d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <button id="bulkDeleteBtn" class="btn btn-danger btn-sm d-none me-2">
            <i class="las la-trash-alt me-1"></i> Delete Selected
        </button>
        <span class="text-muted small" id="selectedCount">0 selected</span>
    </div>
    <div class="text-muted">
        Showing {{ $buys->firstItem() }} to {{ $buys->lastItem() }} of {{ $buys->total() }} entries
    </div>
</div>

<!-- Pagination -->
<div class="mt-4 d-flex justify-content-center">
    {{ $buys->links('vendor.pagination.bootstrap-4') }}
</div>
@else
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="las la-shopping-cart la-4x text-muted"></i>
        </div>
        <h5 class="text-muted">No purchase records found</h5>
        @if($search)
            <p class="text-muted">No results found for your search "{{ $search }}"</p>
            <a href="{{ route('admin.buy.index') }}" class="btn btn-primary mt-2">
                <i class="las la-list me-1"></i> View All Purchases
            </a>
        @else
            <p class="text-muted">There are no property purchase records in the system yet.</p>
        @endif
    </div>
@endif

<script>
// Update selected count
function updateSelectedCount() {
    const selectedCount = $('input[name="buy_ids[]"]:checked').length;
    $('#selectedCount').text(selectedCount + ' selected');
}

$(document).ready(function() {
    $('input[name="buy_ids[]"]').on('change', updateSelectedCount);
    $('#selectAll').on('change', updateSelectedCount);
    updateSelectedCount();
});
</script>