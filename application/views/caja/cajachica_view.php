<!--CAJA CHICA-->

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="col-md-11" style="margin-left: 4%">
            <div id="panel-cie" class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Registro de Gastos de Caja Chica</h3>
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

                    <?= form_open(base_url('regcajachica'), $form_regcajachica) ?>

                    <div class="modal-body">

                        <div class="form-group"><label> # Caja: </label><?= form_input($codi_cac, $cajachica->codi_cac) ?></div>
                        <div class="form-group"><label> Usuario activo: </label><?= form_input($codi_usu, $this->session->userdata('user_name')) ?></div>
                        <div class="form-group">
                            <label>Concepto de Gasto: </label>
                            <select id="codi_rol" class="form-control" name="codi_con"><?php foreach ($concepto as $r) { ?> <option value="<?= $r->codi_con ?>"><?= $r->nomb_con ?></option> <?php } ?></select>
                        </div>
                        <div class="form-group"><label> Descripci&oacute;n del Gasto: * </label><?= form_input($nomb_gas) ?></div>
                        <div class="form-group"><label> Importe utilizado (S/ 0.00): * </label><?= form_input($impo_gas) ?></div>
                        <div class="form-group"><label> Observaci&oacute;n: </label><?= form_textarea($obsv_gas) ?></div>

                    </div>
                    <div class="modal-footer">
                        <div style="float: right;">
                            <?= form_submit($registrar) ?>
                        </div>
                    </div>

                    <?= form_close() ?>

                </div>
            </div>
        </div>
    </div>
</div>