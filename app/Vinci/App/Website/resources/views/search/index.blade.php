@extends('website::layouts.master')


@section('content')
    <div class="header-internal template1-bg">
        @include('website::layouts.menu')
        <div class="row">
            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a class="breadcrumb-link" href="/"><span>Início</span></a> >
                </li>
                <li class="breadcrumb-item">
                    <span>Resultado de busca</span> >
                </li>
                <li class="breadcrumb-item">
                    <span>{{ $result->getTerm() }}</span>
                </li>
            </ul>
            <span class="internal-subtitle">Resultado de busca</span>

            <h1 class="search-item">{{ $result->getTerm() }}</h1>
        </div>
    </div>

    <div class="row">
        @if($result->hasItems())
            <article class="wrap-content-search">

                <div class="search-column opacidade-coluna1">

                    <h3 class="title-filter">Palavra Buscada</h3>
                    <ul class="filter-search">
                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">{{ $result->getTerm() }}</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">X</a>
                                </li>
                            </ul>
                        </li>

                    </ul>

                    <h3 class="title-filter">País</h3>
                    <ul class="filter-search">
                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">23</a>
                                </li>
                            </ul>
                        </li>
                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">23</a>
                                </li>
                            </ul>
                        </li>

                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">23</a>
                                </li>
                            </ul>
                        </li>

                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">23</a>
                                </li>
                            </ul>
                        </li>

                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">23</a>
                                </li>
                            </ul>
                        </li>

                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França le baois frete da paroo gui</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">23</a>
                                </li>
                            </ul>
                        </li>

                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">213</a>
                                </li>
                            </ul>
                        </li>

                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">23</a>
                                </li>
                            </ul>
                        </li>

                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">23</a>
                                </li>
                            </ul>
                        </li>

                        <span class="see-more-filter">+ veja mais</span>
                    </ul>

                    <h3 class="title-filter">País</h3>
                    <ul class="filter-search">
                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">23</a>
                                </li>
                            </ul>
                        </li>
                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">23</a>
                                </li>
                            </ul>
                        </li>

                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">23</a>
                                </li>
                            </ul>
                        </li>

                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">23</a>
                                </li>
                            </ul>
                        </li>

                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">23</a>
                                </li>
                            </ul>
                        </li>

                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França le baois frete da paroo gui</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">23</a>
                                </li>
                            </ul>
                        </li>

                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">213</a>
                                </li>
                            </ul>
                        </li>

                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">23</a>
                                </li>
                            </ul>
                        </li>

                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">23</a>
                                </li>
                            </ul>
                        </li>

                        <span class="see-more-filter">+ veja mais</span>
                    </ul>

                    <h3 class="title-filter">País</h3>
                    <ul class="filter-search">
                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">23</a>
                                </li>
                            </ul>
                        </li>
                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">23</a>
                                </li>
                            </ul>
                        </li>

                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">23</a>
                                </li>
                            </ul>
                        </li>

                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">23</a>
                                </li>
                            </ul>
                        </li>

                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">23</a>
                                </li>
                            </ul>
                        </li>

                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França le baois frete da paroo gui</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">23</a>
                                </li>
                            </ul>
                        </li>

                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">213</a>
                                </li>
                            </ul>
                        </li>

                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">23</a>
                                </li>
                            </ul>
                        </li>

                        <li class="filter-search-item">
                            <ul class="subitem-filter-search">
                                <li>
                                    <a href="javascript:void(0);">França</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">23</a>
                                </li>
                            </ul>
                        </li>

                        <span class="see-more-filter">+ veja mais</span>
                    </ul>

                </div>

                <div class="column-products-search-inline template1">


                    <header class="header-content-internal">

                        <span class="total-products show-mobile">1- 15 de {{ $result->getTotal() }} produtos</span>


                        <div class="display-filter float-right">
                            <span>Ordernar por</span>
                            <div class="select-standard form-control-white float-right select-widthfull">
                                <select name="" id="">
                                    <option value="">Relevância</option>
                                    <option value="">Menor preço</option>
                                    <option value="">Maior preço</option>
                                    <option value="">Ordem Alfabética (A-Z)</option>
                                    <option value="">Ordem Alfabética (Z-A)</option>
                                </select>
                            </div>
                        </div>

                        <div class="display-filter float-left">
                            <span>Itens por página</span>
                            <div class="select-standard form-control-white float-right select-widthfull">
                                <select name="" id="">
                                    <option value="">15</option>
                                    <option value="">30</option>
                                    <option value="">45</option>
                                </select>
                            </div>
                        </div>

                        <a class="filtro-mobile show-mobile" href="javascript:void(0);">Filtro<span>></span></a>

                        <ul class="filter-search show-mobile">
                            <li class="filter-search-item">
                                <ul class="subitem-filter-search">
                                    <li>
                                        <a href="javascript:void(0);">Cabernet</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">X</a>
                                    </li>
                                </ul>
                            </li>

                        </ul>

                        <div class="wrap-pagination">

                            <div class="container-total-products">
                                <span class="total-products show-desktop">1 - 15 de {{ $result->getTotal() }} produtos</span>
                            </div>

                            <ul class="pagination">
                                <li>
                                    <a href="javascript:void(0);" class="selected">1</a>
                                </li>
                                <li>
                                    <a href="">2</a>
                                </li>
                                <li>
                                    <a href="">3</a>
                                </li>
                                <li>
                                    <a href="">4</a>
                                </li>
                                <li>
                                    <a href="">5</a>
                                </li>
                                <li>
                                    <a href="">></a>
                                </li>
                            </ul>

                        </div>

                    </header>

                    @foreach($result->getItems() as $product)

                        <div class="wine-card">
                            <div class="thumb-wine">
                                <a href="javascript:void(0);">
                                    <img class="wine-bottle" src="{{ asset_web('images/no_photo.jpg') }}" alt="Vinho">
                                </a>
                            </div>
                            <div class="colum-description-wine">
                                <h3 class="title-card-wine">
                                    <a href="javascript:void(0);">
                                        {{ $product->title }}
                                        @if($product->hasProducer())
                                            <span>{{ $product->producer->name }}</span>
                                        @endif
                                    </a>
                                    <span class="favorite"></span>
                                </h3>
                                <a href="javascript:void(0);">
                                    <p class="wine-intro">{{ $product->short_description }}</p>
                                    <p class="info-details-wine">Tinto Pinot</p>
                                    <p class="info-details-wine">Noir Chile</p>
                                </a>
                            </div>
                            <div class="other-wine-info">

                                {{--<p class="in"> De <span>R$ 38,50</span></p>--}}
                                <p class="wine-price">{{ $product->sale_price }}</p>

                                <a href="javascript:void(0);" class="bt-default" cart-add-button variant-id="{{ $product->getMasterVariant()->getId() }}" quantity="1">Comprar <span class="arrow-link">></span></a>
                            </div>
                        </div>

                    @endforeach

                    <div class="wrap-pagination">

                        <div class="container-total-products">
                            <span class="total-products show-desktop">1 - 15 de {{ $result->getTotal() }} produtos</span>
                        </div>

                        <ul class="pagination">
                            <li>
                                <a href="javascript:void(0);" class="selected">1</a>
                            </li>
                            <li>
                                <a href="">2</a>
                            </li>
                            <li>
                                <a href="">3</a>
                            </li>
                            <li>
                                <a href="">4</a>
                            </li>
                            <li>
                                <a href="">5</a>
                            </li>
                            <li>
                                <a href="">></a>
                            </li>
                        </ul>

                    </div>
                </div>


            </article>
            @include('website::layouts.partials.featuredweek')
        @else

            <div style="text-align: center;">
                <h2>Nenhum resultado encontrado.</h2>
            </div>

        @endif
    </div>

    <div class="bg-layer-filtro"></div>

    @include('website::layouts.footer')

@stop