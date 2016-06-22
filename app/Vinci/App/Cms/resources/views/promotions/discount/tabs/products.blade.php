<div class="tab-pane {{ currentTabActive('#tabProducts') }}" id="tabProducts">
    <div class="row">

        <div class="col-xs-12">
            <div class="form-group">
                <label for="txtShowcasePosition">Adicionar produto à promoção</label>
                <select name="product" id="selectProduct" class="form-control" style="width: 100%;"></select>
            </div>
        </div>

        <div class="col-xs-12">
            <button type="button" id="btnAddProduct" class="btn btn-success"><i class="fa fa-plus-circle"></i> Adicionar</button>
        </div>

        <div class="col-xs-12" style="margin-top: 20px;">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" data-url="{{ route('cms.' . $currentModule->getName() . '.edit#items-datatable', [$promotion->getId()]) }}">
                    <thead>
                    <tr>
                        <th>#SKU</th>
                        <th><i class="fa fa-pencil"></i> Título</th>
                        <th><i class="fa fa-cube"></i> Estoque</th>
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
                    url: $table.data('url'),
                    type: "POST",
                    data: function(data) {

                        data.promotion = {
                            id: '{{ $promotion->getId() }}',
                            type: '{{ $promotion->getType() }}'
                        };

                    }
                },
                searchDelay: 600,
                order: [[ 0, "asc" ]],
                columnDefs: [
                    {orderable: false, width: '92px', targets: -1 },
                    {className: 'hcenter vcenter', width: '20px', targets: 0 },
                    {className: 'hcenter vcenter', width: '70px', targets: 2 },
                    {className: 'hcenter vcenter', width: '120px', targets: 3 },
                    {className: 'vcenter', targets: [2,3] }
                ]
            });

            function reloadTable()
            {
                $table.DataTable().ajax.reload();
            }

            var $selectProduct = $('#selectProduct');

            $selectProduct.select2({
                minimumInputLength: 2,
                tags: [],
                ajax: {
                    url: '/cms/products/select',
                    dataType: 'json',
                    type: "GET",
                    delay: 250
                }
            });

            $('#btnAddProduct').bind('click', function(e) {

                var productId = $selectProduct.val();

                $.ajax({
                    url: '/cms/promotions/discount-promotion/{{ $promotion->id }}/items',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        promotionId: '{{ $promotion->id }}',
                        productId: productId
                    },
                    success: function () {

                        reloadTable();

                        $selectProduct.val('');
                        $selectProduct.text('');
                        $selectProduct.find('option:first').prop('selected', true);
                        $selectProduct.trigger('change');

                        swal('Pronto!', 'O produto foi adicionado na promoção com sucesso!', 'success');
                    },
                    error: function() {
                        swal('Ops!', 'Não foi possível adicionar o produto na promoção. Tente novamente.', 'error')
                    }
                });

                e.preventDefault();
            });

            $('body').delegate('[data-remove-item]', 'click', function(e) {

                var $self = $(this);

                function submitForm()
                {
                    var method = $self.data('method');
                    var action = $self.data('action');

                    $.ajax({
                        type: method,
                        url: action,
                        dataType: 'json',
                        success: function(response) {

                            reloadTable();

                            swal('Pronto!', response.message, 'success');

                        },
                        error: function(response) {

                            swal('Ops!', response.message, 'error');

                        }
                    });

                    return true;
                }

                var confirmTitle = $self.data('confirm-title');
                var confirmText = $self.data('confirm-text');

                if (typeof confirmTitle !== typeof undefined && confirmTitle !== false) {

                    swal({
                        title: confirmTitle,
                        text: confirmText,
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Sim",
                        cancelButtonText: "Não",
                        closeOnConfirm: false
                    }, function() {

                        submitForm();

                    });

                }

                e.preventDefault();
            });


        });

    </script>

@endsection