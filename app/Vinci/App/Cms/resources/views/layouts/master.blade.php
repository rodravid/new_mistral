<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>@yield('title', 'CMS Vinci' . (isset($currentModule) ? ' - ' . $currentModule->getTitle() : ''))</title>

    @section('styles')

        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="{{ asset_cms('bootstrap/css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Animate -->
        <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{ asset_cms('plugins/iCheck/all.css') }}">
        <!-- Morris chart -->
        <link rel="stylesheet" href="{{ asset_cms('plugins/morris/morris.css') }}">
        <!-- jvectormap -->
        <link rel="stylesheet" href="{{ asset_cms('plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
        <!-- Date Picker -->
        <link rel="stylesheet" href="{{ asset_cms('plugins/datepicker/datepicker3.css') }}">
        <!-- Date Picker -->
        <link rel="stylesheet" href="{{ asset_cms('plugins/datepicker/bootstrap-datetimepicker.min.css') }}">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="{{ asset_cms('plugins/daterangepicker/daterangepicker-bs3.css') }}">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="{{ asset_cms('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset_cms('plugins/datatables/dataTables.bootstrap.css') }}">
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset_cms('plugins/select2/select2.min.css') }}">
        <!-- Sweet alert -->
        <link rel="stylesheet" href="{{ asset_cms('plugins/sweetalert/dist/sweetalert.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset_cms('dist/css/AdminLTE.min.css') }}">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{ asset_cms('dist/css/skins/_all-skins.min.css') }}">

        <style>
            td.vcenter {
                vertical-align: middle !important;
            }

            td.hcenter {
                text-align: center !important;
            }
        </style>

    @show

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition sidebar-mini {{ $loggedUser->settings()->get('theme', 'skin-blue') }}">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="/cms" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="{{ asset_cms('dist/img/logo-v.png') }}"></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><img src="{{ asset_cms('dist/img/logo-vinci.png') }}"></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    @if(isset($currentDollar))
                        <li class="hidden-xs"><a href="{{ route('cms.dollar.list') }}"><span><i class="fa fa-money"></i> Dólar: <b>{{ $currentDollar->amount }}</b></span></a></li>
                    @endif
                    @if(isset($currentDeadline))
                        <li class="hidden-xs"><a href="{{ route('cms.deadline.list') }}"><span><i class="fa fa-calendar-check-o"></i> Entrega: <b>{{ $currentDeadline->days_written }}</b></span></a></li>
                    @endif
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ $loggedUser->profile_photo }}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{ $loggedUser->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{{ $loggedUser->profile_photo }}" class="img-circle" alt="User Image">

                                <p>
                                    {{ $loggedUser->name }} {{ $loggedUser->office }}
                                    <small>Membro desde {{ $loggedUser->getCreatedAt()->format('M/Y') }}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ route('cms.profile') }}" class="btn btn-default btn-flat">Perfil</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('cms.logout') }}" class="btn btn-default btn-flat">Sair</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Left side column. contains the logo and sidebar -->
    @include('cms::layouts.partials.menu')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->

    @include('cms::layouts.partials.footer')
    @include('cms::layouts.partials.sidebar')

</div>
<!-- ./wrapper -->

@section('scripts')

    <!-- jQuery 2.2.0 -->
    <script src="{{ asset_cms('plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset_cms('plugins/jQueryUI/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.6 -->
    <script src="{{ asset_cms('bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="{{ asset_cms('plugins/morris/morris.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset_cms('plugins/sparkline/jquery.sparkline.min.js') }}"></script>
    <!-- jvectormap -->
    <script src="{{ asset_cms('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset_cms('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset_cms('plugins/knob/jquery.knob.js') }}"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="{{ asset_cms('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- datepicker -->
    <script src="{{ asset_cms('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset_cms('plugins/datepicker/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset_cms('plugins/datepicker/locales/bootstrap-datepicker.pt-BR.js') }}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset_cms('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <!-- Slimscroll -->
    <script src="{{ asset_cms('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset_cms('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset_cms('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset_cms('plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset_cms('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset_cms('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset_cms('plugins/fastclick/fastclick.js') }}"></script>
    <!-- Notify -->
    <script src="{{ asset_cms('plugins/bootstrap-notify/dist/bootstrap-notify.min.js') }}"></script>
    <!-- iCheck 1.0.1 -->
    <script src="{{ asset_cms('plugins/iCheck/icheck.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset_cms('plugins/select2/select2.full.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset_cms('plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
    <!-- AngularJS -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset_cms('dist/js/app.min.js') }}"></script>
    <script src="{{ asset_cms('dist/js/skins.js') }}"></script>

    <script>

        (function() {
            var $activeItem = $('#mainMenu').find('li.active');
            $activeItem.parents('li').addClass('active');
            $activeItem.parents('ul.treeview-menu').addClass('menu-open').slideDown();
        }());

        $(function () {

            $(".select2").select2();

            $("[data-mask]").inputmask();

            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });

            $('.html-editor').wysihtml5();

            $.extend( true, $.fn.dataTable.defaults, {
                "language": {
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "_MENU_ resultados por página",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                        "sSortDescending": ": Ordenar colunas de forma descendente"
                    }
                }
            });

            $.each($('.table[data-table-default]'), function(i, table) {

                var $table = $(table);

                $(table).DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: $table.data('url'),
                    searchDelay: 600,
                    columnDefs: [
                        {orderable: false, width: '92px', targets: -1 },
                    ]
                });

            });

            $('body').delegate('[data-form-link]', 'click', function(e) {

                var $self = $(this);

                function submitForm()
                {
                    var method = $self.data('method');
                    var action = $self.data('action');
                    var $form = $('<form method="POST" action="' + action + '"><input type="hidden" name="_method" value="' + method + '"></form>');
                    $form.submit();
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

                } else {
                    submitForm();
                }

                e.preventDefault();
            });

        });

    </script>

    <script type="text/javascript">

        $(function() {

            if ($('#txtStartsAtPicker').length > 0) {

                $("#clearDate").click(function () {
                    $('#endText').html('<strong>Nunca expira!</strong>');
                    $(this).parent().find('input').val('');
                    $(this).parents('.publishing-fields').first().slideUp(500);
                });

                function setStartsAtText() {
                    var publishingDate = $('#txtStartsAtPicker').data("DateTimePicker").getDate();
                    var currentDate = new Date();
                    var startDate = moment(publishingDate);

                    if (publishingDate <= currentDate) {
                        $('#startText').html('Publicar <strong>imediatamente</strong>');
                    } else {
                        $('#startText').html('Publicar em <strong>' + startDate.format('DD/MM/YYYY HH:mm') + '</strong>');
                    }
                }

                function setExpirationAtText() {
                    var finishingDate = $('#txtExpirationAtPicker').data("DateTimePicker").getDate();
                    var endDate = moment(finishingDate);
                    $('#endText').html('Publicado até <strong>' + endDate.format('DD/MM/YYYY HH:mm') + '</strong>');
                }

                $('#txtStartsAtPicker').datetimepicker({
                    language: 'pt-BR',
                    format: 'DD/MM/YYYY HH:mm',
                    pick12HourFormat: false
                }).bind('dp.change', function () {
                    setStartsAtText();
                });

                setStartsAtText();

                $('#txtExpirationAtPicker').datetimepicker({
                    language: 'pt-BR',
                    format: 'DD/MM/YYYY HH:mm',
                    pick12HourFormat: false
                }).bind('dp.change', function () {
                    setExpirationAtText();
                });

                (function () {
                    var finishingDate = $('#txtExpirationAtPicker').data("DateTimePicker").getDate();

                    if ($('#txtExpirationAtPicker').data('has-expiration')) {
                        var endDate = moment(finishingDate);
                        $('#endText').html('Publicado até <strong>' + endDate.format('DD/MM/YYYY HH:mm') + '</strong>');
                    } else {
                        $('#endText').html('<strong>Nunca expira!</strong>');
                    }
                }());

                $('#txtStartsAtPicker').data("DateTimePicker").setMinDate(moment().startOf('day'));
                $('#txtExpirationAtPicker').data("DateTimePicker").setMinDate(moment().startOf('day'));

                $('.publishing-action').click(function () {
                    var fields = $(this).siblings('.publishing-fields');
                    if (fields.is(':hidden'))
                        fields.stop().slideDown(500);
                    else
                        fields.stop().slideUp(500);
                });

            }

        });

    </script>

    @if (Session::has('flash_notification.message'))
        <script>
            $.notify({
                message: '{{ Session::get('flash_notification.message') }}'
            },{
                type: '{{ Session::get('flash_notification.level') }}'
            });
        </script>
    @endif

    @if($errors->has())
        <script>
            $.notify({
                message: ' {{ $errors->first() }}'
            },{
                type: 'error'
            });
        </script>
    @endif

@show
</body>
</html>
