$(document).ready(function() {

    var empleado;
    var codi_emp;
    var nombre_emp_his;
    var sw_pago = "0";
    var tabla_reporte_2;
    var input = "";

    if ($("#cpo_pago").is(':visible')) {

        $('#dates_reporte_2').daterangepicker();

        $('#sw_filter_2').change(function() {
            
            if ($(this).val() != sw_pago) {

                sw_pago = $(this).val();
//                console.log(codi_emp);

                if (sw_pago == "0") {
                    $("#type_filter2_b").slideUp();
                } else if (sw_pago == "1") {
                    $("#type_filter2_b").slideDown();
                }
            }
        });

        $('#reporte_2_prev').click(function() {
            codi_emp = $('#codi_emp').find(":selected").attr('value');
            
            if (sw_pago == "0") {
                input = 'all';
            } else if (sw_pago == "1") {
                input = $('#dates_reporte_2').val();
            }
            console.log(input);
            console.log(sw_pago);
            console.log(codi_emp);

            if (input != "") {

//                $('#cpo_reporte_2').css('display', 'inherit');
//                $('#reporte_2_pdf').parent().css('display', 'inherit');

                $.ajax({
                    data: {'month_2': input, 'type_2': sw_pago, 'codi_emp': codi_emp},
                    url: base_url + "pago/input_2",
                    type: 'post',
                    success: function(response) {
                        console.log(response);
                        tabla_reporte_2 = $('#table_pago').DataTable({
                            "destroy": true,
                            "iDisplayLength": 10,
                            "aLengthMenu": [10, 25, 50],
                            "sPaginationType": "full_numbers",
                            "bProcessing": true,
                            "bServerSide": true,
                            "sAjaxSource": base_url + "pago/get_v_empleado_paginate",
                            "sServerMethod": "POST",
                            "bPaginate": true,
                            "bFilter": false,
                            "bSort": false,
                            "drawCallback": function(settings) {
                                if ($('#table_pago tbody tr td').is(":contains('No se encontró')")) {
//                                    $('#reporte_2_pdf').prop('disabled', true);
//                                    $('#reporte_2_pdf').parent().removeAttr('href');
                                } else {
//                                    $('#reporte_2_pdf').prop('disabled', false);
//                                    $('#reporte_2_pdf').parent().attr('href', base_url + "reporte/venta");
                                }
                            }
                        });

                    }
                });

            } else {
                if (sw_pago == "1") {
                    alert("Por favor, seleccione el rango de días");
                    $('#dates_reporte_2').focus();
                }
            }
        });

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
                                    $('#nomb_emp_pago').html(nombre_emp + ' ' + row[2]);
                                    $('#tipo_emp_pago').html(row[3]);
                                    $('#pla_emp_pago').html(row[4]);
                                    $('#pla_suel_emp_pago').html("S/. " + row[5]);
                                    $('#dias_emp_pago').html(row[6]);
                                    $('#prod_emp_pago').html(row[7]);
                                    $('#suto_emp_pago').html("S/. " + row[8]);
                                    $('#desc_emp_pago').html("S/. " + row[9]);
                                    $('#tota_emp_pago').html("S/. " + row[10]);
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

//        $('#table_pago').DataTable({
//            "iDisplayLength": 30,
//            "aLengthMenu": [30, 50, 100],
//            "sPaginationType": "full_numbers",
//            "bProcessing": true,
//            "bServerSide": true,
//            "sAjaxSource": base_url + "registro/paginate_registro_diario_dia",
//            "sServerMethod": "POST",
//            "bPaginate": true,
//            "bFilter": true,
//            "bSort": false,
//            "displayLength": 10
//        });
    }

    /* TABLA GENERAL PAGO */

});