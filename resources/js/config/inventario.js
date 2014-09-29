$(document).ready(function() {

    $('#inventario_update').prop('disabled', true);

    $("#prec_prod_e").keyup(function(event) {
        var precio = $(this).val();
        var stock = $("#stoc_prod_e").val();
        if (parseFloat(precio) > 0 && parseFloat(stock) > 0) {
            $('#inventario_update').prop('disabled', false);
        } else {
            $('#inventario_update').prop('disabled', true);
        }
    });

    $("#stoc_prod_e").keyup(function(event) {
        var precio = $("#prec_prod_e").val();
        var stock = $(this).val();
        if (parseFloat(precio) >0 && parseFloat(stock) > 0) {
            $('#inventario_update').prop('disabled', false);
        } else {
            $('#inventario_update').prop('disabled', true);
        }
    });

    if ($("#cpo_inventario").is(':visible')) {

        $('#table_inventario').DataTable({
            "iDisplayLength": 30,
            "aLengthMenu": [30, 50, 100],
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": base_url + "producto/paginate/inv",
            "sServerMethod": "POST",
            "bPaginate": true,
            "bFilter": true,
            "bSort": false,
            "displayLength": 10
        });
    }

    $(document).on('click', '.editar_inv', function() {

        var tr = $(this).parent().parent();

        $("#codi_prod_e").val(tr.find("td").eq(0).html());
        $("#nomb_tipo_e").val(tr.find("td").eq(1).html());
        $("#nomb_prod_e").val(tr.find("td").eq(2).html());
        $("#prec_prod_e").val(tr.find("td").eq(6).html());
        $("#stoc_prod_e").val(tr.find("td").eq(7).html());
        $("#ModalEditarInventarioProducto").modal("show");
    });

});