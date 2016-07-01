@extends('website::layouts.emails.order.default.layouts.template')

@section('body')

    @include('website::layouts.emails.order.default.layouts.partials.salutation')

    Informamos que referente ao seu pedido nº. <span style="font-size: 13px; color: #11b6f0 !important;"><b>{{ $order->number }}</b></span> estamos com dificuldades em processar o faturamento.<br /><br />

    Lembramos que os problemas mais comuns são divergências na data de validade ou no código de segurança. Para outros casos, consulte sua operadora, antes de nos contatar.<br /><br />

    Para confirmar seus dados de pagamento, por favor, entre em contato conosco através deste e-mail <span style="font-size: 13px; color: #11b6f0 !important;">info@vinci.com.br</span> ou ligue para nosso atendimento no telefone (11) 3130-4646 (Atenção: atendimento de Internet somente de segunda a sexta-feira das 9h às 18h e sábados das 9h às 13h - exceto feriados).<br /><br />

    Importante lembrar que o prazo de entrega do seu respectivo pedido somente é contado a partir da confirmação de pagamento.<br /><br />

    Os comunicados referente aos pedidos realizados pela internet, são em primeira instância, sempre tratados através de mensagens de e-mail.<br /><br />

@endsection
