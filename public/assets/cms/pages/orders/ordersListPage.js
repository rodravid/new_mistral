$(document).ready(function () {
    $(".btn.btn-success").click(function (event) {
        var itemsPerPage = $("#itemsPerPage").val();
        $("#itemsPerPage").val('0');

        var filters = $('#filters').serialize() + '&itemsPerPage=0';
        window.open($(this).prop('href') + '?' + filters);

        $("#itemsPerPage").val(itemsPerPage);

        event.preventDefault();
    });
});

$(function(){
    $('#startDatePicker').datetimepicker();
    $('#endDatePicker').datetimepicker();
});