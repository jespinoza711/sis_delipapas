$(document).ready(function() {

    function format_empleado(codigo) {
        var direccion = "";
        var dni = "";
        var sexo = "";
        var civil = "";
        var afp = "";
        var estado = "";
        $('#empleados-reg tr').each(function() {
            var codigo_reg = $(this).find("td").eq(0).html();
            if (codigo == codigo_reg) {
                direccion = $(this).find("td").eq(3).html();
                dni = $(this).find("td").eq(4).html();
                var sexo_a = $(this).find("td").eq(6).html();
                if (sexo_a == "M") {
                    sexo = "Masculino";
                } else if (sexo_a == "F") {
                    sexo = "Femenino";
                }
                var civil_a = $(this).find("td").eq(8).html();
                if (civil_a == "S") {
                    civil = "Soltero";
                } else if (civil_a == "C") {
                    civil = "Casado";
                } else if (civil_a == "D") {
                    civil = "Divorciado";
                }
                afp = $(this).find("td").eq(7).html() + '%';
                var esta_a = $(this).find("td").eq(9).html();
                if (esta_a == "A") {
                    estado = "Habilitado";
                } else if (esta_a == "D") {
                    estado = "Deshabilitado";
                }
            }
        });
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
                '<td>'+sexo+'</td>' +
                '</tr>' +
                '<tr>' +
                '<td><strong>Estado Civil:</strong></td>' +
                '<td>'+civil+'</td>' +
                '</tr>' +
                '<tr>' +
                '<td><strong>AFP:</strong></td>' +
                '<td>'+afp+'</td>' +
                '</tr>' +
                '<tr>' +
                '<td><strong>Estado:</strong></td>' +
                '<td>'+estado+'</td>' +
                '</tr>' +
                '</table>';
    }



    var table_empleado = $('#table_empleado').DataTable({
        "columnDefs": [
            {"visible": false, "targets": 3}
        ],
        "order": [[3, 'asc']],
        "displayLength": 25,
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

    $('#table_empleado tbody').on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        }
        else {
            table_empleado.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    $('#table_empleado tbody').on('click', 'td.extra', function() {
        var tr = $(this).closest('tr');
        var row = table_empleado.row(tr);

        if (row.child.isShown()) {
            $(this).find('button').removeClass('btn-warning');
            $(this).find('button').addClass('btn-primary');
            $(this).find('i').removeClass('fa-minus');
            $(this).find('i').addClass('fa-list');
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            $(this).find('button').removeClass('btn-primary');
            $(this).find('button').addClass('btn-warning');
            $(this).find('i').removeClass('fa-list');
            $(this).find('i').addClass('fa-minus');
            row.child(format_empleado($(this).parent().find("td").eq(1).html())).show();
            tr.addClass('shown');
        }
    });

    $(".editar_emp").click(function() {

        var tr = $(this).parent().parent();

        var codigo = tr.find("td").eq(0).html();

        $('#empleados-reg tr').each(function() {
            var codigo_reg = $(this).find('td').eq(0).html();
            if (codigo == codigo_reg) {
                $("#codigo_emp_e").val(codigo);
                $("#nomb_emp_e").val($(this).find('td').eq(1).html());
                $("#apel_emp_e").val($(this).find('td').eq(2).html());
                $("#dni_emp_e").val($(this).find('td').eq(4).html());
                var telefono = $(this).find('td').eq(5).html();
                if (telefono.length == 13) {
                    $('#movil_e').removeClass('active');
                    $('#linea_e').addClass('active');
                    $("#telefono_emp_e").val(telefono);
                    $('#telefono_emp_e').inputmask("mask", {"mask": "(99) 999-9999"});
                } else if (telefono.length == 16) {
                    $('#linea_e').removeClass('active');
                    $('#movil_e').addClass('active');
                    $("#telefono_emp_e").val(telefono);
                    $('#telefono_emp_e').inputmask("mask", {"mask": "(99) 999-999-999"});
                }
                $("#direccion_emp_e").val($(this).find('td').eq(3).html());

                var sexo = $(this).find('td').eq(6).html();
                var civil = $(this).find('td').eq(8).html();

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

                var codi_tem = $(this).find('td').eq(11).html();
                $("#tipo_emp_e option[value='" + codi_tem + "']").prop("selected", true);
                var codi_pla = $(this).find('td').eq(10).html();
                $("#plan_emp_e option[value='" + codi_pla + "']").prop("selected", true);
                $("#afp_emp_e").val($(this).find('td').eq(7).html());

                // REGISTRO ACTUAL
                $("#nomb_emp_h").val($(this).find('td').eq(1).html());
                $("#apel_emp_h").val($(this).find('td').eq(2).html());
                $("#dni_emp_h").val($(this).find('td').eq(4).html());
                $("#telefono_emp_h").val($(this).find('td').eq(5).html());
                $("#direccion_emp_h").val($(this).find('td').eq(3).html());
                $("#sexo_emp_h").val($(this).find('td').eq(6).html());
                $("#civil_emp_h").val($(this).find('td').eq(8).html());
                $("#afp_emp_h").val($(this).find('td').eq(7).html());
                $("#tem_emp_h").val($(this).find('td').eq(10).html());
                $("#pla_emp_h").val($(this).find('td').eq(11).html());

                $('#dni_emp_e').parent().removeClass('has-error');
                $('#dni_emp_e').parent().removeClass('has-success');
                $('#dni_emp_e').parent().find('label').html('D.N.I.: * <span class="text-muted" style="font-style: italic;">(Debe contener 8 dígitos)</span>');
                $('#editar_emp').prop('disabled', false);

                $("#ModalEditarEmpleado").modal("show");
                return false;
            }
        });
    });

    $('#form_pla').submit(function() {
        var sueldo = $('#suel_pla').val() + '.00';
        var sw = false;
        $('#pla-reg tr').each(function() {
            var pla = $(this).find("td").eq(2).html();
            if (pla == sueldo) {
                $('#error_pla1').css('display', 'inherit');
                $('#error_pla1').parent().addClass('has-error');
                $('#registrar_pla').prop('disabled', true);
                sw = true;
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
        $('#tipo_emp-reg tr').each(function() {
            var tem = $(this).find("td").eq(1).html();
            if (tem.toUpperCase() == nombre.toUpperCase()) {
                $('#error_tem1').css('display', 'inherit');
                $('#error_tem1').parent().addClass('has-error');
                $('#registrar_temp').prop('disabled', true);
                sw = true;
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
            if (!es_numerico(telf.charAt(13)))
                sw = true;
            if (!es_numerico(telf.charAt(14)))
                sw = true;
            if (!es_numerico(telf.charAt(15)))
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
            if (!es_numerico(telf.charAt(13)))
                sw = true;
            if (!es_numerico(telf.charAt(14)))
                sw = true;
            if (!es_numerico(telf.charAt(15)))
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
    });
    $('#form_emp_edit').submit(function() {
        if (!verificar_format_telefono_e()) {
            $('#error_telf1_e').css('display', 'inherit');
            $('#telefono_emp_e').parent().addClass('has-error');
            return false;
        }
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
        $('#telefono_emp').inputmask("mask", {"mask": "(99) 999-999-999"});

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
        $('#telefono_emp_e').inputmask("mask", {"mask": "(99) 999-999-999"});

        if (verificar_format_telefono_e()) {
            $('#telefono_emp_e').parent().removeClass('has-error');
            $('#error_telf1_e').css('display', 'none');
            $('#telefono_emp_e').parent().addClass('has-success');
        } else {
            $('#error_telf1_e').css('display', 'none');
            $('#telefono_emp_e').parent().removeClass('has-success');
        }
    });

    $('#dni_emp').number(true, 0, ',', '');
    $('#dni_emp_e').number(true, 0, ',', '');
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
        $('#empleados-reg tr').each(function() {
            var dni_reg = $(this).find('td').eq(4).html();
            if (dni == dni_reg) {
                $('#dni_emp').parent().addClass('has-error');
                $('#dni_emp').parent().find('label').html('<i class="fa fa-times-circle-o"></i> D.N.I.: * Ya se encuentra asociado con otro empleado');
                $('#registrar_emp').prop('disabled', true);
                sw = false;
                return false;
            }
        });
        if (sw) {
            $('#dni_emp').parent().removeClass('has-error');
            $('#dni_emp').parent().removeClass('has-success');
            $('#dni_emp').parent().find('label').html('D.N.I.: * <span class="text-muted" style="font-style: italic;">(Debe contener 8 dígitos)</span>');
            $('#registrar_emp').prop('disabled', false);

            if ($('#dni_emp').val().length == 8) {
                $('#dni_emp').parent().addClass('has-success');
                $('#dni_emp').parent().find('label').html('<i class="fa fa-check"></i> D.N.I.: * ¡Correcto!');
            }
        }
    });
    $('#dni_emp_e').keyup(function() {
        var dni = $(this).val();
        var dni_h = $('#dni_emp_h').val();
        var sw = true;
        $('#empleados-reg tr').each(function() {
            var dni_reg = $(this).find('td').eq(4).html();
            if (dni == dni_reg && dni != dni_h) {
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

            if ($('#dni_emp_e').val().length == 8) {
                $('#dni_emp_e').parent().addClass('has-success');
                $('#dni_emp_e').parent().find('label').html('<i class="fa fa-check"></i> D.N.I.: * ¡Correcto!');
            }
        }
    });

});