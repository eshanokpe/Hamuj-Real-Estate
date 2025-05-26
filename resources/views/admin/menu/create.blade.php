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
                                <a href="{{ route('admin.menu.index')}}" class="btn btn-dark">View Menu</a>
                            </ol>
                        </div>
                        <h4 class="page-title">Add Menu</h4>
                    </div>
                    <!--end page-title-box-->
                </div>
                <!--end col-->
            </div>
            <!-- end page title end breadcrumb -->
            
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Menu Form</h4>
                         </div><!--end card-header-->
                        <div class="card-body">
                            @if(session('success'))
                                <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('admin.menu.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputEmail1">Menu Item Name</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Menu Item Name" required>
                                 </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1">Dropdown Items</label>
                                    <div class="col-sm-9" id="dropdown-items">
                                        <button type="button" class="btn btn-warning" onclick="addDropdownItem()">Add Dropdown Item</button>
                                    </div>
                                    {{-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Password"> --}}
                                </div>
                               
                                <button type="submit" class="btn btn-dark">Create Menu Item</button>
                                <button type="reset" class="btn btn-danger">Cancel</button>
                            </form>    
                            <script>
                                window.setTimeout(function() {
                                   var alert = document.getElementById('success-alert');
                                   if (alert) {
                                       alert.remove();
                                   }
                               }, 3000);
                        
                                function addDropdownItem() {
                                    const dropdownItemsDiv = document.getElementById('dropdown-items');

                                    // Create a container div for the input and remove button
                                    const itemDiv = document.createElement('div');
                                    itemDiv.className = 'input-group mb-2 mt-2';

                                    // Create the input element
                                    const input = document.createElement('input');
                                    input.type = 'text';
                                    input.name = 'dropdown_items[]';
                                    input.className = 'form-control';
                                    input.placeholder = 'Enter Dropdown Item';
                                    input.required = true; // Make the field required

                                    // Create the remove button
                                    const buttonDiv = document.createElement('div');
                                    buttonDiv.className = 'input-group-append';
                                    const removeButton = document.createElement('button');
                                    removeButton.type = 'button';
                                    removeButton.className = 'btn btn-danger';
                                    removeButton.innerHTML = 'Remove';
                                    removeButton.onclick = function() {
                                        dropdownItemsDiv.removeChild(itemDiv);
                                    };

                                    // Append the input and button to the container div
                                    buttonDiv.appendChild(removeButton);
                                    itemDiv.appendChild(input);
                                    itemDiv.appendChild(buttonDiv);
                                    dropdownItemsDiv.appendChild(itemDiv);
                                }

                           </script>                                       
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div><!--end col-->
                <div class="col-lg-3"></div>
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