$(document).ready(function() {

    function update_total() {
        var pago = $('#suel_pla').val();
        var cantidad = $('#cant_dpl').val();
        var descuento = $('#desc_dpl').val();
        if (parseFloat(cantidad) > 0 && parseFloat(descuento) >= 0) {
            var subtotal = (parseFloat(pago * cantidad)).toFixed(2);
            var total = (parseFloat(subtotal - descuento)).toFixed(2);
            $('#suto_dpl').val(subtotal);
            $('#tota_dpl').val(total);
            $('#registrodiario').prop('disabled', false);
        } else {
            $('#registrodiario').prop('disabled', true);
        }
    }

    $('#registrodiario').prop('disabled', true);
    $("#cant_dpl").keyup(function(event) {
        update_total();
    });
    $("#desc_dpl").keyup(function(event) {
        update_total();
    });
    
    $("#btnPagoPla").click(function (){
        $("#suel_pla").prop('readonly', false);
    });

    function update_total_edit() {
        var pago = $('#suel_pla_e').val();
        var cantidad = $('#cant_dpl_e').val();
        var descuento = $('#desc_dpl_e').val();
        if (parseFloat(cantidad) > 0 && parseFloat(descuento) >= 0) {
            var subtotal = (parseFloat(pago * cantidad)).toFixed(2);
            var total = (parseFloat(subtotal - descuento)).toFixed(2);
            $('#suto_dpl_e').val(subtotal);
            $('#tota_dpl_e').val(total);
            $('#registrodiario_edit').prop('disabled', false);
        } else {
            $('#registrodiario_edit').prop('disabled', true);
        }
    }

    $('#registrodiario_edit').prop('disabled', true);
    $("#cant_dpl_e").keyup(function(event) {
        update_total_edit();
    });
    $("#desc_dpl_e").keyup(function(event) {
        update_total_edit();
    });

    if ($("#cpo_registrodiario").is(':visible')) {

        $('#table_registrodiario').DataTable({
            "iDisplayLength": 10,
            "aLengthMenu": [10, 25, 50],
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": base_url + "registro/paginate_registro_diario_dia",
            "sServerMethod": "POST",
            "bPaginate": true,
            "bFilter": true,
            "bSort": false,
            "displayLength": 10
        });
    }

    $(document).on('click', '.editar_registrodiario', function() {

        var tr = $(this).parent().parent();

        $("#codi_dpl_e").val($(this).find("input").val());

        $("#fech_dpl_e").val(tr.find("td").eq(0).html());
        $("#nomb_emp_e").val(tr.find("td").eq(2).html());
        $("#cant_dpl_e").val(tr.find("td").eq(4).html());
        $("#suto_dpl_e").val(tr.find("td").eq(5).html());
        $("#desc_dpl_e").val(tr.find("td").eq(6).html());
        $("#tota_dpl_e").val(tr.find("td").eq(7).html());
        $("#obsv_dpl_e").val(tr.find("td").eq(8).find('input').val());
        $("#ModalEditarRegistroDiario").modal("show");
    });

});