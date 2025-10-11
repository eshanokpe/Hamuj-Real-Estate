
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
                        <h4 class="page-title">Wallet Transactions</h4>
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
                            <h4 class="card-title">Transactions List</h4>
                           
                        </div><!--end card-header-->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead> 
                                        <tr>
                                            <th class="width80">#</th>
                                            <th>User FullName</th>
                                            <th>Type</th>
                                            <th>Account Name</th>
                                            <th>Bank Name</th>
                                            <th>Amount</th>
                                            <th>Reason</th>
                                            <th>Recipient Code</th>
                                            <th>Status</th>
                                            <th>DATE   </th>
                                            {{--
                                            <th class="text-end">Action</th>
                                            --}}
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        @forelse ($walletTransactions as $walletTransaction)
                                        @php $index = $loop->index; @endphp
                                            <tr>
                                                <td><strong>{{  $index + 1 }}</strong></td>                                             
                                                <td style="text-transform: uppercase;">{{ $walletTransaction ->user->first_name. ' ' . $walletTransaction->user->last_name}}</td>
                                                <td>{{ $walletTransaction->type ?? ''}}</td>
                                                <td>{{ $walletTransaction->accountName ?? ''}}</td>
                                                <td>{{ $walletTransaction->bankName ?? ''}}</td>
                                                <td>₦{{ number_format($walletTransaction->amount ?? 0, 2) }}</td>
                                                <td>{{ $walletTransaction->reason ?? ''}}</td>
                                                <td>{{ $walletTransaction->recipient_code ?? ''}}</td>
                                                <td>
                                                    @if($walletTransaction->status === 'pending')
                                                        <button class="btn btn-warning btn-sm">{{ ucfirst($walletTransaction->status) }}</button>
                                                    @elseif($walletTransaction->status === 'completed' || $walletTransaction->status === 'success')
                                                        <button class="btn btn-success btn-sm">{{ ucfirst($walletTransaction->status) }}</button>
                                                    @elseif($walletTransaction->status === 'failed' || $walletTransaction->status === 'cancelled')
                                                        <button class="btn btn-danger btn-sm">{{ ucfirst($walletTransaction->status) }}</button>
                                                    @endif
                                                </td>
                                                <td>{{ $walletTransaction->created_at->format('d F Y') ??'' }}</td>
                                                {{--
                                                <td class="text-end">                                                       
                                                    <a class="btn btn-primary text-white" href="{{ route('admin.users.show', encrypt($wallet->id) )  }}" ><i class="las la-eye text-white font-16"></i></a>
                                                    <a class="btn btn-danger text-white" href="{{ route('admin.users.destroy', encrypt($wallet->id) )  }}" onclick="return confirm('Are you sure you want to delete this Menu?');"><i class="las la-trash-alt text-white font-16"></i></a>
                                                </td>
                                                --}}
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No menu items found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table><!--end /table-->
                               
                                <div class="mt-4 d-flex justify-content-center">
                                    {{ $walletTransactions->links('vendor.pagination.bootstrap-4') }}
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
