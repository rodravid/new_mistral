<div class="tab-pane {{ currentTabActive('#productData', 'active', true) }}" id="productData">
    <div class="row">

        <div class="col-xs-12">
            <div class="form-group has-feedback">
                <label for="txtName">Nome</label>
                {!! Form::text('name', null, ['id' => 'txtName', 'class' => 'form-control', 'placeholder' => 'Digite o nome do produto']) !!}
                <span class="fa fa-pencil form-control-feedback"></span>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group has-feedback">
                <label for="txtCountryDescription">Descrição</label>
                {!! Form::textarea('description', null, ['id' => 'txtCountryDescription', 'class' => 'form-control html-editor', 'rows' => 5, 'placeholder' => 'Digite a descrição']) !!}
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
            <div class="form-group">
                <label for="txtKeywords">Palavras chaves</label>
                {!! Form::text('seoKeywords', null, ['id' => 'txtKeywords', 'class' => 'form-control', 'placeholder' => 'Digite a descrição para SEO', 'data-keywords']) !!}
            </div>
        </div>

    </div>
</div>