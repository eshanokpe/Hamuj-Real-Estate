@extends('layouts.dashboard')

@section('content')
<div class="page__body--wrapper" id="dashbody__page--body__wrapper">
    <main class="main__content_wrapper">
        <div class="dashboard__container">
            
            <div class="reviews__heading mb-30">
                <h2 class="reviews__heading--title">Verify Recipient</h2>
                <p class="reviews__heading--desc">Please confirm the recipient details before finalizing the transfer.</p>
            </div>

            <div class="row">
                <!-- Property Details Card -->
                <div class="col-lg-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                            <h5 class="fw-bold" style="color: #47008E;">Property Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4">
                                <img src="{{ asset($propertyImage ?? 'path/to/default.jpg') }}" 
                                     alt="{{ $propertyName }}" 
                                     class="rounded me-3" 
                                     style="width: 80px; height: 80px; object-fit: cover;">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $propertyName }}</h6>
                                    <small class="text-muted">{{ $propertySlug }}</small>
                                </div>
                            </div>
                            
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted ps-0">Transfer Amount:</td>
                                    <td class="text-end fw-bold text-success">₦{{ number_format($amount, 2) }}</td>
                                </tr>

                                @if(isset($purchaseDate))
                                <tr>
                                    <td class="text-muted ps-0">Date Acquired:</td>
                                    <td class="text-end">{{ $purchaseDate->format('d F, Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">ROI:</td>
                                    <td class="text-end">{{ $roiPercentage }}% <small class="text-muted">(locked)</small></td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">Amount to Earn (1yr):</td>
                                    <td class="text-end fw-bold" style="color: #47008E;">₦{{ number_format($totalROI, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">Monthly ROI:</td>
                                    <td class="text-end">₦{{ number_format($monthlyROI, 2) }} / month</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">ROI Due Date:</td>
                                    <td class="text-end fw-bold text-success">{{ $roiDueDate->format('d F, Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">Status:</td>
                                    <td class="text-end">
                                        @if($isMatured)
                                            <span class="badge bg-danger">Matured (12/12 Months)</span>
                                        @else
                                            <span class="badge bg-primary">Month {{ $monthsElapsed }} of 12 ({{ $daysIntoMonth }}d into this month)</span>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recipient Details Card -->
                <div class="col-lg-6 mb-4">
                    <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #28a745 !important;">
                        <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold text-success">Recipient Verified</h5>
                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Active User</span>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 60px; height: 60px; font-size: 1.5rem; color: #47008E;">
                                    {{ strtoupper(substr($recipientData->first_name, 0, 1)) }}{{ strtoupper(substr($recipientData->last_name, 0, 1)) }}
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1">{{ $recipientData->first_name }} {{ $recipientData->last_name }}</h5>
                                    <small class="text-muted">ID: {{ $recipientData->recipient_id }}</small>
                                </div>
                            </div>

                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted ps-0">Email Address:</td>
                                    <td class="text-end">{{ $recipientData->email }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">Phone Number:</td>
                                    <td class="text-end">{{ $recipientData->phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">Account Status:</td>
                                    <td class="text-end">
                                        @if($recipientData->active)
                                            <span class="badge bg-success bg-opacity-10 text-white">Active</span>
                                        @else
                                            <span class="badge bg-danger bg-opacity-10 text-white">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Final Confirmation Action -->
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body p-4">
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-triangle me-2 fs-4"></i>
                        <div>
                            <strong>Important:</strong> Once you proceed, ₦{{ number_format($amount, 2) }} will be deducted from your wallet/assets and credited to <strong>{{ $recipientData->first_name }}</strong>. This action cannot be undone.
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger mt-3 mb-0 py-2 px-3 small">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger mt-3 mb-0 py-2 px-3 small">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Form to finalize the actual transfer -->
                    <form id="finalizeTransferForm" action="{{ route('user.submit.transferRequest') }}" method="POST" class="mt-3">
                        @csrf 
                        <!-- Pass all necessary data to the final processing controller -->
                        <input type="hidden" name="property_id" value="{{ $propertyId }}">
                        <input type="hidden" name="recipient_id" value="{{ $recipientData->recipient_id }}">
                        <input type="hidden" name="amount" value="{{ $amount }}">
                        <input type="hidden" name="property_slug" value="{{ $propertySlug }}">
                        <input type="hidden" name="selected_size_land" value="{{ $landSize }}">
                        <input type="hidden" name="property_name" value="{{ $propertyName }}">
                        <input type="hidden" name="property_image" value="{{ $propertyImage }}">
                        <input type="hidden" name="buy_id" value="{{ $buyId ?? '' }}">

                        <div class="add__listing--input__box mb-3" style="max-width: 220px;">
                            <label class="add__listing--input__label fw-bold" for="transaction_pin_input">Transaction PIN</label>
                            <input required
                                   class="add__listing--input__field form-control text-center"
                                   id="transaction_pin_input"
                                   name="transaction_pin"
                                   type="password"
                                   inputmode="numeric"
                                   pattern="\d{4}"
                                   maxlength="4"
                                   autocomplete="off"
                                   placeholder="••••"
                                   style="letter-spacing: 6px; font-weight: bold;">
                            <small class="text-muted">Enter your 4-digit transaction PIN to confirm.</small>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('user.transfer') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                            <button type="submit" id="finalizeTransferBtn" class="btn text-white px-4 py-2" style="background-color: #47008E;">
                                <i class="fas fa-paper-plane me-1"></i> Proceed to Transfer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pinInput = document.getElementById('transaction_pin_input');
        pinInput.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 4);
        });

        const form = document.getElementById('finalizeTransferForm');
        const btn = document.getElementById('finalizeTransferBtn');
        form.addEventListener('submit', function () {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Processing...';
        });
    });
</script>
@endsection
