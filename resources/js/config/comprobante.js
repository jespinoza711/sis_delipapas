$(document).ready(function() {

    if ($("#cpo_comprobante").is(':visible')) {

        var comprobantes;

        $.ajax({
            url: base_url + 'ajustes/get_comprobante',
            type: 'post',
            success: function(data) {
                comprobantes = $.parseJSON(data);
                console.log(comprobantes);
            }
        });

        $('#table_comprobante').DataTable({
            "iDisplayLength": 10,
            "aLengthMenu": [10, 25, 50],
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": base_url + "ajustes/paginate_comprobante",
            "sServerMethod": "POST",
            "bPaginate": true,
            "bFilter": true,
            "bSort": false,
            "displayLength": 10
        });

        $(document).on('click', '.editar_comprobante', function() {

            var tr = $(this).parent().parent();

            $("#codi_com_e").val(tr.find("td").eq(0).html());
            $("#fech_reg_e").val(tr.find("td").eq(1).html());
            $("#nomb_com_e").val(tr.find("td").eq(2).html());
            $("#serie_com_e").val(tr.find("td").eq(3).html());
            $("#nume_com_e").val(tr.find("td").eq(4).html());
            var observa = tr.find("td").eq(5).html();
            if (observa == "-") {
                observa = "";
            }
            $("#obsv_com_e").val(observa);
            $("#ModalEditarComprobante").modal("show");
        });

        $("#form_comprobante").submit(function() {
            return true;
        });

        $("#form_comprobante_edit").submit(function() {
            return true;
        });
    }

});