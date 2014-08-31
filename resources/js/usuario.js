$(document).ready(function() {

    $(".tooltip-usu").tooltip();

//    $("#table-usuario").DataTable();

    $("#form_usu").submit(function() {

        var logi_usu = $('#logi_usu').val();
        var sw_usu = false;
        $("#usuarios-rep li").each(function() {
            if ($(this).html() == logi_usu) {
                var dialog = confirm("Ya existe un usuario con el nombre " + logi_usu + ". ¿Desea editar el usuario existente?");
                if (dialog == true) {
                    $("#usuarios-det tr").each(function() {
                        if ($(this).find("td").eq(1).html() == logi_usu) {
                            var tr = $(this);
                            $("#codi_usu_e").val(tr.find("td").eq(0).html());
                            $("#logi_usu_e").val(tr.find("td").eq(1).html());
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
            var con_pass_usu = $('#con_pass_usu').val();
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
        var con_pass_usu = $('#con_pass_usu_e').val();
        if ((pass_usu != "" || con_pass_usu != "") && pass_usu != con_pass_usu) {
            $('#pass_usu_e').focus();
            alert("Las contraseñas no coinciden, intente nuevamente");
            return false;
        }
    });

    // TEST: MOSTRAR CONTRASEÑA
//    $("#table-usuario").on("click", ".watch-key", function() {
//        
//
//        var tr = $(this).parent().parent();
//        var key = tr.find(".pass_key").html();
//
//        if (tr.parent().find(".popover").is(":visible")) {
//            $(this).popover("destroy");
//            $(this).attr("data-toggle", "tooltip");
//            $(this).attr("data-content", "Ver contraseña");
//            $(this).attr("title", "Ver contraseña");
//            $(this).attr("data-original-title", "Ver contraseña");
//            $(this).tooltip();
//        } else {
//            $(this).tooltip("destroy");
//            $(this).attr("data-toggle", "popover");
//            $(this).attr("data-content", key);
//            $(this).attr("title", "");
//            $(this).attr("data-original-title", "Contraseña");
//            $(this).popover("show");
//        }
//    });

    $(".editar_usu").click(function() {

        var tr = $(this).parent().parent();

        $("#codi_usu_e").val(tr.find("td").eq(0).html());
        $("#logi_usu_e").val(tr.find("td").eq(1).html());
        $("#codi_rol_e option:contains('" + tr.find("td").eq(2).html() + "')").prop("selected", true);

        $("#ModalEditarUsuario").modal("show");
    });
//
//    $('#form_enf').submit(function() {
//
//        var codi_enf = $("#codi_cie").val();
//
//        var sw_registrar = false;
//        $("#enfermedades-rep li").each(function() {
//            if ($(this).html() == codi_enf) {
//                sw_registrar = true;
//                var dialogo = confirm("Ya existe una enfermedad del código ingresado, ¿Desea editar la enfermedad?");
//                if (dialogo == true) {
//                    var tr = $("#table-cie tbody tr td:contains('" + codi_enf + "')").parent();
//
//                    $("#codi_cie_e").val(tr.find("td").eq(0).html());
//                    $("#titu_cie_e").val(tr.find("td").eq(1).html());
//                    $("#desc_cie_e").val(tr.find("td").eq(2).html());
//
//                    $("#ModalNuevaEnfermedad").modal("hide");
//                    $("#ModalEditarEnfermedad").modal("show");
//                }
//            }
//        });
//        if (sw_registrar) {
//            return false;
//        }
//    });


});