@extends('website::layouts.emails.templates.default')

@section('body')

    Prezado(a) Sr.(a) <b><span style="color: #11b6f0 !important;">{{ $user->getName() }}</span>,</b><br/><br/>

    <p> Conforme solicitado, segue o link para efetuar a troca de sua senha
        <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}" style="font-size:13px; color: #11b6f0 !important;">
            Clique aqui para alterar a sua senha
        </a>, este link expira em 24 horas.
    </p>

    <p>
        Para sua segurança, lembre-se que sua senha é pessoal, nunca revele a ninguém. Se você não
        solicitou sua senha, não se preocupe, pois, essa mensagem foi enviada somente para o seu
        e-mail, onde só você pode visualizar.
    </p>

    @include('website::layouts.emails.templates.partials.additional_message')

@endsection