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
				<span>Dados da conta</span>
			</li>
		</ul>

		<h1 class="internal-subtitle">Minha conta</h1>

	</div>
</div>

<div class="wrap-menu-account-data">

	<div class="row">

		<div class="menu-account-mob">
			<p>Favoritos</p> <span class="seta-mobile-account">v</span>
		</div>	

		<ul class="menu-account-data">


			<li>
				<a href="/minhaconta-pedidos">Meus pedidos</a>
			</li>

			<li>
				<a href="/minhaconta-cadastro">Dados da conta</a>
			</li>

			<li class="current-account-data">
				<a href="/minhaconta-favoritos">Favoritos</a>
			</li>

			<li>
				<a href="/minhaconta-enderecos">Endereços</a>
			</li>

		</ul>

	</div>

</div>

<div class="row">

	<div class="wrap-pagination-favorites">

		<div class="container-total-products">
			<span class="total-products show-mobile">1 - 15 de 350 produtos</span>
		</div>

		<div class="search-internal">
			<input type="search" placeholder="Buscar" class="input-serach-internal">
			<input type="submit" class="sprite-icon bt-search-internal" value="">
		</div>

		<div class="container-left-pag">

			<div class="container-total-products">
				<span class="total-products show-desktop">1 - 15 de 350 produtos</span>
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

	<article class="wrap-content-four-line template4">

		<div class="wine-card">
			<span class="favorite clicado opacity1"></span>

			<h3 class="title-card-wine">
				<a href="javascript:void(0);">
					Kaiken terroir series Corte 2012
					<span>Kaiken</span>
				</a>
			</h3>
			<p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
			<div class="content-card-product">
				<div class="thumb-wine">
					<img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
					<a href="javascript:void(0);">
						<img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
					</a>
				</div>
				<div class="other-wine-info">
					<a href="javascript:void(0);">
						<p class="info-details-wine">Tinto Pinot</p>
						<p class="info-details-wine">Noir Chile</p>
						<p class="in"> De <span>R$ 38,50</span></p>
						<p class="wine-price">
							R$ 72,26
						</p>
					</a>
				</div>

			</div>

			<a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
		</div>

		<div class="wine-card">
			<span class="favorite clicado opacity1"></span>

			<h3 class="title-card-wine">
				<a href="javascript:void(0);">
					Kaiken terroir series Corte 2012
					<span>Kaiken</span>
				</a>
			</h3>
			<p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
			<div class="content-card-product">
				<div class="thumb-wine">
					<img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
					<a href="javascript:void(0);">
						<img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
					</a>
				</div>
				<div class="other-wine-info">
					<a href="javascript:void(0);">
						<p class="info-details-wine">Tinto Pinot</p>
						<p class="info-details-wine">Noir Chile</p>
						<p class="in"> De <span>R$ 38,50</span></p>
						<p class="wine-price">
							R$ 72,26
						</p>
					</a>
				</div>

			</div>

			<a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
		</div>

		<div class="wine-card">
			<span class="favorite clicado opacity1"></span>

			<h3 class="title-card-wine">
				<a href="javascript:void(0);">
					Kaiken terroir series Corte 2012
					<span>Kaiken</span>
				</a>
			</h3>
			<p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
			<div class="content-card-product">
				<div class="thumb-wine">
					<img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
					<a href="javascript:void(0);">
						<img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
					</a>
				</div>
				<div class="other-wine-info">
					<a href="javascript:void(0);">
						<p class="info-details-wine">Tinto Pinot</p>
						<p class="info-details-wine">Noir Chile</p>
						<p class="in"> De <span>R$ 38,50</span></p>
						<p class="wine-price">
							R$ 72,26
						</p>
					</a>
				</div>

			</div>

			<a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
		</div>

		<div class="wine-card">
			<span class="favorite clicado opacity1"></span>

			<h3 class="title-card-wine">
				<a href="javascript:void(0);">
					Kaiken terroir series Corte 2012
					<span>Kaiken</span>
				</a>
			</h3>
			<p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
			<div class="content-card-product">
				<div class="thumb-wine">
					<img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
					<a href="javascript:void(0);">
						<img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
					</a>
				</div>
				<div class="other-wine-info">
					<a href="javascript:void(0);">
						<p class="info-details-wine">Tinto Pinot</p>
						<p class="info-details-wine">Noir Chile</p>
						<p class="in"> De <span>R$ 38,50</span></p>
						<p class="wine-price">
							R$ 72,26
						</p>
					</a>
				</div>

			</div>

			<a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
		</div>

		<div class="wine-card">
			<span class="favorite clicado opacity1"></span>

			<h3 class="title-card-wine">
				<a href="javascript:void(0);">
					Kaiken terroir series Corte 2012
					<span>Kaiken</span>
				</a>
			</h3>
			<p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
			<div class="content-card-product">
				<div class="thumb-wine">
					<img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
					<a href="javascript:void(0);">
						<img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
					</a>
				</div>
				<div class="other-wine-info">
					<a href="javascript:void(0);">
						<p class="info-details-wine">Tinto Pinot</p>
						<p class="info-details-wine">Noir Chile</p>
						<p class="in"> De <span>R$ 38,50</span></p>
						<p class="wine-price">
							R$ 72,26
						</p>
					</a>
				</div>

			</div>

			<a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
		</div>

		<div class="wine-card">
			<span class="favorite clicado opacity1"></span>

			<h3 class="title-card-wine">
				<a href="javascript:void(0);">
					Kaiken terroir series Corte 2012
					<span>Kaiken</span>
				</a>
			</h3>
			<p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
			<div class="content-card-product">
				<div class="thumb-wine">
					<img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
					<a href="javascript:void(0);">
						<img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
					</a>
				</div>
				<div class="other-wine-info">
					<a href="javascript:void(0);">
						<p class="info-details-wine">Tinto Pinot</p>
						<p class="info-details-wine">Noir Chile</p>
						<p class="in"> De <span>R$ 38,50</span></p>
						<p class="wine-price">
							R$ 72,26
						</p>
					</a>
				</div>

			</div>

			<a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
		</div>

		<div class="wine-card">
			<span class="favorite clicado opacity1"></span>

			<h3 class="title-card-wine">
				<a href="javascript:void(0);">
					Kaiken terroir series Corte 2012
					<span>Kaiken</span>
				</a>
			</h3>
			<p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
			<div class="content-card-product">
				<div class="thumb-wine">
					<img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
					<a href="javascript:void(0);">
						<img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
					</a>
				</div>
				<div class="other-wine-info">
					<a href="javascript:void(0);">
						<p class="info-details-wine">Tinto Pinot</p>
						<p class="info-details-wine">Noir Chile</p>
						<p class="in"> De <span>R$ 38,50</span></p>
						<p class="wine-price">
							R$ 72,26
						</p>
					</a>
				</div>

			</div>

			<a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
		</div>

		<div class="wine-card">
			<span class="favorite clicado opacity1"></span>

			<h3 class="title-card-wine">
				<a href="javascript:void(0);">
					Kaiken terroir series Corte 2012
					<span>Kaiken</span>
				</a>
			</h3>
			<p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
			<div class="content-card-product">
				<div class="thumb-wine">
					<img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
					<a href="javascript:void(0);">
						<img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
					</a>
				</div>
				<div class="other-wine-info">
					<a href="javascript:void(0);">
						<p class="info-details-wine">Tinto Pinot</p>
						<p class="info-details-wine">Noir Chile</p>
						<p class="in"> De <span>R$ 38,50</span></p>
						<p class="wine-price">
							R$ 72,26
						</p>
					</a>
				</div>

			</div>

			<a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
		</div>

		<div class="wine-card">
			<span class="favorite clicado opacity1"></span>

			<h3 class="title-card-wine">
				<a href="javascript:void(0);">
					Kaiken terroir series Corte 2012
					<span>Kaiken</span>
				</a>
			</h3>
			<p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
			<div class="content-card-product">
				<div class="thumb-wine">
					<img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
					<a href="javascript:void(0);">
						<img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
					</a>
				</div>
				<div class="other-wine-info">
					<a href="javascript:void(0);">
						<p class="info-details-wine">Tinto Pinot</p>
						<p class="info-details-wine">Noir Chile</p>
						<p class="in"> De <span>R$ 38,50</span></p>
						<p class="wine-price">
							R$ 72,26
						</p>
					</a>
				</div>

			</div>

			<a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
		</div>

		<div class="wine-card">
			<span class="favorite clicado opacity1"></span>

			<h3 class="title-card-wine">
				<a href="javascript:void(0);">
					Kaiken terroir series Corte 2012
					<span>Kaiken</span>
				</a>
			</h3>
			<p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
			<div class="content-card-product">
				<div class="thumb-wine">
					<img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
					<a href="javascript:void(0);">
						<img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
					</a>
				</div>
				<div class="other-wine-info">
					<a href="javascript:void(0);">
						<p class="info-details-wine">Tinto Pinot</p>
						<p class="info-details-wine">Noir Chile</p>
						<p class="in"> De <span>R$ 38,50</span></p>
						<p class="wine-price">
							R$ 72,26
						</p>
					</a>
				</div>

			</div>

			<a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
		</div>

		<div class="wine-card">
			<span class="favorite clicado opacity1"></span>

			<h3 class="title-card-wine">
				<a href="javascript:void(0);">
					Kaiken terroir series Corte 2012
					<span>Kaiken</span>
				</a>
			</h3>
			<p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
			<div class="content-card-product">
				<div class="thumb-wine">
					<img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
					<a href="javascript:void(0);">
						<img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
					</a>
				</div>
				<div class="other-wine-info">
					<a href="javascript:void(0);">
						<p class="info-details-wine">Tinto Pinot</p>
						<p class="info-details-wine">Noir Chile</p>
						<p class="in"> De <span>R$ 38,50</span></p>
						<p class="wine-price">
							R$ 72,26
						</p>
					</a>
				</div>

			</div>

			<a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
		</div>

		<div class="wine-card">
			<span class="favorite clicado opacity1"></span>

			<h3 class="title-card-wine">
				<a href="javascript:void(0);">
					Kaiken terroir series Corte 2012
					<span>Kaiken</span>
				</a>
			</h3>
			<p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
			<div class="content-card-product">
				<div class="thumb-wine">
					<img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
					<a href="javascript:void(0);">
						<img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
					</a>
				</div>
				<div class="other-wine-info">
					<a href="javascript:void(0);">
						<p class="info-details-wine">Tinto Pinot</p>
						<p class="info-details-wine">Noir Chile</p>
						<p class="in"> De <span>R$ 38,50</span></p>
						<p class="wine-price">
							R$ 72,26
						</p>
					</a>
				</div>

			</div>

			<a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
		</div>



	</article>



	<div class="container-total-products">
		<span class="total-products show-desktop">1 - 15 de 350 produtos</span>
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

<div class="border-footer">

	@include('website::layouts.footer')

</div>



@stop