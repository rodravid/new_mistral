@extends('website::layouts.emails.order.default.layouts.template')

<?php $color = '#00bff2'; ?>
@section('header.title', 'Notificação de indisponibilidade de produtos')
@section('header.bg.color', $color)
@section('footer.img.src', asset_web('images/emails/logo-footer-blue.jpg'))

@section('body')

    <tr>
        <td style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px; padding-bottom: 20px;">

            Olá Felipe, <br><br>

            Segue a lista de produtos sem estoque da data 23/08/2016 às 10:35h: <br /><br />

            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <th width="100" align="left" style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px; padding-bottom: 15px;">#Código</th>
                    <th width="250" align="left" style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px;padding-bottom: 15px;">Título</th>
                    <th width="100" align="left" style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px;padding-bottom: 15px;">URL</th>
                </tr>
                <tr>
                    <td valign="top" style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px;padding-bottom: 10px;">12345</td>
                    <td valign="top" style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px; padding:0 3px 10px 3px;">Cabernet Sauvgnon Reserva 2015</td>
                    <td valign="top" style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px; padding-bottom: 10px;" align="left"><a href="/teste" target="_blank" style="color:{{ $color }} !important;">Link do produto</a></td>
                </tr>

                <tr>
                    <td valign="top" style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px;padding-bottom: 10px;">12345</td>
                    <td valign="top" style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px; padding:0 3px 10px 3px;">Cabernet Sauvgnon Reserva 2015</td>
                    <td valign="top" style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px; padding-bottom: 10px;" align="left"><a href="/teste" target="_blank" style="color:{{ $color }} !important;">Link do produto</a></td>
                </tr>

                <tr>
                    <td valign="top" style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px;padding-bottom: 10px;">12345</td>
                    <td valign="top" style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px; padding:0 3px 10px 3px;">Cabernet Sauvgnon Reserva 2015 lorem</td>
                    <td valign="top" style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px; padding-bottom: 10px;" align="left"><a href="/teste" target="_blank" style="color:{{ $color }} !important;">Link do produto</a></td>
                </tr>

            </table>

            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px;padding:20px 0;">
                        Segue a lista de produtos sem estoque da data 23/08/2016 às 10:35h:
                    </td>
                </tr>
            </table>
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <th width="100" align="left" style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px; padding-bottom: 15px;">#Código</th>
                    <th width="250" align="left" style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px;padding-bottom: 15px;">Título</th>
                    <th width="100" align="left" style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px;padding-bottom: 15px;">URL</th>
                </tr>
                <tr>
                    <td valign="top" style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px;padding-bottom: 10px;">12345</td>
                    <td valign="top" style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px; padding:0 3px 10px 3px;">Cabernet Sauvgnon Reserva 2015</td>
                    <td valign="top" style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px; padding-bottom: 10px;" align="left"><a href="/teste" target="_blank" style="color:{{ $color }} !important;">Link do produto</a></td>
                </tr>

                <tr>
                    <td valign="top" style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px;padding-bottom: 10px;">12345</td>
                    <td valign="top" style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px; padding:0 3px 10px 3px;">Cabernet Sauvgnon Reserva 2015</td>
                    <td valign="top" style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px; padding-bottom: 10px;" align="left"><a href="/teste" target="_blank" style="color:{{ $color }} !important;">Link do produto</a></td>
                </tr>

                <tr>
                    <td valign="top" style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px;padding-bottom: 10px;">12345</td>
                    <td valign="top" style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px; padding:0 3px 10px 3px;">Cabernet Sauvgnon Reserva 2015 lorem</td>
                    <td valign="top" style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px; padding-bottom: 10px;" align="left"><a href="/teste" target="_blank" style="color:{{ $color }} !important;">Link do produto</a></td>
                </tr>

            </table>


        </td>
    </tr>

@endsection
