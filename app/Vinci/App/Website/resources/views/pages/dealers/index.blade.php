@extends('website::layouts.master')


@section('content')
<div class="header-internal template12-bg">
	@include('website::layouts.menu')
	<div class="row">

		<ul class="breadcrumb">
			<li class="breadcrumb-item">
				<a class="breadcrumb-link" href="/"><span>Início</span></a> >
			</li>

			<li class="breadcrumb-item">
				<span>Revendedores</span>
			</li>
		</ul>

		<h1 class="internal-subtitle">Revendedores</h1>

	</div>
</div>

<div class="row">

	<header class="mbottom20">
		<span class="title-internal-15">Veja abaixo a lista dos nossos representantes.</span>
	</header>

	<article class="wrap-content-register template12">
		
		<div class="colum-620">	
			
			<ul class="colum-dealers float-left">
				<li>
					<strong class="txt-contact">BAURU E REGIÃO / SP</strong>
					<p>ARTUR RICARDO DE SOUZA  </p>
					<strong>(18) 98133-5552</strong>
				</li>

				<li>
					<strong class="txt-contact">BRASÍLIA E GOIÁS </strong>
					<p> MARLY MAIA </p>
					<strong>(61) 3248-7311 / (61) 9304-0653 </strong>
				</li>

				<li>
					<strong class="txt-contact">CAMPINAS E REGIÃO / SP</strong>
					<p>PEDRO CUNHA    </p>
					<strong>(18) 98133-5552</strong>
				</li>

				<li>
					<strong class="txt-contact">CURITIBA / PR   </strong>
					<p>  JORGE FERLIN
					</p>
					<strong>(41) 9644-3535 </strong>
				</li>

				<li>
					<strong class="txt-contact">FORTALEZA / CE </strong>
					<p>MARCO FERRARI  </p>
					<strong> (85) 3267-8038 / (85) 8845-1823</strong>
				</li>

				<li>
					<strong class="txt-contact">INTERIOR / RJ  </strong>
					<p>  JULIO CESAR 
					</p>
					<strong>(21) 98660-1909 / (21) 99843-9956 </strong>
				</li>

				<li>
					<strong class="txt-contact">INTERIOR / SP  </strong>
					<p> FLAVIO ROBERTO   </p>
					<strong>(19) 99603-6423 / (19) 7806-9292 </strong>
				</li>





			</ul>

			<ul class="colum-dealers float-right">


				<li>
					<strong class="txt-contact">MANAUS / AM </strong>
					<p> JOSÉ CESAR DA FONSECA </p>
					<strong>(92) 98238-8492</strong>
				</li>

				<li>
					<strong class="txt-contact">RECIFE / PE </strong>
					<p>TIAGO EMERY  </p>
					<strong> (81) 8889-3609</strong>
				</li>

				<li>
					<strong class="txt-contact"> RIO DE JANEIRO / RJ</strong>
					<p> VALÉRIA CRISTIANE  </p>
					<strong>(21) 96681-3605 / (21) 99270-1765 </strong>
				</li>

				<li>
					<strong class="txt-contact"> SALVADOR / BA</strong>
					<p> ALEXANDRE BRAULT </p>
					<strong> (71) 99169-8809/ (71) 99224-9880</strong>
				</li>


				<li>
					<strong class="txt-contact">VALE DO PARAÍBA E LITORAL NORTE / SP </strong>
					<p>GENESIO FILHO   </p>
					<strong>(12) 98230-6747</strong>
				</li>

				<li>
					<strong class="txt-contact"> VITÓRIA / ES</strong>
					<p> SIMEY SANTOS </p>
					<strong>(27) 99234-1668 </strong>
				</li>

			</ul>

		</div>

		<sidebar class="sidebar">

			<p>
				<span class="txt-contact">ATENDIMENTO</span>
				Se preferir, compre pelo telefone 
				<span class="txt-contact">(11) 3130-4500</span>
				(a política de venda através do site pode ser diferente da praticada na loja ou através do televendas). 
			</p>

			<p>
				Não há pedido mínimo. O frete é gratuito para pedidos acima de R$200,00 para a maioria das cidades da Grande São Paulo. Entregamos em quase todas as cidades do país, com frete contratado por conta do comprador, para mais detalhes consulte nossa política de frete.
			</p>

		</sidebar>

	</article>

</div>

<div class="border-footer">

	@include('website::layouts.footer')

</div>

@stop