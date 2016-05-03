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
		<span class="title-internal-mgs-send">Mensagem Enviada</span>
		<br><br>
		<p>Agradecemos o seu contato e retornaremos o mais breve possível.</p>
	</header>
	<!-- MENSAGEM DE ENVIADO COM SUCESSO -->


	<article class="wrap-content-register">

		<form action="">
			


			<div class="col-register1 template9">

				<div class="user-data">

					<ul class="list-form-register">
						<li>
							<label for="name-complete" class="label-input">Nome *</label>
							<input class="name-complete input-register full" type="text" placeholder="Nome completo *" id="name-complete">
						</li>
						<li>
							<label for="email" class="label-input">E-mail *</label>
							<input class="email input-register full" type="email" placeholder="E-mail *" id="email">
						</li>

						<li>
							<label for="phone1" class="label-input">Telefone</label>
							<input class="cel input-register full" type="tel" placeholder="Telefone" phone-mask id="phone1">
						</li>
					</ul>

				</div>

			</div>

			<div class="col-larger-form template9">
				<ul class="list-form-register">
					<li>
						<label for="assunto" class="label-input">Assunto *</label>
						<input class="name-complete input-register half" type="text" placeholder="Assunto" id="assunto">
					</li>

					<li>
						<label for="mensagem" class="label-input">Mensagem *</label>
						<textarea class="field-txt full" name="" placeholder="Mensagem *" id="mensagem"></textarea>
					</li>
				</ul>
			</div>

		</form>


		<div class="wrap-content-bt">
			<div class="content-bt-big">
				<a class="bt-default-full template10 bt-middle" href="#">Enviar <span class="arrow-link">></span></a>
			</div>
		</div>
	</form>


</article>

</div>

<div class="border-footer">

	@include('website::layouts.footer')

</div>

@stop