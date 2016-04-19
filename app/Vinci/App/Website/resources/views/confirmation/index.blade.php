@extends('website::layouts.master')


@section('content')
<div class="header-internal header-checkout-confirmation template1-bg">
	@include('website::layouts.menu')
	<div class="row">
		
		<div class="wrap-content-bt mbottom20">
<!-- 			<span class="logo">
				<a class="logo-vinci sprite-icon" href="/" title="Vinci - Loucos por vinho">Vinci - Loucos por vinho</a>
			</span> -->
		</div>

		<h1 class="internal-subtitle">Meu Carrinho</h1>

		<nav class="nav-status float-right">

			<ul class="list-status">

				<li class="show-desktop">
					<span>Entrega</span>
				</li>
				<li class="show-desktop">
					<span>Pagamento</span>
				</li>
				<li class="current-status">
					<span>Confirmação</span>
					<img class="cup-status" src="{{ asset_web('images/taca.png') }}" alt="">
				</li>

			</ul>

		</nav>

	</div>

</div>

<div class="row">

	<section class="wrap-payment">

		<div class="wrap-content-bt mbottom20">
			<span class="title-internal-confirmation uppercase float-left">Pedido concluído com sucesso!</span>
			<div class="content-bt-big hide-mobile">
				<a class="bt-default-full bt-color" href="#">Continuar comprando <span class="arrow-link">&gt;</span></a>
			</div>
		</div>

		<article class="order section-payment">
			<div class="content-order float-left">
				<p class="txt-order">Numero do pedido</p>
				<span class="num-order">12345678</span>
			</div>
			<div class="status-order float-right">
				<p class="txt-order">Status</p>
				<p class="title-internal-15 mtop10">Aguardando pagamento</p>
			</div>
		</article>
		
		<p class="title-internal-blue mbottom20">Resumo do pedido</p>

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

		<p class="title-internal-blue mbottom20">Endereço de Entrega</p>

		<article class="to-deliver section-payment">
			<div class="float-left">
				<span class="title-internal-15 uppercase">Casa</span>
				<p>Rua bahia, 1126, Higienópolis</p>
				<p>São Paulo - SP</p>
				<p>CEP 04412-300</p>
			</div>

		</article>

		<p class="title-internal-blue mbottom20">Forma de pagamento</p>

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

		<div class="wrap-content-bt mbottom20 show-mobile">
			<div class="content-bt-middle ">
				<a class="bt-default-full bt-big bt-color" href="#">Continuar comprando <span class="arrow-link">&gt;</span></a>
			</div>
		</div>


	</section>


</div>

@include('website::layouts.footer')


@stop