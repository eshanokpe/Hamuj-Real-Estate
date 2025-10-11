@extends('layouts.dashboard')

@section('content')
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
                                    @if($property->valuationSummary) 
                                        <td>
                                            <span class="item-price">₦{{ number_format($property->valuationSummary->current_value_sum, 2) }} per/sqm</span>
                                        </td>
                                    @else
                                        <td>
                                            <span class="item-price">₦{{ number_format($property->price, 2) }} per/sqm</span>
                                        </td>
                                    @endif
                                    <td>
                                        <span>{{ $property->size }} SQM </span>
                                    </td>
                                    
                                    <td class="available-size" data-initial-size="{{ number_format($property->buys->sum('selected_size_land'), 4) }}">
                                      
                                        {{ $property->buys->sum('selected_size_land') }} SQM
                                    </td> 
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-outline-secondary btn-sm decrement-btn" 
                                                style="padding: 5px 10px; background:#47008E; color:#fff; font-size:18px">-</button>
                                            <input type="number" value="0" class="quantity-input text-center mx-2"
                                                style="width: 50px;" min="0">
                                            <button class="btn btn-outline-secondary btn-sm increment-btn" 
                                                style="padding: 5px 10px; background:#47008E; color:#fff; font-size:18px">+</button>
                                        </div>
                                    </td>
                                    
                                    @if($property->valuationSummary) 
                                        <td>
                                            <span class="total-price" style="color: #47008E">₦0.00</span> {{-- Initial total price is 0 --}}
                                        </td>
                                    @else
                                        <td>
                                            <span class="total-price" style="color: #47008E">₦0.00</span> {{-- Initial total price is 0 --}}
                                        </td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="dashboard__container dashboard__reviews--container">
                <div class="cart__footer d-flex justify-content-end align-items-center mt-4">
                    
                    <div>
                        <a href="#" class="solid__btn" id="make-payment-btn">Submit Request</a>
                    </div>
                </div> 
                <!-- Hidden Form to Pass Data for Payment --> 
                <form id="payment-form" action="{{ route('user.sell.property') }}" method="POST" style="display: none">
                    @csrf
                    <input type="hidden" name="remaining_size" id="remaining_size">
                    <input type="hidden" name="property_slug" id="property_slug" value="{{ $property->slug }}">
                    <input type="hidden" name="quantity" id="quantity">
                    <input type="hidden" name="total_price" id="total_price">
                </form>
            </div>
        </main>
    </div>
</div>

<script>
    // Update total price and available size
function updateCart(row) {
    const price = parseFloat(row.querySelector('.item-price').textContent.replace(/₦|,/g, ''));
    const quantityInput = row.querySelector('.quantity-input');
    const quantity = parseInt(quantityInput.value) || 0; // Default to 0 if input is invalid
    const availableSizeElement = row.querySelector('.available-size');
    const initialSize = parseFloat(availableSizeElement.dataset.initialSize);

    const total = price * quantity;
    // Ensure remaining size doesn't go below 0, but can be 0
    const remainingSize = Math.max(initialSize - quantity, 0); 
    row.querySelector('.total-price').textContent = `₦${total.toLocaleString('en-NG', { minimumFractionDigits: 2 })}`;
    availableSizeElement.textContent = `${remainingSize} SQM`;
}

// Add event listeners for buttons and inputs
document.querySelectorAll('.cart__table tbody tr').forEach(row => {
    const decrementBtn = row.querySelector('.decrement-btn');
    const incrementBtn = row.querySelector('.increment-btn');
    const quantityInput = row.querySelector('.quantity-input');
    const availableSizeElement = row.querySelector('.available-size');
    const initialSize = parseFloat(availableSizeElement.dataset.initialSize); // Available size


    decrementBtn.addEventListener('click', () => {
        if (quantityInput.value > 0) { // Allow decrementing to 0
            quantityInput.value--;
            updateCart(row);
        }
    });

    incrementBtn.addEventListener('click', () => {
        if (parseInt(quantityInput.value) < initialSize) {
            quantityInput.value++;
            updateCart(row); 
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
        updateCart(row);
    });

    // Initial update on page load
    updateCart(row);
});

// Handle "Make Payment" button click
document.getElementById('make-payment-btn').addEventListener('click', function(event) {
    event.preventDefault();
    const row = document.querySelector('.cart__table tbody tr'); // Assuming only one row for now
    const availableSizeElement = row.querySelector('.available-size');
    const remainingSize = availableSizeElement.textContent.trim().split(' ')[0]; 
    const quantity = row.querySelector('.quantity-input').value.trim();
    const totalPrice = row.querySelector('.total-price').textContent.replace(/₦|,/g, '').trim();
 
    // Update hidden input fields
    document.getElementById('remaining_size').value = remainingSize;

    // Prevent submission if quantity is 0
    if (parseInt(quantity) <= 0) {
        alert('Please select a quantity greater than 0 to sell.');
        return; // Stop the function here
    }
    document.getElementById('quantity').value = quantity;
    document.getElementById('total_price').value = totalPrice;

    // Submit the form
    document.getElementById('payment-form').submit();
});

</script>
@endsection
