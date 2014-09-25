$(document).ready(function() {

    function update_total() {
        var pago = $('#suel_pla').val();
        var cantidad = $('#cant_dpl').val();
        var descuento = $('#desc_dpl').val();
        var subtotal = (parseFloat(pago * cantidad)).toFixed(2);
        var total = (parseFloat(subtotal - descuento)).toFixed(2);
        $('#suto_dpl').val(subtotal);
        $('#tota_dpl').val(total);
    }

    $("#cant_dpl").keyup(function(event) {
        update_total();
    });
    $("#desc_dpl").keyup(function(event) {
        update_total();
    });

    if ($("#cpo_registrodiario").is(':visible')) {


    }

});