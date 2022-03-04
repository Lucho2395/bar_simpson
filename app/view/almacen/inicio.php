<?php
/**
 * Created by PhpStorm
 * User: Franz
 * Date: 15/03/2021
 * Time: 09:54
 */
?>
<!-- Modal Agregar Almacen-->
<div class="modal fade" id="gestionAlmacen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar/Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="gestionarInfoAlmacen">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="almacen">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Negocio:</label>
                                        <select class="form-control" onchange="actualizar_almacen()" id= "id_negocio" name="id_negocio">
                                            <option selected value="">Seleccionar Negocio</option>
                                            <?php
                                            foreach($negocios as $n){
                                                ?>
                                                <option value="<?php echo $n->id_negocio;?>"><?php echo $n->negocio_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Sucursal:</label>
                                        <div id="datos_almacen"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre Almacén: </label>
                                        <input class="form-control" type="text" id="almacen_nombre" name="almacen_nombre" maxlength="100" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Capacidad:</label>
                                        <input class="form-control" type="text" id="almacen_capacidad" onkeyup="return validar_numeros(this.id)" name="almacen_capacidad" maxlength="100" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Estado: </label>
                                        <select id="almacen_estado" name="almacen_estado" class="form-control" onchange="cambiar_color_estado('almacen_estado')">
                                            <option value="1" style="background-color: #17a673; color: white;" selected>HABILITADO</option>
                                            <option value="0" style="background-color: #e74a3b; color: white;">DESHABILITADO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-agregar-almacen"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Editar Almacen-->
<div class="modal fade" id="editarDatosAlmacen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Editar Almacen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="editarInformacionAlmacen">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="almacen">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre Almacén: </label>
                                        <input class="form-control" type="hidden" id="id_almacen" name="id_almacen" maxlength="11" readonly>
                                        <input class="form-control" type="text" id="almacen_nombre_e" name="almacen_nombre_e" maxlength="100" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="col-form-label">Capacidad: </label>
                                    <input class="form-control" type="text" id="almacen_capacidad_e" onkeyup="return validar_numeros(this.id)" name="almacen_capacidad_e" maxlength="100" placeholder="Ingrese Información...">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="col-form-label">Estado: </label>
                                    <select id="almacen_estado_e" name="almacen_estado_e" class="form-control" onchange="cambiar_color_estado('almacen_estado_e')">
                                        <option value="1" style="background-color: #17a673; color: white;" selected>HABILITADO</option>
                                        <option value="0" style="background-color: #e74a3b; color: white;">DESHABILITADO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Negocio:</label>
                                    <select class="form-control" onchange="actualizar_almacen()" id= "id_negocio" name="id_negocio">
                                        <option value="">Seleccionar Negocio</option>
                                        <?php
                                        foreach($negocios as $c){
                                            ?>
                                            <option value="<?php echo $c->id_negocio;?>"><?php echo $c->negocio_nombre;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Sucursal:</label>
                                    <div id="datos_almacen"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-editar-almacen"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="sacar_stock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Sacar Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <input type="hidden" id="id_recurso_modal" name="id_recurso_modal">
                        <input type="hidden" id="id_negocio_modal" name="id_negocio_modal">
                        <div class="col-lg-12">
                            <h5><span id="nombre_producto_"></span></h5><br>
                        </div>

                        <div class="col-lg-6">
                            <input class="form-control" type="text" id="cantidad_salida" name="cantidad_salida" placeholder="Ingrese Cantidad...">
                        </div>
                        <div class="col-lg-3">
                            <button class="btn btn-success" onclick="salida()"><i class="fa fa-arrow-down"></i> Sacar </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
               <!-- <button data-toggle="modal" data-target="#gestionAlmacen" onclick="cambiar_texto_formulario('exampleModalLabel', 'Agregar Nuevo Almacen'); agregacion_almacen()" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Nuevo</button>-->
            </div>
            <!-- /.row (main row) -->
            <div class="row">
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h4 class="m-0 font-weight-bold text-primary">Lista de Productos Registrados</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-earning" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>ID</th>
                                        <th>Negocio</th>
                                        <th>Producto</th>
                                        <th>Stock</th>
                                        <th>Accion</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($productos as $m){
                                        $estado = "DESHABILITADO";
                                        $estilo_estado = "class=\"texto-deshabilitado\"";
                                        if($m->almacenes_estado == 1){
                                            $estado = "HABILITADO";
                                            $estilo_estado = "class=\"texto-habilitado\"";
                                        }
                                        ?>
                                        <tr>
                                            <td><?= $a;?></td>
                                            <td><?= $m->negocio_nombre;?></td>
                                            <td><?= $m->recurso_nombre;?></td>
                                            <td><?= $m->recurso_sede_stock;?></td>
                                            <td>
                                                <a class="btn btn-warning" onclick="sacar_stock_almacen(<?= $m->id_recurso_sede?>,'<?= $m->id_negocio?>','<?= $m->recurso_nombre?>')" data-target="#sacar_stock" data-toggle="modal" title='Sacar Stock'><i class='fa fa-minus-square text-white editar margen'></i></a>
                                              <!-- <a class="btn btn-danger" onclick="preguntar('¿Esta seguro que quiere Deshabilitar este producto?','deshabilitar','Si','No',<?= $m->id_recurso_sede?>,0)" title='Deshabilitar producto'><i class='fa fa-trash text-white editar margen'></i></a>-->
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

            <form method="post" action="<?= _SERVER_ ?>Almacen/inicio">
                <input type="hidden" id="enviar_fecha" name="enviar_fecha" value="1">
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-2 col-sm-4 col-xs-4 col-md-4">
                        <label for="turno">Desde:</label>
                        <input type="date" class="form-control" id="fecha_filtro" name="fecha_filtro" step="1" value="<?php echo $fecha_i;?>">
                    </div>
                    <div class="col-lg-2 col-sm-4 col-xs-4 col-md-4">
                        <label for="turno">Hasta:</label>
                        <input type="date" class="form-control" id="fecha_filtro_fin" name="fecha_filtro_fin" value="<?php echo $fecha_f;?>">
                    </div>
                    <div class="col-lg-2 col-sm-4 col-xs-4 col-md-4">
                        <button style="margin-top: 35px;" class="btn btn-success" ><i class="fa fa-search"></i> Buscar Registro</button>
                    </div>
                </div>
            </form>
            <br>
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8 col-sm-12 col-xs-12 col-md-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h4 class="m-0 font-weight-bold text-primary">Listado de Salidas de Stock</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" style="border-color: black">
                                <thead>
                                <tr style="background-color: #ebebeb">
                                    <th>FECHAS</th>
                                    <th>PRODUCTO</th>
                                    <th>CANTIDAD SACADA</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($datos){
                                    for($i=$fecha_filtro;$i<=$fecha_filtro_fin;$i+=86400) {
                                        $cantidad_sacada = $this->almacen->cantidad_sacada(date("Y-m-d", $i));
                                        $fecha = date("d-m-Y", $i);
                                        ?>

                                            <?php
                                        foreach ($cantidad_sacada as $cs){
                                            ?>
                                            <tr>
                                                <td><?= $fecha;?></td>
                                                <td><?= $cs->nombre?></td>
                                                <td><?= $cs->total ?? 0?></td>
                                            </tr>
                                                <?php
                                        }
                                    ?>
                                    <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2"></div>
            </div>
        <!-- /.container-fluid -->
    </div>
</div>
<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>almacen.js"></script>
<script>
    function sacar_stock_almacen(id,id_negocio,nombre){
        $("#id_recurso_modal").val(id);
        $("#id_negocio_modal").val(id_negocio);
        $("#nombre_producto_").html(nombre);
    }
</script>