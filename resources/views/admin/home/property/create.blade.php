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
                        <h4 class="page-title">Add Property</h4>
                    </div>
                    <!--end page-title-box-->
                </div>
                <!--end col-->
            </div>
            <!-- end page title end breadcrumb -->
            <form method="POST" action="{{ route('admin.properties.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Creat Property </h4>
                            </div><!--end card-header--> 
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Property Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Enter Property Name" required>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Property Description</label>
                                        <textarea id="basic-conf" name="description"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Property Location</label>
                                        <input type="text" class="form-control" name="location" placeholder="Enter Location" required>
                                        @error('location')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1"> State</label>
                                                <select name="city" id="state" class="form-select">
                                                    <option value="">Select a state</option>
                                                    @foreach ($city as $city)
                                                        <option value="{{ $city }}" >
                                                            {{ $city }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('city')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1"> Country</label>
                                            <select name="country" class="form-select">
                                                    <option>Nigeria</option>
                                            </select>
                                                @error('country')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="launchPrice">Launch Price</label>
                                        <input type="number" class="form-control" id="launchPrice" name="lunch_price" placeholder="Enter Launch Price" value="" required>
                                        @error('lunch_price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="currentPrice">Current Price</label>
                                        <input type="number" class="form-control" id="currentPrice" name="price" placeholder="Enter Current Price" value="" required>
                                        @error('price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="priceIncrease">Price Increase (%)</label>
                                        <input type="text" class="form-control" name="percentage_increase" id="priceIncrease" placeholder="Price Increase" readonly>
                                    </div>
                                    
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            const launchPriceInput = document.getElementById('launchPrice');
                                            const currentPriceInput = document.getElementById('currentPrice');
                                            const priceIncreaseInput = document.getElementById('priceIncrease');
                                    
                                            function calculateIncrease() {
                                                const launchPrice = parseFloat(launchPriceInput.value) || 0;
                                                const currentPrice = parseFloat(currentPriceInput.value) || 0;
                                                if (launchPrice > 0 && currentPrice > 0) {
                                                    const increasePercentage = ((currentPrice - launchPrice) / launchPrice) * 100;
                                                    priceIncreaseInput.value = increasePercentage.toFixed(2) + '%';
                                                } else {
                                                    priceIncreaseInput.value = 'N/A';
                                                }
                                            }
                                    
                                            launchPriceInput.addEventListener('input', calculateIncrease);
                                            currentPriceInput.addEventListener('input', calculateIncrease);
                                    
                                            // Trigger calculation on page load
                                            calculateIncrease();
                                        });
                                    </script>
                                    
                                    
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Size (sq. ft.)</label>
                                        <input type="text" class="form-control" name="size" placeholder="Enter Land Size" required>
                                        @error('size')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="currentPrice">Gazette Number</label>
                                        <input type="text" class="form-control" id="gazetteNumber" name="gazette_number" placeholder="Enter Gazette Number" value="{{ $property->gazette_number ?? '' }}" required>
                                        @error('gazette_number')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="currentPrice">Tenure Free</label>
                                        <input type="text" class="form-control" id="tenureFree" name="tenure_free" placeholder="Enter  Tenure Free" value="{{ $property->tenure_free ?? '' }}" required>
                                        @error('tenure_free')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                  
                                
                                                    
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end col-->
                    <div class="col-lg-5 ">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1">Property Image</label>
                                    <input onchange="previewImage(event)" class="form-control" type="file" value="" name="property_images" required>
                                    @error('property_images')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <img id="image-preview" src="" alt="Image Preview" class="img-thumbnail mt-2" style="display:none; max-width: 200px;">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1">Upload Payment Plan</label>
                                    <input onchange="paymentPlan(event)" type="file" class="form-control" name="payment_plan" required>
                                    @error('payment_plan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <img id="image-paymentPlan" src="" alt="Image Preview" class="img-thumbnail mt-2" style="display:none; max-width: 200px;">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1">Upload Brochure</label>
                                    <input onchange="previewBrochure(event)" type="file" class="form-control" name="brochure" required>
                                    @error('brochure')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <img id="image-Brochure" src="" alt="Image Preview" class="img-thumbnail mt-2" style="display:none; max-width: 200px;">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1">Land Survey</label>
                                    <input onchange="previewLandSurvey(event)" type="file" class="form-control" name="land_survey" required>
                                    @error('land_survey')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <img id="image-LandSurvey" src="" alt="Image Preview" class="img-thumbnail mt-2" style="display:none; max-width: 200px;">
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1">Upload Contract deed document</label>
                                    <input onchange="previewContractDeed(event)" type="file" class="form-control" name="contract_deed" required>
                                    @error('contract_deed')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <img id="image-contractDeed" src="" alt="Image Preview" class="img-thumbnail mt-2" style="display:none; max-width: 200px;">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="exampleInputEmail1">Video Link</label>
                                    <input type="text" class="form-control" name="video_link" placeholder="Video Link" required>
                                    @error('video_link')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1">Google map Link</label>
                                    <input type="text" class="form-control" name="google_map"  placeholder="Google map Link" >
                                    @error('google_map')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="exampleInputEmail1">Property Status</label>
                                    <select class="form-select" id="propertyStatus" name="status" required>
                                        <option value="available">Available</option>
                                        <option value="sold">Sold</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                @php
                                    use Carbon\Carbon;
                                @endphp
                            
                                <div class="mb-3"> 
                                    <label for="exampleInputEmail1">Year :</label>
                                    <input type="text" class="form-control" 
                                    min="1900" max="{{ Carbon::now()->year }}"
                                    name="year" placeholder="{{ Carbon::now()->year }}" value="{{ Carbon::now()->year }}" required>
                                    @error('year')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1"></div>
                </div><!--end row-->
                <div class="row mb-3">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-dark">Create Property </button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>
                </div>

            </form>    
            <script>
                function previewImage(event) {
                    const input = event.target;
                    const preview = document.getElementById('image-preview');
                    
                    if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        };
                        
                        reader.readAsDataURL(input.files[0]);
                    }
                }
                function paymentPlan(event) {
                    const input = event.target;
                    const preview = document.getElementById('image-paymentPlan');
                    
                    if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        };
                        
                        reader.readAsDataURL(input.files[0]);
                    }
                }
                function previewBrochure(event) {
                    const input = event.target;
                    const preview = document.getElementById('image-Brochure');
                    
                    if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        };
                        
                        reader.readAsDataURL(input.files[0]);
                    }
                }
                function previewLandSurvey(event) {
                    const input = event.target;
                    const preview = document.getElementById('image-LandSurvey');
                    
                    if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        };
                        
                        reader.readAsDataURL(input.files[0]);
                    }
                }
                function previewContractDeed(event) {
                    const input = event.target;
                    const preview = document.getElementById('image-contractDeed');
                    
                    if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        };
                        
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            </script>  
           
        </div><!-- container -->

        <!--Start Rightbar-->
        <!--Start Rightbar/offcanvas-->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="Appearance" aria-labelledby="AppearanceLabel">
            <div class="offcanvas-header border-bottom">
              <h5 class="m-0 font-14" id="AppearanceLabel">Appearance</h5>
              <button type="button" class="btn-close text-reset p-0 m-0 align-self-center" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">  
                <h6>Account Settings</h6>
                <div class="p-2 text-start mt-3">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch1">
                        <label class="form-check-label" for="settings-switch1">Auto updates</label>
                    </div><!--end form-switch-->
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch2" checked>
                        <label class="form-check-label" for="settings-switch2">Location Permission</label>
                    </div><!--end form-switch-->
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="settings-switch3">
                        <label class="form-check-label" for="settings-switch3">Show offline Contacts</label>
                    </div><!--end form-switch-->
                </div><!--end /div-->
                <h6>General Settings</h6>
                <div class="p-2 text-start mt-3">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch4">
                        <label class="form-check-label" for="settings-switch4">Show me Online</label>
                    </div><!--end form-switch-->
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch5" checked>
                        <label class="form-check-label" for="settings-switch5">Status visible to all</label>
                    </div><!--end form-switch-->
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="settings-switch6">
                        <label class="form-check-label" for="settings-switch6">Notifications Popup</label>
                    </div><!--end form-switch-->
                </div><!--end /div-->               
            </div><!--end offcanvas-body-->
        </div>
        <!--end Rightbar/offcanvas-->
        <!--end Rightbar-->
        
      
    </div>
    <!-- end page content -->
</div>
<!-- end page-wrapper -->


@endsection