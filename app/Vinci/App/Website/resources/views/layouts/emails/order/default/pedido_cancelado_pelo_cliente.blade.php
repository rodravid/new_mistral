@extends('website::layouts.emails.order.default.layouts.template')

<?php $color = '#00bff2'; ?>
@section('header.title', 'Pedido cancelado')
@section('header.bg.color', $color)
@section('footer.img.src', asset_web('images/emails/logo-footer-blue.jpg'))

@section('body')


    <tr>
        <td style="font-size: 20px;font-family:Arial, verdana, sans-serif;color: {{ $color }}  !important; padding:0px 0 20px 0;">
            <b>Status do Pedido</b>
        </td>
    </tr>

    <tr>
        <td style="font-size:15px;font-family:Arial, verdana, sans-serif;">
            @include('website::layouts.emails.order.default.layouts.partials.salutation')
        </td>
    </tr>

    <tr>
        <td style="font-size:15px;font-family:Arial, verdana, sans-serif; padding:0 0 20px 0">
            Conforme solicitado, o pedido de número <span style="font-size: 15px; color: #11b6f0 !important;"><b>{{ $order->number }}</b></span> foi cancelado em nosso site.
        </td>
    </tr>

    <tr>
        <td style="font-size:15px;font-family:Arial, verdana, sans-serif;">
            @include('website::layouts.emails.order.default.layouts.partials.additional_message')
        </td>
    </tr>



@endsection

