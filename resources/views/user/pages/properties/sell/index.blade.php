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
                            {{-- Filter the collection in the view to only include properties with a sellable size --}}
                            {{-- Note: It's generally better practice to filter this in the Controller before passing to the view, especially for pagination accuracy. --}}
                            @php
                                $sellableProperties = $sellProperty->filter(function ($item) {
                                    // Ensure total_selected_size_land exists, is numeric, and greater than 0
                                    return isset($item->total_selected_size_land) && is_numeric($item->total_selected_size_land) && $item->total_selected_size_land > 0;
                                });
                            @endphp

                            {{-- Loop through only the properties that have a sellable size --}}
                            @forelse ($sellableProperties as $property)
                            <tr>
                                <td>
                                    <div class="properties__author d-flex align-items-center">
                                        <div class="properties__author--thumb flex-shrink-0 me-3"> {{-- Added margin --}}
                                            {{-- Use optional() helper and provide a default/placeholder image --}}
                                            <img src="{{ asset(optional($property->property)->property_images ?? 'path/to/default-image.jpg') }}"
                                                 alt="{{ optional($property->property)->name ?? 'Property Image' }}"
                                                 style="width:70px; height:90px; object-fit:cover; border-radius: 4px;"> {{-- Consistent size & added radius --}}
                                        </div>
                                        <div class="reviews__author--text">
                                            {{-- Use optional() helper for safety --}}
                                            <h3 class="reviews__author--title mb-1 fs-6">{{ optional($property->property)->name ?? 'N/A' }}</h3>
                                            <p class="reviews__author--subtitle text-muted small mb-1">{{ optional($property->property)->location ?? 'N/A' }}</p>
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
                                <td class="text-nowrap align-middle"> {{-- Align vertically --}}
                                    <span class="reviews__date">
                                        {{-- Use optional() and Carbon's helper for cleaner date formatting --}}
                                        {{ optional($property->latest_created_at)->isoFormat('ll') ?? 'N/A' }} {{-- e.g., Sep 5, 2024 --}}
                                    </span>
                                </td>
                                <td class="text-nowrap align-middle fw-bold"> {{-- Align vertically, make bold --}}
                                    <span class="properties__views">{{ number_format($property->total_selected_size_land, 0) }} SQM</span>
                                </td>
                                <td class="text-nowrap align-middle text-center"> {{-- Align vertically & center --}}
                                    {{-- Use button classes for better styling consistency --}}
                                    <a href="{{ route('user.properties.show', encrypt(optional($property->property)->id)) }}" class="btn btn-sm btn-outline-secondary">
                                        View
                                    </a>
                                </td>
                                <td class="text-nowrap align-middle text-center"> {{-- Align vertically & center --}}
                                    {{-- Use button classes and specific styling --}}
                                    <a href="{{ route('user.cart.sell.index', encrypt(optional($property->property)->id)) }}" class="btn btn-sm text-white" style="background-color: #47008E; border-color: #47008E;">
                                        Sell
                                    </a>
                                </td>
                            </tr>
                            @empty
                            {{-- This message shows if $sellableProperties is empty --}}
                            <tr>
                                {{-- Span across all table columns --}}
                                <td colspan="5">
                                    <div class="text-center p-5 border-top">
                                        {{-- Optional: Add an icon (e.g., using Font Awesome)
                                        <i class="fas fa-store-slash fa-3x text-muted mb-3"></i>
                                        --}}
                                        <h4 class="text-muted fw-normal">No Assets Currently Available to Sell</h4>
                                        <p class="text-muted mb-0">You do not have any property portions with a size greater than 0 SQM available for sale at this time.</p>
                                        {{-- Optional: Link to buy more or view all holdings --}}
                                        {{-- <a href="{{ route('user.properties.index') }}" class="btn btn-link mt-2">View All Holdings</a> --}}
                                    </div>
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                 @if ($sellProperty->hasPages())
                <div class="pagination__area mt-4">
                    <nav class="pagination justify-content-center">
                        {{-- Recommended: Use Laravel's default pagination view --}}
                        {{ $sellProperty->links('vendor.pagination.bootstrap-5') }}

                        {{-- Or keep your custom pagination logic if needed, ensuring it uses $sellProperty --}}
                        {{-- <ul class="pagination__menu d-flex align-items-center justify-content-center"> ... your custom links using $sellProperty ... </ul> --}}
                    </nav>
                </div>
                @endif
            </div>
        </div>
        <!-- dashboard container .\ -->

    </main>

</div>

@endsection
