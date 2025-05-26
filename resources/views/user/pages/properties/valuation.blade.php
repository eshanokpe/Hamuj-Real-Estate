@extends('layouts.dashboard')


@section('content')

 
<div class="dashboard__page--wrapper">
    <div class="page__body--wrapper" id="dashbody__page--body__wrapper">
        <main class="main__content_wrapper">
            <!-- dashboard container -->
            <div class="dashboard__container d-flex">
                <div class="main__content--left">
                    <div class="main__content--left__inner">
                        <!-- Welcome section --> 
                        <div class="welcome__section align-items-center">
                            <div class="row mb-3 d-flex justify-content-center">                                                
                                <div class="col">
                                    <p class="text-dark mb-1 fw-semibold">Name of Property</p>
                                    <h3 class="font-22 fw-bold">{{ $property->name }}</h3> 
                                </div>
                            </div>
                            <div class="row mb-3 d-flex justify-content-center">                                                
                                <div class="col">
                                    <p class="text-dark mb-1 fw-semibold">Initial Price</p>
                                    <h3 class="font-22 fw-bold">₦{{ number_format($initialValueSum, 2) }}</h3> 
                                </div>
                            </div>
                            <div class="row mb-3 d-flex justify-content-center">                                                
                                <div class="col"> 
                                    <p class="text-dark mb-1 fw-semibold">Current Price</p>
                                    <h3 class="font-22 fw-bold">₦{{ number_format($marketValueSum, 2) }}</h3> 
                                </div>
                                <div class="col">
                                    <h3 class="font-22 fw-bold"> {{ $percentageIncrease}}%  
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="green">
                                            <path d="M12 4l8 8h-6v8h-4v-8H4l8-8z"/>
                                        </svg>
                                    </h3> 
                                </div>
                            </div>
                        </div>
                        <!-- Welcome section .\ -->

                        <!-- Sales Report section -->
                        <div class="sales__report--section">
                            <div class="sales__report--heading d-flex  justify-content-between align-items-center mb-30">
                                <h2 class="sales__report--heading__title mb-3">Evaluation Variation</h2>
                            </div>
                            <div class="welcome__section align-items-center">
                                @forelse ($propertyValuation as $item)
                                    <div class="row mb-3 d-flex justify-content-center">                                                
                                        <div class="col">
                                            <p class="text-dark mb-1 fw-semibold">{{ $item->valuation_type }}</p>
                                            <h3 class="font-22 fw-bold">₦{{ number_format($item->market_value, 2) }}</h3> 
                                        </div>
                                        <div class="col">

                                            <h3 class="font-22 fw-bold"> {{ $item->percentage_increase}}%  
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="green">
                                                    <path d="M12 4l8 8h-6v8h-4v-8H4l8-8z"/>
                                                </svg>
                                            </h3> 
                                            <p class="text-dark mb-1 fw-semibold"> {{  \Carbon\Carbon::parse($item->created_at)->format('d F, Y') }} </p>

                                        </div>
                                    </div>
                                @empty
                                    <p>No valuation</p>
                                @endforelse
                            </div>
                        </div> 
                        <!-- Sales Report section .\ -->
                        <br/>
                         <!-- Sales Report section -->
                         <div class="sales__report--section">
                            <div class="sales__report--heading d-flex  justify-content-between align-items-center mb-30">
                                <h2 class="sales__report--heading__title mb-3">Evaluation Variation Prediction</h2>
                            </div>
                            <div class="welcome__section align-items-center">
                                @forelse ($propertyValuationPrediction as $item)
                                    <div class="row mb-3 d-flex justify-content-center">                                                
                                        <div class="col">
                                            <p class="text-dark mb-1 fw-semibold">{{ $item->valuation_type }}</p>
                                            <h3 class="font-22 fw-bold">₦{{ number_format($item->future_market_value, 2) }}</h3> 
                                        </div>
                                        <div class="col">

                                            <h3 class="font-22 fw-bold"> {{ $item->percentage_increase}}%  
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="green">
                                                    <path d="M12 4l8 8h-6v8h-4v-8H4l8-8z"/>
                                                </svg>
                                            </h3> 
                                            <p class="text-dark mb-1 fw-semibold"> {{  \Carbon\Carbon::parse($item->created_at)->format('d F, Y') }} </p>

                                        </div>
                                    </div>
                                @empty
                                    <p>No valuation</p>
                                @endforelse
                            </div>
                        </div>
                        <!-- Sales Report section .\ -->

                        
                      
                    </div>
                </div>
                <div class="main__content--right">
                    <div class="dashboard__chart--box mb-30">
                        <div class=" d-flex  justify-content-between  mb-10">
                            <h2 class="dashboard__chart--title">View Property Valuation</h2>
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
                            
                        </div>

                        <div class="dashboard__chart--box__inner">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        // Get valuation data from Blade and convert it into JavaScript arrays
                        const valuationData = @json($valuationData);
                    
                        // Extract dates and prices for the chart
                        const labels = valuationData.map(item => item.date);
                        const prices = valuationData.map(item => parseFloat(item.price.replace(/,/g, '')));
                    
                        // Dataset for the chart
                        const statisticsDataset = {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Property Valuation',
                                    backgroundColor: "#16a34a",
                                    borderColor: "#16a34a",
                                    color: "#707070",
                                    data: prices,
                                },
                            ],
                        };
                    
                        // Configuration for the chart
                        const statisticsConfig = {
                            type: "line", // Type of the chart
                            data: statisticsDataset, // The data to display on the chart
                            options: {
                                responsive: true, // Makes the chart responsive
                                maintainAspectRatio: false, // Allows the chart to resize dynamically
                                plugins: {
                                    legend: {
                                        display: true, // Hides the legend
                                    },
                                },
                            },
                        };
                    
                        // Initialize the chart
                        const statisticsChart = new Chart(document.getElementById("myChart"), statisticsConfig);
                    </script>
                    
                    
                </div>
            </div>
            <!-- dashboard container .\ -->

        </main>
    </div>
</div>
        
       

@endsection 
