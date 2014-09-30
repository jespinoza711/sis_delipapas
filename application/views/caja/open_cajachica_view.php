<div class="modal-dialog demo-modal">
    <div class="modal-content panel panel-info">
        <div class="modal-header panel-heading">
            <h4 class="modal-title"> Aperturar Caja Chica </h4>
        </div>
        <div class="modal-body">

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
            
            <p style="text-align:center">Hoy es: <br><h3 style="text-align:center"> <?= $datetime ?></h3></p>

            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                Porfavor verifique que la fecha y hora indicada sea la correcta 
                para poder aperturar la caja chica, si no es la correcta, actualize su terminal a la fecha 
                y hora actual.
            </div>            

            <?php foreach ($cajas as $row) { ?>

                <div class="modal-body">
                    <table class="table table-condensed">
                        <tr>
                            <td><label> # Caja: </label></td>
                            <td><label> <?= $row['codi_cac'] ?> </label></td>
                        </tr>
                        <tr>
                            <td><label> &Uacute;ltimo cierre: </label></td>
                            <td><label> <?= date('d/m/Y g:i A', strtotime($row['fein_ccd'])) ?> </label></td>
                        </tr>
                        <tr>
                            <td><label> Usuario (Apertura): </label></td>
                            <td><label> <?= $row['usin_ccd'] ?> </label></td>
                        </tr>
                        <tr>
                            <td><label> Saldo inicial (S/.): </label></td>
                            <td><label> <?= $row['sain_ccd'] ?> </label></td>
                        </tr>
                        <tr>
                            <td><label> Usuario (Cierre): </label></td>
                            <td><label> <?= $row['usfi_ccd'] ?> </label></td>
                        </tr>
                        <tr>
                            <td><label> Saldo final (S/.): </label></td>
                            <td><label> <?= $row['safi_ccd'] ?> </label></td>
                        </tr>
                        <tr>
                            <td><label> Observaci&oacute;n: </label></td>
                            <td><label> <?= $row['obsv_ccd'] ?> </label></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                        </tr>
                    </table>
                </div>

                <?= form_open(base_url('opencajachica'), $form_opencajachica) ?>

                <div class="modal-body">
                    <div class="form-group"><label>Usuario: </label><?= form_input($nomb_usu, $this->session->userdata('user_name')) ?></div>
                    <div class="form-group"><label>Saldo inicial (S/.): *</label> <?= form_input($sain_ccd, $row['safi_ccd']) ?> </div>
                    <div class="form-group"><label>Observaci&oacute;n: (Max. 200 caracteres)</label><?= form_textarea($obsv_ccd) ?></div>
                </div>
                <div class="modal-footer">
                    <div style="float: right;">
                        <input type="hidden" name="codi_cac" value="<?= $row['codi_cac'] ?>">
                        <?= form_submit($registrar) ?>
                    </div>
                </div>

                <?= form_close() ?>

            <?php } ?>

        </div>
    </div>
</div>