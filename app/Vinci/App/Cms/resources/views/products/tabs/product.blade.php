<div class="tab-pane {{ currentTabActive('#productData', 'active', true) }}" id="productData">
    <div class="row">


        <div class="col-xs-12">
            <div class="form-group has-feedback">
                <label for="txtSku">SKU</label>
                {!! Form::text('sku', null, ['id' => 'txtSku', 'class' => 'form-control', 'placeholder' => 'Digite o código do produto (SKU)']) !!}
                <span class="fa fa-pencil form-control-feedback"></span>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="form-group has-feedback">
                <label for="txtTitle">Título</label>
                {!! Form::text('title', null, ['id' => 'txtTitle', 'class' => 'form-control', 'placeholder' => 'Digite o título do produto']) !!}
                <span class="fa fa-pencil form-control-feedback"></span>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group has-feedback">
                <label for="txtShortDescription">Resumo</label>
                {!! Form::textarea('shortDescription', null, ['id' => 'txtShortDescription', 'class' => 'form-control', 'rows' => 2, 'placeholder' => 'Digite o resumo']) !!}
                <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group has-feedback">
                <label for="txtPackSize">Tamanho da Caixa</label>
                {!! Form::number('packSize', null, ['id' => 'txtPackSize', 'class' => 'form-control']) !!}
                <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group has-feedback">
                <label for="txtCountryDescription">Descrição</label>
                {!! Form::textarea('description', null, ['id' => 'txtCountryDescription', 'class' => 'form-control html-editor', 'rows' => 7, 'placeholder' => 'Digite a descrição']) !!}
                <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="form-group has-feedback">
                <label for="txtCountrySlug">URL amigável</label>
                {!! Form::text('slug', null, ['id' => 'txtCountrySlug', 'class' => 'form-control', 'placeholder' => 'URL amigável']) !!}
                <span class="glyphicon glyphicon-link form-control-feedback"></span>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group has-feedback">
                <label>Foto versão desktop</label>
                {!! Form::file('image_desktop') !!}
                <span class="glyphicon glyphicon-picture form-control-feedback"></span>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group has-feedback">
                <label>Foto versão mobile</label>
                {!! Form::file('image_mobile') !!}
                <span class="glyphicon glyphicon-picture form-control-feedback"></span>
            </div>
        </div>

    </div>
</div>