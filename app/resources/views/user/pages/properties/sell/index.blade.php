@extends('layouts.dashboard')

@section('content')
<style>
    /* ... (Keep all your existing CSS exactly as it is) ... */
</style>

<div class="page__body--wrapper" id="dashbody__page--body__wrapper">
    <main class="main__content_wrapper">
        <div class="dashboard__container dashboard__reviews--container">
            
            <div class="reviews__heading mb-30">
                <h2 class="reviews__heading--title">Sell Property</h2>
                <p class="reviews__heading--desc">Manage and initiate the sale of your acquired property portions.</p>
                
                {{-- NEW: Grand Total Summary Card --}}
                <div class="mt-3 p-3 rounded d-inline-block" style="background-color: #f8f9fa; border-left: 4px solid #47008E;">
                    <span class="text-muted me-2">Total Acquired Portfolio Size:</span> 
                    <span class="fw-bold fs-5" style="color: #47008E;">
                        {{ number_format($grandTotalSize ?? 0, 4) }} SQM
                    </span>
                </div>
            </div>

            <div class="properties__wrapper">
                <div class="properties__table table-responsive">
                    <table class="properties__table--wrapper">
                        <thead>
                            <tr>
                                <th>Listing Title</th>
                                <th>Date Acquired</th>
                                <th>Acquired Property (Sellable)</th>
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
                                        <div class="properties__author--thumb flex-shrink-0 me-3">
                                            <img src="{{ asset(($property->property)->property_images ?? 'path/to/default-image.jpg') }}"
                                                 alt="{{ optional($property->property)->name ?? 'Property Image' }}"
                                                 style="width:70px; height:90px; object-fit:cover; border-radius: 4px;">
                                        </div>
                                        <div class="reviews__author--text">
                                            <h3 class="reviews__author--title mb-1 ">{{ optional($property->property)->name ?? 'N/A' }}</h3>
                                            <p class="reviews__author--subtitle text-muted  mb-1">{{ optional($property->property)->location ?? 'N/A' }}</p>
                                            <p class="mt-2 reviews__author--title"><span style="font-weight:bold">ROI:</span> {{ optional($property->property)->percentage_increase}}%</p>
                                        </div>
                                    </div>
                                </td> 
                                <td data-label="Date Acquired">
                                    <span class="reviews__date">
                                        {{ \Carbon\Carbon::parse($property->latest_created_at)->format('d F, Y') }} 
                                    </span>
                                </td> 
                                {{-- UPDATED: Displays Total Amount Paid instead of SQM --}}
                                <td data-label="Total Amount Paid" class="text-nowrap align-middle fw-bold">
                                    <span class="properties__views" style="color: #47008E; font-weight: 800;">
                                        ₦{{ number_format($property->total_amount_paid, 2) }}
                                    </span>
                                </td>  

                                <td data-label="View Property">
                                    <span class="status__btn pending2"> 
                                        <a href="{{ route('user.properties.show', encrypt($property->property->id))}}">View</a>
                                    </span> 
                                </td>
                                <td data-label="Sell Property"> 
                                    <span class="status__btn pending2 " style="background-color: #47008E; ">
                                        <a class="text-white" href="{{ route('user.cart.sell.index', encrypt($property->property->id))}}">Sell</a>
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
                                            <a class="text-white" href="{{ route('user.properties')}}">Buy Properties</a>
                                        </span>
                                     </div>
                                </td>
                            </tr>
                            @endforelse 
                        </tbody>

                       

                    </table>
                </div>

                <!-- Pagination (Keep your existing pagination code exactly as it is) -->
                <div class="pagination__area">
                    <!-- ... -->
                </div> 
            </div>
        </div>
    </main>
</div>
@endsection