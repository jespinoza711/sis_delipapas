$(document).ready(function() {

    function actualizar_tbl_venta() {

        var data = [];

        $("#detalle_productos_ven tbody tr").each(function() {

            var codigo = $(this).find("td").eq(0).html();
            var descripcion = $(this).find("td").eq(1).html();
            var cantidad = $(this).find("td").eq(2).html();
            var precio = $(this).find("td").eq(3).html().substring(4);
            var costo = $(this).find("td").eq(4).html().substring(4);
            var igv = $(this).find("td").eq(5).html().substring(4);
            var importe = $(this).find("td").eq(6).html().substring(4);

            var row = [codigo, descripcion, cantidad, precio, costo, igv, importe];
            data.push(row);
        });

        $('#tbl_venta_reg').val(JSON.stringify(data));
    }

    var productos;
    var nombre_prod_his;

    var submitted = false;

    $("#form_ven").submit(function() {
        submitted = true;
    });

    if ($("#cpo_ventas").is(':visible')) {

        window.onbeforeunload = function(e) {
            if (!$('#detalle_productos_ven tbody tr td').is(":contains('Busque y agregue un producto')") && !submitted) {
                return 'Hay productos agregados en la tabla de ventas. Al cerrar se perderán los cambios...';
            }
        };

        $.ajax({
            url: base_url + 'producto/get_vproducto',
            type: 'post',
            success: function(data) {
                productos = $.parseJSON(data);
//                console.log(productos);
            }
        });


        $.ajax({
            url: base_url + 'caja/get_producto_autocomplete',
            type: 'post',
            success: function(data) {
                var productos_desc = $.parseJSON(data);
                $("#producto_ven").autocomplete({
                    source: productos_desc,
                    select: function(event, ui) {

                        if (ui.item) {

                            var nombre_prod = ui.item.label;

                            $.each(productos, function(key, row) {
                                if (row[1] == nombre_prod) {
                                    nombre_prod_his = nombre_prod;
                                    $('#codi_prod_ven').html(row[0]);
                                    $('#nomb_prod_ven').html(nombre_prod);
                                    $('#tipo_prod_ven').html(row[2]);
                                    $('#stock_prod_ven').html(row[7]);
                                    $('#preci_prod_ven').html("S/. " + row[6]);
                                    $('#fesi_prod_ven').html(row[8]);
                                    $('#fesa_prod_ven').html(row[9]);
                                    $('#obsv_prod_ven').html(row[3]);

                                    $('#cant_pro_ven').attr('max', row[7]);
                                    $('#cant_pro_ven').val('1');
                                    $('#igv_pro_ven').val($('#igv_pro_ven_neg').val());

                                    if (parseInt(row[7]) == 0) {
                                        $("#error_stock_ven").css('display', 'inherit');
                                        $('#cant_pro_ven').prop('disabled', true);
                                        $('#sw_igv_ven').prop('disabled', true);
                                        $('#agregar_pro_ven').prop('disabled', true);
                                    } else {
                                        $("#error_stock_ven").css('display', 'none');
                                        $('#cant_pro_ven').prop('disabled', false);
                                        $('#sw_igv_ven').prop('disabled', false);
                                        $('#agregar_pro_ven').prop('disabled', false);
                                    }

                                    $("#detalle_prod_ven").slideDown();
                                }
                            });

                        }
                    },
                    open: function() {
                        $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
                    },
                    close: function() {
                        $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
                    }
                });
            }
        });

        $('.tooltip_ven').tooltip();

        $("#producto_ven").keyup(function(event) {
            if ($(this).val() != nombre_prod_his) {
                nombre_prod_his = "";
                $("#detalle_prod_ven").slideUp("fast");
            }
        });

        $('#agregar_pro_ven').click(function() {

            if ($('#detalle_productos_ven tbody tr td').is(":contains('Busque y agregue un producto')")) {
                $('#detalle_productos_ven tbody tr').remove();
            }

            var codigo = $('#codi_prod_ven').html();
            var descripcion = $('#nomb_prod_ven').html();
            var precio = $('#preci_prod_ven').html();
            var cantidad = $('#cant_pro_ven').val();

            var sw = true;
            $('#detalle_productos_ven tbody tr').each(function() {
                if (codigo == $(this).find("td").eq(0).html()) {
                    sw = false;

                    $.SmartMessageBox({
                        title: "<i class='fa fa-warning'></i>&nbsp;&nbsp;&nbsp;¡Advertencia!",
                        content: "Ya se ha agregado el producto " + descripcion + " al detalle de ventas, ¿Qué deseas hacer?",
                        buttons: '[Cancelar][Actualizar][Añadir]'
                    }, function(ButtonPressed) {
                        if (ButtonPressed === "Actualizar") {

                            var cant_ant = $("#detalle_productos_ven tbody tr td:contains('" + codigo + "')").parent().find("td").eq(2).html();
                            
                            $("#detalle_productos_ven tbody tr").each(function (){
                                if ($(this).find('td').eq(0).html() == codigo){
                                    $(this).remove();
                                    return false;
                                }
                            });
                            
                            var venta = (parseFloat(precio.substring(4)) * parseInt(cantidad)).toFixed(2);
                            var igv = (parseFloat(venta) * (parseFloat($('#igv_pro_ven').val()) / 100)).toFixed(2);
                            var importe = (parseFloat(venta) + parseFloat(igv)).toFixed(2);

                            $('#detalle_productos_ven tbody').append('<tr>' +
                                    '<td>' + codigo + '</td>' +
                                    '<td>' + descripcion + '</td>' +
                                    '<td>' + cantidad + '</td>' +
                                    '<td>' + precio + '</td>' +
                                    '<td>S/. ' + venta + '</td>' +
                                    '<td>S/. ' + igv + '</td>' +
                                    '<td>S/. ' + importe + '</td>' +
                                    '<td><input type="button" class="tooltip_ven btn btn-danger btn-circle fa quitar_prod_ven" value="&#xf00d;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Quitar"></td>' +
                                    '</tr>');

                            if ($('#total_ven').html() == "") {
                                $('#total_ven').html("S/. " + importe);
                                $('#total_ven_reg').val(importe);
                            } else {

                                var total = 0;
                                $("#detalle_productos_ven tbody tr").each(function() {

                                    if ($(this).find("td").eq(0).html() == codigo) {
                                        total += parseFloat(importe);
                                    } else {
                                        total += parseFloat($(this).find("td").eq(6).html().substring(4));
                                    }

                                });

                                $('#total_ven').html("S/. " + total.toFixed(2));
                                $('#total_ven_reg').val(total);

                            }

                            var cant_row = (parseInt(cant_ant) + parseInt(productos[codigo][7])) - parseInt(cantidad);
                            productos[codigo][7] = cant_row;

                            $('#register_ven').prop('disabled', false);
                            $('#sw_igv_ven').find("input").attr('checked', 'true');

                            $("#detalle_prod_ven").slideUp("fast");
                            $("#producto_ven").val("");
                            $("#producto_ven").focus();

                            $("html,body").animate({scrollTop: $("#cpo_det_ven").eq(0).offset().top}, 1000);

                            $.smallBox({
                                title: "Producto actualizado",
                                content: "<i class='fa fa-table'></i> <i>El producto " + descripcion + " ha sido actualizado en la tabla de productos en venta...</i>",
                                color: "#659265",
                                iconSmall: "fa fa-check fa-2x fadeInRight animated",
                                timeout: 6000
                            });
                            actualizar_tbl_venta();
                        }
                        if (ButtonPressed === "Añadir") {

                            var fila;
                            $("#detalle_productos_ven tbody tr").each(function (){
                                if ($(this).find('td').eq(0).html() == codigo){
                                    fila = $(this);
                                    return false;
                                }
                            });
                            
                            var cant_act = parseInt(cantidad) + parseInt(fila.find("td").eq(2).html());
                            var venta = (parseFloat(precio.substring(4)) * parseInt(cant_act)).toFixed(2);
                            var igv = (parseFloat(venta) * (parseFloat($('#igv_pro_ven').val()) / 100)).toFixed(2);
                            var importe = (parseFloat(venta) + parseFloat(igv)).toFixed(2);

                            fila.find("td").eq(2).html(cant_act);
                            fila.find("td").eq(4).html("S/. " + venta);
                            fila.find("td").eq(5).html("S/. " + igv);
                            fila.find("td").eq(6).html("S/. " + importe);

                            if ($('#total_ven').html() == "") {
                                $('#total_ven').html("S/. " + importe);
                                $('#total_ven_reg').val(importe);
                            } else {

                                var total = 0;
                                $("#detalle_productos_ven tbody tr").each(function() {

                                    if ($(this).find("td").eq(0).html() == codigo) {
                                        total += parseFloat(importe);
                                    } else {
                                        total += parseFloat($(this).find("td").eq(6).html().substring(4));
                                    }

                                });

                                $('#total_ven').html("S/. " + total.toFixed(2));
                                $('#total_ven_reg').val(total);
                            }

                            productos[codigo][7] = parseInt(productos[codigo][7]) - parseInt(cantidad);
                            $('#register_ven').prop('disabled', false);
                            $('#sw_igv_ven').find("input").attr('checked', 'true');

                            $("#detalle_prod_ven").slideUp("fast");
                            $("#producto_ven").val("");
                            $("#producto_ven").focus();

                            $("html,body").animate({scrollTop: $("#cpo_det_ven").eq(0).offset().top}, 1000);

                            $.smallBox({
                                title: "Producto añadido",
                                content: "<i class='fa fa-table'></i> <i>El producto " + descripcion + " ha sido añadido en la tabla de productos en venta...</i>",
                                color: "#659265",
                                iconSmall: "fa fa-check fa-2x fadeInRight animated",
                                timeout: 6000
                            });
                            actualizar_tbl_venta();
                        }
                    }
                    );

                    return false;
                }
            });

            if (sw) {
                var venta = (parseFloat(precio.substring(4)) * parseInt(cantidad)).toFixed(2);
                var igv = (parseFloat(venta) * (parseFloat($('#igv_pro_ven').val()) / 100)).toFixed(2);
                var importe = (parseFloat(venta) + parseFloat(igv)).toFixed(2);

                $('#detalle_productos_ven tbody').append('<tr>' +
                        '<td>' + codigo + '</td>' +
                        '<td>' + descripcion + '</td>' +
                        '<td>' + cantidad + '</td>' +
                        '<td>' + precio + '</td>' +
                        '<td>S/. ' + venta + '</td>' +
                        '<td>S/. ' + igv + '</td>' +
                        '<td>S/. ' + importe + '</td>' +
                        '<td><input type="button" class="tooltip_ven btn btn-danger btn-circle fa quitar_prod_ven" value="&#xf00d;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Quitar"></td>' +
                        '</tr>');

                if ($('#total_ven').html() == "") {
                    $('#total_ven').html("S/. " + importe);
                    $('#total_ven_reg').val(importe);
                } else {

                    var total = 0;
                    $("#detalle_productos_ven tbody tr").each(function() {

                        if ($(this).find("td").eq(0).html() == codigo) {
                            total += parseFloat(importe);
                        } else {
                            total += parseFloat($(this).find("td").eq(6).html().substring(4));
                        }

                    });

                    $('#total_ven').html("S/. " + total.toFixed(2));
                    $('#total_ven_reg').val(total);
                }

                productos[codigo][7] = parseInt(productos[codigo][7]) - parseInt(cantidad);
                $('#register_ven').prop('disabled', false);
                $('#sw_igv_ven').find("input").attr('checked', 'true');

                $("#detalle_prod_ven").slideUp("fast");
                $("#producto_ven").val("");
                $("#producto_ven").focus();

                $("html,body").animate({scrollTop: $("#cpo_det_ven").eq(0).offset().top}, 1000);

                $.smallBox({
                    title: "Producto agregado",
                    content: "<i class='fa fa-table'></i> <i>El producto " + descripcion + " ha sido agregado a la tabla de productos en venta...</i>",
                    color: "#659265",
                    iconSmall: "fa fa-check fa-2x fadeInRight animated",
                    timeout: 6000
                });
                actualizar_tbl_venta();
            }
        });

        $('#sw_igv_ven').click(function() {
            var input = $(this).find("input");

            if (input.attr('checked') == "checked") {
                input.removeAttr('checked');
                $('#igv_pro_ven').val("0");
            } else {
                input.attr('checked', 'true');
                $('#igv_pro_ven').val($('#igv_pro_ven_neg').val());
            }

        });

        $(document).on('click', '.quitar_prod_ven', function() {

            var codigo = $(this).parent().parent().find("td").eq(0).html();
            var descripcion = $(this).parent().parent().find("td").eq(1).html();
            var cantidad = $(this).parent().parent().find("td").eq(2).html();

            var total = 0;
            $("#detalle_productos_ven tbody tr").each(function() {
                if ($(this).find("td").eq(0).html() != codigo) {
                    total += parseFloat($(this).find("td").eq(6).html().substring(4));
                }
            });

            productos[codigo][7] = parseInt(productos[codigo][7]) + parseInt(cantidad);

            $(this).parent().parent().remove();

            if (total != 0) {
                $('#total_ven').html("S/. " + total.toFixed(2));
                $('#total_ven_reg').val(total);
                actualizar_tbl_compra();
                
            } else {
                $('#total_ven').html("");
                $('#total_ven_reg').val("0");
                $('#detalle_productos_ven tbody').append('<tr>' +
                        '<td colspan="8">' +
                        '<div class="callout callout-danger">' +
                        '<p class="text-danger">Busque y agregue un producto</p>' +
                        '</div>' +
                        '</td>' +
                        '</tr>');
                $('#register_ven').prop('disabled', true);
            }

            $.smallBox({
                title: "Producto removido",
                content: "<i class='fa fa-table'></i> <i>El producto " + descripcion + " ha sido removido de la tabla de productos en venta...</i>",
                color: "#C46A69",
                iconSmall: "fa fa-times fa-2x fadeInRight animated",
                timeout: 6000
            });
        });
    }
    
    /* HISTORIAL VENTA */
    
    if ($("#cpo_hisventa").is(':visible')) {

        $('#table_hisventa').DataTable({
            "iDisplayLength": 30,
            "aLengthMenu": [30, 50, 100],
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": base_url + "caja/paginate_historial_venta",
            "sServerMethod": "POST",
            "bPaginate": true,
            "bFilter": true,
            "bSort": false,
            "displayLength": 10
        });        
    }
    
    /* HISTORIAL VENTA DETALLE */
    
    if ($("#cpo_hisventadet").is(':visible')) {
        
        var codi_ven = $('#codi_ven_d').val();

        $('#table_hisventadet').DataTable({
            "iDisplayLength": 30,
            "aLengthMenu": [30, 50, 100],
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": base_url + "caja/paginate_historial_venta_det/" + codi_ven,
            "sServerMethod": "POST",
            "bPaginate": true,
            "bFilter": true,
            "bSort": false,
            "displayLength": 10
        });        
    }

});