<table id="deletedComments" class="table table-bordered">
    <thead>
    <tr>
        <th>Comment</th>
        <th>Author</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($deletedComments as $deletedComment)
        <tr class="deleted">
            <td>{{ $deletedComment->content }}</td>
            <td>
                <img src="{{ asset('/storage/avatars')}}/{{$deletedComment->User->image }}"
                     width="50" height="50" class="rounded-circle" /> {{ $deletedComment->User->name }}
            </td>
            <td>
                @if($deletedComment->approved === \App\Models\Comment::DB_TRUE)
                    <span class="badge rounded-pill bg-success">Approved</span>
                @else
                    <span class="badge rounded-pill bg-danger">Not Approved</span>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
