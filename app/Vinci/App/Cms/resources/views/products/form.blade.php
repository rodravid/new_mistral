<div class="row" ng-app="productForm" ng-controller="ProductFormController as formCtrl">

    <div class="col-xs-12">
        <ul class="nav nav-tabs" style="margin-bottom: 20px;">
            <li class="{{ currentTabActive('#productData', 'active', true) }}"><a href="#productData" data-toggle="tab" aria-expanded="true"><i class="fa fa-cube"></i> Produto</a></li>
            <li class="{{ currentTabActive('#productAttributes') }}"><a href="#productAttributes" data-toggle="tab" aria-expanded="false"><i class="fa fa-list-ul"></i> Atributos</a></li>
            <li class="{{ currentTabActive('#productGrapes') }}"><a href="#productGrapes" data-toggle="tab" aria-expanded="false"><i class="fa fa-pagelines"></i> Uvas</a></li>
            <li class="{{ currentTabActive('#productScores') }}"><a href="#productScores" data-toggle="tab" aria-expanded="false"><i class="fa fa-star"></i> Pontuações</a></li>
        </ul>
        <div class="tab-content">
            <input type="hidden" name="current-tab" id="currentTab" value="{{ old('current-tab', '#productData') }}">
            <div class="tab-pane {{ currentTabActive('#productData', 'active', true) }}" id="productData">
                <div class="row">

                    <div class="col-xs-12">
                        <div class="form-group has-feedback">
                            <label for="txtName">Nome</label>
                            {!! Form::text('name', null, ['id' => 'txtName', 'class' => 'form-control', 'placeholder' => 'Digite o nome do produto']) !!}
                            <span class="fa fa-pencil form-control-feedback"></span>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group has-feedback">
                            <label for="txtCountryDescription">Descrição</label>
                            {!! Form::textarea('description', null, ['id' => 'txtCountryDescription', 'class' => 'form-control html-editor', 'rows' => 5, 'placeholder' => 'Digite a descrição']) !!}
                            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group has-feedback">
                            <label for="txtCountrySeoTitle">Título SEO</label>
                            {!! Form::text('seoTitle', null, ['id' => 'txtCountryName', 'class' => 'form-control', 'placeholder' => 'Digite o título para SEO']) !!}
                            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group has-feedback">
                            <label for="txtCountrySeoDescription">Descrição SEO</label>
                            {!! Form::textarea('seoDescription', null, ['id' => 'txtCountrySeoDescription', 'class' => 'form-control', 'rows' => 4, 'placeholder' => 'Digite a descrição para SEO']) !!}
                            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="tab-pane @if(old('current-tab') == '#productAttributes') active @endif" id="productAttributes">
                <div class="row">
                    <div class="col-xs-12">

                    </div>
                </div>
            </div>
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