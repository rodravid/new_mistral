<div class="tab-pane {{ currentTabActive('#customer-integration') }}" id="customer-integration">
    <div class="row">
        <div class="col-xs-12">

            <div class="btn-group" style="margin-bottom: 20px;">
                <a href="javascript:void(0);" class="btn btn-success"
                   data-form-link
                   data-method="POST"
                   data-params='{"current-tab":"#customer-integration"}'
                   data-action="{{ route('cms.customers.edit#export-erp', [$customer->getId()]) }}"><i class="fa fa-cloud-upload"></i> Exportar agora</a>
                <a href="javascript:void(0);" class="btn btn-primary"
                   data-form-link
                   data-method="POST"
                   data-params='{"current-tab":"#customer-integration"}'
                   data-action="{{ route('cms.customers.edit#export-erp-queue', [$customer->getId()]) }}"><i class="glyphicon glyphicon-export"></i> Enviar para fila de integração</a>
            </div>

            @include('cms::integration.logs.box')
        </div>
    </div>
</div>