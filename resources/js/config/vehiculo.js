$(document).ready(function() {

    if ($("#cpo_vehiculo").is(':visible')) {

        $('#table_vehiculo').DataTable({
            "iDisplayLength": 10,
            "aLengthMenu": [10, 25, 50],
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": base_url + "vehiculo/paginate",
            "sServerMethod": "POST",
            "bPaginate": true,
            "bFilter": true,
            "bSort": false,
            "displayLength": 10
        });

        $(document).on('click', '.editar_vehiculo', function() {

            var tr = $(this).parent().parent();

            $("#id_vehi_e").val(tr.find("td").eq(0).html());
            $("#placa_vehi_e").val(tr.find("td").eq(1).html());
            $("#marca_vehi_e").val(tr.find("td").eq(2).html());
            var observa = tr.find("td").eq(3).html();
            if (observa == "-") {
                observa = "";
            }
            $("#obsv_vehi_e").val(observa);
            $("#ModalEditarVehiculo").modal("show");
        });
    }

});