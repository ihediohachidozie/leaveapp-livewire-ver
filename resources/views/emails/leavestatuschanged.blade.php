@component('mail::message')
# Dear {{$name}}

Kindly be informed that your leave application request is open.

@component('mail::button', ['url' => $url])
Visit App
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
