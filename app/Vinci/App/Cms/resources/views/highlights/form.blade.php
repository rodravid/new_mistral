<div class="row">

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtHighlightTitle">Título</label>
            {!! Form::text('title', null, ['id' => 'txtHighlightTitle', 'class' => 'form-control', 'placeholder' => 'Digite o título']) !!}
            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtHighlightSubtitle">Subtítulo</label>
            {!! Form::text('subtitle', null, ['id' => 'txtHighlightSubtitle', 'class' => 'form-control', 'placeholder' => 'Digite o subtítulo']) !!}
            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtHighlightDescription">Descrição</label>
            {!! Form::textarea('description', null, ['id' => 'txtHighlightDescription', 'class' => 'form-control html-editor', 'placeholder' => 'Digite a descrição']) !!}
            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
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
        <div class="form-group has-feedback">
            <label for="txtHighlightUrl">URL</label>
            {!! Form::text('url', null, ['id' => 'txtHighlightUrl', 'class' => 'form-control', 'placeholder' => 'Digite o link de destino']) !!}
            <span class="glyphicon glyphicon-link form-control-feedback"></span>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group">
            <label for="txtHighlightSubtitle">Target</label>
            {!! Form::select('target', ['_self' => 'Mesma janela', '_blank' => 'Nova janela'], null, ['id' => 'txtHighlightTarget', 'class' => 'form-control']) !!}
        </div>
    </div>

</div>