<div class="tab-pane {{ currentTabActive('#tabProducts') }}" id="tabProducts">
    <div class="row">

        @include('cms::layouts.partials.box.products-filters')

        <div class="col-xs-12" style="margin-top: 20px;">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" data-url="{{ route('cms.' . $currentModule->getName() . '.edit#items-datatable', [$promotion->getId()]) }}">
                    <thead>
                    <tr>
                        <th>#ID</th>
                        <th>SKU</th>
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

        var currentPage = 1;
        var $tabs = '';
        var currentTabTarget = '';
        var keyword = '';

        $(function() {

            var promotion_id = '{{$promotion->id }}';
            var $body = $('body');

            $tabs = $('[data-toggle="tabajax"]');

            $tabs.bind('click', function (e) {

                setPage(1);
                keyword = '';
                loadTab($(this).attr('data-target'));

                e.preventDefault();
                return false;
            });

//            $body.delegate('.pagination li a[data-value]', 'click', function () {
//
//                setPage($(this).data('value'));
//                loadTab(currentTabTarget);
//
//            });
//
//            if (promotion_id > 0) {
//                loadTab('#all-products');
//            }

            var dropzone;
            var oldFile;

            $('#btnImportProducts').dropzone({
                url: '/cms/promotions/' + promotion_id + '/items/add-from-file',
                uploadMultiple: false,
                maxFiles: 1,
                acceptedFiles: '.xls,.xlsx',
                previewsContainer: '#uploadPreview',
                init: function () {
                    dropzone = this;

                    $('#btnImportProducts').bind('click', function () {
                        dropzone.removeAllFiles();
                    });

                },
                sending: function (file, xhr, formData) {

                    formData.append('promotion_id', '{{ $promotion->id }}');
                    formData.append('_token', '{{ csrf_token() }}');

                    $("#upload-message").hide();
                    $('.upload-progress').fadeIn();

                },
                success: function (file, response) {

                    oldFile = file;

                    $("#upload-message").fadeIn();

                    if (! response.error) {

                        reloadTable();

                        swal({
                            title: "Pronto!",
                            text: response.message,
                            type: 'success',
                            html: true
                        });

                        $("#upload-message").html("<i class='fa fa-thumbs-o-up green'></i> Importado com sucesso!");
                        $('#uploadProgress').css('width', '0');
                        $('.upload-progress').hide();

                    } else {

                        swal('Ops! Houve um erro...', response.message, 'error');

                        $("#upload-message").html("<i class='fa fa-thumbs-o-down red'></i> Falha ao importar.");

                    }

                },
                uploadprogress: function (file, progress) {

                    $('#uploadProgress').css('width', progress + '%');

                }
            });

            var $container = $("#containerProductsFilters");
            var $selectProducts = $container.find('#selectProducts');
            var $selectCountries = $container.find('#selectCountries');
            var $selectRegions = $container.find('#selectRegions');
            var $selectProducers = $container.find('#selectProducers');
            var $selectTypes = $container.find('#selectTypes');

            $selectProducts.select2({placeholder: "Selecione os produtos"});
            $selectCountries.select2({placeholder: "Selecione os países"});
            $selectRegions.select2({placeholder: "Selecione as regioes"});
            $selectProducers.select2({placeholder: "Selecione os produtores"});
            $selectTypes.select2({placeholder: "Selecione os tipos de vinho"});

            var $containerExchangeRate = $('#containerExchangeRate');
            var $containerDiscountValue = $('#containerDiscountValue');

            $('#addProducts').bind('click', function(e) {

                var products = $selectProducts.val();

                if (products == null) {
                    swal('', 'Nenhum produto foi selecionado.', 'info');
                    return false;
                }

                swal({
                    title: "Adicionando produtos na promoção...<br /><center><img src='/assets/cms/dist/img/loading.gif' align='center' style='margin-top: 20px;'></center>",
                    text: "Por favor aguarde, isso pode levar alguns minutos.",
                    html: true,
                    showConfirmButton: false
                });

                $.ajax({
                    type: 'POST',
                    url: '/cms/promotions/' + promotion_id + '/items/add',
                    dataType: 'json',
                    data: {id: promotion_id, products: products},
                    success: function(response) {

                        if (! response.error) {

                            $selectProducts.select2('val', '');
                            reloadTable();

                            swal({
                                title: "Pronto!",
                                text: response.message,
                                type: 'success',
                                html: true
                            });

                        } else {

                            swal('Ops! Houve um erro..', response.message, 'error');
                        }

                    }
                });

                e.preventDefault();
            });

            $('#btnAddProducts').bind('click', function(e) {

                var countries = $selectCountries.val();
                var regions = $selectRegions.val();
                var producers = $selectProducers.val();
                var types = $selectTypes.val();

                if (countries == null && regions == null && producers == null && types == null) {
                    swal('', 'Nenhum filtro foi selecionado.', 'info');
                    return false;
                }

                swal({
                    title: "Adicionando produtos na promoção...<br /><center><img src='/assets/cms/dist/img/loading.gif' align='center' style='margin-top: 20px;'></center>",
                    text: "Por favor aguarde, isso pode levar alguns minutos.",
                    html: true,
                    showConfirmButton: false
                });

                $.ajax({
                    type: 'POST',
                    url: '/cms/promotions/' + promotion_id + '/items/add-from-filters',
                    dataType: 'json',
                    data: {id: promotion_id, countries: countries, regions: regions, producers: producers, types: types},
                    success: function(response) {

                        if (! response.error) {

                            resetSelects();
                            reloadTable();

                            swal({
                                title: "Pronto!",
                                text: response.message,
                                type: 'success',
                                html: true
                            });

                        } else {

                            swal('Ops! Houve um erro..', response.message, 'error');
                        }

                    }
                });

                e.preventDefault();
            });

            $('#btnAddAllProducts').bind('click', function(e) {

                swal({
                    title: 'Atenção',
                    text: "Deseja realmente adicionar todos os produtos do site na promoção?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    cancelButtonText: "Não",
                    confirmButtonText: "Sim",
                    closeOnConfirm: false
                }, function() {

                    swal({
                        title: "Adicionando todos os produtos do site na promoção...<br /><center><img src='/assets/cms/dist/img/loading.gif' align='center' style='margin-top: 20px;'></center>",
                        text: "Por favor aguarde, isso pode levar alguns minutos.",
                        html: true,
                        showConfirmButton: false
                    });

                    $.ajax({
                        type: 'POST',
                        url: '/cms/promotions/' + promotion_id + '/items/add-all',
                        dataType: 'json',
                        data: {id: promotion_id, all: true},
                        success: function(response) {

                            if (!response.error) {

                                reloadTable();
                                loadFirstTab();

                                swal({
                                    title: "Pronto!",
                                    text: response.message,
                                    type: 'success',
                                    html: true
                                });

                            } else {

                                swal('Ops! Houve um erro..', response.message, 'error');
                            }

                        }
                    });

                });

                e.preventDefault();

            });

            function resetSelects() {
                $selectCountries.select2('val', '');
                $selectRegions.select2('val', '');
                $selectProducers.select2('val', '');
                $selectTypes.select2('val', '');
            }

            $body.delegate('#selectAll', 'change', function(e) {

                $items = $(currentTabTarget).find('input.item-box');

                if ($(this).is(':checked')) {
                    $.each($items, function (i, item) {
                        $(item).prop('checked', true);
                    });
                } else {
                    $.each($items, function (i, item) {
                        $(item).prop('checked', false);
                    });
                }

                e.preventDefault();
            });

            $body.delegate('#btnSearch', 'click', function(e) {

                doSearch();
                e.preventDefault();
            });

            $body.delegate('#txtSearch', 'keypress', function(e) {
                if (e.keyCode == 13) {
                    doSearch();
                    return false;
                }
            });

            function doSearch() {

                var $txtSearch = $body.find('#txtSearch');
                keyword = $txtSearch.val();

                loadFirstTab();
            }

            $body.delegate('#btnRemoveSelected', 'click', function(e) {

                var items = getSelectedItems();

                if (items.length <= 0) {
                    swal('', 'Nenhum item foi selecionado.', 'info');
                    return false;
                }

                swal({
                    title: 'Atenção',
                    text: "Deseja realmente remover " + items.length + " produto(s) da promoção?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    cancelButtonText: "Não",
                    confirmButtonText: "Sim",
                    closeOnConfirm: false
                }, function() {

                    $.ajax({
                        type: 'POST',
                        url: '/cms/promocao-desconto/promocoes/delProducts',
                        dataType: 'json',
                        data: {promotion_id: promotion_id, products: items},
                        success: function (response) {

                            if (!response.error) {

                                reloadCurrentTab();
                                swal('Pronto!', response.message, 'success');
                            } else {
                                swal('Ops!', response.message, 'error');
                            }
                        }
                    });

                });

                e.preventDefault();
            });

            function getSelectedItems() {

                var items = [];
                $.each($(currentTabTarget).find('input.item-box:checked'), function(i, item) {
                    items.push($(item).val());
                });

                return items;
            }

            $('#frmDiscountType').bind('change', function () {

                var $self = $(this);
                var value = $self.val();

                if (value == 'exchange-rate') {

                    $containerDiscountValue.hide().find('input').val('');
                    $containerExchangeRate.show();

                } else {

                    $containerExchangeRate.hide().find('input').val('');
                    $containerDiscountValue.show();
                }

            }).change();



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
                    {className: 'vcenter', targets: [1,2,3,4,5] }
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



        function loadFirstTab()
        {
            setPage(1);
            loadTab('#all-products');
        }

        function reloadCurrentTab() {
            setPage(1);
            loadTab(currentTabTarget);
        }

        function loadTab(target) {

            var $tab = $tabs.filter('[data-target="' + target + '"]');

            var loadurl = $tab.attr('href'),
                    targ = $tab.attr('data-target'),
                    $target = $(targ);

            $target.html("<center><img src='/assets/cms/dist/img/loading.gif' align='center' style='margin-top: 20px;'></center>");
            $tab.tab('show');

            $tabs.removeClass('active');
            $tab.addClass('active');

            $('body').find('#txtSearch').remove();

            currentTabTarget = targ;

            var params = {};
            if ($tab.attr('data-params') !== undefined && $tab.attr('data-params') !== '') {
                params = JSON.parse($tab.attr('data-params'));
            }

            params.pg = currentPage;
            params.keyword = keyword;

            $.ajax({
                url: loadurl,
                type: "POST",
                data: params,
                dataType: 'json',
                success: function (data) {
                    $target.html(data.html);
                }
            });

        }

        function delProductPromotion(id, product_id) {

            swal({
                title: 'Atenção',
                text: "Deseja realmente remover este produto da promoção?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                cancelButtonText: "Não",
                confirmButtonText: "Sim",
                closeOnConfirm: false
            }, function() {

                if (id > 0) {
                    $.ajax({
                        url: "/cms/promocao-desconto/promocoes/delProducts",
                        type: "POST",
                        data: {promotion_id: id, products: product_id},
                        dataType: 'json',
                        success: function (data) {
                            swal('Pronto!', 'O produto foi removido da promoção.', 'success');
                            reloadCurrentTab();
                        }
                    });
                }

            });

        }

        function setPage(value) {
            currentPage = value;
        }

    </script>

@endsection