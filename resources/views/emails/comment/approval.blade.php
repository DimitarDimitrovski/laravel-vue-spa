@component('mail::message')
Hello, {{ $comment->User->name }}.<br>
this is to inform you that {{ $admin }} has
@if($comment->approved === \App\Models\Review::DB_TRUE) approved @else rejected @endif your comment.<br>
@if($message)
@component('mail::panel')
Message:<br /> {{ $message }}
@endcomponent
@endif
Thanks,<br>
{{ config('app.name') }}
@endcomponent
