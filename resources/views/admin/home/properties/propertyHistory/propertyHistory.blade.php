@extends('layouts.admin')
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

<div class="page-wrapper">

    <!-- Page Content-->
    <div class="page-content-tab">

        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="float-end">
                            <ol class="breadcrumb">
                                <a href="{{ route('admin.properties.index')}}" class="btn btn-dark">View Property</a>
                            </ol>
                        </div>
                        <h4 class="page-title">Property History</h4>
                    </div>
                    <!--end page-title-box-->
                </div>
                <!--end col-->
            </div>
            <!-- end page title end breadcrumb -->
            
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-5">
                        
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Property History Details </h4>
                            </div><!--end card-header--> 
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table cart__table table-borderless" border="0">
                                        <thead class="thead-light">
                                            <th>Year sold</th>
                                            <th style="padding-left: 20px">Sold price</th>
                                            <th style="padding-left: 20px">Action</th>
                                        </thead> 
                                        <tbody class="timeline mt-10" >
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
                                                                    <span class="apartment__info--count">
                                                                        + {{ $item->percentage_increase }}%
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('admin.properties.propertyHistory.edit', encrypt($item->id)) }}" class="btn btn-link text-secondary" >
                                                                <i class="las la-pen font-16"></i>
                                                            </a>
                                                            <a href="{{ route('admin.properties.propertyHistory.delete', encrypt($item->id)) }}" class="btn btn-link text-secondary" onclick="return confirm('Are you sure you want to delete this Property history?');">
                                                                <i class="las la-trash-alt font-16"></i>
                                                            </a>
                                                        </td>
                                                    </div>
                                                </tr>
                                            @empty
                        
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end col-->

                    <div class="col-lg-5 ">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Add Property History Details for {{ $property->name }} </h4>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('admin.properties.propertyHistory.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" class="form-control" name="property_id" value="{{ $property->id}}" placeholder="Enter Valuation type" required>

                                        <div class="row"> 
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1">Pevious Year</label>
                                                <input type="text" class="form-control" 
                                                value="{{$previousPrice->previous_year }}" disabled
                                                name="previous_year"  required>
                                                @error('previous_year')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1">Previous Price</label>
                                                <input type="text" class="form-control" 
                                                value="₦{{ number_format($previousPrice->updated_price, 2) }}" disabled
                                                id="previous_price"
                                                name="previous_price"  required>
                                                @error('previous_price')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1">Enter New Price </label>
                                                <input type="text" placeholder="Enter New Price" class="form-control" name="updated_price" id="updated_price" required>
                                            </div>
                                             @error('updated_price')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                            <script>
                                                document.addEventListener('DOMContentLoaded', function () {
                                                    var updatedPriceInput = document.getElementById('updated_price');
                                                    updatedPriceInput.addEventListener('input', function (e) {
                                                        var value = e.target.value.replace(/,/g, '');
                                                        if (!isNaN(value)) {
                                                            e.target.value = new Intl.NumberFormat().format(value);
                                                        }
                                                    });
                                                });
                                            </script>

                                            <div class="mb-3">
                                                <label for="priceIncrease">Price Increase (%)</label>
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    name="percentage_increase" 
                                                    id="priceIncrease" 
                                                    placeholder="Price Increase" 
                                                    readonly>
                                            </div>
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function () {
                                                    var previousPrice = {{ $previousPrice->updated_price }};
                                                    var updatedPriceInput = document.getElementById('updated_price');
                                                    var priceIncreaseInput = document.getElementById('priceIncrease');

                                                    updatedPriceInput.addEventListener('input', function (e) {
                                                        var value = e.target.value.replace(/,/g, '');
                                                        if (!isNaN(value) && value !== '') {
                                                            var updatedPrice = parseFloat(value);
                                                            var percentageIncrease = ((updatedPrice - previousPrice) / previousPrice) * 100;
                                                            priceIncreaseInput.value = percentageIncrease.toFixed(2);
                                                        } else {
                                                            priceIncreaseInput.value = '';
                                                        }
                                                    });
                                                });
                                            </script>

                                            <div class=" mb-3">
                                                <div class="col-lg-1"></div>
                                                <div class="col-lg-6">
                                                    <button type="submit" class="btn btn-primary">Save </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>
                   
                    </div>
                    <div class="col-lg-1"></div>
                </div><!--end row-->
               
  
        </div><!-- container -->

       
      
    </div>
    <!-- end page content -->
</div>
<!-- end page-wrapper -->


@endsection