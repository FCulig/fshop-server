@component('mail::message')
    # Dobro došli u F Shop!

    {{$firstname}} {{$lastname}}, vaša registracija je uspješna!


    Hvala na povjerenju,
    Vaš {{ config('app.name') }}
@endcomponent

