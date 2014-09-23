<div class="row">
    <div class="col-lg-12 col-xs-12">

        <div class="col-md-11" style="margin-left: 4%;">
            <div id="panel-cie" class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Productos registrados</h3>
                </div>
                <div class="panel-body">

                    <?php if ($this->session->userdata('info') != ''){ ?>

                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <?= $this->session->userdata('info') ?>
                        </div>

                    <?php $this->session->set_userdata('info', ''); } if ($this->session->userdata('error') != ''){ ?>

                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <?= $this->session->userdata('error') ?>
                        </div>

                    <?php $this->session->set_userdata('error', ''); } ?>

                    <div class="table-responsive">
                        <table id="table-producto" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Codigo</th>
                                    <th style="text-align: center;">Tipo</th>
                                    <th style="text-align: center;">Nombre</th>
                                    <th style="text-align: center;">Precio</th>
                                    <th style="text-align: center;">Ult. Ingreso</th>
                                    <th style="text-align: center;">Ult. Salida</th>
                                    <th style="text-align: center;">Stock</th>
                                    <th style="text-align: center;">Observ.</th>
                                    <th style="text-align: center;">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php foreach ($producto as $row) { ?>
                                
                                    <tr style="background-color: none;">
                                        <td style="text-align: center;"><?= $row->codi_prod ?></td>
                                        <td style="text-align: center;"><?= $row->nomb_tipo ?></td>
                                        <td style="text-align: center;"><?= $row->nomb_prod ?></td>
                                        <td style="text-align: center;"><?= $row->prec_prod ?></td>
                                        <td style="text-align: center;"><?= $row->fein_prod ?></td>
                                        <td style="text-align: center;"><?= $row->fesa_prod ?></td>
                                        <td style="text-align: center;"><?= $row->stoc_prod ?></td>
                                        <td style="text-align: center;"><?= $row->obsv_prod ?></td>
                                        <td style="text-align: center;"><?= $row->esta_prod == 'A' ? 'Activo' : 'Inactivo' ?></td>
                                    </tr>
                                    
                                <?php } ?>
                                    
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>