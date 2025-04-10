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
                                <a href="{{ route('admin.buy.index')}}" class="btn btn-dark">View Buy Property</a>
                            </ol>
                        </div>
                        <h4 class="page-title">Update Buy Property </h4>
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
                            <h4 class="card-title">Update Buy Property for {{ $buy->user_email}}</h4>
                         </div><!--end card-header--> 
                        <div class="card-body">
                           
                            <form method="POST" action="{{ route('admin.buy.update', $buy->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">User ID</label>
                                            <input type="text" class="form-control" name="user_id" value="{{ $buy->user_id }}" placeholder="Title" readonly  required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">User Email</label>
                                            <input type="text" class="form-control" name="user_email" value="{{ $buy->user_email}}" placeholder="Title" readonly required>                                
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">Property ID</label>
                                            <input type="text" class="form-control" name="property_id" value="{{ $buy->property_id}}" placeholder="Title" readonly required>                                
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">Transaction ID</label>
                                            <input type="text" class="form-control" name="transaction_id" value="{{ $buy->transaction_id }}" placeholder="Title" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">Selected Size Land</label>
                                            <input type="text" class="form-control" name="selected_size_land" value="{{ $buy->selected_size_land}}" placeholder="Title" readonly required>                                
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">Remaining Size</label>
                                            <input type="text" class="form-control" name="remaining_size" value="{{ $buy->remaining_size}}" placeholder="Title" readonly required>                                
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">Total Price</label>
                                            <input type="text" class="form-control" name="total_price" value="{{ number_format($buy->total_price, 2) }}" placeholder="Title" readonly required>                                
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="status">Status</label>
                                            <select name="status" class="form-control" required>
                                                <option value="{{ $buy->status }}" selected>{{ ucfirst($buy->status) }}</option>
                                                @if($buy->status !== 'sold')
                                                    <option value="sold">Sold</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-dark">Update </button>
                                <button type="reset" class="btn btn-danger">Cancel</button>
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