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
                        <h4 class="page-title"> Neighborhood Category</h4>
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
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead> 
                                            <tr>
                                                <th class="width80">#</th>
                                                <th>Name</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($categories as $item)
                                                <tr>
                                                    <td><strong>{{ $loop->iteration }}</strong></td>
                                                    <td>{{ $item->name }}</td>
                             
                                                   
                                                    <td class="text-end">
                                                        <a href="{{ route('admin.properties.neighborhood.category.edit', encrypt($item->id)) }}">
                                                            <i class="las la-pen text-secondary font-16"></i>
                                                        </a>
                                                      
                                                        <form action="{{ route('admin.properties.neighborhood.category.delete', encrypt($item->id)) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-link text-secondary p-0" onclick="return confirm('Are you sure you want to delete this?');">
                                                                <i class="las la-trash-alt font-16"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No Neighborhood Category found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    
                                </div><!--end /tableresponsive-->
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
                                <h4 class="card-title">Add Neighborhood Category </h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.properties.neighborhood.category.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    {{-- @method('PUT')  --}}
                                    
                                    <div class="row">
                                        
                                        <div class="mb-3">
                                            <label for="neighborhood_name">Enter  Name</label>
                                            <input type="text" class="form-control" name="name" 
                                                placeholder="Enter  Name" required>
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class=" mb-3">
                                            <div class="col-lg-1"></div>
                                            <div class="col-lg-6">
                                                <button type="submit" class="btn btn-primary">Save </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                        @if($editNeighborhoodCategory)
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Neighborhood Category </h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.properties.neighborhood.category.update', $editNeighborhoodCategory->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT') 
                                    
                                    <div class="row">
                                        <input type="hidden" class="form-control" name="neighborhood_category_id" value="{{ $editNeighborhoodCategory->id}}" placeholder="Enter Valuation type" required>

                                        <div class="mb-3">
                                            <label for="neighborhood_name">Enter  Name</label>
                                            <input type="text" class="form-control" name="name"  value="{{ $editNeighborhoodCategory->name }}"
                                                placeholder="Enter  Name" required>
                                            @error('name')
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
                        @endif
                   
                    </div>
                    <div class="col-lg-1"></div>
                </div><!--end row-->
               
  
        </div><!-- container -->

       
      
    </div>
    <!-- end page content -->
</div>
<!-- end page-wrapper -->


@endsection