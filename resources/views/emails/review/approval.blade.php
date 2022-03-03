@component('mail::message')
Hello, {{ $review->User->name }}.<br>
this is to inform you that {{ $admin }} has
@if($review->approved === \App\Models\Review::DB_TRUE) approved @else rejected @endif your
review on {{ $review->Recipe->name }}<br>
@if($message)
@component('mail::panel')
Message:<br /> {{ $message }}
@endcomponent
@endif
Thanks,<br>
{{ config('app.name') }}
@endcomponent
