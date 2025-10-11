@if($wallets->total() > 0)
<div class="table-responsive">
    <table class="table table-striped mb-0">
        <thead> 
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Balance</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody> 
            @foreach ($wallets as $wallet)
                @php $index = ($wallets->currentPage() - 1) * $wallets->perPage() + $loop->index + 1; @endphp
                
                <tr>
                    <td><strong>{{ $index }}</strong></td>
                    <td style="text-transform: uppercase;">
                        {{ trim((optional($wallet->user)->first_name ?? '') . ' ' . (optional($wallet->user)->last_name ?? '')) }}
                        @if($search && $wallet->user && stripos($wallet->user->first_name . ' ' . $wallet->user->last_name, $search) !== false)
                            <i class="las la-search text-success ms-1" title="Match found in name"></i>
                        @endif
                    </td>
                    <td>
                        {{ $wallet->user->email ?? '' }}
                        @if($search && $wallet->user && stripos($wallet->user->email ?? '', $search) !== false)
                            <i class="las la-search text-success ms-1" title="Match found in email"></i>
                        @endif
                    </td>
                    <td>
                        ₦{{ number_format($wallet->balance ?? 0, 2) }}
                        @if($search && stripos($wallet->balance ?? '', $search) !== false)
                            <i class="las la-search text-success ms-1" title="Match found in balance"></i>
                        @endif
                    </td>
                    <td>{{ $wallet->created_at->format('d F Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table><!--end /table-->
    
    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-between align-items-center">
        <div class="text-muted">
            Showing {{ $wallets->firstItem() }} to {{ $wallets->lastItem() }} of {{ $wallets->total() }} entries
        </div>
        <div>
            {{ $wallets->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</div><!--end /tableresponsive-->
@else
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="las la-wallet la-4x text-muted"></i>
        </div>
        <h5 class="text-muted">No wallets found</h5>
        @if($search)
            <p class="text-muted">No results found for your search "{{ $search }}"</p>
            <a href="{{ route('admin.wallet.index') }}" class="btn btn-primary mt-2">
                <i class="las la-list me-1"></i> View All Wallets
            </a>
        @else
            <p class="text-muted">There are no wallets in the system yet.</p>
        @endif
    </div>
@endif