$(document).ready(function() {

    var empleados;
    var planillas;
    var tipo_empleado;

    if ($("#cpo_empleado").is(':visible')) {
        // Carga de registros de empleado, planillas y tipo de empleados
        $.ajax({
            url: base_url + 'empleado/get_vempleado',
            type: 'post',
            success: function(data) {
                empleados = $.parseJSON(data);
            }
        });
        $.ajax({
            url: base_url + 'empleado/get_planillas',
            type: 'post',
            success: function(data) {
                planillas = $.parseJSON(data);
            }
        });
        $.ajax({
            url: base_url + 'empleado/get_tipo_empleado',
            type: 'post',
            success: function(data) {
                tipo_empleado = $.parseJSON(data);
            }
        });
    }
    
    function format_empleado(c) {

        var direccion = "";
        var dni = "";
        var sexo = "";
        var civil = "";
        var afp = "";
        var estado = "";

        direccion = empleados[c][3];
        dni = empleados[c][4];
        var sexo_a = empleados[c][6];
        if (sexo_a == "M") {
            sexo = "Masculino";
        } else if (sexo_a == "F") {
            sexo = "Femenino";
        }
        var civil_a = empleados[c][8];
        if (civil_a == "S") {
            civil = "Soltero";
        } else if (civil_a == "C") {
            civil = "Casado";
        } else if (civil_a == "D") {
            civil = "Divorciado";
        }
        afp = empleados[c][7] + '%';
        var esta_a = empleados[c][9];
        if (esta_a == "A") {
            estado = "Habilitado";
        } else if (esta_a == "D") {
            estado = "Deshabilitado";
        }

        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                '<tr>' +
                '<td><strong>D.N.I.:</strong></td>' +
                '<td>' + dni + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><strong>Dirección:</strong></td>' +
                '<td>' + direccion + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><strong>Sexo:</strong></td>' +
                '<td>' + sexo + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><strong>Estado Civil:</strong></td>' +
                '<td>' + civil + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><strong>AFP:</strong></td>' +
                '<td>' + afp + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><strong>Estado:</strong></td>' +
                '<td>' + estado + '</td>' +
                '</tr>' +
                '</table>';
    }



    var table_empleado = $('#table_empleado').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "empleado/paginate",
        "sServerMethod": "POST",
        "bPaginate": true,
        "bFilter": true,
        "bSort": false,
        "columnDefs": [
            {"visible": false, "targets": 3}
        ],
        "displayLength": 10,
        "drawCallback": function(settings) {
            var api = this.api();
            var rows = api.rows({page: 'current'}).nodes();
            var last = null;

            api.column(3, {page: 'current'}).data().each(function(group, i) {
                if (last !== group) {
                    $(rows).eq(i).before(
                            '<tr class="group"><td colspan="6">' + group + '</td></tr>'
                            );

                    last = group;
                }
            });
        }
    });

    $('#table_empleado tbody').on('click', 'tr.group', function() {
        var currentOrder = table_empleado.order()[0];
        if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
            table_empleado.order([2, 'desc']).draw();
        }
        else {
            table_empleado.order([2, 'asc']).draw();
        }
    });
    $('#table_empleado tbody').on('click', 'button.info_emp', function() {
        var codigo = $(this).parent().parent().find("td").eq(1).html();
        var pos = empleados[codigo];
        if (pos) {
            var tr = $(this).parent().parent().closest('tr');
            var row = table_empleado.row(tr);

            if (row.child.isShown()) {
                $(this).removeClass('btn-warning');
                $(this).addClass('btn-primary');
                $(this).find('i').removeClass('fa-minus');
                $(this).find('i').addClass('fa-chevron-down');
                row.child.hide();
                tr.removeClass('shown');
                table_empleado.$('tr.selected').removeClass('selected');
                $(this).parent().parent().removeClass('selected');
            }
            else {
                $(this).removeClass('btn-primary');
                $(this).addClass('btn-warning');
                $(this).find('i').removeClass('fa-chevron-down');
                $(this).find('i').addClass('fa-minus');
                row.child(format_empleado(codigo)).show();
                tr.addClass('shown');
                $(this).parent().parent().addClass('selected');
            }
        }
    });

    $(document).on('click', '.editar_emp', function() {

        var tr = $(this).parent().parent();

        var codigo = tr.find("td").eq(1).html();

        $("#codigo_emp_e").val(codigo);
        $("#nomb_emp_e").val(empleados[codigo][1]);
        $("#apel_emp_e").val(empleados[codigo][2]);
        $("#dni_emp_e").val(empleados[codigo][4]);
        $('#dni_emp_e').inputmask("mask", {"mask": "99999999"});
        var telefono = empleados[codigo][5];
        if (telefono.length == 13) {
            $('#movil_e').removeClass('active');
            $('#linea_e').addClass('active');
            $("#telefono_emp_e").val(telefono);
            $('#telefono_emp_e').inputmask("mask", {"mask": "(99) 999-9999"});
        } else if (telefono.length == 11) {
            $('#linea_e').removeClass('active');
            $('#movil_e').addClass('active');
            $("#telefono_emp_e").val(telefono);
            $('#telefono_emp_e').inputmask("mask", {"mask": "999-999-999"});
        }
        $("#direccion_emp_e").val(empleados[codigo][3]);

        var sexo = empleados[codigo][6];
        var civil = empleados[codigo][8];

        if (sexo == 'M') {
            $(document).find('#femenino_emp_e').removeAttr('checked');
            $(document).find('#femenino_emp_e').parent().attr('aria-checked', 'false');
            $(document).find('#femenino_emp_e').parent().removeClass('checked');
            $(document).find('#masculino_emp_e').attr('checked', 'true');
            $(document).find('#masculino_emp_e').parent().attr('aria-checked', 'true');
            $(document).find('#masculino_emp_e').parent().addClass('checked');
        } else if (sexo == 'F') {
            $(document).find('#masculino_emp_e').removeAttr('checked');
            $(document).find('#masculino_emp_e').parent().attr('aria-checked', 'false');
            $(document).find('#masculino_emp_e').parent().removeClass('checked');
            $(document).find('#femenino_emp_e').attr('checked', 'true');
            $(document).find('#femenino_emp_e').parent().attr('aria-checked', 'true');
            $(document).find('#femenino_emp_e').parent().addClass('checked');
        }
        if (civil == 'S') {
            $(document).find('#casado_emp_e').removeAttr('checked');
            $(document).find('#casado_emp_e').parent().attr('aria-checked', 'false');
            $(document).find('#casado_emp_e').parent().removeClass('checked');
            $(document).find('#divorciado_emp_e').removeAttr('checked');
            $(document).find('#divorciado_emp_e').parent().attr('aria-checked', 'false');
            $(document).find('#divorciado_emp_e').parent().removeClass('checked');
            $(document).find('#soltero_emp_e').attr('checked', 'true');
            $(document).find('#soltero_emp_e').parent().attr('aria-checked', 'true');
            $(document).find('#soltero_emp_e').parent().addClass('checked');
        } else if (civil == 'C') {
            $(document).find('#soltero_emp_e').removeAttr('checked');
            $(document).find('#soltero_emp_e').parent().attr('aria-checked', 'false');
            $(document).find('#soltero_emp_e').parent().removeClass('checked');
            $(document).find('#divorciado_emp_e').removeAttr('checked');
            $(document).find('#divorciado_emp_e').parent().attr('aria-checked', 'false');
            $(document).find('#divorciado_emp_e').parent().removeClass('checked');
            $(document).find('#casado_emp_e').attr('checked', 'true');
            $(document).find('#casado_emp_e').parent().attr('aria-checked', 'true');
            $(document).find('#casado_emp_e').parent().addClass('checked');
        } else if (civil == 'D') {
            $(document).find('#casado_emp_e').removeAttr('checked');
            $(document).find('#casado_emp_e').parent().attr('aria-checked', 'false');
            $(document).find('#casado_emp_e').parent().removeClass('checked');
            $(document).find('#soltero_emp_e').removeAttr('checked');
            $(document).find('#soltero_emp_e').parent().attr('aria-checked', 'false');
            $(document).find('#soltero_emp_e').parent().removeClass('checked');
            $(document).find('#divorciado_emp_e').attr('checked', 'true');
            $(document).find('#divorciado_emp_e').parent().attr('aria-checked', 'true');
            $(document).find('#divorciado_emp_e').parent().addClass('checked');
        }

        var codi_tem = empleados[codigo][11];
        $("#tipo_emp_e option[value='" + codi_tem + "']").prop("selected", true);
        var codi_pla = empleados[codigo][10];
        $("#plan_emp_e option[value='" + codi_pla + "']").prop("selected", true);
        $("#afp_emp_e").val(empleados[codigo][7]);

        // REGISTRO ACTUAL
        $("#nomb_emp_h").val(empleados[codigo][1]);
        $("#apel_emp_h").val(empleados[codigo][2]);
        $("#dni_emp_h").val(empleados[codigo][4]);
        $("#telefono_emp_h").val(empleados[codigo][5]);
        $("#direccion_emp_h").val(empleados[codigo][3]);
        $("#sexo_emp_h").val(empleados[codigo][6]);
        $("#civil_emp_h").val(empleados[codigo][8]);
        $("#afp_emp_h").val(empleados[codigo][7]);
        $("#tem_emp_h").val(empleados[codigo][10]);
        $("#pla_emp_h").val(empleados[codigo][11]);

        $('#dni_emp_e').parent().removeClass('has-error');
        $('#dni_emp_e').parent().removeClass('has-success');
        $('#dni_emp_e').parent().find('label').html('D.N.I.: * <span class="text-muted" style="font-style: italic;">(Debe contener 8 dígitos)</span>');
        $('#editar_emp').prop('disabled', false);

        $("#ModalEditarEmpleado").modal("show");
    });

    $('#form_pla').submit(function() {
        var sueldo = $('#suel_pla').val() + '.00';
        var sw = false;

        $.each(planillas, function(key, row) {
            if (row[2] == sueldo) {
                $('#error_pla1').css('display', 'inherit');
                $('#error_pla1').parent().addClass('has-error');
                $('#registrar_pla').prop('disabled', true);
                sw = true;
                return false;
            }
        });
        if (sw) {
            return false;
        }
    });

    $('#suel_pla').keydown(function() {
        $('#error_pla1').css('display', 'none');
        $(this).parent().parent().removeClass('has-error');
        $('#registrar_pla').prop('disabled', false);
        $(this).css('cursor', 'auto');
    });

    $('#suel_pla').number(true, 0);
    $('#suel_pla').keyup(function() {
        var suel = $(this).val();
        if (suel > 99999999) {
            $(this).val("99999999");
        }
    });

    $('#btnTipoEmp').click(function() {
        $('#ModalNuevoEmpleado').modal('hide');
        $('#ModalAddTipEmp').modal('show');
    });
    $('#btnTipoEmp_e').click(function() {
        $('#ModalEditarEmpleado').modal('hide');
        $('#ModalAddTipEmp').modal('show');
    });
    $('#btnCancelarTEmp').click(function() {
        $('#ModalAddTipEmp').modal('hide');
        $('#ModalNuevoEmpleado').modal('show');
    });
    $('#btnPlaEmp').click(function() {
        $('#ModalNuevoEmpleado').modal('hide');
        $('#ModalAddPla').modal('show');
    });
    $('#btnPlaEmp_e').click(function() {
        $('#ModalEditarEmpleado').modal('hide');
        $('#ModalAddPla').modal('show');
    });
    $('#btnCancelarPla').click(function() {
        $('#ModalAddPla').modal('hide');
        $('#ModalNuevoEmpleado').modal('show');
    });

    $('#form_tem').submit(function() {
        var nombre = $('#nomb_temp').val();
        var sw = false;

        $.each(tipo_empleado, function(key, row) {
            if (row[2].toUpperCase() == nombre.toUpperCase()) {
                $('#error_tem1').css('display', 'inherit');
                $('#error_tem1').parent().addClass('has-error');
                $('#registrar_temp').prop('disabled', true);
                sw = true;
                return false;
            }
        });
        if (sw) {
            return false;
        }
    });

    $('#nomb_temp').keyup(function() {
        $('#error_tem1').css('display', 'none');
        $(this).parent().removeClass('has-error');
        $('#registrar_temp').prop('disabled', false);
    });

    function es_numerico(val) {
        var nro = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        for (i = 0; i < 10; i++) {
            if (val === nro[i]) {
                return true;
                break;
            }
        }
        return false;
    }

    function verificar_format_dni() {
        var dni = $('#dni_emp').val();
        var sw = false;

        if (!es_numerico(dni.charAt(0)))
            sw = true;
        if (!es_numerico(dni.charAt(1)))
            sw = true;
        if (!es_numerico(dni.charAt(2)))
            sw = true;
        if (!es_numerico(dni.charAt(3)))
            sw = true;
        if (!es_numerico(dni.charAt(4)))
            sw = true;
        if (!es_numerico(dni.charAt(5)))
            sw = true;
        if (!es_numerico(dni.charAt(6)))
            sw = true;
        if (!es_numerico(dni.charAt(7)))
            sw = true;
        if (sw) {
            return false;
            $('#dni_emp').focus();
        } else {
            return true;
        }
    }
    function verificar_format_dni_e() {
        var dni = $('#dni_emp_e').val();
        var sw = false;

        if (!es_numerico(dni.charAt(0)))
            sw = true;
        if (!es_numerico(dni.charAt(1)))
            sw = true;
        if (!es_numerico(dni.charAt(2)))
            sw = true;
        if (!es_numerico(dni.charAt(3)))
            sw = true;
        if (!es_numerico(dni.charAt(4)))
            sw = true;
        if (!es_numerico(dni.charAt(5)))
            sw = true;
        if (!es_numerico(dni.charAt(6)))
            sw = true;
        if (!es_numerico(dni.charAt(7)))
            sw = true;
        if (sw) {
            return false;
            $('#dni_emp_e').focus();
        } else {
            return true;
        }
    }
    function verificar_format_telefono() {
        var telf = $('#telefono_emp').val();
        var sw = false;
        if ($('#linea').hasClass("active")) {
            if (!es_numerico(telf.charAt(1)))
                sw = true;
            if (!es_numerico(telf.charAt(2)))
                sw = true;
            if (!es_numerico(telf.charAt(5)))
                sw = true;
            if (!es_numerico(telf.charAt(6)))
                sw = true;
            if (!es_numerico(telf.charAt(7)))
                sw = true;
            if (!es_numerico(telf.charAt(9)))
                sw = true;
            if (!es_numerico(telf.charAt(10)))
                sw = true;
            if (!es_numerico(telf.charAt(11)))
                sw = true;
            if (!es_numerico(telf.charAt(12)))
                sw = true;
        } else if ($('#movil').hasClass("active")) {
            if (!es_numerico(telf.charAt(0)))
                sw = true;
            if (!es_numerico(telf.charAt(1)))
                sw = true;
            if (!es_numerico(telf.charAt(2)))
                sw = true;
            if (!es_numerico(telf.charAt(4)))
                sw = true;
            if (!es_numerico(telf.charAt(5)))
                sw = true;
            if (!es_numerico(telf.charAt(6)))
                sw = true;
            if (!es_numerico(telf.charAt(8)))
                sw = true;
            if (!es_numerico(telf.charAt(9)))
                sw = true;
            if (!es_numerico(telf.charAt(10)))
                sw = true;
        }
        if (sw) {
            return false;
            $('#telefono_emp').focus();
        } else {
            return true;
        }
    }
    function verificar_format_telefono_e() {
        var telf = $('#telefono_emp_e').val();
        var sw = false;
        if ($('#linea_e').hasClass("active")) {
            if (!es_numerico(telf.charAt(1)))
                sw = true;
            if (!es_numerico(telf.charAt(2)))
                sw = true;
            if (!es_numerico(telf.charAt(5)))
                sw = true;
            if (!es_numerico(telf.charAt(6)))
                sw = true;
            if (!es_numerico(telf.charAt(7)))
                sw = true;
            if (!es_numerico(telf.charAt(9)))
                sw = true;
            if (!es_numerico(telf.charAt(10)))
                sw = true;
            if (!es_numerico(telf.charAt(11)))
                sw = true;
            if (!es_numerico(telf.charAt(12)))
                sw = true;
        } else if ($('#movil_e').hasClass("active")) {
            if (!es_numerico(telf.charAt(0)))
                sw = true;
            if (!es_numerico(telf.charAt(1)))
                sw = true;
            if (!es_numerico(telf.charAt(2)))
                sw = true;
            if (!es_numerico(telf.charAt(4)))
                sw = true;
            if (!es_numerico(telf.charAt(5)))
                sw = true;
            if (!es_numerico(telf.charAt(6)))
                sw = true;
            if (!es_numerico(telf.charAt(8)))
                sw = true;
            if (!es_numerico(telf.charAt(9)))
                sw = true;
            if (!es_numerico(telf.charAt(10)))
                sw = true;
        }
        if (sw) {
            return false;
            $('#telefono_emp_e').focus();
        } else {
            return true;
        }
    }

    $('#telefono_emp').keyup(function() {
        if (verificar_format_telefono()) {
            $('#error_telf1').css('display', 'none');
            $('#telefono_emp').parent().removeClass('has-error');
            $('#telefono_emp').parent().addClass('has-success');
        } else {
            $('#telefono_emp').parent().removeClass('has-success');
        }
    });

    $('#telefono_emp_e').keyup(function() {
        if (verificar_format_telefono_e()) {
            $('#error_telf1_e').css('display', 'none');
            $('#telefono_emp_e').parent().removeClass('has-error');
            $('#telefono_emp_e').parent().addClass('has-success');
        } else {
            $('#telefono_emp_e').parent().removeClass('has-success');
        }
    });

    $('#form_emp').submit(function() {
        if (!verificar_format_telefono()) {
            $('#error_telf1').css('display', 'inherit');
            $('#telefono_emp').parent().addClass('has-error');
            return false;
        }
        if (!verificar_format_dni()) {
            $('#error_dni1').css('display', 'inherit');
            $('#dni_emp').parent().addClass('has-error');
            return false;
        }
    });
    $('#form_emp_edit').submit(function() {
        if (!verificar_format_telefono_e()) {
            $('#error_telf1_e').css('display', 'inherit');
            $('#telefono_emp_e').parent().addClass('has-error');
            return false;
        }
        if (!verificar_format_dni_e()) {
            $('#error_dni1_e').css('display', 'inherit');
            $('#dni_emp_e').parent().addClass('has-error');
            return false;
        }
    });

    $('#btnCancelarNEmp').click(function() {

        $('#dni_emp').parent().removeClass('has-error');
        $('#dni_emp').parent().removeClass('has-success');
        $('#dni_emp').parent().find('label').html('D.N.I.: * <span class="text-muted" style="font-style: italic;">(Debe contener 8 dígitos)</span>');

        $('#error_telf1').css('display', 'none');
        $('#telefono_emp').parent().removeClass('has-success');
        $('#telefono_emp').parent().removeClass('has-error');

        $('#registrar_emp').prop('disabled', false);

        $('#form_emp')[0].reset();

    });

    $('#btnCancelarEdEmp').click(function() {

        $('#dni_emp_e').parent().removeClass('has-error');
        $('#dni_emp_e').parent().removeClass('has-success');
        $('#dni_emp_e').parent().find('label').html('D.N.I.: * <span class="text-muted" style="font-style: italic;">(Debe contener 8 dígitos)</span>');

        $('#error_telf1_e').css('display', 'none');
        $('#telefono_emp_e').parent().removeClass('has-success');
        $('#telefono_emp_e').parent().removeClass('has-error');

        $('#editar_emp').prop('disabled', false);

        $('#form_emp_edit')[0].reset();

    });

    // 13 carácteres en línea y 16 carácteres en móvil
    $('#telefono_emp').inputmask("mask", {"mask": "(99) 999-9999"});
    $('#linea').click(function() {
        $('#movil').removeClass('active');
        $('#linea').addClass('active');
        $('#telefono_emp').inputmask("mask", {"mask": "(99) 999-9999"});

        if (verificar_format_telefono()) {
            $('#error_telf1').css('display', 'none');
            $('#telefono_emp').parent().removeClass('has-error');
            $('#telefono_emp').parent().addClass('has-success');
        } else {
            $('#error_telf1').css('display', 'none');
            $('#telefono_emp').parent().removeClass('has-success');
        }
    });
    $('#movil').click(function() {
        $('#linea').removeClass('active');
        $('#movil').addClass('active');
        $('#telefono_emp').inputmask("mask", {"mask": "999-999-999"});

        if (verificar_format_telefono()) {
            $('#telefono_emp').parent().removeClass('has-error');
            $('#error_telf1').css('display', 'none');
            $('#telefono_emp').parent().addClass('has-success');
        } else {
            $('#error_telf1').css('display', 'none');
            $('#telefono_emp').parent().removeClass('has-success');
        }
    });
    $('#linea_e').click(function() {
        $('#movil_e').removeClass('active');
        $('#linea_e').addClass('active');
        $('#telefono_emp_e').inputmask("mask", {"mask": "(99) 999-9999"});

        if (verificar_format_telefono_e()) {
            $('#error_telf1_e').css('display', 'none');
            $('#telefono_emp_e').parent().removeClass('has-error');
            $('#telefono_emp_e').parent().addClass('has-success');
        } else {
            $('#error_telf1-e').css('display', 'none');
            $('#telefono_emp_e').parent().removeClass('has-success');
        }
    });
    $('#movil_e').click(function() {
        $('#linea_e').removeClass('active');
        $('#movil_e').addClass('active');
        $('#telefono_emp_e').inputmask("mask", {"mask": "999-999-999"});

        if (verificar_format_telefono_e()) {
            $('#telefono_emp_e').parent().removeClass('has-error');
            $('#error_telf1_e').css('display', 'none');
            $('#telefono_emp_e').parent().addClass('has-success');
        } else {
            $('#error_telf1_e').css('display', 'none');
            $('#telefono_emp_e').parent().removeClass('has-success');
        }
    });

    $('#dni_emp').inputmask("mask", {"mask": "99999999"});
    $('#afp_emp').number(true, 1);
    $('#afp_emp').keyup(function() {
        var afp = $(this).val();
        if (afp > 100) {
            $(this).val("100");
        }
    });
    $('#afp_emp_e').number(true, 1);
    $('#afp_emp_e').keyup(function() {
        var afp = $(this).val();
        if (afp > 100) {
            $(this).val("100");
        }
    });

    $('#dni_emp').keyup(function() {
        var dni = $(this).val();
        var sw = true;

        $.each(empleados, function(key, row) {
            if (row[4] == dni) {
                $('#dni_emp').parent().addClass('has-error');
                $('#dni_emp').parent().find('label').html('<i class="fa fa-times-circle-o"></i> D.N.I.: * Ya se encuentra asociado con otro empleado');
                $('#registrar_emp').prop('disabled', true);
                sw = false;
                console.log($(this)[4]);
                return false;
            }
        });

        if (sw) {
            $('#dni_emp').parent().removeClass('has-error');
            $('#dni_emp').parent().removeClass('has-success');
            $('#dni_emp').parent().find('label').html('D.N.I.: * <span class="text-muted" style="font-style: italic;">(Debe contener 8 dígitos)</span>');
            $('#registrar_emp').prop('disabled', false);

            if (verificar_format_dni()) {
                $('#dni_emp').parent().addClass('has-success');
                $('#dni_emp').parent().find('label').html('<i class="fa fa-check"></i> D.N.I.: * ¡Correcto!');
            }
        }
    });
    $('#dni_emp_e').keyup(function() {
        var dni = $(this).val();
        var dni_h = $('#dni_emp_h').val();
        var sw = true;

        if (dni != dni_h) {

            $.each(empleados, function(key, row) {
                if (row[4] == dni) {
                    $('#dni_emp_e').parent().addClass('has-error');
                    $('#dni_emp_e').parent().find('label').html('<i class="fa fa-times-circle-o"></i> D.N.I.: * Ya se encuentra asociado con otro empleado');
                    $('#editar_emp').prop('disabled', true);
                    sw = false;
                    return false;
                }
            });

            if (sw) {
                $('#dni_emp_e').parent().removeClass('has-error');
                $('#dni_emp_e').parent().removeClass('has-success');
                $('#dni_emp_e').parent().find('label').html('D.N.I.: * <span class="text-muted" style="font-style: italic;">(Debe contener 8 dígitos)</span>');
                $('#editar_emp').prop('disabled', false);

                if (verificar_format_dni_e()) {
                    $('#dni_emp_e').parent().addClass('has-success');
                    $('#dni_emp_e').parent().find('label').html('<i class="fa fa-check"></i> D.N.I.: * ¡Correcto!');
                }
            }
        } else {
            $('#dni_emp_e').parent().removeClass('has-error');
            $('#dni_emp_e').parent().removeClass('has-success');
            $('#dni_emp_e').parent().find('label').html('D.N.I.: * <span class="text-muted" style="font-style: italic;">(Debe contener 8 dígitos)</span>');
            $('#editar_emp').prop('disabled', false);
        }
    });

});