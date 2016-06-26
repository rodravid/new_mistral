<div class="tab-pane {{ currentTabActive('#tabData', 'active', true) }}" id="tabData" ng-app="discountPromotionForm" ng-controller="ShippingPromotionFormController">
    <input type="hidden" name="channel" value="1">
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <div class="form-group has-feedback">
                <label for="txtShowcaseTitle">Título</label>
                {!! Form::text('title', null, ['id' => 'txtShowcaseTitle', 'class' => 'form-control', 'placeholder' => 'Digite o título']) !!}
                <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group has-feedback">
                <label for="txtShowcaseDescription">Descrição</label>
                {!! Form::textarea('description', null, ['id' => 'txtShowcaseDescription', 'class' => 'form-control html-editor-especial', 'placeholder' => 'Digite a descrição', 'rows' => '3']) !!}
                <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="form-group has-feedback">
                <label for="txtShowcaseTitle">Valor inicial da compra</label>
                {!! Form::text('initialAmount', null, ['id' => 'txtInitialAmount', 'class' => 'form-control', 'placeholder' => 'Valor inicial da compra']) !!}
                <span class="fa fa-money form-control-feedback"></span>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="form-group has-feedback">
                <label for="txtShowcaseTitle">Valor final da compra</label>
                {!! Form::text('finalAmount', null, ['id' => 'txtFinalAmount', 'class' => 'form-control', 'placeholder' => 'Valor final da compra']) !!}
                <span class="fa fa-money form-control-feedback"></span>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="form-group">
                <label for="txtShowcaseTitle">Aplicar desconto para as seguintes regiões:</label>
                {!! Form::select('deliveryTracks[]', $deliveryTracks, old('deliveryTracks', isset($selectedDeliveryTracks) ? $selectedDeliveryTracks : []), ['id' => 'selectDeliveryTracks', 'class' => 'form-control select2', 'style' => 'width: 100%', 'multiple']) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <label for="txtShowcaseTitle">Tipo de desconto</label>
                {!! Form::select('discountType', [
                \Vinci\Domain\Pricing\Contracts\DiscountType::NEW_VALUE => 'Novo valor de frete',
                \Vinci\Domain\Pricing\Contracts\DiscountType::FIXED => 'Fixo',
                \Vinci\Domain\Pricing\Contracts\DiscountType::PERCENTAGE => 'Porcentagem'
                ], null, ['id' => 'txtDiscountType', 'class' => 'form-control']) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="form-group has-feedback">
                <label for="txtShowcaseTitle">Valor do desconto</label>
                {!! Form::text('discountAmount', null, ['id' => 'txtDiscountAmount', 'class' => 'form-control', 'placeholder' => 'Valor do desconto']) !!}
                <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
            </div>
        </div>

    </div>
</div>

@section('scripts')
    @parent

    <script type="text/javascript">

        angular.module('discountPromotionForm', [])
                .controller('DiscountPromotionFormController', function($scope) {

                });

    </script>

@endsection