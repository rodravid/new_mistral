@extends('cms::layouts.module-list')

@section('module.content.thead')
    <tr>
        <th>#ID</th>
        <th>Título</th>
        <th>Descrição</th>
        <th><i class="fa fa-calendar"></i> Criado em</th>
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

                    {orderable: false, width: '92px', targets: -1 },
                    {className: 'hcenter vcenter', width: '20px', targets: [0] },
                    {className: 'vcenter', width: '200px', targets: 2 },
                    {className: 'vcenter', targets: [3,4] }
                ]
            });

        });

    </script>

@endsection