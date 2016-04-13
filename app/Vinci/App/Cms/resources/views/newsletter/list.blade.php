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
                                        <a href="{{ route('cms.newsletter.export') }}" class="btn btn-success"><span class="glyphicon glyphicon-export"></span> Exportar para excel</a>
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
                                            <th><i class="fa fa-pencil"></i> Nome</th>
                                            <th><i class="fa fa-envelope"></i> E-mail</th>
                                            <th><i class="fa fa-bullhorn"></i> Lançamentos e promoções</th>
                                            <th><i class="fa fa-star"></i> Grandes jantares e eventos</th>
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
                searchDelay: 600
            });

        });

    </script>

@endsection