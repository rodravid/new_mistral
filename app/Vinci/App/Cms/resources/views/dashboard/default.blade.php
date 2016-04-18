@extends('cms::layouts.master')

@section('content')

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="jumbotron">
                    <div class="container">
                        <h2>Olá {{ $loggedUser->name }}, seja bem-vindo!</h2>
                        <p>
                            Aqui você poderá editar suas informações pessoais e alterar a sua senha.
                            Você pode ajudar a manter o seu acesso mais seguro alterando a sua senha
                            regularmente e usando uma senha forte. Para obter mais informações sobre
                            senhas fortes <a href="{{ route('cms.password.help') }}">clique aqui</a>.
                        </p>
                        <p><a class="btn btn-primary btn-lg" href="{{ route('cms.profile') }}" role="button">Editar meus dados &raquo;</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection