<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Publicação</h3>
    </div>
    <div class="box-body">

        <p><i class="fa fa-calendar"></i><b> Criado em</b> {{ $model->getCreatedAt()->format('d/m/Y H:i') }}</p>
        <p><i class="fa fa-calendar"></i><b> Última atualização</b> {{ $model->getUpdatedAt()->format('d/m/Y H:i') }}</p>

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