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
                                                                <span class="apartment__info--title">{{ \Carbon\Carbon::parse($item->updated_year)->format('d F, Y')  }}</span>
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
                                    @php
                                        $defaultPreviousYear = now()->subYear()->year;
                                        $defaultPreviousPrice = 0.00;
                                        $actualPreviousYear = $previousPrice->previous_year ?? $defaultPreviousYear;
                                        $actualPreviousPrice = $previousPrice->updated_price ?? $defaultPreviousPrice;
                                    @endphp

                                    <form method="POST" action="{{ route('admin.properties.propertyHistory.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" class="form-control" name="property_id" value="{{ $property->id }}" required>

                                        <div class="row"> 
                                            <div class="mb-3">
                                                <label for="previous_year">Previous Year</label>
                                                <input type="date" class="form-control" 
                                                    {{-- value="₦{{ number_format($actualPreviousPrice, 2) }}"  --}}
                                                    id="previous_price_display"
                                                    name="previous_year" >
                                                {{-- <select name="previous_year" id="previous_year" class="form-select" required>
                                                    @php
                                                        $currentYear = now()->year;
                                                        $startYear = 2004;
                                                    @endphp
                                                    @for ($year = $startYear; $year <= $currentYear; $year++)
                                                        <option value="{{ $year }}" {{ $year == $actualPreviousYear ? 'selected' : '' }}>
                                                            {{ $year }}
                                                        </option>
                                                    @endfor
                                                </select> --}}
                                            
                                                @error('previous_year')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            
                                            

                                            <div class="mb-3">
                                                <label>Previous Price</label>
                                                <input type="text" class="form-control" 
                                                    value="₦{{ number_format($actualPreviousPrice, 2) }}" 
                                                    id="previous_price_display"
                                                    name="previous_price_display" disabled>
                                                <input type="hidden" name="previous_price" value="{{ $actualPreviousPrice }}">
                                                @error('previous_price')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label>Enter New Price</label>
                                                <input type="text" placeholder="Enter New Price" class="form-control" name="updated_price" id="updated_price" required>
                                                @error('updated_price')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label>Price Increase (%)</label>
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    name="percentage_increase" 
                                                    id="priceIncrease" 
                                                    placeholder="Price Increase" 
                                                    readonly>
                                            </div>

                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </form>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            const updatedPriceInput = document.getElementById('updated_price');
                                            const priceIncreaseInput = document.getElementById('priceIncrease');
                                            const previousPrice = {{ $actualPreviousPrice }};

                                            updatedPriceInput.addEventListener('input', function (e) {
                                                let rawValue = e.target.value.replace(/,/g, '');
                                                if (!isNaN(rawValue) && rawValue !== '') {
                                                    const numericValue = parseFloat(rawValue);
                                                    e.target.value = new Intl.NumberFormat().format(numericValue);

                                                    if (previousPrice > 0) {
                                                        const percentageIncrease = ((numericValue - previousPrice) / previousPrice) * 100;
                                                        priceIncreaseInput.value = percentageIncrease.toFixed(2);
                                                    } else {
                                                        priceIncreaseInput.value = '';
                                                    }
                                                } else {
                                                    priceIncreaseInput.value = '';
                                                }
                                            });
                                        });
                                    </script>

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