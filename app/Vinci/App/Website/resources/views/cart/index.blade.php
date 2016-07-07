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

        <div class="row relative">

            <h2 id="emptyCartMessage" style="text-align: center; display: none;">Não há produtos em seu carrinho.</h2>

            <div id="loading-container" class="loading-container-cart"><img src="{{ asset_web('images/loading.gif') }}" alt="Carregando..." class="loading_gif"></div>

            <div class="alert-purchase alert-red ng-hide" ng-show="ctrl.isInvalid()">
                <p class="alert-msg">Sua compra não pode ser processada. Os produtos no carrinho, estão indisponíveis no momento.</p>
            </div>

            <div class="alert-purchase alert-yellow ng-hide" ng-show="ctrl.cart.valid_items_count != ctrl.cart.count_items && ctrl.cart.valid_items_count != 0">
                <span >Importante</span>
                <p class="alert-msg">Há produtos indisponíveis no momento, em seu carrinho. Estes itens serão automaticamente removidos ao finalizar seu pedido.</p>
            </div>

            <div class="cart-content ng-hide" ng-show="ctrl.hasItems()">

                <div class="wrap-content-bt mbottom20" ng-hide="ctrl.isInvalid()">
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
                                    <a class="link-cart gift" href="javascript:void(0);" ng-hide="item.is_gift_package">
                                        Embalagem para presente >
                                    </a>
                                </div>
                            </div>
                            <div class="col-price-cart">
                                <p class="in" ng-show="item.original_orice"> De <span>R$ @{{ item.original_price | currency }}</span></p>
                                <p class="wine-price">
                                    @{{ item.sale_price | currency }}
                                </p>
                                <p class="unavailable" ng-show="! item.is_stock_available">Indisponível</p>
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
                                    <input type="text" class="cep" ng-model="$root.postalCode" maxlength="9" id="txtPostalCode" ui-br-cep-mask>
                                    <button type="button" ng-click="ctrl.getShipping()" class="btn-submit">OK ></button>
                                </div>
                            </article>
                            <p class="cep-invalido" id="cepInvalido" style="display:none;">CEP inválido!</p>
                        </li>

                        <li id="shipping-info ng-hide" ng-show="ctrl.cart.shipping.price">
                            <article class="wrap-compra-dados-venda">
                                
                                <div class="container-info-compra">
                                    <span>Frete @{{ ctrl.cart.shipping.price }}</span>
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
                            <div class="content-bt-middle" ng-hide="ctrl.isInvalid()">
                                <a class="bt-default-full bt-middle bt-color" href="{{ route('checkout.delivery.index') }}">Finalizar Compra <span class="arrow-link">&gt;</span></a>
                            </div>
                            <a class="keep-buying" href="{{ route('index') }}">Continuar comprando ></a>
                        </div>
                    </div>

                </section>
            </div>

            <section class="also-recommend featured-products hide-tablet">
                    <h2 class="title-category mbottom20">Também recomendamos</h2>
                    @foreach($productsRecommended as $key => $product)
                        <div class="cols-products {{ $templates[$key] }}">
                            @include('website::layouts.partials.product.cards.default', ['product' => $product])
                        </div>
                    @endforeach

            </section>

        </div>
        @include('website::layouts.modals.gift-packaging.default')
    </div>
    
    @include('website::layouts.footer')

@stop