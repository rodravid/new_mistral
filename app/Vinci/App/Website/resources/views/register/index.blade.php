@extends('website::layouts.master')


@section('content')
<div class="header-internal template1-bg">
	@include('website::layouts.menu')
	<div class="row">

		<h1 class="internal-subtitle">Cadastro</h1>

		<ul class="breadcrumb">
			<li class="breadcrumb-item">
				<a class="breadcrumb-link" href="/"><span>Início</span></a> >
			</li>

			<li class="breadcrumb-item">
				<span>Cadastro</span>
			</li>
		</ul>

	</div>
</div>

<div class="row">

	<header class="header-content-internal">

		<div class="container-total-products">
			<span class="title-internal-15">Para criar a sua senha basta preencher os dados abaixo</span>
			<p>* Campos obrigatórios</p>
		</div>

	</header>

	<article class="wrap-content-register">

		<form action="">
			<div class="col-register1">

				<div class="user-data">
					<h2 class="title-form">Dados de acesso *</h2>
					<ul class="list-form-register">
						<li>
							<input class="email input-register full" type="text" placeholder="E-mail *">
						</li>
						<li>
							<input class="senha input-register half" type="password" placeholder="Senha *">
						</li>
						<li>
							<input class="senha input-register half" type="password" placeholder="Confirmar senha *">
						</li>
					</ul>
					<h2 class="title-form">Dados Pessoais *</h2>
					<ul class="list-form-register">
						<li>
							<input class="name-complete input-register full" type="text" placeholder="Nome completo *">
						</li>
						<li>
							<input class="cpf input-register full" type="text" placeholder="CPF *">
						</li>
						<li>
							<input class="rg input-register full" type="text" placeholder="RG">
						</li>
						<li>
							<input class="orgao-emissor input-register half" type="text" placeholder="Orgão Emissor *">
						</li>
						<li>
							<div class="select-standard form-control-white">
								<select class="" name="" id="">
									<option value="">Sexo *</option>
									<option value="">Masculino</option>
									<option value="">Feminino</option>
								</select>
							</div>
						</li>
						<li>
							<input class="birth-date input-register seventy" type="text" placeholder="Data de Nascimento *">
						</li>
					</ul>
				</div>

			</div>

			<div class="col-register2">

				<div class="user-data">
					<h2 class="title-form">Endereço de Entrega *</h2>
					<ul class="list-form-register">
						<li>
							<input class="email input-register full" type="text" placeholder="Identificador do local *">
						</li>
						<li>
							<input class="cep input-register half" type="text" placeholder="CEP">
							<div class="search-cep">
								<p>Não sei o meu CEP.</p>
								<a href="http://m.correios.com.br/movel/buscaCep.do" target="_blank">Faça a pesquisa aqui ></a>
							</div>
						</li>
						<li>
							<div class="select-standard half form-control-white">
								<select class="" name="" id="">
									<option value="">Rua</option>
									<option value="">Avenida</option>
								</select>
							</div>
						</li>
						<li>
							<input class="input-register full" type="text" placeholder="Endereço">
						</li>
						<li>
							<input class="number input-register two-fields" type="text" placeholder="n°">
							<input class="number input-register two-fields" type="text" placeholder="Complemento">
						</li>
						<li>
							<div class="select-standard half form-control-white">
								<select class="" name="" id="">
									<option value="">Estado</option>
									<option value="AL">AC</option>
									<option value="AL">AL</option>
									<option value="AM">AM</option>
									<option value="AP">AP</option>
									<option value="BA">BA</option>
									<option value="CE">CE</option>
									<option value="DF">DF</option>
									<option value="ES">ES</option>
									<option value="GO">GO</option>
									<option value="MA">MA</option>
									<option value="MG">MG</option>
									<option value="MS">MS</option>
									<option value="MT">MT</option>
									<option value="PA">PA</option>
									<option value="PB">PB</option>
									<option value="PE">PE</option>
									<option value="PI">PI</option>
									<option value="PR">PR</option>
									<option value="RJ">RJ</option>
									<option value="RN">RN</option>
									<option value="RO">RO</option>
									<option value="RR">RR</option>
									<option value="RS">RS</option>
									<option value="SC">SC</option>
									<option value="SE">SE</option>
									<option value="SP">SP</option>
									<option value="TO">TO</option>
								</select>
							</div>
						</li>

						<li>
							<input class="input-register full" type="text" placeholder="Bairro">
						</li>

						<li>
							<div class="select-standard full form-control-white">
								<select class="" name="" id="">
									<option value="">Cidade</option>

								</select>
							</div>
						</li>

						<li>
							<div class="select-standard full form-control-white">
								<select class="" name="" id="">
									<option value="">País</option>
									<option value="SC">Brasil</option>

								</select>
							</div>
						</li>

						<li>
							<input class="input-register full" type="text" placeholder="Referência para entrega">
						</li>
					</ul>

				</div>

			</div>

			<div class="col-register3">

				<div class="user-data">
					<h2 class="title-form">Contatos</h2>
					<ul class="list-form-register">
						<li>
							<input class="cel input-register full" type="text" placeholder="Telefone celular">
						</li>
							<li>
							<input class="phone2 input-register full" type="text" placeholder="Telefone comercial">
						</li>
						<li>
							<input class="cel input-register full" type="text" placeholder="Telefone de contato *">
						</li>

					
					</ul>

				</div>

			</div>

			<div class="wrap-content-bt">
				<div class="content-bt-big">
					<a class="bt-default-full bt-color" href="#">Criar conta <span class="arrow-link">></span></a>
				</div>
			</div>
		</form>


	</article>

</div>

@include('website::layouts.footer')



@stop