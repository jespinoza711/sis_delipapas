$(document).ready(function() {

    if ($("#cpo_planilla").is(':visible')) {

        var planillas;

        $.ajax({
            url: base_url + 'ajustes/get_planilla',
            type: 'post',
            success: function(data) {
                planillas = $.parseJSON(data);
//                console.log(planillas);
            }
        });

        $('#table_planilla').DataTable({
            "iDisplayLength": 10,
            "aLengthMenu": [10, 25, 50],
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": base_url + "ajustes/paginate_planilla",
            "sServerMethod": "POST",
            "bPaginate": true,
            "bFilter": true,
            "bSort": false,
            "displayLength": 10
        });

        $(document).on('click', '.editar_planilla', function() {

            var tr = $(this).parent().parent();

            $("#codi_pla_e").val(tr.find("td").eq(0).html());
            $("#fech_pla_e").val(tr.find("td").eq(1).html());            
            $("#suel_pla_e").val(tr.find("td").eq(2).html());
            var observa = tr.find("td").eq(3).html();
            if (observa == "-") {
                observa = "";
            }
            $("#obsv_pla_e").val(observa);
            $("#ModalEditarPlanilla").modal("show");
        });

        $("#form_planilla").submit(function() {
            return true;
        });

        $("#form_planilla_edit").submit(function() {
            return true;
        });
    }

});