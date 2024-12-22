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
                                    <th>Selected Land Size</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                <tr>
                                    <td>
                                        <div class="properties__author d-flex align-items-center">
                                            {{-- <div class="properties__author--thumb">
                                                <img src="{{ asset($data['metadata']['property_image']) }}" alt="img" 
                                                    style="width: 64px; height:64px; object-fit:cover">
                                            </div> --}}
                                            <div class="reviews__author--text">
                                                <h3 class="reviews__author--title">{{ $data['property_name'] }}</h3>
                                            </div>
                                        </div> 
                                    </td>
                                    <td>
                                        <span class="item-price">₦{{ number_format($data['total_price'], 2) }}</span>
                                    </td>
                                    <td class="available-size" data-initial-size="{{  $data['land_size']}}">
                                        {{  $data['land_size'] }} per/sqm
                                    </td>
                                    <td>
                                        <span class="total-price" style="color: #47008E">₦{{ number_format($data['total_price'], 2) }}</span>
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
                                <h4 class="setting__profile--title"> Sender Information</h4>
                                <div class="card mt-3">
                                   
                                    <div class="card-body">
                                        <p><strong>Name:</strong> {{ $sender->last_name }} {{ $sender->first_name }}</p>
                                        <p><strong>Email:</strong> {{ $sender->email }}</p>
                                        <p><strong>Phone:</strong> {{ $sender->phone }}</p> <!-- Assuming phone number is stored -->
                                    </div>
                                </div>
                                <form action="{{ route('user.checkRecipient.transfer') }}" method="POST">
                                    @csrf
                                    <div class="setting__profile--inner">
                                        <input name="selected_size_land" id="selected_size_land" type="hidden" value="{{$data['land_size'] }}"/>
                                        <input name="property_slug" id="property_slug" type="hidden" value="{{$data['property_slug'] }}"/>
                                        <input name="property_id" id="property_id" type="hidden" value="{{$data['property_id'] }}"/>
                                        <input name="amount" id="amount" type="hidden" value="{{$data['total_price'] }}"/>
                                        <div class="add__listing--input__box mb-20">
                                            <label class="add__listing--input__label" for="email"> Recipient ID</label>
                                            <input disabled required class="add__listing--input__field" id="name" name="recipient_id" placeholder="Recipient ID" type="text" value="{{$data['recipient_id']}}">
                                        </div>
                                        
                                        <button type="submit" class="solid__btn add__property--btn">Confirm</button>
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
