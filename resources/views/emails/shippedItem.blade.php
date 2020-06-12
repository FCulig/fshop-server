@component('mail::message')
    # Proizvod poslan!

    Proizvod {{$productName}} je poslan!


    Hvala na povjerenju,
    Vaš {{ config('app.name') }}
@endcomponent
