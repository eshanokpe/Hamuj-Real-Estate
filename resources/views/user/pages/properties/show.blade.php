@extends('layouts.dashboard')


@section('content')

 
<div class="dashboard__page--wrapper">
    <!-- Dashboard sidebar .\ -->
    <div class="page__body--wrapper" id="dashbody__page--body__wrapper">
        
        <main class="main__content_wrapper">
            <!-- dashboard container -->
            <div class="dashboard__container add__property--container">
                <div class="row add__property--heading mb-30">
                    <h2 class="add__property--heading__title text-start">Show Property</h2>
                    <div class="add__property--heading__title text-end">
                        <a href="{{ route('user.properties.valuation', encrypt($property->id)) }}"  class="solid__btn add__property--btn">
                            Valuation
                        </a>
                        <a href="{{ route('user.properties') }}"  class="solid__btn add__property--btn">
                            Back
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="add__property--step__inner">
                            <div class="add__property--box mb-30">
                                <h3 class="add__property--box__title mb-20">View Property</h3>
                                <form class="add__property--form" action="#">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="add__listing--input__box mb-20">
                                                <label class="add__listing--input__label" for="input1">Title</label>
                                                <input disabled value="{{ $property->name }}" class="add__listing--input__field" id="input1" placeholder="Your Name" type="text">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="add__listing--textarea__box mb-15">
                                                <label class="add__listing--input__label" for="input2">Description</label>
                                                <p>{!! $property->description !!}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="add__listing--input__box mb-20">
                                                <label class="add__listing--input__label">Lunch Price</label>
                                                <input disabled value="{{ $property->lunch_price }}" class="add__listing--input__field" id="input1" placeholder="Your Name" type="text">
                                              
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="add__listing--input__box mb-20">
                                                <label class="add__listing--input__label"> Current Price</label>
                                                <input disabled value="{{ $property->price }}" class="add__listing--input__field" id="input1" placeholder="Your Name" type="text">
                                               
                                            </div>
                                        </div> 
                                        <div class="col-lg-4">
                                            <div class="add__listing--input__box mb-20">
                                                <label class="add__listing--input__label" for="input3">Price Increase (%)</label>
                                                <input disabled value="{{ $property->percentage_increase }}%" class="add__listing--input__field" id="input3" placeholder="Price" type="text">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="add__listing--input__box mb-20">
                                                <label class="add__listing--input__label" for="input4">Gazette Number</label>
                                                <input disabled value="{{ $property->gazette_number}}" class="add__listing--input__field" id="input4" placeholder="Description" type="text">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="add__listing--input__box mb-20">
                                                <label class="add__listing--input__label"> Tenure Free</label>
                                                <input disabled value="{{ $property->tenure_free}}" class="add__listing--input__field" id="input4" placeholder="Description" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="add__property--box">
                                <h3 class="add__property--box__title mb-20">Location</h3>
                                <form class="add__property--form" action="#">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="add__listing--input__box mb-20">
                                                <label class="add__listing--input__label" for="input5">Address</label>
                                                <input disabled value="{{ $property->location}}" class="add__listing--input__field" id="input5" placeholder="Your Name" type="text">
                                            </div>
                                        </div>
                                      
                                      
                                        <div class="col-lg-6">
                                            <div class="add__listing--input__box mb-20">
                                                <label class="add__listing--input__label"> City</label>
                                                <input  disabled value="{{ $property->city }}" class="add__listing--input__field" id="neighborhood" type="text">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="add__listing--input__box mb-20">
                                                <label class="add__listing--input__label" for="neighborhood">Neighborhood</label>
                                                <input class="add__listing--input__field" id="neighborhood" placeholder="Neighborhood" type="text">
                                            </div>
                                        </div> 
                                        <div class="col-lg-4">
                                            <div class="add__listing--input__box mb-20">
                                                <label class="add__listing--input__label" for="input7">SIZE(sqm)</label>
                                                <input 
                                                    disabled 
                                                    value="{{ $property->size === $property->available_size ? $property->size : $property->available_size }} sqm" 
                                                    class="add__listing--input__field" 
                                                    id="input7" 
                                                    type="text">
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4">
                                            <div class="add__listing--input__box mb-20">
                                                <label class="add__listing--input__label"> Country</label>
                                                <input disabled value="{{ $property->country}}" class="add__listing--input__field" id="input7"  type="text">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="add__listing--google__map mb-10">
                                                <iframe src="{{ $property->google_map}}" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="add__property--box">
                                <h3 class="add__property--box__title mb-20">Property Document</h3>
                                <form class="add__property--form" action="#">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="add__listing--input__box mb-20">
                                                <label class="add__listing--input__label" for="input5">Land Survey</label>
                                                @if(isset($property) && $property->land_survey)
                                                   
                                                    <!-- View and Download Links -->
                                                    <div class="mt-2">
                                                        <!-- View Button -->
                                                        <a href="{{ asset($property->land_survey) }}" target="_blank" class="solid__btn add__property--btn">
                                                            View Land Survey
                                                        </a>
                                        
                                                        <!-- Download Button -->
                                                        <a href="{{ asset($property->land_survey) }}" download="{{ $property->name }}-land-survey" class="solid__btn add__property--btn">
                                                            Download Land Survey
                                                        </a>
                                                    </div>
                                                @else
                                                    <p class="text-muted mt-2">No Land Survey available.</p>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="col-6">
                                            <div class="add__listing--input__box mb-20">
                                                <label class="add__listing--input__label" for="input5">Contract deed document</label>
                                                @if(isset($property) && $property->contract_deed)
                                                   
                                                    <!-- View and Download Links -->
                                                    <div class="mt-2">
                                                        <!-- View Button -->
                                                        <a href="{{ asset($property->contract_deed) }}" target="_blank" class="solid__btn add__property--btn">
                                                            View Contract deed
                                                        </a>
                                        
                                                        <!-- Download Button -->
                                                        <a href="{{ asset($property->contract_deed) }}" download="{{ $property->name }}-land-survey" class="solid__btn add__property--btn">
                                                            Download Contract deed
                                                        </a>
                                                    </div>
                                                @else
                                                    <p class="text-muted mt-2">No Land Survey available.</p>
                                                @endif
                                            </div>
                                        </div>

                                        
                                    </div>
                                </form>
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
