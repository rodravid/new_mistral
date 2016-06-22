<div class="row">

    <div class="col-xs-12">
        <ul class="nav nav-tabs" style="margin-bottom: 20px;">
            <li class="{{ currentTabActive('#tabData', 'active', true) }}"><a href="#tabData" data-toggle="tab" aria-expanded="true"><i class="fa fa-money"></i> Promoção</a></li>

            @if(isset($promotion))
                <li class="{{ currentTabActive('#tabProducts') }}"><a href="#tabProducts" data-toggle="tab" aria-expanded="true"><i class="fa fa-cubes"></i> Produtos</a></li>
            @endif
        </ul>
        <div class="tab-content">
            <input type="hidden" name="current-tab" id="currentTab" value="{{ old('current-tab', '#tabData') }}">

            @include('cms::promotions.discount.tabs.promotion')

            @if(isset($promotion))
                @include('cms::promotions.discount.tabs.products')
            @endif
        </div>
    </div>
</div>