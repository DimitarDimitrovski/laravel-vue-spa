@component('mail::message')
Hello, {{ $admin }}.<br>
This is to inform you that {{ $author }} has just created a new comment.<br>
Please log in to review the comment.

@component('mail::button', ['url' => route('admin.comments.show', ['id' => $commentId])])
View Comment
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
