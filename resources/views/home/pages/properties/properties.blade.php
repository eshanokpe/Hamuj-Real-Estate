@extends('layouts.app')

@section('content')

    <div>
        <section class="breadcrumb__section section--padding">
            <div class="container">
                <div class="breadcrumb__content text-center aos-init aos-animate" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="100">
                    <h1 class="breadcrumb__title h2"><span>Properties</span> </h1>
                    <ul class="breadcrumb__menu d-flex justify-content-center">
                        <li class="breadcrumb__menu--items"><a class="breadcrumb__menu--link" href="./index.html">Home</a></li>
                        <li><span><svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.22321 4.65179C5.28274 4.71131 5.3125 4.77976 5.3125 4.85714C5.3125 4.93452 5.28274 5.00298 5.22321 5.0625L1.0625 9.22321C1.00298 9.28274 0.934524 9.3125 0.857143 9.3125C0.779762 9.3125 0.71131 9.28274 0.651786 9.22321L0.205357 8.77679C0.145833 8.71726 0.116071 8.64881 0.116071 8.57143C0.116071 8.49405 0.145833 8.4256 0.205357 8.36607L3.71429 4.85714L0.205357 1.34821C0.145833 1.28869 0.116071 1.22024 0.116071 1.14286C0.116071 1.06548 0.145833 0.997023 0.205357 0.9375L0.651786 0.491071C0.71131 0.431547 0.779762 0.401785 0.857143 0.401785C0.934524 0.401785 1.00298 0.431547 1.0625 0.491071L5.22321 4.65179Z" fill="#706C6C"></path>
                            </svg>
                            </span></li>
                        <li><span class="breadcrumb__menu--text">Properties  </span></li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="listing__page--section section--padding">
            <div class="container">
                <div class="row column-reverse-md">
                    <div class="col-lg-4">
                        <div class="listing__widget">
                            <div class="widget__search mb-30 aos-init aos-animate" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="100">
                                <div class="widget__search--input position-relative">
                                    <input class="widget__search--input__field" placeholder="Search product" type="text" />
                                    <button class="widget__search--btn"><svg width="16" height="17" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.10714 9.54464C9.89286 8.75893 10.2857 7.81548 10.2857 6.71429C10.2857 5.61309 9.89286 4.67262 9.10714 3.89286C8.32738 3.10714 7.38691 2.71428 6.28571 2.71428C5.18452 2.71428 4.24107 3.10714 3.45536 3.89286C2.6756 4.67262 2.28571 5.61309 2.28571 6.71429C2.28571 7.81548 2.6756 8.75893 3.45536 9.54464C4.24107 10.3244 5.18452 10.7143 6.28571 10.7143C7.38691 10.7143 8.32738 10.3244 9.10714 9.54464ZM14.8571 14.1429C14.8571 14.4524 14.744 14.7202 14.5179 14.9464C14.2917 15.1726 14.0238 15.2857 13.7143 15.2857C13.3929 15.2857 13.125 15.1726 12.9107 14.9464L9.84822 11.8929C8.78274 12.631 7.59524 13 6.28571 13C5.43452 13 4.61905 12.8363 3.83929 12.5089C3.06548 12.1756 2.39583 11.7292 1.83036 11.1696C1.27083 10.6042 0.824405 9.93452 0.491071 9.16071C0.16369 8.38095 0 7.56548 0 6.71429C0 5.86309 0.16369 5.05059 0.491071 4.27678C0.824405 3.49702 1.27083 2.82738 1.83036 2.26786C2.39583 1.70238 3.06548 1.25595 3.83929 0.928571C4.61905 0.595237 5.43452 0.428571 6.28571 0.428571C7.13691 0.428571 7.94941 0.595237 8.72322 0.928571C9.50298 1.25595 10.1726 1.70238 10.7321 2.26786C11.2976 2.82738 11.744 3.49702 12.0714 4.27678C12.4048 5.05059 12.5714 5.86309 12.5714 6.71429C12.5714 8.02381 12.2024 9.21131 11.4643 10.2768L14.5268 13.3393C14.747 13.5595 14.8571 13.8274 14.8571 14.1429Z" fill="currentColor"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="listing__widget--inner aos-init aos-animate" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="150">
                                
                                <div class="widget__list mb-40">
                                    <h2 class="widget__title mb-30">Price Filtering</h2>
                                    <div class="widget__price--filtering">
                                        <div class="price-input">
                                            <input type="number" class="input-min" value="250000"/>
                                            <div class="separator">-</div>
                                            <input type="number" class="input-max" value="750000"/>
                                        </div>
                                        <div class="price-slider">
                                            <div class="progress"></div>
                                        </div>
                                        <div class="range-input">
                                            <input type="range" class="range-min" min="1000" max="1000000" value="250000" step="10000"/>
                                            <input type="range" class="range-max" min="1000" max="1000000" value="750000" step="10000"/>
                                        </div>
                                        <button class="price__filtering--btn">Filter</button>
                                    </div>
                                </div>
                                

                                                           
                                <div class="widget__list mb-40">
                                @php
                                    $states = $recentProperties->pluck('state')->unique()->sort();
                                @endphp
                                    
                                    <h2 class="widget__title mb-30">Find By Location</h2>
                                    <ul class="widget__location">
                                        @foreach ($states as $index => $state)
                                            <li class="widget__location--list">
                                                <label class="widget__location--label" for="check{{ $index }}">{{ $state }}</label>
                                                <input class="widget__catagories--input state-filter" id="check{{ $index }}"  type="checkbox" name="filter_states[]" value="{{ $state }}"/>
                                               
                                                <span class="widget__catagories--checkmark"></span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="widget__list">
                                    <h2 class="widget__title mb-30">Featured Items</h2>
                                    <div class="widget__featured">
                                        @forelse ($properties as $recentProperty) 
                                            <div class="widget__featured--items d-flex">
                                                <div class="widget__featured--thumb">
                                                    <a class="widget__featured--thumb__link" href="#">
                                                    <img class="widget__featured--media" src="{{ asset($recentProperty->property_images) }}" alt="img"/>
                                                    </a>
                                                </div>
                                                <div class="widget__featured--content">
                                                    <h3 class="widget__featured--title"><a href="#">{{ ($recentProperty->name)}}</a></h3>
                                                    <span class="widget__featured--price">₦{{ number_format($recentProperty->price ?? 0, 2)}}</span>
                                                </div>
                                            </div>
                                        @empty
                                            <p>No recent properties available.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="listing__page--wrapper">
                            <div class="listing__header d-flex justify-content-between align-items-center aos-init aos-animate" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="50">
                                <div class="listing__header--left">
                                    <p class="results__cout--text">Showing 12 of 21 Results</p>
                                </div>
                                <div class="listing__header--right d-flex align-items-center">
                                    <div class="recently__select d-flex align-items-center">
                                        <span class="recently__select--icon"><svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.42426 9.76048L10.1339 12.6088C10.3985 12.8869 10.8273 12.8869 11.0919 12.6088L13.8016 9.76048C14.0661 9.48239 14.0661 9.03159 13.8016 8.7535C13.537 8.47541 13.1082 8.47541 12.8436 8.7535L11.2903 10.3862V0.712076C11.2903 0.318811 10.987 0 10.6129 0C10.2388 0 9.9355 0.318811 9.9355 0.712076V10.3862L8.38222 8.7535C8.11766 8.47541 7.68881 8.47541 7.42426 8.7535C7.1597 9.03159 7.1597 9.48239 7.42426 9.76048ZM3.86611 0.208562C3.60156 -0.0695178 3.17264 -0.0695178 2.90809 0.208562L0.19841 3.05687C-0.0661366 3.33495 -0.0661366 3.78581 0.19841 4.06389C0.462956 4.34197 0.891881 4.34197 1.15643 4.06389L2.70968 2.43118V12.1053C2.70968 12.4985 3.01297 12.8174 3.3871 12.8174C3.76123 12.8174 4.06452 12.4985 4.06452 12.1053V2.43118L5.6178 4.06389C5.88236 4.34197 6.31121 4.34197 6.57576 4.06389C6.84032 3.78581 6.84032 3.33495 6.57576 3.05687L3.86611 0.208562Z" fill="currentColor"></path>
                                            </svg>
                                            </span>
                                        <div class="select">
                                            <select>
                                                <option selected="" value="1">Recently Added</option>
                                                <option value="2">Newest</option>
                                                <option value="3">Best Seller</option>
                                                <option value="4">Best Match</option>
                                                <option value="5">Price Low</option>
                                                <option value="6">Price High</option>
                                            </select>
                                        </div>
                                    </div>
                                    <ul class="nav listing__tab--btn">
                                        <li class="nav-item listing__tab--btn__list">
                                            <button class="listing__tab--btn__field " data-bs-toggle="tab" data-bs-target="#list" type="button"> <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_393_19356)">
                                                <path d="M19.9528 18.125H5.91016C5.33139 18.125 4.8623 17.6559 4.8623 17.0771C4.8623 16.4984 5.33139 16.0293 5.91016 16.0293H19.9524C20.5312 16.0293 21.0003 16.4984 21.0003 17.0771C21.0003 17.6559 20.5315 18.125 19.9528 18.125Z" fill="currentColor"></path>
                                                <path d="M19.9528 11.5479H5.91016C5.33139 11.5479 4.8623 11.0788 4.8623 10.5C4.8623 9.92124 5.33139 9.45215 5.91016 9.45215H19.9524C20.5312 9.45215 21.0003 9.92124 21.0003 10.5C21.0006 11.0788 20.5315 11.5479 19.9528 11.5479Z" fill="currentColor"></path>
                                                <path d="M19.9528 4.9707H5.91016C5.33139 4.9707 4.8623 4.50162 4.8623 3.92285C4.8623 3.34409 5.33139 2.875 5.91016 2.875H19.9524C20.5312 2.875 21.0003 3.34409 21.0003 3.92285C21.0003 4.50162 20.5315 4.9707 19.9528 4.9707Z" fill="currentColor"></path>
                                                <path d="M1.40726 5.41121C2.18448 5.41121 2.81453 4.78116 2.81453 4.00394C2.81453 3.22673 2.18448 2.59668 1.40726 2.59668C0.630054 2.59668 0 3.22673 0 4.00394C0 4.78116 0.630054 5.41121 1.40726 5.41121Z" fill="currentColor"></path>
                                                <path d="M1.40726 11.9073C2.18448 11.9073 2.81453 11.2772 2.81453 10.5C2.81453 9.72283 2.18448 9.09277 1.40726 9.09277C0.630054 9.09277 0 9.72283 0 10.5C0 11.2772 0.630054 11.9073 1.40726 11.9073Z" fill="currentColor"></path>
                                                <path d="M1.40726 18.4034C2.18448 18.4034 2.81453 17.7733 2.81453 16.9961C2.81453 16.2189 2.18448 15.5889 1.40726 15.5889C0.630054 15.5889 0 16.2189 0 16.9961C0 17.7733 0.630054 18.4034 1.40726 18.4034Z" fill="currentColor"></path>
                                                </g>
                                                <defs>
                                                <clipPath id="clip0_393_19356">
                                                <rect width="21" height="21" fill="white"></rect>
                                                </clipPath>
                                                </defs>
                                                </svg>                                                
                                            </button>
                                        </li>
                                        <li class="nav-item listing__tab--btn__list">
                                            <button class="listing__tab--btn__field active" data-bs-toggle="tab" data-bs-target="#grid" type="button">
                                                <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6.15776 0H2.06224C0.925133 0 0 0.972462 0 2.16775V6.47278C0 7.66806 0.925133 8.64052 2.06224 8.64052H6.15776C7.29487 8.64052 8.22 7.66806 8.22 6.47278V2.16775C8.22 0.972462 7.29487 0 6.15776 0ZM6.82678 6.47278C6.82678 6.86054 6.52665 7.17603 6.15776 7.17603H2.06224C1.69335 7.17603 1.39322 6.86054 1.39322 6.47278V2.16775C1.39322 1.77998 1.69335 1.4645 2.06224 1.4645H6.15776C6.52665 1.4645 6.82678 1.77998 6.82678 2.16775V6.47278Z" fill="currentColor"></path>
                                                    <path d="M16.9114 0H12.8711C11.7187 0 10.7812 0.985459 10.7812 2.19674V6.44378C10.7812 7.65506 11.7187 8.64052 12.8711 8.64052H16.9114C18.0638 8.64052 19.0013 7.65506 19.0013 6.44378V2.19674C19.0013 0.985459 18.0638 0 16.9114 0ZM17.608 6.44378C17.608 6.84754 17.2955 7.17603 16.9114 7.17603H12.8711C12.487 7.17603 12.1745 6.84754 12.1745 6.44378V2.19674C12.1745 1.79298 12.487 1.4645 12.8711 1.4645H16.9114C17.2955 1.4645 17.608 1.79298 17.608 2.19674V6.44378Z" fill="currentColor"></path>
                                                    <path d="M6.15776 11.333H2.06224C0.925133 11.333 0 12.3055 0 13.5008V17.8058C0 19.0011 0.925133 19.9735 2.06224 19.9735H6.15776C7.29487 19.9735 8.22 19.0011 8.22 17.8058V13.5008C8.22 12.3055 7.29487 11.333 6.15776 11.333ZM6.82678 17.8058C6.82678 18.1935 6.52665 18.509 6.15776 18.509H2.06224C1.69335 18.509 1.39322 18.1935 1.39322 17.8058V13.5008C1.39322 13.113 1.69335 12.7975 2.06224 12.7975H6.15776C6.52665 12.7975 6.82678 13.113 6.82678 13.5008V17.8058Z" fill="currentColor"></path>
                                                    <path d="M16.9114 11.333H12.8711C11.7187 11.333 10.7812 12.3185 10.7812 13.5298V17.7768C10.7812 18.9881 11.7187 19.9735 12.8711 19.9735H16.9114C18.0638 19.9735 19.0013 18.9881 19.0013 17.7768V13.5298C19.0013 12.3185 18.0638 11.333 16.9114 11.333ZM17.608 17.7768C17.608 18.1805 17.2955 18.509 16.9114 18.509H12.8711C12.487 18.509 12.1745 18.1805 12.1745 17.7768V13.5298C12.1745 13.126 12.487 12.7975 12.8711 12.7975H16.9114C17.2955 12.7975 17.608 13.126 17.608 13.5298V17.7768Z" fill="currentColor"></path>
                                                    </svg>
                                                </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="listing__main--content">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="grid">
                                        <div class="listing__featured--grid">
                                            <div class="row mb--n30">
                                            @forelse ($properties as $recentProperty) 
                                                                
                                                <div class="col-lg-6 col-md-6 col-sm-6 mb-30 aos-init aos-animate single-property" data-price="{{ $recentProperty->price }}" data-state="{{ $recentProperty->state }}" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="50">
                                                    
                                                    <article class="featured__card">
                                                        <div class="featured__thumbnail position-relative">
                                                            <div class="media">
                                                                <a class="featured__thumbnail--link" href="{{ route('home.properties.show',  $recentProperty->slug ) }}">
                                                                <img class="featured__thumbnail--img" src="{{ asset($recentProperty->property_images) }}" alt="featured-img"/></a>
                                                            </div>
                                                            <div class="featured__badge">
                                                                <span class="badge__field">Featured</span>
                                                                <span class="badge__field style2">{{ ($recentProperty->status)}}</span>
                                                            </div>
                                                            <ul class="featured__action">
                                                                <li class="featured__action--items"><a class="featured__action--btn glightbox" data-gallery="properties-view" href="{{ asset($recentProperty->property_images) }}"><svg width="19" height="17" viewBox="0 0 19 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.86602 0.959347L6.59306 2.05356C6.5221 2.33542 6.26879 2.53289 5.97872 2.53289H3.40635C1.82698 2.53289 0.488211 3.69753 0.270403 5.26159C0.269837 5.26413 0.269837 5.26668 0.269131 5.26922C-0.0911809 8.0949 -0.0911807 10.9147 0.278036 13.7304C0.278601 13.7322 0.278601 13.7342 0.278601 13.7355C0.497137 15.2952 1.83069 16.456 3.40564 16.456C6.56124 16.4649 12.4368 16.4649 15.5941 16.4649C17.1741 16.4649 18.5122 15.301 18.7306 13.7362C18.7306 13.7337 18.7312 13.7311 18.7312 13.7286C19.0909 10.908 19.0915 8.08816 18.7217 5.26813C18.7217 5.26629 18.7217 5.26502 18.7211 5.26304C18.5039 3.70332 17.1696 2.54252 15.5953 2.54183C15.1419 2.53293 14.6789 2.53293 14.2889 2.53293C13.9983 2.53293 13.745 2.33532 13.674 2.0536L13.4011 0.959383C13.2599 0.395811 12.7533 0 12.1719 0H8.09506C7.51368 0 7.00707 0.395811 6.86583 0.959383L6.86602 0.959347ZM10.1337 4.43284C7.33786 4.43284 5.06757 6.70312 5.06757 9.49898C5.06757 12.2948 7.33786 14.5651 10.1337 14.5651C12.9296 14.5651 15.1999 12.2948 15.1999 9.49898C15.1999 6.70312 12.9296 4.43284 10.1337 4.43284ZM10.1337 5.69938C12.2304 5.69938 13.9333 7.40229 13.9333 9.49898C13.9333 11.5957 12.2304 13.2986 10.1337 13.2986C8.03702 13.2986 6.33411 11.5957 6.33411 9.49898C6.33411 7.40229 8.03702 5.69938 10.1337 5.69938ZM10.1337 10.7655C9.43459 10.7655 8.86718 10.1981 8.86718 9.49898C8.86718 9.14941 8.58348 8.86572 8.23391 8.86572C7.88434 8.86572 7.60064 9.14941 7.60064 9.49898C7.60064 10.8973 8.73542 12.0321 10.1337 12.0321C10.4833 12.0321 10.767 11.7484 10.767 11.3988C10.767 11.0492 10.4833 10.7655 10.1337 10.7655ZM3.80104 6.33264H4.4343C4.78387 6.33264 5.06757 6.04895 5.06757 5.69938C5.06757 5.3498 4.78387 5.06611 4.4343 5.06611H3.80104C3.45146 5.06611 3.16777 5.3498 3.16777 5.69938C3.16777 6.04895 3.45146 6.33264 3.80104 6.33264Z" fill="currentColor"></path>
                                                                    </svg></a>
                                                                </li>
                                                                
                                                            </ul>
                                                        </div>
                                                        <div class="featured__content">
                                                            <div class="featured__content--top d-flex align-items-center justify-content-between">
                                                                <h3 class="featured__card--title"><a href="{{ route('home.properties.show',  $recentProperty->slug ) }}">{{ ($recentProperty->name)}}</a></h3>
                                                                <span class="featured__card--price">₦{{ number_format($recentProperty->price ?? 0, 2)}}</span>
                                                            </div>
                                                            <p class="featured__content--desc">
                                                                <svg width="11" height="17" viewBox="0 0 11 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M5.48287 0C2.45013 0 0 2.4501 0 5.48288C0 5.85982 0.0343013 6.21958 0.102785 6.57945C0.514031 9.69783 4.42055 11.9767 5.51712 16.4144C6.5966 12.0452 11 8.824 11 5.48288H10.9657C10.9657 2.45013 8.51548 0 5.48282 0H5.48287ZM5.48287 2.17592C7.21338 2.17592 8.61839 3.58097 8.61839 5.31144C8.61839 7.04191 7.21335 8.44696 5.48287 8.44696C3.7524 8.44696 2.34736 7.04191 2.34736 5.31144C2.34736 3.58097 3.75228 2.17592 5.48287 2.17592Z" fill="#F23B3B"></path>
                                                                </svg>
                                                                {{ ($recentProperty->location)}}
                                                            </p>
                                                            <ul class="featured__info d-flex">
                                                                
                                                                <li class="featured__info--items">
                                                                    <span class="featured__info--icon">
                                                                        {{ ($recentProperty->size)}}
                                                                        <svg width="19" height="20" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M17.8417 17.2754L0.685046 0.116923C0.569917 0.00263286 0.39646 -0.0311375 0.247421 0.0301228C0.097685 0.0938982 0 0.239308 0 0.401336L0.00181414 17.593C0.00181414 17.8144 0.178622 17.994 0.400928 17.994H17.5973C17.8196 17.994 18 17.8145 18 17.593C17.9997 17.4634 17.9371 17.3485 17.8419 17.2756L17.8417 17.2754ZM0.80258 17.1915V1.36951L2.73813 3.30506L1.77607 4.26741C1.62006 4.42384 1.62006 4.67906 1.77607 4.83525C1.85366 4.91284 1.95735 4.95289 2.06019 4.95289C2.16207 4.95289 2.26491 4.91284 2.3425 4.83525L3.30595 3.87265L5.02184 5.58868L4.0602 6.55113C3.90419 6.70854 3.90419 6.96168 4.0602 7.11783C4.13779 7.19639 4.24064 7.23547 4.34433 7.23547C4.44717 7.23547 4.55002 7.19625 4.62761 7.11783L5.58996 6.15677L7.29369 7.86011L6.33135 8.82396C6.17547 8.97956 6.17547 9.23407 6.33135 9.39094C6.41061 9.46937 6.5136 9.50858 6.61547 9.50858C6.71832 9.50858 6.82116 9.46937 6.89959 9.39094L7.86194 8.42835L9.56639 10.1331L8.60351 11.0957C8.4493 11.2517 8.4493 11.5062 8.60351 11.6631C8.68277 11.7415 8.78576 11.7807 8.88944 11.7807C8.99229 11.7807 9.09248 11.7415 9.17273 11.6621L10.1339 10.7001L11.8393 12.4053L10.8773 13.3677C10.7203 13.5237 10.7203 13.7782 10.8773 13.9342C10.9549 14.0136 11.0576 14.0531 11.1611 14.0531C11.2641 14.0531 11.3658 14.0139 11.4434 13.9342L12.4063 12.9726L14.1117 14.6779L13.1491 15.6395C12.9921 15.7945 12.9921 16.0492 13.1491 16.2083C13.2267 16.2859 13.3301 16.3241 13.433 16.3241C13.535 16.3241 13.6373 16.2859 13.7154 16.2083L14.6787 15.2454L16.625 17.1917L0.80258 17.1915Z" fill="black"></path>
                                                                            <path d="M3.52378 9.14585C3.40949 9.02946 3.23715 8.99583 3.08726 9.05821C2.93823 9.11961 2.83984 9.26544 2.83984 9.42871V14.7534C2.83984 14.9755 3.0193 15.1552 3.2416 15.1552H8.5717C8.794 15.1552 8.97442 14.9757 8.97442 14.7534C8.97442 14.6242 8.91176 14.5098 8.81673 14.4365L3.52378 9.14585ZM3.64324 14.353L3.64142 10.3976L7.59863 14.3534L3.64324 14.353Z" fill="black"></path>
                                                                            </svg>                                                          
                                                                    </span>
                                                                    <span class="featured__info--text">Square Meter</span>
                                                                </li>
                                                            </ul>

                                                            
                                                            
                                                        </div>
                                                    </article>
                                                </div>
                                                
                                            @empty
                                                <p>No recent properties available.</p>
                                            @endforelse
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade " id="list">
                                        @forelse ($properties as $recentProperty) 
                                            <div class="listing__featured--list">
                                                <article class="featured__card--list d-flex align-items-center mb-30">
                                                    <div class="listing__featured--thumbnail position-relative">
                                                        <div class="media">
                                                            <a class="featured__thumbnail--link" href="#">
                                                            <img class="featured__thumbnail--img" src="{{ asset($recentProperty->property_images) }}" alt="featured-img"/></a>
                                                        </div>
                                                        <div class="featured__badge">
                                                            <span class="badge__field style2">{{ ($recentProperty->status)}}</span>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="listing__featured--content">
                                                        <div class="featured__content--list__top d-flex justify-content-between">
                                                            <h3 class="featured__card--title"><a href="#">{{ ($recentProperty->name)}}</a></h3>
                                                            <ul class="featured__list--action d-flex">
                                                                <li class="featured__share--btn__list">
                                                                    <a class="featured__share--btn" href="listing.html">
                                                                        <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M7.5 13.3452C7.28645 13.3452 7.08057 13.2678 6.92013 13.1273C6.31416 12.5974 5.72994 12.0995 5.2145 11.6603L5.21187 11.658C3.70068 10.3702 2.39571 9.25804 1.48773 8.1625C0.472755 6.93775 0 5.77652 0 4.50794C0 3.27541 0.42263 2.13833 1.18996 1.306C1.96644 0.463829 3.03188 0 4.19037 0C5.05623 0 5.84919 0.273743 6.54716 0.81356C6.89941 1.08604 7.2187 1.41953 7.5 1.80851C7.78141 1.41953 8.10059 1.08604 8.45295 0.81356C9.15092 0.273743 9.94389 0 10.8097 0C11.9681 0 13.0337 0.463829 13.8102 1.306C14.5775 2.13833 15 3.27541 15 4.50794C15 5.77652 14.5274 6.93775 13.5124 8.16238C12.6044 9.25804 11.2996 10.3701 9.78859 11.6578C9.27223 12.0977 8.6871 12.5964 8.07976 13.1275C7.91943 13.2678 7.71343 13.3452 7.5 13.3452ZM4.19037 0.878677C3.28022 0.878677 2.44411 1.24191 1.83586 1.90155C1.21857 2.57114 0.878563 3.49674 0.878563 4.50794C0.878563 5.57487 1.2751 6.52908 2.16419 7.60185C3.02353 8.6388 4.30172 9.72805 5.78167 10.9893L5.78442 10.9916C6.3018 11.4325 6.88831 11.9324 7.49874 12.4662C8.11283 11.9314 8.70026 11.4307 9.21867 10.9891C10.6985 9.72782 11.9766 8.6388 12.8359 7.60185C13.7249 6.52908 14.1214 5.57487 14.1214 4.50794C14.1214 3.49674 13.7814 2.57114 13.1641 1.90155C12.556 1.24191 11.7198 0.878677 10.8097 0.878677C10.143 0.878677 9.53087 1.09062 8.99036 1.50856C8.50868 1.88118 8.17314 2.35222 7.97642 2.68181C7.87525 2.8513 7.69718 2.95246 7.5 2.95246C7.30282 2.95246 7.12475 2.8513 7.02358 2.68181C6.82697 2.35222 6.49143 1.88118 6.00964 1.50856C5.46913 1.09062 4.85699 0.878677 4.19037 0.878677Z" fill="currentColor"></path>
                                                                            </svg>                                                                                                                          
                                                                        <span class="visually-hidden">Wishlist</span>
                                                                    </a>
                                                                </li>
                                                                
                                                                
                                                            </ul>
                                                        </div>
                                                        <span class="featured__card--price">₦{{ number_format($recentProperty->price ?? 0, 2)}}</span>
                                                        <ul class="listing__featured--info d-flex">
                                                            <li class="listing__featured--info__items">
                                                                <span class="listing__featured--info__icon">
                                                                    <svg width="19" height="20" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M17.8417 17.2754L0.685046 0.116923C0.569917 0.00263286 0.39646 -0.0311375 0.247421 0.0301228C0.097685 0.0938982 0 0.239308 0 0.401336L0.00181414 17.593C0.00181414 17.8144 0.178622 17.994 0.400928 17.994H17.5973C17.8196 17.994 18 17.8145 18 17.593C17.9997 17.4634 17.9371 17.3485 17.8419 17.2756L17.8417 17.2754ZM0.80258 17.1915V1.36951L2.73813 3.30506L1.77607 4.26741C1.62006 4.42384 1.62006 4.67906 1.77607 4.83525C1.85366 4.91284 1.95735 4.95289 2.06019 4.95289C2.16207 4.95289 2.26491 4.91284 2.3425 4.83525L3.30595 3.87265L5.02184 5.58868L4.0602 6.55113C3.90419 6.70854 3.90419 6.96168 4.0602 7.11783C4.13779 7.19639 4.24064 7.23547 4.34433 7.23547C4.44717 7.23547 4.55002 7.19625 4.62761 7.11783L5.58996 6.15677L7.29369 7.86011L6.33135 8.82396C6.17547 8.97956 6.17547 9.23407 6.33135 9.39094C6.41061 9.46937 6.5136 9.50858 6.61547 9.50858C6.71832 9.50858 6.82116 9.46937 6.89959 9.39094L7.86194 8.42835L9.56639 10.1331L8.60351 11.0957C8.4493 11.2517 8.4493 11.5062 8.60351 11.6631C8.68277 11.7415 8.78576 11.7807 8.88944 11.7807C8.99229 11.7807 9.09248 11.7415 9.17273 11.6621L10.1339 10.7001L11.8393 12.4053L10.8773 13.3677C10.7203 13.5237 10.7203 13.7782 10.8773 13.9342C10.9549 14.0136 11.0576 14.0531 11.1611 14.0531C11.2641 14.0531 11.3658 14.0139 11.4434 13.9342L12.4063 12.9726L14.1117 14.6779L13.1491 15.6395C12.9921 15.7945 12.9921 16.0492 13.1491 16.2083C13.2267 16.2859 13.3301 16.3241 13.433 16.3241C13.535 16.3241 13.6373 16.2859 13.7154 16.2083L14.6787 15.2454L16.625 17.1917L0.80258 17.1915Z" fill="black"></path>
                                                                        <path d="M3.52378 9.14585C3.40949 9.02946 3.23715 8.99583 3.08726 9.05821C2.93823 9.11961 2.83984 9.26544 2.83984 9.42871V14.7534C2.83984 14.9755 3.0193 15.1552 3.2416 15.1552H8.5717C8.794 15.1552 8.97442 14.9757 8.97442 14.7534C8.97442 14.6242 8.91176 14.5098 8.81673 14.4365L3.52378 9.14585ZM3.64324 14.353L3.64142 10.3976L7.59863 14.3534L3.64324 14.353Z" fill="black"></path>
                                                                        </svg>                                                         
                                                                </span>
                                                                <span class="listing__featured--info__text"> {{ ($recentProperty->size)}} SQM</span>
                                                            </li>
                                                        </ul>
                                                        <div class="featured__content--list__footer d-flex justify-content-between">
                                                            <p class="featured__content--desc listing__style m-0"><svg width="11" height="17" viewBox="0 0 11 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M5.48287 0C2.45013 0 0 2.4501 0 5.48288C0 5.85982 0.0343013 6.21958 0.102785 6.57945C0.514031 9.69783 4.42055 11.9767 5.51712 16.4144C6.5966 12.0452 11 8.824 11 5.48288H10.9657C10.9657 2.45013 8.51548 0 5.48282 0H5.48287ZM5.48287 2.17592C7.21338 2.17592 8.61839 3.58097 8.61839 5.31144C8.61839 7.04191 7.21335 8.44696 5.48287 8.44696C3.7524 8.44696 2.34736 7.04191 2.34736 5.31144C2.34736 3.58097 3.75228 2.17592 5.48287 2.17592Z" fill="#F23B3B"></path>
                                                                </svg>
                                                                {{ ($recentProperty->location)}}</p>
                                                            <a class="listing__details--btn" href="#"> Land Details</a>
                                                        </div>
                                                        
                                                    </div>
                                                </article>
                                            </div>
                                        @empty
                                            <p>No recent properties available.</p>
                                        @endforelse
                                    </div>
                                </div>
                                <div class="page__pagination--area">
                                    <ul class="page__pagination--wrapper d-flex justify-content-center">
                                        <!-- Previous Page Link -->
                                        @if ($properties->onFirstPage())
                                            <li class="page__pagination--list disabled">
                                                <a class="page__pagination--link" href="#" tabindex="-1" aria-disabled="true">
                                                    <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6 5.12695C5.73633 5.39062 5.73633 5.83008 6 6.12305L9.98438 10.1074C10.2773 10.3711 10.7168 10.3711 10.9805 10.1074L11.6543 9.43359C11.918 9.14062 11.918 8.70117 11.6543 8.4375L8.8125 5.5957L11.6543 2.7832C11.918 2.51953 11.918 2.08008 11.6543 1.78711L10.9805 1.14258C10.7168 0.849609 10.2773 0.849609 9.98437 1.14258L6 5.12695ZM0.375 6.12305L4.35938 10.1074C4.65234 10.3711 5.0918 10.3711 5.35547 10.1074L6.0293 9.43359C6.29297 9.16992 6.29297 8.70117 6.0293 8.4375L3.1875 5.625L6.0293 2.7832C6.29297 2.51953 6.29297 2.08008 6.0293 1.78711L5.35547 1.14258C5.0918 0.849609 4.62305 0.849609 4.35937 1.14258L0.375 5.12695C0.111328 5.39063 0.111328 5.83008 0.375 6.12305Z" fill="currentColor"></path>
                                                    </svg>
                                                </a>
                                            </li>
                                        @else
                                            <li class="page__pagination--list">
                                                <a class="page__pagination--link" href="{{ $properties->previousPageUrl() }}">
                                                    <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6 5.12695C5.73633 5.39062 5.73633 5.83008 6 6.12305L9.98438 10.1074C10.2773 10.3711 10.7168 10.3711 10.9805 10.1074L11.6543 9.43359C11.918 9.14062 11.918 8.70117 11.6543 8.4375L8.8125 5.5957L11.6543 2.7832C11.918 2.51953 11.918 2.08008 11.6543 1.78711L10.9805 1.14258C10.7168 0.849609 10.2773 0.849609 9.98437 1.14258L6 5.12695ZM0.375 6.12305L4.35938 10.1074C4.65234 10.3711 5.0918 10.3711 5.35547 10.1074L6.0293 9.43359C6.29297 9.16992 6.29297 8.70117 6.0293 8.4375L3.1875 5.625L6.0293 2.7832C6.29297 2.51953 6.29297 2.08008 6.0293 1.78711L5.35547 1.14258C5.0918 0.849609 4.62305 0.849609 4.35937 1.14258L0.375 5.12695C0.111328 5.39063 0.111328 5.83008 0.375 6.12305Z" fill="currentColor"></path>
                                                    </svg>
                                                </a>
                                            </li>
                                        @endif

                                        <!-- Page Number Links -->
                                        @foreach ($properties->getUrlRange(1, $properties->lastPage()) as $page => $url)
                                            <li class="page__pagination--list">
                                                <a class="page__pagination--link {{ $properties->currentPage() == $page ? 'active' : '' }}" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endforeach

                                        <!-- Next Page Link -->
                                        @if ($properties->hasMorePages())
                                            <li class="page__pagination--list">
                                                <a class="page__pagination--link" href="{{ $properties->nextPageUrl() }}">
                                                    <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6 5.87305C6.26367 5.60938 6.26367 5.16992 6 4.87695L2.01562 0.892578C1.72266 0.628906 1.2832 0.628906 1.01953 0.892578L0.345703 1.56641C0.0820312 1.85938 0.0820312 2.29883 0.345703 2.5625L3.1875 5.4043L0.345703 8.2168C0.0820312 8.48047 0.0820312 8.91992 0.345703 9.21289L1.01953 9.85742C1.2832 10.1504 1.72266 10.1504 2.01562 9.85742L6 5.87305ZM11.625 4.87695L7.64062 0.892578C7.34766 0.628906 6.9082 0.628906 6.64453 0.892578L5.9707 1.56641C5.70703 1.83008 5.70703 2.29883 5.9707 2.5625L8.8125 5.375L5.9707 8.2168C5.70703 8.48047 5.70703 8.91992 5.9707 9.21289L6.64453 9.85742C6.9082 10.1504 7.37695 10.1504 7.64062 9.85742L11.625 5.87305C11.8887 5.60938 11.8887 5.16992 11.625 4.87695Z" fill="currentColor"></path>
                                                    </svg>
                                                </a>
                                            </li>
                                        @else
                                            <li class="page__pagination--list disabled">
                                                <a class="page__pagination--link" href="#" tabindex="-1" aria-disabled="true">
                                                    <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6 5.87305C6.26367 5.60938 6.26367 5.16992 6 4.87695L2.01562 0.892578C1.72266 0.628906 1.2832 0.628906 1.01953 0.892578L0.345703 1.56641C0.0820312 1.85938 0.0820312 2.29883 0.345703 2.5625L3.1875 5.4043L0.345703 8.2168C0.0820312 8.48047 0.0820312 8.91992 0.345703 9.21289L1.01953 9.85742C1.2832 10.1504 1.72266 10.1504 2.01562 9.85742L6 5.87305ZM11.625 4.87695L7.64062 0.892578C7.34766 0.628906 6.9082 0.628906 6.64453 0.892578L5.9707 1.56641C5.70703 1.83008 5.70703 2.29883 5.9707 2.5625L8.8125 5.375L5.9707 8.2168C5.70703 8.48047 5.70703 8.91992 5.9707 9.21289L6.64453 9.85742C6.9082 10.1504 7.37695 10.1504 7.64062 9.85742L11.625 5.87305C11.8887 5.60938 11.8887 5.16992 11.625 4.87695Z" fill="currentColor"></path>
                                                    </svg>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>

                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <script>
        document.querySelectorAll('.state-filter').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const selectedStates = Array.from(document.querySelectorAll('.state-filter:checked'))
                    .map(cb => cb.value);

                document.querySelectorAll('.single-property').forEach(function(property) {
                    const propertyState = property.getAttribute('data-state');

                    if (selectedStates.length === 0 || selectedStates.includes(propertyState)) {
                        property.style.display = '';
                    } else {
                        property.style.display = 'none';
                    }
                });
            });
        });
    </script>
    <script>
    const minInput = document.querySelector('.input-min');
    const maxInput = document.querySelector('.input-max');
    const rangeMin = document.querySelector('.range-min');
    const rangeMax = document.querySelector('.range-max');
    const filterBtn = document.querySelector('.price__filtering--btn');

    // Sync number inputs with sliders
    rangeMin.addEventListener('input', () => {
        minInput.value = rangeMin.value;
    });

    rangeMax.addEventListener('input', () => {
        maxInput.value = rangeMax.value;
    });

    minInput.addEventListener('input', () => {
        rangeMin.value = minInput.value;
    });

    maxInput.addEventListener('input', () => {
        rangeMax.value = maxInput.value;
    });

    // Filter on button click
    filterBtn.addEventListener('click', () => {
        const minPrice = parseInt(minInput.value);
        const maxPrice = parseInt(maxInput.value);

        document.querySelectorAll('.single-property').forEach(function(property) {
            const propertyPrice = parseInt(property.getAttribute('data-price'));

            if (propertyPrice >= minPrice && propertyPrice <= maxPrice) {
                property.style.display = '';
            } else {
                property.style.display = 'none';
            }
        });
    });
</script>



@endsection 