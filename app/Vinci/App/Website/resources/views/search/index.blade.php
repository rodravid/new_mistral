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

                    @foreach($result->getVisibleFilters() as $filter)

                        <h3 class="title-filter">{{ $filter->title }}</h3>

                        <ul class="filter-search">
                            @foreach($filter->getValues() as $value)
                                <li class="filter-search-item">
                                    <ul class="subitem-filter-search">
                                        <li>
                                            <a href="javascript:void(0);">{{ $value->title }}</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">{{ $value->count }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endforeach

                            <span class="see-more-filter">+ veja mais</span>
                        </ul>

                    @endforeach

                </div>

                <div class="column-products-search-inline template1">

                    <header class="header-content-internal">

                        <span class="total-products show-mobile">{{ $result->items->range_view }} produtos</span>


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
                                <span class="total-products show-desktop">{{ $result->items->range_view }} produtos</span>
                            </div>

                            <ul class="pagination">
                                {{ $result->items->links() }}
                            </ul>
                        </div>

                    </header>

                    @each('website::layouts.partials.product.cards.search', $result->getItems(), 'product')

                    <div class="wrap-pagination">
                        <div class="container-total-products">
                            <span class="total-products show-desktop">{{ $result->items->range_view }} produtos</span>
                        </div>
                        <ul class="pagination">
                            {{ $result->items->links() }}
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