<div class="row" ng-app="productForm" ng-controller="ProductFormController as formCtrl">

    <div class="col-xs-12">
        <ul class="nav nav-tabs" style="margin-bottom: 20px;">
            <li class="{{ currentTabActive('#productData', 'active', true) }}"><a href="#productData" data-toggle="tab" aria-expanded="true"><i class="fa fa-cube"></i> Produto</a></li>
            <li class="{{ currentTabActive('#productPrices') }}"><a href="#productPrices" data-toggle="tab" aria-expanded="false"><i class="fa fa-money"></i> Preço</a></li>
            <li class="{{ currentTabActive('#productAttributes') }}"><a href="#productAttributes" data-toggle="tab" aria-expanded="false"><i class="fa fa-list-ul"></i> Atributos</a></li>

            @if($type == 'wine')
                <li class="{{ currentTabActive('#productGrapes') }}"><a href="#productGrapes" data-toggle="tab" aria-expanded="false"><i class="fa fa-pagelines"></i> Uvas</a></li>
                <li class="{{ currentTabActive('#productScores') }}"><a href="#productScores" data-toggle="tab" aria-expanded="false"><i class="fa fa-star"></i> Pontuações</a></li>
            @endif
        </ul>
        <div class="tab-content">
            <input type="hidden" name="current-tab" id="currentTab" value="{{ old('current-tab', '#productData') }}">

            @include('cms::products.tabs.product')
            @include('cms::products.tabs.price')
            @include('cms::products.tabs.attributes')

            @if($type == 'wine')
                @include('cms::products.tabs.grapes')
                @include('cms::products.tabs.scores')
            @endif

        </div>
    </div>

</div>

@section('scripts')
    @parent

    <script type="text/javascript">

        angular.module('productForm', [])
                .controller('ProductFormController', function($scope) {


                });

        (function($) {


        })($);

    </script>

@endsection