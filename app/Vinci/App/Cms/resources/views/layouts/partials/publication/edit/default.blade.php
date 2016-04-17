<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Publicação</h3>
    </div>
    <div class="box-body">

        @if($model->hasProperty('status'))
            <p>{!! present_status_html($model->getStatus()) !!}</p>
        @endif

        <p><i class="fa fa-calendar"></i><b> Criado em:</b> {{ $model->getCreatedAt()->format('d/m/Y \à\s H:i\h') }}</p>
        <p><i class="fa fa-calendar"></i><b> Última atualização:</b> {{ $model->getUpdatedAt()->format('d/m/Y \à\s H:i\h') }}</p>

        @if($model->hasProperty('startsAt'))
            <div class="form-group has-feedback">
                <span id="startText">Publicar <strong>imediatamente</strong></span>
                <a class="publishing-action blue">Editar</a>
                <div class="publishing-fields" style="display: none;">
                    <div class="input-group date" id="txtStartsAtPicker">
                        {{ Form::text('startsAt', $model->getStartsAt()->format('d/m/Y H:i'), ['id' => 'txtStartsAt', 'class' => 'form-control']) }}
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>
        @endif

        @if($model->hasProperty('expirationAt'))
            <div class="form-group">
                <span id="endText"><strong>Nunca expira!</strong></span>
                <a class="publishing-action blue">Editar</a>
                <div class="publishing-fields" style="display: none;">
                    <div class="input-group date" id="txtExpirationAtPicker" data-has-expiration="{{ (! empty($model->getExpirationAt()) ? 'true' : 'false') }}">
                        {{ Form::text('expirationAt', (! empty($model->getExpirationAt()) ? $model->getExpirationAt()->format('d/m/Y H:i') : null), ['id' => 'txtExpirationAt', 'class' => 'form-control']) }}
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                    <span id="clearDate" class="btn btn-default btn-block"><span class="glyphicon glyphicon-remove"></span></span>
                </div>
            </div>
        @endif
    </div>

    <div class="box-footer">
        <button type="submit" class="btn btn-success btn-block" name="status" value="1"><i class="fa fa-check"></i> Salvar e publicar</button>
        @if($model->hasProperty('status'))
            <button type="submit" class="btn btn-primary btn-block" name="status" value="0"><i class="fa fa-edit"></i> Savar como rascunho</button>
        @endif
        <a href="javascript:void(0);" class="btn btn-danger btn-block"
           data-form-link
           data-confirm-title="Confirmação de exclusão"
           data-confirm-text="Deseja realmente excluir esse registro?"
           data-method="DELETE"
           data-action="/{{ Route::current()->getPrefix() }}/{{ $model->getId() }}/delete"><i class="fa fa-trash"></i> Excluir</a>
    </div>
</div>