

@extends('layouts.admin')
@section('content') 

<div class="page-wrapper">

    

    <!-- Page Content-->
    <div class="page-content-tab ">
        <div class="container-fluid ">
             <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="float-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Dohmayn / </a>
                                </li><!--end nav-item-->
                                <li class="active"> Dashboard</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Dashboard</h4>
                    </div><!--end page-title-box-->
                </div><!--end col-->
            </div>
            <!-- end page title end breadcrumb -->
            <div class="row" style="margin-top:10px;">
                <div class="col-md-12 col-lg-3  order-lg-1 order-md-2 order-sm-2">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="pt-3">
                                <h3 class="text-dark text-center font-24 fw-bold line-height-lg">
                                    <i class="ti ti-users font-36 align-self-center text-dark"></i>
                                     Users
                                </h3>
                                <div class="text-center text-muted font-16 fw-bold pt-3 pb-1">{{ $users }}</div>
                               
                                <div class="text-center py-3 mb-3">
                                    <a href="{{ route('admin.users') }}" class="btn btn-primary">View more</a>
                                </div> 
                            </div>
                        </div><!--end card-body--> 
                    </div><!--end card-->                            
                </div> <!--end col-->
                <div class="col-lg-9 order-lg-2 order-md-1 order-sm-1">
                    <div class="row justify-content-center"> 
                        <div class="col-lg-3 col-md-6">
                            <div class="card overflow-hidden">
                                <div class="card-body">
                                    <a href="{{ route('admin.properties.index') }}">
                                        <div class="row d-flex">
                                            <div class="col-3">
                                                <i class="ti ti-building-store font-36 align-self-center text-dark"></i>
                                            </div><!--end col-->
                                            <div class="col-12 ms-auto align-self-center">
                                                <br/>
                                                <br/>
                                            </div><!--end col-->
                                            <div class="col-12 ms-auto align-self-center">
                                                <h3 class="text-dark my-0 font-22 fw-bold">{{ $properties }}</h3>
                                                <p class="text-muted mb-0 fw-semibold">Properties</p>
                                            </div><!--end col-->
                                        </div><!--end row-->
                                    </a>
                                </div><!--end card-body--> 
                            </div><!--end card-->                                     
                        </div> <!--end col--> 
                        <div class="col-lg-3 col-md-6">
                            <div class="card overflow-hidden">
                                <div class="card-body">
                                    <a href="{{ route('admin.buy.index') }}">
                                        <div class="row d-flex">
                                            <div class="col-3">
                                                <i class="ti ti-shopping-cart font-36 align-self-center text-dark"></i>
                                            </div>
                                            
                                            <div class="col-12 ms-auto align-self-center">
                                                <br/>
                                                <br/>
                                            </div><!--end col-->
                                            <div class="col-12 ms-auto align-self-center">
                                                <h3 class="text-dark my-0 font-22 fw-bold">{{ $buy }}</h3>
                                                <p class="text-muted mb-0 fw-semibold">Buys</p>
                                            </div><!--end col-->
                                        </div><!--end row-->
                                    </a>
                                </div><!--end card-body--> 
                            </div><!--end card-->                                     
                        </div> <!--end col--> 
                        <div class="col-lg-3 col-md-6">
                            <div class="card overflow-hidden">
                                <div class="card-body">
                                    <a href="{{ route('admin.sell.index') }}">
                                    <div class="row d-flex">
                                        <div class="col-3">
                                            <i class="ti ti-cash font-36 align-self-center text-dark"></i>
                                        </div><!--end col-->
                                        <div class="col-12 ms-auto align-self-center">
                                            <br/>
                                            <br/>
                                        </div><!--end col-->
                                        <div class="col-12 ms-auto align-self-center">
                                            <h3 class="text-dark my-0 font-22 fw-bold">{{ $sell }}</h3>
                                            <p class="text-muted mb-0 fw-semibold">Sell</p>
                                        </div><!--end col-->
                                    </div><!--end row-->
                                    </a>
                                </div><!--end card-body--> 
                            </div><!--end card-->                                     
                        </div> <!--end col--> 
                        
                        <div class="col-lg-3 col-md-6">
                            <div class="card overflow-hidden">
                                <div class="card-body">
                                    <div class="row d-flex">
                                         <a href="{{ route('admin.transfer.index') }}">
                                            <div class="col-3">
                                                <i class="ti ti-repeat font-36 align-self-center text-dark"></i>
                                            </div><!--end col-->
                                            
                                            <div class="col-12 ms-auto align-self-center">
                                                <br/>
                                                <br/>
                                            </div><!--end col-->
                                            <div class="col-12 ms-auto align-self-center">
                                                <h3 class="text-dark my-0 font-22 fw-bold">{{ $transfer }}</h3>
                                                <p class="text-muted mb-0 fw-semibold">Transfer</p>
                                            </div><!--end col-->
                                        </a>
                                    </div><!--end row-->
                                </div><!--end card-body--> 
                            </div><!--end card-->                                     
                        </div> <!--end col-->                                                                   
                    </div><!--end row-->
                     
                </div><!--end col-->                        
            </div><!--end row-->
        </div><!-- container -->

        <div class="container-fluid pt-10">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">                      
                                    <h4 class="card-title">Wallet Transactions</h4>                      
                                </div><!--end col-->  
                                <div class="col text-end">                      
                                    <a href="{{ route('admin.walletTransaction') }}">View More</a>                      
                                </div><!--end col-->                                       
                            </div>  <!--end row-->                                  
                        </div><!--end card-header-->
                        <div class="card-body">
                            <div class="table-responsive browser_users">
                                <table class="table table-hover mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="border-top-0">User</th>
                                            <th class="border-top-0">Type</th>
                                            <th class="border-top-0">Amount</th>
                                            <th class="border-top-0">Status</th>
                                        </tr><!--end tr-->
                                    </thead>
                                    <tbody>
                                        @forelse ($walletTransactions as $walletTransaction)
                                            <tr>  
                                                <td style="text-transform: uppercase;">{{ $walletTransaction ->user->first_name. ' ' . $walletTransaction->user->last_name}}</td>
                                                <td style="text-transform: uppercase;">{{ $walletTransaction->type ?? ''}}</td>
                                                
                                                <td>₦{{ number_format($walletTransaction->amount ?? 0, 2) }}</td>                                  
                                                <td>
                                                    @if($walletTransaction->status === 'pending')
                                                        <button class="btn btn-warning btn-sm">{{ ucfirst($walletTransaction->status) }}</button>
                                                    @elseif($walletTransaction->status === 'completed' || $walletTransaction->status === 'success')
                                                        <button class="btn btn-success btn-sm">{{ ucfirst($walletTransaction->status) }}</button>
                                                    @elseif($walletTransaction->status === 'failed' || $walletTransaction->status === 'cancelled')
                                                        <button class="btn btn-danger btn-sm">{{ ucfirst($walletTransaction->status) }}</button>
                                                    @endif
                                                </td>
                                               
                                            </tr><!--end tr-->
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No menu items found.</td>
                                            </tr>
                                        @endforelse                                 
                                    </tbody>
                                </table> <!--end table--> 
                                                                             
                            </div><!--end /div--> 
                        </div><!--end card-body--> 
                    </div><!--end card--> 
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">                      
                                    <h4 class="card-title">Transactions</h4>                      
                                </div><!--end col--> 
                                <div class="col text-end">                      
                                    <a href="{{ route('admin.transaction') }}">View More</a>                      
                                </div><!--end col-->                                       
                            </div>  <!--end row-->                                  
                        </div><!--end card-header-->
                        <div class="card-body">
                            <div class="table-responsive browser_users">
                                <table class="table mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="border-top-0">User</th>
                                            <th class="border-top-0">Property Name</th>
                                            <th class="border-top-0">Amount</th>
                                            <th class="border-top-0">Status</th>
                                        </tr><!--end tr-->
                                    </thead>
                                    <tbody>
                                        @forelse ($transactions as $transaction)

                                            <tr>                                                        
                                                
                                                <td style="text-transform: uppercase;">{{ $transaction ->user->first_name. ' ' . $transaction->user->last_name}}</td>
                                                <td>{{ $transaction->property_name ?? ''}}</td>
                                                <td>₦{{ number_format($transaction->amount ?? 0, 2) }}</td>
                                                <td>
                                                    @if($transaction->status === 'pending')
                                                        <button class="btn btn-warning btn-sm">{{ ucfirst($transaction->status) }}</button>
                                                    @elseif($transaction->status === 'completed' || $transaction->status === 'success')
                                                        <button class="btn btn-success btn-sm">{{ ucfirst($transaction->status) }}</button>
                                                    @elseif($transaction->status === 'failed' || $transaction->status === 'cancelled')
                                                        <button class="btn btn-danger btn-sm">{{ ucfirst($transaction->status) }}</button>
                                                    @endif
                                                </td>
                                                
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No menu items found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table><!--end /table-->
                                                                          
                            </div><!--end /div-->
                        </div><!--end card-body--> 
                    </div><!--end card--> 
                </div> <!--end col--> 
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">                      
                                    <h4 class="card-title">Buy Properties</h4>                      
                                </div><!--end col-->
                                <div class="col text-end">                      
                                    <a href="{{ route('admin.properties.index') }}">View More</a>                      
                                </div><!--end col-->
                            </div>  <!--end row-->                                  
                        </div><!--end card-header-->
                        <div class="card-body"> 
                            <div class="table-responsive mt-2">
                                <table class="table  mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th >User</th>
                                            <th >Properties</th>
                                            <th >Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($buys as $buy)
                                            <tr> 
                                                <td style="text-transform: uppercase;">{{ $buy ->user->first_name. ' ' . $buy->user->last_name}}</td>
                                                <td>{{ $buy->property->name }}</td>
                                                <td>₦{{ number_format($buy->total_price, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No properties found.</td>
                                            </tr>
                                        @endforelse
                                    
                                    </tbody>
                                </table><!--end /table-->
                            </div><!--end /div-->                                 
                        </div><!--end card-body--> 
                    </div><!--end card--> 
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">                      
                                    <h4 class="card-title">Sell Properties</h4>                      
                                </div><!--end col-->
                                <div class="col text-end">                      
                                    <a href="{{ route('admin.properties.index') }}">View More</a>                      
                                </div><!--end col-->
                            </div>  <!--end row-->                                  
                        </div><!--end card-header-->
                        <div class="card-body"> 
                            <div class="table-responsive mt-2">
                                <table class="table  mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th >User</th>
                                            <th >Properties</th>
                                            <th >Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($sells as $sell)
                                            <tr> 
                                                <td style="text-transform: uppercase;">{{ $sell ->user->first_name. ' ' . $sell->user->last_name}}</td>
                                                <td>{{ $sell->property->name }}</td>
                                                <td>₦{{ number_format($sell->total_price, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No properties found.</td>
                                            </tr>
                                        @endforelse
                                    
                                    </tbody>
                                </table><!--end /table-->
                            </div><!--end /div-->                                 
                        </div><!--end card-body--> 
                    </div><!--end card--> 
                    
                </div> <!--end col-->
                
            </div><!--end row-->
        </div><!-- container -->


        <!--Start Rightbar-->
        <!--Start Rightbar/offcanvas-->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="Appearance" aria-labelledby="AppearanceLabel">
            <div class="offcanvas-header border-bottom">
              <h5 class="m-0 font-14" id="AppearanceLabel">Appearance</h5>
              <button type="button" class="btn-close text-reset p-0 m-0 align-self-center" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">  
                <h6>Account Settings</h6>
                <div class="p-2 text-start mt-3">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch1">
                        <label class="form-check-label" for="settings-switch1">Auto updates</label>
                    </div><!--end form-switch-->
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch2" checked>
                        <label class="form-check-label" for="settings-switch2">Location Permission</label>
                    </div><!--end form-switch-->
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="settings-switch3">
                        <label class="form-check-label" for="settings-switch3">Show offline Contacts</label>
                    </div><!--end form-switch-->
                </div><!--end /div-->
                <h6>General Settings</h6>
                <div class="p-2 text-start mt-3">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch4">
                        <label class="form-check-label" for="settings-switch4">Show me Online</label>
                    </div><!--end form-switch-->
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch5" checked>
                        <label class="form-check-label" for="settings-switch5">Status visible to all</label>
                    </div><!--end form-switch-->
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="settings-switch6">
                        <label class="form-check-label" for="settings-switch6">Notifications Popup</label>
                    </div><!--end form-switch-->
                </div><!--end /div-->               
            </div><!--end offcanvas-body-->
        </div>
        <!--end Rightbar/offcanvas-->
         <!--end Rightbar-->
         
       
    </div>
    <!-- end page content -->
</div>
<!-- end page-wrapper -->

@endsection