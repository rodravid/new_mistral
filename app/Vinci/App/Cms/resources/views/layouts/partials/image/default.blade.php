<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $box_title }}</h3>
    </div>
    <div class="box-body">
        <img src="{{ $image->getWebPath() }}" class="img-responsive center-block" />
    </div>

    <div class="box-footer">
        <a href="javascript:void(0);" class="btn btn-danger btn-xs"
           data-form-link
           data-confirm-title="Confirmação de exclusão"
           data-confirm-text="Deseja realmente excluir essa imagem?"
           data-method="DELETE"
           data-action="{{ $delete_url }}"><i class="fa fa-trash"></i> Remover imagem</a>
    </div>
</div>