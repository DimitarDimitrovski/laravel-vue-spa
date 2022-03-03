<table id="deletedRecipes" class="table table-bordered">
    <thead>
    <tr>
        <th>Recipe</th>
        <th>Cook</th>
        <th>Type</th>
        <th>Preparation Time</th>
        <th>Preparation Level</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($deletedRecipes as $deletedRecipe)
        <tr class="deleted">
            <td style="position: relative">
                {{ $deletedRecipe->name }}
            </td>
            <td>
                <img src="{{ asset('/storage/avatars')}}/{{$deletedRecipe->User->image }}"
                     width="50" height="50" class="rounded-circle" /> {{ $deletedRecipe->User->name }}
            </td>
            <td>{{ $deletedRecipe->type }}</td>
            <td>{{ $deletedRecipe->preparation_time }} min.</td>
            <td>{{ $deletedRecipe->preparation_level }}</td>
            <td>
                @if($deletedRecipe->approved === \App\Models\Review::DB_TRUE)
                    <span class="badge rounded-pill bg-success">Approved</span>
                @else
                    <span class="badge rounded-pill bg-danger">Not Approved</span>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
