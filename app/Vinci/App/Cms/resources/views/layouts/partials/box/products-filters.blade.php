<div class="col-xs-12" id="containerProductsFilters">
    <div class="well panel panel-primary">
        <h4 class="panel-heading">Adicionar produtos à promoção</h4>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12" style="padding: 0 0 30px;">
                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <label for="name">Selecione o(s) produto(s):</label>
                            <p>
                                {!! Form::select('products', $products, [], ['id' => 'selectProducts', 'class' => "form-control input-sm select-filter", 'multiple', 'style' => 'width: 100%']) !!}
                            </p>
                        </div>
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <p>
                                <a href="javascript: void(0);" id="addProducts" class="btn btn-info"><i class="fa fa-plus-circle"></i>
                                    Adicionar produto(s) na promoção
                                </a>
                                <small id="messageAddProductShowcase"></small>
                            </p>
                        </div>

                        <div class="col-xs-12 col-md-12 col-lg-12" style="margin-top: 15px;">
                            <label for="name">Ou adicione a partir dos filtros:</label>
                        </div>

                        <div class="col-xs-12 col-md-3 col-lg-3" style="margin-top: 15px;">
                            <label for="countries">Países</label>
                            {!! Form::select('countries', $countries, [], ['id' => 'selectCountries', 'class' => "form-control input-sm select-filter", 'multiple', 'style' => 'width: 100%']) !!}
                        </div>

                        <div class="col-xs-12 col-md-3 col-lg-3" style="margin-top: 15px;">
                            <label for="regions">Regiões</label>
                            {!! Form::select('regions', $regions, [], ['id' => 'selectRegions', 'class' => "form-control input-sm select-filter", 'multiple', 'style' => 'width: 100%']) !!}
                        </div>

                        <div class="col-xs-12 col-md-3 col-lg-3" style="margin-top: 15px;">
                            <label for="producers">Produtores</label>
                            {!! Form::select('producers', $producers, [], ['id' => 'selectProducers', 'class' => "form-control input-sm select-filter", 'multiple', 'style' => 'width: 100%']) !!}
                        </div>

                        <div class="col-xs-12 col-md-3 col-lg-3" style="margin-top: 15px;">
                            <label for="producers">Tipos de vinho</label>
                            {!! Form::select('types', $productTypes, [], ['id' => 'selectTypes', 'class' => "form-control input-sm select-filter", 'multiple', 'style' => 'width: 100%']) !!}
                        </div>

                        <div class="col-xs-12 col-md-12 col-lg-12" style="margin-top: 15px;">
                            <button class="btn btn-info" id="btnAddProducts">Adicionar produtos dos filtros selecionados</button>
                        </div>

                        <div class="col-xs-12 col-md-12 col-lg-12" style="margin-top: 15px;">
                            <label>Você ainda pode:</label><br/>
                            <button class="btn btn-info" id="btnAddAllProducts">Adicionar todos produtos do site</button>
                        </div>

                        <div class="col-xs-12 col-md-12 col-lg-12" style="margin-top: 15px;">
                            <label>Ou se preferir importar de uma planilha excel:</label><br/>

                            <div class="btn btn-info" id="btnImportProducts">
                                Selecionar arquivo...
                                <div id="uploadPreview"></div>
                                <div class="upload-progress pull-left"
                                     style="width: 100%; display: none;">
                                    <div class="progress mgTop15">
                                        <div class="progress-bar"
                                             role="progressbar"
                                             id="uploadProgress"
                                             aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div id="upload-message" class="mgTop15"
                                     style="float: left; display: none;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>