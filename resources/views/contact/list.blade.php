<div class="table-responsive">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($entities as $entity)
            <tr>
                <td>{{ $entity->id }}</td>
                <td>{{ $entity->full_name }}</td>
                <td>{{ $entity->email }}</td>
                <td>
                    <a href="{{ route('contact.show', ['id' => $entity->id]) }}" type="button" class="btn btn-xs btn-success">Edit</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="clearfix"></div>
{{-- PAGINATION --}}
@if($entities->lastPage() > 1)
    <nav class="" aria-label="Page Navigation">
        <ul class="pagination">
            @if($entities->currentPage() > 1)
                <li>
                    <a data-page="1" class="" aria-label="Previous">
                    <span aria-hidden="true">
                      <i class="fa fa-angle-left"></i> <i class="fa fa-angle-left"></i>
                    </span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
            @endif
            @if($entities->currentPage() > 1)
                <li class="">
                    <a data-page="{{ $entities->currentPage() - 1 }}"  class="">
                        <i class="fa fa-angle-left"></i>&nbsp;
                    </a>
                </li>
            @endif
            @for($i = 1; $i <= $entities->lastPage(); $i ++)
                <li class="@if($entities->currentPage() == $i) active @endif">
                    <a data-page="{{ $i }}" href>{{ $i }}</a>
                </li>
            @endfor
            @if($entities->currentPage() < $entities->lastPage())
                <li>
                    <a data-page="{{ $entities->currentPage() + 1 }}" aria-label="Next">
                        <span aria-hidden="true">
                           &nbsp;<i class="fa fa-angle-right"></i>
                        </span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            @endif
            <li>
                <a data-page="{{ $entities->lastPage() }}" aria-label="Next">
                    <span aria-hidden="true">
                        <i class="fa fa-angle-right"></i> <i class="fa fa-angle-right"></i>
                    </span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>
@endif