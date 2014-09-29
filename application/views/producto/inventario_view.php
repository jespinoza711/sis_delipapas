<div class="row" id="cpo_inventario">
    <div class="col-lg-12 col-xs-12">
        <div class="col-md-12">
            <div id="panel-cie" class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Productos en inventario</h3>
                </div>
                <div class="panel-body">

                    <?php if ($this->session->userdata('info') != ''){ ?>

                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <?= $this->session->userdata('info') ?>
                        </div>

                    <?php $this->session->set_userdata('info', ''); } if ($this->session->userdata('error') != ''){ ?>

                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <?= $this->session->userdata('error') ?>
                        </div>

                    <?php $this->session->set_userdata('error', ''); } ?>
                    
                    <?php if($this->session->userdata('user_rol') == 1){ ?>
                    
                    <a href="<?= base_url('producto') ?>"><button type="button" class="btn btn-info"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Nuevo producto</button></a>
                    <br><br>
                    
                    <?php } ?>

                    <div class="table-responsive">
                        <table id="table_inventario" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">#</th>
                                    <th style="text-align: center;">Tipo</th>
                                    <th style="text-align: center;">Nombre</th>
                                    <th style="text-align: center;">Desc.</th>
                                    <th style="text-align: center;">Ult. Ingreso</th>
                                    <th style="text-align: center;">Ult. Salida</th>
                                    <th style="text-align: center;">Precio Uni.</th>
                                    <th style="text-align: center;">Stock Kilo</th>
                                    <th style="text-align: center;">Valor (S/.)</th>                                    
                                    <th style="text-align: center;">Estado</th>
                                    <th style="text-align: center;">Aciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalEditarInventarioProducto" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content" style="border-color: #428bca; border-style: inset;">
            
            <?= form_open(base_url('inventario'), $form_inventario) ?>
            
            <div class="modal-header" style="
                 padding: 10px 15px;
                 border-bottom: 1px solid transparent;
                 border-top-left-radius: 3px;
                 border-top-right-radius: 3px;
                 color: #fff;
                 background-color: #428bca;
                 border-color: #428bca;
                 ">
                <h4 class="modal-title" id="myModalLabel">Actualizar Stock / Precio del producto</h4>
            </div>
            <div class="modal-body">
                <div class="form-group"><label>C&oacute;digo: </label><?= form_input($codi_prod_e) ?></div>
                <div class="form-group"><label>Tipo de Producto: </label><?= form_input($nomb_tipo_e) ?></div>
                <div class="form-group"><label>Nombre del producto: </label><?= form_input($nomb_prod_e) ?></div>
                <div class="form-group"><label>Precio (S/ 0.00): *</label><?= form_input($prec_prod_e) ?></div>
                <div class="form-group"><label>Stock (Kilos): *</label><?= form_input($stoc_prod_e) ?></div>
                <p class="text-muted" style="font-style: italic;">(*) Los campos con asterisco son obligatorios.</p>
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarEditarProd" type="button" class="btn btn-default btn-lg   " data-dismiss="modal">Cancelar</button>
                    <?= form_submit($inventario_update) ?>
                </div>
            </div>

            <?= form_close() ?>
            
        </div>
    </div>
</div>