<div class="row">

    <div class="col-lg-12">
        <div class="form-group">
            <label for="selectPaymentStatus">Status do pagamento</label>
            {!! Form::select('payment_status', $paymentStatus, $order->getPayment()->getStatus(), ['id' => 'selectPaymentStatus', 'class' => 'form-control select2', 'style' => 'width: 100%;']) !!}
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group">
            <label for="selectOrderStatus">Status do pedido</label>
            {!! Form::select('order_status', $orderStatus, $order->getStatus(), ['id' => 'selectOrderStatus', 'class' => 'form-control select2', 'style' => 'width: 100%;']) !!}
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group">
            <label for="selectOrderTrackingStatus">Status de acompanhamento (Visível ao usuário)</label>
            {!! Form::select('order_tracking_status', $trackingStatus, $order->getTrackingStatus()->getId(), ['id' => 'selectOrderTrackingStatus', 'class' => 'form-control select2', 'style' => 'width: 100%;']) !!}
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group">
            <label for="txtMailSubject">Assunto</label>
            {!! Form::text('mail_subject', null, ['id' => 'txtMailSubject', 'class' => 'form-control']) !!}
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtMailBody">E-mail</label>
            {!! Form::textarea('mail_body', null, ['id' => 'txtMailBody', 'class' => 'form-control html-editor', 'rows' => '30']) !!}
            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group">
            <div class="checkbox">
                <label for="ckbSendMail">
                    {!! Form::checkbox('send_mail', 1, true, ['id' => 'ckbSendMail']) !!}
                    Enviar e-mail ao cliente
                </label>
            </div>
        </div>
    </div>

    <div class="col-xs-12">
        <button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> Salvar</button>
    </div>

</div>

@section('scripts')
    @parent

    <script type="text/javascript">

        $(document).ready(function() {

            var orderId = '{{ $order->getId() }}';
            var $selectTrackingStatus = $('#selectOrderTrackingStatus');
            var $mailTextarea = $('#txtMailBody');
            var $txtMailSubject = $('#txtMailSubject');
            var $form = $('#frmChangeOrderStatus');

            $selectTrackingStatus.bind('change', function() {

                var trackingStatus = $(this).val();

                loadMailTemplate(trackingStatus);

            }).change();

            $form.bind('submit', function(e) {

                setTimeout(function() {

                    $form.unbind().submit();

                }, 500)

                e.preventDefault();
            });

            function loadMailTemplate(trackingStatus)
            {
                setEditorContent('<center><br><img src="/assets/cms/dist/img/loading.gif" align="center"></center>');

                $.ajax({
                    type: 'GET',
                    url: '/cms/orders/tracking-status/load-mail-template',
                    dataType: 'json',
                    data: {trackingStatusId: trackingStatus, orderId: orderId},
                    success: function(mailTemplate) {

                        var body = mailTemplate.body;

                        body = replaceAll("{w11HD}","<head",body);
                        body = replaceAll("{/w11HD}","</head",body);
                        body = replaceAll("{w11MTA}","<meta",body);
                        body = replaceAll("{w11BD}","<body",body);
                        body = replaceAll("{w11ST}","<style",body);
                        body = replaceAll("{/w11ST}","</style",body);

                        $txtMailSubject.val(mailTemplate.subject);
                        setEditorContent(body);
                    }

                });

            }

            function replaceAll(find, replace, str) {
                return str.replace(new RegExp(find, 'g'), replace);
            }

            function setEditorContent(content)
            {
                $mailTextarea.data("wysihtml5").editor.setValue(content);
            }

        });


    </script>

@endsection