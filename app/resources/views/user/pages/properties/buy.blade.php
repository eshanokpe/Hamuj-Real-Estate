@extends('layouts.dashboard')
<style>
    .properties__table--wrapper .offer-price-btn {
        display: inline-block; /* Ensures the button behaves as a single block element */
        white-space: nowrap; /* Prevents breaking the text into multiple lines */
        background-color: #47008E; /* Custom button background color */
        color: #fff; /* Text color */
        padding: 0px 10px; /* Add padding for spacing */
        font-size: 14px; /* Font size for readability */
        text-align: center; /* Center-align text */
        margin: 0 auto; /* Centers the button in its container */
        text-decoration: none; /* Removes underline */
        border-radius: 4px; /* Rounded corners for the button */
        cursor: pointer; /* Pointer cursor on hover */
    }

    /* Mobile-responsive table styles */
    @media screen and (max-width: 768px) {
        .properties__table {
            overflow-x: visible;
        }
        
        .properties__table--wrapper {
            width: 100%;
            border-collapse: collapse;
        }
        
        .properties__table--wrapper thead {
            display: none; /* Hide table headers on mobile */
        }
        
        .properties__table--wrapper tbody tr {
            display: block;
            margin-bottom: 1.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            background: white;
        }
        
        .properties__table--wrapper tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0.5rem;
            border-bottom: 1px solid #f1f5f9;
            text-align: right;
        }
        
        .properties__table--wrapper tbody td:last-child {
            border-bottom: none;
        }
        
        .properties__table--wrapper tbody td:before {
            content: attr(data-label);
            font-weight: 600;
            text-align: left;
            margin-right: 1rem;
            color: #475569;
        }
        
        /* Special handling for the image column */
        .properties__table--wrapper tbody td:first-child {
            display: block;
            padding: 0;
            border-bottom: none;
        }
        
        .properties__table--wrapper tbody td:first-child:before {
            display: none;
        }
        
        /* Action column styling */
        .properties__table--wrapper tbody td[colspan="2"] {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            align-items: stretch;
        }
        
        .properties__table--wrapper tbody td[colspan="2"]:before {
            content: "Actions";
        }
        
        .properties__table--wrapper tbody td .status__btn,
        .properties__table--wrapper tbody td .offer-price-btn {
            display: block;
            text-align: center;
            margin: 0.25rem 0;
            width: 100%;
        }
        
        /* Remove center alignment for mobile */
        .properties__table--wrapper tbody td[colspan="2"] center {
            display: block;
            width: 100%;
        }
    }

    /* Ensure table cells have data labels for mobile */
    @media screen and (max-width: 768px) {
        .properties__table--wrapper tbody td:nth-child(2):before { content: "Percentage"; }
        .properties__table--wrapper tbody td:nth-child(3):before { content: "Acquired Size"; }
    }

    /* Improve pagination for mobile */
    @media screen and (max-width: 768px) {
        .pagination__menu {
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        
        .pagination__menu--items {
            margin: 0;
        }
    }
</style>

@section('content')

<div class="page__body--wrapper" id="dashbody__page--body__wrapper">
    
    <main class="main__content_wrapper">
        <!-- dashboard container -->
        <div class="dashboard__container dashboard__reviews--container">
            <div class="reviews__heading mb-30">
                <h2 class="reviews__heading--title">My Assets</h2>
                <p class="reviews__heading--desc">We are glad to see you again!</p>
            </div>
            <div class="properties__wrapper">
                <div class="properties__table table-responsive">
                    <table class="properties__table--wrapper">
                        <thead>
                            <tr>
                                <th>Listing Title</th>
                                <th><span class="min-w-100">Percentage</span></th>
                                <th>Acquired Size</th>
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($buyProperty as $property)
                            <tr>
                                <td>
                                    <div class="properties__author d-flex align-items-center">
                                        <div class="properties__author--thumb">
                                            <img src=" {{ asset($property->property->property_images) }}" alt="img" style="max-height: 100%; max-width:100%; width:70px; height:80px; object-fit:cover">
                                        </div>
                                        <div class="reviews__author--text">
                                            <h3 class="reviews__author--title">{{$property->property->name}}</h3>
                                            <p class="reviews__author--subtitle">{{$property->property->location}}</p>
                                           
                                            @if($property->valuationSummary)  
                                                <span class="properties__author--price">₦{{ number_format($property->valuationSummary->current_value_sum, 2)}} per/sqm</span>
                                                <p class="properties__author--price text-decoration-line-through text-muted">₦{{ number_format($property->valuationSummary->initial_value_sum, 2)}} per/sqm</p>
                                            @else    
                                                <span class="properties__author--price">₦{{ number_format($property->property->price, 2)}} per/sqm</span>
                                            @endif
                                        </div> 
                                    </div>
                                </td>
                                <td data-label="Percentage">
                                    <span class="properties__views">
                                        @if($property->valuationSummary)
                                            {{ $property->valuationSummary->percentage_value }}%
                                        @else
                                            {{ $property->property->percentage_increase }}%
                                        @endif
                                    </span>
                                </td>   
                                <td data-label="Acquired Size"> 
                                    <span class="properties__views">{{ $property->total_selected_size_land }} SQM</span>
                                </td>
                                <td colspan="2" data-label="Actions">
                                    <p class="status__btn pending">
                                        <a href="{{ route('user.properties.show', encrypt($property->property->id))}}">
                                        View</a>
                                    </p>
                                    @if($property->status == 'sold out')
                                        <center>
                                            <a class="solid__btn offer-price-btn" 
                                            style="color: #fff; font-size:14px; margin:1px; padding: 8px 12px;" 
                                            href="{{ route('user.offerPrice', encrypt($property->property->id))}}">
                                                Offer Price
                                            </a> 
                                        </center>
                                    @endif
                                </td>
                              
                            </tr>
                            @empty 
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 2rem;">
                                        You have not bought any property yet.
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