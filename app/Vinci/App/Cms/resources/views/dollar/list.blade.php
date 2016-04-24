@extends('cms::layouts.module-list')

@section('module.content.thead')
    <tr>
        <th>#ID</th>
        <th><i class="fa fa-file-text-o"></i> Descrição</th>
        <th><i class="fa fa-money"></i> Valor</th>
        <th><i class="fa fa-user"></i> Usuário</th>
        <th><i class="fa fa-calendar"></i> Definido em</th>
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
                order: [[ 0, "desc" ]],
                columnDefs: [
                    {className: 'hcenter vcenter', width: '20px', targets: 0 },
                    {className: 'vcenter', targets: [3,4] }
                ]
            });

        });

    </script>

@endsection