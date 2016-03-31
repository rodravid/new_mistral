@extends('website::layouts.master')


@section('content')
<div class="header-internal template1-bg">
	@include('website::layouts.menu')
	<div class="row">

		<h1 class="internal-subtitle">Meu Carrinho</h1>

	</div>
</div>

<div class="row">

	<div class="wrap-content-bt mbottom20">
		<div class="content-bt-middle">
			<a class="bt-default-full bt-middle bt-color" href="#">Finalizar Compra <span class="arrow-link">&gt;</span></a>
		</div>
	</div>

	

	<section class="wrap-cart">

		<div class="row-item-cart template1 show-desktop">

			<div class="col-cart1">

				<div class="col-product-cart">
					PRODUTOS


				</div>

				<div class="col-price-cart">
					PREÇO
				</div>

				<div class="col-cart2 hide-tablet"> 
					QUANTIDADE
				</div>

			</div>



			<div class="col-cart3"> 
				SUBTOTAL
			</div>

		</div>

		<article class="row-item-cart template1"> 	

			<div class="col-cart1">

				<div class="col-product-cart">
					<div class="thumb-wine">
						<a href="javascript:void(0);">
							<img class="wine-bottle" src="http://10.10.10.149:8085/assets/website/images/img-vinho.jpg" alt="Vinho">
						</a>
					</div>

					<div class="colum-description-cart">
						<h3 class="title-card-wine">
							
							Kaiken terroir series Corte 2012
							<span>Kaiken</span>
							
						</h3>

						<a class="link-cart" href="javascript:void();">
							Embalagem para presente >
						</a>

					</div>
				</div>

				<div class="col-price-cart">
					<p class="in"> De <span>R$ 38,50</span></p>
					<p class="wine-price">
						R$ 72,26
					</p>
				</div>

				<div class="col-cart2"> 
					<div class="botoes-add">
						<a id="remover-unidade" class="bt-remove" href="javascript:void(0);">-</a>
						<input type="text" id="mudarUnidade" class="input-quantity" value="1">
						<a id="add-unidade" href="javascript:void(0);" class="bt-add">+</a>
					</div>
					<a class="link-cart remove-product-cart" href="javascript:void();">
						Remover >
					</a>
				</div>

			</div>



			<div class="col-cart3 show-desktop"> 
				<h3 class="current-price">
					R$ 72,26
				</h3>
			</div>

		</article>

		<article class="row-item-cart template1"> 	

			<div class="col-cart1">

				<div class="col-product-cart">
					<div class="thumb-wine">
						<a href="javascript:void(0);">
							<img class="wine-bottle" src="http://10.10.10.149:8085/assets/website/images/img-vinho.jpg" alt="Vinho">
						</a>
					</div>

					<div class="colum-description-cart">
						<h3 class="title-card-wine">
							
							Kaiken terroir series Corte 2012 Super
							<span>Kaiken</span>
							
						</h3>

						<a class="link-cart" href="javascript:void();">
							Embalagem para presente >
						</a>

					</div>
				</div>

				<div class="col-price-cart">
					<p class="in"> De <span>R$ 3458,50</span></p>
					<p class="wine-price">
						R$ 1724,26
					</p>
				</div>

				<div class="col-cart2"> 
					<div class="botoes-add">
						<a id="remover-unidade" class="bt-remove" href="javascript:void(0);">-</a>
						<input type="text" id="mudarUnidade" class="input-quantity" value="1">
						<a id="add-unidade" href="javascript:void(0);" class="bt-add">+</a>
					</div>
					<a class="link-cart remove-product-cart" href="javascript:void();">
						Remover >
					</a>
				</div>

			</div>



			<div class="col-cart3 show-desktop"> 
				<h3 class="current-price">
					R$ 7112,26
				</h3>
			</div>

		</article>


		<ul class="valor-total-carrinho float-right">
			<li>
				<article class="wrap-compra-dados-venda">
					<span>Subtotal</span>
					<div class="container-info-compra">
						<p class="preco-menu" id="pgCartSubtotal">R$ 7112,26</p>
					</div>
				</article>
			</li>

			<li>
				<article class="wrap-compra-dados-venda">
					<span>Digite o CEP</span>
					<div class="container-info-compra">
						<form action="/checkShippingByShoppingCart" id="check-shipping">
							<input type="text" class="cep" id="postalCode" data-postal-code="0" maxlenght="9">
							<input type="submit" value="OK >">
						</form>
					</div>
				</article>
				<p class="cep-invalido" id="cepInvalido" style="display:none;">CEP inválido!</p>
			</li>

			<li id="shipping-info" style="display:none;">
				<article class="wrap-compra-dados-venda">
					<span>Frete</span>
					<div class="container-info-compra">
						<span id="shipping-value"></span>
					</div>
				</article>
				<article class="wrap-compra-dados-venda">

					<div class="container-info-compra">
						<span id="shipping-delivery"></span>
					</div>
				</article>
				<article class="wrap-compra-dados-venda">
					<div class="wrap-select-convencional select-standard half form-control-white">
						<select name="" id="" class="select-standard" style="display: none;">
							<option value="">convencional</option>
						</select>
					</div>
					<div class="container-info-remover">
						<a href="javascript:void(0);" class="remover-carrinho" id="removeShipping">remover</a>
					</div>
				</article>
			</li>
			<li>
				<article class="wrap-compra-dados-venda">
					<span>Total</span>
					<div class="container-info-compra">
						<p class="current-price" id="pgCartTotal">R$ 99,00</p>
					</div>
				</article>
			</li>
		</ul>

		<div class="wrap-content-bt">

			<div class="box-two-links">

				<a class="keep-buying" href="#">Continuar comprando ></a>

				<div class="content-bt-middle">
					<a class="bt-default-full bt-middle bt-color" href="#">Finalizar Compra <span class="arrow-link">&gt;</span></a>
				</div>

			</div>
		</div>

	</section>


	<section class="also-recommend featured-products hide-tablet">

		<h2 class="title-category">Também recomendamos</h2>

		<div class="cols-products">
			
			<div class="wine-card bg-template template2">
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
						<img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
						<a href="javascript:void(0);">
							<img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
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

		</div>

		<div class="cols-products">
			
			<div class="wine-card bg-template template4">
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
						<img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
						<a href="javascript:void(0);">
							<img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
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

		</div>

		<div class="cols-products">
			
			<div class="wine-card bg-template template7">
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
						<img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
						<a href="javascript:void(0);">
							<img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
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

		</div>

		<div class="cols-products">
			
			<div class="wine-card bg-template template1">
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
						<img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
						<a href="javascript:void(0);">
							<img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
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

		</div>

	</section>

</div>





@stop