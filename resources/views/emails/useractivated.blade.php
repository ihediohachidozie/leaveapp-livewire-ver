@component('mail::message')
# Dear {{$name}}

Kindly be inform that you have been activated and can proceed with your leave applications.

@component('mail::button', ['url' => $url])
Visit App
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
