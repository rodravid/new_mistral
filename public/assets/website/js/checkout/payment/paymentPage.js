$(document).ready(function () {
    var paymentMethod = $("input[name='payment[method]']:first").prop('checked', true).val();

    submitAjaxRequest(paymentMethod);

    $("input[name='payment[method]']").change(function () {
        var paymentMethod = $(this).val();

        if (paymentMethod != 5) {
            submitAjaxRequest(paymentMethod);
        }
    })
});

function submitAjaxRequest(paymentMethod) {
    $.ajax({
        url: 'pagamento/getInstallments',
        method: 'POST',
        data: 'paymentMethod=' + paymentMethod,
        dataType: 'json',
        success: function (dataReturn) {
            var html = "<option value='' selected>Selecione...</option>";

            $.each(dataReturn, function (index, value) {
                html += "<option value='" + index + "'>" + value + "</option>";
            });

            $("#paymentInstallments").html(html);
        }
    });
}