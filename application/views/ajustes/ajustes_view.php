<!--NEGOCIO-->

<div class="row" style="margin-top: 2%" id="cpo_negocio">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Datos de la empresa</h3>
            </div>
            <div class="panel-body">
                
                <?php if ($this->session->userdata('info_negocio') != ''){ ?>
                
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        <?= $this->session->userdata('info_negocio') ?>
                    </div>
                
                <?php $this->session->set_userdata('info_negocio', ''); } if ($this->session->userdata('error_negocio') != ''){ ?>
                
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        <?= $this->session->userdata('error_negocio') ?>
                    </div>
                
                <?php $this->session->set_userdata('error_negocio', ''); } ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4><i class="fa fa-fw fa-check"></i> Empresa </h4>
                            </div>
                            <div class="panel-body">
                                
                                <?= form_open(base_url('ajustes'), $form_negocio) ?>

                                    <div class="modal-body">
                                        <div class="form-group"><div class="input-group"><div class="input-group-addon"> RUC </div><?= form_input($ruc_neg, $negocio->ruc_neg) ?></div></div>
                                        <div class="form-group"><div class="input-group"><div class="input-group-addon"> Empresa: </div><?= form_input($nomb_neg, $negocio->nomb_neg) ?></div></div>
                                        <div class="form-group"><div class="input-group"><div class="input-group-addon"> Direcci&oacute;n: </div><?= form_input($dire_neg, $negocio->dire_neg) ?></div></div>
                                        <div class="form-group"><div class="input-group"><div class="input-group-addon"> Telef. 1: </div><?= form_input($tel1_neg, $negocio->tel1_neg) ?></div></div>
                                        <div class="form-group"><div class="input-group"><div class="input-group-addon"> Telef. 2: </div><?= form_input($tel2_neg, $negocio->tel2_neg) ?></div></div>
                                        <div class="form-group"><div class="input-group"><div class="input-group-addon"> Email: </div><?= form_input($email_neg, $negocio->email_neg) ?></div></div>
                                        <div class="form-group"><div class="input-group"><div class="input-group-addon"> Pag. Web: </div><?= form_input($web_neg, $negocio->web_neg) ?></div></div>
                                        <div class="form-group"><div class="input-group"><div class="input-group-addon"> Descripci&oacute;n: </div><?= form_textarea($desc_neg, $negocio->desc_neg) ?></div></div>
                                    </div>
                                    <div class="modal-footer">
                                        <div style="float: right;">
                                            <?= form_submit($registrar_negocio) ?>
                                        </div>
                                    </div>

                                <?= form_close() ?>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4><i class="fa fa-fw fa-check"></i> Parametros de Operaci&oacute;n </h4>
                            </div>
                            <div class="panel-body">
                                
                                <?= form_open(base_url('ajustes'), $form_igv) ?>
                        
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon"> I.G.V (%) </div>
                                            <?= form_input($igv_pla, $negocio->igv_pla) ?>
                                            <div class="input-group-addon"> <?= form_submit($registrar_igv) ?> </div>
                                        </div>
                                        
                                    </div>

                                <?= form_close() ?>
                                
                                <?= form_open(base_url('ajustes'), $form_num_orden) ?>
                        
                                    <div class="form-group">
                                        <label> Establecer numeraci&oacute;n inicial para Orden de Despacho: * </label>
                                        <div class="input-group">
                                            <div class="input-group-addon"> Ord. Despacho </div>
                                            <?= form_input($num_ini_orden, $negocio->num_ini_orden) ?>
                                            <div class="input-group-addon"> <?= form_submit($registrar_num_orden) ?> </div>
                                        </div>
                                        
                                    </div>

                                <?= form_close() ?>
                                
                                <?= form_open(base_url('ajustes'), $form_num_factura) ?>
                        
                                    <div class="form-group">
                                        <label> Establecer numeraci&oacute;n inicial para Factura: * </label>
                                        <div class="input-group">
                                            <div class="input-group-addon"> Factura </div>
                                            <?= form_input($num_ini_factura, $negocio->num_ini_factura) ?>
                                            <div class="input-group-addon"> <?= form_submit($registrar_num_factura) ?> </div>
                                        </div>
                                        
                                    </div>

                                <?= form_close() ?>
                                
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>

<!--PLANILLA-->

<div class="row" style="margin-top: 2%" id="cpo_planilla">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Planillas registradas</h3>
            </div>
            <div class="panel-body">
                
                <?php if ($this->session->userdata('info_planilla') != ''){ ?>
                
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        <?= $this->session->userdata('info_planilla') ?>
                    </div>
                
                <?php $this->session->set_userdata('info_planilla', ''); } if ($this->session->userdata('error_planilla') != ''){ ?>
                
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        <?= $this->session->userdata('error_planilla') ?>
                    </div>
                
                <?php $this->session->set_userdata('error_planilla', ''); } ?>
                
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalNuevaPlanilla"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Nueva Planilla</button>
                <br><br>
                <div class="table-responsive">
                    <table id="table_planilla" class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center;">C&oacute;digo</th>
                                <th style="text-align: center;">Fecha de registro</th>
                                <th style="text-align: center;">Suelo fijado (Pago. Kilo)</th>
                                <th style="text-align: center;">Obervaci&oacute;n</th>
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

<div class="modal fade" id="ModalNuevaPlanilla" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content" style="border-color: #428bca; border-style: inset;">
            
            <?= form_open(base_url('ajustes'), $form_planilla) ?>
            
            <div class="modal-header" style="
                 padding: 10px 15px;
                 border-bottom: 1px solid transparent;
                 border-top-left-radius: 3px;
                 border-top-right-radius: 3px;
                 color: #fff;
                 background-color: #428bca;
                 border-color: #428bca;
                 ">
                <h4 class="modal-title" id="myModalLabel">Nueva planilla</h4>
            </div>
            <div class="modal-body">
                <div class="form-group"><label>Fecha de registro: </label><?= form_input($fech_pla, $datetime) ?></div>
                <div class="form-group"><label>Sueldo (Pago. Kilo): *</label><?= form_input($suel_pla) ?></div>
                <div class="form-group"><label>Observación: </label><?= form_textarea($obsv_pla) ?></div>
                <p class="text-muted" style="font-style: italic;">(*) Los campos con asterisco son obligatorios.</p>
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarNuevaPlanilla" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <?= form_submit($registrar_planilla) ?>
                </div>
            </div>
            
            <?= form_close() ?>
            
        </div>
    </div>
</div>

<div class="modal fade" id="ModalEditarPlanilla" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content" style="border-color: #428bca; border-style: inset;">
            
            <?= form_open(base_url('ajustes'), $form_planilla_edit) ?>
            
            <div class="modal-header" style="
                 padding: 10px 15px;
                 border-bottom: 1px solid transparent;
                 border-top-left-radius: 3px;
                 border-top-right-radius: 3px;
                 color: #fff;
                 background-color: #428bca;
                 border-color: #428bca;
                 ">
                <h4 class="modal-title" id="myModalLabel">Editar planilla</h4>
            </div>
            <div class="modal-body">
                <div class="form-group"><label>Fecha de registro: </label><?= form_input($fech_pla_e) ?></div>
                <div class="form-group"><label>Código: </label><?= form_input($codi_pla_e) ?></div>
                <div class="form-group"><label>Sueldo (Pago. Kilo): *</label><?= form_input($suel_pla_e) ?></div>
                <div class="form-group"><label>Observación: </label><?= form_textarea($obsv_pla_e) ?></div>                
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarEditarPlanilla" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <?= form_submit($editar_planilla) ?>
                </div>
            </div>
            
            <?= form_close() ?>
            
        </div>
    </div>
</div>

<!--CONCEPTO-GASTO-->

<div class="row" style="margin-top: 2%" id="cpo_concepto">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Concepto de gasto registrados (Caja chica)</h3>
            </div>
            <div class="panel-body">
                
                <?php if ($this->session->userdata('info_concepto') != ''){ ?>
                
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        <?= $this->session->userdata('info_concepto') ?>
                    </div>
                
                <?php $this->session->set_userdata('info_concepto', ''); } if ($this->session->userdata('error_concepto') != ''){ ?>
                
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        <?= $this->session->userdata('error_concepto') ?>
                    </div>
                
                <?php $this->session->set_userdata('error_concepto', ''); } ?>
                
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalNuevoConcepto"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Nuevo Concepto de Gasto</button>
                <br><br>
                <div class="table-responsive">
                    <table id="table_concepto" class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center;">C&oacute;digo</th>
                                <th style="text-align: center;">Fecha de registro</th>
                                <th style="text-align: center;">Usuario que registro</th>
                                <th style="text-align: center;">Concepto</th>
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

<div class="modal fade" id="ModalNuevoConcepto" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content" style="border-color: #428bca; border-style: inset;">
            
            <?= form_open(base_url('ajustes'), $form_concepto) ?>
            
            <div class="modal-header" style="
                 padding: 10px 15px;
                 border-bottom: 1px solid transparent;
                 border-top-left-radius: 3px;
                 border-top-right-radius: 3px;
                 color: #fff;
                 background-color: #428bca;
                 border-color: #428bca;
                 ">
                <h4 class="modal-title" id="myModalLabel">Nuevo Concepto de Gasto</h4>
            </div>
            <div class="modal-body">
                <div class="form-group"><label>Fecha de registro: </label><?= form_input($fech_con, $datetime) ?></div>
                <div class="form-group"><label>Usuario que registrar&aacute; este concepto: </label><?= form_input($nomb_usu, $this->session->userdata('user_name')) ?></div>
                <div class="form-group"><label>Concepto: *</label><?= form_input($nomb_con) ?></div>
                <p class="text-muted" style="font-style: italic;">(*) Los campos con asterisco son obligatorios.</p>
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarNuevoConcepto" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <?= form_submit($registrar_concepto) ?>
                </div>
            </div>
            
            <?= form_close() ?>
            
        </div>
    </div>
</div>

<div class="modal fade" id="ModalEditarConcepto" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content" style="border-color: #428bca; border-style: inset;">
            
            <?= form_open(base_url('ajustes'), $form_concepto_edit) ?>
            
            <div class="modal-header" style="
                 padding: 10px 15px;
                 border-bottom: 1px solid transparent;
                 border-top-left-radius: 3px;
                 border-top-right-radius: 3px;
                 color: #fff;
                 background-color: #428bca;
                 border-color: #428bca;
                 ">
                <h4 class="modal-title" id="myModalLabel">Editar Concepto de Gasto</h4>
            </div>
            <div class="modal-body">
                <div class="form-group"><label>Fecha de registro: </label><?= form_input($fech_con_e) ?></div>
                <div class="form-group"><label>C&oacute;digo: </label><?= form_input($codi_con_e) ?></div>
                <div class="form-group"><label>Usuario que registr&oacute; este concepto: </label><?= form_input($nomb_usu_e, $this->session->userdata('user_name')) ?></div>
                <div class="form-group"><label>Concepto: *</label><?= form_input($nomb_con_e) ?></div>            
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarEditarConcepto" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <?= form_submit($editar_concepto) ?>
                </div>
            </div>
            
            <?= form_close() ?>
            
        </div>
    </div>
</div>