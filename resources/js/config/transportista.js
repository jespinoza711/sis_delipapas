$(document).ready(function() {

    if ($("#cpo_transportista").is(':visible')) {

        $('#table_transportista').DataTable({
            "iDisplayLength": 10,
            "aLengthMenu": [10, 25, 50],
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": base_url + "transportista/paginate",
            "sServerMethod": "POST",
            "bPaginate": true,
            "bFilter": true,
            "bSort": false,
            "displayLength": 10
        });

        $(document).on('click', '.editar_transportista', function() {

            var tr = $(this).parent().parent();

            $("#id_tran_e").val(tr.find("td").eq(0).html());
            $("#nomb_tran_e").val(tr.find("td").eq(1).html());
            $("#ruc_tran_e").val(tr.find("td").eq(2).html());
            $("#dire_tran_e").val(tr.find("td").eq(3).html());
            $("#telf_tran_e").val(tr.find("td").eq(4).html());
            var observa = tr.find("td").eq(5).html();
            if (observa == "-") {
                observa = "";
            }
            $("#obsv_tran_e").val(observa);
            $("#ModalEditarTransportista").modal("show");
        });
    }

});