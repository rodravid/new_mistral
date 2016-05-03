@extends('cms::layouts.module-list')

@section('module.content.thead')
    <th>#ID</th>
    <th><i class="fa fa-picture-o"></i> Mapa</th>
    <th><i class="fa fa-pencil"></i> Nome</th>
    <th><i class="fa fa-calendar"></i> Criado em</th>
    <th><i class="fa fa-eye"></i> Visível no site</th>
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
                columnDefs: [
                    {orderable: false, targets: 1 },
                    {orderable: false, width: '92px', targets: -1 },
                    {className: 'hcenter vcenter', width: '70px', targets: 1 },
                    {className: 'vcenter', width: '200px', targets: 2 },
                    {className: 'hcenter vcenter', targets: 0 },
                    {className: 'vcenter', targets: [0,2,3,4,5,6] }
                ]
            });

        });

    </script>

@endsection