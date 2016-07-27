@extends('website::layouts.emails.order.default.layouts.template')

<?php $color = '#00bff2'; ?>
@section('header.title', 'Pedido cancelado')
@section('header.bg.color', $color)
@section('footer.img.src', asset_web('images/emails/logo-footer-blue.jpg'))

@section('body')

    @include('website::layouts.emails.order.default.layouts.partials.salutation')

    <tr>
        <td style="font-size: 15px;font-family:Arial, verdana, sans-serif; padding-bottom: 20px">
            Não identificamos o pagamento do pedido número <span style="font-size: 13px; color: #11b6f0 !important;"><b>{{ $order->number }}</b></span>
            e por este motivo o mesmo foi cancelado em nosso site.
        </td>
    </tr>

    <tr>
        <td style="font-size: 15px;font-family:Arial, verdana, sans-serif;">
            @include('website::layouts.emails.order.default.layouts.partials.additional_message')
        </td>
    </tr>

@endsection



