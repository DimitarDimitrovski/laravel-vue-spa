<table id="activeComments" class="table table-bordered">
    <thead>
    <tr>
        <th>Comment</th>
        <th>Author</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($comments as $comment)
        <tr>
            <td>{{ $comment->content }}</td>
            <td>
                <img src="{{ asset('/storage/avatars')}}/{{$comment->User->image }}"
                     width="50" height="50" class="rounded-circle" /> {{ $comment->User->name }}
            </td>
            <td>
                @if($comment->approved === \App\Models\Comment::DB_TRUE)
                    <span class="badge rounded-pill bg-success">Approved</span>
                @else
                    <span class="badge rounded-pill bg-danger">Not Approved</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.comments.show', ['id' => $comment->id]) }}"
                   class="text-decoration-none" style="cursor: pointer;">
                    <i class="fa fa-eye"></i>
                </a>
                <span style="cursor: pointer; color: red;" data-bs-toggle="modal" data-bs-target="#deletePopup" class="delete"
                      data-url="{{ route('admin.comments.destroy', ['id' => $comment->id]) }}">
                        <i class="fa fa-trash"></i>
                    </span>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
