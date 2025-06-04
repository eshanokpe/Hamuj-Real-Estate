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
            <h2>Dohmayn Technology Limited</h2>
            <h3>Transaction Receipt</h3>
        </div>
         
        <div class="details">
            <div style="margin-left: auto; padding-left: 10px;">
                <img src="{{ public_path('assets/img/dohmaynlogo.png') }}" style="width: 100px; height: auto; display: block;" alt="Company Logo">
            </div>
            <div class="detail-row" style="align-items: center;">
                <div class="detail-label">Transaction Reference:</div>
                <div>{{ $transaction->reference }}</div>
            </div>
            <div class="detail-row" style="align-items: center;">
                <div class="detail-label">Date:</div>
                <div>{{ $transaction->created_at->format('M d, Y g:i A') }}</div>
                
            </div>
            <div class="detail-row">
                <div class="detail-label">Type:</div>
                <div>
                    @if (isset($transaction->payment_method) && strtolower($transaction->payment_method) === 'dedicated_nuban')
                        Wallet Deposit
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

            @php
                $metadata = [];
                // Safely decode metadata
                if (!empty($transaction->metadata)) {
                    if (is_array($transaction->metadata)) {
                        $metadata = $transaction->metadata;
                    } elseif (is_string($transaction->metadata)) {
                        $decoded = json_decode($transaction->metadata, true);
                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                            $metadata = $decoded;
                        }
                    }
                }

                // Initialize receiver details
                $receiverName = $metadata['receiver_name'] ?? $transaction->recipient_name ?? null;
                $receiverBank = $metadata['receiver_bank'] ?? $transaction->bank_name ?? $transaction->bankName ?? null;
                $receiverAccountNumber = $metadata['receiver_account_number'] ?? $transaction->account_number ?? null;

                // Fallback for receiver name using account_name or accountName if not already set
                if (empty($receiverName)) {
                    $potentialName = $metadata['account_name'] ?? $transaction->account_name ?? $transaction->accountName ?? null;
                    if ($potentialName && (!is_numeric(str_replace(' ', '', $potentialName)) || !empty($receiverAccountNumber)) ) {
                        $receiverName = $potentialName;
                    }
                }

                // Fallback for account number using account_name or accountName if not already set
                if (empty($receiverAccountNumber)) {
                    $potentialAccountNumber = $metadata['account_name'] ?? $transaction->account_name ?? $transaction->accountName ?? null;
                    if ($potentialAccountNumber && is_numeric(str_replace(' ', '', $potentialAccountNumber))) {
                        $receiverAccountNumber = $potentialAccountNumber;
                        if ($receiverName === $receiverAccountNumber) {
                            $receiverName = $metadata['receiver_name'] ?? $transaction->recipient_name ?? null;
                        }
                    }
                }
            @endphp

            @if($receiverName || $receiverBank || $receiverAccountNumber)
                <div style="margin-top: 15px; margin-bottom: 5px; border-top: 1px solid #eee; padding-top: 10px;">
                    <div style="font-weight:bold; margin-bottom: 5px;">Receiver Information:</div>
                </div>
                @if($receiverName)
                <div class="detail-row">
                    <div class="detail-label">Name:</div>
                    <div>{{ $receiverName }}</div>
                </div>
                @endif
                @if($receiverBank)
                <div class="detail-row">
                    <div class="detail-label">Bank:</div>
                    <div>{{ $receiverBank }}</div>
                </div>
                @endif
                @if($receiverAccountNumber)
                <div class="detail-row">
                    <div class="detail-label">Account Number:</div>
                    <div>{{ $receiverAccountNumber }}</div>
                </div>
                @endif
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