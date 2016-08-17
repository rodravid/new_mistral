@extends('cms::layouts.module-list')

@section('module.content.thead')
    <tr>
        <th>#ID</th>
        <th>SKU</th>
        <th><i class="fa fa-picture-o"></i> Imagem</th>
        <th><i class="fa fa-pencil"></i> Título</th>
        <th><i class="fa fa-cubes"></i> Estoque</th>
        <th><i class="fa fa-file-text-o"></i> Importa estoque</th>
        <th><i class="fa fa-file-text-o"></i> Importa preço</th>
        <th><i class="fa fa-eye"></i> Visível no site</th>
        <th><i class="fa fa-calendar"></i> Criado em</th>
        <th><i class="fa fa-edit"></i> Status</th>
        <th>Ações</th>
    </tr>
@endsection

@section('scripts')
    @parent

    <script type="text/javascript">

        $(function() {

            var $table = $('.table');

            $table.DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": $table.data('url'),
                    "type": "POST"
                },
                searchDelay: 600,
                columnDefs: [
                    {orderable: false, targets: [2] },
                    {orderable: false, width: '100px', targets: -1 },
                    {className: 'hcenter vcenter', width: '20px', targets: [0] },
                    {className: 'hcenter vcenter', width: '100px', targets: [2] },
                    {className: 'vcenter', targets: [1,2,3,4,5,6,7,8,9,10] }
                ]
            });

        });

    </script>

@endsection