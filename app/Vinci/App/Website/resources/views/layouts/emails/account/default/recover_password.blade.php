@extends('website::layouts.emails.templates.default')

@section('body')


		Prezado(a) Sr.(a) <b><span style="color: #11b6f0 !important;">{{ $customer->name }}</span>,</b><br/><br/>

		<p> De acordo, com sua solicitação <a href="" style="font-size:13px; color: #11b6f0 !important;">Clique aqui para alterar a sua senha</a>, este link expira em 24 horas. </p>

		<p>
		Para sua segurança, lembre-se que sua senha é pessoal, nunca revele a ninguém. Se você não
		solicitou sua senha, não se preocupe, pois, essa mensagem foi enviada somente para o seu
		e-mail, onde só você pode visualizar.
		</p>

		<p>
		Qualquer dúvida, entre em contato conosco através do e-mail <font color="#11b6f0">info@vinci.com.br</font>
		</p>



@endsection