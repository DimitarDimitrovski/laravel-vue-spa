<table id="activeCooks" class="table table-bordered">
    <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>City</th>
        <th>Bio</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($cooks as $cook)
        <tr>
            <td style="position: relative">
                <img src="{{ asset('/storage/avatars')}}/{{$cook->image }}"
                     width="50" height="50" class="rounded-circle" /> {{ $cook->name }}
            </td>
            <td>{{ $cook->email }}</td>
            <td>{{ $cook->city }}</td>
            <td>{{ $cook->description }}</td>
            <td>
                <a href="{{ route('admin.users.show', ['id' => $cook->id]) }}" class="text-decoration-none">
                    <i class="fa fa-eye"></i>
                </a>
                <span style="cursor: pointer; color: red;" data-bs-toggle="modal" data-bs-target="#deletePopup" class="delete"
                      data-url="{{ route('admin.users.destroy', ['id' => $cook->id]) }}">
                    <i class="fa fa-trash"></i>
                </span>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
