@extends('layouts.dashboard')


@section('content')

 
<div class="dashboard__page--wrapper">
    <!-- Dashboard sidebar .\ -->
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
                                    <th>Image</th>
                                    <th>Date published</th>
                                    <th>
                                        <span class="min-w-100">Status</span>
                                    </th>
                                    <th>Size</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($properties as $index => $item)
                                    <tr>
                                        <td>
                                            <div class="properties__author d-flex align-items-center">
                                                <div class="properties__author--thumb">
                                                    <img src="{{ asset($item->property_images) }}" alt="img" style="width: 64px; height:64px; max-width:100%; max-height:100%; object-fit:cover"> 
                                                </div>
                                                <div class="reviews__author--text">
                                                    <h3 class="reviews__author--title">{{$item->name}}</h3>
                                                    <p class="reviews__author--subtitle">{{$item->location}}</p>
                                                    <span class="properties__author--price">₦{{ number_format($item->price, 2) }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="reviews__date">{{ $item->created_at->format('d F Y') }}</span>
                                        </td>
                                        <td>
                                            @if( $item->status == 'available')
                                                <span class="status__btn processing">{{ ucFirst($item->status)}}</span>
                                            @elseif($item->status === 'sold')
                                                <span class="status__btn active">{{ ucFirst($item->status)}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="properties__views">{{$item->size}}</span>
                                        </td>
                                        <td>
                                            <span class="sales__report--status pending2"><a href="{{ route('user.properties.show', encrypt($item->id))}}">View</a></span>

                                        </td>
                                    </tr>
                                @empty
                                    <p>No data available</p>
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