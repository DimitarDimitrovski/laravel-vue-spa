@component('mail::message')
Hello, {{ $admin }}.<br>
This is to inform you that {{ $author }} has just updated their recipe.<br>
Please log in to view the changes and apply approval status.
@component('mail::button', ['url' => route('admin.recipes.show', ['id' => $recipeId])])
    View Recipe
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
