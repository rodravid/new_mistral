<div class="tab-pane {{ currentTabActive('#tabData', 'active', true) }}" id="tabData">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">

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
                <label for="txtShowcaseDescription">Descrição</label>
                {!! Form::textarea('description', null, ['id' => 'txtShowcaseDescription', 'class' => 'form-control html-editor-especial', 'placeholder' => 'Digite a descrição', 'rows' => '3']) !!}
                <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
            </div>
        </div>
    </div>
</div>