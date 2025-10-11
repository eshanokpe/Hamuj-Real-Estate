<div class="card-header mb-3">
    <h4 class="card-title">Edit and Update Socila Media Link </h4>
</div><!--end card-header-->
<div class="row">
    <div class="col-lg-1"></div>
    <div class="col-lg-10">
        <form method="POST" action="{{ isset($sociallink) ? route('admin.settings.updateSocialLinks', $sociallink->id) : route('admin.settings.storeSocialLinks') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($sociallink))
                @method('PUT')
            @endif
            <div class="mb-3 row">
                <label for="" required class="col-sm-2 col-form-label text-end">Facebook Link</label>
                <div class="col-sm-10">
                    <input name="facebook" class="form-control" placeholder="Facebook Link" type="text" value=" {{ isset($sociallink) ? $sociallink->facebook : '' }}" required id="" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="" required class="col-sm-2 col-form-label text-end">Twitter Link</label>
                <div class="col-sm-10">
                    <input name="twitter" class="form-control"placeholder="Twitter Link" type="text" value=" {{ isset($sociallink) ? $sociallink->twitter : '' }}" required id="" required>
                </div>
            </div>
            
            <div class="mb-3 row">
                <label for="" required class="col-sm-2 col-form-label text-end">WhatsApp Link</label>
                <div class="col-sm-10">
                    <input name="whatsapp" class="form-control" placeholder="WhatsApp Link" type="text" value=" {{ isset($sociallink) ? $sociallink->whatsapp : '' }}" required  id="" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="" required class="col-sm-2 col-form-label text-end">Instagram Link</label>
                <div class="col-sm-10">
                    <input name="instagram" class="form-control"  placeholder="Instagram" type="text" value=" {{ isset($sociallink) ? $sociallink->instagram : '' }}" required  id="" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="" required class="col-sm-2 col-form-label text-end">Linkedin Link</label>
                <div class="col-sm-10">
                    <input name="linkedin" class="form-control"  placeholder="Linkedin Link" type="text" value=" {{ isset($sociallink) ? $sociallink->linkedin : '' }}" required  id="" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="" required class="col-sm-2 col-form-label text-end">YouTube Link</label>
                <div class="col-sm-10">
                    <input name="youtube" class="form-control" placeholder="YouTube Link" type="text" value=" {{ isset($sociallink) ? $sociallink->youtube : '' }}" required  id="" required>
                </div>
            </div>
            <div class="mb-3 mb-lg-0 row">
                <label for="example-search-input" class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">{{ isset($about) ? 'Update' : 'Creat' }}</button>
                </div>
            </div>  
        </form>
                               
    </div>
    <div class="col-lg-1"></div>
</div>   