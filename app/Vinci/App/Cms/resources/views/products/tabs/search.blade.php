<div class="tab-pane {{ currentTabActive('#productSearch') }}" id="productSearch">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
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

                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="txtKeywords">Palavras chave</label>
                        {!! Form::text('seoKeywords', null, ['id' => 'txtKeywords', 'class' => 'form-control', 'placeholder' => 'Palavras chave', 'data-keywords']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>