@extends('website::layouts.emails.order.default.layouts.template')

<?php $color = '#00bff2'; ?>
@section('header.title', 'Notificação de indisponibilidade de produtos')
@section('header.bg.color', $color)
@section('footer.img.src', asset_web('images/emails/logo-footer-blue.jpg'))

@section('body')

    <tr>
        <td style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px; padding-bottom: 20px;">

            Olá {{ $receiver->getName() }}, <br><br>

            Segue a lista de produtos indisponíveis gerada em {{ $date }}: <br /><br />

            <b>Total de produtos indisponíveis:</b> {{ $total }} <br /><br /><br />

            <b>Produtos exibidos nas vitrines da home:</b> <br /><br />

            @if($productsHome->count())
                <table width="515" border="0" cellpadding="1" cellspacing="1" style="background-color:#f1f1f1;">
                    <tr style="background-color: #00bff2;height: 35px;">
                        <th valign="middle" width="90" align="center" style="color:#ffffff;font-family:Arial, verdana, sans-serif; font-size:15px;">#Código</th>
                        <th valign="middle" align="left" style="color:#ffffff;font-family:Arial, verdana, sans-serif; font-size:15px;padding-left: 5px;">Título</th>
                    </tr>

                    @foreach($productsHome as $product)
                        <tr>
                            <td valign="middle" align="center" style="height: 35px;border: 1px solid #cccccc;color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px;"><a href="{{ url('/p/vinho/' . $product['slug']) }}" target="_blank" style="color:{{ $color }} !important;">{{ $product['sku'] }}</a></td>
                            <td valign="middle" style="height: 35px;border: 1px solid #cccccc;color:#000000;font-family:Arial, verdana, sans-serif; font-size:13px;padding-left: 5px;">{{ $product['title'] }}</td>
                        </tr>
                    @endforeach
                </table>
            @else
                <table width="515" border="0" cellpadding="1" cellspacing="1" style="background-color:#f1f1f1;">
                    <tr style="background-color: #32b719;height: 35px;">
                        <th valign="middle" align="center" style="color:#ffffff;font-family:Arial, verdana, sans-serif; font-size:15px;">Não existem produtos indisponíveis nas vitrines da Home!</th>
                    </tr>
                </table>
            @endif

            @if($productsDefault->count())
            <table width="515" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px;padding:20px 0;">
                        <b>Outros produtos:</b>
                    </td>
                </tr>
            </table>
            <table border="0" cellpadding="1" cellspacing="1">
                <tr style="background-color: #888585;height: 35px;">
                    <th valign="middle" width="90" align="center" style="color:#ffffff;font-family:Arial, verdana, sans-serif; font-size:15px;">#Código</th>
                    <th valign="middle" align="left" style="color:#ffffff;font-family:Arial, verdana, sans-serif; font-size:15px;padding-left: 5px;">Título</th>
                    <th valign="middle" width="90" align="left" style="color:#ffffff;font-family:Arial, verdana, sans-serif; font-size:15px;padding-left: 5px;">Visível Site</th>
                </tr>
                @foreach($productsDefault as $product)
                    <tr>
                        <td valign="middle" align="center" style="height: 35px;border: 1px solid #cccccc;color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px;"><a href="{{ url('/p/vinho/' . $product['slug']) }}" target="_blank" style="color:{{ $color }} !important;">{{ $product['sku'] }}</a></td>
                        <td valign="middle" style="height: 35px;border: 1px solid #cccccc;color:#000000;font-family:Arial, verdana, sans-serif; font-size:13px;padding-left: 5px;">{{ $product['title'] }}</td>
                        <td valign="middle" align="center" style="height: 35px;border: 1px solid #cccccc;color:#000000;font-family:Arial, verdana, sans-serif; font-size:13px;padding-left: 5px;">{{ $product['online'] ? 'Sim' : 'Não' }}</td>
                    </tr>
                @endforeach
            </table>
            @endif


        </td>
    </tr>

@endsection
