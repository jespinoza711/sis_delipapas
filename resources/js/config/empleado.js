$(document).ready(function() {

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

    $('#telefono_emp').keyup(function() {
        if (verificar_format_telefono()) {
            $('#error_telf1').css('display','none');
            $('#telefono_emp').parent().removeClass('has-error');
            $('#telefono_emp').parent().addClass('has-success');
        } else {
            $('#telefono_emp').parent().removeClass('has-success');
        }
    });

    $('#form_emp').submit(function() {
        if (!verificar_format_telefono()) {
            $('#error_telf1').css('display','inherit');
            $('#telefono_emp').parent().addClass('has-error');
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
            $('#error_telf1').css('display','none');
            $('#telefono_emp').parent().removeClass('has-error');
            $('#telefono_emp').parent().addClass('has-success');
        } else {
            $('#error_telf1').css('display','none');
            $('#telefono_emp').parent().removeClass('has-success');
        }
    });
    $('#movil').click(function() {
        $('#linea').removeClass('active');
        $('#movil').addClass('active');
        $('#telefono_emp').inputmask("mask", {"mask": "(99) 999-999-999"});

        if (verificar_format_telefono()) {
            $('#telefono_emp').parent().removeClass('has-error');
            $('#error_telf1').css('display','none');
            $('#telefono_emp').parent().addClass('has-success');
        } else {
            $('#error_telf1').css('display','none');
            $('#telefono_emp').parent().removeClass('has-success');
        }
    });

    $('#dni_emp').number(true, 0, ',', '');
    $('#afp_emp').number(true, 1);
    $('#afp_emp').keyup(function() {
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

});