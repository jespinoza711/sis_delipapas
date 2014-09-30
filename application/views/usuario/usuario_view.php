<div class="row" style="margin-top: 2%" id="cpo_usuario">
    <div class="col-md-10 col-md-offset-1">
        <div id="panel-cie" class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Mantenimiento</h3>
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
                
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalNuevoUsuario"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Nuevo Usuario</button>
                <br><br>
<!--                <div class="form-group">
                    <label>Tipo de búsqueda: </label>
                    <label class="radio-inline sw_search_usu">
                        <input type="radio" class="default" name="tipo_busqueda_usuario" value="0" id="default_search_usu" required="true" checked> Predeterminado
                    </label>
                    <label class="radio-inline sw_search_usu">
                        <input type="radio" class="buy" name="tipo_busqueda_usuario" value="0" id="buy_search_usu" required="true"> Fecha de compra
                    </label>
                </div>-->
                <div class="table-responsive">
                    <table id="table-usuario" class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center;">C&oacute;digo</th>
                                <th style="text-align: center;">Usuario</th>
                                <th style="text-align: center;">Rol</th>
                                <th style="text-align: center;">&Uacute;lt. Sesi&oacute;n</th>
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

<div class="modal fade" id="ModalNuevoUsuario" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content" style="border-color: #428bca; border-style: inset;">
            
            <?= form_open(base_url('usuario'), $form_usu) ?>
            
            <div class="modal-header" style="
                 padding: 10px 15px;
                 border-bottom: 1px solid transparent;
                 border-top-left-radius: 3px;
                 border-top-right-radius: 3px;
                 color: #fff;
                 background-color: #428bca;
                 border-color: #428bca;
                 ">
                <h4 class="modal-title" id="myModalLabel">Nuevo usuario</h4>
            </div>
            <div class="modal-body">

                <div class="form-group"><label>Usuario: *</label><?= form_input($nomb_usu) ?></div>
                <div class="form-group"><label>Contrase&ntilde;a: *</label><?= form_password($pass_usu) ?></div>
                <div class="form-group"><label>Confirmar contraseña: *</label><?= form_password($pass_usu_con) ?></div>
                <div class="form-group">
                    <label>Rol: *</label>
                    <select id="codi_rol" class="form-control" name="codi_rol"><?php foreach ($rol as $r) { ?> <option value="<?= $r->codi_rol ?>"><?= $r->nomb_rol ?></option> <?php } ?></select>
                </div>
                <p class="text-muted" style="font-style: italic;">(*) Los campos con asterisco son obligatorios.</p>
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarNuevoUsu" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <?= form_submit($registrar) ?>
                </div>
            </div>
            
            <?= form_close() ?>
            
        </div>
    </div>
</div>

<div class="modal fade" id="ModalEditarUsuario" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content" style="border-color: #428bca; border-style: inset;">
            
            <?= form_open(base_url('usuario'), $form_usu_edit) ?>
            
            <div class="modal-header" style="
                 padding: 10px 15px;
                 border-bottom: 1px solid transparent;
                 border-top-left-radius: 3px;
                 border-top-right-radius: 3px;
                 color: #fff;
                 background-color: #428bca;
                 border-color: #428bca;
                 ">
                <h4 class="modal-title" id="myModalLabel">Editar usuario</h4>
            </div>
            <div class="modal-body">

                <div class="form-group"><label>Código: *</label><?= form_input($codi_usu_e) ?></div>
                <div class="form-group"><label>Usuario: *</label><?= form_input($nomb_usu_e) ?></div>
                <div class="form-group"><label>Contraseña:</label><?= form_password($pass_usu_e) ?></div>
                <div class="form-group"><label>Confirmar contraseña:</label><?= form_password($pass_usu_con_e) ?></div>
                <div class="form-group">
                    <label>Rol: *</label>
                    <select id="codi_rol_e" class="form-control" name="codi_rol_e"><?php foreach ($rol as $r) { ?> <option value="<?= $r->codi_rol ?>"><?= $r->nomb_rol ?></option> <?php } ?></select>
                </div>
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarNuevoUsu" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <?= form_submit($editar) ?>
                </div>
            </div>
            
            <?= form_close() ?>
            
        </div>
    </div>
</div>

<div class="modal fade" id="ModalDeshabilitarUsu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; top: 25%;">
    <div class="modal-dialog" style="width: 350px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title" id="myModalLabel" style="text-align: center;">¿Est&aacute;s seguro de que desea deshabilitar a este usuario?</h4>
            </div>
            <div class="modal-footer" style="margin: 0px; border: 0px; padding: 0px;">
                <div style="text-align: center">
                    <button type="button" class="btn btn-default" data-dismiss="modal" 
                            style="padding-top: 20px; padding-bottom: 20px; width: 49%; float: left; margin:0px; border: none; border-radius: 0px;">No</button>
                    <button id="deshabilitarUsu" type="button" class="btn btn-danger" style="padding-top: 20px; padding-bottom: 20px; width: 49%; float: right; margin:0px; border: none; border-radius: 0px;">Si</button>
                </div>
            </div>
        </div>
    </div>
</div>