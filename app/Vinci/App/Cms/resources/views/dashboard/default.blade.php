@extends('cms::layouts.master')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Home</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <h2>Olá {{ $loggedUser->name }}, seja bem-vindo!</h2>
            </div>
        </div>
    </section>
    <!-- /.content -->

@endsection