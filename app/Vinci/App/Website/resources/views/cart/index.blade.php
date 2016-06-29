@extends('website::layouts.master')

@section('content')

    <div ng-controller="CartController as ctrl">

        <div class="header-internal template1-bg">
            @include('website::layouts.menu')
            <div class="row">

                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a class="breadcrumb-link" href="{{ route('index') }}"><span>Início</span></a> >
                    </li>
                    <li class="breadcrumb-item">
                        <span>Carrinho</span>
                    </li>
                </ul>

                <h1 class="internal-subtitle">Meu Carrinho</h1>
            </div>
        </div>

        <div class="row">

            <h2 id="emptyCartMessage" style="text-align: center; display: none;">Não há produtos em seu carrinho.</h2>

            <img src="{{ asset_web('images/loading.gif') }}" alt="Carregando..." class="loading_gif">

            <div class="cart-content ng-hide" ng-show="ctrl.hasItems()">

                <div class="wrap-content-bt mbottom20">
                    <div class="content-bt-middle">
                        <a class="bt-default-full bt-middle bt-color" href="{{ route('checkout.delivery.index') }}">Finalizar Compra <span class="arrow-link">&gt;</span></a>
                    </div>
                </div>

                <section class="wrap-cart">

                    <div class="row-item-cart template1 show-desktop">

                        <div class="col-cart1">
                            <div class="col-product-cart">PRODUTOS</div>
                            <div class="col-price-cart">PREÇO</div>
                            <div class="col-cart2 hide-tablet">QUANTIDADE</div>
                        </div>

                        <div class="col-cart3">SUBTOTAL</div>
                    </div>

                    <article cart-item="@{{ item.id }}" class="row-item-cart template1" ng-repeat="item in ctrl.cart.items">
                        <div class="col-cart1">
                            <div class="col-product-cart">
                                <div class="thumb-wine">
                                    <a href="@{{ item.web_path }}">
                                        <img class="wine-bottle" src="@{{ item.image_url }}" alt="Vinho">
                                    </a>
                                </div>
                                <div class="colum-description-cart">
                                    <h3 class="title-card-wine">
                                        @{{ item.name }}
                                        <span ng-show="item.producer">@{{ item.producer }}</span>
                                    </h3>
                                    <a class="link-cart gift" href="javascript:void(0);">
                                        Embalagem para presente >
                                    </a>
                                </div>
                            </div>
                            <div class="col-price-cart">
                                <p class="in" ng-show="item.original_orice"> De <span>R$ @{{ item.original_price | currency }}</span></p>
                                <p class="wine-price">
                                    @{{ item.sale_price | currency }}
                                </p>
                            </div>
                            <div class="col-cart2" ng-init="quantity = item.quantity">
                                <div class="botoes-add">
                                    <a href="javascript:void(0);" class="bt-remove" ng-click="decrementQuantity()">-</a>
                                    <input type="text" class="input-quantity txtQuantity" value="@{{ item.quantity }}" ng-model="quantity" ng-blur="syncQuantity()">
                                    <a href="javascript:void(0);" class="bt-add" ng-click="incrementQuantity()">+</a>
                                </div>
                                <a class="link-cart remove-product-cart" href="javascript:void(0);" ng-click="removeItem()">Remover ></a>
                            </div>
                        </div>
                        <div class="col-cart3 show-desktop">
                            <h3 class="current-price">
                                @{{ item.subtotal | currency }}
                            </h3>
                        </div>
                    </article>

                    <ul class="valor-total-carrinho float-right">

                        {{--<li>--}}
                        {{--<article class="wrap-compra-dados-venda">--}}
                        {{--<span>Desconto</span>--}}
                        {{--<div class="container-info-compra">--}}
                        {{--<p class="price-cart" id="pgCartSubtotal">R$ 27,50</p>--}}
                        {{--</div>--}}
                        {{--</article>--}}
                        {{--</li>--}}

                        <li>
                            <article class="wrap-compra-dados-venda">
                                <span>Subtotal</span>
                                <div class="container-info-compra">
                                    <p class="price-cart" id="pgCartSubtotal">@{{ ctrl.cart.subtotal | currency }}</p>
                                </div>
                            </article>
                        </li>

                        <li>
                            <article class="wrap-compra-dados-venda">
                                <span>Digite o CEP</span>
                                <div class="container-info-compra">
                                    <input type="text" class="cep" ng-model="$root.postalCode" maxlength="8" id="txtPostalCode">
                                    <button type="button" ng-click="ctrl.getShipping()" class="btn-submit">OK ></button>
                                </div>
                            </article>
                            <p class="cep-invalido" id="cepInvalido" style="display:none;">CEP inválido!</p>
                        </li>

                        <li id="shipping-info ng-hide" ng-show="ctrl.cart.shipping.price">
                            <article class="wrap-compra-dados-venda">
                                <span>Frete @{{ ctrl.cart.shipping.price }}</span>
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
                                    <select name="" id="" class="select-standard" style="">
                                        <option value="">convencional</option>
                                    </select>
                                </div>
                                <div class="container-info-remover">
                                    <a href="javascript:void(0);" class="remover-carrinho" id="removeShipping" ng-click="ctrl.removeShipping()">remover</a>
                                </div>
                            </article>
                        </li>
                        <li>
                            <article class="wrap-compra-dados-venda">
                                <span>Total</span>
                                <div class="container-info-compra">
                                    <p class="current-price" id="pgCartTotal">@{{ cart.total | currency }}</p>
                                </div>
                            </article>
                        </li>
                    </ul>

                    <div class="wrap-content-bt">
                        <div class="box-two-links">

                            <a class="keep-buying" href="{{ route('index') }}">Continuar comprando ></a>

                            <div class="content-bt-middle">
                                <a class="bt-default-full bt-middle bt-color" href="{{ route('checkout.delivery.index') }}">Finalizar Compra <span class="arrow-link">&gt;</span></a>
                            </div>
                        </div>
                    </div>

                </section>

            </div>

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
                        <p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para
                            ...</p>
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
                        <p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para
                            ...</p>
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
                        <p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para
                            ...</p>
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
                        <p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para
                            ...</p>
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
    @include('website::layouts.modals.gift-packaging.default')
    </div>
    
    @include('website::layouts.footer')

@stop