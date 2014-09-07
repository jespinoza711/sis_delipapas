<div class="row" id="cpo_empleado">
    <div class="col-lg-12 col-xs-12">
        <div class="col-md-11" style="margin-left: 4%;">
            <div id="panel-cie" class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Mantenimiento</h3>
                </div>
                <div class="panel-body">
                    <?php if ($this->session->userdata('mensaje_emp') && $this->session->userdata('mensaje_emp') != "") { ?>
                        <div class="alert alert-<?= $this->session->userdata('ripo_mensaje_emp') ?> alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?= $this->session->userdata('mensaje_emp') ?>
                        </div>
                        <?php
                        $this->session->unset_userdata('mensaje_emp');
                        $this->session->unset_userdata('ripo_mensaje_emp');
                    }
                    ?>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalNuevoEmpleado"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Nuevo</button>
                    <br><br>
                    <div class="table-responsive">
                        <table id="table_empleado" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th style="text-align: center;">Codigo</th>
                                    <th style="text-align: center;">Nombres</th>
                                    <th style="text-align: center;">Tipo de empleado</th>
                                    <th style="text-align: center;">Salario</th>
                                    <th style="text-align: center;">Teléfono</th>
                                    <th style="text-align: center;">Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalNuevoEmpleado" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content" style="border-color: #428bca; border-style: inset;">
            <?= form_open(base_url() . 'empleado', $form) ?>
            <div class="modal-header" style="
                 padding: 10px 15px;
                 border-bottom: 1px solid transparent;
                 border-top-left-radius: 3px;
                 border-top-right-radius: 3px;
                 color: #fff;
                 background-color: #428bca;
                 border-color: #428bca;
                 ">
                <h4 class="modal-title" id="myModalLabel">Nuevo empleado</h4>
            </div>
            <div class="modal-body">
                <?php if ($this->session->userdata('mensaje_nemp') && $this->session->userdata('mensaje_nemp') != "") { ?>
                    <div class="alert alert-<?= $this->session->userdata('ripo_mensaje_nemp') ?> alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?= $this->session->userdata('mensaje_nemp') ?>
                    </div>
                    <?php
                    $this->session->unset_userdata('mensaje_nemp');
                    $this->session->unset_userdata('ripo_mensaje_nemp');
                }
                ?>
                <div class="form-group">
                    <label>Nombres: *</label>
                    <?= form_input($nombre) ?>
                </div>
                <div class="form-group">
                    <label>Apellidos: *</label>
                    <?= form_input($apellido) ?>
                </div>
                <div class="form-group">
                    <label>D.N.I.: * <span class="text-muted" style="font-style: italic;">(Debe contener 8 dígitos)</span></label>
                    <?= form_input($dni) ?>
                    <p id="error_dni1" style="font-style: italic; display: none;">Debe completar el campo de D.N.I.</p>
                </div>
                <div class="form-group">
                    <label>Teléfono: *</label>
                    <div id="tipo_telf" class="btn-group" style="margin-left: 10px; margin-bottom: 4px;">
                        <button id="linea" type="button" class="btn btn-sm btn-default active"  data-toggle="tooltip" data-placement="top" title="Formato de teléfono (99) 999-9999" <?= $disabled ?>>Línea</button>
                        <button id="movil" type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Formato de teléfono (99) 999-999-999" <?= $disabled ?>>Móvil</button>
                    </div>
                    <?= form_input($telefono) ?>
                    <p id="error_telf1" style="font-style: italic; display: none;">Debe completar el campo de teléfono</p>
                </div>
                <div class="form-group">
                    <label>Dirección: *</label>
                    <?= form_input($direccion) ?>
                </div>
                <div class="form-group">
                    <label>Sexo: *</label>
                    <label class="radio-inline">
                        <?= form_radio($masculino) ?> Masculino
                    </label>
                    <label class="radio-inline">
                        <?= form_radio($femenino) ?> Femenino
                    </label>
                </div>
                <div class="form-group">
                    <label>Estado civil: *</label><br>
                    <label class="radio-inline">
                        <?= form_radio($soltero) ?> Soltero
                    </label>
                    <label class="radio-inline">
                        <?= form_radio($casado) ?> Casado
                    </label>
                    <label class="radio-inline">
                        <?= form_radio($divorciado) ?> Divorciado
                    </label>
                </div>
                <div class="form-group">
                    <label>Tipo de empleado: * <button id="btnTipoEmp" type="button" class="btn btn-sm btn-primary" style="padding: 0px 10px; margin-left: 4px;"  data-toggle="tooltip" data-placement="top" title="Añadir tipo de empleado"><i class="fa fa-plus"></i></button></label>
                    <?= form_dropdown('tipo_emp', $tipo, array(), 'id="tipo_emp" class="form-control" ' . $disabled) ?>
                </div>
                <div class="form-group">
                    <label>Planilla: * <button id="btnPlaEmp" type="button" class="btn btn-sm btn-primary" style="padding: 0px 10px; margin-left: 4px;"  data-toggle="tooltip" data-placement="top" title="Añadir planilla"><i class="fa fa-plus"></i></button></label>
                    <?= form_dropdown('plan_emp', $planilla, array(), 'id="plan_emp" class="form-control" ' . $disabled) ?>
                </div>
                <div class="form-group input-group" style="width: 160px;">
                    <span class="input-group-addon">A.F.P. *</span>
                    <input type="text" name="afp" id="afp_emp" value="0" maxlength="5" class="form-control" style="text-align: right;" required="true" <?= $disabled ?>>
                    <span class="input-group-addon">%</span>
                </div>
                <p class="text-muted" style="font-style: italic;">(*) Los campos con asterisco son obligatorios.</p>
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarNEmp" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <?= form_submit($registrar) ?>
                </div>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalEditarEmpleado" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content" style="border-color: #428bca; border-style: inset;">
            <?= form_open(base_url() . 'empleado', $form_editar) ?>
            <div class="modal-header" style="
                 padding: 10px 15px;
                 border-bottom: 1px solid transparent;
                 border-top-left-radius: 3px;
                 border-top-right-radius: 3px;
                 color: #fff;
                 background-color: #428bca;
                 border-color: #428bca;
                 ">
                <h4 class="modal-title" id="myModalLabel">Editar empleado</h4>
            </div>
            <div class="modal-body">
                <?php if ($this->session->userdata('mensaje_edemp') && $this->session->userdata('mensaje_edemp') != "") { ?>
                    <div class="alert alert-<?= $this->session->userdata('tipo_mensaje_edemp') ?> alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?= $this->session->userdata('mensaje_edemp') ?>
                    </div>
                    <?php
                    $this->session->unset_userdata('mensaje_edemp');
                    $this->session->unset_userdata('tipo_mensaje_edemp');
                }
                ?>
                <div class="form-group">
                    <label>Código: *</label>
                    <?= form_input($codigo_e) ?>
                </div>
                <div class="form-group">
                    <label>Nombres: *</label>
                    <?= form_input($nombre_e) ?>
                </div>
                <div class="form-group">
                    <label>Apellidos: *</label>
                    <?= form_input($apellido_e) ?>
                </div>
                <div class="form-group">
                    <label>D.N.I.: * <span class="text-muted" style="font-style: italic;">(Debe contener 8 dígitos)</span></label>
                    <?= form_input($dni_e) ?>
                    <p id="error_dni1_e" style="font-style: italic; display: none;">Debe completar el campo de D.N.I.</p>
                </div>
                <div class="form-group">
                    <label>Teléfono: *</label>
                    <div id="tipo_telf_e" class="btn-group" style="margin-left: 10px; margin-bottom: 4px;">
                        <button id="linea_e" type="button" class="btn btn-sm btn-default active"  data-toggle="tooltip" data-placement="top" title="Formato de teléfono (99) 999-9999" <?= $disabled ?>>Línea</button>
                        <button id="movil_e" type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Formato de teléfono (99) 999-999-999" <?= $disabled ?>>Móvil</button>
                    </div>
                    <?= form_input($telefono_e) ?>
                    <p id="error_telf1_e" style="font-style: italic; display: none;">Debe completar el campo de teléfono</p>
                </div>
                <div class="form-group">
                    <label>Dirección: *</label>
                    <?= form_input($direccion_e) ?>
                </div>
                <div class="form-group">
                    <label>Sexo: *</label>
                    <label class="radio-inline" id="cpo_m_emp">
                        <?= form_radio($masculino_e) ?> Masculino
                    </label>
                    <label class="radio-inline" id="cpo_f_emp">
                        <?= form_radio($femenino_e) ?> Femenino
                    </label>
                </div>
                <div class="form-group">
                    <label>Estado civil: *</label><br>
                    <label class="radio-inline" id="cpo_s_emp">
                        <?= form_radio($soltero_e) ?> Soltero
                    </label>
                    <label class="radio-inline" id="cpo_c_emp">
                        <?= form_radio($casado_e) ?> Casado
                    </label>
                    <label class="radio-inline" id="cpo_d_emp">
                        <?= form_radio($divorciado_e) ?> Divorciado
                    </label>
                </div>
                <div class="form-group">
                    <label>Tipo de empleado: * <button id="btnTipoEmp_e" type="button" class="btn btn-sm btn-primary" style="padding: 0px 10px; margin-left: 4px;"  data-toggle="tooltip" data-placement="top" title="Añadir tipo de empleado"><i class="fa fa-plus"></i></button></label>
                    <?= form_dropdown('tipo_emp', $tipo, array(), 'id="tipo_emp_e" class="form-control" ' . $disabled) ?>
                </div>
                <div class="form-group">
                    <label>Planilla: * <button id="btnPlaEmp_e" type="button" class="btn btn-sm btn-primary" style="padding: 0px 10px; margin-left: 4px;"  data-toggle="tooltip" data-placement="top" title="Añadir planilla"><i class="fa fa-plus"></i></button></label>
                    <?= form_dropdown('plan_emp', $planilla, array(), 'id="plan_emp_e" class="form-control" ' . $disabled) ?>
                </div>
                <div class="form-group input-group" style="width: 160px;">
                    <span class="input-group-addon">A.F.P. *</span>
                    <input type="text" name="afp" id="afp_emp_e" value="0" maxlength="5" class="form-control" style="text-align: right;" required="true" <?= $disabled ?>>
                    <span class="input-group-addon">%</span>
                </div>
                <p class="text-muted" style="font-style: italic;">(*) Los campos con asterisco son obligatorios.</p>
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarEdEmp" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <?= form_submit($editar) ?>
                </div>
            </div>
            <!--REGISTRO ACTUAL-->
            <input type="hidden" id="nomb_emp_h" name="nombre_h">
            <input type="hidden" id="apel_emp_h" name="apellido_h">
            <input type="hidden" id="dni_emp_h" name="dni_h">
            <input type="hidden" id="telefono_emp_h" name="telefono_h">
            <input type="hidden" id="direccion_emp_h" name="direccion_h">
            <input type="hidden" id="sexo_emp_h" name="sexo_h">
            <input type="hidden" id="civil_emp_h" name="civil_h">
            <input type="hidden" id="afp_emp_h" name="afp_h">
            <input type="hidden" id="tem_emp_h" name="tem_h">
            <input type="hidden" id="pla_emp_h" name="pla_h">
            <?= form_close() ?>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalAddTipEmp" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%; margin-top: 15%;">
        <div class="modal-content" style="border-color: #ddd; border-style: inset;">
            <?= form_open(base_url() . 'empleado', $form_tipo) ?>
            <div class="modal-header" style="
                 padding: 10px 15px;
                 border-bottom: 1px solid transparent;
                 border-top-left-radius: 3px;
                 border-top-right-radius: 3px;
                 color: #000;
                 background-color: #ddd;
                 border-color: #ddd;
                 ">
                <h4 class="modal-title" id="myModalLabel">Añadir tipo de empleado</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nombre de tipo de empleado: * <p class="text-muted" style="font-style: italic;">(Debe contener mínimo 6 carácteres)</p></label>
                    <?= form_input($nombre_tipo) ?>                    
                    <p id="error_tem1" style="font-style: italic; display: none;">Ya existe este tipo de empleado, intente con otro nombre</p>
                </div>
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarTEmp" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <?= form_submit($registrar_temp) ?>
                </div>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalAddPla" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%; margin-top: 15%;">
        <div class="modal-content" style="border-color: #ddd; border-style: inset;">
            <?= form_open(base_url() . 'empleado', $form_pla) ?>
            <div class="modal-header" style="
                 padding: 10px 15px;
                 border-bottom: 1px solid transparent;
                 border-top-left-radius: 3px;
                 border-top-right-radius: 3px;
                 color: #000;
                 background-color: #ddd;
                 border-color: #ddd;
                 ">
                <h4 class="modal-title" id="myModalLabel">Añadir planilla</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Fecha:</label>&nbsp;&nbsp;<?= $fecha ?>
                </div>
                <div class="form-group">
                    <label>Sueldo: *</label>
                    <div class="input-group" style="width: 175px;">
                        <span class="input-group-addon">S/. </span>
                        <input type="text" id="suel_pla" name="sueldo" maxlength="10" value="" class="form-control" required="true" autocomplete="off" style="text-align: right;">
                        <span class="input-group-addon">.00</span>
                    </div>
                    <p id="error_pla1" style="font-style: italic; display: none;">Ya existe este sueldo en el año actual, intente con otro sueldo</p>
                </div>
                <div class="form-group">
                    <label>Observación:</label>
                    <textarea id="observa_pla" class="form-control" name="observa" rows="3" placeholder="Ingrese (opcional) ..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarPla" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <?= form_submit($registrar_pla) ?>
                </div>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>