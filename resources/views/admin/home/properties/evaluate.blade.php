@extends('layouts.admin')

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
                        <h4 class="page-title">Valuation</h4>
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
                                <h4 class="card-title">Valuation  </h4>
                            </div><!--end card-header--> 
                            <div class="card-body">
                                <div class="row mb-3 d-flex justify-content-center">                                                
                                    <div class="col">
                                        <p class="text-dark mb-1 fw-semibold">Name of Property</p>
                                        <h4 class="font-22 fw-bold">{{ $property->name }}</h4> 
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center mb-3">                                                
                                    <div class="col">
                                        <p class="text-dark mb-1 fw-semibold">Initial Price</p>
                                        <h4 class="font-22 fw-bold">₦{{ number_format($property->lunch_price, 2) ?? '' }}</h4>   
                                    </div> 
                                </div>

                                <div class="row d-flex justify-content-center mb-3">                                                
                                    <div class="col">
                                        <p class="text-dark mb-1 fw-semibold">Current Price</p>
                                        <h4 class="font-22 fw-bold">₦{{ number_format($property->price, 2) ?? '' }}</h4> 
                                        
                                    </div>
                                    <div class="col-auto align-self-center">
                                        <div class="bg-light-alt d-flex justify-content-center align-items-center thumb-md  rounded-circle">
                                            {{-- <i data-feather="fas fa-angle-double-up" class="align-self-center text-muted icon-sm"></i>   --}}
                                            {{ $property->percentage_increase}}% <i class="fas fa-angle-double-up align-self-center text-success icon-md"></i>
                                        </div>
                                    </div> 
                                </div>

                            </div><!--end card-body-->
                        </div><!--end card-->

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Evaluation Variation  </h4>
                            </div><!--end card-header--> 
                            <div class="card-body">
                                @forelse ($propertyValuation as $item)
                                    <div class="row d-flex justify-content-center mb-3">                                                
                                        <div class="col">
                                            <p class="text-dark mb-1 fw-semibold">{{ $item->valuation_type }}</p>
                                            <h4 class="font-22 fw-bold">₦{{ number_format($item->market_value, 2) ?? '' }}</h4> 
                                            <p class="mb-0 text-truncate text-muted">{{  \Carbon\Carbon::parse($item->created_at)->format('d F, Y') }} </p>
                                            
                                        </div>
                                        <div class="col-auto align-self-center">
                                            <div class="bg-light-alt d-flex justify-content-center align-items-center thumb-md  rounded-circle">
                                                {{-- <i data-feather="fas fa-angle-double-up" class="align-self-center text-muted icon-sm"></i>   --}}
                                                {{ $item->percentage_increase}}% <i class="fas fa-angle-double-up align-self-center text-success icon-md"></i>
                                                <a href="{{ route('admin.properties.valuation.edit', encrypt($item->id)) }}" class="btn btn-link text-secondary p-2" >
                                                    <i class="las la-pen font-16"></i>
                                                </a>
                                            </div>
                                        </div> 
                                    </div>
                                @empty
                                    <p>No valuation</p>
                                @endforelse
                               

                            

                            </div><!--end card-body-->
                        
                        </div><!--end card-->

                    </div><!--end col-->


                    <div class="col-lg-5 ">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <div class="row align-items-center">
                                                                    <div class="col">                      
                                                                        <h4 class="card-title">Valuation Chart</h4>                      
                                                                    </div><!--end col-->
                                                                    <div class="col-auto"> 
                                                                        <div class="sales__report--short-by select">
                                                                            <form method="GET" id="sortForm">
                                                                                <select name="filter" class="sales__report--short-by__select" onchange="document.getElementById('sortForm').submit();">
                                                                                    <option value="">This Year</option>
                                                                                    @php
                                                                                        // Get the current year and the previous years to display in the options
                                                                                        $currentYear = date('Y');
                                                                                        $years = range($currentYear, $currentYear - 1); // You can adjust the range of years here
                                                                                    @endphp
                                                                                    @foreach ($years as $year)
                                                                                        <option value="{{ $year }}" {{ request('filter') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </form>
                                                                        </div>           
                                                                    </div><!--end col-->
                                                                </div>  <!--end row-->                                  
                                                            </div><!--end card-header-->
                                                            <div class="card-body">
                                                                <div id="ana_dash_2" class="apex-charts"></div>
                                                            </div><!--end card-body--> 
                                                        </div><!--end card-->
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                        
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                var valuationData = @json($valuationData); // Pass the valuation data to JavaScript
                                        
                                                var dates = valuationData.map(function(item) { return item.date; });
                                                var prices = valuationData.map(function(item) { return item.price; });
                                        
                                                var options = {
                                                    chart: {
                                                        type: 'line', // Line chart
                                                        height: 350,
                                                    },
                                                    series: [{
                                                        name: 'Price',
                                                        data: prices, // Property prices (current_price or market_value)
                                                    }],
                                                    plotOptions: {
                                                        bar: {
                                                            horizontal: false,
                                                            columnWidth: '30%',
                                                        },
                                                    },
                                                    stroke: {
                                                        width: [5, 5],
                                                    },
                                                    dataLabels: {
                                                        enabled: true,
                                                        enabledOnSeries: [1],
                                                        style: {
                                                            colors: ['rgba(255, 255, 255, .6)'],
                                                        },
                                                        background: {
                                                            enabled: true,
                                                            foreColor: '#b2bdcc',
                                                            padding: 4,
                                                            borderRadius: 2,
                                                            borderWidth: 1,
                                                            borderColor: '#b2bdcc',
                                                            opacity: 0.9,
                                                        },
                                                    },
                                                    colors: ["#a4b1c3", "#6f7b8b"],

                                                    xaxis: {
                                                        categories: dates, // X-axis values (dates)
                                                        
                                                    },
                                                    yaxis: {
                                                        title: {
                                                            text: 'Price (₦)'
                                                        }
                                                    },
                                                    title: {
                                                        text: 'Property Price Over Time',
                                                        align: 'center'
                                                    },
                                                    grid: {
                                                        row: {
                                                            colors: ['transparent', 'transparent'], // takes an array which will be repeated on columns
                                                            opacity: 0.2,           
                                                        },
                                                        strokeDashArray: 2.5,
                                                    },
                                                };
                                        
                                                var chart = new ApexCharts(document.querySelector("#ana_dash_2"), options);
                                                chart.render();
                                            });
                                        </script>
                                        
                                    </div>
                                </div> 
                            </div>
                        </div>
                        
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var valuationData = @json($valuationData); // Pass the valuation data to JavaScript
                        
                                var dates = valuationData.map(function(item) { return item.date; });
                                var percentages = valuationData.map(function(item) { return item.percentage_increase; });
                        
                                var options = {
                                    chart: {
                                        type: 'line', // Line chart
                                        height: 350,
                                    },
                                    series: [{
                                        name: 'Percentage Increase',
                                        data: percentages, // Values for percentage increase
                                    }],
                                    xaxis: {
                                        categories: dates, // X-axis values (dates)
                                        title: {
                                            text: 'Date'
                                        }
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Percentage Increase (%)'
                                        }
                                    },
                                    title: {
                                        text: 'Property Valuation Over Time',
                                        align: 'center'
                                    }
                                };
                        
                                var chart = new ApexCharts(document.querySelector("#ana_dash_1"), options);
                                chart.render();
                            });
                        </script>



                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('admin.properties.valuation') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Add Valuation </h4>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" class="form-control" name="property_id" value="{{ $property->id}}" placeholder="Enter Valuation type" required>

                                    <div class="row">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">Enter Valuation type</label>
                                            <input type="text" class="form-control" name="valuation_type" placeholder="Enter Valuation type" required>
                                            @error('valuation_type')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                     
                                        <div class="mb-3">
                                            <label for="launchPrice">Current Price (₦)</label>
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="currentPrice" 
                                                name="current_price" 
                                                placeholder="Enter Current Price" 
                                                value="{{ $property->price ? '₦' . number_format($property->price, 2) : '' }}" 
                                                required>
                                                @error('current_price')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="marketValue">Current Market Value (₦)</label>
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="marketValue" 
                                                name="market_value" 
                                                placeholder="Enter Current Market Value" 
                                                value="" 
                                                required>
                                            @error('market_value')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                const marketValueInput = document.getElementById('marketValue');
                                        
                                                marketValueInput.addEventListener('input', function () {
                                                    // Allow only numeric input, including decimals
                                                    this.value = this.value.replace(/[^0-9.]/g, '');
                                                });
                                        
                                                marketValueInput.addEventListener('blur', function () {
                                                    // Format the value as currency on blur
                                                    const numericValue = parseFloat(this.value.replace(/,/g, '')) || 0;
                                                    this.value = new Intl.NumberFormat('en-NG', {
                                                        style: 'currency',
                                                        currency: 'NGN',
                                                        minimumFractionDigits: 2
                                                    }).format(numericValue);
                                                });
                                        
                                                marketValueInput.addEventListener('focus', function () {
                                                    // Remove currency formatting on focus for easier editing
                                                    this.value = this.value.replace(/[^0-9.]/g, '');
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
                                                const currentPriceInput = document.getElementById('currentPrice');
                                                const marketPriceInput = document.getElementById('marketValue');
                                                const priceIncreaseInput = document.getElementById('priceIncrease');
                                        
                                                function parseCurrency(value) {
                                                    return parseFloat(value.replace(/[₦,]/g, '')) || 0;
                                                }
                                        
                                                function calculateIncrease() {
                                                    const currentPrice = parseCurrency(currentPriceInput.value);
                                                    const marketPrice = parseFloat(marketPriceInput.value) || 0;
                                        
                                                    if (currentPrice > 0 && marketPrice > 0) {
                                                        const increasePercentage = ((marketPrice - currentPrice) / currentPrice) * 100;
                                                        priceIncreaseInput.value = increasePercentage.toFixed(0) + '%';
                                                    } else {
                                                        priceIncreaseInput.value = '0.0';
                                                    }
                                                }
                                        
                                                currentPriceInput.addEventListener('input', calculateIncrease);
                                                marketPriceInput.addEventListener('input', calculateIncrease);
                                        
                                                // Trigger calculation on page load
                                                calculateIncrease();
                                            });
                                        </script>
                                        
                                        
                                        

                                        <div class=" mb-3">
                                            <div class="col-lg-1"></div>
                                            <div class="col-lg-6">
                                                <button type="submit" class="btn btn-primary">Add Valuation </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-1"></div>
                </div><!--end row-->
               
  
        </div><!-- container -->

       
      
    </div>
    <!-- end page content -->
</div>
<!-- end page-wrapper -->


@endsection