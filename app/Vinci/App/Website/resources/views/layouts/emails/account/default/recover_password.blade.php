@extends('website::layouts.emails.templates.default')

<?php $color = '#00bff2'; ?>
@section('header.title', 'Alteração de senha')
@section('header.bg.color', $color)
@section('footer.img.src', asset_web('images/emails/logo-footer-blue.jpg'))

@section('body')

    <tr>
        <td style="font-size:15px;font-family:Arial, verdana, sans-serif;">
            Prezado(a) Sr.(a) <b><span style="color: {{$color}} !important;">{{ $user->getName() }}</span>,</b><br/><br/>
        </td>
    </tr>

    <tr>
        <td style="font-size:15px;font-family:Arial, verdana, sans-serif; padding:10px 0 10px 0">
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
        </td>
    </tr>

    <tr>
        <td style="font-size:15px;font-family:Arial, verdana, sans-serif; padding:10px 0 10px 0">
            @include('website::layouts.emails.templates.partials.additional_message')
        </td>
    </tr>


@endsection