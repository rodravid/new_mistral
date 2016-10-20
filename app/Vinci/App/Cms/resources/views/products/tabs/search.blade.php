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

                <div class="panel mgTop15 modContent">
                    <div class="panel-body">
                        <div class="col-xs-12 col-md-12 col-lg-7 mgTop15">
                            <label>Link de Redirecionamento</label>
                            {!! Form::text('redirect_url', null, ['class' => 'form-control', 'placeholder' => 'Ex.: http://']) !!}
                        </div>
                        <div class="col-xs-12 col-md-12 col-lg-5 mgTop15">
                            <label>Tipo de redirecionamento</label>
                            <div class="flat-green">
                                <input type="radio" id="redirect_301" name="redirect_type" value="301"
                                       @if ($product->getRedirectType() == 301) checked="checked" @endif>
                                <label for="redirect_301">301 <small class="text-blue">(Moved Permanently)</small></label>
                                <br>
                                <input type="radio" id="redirect_302" name="redirect_type" value="302"
                                    @if ($product->getRedirectType() == 302 || empty($product->getRedirectType())) checked="checked" @endif>
                                <label for="redirect_302">302 <small class="text-green">(Moved Temporarily)</small></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>