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
                                            <input type="number" value="1" class="quantity-input text-center mx-2" style="width: 50px;" min="1">
                                            <button class="btn btn-outline-secondary btn-sm increment-btn" style="padding: 5px 10px; background:#47008E; color:#fff; font-size:18px">+</button>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="total-price" style="color: #47008E">
                                            ₦{{ number_format($property->valuationSummary->current_value_sum ?? $property->price, 2) }}
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
                        <a href="#" class="solid__btn" id="make-payment-btn">Make Payment</a>
                    </div>
                </div>

                <!-- Payment Form -->
                <div class="row mt-3">
                    <div class="col-6"></div>
                    <div class="col-6">
                        <form id="payment-form" action="{{ route('user.payment.initiate') }}" method="POST" style="display: none;">
                            @csrf
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
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
// Redirect user to set PIN if not set
@auth
@if (!auth()->user()->transaction_pin)
    window.location.href = "{{ route('user.transaction.pin') }}";  // Redirect to the PIN setup page
@endif
@endauth

// Update price and remaining size
function updateCart(row) {
    const price = parseFloat(row.querySelector('.item-price').textContent.replace(/₦|,/g, ''));
    const quantityInput = row.querySelector('.quantity-input');
    const availableSizeElement = row.querySelector('.available-size');
    const initialSize = parseFloat(availableSizeElement.dataset.initialSize);
    const quantity = parseInt(quantityInput.value) || 1;
    const total = price * quantity;
    const remainingSize = Math.max(initialSize - quantity, 1);

    row.querySelector('.total-price').textContent = `₦${total.toLocaleString('en-NG', { minimumFractionDigits: 2 })}`;
    availableSizeElement.textContent = `${remainingSize} SQM`;
}

// Quantity logic
document.querySelectorAll('.cart__table tbody tr').forEach(row => {
    const decrementBtn = row.querySelector('.decrement-btn');
    const incrementBtn = row.querySelector('.increment-btn');
    const quantityInput = row.querySelector('.quantity-input');

    decrementBtn.addEventListener('click', () => {
        if (quantityInput.value > 1) {
            quantityInput.value--;
            updateCart(row);
        }
    });

    incrementBtn.addEventListener('click', () => {
        quantityInput.value++;
        updateCart(row);
    });

    quantityInput.addEventListener('input', () => {
        if (quantityInput.value < 1) quantityInput.value = 1;
        updateCart(row);
    });
});

// Show the form on "Make Payment"
document.getElementById('make-payment-btn').addEventListener('click', function(e) {
    e.preventDefault();

    const row = document.querySelector('.cart__table tbody tr');
    const availableSizeElement = row.querySelector('.available-size');
    const remainingSize = availableSizeElement.textContent.trim().split(' ')[0]; 
    const quantity = row.querySelector('.quantity-input').value.trim();
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
</script>
@endsection
