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
                        <h4 class="page-title">Edit Property</h4>
                    </div>
                    <!--end page-title-box-->
                </div>
                <!--end col-->
            </div> 
            <!-- end page title end breadcrumb -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Property</h4>
                </div><!--end card-header--> 
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('admin.properties.update', $property->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-5">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1">Property Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter Property Name" value="{{ $property->name}}" required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1">Property Description</label>
                                    <textarea id="basic-conf" name="description">{{ $property->description}}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1">Property Location</label>
                                    <input type="text" class="form-control" name="location" placeholder="Enter Location" value="{{ $property->location}}" required>
                                    @error('location')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">Country</label>
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
                                   
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">State</label>
                                            <select name="state" id="state" class="form-select">
                                                <option value="">Select a State</option>
                                                @foreach ($state as $state)
                                                    <option value="{{ $state }}" {{ $property->state == $state ? 'selected' : '' }}>
                                                        {{ $state }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            
                                            @error('state')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                   
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">City</label>
                                            <input type="text" class="form-control" id="city" name="city" placeholder="Enter City" value="{{ $property->city ?? '' }}" required>
                                            @error('city')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="launchPrice">Launch Price</label>
                                    <input type="text" class="form-control" id="launchPrice" name="lunch_price" placeholder="Enter Launch Price" value="{{ $property->lunch_price ?? '' }}" required>
                                    @error('lunch_price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                   
                                <div class="mb-3">
                                    <label for="currentPrice">Current Price</label>
                                    <input type="text" class="form-control" id="currentPrice" name="price" placeholder="Enter Current Price" value="{{ $property->price ?? '' }}" required>
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
                                    <input type="text" class="form-control" id="tenureFree" name="tenure_free" placeholder="Enter Tenure Free" value="{{ $property->tenure_free ?? '' }}" required>
                                    @error('tenure_free')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="exampleInputEmail1">Size(sqm)</label>
                                    <input type="text" class="form-control" name="size" placeholder="Enter Land Size" value="{{ $property->size}}" required>
                                    @error('size')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1">Property Image</label>
                                    <input onchange="previewImage(event)" class="form-control" type="file" value="" name="property_images">
                                    @error('property_images')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    @if(isset($property))
                                    <img src="{{ asset($property->property_images) }}" alt="{{ $property->name }}" class="img-thumbnail mt-2" width="200">
                                    @endif
                                    <img id="image-preview" src="" alt="Image Preview" class="img-thumbnail mt-2" style="display:none; max-width: 200px;">
                                </div>
                                @php
                                    use Carbon\Carbon;
                                @endphp
                            
                                <div class="mb-3"> 
                                    <label for="exampleInputEmail1">Year:</label>
                                    <input type="text" class="form-control" 
                                    min="1900" max="{{ Carbon::now()->year }}"
                                    name="updated_year" placeholder="{{ Carbon::now()->year }}" value="{{ Carbon::now()->year }}" required>
                                    @error('updated_year')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>           
                            </div><!--end card-body-->
                        </div><!--end col-->
                        <div class="col-lg-5">
                            <div class="mb-3">
                                <label for="exampleInputEmail1">Land Survey</label>
                                <input onchange="previewLandSurvey(event)" type="file" class="form-control" name="land_survey">
                                @error('land_survey')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                @if(isset($property))
                                    <img src="{{ asset($property->land_survey) }}" alt="{{ $property->name }}" class="img-thumbnail mt-2" width="200">
                                @endif
                                <img id="image-LandSurvey" src="" alt="Image Preview" class="img-thumbnail mt-2" style="display:none; max-width: 200px;">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1">Land Information Certificate</label>
                                <input onchange="previewContractDeed(event)" type="file" class="form-control" name="contract_deed">
                                @error('contract_deed')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                @if(isset($property))
                                    <img src="{{ asset($property->contract_deed) }}" alt="{{ $property->name }}" class="img-thumbnail mt-2" width="200">
                                @endif
                                <img id="image-contractDeed" src="" alt="Image Preview" class="img-thumbnail mt-2" style="display:none; max-width: 200px;">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1">Video Link</label>
                                <input type="text" class="form-control" name="video_link" value="{{ $property->video_link }}" placeholder="Video Link">
                                @error('video_link')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1">Google map Link</label>
                                <input type="text" class="form-control" name="google_map" value="{{ $property->google_map }}" placeholder="Google map Link">
                                @error('google_map')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                           
                            <div class="mb-3">
                                <label for="exampleInputEmail1">Property Status</label>
                                <select class="form-select" id="propertyStatus" name="status" required>
                                    <option value="available" {{ $property->status == 'available' ? 'selected':''}}>Available</option>
                                    <option value="sold" {{ $property->status == 'sold' ? 'selected': ''}}>Sold</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-1"></div>
                    </div><!--end row-->
                    <div class="row mb-3">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-dark">Update Property</button>
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
            </div><!--end card-->
        </div><!-- container -->
    </div>
    <!-- end page content -->
</div>
<!-- end page-wrapper -->
@endsection