@extends('layouts.admin')

@section('content')

<div class="page-wrapper">
    <!-- Page Content-->
    <div class="page-content-tab">
        <div class="container-fluid">

            <!-- Page Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="float-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.property.createPropertyType') }}" class="btn btn-dark">Add Property Type</a>
                                </li>
                            </ol> 
                        </div>
                        <h4 class="page-title">Property Types</h4>
                    </div>
                </div>
            </div>
            <!-- End Page Title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Property Type List</h4>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th class="width80">#</th>
                                            <th>Title & Subtitles</th>
                                            <th>Created Date</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($propertyTypes as $type)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <strong>{{ $type->title }}</strong>
                                                    @if(!empty($type->subtitles))
                                                        <div class="mt-2">
                                                            @foreach($type->subtitles as $subtitle)
                                                                <span class="badge bg-secondary">{{ $subtitle }}</span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{{ $type->created_at->format('d M, Y') }}</td>
                                                <td class="text-end">
                                                    <a href="{{ route('admin.property.type.edit', encrypt($type->id) ) }}" class="btn btn-sm btn-primary">Edit</a>

                                                    <form action="{{ route('admin.property.type.destroy', encrypt($type->id) ) }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button 
                                                            type="submit" 
                                                            class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Are you sure you want to delete this property type?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No Property Types Found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> 
            </div> 

        </div>
    </div>
</div>

@endsection
