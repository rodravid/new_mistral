@extends('website::layouts.emails.order.default.layouts.template')

@section('body')

    <span style="font-size: 20px; color: #14a68f !important;"><b>Pedido Recebido</b></span><br /><br />

    @include('website::layouts.emails.order.default.layouts.partials.salutation')

    O status do seu pedido nº <span style="font-size: 13px; color: #14a68f !important;"><b>{{ $order->number }}</b></span> no valor de {{ $order->total }}
    foi recebido com sucesso, para visualizar mais detalhes acesse os seus pedidos na área restrita.

    @include('website::layouts.emails.order.default.layouts.partials.additional_message')

@endsection
