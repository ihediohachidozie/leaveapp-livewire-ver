@component('mail::message')
# Dear Sir/Ma,

Kindly approve leave application request for {{ $name}}
with staff Id {{ $staff_id }}.

@component('mail::button', ['url' => $url])
Visit app
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
