@component('mail::message')
# Dear {{$staff_name}}

Kindly be informed that your leave application request is {{$statusResult}}.

Comment:

{{$comment}}


@component('mail::button', ['url' => $url])
Visit App
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
