@extends('website::layouts.master')


@section('content')
<div class="header-internal template4-bg">
	@include('website::layouts.menu')
	<div class="row">

		<ul class="breadcrumb">
			<li class="breadcrumb-item">
				<a class="breadcrumb-link" href="/"><span>Início</span></a> >
			</li>

			<li class="breadcrumb-item">
				<a class="breadcrumb-link" href="javascript:void(0);"><span>Minha conta</span></a> >
			</li>
			<li class="breadcrumb-item">
				<a class="breadcrumb-link" href="/minha-conta-pedidos"><span>Meus pedidos</span> </a> >
			</li>
			<li class="breadcrumb-item">
				<span>123456789</span>
			</li>
		</ul>

		<h1 class="internal-subtitle">Minha conta</h1>

	</div>
</div>

<div class="wrap-menu-account-data">

	<div class="row">

		<div class="menu-account-mob">
			<p>Meus pedidos</p> <span class="seta-mobile-account">v</span>
		</div>	

		<ul class="menu-account-data">

			<li class="current-account-data">
				<a href="/minhaconta-pedidos">Meus pedidos</a>
			</li>

			<li>
				<a href="/minhaconta-cadastro">Dados da conta</a>
			</li>

			<li>
				<a href="/minhaconta-favoritos">Favoritos</a>
			</li>

			<li>
				<a href="/minhaconta-enderecos">Endereços</a>
			</li>

		</ul>

	</div>

</div>

<div class="row">

	<section class="wrap-payment template4">


			<div class="wrap-content-bt mbottom20 show-mobile">
			<div class="content-bt-small ">
				<a class="bt-default-full template11 bt-middle" href="#">Voltar <span class="arrow-link">></span></a>
			</div>
		</div>

		<div class="wrap-content-bt mbottom10">
			<p class="title-info-req">Número do pedido</p>
					<span class="num-request-cod">12345678</span>
			<div class="content-bt-small hide-mobile">
				<a class="bt-default-full bt-middle template11" href="#">Voltar <span class="arrow-link">></span></a>
			</div>
		</div>	

		<article class="order section-payment">
			<div class="content-order float-left">
				<p class="txt-order">Data do pedido</p>
				<span class="title-txt-req">25/jan/2016</span>
			</div>
			<div class="status-order float-right">
				<p class="txt-order">Status</p>
				<p class="title-internal-15">Entregue 02/fev</p>
			</div>
		</article>

		<div class="wrap-content-bt mbottom10 show-desktop hide-tablet">
			<div class="content-bt-middle">
				<a class="bt-default-full template11 bt-middle" href="#">Imprimir pedido <span class="arrow-link">></span></a>
			</div>
		</div>
		
		<p class="title-internal mbottom20">Resumo do pedido</p>

		<article class="request section-confirmation">

			<div class="row-request">

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




			</div>

			<div class="row-request">

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

			</div>

			<div class="row-request">
				<div class="info-request float-left">
					<span class="title-internal-15">	Frete</span>
				</div>
				<div class="price-final float-right">
					<span class="title-internal-15">R$ 10,26</span>
				</div>
			</div>

			<div class="row-request">
				<div class="info-request float-left">
					<span class="title-internal-15">	Total</span>
				</div>
				<div class="price-final float-right">
					<span class="title-internal-15">R$ 2172,26</span>
				</div>
			</div>
			
		</article>

		<div class="wrap-content-bt mbottom10">
			<div class="content-bt-middle ">
				<a class="bt-default-full template11 bt-middle" href="#">Repetir pedido <span class="arrow-link">></span></a>
			</div>
		</div>

		<p class="title-internal mbottom20">Endereço de Entrega</p>

		<article class="to-deliver section-payment">
			<div class="float-left">
				<span class="title-internal-15 uppercase">Casa</span>
				<p>Rua bahia, 1126, Higienópolis</p>
				<p>São Paulo - SP</p>
				<p>CEP 04412-300</p>
			</div>

		</article>



		<p class="title-internal mbottom20">Forma de pagamento</p>

		<article class="purchase-data section-payment">
			<div class="content-img-card float-left">
				<img src="{{ asset_web('images/img-cartao-credito.jpg') }}" alt="">
			</div>
			<div class="info-card-payment">
				<p class="amount-paid">1x de R$ 154,56</p>
				<p class="card-used">
					Nome impresso no cartão 
					<span>xxxx xxxx xxxx 1234</span>
				</p>
			</div>
		</article>

		<div class="wrap-content-bt mbottom10">
			<div class="content-bt-small">
				<a class="bt-default-full template11 bt-middle" href="#">Voltar <span class="arrow-link">></span></a>
			</div>
		</div>


	</section>


</div>

<div class="border-footer">

	@include('website::layouts.footer')

</div>



@stop