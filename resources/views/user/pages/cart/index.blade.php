@extends('layouts.dashboard')

@section('content')
<div class="dashboard__page--wrapper">
    <div class="page__body--wrapper" id="dashbody__page--body__wrapper">
        <main class="main__content_wrapper">
            <div class="dashboard__container dashboard__reviews--container">
                <div class="reviews__heading mb-30">
                    <h2 class="reviews__heading--title">Purchase Property</h2>
                    <p class="reviews__heading--desc">Review the property details and confirm your purchase.</p>
                </div>

                <div class="properties__wrapper">
                    <div class="properties__table table-responsive">
                        {{-- Ensure $property exists before trying to access it --}}
                        @if($property)
                        <table class="properties__table--wrapper cart__table">
                            <thead>
                                <tr>
                                    <th>Property Details</th>
                                    <th>Price per SQM</th>
                                    <th>Total Size</th>
                                    <th>Available Size</th>
                                    <th>Select Size (SQM)</th>
                                    <th>Amount Payable</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Add data attributes for easier JS access --}}
                                <tr data-property-price="{{ $property->valuationSummary->current_value_sum ?? $property->price }}"
                                    data-property-slug="{{ $property->slug }}"
                                    data-initial-size="{{ $property->available_size }}">
                                    <td>
                                        <div class="properties__author d-flex align-items-center">
                                            <div class="properties__author--thumb flex-shrink-0 me-3">
                                                {{-- Use secure_asset for HTTPS if applicable, add descriptive alt text --}}
                                                <img src="{{ asset($property->property_images) }}" alt="Image of {{ $property->name }}"
                                                    style="width: 64px; height:64px; object-fit:cover; border-radius: 4px;">
                                            </div>
                                            <div class="reviews__author--text">
                                                <h3 class="reviews__author--title mb-1">{{ $property->name }}</h3>
                                                <p class="reviews__author--subtitle text-muted small">{{ $property->location }}</p>
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
                                        <div class="d-flex align-items-center input-group input-group-sm" style="max-width: 120px;">
                                            {{-- Use button type="button" for non-submitting buttons --}}
                                            <button type="button" class="btn btn-outline-secondary decrement-btn" style="background:#47008E; color:#fff; border-color: #47008E;">-</button>
                                            <input type="number" value="1" class="quantity-input form-control text-center px-1" min="1" max="{{ $property->available_size }}" aria-label="Quantity">
                                            <button type="button" class="btn btn-outline-secondary increment-btn" style="background:#47008E; color:#fff; border-color: #47008E;">+</button>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="total-price h5 mb-0" style="color: #47008E; font-weight: bold;">
                                            {{-- Initial total based on default quantity 1 --}}
                                            ₦{{ number_format($property->valuationSummary->current_value_sum ?? $property->price, 2) }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @else
                            <div class="alert alert-warning" role="alert">
                                Property details could not be loaded or are unavailable.
                            </div>
                        @endif
                    </div>
                </div>


                {{-- Only show payment options if property exists --}}
                @if($property)
                <div class="cart__footer d-flex flex-column flex-md-row justify-content-between align-items-md-center mt-4 gap-3">
                    <a href="{{ route('user.buy') }}" class="solid__btn btn btn-secondary" style="background-color: #CC9933; border-color: #CC9933;">
                        <i class="fas fa-arrow-left me-1"></i> View Other Properties
                    </a>
                    <div>
                        {{-- Use button type="button" --}}
                        <button type="button" class="solid__btn btn btn-primary" id="make-payment-btn">
                           Proceed to Payment <i class="fas fa-credit-card ms-1"></i>
                        </button>
                    </div>
                </div>

                <div class="payment-section mt-4 border-top pt-4" id="payment-details-section" style="display: none;">
                     {{-- Commission Section --}}
                     <div class="mb-4">
                        <div class="form-check">
                             {{-- Disable checkbox if commission balance is zero or property price is zero --}}
                            <input class="form-check-input" id="commission-switch" type="checkbox" {{ (auth()->user()->commission_balance ?? 0) > 0 && ($property->valuationSummary->current_value_sum ?? $property->price) > 0 ? '' : 'disabled' }}>
                            <label class="form-check-label" for="commission-switch">
                                <b>Apply Commission Balance</b>
                            </label>
                        </div>
                         <div class="ms-4 mt-1">
                             <span class="text-muted">
                                 Available Commission: <span id="commission-balance-display" class="fw-bold">₦{{ number_format(auth()->user()->commission_balance ?? 0, 2) }}</span>
                                 @if((auth()->user()->commission_balance ?? 0) <= 0)
                                 <small class="text-danger">(None available)</small>
                                 @endif
                             </span>
                         </div>
                     </div>

                    {{-- Payment Form --}}
                    <form id="payment-form" action="{{ route('user.payment.initiate') }}" method="POST">
                        @csrf
                        {{-- Hidden fields will be populated by JS --}}
                        <input type="hidden" name="property_slug" id="property_slug" value="{{ $property->slug }}">
                        <input type="hidden" name="quantity" id="form_quantity">
                        <input type="hidden" name="total_price" id="form_total_price"> {{-- This will be the FINAL amount payable --}}
                        <input type="hidden" name="apply_commission" id="form_apply_commission" value="0"> {{-- 0 for false, 1 for true --}}
                        <input type="hidden" name="commission_applied_amount" id="form_commission_applied_amount" value="0"> {{-- Actual amount deducted from commission --}}

                        <div class="row justify-content-end">
                            <div class="col-md-6 col-lg-4">
                                <div class="mb-3">
                                    <label for="transaction_pin" class="form-label">Enter 4-digit Transaction PIN <span class="text-danger">*</span></label>
                                    <input type="password"
                                           class="form-control form-input text-center" {{-- Use Bootstrap class --}}
                                           name="transaction_pin"
                                           id="transaction_pin"
                                           maxlength="4"
                                           inputmode="numeric"
                                           pattern="\d{4}"
                                           placeholder="****"
                                           required
                                           autocomplete="off">
                                     <div class="invalid-feedback">
                                        Please enter a valid 4-digit PIN.
                                     </div>
                                </div>
                                <button type="submit" class="solid__btn btn btn-success w-100" id="confirm-payment-btn">
                                    <i class="fas fa-lock me-1"></i> Confirm & Pay
                                </button>
                            </div>
                        </div>
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
            // Consider a more user-friendly approach like a modal or alert first
            alert('Please set your transaction PIN before you can make purchases.');
            window.location.href = "{{ route('user.transaction.pin') }}"; // Redirect to PIN setup page
        @endif
    @else
        // Should ideally be handled by middleware, but as a fallback:
        alert('You must be logged in to make a purchase.');
        window.location.href = "{{ route('login') }}"; // Adjust route name if needed
        return; // Stop script execution
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
    const paymentDetailsSection = document.getElementById('payment-details-section'); // Reference the whole section
    const paymentForm = document.getElementById('payment-form');
    const pinInput = document.getElementById('transaction_pin');

    // Hidden form inputs
    const formQuantityInput = document.getElementById('form_quantity');
    const formTotalPriceInput = document.getElementById('form_total_price'); // Final payable amount
    const formApplyCommissionInput = document.getElementById('form_apply_commission');
    const formCommissionAppliedInput = document.getElementById('form_commission_applied_amount');


    // --- Initial Data ---
    const pricePerSqm = parseFloat(itemPriceElement.dataset.priceRaw) || 0; // Default to 0 if parsing fails
    const initialAvailableSize = parseFloat(propertyRow.dataset.initialSize) || 0;
    const maxQuantity = Math.floor(initialAvailableSize); // Use floor for whole SQM units
    const commissionAvailable = parseFloat({{ auth()->user()->commission_balance ?? 0 }});

    // Set max attribute for quantity input, ensure it's at least 1 if available
    quantityInput.max = maxQuantity > 0 ? maxQuantity : 1;
    if (maxQuantity <= 0) {
        quantityInput.value = 0; // Or handle appropriately if no size available
        quantityInput.disabled = true;
        decrementBtn.disabled = true;
        incrementBtn.disabled = true;
        makePaymentBtn.disabled = true; // Disable payment if nothing to buy
         if(commissionSwitch) commissionSwitch.disabled = true;
    }


    // --- Helper Functions ---
    function formatCurrency(amount) {
        // Ensure amount is a number, default to 0 if not
        const numericAmount = typeof amount === 'number' && !isNaN(amount) ? amount : 0;
        return `₦${numericAmount.toLocaleString('en-NG', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    }

    // --- Core Update Function ---
    function updateDisplayAndForm() {
        // Ensure quantity is within valid bounds (1 to maxQuantity)
        let quantity = parseInt(quantityInput.value) || 0;
        if (quantity < 1 && maxQuantity > 0) {
            quantity = 1;
        } else if (quantity > maxQuantity) {
            quantity = maxQuantity;
        } else if (maxQuantity <= 0) {
             quantity = 0; // Cannot select quantity if none available
        }
        quantityInput.value = quantity; // Update input field if corrected

        const total = pricePerSqm * quantity;
        const remainingSize = initialAvailableSize - quantity;

        let finalPrice = total; // This is the amount the user needs to pay
        let commissionApplied = 0;
        let applyCommissionFlag = 0;

        // Apply commission only if switch is checked, commission is available, and total > 0
        if (commissionSwitch && commissionSwitch.checked && commissionAvailable > 0 && total > 0) {
            commissionApplied = Math.min(total, commissionAvailable); // Apply up to the total cost or available balance
            finalPrice = total - commissionApplied; // Reduce the amount payable
            applyCommissionFlag = 1;
        }

        // Update displayed values
        totalPriceElement.textContent = formatCurrency(finalPrice); // Show the final payable amount
        availableSizeElement.textContent = `${remainingSize.toFixed(2)} SQM`; // Show remaining size, allow decimals if needed

        // Update hidden form fields for submission
        formQuantityInput.value = quantity;
        formTotalPriceInput.value = finalPrice.toFixed(2); // Send final payable amount to server
        formApplyCommissionInput.value = applyCommissionFlag;
        formCommissionAppliedInput.value = commissionApplied.toFixed(2); // Send how much commission was used

        // For debugging:
        // console.log({
        //     pricePerSqm, quantity, total, commissionAvailable,
        //     commissionApplied, finalPrice, remainingSize, applyCommissionFlag
        // });
    }

    // --- Event Listeners ---

    // Quantity Buttons & Input
    decrementBtn.addEventListener('click', () => {
        if (parseInt(quantityInput.value) > 1) {
            quantityInput.stepDown(); // Use built-in stepDown
            updateDisplayAndForm();
        }
    });

    incrementBtn.addEventListener('click', () => {
        if (parseInt(quantityInput.value) < maxQuantity) {
             quantityInput.stepUp(); // Use built-in stepUp
            updateDisplayAndForm();
        }
    });

    quantityInput.addEventListener('input', updateDisplayAndForm); // Update on every keystroke/change
    quantityInput.addEventListener('change', updateDisplayAndForm); // Ensure update on blur/enter after manual input


    // Commission Switch Change
    if (commissionSwitch) {
        commissionSwitch.addEventListener('change', updateDisplayAndForm);
    }

    // Make Payment Button Click
    if (makePaymentBtn) {
        makePaymentBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (maxQuantity <= 0 || parseInt(quantityInput.value) <= 0) {
                alert("Please select a valid quantity to purchase.");
                return;
            }
            // Ensure calculations are up-to-date before showing form
            updateDisplayAndForm();
            // Show the payment details section
            if (paymentDetailsSection) {
                paymentDetailsSection.style.display = 'block';
                paymentDetailsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                pinInput.focus(); // Focus the PIN input
            }
        });
    }

    // Form Submission (using 'submit' event is better for validation)
    if (paymentForm) {
        paymentForm.addEventListener('submit', function(e) {
            const pin = pinInput.value.trim();
            pinInput.classList.remove('is-invalid'); // Reset validation state

            if (pin.length !== 4 || !/^\d{4}$/.test(pin)) {
                e.preventDefault(); // Prevent form submission
                pinInput.classList.add('is-invalid'); // Show validation feedback
                pinInput.focus();
                // alert('Please enter a valid 4-digit PIN.'); // Optional: keep alert if preferred
            } else {
                // PIN looks valid, ensure latest values are in hidden fields just before submission
                updateDisplayAndForm();
                // Optional: Disable submit button to prevent double-clicks
                const submitButton = paymentForm.querySelector('button[type="submit"]');
                if(submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
                }
            }
        });
    }

    // --- Initial Calculation on Load ---
    // Run only if there's quantity available to purchase
    if (maxQuantity > 0) {
       updateDisplayAndForm();
    } else {
        totalPriceElement.textContent = formatCurrency(0); // Show 0 if nothing available
    }


});
</script>
@endif {{-- End of @if($property) for script --}}

@endsection
