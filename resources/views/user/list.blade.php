<div class="table-responsive">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th> <span class="cursor-pointer sort" data-sort="name"> Name <i class="fa fa-sort" aria-hidden="true"></i> </span></th>
            <th> <span class="cursor-pointer sort" data-sort="email"> Email <i class="fa fa-sort" aria-hidden="true"></i> </span></th>
            <th>Roles</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($entities as $key => $entity)
            <tr class="entity-row clickable-row cursor-pointer" data-href="{{ route('user.show', ['id' => $entity->id]) }}">
                <td>{{ $key+1 }}</td>
                <td>{{ $entity->first_name }} {{ $entity->last_name }}</td>
                <td>{{ $entity->email }}</td>
                <td>
                    @foreach($entity->roles as $role)
                        <span class="label">{{ $role->name }}</span>
                    @endforeach
                </td>
                <td>{{ $entity->status_text }}</td>
                <td class="action">
                    <a href="{{ route('user.show', ['id' => $entity->id]) }}" class="btn btn-outline btn-sm btn-success">Edit</a>
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