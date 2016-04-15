<div class="row">

    <div class="col-xs-12">
        <div class="form-group has-feedback">
            <label for="txtCountryName">Nome</label>
            {!! Form::text('name', null, ['id' => 'txtCountryName', 'class' => 'form-control', 'placeholder' => 'Digite o nome']) !!}
            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="form-group">
            <div class="checkbox">
                <input type="hidden" name="visibleSite" value="0">
                <label for="ckbCountryVisibleSite"> {!! Form::checkbox('visibleSite', 1, null, ['id' => 'ckbCountryVisibleSite', 'class' => '']) !!} Visível no site ?</label>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtCountryDescription">Descrição</label>
            {!! Form::textarea('description', null, ['id' => 'txtCountryDescription', 'class' => 'form-control html-editor', 'placeholder' => 'Digite a descrição']) !!}
            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
        </div>
    </div>

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
        <div class="form-group has-feedback">
            <label for="txtCountryImageMap">Imagem do mapa</label>
            {!! Form::file('image_map', ['id' => 'txtCountryImageMap']) !!}
            <span class="glyphicon glyphicon-picture form-control-feedback"></span>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtCountryImageBanner">Imagem do banner</label>
            {!! Form::file('image_banner', ['id' => 'txtCountryImageBanner']) !!}
            <span class="glyphicon glyphicon-picture form-control-feedback"></span>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="form-group has-feedback">
            <label for="txtCountrySlug">URL amigável</label>
            {!! Form::text('slug', null, ['id' => 'txtCountrySlug', 'class' => 'form-control', 'placeholder' => 'URL amigável']) !!}
            <span class="glyphicon glyphicon-link form-control-feedback"></span>
        </div>
    </div>

</div>