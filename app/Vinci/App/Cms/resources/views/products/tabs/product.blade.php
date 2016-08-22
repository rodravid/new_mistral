<div class="tab-pane {{ currentTabActive('#productData', 'active', true) }}" id="productData">
    <div class="row">

        <style>
            .mp15 {
                padding: 15px;
            }

            .boxLineAttributes {
                background-color: #f1f1f1;
                float: left;
                width: 100%;
                padding: 10px;
                border: 1px solid #eaeaea;
                border-radius: 4px;
            }
        </style>

        @if(isset($product))
            <div class="col-sm-12">
                <div class="row mp15">
                    <div class="boxLineAttributes">
                        <div class="col-xs-12 col-sm-3">
                            <div class="form-group">
                                <label for="txtTitle"><i class="fa fa-flag"></i> País</label>
                                <p>{{ $product->getCountry()->getName() }}</p>

                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-3">
                            <div class="form-group">
                                <label for="txtTitle"><i class="fa fa-map-marker"></i> Região</label>

                                <p>{{ $product->getRegion()->getName() }}</p>

                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-3">
                            <div class="form-group">
                                <label for="txtTitle"><i class="fa fa-users"></i> Produtor</label>

                                <p>{{ $product->getProducer()->getName() }}</p>

                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-3">
                            <div class="form-group">
                                <label for="txtTitle"><i class="fa fa-tags"></i> Tipo de vinho</label>

                                <p>{{ $product->getProductType()->getName() }}</p>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        @endif

        <div class="col-xs-12">
            <div class="form-group">
                <label for="txtSku">SKU</label>
                {!! Form::text('sku', null, ['id' => 'txtSku', 'class' => 'form-control', 'placeholder' => 'Digite o código do produto (SKU)']) !!}

            </div>
        </div>

        <div class="col-xs-12">
            <div class="form-group">
                <label for="txtTitle">Título</label>
                {!! Form::text('title', null, ['id' => 'txtTitle', 'class' => 'form-control', 'placeholder' => 'Digite o título do produto']) !!}

            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <label for="txtShortDescription">Resumo</label>
                {!! Form::textarea('shortDescription', null, ['id' => 'txtShortDescription', 'class' => 'form-control', 'rows' => 2, 'placeholder' => 'Digite o resumo']) !!}

            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <label for="txtPackSize">Tamanho da Caixa</label>
                {!! Form::number('packSize', null, ['id' => 'txtPackSize', 'class' => 'form-control']) !!}

            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <label for="txtCountryDescription">Descrição</label>
                {!! Form::textarea('description', null, ['id' => 'txtCountryDescription', 'class' => 'form-control html-editor', 'rows' => 7, 'placeholder' => 'Digite a descrição']) !!}

            </div>
        </div>

        <div class="col-xs-12">
            <div class="form-group">
                <label for="txtCountrySlug">URL amigável</label>
                {!! Form::text('slug', null, ['id' => 'txtCountrySlug', 'class' => 'form-control', 'placeholder' => 'URL amigável']) !!}
                <span class="glyphicon glyphicon-link form-control-feedback"></span>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <label>Foto</label>
                {!! Form::file('photo') !!}
                <span class="glyphicon glyphicon-picture form-control-feedback"></span>
            </div>
        </div>

    </div>
</div>