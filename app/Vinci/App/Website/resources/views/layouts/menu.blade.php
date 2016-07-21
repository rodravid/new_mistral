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
                        <li><a class="all-links" href="/c/pais/uruguai">Lista de todos os países <small>></small></a></li>    
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
                            <li><a href="/c/pais/chile">Mendoza</a></li>
                            <li><a href="/c/pais/argentina">Toscana</a></li>
                            <li><a href="/c/pais/espanha">Bordeaux</a></li>
                            <li><a href="/c/pais/italia">Douro e Porto</a></li>
                            <li><a href="/c/pais/franca">Alentejo</a></li>
                            <li><a href="/c/pais/portugal">Bairrada</a></li>
                        </ul>
                    </div>

                    <div class="division">
                        <ul class="list-sub-menu">
                            <li><a href="/c/pais/chile">Bourgogne</a></li>
                            <li><a href="/c/pais/argentina">Languedoc-Roussillon</a></li>
                            <li><a href="/c/pais/espanha">Piemonte</a></li>
                            <li><a href="/c/pais/italia">Rhône</a></li>
                            <li><a href="/c/pais/franca">Rioja</a></li>
                            <li><a href="/c/pais/portugal">Puglia</a></li>
                        </ul>
                    </div>

                    <div class="division">
                        <a href="/regioes-produtoras-de-vinhos">
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
                    Região
                </a>
                <div class="drop-menu">
                    <div class="division">
                        <ul class="list-sub-menu">
                            <li><a href="/c/pais/chile">Errazuriz</a></li>
                            <li><a href="/c/pais/argentina">Kaiken <span>(Viña Montes)</span></a></li>
                            <li><a href="/c/pais/espanha">Tilia <span>(Bodegas Esmeralda)</span></a></li>
                            <li><a href="/c/pais/italia">Laura Catena</a></li>
                            <li><a href="/c/pais/franca">Terra Andina</a></li>
                            <li><a href="/c/pais/portugal">Viña Tondonia</a></li>
                        </ul>
                    </div>

                    <div class="division">
                        <ul class="list-sub-menu">
                            <li><a href="/c/pais/chile">Niepoort</a></li>
                            <li><a href="/c/pais/argentina">Piccini</a></li>
                            <li><a href="/c/pais/espanha">Monte da Ravasqueira</a></li>
                            <li><a href="/c/pais/italia">Ogier</a></li>
                            <li><a href="/c/pais/franca">CVNE</a></li>
                            <li><a href="/c/pais/portugal">Massaria Trajone</a></li>
                        </ul>
                    </div>

                    <div class="division">
                        <a href="/regioes-produtoras-de-vinhos">
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
                            <li><a href="/c/pais/chile">Tintos</a></li>
                            <li><a href="/c/pais/argentina">Brancos</a></li>
                            <li><a href="/c/pais/espanha">Rosados</span></a></li>
                            <li><a href="/c/pais/italia">Champagne e Espumantes</a></li>
                            <li><a href="/c/pais/franca">Porto</a></li>
                            <li><a href="/c/pais/portugal">Sobremessa</a></li>
                        </ul>
                    </div>

                    <div class="division">
                        <div class="featured-wrap">
                        <h2 class="title-menu">Tinto</h2>
                            <div class="featured-sub-menu">
                                <a href="javascript:void(0);">
                                    <h3>
                                       LUCA PINOT NOIR 2012
                                    </h3>
                                    <p class="wine-card-producer">Luca (Laura Catena)</p>
                                    <p class="featured-sub-descr">Elaborado pela talentosa Laura Catena, este Malbec poderoso e cheio de personalidade ...</p>
                                    <p class="price-card-menu">R$ 183,00</p>
                                </a>
                                <a href="javascript:void(0);" class="bt-default-full template4">Comprar <span class="arrow-link">></span></a>
                            </div>

                        </div>
                    </div>

                    <div class="division">
                        <div class="featured-wrap">
                            <h2 class="title-menu">Champagne e espumantes</h2>
                            <div class="featured-sub-menu">
                                <a href="javascript:void(0);">
                                    <h3>
                                      ESPUMANTE BRUT TALISE
                                    </h3>
                                    <p class="wine-card-producer">Talise</p>
                                    <p class="featured-sub-descr">Elaborado pela talentosa Laura Catena, este Malbec poderoso e cheio de personalidade ...</p>
                                    <p class="price-card-menu">R$ 47,20</p>
                                </a>
                                <a href="javascript:void(0);" class="bt-default-full template4">Comprar <span class="arrow-link">></span></a>
                            </div>

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
                            <li><a href="/c/pais/chile">Malbec</a></li>
                            <li><a href="/c/pais/argentina">Cabernet Sauvignon</span></a></li>
                            <li><a href="/c/pais/espanha">Tempranillo </a></li>
                            <li><a href="/c/pais/italia">Chardonnay</a></li>
                            <li><a href="/c/pais/franca">Carmenère</a></li>
                            <li><a href="/c/pais/portugal">Merlot</a></li>
                        </ul>
                    </div>

                    <div class="division">
                        <ul class="list-sub-menu">
                            <li><a href="/c/pais/chile">Sauvignon Blanc</a></li>
                            <li><a href="/c/pais/argentina">Sangiovese</a></li>
                            <li><a href="/c/pais/espanha">Pinot Noir</a></li>
                            <li><a href="/c/pais/italia">Syrah e Shiraz</a></li>
                            <li><a href="/c/pais/franca">Primitivo</a></li>
                            <li><a href="/c/pais/portugal">Cortes</a></li>
                        </ul>
                    </div>

                    <div class="division">
                        <a href="/regioes-produtoras-de-vinhos">
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
                            <h2 class="title-menu">África do Sul</h2>
                            <div class="featured-sub-menu">
                                <a href="javascript:void(0);">
                                    <h3>
                                      ROBERTSON PINOTAGE 2012 
                                    </h3>
                                    <p class="wine-card-producer">Robertson Winery</p>
                                    <p class="featured-sub-descr">Elaborado pela talentosa Laura Catena, este Malbec poderoso e cheio de personalidade ...</p>
                                        <p class="price-card-menu">R$ 120,20</p>
                                    </a>
                                    <a href="javascript:void(0);" class="bt-default-full template6">Comprar <span class="arrow-link">></span></a>
                                </div>

                            </div>
                        </div>

                        <div class="division">
                            <div class="featured-wrap">
                                <h2 class="title-menu">Chile</h2>
                                <div class="featured-sub-menu">
                                    <a href="javascript:void(0);">
                                        <h3>
                                            KAIKEN TERROIR SERIES CORTE 2013
                                        </h3>
                                        <p class="wine-card-producer">Kaiken</p>
                                        <p class="featured-sub-descr">Elaborado pela talentosa Laura Catena, este Malbec poderoso e cheio de personalidade ...</p>
                                        <p class="price-card-menu">R$ 120,20</p>
                                    </a>
                                    <a href="javascript:void(0);" class="bt-default-full template6">Comprar <span class="arrow-link">></span></a>
                                </div>

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
                        <li><a href="/c/pais/chile">Até R$ 60</a></li>
                            <li><a href="/c/pais/argentina">R$ 60 a R$100</a></li>
                            <li><a href="/c/pais/espanha">R$ 100 a R$ 170</a></li>
                            <li><a href="/c/pais/italia">R$ 170 a R$ 270</a></li>
                            <li><a href="/c/pais/franca">R$ 270 a R$ 500</a></li>
                            <li><a href="/c/pais/portugal">Acima de R$ 500</a></li>
                        </ul>
                    </div>
                    <div class="division">
                        <div class="featured-wrap">
                            <h2 class="title-menu">Até R$ 60</h2>
                            <div class="featured-sub-menu">
                                <a href="javascript:void(0);">
                                    <h3>
                                      ROBERTSON PINOTAGE 2012 
                                    </h3>
                                    <p class="wine-card-producer">Robertson Winery</p>
                                    <p class="featured-sub-descr">Elaborado pela talentosa Laura Catena, este Malbec poderoso e cheio de personalidade ...</p>
                                        <p class="price-card-menu">R$ 120,20</p>
                                    </a>
                                    <a href="javascript:void(0);" class="bt-default-full template7">Comprar <span class="arrow-link">></span></a>
                                </div>

                            </div>
                        </div>

                        <div class="division">
                            <div class="featured-wrap">
                                <h2 class="title-menu">R$ 100 a R$ 170</h2>
                                <div class="featured-sub-menu">
                                    <a href="javascript:void(0);">
                                        <h3>
                                            KAIKEN TERROIR SERIES CORTE 2013
                                        </h3>
                                        <p class="wine-card-producer">Kaiken</p>
                                        <p class="featured-sub-descr">Elaborado pela talentosa Laura Catena, este Malbec poderoso e cheio de personalidade ...</p>
                                        <p class="price-card-menu">R$ 120,20</p>
                                    </a>
                                    <a href="javascript:void(0);" class="bt-default-full template7">Comprar <span class="arrow-link">></span></a>
                                </div>

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
                            <h2 class="title-menu">África do Sul</h2>
                            <div class="featured-sub-menu">
                                <a href="javascript:void(0);">
                                    <h3>
                                      ROBERTSON PINOTAGE 2012 
                                    </h3>
                                    <p class="wine-card-producer">Robertson Winery</p>
                                    <p class="featured-sub-descr">Elaborado pela talentosa Laura Catena, este Malbec poderoso e cheio de personalidade ...</p>
                                        <p class="price-card-menu">R$ 120,20</p>
                                    </a>
                                    <a href="javascript:void(0);" class="bt-default-full template12">Comprar <span class="arrow-link">></span></a>
                                </div>

                            </div>
                        </div>

                        <div class="division">
                            <div class="featured-wrap">
                                <h2 class="title-menu">Chile</h2>
                                <div class="featured-sub-menu">
                                <div class="wrap-seal-card">
                                        <div class="content-seal-card">
                                            <div class="seal-score-card">
                                                <img src="{{ asset_web('images/selo-grande.png') }}" alt="">
                                                <span>92</span>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="javascript:void(0);">
                                        <h3>
                                            KAIKEN TERROIR SERIES CORTE 2013
                                        </h3>
                                        <p class="wine-card-producer">Kaiken</p>
                                        <p class="featured-sub-descr">Elaborado pela talentosa Laura Catena, este Malbec poderoso e cheio de personalidade ...</p>
                                        <p class="price-card-menu">R$ 120,20</p>
                                    </a>
                                    <a href="javascript:void(0);" class="bt-default-full template12">Comprar <span class="arrow-link">></span></a>
                                </div>

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
                                <h2 class="title-menu">Chile</h2>
                                <div class="featured-sub-menu">
                                <div class="wrap-seal-card">
                                        <div class="content-seal-card">
                                            <div class="seal-score-card">
                                                <img src="{{ asset_web('images/selo-grande.png') }}" alt="">
                                                <span>92</span>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="javascript:void(0);">
                                        <h3>
                                            KAIKEN TERROIR SERIES CORTE 2013
                                        </h3>
                                        <p class="wine-card-producer">Kaiken</p>
                                        <p class="featured-sub-descr">Elaborado pela talentosa Laura Catena, este Malbec poderoso e cheio de personalidade ...</p>
                                        <p class="price-card-menu">R$ 120,20</p>
                                    </a>
                                    <a href="javascript:void(0);" class="bt-default-full template9">Comprar <span class="arrow-link">></span></a>
                                </div>

                            </div>
                        </div>

                      <div class="division">
                            <div class="featured-wrap">
                                <h2 class="title-menu">Chile</h2>
                                <div class="featured-sub-menu">
                                <div class="wrap-seal-card">
                                        <div class="content-seal-card">
                                            <div class="seal-score-card">
                                                <img src="{{ asset_web('images/selo-grande.png') }}" alt="">
                                                <span>92</span>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="javascript:void(0);">
                                        <h3>
                                            KAIKEN TERROIR SERIES CORTE 2013
                                        </h3>
                                        <p class="wine-card-producer">Kaiken</p>
                                        <p class="featured-sub-descr">Elaborado pela talentosa Laura Catena, este Malbec poderoso e cheio de personalidade ...</p>
                                        <p class="price-card-menu">R$ 120,20</p>
                                    </a>
                                    <a href="javascript:void(0);" class="bt-default-full template9">Comprar <span class="arrow-link">></span></a>
                                </div>

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




