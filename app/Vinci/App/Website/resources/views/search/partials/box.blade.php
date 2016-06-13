<div class="row">
    @if($result->hasItems())
        <article class="wrap-content-search">

            @include('website::search.partials.filters')

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
                            {!! Form::select('max', [15 => 15, 30 => 30, 45 => 45], $result->getLimit(), ['class' => 'changeLimit']) !!}
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

                        {{ $result->items->links() }}
                    </div>

                </header>

                @yield('search.content')

                <div class="wrap-pagination">
                    <div class="container-total-products">
                        <span class="total-products show-desktop">{{ $result->items->range_view }} produtos</span>
                    </div>
                    {{ $result->items->links() }}
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