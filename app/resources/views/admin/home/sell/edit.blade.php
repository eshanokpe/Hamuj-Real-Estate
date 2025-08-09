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
                                <a href="{{ route('admin.sell.index')}}" class="btn btn-dark">View Sell Property</a>
                            </ol>
                        </div>
                        <h4 class="page-title">Update Sell Property </h4>
                    </div>
                    <!--end page-title-box-->
                </div>
                <!--end col-->
            </div>
            <!-- end page title end breadcrumb -->
            
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" style="text-transform:lowercase">Update Sell Property for {{ $sell->user_email}}</h4>
                         </div><!--end card-header--> 
                        <div class="card-body">
                           
                            <form method="POST" action="{{ route('admin.sell.update', $sell->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">User ID</label>
                                            <input type="text" class="form-control" name="user_id" value="{{ $sell->user_id }}" placeholder="Title" readonly  required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">User Email</label>
                                            <input type="text" class="form-control" name="user_email" value="{{ $sell->user_email}}" placeholder="Title" readonly required>                                
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">Property ID</label>
                                            <input type="text" class="form-control" name="property_id" value="{{ $sell->property_id}}" placeholder="Title" readonly required>                                
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">Transaction ID</label>
                                            <input type="text" class="form-control" name="transaction_id" value="{{ $sell->transaction_id }}" placeholder="Title" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">Selected Size Land</label>
                                            <input type="text" class="form-control" name="selected_size_land" value="{{ $sell->selected_size_land}}" placeholder="Title" readonly required>                                
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">Remaining Size</label>
                                            <input type="text" class="form-control" name="remaining_size" value="{{ $sell->remaining_size}}" placeholder="Title" readonly required>                                
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">Total Price</label>
                                            <input type="text" class="form-control" name="total_price" value="{{ number_format($sell->total_price, 2) }}" placeholder="Title" readonly required>                                
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="status">Status</label>
                                            <select name="status" class="form-control" required>
                                                <option value="{{ $sell->status }}" selected>{{ ucfirst($sell->status) }}</option>
                                                @if($sell->status !== 'sold')
                                                    <option value="sold">Sold</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                {{-- <button type="submit" class="btn btn-dark">Update </button> --}}
                                {{-- <button type="reset" class="btn btn-danger">Cancel</button> --}}
                                <a href="{{ route('admin.sell.index')}}"  class="btn btn-primary">Back</a>
                            </form>    
                                                    
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div><!--end col-->
                <div class="col-lg-2"></div>
            </div><!--end row-->

           
           
        </div>
        
      
    </div>
    <!-- end page content -->
</div>
<!-- end page-wrapper -->


@endsection