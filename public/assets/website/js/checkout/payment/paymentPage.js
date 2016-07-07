$(document).ready(function () {
    $('#paymentTabs').responsiveTabs({
        startCollapsed: 'accordion',
        activate: function (event, tab) {
            var $radios = $(tab.selector).find('input[type="radio"]');

            if (! $($radios.selector + ':checked').length) {
                var $radio = $radios.first().prop('checked', true);

                $radio.trigger('change');

            }
        }
    });
});