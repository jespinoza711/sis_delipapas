$(document).ready(function() {

    if ($("#cpo_conductor").is(':visible')) {

        $('#table_conductor').DataTable({
            "iDisplayLength": 10,
            "aLengthMenu": [10, 25, 50],
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": base_url + "conductor/paginate",
            "sServerMethod": "POST",
            "bPaginate": true,
            "bFilter": true,
            "bSort": false,
            "displayLength": 10
        });

        $(document).on('click', '.editar_conductor', function() {

            var tr = $(this).parent().parent();

            $("#id_cond_e").val(tr.find("td").eq(0).html());
            $("#dni_cond_e").val(tr.find("td").eq(1).html());
            $("#nomb_cond_e").val(tr.find("td").eq(2).html());
            $("#apel_cond_e").val(tr.find("td").eq(3).html());            
            $("#licen_cond_e").val(tr.find("td").eq(4).html());
            var observa = tr.find("td").eq(5).html();
            if (observa == "-") {
                observa = "";
            }
            $("#obsv_cond_e").val(observa);
            $("#ModalEditarConductor").modal("show");
        });
    }

});