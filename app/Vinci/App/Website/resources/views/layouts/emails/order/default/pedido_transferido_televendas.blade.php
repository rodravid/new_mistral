@extends('website::layouts.emails.order.default.layouts.template')

<?php $color = '#00bff2'; ?>
@section('header.title', 'Pedido transferido')
@section('header.bg.color', $color)
@section('footer.img.src', asset_web('images/emails/logo-footer-blue.jpg'))

@section('body')

    <tr>
        <td>
            @include('website::layouts.emails.order.default.layouts.partials.salutation')
        </td>
    </tr>

    <tr>
        <td style="font-size:15px;font-family:Arial, verdana, sans-serif;">
            <p>Agradecemos por sua compra na Vinci.</p>

            <p>
                Para melhor atendê-lo, seu pedido de número <span style="font-size: 15px; color: #11b6f0 !important;"><b>{{ $order->number }}</b></span>
                realizado em nosso site foi transferido para o setor de televendas.
            </p>

            <p>Pedimos por gentileza que aguarde nosso breve contato.</p>
        </td>
    </tr>


    <tr>
        <td style="font-size:15px;font-family:Arial, verdana, sans-serif;">
            @include('website::layouts.emails.order.default.layouts.partials.additional_message')
        </td>
    </tr>



@endsection