<div class="card-header mb-3">
    <h4 class="card-title">Edit and Update Terms details </h4>
</div><!--end card-header-->
<div class="row">
    <div class="col-lg-1"></div>
    <div class="col-lg-10">
        <form method="POST" action="{{ isset($contactDetials) ? route('admin.contact.update', $contactDetials->id) : route('admin.contact.store') }}" enctype="multipart/form-data">
            @csrf 
            @if(isset($contactDetials))
                @method('PUT')
            @endif
            
             
            <div class="mb-3">
                <label for="exampleInputEmail1" class="mb-3">Content</label>
                <textarea id="basic-conf" name="content"></textarea>
            </div>
            
            
            <div class="mb-3 mb-lg-0 row">
                <label for="example-search-input" class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">{{ isset($contactDetials) ? 'Update' : 'Creat' }}</button>
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
            function previewImageFavicon(event) {
                const input = event.target;
                const preview = document.getElementById('image-preview-favicon');
                
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