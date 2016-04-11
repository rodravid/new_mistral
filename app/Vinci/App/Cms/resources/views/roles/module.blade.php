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

        });

        $('.select-container').find('input[type="checkbox"]').not('[data-checkall]').bind('change', function() {

            var $self = $(this);

            if($self.is(':checked')) {
                $self.parents('.select-container').find('[data-checkall]').prop('checked', true);
            } else {
                $self.parents('.select-container').find('[data-checkall]').prop('checked', true);
            }

        });

    </script>

@endsection