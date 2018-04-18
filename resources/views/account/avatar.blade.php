@if($avatar)
    <div class="file-box avatar-container">
        <div class="file">
            <span class="corner"></span>
            <div class="image" style="background-image:url('{{ $avatar->url }}')"></div>
            <div class="file-name">
                <div class="row">
                    <div class="col-sm-10">
                        asd
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="file-box avatar-container">
        <div class="file">
            <span class="corner"></span>
            <div class="image" style="background-image:url('http://via.placeholder.com/200x200?text=Avatar')"></div>
            <div class="file-name">
                <div class="row">
                    <div class="col-sm-10">
                        asd
                    </div>
                    <div class="col-sm-2">
                        asd
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif


