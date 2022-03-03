@component('mail::message')
Hello, {{ $admin }}.<br>
This is to inform you that {{ $user }} has just created a new recipe.<br>
Please log in to view the recipe.
@component('mail::button', ['url' => route('admin.recipes.show', ['id' => $recipeId])])
View Recipe
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
