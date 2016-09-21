<footer>
	<div class="row">
		
		<div class="row-footer border-top-footer show-desktop">	
			<ul class="list-links-clients">
				<li><a class="link-light" href="{{ route('about.index') }}">Sobre a vinci</a></li>
				<li><a class="link-light" href="{{ route('dealers.index') }}">Revendedores</a></li>
				<li><a class="link-light" href="/atendimento/">Fale conosco</a></li>
				<li><a class="link-light" href="{{ route('frequent-doubts.index') }}">Dúvidas frequentes</a></li>
			</ul>
		</div>

		<div class="row-footer border-mobile-footer">	
			<ul class="buy-phone two-cols">
				<li> 
					<span>compre pelo telefone <span class="phone-mobile">(11) 3130.4500</span></span>
				</li>
				<li>
					<span>atendimento de  compras pelo site <span class="phone-mobile">(11) 2797.0000</span></span>
				</li>

			</ul>
		</div>

		<div class="row-footer show-desktop">
			
			<div class="wrap-links-footer">
				<h4>Vinhos</h4>
				<ul class="links-main-footer">

					<li class="item-main-footer">
						<a class="link-light" href="/c/pais/">País</a>
					</li>

					<li class="item-main-footer">
						<a class="link-light" href="/c/regiao/">Região</a>
					</li>

					<li class="item-main-footer">
						<a class="link-light" href="/c/produtor/">Produtor</a>
					</li>

				</ul>

				<ul class="links-main-footer">

					<li class="item-main-footer">
						<a class="link-light" href="/c/tipo-de-vinho/">Tipo de vinho</a>
					</li>

					<li class="item-main-footer">
						<a class="link-light" href="/c/tipo-de-uva/">Uva</a>
					</li>

					<li class="item-main-footer">
						<a class="link-light" href="/c/vinhos-bons-e-baratos/">Bons e baratos</a>
					</li>

				</ul>

				<ul class="links-main-footer">

					<li class="item-main-footer">
						<a class="link-light" href="javascript:void(0);">Por preço</a>
						<div class="drop-footer">
							<a class="link-drop-footer" href="/c/vinhos-por-preco/ate-60">Até R$ 60</a>
							<a class="link-drop-footer" href="/c/vinhos-por-preco/de-60-a-100">R$ 60 a R$100</a>
							<a class="link-drop-footer" href="/c/vinhos-por-preco/de-100-a-170">R$ 100 a R$ 170</a>
							<a class="link-drop-footer" href="/c/vinhos-por-preco/de-170-a-270">R$ 170 a R$ 270</a>
							<a class="link-drop-footer" href="/c/vinhos-por-preco/de-270-a-500">R$ 270 a R$ 500</a>
							<a class="link-drop-footer" href="/c/vinhos-por-preco/acima-de-500">Acima de R$ 500</a>
						</div>
					</li>

					<li class="item-main-footer">
						<a class="link-light" href="/c/meias-garrafas/">Mini e Meias garrafas</a>
					</li>

					<li class="item-main-footer">
						<a class="link-light" href="/c/vinhos-pontuados/">Vinhos pontuados</a>
					</li>

				</ul>
			</div>

			<div class="newsletter show-desktop" newsletter-widget>
				<h4>Newsletter</h4>
				<form action="{{ route('api.newsletter.register') }}" method="POST" ng-submit="submitForm($event)">
					<input class="input-newsletter" type="text" placeholder="NOME" name="newsletter_name" ng-model="name">
					<input class="input-newsletter" type="text" placeholder="E-MAIL" name="newsletter_email" ng-model="email">
					<button class="bt-newsletter" type="submit">CADASTRAR</button>
				</form>
			</div>
		</div>

		<div class="row-footer">	
			<ul class="address two-cols m-bottom20">
				<li> 
					<h4>
						Administração
					</h4>
					<p>
						Rua Dr. Siqueira Cardoso, 205 / 227 - CEP 03163-020  - São Paulo - SP
					</p>
				</li>
				<li>
					<h4>Escritório de Vendas</h4>
					<p>
						Rua Pamplona, 917 - CEP 01405-200 - Jardim Paulista - São Paulo - SP
					</p>
				</li>

			</ul>

			<p class="info-content-site">
				Proibida a reprodução total ou parcial desautorizada. Beba com responsabilidade. A venda de bebidas alcoólicas é proibida para menores de 18 anos. Dirigir sob a influência de álcool configura delito, passível de sanção penal. As imagens são meramente ilustrativas. No caso dos vinhos safrados, a safra mostrada no rótulo da imagem pode não corresponder ao ano de fabricação do vinho, que está especificado corretamente em "características" do produto. Para outros produtos e acessórios, algumas imagens são compostas com outros elementos para ilustrar sua utilidade.
			</p>

			<ul class="two-cols logo-seal mtop20">
				<li>
					<a class="sprite-icon logo-footer" href="{{ route('index') }}" title="Vinci Loucos por vinho"></a>
				</li>
				<li>
					<span id="siteseal"><script async type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=DOBokIXEwwsOZSPWYexGWiftbujJYSZJAk7noiKJyiCZAX11brcZBi2cR8fY"></script></span>
				</li>
			</ul>

		</div>
		
		<p>
			
		</p>

		<ul class="copyright two-cols m-bottom20">
			<li>
				<p>
					Copyright © 2016 Vinci Importadora e Exportadora de Bebidas Ltda. Todos os direitos reservados.
				</p>
			</li>
			<li>
				
				<p>
					<a href="{{ route('privacy.index') }}">Termos de Uso e Política de Privicidade e Segurança.</a>
				</p>
			</li>

		</ul>
	</div>

</footer>