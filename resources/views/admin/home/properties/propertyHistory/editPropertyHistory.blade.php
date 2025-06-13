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
                        <h4 class="page-title">Edit Property History</h4>
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
                                    <h4 class="card-title">Edit Property History </h4>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('admin.properties.propertyHistory.update', encrypt($propertyHistory->id) ) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Update Property History </h4>
                                            </div>
                                            <div class="card-body">
                                                <input type="hidden" class="form-control" name="property_id" value="{{ $propertyHistory->property_id}}" placeholder="Enter Valuation type" required>
            
                                                <div class="row">
                                                    <div class="mb-3">
                                                        <label for="exampleInputEmail1">Enter Year</label>
                                                        <input type="number" class="form-control" name="updated_year" value="{{ $propertyHistory->updated_year}}" placeholder="Enter Year" min="1900" max="2099" step="1" required>
                                                        @error('updated_year')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="exampleInputEmail1">Previous Price (₦)</label>
                                                        <input type="text" class="form-control" 
                                                        value="₦{{ number_format($propertyHistory->previous_price, 2) }}" 
                                                        id="previous_price"
                                                        name="previous_price"  readonly>
                                                        @error('previous_price')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label for="marketValue">Updated Price (₦)</label>
                                                        <input 
                                                            type="text" 
                                                            class="form-control" 
                                                            id="updated_price" 
                                                            name="updated_price" 
                                                            placeholder="Enter Updated Price" 
                                                            value="{{ $propertyHistory->updated_price ? number_format($propertyHistory->updated_price, 2) : '' }}" 
                                                            required>
                                                        @error('updated_price')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function () {
                                                            var updatedPriceInput = document.getElementById('updated_price');
                                                            updatedPriceInput.addEventListener('input', function (e) {
                                                                var value = e.target.value.replace(/,/g, '');
                                                                if (!isNaN(value)) {
                                                                    e.target.value = new Intl.NumberFormat().format(value);
                                                                }
                                                            });

                                                            document.querySelector('form').addEventListener('submit', function () {
                                                                updatedPriceInput.value = updatedPriceInput.value.replace(/[₦,]/g, '');
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
                                                            value="{{ ($propertyHistory->percentage_increase) }}"
                                                            placeholder="Price Increase" 
                                                            readonly>
                                                    </div>
                                                    
                                                    <script>
                                                         document.addEventListener('DOMContentLoaded', function () {
                                                            var previousPrice = {{ $propertyHistory->updated_price }};
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
                                                            <button type="submit" class="btn btn-primary">Update  </button>
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