$(document).ready(function() {

    if ($("#cpo_caja").is(':visible')) {

        var cajas;

        $.ajax({
            url: base_url + 'caja/get_caja',
            type: 'post',
            success: function(data) {
                cajas = $.parseJSON(data);
//                console.log(cajas);
            }
        });

        $('#table_caja').DataTable({
            "iDisplayLength": 10,
            "aLengthMenu": [10, 25, 50],
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": base_url + "caja/paginate",
            "sServerMethod": "POST",
            "bPaginate": true,
            "bFilter": true,
            "bSort": false,
            "displayLength": 10
        });

        var num_caj_h;

        $(document).on('click', '.editar_caj', function() {

            var tr = $(this).parent().parent();

            num_caj_h = tr.find("td").eq(1).html();

            $("#codi_caj_e").val(tr.find("td").eq(0).html());
            $("#num_caj_e").val(tr.find("td").eq(1).html());
            var observa = tr.find("td").eq(2).html();
            if (observa == "-") {
                observa = "";
            }
            $("#obsv_caj_e").val(observa);
            $("#ModalEditarCaja").modal("show");
        });

        $("#form_caj").submit(function() {

            var num_caja = $('#num_caj').val();
            var sw_usu = false;

            $.each(cajas, function(key, row) {
                if (row[1] == num_caja) {
                    var dialog = confirm("Ya existe una caja con el número " + num_caja + ". ¿Desea editar la caja existente?");
                    if (dialog == true) {
                        $("#codi_caj_e").val(row[0]);
                        $("#num_caj_e").val(row[1]);
                        var observa = row[2];
                        if (observa == null) {
                            observa = "";
                        }
                        $("#obsv_caj_e").val(observa);
                        $("#ModalNuevaCaja").modal("hide");
                        $("#ModalEditarCaja").modal("show");
                    }
                    sw_usu = true;
                    return false;
                }
            });

            if (sw_usu) {
                return false;
            }
        });

        $("#form_caj_edit").submit(function() {

            var num_caja = $('#num_caj_e').val();

            if (num_caja != num_caj_h) {

                var sw_usu = false;

                $.each(cajas, function(key, row) {
                    if (row[1] == num_caja) {
                        alert('Ya existe una caja con el número ' + num_caja + ", intente con otro número")
                        sw_usu = true;
                        return false;
                    }
                });

                if (sw_usu) {
                    return false;
                }

            }
        });



    }

});