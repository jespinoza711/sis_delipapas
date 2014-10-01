<div class="row" id="cpo_pago">
    <div class="col-lg-12 col-xs-12">
        <div class="col-md-12">
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
                        <div class="form-group">
                            <select id="sw_codi_emp" class="form-control" name="codi_emp"><?php foreach ($empleado as $r) { ?> <option value="<?= $r->codi_emp ?>"><?= $r->nomb_emp . ' ' . $r->apel_emp ?></option> <?php } ?></select>
                        </div>
                        <div class="form-group">
                            <label>Filtrar por: </label>
                            <select id="sw_filter_pago" class="form-control" style="display: inline; margin-left: 10px; width: auto;">
                                <option value="0">Todos los registros</option>
                                <option value="1">Rango de d&iacute;as</option>
                            </select>
                        </div>
                        <div class="form-group" id="type_filter_2" style="display: none">
                            <label>Seleccione rango de días: </label>
                            <div class="input-group" style="width: 50%;">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right input-lg" id="dates_filter_2">
                            </div>
                        </div>
                        <br>
                        <button id="filter_prev" class="btn btn-block btn-lg btn-default" style="width: 50%;">Filtrar registros de pago</button>
                    </div>
                    
                    <section id="detalle_emp_pago" class="content invoice" style="display: none; width: 100%;">
                        <div class="row">
                            <div class="col-xs-12">
                                <h2 class="page-header">
                                    <i class="fa fa-check"></i> Información del empleado
                                </h2>
                            </div>
                        </div>

                        <div class="row invoice-info">
                            <table class="table table-condensed">
                                <tbody>
                                    <tr>
                                        <td style="vertical-align: middle;"><strong>Código:</strong></td>
                                        <td id="codi_emp_pago" style="vertical-align: middle;"></td>
                                        <td style="vertical-align: middle;"><strong>D&iacute;as trabajados:</strong></td>
                                        <td id="dias_emp_pago" style="vertical-align: middle;"></td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: middle;"><strong>Nombre:</strong></td>
                                        <td id="nomb_emp_pago" style="vertical-align: middle;"></td>
                                        <td style="vertical-align: middle;"><strong>Prod. Proc. acumulado (Kls):</strong></td>
                                        <td id="prod_emp_pago" style="vertical-align: middle;"></td>                                        
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: middle;"><strong>Tipo de Empleado:</strong></td>
                                        <td id="tipo_emp_pago" style="vertical-align: middle;"></td>
                                        <td style="vertical-align: middle;"><strong>Pago acumulado (S/.):</strong></td>
                                        <td id="suto_emp_pago" style="vertical-align: middle;"></td>                                        
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: middle;"><strong>Planilla actual:</strong></td>
                                        <td id="pla_emp_pago" style="vertical-align: middle;"></td>
                                        <td style="vertical-align: middle;"><strong>Descuento acumulado (S/.):</strong></td>
                                        <td id="desc_emp_pago" style="vertical-align: middle;"></td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: middle;"><strong>Plan. actual (Pago. Kilo):</strong></td>
                                        <td id="pla_suel_emp_pago" style="vertical-align: middle;"></td>
                                        <td style="vertical-align: middle;"><strong>Total acumulado (S/.):</strong></td>
                                        <td id="tota_emp_pago" style="vertical-align: middle;"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="vertical-align: middle;"></td>
                                    </tr>
                                </tbody>
                            </table>                            
                        </div>
                    </section>
                    <br>
                    <button id="btn_all_pago" type="button" class="btn btn-info"><i class="fa fa-eye"></i>&nbsp;&nbsp;&nbsp;Mostrar todos los registros</button>
                    <br><br>
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

<div class="modal fade" id="ModalEditarRegistroDiario" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content" style="border-color: #428bca; border-style: inset;">
            
            <?= form_open(base_url('pago/registro_diario_dia_edit'), $form_regdiario_edit) ?>
            
            <div class="modal-header" style="
                 padding: 10px 15px;
                 border-bottom: 1px solid transparent;
                 border-top-left-radius: 3px;
                 border-top-right-radius: 3px;
                 color: #fff;
                 background-color: #428bca;
                 border-color: #428bca;
                 ">
                <h4 class="modal-title" id="myModalLabel">Editar registro diario</h4>
            </div>
            <div class="modal-body">
                <div class="form-group"><label> Codigo: </label><?= form_input($codi_dpl_e) ?></div>
                <div class="form-group"><label> Fecha: </label><?= form_input($fech_dpl_e) ?></div>
                <div class="form-group"><label> Empleado: </label><?= form_input($nomb_emp_e) ?></div>
                <div class="form-group"><label> Pago por kilo (S/ 0.00): (Planilla actual) </label><?= form_input($suel_pla_e, $planilla->suel_pla) ?></div>
                <div class="form-group"><label> Productos Procesados (Kilos): * </label><?= form_input($cant_dpl_e) ?></div>
                <div class="form-group"><label> Subtotal a Pagar (S/ 0.00): * </label><?= form_input($suto_dpl_e) ?></div>
                <div class="form-group"><label> Descuentos Observados (S/ 0.00): </label><?= form_input($desc_dpl_e) ?></div>
                <div class="form-group"><label> Total a Pagar (S/ 0.00): *</label><?= form_input($tota_dpl_e) ?></div>
                <div class="form-group"><label> Observaci&oacute;n: (Max. 500 caracteres)</label><?= form_textarea($obsv_dpl_e) ?></div>           
                <p class="text-muted" style="font-style: italic;">(*) Los campos con asterisco son obligatorios.</p>
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarEditarPlanilla" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <?= form_submit($registrodiario_edit) ?>
                </div>
            </div>
            
            <?= form_close() ?>
            
        </div>
    </div>
</div>