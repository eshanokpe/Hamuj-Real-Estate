@extends('layouts.dashboard')


@section('content')

<div class="page__body--wrapper" id="dashbody__page--body__wrapper">
   
    <main class="main__content_wrapper">
        <!-- dashboard container -->
        <div class="dashboard__container dashboard__reviews--container">
            <div class="reviews__heading mb-30">
                <h2 class="reviews__heading--title">Transfer History</h2>
                <p class="reviews__heading--desc">We are glad to see you again!</p>
            </div>
            <div class="properties__wrapper"> 
                <div class="properties__table table-responsive">
                    <table class="properties__table--wrapper">
                        <thead>
                            <tr>
                                <th>Listing Title</th>
                                <th>Date published</th>
                                <th>Size Land</th>
                                <th>View </th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transferProperty as $transfer)
                            <tr>
                                <td>
                                    <div class="properties__author d-flex align-items-center">
                                        <div class="properties__author--thumb">
                                            <img src="{{ asset($transfer->property->property_images) }}" alt="img" style="max-height: 100%; max-width:100%; width:70px; height:70px; object-fit:cover">
                                        </div>
                                        <div class="reviews__author--text">
                                            <h3 class="reviews__author--title">{{$transfer->property->name}}</h3>
                                            <p class="reviews__author--subtitle">{{$transfer->property->location}}</p>
                                            <span class="properties__author--price">₦{{ number_format($transfer->property->price, 2)}}</span>
                                            <p class="properties__author--price text-decoration-line-through text-muted">₦{{ number_format($transfer->property->lunch_price, 2)}}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="reviews__date">
                                        {{  \Carbon\Carbon::parse($transfer->latest_created_at)->format('d F, Y')  }} 
                                    </span>
                                </td>
                              
                                <td> 
                                    <span class="properties__views">{{ $transfer->total_land_size }} per/sqm</span>
                                </td>
                                <td>
                                    <span class="status__btn pending2">
                                        <a href="{{ route('user.properties.show', encrypt($transfer->property->id))}}">
                                            View
                                        </a> 
                                    </span>
                                </td>
                                <td>
                                    @if($transfer->status == 'pending')
                                        <span class="status__btn pending2 " style="background-color: #f39c12; ">
                                            <a class="text-white" >{{$transfer->status}}</a>
                                        </span>
                                    @elseif($transfer->status == 'completed')
                                        <span class="status__btn pending2 " style="background-color:  #28a745; ">
                                            <a class="text-white" >{{$transfer->status}}</a>
                                        </span>
                                    @elseif($transfer->status == 'failed')
                                        <span class="status__btn pending2 " style="background-color:  #dc3545; ">
                                            <a class="text-white" >{{$transfer->status}}</a>
                                        </span>
                                    @else
                                        <span class="status__btn pending2 " style="background-color:  #6c757d; ">
                                            <a class="text-white" >{{$transfer->status}}</a>
                                        </span>
                                    @endif
                                   
                                    {{-- @if($property->status == 'pending')
                                    <center>
                                        <a class="solid__btn offer-price-btn" 
                                        style="color: #fff; font-size:14px margine:1px; " 
                                        href="{{ route('user.offerPrice', encrypt($property->property->id))}}">
                                            Offer Price
                                        </a>
                                    </center>
                                @endif --}}
                                </td>
                              
                            </tr>
                            @empty
                                <tr>
                                    <td> No Transfer Property available </td>
                                    <a href="{{ route('user.transfer.add') }}" class="btn btn-success btn-lg">Transfer</a>
                                </tr>
                            @endforelse
                           
                            
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="pagination__area">
                    <nav class="pagination justify-content-center">
                        <ul class="pagination__menu d-flex align-items-center justify-content-center">
                            <!-- Render pagination links dynamically -->
                            @if ($transferProperty->onFirstPage())
                                <li class="pagination__menu--items pagination__arrow disabled">
                                    <span class="pagination__arrow-icon">
                                        <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.583 20.5832L0.999675 10.9998L10.583 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </li>
                            @else
                                <li class="pagination__menu--items pagination__arrow">
                                    <a href="{{ $transferProperty->previousPageUrl() }}" class="pagination__arrow-icon link">
                                        <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.583 20.5832L0.999675 10.9998L10.583 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                </li>
                            @endif

                            <!-- Page numbers -->
                            @foreach ($transferProperty->links()->elements[0] as $page => $url)
                                <li class="pagination__menu--items">
                                    <a href="{{ $url }}" class="pagination__menu--link {{ $page == $transferProperty->currentPage() ? 'active color-accent-1' : '' }}">
                                        {{ $page }}
                                    </a>
                                </li>
                            @endforeach

                            @if ($transferProperty->hasMorePages())
                                <li class="pagination__menu--items pagination__arrow">
                                    <a href="{{ $transferProperty->nextPageUrl() }}" class="pagination__arrow-icon link">
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
