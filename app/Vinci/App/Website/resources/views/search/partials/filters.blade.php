<div class="search-column opacidade-coluna1" ng-controller="SearchFiltersController as ctrl">

    <div search-filters>

        @if(! empty($result->getTerm()))
            <h3 class="title-filter">Palavra Buscada</h3>
        @endif

        <ul class="filter-search">

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

            <div id="search-selected-filters">
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
            </div>

        </ul>

        @foreach($result->getVisibleFilters() as $filter)

            <h3 class="title-filter">{{ $filter->title }}</h3>

            <ul class="filter-search search-filter" data-urlkey="{{ $filter->name }}[]">
                @foreach($filter->getValues() as $value)
                    <li class="filter-search-item search-filter-value {{ ! $value->count > 0 ? 'disabled' : '' }}" data-value="{{ $value->getTitle() }}">
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

                @if ($filter->name != 'preco')
                    <span class="see-more-filter">+ veja mais</span>
                @endif
            </ul>

        @endforeach

    </div>

</div>