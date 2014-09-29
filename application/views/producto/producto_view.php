<div class="row" id="cpo_producto" style="margin-top: 2%">
    <div class="col-lg-12 col-xs-12">
        
        <div class="col-md-11" style="margin-left: 4%;">
            <div id="panel-producto" class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Mantenimiento</h3>
                </div>
                <div class="panel-body">
                    
                    <?php if ($this->session->userdata('info_prod') != ''){ ?>
                
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        <?= $this->session->userdata('info_prod') ?>
                    </div>
                
                    <?php $this->session->set_userdata('info_prod', ''); } if ($this->session->userdata('error_prod') != ''){ ?>

                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <?= $this->session->userdata('error_prod') ?>
                        </div>

                    <?php $this->session->set_userdata('error_prod', ''); } ?>
                    
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalNuevoProducto" <?= $disabled ?>><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Nuevo producto</button>
                    <br><br>
                    <div class="table-responsive">
                        <table id="table_producto" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">C&oacute;digo</th>
                                    <th style="text-align: center;">Nombre</th>  
                                    <th style="text-align: center;">Tipo</th>                                                                      
                                    <th style="text-align: center;">Descripci&oacute;n</th>
                                    <th style="text-align: center;">Estado</th>
                                    <th style="text-align: center;">Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<div class="modal fade" id="ModalNuevoProducto" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content" style="border-color: #428bca; border-style: inset;">
            
            <?= form_open(base_url('producto'), $form) ?>
            
            <div class="modal-header" style="
                 padding: 10px 15px;
                 border-bottom: 1px solid transparent;
                 border-top-left-radius: 3px;
                 border-top-right-radius: 3px;
                 color: #fff;
                 background-color: #428bca;
                 border-color: #428bca;
                 ">
                <h4 class="modal-title" id="myModalLabel">Nuevo producto</h4>
            </div>
            <div class="modal-body">
                <div class="form-group"><label>Tipo: * <button id="btnAddTPro" type="button" class="btn btn-sm btn-primary" style="padding: 0px 10px; margin-left: 4px;"  data-toggle="tooltip" data-placement="top" title="Añadir tipo de producto"><i class="fa fa-plus"></i></button></label>
                    <?= form_dropdown('tipo', $tipo, array(), 'id="tipo_prod" class="form-control input-lg"') ?>
                </div>
                <div class="form-group"><label>Nombre: *</label><?= form_input($nombre) ?></div>
                <div class="form-group"><label>Observación: </label><?= form_textarea($observa) ?></div>
                <p class="text-muted" style="font-style: italic;">(*) Los campos con asterisco son obligatorios.</p>
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarNuevoProd" type="button" class="btn btn-default btn-lg" data-dismiss="modal">Cancelar</button>
                    <?= form_submit($registrar) ?>
                </div>
            </div>
            
            <?= form_close() ?>
            
        </div>
    </div>
</div>

<div class="modal fade" id="ModalEditarProducto" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content" style="border-color: #428bca; border-style: inset;">
            
            <?= form_open(base_url('producto'), $form_e) ?>
            
            <div class="modal-header" style="
                 padding: 10px 15px;
                 border-bottom: 1px solid transparent;
                 border-top-left-radius: 3px;
                 border-top-right-radius: 3px;
                 color: #fff;
                 background-color: #428bca;
                 border-color: #428bca;
                 ">
                <h4 class="modal-title" id="myModalLabel">Editar producto</h4>
            </div>
            <div class="modal-body">
                <div class="form-group"><label>Código: *</label><?= form_input($codigo_e) ?></div>
                <div class="form-group"><label>Tipo: * <button id="btnAddTPro_e" type="button" class="btn btn-sm btn-primary" style="padding: 0px 10px; margin-left: 4px;"  data-toggle="tooltip" data-placement="top" title="Añadir tipo de producto"><i class="fa fa-plus"></i></button></label>
                    <?= form_dropdown('tipo', $tipo, array(), 'id="tipo_prod_e" class="form-control input-lg"') ?>
                </div>
                <div class="form-group"><label>Nombre: *</label><?= form_input($nombre_e) ?></div>
                <div class="form-group"><label>Observación: </label><?= form_textarea($observa_e) ?></div>
                <p class="text-muted" style="font-style: italic;">(*) Los campos con asterisco son obligatorios.</p>
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarEditarProd" type="button" class="btn btn-default btn-lg   " data-dismiss="modal">Cancelar</button>
                    <?= form_submit($editar) ?>
                </div>
            </div>
            <input type="hidden" id="nomb_prod_h" name="nombre_h">
            <input type="hidden" id="codi_tpro_h" name="tipo_h">
            <input type="hidden" id="obsv_prod_h" name="obsv_h">
            <input type="hidden" id="esta_prod_h" name="esta_h">
            <?= form_close() ?>
            
        </div>
    </div>
</div>

<div class="modal fade" id="ModalNuevoTipoProd" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%; margin-top: 15%;">
        <div class="modal-content" style="border-color: #ddd; border-style: inset;">
            <?= form_open(base_url() . 'producto', $form_tpro) ?>
            <div class="modal-header" style="
                 padding: 10px 15px;
                 border-bottom: 1px solid transparent;
                 border-top-left-radius: 3px;
                 border-top-right-radius: 3px;
                 color: #000;
                 background-color: #ddd;
                 border-color: #ddd;
                 ">
                <h4 class="modal-title" id="myModalLabel">Añadir tipo de producto</h4>
            </div>
            <div class="modal-body">
                <div class="form-group"><label>Nombre: *</label><?= form_input($nombre_tpro) ?></div>
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarNTProd" type="button" class="btn btn-default btn-lg" data-dismiss="modal">Cancelar</button>
                    <?= form_submit($registrar_tpro) ?>
                </div>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>