 <table class="sales__report--table table-responsive">
    <thead>
        <tr> 
            <th style="width: 5%; padding: 10px;">#</th>
            <th style="width: 20%; padding: 5px;">Type</th>
            <th style="width: 20%; padding: 5px;">Details</th>
            <th style="width: 15%; padding: 5px;">Amount</th>
            <th style="width: 15%; padding: 5px;">Date</th>
            <th style="width: 10%; padding: 5px;">Status</th>
            <th style="width: 10%; padding: 5px;">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($transactions as $transaction)
            @php
                $originalTransactionType = $transaction['type'] ?? null;

                $isDeposit = ($originalTransactionType === 'dedicated_nuban');
                $isTransfer = ($originalTransactionType === 'transfer');
                
                // Determine display type string
                if ($originalTransactionType === 'dedicated_nuban') {
                    $type = 'Deposit'; 
                } else {
                    $type = $originalTransactionType ?? 'Deposit' ?? 'N/A';
                }
                $description = $transaction['reason'] ?? ($transaction['description'] ?? null);
                $bankName = $transaction['bankName'] ?? ($transaction['bank_name'] ?? '');
                $accountName = $transaction['accountName'] ?? ($transaction['account_name'] ?? ($transaction['recipient_name'] ?? ''));
                
                // Status handling with fallbacks
                $status = strtolower(
                    $transaction['status'] ?? 
                    ($transaction['transaction_state'] ?? 
                    ($transaction['metadata']['status'] ?? 'pending'))
                );
                
                // Status classes
                $statusClass = 'secondary';
                if(in_array($status, ['successful', 'completed', 'success'])) {
                    $statusClass = 'success';
                } elseif($status == 'pending') {
                    $statusClass = 'warning';
                } elseif(in_array($status, ['failed', 'cancelled'])) {
                    $statusClass = 'danger';
                }
                
                // Amount formatting
                $amount = $transaction['amount'] ?? 0;
                $amountValue = is_numeric($amount) ? number_format($amount, 2) : number_format(floatval($amount), 2);
            @endphp
            
            <tr>
                <td style="padding: 10px;">{{ $loop->iteration }}</td>
                <td style="padding: 5px;">
                    <span class="sales__report--body__text">
                        {{ ucfirst($type) }}
                        @if($description)
                            <br>
                            <small class="text-muted">{{ $description }}</small>
                        @endif
                    </span>
                </td>
                <td style="padding: 5px;">
                    <span class="sales__report--body__text">
                        @if($bankName || $accountName)
                            {{ $bankName }}<br>
                            <b>{{ ucfirst($accountName) }}</b>
                        @else
                            N/A
                        @endif
                    </span>
                </td> 
                <td style="padding: 5px;">
                    <span class="sales__report--body__text {{ $isTransfer ? 'text-danger' : 'text-success' }}">
                        {{ $isTransfer ? '-' : ($isTransfer ? '-' : '+') }}₦{{ $amountValue }}
                    </span>
                </td>
                <td style="padding: 5px;">
                    <span class="sales__report--body__text">
                        @if(isset($transaction['created_at']))
                            {{ \Carbon\Carbon::parse($transaction['created_at'])->format('M d, Y g:i A') }}
                        @else 
                            N/A
                        @endif
                    </span>
                </td>
                <td style="padding: 5px;">
                    <button class="btn btn-{{ $statusClass }} btn-sm">
                        {{ ucfirst($status) }}
                    </button>
                </td>   
                <td style="padding: 5px;">
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('user.transaction.download', $transaction['id']) }}"
                        class="btn btn-primary"
                        title="Download Receipt">
                            <i class="fas fa-download"></i>
                        </a>
                        <a href="{{ route('user.transaction.show', encrypt($transaction['id'])) }}"
                        class="btn btn-info"
                        title="View Details">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center" style="padding: 10px;">
                    No transactions found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- @if($totalTransactions > 6)
    <div class="text-center mt-3">
        <a class="welcome__content--btn solid__btn" href="{{ route('user.transactions') }}">View More Transactions</a>
    </div>
@endif --}}