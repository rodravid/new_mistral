<div class="row">
    @if($result->hasItems())
        <div search-filters>
            <article class="wrap-content-search @if(isset($template)) {{ $template }} @else template1 @endif">

            @include('website::search.partials.filters')

            <div class="@yield('box_class')">

                <header class="header-content-internal">

                    <span class="total-products show-mobile">{{ $result->items->range_view }} produtos</span>

                    <div class="display-filter float-right">
                        <span>Ordernar por</span>
                        <div class="select-standard form-control-white float-right select-widthfull">
                            {!! Form::select('max', [
                                1 => 'Relevância',
                                2 => 'Menor preço',
                                3 => 'Maior preço',
                                4 => 'Ordem Alfabética (A-Z)',
                                5 => 'Ordem Alfabética (Z-A)',
                            ], $result->getSort(), ['class' => 'changeOrder']) !!}
                        </div>
                    </div>

                    <div class="display-filter float-left">
                        <span>Itens por página</span>
                        <div class="select-standard form-control-white float-right select-widthfull">
                            {!! Form::select('max', [15 => 15, 30 => 30, 45 => 45], $result->getLimit(), ['class' => 'changeLimit']) !!}
                        </div>
                    </div>

                    <a class="filtro-mobile show-mobile" href="javascript:void(0);">Filtro<span>></span></a>

                    <div class="search-selected-filters">
                        <ul class="filter-search show-mobile">
                            @if(! empty($result->getTerm()))
                                <li class="filter-search-item">
                                    <ul class="subitem-filter-search remove-filter" data-urlkey="termo" data-value="{{ $result->getTerm() }}">
                                        <li>
                                            <a href="javascript:void(0);">{{ $result->getTerm() }}</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">X</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                            @foreach($result->getSelectedFilters() as $filter)
                                @foreach($filter->getValues() as $selectedValue)
                                    <li class="filter-search-item">
                                        <ul class="subitem-filter-search remove-filter" data-urlkey="{{ $filter->name }}[]" data-value="{{ $selectedValue->getTitle() }}">
                                            <li>
                                                <a href="javascript:void(0);">{{ $filter->title }} - {{ $selectedValue->title }}</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);">X</a>
                                            </li>
                                        </ul>
                                    </li>
                                @endforeach
                            @endforeach
                        </ul>
                    </div>

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
        </div>
        @include('website::layouts.partials.featuredweek')
    @else
        <div style="text-align: center;">
            <h2>Nenhum resultado encontrado.</h2>
        </div>
    @endif
</div>