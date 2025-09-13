@extends('layouts.dashboard')

@section('content')
<div class="dashboard__page--wrapper">
    <!-- Dashboard sidebar -->
    <div class="page__body--wrapper" id="dashbody__page--body__wrapper">
        <main class="main__content_wrapper">
            <!-- Dashboard container -->
            <div class="dashboard__container dashboard__reviews--container">
                <div class="reviews__heading mb-30">
                    <h2 class="reviews__heading--title">Offer Price</h2>
                    {{-- <p class="reviews__heading--desc">We are glad to see you again!</p> --}}
                </div>
                <div class="properties__wrapper mb-30">
                    <div class="properties__table table-responsive">
                        <table class="properties__table--wrapper cart__table">
                            <thead>
                                <tr>
                                    <th>Product Image</th>
                                    <th>State</th>
                                    <th>Price</th>
                                    <th>Actual Land Size</th>
                                    <th>Available Land Size</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="properties__author d-flex align-items-center">
                                            <div class="properties__author--thumb">
                                                <img src="{{ asset('app/public/' . $buy->property->property_images) }}" alt="img" 
                                                    style="width: 64px; height:64px; object-fit:cover">
                                            </div>
                                            <div class="reviews__author--text">
                                                <h3 class="reviews__author--title">{{ $buy->property->name }}</h3>
                                                <p class="reviews__author--subtitle">{{ $buy->property->location }}</p>
                                                <span class="properties__author--price text-decoration-line-through text-muted" style="color: #47008E">₦{{ number_format($buy->property->lunch_price, 2) }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($buy->status == 'available')
                                            <span class="status__btn pending">
                                                {{  ucFirst($buy->status) }}
                                            </span>
                                        @elseif($buy->status == 'sold out')
                                            <span class="status__btn active" style="color: green">
                                                {{  ucFirst($buy->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="properties__author--price">₦{{ number_format($buy->property->price, 2) }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $buy->property->size }} per/sqm</span>
                                    </td>
                                    <td class="available-size" data-initial-size="{{ $buy->property->available_size }}">
                                        {{ $buy->property->available_size }} per/sqm
                                    </td>
                                   
                                    <td>
                                        <span class="total-price" style="color: #47008E">₦{{ number_format($buy->property->price, 2) }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-4"></div>
                    <div class="col-8 " >
                        <div class="setting__profile edit-profile">
                            <div class="edit__profile--step">
                                <h3 class="setting__profile--title">Place New Offer Price for the Properties</h3>
                                <div class="setting__profile--inner">
                                    <form action="{{ route('user.offerPrice.post')}}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12 col-md-6">
                                                <input name="buy_id" value="{{ $buy->id}}" class="add__listing--input__field" id="name1" type="hidden" required>
                                                @error('buy_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <input name="property_id" value="{{ $buy->property->id}}" class="add__listing--input__field" id="name1" type="hidden" required>
                                                @error('property_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                                <div class="add__listing--input__box mb-20">
                                                    <label class="add__listing--input__label" for="name1">Enter offer Price per/sqm</label>
                                                    <input  id="offerPrice" name="offer_price" class="add__listing--input__field" id="name1" placeholder="Enter offer Price per/sqm" type="text" required>
                                                </div>
                                                @error('offer_price')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="edit__profile--button d-flex justify-content-end">
                                                <button class="edit__profile--update__btn solid__btn">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                    <script>
                                        const offerPriceInput = document.getElementById('offerPrice');
                                    
                                        offerPriceInput.addEventListener('input', function () {
                                            let value = this.value.replace(/\D/g, ''); 
                                             if (value) {
                                                this.value = parseFloat(value).toLocaleString('en-NG');
                                            }
                                        });
                                    
                                        offerPriceInput.addEventListener('blur', function () {
                                            if (this.value === '') {
                                                this.value = ''; // Reset to empty if no value
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                           
                        </div>
                    </div>
               
                </div>

            </div>

            

           
        </main>
    </div>
</div>

<script>
    // Update total price and available size
function updateCart(row) {
    const price = parseFloat(row.querySelector('.item-price').textContent.replace(/₦|,/g, ''));
    const quantityInput = row.querySelector('.quantity-input');
    const availableSizeElement = row.querySelector('.available-size');
    const initialSize = parseFloat(availableSizeElement.dataset.initialSize);

    const quantity = parseInt(quantityInput.value) || 1;
    const total = price * quantity;
    const remainingSize = Math.max(initialSize - quantity, 1); // Prevent negative sizes

    row.querySelector('.total-price').textContent = `₦${total.toLocaleString('en-NG', { minimumFractionDigits: 2 })}`;
    availableSizeElement.textContent = `${remainingSize} per/sqm`;
}

// Add event listeners for buttons and inputs
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

// Handle "Make Payment" button click
document.getElementById('make-payment-btn').addEventListener('click', function(event) {
    event.preventDefault();
    const row = document.querySelector('.cart__table tbody tr');
    const availableSizeElement = row.querySelector('.available-size');
    const remainingSize = availableSizeElement.textContent.trim().split(' ')[0]; 
    const quantity = row.querySelector('.quantity-input').value.trim();
    const totalPrice = row.querySelector('.total-price').textContent.replace(/₦|,/g, '').trim();
 
    // Update hidden input fields
    document.getElementById('remaining_size').value = remainingSize;
    document.getElementById('quantity').value = quantity;
    document.getElementById('total_price').value = totalPrice;

    // Submit the form
    document.getElementById('payment-form').submit();
});

</script>
@endsection
