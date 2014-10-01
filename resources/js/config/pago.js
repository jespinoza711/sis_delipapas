$(document).ready(function() {

    var empleado;
    var nombre_emp_his;

    if ($("#cpo_pago").is(':visible')) {

        $.ajax({
            url: base_url + 'pago/get_vempleado',
            type: 'post',
            success: function(data) {
                empleado = $.parseJSON(data);
                console.log(empleado);
            }
        });


        $.ajax({
            url: base_url + 'pago/get_empleado_autocomplete',
            type: 'post',
            success: function(data) {
                var empleado_desc = $.parseJSON(data);
                $("#empleado_pago").autocomplete({
                    source: empleado_desc,
                    select: function(event, ui) {

                        if (ui.item) {

                            var nombre_emp = ui.item.label;

                            $.each(empleado, function(key, row) {
                                if (row[1] == nombre_emp) {
                                    nombre_emp_his = nombre_emp;
                                    $('#codi_emp_pago').html(row[0]);
                                    $('#nomb_emp_pago').html(nombre_emp);
                                    $('#tipo_emp_pago').html(row[2]);
                                    $('#dias_emp_pago').html(row[7]);
                                    $('#suto_emp_pago').html("S/. " + row[6]);
                                    $('#desc_emp_pago').html("S/. " + row[6]);
                                    $('#tota_emp_pago').html("S/. " + row[6]);
                                    $('#obsv_prod_ven').html(row[3]);
                                    $("#detalle_emp_pago").slideDown();
                                }
                            });

                        }
                    },
                    open: function() {
                        $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
                    },
                    close: function() {
                        $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
                    }
                });
            }
        });

        $('.tooltip_pago').tooltip();

        $("#empleado_pago").keyup(function(event) {
            if ($(this).val() != nombre_emp_his) {
                nombre_emp_his = "";
                $("#detalle_emp_pago").slideUp("fast");
            }
        });

        $('#table_pago').DataTable({
            "iDisplayLength": 30,
            "aLengthMenu": [30, 50, 100],
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

    /* TABLA GENERAL PAGO */

});