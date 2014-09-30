<div class="row" id="cpo_hiscompradet">
    <input id="codi_com_d" type="hidden" value="<?= $compra->codi_com ?>">
    <div class="col-lg-12 col-xs-12">
        <div class="col-md-11" style="margin-left: 4%">
            <div id="panel-cie" class="panel panel-primary">

                <div class="panel-heading">
                    <h3 class="panel-title"> Detalle de compra </h3>
                </div>

                <div class="panel-body">

                    <?php if ($this->session->userdata('info') != '') { ?>

                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <?= $this->session->userdata('info') ?>
                        </div>

                        <?php $this->session->set_userdata('info', '');
                    } if ($this->session->userdata('error') != '') {
                        ?>

                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    <?= $this->session->userdata('error') ?>
                        </div>

                        <?php $this->session->set_userdata('error', '');
                    }
                    ?>                    

                    <a href="<?= base_url('hiscompra') ?>"><button type="button" class="btn btn-info"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Ver todas las compras registradas</button></a>
                    <br><br><br>

                    <table class="table table-condensed">
                        <tbody>
                            <tr>
                                <td style="vertical-align: middle;"><strong>N&uacute;mero de compra:</strong></td>
                                <td colspan="3" style="vertical-align: middle;"><?= $compra->num_com ?></td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle;"><strong>Fecha:</strong></td>
                                <td style="vertical-align: middle;"><?= date("d/m/Y g:i A", strtotime($compra->fech_com)) ?></td>
                                <td style="vertical-align: middle;"><strong>Usuario que registr&oacute;:</strong></td>
                                <td style="vertical-align: middle;"><?= $compra->nomb_usu ?></td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle;"><strong>C&oacute;digo l&oacute;gico:</strong></td>
                                <td style="vertical-align: middle;"><?= $compra->codi_com ?></td>
                                <td style="vertical-align: middle;"><strong>Total de la compra (S/.):</strong></td>
                                <td style="vertical-align: middle;"><?= $compra->tota_com ?></td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle;"><strong>Observación:</strong></td>
                                <td colspan="3" style="vertical-align: middle;"><?= $compra->obsv_com ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    
                    <div class="table-responsive">
                        <table id="table_hiscompradet" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tipo Prod.</th>
                                    <th>Producto</th>
                                    <th>Proveedor</th>
                                    <th>Precio (S/.)</th>
                                    <th>Cantidad</th>
                                    <th>Importe (S/.)</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>