@extends('website::layouts.emails.order.default.layouts.template')

<?php $color = '#00bff2'; ?>
@section('header.title', 'Pedido não faturado')
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
            Estamos com dificuldades em processar o faturamento de seu pedido de número
            <span style="font-size: 15px; color: {{ $color }} !important;"><b>{{ $order->number }}</b></span> através do cartão de crédito informado.<br><br>

            Os problemas mais comuns são divergências na data de validade ou no código de segurança.<br><br>

            Se os dados do cartão estiverem corretos, é possível que a sua operadora tenha bloqueado a compra por medida de segurança.<br><br>

            Para todos os casos, pedimos a gentileza de entrar em contato com a operadora do seu cartão de crédito e solicitar a
            liberação da compra, uma vez que apenas o titular do cartão está autorizado a fazer isto. Caso seja mais conveniente para
            o(a) Sr(a), pode ser feita a troca do cartão de crédito ou mesmo um depósito em conta no banco Itaú.<br><br>

            Para confirmar seus dados de pagamento com segurança, solicitamos que entre em contato conosco através do
            telefone (11) 2797-0000 (o horário de atendimento telefônico para clientes da internet é de segunda a sexta-feira
            das 9h00 às 18h00, exceto feriados).<br><br>

            É importante lembrar que o prazo de entrega do seu respectivo pedido somente será contado a partir da confirmação de pagamento.<br><br>

            *Os comunicados referentes aos pedidos realizados são sempre tratados através de mensagens de e-mail em primeira instância.<br><br>
        </td>
    </tr>


@endsection
