@extends('layouts.dashboard')

@section('content')
<div class="dashboard__page--wrapper">
    <!-- Dashboard sidebar -->
    <div class="page__body--wrapper" id="dashbody__page--body__wrapper">
        <main class="main__content_wrapper">
            <!-- Dashboard container -->
            <div class="dashboard__container dashboard__reviews--container">
                <div class="reviews__heading mb-30">
                    <h2 class="reviews__heading--title">Transfer Property</h2>
                    <p class="reviews__heading--desc">We are glad to see you again!</p>
                </div>
                <div class="properties__wrapper">
                    <div class="properties__table table-responsive">
                        <table class="properties__table--wrapper cart__table">
                            <thead>
                                <tr>
                                    <th>Product Image</th>
                                    <th>Price</th>
                                    <th>Acquired Size</th>
                                    <th>Total</th>
                                </tr> 
                            </thead>
                            <tbody>
                               
                                <tr>
                                    <td>
                                        <div class="properties__author d-flex align-items-center">
                                            <div class="properties__author--thumb">
                                                <img src="{{ asset($propertyImage) }}" alt="img" 
                                                    style="width: 64px; height:64px; object-fit:cover">
                                            </div>
                                            <div class="reviews__author--text">
                                                <h3 class="reviews__author--title">{{ $propertyName }}</h3>
                                            </div>
                                        </div> 
                                    </td>
                                    <td>
                                        <span class="item-price">₦{{ number_format($amount, 2) }}</span>
                                    </td>
                                    <td class="available-size" data-initial-size="{{  $landSize }}">
                                        {{  $landSize }} SQM
                                    </td> 
                                    <td>
                                        <span class="total-price" style="color: #47008E">₦{{ number_format($amount, 2) }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="dashboard__container dashboard__reviews--container">
                <div class="row">
                   <div class="col-lg-6"></div>
                   <div class="col-lg-6">
                        <div class="setting__profile " style="background-color: #fff"> 
                            <div class="edit__profile--step">
                                <h4 class="setting__profile--title">Recipient Information</h4>
                                <form action="{{ route('user.checkRecipient.transfer') }}" method="POST">
                                    @csrf
                                    <div class="setting__profile--inner">
                                        <input name="selected_size_land" id="selected_size_land" type="hidden" value="{{$landSize }}"/>
                                        <input name="property_slug" id="property_slug" type="hidden" value="{{ $propertySlug }}"/>
                                        <input name="property_id" id="property_id" type="hidden" value="{{$propertyId }}"/>
                                        <input name="amount" id="amount" type="hidden" value="{{ $amount }}"/>
                                        <input required class="add__listing--input__field mb-10" id="name" name="recipient_id"  placeholder="Recipient ID" type="hidden" value="{{ $recipientData->id }}">
 
                                        <div class="add__listing--input__box mb-20">
                                            <label class="add__listing--input__label" for="email">Recipient Details</label>
                                            <input required class="add__listing--input__field mb-10" id="name" name="recipient_id" disabled placeholder="Recipient ID" type="text" value="{{ $recipientData->last_name.' '.$recipientData->first_name }}">
                                            <input required class="add__listing--input__field mb-10" id="name" name="recipient_id" disabled placeholder="Recipient ID" type="text" value="{{ $recipientData->email}}">
                                        </div> 
                                        <div class="add__listing--input__box mb-20">
                                            <label class="add__listing--input__label" for="email">Enter 4-digit Transaction PIN</label>
                                            <input required class="add__listing--input__field mb-10" 
                                            id="transaction_pin"  name="transaction_pin"  maxlength="4"
                                            placeholder="****" type="password" inputmode="numeric" pattern="\d{4}" required
                                            >
                                        </div> 
                                       
                                        
                                        <button type="submit" class="solid__btn add__property--btn">Submit Transfer Request</button>
                                    </div>
                                </form>
                                <!-- Payment Form -->
                                


                            </div>
                        </div>
                        {{-- <a href="#" class="solid__btn" id="make-payment-btn">Continue</a> --}}
                    </div>
                </div>
                <!-- Hidden Form to Pass Data for Payment -->
               
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
</script>

@endsection
