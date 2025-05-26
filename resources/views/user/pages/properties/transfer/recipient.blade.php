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
                                                <img src="{{ asset($data['metadata']['property_image']) }}" alt="img" 
                                                    style="width: 64px; height:64px; object-fit:cover">
                                            </div>
                                            <div class="reviews__author--text">
                                                <h3 class="reviews__author--title">{{ $data['metadata']['property_name'] }}</h3>
                                            </div>
                                        </div> 
                                    </td>
                                    <td>   
                                        <span class="item-price">₦{{ number_format($data['amount'], 2) }}</span>
                                    </td>
                                    <td class="available-size" data-initial-size="{{  $data['metadata']['remaining_size']}}">
                                        {{  $data['metadata']['remaining_size'] }} SQM
                                    </td>  
                                    <td>
                                        <span class="total-price" style="color: #47008E">₦{{ number_format($data['amount'], 2) }}</span>
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
                                    <form action="{{ route('user.transfer.checkRecipient') }}" method="POST">
                                    @csrf 
                                    <div class="setting__profile--inner">
                                        <input name="selected_size_land" id="selected_size_land" type="hidden" value="{{$data['metadata']['selected_size_land'] }}"/>
                                        <input name="property_slug" id="property_slug" type="hidden" value="{{$data['metadata']['property_slug'] }}"/>
                                        <input name="property_id" id="property_id" type="hidden" value="{{$data['metadata']['property_id'] }}"/>
                                        <input name="amount" id="amount" type="hidden" value="{{$data['amount'] }}"/>
                                        <div class="add__listing--input__box mb-20">
                                            <label class="add__listing--input__label" for="email">Enter Recipient ID</label>
                                            <input required class="add__listing--input__field" id="name" name="recipient_id" placeholder="Recipient ID" type="text" value="">
                                            <input name="property_slug" id="property_slug" type="hidden" value="{{$data['metadata']['property_slug'] }}"/>
                                            <input required class="add__listing--input__field" id="name" name="property_image" placeholder="Recipient ID" type="hidden" value="{{ $data['metadata']['property_image'] }}">
                                            <input required class="add__listing--input__field" id="name" name="property_name" placeholder="Recipient ID" type="hidden" value="{{ $data['metadata']['property_name'] }}">
                                            <input required class="add__listing--input__field" id="name" name="amount" placeholder="Recipient ID" type="hidden" value="{{ $data['amount'] }}">
                                            <input required class="add__listing--input__field" id="name" name="selected_size_land" placeholder="Recipient ID" type="hidden" value="{{ $data['metadata']['selected_size_land'] }}">
                                            <input required class="add__listing--input__field" id="name" name="remaining_size" placeholder="Recipient ID" type="hidden" value="{{ $data['metadata']['remaining_size'] }}">
                                            
                                        </div> 
                                        
                                        <button type="submit" class="solid__btn add__property--btn">Continue</button>
                                    </div>
                                </form>
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


@endsection
