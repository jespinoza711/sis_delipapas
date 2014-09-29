$(document).ready(function() {

    $('#num_ini_orden').keypress(function(tecla) {
        if (tecla.charCode < 48 || tecla.charCode > 57)
            return false;
    });
    $('#num_ini_factura').keypress(function(tecla) {
        if (tecla.charCode < 48 || tecla.charCode > 57)
            return false;
    });

    var tabla_reporte_1;
    var tabla_reporte_2;
    var tabla_reporte_3;
    var tabla_reporte_4;
    var tabla_reporte_5;
    var tabla_reporte_6;
    var tabla_reporte_7;
    var tabla_reporte_8;
    var tabla_reporte_9;
    var tabla_reporte_10;

    if ($("#cpo_reporte").is(':visible')) {

        $('#panel_reporte_1').click(function() {
            $("html,body").animate({scrollTop: $('#panel_reporte_1').eq(0).offset().top}, 1000);
        });
        $('#panel_reporte_2').click(function() {
            $("html,body").animate({scrollTop: $('#panel_reporte_2').eq(0).offset().top}, 1000);
        });
        $('#panel_reporte_3').click(function() {
            $("html,body").animate({scrollTop: $('#panel_reporte_3').eq(0).offset().top}, 1000);
        });
        $('#panel_reporte_4').click(function() {
            $("html,body").animate({scrollTop: $('#panel_reporte_4').eq(0).offset().top}, 1000);
        });
        $('#panel_reporte_5').click(function() {
            $("html,body").animate({scrollTop: $('#panel_reporte_5').eq(0).offset().top}, 1000);
        });
        $('#panel_reporte_6').click(function() {
            $("html,body").animate({scrollTop: $('#panel_reporte_6').eq(0).offset().top}, 1000);
        });
        $('#panel_reporte_7').click(function() {
            $("html,body").animate({scrollTop: $('#panel_reporte_7').eq(0).offset().top}, 1000);
        });
        $('#panel_reporte_8').click(function() {
            $("html,body").animate({scrollTop: $('#panel_reporte_8').eq(0).offset().top}, 1000);
        });
        $('#panel_reporte_9').click(function() {
            $("html,body").animate({scrollTop: $('#panel_reporte_9').eq(0).offset().top}, 1000);
        });
        $('#panel_reporte_10').click(function() {
            $("html,body").animate({scrollTop: $('#panel_reporte_10').eq(0).offset().top}, 1000);
        });

        // Rango de días
        $('#dates_reporte_2').daterangepicker();
        $('#dates_reporte_1').daterangepicker();
        $('#dates_reporte_8').daterangepicker();
        $('#dates_reporte_9').daterangepicker();
        $('#dates_reporte_10').daterangepicker();

        var sw_report_1 = "0";
        $('#sw_filter_1').change(function() {
            if ($(this).val() != sw_report_1) {

                sw_report_1 = $(this).val();

                if (sw_report_1 == "0") {
                    $("#type_filter1_b").slideUp();
                    $("#type_filter1_a").slideDown();
                } else if (sw_report_1 == "1") {
                    $("#type_filter1_a").slideUp();
                    $("#type_filter1_b").slideDown();
                }
            }
        });
        var sw_report_2 = "0";
        $('#sw_filter_2').change(function() {
            if ($(this).val() != sw_report_2) {

                sw_report_2 = $(this).val();

                if (sw_report_2 == "0") {
                    $("#type_filter2_b").slideUp();
                    $("#type_filter2_a").slideDown();
                } else if (sw_report_2 == "1") {
                    $("#type_filter2_a").slideUp();
                    $("#type_filter2_b").slideDown();
                }
            }
        });
        var sw_report_8 = "0";
        $('#sw_filter_8').change(function() {
            if ($(this).val() != sw_report_8) {

                sw_report_8 = $(this).val();

                if (sw_report_8 == "0") {
                    $("#type_filter8").slideUp();
                } else if (sw_report_8 == "1") {
                    $("#type_filter8").slideDown();
                }
            }
        });
        var sw_report_9 = "0";
        $('#sw_filter_9').change(function() {
            if ($(this).val() != sw_report_9) {

                sw_report_9 = $(this).val();

                if (sw_report_9 == "0") {
                    $("#type_filter9").slideUp();
                } else if (sw_report_9 == "1") {
                    $("#type_filter9").slideDown();
                }
            }
        });
        var sw_report_10 = "0";
        $('#sw_filter_10').change(function() {
            if ($(this).val() != sw_report_10) {

                sw_report_10 = $(this).val();

                if (sw_report_10 == "0") {
                    $("#type_filter10").slideUp();
                } else if (sw_report_10 == "1") {
                    $("#type_filter10").slideDown();
                }
            }
        });

        $('.tooltip_rep').tooltip();

        $('#reporte_2_prev').click(function() {
            var input = "";

            if (sw_report_2 == "0") {
                input = $('#reporte_2_a').val();

            } else if (sw_report_2 == "1") {
                input = $('#dates_reporte_2').val();
            }

            if (input != "") {

                $('#cpo_reporte_2').css('display', 'inherit');
                $('#reporte_2_pdf').parent().css('display', 'inherit');

                $.ajax({
                    data: {'month_2': input, 'type_2': sw_report_2},
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
                                if ($('#table_reporte_2 tbody tr td').is(":contains('No se encontró')")) {
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
                if (sw_report_2 == "0") {
                    alert("Por favor, seleccione el mes y año");
                    $('#reporte_2_a').focus();

                } else if (sw_report_2 == "1") {
                    alert("Por favor, seleccione el rango de días");
                    $('#dates_reporte_2').focus();
                }
            }
        });

        $('#reporte_1_prev').click(function() {
            var input = "";

            if (sw_report_1 == "0") {
                input = $('#reporte_1_a').val();

            } else if (sw_report_1 == "1") {
                input = $('#dates_reporte_1').val();
            }

            if (input != "") {

                $('#cpo_reporte_1').css('display', 'inherit');
                $('#reporte_1_pdf').parent().css('display', 'inherit');

                $.ajax({
                    data: {'month': input, 'type': sw_report_1},
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
                                if ($('#table_reporte_1 tbody tr td').is(":contains('No se encontró')")) {
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
                if (sw_report_1 == "0") {
                    alert("Por favor, seleccione el mes y año");
                    $('#reporte_1_a').focus();

                } else if (sw_report_1 == "1") {
                    alert("Por favor, seleccione el rango de días");
                    $('#dates_reporte_1').focus();
                }
            }
        });

        $('#reporte_8_prev').click(function() {
            var input = "";

            if (sw_report_8 == "1") {
                input = $('#dates_reporte_8').val();
            }

            if (sw_report_8 == "0" || input != "") {

                $('#cpo_reporte_8').css('display', 'inherit');
                $('#reporte_8_pdf').parent().css('display', 'inherit');

                $.ajax({
                    data: {'month_8': input, 'type_8': sw_report_8},
                    url: base_url + "reporte/input_8",
                    type: 'post',
                    success: function(response) {
                        tabla_reporte_8 = $('#table_reporte_8').DataTable({
                            "destroy": true,
                            "iDisplayLength": 10,
                            "aLengthMenu": [10, 25, 50],
                            "sPaginationType": "full_numbers",
                            "bProcessing": true,
                            "bServerSide": true,
                            "sAjaxSource": base_url + "caja/paginate_report",
                            "sServerMethod": "POST",
                            "bPaginate": true,
                            "bFilter": false,
                            "bSort": false,
                            "drawCallback": function(settings) {
                                if ($('#table_reporte_8 tbody tr td').is(":contains('No se encontró')")) {
                                    $('#reporte_8_pdf').prop('disabled', true);
                                    $('#reporte_8_pdf').parent().removeAttr('href');
                                } else {
                                    $('#reporte_8_pdf').prop('disabled', false);
                                    $('#reporte_8_pdf').parent().attr('href', base_url + "reporte/caja");
                                }
                            }
                        });

                    }
                });

            } else {
                if (sw_report_8 == "1") {
                    alert("Por favor, seleccione el rango de días");
                    $('#dates_reporte_8').focus();
                }
            }
        });

        $('#reporte_9_prev').click(function() {
            var input = "";

            if (sw_report_9 == "1") {
                input = $('#dates_reporte_9').val();
            }

            if (sw_report_9 == "0" || input != "") {

                $('#cpo_reporte_9').css('display', 'inherit');
                $('#reporte_9_pdf').parent().css('display', 'inherit');

                $.ajax({
                    data: {'month_9': input, 'type_9': sw_report_9},
                    url: base_url + "reporte/input_9",
                    type: 'post',
                    success: function(response) {
                        tabla_reporte_9 = $('#table_reporte_9').DataTable({
                            "destroy": true,
                            "iDisplayLength": 10,
                            "aLengthMenu": [10, 25, 50],
                            "sPaginationType": "full_numbers",
                            "bProcessing": true,
                            "bServerSide": true,
                            "sAjaxSource": base_url + "caja/chica_paginate_report",
                            "sServerMethod": "POST",
                            "bPaginate": true,
                            "bFilter": false,
                            "bSort": false,
                            "drawCallback": function(settings) {
                                if ($('#table_reporte_9 tbody tr td').is(":contains('No se encontró')")) {
                                    $('#reporte_9_pdf').prop('disabled', true);
                                    $('#reporte_9_pdf').parent().removeAttr('href');
                                } else {
                                    $('#reporte_9_pdf').prop('disabled', false);
                                    $('#reporte_9_pdf').parent().attr('href', base_url + "reporte/caja_chica");
                                }
                            }
                        });

                    }
                });

            } else {
                if (sw_report_9 == "1") {
                    alert("Por favor, seleccione el rango de días");
                    $('#dates_reporte_9').focus();
                }
            }
        });

        $('#reporte_10_prev').click(function() {
            var input = "";

            if (sw_report_10 == "1") {
                input = $('#dates_reporte_10').val();
            }

            if (sw_report_10 == "0" || input != "") {

                $('#cpo_reporte_10').css('display', 'inherit');
                $('#reporte_10_pdf').parent().css('display', 'inherit');

                $.ajax({
                    data: {'month_10': input, 'type_10': sw_report_10},
                    url: base_url + "reporte/input_10",
                    type: 'post',
                    success: function(response) {
                        tabla_reporte_10 = $('#table_reporte_10').DataTable({
                            "destroy": true,
                            "iDisplayLength": 10,
                            "aLengthMenu": [10, 25, 50],
                            "sPaginationType": "full_numbers",
                            "bProcessing": true,
                            "bServerSide": true,
                            "sAjaxSource": base_url + "registro/paginate_report",
                            "sServerMethod": "POST",
                            "bPaginate": true,
                            "bFilter": false,
                            "bSort": false,
                            "drawCallback": function(settings) {
                                if ($('#table_reporte_10 tbody tr td').is(":contains('No se encontró')")) {
                                    $('#reporte_10_pdf').prop('disabled', true);
                                    $('#reporte_10_pdf').parent().removeAttr('href');
                                } else {
                                    $('#reporte_10_pdf').prop('disabled', false);
                                    $('#reporte_10_pdf').parent().attr('href', base_url + "reporte/registro");
                                }
                            }
                        });

                    }
                });

            } else {
                if (sw_report_9 == "1") {
                    alert("Por favor, seleccione el rango de días");
                    $('#dates_reporte_9').focus();
                }
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
                if ($('#table_reporte_3 tbody tr td').is(":contains('No se encontró')")) {
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
                if ($('#table_reporte_4 tbody tr td').is(":contains('No se encontró')")) {
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
                if ($('#table_reporte_5 tbody tr td').is(":contains('No se encontró')")) {
                    $('#reporte_5_pdf').prop('disabled', true);
                    $('#reporte_5_pdf').parent().removeAttr('href');
                } else {
                    $('#reporte_5_pdf').prop('disabled', false);
                    $('#reporte_5_pdf').parent().attr('href', base_url + "reporte/proveedor");
                }
            }
        });

        tabla_reporte_6 = $('#table_reporte_6').DataTable({
            "destroy": true,
            "iDisplayLength": 10,
            "aLengthMenu": [10, 25, 50],
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": base_url + "usuario/paginate_report",
            "sServerMethod": "POST",
            "bPaginate": true,
            "bFilter": false,
            "bSort": false,
            "drawCallback": function(settings) {
                if ($('#table_reporte_6 tbody tr td').is(":contains('No se encontró')")) {
                    $('#reporte_6_pdf').prop('disabled', true);
                    $('#reporte_6_pdf').parent().removeAttr('href');
                } else {
                    $('#reporte_6_pdf').prop('disabled', false);
                    $('#reporte_6_pdf').parent().attr('href', base_url + "reporte/usuario");
                }
            }
        });

        tabla_reporte_7 = $('#table_reporte_7').DataTable({
            "destroy": true,
            "iDisplayLength": 10,
            "aLengthMenu": [10, 25, 50],
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": base_url + "empleado/paginate_report",
            "sServerMethod": "POST",
            "bPaginate": true,
            "bFilter": false,
            "bSort": false,
            "drawCallback": function(settings) {
                if ($('#table_reporte_7 tbody tr td').is(":contains('No se encontró')")) {
                    $('#reporte_7_pdf').prop('disabled', true);
                    $('#reporte_7_pdf').parent().removeAttr('href');
                } else {
                    $('#reporte_7_pdf').prop('disabled', false);
                    $('#reporte_7_pdf').parent().attr('href', base_url + "reporte/empleado");
                }
            }
        });
        $.ajax({
            data: {'month_8': "", 'type_8': sw_report_8},
            url: base_url + "reporte/input_8",
            type: 'post',
            success: function(response) {
                tabla_reporte_8 = $('#table_reporte_8').DataTable({
                    "destroy": true,
                    "iDisplayLength": 10,
                    "aLengthMenu": [10, 25, 50],
                    "sPaginationType": "full_numbers",
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": base_url + "caja/paginate_report",
                    "sServerMethod": "POST",
                    "bPaginate": true,
                    "bFilter": false,
                    "bSort": false,
                    "drawCallback": function(settings) {
                        if ($('#table_reporte_8 tbody tr td').is(":contains('No se encontró')")) {
                            $('#reporte_8_pdf').prop('disabled', true);
                            $('#reporte_8_pdf').parent().removeAttr('href');
                        } else {
                            $('#reporte_8_pdf').prop('disabled', false);
                            $('#reporte_8_pdf').parent().attr('href', base_url + "reporte/caja");
                        }
                    }
                });
            }
        });
        $.ajax({
            data: {'month_9': "", 'type_9': sw_report_9},
            url: base_url + "reporte/input_9",
            type: 'post',
            success: function(response) {
                tabla_reporte_8 = $('#table_reporte_9').DataTable({
                    "destroy": true,
                    "iDisplayLength": 10,
                    "aLengthMenu": [10, 25, 50],
                    "sPaginationType": "full_numbers",
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": base_url + "caja/chica_paginate_report",
                    "sServerMethod": "POST",
                    "bPaginate": true,
                    "bFilter": false,
                    "bSort": false,
                    "drawCallback": function(settings) {
                        if ($('#table_reporte_9 tbody tr td').is(":contains('No se encontró')")) {
                            $('#reporte_9_pdf').prop('disabled', true);
                            $('#reporte_9_pdf').parent().removeAttr('href');
                        } else {
                            $('#reporte_9_pdf').prop('disabled', false);
                            $('#reporte_9_pdf').parent().attr('href', base_url + "reporte/caja_chica");
                        }
                    }
                });
            }
        });

        $.ajax({
            data: {'month_10': "", 'type_10': sw_report_10},
            url: base_url + "reporte/input_10",
            type: 'post',
            success: function(response) {
                tabla_reporte_10 = $('#table_reporte_10').DataTable({
                    "destroy": true,
                    "iDisplayLength": 10,
                    "aLengthMenu": [10, 25, 50],
                    "sPaginationType": "full_numbers",
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": base_url + "registro/paginate_report",
                    "sServerMethod": "POST",
                    "bPaginate": true,
                    "bFilter": false,
                    "bSort": false,
                    "drawCallback": function(settings) {
                        if ($('#table_reporte_10 tbody tr td').is(":contains('No se encontró')")) {
                            $('#reporte_10_pdf').prop('disabled', true);
                            $('#reporte_10_pdf').parent().removeAttr('href');
                        } else {
                            $('#reporte_10_pdf').prop('disabled', false);
                            $('#reporte_10_pdf').parent().attr('href', base_url + "reporte/registro");
                        }
                    }
                });

            }
        });

    }

});