@extends('website::layouts.emails.order.default.layouts.template')

@section('body')

    <span style="font-size: 20px; color: #11b6f0 !important;"><b>Pagamento confirmado</b></span><br /><br />

    @include('website::layouts.emails.order.default.layouts.partials.salutation')

    Seu pedido número <span style="font-size: 13px; color: #11b6f0 !important;"><b>{{ $order->number }}</b></span> foi faturado e a nota fiscal foi emitida. <br><br>

    O pedido será entregue em até {{ $order->shipment->deadline }}.

    @include('website::layouts.emails.order.default.layouts.partials.additional_message')

@endsection
