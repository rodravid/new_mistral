@extends('website::layouts.emails.order.default.layouts.template')

<?php $color = '#fd571d'; ?>
@section('header.title', 'Pedido recebido')
@section('header.bg.color', $color)
@section('footer.img.src', asset_web('images/emails/logo-footer-orange.jpg'))

@section('body')

    @include('website::layouts.emails.order.default.layouts.partials.salutation')

    <tr>
        <td style="font-size: 18px;font-family:Arial, verdana, sans-serif;color: {{ $color }}  !important; padding-bottom:25px;">
            <b>Agradecemos por sua compra na Vinci.</b>
        </td>
    </tr>

    <tr>
        <td style="border: solid 1px #bbcad1; padding: 20px; font-size: 18px;font-family:Arial, verdana, sans-serif;">
            Seu pedido de número <span style="color: {{ $color }} !important;"><b>{{ $order->number }}</b></span>, no valor total de
            <b style="color: {{ $color }} !important;">{{ $order->total }}</b> foi recebido em nosso sistema de comércio eletrônico e está em processamento.
        </td>
    </tr>

    <tr>
        <td style="font-size: 20px;font-family:Arial, verdana, sans-serif;color: {{ $color }}  !important; padding:40px 0 0px 0;">
            <b>Detalhes do pedido</b>
        </td>
    </tr>


    <tr>
        <td style="padding-top: 10px">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="190" style="font-size: 15px">
                        Pedido Número
                    </td>

                    <td width="300" style="font-size: 15px">
                        {{ $order->number }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>


    <tr><td height="12" style="line-height:12px;border-bottom:solid 1px #bbcad1">&nbsp;</td></tr>

    <tr>
        <td style="padding-top: 10px">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="190" style="font-size: 15px">
                        Data
                    </td>

                    <td width="300" style="font-size: 15px">
                        {{ $order->creation_date }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr><td height="12" style="line-height:12px;border-bottom:solid 1px #bbcad1">&nbsp;</td></tr>

    <tr>
        <td style="padding-top: 10px">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="190" style="font-size: 15px">
                        Valor do(s) Produto(s)
                    </td>

                    <td width="300" style="font-size: 15px">
                        {{ $order->items_total }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>


    <tr><td height="12" style="line-height:12px;border-bottom:solid 1px #bbcad1">&nbsp;</td></tr>

    <tr>
        <td style="padding-top: 10px">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="190" style="font-size: 15px">
                        Valor do Frete
                    </td>

                    <td width="300" style="font-size: 15px">
                        {{ $order->shipment->amount }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr><td height="12" style="line-height:12px;border-bottom:solid 1px #bbcad1">&nbsp;</td></tr>

    <tr>
        <td style="padding-top: 10px">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="190" style="font-size: 15px">
                        Valor Total do Pedido
                    </td>

                    <td width="300" style="font-size: 15px">
                        {{ $order->total }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{--Sua solicitação de pedido N° <span--}}
            {{--style="font-size: 13px; color: #000 !important;"><b>{{ $order->number }}</b></span>, no valor total de--}}
    {{--<b>{{ $order->total }}</b> foi recebido em nosso sistema de comércio eletrônico e está em processamento.<br/><br/>--}}

    {{--<br/><font style="font-size:15px; color: #11b6f0 !important;">Detalhes do Pedido:</font><br/><br/>--}}

    {{--Pedido Número: {{ $order->number }}<br/>--}}
    {{--Data: {{ $order->creation_date }}<br/>--}}
    {{--Valor do(s) Produto(s): {{ $order->items_total }}<br/>--}}
    {{--Valor do Frete: {{ $order->shipment->amount }}<br/>--}}
    {{--Valor Total do Pedido: {{ $order->total }}<br/><br/>--}}

    {{--<font style="font-size:15px; color: #11b6f0 !important;">Produtos Solicitados:</font><br/><br/>--}}

    {{--<table width="100%" border="0" cellpadding="3" cellspacing="3">--}}
        {{--<tr bgcolor="#f2f2f2" height="30" style="border-bottom: 1px solid #eaeaea !important;">--}}
            {{--<td bgcolor="#f2f2f2"><b>Produto</b></td>--}}
            {{--<td bgcolor="#f2f2f2" align="center"><b>Quantidade</b></td>--}}
            {{--<td bgcolor="#f2f2f2" width="100"><b>Valor Unitário</b></td>--}}
        {{--</tr>--}}

        {{--@foreach($order->items as $item)--}}

            {{--<tr height="35" style="border-bottom: 1px solid #eaeaea !important;">--}}
                {{--<td>{{ $item->product->title }}</td>--}}
                {{--<td align="center">{{ $item->quantity_units }}</td>--}}
                {{--<td>{{ $item->price }}</td>--}}
            {{--</tr>--}}

        {{--@endforeach--}}
    {{--</table>--}}

    <tr>
        <td style="font-size: 20px;font-family:Arial, verdana, sans-serif;color: {{ $color }}  !important; padding:40px 0 0px 0;">
            <b>Produtos Solicitados</b>
        </td>
    </tr>

    @foreach($order->items as $item)
        <tr>
            <td style="border-bottom:1px solid #bbcad1; padding: 15px 0;">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td width="240" style="font-size:18px;font-family:Arial, verdana, sans-serif; text-transform: uppercase" align="left">
                            {{ $item->product->title }} #{{ $item->product->sku }}
                        </td>
                        {{--<font style="font-size: 15px;">kaiken</font>--}}
                        <td width="150" style="font-size:15px;font-family:Arial, verdana, sans-serif;" align="center">
                            {{ $item->quantity_units }}
                        </td>
                        <td width="10" style="font-size:11px;font-family:Arial, verdana, sans-serif;" align="center">
                            X
                        </td>
                        <td width="120" align="right" style="font-size:18px;font-family:Arial, verdana, sans-serif;">
                            <b>{{ $item->price }}</b>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    @endforeach

    {{--<font style="font-size:15px; color: #11b6f0 !important;">Forma de Pagamento:</font><br/><br/>--}}

    {{--@if($order->payment->wasMadeWithCreditCard())--}}

        {{--<b>Cartão de Crédito {{ $order->payment->method->code }} </b> - {{ $order->payment->installment_text }}--}}

    {{--@else--}}

        {{--{{ $order->payment->method->code }}--}}

    {{--@endif--}}

    {{--<br/><br/>--}}

    {{--<font style="font-size:15px; color: #11b6f0 !important;">Dados de entrega:</font><br/><br/>--}}

    {{--{{ $order->customer->name }}<br/>--}}
    {{--Endereço: {{ $order->shipping_address->full_address }}<br/>--}}
    {{--Bairro: {{ $order->shipping_address->district }}<br/>--}}
    {{--Cidade: {{ $order->shipping_address->city_name }}<br/>--}}
    {{--Estado: {{ $order->shipping_address->state_name }}<br/>--}}
    {{--CEP: {{ $order->shipping_address->postal_code }}<br/>--}}

    {{--@if (! empty($order->shipping_address->complement))--}}
        {{--Complemento: {{ $order->shipping_address->complement }}<br/>--}}
    {{--@endif--}}

    {{--<br/><br/>--}}


    <tr>
        <td style="font-size: 20px;font-family:Arial, verdana, sans-serif;color: {{ $color }}  !important; padding:40px 0 20px 0;">
            <b>Forma de pagamento</b>
        </td>
    </tr>

    <tr>
        <td style="border: solid 1px #bbcad1; padding: 20px; font-size: 18px;font-family:Arial, verdana, sans-serif;">

            @if($order->payment->wasMadeWithCreditCard())
                <img src="" alt=""> <br>
                <b>Cartão de Crédito {{ $order->payment->method->code }} </b> - {{ $order->payment->installment_text }}

            @else

                {{ $order->payment->method->code }}

            @endif
        </td>
    </tr>

    <tr>
        <td style="font-size: 20px;font-family:Arial, verdana, sans-serif;color: {{ $color }}  !important; padding:40px 0 20px 0;">
            <b>Endereço de entrega</b>
        </td>
    </tr>

    <tr>
        <td style="border: solid 1px #bbcad1; padding: 20px; font-size: 15px;font-family:Arial, verdana, sans-serif;">


            {{ $order->shipping_address->full_address }} ,
            {{ $order->shipping_address->district }}<br/>
            {{ $order->shipping_address->city_name }} -
            {{ $order->shipping_address->state_name }}<br/>
            {{ $order->shipping_address->postal_code }}<br/>

            @if (! empty($order->shipping_address->complement))
                Complemento: {{ $order->shipping_address->complement }}<br/>
            @endif
            <br>

            <b>Previsão de entrega em até</b> <br>
            {{ $order->shipment->deadline }}


            <br><br>
            <b>Acompanhe seu pedido clicando no link abaixo</b><br/>
            <a href="{{ route('account.orders.show', $order->number) }}" style="font-size:13px; color: {{ $color }} !important;"><b>{{ route('account.orders.show', $order->number) }}</b></a>
        </td>
    </tr>


    <tr>
        <td style="padding: 20px 0; font-size: 15px;font-family:Arial, verdana, sans-serif;">
            {{--<b>Previsão de entrega em até: {{ $order->shipment->deadline }}.</b><br/><br/>--}}

            <font style="color: {{ $color }} !important">* Atenção <br></font>
            Esta solicitação de compra está sujeita a alterações, conforme termos abaixo: <br> <br>

            - A disponibilidade de produtos em estoque bem como o prazo de entrega estão sujeitos à confirmação.
            <br>
            - No caso de indisponibilidade de um ou mais itens do seu pedido, despacharemos somente os produtos disponíveis e seu pedido será concluído. Sendo, neste caso, cobrados apenas os valores proporcionais ao pedido atendido.
            <br>
            - A liberação do pedido será realizada após confirmação de pagamento (cartão de crédito na 1ª. tentativa e depósito à vista).
            <br><br>

            <font style="color: {{ $color }} !important">Avisos importantes</font> <br>
            -  Os produtos vendidos através do site destinam-se somente a consumidor final. No caso de revenda, por favor consultar nosso departamento de vendas para restaurantes, lojas e hotéis pelo e-mail <font style="color: {{ $color }} !important">info@vinci.com.br</font>
            <br>
            - Qualquer compra cuja quantidade possa ser caracterizada como revenda ou por outro motivo de retenção pelo SEFAZ do seu Estado, ficará sujeita ao recolhimento de ICMS no posto fiscal da fronteira do Estado de destino. Estes valores e eventuais despesas são de total responsabilidade do cliente.
            <br>
            - Atenção compradores do Estado do AMAZONAS: o pedido de compra está sujeito à fiscalização da SEFAZ/AM e Taxa de Armazenagem. Eventuais despesas acrescidas são integralmente por conta do cliente.
            <br><br>
            De acordo com a Medida Provisória número 690/15, convertida em Lei número 13.241 (30/12/2015), desde 01/12/2015 todos os vinhos e destilados vendidos no território brasileiro estão sujeitos à cobrança de IPI. As seguintes alíquotas serão adicionadas aos preços do catálogo impresso, do site e das nossas newsletters anunciadas: 10% sobre os vinhos de mesa (tintos, brancos e espumantes), 20% sobre os vinhos do Porto, Madeira e Jerez, e 30% sobre os destilados (Cognac, Armagnac, Grappa).
            <br>
            Os preços de venda em reais referenciados em nosso site já incluem o valor do IPI.

        </td>
    </tr>

    <tr>
        <td style="font-family:Arial, verdana, sans-serif; font-size: 15px; padding-bottom: 20px;">
            Atenciosamente, <br>
            Equipe de Comércio Eletrônico
        </td>
    </tr>

    {{--<table width="100%" border="0" bgcolor="#f2f2f2" cellpadding="1" cellspacing="1">--}}
        {{--<tr>--}}
            {{--<td style="padding: 10px;">--}}
                {{--<b>Previsão de entrega em até: {{ $order->shipment->deadline }}.</b><br/><br/>--}}

                {{--<b>ATENÇÃO: Esta solicitação de compra está sujeita a alterações, conforme termos abaixo:</b><br/><br/>--}}

                {{--TERMOS DO PRAZO: A previsão de entrega é válida após as seguintes condições:<br/><br/>--}}

                {{--- A disponibilidade de produtos em estoque bem como o prazo de entrega estão sujeitos à--}}
                {{--confirmação.<br/>[--}}

                {{--- No caso de indisponibilidade de um ou mais itens do seu pedido, despacharemos--}}
                {{--somente os produtos disponíveis e seu pedido será concluído. Sendo neste caso,--}}
                {{--cobrado apenas os valores proporcionais do pedido atendido.<br/><br/>--}}

                {{--- A liberação do pedido efetuado, estará sujeita à confirmação de pagamento. (Cartão--}}
                {{--de Crédito na 1a. tentativa e Depósito à vista).<br/>--}}

                {{--AVISOS IMPORTANTES: Os produtos vendidos através do site destinam-se somente ao--}}
                {{--consumidor final. No caso de revendas, favor consultar nosso departamento de vendas--}}
                {{--para restaurantes, lojas e hotéis por e-mail: vendas@vinci.com.br<br/><br/>--}}

                {{--- Qualquer compra cuja quantidade possa ser caracterizada como revenda ou--}}
                {{--por outro motivo de retenção pela SEFAZ do Seu Estado, ficará sujeito ao recolhimento--}}
                {{--de ICMS no posto fiscal da fronteira do Estado de destino. Estes valores e--}}
                {{--eventuais despesas são de total responsabilidade do cliente.<br/>--}}
                {{--- Atenção compradores do Estado do AMAZONAS: o pedido de compra está sujeito à--}}
                {{--fiscalização da SEFAZ/AM e Taxa de Armazenagem. Eventuais despesas acrescidas são--}}
                {{--integralmente por conta do cliente.<br/><br/>--}}

                {{--<b>De acordo com a Medida Provisória número 690/15, convertida em Lei número 13.241 (30/12/2015),</b>--}}
                {{--desde 01/12/2015 todos os vinhos e destilados vendidos no território brasileiro estão sujeitos à--}}
                {{--cobrança de IPI. As seguintes alíquotas serão adicionadas aos preços do catálogo impresso, do site e das--}}
                {{--nossas newsletters anunciadas: 10% sobre os vinhos de mesa (tintos, brancos e espumantes), 20% sobre os--}}
                {{--vinhos do Porto, Madeira e Jerez, e 30% sobre os destilados (Cognac, Armagnac, Grappa).<br>--}}
                {{--Os preços de venda em reais referenciados em nosso site já incluem o valor do IPI.--}}
                {{--<br><br>--}}

                {{--<b>Para acompanhar seu pedido, clique no link:</b><br/>--}}
                {{--<a href="{{ route('account.orders.show', $order->number) }}"--}}
                   {{--style="font-size:13px; color: #11b6f0 !important;"><b>{{ route('account.orders.show', $order->number) }}</b></a>--}}

            {{--</td>--}}
        {{--</tr>--}}
    {{--</table>--}}

@endsection