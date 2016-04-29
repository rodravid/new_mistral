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
				<span>Meus pedidos</span>
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

	
	<div class="wrap-pag-header">	

		<div class="container-total-products">
			<span class="total-products">1 - 15 de 350 produtos</span>
		</div>

		<ul class="pagination">
			<li>
				<a href="javascript:void(0);" class="selected">1</a>
			</li>
			<li>
				<a href="">2</a>
			</li>
			<li>
				<a href="">3</a>
			</li>
			<li>
				<a href="">4</a>
			</li>
			<li>
				<a href="">5</a>
			</li>
			<li>
				<a href="">></a>
			</li>
		</ul>

	</div>

	<article class="request section-request">

		<div class="row-request-account template11">

			<div class="col-request-account">

				<div class="num-request-account">
					<p class="title-info-req">Número do pedido</p>
					<span class="num-request-cod">12345678</span>
				</div>

				<div class="num-request-date">
					<p class="title-info-req">Data do pedido</p>
					<span class="title-txt-req">25/jan/2106</span>
				</div>

				<div class="num-request-price">
					<p class="title-info-req">Valor</p>
					<span class="title-txt-req">R$ 145,56</span>
				</div>

				<div class="num-request-status">
					<p class="title-info-req">Status</p>
					<span class="title-txt-req">Entregue 02/fev</span>
				</div>

				<div class="float-right mtop10">
					<a class="bt-arrow-action" href="/minhaconta-detalhe-pedido"> > </a>
				</div>

			</div>

		</div>

		<div class="row-request-account template11">

			<div class="col-request-account">

				<div class="num-request-account">
					<p class="title-info-req">Número do pedido</p>
					<span class="num-request-cod">12345678</span>
				</div>

				<div class="num-request-date">
					<p class="title-info-req">Data do pedido</p>
					<span class="title-txt-req">25/jan/2106</span>
				</div>

				<div class="num-request-price">
					<p class="title-info-req">Valor</p>
					<span class="title-txt-req">R$ 145,56</span>
				</div>

				<div class="num-request-status">
					<p class="title-info-req">Status</p>
					<span class="title-txt-req">Entregue 02/fev</span>
				</div>

				<div class="float-right mtop10">
					<a class="bt-arrow-action" href="/minhaconta-detalhe-pedido"> > </a>
				</div>

			</div>

		</div>

		<div class="row-request-account template11">

			<div class="col-request-account">

				<div class="num-request-account">
					<p class="title-info-req">Número do pedido</p>
					<span class="num-request-cod">12345678</span>
				</div>

				<div class="num-request-date">
					<p class="title-info-req">Data do pedido</p>
					<span class="title-txt-req">25/jan/2106</span>
				</div>

				<div class="num-request-price">
					<p class="title-info-req">Valor</p>
					<span class="title-txt-req">R$ 145,56</span>
				</div>

				<div class="num-request-status">
					<p class="title-info-req">Status</p>
					<span class="title-txt-req">Entregue 02/fev</span>
				</div>

				<div class="float-right mtop10">
					<a class="bt-arrow-action" href="/minhaconta-detalhe-pedido"> > </a>
				</div>

			</div>

		</div>

		<div class="row-request-account template11">

			<div class="col-request-account">

				<div class="num-request-account">
					<p class="title-info-req">Número do pedido</p>
					<span class="num-request-cod">12345678</span>
				</div>

				<div class="num-request-date">
					<p class="title-info-req">Data do pedido</p>
					<span class="title-txt-req">25/jan/2106</span>
				</div>

				<div class="num-request-price">
					<p class="title-info-req">Valor</p>
					<span class="title-txt-req">R$ 145,56</span>
				</div>

				<div class="num-request-status">
					<p class="title-info-req">Status</p>
					<span class="title-txt-req">Entregue 02/fev</span>
				</div>

				<div class="float-right mtop10">
					<a class="bt-arrow-action" href="/minhaconta-detalhe-pedido"> > </a>
				</div>

			</div>

		</div>


	</article>


	<div class="wrap-pag-header">	

		<div class="container-total-products show-desktop">
			<span class="total-products ">1 - 15 de 350 produtos</span>
		</div>

		<ul class="pagination">
			<li>
				<a href="javascript:void(0);" class="selected">1</a>
			</li>
			<li>
				<a href="">2</a>
			</li>
			<li>
				<a href="">3</a>
			</li>
			<li>
				<a href="">4</a>
			</li>
			<li>
				<a href="">5</a>
			</li>
			<li>
				<a href="">></a>
			</li>
		</ul>

	</div>

</div>

<div class="border-footer">

	@include('website::layouts.footer')

</div>



@stop