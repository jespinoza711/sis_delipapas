<div>
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb" style="margin-top: 2%;">
                <li><a href="<?= base_url('home') ?>">Inicio</a></li>
                <li class="active">Usuario</li>
            </ol>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 2%">
    <div class="col-md-8 col-md-offset-2">
        <div id="panel-cie" class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Lista de usuarios</h3>
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
                
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalNuevoUsuario">Nuevo usuario</button>
                <br><br>
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
                        <tbody>
                            
                            <?php foreach ($usuarios as $row) { ?>
                            
                                <tr style="background-color: none;">
                                    <td style="text-align: center;"><?= $row->codi_usu ?></td>
                                    <td style="text-align: center;"><?= $row->nomb_usu ?></td>
                                    <td style="text-align: center;"><?= $row->nomb_rol ?></td>
                                    <td style="text-align: center;"><?= $row->ses_usu ?></td>
                                    <td style="text-align: center;"><?= $row->esta_usu == 'A' ? 'Activo' : 'Inactivo' ?></td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <button type="button" class="tooltip-usu btn btn-success btn-circle editar_usu" data-toggle="tooltip" data-placement="top" title="Editar" >
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        
                                        <?php if ($row->esta_usu == 'D') { ?>
                                            <span>
                                                <?= form_open(base_url('usuario'), $form_status) ?>
                                                <input type="hidden" name="codi_usu" value="<?= $row->codi_usu ?>">
                                                <input type="hidden" name="nomb_usu" value="<?= $row->nomb_usu ?>">
                                                <input name="activar" type="submit" class="tooltip-usu btn btn-primary btn-circle fa" value="&#xf00c;" data-toggle="tooltip" data-placement="top" title="Habilitar">
                                                <?= form_close() ?>
                                            </span>
                                        
                                        <?php } else { ?>
                                        
                                            <span>
                                                <?= form_open(base_url('usuario'), $form_status) ?>
                                                <input type="hidden" name="codi_usu" value="<?= $row->codi_usu ?>">
                                                <input type="hidden" name="nomb_usu" value="<?= $row->nomb_usu ?>">
                                                <input name="desactivar" type="submit" class="tooltip-usu btn btn-danger btn-circle fa" value="&#xf05e;" data-toggle="tooltip" data-placement="top" title="Deshabilitar">
                                                <?= form_close() ?>
                                            </span>
                                        
                                        <?php } ?>
                                        
                                    </td>
                                </tr>
                                
                            <?php } ?>
                                
                        </tbody>
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
                    <select id="codi_rol" class="form-control" name="codi_rol_e"><?php foreach ($rol as $r) { ?> <option value="<?= $r->codi_rol ?>"><?= $r->nomb_rol ?></option> <?php } ?></select>
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

<!--<ul id="usuarios-rep" style="display: none;">
    
    <?php foreach ($usuarios as $row) { ?><li><?= $row->nomb_usu ?></li><?php } ?>
    
</ul>
<table id="usuarios-det" style="display: none;">
    
    <?php foreach ($usuarios as $row) { ?>
    
        <tr>
            <td><?= $row->codi_usu ?></td>
            <td><?= $row->logi_usu ?></td>
            <td><?= $row->nomb_rol ?></td>
            <td><?= $row->esta_usu ?></td>
        </tr>
        
    <?php } ?>
        
</table>-->