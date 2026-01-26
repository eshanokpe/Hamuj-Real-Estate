@extends('layouts.app')

@section('content')
<section class="breadcrumb__section section--padding">
    <div class="container">
        <div class="breadcrumb__content text-center aos-init aos-animate" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="100">
            <h1 class="breadcrumb__title h2"><span>Properties</span> Cart</h1>
            <ul class="breadcrumb__menu d-flex justify-content-center">
                <li class="breadcrumb__menu--items"><a class="breadcrumb__menu--link" href="./index.html">Home</a></li>
                <li><span><svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.22321 4.65179C5.28274 4.71131 5.3125 4.77976 5.3125 4.85714C5.3125 4.93452 5.28274 5.00298 5.22321 5.0625L1.0625 9.22321C1.00298 9.28274 0.934524 9.3125 0.857143 9.3125C0.779762 9.3125 0.71131 9.28274 0.651786 9.22321L0.205357 8.77679C0.145833 8.71726 0.116071 8.64881 0.116071 8.57143C0.116071 8.49405 0.145833 8.4256 0.205357 8.36607L3.71429 4.85714L0.205357 1.34821C0.145833 1.28869 0.116071 1.22024 0.116071 1.14286C0.116071 1.06548 0.145833 0.997023 0.205357 0.9375L0.651786 0.491071C0.71131 0.431547 0.779762 0.401785 0.857143 0.401785C0.934524 0.401785 1.00298 0.431547 1.0625 0.491071L5.22321 4.65179Z" fill="#706C6C"></path>
                    </svg>
                    </span></li>
                <li><span class="breadcrumb__menu--text">Cart </span></li>
            </ul>
        </div>
    </div>
</section> 
 
<section class="cart__section section--padding">
    <div class="container">
        <div class="cart__inner">
            <div class="cart__wrapper mb-80">
                <h2 class="cart__title text-center mb-4">Properties Cart</h2>
                <div class="table-responsive">
                    <table class="table table-bordered cart__table">
                        <thead class="thead-light">
                            <tr>
                                <th>Product Image</th> 
                                <th>Product Name</th>
                                <th>Current Price</th>
                                <th>Available Land size</th>
                                <th>Select Land size</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Cart Item Example -->
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img class="featured__thumbnail--img" src="{{ asset($property->property_images) }}" alt="featured-img" style="width: 200px; height: 150px; object-fit:cover">
                                        <div style="display: none" class="featured__card--slug">
                                            <h3>{{ $property->slug }}</h3>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="featured__card--title">
                                    <h3>{{ $property->name }}</h3>
                                </td>
                                <td>
                                    <p class="listing__details--price__new">
                                        ₦<span class="item-price">{{ number_format($property->price, 2) }}</span>
                                    </p>
                                    <span class="listing__details--price__old">
                                        ₦{{ number_format($property->lunch_price, 2) }}
                                    </span>
                                </td>
                                <td class="featured__info--icon available-size" data-initial-size="{{ $property->size }}">{{ $property->size }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-outline-secondary btn-sm decrement-btn"
                                            style="padding: 5px 10px; background:#47008E; color:#fff; font-size:18px">-</button>
                                        <input type="number" 
                                            value="1" 
                                            class="account__form--input__field quantity-input text-center mx-2" 
                                            style="width: 50px;" 
                                            min="1">
                                        <button class="btn btn-outline-secondary btn-sm increment-btn"
                                            style="padding: 5px 10px; background:#47008E; color:#fff; font-size:18px">+</button>
                                    </div>
                                </td>
                                <td>
                                    <span class="total-price listing__details--price__new">₦{{ number_format($property->price, 2) }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="cart__footer d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('home.pages','properties')}}" class="solid__btn" style="background-color: #CC9933">View Properties</a>
                    <div>
                        <a href="#" class="solid__btn" id="make-payment-btn">Make Payment</a>
                    </div>
                </div>
            </div>

            <!-- Hidden Form to Pass Data for Payment -->
            <form id="payment-form" action="{{ route('user.payment.initiate') }}" method="POST" style="display:none">
                @csrf
                <input type="text" name="remaining_size" id="remaining_size">
                <input type="text" name="property_slug" id="property_slug">
                <input type="text" name="quantity" id="quantity">
                <input type="text" name="total_price" id="total_price">
            </form>
        </div>
    </div>
</section>

<script>
    // Update total price and available size
    function updateCart(row) {
        const price = parseFloat(row.querySelector('.item-price').textContent.replace(/,/g, ''));
        const quantityInput = row.querySelector('.quantity-input');
        const availableSizeElement = row.querySelector('.available-size');
        
        const quantity = parseInt(quantityInput.value) || 1;
        const initialSize = parseFloat(availableSizeElement.dataset.initialSize); // Retrieve initial size

        // Update total price
        const total = price * quantity;
        row.querySelector('.total-price').textContent = `₦${total.toLocaleString('en-NG', { minimumFractionDigits: 2 })}`;
        
        // Update available size (300 sqm per unit)
        const remainingSize = initialSize - quantity;
        const remaining = `${remainingSize} per/sqm`;
        availableSizeElement.textContent = remainingSize < 0 ? 0 : remaining; // Prevent negative sizes
    }

    // Add event listeners to buttons and inputs
    document.querySelectorAll('.cart__table tbody tr').forEach(row => {
        const decrementBtn = row.querySelector('.decrement-btn');
        const incrementBtn = row.querySelector('.increment-btn');
        const quantityInput = row.querySelector('.quantity-input');
        const availableSizeElement = row.querySelector('.available-size');

        // Set initial size in data attribute
        availableSizeElement.dataset.initialSize = availableSizeElement.textContent;

        decrementBtn.addEventListener('click', () => {
            const currentValue = parseInt(quantityInput.value) || 1;
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
                updateCart(row);
            }
        });

        incrementBtn.addEventListener('click', () => {
            const currentValue = parseInt(quantityInput.value) || 1;
            quantityInput.value = currentValue + 1;
            updateCart(row);
        });

        quantityInput.addEventListener('input', () => {
            const value = parseInt(quantityInput.value);
            if (!value || value < 1) quantityInput.value = 1; // Ensure value is valid
            updateCart(row);
        });
        
    });

    // Event listener for the "Make Payment" button
    document.getElementById('make-payment-btn').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default link behavior

         const row = document.querySelector('.cart__table tbody tr');
        const remainingSize = row.querySelector('.available-size').textContent;
        const propertySlug = row.querySelector('.featured__card--slug h3').textContent;
        const quantity = row.querySelector('.quantity-input').value;
        const totalPrice = row.querySelector('.total-price').textContent.replace('₦', '').replace(/,/g, '');

        document.getElementById('remaining_size').value = remainingSize;
        document.getElementById('property_slug').value = propertySlug;
        document.getElementById('quantity').value = quantity;
        document.getElementById('total_price').value = totalPrice;

        // Submit the form
        document.getElementById('payment-form').submit();
    });
</script>



@endsection