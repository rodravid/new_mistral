@extends('cms::layouts.master')

@section('content')

    <section class="content-header">
        <h1>Usuários</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Usuários</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table class="table table-bordered table-striped" data-url="/cms/users/datatable">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Criado em</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection