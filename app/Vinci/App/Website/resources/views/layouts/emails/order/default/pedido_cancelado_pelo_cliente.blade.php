@extends('website::layouts.emails.order.default.layouts.template')

@section('body')

    <span style="font-size: 13px; color: #11b6f0 !important;"><b>Status do Pedido</b></span><br /><br />

    @include('website::layouts.emails.order.default.layouts.partials.salutation')

    O pedido Nº <span style="font-size: 13px; color: #11b6f0 !important;"><b>{{ $order->number }}</b></span> foi cancelado pelo cliente ou por motivos diversos.

    @include('website::layouts.emails.order.default.layouts.partials.additional_message')

@endsection

