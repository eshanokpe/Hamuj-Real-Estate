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
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.faq.create')}}" class="btn btn-dark">Add FAQ</a>
                                </li>
                            </ol>
                        </div>
                        <h4 class="page-title">Users</h4>
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
                            <h4 class="card-title">User List</h4>
                           
                        </div><!--end card-header-->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead> 
                                        <tr>
                                            <th class="width80">#</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Active</th>
                                            <th>DATE   </th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        @forelse ($users as $user)
                                        @php $index = ($users->currentPage() - 1) * $users->perPage() + $loop->index + 1; @endphp
                                            <tr> 
                                                <td><strong>{{  $index  }}</strong></td>
                                                <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                                                <td>{{ $user->email ?? ''}}</td>
                                                <td>
                                                    <form action="{{ route('admin.users.toggle-active', $user->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        @if ($user->active)
                                                            <button type="submit" class="btn badge bg-success" title="Status: Active. Click to Deactivate.">Active</button>
                                                        @else
                                                            <button type="submit" class="btn badge bg-danger" title="Status: Inactive. Click to Activate.">Inactive</button>
                                                        @endif
                                                    </form>
                                                </td>
                                                <td>{{ $user->created_at->format('d F Y') ??'' }}</td>
                                                <td class="text-end">                                                       
                                                    <a class="btn btn-primary text-white" href="{{ route('admin.users.show', encrypt($user->id) )  }}" ><i class="las la-eye text-white font-16"></i></a>
                                                    {{-- <a class="btn btn-danger text-white" href="{{ route('admin.users.destroy', encrypt($user->id) )  }}" onclick="return confirm('Are you sure you want to delete this User?');"><i class="las la-trash-alt text-white font-16"></i></a> --}}
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
                                    {{ $users->links('vendor.pagination.bootstrap-4') }}
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