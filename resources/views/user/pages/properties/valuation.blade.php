
@extends('layouts.dashboard')

@section('content')
<div class="dashboard__page--wrapper">
    <div class="page__body--wrapper" id="dashbody__page--body__wrapper">
        <main class="main__content_wrapper">
            <!-- Dashboard Container -->
            <div class="row mb-30 ml-20" style="margin-left: 10px">
                <div class="col-6">
                    <div class="main__content--left__inner">
                        <!-- Welcome Section -->
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
                        <!-- Welcome Section End -->

                        <!-- Sales Report Section -->
                        <div class="sales__report--section">
                            <div class="sales__report--heading d-flex justify-content-between align-items-center mb-30">
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
                                            <p class="text-dark mb-1 fw-semibold">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p>No valuation</p>
                                @endforelse
                            </div>
                        </div> 
                        <!-- Sales Report Section End -->
                        <br/>
                        <!-- Sales Report Section -->
                        <div class="sales__report--section">
                            <div class="sales__report--heading d-flex justify-content-between align-items-center mb-30">
                                <h2 class="sales__report--heading__title mb-3">Evaluation Variation Prediction</h2>
                            </div>
                            <div class="welcome__section align-items-center">
                                @forelse ($propertyValuationPrediction as $item)
                                    <div class="row mb-3 d-flex justify-content-center">                                                
                                        <div class="col">
                                            <p class="text-dark mb-1 fw-semibold"> {{  \Carbon\Carbon::parse($item->future_date)->format('d F, Y') }} </p>
                                            
                                            <p class="text-dark mb-1 fw-semibold">{{ $item->valuation_type }}</p>
                                            <h3 class="font-22 fw-bold">₦{{ number_format($item->future_market_value, 2) }}</h3> 
                                        </div>
                                        <div class="col">
                                            <h3 class="font-22 fw-bold"> {{ $item->percentage_increase}}%  
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="green">
                                                    <path d="M12 4l8 8h-6v8h-4v-8H4l8-8z"/>
                                                </svg>
                                            </h3> 
                                        </div>
                                    </div>
                                @empty
                                    <p>No valuation</p>
                                @endforelse
                            </div>
                        </div>
                        <!-- Sales Report Section End -->
                    </div>
                </div>
                 <div class="col-6">
                    <div class="dashboard__chart--box mb-30">
                        <div class="d-flex justify-content-between mb-10">
                            <h2 class="dashboard__chart--title">View Property Valuation</h2>
                            <div class="sales__report--short-by select">
                                <form method="GET" id="sortForm">
                                    <select name="filter" class="sales__report--short-by__select" onchange="document.getElementById('sortForm').submit();">
                                        <option value="">All</option>
                                        <option value="1d">1 Day Ago</option>
                                        <option value="1w">1 Week Ago</option>
                                        <option value="1m">1 Month Ago</option>
                                        @php
                                            $currentYear = date('Y');
                                            $years = range($currentYear, $currentYear - 5);
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
                    <!-- Moment.js for relative time -->
                    <script src="https://momentjs.com/downloads/moment.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        // Get valuation data from Blade and convert it into JavaScript arrays
                        const valuationData = @json($valuationData ?? []);
 
                        // Extract and sort dates and prices
                        const sortedData = valuationData.sort((a, b) => new Date(a.date) - new Date(b.date));
                        const labels = sortedData.map(item => item.date);
                        const prices = sortedData.map(item => parseFloat(item.price.replace(/,/g, '')));

                        // Current date for the vertical line (02:40 AM WAT, June 13, 2025)
                        const currentDate = new Date('2025-06-13T02:40:00+01:00'); // 02:40 AM WAT
                        const currentIndex = labels.findIndex(date => new Date(date) >= currentDate) || labels.length - 1;

                        // Custom function to convert date to relative time
                        function toRelativeTime(dateStr) {
                            const date = new Date(dateStr);
                            const diffMs = currentDate - date;
                            const diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));
                            const diffMonths = Math.floor(diffDays / 30);
                            const diffYears = Math.floor(diffDays / 365);

                            if (diffYears > 0) return `${diffYears} yr${diffYears > 1 ? 's' : ''} ago`;
                            if (diffMonths > 0) return `${diffMonths} month${diffMonths > 1 ? 's' : ''} ago`;
                            return `${diffDays} day${diffDays !== 1 ? 's' : ''} ago`;
                        }

                        // Dataset for the chart
                        const statisticsDataset = {
                            labels: labels.map(date => toRelativeTime(date)), // Convert to relative time
                            datasets: [{
                                label: 'Property Valuation',
                                backgroundColor: 'rgba(22, 163, 74, 0.2)', // Light green fill
                                borderColor: '#16a34a', // Solid green line
                                pointBackgroundColor: '#16a34a', // Green points
                                pointBorderColor: '#fff', // White border for points
                                pointRadius: currentIndex === -1 ? 0 : (i => i === currentIndex ? 4 : 0), // Highlight current point
                                pointHoverRadius: 6,
                                data: prices,
                                fill: true, // Fill under the line
                                tension: 0.4 // Smooth curve
                            }]
                        };

                        // Configuration for the chart
                        const statisticsConfig = {
                            type: 'line',
                            data: statisticsDataset,
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false // Hide legend
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                return `₦${context.raw.toLocaleString()}`;
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        display: true,
                                        title: {
                                            display: false
                                        },
                                        ticks: {
                                            maxRotation: 0,
                                            minRotation: 0,
                                            callback: function(value, index) {
                                                return this.getLabelForValue(index); // Use the relative time labels
                                            }
                                        }
                                    },
                                    y: {
                                        beginAtZero: false,
                                        title: {
                                            display: false
                                        },
                                        ticks: {
                                            callback: function(value) {
                                                return '₦' + value.toLocaleString();
                                            }
                                        }
                                    }
                                },
                                elements: {
                                    line: {
                                        borderWidth: 2
                                    },
                                    point: {
                                        hitRadius: 10
                                    }
                                },
                                annotation: {
                                    annotations: [{
                                        type: 'line',
                                        mode: 'vertical',
                                        scaleID: 'x',
                                        value: toRelativeTime(labels[currentIndex]) || toRelativeTime(labels[labels.length - 1]), // Vertical line at current date
                                        borderColor: 'rgba(255, 255, 255, 0.3)', // Dashed line color
                                        borderWidth: 1,
                                        borderDash: [5, 5], // Dashed style
                                        label: {
                                            enabled: false
                                        }
                                    }]
                                }
                            }
                        };

                        // Initialize the chart
                        const statisticsChart = new Chart(document.getElementById('myChart'), statisticsConfig);

                        // Update chart when filter changes
                        document.getElementById('sortForm').addEventListener('submit', function(e) {
                            e.preventDefault();
                            const filter = this.querySelector('select').value;
                            let filteredLabels = [...labels];
                            let filteredPrices = [...prices];
                            const now = new Date();
                            if (filter) {
                                let startDate;
                                if (filter === '1d') startDate = new Date(now.setDate(now.getDate() - 1));
                                else if (filter === '1w') startDate = new Date(now.setDate(now.getDate() - 7));
                                else if (filter === '1m') startDate = new Date(now.setMonth(now.getMonth() - 1));
                                else startDate = new Date(now.getFullYear() - (filter === 'all' ? 5 : 0), 0, 1);
                                if (filter !== 'all' && !['1d', '1w', '1m'].includes(filter)) startDate.setFullYear(filter);
                                const startIndex = labels.findIndex(date => new Date(date) >= startDate);
                                filteredLabels = labels.slice(startIndex >= 0 ? startIndex : 0);
                                filteredPrices = prices.slice(startIndex >= 0 ? startIndex : 0);
                            }
                            const newCurrentIndex = filteredLabels.findIndex(label => new Date(label) >= currentDate) || filteredLabels.length - 1;
                            const newLabels = filteredLabels.map(date => toRelativeTime(date));

                            statisticsChart.data.labels = newLabels;
                            statisticsChart.data.datasets[0].data = filteredPrices;
                            statisticsChart.data.datasets[0].pointRadius = newCurrentIndex === -1 ? 0 : (i => i === newCurrentIndex ? 4 : 0);
                            statisticsChart.options.annotation.annotations[0].value = newLabels[newCurrentIndex] || newLabels[newLabels.length - 1];
                            statisticsChart.update();
                        });
                    </script>
                </div>
            </div>
            <!-- Dashboard Container End -->
        </main>
    </div>
</div>
@endsection