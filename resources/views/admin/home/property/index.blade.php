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
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.properties.create')}}" class="btn btn-dark">Add Property</a>
                                </li>
                            </ol>
                        </div>
                        <h4 class="page-title">Property</h4>
                    </div>
                    <!--end page-title-box-->
                </div>
                <!--end col-->
            </div>
            <!-- end page title end breadcrumb -->
           

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Property List</h4>
                           
                        </div><!--end card-header-->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead> 
                                        <tr>
                                            <th class="width80">#</th>
                                            <th>Name</th>
                                            <th>Content</th>
                                            <th>Image</th>
                                            <th>DATE</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($properties as $property)
                                            <tr>
                                                <td><strong>{{ $loop->iteration }}</strong></td>
                                                <td>{{ $property->name }}</td>
                                                <td>{!! Str::limit($property->description, 80) !!}</td>
                                                <td>
                                                    <img style="width: 100px; height: 100px; object-fit: cover;" 
                                                         src="{{ asset($property->property_images) }}" 
                                                         class="img-thumbnail" 
                                                         alt="{{ $property->name }}" />
                                                </td>
                                                <td>{{ $property->created_at ? $property->created_at->format('d F Y') : 'N/A' }}</td>
                                                <td class="text-end">
                                                    <a href="{{ route('admin.properties.edit', encrypt($property->id)) }}">
                                                        <i class="las la-pen text-secondary font-16"></i>
                                                    </a>
                                                    <form action="{{ route('admin.properties.destroy', encrypt($property->id)) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link text-secondary p-0" onclick="return confirm('Are you sure you want to delete this property?');">
                                                            <i class="las la-trash-alt font-16"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No properties found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                
                            </div><!--end /tableresponsive-->
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!-- end col -->

            </div> <!-- end row -->



        </div><!-- container -->

        
        
      
    </div>
    <!-- end page content -->
</div>
<!-- end page-wrapper -->

@endsection