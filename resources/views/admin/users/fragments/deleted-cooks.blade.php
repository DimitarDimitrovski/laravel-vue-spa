<table id="deletedCooks" class="table table-bordered">
    <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>City</th>
        <th>Bio</th>
    </tr>
    </thead>
    <tbody>
    @foreach($deletedCooks as $deletedCook)
        <tr class="deleted">
            <td style="position: relative">
                <img src="{{ asset('/storage/avatars')}}/{{$deletedCook->image }}"
                     width="50" height="50" class="rounded-circle" /> {{ $deletedCook->name }}
            </td>
            <td>{{ $deletedCook->email }}</td>
            <td>{{ $deletedCook->city }}</td>
            <td>{{ $deletedCook->description }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
