@extends('layouts.app')

@section('content')


<section class="listing__hero--section">
    <div class="listing__hero--section__inner position-relative">
        <div class="listing__hero--slider">
            <div class="swiper hero__swiper--column1 swiper-initialized swiper-horizontal swiper-pointer-events">
                <div class="swiper-wrapper" id="swiper-wrapper-d5456d1034876fc11" aria-live="polite" style="transform: translate3d(0px, 0px, 0px);">
                    <div class="swiper-slide swiper-slide-active" role="group" aria-label="1 / 4" style="width: 538px; margin-right: 20px;">
                      <div class=" listing__hero--slider__items position-relative">
                        <img class="listing__hero--slider__media" src="{{ asset($property->property_images) }}" alt="img">
                        <div class="listing__hero--slider__container">
                            <div class="container">
                            <!-- Hero Content -->
                            <div class="listing__hero--slider__content">
                                <div class="listing__hero--slider__content--top d-flex align-items-center justify-content-between">
                                    <h3 class="listing__hero--slider__title">{{ $property->name }}</h3>
                                    <span class="listing__hero--slider__price" style="color: #fff; front-size:26px">₦{{ number_format($property->price) }}</span>
                                </div>
                                <p class="listing__hero--slider__text"><svg width="11" height="17" viewBox="0 0 11 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.48287 0C2.45013 0 0 2.4501 0 5.48288C0 5.85982 0.0343013 6.21958 0.102785 6.57945C0.514031 9.69783 4.42055 11.9767 5.51712 16.4144C6.5966 12.0452 11 8.824 11 5.48288H10.9657C10.9657 2.45013 8.51548 0 5.48282 0H5.48287ZM5.48287 2.17592C7.21338 2.17592 8.61839 3.58097 8.61839 5.31144C8.61839 7.04191 7.21335 8.44696 5.48287 8.44696C3.7524 8.44696 2.34736 7.04191 2.34736 5.31144C2.34736 3.58097 3.75228 2.17592 5.48287 2.17592Z" fill="#FA4B4A"></path>
                                </svg>
                                {{ $property->location }}</p>
                            </div>
                            <!-- Hero Content .\ -->
                            </div>
                        </div>
                      </div>
                    </div>
                   
                   
                   
                </div>
            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
        </div>

        <!-- Hero swiper -->
        <div class="listing__small--hero__slider">
            <div class="swiper hero__swiper--column3 swiper-initialized swiper-horizontal swiper-pointer-events swiper-thumbs">
                   
            </div>
        </div>
        <!-- Hero swiper .\ -->
    </div>
</section>

<section class="listing__details--section section--padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="listing__details--wrapper">
                    <div class="listing__details--content">
                        <div class="listing__details--content__top mb-25 d-flex align-items-center justify-content-between">
                            <div class="listing__details--meta">
                                <ul class="listing__details--meta__wrapper d-flex align-items-center">
                                    <li><span class="listing__details--badge">Featured</span></li>
                                    <li><span class="listing__details--badge two">{{ ucfirst($property->status)}}</span></li>
                                    <li>
                                        <span class="listing__details--meta__icon">
                                            <svg width="13" height="15" viewBox="0 0 13 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 13.0469H3.25V10.7969H1V13.0469ZM3.75 13.0469H6.25V10.7969H3.75V13.0469ZM1 10.2969H3.25V7.79687H1V10.2969ZM3.75 10.2969H6.25V7.79687H3.75V10.2969ZM1 7.29687H3.25V5.04688H1V7.29687ZM6.75 13.0469H9.25V10.7969H6.75V13.0469ZM3.75 7.29687H6.25V5.04688H3.75V7.29687ZM9.75 13.0469H12V10.7969H9.75V13.0469ZM6.75 10.2969H9.25V7.79687H6.75V10.2969ZM4 3.54687V1.29687C4 1.22917 3.97396 1.17187 3.92188 1.125C3.875 1.07292 3.81771 1.04687 3.75 1.04687H3.25C3.18229 1.04687 3.1224 1.07292 3.07031 1.125C3.02344 1.17187 3 1.22917 3 1.29687V3.54687C3 3.61458 3.02344 3.67448 3.07031 3.72656C3.1224 3.77344 3.18229 3.79687 3.25 3.79687H3.75C3.81771 3.79687 3.875 3.77344 3.92188 3.72656C3.97396 3.67448 4 3.61458 4 3.54687ZM9.75 10.2969H12V7.79687H9.75V10.2969ZM6.75 7.29687H9.25V5.04688H6.75V7.29687ZM9.75 7.29687H12V5.04688H9.75V7.29687ZM10 3.54687V1.29687C10 1.22917 9.97396 1.17187 9.92188 1.125C9.875 1.07292 9.81771 1.04687 9.75 1.04687H9.25C9.18229 1.04687 9.1224 1.07292 9.07031 1.125C9.02344 1.17187 9 1.22917 9 1.29687V3.54687C9 3.61458 9.02344 3.67448 9.07031 3.72656C9.1224 3.77344 9.18229 3.79687 9.25 3.79687H9.75C9.81771 3.79687 9.875 3.77344 9.92188 3.72656C9.97396 3.67448 10 3.61458 10 3.54687ZM13 3.04687V13.0469C13 13.3177 12.901 13.5521 12.7031 13.75C12.5052 13.9479 12.2708 14.0469 12 14.0469H1C0.729167 14.0469 0.494792 13.9479 0.296875 13.75C0.0989583 13.5521 0 13.3177 0 13.0469V3.04687C0 2.77604 0.0989583 2.54167 0.296875 2.34375C0.494792 2.14583 0.729167 2.04687 1 2.04687H2V1.29687C2 0.953124 2.1224 0.658853 2.36719 0.414062C2.61198 0.16927 2.90625 0.046874 3.25 0.046874H3.75C4.09375 0.046874 4.38802 0.16927 4.63281 0.414062C4.8776 0.658853 5 0.953124 5 1.29687V2.04687H8V1.29687C8 0.953124 8.1224 0.658853 8.36719 0.414062C8.61198 0.16927 8.90625 0.046874 9.25 0.046874H9.75C10.0938 0.046874 10.388 0.16927 10.6328 0.414062C10.8776 0.658853 11 0.953124 11 1.29687V2.04687H12C12.2708 2.04687 12.5052 2.14583 12.7031 2.34375C12.901 2.54167 13 2.77604 13 3.04687Z" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                         <span class="listing__details--meta__text">Added on: {{  $property->created_at->format('d F, Y') }}</span>
                                    </li>
                                   
                                </ul>
                            </div>
                            <ul class="listing__details--action d-flex">
                               
                                @if($property->transaction == null || $property->$transaction->transaction_state != 'Buy')
                                    <li class="listing__details--action__list"> 
                                        <form action="{{ route('user.payment.initiate') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="property_state" value="Sell">
                                            <input type="hidden" name="email" value="{{ auth()->user()->email ?? '' }}">
                                            <input type="hidden" name="amount" value="{{ $property->price }}">
                                            <input type="hidden" name="property_name" value="{{ $property->name }}">
                                            <input type="hidden" name="property_id" value="{{ $property->id }}">
                                            <button class="listing__details--wishlist__btn" type="submit" style="background-color: #008000; color: #fff; border: none; padding: 10px 30px; cursor: pointer;">
                                                Buy
                                            </button>
                                        </form>
                                    </li> 
                                   
                                @else
                                    <li class="listing__details--action__list"> 
                                        <form action="{{ route('user.payment.initiate') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="property_state" value="Sell">
                                            <input type="hidden" name="email" value="{{ auth()->check() && auth()->user()->email ? auth()->user()->email : '' }}">

                                            <input type="hidden" name="amount" value="{{ $property->price }}">
                                            <input type="hidden" name="property_name" value="{{ $property->name  }}">
                                            <input type="hidden" name="property_id" value="{{ $property->id }}">
                                            <button class="listing__details--wishlist__btn" type="submit" style="background-color: #FF6347; color: #fff; border: none; padding: 10px 20px; cursor: pointer;">
                                                Sell
                                            </button>
                                        </form>
                                    </li>
                                    <li class="listing__details--action__list"> 
                                        <form action="{{ route('user.payment.initiate') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="property_state" value="Transfer">
                                            <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                            <input type="hidden" name="amount" value="{{ $property->price }}">
                                            <input type="hidden" name="property_name" value="{{ $property->name }}">
                                            <input type="hidden" name="property_id" value="{{ $property->id }}">
                                            <button class="listing__details--wishlist__btn" type="submit" style="background-color: #1E90FF; color: #fff; border: none; padding: 10px 40px; cursor: pointer;">
                                                Transfer
                                            </button>
                                        </form>
                                    </li>
                                @endif


                                    
                            </ul>
                        </div>
                        <div class="listing__details--content__step">
                            <h2 class="listing__details--title mb-25">{{ $property->name }}</h2>
                            <div class="listing__details--price__id d-flex align-items-center">
                                <div class="listing__details--price d-flex">
                                    <span class="listing__details--price__new">₦{{ number_format($property->price) }}</span>
                                    <span class="listing__details--price__old">₦{{ number_format($property->lunch_price) }}</span>
                                </div>
                                <span class="listing__details--property__id">Gazette Number: {{ $property->gazette_number}}</span>
                            </div>
                            <p class="listing__details--location__text"><svg width="11" height="17" viewBox="0 0 11 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.48287 0C2.45013 0 0 2.4501 0 5.48288C0 5.85982 0.0343013 6.21958 0.102785 6.57945C0.514031 9.69783 4.42055 11.9767 5.51712 16.4144C6.5966 12.0452 11 8.824 11 5.48288H10.9657C10.9657 2.45013 8.51548 0 5.48282 0H5.48287ZM5.48287 2.17592C7.21338 2.17592 8.61839 3.58097 8.61839 5.31144C8.61839 7.04191 7.21335 8.44696 5.48287 8.44696C3.7524 8.44696 2.34736 7.04191 2.34736 5.31144C2.34736 3.58097 3.75228 2.17592 5.48287 2.17592Z" fill="#FA4B4A"></path>
                                </svg>
                                 {{ ($property->location) }}
                            </p>
                        </div>
                    </div>
                    <div class="listing__details--main__content">
                        <div class="listing__details--content__step mb-80">
                            <h3 class="listing__details--content__title">Description:</h3>
                            <p class="listing__details--content__desc">
                                {!! ($property->description) !!}
                            </p>
                            <div class="apartment__info listing__d--info">
                                <div class="apartment__info--wrapper d-flex">
                                    
                                    <div class="apartment__info--list">
                                        <span class="apartment__info--icon"><img src="{{ asset('assets/img/icon/set-square.png')}}" alt="img"></span>
                                        <p>
                                            <span class="apartment__info--title">{{ ($property->size) }} Sqft</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="listing__details--content__step properties__info mb-80">
                            <h3 class="listing__details--content__title mb-40">Properties Details:</h3>
                            <ul class="properties__details--info__wrapper d-flex">
                                <li class="properties__details--info__list d-flex justify-content-between">
                                    <span class="properties__details--info__title">Price:</span>
                                    <span class="properties__details--info__subtitle">₦{{ number_format($property->price) }}</span>
                                </li>
                                <li class="properties__details--info__list d-flex justify-content-between">
                                    <span class="properties__details--info__title">Land Area Size:</span>
                                    <span class="properties__details--info__subtitle">{{ $property->size }} Sq Ft</span>
                                </li>
                                <li class="properties__details--info__list d-flex justify-content-between">
                                    <span class="properties__details--info__title">Tenure Free:</span>
                                    <span class="properties__details--info__subtitle">{{ $property->tenure_free }} </span>
                                </li>
                                
                            </ul>
                        </div>
                        
                        <div class="listing__details--content__step mb-80">
                            <div class="properties__floor--plans d-flex">
                                <div class="properties__floor--plans__content">
                                    <h3 class="listing__details--content__title mb-40">Land Survey</h3>
                                    <div class="properties__floor--plans__display">
                                        <img src="{{ asset($property->land_survey) }}" alt="img">
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <div class="listing__details--content__step mb-80">
                            <div class="listing__details--location__header d-flex justify-content-between mb-40">
                                <div class="listing__details--location__header--left">
                                    <h3 class="listing__details--content__title m-0">Location &amp; Google Maps</h3>
                                </div>
                                <div class="location__google--maps">
                                    <details>
                                        <summary>Open on Google Maps</summary>
                                        <iframe src="{{ $property->google_map}}" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                    </details>
                                </div>
                            </div>
                            <div class="location__google--maps__info d-flex">
                                <ul class="location__google--maps__info--step">
                                    <li class="location__google--maps__info--list d-flex">
                                        <span class="location__google--maps__info--title">Address:</span>
                                        <span class="location__google--maps__info--subtitle">{{ $property->location}}</span>
                                    </li>
                                    <li class="location__google--maps__info--list d-flex">
                                        <span class="location__google--maps__info--title">Country: </span>
                                        <span class="location__google--maps__info--subtitle">{{ $property->country}}</span>
                                    </li>
                                    
                                </ul>
                                <ul class="location__google--maps__info--step">
                                    <li class="location__google--maps__info--list d-flex">
                                        <span class="location__google--maps__info--title">City/Town:</span>
                                        <span class="location__google--maps__info--subtitle">Lekki</span>
                                    </li>
                                    <li class="location__google--maps__info--list d-flex">
                                        <span class="location__google--maps__info--title">Province/State: </span>
                                        <span class="location__google--maps__info--subtitle">{{ $property->city}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="listing__details--content__step mb-80">
                            <h3 class="listing__details--content__title mb-40">Video</h3>
                            <div class="listing__details--video__thumbnail position-relative">
                                <img src="{{ asset($property->property_images)}}" alt="img">
                                <div class="bideo__play">
                                    
                                    <a class="bideo__play--icon glightbox" target="_blank" href="{{ $property->video_link }}">
                                        <svg width="13" height="17" viewBox="0 0 13 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.9358 7.28498C12.5203 7.67662 12.5283 8.53339 11.9512 8.93591L1.99498 15.8809C1.33555 16.3409 0.430441 15.8741 0.422904 15.0701L0.294442 1.36797C0.286904 0.563996 1.1831 0.0802964 1.85104 0.527837L11.9358 7.28498Z" fill="currentColor"></path>
                                        </svg> 
                                        <span class="visually-hidden">Video Play</span>
                                    </a>
                                    
                                </div>
                            </div>
                        </div>
                       
                      
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="listing__widget">
                    
                    
                    <div class="widget__step mb-30">
                        <h2 class="widget__step--title">Property History</h2>
                        <div class="widget__form">
                            <form action="#">
                                <div class="widget__form--input mb-20">
                                    <input class="widget__form--input__field" placeholder="Full name" type="text">
                                </div>
                                <div class="widget__form--input mb-20">
                                    <input class="widget__form--input__field" placeholder="Phone Number" type="text">
                                </div>
                                <div class="widget__form--input mb-20">
                                    <input class="widget__form--input__field" placeholder="Email Address" type="email">
                                </div>
                                <div class="widget__form--input">
                                    <textarea class="widget__form--textarea__field" placeholder="Write You Messege"></textarea>
                                </div>
                                <button class="widget__form--btn solid__btn" type="submit">Send Messege</button>
                            </form>
                        </div>
                    </div>

                    <div class="widget__step">
                        <h2 class="widget__step--title">Property Items</h2>
                        <div class="widget__featured">
                            @forelse ($recentProperties as $recentProperty)
                                <div class="widget__featured--items d-flex">
                                    <div class="widget__featured--thumb">
                                        <a class="widget__featured--thumb__link" href="{{ route('home.properties.show',  $recentProperty->slug ) }}">
                                            <img style="max-width: 100%; max-height: 100%;  width: 96%; height: 86%; object-fit: cover;"
                                            class="widget__featured--media" src="{{asset($recentProperty->property_images)}}" alt="img">
                                        </a>
                                    </div>
                                    <div class="widget__featured--content">
                                        <h3 class="widget__featured--title">
                                            <a href="./listing-details.html">
                                                {{$recentProperty->name}}
                                            </a></h3>
                                        <span class="widget__featured--price">₦{{ number_format($recentProperty->price) }}</span>
                                    </div>
                                </div>
                            @empty
                                <p>No data available</p>
                            @endforelse
                           
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection