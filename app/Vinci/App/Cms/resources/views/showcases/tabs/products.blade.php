<div class="tab-pane {{ currentTabActive('#showcaseProducts') }}" id="showcaseProducts">
    <div class="row">
        <div class="col-xs-12">

            <div class="table-responsive">
                <table class="table table-bordered table-striped" data-url="{{ route('cms.home-showcases.edit#items-datatable', [$showcase->getId()]) }}">
                    <thead>
                    <tr>
                        <th>#ID</th>
                        <th><i class="fa fa-pencil"></i> Título</th>
                        <th><i class="fa fa-list-ol"></i> Ordem</th>
                        <th><i class="fa fa-calendar"></i> Adicinado em</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
</div>

@section('scripts')
    @parent

    <script type="text/javascript">

        $(function() {

            var $table = $('.table');

            $table.DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": $table.data('url'),
                    "type": "POST"
                },
                searchDelay: 600,
                order: [[ 1, "asc" ]],
                columnDefs: [
                    {orderable: false, width: '92px', targets: -1 },
                    {className: 'hcenter vcenter', width: '20px', targets: 0 },
                    {className: 'hcenter vcenter', width: '70px', targets: 2 },
                    {className: 'hcenter vcenter', width: '120px', targets: 3 },
                    {className: 'vcenter', targets: [2,3,4] }
                ]
            });

        });

    </script>

@endsection