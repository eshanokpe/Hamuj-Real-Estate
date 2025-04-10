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
                        <a 
                        style="max-width: 100%; width:200px; object-fit:contain"
                        href="{{ route('user.properties.history', encrypt($property->id)) }}"  class="mb-3 solid__btn add__property--btn ">
                            Property history
                        </a>
                        <a href="{{ route('user.properties.valuation', encrypt($property->id)) }}"  class="mb-3 solid__btn add__property--btn">
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
                             
                                <div class="row m-2">
                                    <div class="col-12">
                                        <div class="add__listing--google__map mb-10">
                                            <img 
                                            style="object-fit: contain"
                                            src="{{ asset($property->property_images) }}" />
                                        </div>
                                    </div>
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
                                            @if($property->valuationSummary)
                                                <input disabled value="₦{{ number_format($property->valuationSummary->initial_value_sum,2) }}" class="add__listing--input__field" id="input1" placeholder="Your Name" type="text">
                                            @else
                                                <input disabled value="₦{{ number_format($property->lunch_price,2) }}" class="add__listing--input__field" id="input1" placeholder="Your Name" type="text">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="add__listing--input__box mb-20">
                                            <label class="add__listing--input__label"> Current Price</label>
                                            @if($property->valuationSummary)
                                                <input disabled value="₦{{ number_format($property->valuationSummary->current_value_sum,2) }}" class="add__listing--input__field" id="input1" placeholder="Your Name" type="text" >
                                            @else
                                                <input disabled value="₦{{ number_format($property->price,2) }}" class="add__listing--input__field" id="input1" placeholder="Your Name" type="text" >
                                            @endif
                                           
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
                                            <textarea disabled value="" class="add__listing--input__field" id="input4" rows="2">{{ $property->gazette_number}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="add__listing--input__box mb-20">
                                            <label class="add__listing--input__label"> Tenure Free</label>
                                            <input disabled value="{{ $property->tenure_free}}" class="add__listing--input__field" id="input4" placeholder="Description" type="text">
                                        </div>
                                    </div>
                                </div>
                            
                            </div>
                            <div class="add__property--box">
                                <h3 class="add__property--box__title mb-20">Location</h3>
                                <div class="row m-2">
                                    <div class="col-12">
                                        <div class="add__listing--input__box mb-20">
                                            <label class="add__listing--input__label" for="input5">Address</label>
                                            <input disabled value="{{ $property->location}}" class="add__listing--input__field" id="input5" placeholder="Your Name" type="text">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="add__listing--input__box mb-20">
                                            <label class="add__listing--input__label"> Country</label>
                                            <input disabled value="{{ $property->country}}" class="add__listing--input__field" id="input7"  type="text">
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <div class="add__listing--input__box mb-20">
                                            <label class="add__listing--input__label"> City</label>
                                            <input  disabled value="{{ $property->city }}" class="add__listing--input__field" id="neighborhood" type="text">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="add__listing--input__box mb-20">
                                            <label class="add__listing--input__label"> State</label>
                                            <input  disabled value="{{ $property->state }}" class="add__listing--input__field" id="neighborhood" type="text">
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-4">
                                        <div class="add__listing--input__box mb-20">
                                            <label class="add__listing--input__label" for="neighborhood">Neighborhood</label>
                                            <input class="add__listing--input__field" id="neighborhood" placeholder="Neighborhood" type="text">
                                        </div>
                                    </div>  --}}
                                    <div class="col-lg-3">
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
                                    
                                    <div class="col-12">
                                        <div class="add__listing--google__map mb-10">
                                            <iframe src="{{ $property->google_map}}" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                        </div>
                                    </div>
                
                                </div>
                            </div>
                            <div class="add__property--box">
                                <h3 class="add__property--box__title mb-20">Neighborhood</h3>
                                <div class="properties__floor--plans d-flex">
                                    <div class="row m-2">
                                        <ul class="nav nav-pills mb-3 floor__plans--tab__btn"  id="pills-tab" role="tablist">
                                            @foreach ($neighborhoods as $categoryName => $neighborhoodsList)
                                                <li class="nav-item" role="presentation">
                                                    <button 
                                                        class="nav-link {{ $loop->first ? 'active' : '' }}" 
                                                        id="pills-{{ Str::slug($categoryName) }}-tab" 
                                                        data-bs-toggle="pill" 
                                                        data-bs-target="#pills-{{ Str::slug($categoryName) }}" 
                                                        type="button" 
                                                        {{-- style="color: brown" --}}
                                                        role="tab" 
                                                        aria-controls="pills-{{ Str::slug($categoryName) }}" 
                                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                                        {{ $categoryName }}
                                                    </button>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content" id="pills-tabContent">
                                            @foreach ($neighborhoods as $categoryName => $neighborhoodsList)
                                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                                                    id="pills-{{ Str::slug($categoryName) }}" 
                                                    role="tabpanel" 
                                                    aria-labelledby="pills-{{ Str::slug($categoryName) }}-tab" 
                                                    tabindex="0">
                                                    <div class="properties__floor--plans__display">
                                                        <ul class="properties__floor--plans__info">
                                                            <p><b>Nearest Landmark</b></p>
                                                            @foreach ($neighborhoodsList as $neighborhood)
                                                                <li class=" d-flex justify-content-between">
                                                                    <span class="location__google--maps__info--title">{{ $neighborhood->neighborhood_name }}</span>
                                                                    <span class="location__google--maps__info--subtitle">Distance: {{ $neighborhood->distance }} miles</span>
                                                                </li>
                                                                <hr>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="add__property--box">
                                <h3 class="add__property--box__title mb-20">Property Document</h3>
                              
                                <div class="row m-2">
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
                                            <label class="add__listing--input__label" for="input5">Land Information certificate</label>
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
