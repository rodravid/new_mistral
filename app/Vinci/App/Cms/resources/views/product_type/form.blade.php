<div class="row">

    <div class="col-xs-12">
        <div class="form-group has-feedback">
            <label for="txtGrapeName">Nome</label>
            {!! Form::text('name', null, ['id' => 'txtGrapeName', 'class' => 'form-control', 'placeholder' => 'Digite o nome']) !!}
            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="form-group">
            <div class="checkbox">
                <input type="hidden" name="visibleSite" value="0">
                <label for="ckbGrapeVisibleSite"> {!! Form::checkbox('visibleSite', 1, null, ['id' => 'ckbGrapeVisibleSite', 'class' => '']) !!} Visível no site ?</label>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtGrapeDescription">Descrição</label>
            {!! Form::textarea('description', null, ['id' => 'txtGrapeDescription', 'class' => 'form-control html-editor', 'placeholder' => 'Digite a descrição']) !!}
            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtGrapeSeoTitle">Título SEO</label>
            {!! Form::text('seoTitle', null, ['id' => 'txtGrapeName', 'class' => 'form-control', 'placeholder' => 'Digite o título para SEO']) !!}
            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtGrapeSeoDescription">Descrição SEO</label>
            {!! Form::textarea('seoDescription', null, ['id' => 'txtGrapeSeoDescription', 'class' => 'form-control', 'rows' => 4, 'placeholder' => 'Digite a descrição para SEO']) !!}
            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtGrapeImageMap">Imagem</label>
            {!! Form::file('picture', ['id' => 'txtGrapePicture']) !!}
            <span class="glyphicon glyphicon-picture form-control-feedback"></span>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtGrapeImageBanner">Imagem mobile</label>
            {!! Form::file('picture_mobile', ['id' => 'txtGrapePictureMobile']) !!}
            <span class="glyphicon glyphicon-picture form-control-feedback"></span>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="form-group has-feedback">
            <label for="txtGrapeSlug">URL amigável</label>
            {!! Form::text('slug', null, ['id' => 'txtGrapeSlug', 'class' => 'form-control', 'placeholder' => 'URL amigável']) !!}
            <span class="glyphicon glyphicon-link form-control-feedback"></span>
        </div>
    </div>

</div>