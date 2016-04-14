@extends('cms::layouts.module-list')

@section('module.content.thead')
    <th>#ID</th>
    <th><i class="fa fa-list-ol"></i> Ordem</th>
    <th><i class="fa fa-picture-o"></i> Imagem</th>
    <th><i class="fa fa-pencil"></i> Título</th>
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
                ajax: $table.data('url'),
                searchDelay: 600,
                order: [[ 1, "asc" ]],
                columnDefs: [
                    {orderable: false, width: '92px', targets: -1 },
                    {className: 'hcenter vcenter', width: '20px', targets: 0 },
                    {className: 'hcenter vcenter', width: '70px', targets: 1 },
                    {className: 'hcenter vcenter', width: '70px', targets: 2 },
                    {className: 'vcenter', width: '200px', targets: 2 },
                    {className: 'vcenter', targets: [3,4,5,6] }
                ]
            });

        });

    </script>

@endsection