@extends('layouts.dashboard')

@section('content')
<style>
    /* Mobile-responsive styles for Sell Property Form */
    @media screen and (max-width: 768px) {
        .cart__table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .cart__table thead {
            display: none; /* Hide table headers on mobile */
        }
        
        .cart__table tbody tr {
            display: block;
            margin-bottom: 1.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            background: white;
        }
        
        .cart__table tbody td {
            display: flex;
            flex-direction: column;
            padding: 0.75rem 0.5rem;
            border-bottom: 1px solid #f1f5f9;
            text-align: center;
        }
        
        .cart__table tbody td:last-child {
            border-bottom: none;
        }
        
        .cart__table tbody td:before {
            content: attr(data-label);
            font-weight: 600;
            text-align: center;
            margin-bottom: 0.5rem;
            color: #475569;
            font-size: 0.9rem;
        }
        
        /* Special handling for the image column */
        .cart__table tbody td:first-child {
            display: block;
            padding: 0;
            border-bottom: none;
            text-align: left;
        }
        
        .cart__table tbody td:first-child:before {
            display: none;
        }
        
        /* Adjust property author layout for mobile */
        .properties__author {
            flex-direction: column;
            text-align: center;
        }
        
        .properties__author--thumb {
            margin-bottom: 1rem;
        }
        
        .properties__author--thumb img {
            width: 80px !important;
            height: 80px !important;
        }
        
        .reviews__author--text {
            text-align: center;
        }
        
        /* Input field styling for mobile */
        .amount-input {
            width: 100% !important;
            margin: 0.5rem 0 !important;
            padding: 0.75rem;
            font-size: 16px; /* Prevents zoom on iOS */
        }
        
        /* Button styling for mobile */
        .solid__btn {
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
        }
        
        /* Modal adjustments for mobile */
        .modal-dialog {
            margin: 1rem;
        }
        
        .modal-content {
            border-radius: 12px;
        }
        
        /* Text sizing for mobile */
        .reviews__author--title {
            font-size: 1.1rem;
        }
        
        .reviews__author--subtitle {
            font-size: 0.9rem;
        }
        
        .properties__author--price {
            font-size: 0.85rem;
        }
        
        /* Ensure calculated values are prominent */
        .calculated-size, .total-price {
            font-size: 1rem !important;
            padding: 0.5rem;
            background: #f8f9fa;
            border-radius: 4px;
            margin: 0.25rem 0;
        }
        
        /* Hide small text on mobile to save space */
        .text-muted small {
            display: block;
            margin-top: 0.25rem;
        }
    }

    /* Ensure table cells have data labels for mobile */
    @media screen and (max-width: 768px) {
        .cart__table tbody td:nth-child(2):before { content: "Price per SQM"; }
        .cart__table tbody td:nth-child(3):before { content: "Actual Land Size"; }
        .cart__table tbody td:nth-child(4):before { content: "Your Available Size"; }
        .cart__table tbody td:nth-child(5):before { content: "Enter Sale Amount"; }
        .cart__table tbody td:nth-child(6):before { content: "Calculated Size to Sell"; }
        .cart__table tbody td:nth-child(7):before { content: "Total Sale Value"; }
    }

    /* Additional mobile optimizations */
    @media screen and (max-width: 480px) {
        .dashboard__container {
            padding: 0.5rem;
        }
        
        .reviews__heading--title {
            font-size: 1.5rem;
        }
        
        .reviews__heading--desc {
            font-size: 0.9rem;
        }
        
        .cart__table tbody tr {
            padding: 0.75rem;
            margin-bottom: 1rem;
        }
    }

    /* Prevent horizontal scrolling */
    .table-responsive {
        overflow-x: visible;
    }
    
    @media screen and (max-width: 768px) {
        .table-responsive {
            border: none;
        }
    }
</style>

<div class="dashboard__page--wrapper">
    <!-- Dashboard sidebar -->
    <div class="page__body--wrapper" id="dashbody__page--body__wrapper">
        <main class="main__content_wrapper">
            <!-- Dashboard container -->
            <div class="dashboard__container dashboard__reviews--container">
                <div class="reviews__heading mb-30">
                    <h2 class="reviews__heading--title">Sell Property</h2>
                    <p class="reviews__heading--desc">We are glad to see you again!</p>
                </div> 
                <div class="properties__wrapper">
                    <div class="properties__table table-responsive">
                        <table class="properties__table--wrapper cart__table">
                            <thead>
                                <tr>
                                    <th>Product Image</th>
                                    <th>Price</th>
                                    <th>Actual Land Size</th>
                                    <th>Acquired Land Size</th>
                                    <th>Enter Amount (₦)</th>
                                    <th>Calculated Land Size</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-label="Property">
                                        <div class="properties__author d-flex align-items-center">
                                            <div class="properties__author--thumb">
                                                <img src="{{ asset($property->property_images) }}" alt="img" 
                                                    style="width: 64px; height:64px; object-fit:cover">
                                            </div>
                                            <div class="reviews__author--text">
                                                <h3 class="reviews__author--title">{{ $property->name }}</h3>
                                                <p class="reviews__author--subtitle">{{ $property->location }}</p>
                                            </div>
                                        </div> 
                                    </td>
                                    @if($property->valuationSummary) 
                                        <td data-label="Price">
                                            <span class="item-price" data-price="{{ $property->valuationSummary->current_value_sum }}">₦{{ number_format($property->valuationSummary->current_value_sum, 2) }} per/sqm</span>
                                        </td>
                                    @else
                                        <td data-label="Price">
                                            <span class="item-price" data-price="{{ $property->price }}">₦{{ number_format($property->price, 2) }} per/sqm</span>
                                        </td>
                                    @endif 
                                    <td data-label="Actual Size">
                                        <span class="actual-size" data-size="{{ $property->size }}">{{ $property->size }} SQM</span>
                                    </td>
                                    
                                    <td data-label="Your Size" class="available-size" data-initial-size="{{ $property->buys->sum('selected_size_land') }}">
                                        {{ number_format($property->buys->sum('selected_size_land'), 4) }} SQM
                                    </td> 
                                    <td data-label="Enter Amount">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <input type="number" class="amount-input text-center mx-2"
                                                style="width: 120px;" min="1000" step="100" placeholder="Enter amount">
                                        </div>
                                        <small class="text-muted">Minimum: ₦1,000</small>
                                    </td>
                                    <td data-label="Calculated Size">
                                        <span class="calculated-size" style="color: #47008E; font-weight: bold">0.0000 SQM</span>
                                    </td>
                                    <td data-label="Total Value">
                                        <span class="total-price" style="color: #47008E; font-weight: bold">₦0.00</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="dashboard__container dashboard__reviews--container">
                <div class="cart__footer d-flex justify-content-end align-items-center mt-4">
                    <div style="width: 100%; max-width: 300px;">
                        <a href="#" class="solid__btn" id="make-payment-btn" style="opacity: 0.6; cursor: not-allowed; width: 100%;" disabled>Submit Request</a>
                    </div>
                </div> 
                <!-- Hidden Form to Pass Data for Payment --> 
                <form id="payment-form" action="{{ route('user.sell.property') }}" method="POST" style="display: none">
                    @csrf 
                    <input type="hidden" name="acquired_size_land" id="acquired_size_land" value="{{ number_format($property->buys->sum('selected_size_land'), 4) }}">
                    <input type="hidden" name="remaining_size" id="remaining_size">
                    <input type="hidden" name="available_size"  value="{{ $property->available_size }}">
                    <input type="hidden" name="property_slug" id="property_slug" value="{{ $property->slug }}">
                    <input type="hidden" name="amount" id="amount">
                    <input type="hidden" name="calculated_size" id="calculated_size">
                    <input type="hidden" name="total_price" id="total_price">
                </form> 
            </div>
        </main>
    </div>
</div>

<!-- Transaction PIN Verification Modal -->
<div class="modal fade" id="pinModal" tabindex="-1" aria-labelledby="pinModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="pinModalLabel"><b>Verify Transaction PIN</b></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center"><b>Please enter your 4-digit transaction PIN to confirm the property sale.</b></p>
                <div class="mb-3"> 
                    <label for="transaction_pin" class="form-label">Transaction PIN</label>
                    <input type="password" 
                    style="padding: 10px 10px;"
                    class="form-control" id="transaction_pin" placeholder="Enter 4-digit PIN" maxlength="4" inputmode="numeric" pattern="[0-9]*">
                    <div id="pinError" class="text-danger mt-1" style="display: none;"></div>
                    <div id="pinAttempts" class="text-warning mt-1" style="display: none;"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button 
                    type="button" 
                    style="background-color: white; color: black; border: 1px solid gray;"
                    class="solid__btn" 
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>
                <button type="button" class="solid__btn" id="confirmPin">Confirm & Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Update calculated land size and total
    function updateCart(row) {
        const pricePerSqm = parseFloat(row.querySelector('.item-price').dataset.price);
        const amountInput = row.querySelector('.amount-input');
        const amount = parseFloat(amountInput.value) || 0; // Default to 0 if input is invalid
        const availableSizeElement = row.querySelector('.available-size');
        const initialAvailableSize = parseFloat(availableSizeElement.dataset.initialSize);
        const calculatedSizeElement = row.querySelector('.calculated-size');
        const actualSize = parseFloat(row.querySelector('.actual-size').dataset.size);
        const submitBtn = document.getElementById('make-payment-btn');

        // Calculate land size using formula: amount / price per sqm
        const calculatedSize = amount / pricePerSqm;
        
        // Ensure calculated size doesn't exceed available size
        const finalCalculatedSize = Math.min(calculatedSize, initialAvailableSize);
        
        // Also ensure it doesn't exceed actual property size
        const safeCalculatedSize = Math.min(finalCalculatedSize, actualSize);
        
        // Calculate final amount based on the safe calculated size
        const finalAmount = safeCalculatedSize * pricePerSqm;

        // Update display
        calculatedSizeElement.textContent = `${safeCalculatedSize.toFixed(4)} SQM`;
        row.querySelector('.total-price').textContent = `₦${finalAmount.toLocaleString('en-NG', { minimumFractionDigits: 2 })}`;
        
        // Update available size display (remaining after this sale)
        const remainingSize = Math.max(initialAvailableSize - safeCalculatedSize, 0); 
        availableSizeElement.textContent = `${remainingSize.toFixed(4)} SQM`;

        // Check if amount exceeds available land size
        const exceedsAvailableSize = calculatedSize > initialAvailableSize;
        const exceedsActualSize = calculatedSize > actualSize;
        
        // Show warnings if limits are exceeded
        if (exceedsAvailableSize) {
            calculatedSizeElement.style.color = 'red';
            calculatedSizeElement.innerHTML = `${safeCalculatedSize.toFixed(4)} SQM <small style="color: orange;">(Max available)</small>`;
            
            // Reset amount to 0 and disable submit button
            amountInput.value = '';
            submitBtn.style.opacity = '0.6';
            submitBtn.style.cursor = 'not-allowed';
            submitBtn.disabled = true;
            
        } else if (exceedsActualSize) {
            calculatedSizeElement.style.color = 'red';
            calculatedSizeElement.innerHTML = `${safeCalculatedSize.toFixed(4)} SQM <small style="color: orange;">(Max actual size)</small>`;
            
            // Reset amount to 0 and disable submit button
            amountInput.value = '';
            submitBtn.style.opacity = '0.6';
            submitBtn.style.cursor = 'not-allowed';
            submitBtn.disabled = true;
            
        } else {
            calculatedSizeElement.style.color = '#47008E';
            
            // Enable submit button only if amount meets minimum requirement
            if (amount >= 1000) {
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor = 'pointer';
                submitBtn.disabled = false;
            } else {
                submitBtn.style.opacity = '0.6';
                submitBtn.style.cursor = 'not-allowed';
                submitBtn.disabled = true;
            }
        }

        // Update amount input if it was adjusted due to limits (but not when resetting to 0)
        if (safeCalculatedSize !== calculatedSize && !exceedsAvailableSize && !exceedsActualSize) {
            amountInput.value = finalAmount.toFixed(2);
        }
    }

    // Add event listeners for input
    document.querySelectorAll('.cart__table tbody tr').forEach(row => {
        const amountInput = row.querySelector('.amount-input');
        const availableSizeElement = row.querySelector('.available-size');
        const initialAvailableSize = parseFloat(availableSizeElement.dataset.initialSize);
        const pricePerSqm = parseFloat(row.querySelector('.item-price').dataset.price);
        const actualSize = parseFloat(row.querySelector('.actual-size').dataset.size);
        const submitBtn = document.getElementById('make-payment-btn');

        amountInput.addEventListener('input', () => {
            const currentVal = parseFloat(amountInput.value);
            if (isNaN(currentVal) || currentVal < 0) {
                amountInput.value = '';
            }
            updateCart(row);
        });

        amountInput.addEventListener('blur', () => {
            const currentVal = parseFloat(amountInput.value);
            
            // Validate minimum amount
            if (isNaN(currentVal) || currentVal < 1000) {
                if (amountInput.value !== '') {
                    alert('Minimum amount is ₦1,000');
                    amountInput.value = '';
                }
            } else {
                amountInput.value = currentVal.toFixed(2);
                
                // Check if amount exceeds limits
                const calculatedSize = currentVal / pricePerSqm;
                if (calculatedSize > initialAvailableSize) {
                    alert(`The amount entered exceeds your available land size. Please enter a smaller amount.`);
                    amountInput.value = '';
                } else if (calculatedSize > actualSize) {
                    alert(`The amount entered exceeds the actual property size. Please enter a smaller amount.`);
                    amountInput.value = '';
                }
            }
            updateCart(row);
        });

        amountInput.addEventListener('change', () => {
            const currentVal = parseFloat(amountInput.value);
            
            // Check minimum amount
            if (currentVal < 1000 && amountInput.value !== '') {
                alert('Minimum amount is ₦1,000');
                amountInput.value = '';
            }
            
            const calculatedSize = currentVal / pricePerSqm;
            
            // Check if calculated size exceeds available size
            if (calculatedSize > initialAvailableSize) {
                const maxAmount = initialAvailableSize * pricePerSqm;
                alert(`The amount entered would exceed your available land size. Maximum amount you can sell: ₦${maxAmount.toLocaleString('en-NG', { minimumFractionDigits: 2 })}`);
                amountInput.value = '';
            }
            
            // Check if calculated size exceeds actual property size
            if (calculatedSize > actualSize) {
                const maxAmountByActualSize = actualSize * pricePerSqm;
                alert(`The amount entered would exceed the actual property size. Maximum amount based on actual size: ₦${maxAmountByActualSize.toLocaleString('en-NG', { minimumFractionDigits: 2 })}`);
                amountInput.value = '';
            }
            
            updateCart(row);
        });

        // Focus event to clear placeholder behavior
        amountInput.addEventListener('focus', () => {
            if (amountInput.value === '') {
                amountInput.placeholder = '';
            }
        });

        // Initial update on page load
        updateCart(row);
    });

    // Handle "Submit Request" button click - Show PIN modal instead of submitting directly
    document.getElementById('make-payment-btn').addEventListener('click', function(event) {
        event.preventDefault();
        const row = document.querySelector('.cart__table tbody tr');
        const amount = row.querySelector('.amount-input').value.trim();

        // Prevent submission if amount is empty or less than 1000
        if (amount === '' || parseFloat(amount) < 1000) {
            alert('Please enter an amount of at least ₦1,000 to sell.');
            return;
        }

        // Show PIN verification modal instead of submitting directly
        const pinModal = new bootstrap.Modal(document.getElementById('pinModal'));
        pinModal.show();
    });

    // Handle PIN confirmation
    document.getElementById('confirmPin').addEventListener('click', function() {
        const transactionPin = document.getElementById('transaction_pin').value;
        const pinError = document.getElementById('pinError');
        const pinAttempts = document.getElementById('pinAttempts');
        
        // Clear previous errors
        pinError.style.display = 'none';
        pinAttempts.style.display = 'none';
        
        if (!transactionPin) {
            pinError.textContent = 'Please enter your 4-digit transaction PIN';
            pinError.style.display = 'block';
            return;
        }

        if (!/^\d{4}$/.test(transactionPin)) {
            pinError.textContent = 'Transaction PIN must be exactly 4 digits';
            pinError.style.display = 'block';
            return;
        }

        // Verify transaction PIN via AJAX
        fetch('{{ route("user.verify.transaction.pin") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ transaction_pin: transactionPin })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // PIN is correct, proceed with form submission
                const row = document.querySelector('.cart__table tbody tr');
                const availableSizeElement = row.querySelector('.available-size');
                const remainingSize = availableSizeElement.textContent.trim().split(' ')[0]; 
                const amount = row.querySelector('.amount-input').value.trim();
                const calculatedSize = row.querySelector('.calculated-size').textContent.trim().split(' ')[0];
                const totalPrice = row.querySelector('.total-price').textContent.replace(/₦|,/g, '').trim();

                // Update hidden input fields
                document.getElementById('remaining_size').value = remainingSize;
                document.getElementById('amount').value = amount;
                document.getElementById('calculated_size').value = calculatedSize;
                document.getElementById('total_price').value = totalPrice;

                // Hide modal and submit form
                const pinModal = bootstrap.Modal.getInstance(document.getElementById('pinModal'));
                pinModal.hide();
                
                // Submit the form
                document.getElementById('payment-form').submit();
            } else {
                // PIN is incorrect or other error
                if (data.redirect_url) {
                    // Redirect to PIN setup page
                    window.location.href = data.redirect_url;
                    return;
                }

                if (data.lockout_time) {
                    pinError.textContent = 'Too many failed attempts. Try again after 15 minutes.';
                    pinError.style.display = 'block';
                    document.getElementById('transaction_pin').disabled = true;
                    document.getElementById('confirmPin').disabled = true;
                    return;
                }

                if (data.attempts_remaining !== undefined) {
                    pinError.textContent = data.message || 'Invalid transaction PIN';
                    pinError.style.display = 'block';
                    pinAttempts.textContent = `${data.attempts_remaining} attempt(s) remaining`;
                    pinAttempts.style.display = 'block';
                } else {
                    pinError.textContent = data.message || 'Invalid transaction PIN. Please try again.';
                    pinError.style.display = 'block';
                }
                
                document.getElementById('transaction_pin').value = '';
                document.getElementById('transaction_pin').focus();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            pinError.textContent = 'An error occurred. Please try again.';
            pinError.style.display = 'block';
        });
    });

    // Clear PIN field when modal is closed
    document.getElementById('pinModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('transaction_pin').value = '';
        document.getElementById('transaction_pin').disabled = false;
        document.getElementById('confirmPin').disabled = false;
        document.getElementById('pinError').style.display = 'none';
        document.getElementById('pinAttempts').style.display = 'none';
    });

    // Allow pressing Enter in PIN field to confirm
    document.getElementById('transaction_pin').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('confirmPin').click();
        }
    });

    // Only allow numeric input for PIN field
    document.getElementById('transaction_pin').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 4) {
            this.value = this.value.slice(0, 4);
        }
    });
</script>
@endsection