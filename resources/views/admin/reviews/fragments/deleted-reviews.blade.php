<table id="deletedReviews" class="table table-bordered">
    <thead>
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Recipe</th>
        <th>Rating</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($deletedReviews as $deletedReview)
        <tr class="deleted">
            <td>{{ $deletedReview->title }}</td>
            <td>
                <img src="{{ asset('/storage/avatars')}}/{{$deletedReview->User->image }}"
                     width="50" height="50" class="rounded-circle" /> {{ $deletedReview->User->name }}
            </td>
            <td>{{ $deletedReview->Recipe->name }}</td>
            <td>{{ $deletedReview->rating }}</td>
            <td>
                @if($deletedReview->approved === \App\Models\Review::DB_TRUE)
                    <span class="badge rounded-pill bg-success">Approved</span>
                @else
                    <span class="badge rounded-pill bg-danger">Not Approved</span>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
