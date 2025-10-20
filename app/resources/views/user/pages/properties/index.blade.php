@extends('layouts.dashboard')

@section('content')
<style>
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
    
    /* Ensure action buttons are properly displayed */
    .properties__table--wrapper tbody td .status__btn,
    .properties__table--wrapper tbody td .sales__report--status {
        display: inline-block;
        margin: 0.25rem 0;
    }
}

/* Ensure table cells have data labels for mobile */
@media screen and (max-width: 768px) {
    .properties__table--wrapper tbody td:nth-child(2):before { content: "Status"; }
    .properties__table--wrapper tbody td:nth-child(3):before { content: "Size"; }
    .properties__table--wrapper tbody td:nth-child(4):before { content: "Available Size"; }
    .properties__table--wrapper tbody td:nth-child(5):before { content: "Action"; }
    .properties__table--wrapper tbody td:nth-child(6):before { content: "Details"; }
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
 
<div class="dashboard__page--wrapper">
    <!-- Dashboard sidebar .\ -->
    <div class="page__body--wrapper" id="dashbody__page--body__wrapper">
        
        <main class="main__content_wrapper">
            <!-- dashboard container -->
            <div class="dashboard__container dashboard__reviews--container">
                <div class="reviews__heading mb-30"> 
                    <h2 class="reviews__heading--title">Buy Properties</h2>
                    <p class="reviews__heading--desc">We are glad to see you again!</p>
                </div>
                <div class="properties__wrapper">
                    <div class="properties__table table-responsive">
                        <table class="properties__table--wrapper">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>
                                        <span class="min-w-100">Status</span>
                                    </th>
                                    <th>Size</th>
                                    <th>Available Size</th>
                                    <th>Action</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($properties as $index => $item)
                                    <tr> 
                                        <td>  
                                            <div class="properties__author d-flex align-items-center">
                                                <div class="properties__author--thumb">
                                                    <img src="{{ asset($item->property_images) }}" alt="img" style="width: 90px; height:120px; max-width:100%; max-height:100%; object-fit:cover"> 
                                                </div>
                                                <div class="reviews__author--text">
                                                    <h3 class="reviews__author--title">{{$item->name}}</h3>
                                                    <p class="reviews__author--subtitle">{{$item->location}}</p>
                                                    @if($item->valuationSummary)
                                                        <span class="properties__author--price">₦{{ number_format($item->valuationSummary->current_value_sum, 2)}} per/sqm</span>
                                                        <p class="properties__author--price text-decoration-line-through text-muted">₦{{ number_format($item->valuationSummary->initial_value_sum, 2)}} per/sqm</p>
                                                        <p class="reviews__author--title">{{$item->valuationSummary->percentage_value}}%</p>
                                                    @else   
                                                        <span class="properties__author--price">₦{{ number_format($item->property->price, 2)}} per/sqm</span>
                                                        <p class="reviews__author--title">{{$item->percentage_increase}}%</p>

                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="Status">
                                            @if( $item->status == 'available')
                                                <span class="status__btn processing">{{ ucFirst($item->status)}}</span>
                                            @elseif($item->status === 'sold out')
                                                <span class="status__btn active" style="color: #008000">{{ ucFirst($item->status)}}</span>
                                            @endif
                                        </td>
                                        <td data-label="Size">
                                            <span class="properties__views">{{ $item->size }} SQM </span>
                                        </td>
                                        <td data-label="Available Size">
                                            <span class="properties__views">{{ $item->available_size }} SQM </span> 
                                        </td>
                                        <td data-label="Action">
                                            @if($item->status === 'sold out')
                                                <span class="status__btn " style="color:#fff; background-color:#47008E ">
                                                    <a href="{{ route('user.offerPrice', encrypt($item->id))}}" 
                                                        style=" color: #fff; border: none;  cursor: pointer;">
                                                        Offer Price 
                                                    </a>
                                                </span>
                                            @elseif($item->status === 'available')
                                                <span class="sales__report--status pending2"   style="background-color: #008000;">
                                                    <a  
                                                    style=" color: #fff; border: none;  cursor: pointer;"
                                                    href="{{ route('user.cart.index', $item->slug) }}"
                                                    >Buy</a>  
                                                </span>
                                            @endif
                                        </td>
                                        <td data-label="Details">
                                            <span class="sales__report--status pending2"><a href="{{ route('user.properties.show', encrypt($item->id))}}">View</a></span>
                                        </td>
                  
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; padding: 2rem;">
                                            <p>No data available</p>
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
                                @if ($properties->onFirstPage())
                                    <li class="pagination__menu--items pagination__arrow disabled">
                                        <span class="pagination__arrow-icon">
                                            <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10.583 20.5832L0.999675 10.9998L10.583 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                    </li>
                                @else
                                    <li class="pagination__menu--items pagination__arrow">
                                        <a href="{{ $properties->previousPageUrl() }}" class="pagination__arrow-icon link">
                                            <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10.583 20.5832L0.999675 10.9998L10.583 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>
                                    </li>
                                @endif

                                <!-- Page numbers -->
                                @foreach ($properties->links()->elements[0] as $page => $url)
                                    <li class="pagination__menu--items">
                                        <a href="{{ $url }}" class="pagination__menu--link {{ $page == $properties->currentPage() ? 'active color-accent-1' : '' }}">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endforeach

                                @if ($properties->hasMorePages())
                                    <li class="pagination__menu--items pagination__arrow">
                                        <a href="{{ $properties->nextPageUrl() }}" class="pagination__arrow-icon link">
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
</div>
        
       

@endsection