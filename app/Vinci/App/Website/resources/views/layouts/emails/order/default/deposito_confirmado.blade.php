@extends('website::layouts.emails.order.default.layouts.template')

<?php $color = '#8a25d8'; ?>
@section('header.title', 'Depósito confirmado')
@section('header.bg.color', $color)
@section('footer.img.src', asset_web('images/emails/logo-footer-purple.jpg'))

@section('body')

    @include('website::layouts.emails.order.default.layouts.partials.salutation')

    <tr>
        <td style="font-size: 18px;font-family:Arial, verdana, sans-serif;color: {{ $color }}  !important; padding-bottom:25px;">
            <b>Agradecemos por sua compra na Vinci.</b>
        </td>
    </tr>

    <tr>
        <td style="border: solid 1px #bbcad1; padding: 20px; font-size: 18px;font-family:Arial, verdana, sans-serif;">
            Confirmamos o recebimento do depósito bancário no valor de <span style="font-size: 18px; color: {{ $color }}  !important;">{{ $order->total }} </span> referente ao seu pedido de número <span style="font-size: 18px; color: {{ $color }}  !important;">{{ $order->number }}</span>.
        </td>
    </tr>

    <tr>
        <td style="font-family:Arial, verdana, sans-serif; font-size: 15px; padding:20px 0;">
            O pedido será finalizado em até 2 (dois) dias úteis e seguirá para entrega.
        </td>
    </tr>

    <tr>
        <td style="font-family:Arial, verdana, sans-serif; font-size: 15px; padding-bottom: 20px;">
            Lembramos que a previsão de entrega é contada após identificação e confirmação do pagamento.
        </td>
    </tr>

    <tr>
        <td style="font-family:Arial, verdana, sans-serif; font-size: 15px; padding-bottom: 0px;">
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