@extends('cms::layouts.master')

@section('content')

    <div>
        <div class="page-title">
            <div class="title_left">
                <h3>Usuários</h3>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <table id="example" class="table table-striped responsive-utilities jambo_table">
                            <thead>
                                <tr class="headings">
                                    <th><input type="checkbox" class="tableflat"></th>
                                    <th>#Id</th>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Criado em</th>
                                    <th class=" no-link last"><span class="nobr">Action</span></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection