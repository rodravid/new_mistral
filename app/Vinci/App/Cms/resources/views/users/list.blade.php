@extends('cms::layouts.module-list')

@section('module.content.thead')
    <tr>
        <th>#ID</th>
        <th><i class="fa fa-picture-o"></i> Foto</th>
        <th><i class="fa fa-pencil"></i> Nome</th>
        <th><i class="fa fa-envelope"></i> E-mail</th>
        <th><i class="fa fa-users"></i> Grupo</th>
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
                    {className: 'hcenter vcenter', width: '50px', targets: 1 },
                    {className: 'vcenter', width: '200px', targets: 2 },
                    {className: 'vcenter', targets: [3,4,5,6] }
                ]
            });

        });

    </script>

@endsection