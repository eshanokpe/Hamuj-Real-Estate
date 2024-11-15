<div class="card-header mb-3">
    <h4 class="card-title">Edit and Update About content </h4>
</div><!--end card-header-->
<div class="row">
    <div class="col-lg-1"></div>
    <div class="col-lg-10">
        <form method="POST" action="{{ isset($about) ? route('admin.settings.updateAboutus', $about->id) : route('admin.settings.storeAboutus') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($about))
                @method('PUT')
            @endif
            <div class="mb-3 row">
                <label for="" required class="col-sm-2 col-form-label text-end">Title</label>
                <div class="col-sm-10">
                    <input name="title" class="form-control" type="text" value=" {{ isset($about) ? $about->title : '' }}" required placeholder="Title" id="" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="example-email-input" class="col-sm-2 col-form-label text-end">Content</label>
                <div class="col-sm-10">
                    <textarea id="basic-conf" name="content">{{ isset($about) ? $about->content : '' }}</textarea>
                </div>
            </div> 
            <div class="mb-3 row">
                <label for="" required class="col-sm-2 col-form-label text-end">Image</label>
                <div class="col-sm-10">
                    <input onchange="previewImage(event)" class="form-control @error('image') is-invalid @enderror" type="file" value="" name="image" required>
           
                    @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @if(isset($about))
                    <img src="{{ asset($about->image) }}" alt="{{ $about->title }}" class="img-thumbnail mt-2" width="200">
                    @endif
                    <img id="image-preview" src="" alt="Image Preview" class="img-thumbnail mt-2" style="display:none; max-width: 200px;">
                </div>
            </div>
            
            <div class="mb-3 mb-lg-0 row">
                <label for="example-search-input" class="col-sm-2 col-form-label text-end"></label>
                <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">{{ isset($aboutUs) ? 'Update' : 'Add' }}</button>
                </div>
            </div>     
        </form>
        <script>
            function previewImage(event) {
                const input = event.target;
                const preview = document.getElementById('image-preview');
                
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>                            
    </div>
    <div class="col-lg-1"></div>
</div>   