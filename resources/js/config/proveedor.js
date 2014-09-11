$(document).ready(function() {

    var proveedores;

    if ($("#cpo_proveedor").is(':visible')) {
        $.ajax({
            url: base_url + 'proveedor/get_proveedor',
            type: 'post',
            success: function(data) {
                proveedores = $.parseJSON(data);
//                console.log(proveedores);
            }
        });
    }

    var table_proveedor = $('#table_proveedor').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "proveedor/paginate",
        "sServerMethod": "POST",
        "bPaginate": true,
        "bFilter": true,
        "bSort": false,
        "displayLength": 10
    });

    $('#table_proveedor tbody').on('click', 'button.info_prov', function() {
        var codigo = $(this).parent().parent().find("td").eq(1).html();
        var pos = proveedores[codigo];
        if (pos) {
            var tr = $(this).parent().parent().closest('tr');
            var row = table_proveedor.row(tr);

            if (row.child.isShown()) {
                $(this).removeClass('btn-warning');
                $(this).addClass('btn-primary');
                $(this).find('i').removeClass('fa-minus');
                $(this).find('i').addClass('fa-chevron-down');
                row.child.hide();
                tr.removeClass('shown');
                table_proveedor.$('tr.selected').removeClass('selected');
                $(this).parent().parent().removeClass('selected');
            }
            else {
                $(this).removeClass('btn-primary');
                $(this).addClass('btn-warning');
                $(this).find('i').removeClass('fa-chevron-down');
                $(this).find('i').addClass('fa-minus');
                row.child(format_proveedor(codigo)).show();
                tr.addClass('shown');
                $(this).parent().parent().addClass('selected');
            }
        }
    });

    function format_proveedor(c) {

        var direccion = "";
        var telefono = "";
        var ruc = "";
        var email = "-";

        direccion = proveedores[c][2];
        telefono = proveedores[c][3];
        ruc = proveedores[c][4];
        if (proveedores[c][5] != null) {
            email = proveedores[c][5];
        }

        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                '<tr>' +
                '<td><strong>R.U.C.:</strong></td>' +
                '<td>' + ruc + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><strong>Dirección:</strong></td>' +
                '<td>' + direccion + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><strong>Teléfono:</strong></td>' +
                '<td>' + telefono + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><strong>E-mail:</strong></td>' +
                '<td>' + email + '</td>' +
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

    function verificar_format_ruc_prov() {
        var ruc = $('#ruc_prov').val();
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
            $('#ruc_prov').focus();
        } else {
            return true;
        }
    }

    function verificar_format_telefono_prov() {
        var telf = $('#telefono_prov').val();
        var sw = false;
        if ($('#linea_prov').hasClass("active")) {
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
        } else if ($('#movil_prov').hasClass("active")) {
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
            $('#telefono_prov').focus();
        } else {
            return true;
        }
    }

    function verificar_format_ruc_prov_e() {
        var ruc = $('#ruc_prov_e').val();
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
            $('#ruc_prov_e').focus();
        } else {
            return true;
        }
    }

    function verificar_format_telefono_prov_e() {
        var telf = $('#telefono_prov_e').val();
        var sw = false;
        if ($('#linea_prov_e').hasClass("active")) {
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
        } else if ($('#movil_prov_e').hasClass("active")) {
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
            $('#telefono_prov_e').focus();
        } else {
            return true;
        }
    }

    // Nuevo proveedor

    $('#ruc_prov').inputmask("mask", {"mask": "99999999999"});
    $('#telefono_prov').inputmask("mask", {"mask": "(99) 999-9999"});
    $('#linea_prov').click(function() {
        $('#movil_prov').removeClass('active');
        $('#linea_prov').addClass('active');
        $('#telefono_prov').inputmask("mask", {"mask": "(99) 999-9999"});

        if (verificar_format_telefono_prov()) {
            $('#error_telf1_prov').css('display', 'none');
            $('#telefono_prov').parent().removeClass('has-error');
            $('#telefono_prov').parent().addClass('has-success');
        } else {
            $('#error_telf1_prov').css('display', 'none');
            $('#telefono_prov').parent().removeClass('has-success');
        }
    });
    $('#movil_prov').click(function() {
        $('#linea_prov').removeClass('active');
        $('#movil_prov').addClass('active');
        $('#telefono_prov').inputmask("mask", {"mask": "999-999-999"});

        if (verificar_format_telefono_prov()) {
            $('#telefono_prov').parent().removeClass('has-error');
            $('#error_telf1_prov').css('display', 'none');
            $('#telefono_prov').parent().addClass('has-success');
        } else {
            $('#error_telf1_prov').css('display', 'none');
            $('#telefono_prov').parent().removeClass('has-success');
        }
    });
    $('#ruc_prov').keyup(function() {
        var ruc = $(this).val();
        var sw = true;

        $.each(proveedores, function(key, row) {
            if (row[4] == ruc) {
                $('#ruc_prov').parent().addClass('has-error');
                $('#ruc_prov').parent().find('label').html('<i class="fa fa-times-circle-o"></i> R.U.C.: * Ya se encuentra asociado con otro proveedor');
                $('#registrar_prov').prop('disabled', true);
                sw = false;
                return false;
            }
        });

        if (sw) {
            $('#ruc_prov').parent().removeClass('has-error');
            $('#ruc_prov').parent().removeClass('has-success');
            $('#ruc_prov').parent().find('label').html('R.U.C.: *');
            $('#registrar_prov').prop('disabled', false);

            if (verificar_format_ruc_prov()) {
                $('#ruc_prov').parent().addClass('has-success');
                $('#ruc_prov').parent().find('label').html('<i class="fa fa-check"></i> R.U.C.: * ¡Correcto!');
            }
        }
    });

    $('#form_prov').submit(function() {
        if (!verificar_format_telefono_prov()) {
            $('#error_telf1_prov').css('display', 'inherit');
            $('#telefono_prov').parent().addClass('has-error');
            return false;
        }
        if (!verificar_format_ruc_prov()) {
            $('#ruc_prov').parent().addClass('has-error');
            $('#registrar_prov').prop('disabled', true);
            return false;
        }
    });

    // Editar proveedor

    $(document).on('click', '.editar_prov', function() {

        var tr = $(this).parent().parent();

        var codigo = tr.find("td").eq(1).html();

        $("#codigo_prov_e").val(codigo);
        $("#nomb_prov_e").val(proveedores[codigo][1]);
        $("#direccion_prov_e").val(proveedores[codigo][2]);
        $("#ruc_prov_e").val(proveedores[codigo][4]);
        $('#ruc_prov_e').inputmask("mask", {"mask": "99999999999"});
        var telefono = proveedores[codigo][3];
        if (telefono.length == 13) {
            $('#movil_prov_e').removeClass('active');
            $('#linea_prov_e').addClass('active');
            $("#telefono_prov_e").val(telefono);
            $('#telefono_prov_e').inputmask("mask", {"mask": "(99) 999-9999"});
        } else if (telefono.length == 11) {
            $('#linea_prov_e').removeClass('active');
            $('#movil_prov_e').addClass('active');
            $("#telefono_prov_e").val(telefono);
            $('#telefono_prov_e').inputmask("mask", {"mask": "999-999-999"});
        }

        if (proveedores[codigo][5] != null) {
            $('#email_prov_e').val(proveedores[codigo][5]);
        }

        $('#ruc_prov_e').parent().removeClass('has-error');
        $('#ruc_prov_e').parent().removeClass('has-success');
        $('#ruc_prov_e').parent().find('label').html('R.U.C.: * ');
        $('#error_telf1_prov_e').css('display', 'none');
        $('#telefono_prov_e').parent().removeClass('has-success');
        $('#editar_prov').prop('disabled', false);

        // REGISTRO ACTUAL
        $("#nomb_prov_h").val(proveedores[codigo][1]);
        $("#ruc_prov_h").val(proveedores[codigo][4]);
        $("#telf_prov_h").val(proveedores[codigo][3]);
        $("#dire_prov_h").val(proveedores[codigo][2]);
        $("#emai_prov_h").val(proveedores[codigo][5]);

        $("#ModalEditarProveedor").modal("show");

    });

    $('#linea_prov_e').click(function() {
        $('#movil_prov_e').removeClass('active');
        $('#linea_prov_e').addClass('active');
        $('#telefono_prov_e').inputmask("mask", {"mask": "(99) 999-9999"});

        if (verificar_format_telefono_prov_e()) {
            $('#error_telf1_prov_e').css('display', 'none');
            $('#telefono_prov_e').parent().removeClass('has-error');
            $('#telefono_prov_e').parent().addClass('has-success');
        } else {
            $('#error_telf1_prov_e').css('display', 'none');
            $('#telefono_prov_e').parent().removeClass('has-success');
        }
    });
    $('#movil_prov_e').click(function() {
        $('#linea_prov_e').removeClass('active');
        $('#movil_prov_e').addClass('active');
        $('#telefono_prov_e').inputmask("mask", {"mask": "999-999-999"});

        if (verificar_format_telefono_prov_e()) {
            $('#telefono_prov_e').parent().removeClass('has-error');
            $('#error_telf1_prov_e').css('display', 'none');
            $('#telefono_prov_e').parent().addClass('has-success');
        } else {
            $('#error_telf1_prov_e').css('display', 'none');
            $('#telefono_prov_e').parent().removeClass('has-success');
        }
    });
    $('#ruc_prov_e').keyup(function() {
        var ruc = $(this).val();
        var ruc_h = $('#ruc_prov_h').val();
        var sw = true;

        if (ruc != ruc_h) {
            $.each(proveedores, function(key, row) {
                if (row[4] == ruc) {
                    $('#ruc_prov_e').parent().addClass('has-error');
                    $('#ruc_prov_e').parent().find('label').html('<i class="fa fa-times-circle-o"></i> R.U.C.: * Ya se encuentra asociado con otro proveedor');
                    $('#editar_prov').prop('disabled', true);
                    sw = false;
                    return false;
                }
            });

            if (sw) {
                $('#ruc_prov_e').parent().removeClass('has-error');
                $('#ruc_prov_e').parent().removeClass('has-success');
                $('#ruc_prov_e').parent().find('label').html('R.U.C.: *');
                $('#editar_prov').prop('disabled', false);

                if (verificar_format_ruc_prov_e()) {
                    $('#ruc_prov_e').parent().addClass('has-success');
                    $('#ruc_prov_e').parent().find('label').html('<i class="fa fa-check"></i> R.U.C.: * ¡Correcto!');
                }
            }
        } else {
            $('#ruc_prov_e').parent().removeClass('has-error');
            $('#ruc_prov_e').parent().removeClass('has-success');
            $('#ruc_prov_e').parent().find('label').html('R.U.C.: *');
            $('#editar_prov').prop('disabled', false);
        }
    });
    
    $('#form_prov_e').submit(function() {
        if (!verificar_format_telefono_prov_e()) {
            $('#error_telf1_prov_e').css('display', 'inherit');
            $('#telefono_prov_e').parent().addClass('has-error');
            return false;
        }
        if (!verificar_format_ruc_prov_e()) {
            $('#ruc_prov_e').parent().addClass('has-error');
            $('#editar_prov').prop('disabled', true);
            return false;
        }
    });
    
});