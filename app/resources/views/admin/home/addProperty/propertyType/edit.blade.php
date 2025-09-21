@extends('layouts.admin')

@section('content')
<div class="page-wrapper">
    <div class="page-content-tab">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box d-flex justify-content-between align-items-center">
                        <h4 class="page-title">Edit Property Type</h4>
                        <a href="{{ route('admin.property.type.index') }}" class="btn btn-dark">Back</a>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Property Type</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.property.type.update', encrypt($propertyType->id)) }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" name="title"
                                           value="{{ old('title', $propertyType->title) }}" required>
                                </div>

                                <div id="subtitles-wrapper">
                                    @if($propertyType->subtitles)
                                        @foreach($propertyType->subtitles as $subtitle)
                                            <div class="mb-3 subtitle-group">
                                                <div class="d-flex gap-2">
                                                    <input type="text" class="form-control" name="subtitles[]" value="{{ $subtitle }}" placeholder="Enter subtitle">
                                                    <button type="button" class="btn btn-danger btn-sm remove-subtitle">x</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="mb-3 subtitle-group">
                                            <input type="text" class="form-control" name="subtitles[]" placeholder="Enter subtitle">
                                        </div>
                                    @endif
                                </div>

                                <button type="button" id="add-subtitle" class="btn btn-secondary btn-sm">+ Add Subtitle</button>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-dark">Update</button>
                                    <a href="{{ route('admin.property.type.index') }}" class="btn btn-secondary">Cancel</a>
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

                                    div.querySelector('.remove-subtitle').addEventListener('click', function () {
                                        div.remove();
                                    });
                                });

                                // Attach remove handler to existing buttons
                                document.querySelectorAll('.remove-subtitle').forEach(button => {
                                    button.addEventListener('click', function () {
                                        button.closest('.subtitle-group').remove();
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3"></div>
            </div>

        </div>
    </div>
</div>
@endsection

