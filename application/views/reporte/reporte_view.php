<div class="row" id="cpo_reporte">
    <div class="col-lg-12 col-xs-12">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading input-lg">
                    Seleccione un reporte:
                </div>
                <div class="panel-body">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapsed">Listado de movimientos de venta por mes</a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse" style="height: 0px;">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label>Seleccione mes y año: </label>
                                        <input type="month" class="form-control input-lg" id="reporte_2_a" style="width: 50%;">
                                        <br>
                                        <button id="reporte_2_prev" class="btn btn-block btn-lg btn-default" style="width: 50%;">Previsualizar lista</button>
                                    </div>
                                    <div class="table-responsive" id="cpo_reporte_2" style="display: none;">
                                        <table id="table_reporte_2" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;">Fecha</th>
                                                    <th style="text-align: center;">Cliente</th>
                                                    <th style="text-align: center;" class="tooltip_rep" data-toggle="tooltip" data-placement="top" title="" data-original-title="N° de caja">N°</th>
                                                    <th style="text-align: center;" class="tooltip_rep" data-toggle="tooltip" data-placement="top" title="" data-original-title="Usuario vendedor">U.V.</th>
                                                    <th style="text-align: center;" class="tooltip_rep" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tipo de comprobante">Com.</th>
                                                    <th style="text-align: center;" class="tooltip_rep" data-toggle="tooltip" data-placement="top" title="" data-original-title="Total de venta">Total</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <a href="<?= base_url('reporte/venta') ?>" target="_blank" style="display: none;"><button id="reporte_2_pdf" class="btn btn-block btn-lg btn-danger" disabled="true">Generar PDF</button></a>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed">Listado de movimientos de compra por mes</a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label>Seleccione mes y año: </label>
                                        <input type="month" class="form-control input-lg" id="reporte_1_a" style="width: 50%;">
                                        <br>
                                        <button id="reporte_1_prev" class="btn btn-block btn-lg btn-default" style="width: 50%;">Previsualizar lista</button>
                                    </div>
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
                        <div class="panel panel-default">
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
                        <div class="panel panel-default">
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
                        <div class="panel panel-default">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>