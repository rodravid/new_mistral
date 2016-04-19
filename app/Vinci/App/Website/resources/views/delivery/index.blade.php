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
				<li class="current-status">
					<span>Entrega</span>
					<img class="cup-status" src="{{ asset_web('images/taca.png') }}" alt="">
				</li>
				<li class="show-desktop">
					<span>Pagamento</span>
					
				</li>
				<li class="show-desktop">
					<span>Confirmação</span>
				</li>

			</ul>
		</nav>

	</div>
</div>

<div class="row">

	<div class="wrap-content-bt mbottom20">
		<span class="title-internal-15 float-left">Escolha o endereço de entrega</span>
		<div class="content-bt-middle mright-ajust hide-mobile">
			<a class="bt-default-full bt-color" href="#">Novo endereço <span class="arrow-link">&gt;</span></a>
		</div>
	</div>

	<section class="adress-delivery">

		<div class="adress">
			<a href="javascript:void(0);" class="bt-edit" title="Editar Endereço"> > </a>
			<div class="content-adress mbottom20">
				<h4 class="uppercase">casa</h4>
				<p>Rua bahia, 1126, Higienópolis</p>
				<p>São Paulo - SP</p>
				<p>CEP 04412-300</p>
			</div>
			<h4>Frete</h4>
			<p>R$ 10,00</p>
			<a class="bt-default-full bt-color mtop20" href="/pagamento">Usar esse endereço <span class="arrow-link">&gt;</span></a>
		</div>

		<div class="adress">
			<a href="javascript:void(0);" class="bt-edit" title="Editar Endereço"> > </a>
			<div class="content-adress mbottom20">
				<h4 class="uppercase">casa</h4>
				<p>Rua bahia, 1126, Higienópolis</p>
				<p>São Paulo - SP</p>
				<p>CEP 04412-300</p>
			</div>
			<h4>Frete</h4>
			<p>R$ 10,00</p>
			<a class="bt-default-full bt-color mtop20" href="/pagamento">Usar esse endereço <span class="arrow-link">&gt;</span></a>
		</div>

				<div class="adress">
			<a href="javascript:void(0);" class="bt-edit" title="Editar Endereço"> > </a>
			<div class="content-adress mbottom20">
				<h4 class="uppercase">casa</h4>
				<p>Rua bahia, 1126, Higienópolis</p>
				<p>São Paulo - SP</p>
				<p>CEP 04412-300</p>
			</div>
			<h4>Frete</h4>
			<p>R$ 10,00</p>
			<a class="bt-default-full bt-color mtop20" href="/pagamento">Usar esse endereço <span class="arrow-link">&gt;</span></a>
		</div>

				<div class="adress">
			<a href="javascript:void(0);" class="bt-edit" title="Editar Endereço"> > </a>
			<div class="content-adress mbottom20">
				<h4 class="uppercase">casa</h4>
				<p>Rua bahia, 1126, Higienópolis</p>
				<p>São Paulo - SP</p>
				<p>CEP 04412-300</p>
			</div>
			<h4>Frete</h4>
			<p>R$ 10,00</p>
			<a class="bt-default-full bt-color mtop20" href="/pagamento">Usar esse endereço <span class="arrow-link">&gt;</span></a>
		</div>

						<div class="adress">
			<a href="javascript:void(0);" class="bt-edit" title="Editar Endereço"> > </a>
			<div class="content-adress mbottom20">
				<h4 class="uppercase">casa</h4>
				<p>Rua bahia, 1126, Higienópolis</p>
				<p>São Paulo - SP</p>
				<p>CEP 04412-300</p>
			</div>
			<h4>Frete</h4>
			<p>R$ 10,00</p>
			<a class="bt-default-full bt-color mtop20" href="/pagamento">Usar esse endereço <span class="arrow-link">&gt;</span></a>
		</div>
		
		<div class="wrap-content-bt mbottom20 show-mobile">
			<div class="content-bt-middle">
				<a class="bt-default-full bt-color" href="#">Novo endereço <span class="arrow-link">&gt;</span></a>
			</div>
		</div>

	</section>

	
</div>

@include('website::layouts.partials.checkoutfooter')


@stop