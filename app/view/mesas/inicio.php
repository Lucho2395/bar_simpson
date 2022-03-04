<?php
/**
 * Created by PhpStorm
 * User: Franz
 * Date: 12/03/2021
 * Time: 12:24
 */
?>
<!-- Modal Agregar Mesa-->
<div class="modal fade" id="gestionMesa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar/Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="gestionarInfoMesa">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="mesa">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre Mesa: </label>
                                        <input class="form-control" type="text" id="mesa_nombre" name="mesa_nombre" maxlength="100" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Negocio:</label>
                                        <select class="form-control" onchange="actualizar_mesa()" id= "id_negocio" name="id_negocio">
                                            <option value="">Seleccionar Negocio</option>
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
                                        <div id="datos_mesa"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Capacidad:</label>
                                        <input class="form-control" type="text" id="mesa_capacidad" onkeyup="return validar_numeros(this.id)" name="mesa_capacidad" maxlength="100" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-agregar-mesa"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Mesa-->
<div class="modal fade" id="editarDatosMesa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Editar Mesa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="editarInformacionMesa">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="mesa">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre Mesa: </label>
                                        <input type="hidden" id="id_mesa" name="id_mesa">
                                        <input class="form-control" type="text" id="mesa_nombre_e" name="mesa_nombre_e" maxlength="100" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Negocio:</label>
                                    <select class="form-control" onchange="actualizar_mesa_editar()" id= "id_negocio_e" name="id_negocio_e">
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
                                    <div id="datos_mesa_editar"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Capacidad: </label>
                                    <input class="form-control" type="text" id="mesa_capacidad_e" onkeyup="return validar_numeros(this.id)" name="mesa_capacidad_e" maxlength="100" placeholder="Ingrese Información...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-editar-mesa"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
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
            </div>
            <div class="row">
                <div class="col-lg-9 col-sm-8 col-xs-8 col-md-8"></div>
                <div class="col-lg-3 col-xs-3 col-md-3 col-sm-3">
                    <button data-toggle="modal" data-target="#gestionMesa" onclick="cambiar_texto_formulario('exampleModalLabel', 'Agregar Nuevo Mesa'); agregacion_mesa()" class="btn btn-success"><i class="fa fa-plus"></i> Agregar Nuevo</button>
                </div>
                <div class="col-sm-1 col-md-1 col-sm-1"></div>
            </div>
            <br>
        <!-- /.row (main row) -->
        <div class="row">
            <div class="col-lg-12">
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Lista de Mesas Registradas</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless table-striped table-earning" id="dataTable" width="100%" cellspacing="0">
                            <thead class="text-capitalize">
                            <tr>
                                <th>ID</th>
                                <th>Sucursal</th>
                                <th>Nombre</th>
                                <th>Capacidad</th>
                                <th>Estado</th>
                                <th>Accion</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($mesas as $m){
                                $estado = "DESHABILITADO";
                                $estilo_estado = "class=\"texto-deshabilitado\"";
                                if($m->mesa_estado == 1){
                                    $estado = "HABILITADO";
                                    $estilo_estado = "class=\"texto-habilitado\"";
                                }
                                ?>
                                <tr>
                                    <td>►</td>
                                    <td id="sucursalnombre<?= $m->id_sucursal;?>"><strong><?= $m->sucursal_nombre;?></strong></td>
                                    <td id="mesanombre<?= $m->id_mesa;?>"><?= $m->mesa_nombre;?></td>
                                    <td id="mesacapacidad<?php echo $m->id_mesa;?>"><?php echo $m->mesa_capacidad;?></td>
                                    <td <?=$estilo_estado;?> id="mesaestado<?= $m->id_mesa?>"><?= $estado;?></td>

                                    <td>
                                        <button data-toggle="modal" data-target="#editarDatosMesa" onclick="editar_mesa(<?= $m->id_mesa;?>,'<?= $m->id_negocio;?>','<?= $m->id_sucursal;?>','<?= $m->mesa_nombre;?>','<?= $m->mesa_capacidad;?>');actualizar_mesa_editar()" class="btn btn-sm btn-info btne" title='Editar'><i class='fa fa-edit text-white editar margen'></i></button>
                                        <button id="btn-eliminarmesa<?= $m->id_mesa;?>" class="btn btn-sm btn-secondary btn-danger" onclick="preguntar('¿Está seguro que desea eliminar esta mesa?','eliminar_mesa','Si','No',<?= $m->id_mesa;?>)"><i class='fa fa-trash text-white editar margen'></i></button>
                                    </td>
                                </tr>
                                <?php
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
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>mesa.js"></script>
