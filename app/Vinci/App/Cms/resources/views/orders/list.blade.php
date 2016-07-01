@extends('cms::layouts.module')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        @if($currentModule->hasParent())
            <li><i class="{{ $currentModule->getParent()->getIcon() }}"></i> {{ $currentModule->getParent()->getTitle() }}</li>
        @endif
        <li class="active">{{ $currentModule->getTitle() }}</li>
    </ol>
@endsection

@section('module.content')

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" data-url="{{ $currentModule->getDatatableUrl() }}">
                                        <thead>
                                        <tr>
                                            <th>#ID</th>
                                            <th><i class="fa fa-tag"></i> Número</th>
                                            <th><i class="fa fa-user"></i> Cliente</th>
                                            <th><i class="fa fa-money"></i> Valor</th>
                                            <th><i class="fa fa-calendar"></i> Criado em</th>
                                            <th><i class="fa fa-edit"></i> Status</th>
                                            <th>Ações</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                    {orderable: false, width: '170px', targets: -1 },
                    {className: 'hcenter vcenter', width: '20px', targets: [0] },
                    {className: 'vcenter', targets: [1,2,3,4,5,6] }
                ]
            });

        });

    </script>

@endsection