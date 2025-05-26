<div class="card-header mb-3">
    <h4 class="card-title">Edit and Update Privacy Policy details </h4>
</div><!--end card-header-->
<div class="row">
    <div class="col-lg-12">
        <form method="POST" action="{{ isset($privacy) ? route('admin.privacy.update', $privacy->id) : route('admin.privacy.store') }}" enctype="multipart/form-data">
            @csrf 
            @if(isset($privacy))
                @method('PUT')
            @endif
            
             
            <div class="mb-3">
                <label for="exampleInputEmail1" class="mb-3">Content</label>
                <textarea id="basic-conf" name="content">{{ isset($privacy) ? $privacy->content : ''}}</textarea>
            </div>
            
            
            <div class="mb-3 mb-lg-0 row">
                <label for="example-search-input" class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">{{ isset($privacy) ? 'Update' : 'Creat' }}</button>
                </div>
            </div>     
        </form>
                                 
    </div>
   
</div>   