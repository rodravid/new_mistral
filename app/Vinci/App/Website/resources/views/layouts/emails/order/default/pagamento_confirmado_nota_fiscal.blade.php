@extends('website::layouts.emails.order.default.layouts.template')

<?php $color = '#00bff2'; ?>
@section('header.title', 'Nota Fiscal Emitida')
@section('header.bg.color', $color)
@section('footer.img.src', asset_web('images/emails/logo-footer-blue.jpg'))

@section('body')

    @include('website::layouts.emails.order.default.layouts.partials.salutation')

    <tr>
        <td style="border: solid 1px #bbcad1; padding: 20px; font-size: 18px;font-family:Arial, verdana, sans-serif;">
            Seu pedido número <span style="font-size: 18px; color: {{ $color }}  !important;"><b>{{ $order->number }}</b></span> foi faturado e a nota fiscal foi emitida.
        </td>
    </tr>

    <tr>
        <td style="font-family:Arial, verdana, sans-serif; font-size: 15px; padding: 34px 0 25px 0">
            O pedido será entregue em até <font style="color:{{ $color }}; font-weight: bold;">{{ $order->shipment->deadline }}</font>.
        </td>
    </tr>

    <tr>
        <td style="font-family:Arial, verdana, sans-serif; font-size: 15px; padding-bottom: 20px;">
            @include('website::layouts.emails.order.default.layouts.partials.additional_message')
        </td>
    </tr>

    <tr>
        <td style="font-family:Arial, verdana, sans-serif; font-size: 15px; padding-bottom: 20px;">
            Atenciosamente, <br>
            Equipe de Comércio Eletrônico
        </td>
    </tr>



@endsection
