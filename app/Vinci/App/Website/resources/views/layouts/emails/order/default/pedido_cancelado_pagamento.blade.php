@extends('website::layouts.emails.order.default.layouts.template')

@section('body')

    @include('website::layouts.emails.order.default.layouts.partials.salutation')

    Não identificamos o pagamento do pedido número <span style="font-size: 13px; color: #11b6f0 !important;"><b>{{ $order->number }}</b></span>
    e por este motivo o mesmo foi cancelado em nosso site.

    @include('website::layouts.emails.order.default.layouts.partials.additional_message')

@endsection



