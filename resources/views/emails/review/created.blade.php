@component('mail::message')
Hello, {{ $admin }}.<br>
This is to inform you that {{ $author }} has just added a new review.<br>
Please log in to view the review.

@component('mail::button', ['url' => route('admin.reviews.show', ['id' => $reviewId])])
View Review
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
