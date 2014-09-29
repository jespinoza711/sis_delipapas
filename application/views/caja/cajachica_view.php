<!--CAJA CHICA-->

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="col-md-11" style="margin-left: 4%">
            <div id="panel-cie" class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Registro de gastos de caja chica</h3>
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
                    
                    <div class="row">
                        <div class="breadcrumb" style="text-align:center;margin:0%;border-radius:0px;background-color:#d9f6de">
                             <h3><?= $datetime ?></h3>
                        </div>
                    </div>

                    <?= form_open(base_url('cajachicainsert'), $form_regcajachica) ?>

                    <div class="modal-body">

                        <div class="form-group"><label> # Caja: </label><?= form_input($codi_cac, $cajachica->codi_cac) ?></div>
                        <div class="form-group"><label> Usuario activo: </label><?= form_input($nomb_usu, $this->session->userdata('user_name')) ?></div>
                        <div class="form-group">
                            <label>Concepto de Gasto: * </label>
                            <select id="codi_rol" class="form-control" name="codi_con"><?php foreach ($concepto as $r) { ?> <option value="<?= $r->codi_con ?>"><?= $r->nomb_con ?></option> <?php } ?></select>
                        </div>
                        <div class="form-group"><label> Descripci&oacute;n del Gasto: (Max. 50 caracteres) * </label><?= form_input($nomb_gas) ?></div>
                        <div class="form-group"><label> Importe utilizado (S/ 0.00): * </label><?= form_input($impo_gas) ?></div>
                        <div class="form-group"><label> Observaci&oacute;n: (Max. 200 caracteres) </label><?= form_textarea($obsv_gas) ?></div>
                        <p class="text-muted" style="font-style: italic;">(*) Los campos con asterisco son obligatorios.</p>
                    </div>
                    <div class="modal-footer">
                        <div style="float: right;">
                            <?= form_submit($cajachica_insert) ?>
                        </div>
                    </div>

                    <?= form_close() ?>

                </div>
            </div>
        </div>
    </div>
</div>

<!--REGISTRADOS HOY-->

<div class="row" id="cpo_regcajachica">
    <div class="col-lg-12 col-xs-12">
        <div class="col-md-11" style="margin-left: 4%">
            <div id="panel-cie" class="panel panel-primary">
                
                <div class="panel-heading">
                    <h3 class="panel-title"> Gastos registrados hoy </h3>
                </div>

                <div class="panel-body">
                    <a href="<?= base_url('hiscajachica') ?>"><button type="button" class="btn btn-info"><i class="fa fa-eye"></i>&nbsp;&nbsp;Ver todos los registros</button></a>
                    <br><br>
                    <div class="table-responsive">
                        <table id="table_regcajachica" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>C&oacute;digo</th>
                                    <th>Fecha de registro</th>
                                    <th>Usuario</th>
                                    <th>Concepto</th>
                                    <th>Descripci&oacute;n</th>
                                    <th>Importe (S/.)</th>
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

<div class="modal fade" id="ModalEditarRegistroCajaChica" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content" style="border-color: #428bca; border-style: inset;">
            
            <?= form_open(base_url('cajachicaedit'), $form_regcajachica_edit) ?>
            
            <div class="modal-header" style="
                 padding: 10px 15px;
                 border-bottom: 1px solid transparent;
                 border-top-left-radius: 3px;
                 border-top-right-radius: 3px;
                 color: #fff;
                 background-color: #428bca;
                 border-color: #428bca;
                 ">
                <h4 class="modal-title" id="myModalLabel">Editar gasto</h4>
            </div>
            <div class="modal-body">

                <div class="form-group"><label> # Caja: </label><?= form_input($codi_cac_e, $cajachica->codi_cac) ?></div>
                <div class="form-group"><label> C&oacute;digo: </label><?= form_input($codi_gas_e) ?></div>
                <div class="form-group"><label> Usuario activo: </label><?= form_input($nomb_usu_e, $this->session->userdata('user_name')) ?></div>
                <div class="form-group">
                    <label>Concepto de Gasto: * </label>
                    <select id="codi_rol" class="form-control" name="codi_con_e">
                        <?php foreach ($concepto as $r) { ?> <option value="<?= $r->codi_con ?>"><?= $r->nomb_con ?></option> <?php } ?>
                    </select>
                </div>
                <div class="form-group"><label> Descripci&oacute;n del Gasto: (Max. 50 caracteres) * </label><?= form_input($nomb_gas_e) ?></div>
                <div class="form-group"><label> Importe utilizado (S/ 0.00): * </label><?= form_input($impo_gas_e) ?></div>
                <div class="form-group"><label> Observaci&oacute;n: (Max. 200 caracteres) </label><?= form_textarea($obsv_gas_e) ?></div>
                <p class="text-muted" style="font-style: italic;">(*) Los campos con asterisco son obligatorios.</p>
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarEditarPlanilla" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <?= form_submit($cajachica_edit) ?>
                </div>
            </div>
            
            <?= form_close() ?>
            
        </div>
    </div>
</div>