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
                <label for="txtShortDescription">Resumo</label>
                {!! Form::textarea('shortDescription', null, ['id' => 'txtShortDescription', 'class' => 'form-control', 'rows' => 2, 'placeholder' => 'Digite o resumo']) !!}
                <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group has-feedback">
                <label for="txtCountryDescription">Descrição</label>
                {!! Form::textarea('description', null, ['id' => 'txtCountryDescription', 'class' => 'form-control html-editor', 'rows' => 5, 'placeholder' => 'Digite a descrição']) !!}
                <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
            </div>
        </div>

    </div>
</div>