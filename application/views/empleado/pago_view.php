<div class="row" id="cpo_pago">
    <div class="col-lg-12 col-xs-12">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Control de Pagos
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

                    <a href="<?= base_url('registrodiario') ?>"><button type="button" class="btn btn-info"><i class="fa fa-eye"></i>&nbsp;&nbsp;&nbsp;Registro Diario</button></a>
                    <br>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>Buscar Empleado: </label>
                        <input type="text" id="empleado_pago" class="form-control input-lg" placeholder="Escriba el nombre del empleado y seleccione...">
                    </div>
                    
                    <section id="detalle_empleado_pago" class="content invoice" style="display: none; width: 100%;">
                        <div class="row">
                            <div class="col-xs-12">
                                <h2 class="page-header">
                                    <i class="fa fa-bars"></i> Información del empleado
                                </h2>
                            </div>
                        </div>

                        <div class="row invoice-info">
                            <table class="table table-condensed">
                                <tbody>
                                    <tr>
                                        <td style="vertical-align: middle;"><strong>Código:</strong></td>
                                        <td id="codi_emp_pago" colspan="3" style="vertical-align: middle;"></td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: middle;"><strong>Nombre:</strong></td>
                                        <td id="nomb_emp_pago" style="vertical-align: middle;"></td>
                                        <td style="vertical-align: middle;"><strong>Tipo de Empleado:</strong></td>
                                        <td id="tipo_emp_pago" style="vertical-align: middle;"></td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: middle;"><strong>D&iacute;as trabajados:</strong></td>
                                        <td id="dias_emp_pago" style="vertical-align: middle;"></td>
                                        <td style="vertical-align: middle;"><strong>Pago acumulado (S/.):</strong></td>
                                        <td id="suto_emp_pago" style="vertical-align: middle;"></td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: middle;"><strong>Descuento acumulado (S/.):</strong></td>
                                        <td id="desc_emp_pago" style="vertical-align: middle;"></td>
                                        <td style="vertical-align: middle;"><strong>Pago Total (S/.):</strong></td>
                                        <td id="tota_emp_pago" style="vertical-align: middle;"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" id="obsv_prod_ven" style="vertical-align: middle;"></td>
                                    </tr>
                                </tbody>
                            </table>

                            <button id="agregar_pro_ven" class="btn btn-block btn-lg btn-primary">Buscar</button>
                            
                        </div>
                    </section>
                    <div class="table-responsive">
                        <table id="table_pago" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Fecha de registro</th>
                                    <th>Usuario</th>
                                    <th>Empleado</th>
                                    <th>Pago. Kilo</th>
                                    <th>Prod. Proc. (Kls)</th>
                                    <th>Subtotal</th>
                                    <th>Descuento</th>
                                    <th>Total</th>
                                    <th>Observaci&oacute;n</th>
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