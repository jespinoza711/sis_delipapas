<div class="row">
    <div class="col-lg-12 col-xs-12">

        <div class="col-md-11" style="margin-left: 4%;">
            <div id="panel-cie" class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"> Registro Di&aacute;rio </h3>
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

                    <?= form_open(base_url('registrodiariodia'), $form_regdiario) ?>

                    <div class="modal-body">
                        <div class="form-group" style="text-align:center"><h3> <?= $datetime ?> </h3></div>
                        <div class="form-group">
                            <label> Empleado: *</label>
                            <select id="codi_rol" class="form-control" name="codi_emp"><?php foreach ($empleado as $r) { ?> <option value="<?= $r->codi_emp ?>"><?= $r->nomb_emp . ' ' . $r->apel_emp ?></option> <?php } ?></select>
                        </div>
                        <div class="form-group"><label> Pago. Kilo: * </label><?= form_input($pago_kilo, $planilla->suel_pla) ?></div>
                        <div class="form-group"><label> Prod. Procesados (Kls): * </label><?= form_input($cant_dpl) ?></div>
                        <div class="form-group"><label> Descuentos Observados (S/.): </label><?= form_input($desc_dpl, '0.00') ?></div>
                        <div class="form-group"><label> Observaci&oacute;n: * </label><?= form_textarea($obsv_dpl) ?></div>
                    </div>
                    <div class="modal-footer">
                        <div style="float: right;">
                            <input type="hidden" name="pago_kilo" value="<?= $planilla->suel_pla ?>">
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