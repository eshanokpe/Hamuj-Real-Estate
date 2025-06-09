@extends('layouts.dashboard')


@section('content')

<div class="page__body--wrapper" id="dashbody__page--body__wrapper">
   
    <main class="main__content_wrapper">
        <!-- dashboard container -->
        <div class="dashboard__container dashboard__reviews--container">
            <div class="reviews__heading mb-30">
                <h2 class="reviews__heading--title">Transaction</h2>
                <p class="reviews__heading--desc">We are glad to see you again!</p>
            </div>
            <div class="properties__wrapper"> 
                <div class="properties__table table-responsive">
                    <table class="properties__table--wrapper">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Property name</th>
                                {{-- <th>Reference </th> --}}
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse ($transactions as $index => $transaction)
    <tr>
        <td>
            {{ $loop->iteration }} <!-- This will display the row number -->
        </td>
        <td>
            @if(is_array($transaction->metadata) || is_object($transaction->metadata))
                <div class="metadata-container">
                    @if(isset($transaction->metadata['custom_fields']))
                        @foreach($transaction->metadata['custom_fields'] as $field)
                            <strong>{{ $field['display_name'] }}:</strong> {{ $field['value'] ?? 'N/A' }}<br>
                        @endforeach
                    @else
                        <strong>Property:</strong> {{ $transaction->metadata['property_name'] ?? 'N/A' }}<br>
                        <strong>Size:</strong> {{ $transaction->metadata['selected_size_land'] ?? 'N/A' }} of 
                        {{ $transaction->metadata['remaining_size'] ?? 'N/A' }} SQM<br>
                    @endif
                    <strong>Amount:</strong> {{ number_format($transaction->amount, 2) }}<br>
                    <strong>Date:</strong> {{ \Carbon\Carbon::parse($transaction->paid_at)->format('M d, Y h:i A') }}
                </div>
            @else
                {{ $transaction->metadata ?? 'No metadata available' }}
            @endif
        </td>
        <td>
            @php
                $statusColors = [
                    'pending' => '#f39c12',
                    'completed' => '#28a745',
                    'success' => '#28a745',
                    'failed' => '#dc3545',
                    'default' => '#6c757d'
                ];
                $statusColor = $statusColors[$transaction->status] ?? $statusColors['default'];
            @endphp
            <span class="status__btn pending2" style="background-color: {{ $statusColor }}; color:#fff">
                {{ ucfirst($transaction->status) }}
            </span>
        </td> 
        <td>
            <span class="status__btn pending2">
                <a href="{{ route('user.transaction.show', encrypt($transaction->id)) }}">
                    View Receipt
                </a>
            </span>
        </td>
    </tr>
@empty
    <tr> 
        <td colspan="7" class="text-center">No transactions available</td>
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
                            @if ($transactions->onFirstPage())
                                <li class="pagination__menu--items pagination__arrow disabled">
                                    <span class="pagination__arrow-icon">
                                        <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.583 20.5832L0.999675 10.9998L10.583 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </li>
                            @else
                                <li class="pagination__menu--items pagination__arrow">
                                    <a href="{{ $transactions->previousPageUrl() }}" class="pagination__arrow-icon link">
                                        <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.583 20.5832L0.999675 10.9998L10.583 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                </li>
                            @endif

                            <!-- Page numbers -->
                            @foreach ($transactions->links()->elements[0] as $page => $url)
                                <li class="pagination__menu--items">
                                    <a href="{{ $url }}" class="pagination__menu--link {{ $page == $transactions->currentPage() ? 'active color-accent-1' : '' }}">
                                        {{ $page }}
                                    </a>
                                </li>
                            @endforeach

                            @if ($transactions->hasMorePages())
                                <li class="pagination__menu--items pagination__arrow">
                                    <a href="{{ $transactions->nextPageUrl() }}" class="pagination__arrow-icon link">
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
