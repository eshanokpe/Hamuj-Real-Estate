@extends('layouts.dashboard')

@section('content')
<div class="dashboard__page--wrapper">
    <div class="page__body--wrapper" id="dashbody__page--body__wrapper">
        <main class="main__content_wrapper">
            <div class="dashboard__container dashboard__reviews--container">
                <div class="reviews__heading mb-30">
                    <h2 class="reviews__heading--title">My Property</h2>
                    <p class="reviews__heading--desc">We are glad to see you again!</p>
                </div>

                <div class="properties__wrapper">
                    <div class="properties__table table-responsive">
                        {{-- Ensure $property exists before trying to access it --}}
                        @if($property)
                        <table class="properties__table--wrapper cart__table">
                            <thead>
                                <tr>
                                    <th>Product Image</th>
                                    <th>Price per SQM</th>
                                    <th>Actual Land Size</th>
                                    <th>Available Land Size</th>
                                    <th>Select Land Size (SQM)</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Add data attributes for easier JS access --}}
                                <tr data-property-price="{{ $property->valuationSummary->current_value_sum ?? $property->price }}"
                                    data-property-slug="{{ $property->slug }}"
                                    data-initial-size="{{ $property->available_size }}">
                                    <td>
                                        <div class="properties__author d-flex align-items-center">
                                            <div class="properties__author--thumb">
                                                {{-- Use secure_asset for HTTPS if applicable, add alt text --}}
                                                <img src="{{ asset($property->property_images) }}" alt="{{ $property->name }} image"
                                                    style="width: 64px; height:64px; object-fit:cover">
                                            </div>
                                            <div class="reviews__author--text">
                                                <h3 class="reviews__author--title">{{ $property->name }}</h3>
                                                <p class="reviews__author--subtitle">{{ $property->location }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{-- Store raw price in data attribute for JS --}}
                                        <span class="item-price" data-price-raw="{{ $property->valuationSummary->current_value_sum ?? $property->price }}">
                                            ₦{{ number_format($property->valuationSummary->current_value_sum ?? $property->price, 2) }}
                                        </span>
                                    </td>
                                    <td><span>{{ $property->size }} SQM</span></td>
                                    <td class="available-size">
                                        {{ $property->available_size }} SQM
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            {{-- Consider moving inline styles to CSS --}}
                                            <button type="button" class="btn btn-outline-secondary btn-sm decrement-btn" style="padding: 5px 10px; background:#47008E; color:#fff; font-size:18px">-</button>
                                            <input type="number" value="1" class="quantity-input text-center mx-2" style="width: 50px;" min="1" max="{{ $property->available_size }}">
                                            <button type="button" class="btn btn-outline-secondary btn-sm increment-btn" style="padding: 5px 10px; background:#47008E; color:#fff; font-size:18px">+</button>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="total-price" style="color: #47008E; font-weight: bold;">
                                            {{-- Initial total based on default quantity 1 --}}
                                            ₦{{ number_format($property->valuationSummary->current_value_sum ?? $property->price, 2) }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @else
                            <p>Property details not found.</p>
                        @endif
                    </div>
                </div>


                {{-- Only show payment options if property exists --}}
                @if($property)
                <div class="cart__footer d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('user.buy') }}" class="solid__btn" style="background-color: #CC9933">
                        View Other Properties
                    </a>
                    <div>
                        <button type="button" class="solid__btn" id="make-payment-btn">Make Payment</button>
                    </div>
                </div>

                <div class="cart__footer d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mt-4">
                    {{-- Commission Section --}}
                    <div class="reviews__author--check position-relative mb-3 mb-md-0">
                        <label for="commission-switch" class="d-block mb-1"><b>Apply Commission</b></label>
                        <div class="d-flex align-items-center">
                             {{-- Disable checkbox if commission balance is zero --}}
                            <input class="reviews__author--check__input" id="commission-switch" type="checkbox" {{ auth()->user()->commission_balance > 0 ? '' : 'disabled' }}>
                            <span class="reviews__author--checkmark"></span>
                            <span class="ms-2">
                                Commission Balance: <span id="commission-balance-display">₦{{ number_format(auth()->user()->commission_balance ?? 0, 2) }}</span>
                                @if(auth()->user()->commission_balance <= 0)
                                <small class="text-muted">(Insufficient)</small>
                                @endif
                            </span>
                        </div>
                    </div>

                    {{-- Payment Form --}}
                    <form id="payment-form" action="{{ route('user.payment.initiate') }}" method="POST" style="display: none;" class="w-100 w-md-auto">
                        @csrf
                        {{-- Hidden fields will be populated by JS --}}
                        <input type="hidden" name="property_slug" id="property_slug" value="{{ $property->slug }}">
                        <input type="hidden" name="quantity" id="form_quantity">
                        <input type="hidden" name="total_price" id="form_total_price">
                        <input type="hidden" name="apply_commission" id="form_apply_commission" value="0"> {{-- 0 for false, 1 for true --}}
                        <input type="hidden" name="commission_applied_amount" id="form_commission_applied_amount" value="0"> {{-- Actual amount deducted from commission --}}

                        <div class="form-group mt-3">
                            <label for="transaction_pin" class="form-label">Enter 4-digit Transaction PIN</label>
                            <input type="password"
                                   class="form-control form-input" {{-- Use Bootstrap class --}}
                                   name="transaction_pin"
                                   id="transaction_pin"
                                   maxlength="4"
                                   inputmode="numeric"
                                   pattern="\d{4}"
                                   placeholder="****"
                                   required>
                        </div>

                        <button type="submit" class="solid__btn mt-2 w-100" id="confirm-payment-btn">Confirm Payment</button>
                    </form>
                </div>
                @endif

            </div>
        </main>
    </div>
</div>

{{-- Ensure script runs only if property exists --}}
@if($property)
<script>
document.addEventListener('DOMContentLoaded', function() {

    // --- Authentication and PIN Check ---
    @auth
        @if (!auth()->user()->transaction_pin)
            // Consider showing a modal or message instead of immediate redirect
            // alert('Please set your transaction PIN before proceeding.');
            window.location.href = "{{ route('user.transaction.pin') }}";
        @endif
    @else
        // Redirect to login if user is not authenticated
        window.location.href = "{{ route('login') }}"; // Adjust route name if needed
    @endauth

    // --- Element References ---
    const propertyRow = document.querySelector('.cart__table tbody tr');
    if (!propertyRow) {
        console.error("Property row not found in table.");
        return; // Stop script if essential elements are missing
    }

    const decrementBtn = propertyRow.querySelector('.decrement-btn');
    const incrementBtn = propertyRow.querySelector('.increment-btn');
    const quantityInput = propertyRow.querySelector('.quantity-input');
    const availableSizeElement = propertyRow.querySelector('.available-size');
    const totalPriceElement = propertyRow.querySelector('.total-price');
    const itemPriceElement = propertyRow.querySelector('.item-price');
    const commissionSwitch = document.getElementById('commission-switch');
    const makePaymentBtn = document.getElementById('make-payment-btn');
    const paymentForm = document.getElementById('payment-form');
    const confirmPaymentBtn = document.getElementById('confirm-payment-btn');
    const pinInput = document.getElementById('transaction_pin');

    // Hidden form inputs
    const formQuantityInput = document.getElementById('form_quantity');
    const formTotalPriceInput = document.getElementById('form_total_price');
    const formApplyCommissionInput = document.getElementById('form_apply_commission');
    const formCommissionAppliedInput = document.getElementById('form_commission_applied_amount');


    // --- Initial Data ---
    const pricePerSqm = parseFloat(itemPriceElement.dataset.priceRaw);
    const initialAvailableSize = parseFloat(propertyRow.dataset.initialSize);
    const maxQuantity = initialAvailableSize; // Cannot buy more than available
    const commissionAvailable = parseFloat({{ auth()->user()->commission_balance ?? 0 }});

    // Set max attribute for quantity input
    quantityInput.max = maxQuantity;

    // --- Helper Functions ---
    function formatCurrency(amount) {
        return `₦${amount.toLocaleString('en-NG', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    }

    // --- Core Update Function ---
    function updateDisplayAndForm() {
        let quantity = parseInt(quantityInput.value) || 0;

        // Validate quantity
        if (quantity < 1) {
            quantity = 1;
            quantityInput.value = 1; // Correct input if invalid
        } else if (quantity > maxQuantity) {
            quantity = maxQuantity;
            quantityInput.value = maxQuantity; // Correct input if exceeds max
        }

        const total = pricePerSqm * quantity;
        const remainingSize = initialAvailableSize - quantity; // No need for Math.max here

        let finalPrice = total;
        let commissionApplied = 0;
        let applyCommissionFlag = 0;

        if (commissionSwitch.checked && commissionAvailable > 0) {
            commissionApplied = Math.min(total, commissionAvailable);
            finalPrice = total - commissionApplied;
            applyCommissionFlag = 1;
        }

        // Update displayed values
        totalPriceElement.textContent = formatCurrency(finalPrice);
        availableSizeElement.textContent = `${remainingSize} SQM`;

        // Update hidden form fields for submission
        formQuantityInput.value = quantity;
        formTotalPriceInput.value = finalPrice.toFixed(2); // Send final price to server
        formApplyCommissionInput.value = applyCommissionFlag;
        formCommissionAppliedInput.value = commissionApplied.toFixed(2);

        // For debugging:
        console.log({
            pricePerSqm,
            quantity,
            total,
            commissionAvailable,
            commissionApplied,
            finalPrice,
            remainingSize,
            applyCommissionFlag
        });
    }

    // --- Event Listeners ---

    // Quantity Buttons
    decrementBtn.addEventListener('click', () => {
        if (quantityInput.value > 1) {
            quantityInput.value--;
            updateDisplayAndForm();
        }
    });

    incrementBtn.addEventListener('click', () => {
         // Check against maxQuantity before incrementing
        if (parseInt(quantityInput.value) < maxQuantity) {
            quantityInput.value++;
            updateDisplayAndForm();
        }
    });

    // Quantity Input Change
    quantityInput.addEventListener('input', () => {
        // Basic validation on input change
        if (parseInt(quantityInput.value) < 1) quantityInput.value = 1;
        if (parseInt(quantityInput.value) > maxQuantity) quantityInput.value = maxQuantity;
        updateDisplayAndForm();
    });
     quantityInput.addEventListener('change', () => { // Ensure update on blur/enter
        updateDisplayAndForm();
    });


    // Commission Switch Change
    if (commissionSwitch) { // Check if exists
        commissionSwitch.addEventListener('change', updateDisplayAndForm);
    }

    // Make Payment Button Click
    if (makePaymentBtn) { // Check if exists
        makePaymentBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // Ensure calculations are up-to-date before showing form
            updateDisplayAndForm();
            paymentForm.style.display = 'block';
            paymentForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
            pinInput.focus(); // Focus the PIN input
        });
    }

    // Confirm Payment Button Click (Form Submission)
    if (confirmPaymentBtn) { // Check if exists
        paymentForm.addEventListener('submit', function(e) {
            const pin = pinInput.value.trim();
            if (pin.length !== 4 || !/^\d{4}$/.test(pin)) {
                alert('Please enter a valid 4-digit PIN.');
                e.preventDefault(); // Prevent form submission
                pinInput.focus();
            }
            // If PIN is valid, the form will submit naturally.
            // Ensure latest values are in hidden fields before submission
            updateDisplayAndForm();
        });
    }

    // --- Initial Calculation on Load ---
    updateDisplayAndForm();

});
</script>
@endif {{-- End of @if($property) for script --}}

@endsection
