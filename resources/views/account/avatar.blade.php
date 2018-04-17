@if($avatar)
    <img id="img-entity-avatar" src="{{ $avatar->url }}" class="img-lg"> <br> <br>
@else
    <img id="img-entity-avatar" src="http://via.placeholder.com/200x200?text=Avatar" class="img-lg"> <br> <br>
@endif