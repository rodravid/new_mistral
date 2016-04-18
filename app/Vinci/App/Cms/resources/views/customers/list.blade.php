@extends('cms::layouts.module-list')

@section('module.content.thead')
    <tr>
        <th>#ID</th>
        <th><i class="fa fa-tag"></i> Tipo</th>
        <th><i class="fa fa-pencil"></i> Nome</th>
        <th><i class="fa fa-envelope"></i> E-mail</th>
        <th><i class="fa fa-file-text-o"></i> CPF/CNPJ</th>
        <th><i class="fa fa-file-text-o"></i> RG/IE</th>
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
                ajax: $table.data('url'),
                searchDelay: 600,
                columnDefs: [
                    {orderable: false, targets: [4,5] },
                    {orderable: false, width: '92px', targets: -1 },
                    {className: 'hcenter vcenter', width: '20px', targets: [0] },
                    {className: 'vcenter', targets: [1,2,3,4,5,6,7,8] }
                ]
            });

        });

    </script>

@endsection