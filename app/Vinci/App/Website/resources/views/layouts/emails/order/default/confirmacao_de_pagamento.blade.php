@extends('website::layouts.emails.order.default.layouts.template')
@section('body')

    @include('website::layouts.emails.order.default.layouts.partials.salutation')

    Confirmamos o recebimento do depósito bancário no valor de {{ $order->total }} referente ao seu pedido de número {{ $order->number }}.
    <br><br>

    O pedido será finalizado em até 2 (dois) dias úteis e seguirá então para entrega. <br><br>

    Lembramos que a previsão de entrega é contada após identificação e confirmação do pagamento.

    @include('website::layouts.emails.order.default.layouts.partials.additional_message')
@endsection