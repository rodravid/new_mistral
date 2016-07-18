@extends('website::layouts.emails.order.default.layouts.template')

@section('body')

    @include('website::layouts.emails.order.default.layouts.partials.salutation')

    Seu pedido número <span style="font-size: 13px; color: #11b6f0 !important;"><b>{{ $order->number }}</b></span>, no valor total de <span style="font-size: 13px; color: #11b6f0 !important;"><b>{{ $order->total }}</b></span>
    foi recebido em nosso sistema de comércio eletrônico e está em processamento.<br><br>

    Seguem abaixo as instruções para depósito:<br><br>

    <b>MV Net Distribuidora de Bebidas Ltda</b><br>
    Banco: <b>Itaú</b><br>
    Agência: <b>2946</b><br>
    Conta Corrente: <b>09026-9</b><br>
    CNPJ: <b>12.500.701/0001-79</b><br><br>

    <b>Valor total do depósito: {{ $order->total }}</b><br><br>

    <b>Previsão de entrega em até: </b>{{ $order->shipment->deadline }}<br><br>

    <span style="font-size: 13px; color: #11b6f0 !important;"><b>IMPORTANTE:</b></span><br>
    Para que seu pedido seja validado, o depósito deve ser feito em até 3 (três) dias úteis e exatamente no mesmo valor acima.<br>
    Solicitamos, por gentileza, que nos encaminhe o comprovante de depósito pelo e-mail pedido@vinci.com.br.<br><br>

    *Lembramos que a previsão de entrega é contada após identificação e confirmação do pagamento<br><br>

    Para acompanhar seu pedido, clique no link:<br>
    <a href="{{ route('account.orders.show', $order->number) }}" style="font-size:13px; color: #11b6f0 !important;" target="_blank"><b>{{ route('account.orders.show', $order->number) }}</b></a>

    @include('website::layouts.emails.order.default.layouts.partials.additional_message')

@endsection