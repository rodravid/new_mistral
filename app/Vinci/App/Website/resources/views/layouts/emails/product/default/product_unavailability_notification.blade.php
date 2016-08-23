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

            <table>
                <tr>
                    <th>#Código</th>
                    <th>Título</th>
                    <th>URL</th>
                    <th>Visível na home</th>
                </tr>
                <tr>
                    <td>12345</td>
                    <td>Cabernet Sauvgnon Reserva 2015</td>
                    <td><a href="/teste">Link do produto</a></td>
                    <td>Sim</td>
                </tr>
                <tr>
                    <td>12345</td>
                    <td>Cabernet Sauvgnon Reserva 2015</td>
                    <td><a href="/teste">Link do produto</a></td>
                    <td>Sim</td>
                </tr>
                <tr>
                    <td>12345</td>
                    <td>Cabernet Sauvgnon Reserva 2015</td>
                    <td><a href="/teste">Link do produto</a></td>
                    <td>Sim</td>
                </tr>
                <tr>
                    <td>12345</td>
                    <td>Cabernet Sauvgnon Reserva 2015</td>
                    <td><a href="/teste">Link do produto</a></td>
                    <td>Não</td>
                </tr>
            </table>


        </td>
    </tr>

@endsection
