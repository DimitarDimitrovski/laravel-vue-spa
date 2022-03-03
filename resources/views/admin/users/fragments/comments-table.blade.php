<table id="commentsTable" class="table table-bordered">
    <thead>
    <tr>
        <th>Comment</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($user->Comments as $comment)
        <tr>
            <td>{{ $comment->content }}</td>
            <td>
                <a href="{{ route('admin.comments.show', ['id' => $comment->id]) }}" class="text-decoration-none">
                    <i class="fa fa-eye"></i>
                </a>
                <span style="cursor: pointer; color: red;" data-bs-toggle="modal" data-bs-target="#deletePopup"
                      data-url="{{ route('admin.comments.destroy', ['id' => $comment->id]) }}">
                        <i class="fa fa-trash"></i>
                    </span>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
