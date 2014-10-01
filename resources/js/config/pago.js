$(document).ready(function() {

    var empleado;
    var codi_emp;
    var sw_pago = "0";
    var tabla_pago;
    var input = "all";

    function all() {
        $('#table_pago').DataTable({
            "destroy": true,
            "iDisplayLength": 30,
            "aLengthMenu": [30, 50, 100],
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": base_url + "registro/paginate_registro_diario",
            "sServerMethod": "POST",
            "bPaginate": true,
            "bFilter": true,
            "bSort": false,
            "displayLength": 10
        });
    }

    if ($("#cpo_pago").is(':visible')) {

        all();

        $('.tooltip_pago').tooltip();
        $('#dates_filter_2').daterangepicker();
        
        $('#btn_all_pago').click(function() {
            $("#detalle_emp_pago").slideUp("fast");
            all();
        });

        $('#sw_codi_emp').change(function() {
            $("#detalle_emp_pago").slideUp("fast");
        });

        $('#sw_filter_pago').change(function() {

            $("#detalle_emp_pago").slideUp("fast");

            if ($(this).val() != sw_pago) {
                sw_pago = $(this).val();
                if (sw_pago == "0") {
                    $("#type_filter_2").slideUp();
                } else if (sw_pago == "1") {
                    $("#type_filter_2").slideDown();
                }
            }
        });

        $('#filter_prev').click(function() {

            codi_emp = $('#sw_codi_emp').find(":selected").attr('value');

            if (sw_pago == "1") {
                input = $('#dates_filter_2').val();
            }
            console.log(input);
            console.log(sw_pago);
            console.log(codi_emp);

            $.ajax({
                data: {'input': input, 'type': sw_pago, 'codi_emp': codi_emp},
                url: base_url + 'pago/get_vempleado/',
                type: 'post',
                success: function(data) {
                    empleado = $.parseJSON(data);
                    console.log(empleado);
                    $.each(empleado, function(key, row) {
                        $('#codi_emp_pago').html(row[0]);
                        $('#nomb_emp_pago').html(row[2] + ', ' + row[1]);
                        $('#tipo_emp_pago').html(row[3]);
                        $('#pla_emp_pago').html(row[4]);
                        $('#pla_suel_emp_pago').html("S/. " + row[5]);
                        $('#dias_emp_pago').html(row[6]);
                        $('#prod_emp_pago').html(row[7]);
                        $('#suto_emp_pago').html("S/. " + row[8]);
                        $('#desc_emp_pago').html("S/. " + row[9]);
                        $('#tota_emp_pago').html("S/. " + row[10]);
                        $("#detalle_emp_pago").slideDown();
                    });
                }
            });

            if (input != "") {
                $.ajax({
                    data: {'input': input, 'type': sw_pago, 'codi_emp': codi_emp},
                    url: base_url + "pago/input_filtar_pago",
                    type: 'post',
                    success: function(response) {
                        tabla_pago = $('#table_pago').DataTable({
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
                            "bSort": false
                        });

                    }
                });

            } else {
                if (sw_pago == "1") {
                    alert("Por favor, seleccione el rango de días");
                    $('#dates_filter_2').focus();
                }
            }
        });



    }

    /* TABLA GENERAL PAGO */

});