<div class="row" id="cpo_proveedor" style="margin-top: 2%">
    <div class="col-md-10 col-md-offset-1">
        <div id="panel-proveedor" class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Mantenimiento</h3>
            </div>
            <div class="panel-body">
                
                <?php if ($this->session->userdata('info_pro') != ''){ ?>
                
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        <?= $this->session->userdata('info_pro') ?>
                    </div>
                
                <?php $this->session->set_userdata('info_pro', ''); } if ($this->session->userdata('error_pro') != ''){ ?>
                
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        <?= $this->session->userdata('error_pro') ?>
                    </div>
                
                <?php $this->session->set_userdata('error_pro', ''); } ?>
                
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalNuevoProveedor"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Nuevo Proveedor</button>
                <br><br>
                <div class="table-responsive">
                    <table id="table_proveedor" class="table table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th style="text-align: center;">C&oacute;digo</th>
                                <th style="text-align: center;">Nombre</th>
                                <th style="text-align: center;">R.U.C.</th>
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

<div class="modal fade" id="ModalNuevoProveedor" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content" style="border-color: #428bca; border-style: inset;">
            
            <?= form_open(base_url('proveedor'), $form) ?>
            
            <div class="modal-header" style="
                 padding: 10px 15px;
                 border-bottom: 1px solid transparent;
                 border-top-left-radius: 3px;
                 border-top-right-radius: 3px;
                 color: #fff;
                 background-color: #428bca;
                 border-color: #428bca;
                 ">
                <h4 class="modal-title" id="myModalLabel">Nuevo proveedor</h4>
            </div>
            <div class="modal-body">
                <div class="form-group"><label>Nombre: *</label><?= form_input($nombre) ?></div>
                <div class="form-group"><label>R.U.C.: *</label><?= form_input($ruc) ?></div>
                <div class="form-group"><label>Dirección: *</label><?= form_input($direccion) ?></div>
                <div class="form-group">
                    <label>Teléfono: *</label>
                    <div id="tipo_telf_prov" class="btn-group" style="margin-left: 10px; margin-bottom: 4px;">
                        <button id="linea_prov" type="button" class="btn btn-sm btn-default active"  data-toggle="tooltip" data-placement="top" title="Formato de teléfono (99) 999-9999">Línea</button>
                        <button id="movil_prov" type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Formato de teléfono (99) 999-999-999">Móvil</button>
                    </div>
                    <?= form_input($telefono) ?>
                    <p id="error_telf1_prov" style="font-style: italic; display: none;">Debe completar el campo de teléfono</p>
                </div>
                <div class="form-group"><label>E-mail: </label><?= form_input($email) ?></div>
                <p class="text-muted" style="font-style: italic;">(*) Los campos con asterisco son obligatorios.</p>
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarNuevoProv" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <?= form_submit($registrar) ?>
                </div>
            </div>
            
            <?= form_close() ?>
            
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditarProveedor" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content" style="border-color: #428bca; border-style: inset;">
            
            <?= form_open(base_url('proveedor'), $form_e) ?>
            
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
                <div class="form-group"><label>Nombre: *</label><?= form_input($nombre_e) ?></div>
                <div class="form-group"><label>R.U.C.: *</label><?= form_input($ruc_e) ?></div>
                <div class="form-group"><label>Dirección: *</label><?= form_input($direccion_e) ?></div>
                <div class="form-group">
                    <label>Teléfono: *</label>
                    <div id="tipo_telf_prov_e" class="btn-group" style="margin-left: 10px; margin-bottom: 4px;">
                        <button id="linea_prov_e" type="button" class="btn btn-sm btn-default active"  data-toggle="tooltip" data-placement="top" title="Formato de teléfono (99) 999-9999">Línea</button>
                        <button id="movil_prov_e" type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Formato de teléfono (99) 999-999-999">Móvil</button>
                    </div>
                    <?= form_input($telefono_e) ?>
                    <p id="error_telf1_prov_e" style="font-style: italic; display: none;">Debe completar el campo de teléfono</p>
                </div>
                <div class="form-group"><label>E-mail: </label><?= form_input($email_e) ?></div>
                <p class="text-muted" style="font-style: italic;">(*) Los campos con asterisco son obligatorios.</p>
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarEditarProv" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <?= form_submit($editar) ?>
                </div>
            </div>
            <input type="hidden" id="nomb_prov_h" name="nombre_h">
            <input type="hidden" id="ruc_prov_h" name="ruc_h">
            <input type="hidden" id="telf_prov_h" name="telefono_h">
            <input type="hidden" id="dire_prov_h" name="direccion_h">
            <input type="hidden" id="emai_prov_h" name="email_h">
            <?= form_close() ?>
            
        </div>
    </div>
</div>