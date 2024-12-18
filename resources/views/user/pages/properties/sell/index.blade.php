@extends('layouts.dashboard')


@section('content')

<div class="page__body--wrapper" id="dashbody__page--body__wrapper">
   
    <main class="main__content_wrapper">
        <!-- dashboard container -->
        <div class="dashboard__container dashboard__reviews--container">
            <div class="reviews__heading mb-30">
                <h2 class="reviews__heading--title">Sell Property</h2>
                <p class="reviews__heading--desc">We are glad to see you again!</p>
            </div>
            <div class="properties__wrapper">
                <div class="properties__table table-responsive">
                    <table class="properties__table--wrapper">
                        <thead>
                            <tr>
                                <th>Listing Title</th>
                                <th>Date published</th>
                                <th>Acquired Size</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($buyProperty as $property)
                            <tr>
                                <td>
                                    <div class="properties__author d-flex align-items-center">
                                        <div class="properties__author--thumb">
                                            <img src="{{ asset($property->property->property_images) }}" alt="img" style="max-height: 100%; max-width:100%; width:70px; height:70px; object-fit:cover">
                                        </div>
                                        <div class="reviews__author--text">
                                            <h3 class="reviews__author--title">{{$property->property->name}}</h3>
                                            <p class="reviews__author--subtitle">{{$property->property->location}}</p>
                                            <span class="properties__author--price">₦{{ number_format($property->property->price, 2)}}</span>
                                            <p class="properties__author--price text-decoration-line-through text-muted">₦{{ number_format($property->property->lunch_price, 2)}}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="reviews__date">
                                        {{  \Carbon\Carbon::parse($property->latest_created_at)->format('d F, Y')  }} 
                                    </span>
                                </td>
                                <td> 
                                    <span class="properties__views">{{ $property->total_selected_size_land }} per/sqm</span>
                                </td>
                                <td>
                                    <span class="status__btn pending2"> 
                                        <a href="{{ route('user.properties.show', encrypt($property->property->id))}}">
                                        View</a>
                                    </span>
                                </td>
                                <td>
                                    
                                    <span class="status__btn pending2 " style="background-color: #47008E; ">
                                        <a class="text-white" href="{{ route('user.cart.sell.index', encrypt($property->property->id))}}">
                                        Sell</a>
                                    </span>
                                </td>
                              
                            </tr>
                            @empty
                               <tr><td> No Sell Property available </td></tr>
                            @endforelse
                           
                            
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="pagination__area">
                    <nav class="pagination justify-content-center">
                        <ul class="pagination__menu d-flex align-items-center justify-content-center">
                            <!-- Render pagination links dynamically -->
                            @if ($buyProperty->onFirstPage())
                                <li class="pagination__menu--items pagination__arrow disabled">
                                    <span class="pagination__arrow-icon">
                                        <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.583 20.5832L0.999675 10.9998L10.583 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </li>
                            @else
                                <li class="pagination__menu--items pagination__arrow">
                                    <a href="{{ $buyProperty->previousPageUrl() }}" class="pagination__arrow-icon link">
                                        <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.583 20.5832L0.999675 10.9998L10.583 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                </li>
                            @endif

                            <!-- Page numbers -->
                            @foreach ($buyProperty->links()->elements[0] as $page => $url)
                                <li class="pagination__menu--items">
                                    <a href="{{ $url }}" class="pagination__menu--link {{ $page == $buyProperty->currentPage() ? 'active color-accent-1' : '' }}">
                                        {{ $page }}
                                    </a>
                                </li>
                            @endforeach

                            @if ($buyProperty->hasMorePages())
                                <li class="pagination__menu--items pagination__arrow">
                                    <a href="{{ $buyProperty->nextPageUrl() }}" class="pagination__arrow-icon link">
                                        <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.00098 20.5832L10.5843 10.9998L1.00098 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                </li>
                            @else
                                <li class="pagination__menu--items pagination__arrow disabled">
                                    <span class="pagination__arrow-icon">
                                        <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.00098 20.5832L10.5843 10.9998L1.00098 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div> 
            </div>
        </div>
        <!-- dashboard container .\ -->

       
    </main>

</div>

@endsection 
