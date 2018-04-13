<div class="table-responsive">
    <table class="table table-hover issue-tracker">
        <tbody>
        @foreach($entities as $entity)
            <tr id="container-note-{{ $entity->id }}" class="note-row">
                <td class="issue-info">
                    <a href="#">
                        {{ $entity->title }}
                    </a>
                    <small>
                        {{ $entity->content }}
                    </small>
                </td>
                <td>
                    <i class="fa fa-user-o" aria-hidden="true"></i> {{ $entity->user->first_name }} {{ $entity->user->last_name }}
                </td>
                <td>
                    <i class="fa fa-calendar" aria-hidden="true"></i> {{ $entity->created_at->toFormattedDateString() }}
                </td>
                <td class="action">
                    <button type="button" data-entity-id="{{ $entity->id }}" data-entity="{{ $entity }}" class="btn btn-outline btn-success btn-note-edit">Edit</button>
                    <button type="button" data-entity-id="{{ $entity->id }}" class="btn btn-outline btn-danger btn-note-delete">Delete</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>