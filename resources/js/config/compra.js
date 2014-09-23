$(document).ready(function() {

    function actualizar_tbl_compra() {

        var data = [];

        $("#detalle_productos_compra tbody tr").each(function() {

            var codigo = $(this).find("td").eq(0).html();
            var producto = $(this).find("td").eq(1).html();
            var cantidad = $(this).find("td").eq(2).html();
            var valor = $(this).find("td").eq(3).html().substring(4);
            var proveedor = $(this).find("td").eq(4).html();
            var importe = $(this).find("td").eq(5).html().substring(4);

            var row = [codigo, producto, cantidad, valor, proveedor, importe];
            data.push(row);
        });

        $('#tbl_compra_reg').val(JSON.stringify(data));
    }

    var productos;
    var submitted = false;

    $("#form_compra").submit(function() {
        submitted = true;
    });

    if ($("#cpo_compra").is(':visible')) {

        window.onbeforeunload = function(e) {
            if (!$('#detalle_productos_compra tbody tr td').is(":contains('Busque y agregue un producto')") && !submitted) {
                return 'Hay productos agregados en la tabla de compras. Al cerrar se perderán los cambios.';
            }
        };

        $('.tooltip_compra').tooltip();

//--- ADD PRODUCT

        $(document).on('click', '.agregar_prod_compra', function() {

            var codigo = $(this).parent().parent().find("td").eq(0).html();
            var producto = $(this).parent().parent().find("td").eq(2).html();
            var precio = $(this).parent().parent().find("td").eq(3).html();
            var cantidad = $(this).parent().parent().find("td").eq(6).find("input").val();
            var proveedor = $(this).parent().parent().find("td").eq(7).find("select").find("option").html();
            var sw = true;

            if ($('#detalle_productos_compra tbody tr td').is(":contains('Busque y agregue un producto')")) {
                $('#detalle_productos_compra tbody tr').remove();
            }

            $('#detalle_productos_compra tbody tr').each(function() {
                if (codigo == $(this).find("td").eq(0).html()) {
                    sw = false;

                    $.SmartMessageBox({
                        title: "<i class='fa fa-warning'></i>&nbsp;&nbsp;&nbsp;¡Advertencia!",
                        content: "Ya se ha agregado el producto " + producto + " al detalle de compras, ¿Qué deseas hacer?",
                        buttons: '[Cancelar][Actualizar][Añadir]'
                    }, function(ButtonPressed) {

                        if (ButtonPressed === "Actualizar") {

                            var cant_ant = $("#detalle_productos_compra tbody tr td:contains('" + codigo + "')").parent().find("td").eq(2).html();
                            $("#detalle_productos_compra tbody tr td:contains('" + codigo + "')").parent().remove();

                            var venta = (parseFloat(precio) * parseInt(cantidad)).toFixed(2);
                            var importe = (parseFloat(venta) + 0).toFixed(2);

                            $('#detalle_productos_compra tbody').append('<tr>' +
                                    '<td>' + codigo + '</td>' +
                                    '<td>' + producto + '</td>' +
                                    '<td>' + cantidad + '</td>' +
                                    '<td>S/. ' + precio + '</td>' +
                                    '<td>' + proveedor + '</td>' +
                                    '<td>S/. ' + importe + '</td>' +
                                    '<td><input type="button" class="tooltip_ven btn btn-danger btn-circle fa quitar_prod_compra" value="&#xf00d;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Quitar" style="width: 22px; height: 22px; line-height: 18px;"></td>' +
                                    '</tr>');

                            if ($('#total_compra').html() == "") {
                                $('#total_compra').html("S/. " + importe);
                                $('#total_compra_reg').val(importe);

                            } else {
                                var total = 0;
                                $("#detalle_productos_compra tbody tr").each(function() {
                                    if ($(this).find("td").eq(0).html() == codigo) {
                                        total += parseFloat(importe);
                                    } else {
                                        total += parseFloat($(this).find("td").eq(5).html().substring(4));
                                    }
                                });

                                $('#total_compra').html("S/. " + total.toFixed(2));
                                $('#total_compra_reg').val(total);

                            }

                            var cant_row = (parseInt(cant_ant) + parseInt(productos[codigo][6])) - parseInt(cantidad);
                            productos[codigo][6] = cant_row;

                            $('#register_compra').prop('disabled', false);
                            $("#detalle_prod_compra").slideUp("fast");
                            $("html,body").animate({scrollTop: $("#cpo_det_compra").eq(0).offset().top}, 1000);

                            $.smallBox({
                                title: "Producto actualizado",
                                content: "<i class='fa fa-table'></i> <i>El producto " + producto + " ha sido actualizado en la tabla de productos en compra.</i>",
                                color: "#659265",
                                iconSmall: "fa fa-check fa-2x fadeInRight animated",
                                timeout: 6000
                            });
                            actualizar_tbl_compra();
                        }

                        if (ButtonPressed === "Añadir") {

                            var fila = $("#detalle_productos_compra tbody tr td:contains('" + codigo + "')").parent();
                            var cant_act = parseInt(cantidad) + parseInt(fila.find("td").eq(2).html());
                            var venta = (parseFloat(precio) * parseInt(cant_act)).toFixed(2);
                            var importe = (parseFloat(venta) + 0).toFixed(2);

                            fila.find("td").eq(2).html(cant_act);
                            fila.find("td").eq(5).html("S/. " + importe);

                            if ($('#total_compra').html() == "") {
                                $('#total_compra').html("S/. " + importe);
                                $('#total_compra_reg').val(importe);

                            } else {
                                var total = 0;
                                $("#detalle_productos_compra tbody tr").each(function() {
                                    if ($(this).find("td").eq(0).html() == codigo) {
                                        total += parseFloat(importe);
                                    } else {
                                        total += parseFloat($(this).find("td").eq(5).html().substring(4));
                                    }
                                });

                                $('#total_compra').html("S/. " + total.toFixed(2));
                                $('#total_compra_reg').val(total);
                            }

                            productos[codigo][6] = parseInt(productos[codigo][6]) - parseInt(cantidad);

                            $('#register_compra').prop('disabled', false);
                            $("#detalle_prod_compra").slideUp("fast");
                            $("html,body").animate({scrollTop: $("#cpo_det_compra").eq(0).offset().top}, 1000);

                            $.smallBox({
                                title: "Producto añadido",
                                content: "<i class='fa fa-table'></i> <i>El producto " + producto + " ha sido añadido en la tabla de productos en compra.</i>",
                                color: "#659265",
                                iconSmall: "fa fa-check fa-2x fadeInRight animated",
                                timeout: 6000
                            });
                            actualizar_tbl_compra();
                        }
                    });

                    return false;
                }
            });

            /* ADD */

            if (sw) {
                var venta = (parseFloat(precio) * parseInt(cantidad)).toFixed(2);
                var importe = (parseFloat(venta) + 0).toFixed(2);

                $('#detalle_productos_compra tbody').append('<tr>' +
                        '<td>' + codigo + '</td>' +
                        '<td>' + producto + '</td>' +
                        '<td>' + cantidad + '</td>' +
                        '<td>S/. ' + precio + '</td>' +
                        '<td>' + proveedor + '</td>' +
                        '<td>S/. ' + importe + '</td>' +
                        '<td><input type="button" class="tooltip_ven btn btn-danger btn-circle fa quitar_prod_compra" value="&#xf00d;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Quitar"></td>' +
                        '</tr>');

                if ($('#total_compra').html() == "") {
                    $('#total_compra').html("S/. " + importe);
                    $('#total_compra_reg').val(importe);
                } else {

                    var total = 0;
                    $("#detalle_productos_compra tbody tr").each(function() {

                        if ($(this).find("td").eq(0).html() == codigo) {
                            total += parseFloat(importe);
                        } else {
                            total += parseFloat($(this).find("td").eq(5).html().substring(4));
                        }

                    });

                    $('#total_compra').html("S/. " + total.toFixed(2));
                    $('#total_compra_reg').val(total);
                }

                productos[codigo][6] = parseInt(productos[codigo][6]) - parseInt(cantidad);
                
                $('#register_compra').prop('disabled', false);
                $("#detalle_compra_ven").slideUp("fast");
                $("html,body").animate({scrollTop: $("#cpo_det_compra").eq(0).offset().top}, 1000);

                $.smallBox({
                    title: "Producto agregado",
                    content: "<i class='fa fa-table'></i> <i>El producto " + producto + " ha sido agregado a la tabla de productos en compra.</i>",
                    color: "#659265",
                    iconSmall: "fa fa-check fa-2x fadeInRight animated",
                    timeout: 6000
                });
                actualizar_tbl_compra();
            }
        });
        
        /* REMOVE */

        $(document).on('click', '.quitar_prod_compra', function() {

            var codigo = $(this).parent().parent().find("td").eq(0).html();
            var producto = $(this).parent().parent().find("td").eq(1).html();
            var cantidad = $(this).parent().parent().find("td").eq(2).html();
            var total = 0;
            
            $("#detalle_productos_compra tbody tr").each(function() {
                if ($(this).find("td").eq(0).html() != codigo) {
                    total += parseFloat($(this).find("td").eq(5).html().substring(4));
                }
            });

            productos[codigo][6] = parseInt(productos[codigo][6]) + parseInt(cantidad);

            $(this).parent().parent().remove();

            if (total != 0) {
                $('#total_compra').html("S/. " + total.toFixed(2));
                $('#total_compra_reg').val(total);
                
            } else {
                $('#total_compra').html("");
                $('#total_compra_reg').val("0");
                $('#detalle_productos_compra tbody').append('<tr>' +
                        '<td colspan="8">' +
                        '<div class="callout callout-danger">' +
                        '<p class="text-danger">Busque y agregue un producto</p>' +
                        '</div>' +
                        '</td>' +
                        '</tr>');
                $('#register_compra').prop('disabled', true);
            }

            $.smallBox({
                title: "Producto removido",
                content: "<i class='fa fa-table'></i> <i>El producto " + producto + " ha sido removido de la tabla de productos en compra.</i>",
                color: "#C46A69",
                iconSmall: "fa fa-times fa-2x fadeInRight animated",
                timeout: 6000
            });
            actualizar_tbl_compra();
        });
    }

});