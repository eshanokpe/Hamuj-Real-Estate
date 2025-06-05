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
                        
                        <h4 class="page-title">Transfer (Property)</h4>
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
                            <h4 class="card-title">List of Property Transfer</h4>
                           
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
                                            <th>Recipient FullName</th>
                                            <th>Land Size</th>
                                            <th>Transaction ID</th>
                                            <th>Total Price</th>                                            
                                            <th>Status</th>
                                            <th>Confirmation Status</th>
                                            <th>Confirmation Date</th>
                                            <th>Confirmed By</th>
                                            <th>Rejection Reason</th>
                                            <th>Date</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($transfers as $transfer)
                                            @php $index = ($transfers->currentPage() - 1) * $transfers->perPage() + $loop->index + 1; @endphp
                                            <tr>
                                                <td><strong>{{ $index }}</strong></td>
                                                <td style="text-transform: uppercase;">
                                                    {{ $transfer->user->first_name ?? '' }} {{ $transfer->user->last_name ?? '' }}
                                                </td>
                                                <td>{{ $transfer->user_email }}</td>
                                                <td>{{ $transfer->property_name }}</td>
                                                <td style="text-transform: uppercase;">
                                                    {{ $transfer->recipient->first_name ?? '' }} {{ $transfer->recipient->last_name ?? '' }}
                                                </td>
                                                
                                                <td>{{ $transfer->land_size }}</td>
                                                <td>{{ $transfer->reference }}</td>
                                                <td>₦{{ number_format($transfer->total_price, 2) }}</td>
                                                <td>
                                                    @if($transfer->status === 'pending')
                                                        <button class="btn btn-warning btn-sm">{{ ucfirst($transfer->status) }}</button>
                                                    @elseif($transfer->status === 'confirmed' || $transfer->status === 'approved')
                                                        <button class="btn btn-success btn-sm">{{ ucfirst($transfer->status) }}</button>
                                                    @elseif($transfer->status === 'failed' || $transfer->status === 'cancelled')
                                                        <button class="btn btn-danger btn-sm">{{ ucfirst($transfer->status) }}</button>
                                                    @endif 
                                                </td>
                                                <td>
                                                    @if($transfer->confirmation_status === 'pending')
                                                        <button class="btn btn-warning btn-sm">{{ ucfirst($transfer->confirmation_status) }}</button>
                                                    @elseif($transfer->confirmation_status === 'confirmed' || $transfer->confirmation_status === 'approved')
                                                        <button class="btn btn-success btn-sm">{{ ucfirst($transfer->confirmation_status) }}</button>
                                                    @elseif($transfer->confirmation_status === 'failed' || $transfer->confirmation_status === 'cancelled')
                                                        <button class="btn btn-danger btn-sm">{{ ucfirst($transfer->confirmation_status) }}</button>
                                                    @endif 
                                                </td>
                                                <td>{{ $transfer->confirmation_date ? \Carbon\Carbon::parse($transfer->confirmation_date)->format('d F Y') : 'N/A' }}</td>
                                                <td>
                                                    @if ($transfer->confirmed_by == 3)
                                                        Admin
                                                    @elseif ($transfer->confirmed_by == 6)
                                                        Sales Rep
                                                    @else
                                                        None
                                                    @endif
                                                </td>

                                                <td>{{ $transfer->rejection_reason ?? 'None' }}</td>
                                                <td>{{ $transfer->created_at ? $transfer->created_at->format('d F Y') : 'N/A' }}</td>
                                                
                                                <td class="text-end">
                                                    <a href="{{ route('admin.transfer.edit', encrypt($transfer->id)) }}">
                                                        <i class="las la-pen text-secondary font-16"></i>
                                                    </a>
                                                  
                                                    <form action="{{ route('admin.transfer.destroy', encrypt($transfer->id)) }}" method="POST" style="display:inline;">
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
                                    {{ $transfers->links() }}
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