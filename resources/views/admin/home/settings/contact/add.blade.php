<div class="card-header mb-3">
    <h4 class="card-title">Edit and Update Contact details </h4>
</div><!--end card-header-->
<div class="row">
    <div class="col-lg-1"></div>
    <div class="col-lg-10">
        <form method="POST" action="{{ isset($contactDetials) ? route('admin.contact.update', $contactDetials->id) : route('admin.contact.store') }}" enctype="multipart/form-data">
            @csrf 
            @if(isset($contactDetials))
                @method('PUT')
            @endif
            <div class="mb-3 row">
                <label for="example-email-input" class="col-sm-2 col-form-label text-end">Company name</label>
                <div class="col-sm-10">
                    <input autocomplete="off" type="text" class="form-control" placeholder="Company name" name="company_name" value=" {{ isset($contactDetials) ? $contactDetials->company_name : '' }}" required>
                </div>
            </div> 
           
            <div class="mb-3 row">
                <label for="example-email-input" class="col-sm-2 col-form-label text-end">First Phone number</label>
                <div class="col-sm-10">
                    <input autocomplete="off" type="text" class="form-control" placeholder="First Phone number" name="first_phone" value=" {{ isset($contactDetials) ? $contactDetials->first_phone : '' }}" required>
                </div>
            </div> 
            <div class="mb-3 row">
                <label for="example-email-input" class="col-sm-2 col-form-label text-end">Second Phone number</label>
                <div class="col-sm-10">
                    <input autocomplete="off" type="text" class="form-control" placeholder="Second Phone number " name="second_phone" value=" {{ isset($contactDetials) ? $contactDetials->second_phone : '' }}" required>
                </div>
            </div> 
            <div class="mb-3 row">
                <label for="example-email-input" class="col-sm-2 col-form-label text-end">First Email</label>
                <div class="col-sm-10">
                    <input autocomplete="off" type="email" class="form-control" placeholder="First Email" name="first_email" value=" {{ isset($contactDetials) ? $contactDetials->first_email : '' }}" required>
                </div>
            </div> 
            <div class="mb-3 row">
                <label for="example-email-input" class="col-sm-2 col-form-label text-end">Second Email</label>
                <div class="col-sm-10">
                    <input autocomplete="off" type="email" class="form-control" placeholder="Second Email" name="second_email" value=" {{ isset($contactDetials) ? $contactDetials->second_email : '' }}" required>
                </div>
            </div> 
            <div class="mb-3 row">
                <label for="example-email-input" class="col-sm-2 col-form-label text-end">First Address</label>
                <div class="col-sm-10">
                    <input autocomplete="off" type="text" class="form-control" placeholder="First Address" name="first_address" value=" {{ isset($contactDetials) ? $contactDetials->first_address : '' }}" required>
                </div>
            </div> 
            <div class="mb-3 row">
                <label for="example-email-input" class="col-sm-2 col-form-label text-end">Website Logo</label>
                <div class="col-sm-10">
                    <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="site_logo"  onchange="previewImage(event)">
                    @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @if(isset($contactDetials)) 
                    <img src="{{ asset($contactDetials->site_logo) }}" alt="{{ $contactDetials->company_name }}" class="img-thumbnail mt-2" width="200">
                    @endif
                    <img id="image-preview" src="" alt="Image Preview" class="img-thumbnail mt-2" style="display:none; max-width: 200px;">
                </div>
            </div> 
            <div class="mb-3 row">
                <label for="example-email-input" class="col-sm-2 col-form-label text-end"> Favicon Logo </label>
                <div class="col-sm-10">
                    <input id="image" type="file" class="form-control @error('favicon') is-invalid @enderror" name="favicon"  onchange="previewImageFavicon(event)">
                    @error('favicon')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @if(isset($contactDetials)) 
                    <img src="{{ asset($contactDetials->favicon) }}" alt="{{ $contactDetials->company_name }}" class="img-thumbnail mt-2" width="200">
                    @endif
                    <img id="image-preview-favicon" src="" alt="Image Preview" class="img-thumbnail mt-2" style="display:none; max-width: 200px;">
                </div>
            </div> 
            <div class="mb-3 row">
                <label for="example-email-input" class="col-sm-2 col-form-label text-end">Contact us Logo</label>
                <div class="col-sm-10">
                    <input id="contactUs_logo" type="file" class="form-control @error('image') is-invalid @enderror" name="contactUs_logo"  onchange="previewImageContactUs(event)">
                    @error('contactUs_logo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @if(isset($contactDetials)) 
                        <img src="{{ asset($contactDetials->contactUs_logo) }}" alt="{{ $contactDetials->company_name }}" class="img-thumbnail mt-2" width="200">
                    @endif
                    <img id="image-preview-contactus" src="" alt="Image Preview" class="img-thumbnail mt-2" style="display:none; max-width: 200px;">
                </div>
            </div> 
            
            <div class="mb-3 mb-lg-0 row">
                <label for="example-search-input" class="col-sm-2 col-form-label text-end"></label>
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
            function previewImageContactUs(event) {
                const input = event.target;
                const preview = document.getElementById('image-preview-contactus');
                
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