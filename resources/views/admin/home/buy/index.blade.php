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
                        
                        <h4 class="page-title">Buy (Property)</h4>
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
                            <h4 class="card-title">List of Property Buy</h4>
                           
                        </div><!--end card-header-->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead> 
                                        <tr>
                                            <th class="width80">#</th>
                                            <th>User FullName</th>
                                            <th>User Email</th>
                                            <th>Property Name</th>
                                            <th>Transaction ID</th>
                                            <th>Selected Size Land</th>
                                            <th>Remaining Size</th>
                                            <th>Total Price</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($buys as $buy)
                                            <tr>
                                                <td><strong>{{ $loop->iteration }}</strong></td>
                                                <td style="text-transform: uppercase;">{{ $buy ->user->first_name. ' ' . $buy->user->last_name}}</td>
                                                <td>{{ $buy->user_email }}</td>
                                                <td>{{ $buy->property->name }}</td>
                                                <td>{{ $buy->transaction_id }}</td>
                                                <td>{{ $buy->selected_size_land }}</td>
                                                <td>{{ $buy->remaining_size }}</td>
                                                <td>₦{{ number_format($buy->total_price, 2) }}</td>
                                                <td>{{ $buy->status }}</td> 
                                                <td>{{ $buy->created_at ? $buy->created_at->format('d F Y') : 'N/A' }}</td>
                                                
                                                <td class="text-end">
                                                    <a href="{{ route('admin.buy.edit', encrypt($buy->id)) }}">
                                                        <i class="las la-pen text-secondary font-16"></i>
                                                    </a>
                                                  
                                                    <form action="{{ route('admin.buy.destroy', encrypt($buy->id)) }}" method="POST" style="display:inline;">
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
                                                <td colspan="6" class="text-center">Nothing found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{ $buys->links() }}
                                </div>

                                
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