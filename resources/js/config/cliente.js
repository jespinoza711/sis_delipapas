$(document).ready(function() {

    var clientes;

    if ($("#cpo_cliente").is(':visible')) {
        $.ajax({
            url: base_url + 'cliente/get_cliente',
            type: 'post',
            success: function(data) {
                clientes = $.parseJSON(data);
                console.log(clientes);
            }
        });
    }

    var table_cliente = $('#table_cliente').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "cliente/paginate",
        "sServerMethod": "POST",
        "bPaginate": true,
        "bFilter": true,
        "bSort": false,
        "displayLength": 10
    });

    $('#table_cliente tbody').on('click', 'button.info_cli', function() {
        var codigo = $(this).parent().parent().find("td").eq(1).html();
        var pos = clientes[codigo];
        if (pos) {
            var tr = $(this).parent().parent().closest('tr');
            var row = table_cliente.row(tr);

            if (row.child.isShown()) {
                $(this).removeClass('btn-warning');
                $(this).addClass('btn-primary');
                $(this).find('i').removeClass('fa-minus');
                $(this).find('i').addClass('fa-chevron-down');
                row.child.hide();
                tr.removeClass('shown');
                table_cliente.$('tr.selected').removeClass('selected');
                $(this).parent().parent().removeClass('selected');
            }
            else {
                $(this).removeClass('btn-primary');
                $(this).addClass('btn-warning');
                $(this).find('i').removeClass('fa-chevron-down');
                $(this).find('i').addClass('fa-minus');
                row.child(format_cliente(codigo)).show();
                tr.addClass('shown');
                $(this).parent().parent().addClass('selected');
            }
        }
    });

    function format_cliente(c) {

        var direccion = "";
        var fecha = "";
        var ruc = "-";
        var sexo = "";

        direccion = clientes[c][3];
        fecha = clientes[c][6];
        var sexo_a = clientes[c][5];
        if (sexo_a == "M") {
            sexo = "Masculino";
        } else if (sexo_a == "F") {
            sexo = "Femenino";
        }
        if (clientes[c][7] != null) {
            ruc = clientes[c][7];
        }

        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                '<tr>' +
                '<td><strong>Fecha de nacimiento:</strong></td>' +
                '<td>' + fecha + '</td>' +
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
                '<td><strong>R.U.C.:</strong></td>' +
                '<td>' + ruc + '</td>' +
                '</tr>' +
                '</table>';
    }

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

    function verificar_format_ruc_cli() {
        var ruc = $('#ruc_cli').val();
        if (ruc != "") {
            var sw = false;

            if (!es_numerico(ruc.charAt(0)))
                sw = true;
            if (!es_numerico(ruc.charAt(1)))
                sw = true;
            if (!es_numerico(ruc.charAt(2)))
                sw = true;
            if (!es_numerico(ruc.charAt(3)))
                sw = true;
            if (!es_numerico(ruc.charAt(4)))
                sw = true;
            if (!es_numerico(ruc.charAt(5)))
                sw = true;
            if (!es_numerico(ruc.charAt(6)))
                sw = true;
            if (!es_numerico(ruc.charAt(7)))
                sw = true;
            if (!es_numerico(ruc.charAt(8)))
                sw = true;
            if (!es_numerico(ruc.charAt(9)))
                sw = true;
            if (!es_numerico(ruc.charAt(10)))
                sw = true;
            if (sw) {
                return false;
                $('#ruc_cli').focus();
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    function verificar_format_fecha_cli() {
        var ruc = $('#fecha_cli').val();
        var sw = false;

        if (!es_numerico(ruc.charAt(0)))
            sw = true;
        if (!es_numerico(ruc.charAt(1)))
            sw = true;
        if (!es_numerico(ruc.charAt(2)))
            sw = true;
        if (!es_numerico(ruc.charAt(3)))
            sw = true;
        if (!es_numerico(ruc.charAt(5)))
            sw = true;
        if (!es_numerico(ruc.charAt(6)))
            sw = true;
        if (!es_numerico(ruc.charAt(8)))
            sw = true;
        if (!es_numerico(ruc.charAt(9)))
            sw = true;
        if (sw) {
            return false;
            $('#fecha_cli').focus();
        } else {
            return true;
        }
    }

    function verificar_format_telefono_cli() {
        var telf = $('#telefono_cli').val();
        var sw = false;
        if ($('#linea_cli').hasClass("active")) {
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
        } else if ($('#movil_cli').hasClass("active")) {
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
            $('#telefono_cli').focus();
        } else {
            return true;
        }
    }

    function verificar_format_ruc_cli_e() {
        var ruc = $('#ruc_cli_e').val();
        if (ruc != "") {
            var sw = false;

            if (!es_numerico(ruc.charAt(0)))
                sw = true;
            if (!es_numerico(ruc.charAt(1)))
                sw = true;
            if (!es_numerico(ruc.charAt(2)))
                sw = true;
            if (!es_numerico(ruc.charAt(3)))
                sw = true;
            if (!es_numerico(ruc.charAt(4)))
                sw = true;
            if (!es_numerico(ruc.charAt(5)))
                sw = true;
            if (!es_numerico(ruc.charAt(6)))
                sw = true;
            if (!es_numerico(ruc.charAt(7)))
                sw = true;
            if (!es_numerico(ruc.charAt(8)))
                sw = true;
            if (!es_numerico(ruc.charAt(9)))
                sw = true;
            if (!es_numerico(ruc.charAt(10)))
                sw = true;
            if (sw) {
                return false;
                $('#ruc_cli_e').focus();
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    function verificar_format_telefono_cli_e() {
        var telf = $('#telefono_cli_e').val();
        var sw = false;
        if ($('#linea_cli_e').hasClass("active")) {
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
        } else if ($('#movil_cli_e').hasClass("active")) {
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
            $('#telefono_cli_e').focus();
        } else {
            return true;
        }
    }

    function verificar_format_fecha_cli_e() {
        var ruc = $('#fecha_cli_e').val();
        var sw = false;

        if (!es_numerico(ruc.charAt(0)))
            sw = true;
        if (!es_numerico(ruc.charAt(1)))
            sw = true;
        if (!es_numerico(ruc.charAt(2)))
            sw = true;
        if (!es_numerico(ruc.charAt(3)))
            sw = true;
        if (!es_numerico(ruc.charAt(5)))
            sw = true;
        if (!es_numerico(ruc.charAt(6)))
            sw = true;
        if (!es_numerico(ruc.charAt(8)))
            sw = true;
        if (!es_numerico(ruc.charAt(9)))
            sw = true;
        if (sw) {
            return false;
            $('#fecha_cli_e').focus();
        } else {
            return true;
        }
    }

    // Nuevo cliente
    $('#ruc_cli').inputmask("mask", {"mask": "99999999999"});
    $('#fecha_cli').inputmask("mask", {"alias": "yyyy-mm-dd"});
    $('#telefono_cli').inputmask("mask", {"mask": "(99) 999-9999"});
    $('#linea_cli').click(function() {
        $('#movil_cli').removeClass('active');
        $('#linea_cli').addClass('active');
        $('#telefono_cli').inputmask("mask", {"mask": "(99) 999-9999"});

        if (verificar_format_telefono_cli()) {
            $('#error_telf1_cli').css('display', 'none');
            $('#telefono_cli').parent().removeClass('has-error');
            $('#telefono_cli').parent().addClass('has-success');
        } else {
            $('#error_telf1_cli').css('display', 'none');
            $('#telefono_cli').parent().removeClass('has-success');
        }
    });
    $('#movil_cli').click(function() {
        $('#linea_cli').removeClass('active');
        $('#movil_cli').addClass('active');
        $('#telefono_cli').inputmask("mask", {"mask": "999-999-999"});

        if (verificar_format_telefono_cli()) {
            $('#telefono_cli').parent().removeClass('has-error');
            $('#error_telf1_cli').css('display', 'none');
            $('#telefono_cli').parent().addClass('has-success');
        } else {
            $('#error_telf1_cli').css('display', 'none');
            $('#telefono_cli').parent().removeClass('has-success');
        }
    });
    $('#ruc_cli').keyup(function() {
        var ruc = $(this).val();
        var sw = true;

        $.each(clientes, function(key, row) {
            if (row[7] == ruc) {
                $('#ruc_cli').parent().addClass('has-error');
                $('#ruc_cli').parent().find('label').html('<i class="fa fa-times-circle-o"></i> R.U.C.: Ya se encuentra asociado con otro proveedor');
                $('#registrar_cli').prop('disabled', true);
                sw = false;
                return false;
            }
        });

        if (sw) {
            $('#ruc_cli').parent().removeClass('has-error');
            $('#ruc_cli').parent().removeClass('has-success');
            $('#ruc_cli').parent().find('label').html('R.U.C.: ');
            $('#registrar_cli').prop('disabled', false);

            if (verificar_format_ruc_cli()) {
                $('#ruc_cli').parent().addClass('has-success');
                $('#ruc_cli').parent().find('label').html('<i class="fa fa-check"></i> R.U.C.: ¡Correcto!');
            }
        }
    });

    $('#fecha_cli').keyup(function() {
        $('#fecha_cli').parent().parent().removeClass('has-error');
        $('#fecha_cli').parent().parent().removeClass('has-success');
        $('#fecha_cli').parent().parent().find('label').html('Fecha de nacimiento: *');
        $('#registrar_cli').prop('disabled', false);

        if (verificar_format_fecha_cli()) {
            $('#fecha_cli').parent().parent().addClass('has-success');
            $('#fecha_cli').parent().parent().find('label').html('Fecha de nacimiento: * ¡Correcto!');
        }
    });

    $('#form_cli').submit(function() {
        if (!verificar_format_fecha_cli()) {
            $('#fecha_cli').parent().parent().addClass('has-error');
            $('#fecha_cli').parent().parent().find('label').html('<i class="fa fa-times-circle-o"></i> Fecha de nacimiento: * Por favor, complete la fecha');
            $('#registrar_cli').prop('disabled', true);
            return false;
        }
        if (!verificar_format_telefono_cli()) {
            $('#error_telf1_cli').css('display', 'inherit');
            $('#telefono_cli').parent().addClass('has-error');
            return false;
        }
        if (!verificar_format_ruc_cli()) {
            $('#ruc_cli').parent().addClass('has-error');
            $('#registrar_cli').prop('disabled', true);
            return false;
        }
    });

    // Editar cliente

    $(document).on('click', '.editar_cli', function() {

        var tr = $(this).parent().parent();

        var codigo = tr.find("td").eq(1).html();

        $("#codigo_cli_e").val(codigo);
        $("#nomb_cli_e").val(clientes[codigo][1]);
        $("#apel_cli_e").val(clientes[codigo][2]);
        $("#direccion_cli_e").val(clientes[codigo][3]);

        var telefono = clientes[codigo][4];
        if (telefono.length == 13) {
            $('#movil_cli_e').removeClass('active');
            $('#linea_cli_e').addClass('active');
            $("#telefono_cli_e").val(telefono);
            $('#telefono_cli_e').inputmask("mask", {"mask": "(99) 999-9999"});
        } else if (telefono.length == 11) {
            $('#linea_cli_e').removeClass('active');
            $('#movil_cli_e').addClass('active');
            $("#telefono_cli_e").val(telefono);
            $('#telefono_cli_e').inputmask("mask", {"mask": "999-999-999"});
        }

        if (clientes[codigo][7] != null) {
            $('#ruc_cli_e').val(clientes[codigo][7]);
        }
        $('#ruc_cli_e').inputmask("mask", {"mask": "99999999999"});

        $('#fecha_cli_e').val(clientes[codigo][6]);
        $('#fecha_cli_e').inputmask("mask", {"alias": "yyyy-mm-dd"});

        var sexo = clientes[codigo][5];

        if (sexo == 'M') {
            $(document).find('#femenino_cli_e').removeAttr('checked');
            $(document).find('#femenino_cli_e').parent().attr('aria-checked', 'false');
            $(document).find('#femenino_cli_e').parent().removeClass('checked');
            $(document).find('#masculino_cli_e').attr('checked', 'true');
            $(document).find('#masculino_cli_e').parent().attr('aria-checked', 'true');
            $(document).find('#masculino_cli_e').parent().addClass('checked');
        } else if (sexo == 'F') {
            $(document).find('#masculino_cli_e').removeAttr('checked');
            $(document).find('#masculino_cli_e').parent().attr('aria-checked', 'false');
            $(document).find('#masculino_cli_e').parent().removeClass('checked');
            $(document).find('#femenino_cli_e').attr('checked', 'true');
            $(document).find('#femenino_cli_e').parent().attr('aria-checked', 'true');
            $(document).find('#femenino_cli_e').parent().addClass('checked');
        }

        $('#ruc_cli_e').parent().removeClass('has-error');
        $('#ruc_cli_e').parent().removeClass('has-success');
        $('#ruc_cli_e').parent().find('label').html('R.U.C.: ');
        $('#error_telf1_cli_e').css('display', 'none');
        $('#telefono_cli_e').parent().removeClass('has-success');
        $('#fecha_cli_e').parent().removeClass('has-error');
        $('#fecha_cli_e').parent().removeClass('has-success');
        $('#fecha_cli_e').parent().find('label').html('Fecha de nacimiento: *');
        $('#editar_cli').prop('disabled', false);

        // REGISTRO ACTUAL
        $("#nomb_cli_h").val(clientes[codigo][1]);
        $("#apel_cli_h").val(clientes[codigo][2]);
        $("#dire_cli_h").val(clientes[codigo][3]);
        $("#sexo_cli_h").val(clientes[codigo][5]);
        $("#telf_cli_h").val(clientes[codigo][4]);
        $("#ruc_cli_h").val(clientes[codigo][7]);
        $("#fena_cli_h").val(clientes[codigo][6]);

        $("#ModalEditarCliente").modal("show");

    });

    $('#linea_cli_e').click(function() {
        $('#movil_cli_e').removeClass('active');
        $('#linea_cli_e').addClass('active');
        $('#telefono_cli_e').inputmask("mask", {"mask": "(99) 999-9999"});

        if (verificar_format_telefono_cli_e()) {
            $('#error_telf1_cli_e').css('display', 'none');
            $('#telefono_cli_e').parent().removeClass('has-error');
            $('#telefono_cli_e').parent().addClass('has-success');
        } else {
            $('#error_telf1_cli_e').css('display', 'none');
            $('#telefono_cli_e').parent().removeClass('has-success');
        }
    });
    $('#movil_cli_e').click(function() {
        $('#linea_cli_e').removeClass('active');
        $('#movil_cli_e').addClass('active');
        $('#telefono_cli_e').inputmask("mask", {"mask": "999-999-999"});

        if (verificar_format_telefono_cli_e()) {
            $('#telefono_cli_e').parent().removeClass('has-error');
            $('#error_telf1_cli_e').css('display', 'none');
            $('#telefono_cli_e').parent().addClass('has-success');
        } else {
            $('#error_telf1_cli_e').css('display', 'none');
            $('#telefono_cli_e').parent().removeClass('has-success');
        }
    });

    $('#ruc_cli_e').keyup(function() {
        var ruc = $(this).val();
        var ruc_h = $('#ruc_cli_h').val();
        var sw = true;

        if (ruc != ruc_h) {
            $.each(clientes, function(key, row) {
                if (row[7] == ruc) {
                    $('#ruc_cli_e').parent().addClass('has-error');
                    $('#ruc_cli_e').parent().find('label').html('<i class="fa fa-times-circle-o"></i> R.U.C.: Ya se encuentra asociado con otro proveedor');
                    $('#editar_cli').prop('disabled', true);
                    sw = false;
                    return false;
                }
            });

            if (sw) {
                $('#ruc_cli_e').parent().removeClass('has-error');
                $('#ruc_cli_e').parent().removeClass('has-success');
                $('#ruc_cli_e').parent().find('label').html('R.U.C.:');
                $('#editar_cli').prop('disabled', false);

                if (verificar_format_ruc_cli_e()) {
                    $('#ruc_cli_e').parent().addClass('has-success');
                    $('#ruc_cli_e').parent().find('label').html('<i class="fa fa-check"></i> R.U.C.: ¡Correcto!');
                }
            }
        } else {
            $('#ruc_cli_e').parent().removeClass('has-error');
            $('#ruc_cli_e').parent().removeClass('has-success');
            $('#ruc_cli_e').parent().find('label').html('R.U.C.:');
            $('#editar_cli').prop('disabled', false);
        }

    });
    
    
    $('#fecha_cli_e').keyup(function() {
        $('#fecha_cli_e').parent().parent().removeClass('has-error');
        $('#fecha_cli_e').parent().parent().removeClass('has-success');
        $('#fecha_cli_e').parent().parent().find('label').html('Fecha de nacimiento: *');
        $('#editar_cli').prop('disabled', false);

        if (verificar_format_fecha_cli_e()) {
            $('#fecha_cli_e').parent().parent().addClass('has-success');
            $('#fecha_cli_e').parent().parent().find('label').html('Fecha de nacimiento: * ¡Correcto!');
        }
    });
    
    $('#form_cli_e').submit(function() {
        if (!verificar_format_fecha_cli_e()) {
            $('#fecha_cli_e').parent().parent().addClass('has-error');
            $('#fecha_cli_e').parent().parent().find('label').html('<i class="fa fa-times-circle-o"></i> Fecha de nacimiento: * Por favor, complete la fecha');
            $('#editar_cli').prop('disabled', true);
            return false;
        }
        if (!verificar_format_telefono_cli_e()) {
            $('#error_telf1_cli_e').css('display', 'inherit');
            $('#telefono_cli_e').parent().addClass('has-error');
            return false;
        }
        if (!verificar_format_ruc_cli_e()) {
            $('#ruc_cli_e').parent().addClass('has-error');
            $('#editar_cli').prop('disabled', true);
            return false;
        }
    });

});