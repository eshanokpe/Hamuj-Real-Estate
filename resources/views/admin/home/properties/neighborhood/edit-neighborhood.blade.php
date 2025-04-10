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
                        <h4 class="page-title">Edit Neighborhood</h4>
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
                                <h4 class="card-title">Neighborhood Details </h4>
                            </div><!--end card-header--> 
                            <div class="card-body">
                                @forelse ($neighborhoods as $item)
                                    <div class="row d-flex justify-content-center mb-3">                                                
                                        <div class="col">
                                            <p class="text-dark mb-1 fw-semibold">{{ $item->property->name }}</p>
                                            <p class="font-22 fw-bold">{{ $item->neighborhood_name }}<snap style="font-size: 18px"  class="mb-0  text-muted"> ({{ $item->category->name }}) </snap></p> 
                                            {{-- <p class="font-18 fw-">{{ $item->category->name }}</p>  --}}
                                            <p class="mb-0 text-truncate text-muted">{{  \Carbon\Carbon::parse($item->created_at)->format('d F, Y') }} </p>
                                            
                                        </div>
                                        <div class="col-auto align-self-center">
                                            <div class="bg-light-alt d-flex justify-content-center align-items-center  ">
                                               <snap class="mb-0 text-truncate text-muted"> {{ $item->distance}} miles </snap>
                                                <a href="{{ route('admin.properties.neighborhood.edit', encrypt($item->id)) }}" class="btn btn-link text-secondary p-2" >
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
                                    <h4 class="card-title">Update Neighborhood Details for {{ $property->name }} </h4>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('admin.properties.neighborhood.update', $neighborhood->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT') 
                                        <input type="hidden" name="id" value="{{ $neighborhood->id ?? '' }}">
                                        <input type="hidden" name="property_id" value="{{ $property->id }}">
                                        
                                        <div class="row">
                                            <div class="mb-3">
                                                <label for="neighborhood_category_id">Category</label>
                                                <select name="neighborhood_category_id" id="neighborhood_category_id" class="form-control" required>
                                                    <option value="" disabled {{ $neighborhood->neighborhood_category_id ? '' : 'selected' }}>Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" 
                                                            {{ (isset($neighborhood->neighborhood_category_id) && $neighborhood->neighborhood_category_id == $category->id) ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="neighborhood_name">Enter Neighborhood Name</label>
                                                <input type="text" class="form-control" name="neighborhood_name" 
                                                    value="{{ $neighborhood->neighborhood_name ?? '' }}" 
                                                    placeholder="Enter Neighborhood Name" required>
                                                @error('neighborhood_name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="distance">Enter Distance</label>
                                                <input type="number" step="0.01" class="form-control" name="distance" 
                                                    value="{{ $neighborhood->distance ?? '' }}" 
                                                    placeholder="Enter Distance" step="0.00001" required>
                                                @error('distance')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            

                                            <div class=" mb-3">
                                                <div class="col-lg-1"></div>
                                                <div class="col-lg-6">
                                                    <button type="submit" class="btn btn-primary">Update </button>
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