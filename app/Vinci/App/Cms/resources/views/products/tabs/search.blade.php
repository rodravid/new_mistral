<div class="tab-pane {{ currentTabActive('#productSearch') }}" id="productSearch">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="txtSearchRelevance">Relevância na busca (peso)</label>
                        {!! Form::number('searchRelevance', null, ['id' => 'txtSearchRelevance', 'class' => 'form-control', 'placeholder' => 'Digite um valor numérico para relevância (Ex. 10)', 'maxlength' => 10]) !!}
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="txtCountrySeoTitle">Título SEO</label>
                        {!! Form::text('seoTitle', null, ['id' => 'txtCountryName', 'class' => 'form-control', 'placeholder' => 'Digite o título para SEO']) !!}
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="txtSeoDescription">Descrição SEO</label>
                        {!! Form::textarea('seoDescription', null, ['id' => 'txtSeoDescription', 'class' => 'form-control', 'rows' => 4, 'placeholder' => 'Digite a descrição para SEO']) !!}
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