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
                        <h4 class="page-title">Edit Valuation</h4>
                    </div>
                    <!--end page-title-box-->
                </div>
                <!--end col-->
            </div>
            <!-- end page title end breadcrumb -->
            
                <div class="row">
                    <div class="col-lg-2">
                    </div><!--end col-->

                    <div class="col-lg-8">
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
                                    <h4 class="card-title">Update Valuation </h4>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('admin.properties.valuation.update', $propertyValuation->id ) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Update Valuation </h4>
                                            </div>
                                            <div class="card-body">
                                                <input type="hidden" class="form-control" name="property_id" value="{{ $propertyValuation->property_id}}" placeholder="Enter Valuation type" required>
            
                                                <div class="row">
                                                    <div class="mb-3">
                                                        <label for="exampleInputEmail1">Enter Valuation type</label>
                                                        <input type="text" class="form-control" name="valuation_type" value="{{ $propertyValuation->valuation_type}}" placeholder="Enter Valuation type" required>
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
                                                            value="{{ $property->price ? '₦' . number_format($propertyValuation->current_price, 2) : '' }}" 
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
                                                            value="{{ $property->price ? '₦' . number_format($propertyValuation->market_value, 2) : '' }}" 
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
                                                            <button type="submit" class="btn btn-primary">Update Valuation </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>
                   
                    </div>
                    <div class="col-lg-2"></div>
                </div><!--end row-->
               
  
        </div><!-- container -->

       
      
    </div>
    <!-- end page content -->
</div>
<!-- end page-wrapper -->


@endsection