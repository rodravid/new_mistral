@extends('website::layouts.emails.order.default.layouts.template')

@section('body')

    @include('website::layouts.emails.order.default.layouts.partials.salutation')

    O pedido nº <span style="font-size: 13px; color: #11b6f0 !important;"><b>{{ $order->number }}</b></span> ...

    @include('website::layouts.emails.order.default.layouts.partials.additional_message')
@endsection




