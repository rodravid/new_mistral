@extends('website::layouts.master')


@section('content')
<div class="header-internal template9-bg">
	@include('website::layouts.menu')
	<div class="row">

		<ul class="breadcrumb">
			<li class="breadcrumb-item">
				<a class="breadcrumb-link" href="/"><span>Início</span></a> >
			</li>

			<li class="breadcrumb-item">
				<span>Fale conosco</span>
			</li>
		</ul>

		<h1 class="internal-subtitle">Fale conosco</h1>

	</div>
</div>

<div class="row">

	<header class="mbottom10">
		<span class="title-internal-15">Sinta-se à vontade para nos enviar suas dúvidas, críticas ou sugestões.</span>
		<p>* Campos obrigatórios</p>
	</header>

	<!-- MENSAGEM DE ENVIADO COM SUCESSO -->
	<header class="mbottom20" style="display: none">
		<br>
		<span class="title-internal-mgs-send">Mensagem Enviada</span>
		<br>
		<p>Agradecemos o seu contato e retornaremos o mais breve possível.</p>
	</header>
	<!-- MENSAGEM DE ENVIADO COM SUCESSO -->

	<article class="wrap-content-register template9">
		{!! Form::open(['route' => 'contact.store', 'method' => 'POST']) !!}

		<div class="colum-620">
			<div class="">
				<div class="">
					<ul class="list-form-register">
						<li>
							<label for="name-complete" class="label-input">Nome *</label>
							{!! Form::text('name', null, ['id' => 'name-complete', 'class' => 'name-complete input-register half ' . ($errors->has('name') ? 'error-field' : '') , 'placeholder' => 'Nome completo *']) !!}
						</li>
						<li>
							<label for="email" class="label-input">E-mail *</label>
							{!! Form::input('email', 'email', null, ['id' => 'email', 'class' => 'email input-register half ' . ($errors->has('email') ? 'error-field' : '') , 'placeholder' => 'E-mail *']) !!}
						</li>
						<li>
							<label for="phone1" class="label-input">Telefone</label>
							{!! Form::input('tel', 'phone', null, ['id' => 'phone1', 'class' => 'cel input-register half', 'placeholder' => 'Telefone', 'cel-phone-mask' => '']) !!}
						</li>

						<li class="mbottom20">
							<label for="assunto" class="label-input">Assunto *</label>
							{!! Form::text('subject', null, ['id' => 'subject', 'class' => 'name-complete input-register half ' . ($errors->has('subject') ? 'error-field' : '') , 'placeholder' => 'Assunto *']) !!}
						</li>

						<li class="mbottom20">
							<label for="mensagem" class="label-input">Mensagem *</label>
							{!! Form::textarea('message', null, ['id' => 'message', 'class' => 'field-txt full ' . ($errors->has('message') ? 'error-field' : '') , 'placeholder' => 'Mensagem *']) !!}
						</li>
					</ul>
				</div>
			</div>



			<div class="wrap-content-bt">
				<div class="content-bt-big">
					<button type="submit" class="bt-default-full template10 bt-middle">Enviar <span class="arrow-link">></span></button>
				</div>
			</div>

		</div>

		<sidebar class="sidebar">
			<p>Caso sua pergunta não esteja relacionada abaixo envie sua mensagem para o email <span class="txt-contact">info@vinci.com.br</span></p>

			<p>Ou ligue para <span class="txt-contact">(11) 2797-0000</span>  (horário de atendimento telefônico para clientes de internet é de segunda a sexta-feira das 9h às 18h, exceto em feriados). 
			</p>

			<p>Se preferir compre pelo telefone
				<span class="txt-contact">(11) 3130-4500</span>
			</p>
			<p>Vinci Importadora e Exportadora de Bebidas Ltda.</p>

			<p><span>Endereço Administrativo</span>Rua Dr. Siqueira Cardoso, 227 - CEP 03163 020 - São Paulo - SP </p>

			<p><span>Endereço de Vendas</span>
				Rua Pamplona, 917 - CEP 01405-001 - Jardim Paulista - São Paulo - SP </p>
			</sidebar>


			{!! Form::close() !!}


		</article>

	</div>

	<div class="border-footer">

		@include('website::layouts.footer')

	</div>

	@stop