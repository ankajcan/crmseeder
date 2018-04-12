<div class="table-responsive">
    <table class="table table-hover issue-tracker">
        <tbody>
        @foreach($entities as $entity)
            <tr>
                <td class="issue-info">
                    <a href="#">
                        {{ $entity->title }}
                    </a>
                    <small>
                        {{ $entity->content }}
                    </small>
                </td>
                <td>
                    {{ $entity->user->first_name }} {{ $entity->user->last_name }}
                </td>
                <td>
                    {{ $entity->created_at->toFormattedDateString() }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>