<table id="activeRecipes" class="table table-bordered">
    <thead>
    <tr>
        <th>Recipe</th>
        <th>Cook</th>
        <th>Type</th>
        <th>Preparation Time</th>
        <th>Preparation Level</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($recipes as $recipe)
        <tr>
            <td style="position: relative">
                {{ $recipe->name }}
            </td>
            <td>
                <img src="{{ asset('/storage/avatars')}}/{{$recipe->User->image }}"
                     width="50" height="50" class="rounded-circle" /> {{ $recipe->User->name }}
            </td>
            <td>{{ $recipe->type }}</td>
            <td>{{ $recipe->preparation_time }} min.</td>
            <td>{{ $recipe->preparation_level }}</td>
            <td>
                @if($recipe->approved === \App\Models\Review::DB_TRUE)
                    <span class="badge rounded-pill bg-success">Approved</span>
                @else
                    <span class="badge rounded-pill bg-danger">Not Approved</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.recipes.show', ['id' => $recipe->id]) }}" class="text-decoration-none">
                    <i class="fa fa-eye"></i>
                </a>
                <span class="delete" style="cursor: pointer; color: red;" data-bs-toggle="modal" data-bs-target="#deletePopup"
                      data-url="{{ route('admin.recipes.destroy', ['id' => $recipe->id]) }}">
                    <i class="fa fa-trash"></i>
                </span>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
