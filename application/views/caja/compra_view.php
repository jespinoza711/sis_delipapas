<div class="row">
    <div class="col-lg-12 col-xs-12">

        <div class="col-md-11" style="margin-left: 4%;">
            <div id="panel-cie" class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Productos registrados</h3>
                </div>
                <div class="panel-body">

                    <?php if ($this->session->userdata('mensaje_compra') && $this->session->userdata('mensaje_compra') != "") { ?>

                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?= $this->session->userdata('mensaje_compra') ?>
                        </div>

                        <?php
                        $this->session->unset_userdata('mensaje_emp');
                    }
                    ?>

                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalNuevoEmpleado"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Nueva compra</button>
                    <br><br>
                    <div class="table-responsive">
                        <table id="table-usuario" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Codigo</th>
                                    <th style="text-align: center;">Tipo</th>
                                    <th style="text-align: center;">Nombre</th>
                                    <th style="text-align: center;">Stock</th>
                                    <th style="text-align: center;">Proveedor</th>
                                    <th style="text-align: center;">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($producto as $row) { ?>
<!--                                    <tr style="background-color: none;">
                                        <td style="text-align: center;"><?= $row->codi_prod ?></td>
                                        <td><?= $row->nomb_tipo ?></td>
                                        <td style="text-align: center;"><?= $row->dire_emp ?></td>
                                        <td style="text-align: center;"><?= $row->telf_emp ?></td>
                                        <td style="text-align: center;"><?php
                                            if ($row->esta_emp == "A") {
                                                echo "Habilitado";
                                            } else if ($row->esta_emp == "D") {
                                                echo "Deshabilitado";
                                            }
                                            ?></td>
                                        <td style="vertical-align: middle; text-align: center;">
                                            <button type="button" class="tooltip-emp btn btn-success btn-circle editar_emp" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <?php if ($row->esta_emp == "D") { ?>
                                                <span>
                                                    <?= form_open(base_url() . 'empleado', $form_a) ?>
                                                    <input type="hidden" name="codigo" value="<?= $row->codi_emp ?>">
                                                    <input type="hidden" name="empleado" value="<?= $row->nomb_emp . ' ' . $row->apel_emp ?>">
                                                    <input name="activar" type="submit" class="tooltip-emp btn btn-primary btn-circle fa" value="&#xf00c;" data-toggle="tooltip" data-placement="top" title="Habilitar">
                                                    <?= form_close() ?>
                                                </span>
                                            <?php } else if ($row->esta_emp == "A") { ?>
                                                <span>
                                                    <?= form_open(base_url() . 'empleado', $form_a) ?>
                                                    <input type="hidden" name="codigo" value="<?= $row->codi_emp ?>">
                                                    <input type="hidden" name="empleado" value="<?= $row->nomb_emp . ' ' . $row->apel_emp ?>">
                                                    <input name="desactivar" type="submit" class="tooltip-emp btn btn-danger btn-circle fa" value="&#xf05e;" data-toggle="tooltip" data-placement="top" title="Deshabilitar">
                                                    <?= form_close() ?>
                                                </span>
                                            <?php } ?>
                                        </td>
                                    </tr>-->
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <div style="float: right;">
                            <button id="btnCancelarModalMedico" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button id="btnEditarModalMedico" type="button" class="btn btn-primary" disabled>Editar</button>
                            <button id="btnDeshabilitarMedico" type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalDeshabilitar" disabled>Deshabilitar</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-11" style="margin-left: 4%;">
            <div id="panel-cie" class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Nueva lista de compra</h3>
                </div>
                <div class="panel-body">

                    <?php if ($this->session->userdata('mensaje_compra') && $this->session->userdata('mensaje_compra') != "") { ?>

                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?= $this->session->userdata('mensaje_compra') ?>
                        </div>

                        <?php
                        $this->session->unset_userdata('mensaje_emp');
                    }
                    ?>

                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalNuevoEmpleado"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Nueva compra</button>
                    <br><br>
                    <div class="table-responsive">
                        <table id="table-usuario" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Código</th>
                                    <th style="text-align: center;">Nombre</th>
                                    <th style="text-align: center;">Cantidad</th>
                                    <th style="text-align: center;">Observación</th>
                                    <th style="text-align: center;">Proveedor</th>
                                    <th style="text-align: center;">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>