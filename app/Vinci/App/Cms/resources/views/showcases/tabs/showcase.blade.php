<div class="tab-pane {{ currentTabActive('#showcaseData', 'active', true) }}" id="showcaseData">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-xs-2 col-sm-2 col-lg-1 col-md-2">
                    <div class="form-group">
                        <label for="txtShowcasePosition">Ordem</label>
                        {!! Form::text('position', null, ['id' => 'txtShowcasePosition', 'class' => 'form-control span', 'maxlength' => '4']) !!}
                    </div>
                </div>
                <div class="col-xs-10 col-sm-10 col-lg-11 col-md-10">
                    <div class="form-group">
                        <label for="txtShowcasePosition">Template da vitrine</label>
                        {!! Form::select('template', $templates, old('template', isset($showcase) ? $showcase->getTemplate()->getId() : null), ['class' => 'form-control select2']) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12">
                    <div class="form-group has-feedback">
                        <label for="txtShowcaseTitle">Título</label>
                        {!! Form::text('title', null, ['id' => 'txtShowcaseTitle', 'class' => 'form-control', 'placeholder' => 'Digite o título']) !!}
                        <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group has-feedback">
                <label for="txtShowcaseSubtitle">Subtítulo</label>
                {!! Form::text('subtitle', null, ['id' => 'txtShowcaseSubtitle', 'class' => 'form-control', 'placeholder' => 'Digite o subtítulo']) !!}
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

        <div class="col-lg-12">
            <div class="form-group has-feedback">
                <label for="txtRedirectUrl">URL de destino</label>
                {!! Form::text('url', null, ['id' => 'txtRedurectUrl', 'class' => 'form-control', 'placeholder' => 'Digite a URL de destino']) !!}
                <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <label for="txtKeywords">Palavras chave</label>
                {!! Form::text('keywords', null, ['id' => 'txtKeywords', 'class' => 'form-control', 'placeholder' => 'Palavras chave', 'data-keywords']) !!}
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group has-feedback">
                <label for="txtCountryImageBanner">Imagem do banner</label>
                {!! Form::file('image_banner', ['id' => 'txtCountryImageBanner']) !!}
                <span class="glyphicon glyphicon-picture form-control-feedback"></span>
            </div>
        </div>

    </div>
</div>