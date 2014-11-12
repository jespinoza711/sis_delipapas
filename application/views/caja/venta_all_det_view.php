<div class="row" id="cpo_hisventadet">
    <input id="codi_ven_d" type="hidden" value="<?= $venta->codi_ven ?>">
    <div class="col-lg-12 col-xs-12">
        <div class="col-md-11" style="margin-left: 4%">
            <div id="panel-cie" class="panel panel-primary">

                <div class="panel-heading">
                    <h3 class="panel-title"> Detalle de venta </h3>
                </div>

                <div class="panel-body">                 

                    <a href="<?= base_url('hisventa') ?>"><button type="button" class="btn btn-info"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Ver todas las ventas registradas</button></a>
                    <br><br><br>

                    <table class="table table-condensed">
                        <tbody>
                            <tr>
                                <td style="vertical-align: middle;"><strong>Serie y N&uacute;mero:</strong></td>
                                <td colspan="3" style="vertical-align: middle;"><?= $venta->serie_com . ' - ' . $venta->nume_com ?></td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle;"><strong>Fecha:</strong></td>
                                <td style="vertical-align: middle;"><?= date("d/m/Y g:i A", strtotime($venta->fech_ven)) ?></td>
                                <td style="vertical-align: middle;"><strong>Usuario que registr&oacute;:</strong></td>
                                <td style="vertical-align: middle;"><?= $venta->nomb_usu ?></td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle;"><strong>C&oacute;digo l&oacute;gico:</strong></td>
                                <td style="vertical-align: middle;"><?= $venta->codi_ven ?></td>
                                <td style="vertical-align: middle;"><strong>Total de la venta (S/.):</strong></td>
                                <td style="vertical-align: middle;"><?= $venta->tota_ven ?></td>
                            </tr>
                            <tr>
                                <td colspan=4" style="vertical-align: middle;"></td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    
                    <div class="table-responsive">
                        <table id="table_hisventadet" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tipo Prod.</th>
                                    <th>Producto</th>
                                    <th>cantidad</th>
                                    <th>IGV (S/.)</th>
                                    <th>Parcial (S/.)</th>
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