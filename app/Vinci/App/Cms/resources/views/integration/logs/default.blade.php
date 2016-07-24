@extends('cms::layouts.master')

@section('content')

    <section class="content-header">
        <h1><span class="fa fa-exclamation-triangle"></span> @yield('log.title')</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="page-header">
                                    LOG ID #{{ $log->id }} - {{ $log->present()->created_at }}
                                    @yield('log.header')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>Mensagem:</label>
                                    <textarea class="form-control" rows="1" readonly>{!! $log->message !!}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Request:</label>
                                    <textarea class="form-control" rows="10" readonly>{!! $log->request_body !!}</textarea>
                                </div>
                                @if (! empty($log->response_body))
                                    <div class="form-group">
                                        <label>Response:</label>
                                        <textarea class="form-control" rows="10" readonly>{!! $log->response_body !!}</textarea>
                                    </div>
                                @endif

                                @if ($log->type == 'error')
                                    <div class="form-group">
                                        <label>Mensagem de erro:</label>
                                        <textarea class="form-control" rows="3" readonly>{!! $log->error_message !!}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Trace:</label>
                                        <textarea class="form-control" rows="10" readonly>{!! $log->error_trace !!}</textarea>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection