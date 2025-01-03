@extends('layouts.dashboard')


@section('content')

 
<div class="dashboard__page--wrapper">
    <!-- Dashboard sidebar .\ -->
    <div class="page__body--wrapper" id="dashbody__page--body__wrapper">
        
        <main class="main__content_wrapper">
            <!-- dashboard container -->
            <div class="dashboard__container dashboard__reviews--container">
                <div class="reviews__heading mb-30">
                    <h2 class="reviews__heading--title">Notification</h2>
                </div>
               
                <div class="properties__wrapper">
                    <div class="properties__table table-responsive">
                        <table class="properties__table--wrapper">
                            <thead> 
                                <tr>
                                    <th>Listing</th>
                                    
                                    <th>Land Size</th>
                                    <th>
                                        <span class="min-w-100">Status</span>
                                    </th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($notifications as $index => $item)
                                    <tr>
                                        <td>
                                            <div class="properties__author d-flex align-items-center">
                                                @if(isset($item['data']['property_image']) && $item['data']['property_image'])
                                                    <div class="properties__author--thumb">
                                                        <img src="{{ asset($item['data']['property_image']) }}" alt="img" style="width: 64px; height:64px; max-width:100%; max-height:100%; object-fit:cover"> 
                                                    </div>
                                                @endif
                                                <div class="reviews__author--text">
                                                @if(isset($item['data']['property_name']) && $item['data']['property_name'])

                                                    <h3 class="reviews__author--title">{{$item['data']['property_name']}}</h3>
                                                    <h3 class="reviews__author--title">₦{{ number_format($item['data']['market_value'], 2)}}</h3>
                                                    <p class="reviews__author--subtitle">{{$item['data']['percentage_increase']}}%</p>
                                                @endif

                                                @if(isset($item['data']['total_price']) && $item['data']['total_price'])
                                                    <span class="properties__author--price">₦{{ number_format($item['data']['total_price'], 2) }}</span>
                                                @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if(isset($item['data']['land_size']) && $item['data']['land_size'])
                                                <span class="properties__views">{{$item['data']['land_size']}} per/sqm</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($item['data']['status']) && $item['data']['status'])
                                                @if($item['data']['status'] == 'pending')
                                                    <span class="status__btn pending2 " style="background-color: #f39c12; ">
                                                        <a class="text-white" >{{ ucfirst($item['data']['status']) }}</a>
                                                    </span>
                                                @elseif($item['data']['status'] == 'completed')
                                                    <span class="status__btn pending2 " style="background-color:  #28a745; ">
                                                        <a class="text-white" >{{ ucfirst($item['data']['status']) }}</a>
                                                    </span>
                                                @elseif($item['data']['status'] == 'failed')
                                                    <span class="status__btn pending2 " style="background-color:  #dc3545; ">
                                                        <a class="text-white" >{{ ucfirst($item['data']['status']) }}</a>
                                                    </span>
                                                @else
                                                    <span class="status__btn pending2 " style="background-color:  #6c757d; ">
                                                        <a class="text-white" >{{ ucfirst($item['data']['status']) }}</a>
                                                    </span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <span class="sales__report--status">
                                                @if(isset($item['data']['property_name']) && $item['data']['property_name'])

                                                    {{$item->created_at->diffForHumans()}}
                                                @endif

                                            </span>

                                        </td>
                              
                                        <td>
                                            @if(isset($item['data']['status']) && $item['data']['status'])

                                                @if($item['data']['status'] == 'pending') 
                                                
                                                    <span class="status__btn w-100 " style="color:#fff; background-color:#28a745 ">
                                                        <a href="{{ route('user.transfer.property.confirm', ['propertyMode' => $item['data']['property_mode'], 'slug' => $item['data']['property_slug']]) }}" 
                                                        style=" color: #fff; border: none;  cursor: pointer;">
                                                            Confirm Property
                                                        </a>
                                                    </span>
                                                @elseif($item->status === 'confirm')
                                                
                                                @endif
                                            @endif

                                        </td>
                                    </tr>
                                @empty
                                    <tr>    
                                        <td><p>No data available</p></td>
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
                                @if ($notifications->onFirstPage())
                                    <li class="pagination__menu--items pagination__arrow disabled">
                                        <span class="pagination__arrow-icon">
                                            <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10.583 20.5832L0.999675 10.9998L10.583 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                    </li>
                                @else
                                    <li class="pagination__menu--items pagination__arrow">
                                        <a href="{{ $notifications->previousPageUrl() }}" class="pagination__arrow-icon link">
                                            <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10.583 20.5832L0.999675 10.9998L10.583 1.4165" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>
                                    </li>
                                @endif

                                <!-- Page numbers -->
                                @foreach ($notifications->links()->elements[0] as $page => $url)
                                    <li class="pagination__menu--items">
                                        <a href="{{ $url }}" class="pagination__menu--link {{ $page == $notifications->currentPage() ? 'active color-accent-1' : '' }}">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endforeach

                                @if ($notifications->hasMorePages())
                                    <li class="pagination__menu--items pagination__arrow">
                                        <a href="{{ $notifications->nextPageUrl() }}" class="pagination__arrow-icon link">
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
