<div class="row" id="cpo_compra">
    <div class="col-lg-12 col-xs-12">
        <div class="col-md-11" style="margin-left: 4%">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Nueva Compra
                </div>
                <div class="panel-body">
                    
                <?php if ($this->session->userdata('info') != '') { ?>

                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        <?= $this->session->userdata('info') ?>
                    </div>

                <?php $this->session->set_userdata('info', ''); } if ($this->session->userdata('error') != '') { ?>

                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        <?= $this->session->userdata('error') ?>
                    </div>

                <?php $this->session->set_userdata('error', ''); } ?>
                    
                    <a href="<?= base_url('hiscompra') ?>"><button type="button" class="btn btn-info"><i class="fa fa-eye"></i>&nbsp;&nbsp;&nbsp;Ver todas las compras</button></a>
                    <br>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label> Buscar producto en inventario: </label>
                    </div>                    
                    <div class="table-responsive">
                        <table id="table_compra_inv" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Codigo</th>
                                    <th style="text-align: center;">Tipo</th>
                                    <th style="text-align: center;">Nombre</th>
                                    <th style="text-align: center;">Desc.</th>
                                    <th style="text-align: center;">Precio</th>
                                    <th style="text-align: center;">Stock</th>                                    
                                    <th style="text-align: center;">Cantidad</th>
                                    <th style="text-align: center;">Proveedor</th>
                                    <th style="text-align: center;">Carrito</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
  
                    <?= form_open(base_url('caja/registrar_compra'), $form_compra) ?>
                    
                    <section id="detalle_compra" class="content invoice" style="width: 100%;">
                        <div class="form-group" id="cpo_det_compra">
                            <label> Detalle de la compra: </label>
                            <table id="detalle_productos_compra" class="table table-bordered">
                                <thead>
                                    <tr style="background-color: #428bca; color: white;">
                                        <th style="text-align: center;"><span class="tooltip_ven" data-toggle="tooltip" data-placement="top" title="Código">Código</span></th>
                                        <th style="text-align: center;"><span class="tooltip_ven" data-toggle="tooltip" data-placement="top" title="Producto">Producto</span></th>
                                        <th style="text-align: center;"><span class="tooltip_ven" data-toggle="tooltip" data-placement="top" title="Proveedor">Proveedor</span></th>
                                        <th style="text-align: center;"><span class="tooltip_ven" data-toggle="tooltip" data-placement="top" title="Cantidad">Cantidad</span></th>
                                        <th style="text-align: center;"><span class="tooltip_ven" data-toggle="tooltip" data-placement="top" title="Valor unitario">Valor unitario</span></th>
                                        <th style="text-align: center;"><span class="tooltip_ven" data-toggle="tooltip" data-placement="top" title="Importe">Importe</span></th>
                                        <th style="text-align: center;"><span class="tooltip_ven" data-toggle="tooltip" data-placement="top" title="Opciones">Opciones</span></th>
                                        <th></th>
                                    </tr>
                                </thead>                                    
                                <tfoot>
                                    <tr>
                                        <td colspan="5" style="text-align: right;"><strong>Total:</strong></td>
                                        <td id="total_compra"></td>
                                        <td></td>
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
                    </section>
                    <div class="form-group"><label> Observaci&oacute;n de la compra: (Max. 500 caracteres) </label> <?= form_textarea($obsv_com) ?> </div>
                    <input id="tbl_compra_reg" name="tbl_compra" type="hidden">
                    <input id="total_compra_reg" name="total" type="hidden">
                    <input type="submit" value="Registrar compra" id="register_compra" name="registrar" class="btn btn-block btn-lg btn-primary" disabled>
                    
                    <?= form_close() ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>