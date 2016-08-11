@extends('website::layouts.emails.order.default.layouts.template')

<?php $color = '#00bff2'; ?>
@section('header.title', 'Aguardando depósito')
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
            Agradecemos por sua compra na Vinci.
            <br><br>
            Seu pedido de número  <span style="font-size: 15px; color: {{ $color }} !important;"><b>{{ $order->number }}</b></span> , no valor total de  <span style="font-size: 15px; color: {{ $color }} !important;"><b>{{ $order->total }}</b></span>  , foi recebido em nosso sistema de comércio
            eletrônico e está em processamento.
            <br><br>
            Seguem abaixo as instruções para depósito:
            <br><br>
            Banco Itaú <br>
            Agência: 2946 <br>
            Conta Corrente: 05659-1 <br>
            Vinci Importadora de Bebidas Ltda <br>
            CNPJ: 08.227.314/0001-33
            <br><br>
            <strong>Valor total do depósito: {{ $order->total }}</strong>
            <br><br>
            IMPORTANTE: Para que seu pedido seja validado, o depósito deve ser feito em até 3 (três) dias
            úteis e exatamente no mesmo valor acima.
            <br><br>
            Solicitamos, por gentileza, que nos encaminhe o comprovante de depósito pelo e-mail
            pedido@vinci.com.br.
            <br><br>
            *Lembramos que a previsão de entrega é contada após identificação e confirmação do
            pagamento.
            <br><br>
            Em caso de dúvidas, entre em contato conosco pelo e-mail internet@vinci.com.br ou ligue para
            (11) 2797 0000 (o horário de atendimento telefônico para clientes de internet é de segunda a
            sexta-feira de 9h00 às 18h00, exceto feriados). <br><br>
            Atenciosamente, <br>
            Equipe de Comércio Eletrônico<br>
        </td>
    </tr>


@endsection
