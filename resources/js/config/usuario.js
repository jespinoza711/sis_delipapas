$(document).ready(function() {

    var usuarios;

    if ($("#cpo_usuario").is(':visible')) {
        $.ajax({
            url: base_url + 'usuario/get_vusuario',
            type: 'post',
            success: function(data) {
                usuarios = $.parseJSON(data);
//                console.log(usuarios);
            }
        });
    }

    $('#table-usuario').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "usuario/paginate",
        "sServerMethod": "POST",
        "bPaginate": true,
        "bFilter": true,
        "bSort": false,
        "displayLength": 10
    });

    $(".tooltip-usu").tooltip();
    $("#form_usu").submit(function() {

        var nomb_usu = $('#nomb_usu').val();
        var sw_usu = false;

        $.each(usuarios, function(key, row) {
            if (row[3] == nomb_usu) {
                var dialog = confirm("Ya existe un usuario con el nombre " + nomb_usu + ". ¿Desea editar el usuario existente?");
                if (dialog == true) {
                    $("#codi_usu_e").val(row[0]);
                    $("#nomb_usu_e").val(row[3]);
                    $("#codi_rol_e option:contains('" + row[2] + "')").prop("selected", true);
                    $("#ModalNuevoUsuario").modal("hide");
                    $("#ModalEditarUsuario").modal("show");
                }
                sw_usu = true;
                return false;
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

    $(document).on('click', '.editar_usu', function() {
        var tr = $(this).parent().parent();
        $("#codi_usu_e").val(tr.find("td").eq(0).html());
        $("#nomb_usu_e").val(tr.find("td").eq(1).html());
        $("#codi_rol_e option:contains('" + tr.find("td").eq(2).html() + "')").prop("selected", true);
        $("#ModalEditarUsuario").modal("show");
    });

    var sw_search = "default";

    $('.sw_search_usu').click(function() {
        var input = $(this).find("input");

        var class_search = input.attr('class');

        if (class_search != sw_search) {

            sw_search = class_search;
            
            if (class_search == "default") {
                $('#table-usuario_filter input[type="search"]').inputmask("remove");
            } else if (class_search == "buy") {
                $('#table-usuario_filter input[type="search"]').inputmask("mask", {"alias": "dd/mm/yyyy"});
            }

        }


    });

});