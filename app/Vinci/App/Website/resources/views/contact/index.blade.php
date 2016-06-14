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

	<article class="wrap-content-register">
		{!! Form::open(['route' => 'contact.store', 'method' => 'POST']) !!}
			<div class="col-register1 template9">
				<div class="user-data">
					<ul class="list-form-register">
						<li>
							<label for="name-complete" class="label-input">Nome *</label>
                            {!! Form::text('name', null, ['id' => 'name-complete', 'class' => 'name-complete input-register full ' . ($errors->has('name') ? 'error-field' : '') , 'placeholder' => 'Nome completo *']) !!}
						</li>
						<li>
							<label for="email" class="label-input">E-mail *</label>
                            {!! Form::input('email', 'email', null, ['id' => 'email', 'class' => 'email input-register full ' . ($errors->has('email') ? 'error-field' : '') , 'placeholder' => 'E-mail *']) !!}
						</li>
						<li>
							<label for="phone1" class="label-input">Telefone</label>
                            {!! Form::input('tel', 'phone', null, ['id' => 'phone1', 'class' => 'cel input-register full', 'placeholder' => 'Telefone', 'phone-mask' => '']) !!}
						</li>
					</ul>
				</div>
			</div>

			<div class="col-larger-form template9">
				<ul class="list-form-register">
					<li>
						<label for="assunto" class="label-input">Assunto *</label>
                        {!! Form::text('subject', null, ['id' => 'subject', 'class' => 'name-complete input-register half ' . ($errors->has('subject') ? 'error-field' : '') , 'placeholder' => 'Assunto *']) !!}
					</li>

					<li>
						<label for="mensagem" class="label-input">Mensagem *</label>
                        {!! Form::textarea('message', null, ['id' => 'message', 'class' => 'field-txt full ' . ($errors->has('message') ? 'error-field' : '') , 'placeholder' => 'Mensagem *']) !!}
					</li>
				</ul>
			</div>

			<div class="wrap-content-bt">
				<div class="content-bt-big">
                    <button type="submit" class="bt-default-full template10 bt-middle">Enviar <span class="arrow-link">></span></button>
				</div>
			</div>
        {!! Form::close() !!}


	</article>

</div>

<div class="border-footer">

	@include('website::layouts.footer')

</div>

@stop