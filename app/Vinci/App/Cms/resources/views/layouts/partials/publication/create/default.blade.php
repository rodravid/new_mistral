<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Publicação</h3>
    </div>
    <div class="box-body">

        @if(isset($hasSchedule) && $hasSchedule)
            <div class="form-group has-feedback">
                <span id="startText">Publicar <strong>imediatamente</strong></span>
                <a class="publishing-action blue">Editar</a>
                <div class="publishing-fields" style="display: none;">
                    <div class="input-group date" id="txtStartsAtPicker">
                        {{ Form::text('startsAt', \Carbon\Carbon::now()->format('d/m/Y H:i'), ['id' => 'txtStartsAt', 'class' => 'form-control']) }}
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <span id="endText"><strong>Nunca expira!</strong></span>
                <a class="publishing-action blue">Editar</a>
                <div class="publishing-fields" style="display: none;">
                    <div class="input-group date" id="txtExpirationAtPicker" data-has-expiration="false">
                        {{ Form::text('expirationAt', null, ['id' => 'txtExpirationAt', 'class' => 'form-control']) }}
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                    <span id="clearDate" class="btn btn-default btn-block"><span class="glyphicon glyphicon-remove"></span></span>
                </div>
            </div>
        @else
            <button type="submit" class="btn btn-success btn-block" name="status" value="1"><i class="fa fa-check"></i> Salvar e publicar</button>
            @if(isset($hasDraft) && $hasDraft)
                <button type="submit" class="btn btn-primary btn-block" name="status" value="0"><i class="fa fa-edit"></i> Salvar como rascunho</button>
            @endif
        @endif
    </div>
    @if(isset($hasSchedule) && $hasSchedule)
        <div class="box-footer">
            <button type="submit" class="btn btn-success btn-block" name="status" value="1"><i class="fa fa-check"></i> Salvar e publicar</button>
            @if(isset($hasDraft) && $hasDraft)
                <button type="submit" class="btn btn-primary btn-block" name="status" value="0"><i class="fa fa-edit"></i> Salvar como rascunho</button>
            @endif
        </div>
    @endif
</div>