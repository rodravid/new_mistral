<div class="row">

    <div class="col-lg-12">
        <div class="row">
            <div class="col-xs-2 col-sm-2 col-lg-1 col-md-2">
                <div class="form-group">
                    <label for="txtHighlightPosition">Ordem</label>
                    {!! Form::text('position', null, ['id' => 'txtHighlightPosition', 'class' => 'form-control span', 'maxlength' => '4']) !!}
                </div>
            </div>

            <div class="col-xs-10 col-sm-10 col-lg-11 col-md-10">
                <div class="form-group has-feedback">
                    <label for="txtHighlightTitle">Título</label>
                    {!! Form::text('title', null, ['id' => 'txtHighlightTitle', 'class' => 'form-control', 'placeholder' => 'Digite o título', 'rows' => '3']) !!}
                    <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtHighlightPasswordConfirmation">Banner versão desktop</label>
            {!! Form::file('image_desktop', ['id' => 'txtHighlightImageDesktop']) !!}
            <span class="glyphicon glyphicon-picture form-control-feedback"></span>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtHighlightPasswordConfirmation">Banner versão mobile</label>
            {!! Form::file('image_mobile', ['id' => 'txtHighlightImageMobile']) !!}
            <span class="glyphicon glyphicon-picture form-control-feedback"></span>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="row">
            <div class="col-xs-7 col-sm-10">
                <div class="form-group has-feedback">
                    <label for="txtHighlightUrl">URL</label>
                    {!! Form::text('url', null, ['id' => 'txtHighlightUrl', 'class' => 'form-control', 'placeholder' => 'Digite o link de destino']) !!}
                    <span class="glyphicon glyphicon-link form-control-feedback"></span>
                </div>
            </div>

            <div class="col-xs-5 col-sm-2">
                <div class="form-group">
                    <label for="txtHighlightTarget">Target</label>
                    {!! Form::select('target', ['_self' => 'Mesma janela', '_blank' => 'Nova janela'], null, ['id' => 'txtHighlightTarget', 'class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>

</div>