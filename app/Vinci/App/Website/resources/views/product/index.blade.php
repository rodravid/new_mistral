@extends('website::layouts.master')

@section('content')
<div class="header-internal blue-bg">
	@include('website::layouts.menu')
	<div class="row">

		<ul class="breadcrumb">
			<li class="breadcrumb-item">
				<a class="breadcrumb-link" href="/"><span>Início</span></a> >
			</li>

			<li class="breadcrumb-item">
				<a class="breadcrumb-link" href="/"><span>Chile</span></a> >
			</li>

			<li class="breadcrumb-item">
				<a class="breadcrumb-link" href="/"><span>Mendonza</span></a> >
			</li>

			<li class="breadcrumb-item">
				<a class="breadcrumb-link" href="/"><span>Luca (Laura Catena)</span></a> >
			</li>

			<li class="breadcrumb-item">
				<a class="breadcrumb-link" href="/"><span>Luca Malbec</span></a>
			</li>

		</ul>

	</div>

</div>

<div class="bg-product blue"></div>

<div class="row relative">

	<article class="wrap-content-product">
		
		<div class="col-product-one">
			
			<h1> Luca Malbec 2012</h1>
			<span>Luca (Laura catena)</span>

			<h2>O melhor vinho da Argentina entre todos os Top 100
				da Wine Spectator 
			</h2>

		</div>
		<div class="col-product-two">
			<img src="http://www.vinci.com.br/images/product/1895130_g.jpg" alt="">
		</div>
		<div class="col-product-tree">
			col-product-tree

		</div>
		<div class="col-product-four">
			<ul class="detalhes-vinho">

				<li>
					<ul>
						<li><p class="item-info-vinho">Produtor</p></li>
						<li><a href="/produtor/catena-zapata"><p class="info-vinho-verde">Catena Zapata</p></a></li>
					</ul>
				</li>
				
				<li>
					<ul>
						<li><p class="item-info-vinho">País</p></li>
						<li><a href="/pais/argentina"><p class="info-vinho-verde">Argentina</p></a></li>
					</ul>
				</li>
				
				<li>
					<ul>
						<li><p class="item-info-vinho">Região</p></li>
						<li><a href="/regiao/mendoza"><p class="info-vinho-verde">Mendoza</p></a></li>
					</ul>
				</li>
				
				<li>
					<ul>
						<li><p class="item-info-vinho">Safra</p></li>
						<li><p class="info-vinho-preto">2013</p></li>
					</ul>
				</li>
				
				<li>
					<ul>
						<li><p class="item-info-vinho">Tipo</p></li>
						<li><a href="/tipo-de-vinho/branco-seco"><p class="info-vinho-verde">Branco Seco</p></a></li>
					</ul>
				</li>
				
				<li>
					<ul>
						<li><p class="item-info-vinho">Uva</p></li>
						<li><p class="info-vinho-preto">Chardonnay (100%)</p></li>
					</ul>
				</li>
				
				<li>
					<ul>
						<li><p class="item-info-vinho">Volume</p></li>
						<li><p class="info-vinho-preto">750 ml</p></li>
					</ul>
				</li>
				
				<div class="mais-info-vinho">

					<li>
						<ul>
							<li><p class="item-info-vinho">Teor alcólico</p></li>
							<li><p class="info-vinho-preto">14%</p></li>
						</ul>
					</li>
					
					<li>
						<ul>
							<li><p class="item-info-vinho">Temperatura de Serviço</p></li>
							<li><p class="info-vinho-preto">9 a 11ºC</p></li>
						</ul>
					</li>
					
					<li>
						<ul>
							<li><p class="item-info-vinho">Corpo</p></li>
							<li><p class="info-vinho-preto">Encorpado</p></li>
						</ul>
					</li>
					
					<li>
						<ul>
							<li><p class="item-info-vinho">Sugestão de decantação</p></li>
							<li><p class="info-vinho-preto">Não</p></li>
						</ul>
					</li>
					
					<li>
						<ul>
							<li><p class="item-info-vinho">Sugestão de guarda</p></li>
							<li><p class="info-vinho-preto">de 5 até 10 anos</p></li>
						</ul>
					</li>
					
					<li>
						<ul>
							<li><p class="item-info-vinho">Combinações</p></li>
							<li><p class="info-vinho-preto">Peixes, frutos do mar e bacalhau.</p></li>
						</ul>
					</li>
					
					<li>
						<ul>
							<li><p class="item-info-vinho">Validade</p></li>
							<li><p class="info-vinho-preto">Válido por prazo indeterminado desde que conservado deitado em local fresco e escuro.</p></li>
						</ul>
					</li>
					
					<li>
						<ul>
							<li><p class="item-info-vinho">Vinhedo</p></li>
							<li><p class="info-vinho-preto">Adrianna, com altitude de  1480m. Colheita manual e rendimento limitado.</p></li>
						</ul>
					</li>
					
					<li>
						<ul>
							<li><p class="item-info-vinho">Vinificação</p></li>
							<li><p class="info-vinho-preto">Fermentação em barricas de carvalho francês, com leveduras selecionadas e temperatura controlada por 20 dias.</p></li>
						</ul>
					</li>
					
					<li>
						<ul>
							<li><p class="item-info-vinho">Maturação</p></li>
							<li><p class="info-vinho-preto">Maturado 11 meses em barricas de carvalho francês, sendo 73% novas.</p>
							</li>
						</ul>
					</li>
				</div>
			</ul>
			
		</div>
		<div class="col-product-five">
			col-product-five
			
		</div>

	</article>

</div>

@stop