@extends('website::layouts.emails.order.default.layouts.template')

@section('body')

    @include('website::layouts.emails.order.default.layouts.partials.salutation')

    Informamos que seu pedido nº. <span style="font-size: 13px; color: #14a68f !important;"><b>{{ $order->number }}</b></span> realizado no dia {{ $order->creation_date }} no valor de {{ $order->total }} foi confirmado, separado e emitido a Nota Fiscal com sucesso.<br /><br />

    Entregue na transportadora, com o prazo de entrega de até {{ $order->shipment->deadline }}.<br /><br />

    Caso já tenha recebido seu pedido, favor desconsiderar esta mensagem, ou se precisar de qualquer outra informação, por favor entre em contato.

    @include('website::layouts.emails.order.default.layouts.partials.additional_message')

@endsection
