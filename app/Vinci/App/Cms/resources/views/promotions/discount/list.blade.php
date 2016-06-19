@extends('cms::layouts.module-list')

@section('module.content.thead')
    <th>#ID</th>
    <th><i class="fa fa-pencil"></i> Título</th>
    <th><i class="fa fa-user"></i> Usuário</th>
    <th><i class="fa fa-calendar"></i> Criado em</th>
    <th><i class="fa fa-calendar"></i> Início circulação</th>
    <th><i class="fa fa-calendar"></i> Expiração</th>
    <th><i class="fa fa-edit"></i> Status</th>
    <th>Ações</th>
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
                order: [[ 0, "asc" ]],
                columnDefs: [
                    {orderable: false, width: '92px', targets: -1 },
                    {className: 'hcenter vcenter', width: '20px', targets: 0 },
                    {className: 'vcenter', targets: [1,2,3,4,5,6,7] }
                ]
            });

        });

    </script>

@endsection