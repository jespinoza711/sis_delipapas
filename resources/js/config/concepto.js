$(document).ready(function() {

    if ($("#cpo_concepto").is(':visible')) {

        var conceptos;

        $.ajax({
            url: base_url + 'ajustes/get_concepto',
            type: 'post',
            success: function(data) {
                conceptos = $.parseJSON(data);
                console.log(conceptos);
            }
        });

        $('#table_concepto').DataTable({
            "iDisplayLength": 10,
            "aLengthMenu": [10, 25, 50],
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": base_url + "ajustes/paginate_concepto",
            "sServerMethod": "POST",
            "bPaginate": true,
            "bFilter": true,
            "bSort": false,
            "displayLength": 10
        });

        $(document).on('click', '.editar_concepto', function() {

            var tr = $(this).parent().parent();

            $("#codi_con_e").val(tr.find("td").eq(0).html());
            $("#fech_con_e").val(tr.find("td").eq(1).html());            
            $("#nomb_usu_e").val(tr.find("td").eq(2).html());
            $("#nomb_con_e").val(tr.find("td").eq(3).html());
            $("#ModalEditarConcepto").modal("show");
        });

        $("#form_concepto").submit(function() {
            return true;
        });

        $("#form_concepto_edit").submit(function() {
            return true;
        });
    }

});