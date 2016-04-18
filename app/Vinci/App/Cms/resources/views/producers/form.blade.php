<div class="row">

    <div class="col-xs-12">
        <div class="form-group has-feedback">
            <label for="txtProducerName">Nome</label>
            {!! Form::text('name', null, ['id' => 'txtProducerName', 'class' => 'form-control', 'placeholder' => 'Digite o nome']) !!}
            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="form-group">
            <div class="checkbox">
                <input type="hidden" name="visibleSite" value="0">
                <label for="ckbProducerVisibleSite"> {!! Form::checkbox('visibleSite', 1, null, ['id' => 'ckbProducerVisibleSite', 'class' => '']) !!} Visível no site ?</label>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtProducerDescription">Descrição</label>
            {!! Form::textarea('description', null, ['id' => 'txtProducerDescription', 'class' => 'form-control html-editor', 'placeholder' => 'Digite a descrição']) !!}
            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group">
            <label for="selectRegionCountry">Região</label>

            @if(isset($producer))
                <select name="region_id" id="selectRegionCountry" class="form-control select2">
                    <option value="">Selecione a região</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->getId() }}" @if(old('region_id') == $region->getId() || $producer->belongsToRegion($region)) selected @endif>{{ $region->getName() }}</option>
                    @endforeach
                </select>
            @else
                {!! Form::select('region_id', ['' => 'Selecione a região'] + $regions, null, ['id' => 'selectRegionCountry', 'class' => 'form-control select2']) !!}
            @endif

        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtProducerSeoTitle">Título SEO</label>
            {!! Form::text('seoTitle', null, ['id' => 'txtProducerName', 'class' => 'form-control', 'placeholder' => 'Digite o título para SEO']) !!}
            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtProducerSeoDescription">Descrição SEO</label>
            {!! Form::textarea('seoDescription', null, ['id' => 'txtProducerSeoDescription', 'class' => 'form-control', 'rows' => 4, 'placeholder' => 'Digite a descrição para SEO']) !!}
            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtProducerImageMap">Logo</label>
            {!! Form::file('image_logo', ['id' => 'txtProducerImageMap']) !!}
            <span class="glyphicon glyphicon-picture form-control-feedback"></span>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtProducerImageBanner">Logo mobile</label>
            {!! Form::file('image_logo_mobile', ['id' => 'txtProducerImageBanner']) !!}
            <span class="glyphicon glyphicon-picture form-control-feedback"></span>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="form-group has-feedback">
            <label for="txtProducerSlug">URL amigável</label>
            {!! Form::text('slug', null, ['id' => 'txtProducerSlug', 'class' => 'form-control', 'placeholder' => 'URL amigável']) !!}
            <span class="glyphicon glyphicon-link form-control-feedback"></span>
        </div>
    </div>

</div>