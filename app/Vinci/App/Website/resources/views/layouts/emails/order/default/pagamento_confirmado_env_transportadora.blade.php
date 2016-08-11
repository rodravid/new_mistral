@extends('website::layouts.emails.order.default.layouts.template')

<?php $color = '#00bff2'; ?>
@section('header.title', 'Entregue na transportadora')
@section('header.bg.color', $color)
@section('footer.img.src', asset_web('images/emails/logo-footer-blue.jpg'))

@section('body')

    @include('website::layouts.emails.order.default.layouts.partials.salutation')
    <tr>
        <td style="font-size: 15px;font-family:Arial, verdana, sans-serif; padding-bottom: 20px">
            Informamos que seu pedido nº. <span style="font-size: 13px; color: {{ $color }} !important;"><b>{{ $order->number }}</b></span> realizado no dia {{ $order->creation_date }} no valor de {{ $order->total }}
            finalizado com sucesso e está em trânsito. O prazo de entrega é de até {{ $order->shipment->deadline }}.
            <br /><br />

            Caso já tenha recebido seu pedido, por favor desconsidere esta mensagem.

        </td>
    </tr>

    <tr>
        <td style="font-size: 15px;font-family:Arial, verdana, sans-serif;">
            @include('website::layouts.emails.order.default.layouts.partials.additional_message')
        </td>
    </tr>


@endsection
