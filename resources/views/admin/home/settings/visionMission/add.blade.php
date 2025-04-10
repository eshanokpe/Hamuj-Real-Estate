<div class="card-header mb-3">
    <h4 class="card-title">Edit and Update Vision Mission </h4>
</div><!--end card-header-->
<div class="row">
    <div class="col-lg-1"></div>
    <div class="col-lg-10">
        <form method="POST" action="{{ isset($visionMission) ? route('admin.visionMission.update', $visionMission->id) : route('admin.visionMission.store') }}" enctype="multipart/form-data">
            @csrf 
            @if(isset($visionMission))
                @method('PUT')
            @endif
            <div class="mb-3 row">
                <label for="example-email-input" class="col-sm-2 col-form-label text-end">Vision</label>
                <div class="col-sm-10">
                    <textarea  name="vision" class="form-control" rows="5">{{ isset($visionMission) ? $visionMission->vision : '' }}</textarea>
                    
                </div>
            </div> 
            <div class="mb-3 row">
                <label for="example-email-input" class="col-sm-2 col-form-label text-end">Mission</label>
                <div class="col-sm-10">
                    <textarea  name="mission" class="form-control" rows="5">{{ isset($visionMission) ? $visionMission->mission : '' }}</textarea>
                </div>
            </div> 
            
            
            <div class="mb-3 mb-lg-0 row">
                <label for="example-search-input" class="col-sm-2 col-form-label text-end"></label>
                <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">{{ isset($visionMission) ? 'Update' : 'Add' }}</button>
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