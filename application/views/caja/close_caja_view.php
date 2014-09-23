<div class="modal-dialog demo-modal">
    <div class="modal-content panel panel-success">
        <div class="modal-header panel-heading">
            <h4 class="modal-title"> Cerrar Caja </h4>
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

            <p style="text-align:center">
                Hoy es: <br><h3 style="text-align:center"> <?= $datetime ?></h3><br> Porfavor verifique que la fecha y hora indicada sea la correcta 
                para poder cerrar la caja, si no es la correcta, actualize su terminal a la fecha 
                y hora actual.
            </p>

            <?php foreach ($cajas as $row) { ?>

                <div class="modal-body">
                    <table>
                        <tr>
                            <td><label> # Caja: </label></td>
                            <td><label> &nbsp;&nbsp; <?= $row['num_caj'] ?> </label></td>
                        </tr>
                        <tr>
                            <td><label> &Uacute;ltimo cierre: </label></td>
                            <td><label> &nbsp;&nbsp; <?= $row['fein_cad'] ?> </label></td>
                        </tr>
                        <tr>
                            <td><label> Usuario (Apertura): </label></td>
                            <td><label> &nbsp;&nbsp; <?= $row['usin_cad'] ?> </label></td>
                        </tr>
                        <tr>
                            <td><label> Saldo inicial (S/.): </label></td>
                            <td><label> &nbsp;&nbsp; <?= $row['sain_cad'] ?> </label></td>
                        </tr>
                        <tr>
                            <td><label> Usuario (Cierre): </label></td>
                            <td><label> &nbsp;&nbsp; <?= $row['usfi_cad'] ?> </label></td>
                        </tr>
                        <tr>
                            <td><label> Saldo final (S/.): </label></td>
                            <td><label> &nbsp;&nbsp; <?= $row['sain_cad'] ?> </label></td>
                        </tr>
                    </table>
                </div>

                <?= form_open(base_url('closecaja'), $form_closecaja) ?>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Usuario: *</label>
                        <select id="codi_rol" class="form-control" name="usfi_cad"><?php foreach ($usuarios as $r) { ?> <option value="<?= $r->codi_usu ?>"><?= $r->nomb_usu ?></option> <?php } ?></select>
                    </div>
                    <div class="form-group"><label>Saldo inicial (S/.): *</label> <?= form_input($safi_cad, $row['sain_cad']) ?> </div>
                    <div class="form-group"><label>Observaci&oacute;n: *</label><?= form_textarea($obsv_cad, $row['obsv_cad']) ?></div>
                </div>
                <div class="modal-footer">
                    <div style="float: right;">
                        <input type="hidden" name="num_caj" value="<?= $row['num_caj'] ?>">
                        <input type="hidden" name="codi_cad" value="<?= $row['codi_cad'] ?>">
                        <?= form_submit($registrar) ?>
                    </div>
                </div>

                <?= form_close() ?>

            <?php } ?>

        </div>
    </div>
</div>