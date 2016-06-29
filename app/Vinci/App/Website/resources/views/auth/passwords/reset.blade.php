@extends('website::layouts.master')

@section('content')
    <div class="header-internal template1-bg">
        @include('website::layouts.menu')
        <div class="row">

            <h1 class="internal-subtitle">Nova senha</h1>

            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a class="breadcrumb-link" href="/"><span>Início</span></a> >
                </li>

                <li class="breadcrumb-item">
                    <span>Nova senha</span>
                </li>
            </ul>

        </div>
    </div>

    <div class="row">

        <article class="wrap-content-register">

            <div class="pg-log">
                   <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                        {!! csrf_field() !!}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <ul class="list-form-register">

                        <li>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input type="email" class="email input-register full" name="email" value="{{ $email or old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        </li>

                        <li>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Nova senha</label>

                            <div class="col-md-6">
                                <input type="password" class="email input-register full" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        </li>

                        <li>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Confirmar Nova senha</label>
                            <div class="col-md-6">
                                <input type="password" class="email input-register full" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        </li>

                        <li>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                              <!--   <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-refresh"></i>Reset Password
                                </button> -->
                                <button type="submit" class="bt-default-full bt-middle template1">Salvar nova senha <span class="arrow-link">></span></button>
                            </div>
                        </div>

                        </li>

                        </ul>
                    </form>
            </div>


        </article>

    </div>

    @include('website::layouts.footer')

@stop
