<div id="container-file-{{ $file->id }}"  class="file-box file-container">
    <div class="file">
        <span class="corner"></span>
        <a href="{{ $file->url }}" target="_blank">
            @if($file->file_type == "image")
                <div class="image" style="background-image:url('{{ $file->thumb }}')"></div>
            @else
                <div class="icon"><i class="fa fa-file"></i></div>
            @endif
        </a>
        <div class="file-name">
            <div class="row">
                <div class="col-sm-10">
                    <a href="{{ $file->url }}" target="_blank">{{ str_limit($file->name,40) }}</a>
                </div>
                <div class="col-sm-2">
                    <a class="btn-delete-file pull-right" data-entity-id="{{$file->id}}" > <i class="fa fa-trash" aria-hidden="true"></i> </a>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="files[]" value="{{$file->id}}" />
</div>

