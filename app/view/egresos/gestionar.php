
<!-- Modal Agregar Concepto-->
<div class="modal fade" id="movi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 50% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="agregar_egresos">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="sucursal">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Sucursal:</label>
                                        <select class="form-control" id= "id_sucursal" name="id_sucursal">
                                            <?php
                                            foreach($sucursal as $s){
                                                ?>
                                                <option value="<?php echo $s->id_sucursal;?>"><?php echo $s->sucursal_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="">Tipo Movimiento</label>
                                    <select class="form-control" name="movimiento_tipo" id="movimiento_tipo">
                                        <option value="">Seleccione...</option>
                                        <option value="1">Ingreso</option>
                                        <option value="2">Salida</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Concepto:</label>
                                        <textarea rows="3" class="form-control" type="text" id="egreso_descripcion" name="egreso_descripcion" maxlength="200" placeholder="Ingrese Concepto..."></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Total:</label>
                                        <input class="form-control" type="text" id="egreso_monto" onkeyup="return validar_numeros_decimales_dos(this.id)" name="egreso_monto" maxlength="30" placeholder="Ingrese Monto...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btn-agregar-egreso"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="editaregresos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="editar_egresos">
                <input type="hidden" id="id_movimiento" name="id_movimiento" value="">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="sucursal">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Sucursal:</label>
                                        <select class="form-control" id= "id_sucursal_e" name="id_sucursal_e">
                                            <option value="">Seleccione Sucursal</option>
                                            <?php
                                            foreach($sucursal as $s){
                                                ?>
                                                <option value="<?php echo $s->id_sucursal;?>"><?php echo $s->sucursal_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="">Tipo Movimiento</label>
                                    <select class="form-control" name="movimiento_tipo_e" id="movimiento_tipo_e">
                                        <option value="">Seleccione...</option>
                                        <option value="1">Ingreso</option>
                                        <option value="2">Salida</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Concepto:</label>
                                        <textarea rows="3" class="form-control" type="text" id="egreso_descripcion_e" name="egreso_descripcion_e" maxlength="200" placeholder="Ingrese Concepto..."></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Total:</label>
                                        <input class="form-control" type="text" id="egreso_monto_e" onkeyup="return validar_numeros_decimales_dos(this.id)" name="egreso_monto_e" maxlength="30" placeholder="Ingrese Monto...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btn-editar-egreso"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
                <button data-toggle="modal" data-target="#movi" class=" btn btn-success"><i class="fa fa-plus text-white-50"></i> Agregar</button>
            </div>
            <!-- /.row (main row) -->
            <form method="post" action="<?= _SERVER_ ?>Egreso/gestionar">
                <input type="hidden" id="enviar_fecha" name="enviar_fecha" value="1">
                <div class="row">
                    <div class="col-lg-3 col-xs-6 col-md-6 col-sm-6">
                        <label for="">Caja</label>
                        <select class="form-control" id= "id_caja_numero" name="id_caja_numero">
                            <option value="">Seleccione...</option>
                            <?php
                            (isset($caja_))?$cajita=$caja_->id_caja_numero:$cajita=0;
                            foreach($caja as $l){
                                    ($l->id_caja_numero == $cajita)?$sele='selected':$sele='';
                                    ?>
                                    <option value="<?php echo $l->id_caja_numero;?>" <?= $sele; ?>><?php echo $l->caja_numero_nombre;?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-3 col-xs-6 col-md-6 col-sm-6">
                        <label for="turno">Desde:</label>
                        <input type="date" class="form-control" id="fecha_filtro" name="fecha_filtro" step="1" value="<?php echo $fecha_filtro;?>">
                    </div>
                    <div class="col-lg-3 col-xs-6 col-md-6 col-sm-6">
                        <label for="turno">Hasta:</label>
                        <input type="date" class="form-control" id="fecha_filtro_fin" name="fecha_filtro_fin" value="<?php echo $fecha_filtro_fin;?>">
                    </div>
                    <div class="col-lg-3 col-xs-6 col-md-6 col-sm-6">
                        <button style="margin-top: 35px;" class="btn btn-success" ><i class="fa fa-search"></i> Buscar Registro</button>
                    </div>
                </div>
            </form>
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-earning" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>ID</th>
                                        <th>Caja</th>
                                        <th>Concepto</th>
                                        <th>Tipo Movimiento</th>
                                        <th>Monto</th>
                                        <th>Fecha de Registro</th>
                                        <th>Accion</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($egresos as $m){
                                        if($m->movimiento_tipo == 1){
                                            $movi = 'Ingreso';
                                        }else{
                                            $movi = 'Salida';
                                        }
                                        ?>
                                        <tr id="egresos<?= $m->id_movimiento;?>">
                                            <td><?= $a;?></td>
                                            <td><?= $m->caja_numero_nombre;?></td>
                                            <td><?= $m->egreso_descripcion;?></td>
                                            <td><?= $movi;?></td>
                                            <td>S/. <?= $m->egreso_monto;?></td>
                                            <td><?= $m->egreso_fecha_registro;?></td>
                                            <td>
                                                <div id="botondeegreso<?= $m->id_movimiento;?>">
                                                    <button data-toggle="modal" data-target="#editaregresos" onclick="editar_egreso(<?= $m->id_movimiento;?>,'<?= $m->id_sucursal;?>','<?= $m->movimiento_tipo;?>','<?= $m->egreso_descripcion;?>','<?= $m->egreso_monto;?>')" class="btn btn-sm btn-info btne" ><i class="fa fa-pencil"></i></button>
                                                </div>
                                                <button id="btn-eliminar_egreso<?= $m->id_movimiento;?>" class="btn btn-sm btn-secondary btn-danger" onclick="preguntar('¿Está seguro que desea eliminar este registro','eliminar_egreso','Si','No',<?= $m->id_movimiento;?>)"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        <?php
                                        $a++;
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>egresos.js"></script>