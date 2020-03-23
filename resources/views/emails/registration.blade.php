@component('mail::message')
# Welcome to F Shop!

{{$firstname}} {{$lastname}}, your registration was successful, now you can sell or buy products.


Thanks,<br>
{{ config('app.name') }}
@endcomponent

