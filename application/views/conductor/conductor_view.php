<div class="row" style="margin-top: 2%" id="cpo_conductor">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
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
                
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalNuevoConductor"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Nuevo Conductor</button>
                <br><br>
                <div class="table-responsive">
                    <table id="table_conductor" class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center;">C&oacute;digo</th>
                                <th style="text-align: center;">DNI</th>
                                <th style="text-align: center;">Nombre</th>
                                <th style="text-align: center;">Apellidos</th>
                                <th style="text-align: center;"># Licencia</th>
                                <th style="text-align: center;">Obsvervaci&oacute;n</th>
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

<div class="modal fade" id="ModalNuevoConductor" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content" style="border-color: #428bca; border-style: inset;">
            
            <?= form_open(base_url('conductor'), $form_conductor) ?>
            
            <div class="modal-header" style="
                 padding: 10px 15px;
                 border-bottom: 1px solid transparent;
                 border-top-left-radius: 3px;
                 border-top-right-radius: 3px;
                 color: #fff;
                 background-color: #428bca;
                 border-color: #428bca;
                 ">
                <h4 class="modal-title" id="myModalLabel">Nuevo Conductor</h4>
            </div>
            <div class="modal-body">
                <div class="form-group"><label>Nombre: *</label><?= form_input($nomb_cond) ?></div>
                <div class="form-group"><label>Apellidos: *</label><?= form_input($apel_cond) ?></div>
                <div class="form-group"><label>DNI: *</label><?= form_input($dni_cond) ?></div>
                <div class="form-group"><label># Licencia: *</label><?= form_input($licen_cond) ?></div>
                <div class="form-group"><label>Observaci&oacute;n: </label><?= form_textarea($obsv_cond) ?></div>      
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <?= form_submit($registrar) ?>
                </div>
            </div>
            
            <?= form_close() ?>
            
        </div>
    </div>
</div>

<div class="modal fade" id="ModalEditarConductor" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content" style="border-color: #428bca; border-style: inset;">
            
            <?= form_open(base_url('conductor'), $form_conductor_edit) ?>
            
            <div class="modal-header" style="
                 padding: 10px 15px;
                 border-bottom: 1px solid transparent;
                 border-top-left-radius: 3px;
                 border-top-right-radius: 3px;
                 color: #fff;
                 background-color: #428bca;
                 border-color: #428bca;
                 ">
                <h4 class="modal-title" id="myModalLabel">Editar Conductor</h4>
            </div>
            <div class="modal-body">
                <div class="form-group"><label>C&oacute;digo: </label><?= form_input($id_cond_e) ?></div>
                <div class="form-group"><label>Nombre: *</label><?= form_input($nomb_cond_e) ?></div>
                <div class="form-group"><label>Apellidos: *</label><?= form_input($apel_cond_e) ?></div>
                <div class="form-group"><label>DNI: *</label><?= form_input($dni_cond_e) ?></div>
                <div class="form-group"><label># Licencia: *</label><?= form_input($licen_cond_e) ?></div>
                <div class="form-group"><label>Observaci&oacute;n: </label><?= form_textarea($obsv_cond_e) ?></div>           
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <?= form_submit($editar) ?>
                </div>
            </div>
            
            <?= form_close() ?>
            
        </div>
    </div>
</div>