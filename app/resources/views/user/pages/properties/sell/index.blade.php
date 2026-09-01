@extends('layouts.dashboard')

@section('content')
<style>
    /* Mobile-responsive table styles for Sell Property */
    @media screen and (max-width: 768px) {
        .properties__table {
            overflow-x: visible;
        }
        
        .properties__table--wrapper { 
            width: 100%;
            border-collapse: collapse;
        }
        
        .properties__table--wrapper thead {
            display: none;
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
            flex-shrink: 0;
        }
        
        .properties__table--wrapper tbody td:first-child {
            display: block;
            padding: 0;
            border-bottom: none;
        }
        
        .properties__table--wrapper tbody td:first-child:before {
            display: none;
        }
        
        .properties__table--wrapper tbody td .status__btn {
            display: inline-block;
            margin: 0.25rem 0;
            min-width: 100px;
            text-align: center;
        }
        
        .properties__table--wrapper tbody td[colspan] {
            display: block;
            text-align: center;
            padding: 2rem !important;
        }
    }

    /* UPDATED: Mobile labels adjusted for the 8-column layout */
    @media screen and (max-width: 768px) {
        .properties__table--wrapper tbody td:nth-child(2):before { content: "Listing Title"; }
        .properties__table--wrapper tbody td:nth-child(3):before { content: "Date Acquired"; }
        .properties__table--wrapper tbody td:nth-child(4):before { content: "Amount Paid"; }
        .properties__table--wrapper tbody td:nth-child(5):before { content: "ROI Due Date"; }
        .properties__table--wrapper tbody td:nth-child(6):before { content: "ROI Review"; }
        .properties__table--wrapper tbody td:nth-child(7):before { content: "View Property"; }
        .properties__table--wrapper tbody td:nth-child(8):before { content: "Sell Property"; }
    }

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

<div class="page__body--wrapper" id="dashbody__page--body__wrapper">
    <main class="main__content_wrapper">
        <div class="dashboard__container dashboard__reviews--container">
            
            <div class="reviews__heading mb-30">
                <h2 class="reviews__heading--title">Sell Property</h2>
                <p class="reviews__heading--desc">Manage and initiate the sale of your acquired property portions.</p>
                
                {{-- Grand Total Summary Card --}}
                <div class="mt-3 p-3 rounded d-inline-block w-100" style="background-color: #f8f9fa; border-left: 4px solid #47008E;">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div class="mb-2 mb-md-0">
                            <span class="text-muted me-2">Total Portfolio Value:</span> 
                            <span class="fw-bold fs-5" style="color: #47008E;">
                                ₦{{ number_format($grandTotalAmount ?? 0, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="properties__wrapper">
                <div class="properties__table table-responsive">
                    <table class="properties__table--wrapper">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Listing Title</th>
                                <th>Date Acquired</th>
                                <th>Amount to Earn</th>
                                <th>ROI Due Date</th>
                                <th>Total Assets</th>
                                <th colspan="2" class="text-center">Actions</th>
                            </tr>
                        </thead> 
                        <tbody> 
                            @forelse ($sellProperties as $buy) 
                            @php
                                // Calculate ROI Due Date as exactly 365 days from purchase
                                $purchaseDate = \Carbon\Carbon::parse($buy->created_at);
                                $roiDueDate = $purchaseDate->copy()->addDays(365);
                                $today = \Carbon\Carbon::today();
                                $daysRemaining = $today->diffInDays($roiDueDate, false);
                                
                                // Calculate Monthly ROI (Annual ROI / 12)
                                $monthlyROI = ($buy->totalROI ?? 0) / 12;
                            @endphp
                            <tr>
                                <td data-label="S/N" class="fw-bold text-center">
                                    {{ ($sellProperties->currentPage() - 1) * $sellProperties->perPage() + $loop->iteration }}
                                </td>

                                <td>
                                    <div class="properties__author d-flex align-items-center">
                                        <div class="properties__author--thumb flex-shrink-0 me-3">
                                            <img src="{{ asset($buy->property->property_images ?? 'path/to/default-image.jpg') }}"
                                                 alt="{{ $buy->property->name ?? 'Property Image' }}"
                                                 style="width:70px; height:90px; object-fit:cover; border-radius: 4px;">
                                        </div>
                                        <div class="reviews__author--text">
                                            <h3 class="reviews__author--title mb-1">{{ $buy->property->name ?? 'N/A' }}</h3>
                                            <p class="reviews__author--subtitle text-muted mb-1">{{ $buy->property->location ?? 'N/A' }}</p>
                                            <p class="mt-2 reviews__author--title"><span style="font-weight:bold">ROI:</span> {{ $buy->property->percentage_increase ?? 0 }}%</p>
                                        </div>
                                    </div>
                                </td> 
                                
                                <td data-label="Date Acquired">
                                    <span class="reviews__date">
                                        {{ $purchaseDate->format('d F, Y') }} 
                                    </span>
                                </td> 
                                
                                <td data-label="Amount Paid" class="text-nowrap align-middle fw-bold">
                                    <span class="properties__views" style="color: #47008E; font-weight: 800;">
                                        ₦{{ number_format($buy->totalROI, 2) }}
                                        <small class="text-muted fw-normal" style="font-size: 0.75rem;">(Annual)</small>
                                        
                                    </span>
                                </td>  

                                {{-- ROI Due Date --}}
                                <td data-label="ROI Due Date" class="text-nowrap align-middle">
                                    <div class="d-flex flex-column">
                                        <span class="text-success fw-bold">
                                            {{ $roiDueDate->format('d F, Y') }}
                                        </span>
                                        @if($daysRemaining > 0)
                                            <small class="text-muted">{{ $daysRemaining }} days remaining</small>
                                        @elseif($daysRemaining === 0)
                                            <small class="text-warning fw-bold">Due Today!</small>
                                        @else
                                            <small class="text-danger fw-bold">Matured</small>
                                        @endif
                                    </div>
                                </td> 

                                {{-- UPDATED: ROI Review with Annual and Monthly breakdown --}}
                                <td data-label="ROI Review" class="text-nowrap align-middle">
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold" style="color: #28a745;">
                                            ₦{{ number_format($buy->total_price ?? 0, 2) }} 
                                        </span>
                                        <span class="text-muted small">
                                            ≈ ₦{{ number_format($monthlyROI, 2) }} / month
                                        </span>
                                    </div>
                                </td>
                               
                                <td data-label="Sell Property"> 
                                    <span class="status__btn pending2" style="background-color: #47008E;">
                                        <a class="text-white" href="{{ route('user.cart.sell.index', ['property_id' => encrypt($buy->property->id), 'buy_id' => $buy->id]) }}">Sell</a>
                                    </span>
                                </td>
                                
                            </tr>
                            @empty
                            <tr>
                                {{-- UPDATED: colspan changed to 8 to match the 8 columns in thead --}}
                                <td colspan="8">
                                    <div class="text-center p-5 border-top">
                                        <i class="fas fa-store-slash fa-3x text-muted mb-3"></i>
                                        <h4 class="text-muted fw-normal">No Assets Currently Available to Sell</h4>
                                        <br><br>
                                        <span class="status__btn pending2" style="background-color: #47008E;">
                                            <a class="text-white" href="{{ route('user.properties') }}">Buy Properties</a>
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
                            @if ($sellProperties->onFirstPage())
                                <li class="pagination__menu--items pagination__arrow disabled">
                                    <span class="pagination__arrow-icon">
                                        <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.583 20.5832L0.999675 10.9998L10.583 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </li>
                            @else
                                <li class="pagination__menu--items pagination__arrow">
                                    <a href="{{ $sellProperties->previousPageUrl() }}" class="pagination__arrow-icon link">
                                        <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.583 20.5832L0.999675 10.9998L10.583 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                </li>
                            @endif

                            @foreach ($sellProperties->links()->elements[0] as $page => $url)
                                <li class="pagination__menu--items">
                                    <a href="{{ $url }}" class="pagination__menu--link {{ $page == $sellProperties->currentPage() ? 'active color-accent-1' : '' }}">
                                        {{ $page }}
                                    </a>
                                </li>
                            @endforeach

                            @if ($sellProperties->hasMorePages())
                                <li class="pagination__menu--items pagination__arrow">
                                    <a href="{{ $sellProperties->nextPageUrl() }}" class="pagination__arrow-icon link">
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
    </main>
</div>
@endsection