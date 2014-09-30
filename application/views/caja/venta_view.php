<div class="row" id="cpo_ventas">
    <div class="col-lg-12 col-xs-12">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Nueva Venta
                </div>
                <div class="panel-body">
                    
                    <?php if ($this->session->userdata('info_ven') != '') { ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <?= $this->session->userdata('info_ven') ?>
                        </div>
                        <?php
                        $this->session->set_userdata('info_ven', '');
                    } if ($this->session->userdata('error_ven') != '') {
                        ?>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <?= $this->session->userdata('error_ven') ?>
                        </div>
                        <?php
                        $this->session->set_userdata('error_ven', '');
                    }
                    ?>

                    <a href="<?= base_url('hisventa') ?>"><button type="button" class="btn btn-info"><i class="fa fa-eye"></i>&nbsp;&nbsp;&nbsp;Ver todas las ventas</button></a>
                    <br>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>Buscar producto: </label>
                        <input type="text" id="producto_ven" class="form-control input-lg" placeholder="Escriba el nombre del producto y seleccione...">
                    </div>
                    <section id="detalle_prod_ven" class="content invoice" style="display: none; width: 100%;">

                        <div class="row">
                            <div class="col-xs-12">
                                <h2 class="page-header">
                                    <i class="fa fa-bars"></i> Información del producto
                                </h2>
                            </div>
                        </div>

                        <div class="row invoice-info">
                            <table class="table table-condensed">
                                <tbody>
                                    <tr>
                                        <td style="vertical-align: middle;"><strong>Código:</strong></td>
                                        <td id="codi_prod_ven" colspan="3" style="vertical-align: middle;"></td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: middle;"><strong>Nombre:</strong></td>
                                        <td id="nomb_prod_ven" style="vertical-align: middle;"></td>
                                        <td style="vertical-align: middle;"><strong>Tipo:</strong></td>
                                        <td id="tipo_prod_ven" style="vertical-align: middle;"></td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: middle;"><strong>Stock:</strong></td>
                                        <td id="stock_prod_ven" style="vertical-align: middle;"></td>
                                        <td style="vertical-align: middle;"><strong>Último ingreso:</strong></td>
                                        <td id="fesi_prod_ven" style="vertical-align: middle;"></td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: middle;"><strong>Precio unitario:</strong></td>
                                        <td id="preci_prod_ven" style="vertical-align: middle;"></td>
                                        <td style="vertical-align: middle;"><strong>Última salida:</strong></td>
                                        <td id="fesa_prod_ven" style="vertical-align: middle;"></td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: middle;"><strong>Observación:</strong></td>
                                        <td colspan="3" id="obsv_prod_ven" style="vertical-align: middle;"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="form-group">
                                <div class="col-xs-3">
                                    <label>Cantidad: </label>
                                    <input id="cant_pro_ven" type="number" min="1" class="form-control" value="1">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>I.G.V.: </label>
                                <div class="input-group" style="width: 20%;">
                                    <input id="igv_pro_ven" value="<?= $igv ?>" type="number" class="form-control" readonly="true">
                                    <input id="igv_pro_ven_neg" value="<?= $igv ?>" type="hidden">
                                    <span class="input-group-addon">%</span>
                                </div>
                            </div>
                            <div class="checkbox">
                                <label class="" id="sw_igv_ven">
                                    <input type="checkbox" checked="true"> Operación afecta al IGV
                                </label>
                            </div>
                            <div class="callout callout-danger" id="error_stock_ven" style="display: none;">
                                <p class="text-danger">No hay stock disponible hasta el momento.</p>
                            </div>
                            <button id="agregar_pro_ven" class="btn btn-block btn-lg btn-primary">Agregar producto</button>
                        </div>
                    </section>
                    <?= form_open(base_url() . 'caja/registrar_venta', $form) ?>
                    <section id="detalle_ven" class="content invoice" style="width: 100%;">
                        <div class="row">
                            <div class="col-xs-12">
                                <h2 class="page-header">
                                    <i class="fa fa-barcode"></i> Venta
                                </h2>
                            </div>
                        </div>

                        <div class="form-group"><label>Número de caja:</label>
                            <?= form_dropdown('caja', $caja, array(), 'id="caja_ven" class="form-control input-lg"') ?>
                        </div>
                        <div class="form-group"><label>Cliente:</label>
                            <?= form_dropdown('cliente', $cliente, array(), 'id="cliente_ven" class="form-control input-lg"') ?>
                        </div>
                        <div class="form-group" id="cpo_det_ven">
                            <label>Detalle de productos:</label>
                            <table id="detalle_productos_ven" class="table table-bordered">
                                <thead>
                                    <tr style="background-color: #428bca; color: white;">
                                        <th style="text-align: center;"><span class="tooltip_ven" data-toggle="tooltip" data-placement="top" title="Código">Código</span></th>
                                        <th style="text-align: center;"><span class="tooltip_ven" data-toggle="tooltip" data-placement="top" title="Descripción">Descripción</span></th>
                                        <th style="text-align: center;"><span class="tooltip_ven" data-toggle="tooltip" data-placement="top" title="Cantidad">Cantidad</span></th>
                                        <th style="text-align: center;"><span class="tooltip_ven" data-toggle="tooltip" data-placement="top" title="Valor unitario">Valor unitario</span></th>
                                        <th style="text-align: center;"><span class="tooltip_ven" data-toggle="tooltip" data-placement="top" title="Valor de venta">Valor de venta</span></th>
                                        <th style="text-align: center;"><span class="tooltip_ven" data-toggle="tooltip" data-placement="top" title="Impuesto general a la venta">IGV</span></th>
                                        <th style="text-align: center;"><span class="tooltip_ven" data-toggle="tooltip" data-placement="top" title="Importe">Importe</span></th>
                                        <th></th>
                                    </tr>
                                </thead>                                    
                                <tfoot>
                                    <tr>
                                        <td colspan="6" style="text-align: right;"><strong>Total:</strong></td>
                                        <td id="total_ven"></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <tr>
                                        <td colspan="8">
                                            <div class="callout callout-danger">
                                                <p class="text-danger">Busque y agregue un producto</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group"><label>Comprobante:</label>
                            <?= form_dropdown('comprobante', $comprobante, array(), 'id="comprobante_ven" class="form-control input-lg"') ?>
                        </div>
                    </section>
                    <input id="tbl_venta_reg" name="tbl_venta" type="hidden">
                    <input id="total_ven_reg" name="total" type="hidden">
                    <input type="submit" value="Registrar" id="register_ven" name="registrar" class="btn btn-block btn-lg btn-primary" disabled>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>