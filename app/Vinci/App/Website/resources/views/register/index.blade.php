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
			<span class="title-internal-15">Para criar a sua conta basta preencher os dados abaixo</span>
			<p>* Campos obrigatórios</p>
		</div>

	</header>

	<article class="wrap-content-register">

		<form action="">
			
			<header class="header-content-internal">
				<ul class="list-type-buyer">
					<li>
						<label for="physical-person">Pessoa Física</label>
						<input type="radio" name="type-buyer" value="1" class="physical-person" id="physical-person" checked>
					</li>
					<li>
						<label for="legal-person">Pessoa Jurídica</label>
						<input type="radio" name="type-buyer" value="2" class="legal-person" id="legal-person">
					</li>
				</ul>
			</header>

			<div class="col-register1">

				<div class="user-data">
					<h2 class="title-form">Dados de acesso *</h2>
					<ul class="list-form-register">
						<li>
							<label for="email" class="label-input">E-mail</label>
							<input class="email input-register full" type="email" placeholder="E-mail *" id="email">
						</li>
						<li>
							<label for="password" class="label-input">Senha</label>
							<input class="senha input-register half" type="password" placeholder="Senha *" id="password">
						</li>
						<li>
							<label for="password2" class="label-input">Confirmar senha</label>
							<input class="senha input-register half" type="password" placeholder="Confirmar senha *" id="password2">
						</li>
					</ul>

					<div class="" id="person">
						<h2 class="title-form">Dados Pessoais *</h2>
						<ul class="list-form-register">
							<li>
								<label for="name-complete" class="label-input">Nome completo *</label>
								<input class="name-complete input-register full" type="text" placeholder="Nome completo *" id="name-complete">
							</li>
							<li>
								<label for="cpf" class="label-input">CPF *</label>
								<input class="cpf input-register full" type="text" placeholder="CPF *" cpf id="cpf">
							</li>
							<li>
								<label for="rg" class="label-input">RG</label>
								<input class="rg input-register full" type="text" placeholder="RG" id="rg">
							</li>
							<li>
								<label for="orgao-emissor" class="label-input">Orgão Emissor *</label>
								<input class="orgao-emissor input-register half" type="text" placeholder="Orgão Emissor *" id="orgao-emissor">
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
								<label for="birth-date" class="label-input">Data de Nascimento *</label>
								<input class="birth-date input-register seventy" type="text" placeholder="Data de Nascimento *" date id="birth-date">
							</li>
						</ul>
					</div>

					<div class="" id="company">
						<h2 class="title-form">Dados Empresa *</h2>
						<ul class="list-form-register">
							<li>
								<label for="name-company" class="label-input">Nome da empresa *</label>
								<input class="name-complete-company input-register full" type="text" placeholder="Nome da empresa *" id="name-company">
							</li>
							<li>
								<label for="responsavel" class="label-input">Responsável</label>
								<input class="input-register full" type="text" placeholder="Responsável" id="responsavel">
							</li>
							<li>
								<label for="cnpj" class="label-input">CNPJ *</label>
								<input class="cnpj input-register full" type="text" placeholder="CNPJ *" cnpj id="cnpj">
							</li>
							<li>
								<label for="ie" class="label-input">IE</label>
								<input class="ie input-register full" type="text" placeholder="IE" id="ie">
							</li>

						</ul>
					</div>
				</div>

			</div>

			<div class="col-register2">

				<div class="user-address">
					<h2 class="title-form">Endereço de Entrega *</h2>
					<ul class="list-form-register">
						<li>
							<label for="type-addres" class="label-input">Tipo de endereço *</label>
							<input class="type-addres input-register full" type="text" placeholder="Tipo de endereço *" id="type-addres">
						</li>
						<li>
							<label for="cep" class="label-input">CEP</label>
							<input class="cep input-register half" type="text" placeholder="CEP" cep id="cep">
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
							<label for="address" class="label-input">Endereço</label>
							<input class="input-register full" type="text" placeholder="Endereço" id="address">
						</li>
						<li>
							<label for="num" class="label-input">n°</label>
							<input class="number input-register two-fields" type="text" placeholder="n°" id="num">
							<label for="complement" class="label-input">Complemento</label>
							<input class="number input-register two-fields" type="text" placeholder="Complemento" id="complement">
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
							<label for="bairro" class="label-input">Bairro</label>
							<input class="input-register full" type="text" placeholder="Bairro" id="bairro">
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
							<label for="referencia" class="label-input">Referência para entrega</label>
							<input class="input-register full" type="text" placeholder="Referência para entrega" id="referencia">
						</li>
					</ul>

				</div>

			</div>

			<div class="col-register3">

				<div class="user-phones">
					<h2 class="title-form">Contatos</h2>
					<ul class="list-form-register">
						<li>
							<label for="phone1" class="label-input">Telefone celular</label>
							<input class="cel input-register full" type="tel" placeholder="Telefone celular" phone-mask id="phone1">
						</li>
						<li>
							<label for="phone2" class="label-input">Telefone comercial</label>
							<input class="phone2 input-register full" type="tel" placeholder="Telefone comercial" phone-mask id="phone2">
						</li>
						<li>
							<label for="phone3" class="label-input">Telefone de contato *</label>
							<input class="input-register full" type="tel" placeholder="Telefone de contato *" phone-mask id="phone3">
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