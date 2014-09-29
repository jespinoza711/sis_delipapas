$(document).ready(function() {

    var productos;
    var tipo_producto;

    if ($("#cpo_producto").is(':visible')) {
        $.ajax({
            url: base_url + 'producto/get_vproducto',
            type: 'post',
            success: function(data) {
                productos = $.parseJSON(data);
//                console.log(productos);
            }
        });
        $.ajax({
            url: base_url + 'producto/get_tipo_producto',
            type: 'post',
            success: function(data) {
                tipo_producto = $.parseJSON(data);
//                console.log(tipo_producto);
            }
        });
    }

    var table_producto_view = $('#table_producto').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "producto/paginate/prod",
        "sServerMethod": "POST",
        "bPaginate": true,
        "bFilter": true,
        "bSort": false,
        "displayLength": 10
    });

    $("#form_prod").submit(function() {

        var nombre = $("#nomb_prod").val();

        $.each(productos, function(key, row) {
            if (row[1] == nombre) {
                $('#nomb_prod').parent().addClass('has-error');
                $('#nomb_prod').parent().find('label').html('<i class="fa fa-warning"></i> Nombre: * Ya existe un producto con este nombre');
                $('#registrar_prod').prop('disabled', true);
                return false;
            }
        });

    });

    $("#nomb_prod").keyup(function() {

        var nombre = $(this).val();
        var sw = true;

        $('#nomb_prod').parent().removeClass('has-error');
        $('#nomb_prod').parent().removeClass('has-success');
        $('#nomb_prod').parent().find('label').html('Nombre: *');

        $.each(productos, function(key, row) {
            if (row[1] == nombre) {
                $('#nomb_prod').parent().addClass('has-error');
                $('#nomb_prod').parent().find('label').html('<i class="fa fa-warning"></i> Nombre: * Ya existe un producto con este nombre');
                $('#registrar_prod').prop('disabled', true);
                sw = false;
            }
        });

        if (sw && nombre.length > 0) {
            $('#nomb_prod').parent().addClass('has-success');
            $('#nomb_prod').parent().find('label').html('Nombre: * ¡Correcto!');
            $('#registrar_prod').prop('disabled', false);
        }
    });

    // Editar producto

    $(document).on('click', '.editar_prod', function() {

        var tr = $(this).parent().parent();

        var codigo = tr.find("td").eq(0).html();

        $("#codigo_prod_e").val(codigo);
        $("#nomb_prod_e").val(productos[codigo][1]);
        var observa = "";
        if (productos[codigo][3] != null) {
            observa = productos[codigo][3];
        }
        $("#observa_prod_e").val(observa);
        var codi_tpro = productos[codigo][4];
        $("#tipo_prod_e option[value='" + codi_tpro + "']").prop("selected", true);

        $('#nomb_prod_e').parent().removeClass('has-error');
        $('#nomb_prod_e').parent().removeClass('has-success');
        $('#nomb_prod_e').parent().find('label').html('Nombre: *');
        $('#editar_prod').prop('disabled', false);

        // REGISTRO ACTUAL
        $("#nomb_prod_h").val(productos[codigo][1]);
        $("#codi_tpro_h").val(productos[codigo][4]);
        $("#obsv_prod_h").val(productos[codigo][3]);
        $("#esta_prod_h").val(productos[codigo][5]);

        $("#ModalEditarProducto").modal("show");

    });

    $("#form_prod_e").submit(function() {

        var nombre = $("#nomb_prod_e").val();
        var nombre_h = $("#nomb_prod_h").val();

        if (nombre != nombre_h) {
            $.each(productos, function(key, row) {
                if (row[1] == nombre) {
                    $('#nomb_prod_e').parent().addClass('has-error');
                    $('#nomb_prod_e').parent().find('label').html('<i class="fa fa-warning"></i> Nombre: * Ya existe un producto con este nombre');
                    $('#editar_prod').prop('disabled', true);
                    return false;
                }
            });
        } else {
            $('#nomb_prod_e').parent().removeClass('has-error');
            $('#nomb_prod_e').parent().removeClass('has-success');
            $('#nomb_prod_e').parent().find('label').html('Nombre: *');
        }
    });

    $("#nomb_prod_e").keyup(function() {

        var nombre = $(this).val();
        var nombre_h = $("#nomb_prod_h").val();
        var sw = true;

        if (nombre != nombre_h) {

            $('#nomb_prod_e').parent().removeClass('has-error');
            $('#nomb_prod_e').parent().removeClass('has-success');
            $('#nomb_prod_e').parent().find('label').html('Nombre: *');

            $.each(productos, function(key, row) {
                if (row[1] == nombre) {
                    $('#nomb_prod_e').parent().addClass('has-error');
                    $('#nomb_prod_e').parent().find('label').html('<i class="fa fa-warning"></i> Nombre: * Ya existe un producto con este nombre');
                    $('#editar_prod').prop('disabled', true);
                    sw = false;
                }
            });

            if (sw && nombre.length > 0) {
                $('#nomb_prod_e').parent().addClass('has-success');
                $('#nomb_prod_e').parent().find('label').html('Nombre: * ¡Correcto!');
                $('#editar_prod').prop('disabled', false);
            }
        } else {
            $('#nomb_prod_e').parent().removeClass('has-error');
            $('#nomb_prod_e').parent().removeClass('has-success');
            $('#nomb_prod_e').parent().find('label').html('Nombre: *');
        }
    });


    // Añadir tipo de producto

    var modal_tpro;

    $("#btnAddTPro").click(function() {
        $('#ModalNuevoProducto').modal('hide');
        $('#ModalNuevoTipoProd').modal('show');
        modal_tpro = $('#ModalNuevoProducto');
    });
    $("#btnAddTPro_e").click(function() {
        $('#ModalEditarProducto').modal('hide');
        $('#ModalNuevoTipoProd').modal('show');
        modal_tpro = $('#ModalEditarProducto');
    });

    $('#btnCancelarNTProd').click(function() {
        $('#ModalNuevoTipoProd').modal('hide');
        modal_tpro.modal('show');
    });

    $('#nomb_tpro').keyup(function() {
        var nombre = $(this).val();
        var sw = true;
        $(this).parent().removeClass('has-success');
        $(this).parent().removeClass('has-error');
        $(this).parent().find('label').html('Nombre: *');
        $('#registrar_tpro').prop('disabled', false);

        $.each(tipo_producto, function(key, row) {
            if (row[1] == nombre) {
                $('#nomb_tpro').parent().addClass('has-error');
                $('#nomb_tpro').parent().find('label').html('<i class="fa fa-warning"></i> Nombre: * Ya se encuentra registado, intente con otro nombre');
                $('#registrar_tpro').prop('disabled', true);
                sw = false;
                return false;
            }
        });

        if (sw && nombre.length > 0) {
            $('#nomb_tpro').parent().addClass('has-success');
            $('#nomb_tpro').parent().find('label').html('Nombre: * ¡Correcto!');
        }
    });
});