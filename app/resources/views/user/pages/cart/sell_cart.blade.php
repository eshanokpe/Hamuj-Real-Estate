@extends('layouts.dashboard')

@section('content')
<style>
    /* ... (Keep your existing CSS exactly as it is) ... */
</style>

<div class="dashboard__page--wrapper">
    <div class="page__body--wrapper" id="dashbody__page--body__wrapper">
        <main class="main__content_wrapper">
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
                                    <th>Purchase Details</th>
                                    <th>Enter Amount (₦)</th>
                                    <th>Total to Sell</th>
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
                                                <p class="mt-2 reviews__author--title"><span style="font-weight:bold">ROI:</span> {{ $property->percentage_increase }}%</p>
                                            </div>
                                        </div> 
                                    </td>
                                   
                                    {{-- UPDATED: Displays details of the SPECIFIC purchase --}}
                                    <td data-label="Purchase Details" class="available-size">
                                         <div class="d-flex flex-column">
                                             <span style="color: #47008E; font-weight: 800;">
                                                ₦{{ number_format($specificBuy->total_price, 2) }}
                                             </span>
                                             <small class="text-muted">
                                                 Bought on: {{ \Carbon\Carbon::parse($specificBuy->created_at)->format('d M, Y') }}
                                             </small>
                                         </div>
                                    </td> 

                                    <td data-label="Enter Amount">
                                        <div class="d-flex align-items-center justify-content-start">
                                            <input type="number" class="amount-input text-left "
                                                 min="1000" step="100" placeholder="Enter amount">
                                        </div>
                                        <small class="text-muted">Minimum: ₦1,000</small>
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
                    {{-- UPDATED: Use specificBuy data for hidden inputs --}}
                    <input type="hidden" name="buy_id" value="{{ $specificBuy->id }}">
                    <input type="hidden" name="acquired_size_land" id="acquired_size_land" value="{{ number_format($specificBuy->selected_size_land, 4) }}">
                    <input type="hidden" name="remaining_size" id="remaining_size">
                    <input type="hidden" name="available_size" value="{{ $property->available_size }}">
                    <input type="hidden" name="property_slug" id="property_slug" value="{{ $property->slug }}">
                    <input type="hidden" name="amount" id="amount">
                    <input type="hidden" name="calculated_size" id="calculated_size">
                    <input type="hidden" name="total_price" id="total_price">
                </form> 
            </div>
        </main>
    </div>
</div>

<!-- Transaction PIN Verification Modal (Keep your existing modal code exactly as it is) -->
<div class="modal fade" id="pinModal" tabindex="-1" aria-labelledby="pinModalLabel" aria-hidden="true">
    <!-- ... -->
</div>

<script>
    // ... (Keep your existing JavaScript exactly as it is) ...
    
    // NOTE: Your JS relies on .item-price and .actual-size classes. 
    // Since we removed those columns in the previous steps, ensure your JS 
    // has the correct data sources or add hidden spans with those classes 
    // if the JS logic requires them for calculation.
</script>
@endsection