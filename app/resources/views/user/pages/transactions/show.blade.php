@extends('layouts.dashboard')


@section('content')

 
<div class="dashboard__page--wrapper">
    <!-- Dashboard sidebar .\ -->
    <div class="page__body--wrapper" id="dashbody__page--body__wrapper">
        
        <main class="main__content_wrapper">
            <!-- dashboard container -->
            <div class="dashboard__container add__property--container">
                <div class="row add__property--heading mb-30">
                    <h2 class="add__property--heading__title text-start">Show Transaction Details</h2>
                    <div class="add__property--heading__title text-end" >
                        
                        <a href="{{ route('user.transactions.index') }}"  class="solid__btn add__property--btn">
                            Back
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="add__property--step__inner">
                            <div class="add__property--box mb-30">
                                <br/>
                                <div class="row m-2">
                                    <div class="col-12">
                                        <div class="add__listing--input__box mb-20">
                                            <label class="add__listing--input__label" for="input1">Property Name</label>
                                            <div>{{ $transaction->property->name }}</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="add__listing--input__box mb-20">
                                            <label class="add__listing--input__label" for="input1">Reference</label>
                                            <div>{{ $transaction->reference }}</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="add__listing--input__box mb-20">
                                            <label class="add__listing--input__label" for="input1">Payment method</label>
                                            <div>{{ $transaction->payment_method }}</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="add__listing--input__box mb-20">
                                            <label class="add__listing--input__label" for="input1">Created_at</label>
                                            <div> {{ $transaction->created_at->format('d F, Y') }}</div>
                                        </div>
                                    </div>
                                </div>
                            
                            </div>
                            
                            <div class="add__property--box ">
                                <h3 class="add__property--box__title mb-10">Property Document</h3>
                                <a  href="{{ route('user.properties.show', encrypt($transaction->property->id)) }}"  class="m-4 solid__btn ">
                                    View Property
                                </a>
                              
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
            <!-- dashboard container .\ -->

           
        </main>

    </div>
</div>
        
       

@endsection 
