$(document).ready(function() {

    var tabla_reporte_1;
    var tabla_reporte_2;
    var tabla_reporte_3;
    var tabla_reporte_4;
    var tabla_reporte_5;

    if ($("#cpo_reporte").is(':visible')) {

        $('.tooltip_rep').tooltip();

        $('#reporte_1_prev').click(function() {
            var input = $('#reporte_1_a').val();
            if (input != "") {

                $('#cpo_reporte_1').css('display', 'inherit');
                $('#reporte_1_pdf').parent().css('display', 'inherit');

                $.ajax({
                    data: {'month': input},
                    url: base_url + "reporte/input_1",
                    type: 'post',
                    success: function(response) {
                        tabla_reporte_1 = $('#table_reporte_1').DataTable({
                            "destroy": true,
                            "iDisplayLength": 10,
                            "aLengthMenu": [10, 25, 50],
                            "sPaginationType": "full_numbers",
                            "bProcessing": true,
                            "bServerSide": true,
                            "sAjaxSource": base_url + "caja/get_vcompras_paginate",
                            "sServerMethod": "POST",
                            "bPaginate": true,
                            "bFilter": false,
                            "bSort": false,
                            "drawCallback": function(settings) {
                                if ($('#table_reporte_1 tbody tr td').is(":contains('No se encontró resultados')")) {
                                    $('#reporte_1_pdf').prop('disabled', true);
                                    $('#reporte_1_pdf').parent().removeAttr('href');
                                } else {
                                    $('#reporte_1_pdf').prop('disabled', false);
                                    $('#reporte_1_pdf').parent().attr('href', base_url + "reporte/compra");
                                }
                            }
                        });

                    }
                });

            } else {
                alert("Por favor, seleccione el mes y año");
                $('#reporte_1_a').focus();
            }
        });

        $('#reporte_2_prev').click(function() {
            var input = $('#reporte_2_a').val();
            if (input != "") {

                $('#cpo_reporte_2').css('display', 'inherit');
                $('#reporte_2_pdf').parent().css('display', 'inherit');

                $.ajax({
                    data: {'month_2': input},
                    url: base_url + "reporte/input_2",
                    type: 'post',
                    success: function(response) {
                        tabla_reporte_2 = $('#table_reporte_2').DataTable({
                            "destroy": true,
                            "iDisplayLength": 10,
                            "aLengthMenu": [10, 25, 50],
                            "sPaginationType": "full_numbers",
                            "bProcessing": true,
                            "bServerSide": true,
                            "sAjaxSource": base_url + "caja/get_v_ventas_paginate",
                            "sServerMethod": "POST",
                            "bPaginate": true,
                            "bFilter": false,
                            "bSort": false,
                            "drawCallback": function(settings) {
                                if ($('#table_reporte_2 tbody tr td').is(":contains('No se encontró resultados')")) {
                                    $('#reporte_2_pdf').prop('disabled', true);
                                    $('#reporte_2_pdf').parent().removeAttr('href');
                                } else {
                                    $('#reporte_2_pdf').prop('disabled', false);
                                    $('#reporte_2_pdf').parent().attr('href', base_url + "reporte/venta");
                                }
                            }
                        });

                    }
                });

            } else {
                alert("Por favor, seleccione el mes y año");
                $('#reporte_1_a').focus();
            }
        });

        tabla_reporte_3 = $('#table_reporte_3').DataTable({
            "destroy": true,
            "iDisplayLength": 10,
            "aLengthMenu": [10, 25, 50],
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": base_url + "producto/paginate_report",
            "sServerMethod": "POST",
            "bPaginate": true,
            "bFilter": false,
            "bSort": false,
            "drawCallback": function(settings) {
                if ($('#table_reporte_3 tbody tr td').is(":contains('No se encontró resultados')")) {
                    $('#reporte_3_pdf').prop('disabled', true);
                    $('#reporte_3_pdf').parent().removeAttr('href');
                } else {
                    $('#reporte_3_pdf').prop('disabled', false);
                    $('#reporte_3_pdf').parent().attr('href', base_url + "reporte/inventario");
                }
            }
        });

        tabla_reporte_4 = $('#table_reporte_4').DataTable({
            "destroy": true,
            "iDisplayLength": 10,
            "aLengthMenu": [10, 25, 50],
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": base_url + "cliente/paginate_report",
            "sServerMethod": "POST",
            "bPaginate": true,
            "bFilter": false,
            "bSort": false,
            "drawCallback": function(settings) {
                if ($('#table_reporte_4 tbody tr td').is(":contains('No se encontró resultados')")) {
                    $('#reporte_4_pdf').prop('disabled', true);
                    $('#reporte_4_pdf').parent().removeAttr('href');
                } else {
                    $('#reporte_4_pdf').prop('disabled', false);
                    $('#reporte_4_pdf').parent().attr('href', base_url + "reporte/cliente");
                }
            }
        });
        
        tabla_reporte_5 = $('#table_reporte_5').DataTable({
            "destroy": true,
            "iDisplayLength": 10,
            "aLengthMenu": [10, 25, 50],
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": base_url + "proveedor/paginate_report",
            "sServerMethod": "POST",
            "bPaginate": true,
            "bFilter": false,
            "bSort": false,
            "drawCallback": function(settings) {
                if ($('#table_reporte_5 tbody tr td').is(":contains('No se encontró resultados')")) {
                    $('#reporte_5_pdf').prop('disabled', true);
                    $('#reporte_5_pdf').parent().removeAttr('href');
                } else {
                    $('#reporte_5_pdf').prop('disabled', false);
                    $('#reporte_5_pdf').parent().attr('href', base_url + "reporte/proveedor");
                }
            }
        });

    }

});