@component('mail::message')
    # Uspješna narudžba!

    {{$firstname}} {{$lastname}}, uspješno ste naručili {{$productName}} x{{$productQuantity}}!


    Hvala na povjerenju,
    Vaš {{ config('app.name') }}
@endcomponent
