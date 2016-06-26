<div class="row">

    <div class="col-xs-12">
        <ul class="nav nav-tabs" style="margin-bottom: 20px;">
            <li class="{{ currentTabActive('#tabData', 'active', true) }}"><a href="#tabData" data-toggle="tab" aria-expanded="true"><i class="fa fa-money"></i> Promoção</a></li>
        </ul>
        <div class="tab-content">
            <input type="hidden" name="current-tab" id="currentTab" value="{{ old('current-tab', '#tabData') }}">

            @include('cms::promotions.shipping.tabs.promotion')

        </div>
    </div>
</div>