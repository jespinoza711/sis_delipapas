$(document).ready(function() {

    $('#cajachica_insert').prop('disabled', true);

    $("#impo_gas").keyup(function(event) {
        var importe = $(this).val();
        if (parseFloat(importe) > 0) {
            $('#cajachica_insert').prop('disabled', false);
        } else {
            $('#cajachica_insert').prop('disabled', true);
        }
    });

    $('#cajachica_edit').prop('disabled', true);

    $("#impo_gas_e").keyup(function(event) {
        var importe = $(this).val();
        if (parseFloat(importe) > 0) {
            $('#cajachica_edit').prop('disabled', false);
        } else {
            $('#cajachica_edit').prop('disabled', true);
        }
    });

    if ($("#cpo_regcajachica").is(':visible')) {

        $('#table_regcajachica').DataTable({
            "iDisplayLength": 10,
            "aLengthMenu": [10, 25, 50],
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": base_url + "caja/paginate_caja_chica_dia",
            "sServerMethod": "POST",
            "bPaginate": true,
            "bFilter": true,
            "bSort": false,
            "displayLength": 10
        });
    }

    $(document).on('click', '.editar_regcajachica', function() {

        var tr = $(this).parent().parent();

        $("#codi_gas_e").val(tr.find("td").eq(0).html());
        $("#fech_gas_e").val(tr.find("td").eq(1).html());
        $("#nomb_usu_e").val(tr.find("td").eq(2).html());
        $("#nomb_gas_e").val(tr.find("td").eq(4).html());
        $("#impo_gas_e").val(tr.find("td").eq(5).html());
        $("#obsv_gas_e").val(tr.find("td").eq(6).find('input').val());
        $("#ModalEditarRegistroCajaChica").modal("show");
    });

});