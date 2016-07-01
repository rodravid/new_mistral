@extends('website::layouts.emails.order.default.layouts.template')

@section('body')

    @include('website::layouts.emails.order.default.layouts.partials.salutation')

    Seu pedido N°. <span style="font-size: 13px; color: #11b6f0 !important;"><b>{{ $order->number }}</b></span> *, no valor total de <span style="font-size: 13px; color: #11b6f0 !important;"><b>{{ $order->total }}</b></span> foi confirmado e está aguardando o pagamento através de depósito.<br /><br />

    <span style="font-size: 13px; color: #11b6f0 !important;"><b>IMPORTANTE:</b></span> O depósito deve ser EXATAMENTE NO MESMO VALOR DO PEDIDO e deve ser efetuado em até 2 dias e o comprovante de pagamento enviado para nosso fax (11) 3130-4620 ou por e-mail <span style="font-size: 13px; color: #11b6f0 !important;"><b>vendas@vinci.com.br</b></span> - indicando o respectivo número do seu pedido. Lembre-se de enviar o comprovante para seu pedido ser enviado.<br /><br />

    <span style="font-size: 13px; color: #11b6f0 !important;"><b>NOTA:</b></span> Após este prazo e não havendo o envio e confirmação do comprovante de pagamento, seu pedido será cancelado automaticamente pelo sistema.<br /><br />

    Seguem os dados abaixo:<br /><br />

    <b>MV Net Distribuidora de Bebidas Ltda</b><br />

    (Distribuidora da Mistral Importadora Ltda)<br /><br />

    Banco: <b>Itaú (341)</b><br />

    Agência: <b>2946</b><br />

    Conta Corrente: <b>09026-9</b><br />

    CNPJ: <b>12.500.701/0001-79</b><br />

    Valor Total: <b>{{ $order->total }}</b><br /><br />

    <b>Previsão de Entrega em Até:</b> {{ $order->shipment->deadline }}<br /><br />

    Esta previsão de entrega é contada após confirmação do pagamento.<br /><br />

    Para acompanhar seu pedido, clique no link:<br/>
    <a href="{{ route('account.orders.show', $order->number) }}" style="font-size:13px; color: #11b6f0 !important;"><b>{{ route('account.orders.show', $order->number) }}</b></a>

    @include('website::layouts.emails.order.default.layouts.partials.additional_message')

@endsection