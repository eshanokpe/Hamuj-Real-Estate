@extends('layouts.admin')
@section('content')

<div class="page-wrapper">

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
                                    {{-- <li class="breadcrumb-item ">Setting</li> --}}
                                    <li class="breadcrumb-item ">Contents</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Contents</h4>
                        </div>
                        <!--end page-title-box-->
                    </div>
                    <!--end col-->
                </div>
                <!-- end page title end breadcrumb -->
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">

                                <div class="nav flex-column nav-pills text-center" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <a class="nav-link waves-effect waves-light mb-3 "  href="{{ route('admin.settings.index')}}">About</a>
                                    <a class="nav-link waves-effect waves-light mb-3"  href="{{ route('admin.visionMission.index')}}">Vision / Mission</a>
                                    <a class="nav-link waves-effect waves-light "  href="{{ route('admin.contact.index')}}">Contact </a>
                                    <a class="nav-link waves-effect waves-light active"  href="{{ route('admin.terms.index')}}">Terms of use </a>
                                    <a class="nav-link waves-effect waves-light "  href="{{ route('admin.privacyPolicy.index')}}">Privacy Policy </a>

                                </div>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->
                    <div class="col-lg-9">
                        <div class="card">
                            
                            <div class="card-body">  
                                @include('admin.home.settings.terms.add')
                                                                                                   
                            </div><!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->
                </div><!-- End row -->

            </div><!-- container -->

           

        </div>
        <!-- end page content -->
    </div>

</div>
<!-- end page-wrapper -->

@endsection
