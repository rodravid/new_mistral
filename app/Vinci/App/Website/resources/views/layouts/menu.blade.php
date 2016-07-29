<header class="header-main @if(auth('website')->check()) logged-in-user @endif">
    <div class="row relative">
        <input type="checkbox" id="control-nav"/>
        <label for="control-nav" class="control-nav"></label>
        <label for="control-nav" class="control-nav-close"></label>


        <?php $logoTagClass = Route::currentRouteName() == 'index' ? 'h1' : 'span'; ?>

        <{{ $logoTagClass }} class
        ="logo">
        <a class="logo-vinci sprite-icon" href="/" title="Vinci - Loucos por vinho">Vinci - Loucos por vinho</a>
    </{{ $logoTagClass }}>

    <div class="search">
        {!! Form::open(['route' => 'search.index', 'method' => 'GET']) !!}
        <div class="typeahead__container">
            <div class="wrap-input-search">
                <div class="typeahead__field">
                    <input class="input-search js-typeahead" type="search" name="termo" autocomplete="off">
                </div>
                <div class="results-suggestions">
                    <span class="bt-close-suggestions sprite-icon"></span>

                    <div id="suggestion-result"></div>
                </div>
            </div>
            <input class="input-bt-search sprite-icon" type="submit" value="">
        </div>
        {{ Form::close() }}
    </div>

    <nav class="navbar">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('contact.index') }}">
                    Fale conosco
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('account.orders.index') }}">
                    Meus pedidos
                </a>
            </li>
            <li class="nav-item nav-item-cadastro">
                <a class="nav-link" href="{{ route('register.index') }}">
                    Cadastro
                </a>
            </li>
            <li class="nav-item nav-item-login">
                <a class="nav-link call-login" href="javascript:void(0);">
                    Login
                </a>
            </li>

            @if(auth('website')->check())
                <li class="nav-item nav-item-user-logged">
                    <a class="nav-link" href="javascript:void(0);">
                        {{ $loggedUser->salutation }}
                    </a>
                    <div class="drop-user">
                        <a href="{{ route('account.edit') }}">Meus dados</a>
                        <a href="{{ route('account.orders.index') }}">Pedidos</a>
                        <a href="{{ route('account.favorite.index') }}">Favoritos</a>
                        <a href="{{ route('account.addresses.index') }}">Endereços</a>
                        <a href="{{ route('logout') }}">Sair</a>
                    </div>
                </li>
            @endif
        </ul>
    </nav>

    <div ng-controller="CartWidgetController as ctrl">
        <a href="/carrinho">
            <div class="cart-header sprite-icon show-mobile">
                <div class="nav-cart-count sprite-icon" ng-bind="cart.count_items"></div>
            </div>
        </a>

        <div class="cart-header sprite-icon show-desktop">
            <div class="nav-cart-count sprite-icon" ng-bind="cart.count_items"></div>
            <div class="drop-cart template1">

                <p class="your-cart ng-hide" ng-show="!ctrl.hasItems()">Não há produtos em seu carrinho.</p>

                <div class="ng-hide" ng-show="ctrl.hasItems()">
                    <p class="your-cart">Você tem <span id="cartCount">@{{ cart.count_items }} produtos</span> no
                        carrinho de compras</p>
                    <ul class="lista-add" id="cartItems">
                        <li ng-repeat="item in cart.items | limitTo:3 ">
                            <a href="@{{ item.web_path }}">
                                <div class="product-add">
                                    <img src="@{{ item.image_url }}"
                                         width="20" height="57" class="float-left" alt="" class="info-vinho-bold">
                                    <p class="product-name-cart">@{{ item.name }} <span
                                                ng-show="item.producer">(@{{ item.producer }})</span></p>
                                </div>
                                <div class="value-product">
                                    <p class="price-wine">@{{ item.sale_price | currency }} <span>@{{ item.quantity }}
                                            un.</span></p>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <a href="{{ route('cart.index') }}" class="bt-default bt-default-blue float-right">Detalhes do
                        carrinho <span class="arrow-link">></span></a>
                </div>

            </div>
        </div>
    </div>

    <nav class="menu-main">
        <a class="logo-mobile sprite-icon" href="javascript:void(0);"></a>
        <ul class="menu">

            <li class="menu-item larger760 template1">
                <a class="menu-link" href="/categoria">
                    País
                </a>
                <div class="drop-menu">
                    <div class="division">
                        <ul class="list-sub-menu">
                            <li><a href="/c/pais/chile">Chile</a></li>
                            <li><a href="/c/pais/argentina">Argentina</a></li>
                            <li><a href="/c/pais/espanha">Espanha</a></li>
                            <li><a href="/c/pais/italia">Itália</a></li>
                            <li><a href="/c/pais/franca">França</a></li>
                            <li><a href="/c/pais/portugal">Portugal</a></li>
                        </ul>
                    </div>
                    <div class="division">
                        <ul class="list-sub-menu">
                        <li><a href="/c/pais/africa-do-sul">África do Sul</a></li>
                        <li><a href="/c/pais/brasil">Brasil</a></li>
                        <li><a href="/c/pais/alemanha">Alemanha</a></li>
                        <li><a href="/c/pais/uruguai">Uruguai</a></li>
                        <li><a href="/c/pais/estados-unidos">Estados Unidos</a></li>
                        <li><a class="all-links" href="/c/paises">Lista de todos os países <small>></small></a></li>
                        </ul>
                    </div>
                    <div class="division">
                        <div class="featured-wrap">
                            <h2 class="title-menu">Sugerimos</h2>
                            <div class="featured-sub-menu">
                                <a href="javascript:void(0);">
                                    <h3>
                                        KAIKEN TERROIR SERIES CORTE 2013
                                    </h3>
                                    <p class="wine-card-producer">Kaiken</p>
                                    <p class="featured-sub-descr">Elaborado pela talentosa Laura Catena, este Malbec poderoso e cheio de personalidade ...</p>
                                        <p class="price-card-menu">R$ 120,20</p>
                                    </a>
                                    <a href="javascript:void(0);" class="bt-default-full template1">Comprar <span class="arrow-link">></span></a>
                                </div>

                            </div>
                        </div>
                </div>
            </li>

            <li class="menu-item larger760 template2">
                <a class="menu-link" href="javascript:void(0);">
                    Região
                </a>
                <div class="drop-menu">
                    <div class="division">
                        <ul class="list-sub-menu">
                            <li><a href="/c/regiao/mendoza">Mendoza</a></li>
                            <li><a href="/c/regiao/toscana">Toscana</a></li>
                            <li><a href="/c/regiao/bordeaux">Bordeaux</a></li>
                            <li><a href="/c/regiao/douro-e-porto">Douro e Porto</a></li>
                            <li><a href="/c/regiao/alentejo">Alentejo</a></li>
                            <li><a href="/c/regiao/bairrada">Bairrada</a></li>
                        </ul>
                    </div>

                    <div class="division">
                        <ul class="list-sub-menu">
                            <li><a href="/c/regiao/bourgogne">Bourgogne</a></li>
                            <li><a href="/c/regiao/languedoc-roussillon">Languedoc-Roussillon</a></li>
                            <li><a href="/c/regiao/piemonte">Piemonte</a></li>
                            <li><a href="/c/regiao/rhone">Rhône</a></li>
                            <li><a href="/c/regiao/rioja">Rioja</a></li>
                            <li><a href="/c/regiao/puglia">Puglia</a></li>
                        </ul>
                    </div>

                    <div class="division">
                        <a href="/c/regioes">
                            <div class="every-category">
                                <h3>Veja a lista de todas as regiões</h3>
                                <span>></span>
                            </div>
                        </a>
                    </div>

                </div>
            </li>

            <li class="menu-item larger760 template3">
                <a class="menu-link" href="javascript:void(0);">
                    Produtor
                </a>
                <div class="drop-menu">
                    <div class="division">
                        <ul class="list-sub-menu">
                            <li><a href="/c/produtor/errazuriz">Errazuriz</a></li>
                            <li><a href="/c/produtor/kaiken">Kaiken <span>(Viña Montes)</span></a></li>
                            <li><a href="/c/produtor/tilia">Tilia <span>(Bodegas Esmeralda)</span></a></li>
                            <li><a href="/c/produtor/luca-laura-catena">Laura Catena</a></li>
                            <li><a href="/c/produtor/terra-andina">Terra Andina</a></li>
                            <li><a href="/c/produtor/vina-tondonia">Viña Tondonia</a></li>
                        </ul>
                    </div>

                    <div class="division">
                        <ul class="list-sub-menu">
                            <li><a href="/c/produtor/niepoort">Niepoort</a></li>
                            <li><a href="/c/produtor/piccini">Piccini</a></li>
                            <li><a href="/c/produtor/monte-da-ravasqueira">Monte da Ravasqueira</a></li>
                            <li><a href="/c/produtor/ogier">Ogier</a></li>
                            <li><a href="/c/produtor/cvne-cia-vinicola-del-norte-de-espana">CVNE</a></li>
                            <li><a href="/c/produtor/masseria-trajone">Masseria Trajone</a></li>
                        </ul>
                    </div>

                    <div class="division">
                        <a href="/c/produtores">
                            <div class="every-category">
                                <h3>Veja a lista de todos os produtores</h3>
                                <span>></span>
                            </div>
                        </a>
                    </div>

                </div>
            </li>

            <li class="menu-item larger760-right template4">
                <a class="menu-link" href="javascript:void(0);">
                    Tipo de vinho
                </a>
                <div class="drop-menu">
                    <div class="division">
                        <ul class="list-sub-menu">
                            <li><a href="/c/tipo-de-vinho/tinto">Tintos</a></li>
                            <li><a href="/c/tipo-de-vinho/branco">Brancos</a></li>
                            <li><a href="/c/tipo-de-vinho/rosado">Rosados</a></li>
                            <li><a href="/c/tipo-de-vinho/espumante">Champagne e Espumantes</a></li>
                            <li><a href="/c/tipo-de-vinho/porto">Porto</a></li>
                            <li><a href="/c/tipo-de-vinho/sobremesa">Sobremesa</a></li>
                        </ul>
                    </div>

                    <div class="division">
                        <div class="featured-wrap">
                            {!! productCardMenu(159, 'Tinto', 'template4') !!}
                        </div>
                    </div>

                    <div class="division">
                        <div class="featured-wrap">
                            {!! productCardMenu(38, 'Champagne e espumantes', 'template4') !!}
                        </div>
                    </div>
                </div>
            </li>

            <li class="menu-item larger760-right template5">
                <a class="menu-link" href="javascript:void(0);">
                   Uva
                </a>
                <div class="drop-menu">
                    <div class="division">
                        <ul class="list-sub-menu">
                            <li><a href="/c/tipo-de-uva/malbec">Malbec</a></li>
                            <li><a href="/c/tipo-de-uva/cabernet-sauvignon">Cabernet Sauvignon</a></li>
                            <li><a href="/c/tipo-de-uva/tempranillo">Tempranillo</a></li>
                            <li><a href="/c/tipo-de-uva/chardonnay">Chardonnay</a></li>
                            <li><a href="/c/tipo-de-uva/carmenere">Carmenère</a></li>
                            <li><a href="/c/tipo-de-uva/merlot">Merlot</a></li>
                        </ul>
                    </div>

                    <div class="division">
                        <ul class="list-sub-menu">
                            <li><a href="/c/tipo-de-uva/sauvignon-blanc">Sauvignon Blanc</a></li>
                            <li><a href="/c/tipo-de-uva/sangiovese">Sangiovese</a></li>
                            <li><a href="/c/tipo-de-uva/pinot-noir">Pinot Noir</a></li>
                            <li><a href="/c/tipo-de-uva/syrah-e-shiraz">Syrah e Shiraz</a></li>
                            <li><a href="/c/tipo-de-uva/primitivo">Primitivo</a></li>
                            <li><a href="/c/tipo-de-uva/cortese">Cortese</a></li>
                        </ul>
                    </div>

                    <div class="division">
                        <a href="/c/tipos-de-uvas">
                            <div class="every-category">
                                <h3>Veja a lista de todas as uvas</h3>
                                <span>></span>
                            </div>
                        </a>
                    </div>

                </div>
            </li>

            <li class="menu-item larger760-right template6">
                <a class="menu-link" href="javascript:void(0);">
                    Bons e baratos
                </a>
                <div class="drop-menu">

                    <div class="division">
                        <div class="featured-wrap">
                            {!! productCardMenu(203, 'África do Sul', 'template6') !!}
                        </div>
                    </div>

                    <div class="division">
                        <div class="featured-wrap">
                            {!! productCardMenu(162, 'Chile', 'template6') !!}
                        </div>
                    </div>

                    <div class="division">
                        <a href="/c/vinhos-bons-e-baratos">
                            <div class="every-category">
                                <h3>Veja todos os vinhos da categoria  bons e baratos</h3>
                                <span>></span>
                            </div>
                        </a>
                    </div>
                </div>
            </li>

            <li class="menu-item larger760-right template7">
                <a class="menu-link" href="javascript:void(0);">
                    Por preço
                </a>
                <div class="drop-menu">

                    <div class="division">
                        <ul class="list-sub-menu">
                        <li><a href="/busca?preco%5B%5D=*-60">Até R$ 60</a></li>
                            <li><a href="/busca?preco%5B%5D=60-100">R$ 60 a R$100</a></li>
                            <li><a href="/busca?preco%5B%5D=100-170">R$ 100 a R$ 170</a></li>
                            <li><a href="/busca?preco%5B%5D=170-270">R$ 170 a R$ 270</a></li>
                            <li><a href="/busca?preco%5B%5D=270-500">R$ 270 a R$ 500</a></li>
                            <li><a href="/busca?preco%5B%5D=500-*">Acima de R$ 500</a></li>
                        </ul>
                    </div>
                    <div class="division">
                        <div class="featured-wrap">
                            {!! productCardMenu(206, 'Chile', 'template7') !!}
                        </div>
                    </div>

                    <div class="division">
                        <div class="featured-wrap">
                            {!! productCardMenu(783, 'Chile', 'template7') !!}
                        </div>
                    </div>
                </div>
            </li>

            <li class="menu-item larger760-right template12">
                <a class="menu-link" href="javascript:void(0);">
                    Meias garrafas
                </a>
                <div class="drop-menu">
                    <div class="division">
                        <div class="featured-wrap">
                            {!! productCardMenu(145, 'Chile', 'template12') !!}
                        </div>
                    </div>

                        <div class="division">
                            <div class="featured-wrap">
                                {!! productCardMenu(256, 'Chile', 'template12') !!}
                            </div>
                        </div>

                        <div class="division">
                            <a href="/c/vinhos-bons-e-baratos">
                                <div class="every-category">
                                    <h3>Veja todos os vinhos da categoria  bons e baratos</h3>
                                    <span>></span>
                                </div>
                            </a>
                        </div>
                    </div>
            </li>

            <li class="menu-item larger760-right template9">
                <a class="menu-link" href="javascript:void(0);">
                    Vinhos Pontuados
                </a>
                <div class="drop-menu">
                    <div class="division">
                        <ul class="list-sub-menu">
                        <li><a href="/c/pais/chile">Robert Parker</a></li>
                            <li><a href="/c/pais/argentina">95+ pontos</a></li>
                            <li><a href="/c/pais/espanha">Best Buys</a></li>
                            <li><a href="/c/pais/italia">90+ pontos</a></li>
                            <li><a href="/c/pais/franca">Wine Spectator</a></li>
                            <li><a class="all-links" href="/c/pais/portugal">Todos os vinhos pontuados <small>></small></a></li>
                        </ul>
                    </div>

                      <div class="division">
                            <div class="featured-wrap">
                                {!! productCardMenu(135, 'Chile', 'template9') !!}
                            </div>
                        </div>

                      <div class="division">
                            <div class="featured-wrap">
                                {!! productCardMenu(363, 'Chile', 'template9') !!}
                            </div>
                        </div>
                </div>
            </li>


        </ul>
        <ul class="menu menu-logout-mobile">

            <li class="menu-item hide-mobile">
                <a class="menu-link call-login" href="javascript:void(0)">
                    login
                </a>
            </li>

            <li class="menu-item  show-mobile">
                <a class="menu-link" href="{{ route('login') }}">
                    Login
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="{{ route('account.orders.index') }}">
                    Meus pedidos
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="{{ route('register.index') }}">
                    Cadastro
                </a>
            </li>

        </ul>

        <ul class="menu menu-login-mobile">

            <li class="menu-item">
                <a class="menu-link" href="{{ route('account.orders.index') }}">
                    Meus Pedidos
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="{{ route('account.edit') }}">
                    Meus Dados
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="{{ route('account.favorite.index') }}">
                    Favoritos
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="{{ route('account.addresses.index') }}">
                    Endereços
                </a>
            </li>

        </ul>

        <ul class="menu">

            <li class="menu-item">
                <a class="menu-link" href="{{ route('about.index') }}">
                    Sobre a vinci
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="{{ route('dealers.index') }}">
                    Revendedores
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="{{ route('frequent-doubts.index') }}">
                    dúvidas frequentes
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="{{ route('contact.index') }}">
                    Fale conosco
                </a>
            </li>

        </ul>
        @if(auth('website')->check())
            <ul class="menu">

                <li class="menu-item">
                    <span class="name-log-mobile">Logado como {{ $loggedUser->first_name }}</span>
                    <a class="menu-link" href="{{ route('logout') }}">
                        Sair
                    </a>
                </li>
            </ul>
        @endif
    </nav>
    </div>
</header>

@include('website::layouts.modals.login.default')
@include('website::layouts.modals.login.password.recovery.default')

<div class="overlay"></div>




