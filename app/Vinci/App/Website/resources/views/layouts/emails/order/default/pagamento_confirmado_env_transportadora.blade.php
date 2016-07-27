@extends('website::layouts.emails.order.default.layouts.template')

<?php $color = '#00bff2'; ?>
@section('header.title', 'Entregue na transportadora')
@section('header.bg.color', $color)
@section('footer.img.src', asset_web('images/emails/logo-footer-blue.jpg'))

@section('body')

    @include('website::layouts.emails.order.default.layouts.partials.salutation')
    <tr>
        <td style="font-size: 15px;font-family:Arial, verdana, sans-serif; padding-bottom: 20px">
            Informamos que seu pedido nº. <span style="font-size: 13px; color: {{ $color }} !important;"><b>{{ $order->number }}</b></span> realizado no dia {{ $order->creation_date }} no valor de {{ $order->total }} foi confirmado, separado e emitido a Nota Fiscal com sucesso.<br /><br />

            Entregue na transportadora, com o prazo de entrega de até {{ $order->shipment->deadline }}.<br /><br />

            Caso já tenha recebido seu pedido, favor desconsiderar esta mensagem, ou se precisar de qualquer outra informação, por favor entre em contato.

        </td>
    </tr>

    <tr>
        <td style="font-size: 15px;font-family:Arial, verdana, sans-serif;">
            @include('website::layouts.emails.order.default.layouts.partials.additional_message')
        </td>
    </tr>


@endsection
