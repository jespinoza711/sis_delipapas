$(document).ready(function() {

    $(".tooltip-usu").tooltip();
    $("#form_usu").submit(function() {

        var nomb_usu = $('#nomb_usu').val();
        var sw_usu = false;
        $("#usuarios-rep li").each(function() {
            if ($(this).html() == nomb_usu) {
                var dialog = confirm("Ya existe un usuario con el nombre " + nomb_usu + ". ¿Desea editar el usuario existente?");
                if (dialog == true) {
                    $("#usuarios-det tr").each(function() {
                        if ($(this).find("td").eq(1).html() == nomb_usu) {
                            var tr = $(this);
                            $("#codi_usu_e").val(tr.find("td").eq(0).html());
                            $("#nomb_usu_e").val(tr.find("td").eq(1).html());
                            $("#codi_rol_e option:contains('" + tr.find("td").eq(2).html() + "')").prop("selected", true);
                            $("#ModalNuevoUsuario").modal("hide");
                            $("#ModalEditarUsuario").modal("show");
                        }
                    });
                }
                sw_usu = true;
            }
        });
        if (sw_usu) {
            return false;
        } else {
            var pass_usu = $('#pass_usu').val();
            var con_pass_usu = $('#pass_usu_con').val();
            if (pass_usu != con_pass_usu) {
                $('#pass_usu').focus();
                alert("Las contraseñas no coinciden, intente nuevamente");
                return false;
            } else {
                return true;
            }
        }
    });

    $("#form_usu_edit").submit(function() {
        var pass_usu = $('#pass_usu_e').val();
        var con_pass_usu = $('#pass_usu_con_e').val();
        if ((pass_usu != "" || con_pass_usu != "") && pass_usu != con_pass_usu) {
            $('#pass_usu_e').focus();
            alert("Las contraseñas no coinciden, intente nuevamente");
            return false;
        }
    });

    $(".editar_usu").click(function() {
        var tr = $(this).parent().parent();
        $("#codi_usu_e").val(tr.find("td").eq(0).html());
        $("#nomb_usu_e").val(tr.find("td").eq(1).html());
        $("#codi_rol_e option:contains('" + tr.find("td").eq(2).html() + "')").prop("selected", true);
        $("#ModalEditarUsuario").modal("show");
    });

});