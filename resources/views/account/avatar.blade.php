@if($avatar)
    <div class="ibox avatar-container">
        <div class="ibox-content product-box">
            <div class="image-container" style="background-image:url('{{ $avatar->url }}')">
            </div>
            <div class="product-desc">
                <div class="m-t text-righ">
                    <a id="btn-avatar-upload" class="btn btn-success btn-xs btn-outline" @click="openUploadDialog"> Change Avatar</a>
                    <a id="btn-avatar-delete" class="btn btn-xs btn-outline btn-danger pull-right">Delete</a>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="ibox avatar-container">
        <div class="ibox-content product-box">
            <div class="image-container" style="background-image:url('http://via.placeholder.com/200x200?text=PHOTO')">
            </div>
            <div class="product-desc">
                <div class="m-t text-righ">
                    <a id="btn-avatar-upload" class="btn btn-success btn-xs btn-outline" @click="openUploadDialog"> Change Avatar</a>
                </div>
            </div>
        </div>
    </div>
@endif


