@extends('layouts.dashboard')

@section('content')
<div class="dashboard__page--wrapper" id="buyProperties">
    
</div>
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
                        <table class="properties__table--wrapper cart__table">
                            <thead>
                                <tr>
                                    <th>Product Image</th>
                                    <th>Price</th>
                                    <th>Actual Land Size</th>
                                    <th>Available Land Size</th>
                                    <th>Select Land Size</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
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
                                    <td>
                                        <span class="item-price">
                                            ₦{{ number_format($property->valuationSummary->current_value_sum ?? $property->price, 2) }} per/sqm
                                        </span>
                                    </td>
                                    <td><span>{{ $property->size }} SQM</span></td>
                                    <td class="available-size" data-initial-size="{{ $property->available_size }}">
                                        {{ $property->available_size }} SQM 
                                    </td> 
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-outline-secondary btn-sm decrement-btn" style="padding: 5px 10px; background:#47008E; color:#fff; font-size:18px">-</button>
                                            <input type="number" value="0" class="quantity-input text-center mx-2" style="width: 50px;" min="0">
                                            <button class="btn btn-outline-secondary btn-sm increment-btn" style="padding: 5px 10px; background:#47008E; color:#fff; font-size:18px">+</button>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="total-price" style="color: #47008E">
                                            ₦0.00 {{-- Initial total price is 0 --}}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                

                <div class="cart__footer d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('user.buy') }}" class="solid__btn" style="background-color: #CC9933">
                        View Properties
                    </a> 
                    <div>
                        {{-- <a href="#" class="solid__btn" id="make-payment-btn">Make Payment</a> --}}
                        <a href="#" class="solid__btn"  data-bs-toggle="modal" data-bs-target="#revolutModal" aria-label="popup button">Make Payment</a>
                    </div>
                </div> 

                    
                    
                <form id="payment-form" action="{{ route('user.payment.initiate') }}" method="POST" style="display: none;">
                    <div class="cart__footer d-flex justify-content-between align-items-center mt-4">
                       <div class="col">
                        @csrf
                        <div class="reviews__author--check position-relative">
                            <p for="commission-switch"><b>Apply Commission</b></p>
                            <div class="reviews__author--check position-relative d-flex align-items-center">
                                <input class="reviews__author--check__input" name="commission_check" id="commission-switch" type="checkbox">
                                
                                <span class="reviews__author--checkmark"></span> 
                                <span style="margin-left: 20px">Commission Balance: ₦{{ number_format(auth()->user()->commission_balance, 2) }}</span>
                            </div>
                        </div>
                        </div>
                        <div class="col text-end">

                        <input type="hidden" name="commission_applied_amount" id="commission_applied_amount" value="{{auth()->user()->commission_balance}}">
                        <input type="hidden" name="remaining_size" id="remaining_size">
                        <input type="hidden" name="property_slug" id="property_slug" value="{{ $property->slug }}">
                        <input type="hidden" name="quantity" id="quantity">
                        <input type="hidden" name="total_price" id="total_price">

                        <div class="form-group mt-3">
                            <label for="transaction_pin" class="form-label">Enter 4-digit Transaction PIN</label>
                            <input type="password"
                                   class="form-input"
                                   name="transaction_pin"
                                   id="transaction_pin"
                                   class="form-control"
                                   maxlength="4"
                                   inputmode="numeric"
                                   pattern="\d{4}"
                                   placeholder="****"
                                   required>
                        </div>

                        <button type="submit" class="solid__btn mt-2" id="confirm-payment-btn">Confirm Payment</button>
                       
                        </div>
                    </div>
                </form>
               
                <!-- Revolut Payment Modal -->
                {{-- <div class="modal fade" id="revolutModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Pay with Revolut</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="revolut-checkout-container"></div>
                                <div class="d-flex justify-content-between mt-3">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" id="confirm-revolut-payment" class="btn btn-primary">Confirm Payment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                 <!-- Modal Add Contact -->
                <!-- Modal Add Contact -->
                <div class="modal fade" id="revolutModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content modal__contact--main__content">
                            <div class="modal__contact--header d-flex align-items-center justify-content-between">
                                <h3 class="modal__contact--header__title">Pay with Revolut</h3>
                                <button type="button" class="modal__contact--close__btn" data-bs-dismiss="modal" aria-label="Close">    
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12.711" height="12.711" viewBox="0 0 12.711 12.711">
                                        <g id="Group_7205" data-name="Group 7205" transform="translate(-113.644 -321.644)">
                                            <path id="Vector" d="M0,9.883,9.883,0" transform="translate(115.059 323.059)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            <path id="Vector-2" data-name="Vector" d="M9.883,9.883,0,0" transform="translate(115.059 323.059)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                        </g>
                                    </svg>                                                              
                                </button>
                            </div>
                            <div class="modal-body modal__contact--body">
                                <div class="modal__contact--form">
                                    <!-- PIN Entry Form (initially hidden) -->
                                    <div id="pin-entry-form" style="display: none;">
                                        <div class="form-group mt-3">
                                            <label for="modal_transaction_pin" class="form-label">Enter 4-digit Transaction PIN</label>
                                            <input type="password"
                                                class="form-input"
                                                name="modal_transaction_pin"
                                                id="modal_transaction_pin"
                                                class="form-control"
                                                maxlength="4"
                                                inputmode="numeric"
                                                pattern="\d{4}"
                                                placeholder="****"
                                                required>
                                        </div>
                                        <button type="button" class="solid__btn mt-2" id="confirm-payment-with-pin">Confirm Payment</button>
                                    </div>
                                    
                                    <!-- Payment Options (initially shown) -->
                                    <div id="payment-options">
                                        <div id="revolut-checkout-container"></div>
                                        <div class="d-flex justify-content-between mt-3">
                                            <a href="#" class="solid__btn" id="confirm-revolut-payment">Pay with Card</a>
                                            <a href="#" class="solid__btn" id="make-payment-btn" data-bs-dismiss="modal">Pay with Wallet</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal Add Contact -->

               
            </div>
        </main>
    </div>
</div>


<script src="https://assets.revolut.com/web-checkout/1.4/revolut-checkout.js"></script>

<script>

@auth
    @if (!auth()->user()->transaction_pin)
        window.location.href = "{{ route('user.transaction.pin') }}"; 
    @endif
@endauth 

// Initialize commission amount
const commissionRate = @json(auth()->user()->commission_balance); 
console.log(commissionRate);

// Function to update the total price including commission deduction
function updateTotalWithCommission(row) {
    const priceText = row.querySelector('.item-price').textContent;
    const price = parseFloat(priceText.replace(/[^\d.]/g, ''));
    const quantityInput = row.querySelector('.quantity-input');
    const availableSizeElement = row.querySelector('.available-size');
    const initialSize = parseFloat(availableSizeElement.dataset.initialSize);
    const quantity = parseInt(quantityInput.value) || 0; // Default to 0 if input is invalid
    const total = price * quantity;
    // Ensure remaining size doesn't go below 0, but can be 0
    const remainingSize = Math.max(initialSize - quantity, 0); 

    let totalWithCommission = total;

    // Check if commission is applied and subtract the fixed commission amount
    if (document.getElementById('commission-switch').checked) {
        // Subtract the fixed commission amount (2000 in your case)
        // But ensure it doesn't make the total negative
        totalWithCommission = Math.max(total - commissionRate, 0);
    }

    row.querySelector('.total-price').textContent = `₦${totalWithCommission.toLocaleString('en-NG', { minimumFractionDigits: 2 })}`;
    availableSizeElement.textContent = `${remainingSize} SQM`;
    
    // For debugging:
    console.log({
        price,
        quantity,
        total,
        commissionRate,
        totalWithCommission
    });
}

// Quantity logic
document.querySelectorAll('.cart__table tbody tr').forEach(row => {
    const decrementBtn = row.querySelector('.decrement-btn');
    const incrementBtn = row.querySelector('.increment-btn');
    const quantityInput = row.querySelector('.quantity-input');
    const availableSizeElement = row.querySelector('.available-size');
    const initialSize = parseFloat(availableSizeElement.dataset.initialSize); // Available size

    decrementBtn.addEventListener('click', () => {
        if (quantityInput.value > 0) { // Allow decrementing to 0
            quantityInput.value--;
            updateTotalWithCommission(row);
        }
    });

    incrementBtn.addEventListener('click', () => {
        if (parseInt(quantityInput.value) < initialSize) {
            quantityInput.value++;
            updateTotalWithCommission(row);
        } else {
            alert(`You cannot exceed the available size of ${initialSize} per/sqm.`);
        }
    });

    quantityInput.addEventListener('input', () => {
        const currentVal = parseInt(quantityInput.value);
        if (isNaN(currentVal) || currentVal < 0) { // Prevent negative values or non-numeric input
             quantityInput.value = 0;
        } else if (currentVal > initialSize) { // Prevent exceeding available size
            alert(`You cannot exceed the available size of ${initialSize} per/sqm.`);
            quantityInput.value = initialSize;
        }
        updateTotalWithCommission(row);
    });
});

// Listen for toggle switch change
document.getElementById('commission-switch').addEventListener('change', () => {
    document.querySelectorAll('.cart__table tbody tr').forEach(row => {
        updateTotalWithCommission(row);
    });
});

// Show the form on "Make Payment"
document.getElementById('make-payment-btn').addEventListener('click', function(e) {
    e.preventDefault();

    const row = document.querySelector('.cart__table tbody tr');
    const availableSizeElement = row.querySelector('.available-size');
    const remainingSize = availableSizeElement.textContent.trim().split(' ')[0]; 
    const quantity = row.querySelector('.quantity-input').value.trim();

    // Prevent showing payment form if quantity is 0
    if (parseInt(quantity) <= 0) {
        alert('Please select a quantity greater than 0 to proceed.');
        return; // Stop the function here
    }
    const totalPrice = row.querySelector('.total-price').textContent.replace(/₦|,/g, '').trim();

    document.getElementById('remaining_size').value = remainingSize;
    document.getElementById('quantity').value = quantity;
    document.getElementById('total_price').value = totalPrice;

    const form = document.getElementById('payment-form');
    form.style.display = 'block';
    form.scrollIntoView({ behavior: 'smooth' });
});

// Confirm payment (submit form only when valid PIN)
document.getElementById('confirm-payment-btn').addEventListener('click', function(e) {
    const pin = document.getElementById('transaction_pin').value.trim();
    if (pin.length !== 4 || !/^\d{4}$/.test(pin)) {
        alert('Please enter a valid 4-digit PIN.');
        e.preventDefault();
    }
});

    // Initial update on page load to set correct initial total and remaining size
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.cart__table tbody tr').forEach(row => {
            updateTotalWithCommission(row);
        });
    });

    // Handle "Pay with Card" button click
document.getElementById('confirm-revolut-payment').addEventListener('click', function(e) {
    e.preventDefault();
    
    // Hide payment options and show PIN form
    document.getElementById('payment-options').style.display = 'none';
    document.getElementById('pin-entry-form').style.display = 'block';
});

// Handle PIN form submission
document.getElementById('confirm-payment-with-pin').addEventListener('click', function(e) {
    e.preventDefault();
    // Check if RevolutCheckout is available
    // if (typeof RevolutCheckout === 'undefined') {
    //     console.error('Revolut checkout.js not loaded!');
    //     alert('Payment system not available. Please try again later.');
    //     return;
    // }
    
    const pin = document.getElementById('modal_transaction_pin').value.trim();
    
    // Validate PIN
    if (pin.length !== 4 || !/^\d{4}$/.test(pin)) {
        alert('Please enter a valid 4-digit PIN.');
        return;
    }
    
    // Get all necessary values
    const row = document.querySelector('.cart__table tbody tr');
    const quantity = parseInt(row.querySelector('.quantity-input').value);
    const availableSizeElement = row.querySelector('.available-size');
    const remainingSize = availableSizeElement.textContent.trim().split(' ')[0];
    const totalPrice = row.querySelector('.total-price').textContent.replace(/₦|,/g, '').trim();
    const commissionApplied = document.getElementById('commission-switch').checked ? 
        document.getElementById('commission_applied_amount').value : 0;
    
    // Prepare the form data
    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('remaining_size', remainingSize);
    formData.append('property_slug', '{{ $property->slug }}');
    formData.append('quantity', quantity);
    formData.append('total_price', totalPrice);
    formData.append('commission_applied_amount', commissionApplied);
    formData.append('transaction_pin', pin);
    formData.append('commission_check', document.getElementById('commission-switch').checked ? '1' : '0');
    
    const submitBtn = this;
    submitBtn.disabled = true;
    submitBtn.textContent = 'Processing...';
    console.log('Property slug being sent:', formData.get('property_slug')); 
      function loadSDK() {
        return new Promise((resolve, reject) => {
        const script = document.createElement('script');
        script.src = 'https://assets.revolut.com/web-checkout/1.4/revolut-checkout.js';
        script.onload = resolve;
        script.onerror = () => {
            console.error('Failed to load Revolut SDK');
            reject(new Error('Could not load payment processor'));
        };
        document.head.appendChild(script);
        });
    }
    // Submit the data to your backend
    await loadSDK();
    fetch('{{ route("user.revolutPayment.make") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(Object.fromEntries(formData))
        // body: formData
    })
    .then(response => {
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            return response.text().then(text => {
                throw new Error(`Server returned ${response.status}: ${text}`);
            });
        }
        return response.json();
    })
    .then(data => {
         console.error('data:', data);
        if (data.public_id) {
             const { public_id } = await response.json();
      
      // Initialize checkout
      RevolutCheckout(public_id, {
        mode: 'sandbox', // or 'prod'
        onSuccess() {
          window.location.href = '/payment/success';
        },
        onError(error) {
          console.error('Payment error:', error);
          alert('Payment failed. Please try again.');
        }
      }).then(rc => rc.show());
        //  window.location.href = `https://merchant.revolut.com/checkout/${data.public_id}`;

            // // Double-check RevolutCheckout is available
            // if (typeof RevolutCheckout === 'undefined') {
            //     throw new Error('Payment system not loaded. Please refresh the page.');
            // }
            // // Show Revolut payment UI 
            // RevolutCheckout(data.public_id, '{{ config("services.revolut.mode") }}').then(function(rc) {
            //     rc.payWithRevolut({
            //         target: document.getElementById('revolut-checkout-container'),
            //         onSuccess() {
            //             window.location.href = `/payment/success?transaction_id=${data.transaction_id}`;
            //         },
            //         onFailure() {
            //             window.location.href = '/payment/failed';
            //         },
            //         onCancel() {
            //             submitBtn.disabled = false;
            //             submitBtn.textContent = 'Confirm Payment';
            //             // Reset the modal view
            //             document.getElementById('payment-options').style.display = 'block';
            //             document.getElementById('pin-entry-form').style.display = 'none';
            //         }
            //     });
            // });
        } else {
            throw new Error(data.message || 'Payment failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(error.message);
        submitBtn.disabled = false;
        submitBtn.textContent = 'Confirm Payment';
    });
});

// Update modal to ensure all data is collected before showing
document.querySelector('[data-bs-target="#revolutModal"]').addEventListener('click', function(e) {
    const row = document.querySelector('.cart__table tbody tr');
    const quantity = parseInt(row.querySelector('.quantity-input').value);
    
    if (quantity <= 0) {
        e.preventDefault();
        alert('Please select a quantity greater than 0 to proceed.');
        return;
    }
    
    // Reset modal state
    document.getElementById('payment-options').style.display = 'block';
    document.getElementById('pin-entry-form').style.display = 'none';
    
    // Update form fields
    const availableSizeElement = row.querySelector('.available-size');
    const remainingSize = availableSizeElement.textContent.trim().split(' ')[0]; 
    const totalPrice = row.querySelector('.total-price').textContent.replace(/₦|,/g, '').trim();

    document.getElementById('remaining_size').value = remainingSize;
    document.getElementById('quantity').value = quantity;
    document.getElementById('total_price').value = totalPrice;
});

</script>
@endsection