@extends('layouts.dashboard')

@section('content')

<div class="page__body--wrapper" id="dashbody__page--body__wrapper">

    <main class="main__content_wrapper">
        <!-- dashboard container -->
        <div class="dashboard__container dashboard__reviews--container">
            <div class="reviews__heading mb-30">
                <h2 class="reviews__heading--title">Sell Property</h2>
                {{-- More descriptive text --}}
                <p class="reviews__heading--desc">Manage and initiate the sale of your acquired property portions.</p>
            </div>
            <div class="properties__wrapper">
                <div class="properties__table table-responsive">
                    <table class="properties__table--wrapper">
                        <thead>
                            <tr>
                                <th>Listing Title</th>
                                {{-- More accurate header? --}}
                                <th>Date Acquired</th>
                                <th>Acquired Size (Sellable)</th>
                                {{-- Combine action columns for cleaner header --}}
                                <th colspan="2" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody> 
                            @php
                                $sellableProperties = $sellProperty->filter(function ($item) {
                                    return isset($item->total_selected_size_land) && is_numeric($item->total_selected_size_land) && $item->total_selected_size_land > 0;
                                });
                            @endphp

                            @forelse ($sellableProperties as $property)
                            <tr>
                                <td>
                                    <div class="properties__author d-flex align-items-center">
                                        <div class="properties__author--thumb flex-shrink-0 me-3"> {{-- Added margin --}}
                                            {{-- Use optional() helper and provide a default/placeholder image --}}
                                            <img src="{{ asset('app/public/' .optional($property->property)->property_images ?? 'path/to/default-image.jpg') }}"
                                                 alt="{{ optional($property->property)->name ?? 'Property Image' }}"
                                                 style="width:70px; height:90px; object-fit:cover; border-radius: 4px;"> {{-- Consistent size & added radius --}}
                                        </div>
                                        <div class="reviews__author--text">
                                            
                                            <h3 class="reviews__author--title mb-1 ">{{ optional($property->property)->name ?? 'N/A' }}</h3>
                                            <p class="reviews__author--subtitle text-muted  mb-1">{{ optional($property->property)->location ?? 'N/A' }}</p>
                                            @if($property->valuationSummary)
                                                <span class="properties__author--price d-block small">₦{{ number_format($property->valuationSummary->current_value_sum, 2)}} <small class="text-muted">per/sqm</small></span>
                                                <p class="properties__author--price text-decoration-line-through text-muted small mb-0">₦{{ number_format($property->valuationSummary->initial_value_sum, 2)}} <small class="text-muted">per/sqm</small></p>
                                            @elseif(optional($property->property)->price) {{-- Check property and price exist --}}
                                                <span class="properties__author--price d-block small">₦{{ number_format($property->property->price, 2)}} <small class="text-muted">per/sqm</small></span>
                                                @if(optional($property->property)->lunch_price)
                                                <p class="properties__author--price text-decoration-line-through text-muted small mb-0">₦{{ number_format($property->property->lunch_price, 2)}} <small class="text-muted">per/sqm</small></p>
                                                @endif
                                            @else
                                                <span class="properties__author--price d-block text-muted small">Price unavailable</span>
                                            @endif
                                        </div>
                                    </div>
                                </td> 
                                <td>
                                    <span class="reviews__date">
                                        {{  \Carbon\Carbon::parse($property->latest_created_at)->format('d F, Y')  }} 
                                    </span>
                                </td>
                                <td class="text-nowrap align-middle fw-bold"> {{-- Align vertically, make bold --}}
                                    <span class="properties__views">{{ number_format($property->total_selected_size_land, 0) }} SQM</span>
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
                            <tr>
                                <td colspan="5">
                                    <div class="text-center p-5 border-top">
                                        <i class="fas fa-store-slash fa-3x text-muted mb-3"></i>
                                       
                                        <h4 class="text-muted fw-normal">No Assets Currently Available to Sell</h4>
                                        <br><br>
                                        <span class="status__btn pending2 " style="background-color: #47008E; ">
                                            <a class="text-white" href="{{ route('user.properties')}}">
                                                Buy Properties
                                            </a>
                                        </span>
                                     </div>
                                </td>
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
                            @if ($sellProperty->onFirstPage())
                                <li class="pagination__menu--items pagination__arrow disabled">
                                    <span class="pagination__arrow-icon">
                                        <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.583 20.5832L0.999675 10.9998L10.583 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </li>
                            @else
                                <li class="pagination__menu--items pagination__arrow">
                                    <a href="{{ $sellProperty->previousPageUrl() }}" class="pagination__arrow-icon link">
                                        <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.583 20.5832L0.999675 10.9998L10.583 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                </li>
                            @endif

                            <!-- Page numbers -->
                            @foreach ($sellProperty->links()->elements[0] as $page => $url)
                                <li class="pagination__menu--items">
                                    <a href="{{ $url }}" class="pagination__menu--link {{ $page == $sellProperty->currentPage() ? 'active color-accent-1' : '' }}">
                                        {{ $page }}
                                    </a>
                                </li>
                            @endforeach

                            @if ($sellProperty->hasMorePages())
                                <li class="pagination__menu--items pagination__arrow">
                                    <a href="{{ $sellProperty->nextPageUrl() }}" class="pagination__arrow-icon link">
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
