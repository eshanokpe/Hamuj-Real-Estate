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
                    <h4 class="card-title">Edit Property </h4>
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
                                        <input type="text" class="form-control" name="location" placeholder="Enter Location" value="{{ $property->location}}"  required>
                                        @error('location')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Price</label>
                                        <input type="number" class="form-control" name="price" placeholder="Enter Price" value="{{ $property->price}}"  required>
                                        @error('price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Size (sq. ft.)</label>
                                        <input type="text" class="form-control" name="size" placeholder="Enter Land Size" value="{{ $property->size}}" required>
                                        @error('size')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Property Image</label>
                                        <input onchange="previewImage(event)" class="form-control" type="file" value="" name="property_images" >
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
                                           
                            </div><!--end card-body-->
                    
                    </div><!--end col-->
                    <div class="col-lg-5">
                       
                        <div class="mb-3">
                            <label for="exampleInputEmail1">Upload Land Payment Plan</label>
                            <input onchange="paymentPlan(event)" type="file" class="form-control" name="payment_plan" >
                            @error('payment_plan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            @if(isset($property))
                                <img src="{{ asset($property->payment_plan) }}" alt="{{ $property->name }}" class="img-thumbnail mt-2" width="200">
                            @endif
                            <img id="image-paymentPlan" src="" alt="Image Preview" class="img-thumbnail mt-2" style="display:none; max-width: 200px;">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1">Upload Brochure</label>
                            <input onchange="previewBrochure(event)" type="file" class="form-control" name="brochure" >
                            @error('brochure')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            @if(isset($property))
                                <img src="{{ asset($property->brochure) }}" alt="{{ $property->name }}" class="img-thumbnail mt-2" width="200">
                            @endif
                            <img id="image-Brochure" src="" alt="Image Preview" class="img-thumbnail mt-2" style="display:none; max-width: 200px;">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1">Land Survey</label>
                            <input onchange="previewLandSurvey(event)" type="file" class="form-control" name="land_survey" >
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
                            <label for="exampleInputEmail1">Video Link</label>
                            <input type="text" class="form-control" name="video_link" value="{{ $property->video_link }}" placeholder="Video Link" >
                            @error('video_link')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1">Property Status</label>
                            <select class="form-select" id="propertyStatus" name="status" required>
                                <option value="available" {{ old('status') == 'available' ?'selected':''}}>Available</option>
                                <option value="sold" {{ old('status') == 'sold' ? 'selected':''}}>Sold</option>
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
                        <button type="submit" class="btn btn-dark">Upload Property </button>
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
            </script>    

            </div><!--end card-->
           
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