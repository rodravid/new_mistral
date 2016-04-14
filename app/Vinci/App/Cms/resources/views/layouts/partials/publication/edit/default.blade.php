<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Publicação</h3>
    </div>
    <div class="box-body">

        <p><i class="fa fa-calendar"></i><b> Criado em:</b> {{ $model->getCreatedAt()->format('d/m/Y \à\s H:i\h') }}</p>
        <p><i class="fa fa-calendar"></i><b> Última atualização:</b> {{ $model->getUpdatedAt()->format('d/m/Y \à\s H:i\h') }}</p>

        <div class="form-group has-feedback">
            <span id="startText">Publicar <strong>imediatamente</strong></span>
            <a class="publishing-action blue">Editar</a>
            <div class="publishing-fields" style="display: none;">
                <div class='input-group date' id='txtStartsAtPicker'>
                    {{ Form::text('startsAt', $model->startsAt, ['id' => 'txtStartsAt', 'class' => 'form-control']) }}
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <span id="endText"><strong>Nunca expira!</strong></span>
            <a class="publishing-action blue">Editar</a>
            <div class="publishing-fields" style="display: none;">
                <div class='input-group date' id='txtExpirationAtPicker'>
                    {{ Form::text('expirationAt', $model->expirationAt, ['id' => 'txtExpirationAt', 'class' => 'form-control']) }}
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    <span class="input-group-addon" id="clearDate"><span class="glyphicon glyphicon-remove"></span></span>
                </div>
            </div>
        </div>
    </div>

    <div class="box-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="javascript:void(0);" class="btn btn-danger"
           data-form-link
           data-confirm-title="Confirmação de exclusão"
           data-confirm-text="Deseja realmente excluir esse registro?"
           data-method="DELETE"
           data-action="/{{ Route::current()->getPrefix() }}/{{ $model->getId() }}/delete">Excluir</a>
    </div>
</div>