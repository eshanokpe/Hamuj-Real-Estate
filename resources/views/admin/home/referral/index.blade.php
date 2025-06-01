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
                        <h4 class="page-title">Referral Log</h4>
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
                            <h4 class="card-title">Referral List</h4>
                           
                        </div><!--end card-header-->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead> 
                                        <tr>
                                            <th class="width80">#</th>
                                            <th>Referrer Name</th>
                                            <th>Referred Name</th>
                                            <th>Referred Code</th>
                                            <th>Referred Date</th>
                                            <th>Status</th>
                                            <th>Commission Amount</th>
                                            <th>Commission Paid</th>
                                            <th>Commission Paid Date</th>
                                            <th>Property ID</th>
                                            <th>Transaction ID</th>
                                            <th>DATE   </th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        @forelse ($referrals as $referral)
                                        @php $index = $loop->index; @endphp
                                            <tr>
                                                <td><strong>{{  $index + 1 }}</strong></td>
                                                <!-- Referrer (the one who referred someone) -->
                                                <td style="text-transform: uppercase;">
                                                    {{ $referral->referrer->first_name ?? '' }} {{ $referral->referrer->last_name ?? '' }}
                                                </td>

                                                <!-- Referred (the one who was referred) -->
                                                <td style="text-transform: uppercase;">
                                                    {{ $referral->referred->first_name ?? '' }} {{ $referral->referred->last_name ?? '' }}
                                                </td>
                                                <td>{{ $referral->referral_code ?? ''}}</td>
                                                <td>{{ $referral->referred_at->format('d F Y') ??'' }}</td>
                                                <td>
                                                    @if($referral->status === 'commission_pending')
                                                        <button class="btn btn-warning btn-sm">Pending</button>
                                                    @elseif($referral->status === 'paid' || $referral->status === 'approved')
                                                        <button class="btn btn-success btn-sm">{{ ucfirst($referral->status) }}</button>
                                                    @elseif($referral->status === 'failed' || $referral->status === 'cancelled')
                                                        <button class="btn btn-danger btn-sm">{{ ucfirst($referral->status) }}</button>
                                                    @endif 
                                                </td>
                                                <td>₦{{ number_format($referral->commission_amount ?? 0, 2) }}</td>
                                                <td> 
                                                    @if ($referral->commission_paid == 0)
                                                       No
                                                    @elseif ($referral->commission_paid == 1)
                                                        Yes
                                                    @else
                                                        None
                                                    @endif
                                                </td>
                                                <td>{{ $referral->commission_paid_at ?? 'None' }}</td>
                                                <td>{{ $referral->property_id ?? ''}}</td>
                                                <td>{{ $referral->transaction_id ?? ''}}</td>
                                                <td>{{ $referral->created_at->format('d F Y') ??'' }}</td>
                                                <td class="text-end">                                                       
                                                    <a class="btn btn-primary text-white" href="{{ route('admin.referral.show', encrypt($referral->id) )  }}" ><i class="las la-eye text-white font-16"></i></a>
                                                </td>
                                                
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No menu items found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table><!--end /table-->
                                <div class="mt-4 d-flex justify-content-center">
                                    {{ $referrals->links('vendor.pagination.bootstrap-4') }}
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