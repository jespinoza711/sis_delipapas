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
                
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalNuevaPlanilla">Nueva Planilla</button>
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
                
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalNuevoConcepto">Nuevo Concepto de Gasto</button>
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
                <div class="form-group"><label>Usuario que registr&oacute;: </label><?= form_input($nomb_usu) ?></div>
                <div class="form-group"><label>Concepto: *</label><?= form_textarea($nobm_con) ?></div>
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
                <div class="form-group"><label>Código: </label><?= form_input($codi_con_e) ?></div>
                <div class="form-group"><label>Usuario que registr&oacute;: </label><?= form_input($nomb_usu_e) ?></div>
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