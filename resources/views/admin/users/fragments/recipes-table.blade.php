<table id="recipesTable" class="table table-bordered">
    <thead>
    <tr>
        <th>Recipe</th>
        <th>Type</th>
        <th>Preparation Time</th>
        <th>Preparation Level</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($user->Recipes as $recipe)
        <tr>
            <td>{{ $recipe->name }}</td>
            <td>{{ $recipe->type }}</td>
            <td>{{ $recipe->preparation_time }} min.</td>
            <td>{{ $recipe->preparation_level }}</td>
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
