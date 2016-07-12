@extends('website::layouts.emails.order.default.layouts.template')

@section('body')

    @include('website::layouts.emails.order.default.layouts.partials.salutation')

    <p>Agradecemos por sua compra na Vinci.</p>

    <p>
        Para melhor atendê-lo, seu pedido de número <span style="font-size: 13px; color: #11b6f0 !important;"><b>{{ $order->number }}</b></span>
        realizado em nosso site foi transferido para o setor de televendas.
    </p>

    <p>Pedimos por gentileza que aguarde nosso breve contato.</p>

    @include('website::layouts.emails.order.default.layouts.partials.additional_message')

@endsection