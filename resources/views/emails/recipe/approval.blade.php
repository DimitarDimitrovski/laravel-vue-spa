@component('mail::message')
Hello, {{ $user }}<br>
This is to inform you that {{ $admin }} has
{{ $recipe->approved == \App\Models\Recipe::DB_TRUE ? 'approved' : 'rejected' }} your "{{ $recipe->name }}" recipe.<br>
@if($message)
@component('mail::panel')
Message:<br /> {{ $message }}
@endcomponent
@endif
@if($recipe->approved === \App\Models\Recipe::DB_TRUE)
@component('mail::button', ['url' => route('admin.recipes.show', ['id' => $recipe->id])])
View Recipe
@endcomponent
@endif
Thanks,<br>
{{ config('app.name') }}
@endcomponent
