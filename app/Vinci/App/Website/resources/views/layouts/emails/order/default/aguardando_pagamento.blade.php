@extends('website::layouts.emails.order.default.layouts.template')

<?php $color = '#8a25d8'; ?>
@section('header.title', 'Aguardando Depósito')
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
            Seu pedido número <span style="color: {{ $color }} !important;"><b>{{ $order->number }}</b></span>, no valor total de
            <br> <span style="color: {{ $color }} !important;"><b>{{ $order->total }}</b></span>
            foi recebido em nosso sistema de comércio eletrônico e está em processamento.
        </td>
    </tr>

    <tr>
        <td style="font-size: 15px;font-family:Arial, verdana, sans-serif; padding: 34px 0 20px 0">
            Seguem abaixo as instruções para depósito:
        </td>
    </tr>

    <tr>
        <td style="padding-top: 10px; font-family:Arial, verdana, sans-serif;">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="300" style="font-size: 15px">
                        Banco: <b></b>
                    </td>

                    <td width="200" style="font-size: 15px">
                        Itaú
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr><td height="12" style="line-height:12px;border-bottom:solid 1px #bbcad1">&nbsp;</td></tr>

    <tr>
        <td style="padding-top: 10px; font-family:Arial, verdana, sans-serif;">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="300" style="font-size: 15px">
                        Agência:
                    </td>

                    <td width="200" style="font-size: 15px">
                        2946
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr><td height="12" style="line-height:12px;border-bottom:solid 1px #bbcad1">&nbsp;</td></tr>

    <tr>
        <td style="padding-top: 10px; font-family:Arial, verdana, sans-serif;">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="300" style="font-size: 15px">
                        Conta Corrente
                    </td>

                    <td width="200" style="font-size: 15px">
                        09026-9
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td style="font-size: 15px;font-family:Arial, verdana, sans-serif; padding: 30px 0 0 0">
            MV Net Distribuidora de Bebidas Ltda
        </td>
    </tr>

    <tr><td height="12" style="line-height:12px;border-bottom:solid 1px #bbcad1">&nbsp;</td></tr>

    <tr>
        <td style="padding-top: 10px; font-family:Arial, verdana, sans-serif;">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="300" style="font-size: 15px">
                        CNPJ
                    </td>

                    <td width="200" style="font-size: 15px">
                        12.500.701/0001-79
                    </td>
                </tr>
            </table>
        </td>
    </tr>


    <tr>
        <td style="padding:40px 0 0 0; font-size: 15px; font-family:Arial, verdana, sans-serif;">
            <b style="color: {{ $color }};font-size: 18px">Valor total do depósito</b> <br> {{ $order->total }}<br><br><br>

            {{--<b>Previsão de entrega em até: </b>{{ $order->shipment->deadline }}<br><br>--}}


    <span style="font-size: 13px; color: {{ $color }} !important;"><b>IMPORTANTE:</b></span><br>
    Para que seu pedido seja validado, o depósito deve ser feito em até 3 (três) dias úteis e exatamente no mesmo valor acima.<br><br>

    Solicitamos, por gentileza, que nos encaminhe o comprovante de depósito pelo e-mail <font style="color: {{ $color }}">pedido@vinci.com.br</font>.<br><br>

    *Lembramos que a previsão de entrega é contada após identificação e confirmação do pagamento<br><br>

        </td>
    </tr>

    {{--Para acompanhar seu pedido, clique no link:<br>--}}
    {{--<a href="{{ route('account.orders.show', $order->number) }}" style="font-size:13px; color: #11b6f0 !important;" target="_blank"><b>{{ route('account.orders.show', $order->number) }}</b></a>--}}
    <tr>
        <td style="padding:10px 0 0 0; font-size: 15px; font-family:Arial, verdana, sans-serif;">
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