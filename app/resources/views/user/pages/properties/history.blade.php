@extends('layouts.dashboard')

<style>
    .timeline {
      position: relative;
      padding-left: 1px;
    }
    .timeline:before {
      content: '';
      position: absolute;
      top: 0;
      bottom: 0;
      left: 30%;
      width: 1.5px;
      background-color: #47008E;
    }
    .timeline-item {
      position: relative; 
      /* margin-bottom: 70px; */
    }
    .timeline-item:before {
        content: '';
        position: absolute;
        left: 43%;
        top: 110px;
        z-index: 20;
        width: 12px;
        height: 12px;
        background-color: #CC9933;
        border-radius: 50%;
        transform: translateX(-50%);
    }
    .percent-change {
      color: #888;
      font-size: 0.9rem;
    }
    .icon {
      font-size: 1.5rem;
      margin-right: 5px;
    }
</style>
@section('content')

 
<div class="dashboard__page--wrapper">
   
    <div class="page__body--wrapper" id="dashbody__page--body__wrapper">
        <main class="main__content_wrapper">
            <div class="row add__property--heading">
                <h2 class="add__property--heading__title text-start"> Property history</h2>
                <div class="add__property--heading__title text-end">
                    
                    <a href="{{ route('user.properties.valuation', encrypt($property->id)) }}"  class="mb-3 solid__btn add__property--btn">
                        Valuation
                    </a>
                    <a href="{{ route('user.properties.show', encrypt($property->id)) }}"  class="solid__btn add__property--btn">
                        Back
                    </a>
                </div>
            </div>
            <!-- dashboard container -->
            <div class="dashboard__container d-flex">
                <div class="main__content--left">
                    <div class="main__content--left__inner">
                        <!-- Welcome section -->
                        <div class="welcome__section align-items-center">
                            <div class="row mb-3 d-flex justify-content-center">                                                
                                <div class="col">
                                    <h3 class="font-22 fw-bold">Property sale history</h3> 
                                </div>
                            </div>
                            <div class="row mb-3 d-flex justify-content-center">                                                
                                <div class="d-flex col">
                                    <p class="text-dark mb-1 fw-semibold">Launch Price: </p>
                                    <h3 class="font-22 fw-bold"> ₦{{ number_format($property->lunch_price, 2) }}</h3> 
                                </div>
                                <hr/>
                            </div>
                            
                            <div class="welcome__section align-items-center">
                                <div class="table-responsive">
                                    <table class="table cart__table table-borderless" border="0">
                                        <thead class="thead-light">
                                            <th>Year sold</th>
                                            <th style="padding-left: 20px">Sale price</th>
                                        </thead> 
                                        <tbody class="timeline mt-10" >
                                            {{-- @forelse ($property->priceUpdates as $item) --}}
                                            @forelse ($property->priceUpdates->sortByDesc('created_at') as $item)
                                                <tr class="mt-5" > 
                                                    <div class="">
                                                        <td>
                                                            <div class="p-2">
                                                                <span class="apartment__info--title">{{ $item->updated_year}}</span>
                                                                </div>
                                                        </td>
                                                        <td>
                                                            <div  style="padding-left: 20px">
                                                                <span class="properties__details--info__title">
                                                                    ₦{{ number_format($item->updated_price, 2) }}
                                                                </span>
                                                                <div class="percent-change text-end">
                                                                    <p class="apartment__info--count" style="color: #47008E">
                                                                        + {{ $item->percentage_increase }}%
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </div>
                                                </tr>
                                            @empty
                        
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        
                      
                    </div>
                </div>
                
            </div>
            <!-- dashboard container .\ -->

        </main>
    </div>
</div>
        
       

@endsection 
