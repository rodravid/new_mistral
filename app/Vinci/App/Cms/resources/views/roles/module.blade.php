@extends('cms::layouts.module')

@section('scripts')
    @parent

    <script type="text/javascript">

        $('[data-checkall]').bind('change', function() {

            var $self = $(this);
            var $childrens = $self.parents('.select-container').find('input[type="checkbox"]').not($self);

            if($self.is(':checked')) {
                $childrens.prop('checked', true);
            } else {
                $childrens.prop('checked', false);
            }

            checkIfSelected();

        });

        $('.select-container').find('input[type="checkbox"]').not('[data-checkall]').bind('change', function() {

            var $self = $(this);

            if($self.is(':checked')) {
                $self.parents('.select-container').find('[data-checkall]').prop('checked', true);
            } else {
                $self.parents('.select-container').find('[data-checkall]').prop('checked', true);
            }

            checkIfSelected();

        });

        $('#toggleAllPermissions').bind('change', function() {

            var $self = $(this);

            if ($self.is(':checked')) {
                $('.select-container').find('input[type="checkbox"]').prop('checked', true);
            } else {
                $('.select-container').find('input[type="checkbox"]').prop('checked', false);
            }

        });

        function checkIfSelected() {
            var count = $('.select-container').find('input[type="checkbox"]:checked').length;

            if (count > 0) {
                $('#toggleAllPermissions').prop('checked', true);
            } else {
                $('#toggleAllPermissions').prop('checked', false);
            }
        }

        checkIfSelected();

    </script>

@endsection