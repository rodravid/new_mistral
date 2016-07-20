@extends('cms::layouts.login')

@section('content')

    <div class="inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text">
                    <h1><strong>Vinci CMS</strong> Login</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 form-box">
                    <div class="form-top">
                        <div class="form-top-left">
                            <h3>Acesso</h3>
                            <p>Digite seu e-mail e senha para acessar o CMS:</p>

                            @if ($errors->count())
                                <span class="help-block text-danger"><strong>{{ $errors->first() }}</strong></span>
                            @endif

                        </div>
                        <div class="form-top-right">
                            <i class="fa fa-lock"></i>
                        </div>
                    </div>
                    <div class="form-bottom">
                        <form role="form" action="{{ url('/cms/login') }}" method="post" class="login-form">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="sr-only" for="form-username">E-mail</label>
                                <input type="text" name="email" placeholder="E-mail..." value="{{ old('email') }}" class="form-username form-control" id="form-username">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="form-password">Senha</label>
                                <input type="password" name="password" placeholder="Senha..." class="form-password form-control" id="form-password">
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-lg-6">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="remember" style="margin-top: 8px;"> Mantenha-me logado</label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-lg-6">
                                    <a class="btn btn-link pull-right" href="{{ url('/cms/password/reset') }}">Esqueceu sua senha?</a>
                                </div>
                            </div>
                            <button type="submit" class="btn">ENTRAR</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection