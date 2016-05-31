<header class="header-main @if(auth('website')->check()) logged-in-user @endif">
    <div class="row relative">
        <input type="checkbox" id="control-nav"/>
        <label for="control-nav" class="control-nav"></label>
        <label for="control-nav" class="control-nav-close"></label>

        <h1 class="logo">
            <a class="logo-vinci sprite-icon" href="/" title="Vinci - Loucos por vinho">Vinci - Loucos por vinho</a>
        </h1>

        <div class="search">
            {!! Form::open(['route' => 'search.index', 'method' => 'GET']) !!}
                <div class="wrap-input-search">
                        <input class="input-search" type="search" name="termo">
                    <div class="results-suggestions">
                        <span class="bt-close-suggestions sprite-icon"></span>
                        <ul class="suggestions-list">
                            <li class="suggestions-item">
                                <a href="" class="suggestions-link">
                                    Anjou <span>Cabernet</span> 2009
                                    <p>Domain Chupin / Argentina</p>
                                </a>
                            </li>
                            <li class="suggestions-item">
                                <a href="" class="suggestions-link">
                                    <span>Cabernet</span> Arquata rosso dellumbria 2004
                                    <p>Adanti / Austrália</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <input class="input-bt-search sprite-icon" type="submit" value="">
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
                            Seja bem vindo, {{ $loggedUser->first_name }}!
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
                        <p class="your-cart">Você tem <span id="cartCount">@{{ cart.count_items }} produtos</span> no carrinho de compras</p>
                        <ul class="lista-add" id="cartItems">
                            <li ng-repeat="item in cart.items">
                                <a href="/produto/vallontano-espumante-brut-vallontano">
                                    <div class="product-add">
                                        <img src="https://mistral2015.s3.amazonaws.com/products/19446/img_s_19446.jpg"
                                             width="20" height="57" class="float-left" alt="" class="info-vinho-bold">
                                        <p class="product-name-cart">@{{ item.name }} <span ng-show="item.producer">(@{{ item.producer }})</span></p>
                                    </div>
                                    <div class="value-product">
                                        <p class="price-wine">@{{ item.sale_price | currency }} <span>@{{ item.quantity }} un.</span></p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <a href="{{ route('cart.index') }}" class="bt-default bt-default-blue float-right">Detalhes do carrinho <span class="arrow-link">></span></a>
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
                                <li><a href="javascript:void(0);">África do Sul</a></li>
                                <li><a href="javascript:void(0);">Alemanha</a></li>
                                <li><a href="javascript:void(0);">Argentina</a></li>
                                <li><a href="javascript:void(0);">Austrália</a></li>
                                <li><a href="javascript:void(0);">Brasil</a></li>
                                <li><a href="javascript:void(0);">Chile</a></li>
                                <li><a href="javascript:void(0);">Espanha</a></li>
                                <li><a href="javascript:void(0);">Estados Unidos</a></li>
                            </ul>
                        </div>
                        <div class="division">
                            <ul class="list-sub-menu">
                                <li><a href="javascript:void(0);">África do Sul</a></li>
                                <li><a href="javascript:void(0);">Alemanha</a></li>
                                <li><a href="javascript:void(0);">Argentina</a></li>
                                <li><a href="javascript:void(0);">Austrália</a></li>
                                <li><a href="javascript:void(0);">Brasil</a></li>
                                <li><a href="javascript:void(0);">Chile</a></li>
                            </ul>
                        </div>
                        <div class="division">
                            <div class="featured-wrap">
                                <h2 class="title-menu">Argentina</h2>
                                <div class="featured-sub-menu">
                                    <a class="link-featured-sub-menu" href="/produto">
                                        <h3>
                                            Cune Crianza 2011 <span>CVNE</span>
                                        </h3>
                                        <p class="featured-sub-descr">Elaborado pela talentosa Laura Catena, este Malbec
                                            poderoso e cheio de personalidade...</p>

                                        <span class="featured-sub-more">Saiba Mais > </span>
                                    </a>
                                </div>

                                <a href="#" class="featured-sub-link mtop5 float-right">Todos os vinhos ></a>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="menu-item larger760 template2">
                    <a class="menu-link" href="javascript:void(0);">
                        Regiões
                    </a>
                    <div class="drop-menu">
                        <div class="division">
                            <div class="featured-wrap">
                                <h2 class="title-menu">Argentina</h2>
                                <div class="featured-sub-menu">
                                    <a class="link-featured-sub-menu" href="/produto">
                                        <h3>
                                            Cune Crianza 2011 <span>CVNE</span>
                                        </h3>
                                        <p class="featured-sub-descr">Elaborado pela talentosa Laura Catena, este Malbec
                                            poderoso e cheio de personalidade...</p>

                                        <span class="featured-sub-more">Saiba Mais > </span>
                                    </a>
                                </div>

                                <a href="#" class="featured-sub-link mtop5 float-right">Todos os vinhos ></a>
                            </div>
                        </div>

                        <div class="division">
                            <div class="featured-wrap">
                                <h2 class="title-menu">Argentina</h2>
                                <div class="featured-sub-menu">
                                    <a class="link-featured-sub-menu" href="/produto">
                                        <h3>
                                            Cune Crianza 2011 <span>CVNE</span>
                                        </h3>
                                        <p class="featured-sub-descr">Elaborado pela talentosa Laura Catena, este Malbec
                                            poderoso e cheio de personalidade...</p>

                                        <span class="featured-sub-more">Saiba Mais > </span>
                                    </a>
                                </div>

                                <a href="#" class="featured-sub-link mtop5 float-right">Todos os vinhos ></a>
                            </div>
                        </div>

                        <div class="division">
                            <a href="#">
                                <div class="every-category">
                                    <h3>Veja todos os vinhos dessa categoria</h3>
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
                            <div class="featured-wrap">
                                <h2 class="title-menu">Argentina</h2>
                                <div class="featured-sub-menu">
                                    <a class="link-featured-sub-menu" href="/produto">
                                        <h3>
                                            Cune Crianza 2011 <span>CVNE</span>
                                        </h3>
                                        <p class="featured-sub-descr">Elaborado pela talentosa Laura Catena, este Malbec
                                            poderoso e cheio de personalidade...</p>

                                        <span class="featured-sub-more">Saiba Mais > </span>
                                    </a>
                                </div>

                                <a href="#" class="featured-sub-link mtop5 float-right">Todos os vinhos ></a>
                            </div>
                        </div>

                        <div class="division">
                            <div class="featured-wrap">
                                <h2 class="title-menu">Argentina</h2>
                                <div class="featured-sub-menu">
                                    <a class="link-featured-sub-menu" href="/produto">
                                        <h3>
                                            Cune Crianza 2011 <span>CVNE</span>
                                        </h3>
                                        <p class="featured-sub-descr">Elaborado pela talentosa Laura Catena, este Malbec
                                            poderoso e cheio de personalidade...</p>

                                        <span class="featured-sub-more">Saiba Mais > </span>
                                    </a>
                                </div>

                                <a href="#" class="featured-sub-link float-right">Todos os vinhos ></a>
                            </div>
                        </div>

                        <div class="division">
                            <ul class="list-sub-menu">
                                <li><a href="javascript:void(0);">África do Sul</a></li>
                                <li><a href="javascript:void(0);">Alemanha</a></li>
                                <li><a href="javascript:void(0);">Argentina</a></li>
                                <li><a href="javascript:void(0);">Austrália</a></li>
                                <li><a href="javascript:void(0);">Brasil</a></li>
                                <li><a href="javascript:void(0);">Chile</a></li>
                            </ul>
                        </div>

                    </div>
                </li>

                <li class="menu-item larger760-right template4">
                    <a class="menu-link" href="javascript:void(0);">
                        Uva
                    </a>
                    <div class="drop-menu">
                        <div class="division">
                            <div class="featured-wrap">
                                <h2 class="title-menu">Argentina</h2>
                                <div class="featured-sub-menu">
                                    <a class="link-featured-sub-menu" href="/produto">
                                        <h3>
                                            Cune Crianza 2011 <span>CVNE</span>
                                        </h3>
                                        <p class="featured-sub-descr">Elaborado pela talentosa Laura Catena, este Malbec
                                            poderoso e cheio de personalidade...</p>

                                        <span class="featured-sub-more">Saiba Mais > </span>
                                    </a>
                                </div>

                                <a href="#" class="featured-sub-link mtop5 float-right">Todos os vinhos ></a>
                            </div>
                        </div>

                        <div class="division">
                            <div class="featured-wrap">
                                <h2 class="title-menu">Argentina</h2>
                                <div class="featured-sub-menu">
                                    <a class="link-featured-sub-menu" href="/produto">
                                        <h3>
                                            Cune Crianza 2011 <span>CVNE</span>
                                        </h3>
                                        <p class="featured-sub-descr">Elaborado pela talentosa Laura Catena, este Malbec
                                            poderoso e cheio de personalidade...</p>

                                        <span class="featured-sub-more">Saiba Mais > </span>
                                    </a>
                                </div>

                                <a href="#" class="featured-sub-link mtop5 float-right">Todos os vinhos ></a>
                            </div>
                        </div>

                        <div class="division">
                            <a href="#">
                                <div class="every-category">
                                    <h3>Veja todos os vinhos dessa categoria</h3>
                                    <span>></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </li>

                <li class="menu-item larger760-right template5">
                    <a class="menu-link" href="javascript:void(0);">
                        Bons e baratos
                    </a>
                    <div class="drop-menu">
                        <div class="division">
                            <div class="featured-wrap">
                                <h2 class="title-menu">Argentina</h2>
                                <div class="featured-sub-menu">
                                    <a class="link-featured-sub-menu" href="/produto">
                                        <h3>
                                            Cune Crianza 2011 <span>CVNE</span>
                                        </h3>
                                        <p class="featured-sub-descr">Elaborado pela talentosa Laura Catena, este Malbec
                                            poderoso e cheio de personalidade...</p>

                                        <span class="featured-sub-more">Saiba Mais > </span>
                                    </a>
                                </div>

                                <a href="#" class="featured-sub-link mtop5 float-right">Todos os vinhos ></a>
                            </div>
                        </div>

                        <div class="division">
                            <div class="featured-wrap">
                                <h2 class="title-menu">Argentina</h2>
                                <div class="featured-sub-menu">
                                    <a class="link-featured-sub-menu" href="/produto">
                                        <h3>
                                            Cune Crianza 2011 <span>CVNE</span>
                                        </h3>
                                        <p class="featured-sub-descr">Elaborado pela talentosa Laura Catena, este Malbec
                                            poderoso e cheio de personalidade...</p>

                                        <span class="featured-sub-more">Saiba Mais > </span>
                                    </a>
                                </div>

                                <a href="#" class="featured-sub-link mtop5 float-right">Todos os vinhos ></a>
                            </div>
                        </div>

                        <div class="division">
                            <a href="#">
                                <div class="every-category">
                                    <h3>Veja todos os vinhos dessa categoria</h3>
                                    <span>></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </li>

                <li class="menu-item larger760-right template6">
                    <a class="menu-link" href="javascript:void(0);">
                        Vinhos Pontuados
                    </a>
                    <div class="drop-menu">
                        <div class="division">
                            <div class="featured-wrap">
                                <h2 class="title-menu">Argentina</h2>
                                <div class="featured-sub-menu">
                                    <a class="link-featured-sub-menu" href="/produto">
                                        <h3>
                                            Cune Crianza 2011 <span>CVNE</span>
                                        </h3>
                                        <p class="featured-sub-descr">Elaborado pela talentosa Laura Catena, este Malbec
                                            poderoso e cheio de personalidade...</p>

                                        <span class="featured-sub-more">Saiba Mais > </span>
                                    </a>
                                </div>

                                <a href="#" class="featured-sub-link mtop5 float-right">Todos os vinhos ></a>
                            </div>
                        </div>

                        <div class="division">
                            <div class="featured-wrap">
                                <h2 class="title-menu">Argentina</h2>
                                <div class="featured-sub-menu">
                                    <a class="link-featured-sub-menu" href="/produto">
                                        <h3>
                                            Cune Crianza 2011 <span>CVNE</span>
                                        </h3>
                                        <p class="featured-sub-descr">Elaborado pela talentosa Laura Catena, este Malbec
                                            poderoso e cheio de personalidade...</p>

                                        <span class="featured-sub-more">Saiba Mais > </span>
                                    </a>
                                </div>

                                <a href="#" class="featured-sub-link mtop5 float-right">Todos os vinhos ></a>
                            </div>
                        </div>

                        <div class="division">
                            <a href="#">
                                <div class="every-category">
                                    <h3>Veja todos os vinhos dessa categoria</h3>
                                    <span>></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </li>

                <li class="menu-item larger760-right template7">
                    <a class="menu-link" href="javascript:void(0);">
                        Especiais
                    </a>
                    <div class="drop-menu">
                        <div class="division">
                            <div class="featured-wrap">
                                <h2 class="title-menu">Argentina</h2>
                                <div class="featured-sub-menu">
                                    <a class="link-featured-sub-menu" href="/produto">
                                        <h3>
                                            Cune Crianza 2011 <span>CVNE</span>
                                        </h3>
                                        <p class="featured-sub-descr">Elaborado pela talentosa Laura Catena, este Malbec
                                            poderoso e cheio de personalidade...</p>

                                        <span class="featured-sub-more">Saiba Mais > </span>
                                    </a>
                                </div>

                                <a href="#" class="featured-sub-link mtop5 float-right">Todos os vinhos ></a>
                            </div>
                        </div>

                        <div class="division">
                            <div class="featured-wrap">
                                <h2 class="title-menu">Argentina</h2>
                                <div class="featured-sub-menu">
                                    <a class="link-featured-sub-menu" href="/produto">
                                        <h3>
                                            Cune Crianza 2011 <span>CVNE</span>
                                        </h3>
                                        <p class="featured-sub-descr">Elaborado pela talentosa Laura Catena, este Malbec
                                            poderoso e cheio de personalidade...</p>

                                        <span class="featured-sub-more">Saiba Mais > </span>
                                    </a>
                                </div>

                                <a href="#" class="featured-sub-link mtop5 float-right">Todos os vinhos ></a>
                            </div>
                        </div>

                        <div class="division">
                            <a href="#">
                                <div class="every-category">
                                    <h3>Veja todos os vinhos dessa categoria</h3>
                                    <span>></span>
                                </div>
                            </a>
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

            <ul class="menu">

                <li class="menu-item">
                    <span class="name-log-mobile">Logado como Wellington</span>
                    <a class="menu-link" href="{{ route('logout') }}">
                        Sair
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>

@include('website::layouts.modals.login.default')
@include('website::layouts.modals.login.password.recovery.default')

<div class="overlay"></div>




