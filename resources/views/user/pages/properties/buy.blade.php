@extends('layouts.dashboard')


@section('content')

<div class="page__body--wrapper" id="dashbody__page--body__wrapper">
   
    <main class="main__content_wrapper">
        <!-- dashboard container -->
        <div class="dashboard__container dashboard__reviews--container">
            <div class="reviews__heading mb-30">
                <h2 class="reviews__heading--title">My Properties</h2>
                <p class="reviews__heading--desc">We are glad to see you again!</p>
            </div>
            <div class="properties__wrapper">
                <div class="properties__table table-responsive">
                    <table class="properties__table--wrapper">
                        <thead>
                            <tr>
                                <th>Listing Title</th>
                                <th>Date published</th>
                                <th><span class="min-w-100">Status</span></th>
                                <th>Actual Size</th>
                                <th>Available Size</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($properties as $property)
                            <tr>
                                <td>
                                    <div class="properties__author d-flex align-items-center">
                                        <div class="properties__author--thumb">
                                            <img src="{{ asset($property->property_images) }}" alt="img" style="max-height: 100%; max-width:100%; width:70px; height:70px; object-fit:cover">
                                        </div>
                                        <div class="reviews__author--text">
                                            <h3 class="reviews__author--title">{{$property->name}}</h3>
                                            <p class="reviews__author--subtitle">{{$property->location}}</p>
                                            <span class="properties__author--price">₦{{ number_format($property->price, 2)}}</span>
                                            <p class="properties__author--price text-decoration-line-through text-muted">₦{{ number_format($property->lunch_price, 2)}}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="reviews__date">{{  $property->created_at->format('d F, Y') }} </span>
                                </td>
                                <td>
                                    <span class="status__btn pending">{{  ucFirst($property->status) }}</span>
                                </td>
                                <td>
                                    <span class="properties__views">{{ $property->size }}</span>
                                </td>
                                <td>
                                    <span class="properties__views">{{ $property->size }}</span>
                                </td>
                                <td>
                                    <div class="reviews__action--wrapper position-relative">
                                        <button class="reviews__action--btn" aria-label="action button" type="button" aria-expanded="true" data-bs-toggle="dropdown"><svg width="3" height="17" viewBox="0 0 3 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="1.5" cy="1.5" r="1.5" fill="currentColor"/>
                                            <circle cx="1.5" cy="8.5" r="1.5" fill="currentColor"/>
                                            <circle cx="1.5" cy="15.5" r="1.5" fill="currentColor"/>
                                            </svg>
                                        </button>
                                        <ul class="dropdown-menu sold-out__user--dropdown " data-popper-placement="bottom-start">
                                            <li><a data-bs-toggle="modal" href="#">Edit</a></li>
                                            <li><a data-bs-toggle="modal" href="#">Remove</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <p>No Properties available</p>
                            @endforelse
                           
                            
                        </tbody>
                    </table>
                </div>
                <div class="pagination__area">
                    <nav class="pagination justify-content-center">
                        <ul class="pagination__menu d-flex align-items-center justify-content-center">
                            <li class="pagination__menu--items pagination__arrow d-flex">
                                <a href="#" class="pagination__arrow-icon link">
                                    <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.583 20.5832L0.999675 10.9998L10.583 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>                                                    
                                    <span class="visually-hidden">page left arrow</span>
                                </a>
                                <span class="pagination__arrow-icon">
                                    <svg width="3" height="22" viewBox="0 0 3 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.50098 1L1.50098 21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <a href="#" class="pagination__arrow-icon link">
                                    <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.001 20.5832L1.41764 10.9998L11.001 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>                                                                                                        
                                    <span class="visually-hidden">page left arrow</span>
                                </a>
                            </li>
                            <li class="pagination__menu--items"><a href="#" class="pagination__menu--link">01</a></li>
                            <li class="pagination__menu--items"><a href="#" class="pagination__menu--link active color-accent-1">02</a></li>
                            <li class="pagination__menu--items"><a href="#" class="pagination__menu--link">03</a></li>
                            <li class="pagination__menu--items pagination__arrow d-flex">
                                <a href="#" class="pagination__arrow-icon link">
                                    <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.00098 20.5832L10.5843 10.9998L1.00098 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>                                                                                                      
                                    <span class="visually-hidden">page right arrow</span>
                                </a>
                                <span class="pagination__arrow-icon">
                                    <svg width="3" height="22" viewBox="0 0 3 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.50098 1L1.50098 21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <a href="#" class="pagination__arrow-icon link">
                                    <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.41895 20.5832L11.0023 10.9998L1.41895 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>                                                                                                         
                                    <span class="visually-hidden">page right arrow</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- dashboard container .\ -->

       
    </main>

</div>

@endsection 
