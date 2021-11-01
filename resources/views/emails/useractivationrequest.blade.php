@component('mail::message')
# Dear Sir/Ma,

Kindly assign {{ $firstname }} {{' '}} {{ $lastname}} with staff Id {{$staff_id}}
to the appropriate department, category and approval right if appicable.

@component('mail::button', ['url' => '$url'])
Visit app
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
