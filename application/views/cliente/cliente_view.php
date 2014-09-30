<div class="row" id="cpo_cliente" style="margin-top: 2%">
    <div class="col-md-10 col-md-offset-1">
        <div id="panel-proveedor" class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Mantenimiento</h3>
            </div>
            <div class="panel-body">

                <?php if ($this->session->userdata('info_cli') != '') { ?>

                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        <?= $this->session->userdata('info_cli') ?>
                    </div>

                    <?php
                    $this->session->set_userdata('info_cli', '');
                } if ($this->session->userdata('error_cli') != '') {
                    ?>

                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    <?= $this->session->userdata('error_cli') ?>
                    </div>

                    <?php
                    $this->session->set_userdata('error_cli', '');
                }
                ?>

                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalNuevoCliente">Nuevo</button>
                <br><br>
                <div class="table-responsive">
                    <table id="table_cliente" class="table table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th style="text-align: center;">C&oacute;digo</th>
                                <th style="text-align: center;">Empresa</th>
                                <th style="text-align: center;">Nombres y apellidos</th>
                                <th style="text-align: center;">Teléfono</th>
                                <th style="text-align: center;">Estado</th>
                                <th style="text-align: center;">Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalNuevoCliente" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content" style="border-color: #428bca; border-style: inset;">

<?= form_open(base_url('cliente'), $form) ?>

            <div class="modal-header" style="
                 padding: 10px 15px;
                 border-bottom: 1px solid transparent;
                 border-top-left-radius: 3px;
                 border-top-right-radius: 3px;
                 color: #fff;
                 background-color: #428bca;
                 border-color: #428bca;
                 ">
                <h4 class="modal-title" id="myModalLabel">Nuevo cliente</h4>
            </div>
            <div class="modal-body">
                <div class="form-group"><label>Empresa: *</label><?= form_input($empresa) ?></div>
                <div class="form-group"><label>Nombre: *</label><?= form_input($nombre) ?></div>
                <div class="form-group"><label>Apellido: *</label><?= form_input($apellido) ?></div>
                <div class="form-group">
                    <label>Fecha de nacimiento: *</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
<?= form_input($fecha) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label>Teléfono: *</label>
                    <div id="tipo_telf_cli" class="btn-group" style="margin-left: 10px; margin-bottom: 4px;">
                        <button id="linea_cli" type="button" class="btn btn-sm btn-default active"  data-toggle="tooltip" data-placement="top" title="Formato de teléfono (99) 999-9999">Línea</button>
                        <button id="movil_cli" type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Formato de teléfono (99) 999-999-999">Móvil</button>
                    </div>
<?= form_input($telefono) ?>
                    <p id="error_telf1_cli" style="font-style: italic; display: none;">Debe completar el campo de teléfono</p>
                </div>
                <div class="form-group"><label>Dirección: *</label><?= form_input($direccion) ?></div>
                <div class="form-group">
                    <label>Sexo: *</label>
                    <label class="radio-inline">
                        <?= form_radio($masculino) ?> Masculino
                    </label>
                    <label class="radio-inline">
<?= form_radio($femenino) ?> Femenino
                    </label>
                </div>
                <div class="form-group"><label>R.U.C.: </label><?= form_input($ruc) ?></div>
                <p class="text-muted" style="font-style: italic;">(*) Los campos con asterisco son obligatorios.</p>
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarNuevoCli" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
<?= form_submit($registrar) ?>
                </div>
            </div>

<?= form_close() ?>

        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditarCliente" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content" style="border-color: #428bca; border-style: inset;">

            <?= form_open(base_url('cliente'), $form_e) ?>

            <div class="modal-header" style="
                 padding: 10px 15px;
                 border-bottom: 1px solid transparent;
                 border-top-left-radius: 3px;
                 border-top-right-radius: 3px;
                 color: #fff;
                 background-color: #428bca;
                 border-color: #428bca;
                 ">
                <h4 class="modal-title" id="myModalLabel">Editar proveedor</h4>
            </div>
            <div class="modal-body">
                <div class="form-group"><label>Código: *</label><?= form_input($codigo_e) ?></div>
                <div class="form-group"><label>Empresa: *</label><?= form_input($empresa_e) ?></div>
                <div class="form-group"><label>Nombre: *</label><?= form_input($nombre_e) ?></div>
                <div class="form-group"><label>Apellido: *</label><?= form_input($apellido_e) ?></div>
                <div class="form-group">
                    <label>Fecha de nacimiento: *</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <?= form_input($fecha_e) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label>Teléfono: *</label>
                    <div id="tipo_telf_cli_e" class="btn-group" style="margin-left: 10px; margin-bottom: 4px;">
                        <button id="linea_cli_e" type="button" class="btn btn-sm btn-default active"  data-toggle="tooltip" data-placement="top" title="Formato de teléfono (99) 999-9999">Línea</button>
                        <button id="movil_cli_e" type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Formato de teléfono (99) 999-999-999">Móvil</button>
                    </div>
                    <?= form_input($telefono_e) ?>
                    <p id="error_telf1_cli_e" style="font-style: italic; display: none;">Debe completar el campo de teléfono</p>
                </div>
                <div class="form-group"><label>Dirección: *</label><?= form_input($direccion_e) ?></div>
                <div class="form-group">
                    <label>Sexo: *</label>
                    <label class="radio-inline">
                        <?= form_radio($masculino_e) ?> Masculino
                    </label>
                    <label class="radio-inline">
                        <?= form_radio($femenino_e) ?> Femenino
                    </label>
                </div>
                <div class="form-group"><label>R.U.C.: </label><?= form_input($ruc_e) ?></div>
                <p class="text-muted" style="font-style: italic;">(*) Los campos con asterisco son obligatorios.</p>
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarEditarCli" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <?= form_submit($editar) ?>
                </div>
            </div>
            <input type="hidden" id="nomb_cli_h" name="empr_h">
            <input type="hidden" id="nomb_cli_h" name="nomb_h">
            <input type="hidden" id="apel_cli_h" name="apel_h">
            <input type="hidden" id="dire_cli_h" name="dire_h">
            <input type="hidden" id="sexo_cli_h" name="sexo_h">
            <input type="hidden" id="telf_cli_h" name="telf_h">
            <input type="hidden" id="ruc_cli_h" name="ruc_h">
            <input type="hidden" id="fena_cli_h" name="fena_h">
            <?= form_close() ?>
        </div>
    </div>
</div>