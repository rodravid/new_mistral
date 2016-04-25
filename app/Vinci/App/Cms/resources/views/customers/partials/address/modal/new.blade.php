<?php
    $address = new \Vinci\Domain\Customer\Address\Address();
    $r = new ReflectionObject($address);
    $property = $r->getProperty('id');
    $property->setAccessible(true);
    $property->setValue($address, 0);
?>
<div class="modal fade" id="modalNewAddress">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['route' => 'api.customers.addresses.store', 'method' => 'POST', 'id' => 'frmNewAddress']) !!}
                <input type="hidden" name="customer" value="{{ $customer->getId() }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-flag-checkered"></i> Novo endereço</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @include('cms::customers.partials.address.form')
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@section('scripts')
    @parent

    <script type="text/javascript">

        $(function() {

            $('#frmNewAddress').bind('submit', function(e) {

                var $form = $(this);

                $.ajax({
                    type: $form.attr('method'),
                    url: $form.attr('action'),
                    data: $form.serialize(),
                    dataType: 'json',
                    success: function(response) {

                        if (response.success) {

                            $.notify({
                                message: response.message
                            },{
                                type: 'success'
                            });

                            setTimeout(function() {

                                window.location.reload();

                            }, 1000);

                        } else {

                            $.notify({
                                message: response.message[0]
                            },{
                                type: 'error'
                            });

                        }

                    }
                });

                e.preventDefault();
            });


        });

    </script>

@endsection