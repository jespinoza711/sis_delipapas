<div class="row" id="cpo_hiscompra">
    <div class="col-lg-12 col-xs-12">
        <div class="col-md-11" style="margin-left: 4%">
            <div id="panel-cie" class="panel panel-primary">
                
                <div class="panel-heading">
                    <h3 class="panel-title"> Todas las compras registradas </h3>
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
                    
                    <a href="<?= base_url('compra') ?>"><button type="button" class="btn btn-info"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Registrar nueva compra</button></a>
                    <br><br>
                    <div class="table-responsive">
                        <table id="table_hiscompra" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>C&oacute;digo</th>
                                    <th>Fecha de compra</th>
                                    <th>N&uacute;mero</th>
                                    <th>Usuario</th>
                                    <th>Total (S/.)</th>
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