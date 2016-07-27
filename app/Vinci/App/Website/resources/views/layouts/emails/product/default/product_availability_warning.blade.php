@extends('website::layouts.emails.order.default.layouts.template')

<?php $color = '#00bff2'; ?>
@section('header.title', 'Nota Fiscal Emitida')
@section('header.bg.color', $color)
@section('footer.img.src', asset_web('images/emails/logo-footer-blue.jpg'))

@section('body')

    @include('website::layouts.emails.order.default.layouts.partials.salutation')

    <tr>
        <td style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px; padding-bottom: 20px;">
            Gostaríamos de informá-lo(a) que o produto {{ $product->title }} já está disponível novamente em nosso site.
            <br>
            Importante: este é apenas um aviso automático e não garante a reserva do produto.
            <br>
            Para comprá-lo clique em: <a href="{{ url($product->getWebPath()) }}">{{ $product->title }}</a>.
        </td>
    </tr>


    <tr>
        <td style="font-family:Arial, verdana, sans-serif; font-size: 15px; padding-bottom: 0px;">
    @include('website::layouts.emails.order.default.layouts.partials.additional_message')
        </td>
    </tr>

@endsection
