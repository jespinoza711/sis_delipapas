<!--REGISTRO-->

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="col-md-8" style="margin-left: 16%">
            <div id="panel-cie" class="panel panel-primary">
                
                <div class="panel-heading">
                    <h3 class="panel-title"> Registro Di&aacute;rio del Personal </h3>
                </div>
                
                <div class="panel-body">

                    <?php if ($this->session->userdata('info') != '') { ?>

                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <?= $this->session->userdata('info') ?>
                        </div>

                        <?php
                        $this->session->set_userdata('info', '');
                    } if ($this->session->userdata('error') != '') {
                        ?>

                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <?= $this->session->userdata('error') ?>
                        </div>

                        <?php
                        $this->session->set_userdata('error', '');
                    }
                    ?>
                    
                    <div class="row">
                        <div class="breadcrumb" style="text-align:center;margin:0%;border-radius:0px;background-color:#d9f6de">
                             <h3><?= $datetime ?></h3>
                        </div>
                    </div>

                    <?= form_open(base_url('regdiarioinsert'), $form_regdiario) ?>

                    <div class="modal-body">
                        <div class="form-group">
                            <label> Empleado: *</label>
                            <select id="codi_rol" class="form-control" name="codi_emp"><?php foreach ($empleado as $r) { ?> <option value="<?= $r->codi_emp ?>"><?= $r->nomb_emp . ' ' . $r->apel_emp ?></option> <?php } ?></select>
                        </div>
                        <div class="form-group"><label> Pago por kilo (S/ 0.00): (Planilla actual) </label><?= form_input($suel_pla, $planilla->suel_pla) ?></div>
                        <div class="form-group"><label> Productos Procesados (Kilos): * </label><?= form_input($cant_dpl, '0') ?></div>
                        <div class="form-group"><label> Subtotal a Pagar (S/ 0.00): * </label><?= form_input($suto_dpl, '0.00') ?></div>
                        <div class="form-group"><label> Descuentos Observados (S/ 0.00): </label><?= form_input($desc_dpl, '0') ?></div>
                        <div class="form-group"><label> Total a Pagar (S/ 0.00): *</label><?= form_input($tota_dpl, '0.00') ?></div>
                        <div class="form-group"><label> Observaci&oacute;n: (Max. 500 caracteres)</label><?= form_textarea($obsv_dpl) ?></div>
                        <p class="text-muted" style="font-style: italic;">(*) Los campos con asterisco son obligatorios.</p>
                    </div>
                    <div class="modal-footer">
                        <div style="float: right;">
                            <?= form_submit($registrodiario) ?>
                        </div>
                    </div>

                    <?= form_close() ?>

                </div>
            </div>
        </div>

    </div>
</div>

<!--REGISTRADOS HOY-->

<div class="row" id="cpo_registrodiario">
    <div class="col-lg-12 col-xs-12">
        <div class="col-md-12">
            <div id="panel-cie" class="panel panel-primary">
                
                <div class="panel-heading">
                    <h3 class="panel-title"> Pagos registrados hoy </h3>
                </div>

                <div class="panel-body">
                    <a href="<?= base_url('pagoempleado') ?>"><button type="button" class="btn btn-info"><i class="fa fa-eye"></i>&nbsp;&nbsp;Ver todos los registros</button></a>
                    <br><br>
                    <div class="table-responsive">
                        <table id="table_registrodiario" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Fecha de registro</th>
                                    <th>Usuario</th>
                                    <th>Empleado</th>
                                    <th>Pago. Kilo</th>
                                    <th>Prod. Proc. (Kls)</th>
                                    <th>Subtotal</th>
                                    <th>Descuento</th>
                                    <th>Total</th>
                                    <th>Observaci&oacute;n</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalEditarRegistroDiario" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content" style="border-color: #428bca; border-style: inset;">
            
            <?= form_open(base_url('regdiarioedit'), $form_regdiario_edit) ?>
            
            <div class="modal-header" style="
                 padding: 10px 15px;
                 border-bottom: 1px solid transparent;
                 border-top-left-radius: 3px;
                 border-top-right-radius: 3px;
                 color: #fff;
                 background-color: #428bca;
                 border-color: #428bca;
                 ">
                <h4 class="modal-title" id="myModalLabel">Editar registro diario</h4>
            </div>
            <div class="modal-body">
                <div class="form-group"><label> Codigo: </label><?= form_input($codi_dpl_e) ?></div>
                <div class="form-group"><label> Fecha: </label><?= form_input($fech_dpl_e) ?></div>
                <div class="form-group"><label> Empleado: </label><?= form_input($nomb_emp_e) ?></div>
                <div class="form-group"><label> Pago por kilo (S/ 0.00): (Planilla actual) </label><?= form_input($suel_pla_e, $planilla->suel_pla) ?></div>
                <div class="form-group"><label> Productos Procesados (Kilos): * </label><?= form_input($cant_dpl_e) ?></div>
                <div class="form-group"><label> Subtotal a Pagar (S/ 0.00): * </label><?= form_input($suto_dpl_e) ?></div>
                <div class="form-group"><label> Descuentos Observados (S/ 0.00): </label><?= form_input($desc_dpl_e) ?></div>
                <div class="form-group"><label> Total a Pagar (S/ 0.00): *</label><?= form_input($tota_dpl_e) ?></div>
                <div class="form-group"><label> Observaci&oacute;n: (Max. 500 caracteres)</label><?= form_textarea($obsv_dpl_e) ?></div>           
                <p class="text-muted" style="font-style: italic;">(*) Los campos con asterisco son obligatorios.</p>
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarEditarPlanilla" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <?= form_submit($registrodiario_edit) ?>
                </div>
            </div>
            
            <?= form_close() ?>
            
        </div>
    </div>
</div>