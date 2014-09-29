<div class="row" id="cpo_reporte">
    <div class="col-lg-12 col-xs-12">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading input-lg">
                    Seleccione un reporte:
                </div>
                <div class="panel-body">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default" id="panel_reporte_2">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapsed">Listado de movimientos de venta por mes</a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse" style="height: 0px;">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label>Filtrar por: </label>
                                        <select id="sw_filter_2" class="form-control" style="display: inline; margin-left: 10px; width: auto;">
                                            <option value="0">Mes</option>
                                            <option value="1">Días</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="type_filter2_a">
                                        <label>Seleccione mes y año: </label>
                                        <input type="month" class="form-control input-lg" id="reporte_2_a" style="width: 50%;">
                                    </div>
                                    <div class="form-group" id="type_filter2_b" style="display: none;">
                                        <label>Seleccione rango de días: </label>
                                        <div class="input-group" style="width: 50%;">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right input-lg" id="dates_reporte_2">
                                        </div>
                                    </div>
                                    <br>
                                    <button id="reporte_2_prev" class="btn btn-block btn-lg btn-default" style="width: 50%;">Previsualizar lista</button>
                                    <br>
                                    <div class="table-responsive" id="cpo_reporte_2" style="display: none;">
                                        <table id="table_reporte_2" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;">Fecha</th>
                                                    <th style="text-align: center;">Cliente</th>
                                                    <th style="text-align: center;"><span  class="tooltip_rep" data-toggle="tooltip" data-placement="top" title="" data-original-title="N° de caja">N°</span></th>
                                                    <th style="text-align: center;"><span class="tooltip_rep" data-toggle="tooltip" data-placement="top" title="" data-original-title="Usuario vendedor">U.V.</span></th>
                                                    <th style="text-align: center;"><span class="tooltip_rep" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tipo de comprobante">Com.</span></th>
                                                    <th style="text-align: center;"><span class="tooltip_rep" data-toggle="tooltip" data-placement="top" title="" data-original-title="Total de venta">Total</span></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <a href="<?= base_url('reporte/venta') ?>" target="_blank" style="display: none;"><button id="reporte_2_pdf" class="btn btn-block btn-lg btn-danger" disabled="true">Generar PDF</button></a>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default" id="panel_reporte_1">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed">Listado de movimientos de compra por mes</a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label>Filtrar por: </label>
                                        <select id="sw_filter_1" class="form-control" style="display: inline; margin-left: 10px; width: auto;">
                                            <option value="0">Mes</option>
                                            <option value="1">Días</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="type_filter1_a">
                                        <label>Seleccione mes y año: </label>
                                        <input type="month" class="form-control input-lg" id="reporte_1_a" style="width: 50%;">
                                    </div>
                                    <div class="form-group" id="type_filter1_b" style="display: none;">
                                        <label>Seleccione rango de días: </label>
                                        <div class="input-group" style="width: 50%;">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right input-lg" id="dates_reporte_1">
                                        </div>
                                    </div>
                                    <br>
                                    <button id="reporte_1_prev" class="btn btn-block btn-lg btn-default" style="width: 50%;">Previsualizar lista</button>
                                    <br>
                                    <div class="table-responsive" id="cpo_reporte_1" style="display: none;">
                                        <table id="table_reporte_1" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;">Fecha</th>
                                                    <th style="text-align: center;">Usuario</th>
                                                    <th style="text-align: center;">N°</th>
                                                    <th style="text-align: center;">Total de compra</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <a href="<?= base_url('reporte/compra') ?>" target="_blank" style="display: none;"><button id="reporte_1_pdf" class="btn btn-block btn-lg btn-danger" disabled="true">Generar PDF</button></a>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default" id="panel_reporte_8">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseEight" class="collapsed">Listado de movimientos de caja diario</a>
                                </h4>
                            </div>
                            <div id="collapseEight" class="panel-collapse collapse" style="height: 0px;">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label>Filtrar por: </label>
                                        <select id="sw_filter_8" class="form-control" style="display: inline; margin-left: 10px; width: auto;">
                                            <option value="0">Todos</option>
                                            <option value="1">Días</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="type_filter8" style="display: none;">
                                        <label>Seleccione rango de días: </label>
                                        <div class="input-group" style="width: 50%;">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right input-lg" id="dates_reporte_8">
                                        </div>
                                    </div>
                                    <br>
                                    <button id="reporte_8_prev" class="btn btn-block btn-lg btn-default" style="width: 50%;">Previsualizar lista</button>
                                    <br>
                                    <div class="table-responsive" id="cpo_reporte_8">
                                        <table id="table_reporte_8" class="table table-bordered" style="font-size: 12px;">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;"><span class="tooltip_rep" data-toggle="tooltip" data-placement="top" title="" data-original-title="N° de caja">N°</span></th>
                                                    <th style="text-align: center;"><span class="tooltip_rep" data-toggle="tooltip" data-placement="top" title="" data-original-title="Fecha de apertura de caja">Fecha A.</span></th>
                                                    <th style="text-align: center;"><span class="tooltip_rep" data-toggle="tooltip" data-placement="top" title="" data-original-title="Usuario de apertura de caja">Usuario A.</span></th>
                                                    <th style="text-align: center;"><span class="tooltip_rep" data-toggle="tooltip" data-placement="top" title="" data-original-title="Saldo inicial de caja">Saldo I.</span></th>
                                                    <th style="text-align: center;"><span class="tooltip_rep" data-toggle="tooltip" data-placement="top" title="" data-original-title="Fecha de cierre de caja">Fecha C.</span></th>
                                                    <th style="text-align: center;"><span class="tooltip_rep" data-toggle="tooltip" data-placement="top" title="" data-original-title="Usuario de cierre de caja">Usuario C.</span></th>
                                                    <th style="text-align: center;"><span class="tooltip_rep" data-toggle="tooltip" data-placement="top" title="" data-original-title="Saldo final de caja">Saldo F.</span></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <a href="<?= base_url('reporte/caja') ?>" target="_blank"><button id="reporte_8_pdf" class="btn btn-block btn-lg btn-danger" disabled="true">Generar PDF</button></a>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default" id="panel_reporte_9">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseNine" class="collapsed">Listado de movimientos de caja chica diario</a>
                                </h4>
                            </div>
                            <div id="collapseNine" class="panel-collapse collapse" style="height: 0px;">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label>Filtrar por: </label>
                                        <select id="sw_filter_9" class="form-control" style="display: inline; margin-left: 10px; width: auto;">
                                            <option value="0">Todos</option>
                                            <option value="1">Días</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="type_filter9" style="display: none;">
                                        <label>Seleccione rango de días: </label>
                                        <div class="input-group" style="width: 50%;">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right input-lg" id="dates_reporte_9">
                                        </div>
                                    </div>
                                    <br>
                                    <button id="reporte_9_prev" class="btn btn-block btn-lg btn-default" style="width: 50%;">Previsualizar lista</button>
                                    <br>
                                    <div class="table-responsive" id="cpo_reporte_9">
                                        <table id="table_reporte_9" class="table table-bordered" style="font-size: 12px;">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;"><span class="tooltip_rep" data-toggle="tooltip" data-placement="top" title="" data-original-title="Código de caja chica">Código</span></th>
                                                    <th style="text-align: center;"><span class="tooltip_rep" data-toggle="tooltip" data-placement="top" title="" data-original-title="Fecha de apertura de caja chica">Fecha A.</span></th>
                                                    <th style="text-align: center;"><span class="tooltip_rep" data-toggle="tooltip" data-placement="top" title="" data-original-title="Usuario de apertura de caja chica">Usuario A.</span></th>
                                                    <th style="text-align: center;"><span class="tooltip_rep" data-toggle="tooltip" data-placement="top" title="" data-original-title="Saldo inicial de caja chica">Saldo I.</span></th>
                                                    <th style="text-align: center;"><span class="tooltip_rep" data-toggle="tooltip" data-placement="top" title="" data-original-title="Fecha de cierre de caja chica">Fecha C.</span></th>
                                                    <th style="text-align: center;"><span class="tooltip_rep" data-toggle="tooltip" data-placement="top" title="" data-original-title="Usuario de cierre de caja chica">Usuario C.</span></th>
                                                    <th style="text-align: center;"><span class="tooltip_rep" data-toggle="tooltip" data-placement="top" title="" data-original-title="Saldo utilizado de caja chica">Saldo U.</span></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <a href="<?= base_url('reporte/caja_chica') ?>" target="_blank"><button id="reporte_9_pdf" class="btn btn-block btn-lg btn-danger" disabled="true">Generar PDF</button></a>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default" id="panel_reporte_10">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTeen" class="collapsed">Listado de registro diario</a>
                                </h4>
                            </div>
                            <div id="collapseTeen" class="panel-collapse collapse" style="height: 0px;">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label>Filtrar por: </label>
                                        <select id="sw_filter_10" class="form-control" style="display: inline; margin-left: 10px; width: auto;">
                                            <option value="0">Todos</option>
                                            <option value="1">Días</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="type_filter10" style="display: none;">
                                        <label>Seleccione rango de días: </label>
                                        <div class="input-group" style="width: 50%;">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right input-lg" id="dates_reporte_10">
                                        </div>
                                    </div>
                                    <br>
                                    <button id="reporte_10_prev" class="btn btn-block btn-lg btn-default" style="width: 50%;">Previsualizar lista</button>
                                    <br>
                                    <div class="table-responsive" id="cpo_reporte_10">
                                        <table id="table_reporte_10" class="table table-bordered" style="font-size: 12px;">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;"><span>Fecha</span></th>
                                                    <th style="text-align: center;"><span>Usuario</span></th>
                                                    <th style="text-align: center;"><span>Empleado</span></th>
                                                    <th style="text-align: center;"><span class="tooltip_rep" data-toggle="tooltip" data-placement="top" title="" data-original-title="Productos procesados (Kls)">P.P.</span></th>
                                                    <th style="text-align: center;"><span>Total</span></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <a href="<?= base_url('reporte/registro') ?>" target="_blank"><button id="reporte_10_pdf" class="btn btn-block btn-lg btn-danger" disabled="true">Generar PDF</button></a>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default" id="panel_reporte_3">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="collapsed">Listado de inventario</a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="table-responsive" id="cpo_reporte_3">
                                        <table id="table_reporte_3" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;">Producto</th>
                                                    <th style="text-align: center;">Fecha de ingreso</th>
                                                    <th style="text-align: center;">Fecha de salida</th>
                                                    <th style="text-align: center;">Precio unitario</th>
                                                    <th style="text-align: center;">Stock</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <a href="<?= base_url('reporte/inventario') ?>" target="_blank"><button id="reporte_3_pdf" class="btn btn-block btn-lg btn-danger" disabled="true">Generar PDF</button></a>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default" id="panel_reporte_4">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour" class="collapsed">Listado de clientes</a>
                                </h4>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="table-responsive" id="cpo_reporte_4">
                                        <table id="table_reporte_4" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;">Nombres y apellidos</th>
                                                    <th style="text-align: center;">Teléfono</th>
                                                    <th style="text-align: center;">R.U.C.</th>
                                                    <th style="text-align: center;">Dirección</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <a href="<?= base_url('reporte/cliente') ?>" target="_blank"><button id="reporte_4_pdf" class="btn btn-block btn-lg btn-danger" disabled="true">Generar PDF</button></a>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default" id="panel_reporte_5">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive" class="collapsed">Listado de proveedores</a>
                                </h4>
                            </div>
                            <div id="collapseFive" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="table-responsive" id="cpo_reporte_5">
                                        <table id="table_reporte_5" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;">Proveedor</th>
                                                    <th style="text-align: center;">R.U.C.</th>
                                                    <th style="text-align: center;">Teléfono</th>
                                                    <th style="text-align: center;">E-mail</th>
                                                    <th style="text-align: center;">Dirección</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <a href="<?= base_url('reporte/proveedor') ?>" target="_blank"><button id="reporte_5_pdf" class="btn btn-block btn-lg btn-danger" disabled="true">Generar PDF</button></a>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default" id="panel_reporte_6">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix" class="collapsed">Listado de usuarios</a>
                                </h4>
                            </div>
                            <div id="collapseSix" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="table-responsive" id="cpo_reporte_6">
                                        <table id="table_reporte_6" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;">Nombre de usuario</th>
                                                    <th style="text-align: center;">Rol</th>
                                                    <th style="text-align: center;">Última sesión</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <a href="<?= base_url('reporte/usuario') ?>" target="_blank"><button id="reporte_6_pdf" class="btn btn-block btn-lg btn-danger" disabled="true">Generar PDF</button></a>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default" id="panel_reporte_7">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" class="collapsed">Listado de empleados</a>
                                </h4>
                            </div>
                            <div id="collapseSeven" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="table-responsive" id="cpo_reporte_7">
                                        <table id="table_reporte_7" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;">D.N.I.</th>
                                                    <th style="text-align: center;">Apellidos y nombres</th>
                                                    <th style="text-align: center;">Tipo</th>
                                                    <th style="text-align: center;">Teléfono</th>
                                                    <th style="text-align: center;">Sueldo</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <a href="<?= base_url('reporte/empleado') ?>" target="_blank"><button id="reporte_7_pdf" class="btn btn-block btn-lg btn-danger" disabled="true">Generar PDF</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>