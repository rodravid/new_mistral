@extends('cms::layouts.module')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
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
                                <div class="panel">
                                    <div class="btn-group">
                                        <a href="{{ route('cms.deadline.create') }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> Novo prazo de entrega</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" data-url="{{ $currentModule->getDatatableUrl() }}">
                                        <thead>
                                        <tr>
                                            <th>#ID</th>
                                            <th><i class="fa fa-file-text-o"></i> Descrição</th>
                                            <th><i class="fa fa-calendar-times-o"></i> Prazo de entrega em dias</th>
                                            <th><i class="fa fa-user"></i> Usuário</th>
                                            <th><i class="fa fa-calendar"></i> Criado em</th>
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
                ajax: $table.data('url'),
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