<div class="row">

    <div class="col-xs-12">
        <ul class="nav nav-tabs" style="margin-bottom: 20px;">
            <li class="{{ currentTabActive('#showcaseData') }}"><a href="#showcaseData" data-toggle="tab" aria-expanded="true"><i class="fa fa-th"></i> Vitrine</a></li>

            @if(isset($showcase))
                <li class="{{ currentTabActive('#showcaseProducts', 'active', true) }}"><a href="#showcaseProducts" data-toggle="tab" aria-expanded="true"><i class="fa fa-cubes"></i> Produtos</a></li>
            @endif
        </ul>
        <div class="tab-content">
            <input type="hidden" name="current-tab" id="currentTab" value="{{ old('current-tab', '#showcaseData') }}">

            @include('cms::showcases.tabs.showcase')

            @if(isset($showcase))
                @include('cms::showcases.tabs.products')
            @endif
        </div>
    </div>
</div>