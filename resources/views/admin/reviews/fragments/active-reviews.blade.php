<table id="activeReviews" class="table table-bordered">
    <thead>
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Recipe</th>
        <th>Rating</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($reviews as $review)
        <tr>
            <td>{{ $review->title }}</td>
            <td>
                <img src="{{ asset('/storage/avatars')}}/{{$review->User->image }}"
                     width="50" height="50" class="rounded-circle" /> {{ $review->User->name }}
            </td>
            <td>{{ $review->Recipe->name }}</td>
            <td>{{ $review->rating }}</td>
            <td>
                @if($review->approved === \App\Models\Review::DB_TRUE)
                    <span class="badge rounded-pill bg-success">Approved</span>
                @else
                    <span class="badge rounded-pill bg-danger">Not Approved</span>
                @endif
            </td>
            <td>
                <a class="text-decoration-none" href="{{ route('admin.reviews.show', ['id' => $review->id]) }}">
                    <i class="fa fa-eye"></i>
                </a>
                <span style="cursor: pointer; color: red;" data-bs-toggle="modal" data-bs-target="#deletePopup" class="delete"
                      data-url="{{ route('admin.reviews.destroy', ['id' => $review->id]) }}">
                      <i class="fa fa-trash"></i>
                </span>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
