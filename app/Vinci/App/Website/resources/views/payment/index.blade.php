@extends('website::layouts.master')


@section('content')
<div class="header-internal header-checkout template1-bg">
	
	<div class="row">
		
		<div class="wrap-content-bt mbottom20 mtop20">
			<span class="logo">
				<a class="logo-vinci sprite-icon" href="/" title="Vinci - Loucos por vinho">Vinci - Loucos por vinho</a>
			</span>
		</div>

		<h1 class="internal-subtitle">Meu Carrinho</h1>

		<nav class="nav-status float-right">

			<ul class="list-status">

				<li class="show-desktop">
					<span>Entrega</span>
				</li>
				<li class="current-status">
					<span>Pagamento</span>
					<img class="cup-status" src="{{ asset_web('images/taca.png') }}" alt="">
				</li>
				<li class="show-desktop">
					<span>Confirmação</span>
				</li>

			</ul>

		</nav>

	</div>

</div>

<div class="row">

	<section class="wrap-payment">
		
		<p class="title-internal-blue mbottom20">Resumo do pedido</p>

		<article class="request section-payment">

			<div class="row-request template1">

				<div class="col-request">

					<div class="name-product-request">
						<h3 class="title-card-wine">
							Kaiken terroir series Corte 2012
							<span>Kaiken</span>
						</h3>
					</div>

					<div class="qtd-request">
						1 unidade
					</div>

					<div class="price-request">
						<span class="title-internal-15">R$ 72,26</span>
					</div>

				</div>

				<div class="bt-request">
					<a class="bt-arrow-action" href="javascript:void(0);"> > </a>
				</div>


			</div>

			<div class="row-request template1">

				<div class="col-request">

					<div class="name-product-request">
						<h3 class="title-card-wine">
							Kaiken terroir series Corte 2012
							<span>Kaiken</span>
						</h3>
					</div>

					<div class="qtd-request">
						1 unidade
					</div>

					<div class="price-request">
						<span class="title-internal-15">R$ 72,26</span>
					</div>

				</div>

				<div class="bt-request">
					<a class="bt-arrow-action" href="javascript:void(0);"> > </a>
				</div>

			</div>

			<div class="row-request">
				<div class="info-request float-left">
					Frete
				</div>
				<div class="price-final float-right">
					<span class="title-internal-15">R$ 10,26</span>
				</div>
			</div>

			<div class="row-request">
				<div class="info-request float-left">
					Total
				</div>
				<div class="price-final float-right">
					<span class="title-internal-15">R$ 2172,26</span>
				</div>
			</div>
			
		</article>

		<p class="title-internal-blue mbottom20">Endereço de Entrega</p>

		<article class="to-deliver section-payment template1">
			<div class="float-left">
				<span class="title-internal-15 uppercase">Casa</span>
				<p>Rua bahia, 1126, Higienópolis</p>
				<p>São Paulo - SP</p>
				<p>CEP 04412-300</p>
			</div>
			<div class="float-right">
				<a class="bt-arrow-action" href="javascript:void(0);"> > </a>
			</div>
		</article>

		<p class="title-internal-blue mbottom20">Forma de pagamento</p>

		<article class="form-payment section-payment template1">
			<form action="">
				<ul class="flags-card">
					<li class="flags-list">
						<div class="flags visa"></div>
						<input type="radio" name="flag-card" value="" class="visa">
					</li>
					<li class="flags-list">
						<div class="flags master"></div>
						<input type="radio" name="flag-card" value="" class="master">
					</li>
					<li class="flags-list">
						<div class="flags american"></div>
						<input type="radio" name="flag-card" value="" class="american">
					</li>
					<li class="flags-list">
						<div class="flags diners"></div>
						<input type="radio" name="flag-card" value="" class="diners">
					</li>
				</ul>
				<div class="col-register1">

					<div class="user-data">
						<h2 class="title-form">Parcelamento</h2>
						<ul class="list-form-register">
							<li>
								<div class="select-standard full form-control-white">
									<select class="" name="" id="">
										<option value="">1x de R$154,56</option>
										<option value="">2x de R$1254,56</option>
									</select>
								</div>
							</li>
							<li>
								<p>O limite disponível no cartão de crédito deve ser 
									superior ao valor total da compra, e não ao 
									valor de cada parcela.</p>
								</li>
							</ul>



						</div>

					</div>

					<div class="col-register2">

						<div class="user-data">
							<h2 class="title-form">Dados do cartão</h2>
							<ul class="list-form-register">
								<li>
									<input class="email input-register full" type="text" placeholder="CPF / CNPJ">
								</li>

<!-- 						<li>
							<input class="number input-register two-fields" type="text" placeholder="n°">
							<input class="number input-register two-fields" type="text" placeholder="Complemento">
						</li> -->

						<li>
							<input class="email input-register full" type="text" placeholder="Número do cartão">
						</li>


						<li>
							<input class="input-register full" type="text" placeholder="Nome impresso do cartão">
						</li>
					</ul>

				</div>

			</div>

			<div class="col-register3">

				<div class="card-validity">
					<ul class="list-form-register">
						<li>
							<label class="label-above">Data de validade</label>
							<div class="select-standard width120 form-control-white">
								<select class="" name="" id="">
									<option value="">Mês</option>
									<option value="">janeiro</option>
									<option value="">Fevereiro</option>
									<option value="">Março</option>
									<option value="">Abril</option>
									<option value="">Maio</option>
									<option value="">Junho</option>
									<option value="">Julho</option>
									<option value="">Agosto</option>
									<option value="">Setembro</option>
									<option value="">Outubro</option>
									<option value="">novembro</option>
									<option value="">Dezembro</option>
								</select>
							</div>
							<div class="select-standard width120 form-control-white">
								<select class="" name="" id="">
									<option value="">Ano</option>
									<option value="">2016</option>
									<option value="">2017</option>
									<option value="">2018</option>
									<option value="">2019</option>
									<option value="">2020</option>
									<option value="">2021</option>
									<option value="">2022</option>

								</select>
							</div>
						</li>
						<li>
							<label class="label-above">Código de segurança</label>
							<input class="number input-register width120" type="text">
							<img class="float-left img-cod-seg" src="{{ asset_web('images/img-cod-seg.jpg') }}" alt="">
						</li>

					</ul>

				</div>

			</div>


		</form>
	</article>


	<div class="wrap-content-bt remove-mbttom20">
		<div class="content-bt-big">
			<a class="bt-default-full bt-middle bt-color" href="#">Pagar <span class="arrow-link">&gt;</span></a>
		</div>
	</div>
</section>


</div>

@include('website::layouts.partials.checkoutfooter')


@stop