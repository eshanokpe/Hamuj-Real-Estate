<!DOCTYPE html>
<html>
<head>
    <title>Transaction Receipt</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .receipt { width: 100%; max-width: 800px; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 20px; }
        .details { margin-bottom: 30px; }
        .detail-row { display: flex; margin-bottom: 10px; }
        .detail-label { font-weight: bold; width: 150px; }
        .footer { margin-top: 50px; text-align: center; }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <h2>{{ config('app.name') }}</h2>
            <h3>Transaction Receipt</h3>
        </div>
        
        <div class="details">
            <div class="detail-row">
                <div class="detail-label">Transaction Reference:</div>
                <div>{{ $transaction->reference }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Date:</div>
                <div>{{ $transaction->created_at->format('M d, Y g:i A') }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Type:</div>
                <div>
                    @if (isset($transaction->payment_method) && strtolower($transaction->payment_method) === 'wallet')
                        Deposit
                    @elseif(isset($transaction->payment_method))
                        {{ ucfirst($transaction->payment_method) }}
                    @else
                        {{ ucfirst($transaction->type ?? 'N/A') }}
                    @endif
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Amount:</div>
                <div>₦{{ number_format($transaction->amount, 2) }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Status:</div>
                <div>{{ ucfirst($transaction->status ?? $transaction->transaction_state ?? 'pending') }}</div>
            </div>
            @if(isset($transaction->bankName) || isset($transaction->accountName) || isset($transaction->bank_name) || isset($transaction->account_name))
            <div class="detail-row">
                <div class="detail-label">Bank Details:</div>
                <div>
                    {{ $transaction->bankName ?? $transaction->bank_name ?? '' }}<br>
                    {{ $transaction->accountName ?? $transaction->account_name ?? '' }}
                </div>
            </div>
            @endif
            @if(isset($transaction->reason) || isset($transaction->description))
            <div class="detail-row">
                <div class="detail-label">Description:</div>
                <div>{{ $transaction->reason ?? $transaction->description }}</div>
            </div>
            @endif
        </div>
        
        <div class="footer">
            <p>Thank you for using our service</p>
            <p>Generated on: {{ now()->format('M d, Y g:i A') }}</p>
        </div>
    </div>
</body>
</html>