@extends('website::layouts.emails.order.default.layouts.template')

@section('body')

    @include('website::layouts.emails.order.default.layouts.partials.salutation')

    O pedido nº <span style="font-size: 13px; color: #14a68f !important;"><b>{{ $order->number }}</b></span> foi cancelado por falta de produto.

    @include('website::layouts.emails.order.default.layouts.partials.additional_message')

@endsection