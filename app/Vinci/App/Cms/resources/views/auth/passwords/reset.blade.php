@extends('cms::layouts.login')

@section('content')

    <div class="inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text">
                    <h1><strong>Vinci CMS</strong> - Alteração de senha</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 form-box">
                    <div class="form-top">
                        <div class="form-top-left">
                            <h3>Alterar senha</h3>
                            <p>Digite seu e-mail e sua nova senha:</p>

                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if ($errors->count())
                                <span class="help-block text-danger"><strong>{{ $errors->first() }}</strong></span>
                            @endif

                        </div>
                        <div class="form-top-right">
                            <i class="fa fa-lock"></i>
                        </div>
                    </div>
                    <div class="form-bottom">
                        <form role="form" action="{{ url('/cms/password/reset') }}" method="post" class="login-form">
                            {{ csrf_field() }}

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <label class="sr-only" for="form-username">E-mail</label>
                                <input type="text" name="email" placeholder="E-mail..." value="{{ old('email') }}" class="form-username form-control" id="form-username">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="form-username">Senha</label>
                                <input type="password" name="password" placeholder="Senha..." class="form-username form-control" id="form-username">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="form-username">Confirme a senha</label>
                                <input type="password" name="password_confirmation" placeholder="Confirme a senha..." class="form-username form-control" id="form-username">
                            </div>
                            <button type="submit" class="btn">ALTERAR SENHA</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
