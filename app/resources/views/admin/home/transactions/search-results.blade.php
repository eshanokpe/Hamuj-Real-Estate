@if($transactions->total() > 0)
<div class="table-responsive">
    <table class="table table-striped mb-0">
        <thead> 
            <tr>
                <th class="checkbox-column">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="selectAll">
                    </div>
                </th>
                <th>#</th>
                <th>User FullName</th>
                <th>Email</th>
                <th>Transaction Ref.</th>
                <th>Source</th>
                <th>Property Name</th>
                <th>Payment Method</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody> 
            @foreach ($transactions as $transaction)
            @php $index = ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->index + 1; @endphp

                <tr>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input transaction-checkbox" type="checkbox" name="transaction_ids[]" value="{{ encrypt($transaction->id) }}">
                        </div>
                    </td>
                    <td><strong>{{ $index }}</strong></td>
                    <td style="text-transform: uppercase;">
                        {{ $transaction->user->first_name . ' ' . $transaction->user->last_name }}
                        @if($search && stripos($transaction->user->first_name . ' ' . $transaction->user->last_name, $search) !== false)
                            <i class="las la-search text-success ms-1" title="Match found in name"></i>
                        @endif
                    </td>
                    <td>
                        {{ $transaction->email ?? '' }}
                        @if($search && stripos($transaction->email ?? '', $search) !== false)
                            <i class="las la-search text-success ms-1" title="Match found in email"></i>
                        @endif
                    </td>
                    <td>
                        {{ $transaction->reference ?? '' }}
                        @if($search && stripos($transaction->reference ?? '', $search) !== false)
                            <i class="las la-search text-success ms-1" title="Match found in reference"></i>
                        @endif
                    </td>
                    <td>{{ $transaction->source ?? '' }}</td>    
                    <td>
                        {{ $transaction->property_name ?? '' }}
                        @if($search && stripos($transaction->property_name ?? '', $search) !== false)
                            <i class="las la-search text-success ms-1" title="Match found in property"></i>
                        @endif
                    </td>
                    <td>{{ $transaction->payment_method ?? '' }}</td>
                    <td>
                        ₦{{ number_format($transaction->amount ?? 0, 2) }}
                        @if($search && stripos($transaction->amount ?? '', $search) !== false)
                            <i class="las la-search text-success ms-1" title="Match found in amount"></i>
                        @endif
                    </td>
                    <td>
                        @if($transaction->status === 'pending')
                            <span class="badge bg-warning">{{ ucfirst($transaction->status) }}</span>
                        @elseif($transaction->status === 'completed' || $transaction->status === 'success')
                            <span class="badge bg-success">{{ ucfirst($transaction->status) }}</span>
                        @elseif($transaction->status === 'failed' || $transaction->status === 'cancelled')
                            <span class="badge bg-danger">{{ ucfirst($transaction->status) }}</span>
                        @endif
                        @if($search && stripos($transaction->status, $search) !== false)
                            <i class="las la-search text-white ms-1" title="Match found in status"></i>
                        @endif
                    </td>
                    <td>{{ $transaction->created_at->format('d F Y') }}</td>
                    <td class="text-end">
                        <div class="btn-group">
                            <button type="button" 
                                    class="btn btn-sm btn-outline-danger" 
                                    title="Delete Transaction"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal{{ $transaction->id }}">
                                <i class="las la-trash-alt"></i>
                            </button>
                        </div>

                        <!-- Delete Confirmation Modal -->
                        <div class="modal fade" id="deleteModal{{ $transaction->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $transaction->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-danger" id="deleteModalLabel{{ $transaction->id }}">
                                            <i class="las la-exclamation-triangle text-warning me-2"></i>
                                            Delete Transaction
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="mb-3">Are you sure you want to delete this transaction?</p>
                                        
                                        <div class="card border-warning">
                                            <div class="card-body">
                                                <h6 class="card-title">Transaction Details:</h6>
                                                <ul class="list-unstyled mb-0">
                                                    <li><strong>User:</strong> {{ $transaction->user->first_name . ' ' . $transaction->user->last_name }}</li>
                                                    <li><strong>Reference:</strong> {{ $transaction->reference }}</li>
                                                    <li><strong>Amount:</strong> ₦{{ number_format($transaction->amount, 2) }}</li>
                                                    <li><strong>Property:</strong> {{ $transaction->property_name ?? 'N/A' }}</li>
                                                    <li><strong>Status:</strong> <span class="badge bg-{{ $transaction->status === 'success' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'danger') }}">{{ ucfirst($transaction->status) }}</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                        <div class="alert alert-danger mt-3">
                                            <p class="mb-0"><strong>Warning:</strong> This action cannot be undone!</p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('admin.transactions.destroy', encrypt($transaction->id)) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="las la-trash-alt me-1"></i> Delete Transaction
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
    </table><!--end /table-->
    
    <!-- Bulk Actions -->
    <div class="mt-3 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <button id="bulkDeleteBtn" class="btn btn-danger btn-sm d-none me-2">
                <i class="las la-trash-alt me-1"></i> Delete Selected
            </button>
            <span class="text-muted small" id="selectedCount">0 selected</span>
        </div>
        <div class="text-muted">
            Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} entries
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $transactions->links('vendor.pagination.bootstrap-4') }}
    </div>
</div><!--end /tableresponsive-->
@else
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="las la-exchange-alt la-4x text-muted"></i>
        </div>
        <h5 class="text-muted">No transactions found</h5>
        @if($search)
            <p class="text-muted">No results found for your search "{{ $search }}"</p>
            <a href="{{ route('admin.transactions.index') }}" class="btn btn-primary mt-2">
                <i class="las la-list me-1"></i> View All Transactions
            </a>
        @else
            <p class="text-muted">There are no transactions in the system yet.</p>
        @endif
    </div>
@endif

<script>
// Update selected count
function updateSelectedCount() {
    const selectedCount = $('input[name="transaction_ids[]"]:checked').length;
    $('#selectedCount').text(selectedCount + ' selected');
}

$(document).ready(function() {
    $('input[name="transaction_ids[]"]').on('change', updateSelectedCount);
    $('#selectAll').on('change', updateSelectedCount);
    updateSelectedCount();
});
</script>