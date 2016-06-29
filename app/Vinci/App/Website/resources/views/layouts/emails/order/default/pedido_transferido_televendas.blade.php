@extends('website::layouts.emails.order.default.layouts.template')

@section('body')

    @include('website::layouts.emails.order.default.layouts.partials.salutation')

    O atendimento do seu pedido de Nº. <span style="font-size: 13px; color: #14a68f !important;"><b>{{ $order->number }}</b></span> foi transferido para o setor de Televendas.<br /><br />
    Acreditamos assim, que nosso atendimento personalizado irá atendê-lo com mais rapidez e comodidade.<br /><br />
    Aguarde nosso contato, porém, caso tenha qualquer dúvida, fale conosco através do e-mail vendas@vinci.com.br ou ligue para (11) 3130-4646 (atendimento de segunda à sexta-feira das 9h às 18h e sábados das 9h às 13h - exceto feriados), tendo em mãos o número do seu pedido.<br /><br />

@endsection