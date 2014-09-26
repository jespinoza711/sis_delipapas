<div class="row" id="cpo_registrodiario">
    <div class="col-lg-12 col-xs-12">
        <div class="col-md-10 col-md-offset-1">
            <div id="panel-cie" class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Caja chica</h3>
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

                    <?= form_open(base_url('regcajachica'), $form_regcajachica) ?>

                    <div class="modal-body">

                        <div class="form-group"><label> # Caja: * </label><?= form_input($codi_cac, $cajachica->codi_cac) ?></div>
                        <div class="form-group"><label> Usuario: * </label><?= form_input($codi_usu, $this->session->userdata('user_name')) ?></div>
                        <div class="form-group">
                            <label>Concepto: *</label>
                            <select id="codi_rol" class="form-control" name="codi_con"><?php foreach ($concepto as $r) { ?> <option value="<?= $r->codi_con ?>"><?= $r->nomb_con ?></option> <?php } ?></select>
                        </div>
                        <div class="form-group"><label> Descripci&oacute;n: * </label><?= form_input($nomb_gas) ?></div>
                        <div class="form-group"><label> Importe: * </label><?= form_input($impo_gas) ?></div>
                        <div class="form-group"><label> Observaci&oacute;n: * </label><?= form_textarea($obsv_gas) ?></div>

                    </div>
                    <div class="modal-footer">
                        <div style="float: right;">
                            <button id="btnCancelarNuevoUsu" type="button" class="btn btn-default" data-dismiss="modal">limpiar</button>
                            <?= form_submit($registrar) ?>
                        </div>
                    </div>

                    <?= form_close() ?>

                </div>
            </div>
        </div>

    </div>
</div>