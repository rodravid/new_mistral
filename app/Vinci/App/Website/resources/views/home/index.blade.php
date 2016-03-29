@extends('website::layouts.master')


@section('content')
@include('website::layouts.menu')

<div class="wrap-slider-principal">

	<div class="slider slider-principal">

		<div class="bg-slider-principal template1">
			<div class="conteudo-slider-principal" style="background: url({{ asset('website/images/bg-slider.png') }}) no-repeat;">
				<div class="descr-slider">
					<a href="javascript:void(0);">
						<h3 class="title-slider">O MELHOR VINHO DA <span>ARGENTINA</span> ENTRE TODOS <span>OS TOP 100 DA</span> WINE SPECTATOR</h3>
						<span class="sub-title-slider">Luca Malbec 2012</span>
						<p class="txt-slider">Elaborado pela talentosa Laura Catena, este Malbec poderoso e cheio de personalidade é sem dúvida um dos grandes vinhos da Argentina! </p>
					</a>
					<a href="javascript:void(0);" class="bt-default">Clique aqui <span class="arrow-link">></span></a>

				</div>
				<img class="seal-slider" src="{{ asset('website/images/selo-slider.png') }}" alt="">
			</div>
		</div>

		<div class="bg-slider-principal template3">

			<div class="conteudo-slider-principal" style="background: url({{ asset('website/images/bg-slider.png') }}) no-repeat;">

				<div class="descr-slider">
					<a href="javascript:void(0);">
						<h3 class="title-slider">O MELHOR VINHO DA <span>ARGENTINA</span> ENTRE TODOS <span>OS TOP 100 DA</span> WINE SPECTATOR</h3>
						<span class="sub-title-slider">Luca Malbec 2012</span>
						<p class="txt-slider">Elaborado pela talentosa Laura Catena, este Malbec poderoso e cheio de personalidade é sem dúvida um dos grandes vinhos da Argentina! </p>
					</a>
					<a href="javascript:void(0);" class="bt-default">Clique aqui <span class="arrow-link">></span></a>

				</div>

				<img class="seal-slider" src="{{ asset('website/images/selo-slider.png') }}" alt="">

			</div>

		</div>

		<div class="bg-slider-principal template4">

			<div class="conteudo-slider-principal" style="background: url({{ asset('website/images/bg-slider.png') }}) no-repeat;">

				<div class="descr-slider">
					<a href="javascript:void(0);">
						<h3 class="title-slider">O MELHOR VINHO DA <span>ARGENTINA</span> ENTRE TODOS <span>OS TOP 100 DA</span> WINE SPECTATOR</h3>
						<span class="sub-title-slider">Luca Malbec 2012</span>
						<p class="txt-slider">Elaborado pela talentosa Laura Catena, este Malbec poderoso e cheio de personalidade é sem dúvida um dos grandes vinhos da Argentina! </p>
					</a>
					<a href="javascript:void(0);" class="bt-default">Clique aqui <span class="arrow-link">></span></a>
				</div>
				
				<img class="seal-slider" src="{{ asset('website/images/selo-slider.png') }}" alt="">
			</div>



		</div>


	</div>
</div>
<div class="w960">
</div>

<div class="row top90">

	<section class="wrap-banners">
		<ul class="banners">
			<li class="list-banners">
				<img src="{{ asset('website/images/banner1.jpg') }}" alt="">	
			</li>
			<li class="list-banners">
				<img src="{{ asset('website/images/banner2.jpg') }}" alt="">		
			</li>
		</ul>
		
		
	</section>

	<section class="featured-products">

		<div class="cols-products template8">
			<h2 class="title-category">Compras Inteligentes</h2>
			
			<div class="wine-card">
				<span class="favorite"></span>
				
				<h3 class="title-card-wine">
					<a href="javascript:void(0);">
						Kaiken terroir series Corte 2012
						<span>Kaiken</span>
					</a>
				</h3>
				<p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
				<div class="content-card-product">
					<div class="thumb-wine">
						<img class="label-wine" src="{{ asset('website/images/selo-pontos.png') }}" alt="Selo Vinho">
						<a href="javascript:void(0);">
							<img class="wine-bottle" src="{{ asset('website/images/img-vinho.jpg') }}" alt="Vinho">
						</a>
					</div>
					<div class="other-wine-info">
						<a href="javascript:void(0);">
							<span class="wine-intro">Tinto Pinot Noir Chile</span>
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
				<span class="favorite"></span>
				
				<h3 class="title-card-wine">
					<a href="javascript:void(0);">
						Kaiken terroir series Corte 2012
						<span>Kaiken</span>
					</a>
				</h3>
				<p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
				<div class="content-card-product">
					<div class="thumb-wine">
						<a href="javascript:void(0);">
							<img class="wine-bottle" src="{{ asset('website/images/img-vinho.jpg') }}" alt="Vinho">
						</a>
					</div>
					<div class="other-wine-info">
						<a href="javascript:void(0);">
							<span class="wine-intro">Tinto Pinot Noir Chile</span>
							<p class="in"> De <span>R$ 38,50</span></p>
							<p class="wine-price">
								R$ 72,26
							</p>
						</a>
					</div>

				</div>
				
				<a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
			</div>


			<a class="show-mobile bt-default-full" href="#">Carregar mais vinhos <span class="arrow-link">v</span></a>

			
		</div>

		<div class="cols-products template6">
			<h2 class="title-category">90 pontos ou +</h2>
			
			<div class="wine-card">
				<span class="favorite"></span>
				
				<h3 class="title-card-wine">
					<a href="javascript:void(0);">
						Kaiken terroir series Corte 2012
						<span>Kaiken</span>
					</a>
				</h3>
				<p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
				<div class="content-card-product">
					<div class="thumb-wine">
						<a href="javascript:void(0);">
							<img class="wine-bottle" src="{{ asset('website/images/img-vinho.jpg') }}" alt="Vinho">
						</a>
					</div>
					<div class="other-wine-info">
						<a href="javascript:void(0);">
							<span class="wine-intro">Tinto Pinot Noir Chile</span>
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
				<span class="favorite"></span>
				
				<h3 class="title-card-wine">
					<a href="javascript:void(0);">
						Kaiken terroir series Corte 2012
						<span>Kaiken</span>
					</a>
				</h3>
				<p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
				<div class="content-card-product">
					<div class="thumb-wine">
						<a href="javascript:void(0);">
							<img class="wine-bottle" src="{{ asset('website/images/img-vinho.jpg') }}" alt="Vinho">
						</a>
					</div>
					<div class="other-wine-info">
						<a href="javascript:void(0);">
							<span class="wine-intro">Tinto Pinot Noir Chile</span>
							<p class="in"> De <span>R$ 38,50</span></p>
							<p class="wine-price">
								R$ 72,26
							</p>
						</a>
					</div>

				</div>
				
				<a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
			</div>

			
			<a class="show-mobile bt-default-full" href="#">Carregar mais produtos <span class="arrow-link">v</span></a>
			
		</div>

		<div class="cols-products template7">
			<h2 class="title-category">Orgânicos e biodinâmicos</h2>
			
			<div class="wine-card">
				<span class="favorite"></span>
				
				<h3 class="title-card-wine">
					<a href="javascript:void(0);">
						Kaiken terroir series Corte 2012
						<span>Kaiken</span>
					</a>
				</h3>
				<p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
				<div class="content-card-product">
					<div class="thumb-wine">
						<a href="javascript:void(0);">
							<img class="wine-bottle" src="{{ asset('website/images/img-vinho.jpg') }}" alt="Vinho">
						</a>
					</div>
					<div class="other-wine-info">
						<a href="javascript:void(0);">
							<span class="wine-intro">Tinto Pinot Noir Chile</span>
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
				<span class="favorite"></span>
				
				<h3 class="title-card-wine">
					<a href="javascript:void(0);">
						Kaiken terroir series Corte 2012
						<span>Kaiken</span>
					</a>
				</h3>
				<p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
				<div class="content-card-product">
					<div class="thumb-wine">
						<a href="javascript:void(0);">
							<img class="wine-bottle" src="{{ asset('website/images/img-vinho.jpg') }}" alt="Vinho">
						</a>
					</div>
					<div class="other-wine-info">
						<a href="javascript:void(0);">
							<span class="wine-intro">Tinto Pinot Noir Chile</span>
							<p class="in"> De <span>R$ 38,50</span></p>
							<p class="wine-price">
								R$ 72,26
							</p>
						</a>
					</div>

				</div>
				
				<a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
			</div>

			<a class="show-mobile bt-default-full" href="#">Carregar mais vinhos <span class="arrow-link">v</span></a>
			
		</div>

		<div class="cols-products template1">
			<h2 class="title-category">Vinhos para primavera</h2>
			
			<div class="wine-card">
				<span class="favorite"></span>
				
				<h3 class="title-card-wine">
					<a href="javascript:void(0);">
						Kaiken terroir series Corte 2012
						<span>Kaiken</span>
					</a>
				</h3>
				<p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
				<div class="content-card-product">
					<div class="thumb-wine">
						<img class="label-wine" src="{{ asset('website/images/selo-pontos.png') }}" alt="Selo Vinho">
						<a href="javascript:void(0);">
							<img class="wine-bottle" src="{{ asset('website/images/img-vinho.jpg') }}" alt="Vinho">
						</a>
					</div>
					<div class="other-wine-info">
						<a href="javascript:void(0);">
							<span class="wine-intro">Tinto Pinot Noir Chile</span>
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
				<span class="favorite"></span>
				
				<h3 class="title-card-wine">
					<a href="javascript:void(0);">
						Kaiken terroir series Corte 2012
						<span>Kaiken</span>
					</a>
				</h3>
				<p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
				<div class="content-card-product">
					<div class="thumb-wine">
						<img class="label-wine" src="{{ asset('website/images/selo-pontos.png') }}" alt="Selo Vinho">
						<a href="javascript:void(0);">
							<img class="wine-bottle" src="{{ asset('website/images/img-vinho.jpg') }}" alt="Vinho">
						</a>
					</div>
					<div class="other-wine-info">
						<a href="javascript:void(0);">
							<span class="wine-intro">Tinto Pinot Noir Chile</span>
							<p class="in"> De <span>R$ 38,50</span></p>
							<p class="wine-price">
								R$ 72,26
							</p>
						</a>
					</div>

				</div>
				
				<a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
			</div>

			<a class="show-mobile bt-default-full" href="#">Carregar mais vinhos <span class="arrow-link">v</span></a>
			
		</div>

		<a class="bt-default-full template7 show-desktop" href="#">Carregar mais produtos <span class="arrow-link">v</span></a>

	</section>

</div>

@stop