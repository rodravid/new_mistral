<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $boxTitle or 'Log de integração com ERP' }}</h3>
    </div>
    <div class="box-body">
        @if($integrationLogs->count())
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#ID</th>
                    <th><i class="fa fa-user"></i> Usuário</th>
                    @if(isset($with['request_type']))
                        <th><i class="fa fa-edit"></i> Tipo</th>
                    @endif
                    <th><i class="fa fa-edit"></i> Status</th>
                    <th><i class="fa fa-edit"></i> Mensagem</th>
                    <th><i class="fa fa-calendar"></i> Data</th>
                    @if($loggedUser->isSuperAdmin())
                        <th><i class="fa fa-edit"></i> Ações</th>
                    @endif
                </tr>
                </thead>
                @foreach ($integrationLogs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->user }}</td>
                        @if(isset($with['request_type']))
                            <td>{!! $log->present()->request_type !!}</td>
                        @endif
                        <td>{!! $log->present()->status_html !!}</td>
                        <td>{{ $log->message }}</td>
                        <td>{{ $log->present()->created_at }}</td>
                        @if($loggedUser->isSuperAdmin())
                            <td><div class="btn-group btn-group-xs"><a href="{{ route('cms.integration.logs.show', [$log->resource_type, $log->id]) }}" target="_blank" class="btn btn-info"><i class="fa fa-eye"></i> Visualizar</a></div></td>
                        @endif
                    </tr>
                @endforeach
            </table>
        @else
            <h4 class="text-center">Nenhum log encontrado.</h4>
        @endif
    </div>
</div>