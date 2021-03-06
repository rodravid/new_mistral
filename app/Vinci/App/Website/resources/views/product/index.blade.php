@extends('website::layouts.master')

@section('title', $product->title . ' | Vinci Loucos por Vinhos')
@section('description', $product->seo()->description())

@section('content')
    <div class="page-product-wrapper" ng-controller="ProductPageController as ctrl">
        <div class="header-internal {{ $product->template_css }}-bg">
            @include('website::layouts.menu')
            <div class="row">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a class="breadcrumb-link" href="/"><span>Início</span></a> >
                    </li>

                    @if($product->hasCountry())
                        <li class="breadcrumb-item">
                            <a class="breadcrumb-link" href="{{ $product->country->web_url }}"><span>{{ $product->country->name }}</span></a> >
                        </li>
                    @endif

                    @if($product->hasRegion())
                        <li class="breadcrumb-item">
                            <a class="breadcrumb-link" href="{{ $product->region->web_url }}"><span>{{ $product->region->name }}</span></a> >
                        </li>
                    @endif

                    @if($product->hasProducer())
                        <li class="breadcrumb-item">
                            <a class="breadcrumb-link" href="{{ $product->producer->web_url }}"><span>{{ $product->producer->name }}</span></a> >
                        </li>
                    @endif

                    <li class="breadcrumb-item">
                        <span>{{ $product->title }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="bg-product {{ $product->template_css }}"></div>

        <div class="row relative">

            <section class="wrap-content-product {{ $product->template_css }}">

                <div class="col-product-one">
                    <div class="height-bg-product">
                        <favorite-widget product="{{ $product->id }}"
                                         favorited="@isProductFavorited($product->id)"></favorite-widget>

                        <h1 class="tit-product show-desktop">{{ $product->title }}</h1>
                        @if($product->hasProducer())
                            <span class="tit-product-producer show-desktop">{{ $product->producer->name }}</span>
                        @endif

                        <p class="cod-product show-desktop">Cód {{ $product->sku }}</p>

                        @if($product->hasShortDescription())
                            <h2 class="tit-product-info show-desktop">{!! $product->short_description !!}</h2>
                        @endif

                    </div>

                    <ul class="details-wine show-desktop">

                        @if($product->hasProducer())
                            <li>
                                <ul>
                                    <li><p class="item-info-wine">Produtor</p></li>
                                    <li><a href="{{ $product->producer->getWebUrl() }}"><p
                                                    class="info-vinho-template">{{ $product->producer->name }}</p></a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if($product->hasCountry())
                            <li>
                                <ul>
                                    <li><p class="item-info-wine">País</p></li>
                                    <li><a href="{{ $product->country->getWebUrl() }}"><p
                                                    class="info-vinho-template">{{ $product->country->name }}</p></a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if($product->hasRegion())
                            <li>
                                <ul>
                                    <li><p class="item-info-wine">Região</p></li>
                                    <li><a href="{{ $product->region->getWebUrl() }}"><p
                                                    class="info-vinho-template">{{ $product->region->name }}</p></a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if($product->hasProductType())
                            <li>
                                <ul>
                                    <li><p class="item-info-wine">Tipo</p></li>
                                    <li><a href="{{ $product->productType->getWebUrl() }}"><p class="info-vinho-template">{{ $product->productType->name }}</p></a></li>
                                </ul>
                            </li>
                        @endif

                        @if($product->isWine() && $product->hasMainGrapeContent())
                            <li>
                                <ul>
                                    <li><p class="item-info-wine">Uva</p></li>
                                    <li><a href="{{ $product->getMainGrapeContent()->getGrape()->getWebUrl() }}"><p class="info-vinho-template">{{ $product->getMainGrapeContent()->getGrape()->name }}</p></a></li>
                                </ul>
                            </li>
                        @endif

                        <?php
                        $i = 1;
                        $div = false;
                        ?>
                        @foreach($product->getAttributesSorted() as $attribute)

                            @if (! empty($attribute->getValue()))

                                @if ($i == 5)
                                    <?php $div = true;?>
                                    <div class="rule-details-wine">
                                        @endif

                                        <li>
                                            <ul>
                                                <li>
                                                    <p class="item-info-wine">{{ $attribute->getAttribute()->getName() }}</p>
                                                </li>
                                                <li><p class="">{{ $attribute->getValue() }}</p></li>
                                            </ul>
                                        </li>
                                        <?php $i++;?>

                                        @endif

                                        @endforeach

                                        @if($div == true)
                                    </div>
                                    <a href="javascript:void(0);" class="see-more-info"> Veja mais</a>
                                @endif

                    </ul>

                </div>

                <div class="col-product-two">
                    <div class="show-mobile">
                        <favorite-widget product="{{ $product->id }}" favorited="@isProductFavorited($product->id)"></favorite-widget>
                        <h1 class="tit-product">{{ $product->title }}</h1>
                        @if($product->hasProducer())
                            <span class="tit-product-producer">{{ $product->producer->name }}</span>
                        @endif

                        <p class="cod-product">Cód {{ $product->sku }}</p>

                        @if($product->hasShortDescription())
                            <h2 class="tit-product-info">{!! $product->short_description !!}</h2>
                        @endif

                    </div>

                    <div class="content-img-product">
                        <img src="{{ $product->image_url }}" class="img-product" alt="{{ $product->title }}">
                        @if($scores = $product->getHighlightedScores())
                            <div class="wrap-content-seal">
                                @foreach($scores as $score)
                                    <div class="wrap-seal-product">
                                        <div class="content-seal-product">
                                            <div class="seal-score">
                                                {!! $score->seal_img !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-product-tree">

                    @if($product->isAvailable())
                        <div class="wrap-price-units">

                            <div class="box-price-units">
                                {!! $product->original_sale_price_html !!}
                                <h3 class="current-price">
                                    {{ $product->sale_price }}
                                </h3>
                                <div class="wrap-add" ng-init="ctrl.itemQuantity = 1">
                                    <span>GARRAFA</span>
                                    <div class="botoes-add">
                                        <a id="remover-unidade" class="bt-remove" href="javascript:void(0);"
                                           ng-click="ctrl.decrementItemQuantity()">-</a>
                                        <input type="text" id="mudarUnidade" class="input-quantity" value="1"
                                               ng-model="ctrl.itemQuantity" ng-blur="ctrl.updateItemQuantity()">
                                        <a id="add-unidade" href="javascript:void(0);" class="bt-add"
                                           ng-click="ctrl.incrementItemQuantity()">+</a>
                                    </div>
                                </div>

                                @if (! empty($product->getPackSize()))
                                    <div class="wrap-add"
                                         ng-init="ctrl.boxQuantity = 0; ctrl.boxQuantityFactor = {{ $product->getPackSize() }}">
                                        <span>CAIXA <br> ({{ $product->getPackSize() }} garrafas)</span>
                                        <div class="botoes-add">
                                            <a id="remover-unidade" class="bt-remove" href="javascript:void(0);"
                                               ng-click="ctrl.decrementBoxQuantity()">-</a>
                                            <input type="text" id="mudarUnidadePacote" class="input-quantity" value="0"
                                                   ng-model="ctrl.boxQuantity" ng-blur="ctrl.updateBoxQuantity()" packSize="{{ $product->getPackSize() }}">
                                            <a id="add-unidade" href="javascript:void(0);" class="bt-add"
                                               ng-click="ctrl.incrementBoxQuantity()">+</a>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <button type="button" class="bt-default-full-template bt-big template-button" style="cursor:pointer;" cart-add-button
                               variant-id="{{ $product->getMasterVariant()->getId() }}"
                               quantity-resolver="ctrl.getQuantityForCart()">Comprar <span
                                        class="arrow-link">></span></button>

                            <div class="content-term-delivery show-desktop">
                                <a href="javascript:void(0);">
                                    Prazo de entrega >
                                </a>
                            </div>
                        </div>

                    @else

                        <div class="wrap-product-unavailable">
                            <div class="content-unavailable">
                                <p>
                                    Produto temporariamente indisponivel no estoque.
                                </p>
                                <p>
                                    Me avise quando houver disponibilidade atráves do e-mail
                                </p>

                                <form action="{{ route('product.register') }}" method="POST">
                                    {!! Form::hidden('product', $product->getId()) !!}
                                    {!! Form::email('customer_email', null, ['class' => 'email input-register full mbottom10 mtop10 ' . ($errors->has('email') ? 'error-field' : '')]) !!}
                                    @if($errors->count())
                                        <p class="error-email mbottom10"><b>{{ $errors->first() }}</b></p>
                                    @endif

                                    <div class="receive-offers mbottom10">
                                        {!! Form::checkbox('allowSimilarNotifications', true, true) !!}
                                        <span>Deseja receber ofertas de produtos similares?</span>
                                    </div>

                                    <button type="submit" class="bt-default-full-template bt-big template-button">
                                        Enviar <span class="arrow-link">></span>
                                    </button>

                                </form>
                            </div>
                        </div>
                    @endif

                    <ul class="details-wine show-mobile">

                        @if($product->hasProducer())
                            <li>
                                <ul>
                                    <li><p class="item-info-wine">Produtor</p></li>
                                    <li><a href="{{ $product->producer->getWebUrl() }}"><p
                                                    class="info-vinho-template">{{ $product->producer->name }}</p></a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if($product->hasCountry())
                            <li>
                                <ul>
                                    <li><p class="item-info-wine">País</p></li>
                                    <li><a href="{{ $product->country->getWebUrl() }}"><p
                                                    class="info-vinho-template">{{ $product->country->name }}</p></a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if($product->hasRegion())
                            <li>
                                <ul>
                                    <li><p class="item-info-wine">Região</p></li>
                                    <li><a href="{{ $product->region->getWebUrl() }}"><p
                                                    class="info-vinho-template">{{ $product->region->name }}</p></a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if($product->hasProductType())
                            <li>
                                <ul>
                                    <li><p class="item-info-wine">Tipo</p></li>
                                    <li><a href="{{ $product->productType->getWebUrl() }}"><p
                                                    class="info-vinho-template">{{ $product->productType->name }}</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        <?php
                            $i = 1;
                            $div = false;
                        ?>
                        @foreach($product->getAttributesSorted() as $attribute)

                            @if (! empty($attribute->getValue()))

                                @if ($i == 5)
                                    <?php $div = true;?>
                                    <div class="rule-details-wine">
                                        @endif

                                        <li>
                                            <ul>
                                                <li>
                                                    <p class="item-info-wine">{{ $attribute->getAttribute()->getName() }}</p>
                                                </li>
                                                <li><p class="">{{ $attribute->getValue() }}</p></li>
                                            </ul>
                                        </li>
                                        <?php $i++;?>

                                        @endif

                                        @endforeach

                                        @if($div == true)
                                    </div>
                                    <a href="javascript:void(0);" class="see-more-info"> Veja mais</a>
                                @endif


                    </ul>


                    <div class="flex-col-product-tree">

                        @if($product->isType('wine') && $product->hasScores())
                            <div class="invert-mobile1">
                                <ul class="seals-description">
                                    @foreach($product->scores as $score)
                                        <li>
                                            <p class="name-seals-description">{{ $score->featured_text }}</p>
                                            <div>
                                                {!! $score->description !!}
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if($product->hasDescription())
                            <div class="invert-mobile2">
                                <p class="item-info-wine uppercase description-toogle">Descritivo</p>
                                <span>{!! $product->description !!}</span>
                            </div>
                        @endif

                    </div>

                </div>

            </section>

            <section class="also-recommend featured-products">

                @if($productsRecommended->count())
                    <h2 class="title-category mbottom20">Também recomendamos</h2>
                    @foreach($productsRecommended as $key => $product)
                        <div class="cols-products bg-template {{ $templates[$key] }}">
                            @include('website::layouts.partials.product.cards.default', ['product' => $product])
                        </div>
                    @endforeach
                @endif

            </section>
            @include('website::layouts.partials.featuredweek')
            @include('website::layouts.modals.delivery-time.default')
        </div>
    </div>

    @include('website::layouts.footer')

@stop
