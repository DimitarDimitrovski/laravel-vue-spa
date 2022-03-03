@component('mail::message')
Hello, {{ $admin }}.<br>
This is to inform you that {{ $author }} has updated a review.<br>
Please log in to view the changes and set approval status.
@component('mail::button', ['url' => route('admin.reviews.show', ['id' => $reviewId])])
View Changes
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
