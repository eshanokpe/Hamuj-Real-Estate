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
                                <a href="{{ route('admin.property.type.index') }}" class="btn btn-dark">View Property Types</a>
                            </ol>
                        </div>
                        <h4 class="page-title">Add Property Type</h4>
                    </div>
                </div>
            </div>
            <!-- End Page Title -->

            <div class="row">
                <div class="col-lg-3"></div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Create Property Type</h4>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.property.type.store') }}" enctype="multipart/form-data">
                                @csrf
                                
                                <!-- Title -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input 
                                        type="text" 
                                        id="title" 
                                        class="form-control" 
                                        name="title" 
                                        placeholder="Enter title" 
                                        required>
                                </div>

                                <!-- Subtitles -->
                                <div id="subtitles-wrapper">
                                    <div class="mb-3 subtitle-group">
                                        <label class="form-label">Subtitle</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            name="subtitles[]" 
                                            placeholder="Enter subtitle">
                                    </div>
                                </div>

                                <button type="button" id="add-subtitle" class="btn btn-secondary btn-sm">
                                    + Add Subtitle
                                </button>

                                <!-- Actions -->
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-dark">Create</button>
                                    <button type="reset" class="btn btn-danger">Cancel</button>
                                </div>
                            </form>
                            <script>
                                document.getElementById('add-subtitle').addEventListener('click', function () {
                                    let wrapper = document.getElementById('subtitles-wrapper');

                                    let div = document.createElement('div');
                                    div.classList.add('mb-3', 'subtitle-group');
                                    div.innerHTML = `
                                        <div class="d-flex gap-2">
                                            <input type="text" class="form-control" name="subtitles[]" placeholder="Enter subtitle">
                                            <button type="button" class="btn btn-danger btn-sm remove-subtitle">x</button>
                                        </div>
                                    `;

                                    wrapper.appendChild(div);

                                    // Attach remove event
                                    div.querySelector('.remove-subtitle').addEventListener('click', function () {
                                        div.remove();
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3"></div>
            </div><!-- End row -->

        </div><!-- Container -->
    </div><!-- End Page Content -->
</div><!-- End Page Wrapper -->

@endsection


