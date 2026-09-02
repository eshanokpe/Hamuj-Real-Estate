@extends('layouts.dashboard')

@section('content')
<style>
    /* Mobile-responsive table styles for Sell Property */
    @media screen and (max-width: 768px) {
        .properties__table { overflow-x: visible; }
        .properties__table--wrapper { width: 100%; border-collapse: collapse; }
        .properties__table--wrapper thead { display: none; }
        .properties__table--wrapper tbody tr { display: block; margin-bottom: 1.5rem; border: 1px solid #e2e8f0; border-radius: 8px; padding: 1rem; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); background: white; }
        .properties__table--wrapper tbody td { display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0.5rem; border-bottom: 1px solid #f1f5f9; text-align: right; }
        .properties__table--wrapper tbody td:last-child { border-bottom: none; }
        .properties__table--wrapper tbody td:before { content: attr(data-label); font-weight: 600; text-align: left; margin-right: 1rem; color: #475569; flex-shrink: 0; }
        .properties__table--wrapper tbody td:first-child { display: block; padding: 0; border-bottom: none; }
        .properties__table--wrapper tbody td:first-child:before { display: none; }
        .properties__table--wrapper tbody td .status__btn { display: inline-block; margin: 0.25rem 0; min-width: 100px; text-align: center; }
        .properties__table--wrapper tbody td[colspan] { display: block; text-align: center; padding: 2rem !important; }
    }

    @media screen and (max-width: 768px) {
        .properties__table--wrapper tbody td:nth-child(2):before { content: "Listing Title"; }
        .properties__table--wrapper tbody td:nth-child(3):before { content: "Date Acquired"; }
        .properties__table--wrapper tbody td:nth-child(4):before { content: "Amount to Earn"; }
        .properties__table--wrapper tbody td:nth-child(5):before { content: "ROI Due Date"; }
        .properties__table--wrapper tbody td:nth-child(6):before { content: "Total Assets"; }
        .properties__table--wrapper tbody td:nth-child(7):before { content: "Sell Property"; }
    }

    /* Sell button hover/disabled states */
    .status__btn.pending2 { cursor: pointer; border: none; }
    .status__btn.pending2:hover { opacity: 0.9; }
</style>

<div class="page__body--wrapper" id="dashbody__page--body__wrapper">
    <main class="main__content_wrapper">
        <div class="dashboard__container dashboard__reviews--container">

            <div class="reviews__heading mb-30">
                <h2 class="reviews__heading--title">Sell Property</h2>
                <p class="reviews__heading--desc">Manage and initiate the sale of your acquired property portions.</p>

                <div class="mt-3 p-3 rounded d-inline-block w-100" style="background-color: #f8f9fa; border-left: 4px solid #47008E;">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div class="mb-2 mb-md-0">
                            <span class="text-muted me-2">Total Portfolio Value:</span>
                            <span class="fw-bold fs-5" style="color: #47008E;">₦{{ number_format($grandTotalAmount ?? 0, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="properties__wrapper">
                <div class="properties__table table-responsive">
                    <table class="properties__table--wrapper">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Listing Title</th>
                                <th>Date Acquired</th>
                                <th>Amount to Earn</th>
                                <th>ROI Due Date</th>
                                <th>Total Assets</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sellProperties as $buy)
                            @php
                                $purchaseDate = \Carbon\Carbon::parse($buy->created_at);
                                $totalDays    = 365;
                                $roiDueDate   = $purchaseDate->copy()->addDays($totalDays);

                                // +1 makes the purchase day itself "day 1" instead of "day 0"
                                $daysElapsed  = \Carbon\Carbon::today()->diffInDays($purchaseDate) + 1;
                                $daysElapsed  = min($totalDays, max(1, $daysElapsed));
                                $isMatured    = \Carbon\Carbon::today()->greaterThanOrEqualTo($roiDueDate);

                                $avgMonthLength = $totalDays / 12; // 30.4167 days
                                $monthsElapsed   = $isMatured ? 12 : (int) floor(($daysElapsed - 1) / $avgMonthLength);
                                $daysIntoMonth   = $isMatured ? 0  : $daysElapsed - (int) floor($monthsElapsed * $avgMonthLength);

                                // --- FINANCIAL CALCULATION ---
                                $roiPercentage = $buy->roi_percentage ?? 0;
                                $totalROI      = $buy->total_price * ($roiPercentage / 100);
                                $monthlyROI    = $totalROI / 12;
                            @endphp
                            <tr>
                                <td data-label="S/N" class="fw-bold text-center">
                                    {{ ($sellProperties->currentPage() - 1) * $sellProperties->perPage() + $loop->iteration }}
                                </td>

                                <td>
                                    <div class="properties__author d-flex align-items-center">
                                        <div class="properties__author--thumb flex-shrink-0 me-3">
                                            <img src="{{ asset($buy->property->property_images ?? 'path/to/default-image.jpg') }}"
                                                 alt="{{ $buy->property->name ?? 'Property Image' }}"
                                                 style="width:70px; height:90px; object-fit:cover; border-radius: 4px;">
                                        </div>
                                        <div class="reviews__author--text">
                                            <h3 class="reviews__author--title mb-1">{{ $buy->property->name ?? 'N/A' }}</h3>
                                            <p class="reviews__author--subtitle text-muted mb-1">{{ $buy->property->location ?? 'N/A' }}</p>
                                            {{-- Display the LOCKED ROI percentage --}}
                                            <p class="mt-2 reviews__author--title">
                                                <span style="font-weight:bold">ROI:</span> {{ $roiPercentage }}%
                                                <small class="text-muted fw-normal">(locked)</small>
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td data-label="Date Acquired">
                                    <span class="reviews__date">
                                        {{ $purchaseDate->format('d F, Y') }}
                                    </span>
                                </td>

                                <td data-label="Amount to Earn" class="text-nowrap align-middle fw-bold">
                                    <span class="properties__views" style="color: #47008E; font-weight: 800;">
                                        ₦{{ number_format($totalROI, 2) }}
                                        <small class="text-muted fw-normal" style="font-size: 0.75rem; display:block;">(Annual)</small>
                                    </span>
                                </td>

                                {{-- ROI Due Date --}}
                                <td data-label="ROI Due Date" class="text-nowrap align-middle">
                                    <div class="d-flex flex-column">
                                        <span class="text-success fw-bold">{{ $roiDueDate->format('d F, Y') }}</span>
                                        @if($isMatured)
                                            <small class="text-danger fw-bold">Matured</small>
                                        @else
                                            <small class="text-muted live-countdown" data-purchase-date="{{ $purchaseDate->toIso8601String() }}">
                                                Calculating...
                                            </small>
                                        @endif
                                    </div>
                                </td>

                                {{-- Total Assets with Real-time Badge --}}
                                <td data-label="Total Assets" class="text-nowrap align-middle">
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold" style="color: #28a745;">₦{{ number_format($buy->total_price ?? 0, 2) }}</span>
                                        <span class="text-muted small mb-2">≈ ₦{{ number_format($monthlyROI, 2) }} / month</span>

                                        @if($isMatured)
                                            <span class="badge bg-danger rounded-pill align-self-start">
                                                <i class="fas fa-check-circle me-1"></i> Matured (12/12 Months)
                                            </span>
                                        @else
                                            <span class="badge bg-primary rounded-pill align-self-start live-month-badge"
                                                data-purchase-date="{{ $purchaseDate->toIso8601String() }}">
                                                Month {{ $monthsElapsed }} of 12 ({{ $daysIntoMonth }}d into this month)
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Sell Property: sold / sellable (opens confirm modal) / locked --}}
                                <td data-label="Sell Property">
                                    @if($buy->status === 'sold')
                                        <span class="status__btn" style="background-color: #6c757d; color: #fff; cursor: default;">
                                            Sold
                                        </span>
                                    @elseif(!$isMatured)
                                        <button type="button"
                                                class="status__btn pending2 text-white border-0"
                                                style="background-color: #47008E;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#confirmSellModal"
                                                data-property-name="{{ $buy->property->name ?? 'N/A' }}"
                                                data-property-location="{{ $buy->property->location ?? 'N/A' }}"
                                                data-total-price="₦{{ number_format($buy->total_price ?? 0, 2) }}"
                                                data-purchase-date="{{ $purchaseDate->format('d F, Y') }}"
                                                data-action-url="{{ route('user.sell.property') }}"
                                                data-property-id="{{ encrypt($buy->property->id) }}"
                                                data-buy-id="{{ $buy->id }}">
                                            Sell
                                        </button>
                                    @else
                                        <span class="status__btn" style="background-color: #e9ecef; color: #6c757d; cursor: not-allowed;" title="Available for sale on {{ $roiDueDate->format('d F, Y') }}">
                                            Locked
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">
                                    <div class="text-center p-5 border-top">
                                        <i class="fas fa-store-slash fa-3x text-muted mb-3"></i>
                                        <h4 class="text-muted fw-normal">No Assets Currently Available to Sell</h4>
                                        <br><br>
                                        <span class="status__btn pending2" style="background-color: #47008E;">
                                            <a class="text-white" href="{{ route('user.properties') }}">Buy Properties</a>
                                        </span>
                                     </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Confirm Sell Modal: single shared instance, populated per-row via JS --}}
                <div class="modal fade" id="confirmSellModal" tabindex="-1" aria-labelledby="confirmSellModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom: 3px solid #47008E;">
                                <h5 class="modal-title fw-bold" id="confirmSellModalLabel">Confirm Property Sale</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-muted mb-3">You are about to sell the following property portion. This action cannot be undone.</p>
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <td class="text-muted">Property</td>
                                        <td class="fw-bold text-end" id="modalPropertyName"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Location</td>
                                        <td class="text-end" id="modalPropertyLocation"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Date Acquired</td>
                                        <td class="text-end" id="modalPurchaseDate"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Amount to be Credited</td>
                                        <td class="fw-bold text-end" style="color: #28a745;" id="modalTotalPrice"></td>
                                    </tr>
                                </table>
                                <div class="alert alert-warning mt-3 mb-0 py-2 px-3 small">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    Once confirmed, the sale amount will be credited to your wallet and this property will no longer be listed as active.
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form id="confirmSellForm" method="POST" action="">
                                    @csrf
                                    <input type="hidden" name="property_id" id="modalPropertyIdInput">
                                    <input type="hidden" name="buy_id" id="modalBuyIdInput">
                                    <button type="submit" class="btn text-white" id="confirmSellSubmitBtn" style="background-color: #47008E;">
                                        <i class="fas fa-check me-1"></i> Confirm Sale
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="pagination__area">
                    <nav class="pagination justify-content-center">
                        <ul class="pagination__menu d-flex align-items-center justify-content-center">
                            @if ($sellProperties->onFirstPage())
                                <li class="pagination__menu--items pagination__arrow disabled">
                                    <span class="pagination__arrow-icon">
                                        <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.583 20.5832L0.999675 10.9998L10.583 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </li>
                            @else
                                <li class="pagination__menu--items pagination__arrow">
                                    <a href="{{ $sellProperties->previousPageUrl() }}" class="pagination__arrow-icon link">
                                        <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.583 20.5832L0.999675 10.9998L10.583 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                </li>
                            @endif

                            @foreach ($sellProperties->links()->elements[0] as $page => $url)
                                <li class="pagination__menu--items">
                                    <a href="{{ $url }}" class="pagination__menu--link {{ $page == $sellProperties->currentPage() ? 'active color-accent-1' : '' }}">
                                        {{ $page }}
                                    </a>
                                </li>
                            @endforeach

                            @if ($sellProperties->hasMorePages())
                                <li class="pagination__menu--items pagination__arrow">
                                    <a href="{{ $sellProperties->nextPageUrl() }}" class="pagination__arrow-icon link">
                                        <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.00098 20.5832L10.5843 10.9998L1.00098 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                </li>
                            @else
                                <li class="pagination__menu--items pagination__arrow disabled">
                                    <span class="pagination__arrow-icon">
                                        <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.00098 20.5832L10.5843 10.9998L1.00098 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </main>
</div>

{{-- LIVE COUNTDOWN + SELL CONFIRMATION MODAL SCRIPT --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const TOTAL_DAYS = 365;
        const AVG_MONTH_LENGTH = TOTAL_DAYS / 12; // 30.4167
        const MS_PER_DAY = 1000 * 60 * 60 * 24;

        function daysBetween(a, b) {
            return Math.floor((b - a) / MS_PER_DAY);
        }

        function updateCountdowns() {
            const now = new Date();

            // 1. Simple text countdown (ROI Due Date column)
            document.querySelectorAll('.live-countdown').forEach(el => {
                const purchaseDate = new Date(el.dataset.purchaseDate);
                const dueDate = new Date(purchaseDate.getTime() + TOTAL_DAYS * MS_PER_DAY);
                const diffMs = dueDate - now;

                if (diffMs <= 0) {
                    el.textContent = "Due Today!";
                    el.className = "text-warning fw-bold";
                } else {
                    const days = Math.ceil(diffMs / MS_PER_DAY);
                    el.textContent = `${days} day${days === 1 ? '' : 's'} remaining`;
                }
            });

            // 2. Month badge (Total Assets column) — inclusive day counting
            document.querySelectorAll('.live-month-badge').forEach(el => {
                const purchaseDate = new Date(el.dataset.purchaseDate);
                let daysElapsed = daysBetween(purchaseDate, now) + 1; // purchase day = day 1
                daysElapsed = Math.min(TOTAL_DAYS, Math.max(1, daysElapsed));
                const isMatured = daysElapsed >= TOTAL_DAYS;

                if (isMatured) {
                    el.innerHTML = '<i class="fas fa-check-circle me-1"></i> Matured (12/12 Months)';
                    el.classList.remove('bg-primary');
                    el.classList.add('bg-danger');
                } else {
                    const monthsElapsed = Math.floor((daysElapsed - 1) / AVG_MONTH_LENGTH);
                    const daysIntoMonth = daysElapsed - Math.floor(monthsElapsed * AVG_MONTH_LENGTH);
                    el.innerHTML = `Month ${monthsElapsed} of 12 <span class="fw-light ms-1">(${daysIntoMonth}d into this month)</span>`;
                }
            });
        }

        updateCountdowns();
        setInterval(updateCountdowns, 60 * 1000); // day-level data — no need for a 1s tick

        // 3. Populate the confirm-sell modal from whichever row's "Sell" button was clicked
        const confirmSellModal = document.getElementById('confirmSellModal');
        const confirmSellForm = document.getElementById('confirmSellForm');
        const confirmSellSubmitBtn = document.getElementById('confirmSellSubmitBtn');

        confirmSellModal.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget; // the "Sell" button that was clicked
            if (!trigger) return;

            document.getElementById('modalPropertyName').textContent = trigger.dataset.propertyName;
            document.getElementById('modalPropertyLocation').textContent = trigger.dataset.propertyLocation;
            document.getElementById('modalPurchaseDate').textContent = trigger.dataset.purchaseDate;
            document.getElementById('modalTotalPrice').textContent = trigger.dataset.totalPrice;

            document.getElementById('modalPropertyIdInput').value = trigger.dataset.propertyId;
            document.getElementById('modalBuyIdInput').value = trigger.dataset.buyId;
            confirmSellForm.action = trigger.dataset.actionUrl;
        });

        // Prevent double-submit while the request is in flight
        confirmSellForm.addEventListener('submit', function () {
            confirmSellSubmitBtn.disabled = true;
            confirmSellSubmitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Processing...';
        });
    });
</script>
@endsection