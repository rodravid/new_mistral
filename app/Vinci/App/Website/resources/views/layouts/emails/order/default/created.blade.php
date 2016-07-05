@extends('website::layouts.emails.order.default.layouts.template')

@section('body')

    Prezado(a) Sr.(a) <b>{{ $order->customer->name }}</b><br/><br/>

    Obrigado por preferir a Vinci.<br/><br/>

    Sua solicitação de pedido N° <span style="font-size: 13px; color: #000 !important;"><b>{{ $order->number }}</b></span>, no valor total de
    <b>{{ $order->total }}</b> foi recebido em nosso sistema de comércio eletrônico e está em processamento.<br/><br/>

    <font style="font-size:15px; color: #14a68f !important;">Produtos Solicitados:</font><br/><br/>

    <table width="100%" border="0"  cellpadding="3" cellspacing="3">
        <tr bgcolor="#f2f2f2" height="30" style="border-bottom: 1px solid #eaeaea !important;">
            <td bgcolor="#f2f2f2"><b>Produto</b></td>
            <td bgcolor="#f2f2f2" align="center"><b>Quantidade</b></td>
            <td bgcolor="#f2f2f2" width="100"><b>Preço Unitário</b></td>
        </tr>

        @foreach($order->items as $item)

            <tr height="35" style="border-bottom: 1px solid #eaeaea !important;">
                <td>{{ $item->product->title }}</td>
                <td align="center">{{ $item->quantity_units }}</td>
                <td>{{ $item->price }}</td>
            </tr>

        @endforeach
    </table>

    <br/><font style="font-size:15px; color: #14a68f !important;">Detalhes do Pedido:</font><br/><br/>

    Pedido Número: {{ $order->number }}<br/>
    Data: {{ $order->creation_date }}<br/>
    Valor do(s) Produto(s): {{ $order->items_total }}<br/>
    Valor do Frete: {{ $order->shipment->amount }}<br/>
    Valor Total do Pedido: {{ $order->total }}<br/><br/>

    <font style="font-size:15px; color: #14a68f !important;">Forma de Pagamento:</font><br/><br/>

    @if($order->payment->wasMadeWithCreditCard())

        <b>Cartão de Crédito {{ $order->payment->method->code }} </b> - {{ $order->payment->installment_text }}

    @else

        {{ $order->payment->method->code }}

    @endif

    <br/><br/>

    <font style="font-size:15px; color: #14a68f !important;">Dados de entrega:</font><br/><br/>

    {{ $order->customer->name }}<br/>
    Endereço: {{ $order->shipping_address->full_address }}<br/>
    Bairro: {{ $order->shipping_address->district }}<br/>
    Cidade: {{ $order->shipping_address->city_name }}<br />
    Estado: {{ $order->shipping_address->state_name }}<br/>
    CEP: {{ $order->shipping_address->postal_code }}<br/>

    @if (! empty($order->shipping_address->complement))
        Complemento: {{ $order->shipping_address->complement }}<br/>
    @endif

    <br/><br/>

    <table width="100%" border="0" bgcolor="#f2f2f2" cellpadding="1" cellspacing="1">
        <tr>
            <td  style="padding: 10px;">
                <b>Previsão de entrega em até: {{ $order->shipment->deadline }}.</b><br/><br/>

                (ATENÇÃO: Solicitação de Pedido de Compra - sujeito à confirmação pela Vinci,
                conforme termos abaixo).<br/><br/>

                TERMOS DO PRAZO: A previsão de entrega é válida após as seguintes condições:<br/><br/>

                - Disponibilidade de produtos em estoque: As quantidades e os produtos estarão
                sujeitos à confirmação.<br/>
                - A liberação do pedido efetuado, estará sujeita à confirmação de pagamento. (Cartão
                de Crédito na 1a. tentativa e Depósito à vista).<br/>
                - No caso de indisponibilidade de um ou mais itens do seu pedido, despacharemos
                somente os produtos disponíveis e seu pedido será concluído. Sendo neste caso,
                cobrado apenas os valores proporcionais do pedido atendido.<br/><br/>

                AVISOS IMPORTANTES: Os produtos vendidos através do site destinam-se somente ao
                consumidor final. No caso de revendas, favor consultar nosso departamento de vendas
                para restaurantes, lojas e hotéis por e-mail: vendas@vinci.com.br ou através do
                representante local.<br/><br/>

                De acordo com a Medida Provisória número 690/15, convertida em Lei número 13.241 (30/12/2015),
                desde 01/12/2015 <b>todos os vinhos e destilados vendidos no território brasileiro estão sujeitos
                    à cobrança de IPI</b>. As seguintes alíquotas serão <b>adicionadas aos preços do catálogo impresso</b>,
                do site e das nossas newsletters anunciadas: <b>10% sobre os vinhos de mesa</b>
                (tintos, brancos e espumantes), <b>20% sobre os vinhos do Porto, Madeira e Jerez</b>, e <b>30% sobre
                    os destilados</b> (Cognac, Armagnac, Grappa). Os <b>preços de venda em reais</b> referenciados em
                nosso site <b>já incluem o valor do IPI</b>.
                <br><br>

                - Qualquer pedido de compra cuja quantidade possa ser caracterizada como revenda ou
                por outro motivo de retenção pelo SEFAZ do Seu Estado fica sujeito ao recolhimento
                de ICMS no posto fiscal da fronteira do Estado de destino, e estes valores e
                eventuais despesas são de total responsabilidade do cliente.<br/>
                - Atenção compradores do Estado do AMAZONAS: o pedido de compra está sujeito à
                fiscalização da Sefaz/AM e Taxa de Armazenagem. Eventuais despesas acrescidas são
                integralmente por conta do cliente.<br/><br/>

                (*) Essa política publicada aqui está sujeita alterações sem prévio aviso.<br/>
                Data da Publicação desta Política: 19/12/2015.<br/><br/>

                Para acompanhar seu pedido, clique no link:<br/>
                <a href="{{ route('account.orders.show', $order->number) }}" style="font-size:13px; color: #14a68f !important;"><b>{{ route('account.orders.show', $order->number) }}</b></a>

            </td>
        </tr>
    </table>

@endsection