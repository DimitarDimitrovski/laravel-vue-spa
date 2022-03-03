<table id="reviewsTable" class="table table-bordered">
    <thead>
    <tr>
        <th>Title</th>
        <th>Recipe</th>
        <th>Rating</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($user->Reviews as $review)
        <tr>
            <td>{{ $review->title }}</td>
            <td>{{ $review->Recipe->name }}</td>
            <td>{{ $review->rating }}</td>
            <td>
                <a class="text-decoration-none" href="{{ route('admin.reviews.show', ['id' => $review->id]) }}">
                    <i class="fa fa-eye"></i>
                </a>
                <span style="cursor: pointer; color: red;" data-bs-toggle="modal" data-bs-target="#deletePopup"
                      data-url="{{ route('admin.reviews.destroy', ['id' => $review->id]) }}">
                        <i class="fa fa-trash"></i>
                    </span>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
