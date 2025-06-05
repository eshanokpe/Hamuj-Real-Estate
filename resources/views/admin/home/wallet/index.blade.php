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
                        <h4 class="page-title">Wallet</h4>
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
                            <h4 class="card-title">Wallet List</h4>
                           
                        </div><!--end card-header-->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead> 
                                        <tr>
                                            <th class="width80">#</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Balance</th>
                                            <th>DATE   </th>
                                            {{--
                                            <th class="text-end">Action</th>
                                            --}}
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        @forelse ($wallets as $wallet)
                                            @php $index = ($wallets->currentPage() - 1) * $wallets->perPage() + $loop->index + 1; @endphp
                                            
                                            <tr>
                                                <td><strong>{{  $index }}</strong></td>
                                                <td style="text-transform: uppercase;">{{ $wallet->user->first_name . ' ' . $wallet->user->last_name }}</td>
                                                <td>{{ $wallet->user->email ?? ''}}</td>
                                                <td>₦{{ number_format($wallet->balance ?? 0, 2) }}</td>
                                                <td>{{ $wallet->created_at->format('d F Y') ??'' }}</td>
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
                                <div class="mt-3">
                                    {{ $wallets->links() }}
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