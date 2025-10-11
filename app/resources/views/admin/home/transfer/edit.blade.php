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
                                <a href="{{ route('admin.transfer.index')}}" class="btn btn-dark">View Transfer Property</a>
                            </ol>
                        </div>
                        <h4 class="page-title">Update Transfer Property </h4>
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
                            <h4 class="card-title">Update Transfer Property for {{ $transfer->user_email}}</h4>
                         </div><!--end card-header--> 
                        <div class="card-body">
                           
                            <form method="POST" action="{{ route('admin.transfer.update', $transfer->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">User ID</label>
                                            <input type="text" class="form-control" name="user_id" value="{{ $transfer->user_id }}" placeholder="Title" readonly  required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">User Email</label>
                                            <input type="text" class="form-control" name="user_email" value="{{ $transfer->user_email}}" placeholder="Title" readonly required>                                
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">Property ID</label>
                                            <input type="text" class="form-control" name="property_id" value="{{ $transfer->property_id}}" placeholder="Title" readonly required>                                
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">Property Name</label>
                                            <input type="text" class="form-control" name="property_name" value="{{ $transfer->property_name}}" placeholder="Title" readonly required>                                
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">Recipient ID</label>
                                            <input type="text" class="form-control" name="recipient_id" value="{{ $transfer->recipient_id}}" placeholder="Title" readonly required>                                
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">Land Size</label>
                                            <input type="text" class="form-control" name="land_size" value="{{ $transfer->land_size}}" placeholder="Title" readonly required>                                
                                        </div>
                                    </div>                                    
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">Transaction ID</label>
                                            <input type="text" class="form-control" name="refrence" value="{{ $transfer->reference }}" placeholder="Title" readonly required>
                                        </div>
                                    </div>                                       
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">Total Price</label>
                                            <input type="text" class="form-control" name="total_price" value="{{ number_format($transfer->total_price, 2) }}" placeholder="Title" readonly required>                                
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="status">Status</label>
                                            <select name="status" class="form-control" required>
                                                <option value="{{ $transfer->status }}" selected>{{ ucfirst($transfer->status) }}</option>

                                                @if($transfer->status !== 'confirmed')
                                                    <option value="confirmed">Confirmed</option>
                                                @endif

                                                @if($transfer->status !== 'declined')
                                                    <option value="declined">Declined</option>
                                                @endif

                                                @if($transfer->status !== 'pending')
                                                    <option value="pending">Pending</option>
                                                @endif
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="status">Confirmation Status</label>
                                            <select name="confirmation_status" class="form-control" required>
                                                <option value="" disabled {{ is_null($transfer->confirmation_status) ? 'selected' : '' }}>Select status</option>
                                                <option value="pending" {{ $transfer->confirmation_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="confirmed" {{ $transfer->confirmation_status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                <option value="declined" {{ $transfer->confirmation_status === 'declined' ? 'selected' : '' }}>Declined</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="status">Confirmation Date  </label>
                                            <input type="date" class="form-control" name="confirmation_date" value="{{ $transfer->confirmation_date ? \Carbon\Carbon::parse($transfer->confirmation_date)->format('Y-m-d') : '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="status">Confirmed By</label>
                                            <select name="confirmed_by" class="form-control" required>
                                                <option value="" disabled {{ is_null($transfer->confirmed_by) ? 'selected' : '' }}>Confirmed By</option>
                                                <option value="1" {{ $transfer->confirmed_by === 'Admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="2" {{ $transfer->confirmed_by === 'Sale Rep' ? 'selected' : '' }}>Sale's Rep</option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status">Rejection Reason  </label>
                                            <textarea class="form-control" name="rejection_reason" id="rejection_reason"></textarea>
                                        </div>
                                    </div>
                                </div>
                                {{-- <button type="submit" class="btn btn-dark">Update </button> --}}
                                {{-- <button type="reset" class="btn btn-danger">Cancel</button> --}}
                                <a href="{{ route('admin.transfer.index')}}"  class="btn btn-primary">Back</a>

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