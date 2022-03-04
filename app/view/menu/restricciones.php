<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 24/10/2020
 * Time: 0:05
 */
?>
<div class="modal-body">
    <div class="container-fluid">
        <!-- /.row (main row) -->
        <div class="row">
            <div class="col-lg-12">
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Roles con Restricción a Opción: <strong><?= $opcion->opcion_nombre;?></strong></h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead class="text-capitalize">
                                <tr>
                                    <th>ID</th>
                                    <th>Rol</th>
                                    <th>Descripción</th>
                                    <th>¿Con Acceso?</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($roles as $m){
                                    $permiso_vista = "CON ACCESO";
                                    $estilo_permiso = "class=\"texto-habilitado\"";

                                    $vista_habilitado = "no-show";
                                    $vista_deshabilitado = "";
                                    if($this->menu->buscar_restriccion_rol_opcion($m->id_rol, $opcion->id_opcion) === true){
                                        $permiso_vista = "SIN ACCESO";
                                        $estilo_permiso = "class=\"texto-deshabilitado\"";

                                        $vista_habilitado = "";
                                        $vista_deshabilitado = "no-show";
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $m->id_rol;?></td>
                                        <td><?= $m->rol_nombre;?></td>
                                        <td><?= $m->rol_descripcion;?></td>
                                        <td <?= $estilo_permiso;?> id="acceso<?= $m->id_rol;?>"><?= $permiso_vista;?></td>
                                        <td id="vista<?= $m->id_rol;?>">
                                            <button style='color: white;' id="btn-agregaracceso<?=$m->id_rol;?>" class="btn btn-sm btn-success <?= $vista_habilitado;?>" onclick="preguntar('¿Está seguro que desea permitir este acceso?','gestionar_acceso','Si','No',<?= $m->id_rol;?>,<?=$opcion->id_opcion;?>,1)">Permitir Acceso</button>
                                            <button style='color: white;' id="btn-eliminaracceso<?=$m->id_rol;?>" class="btn btn-sm btn-danger <?= $vista_deshabilitado;?>" onclick="preguntar('¿Está seguro que desea eliminar este acceso?','gestionar_acceso','Si','No',<?= $m->id_rol;?>,<?=$opcion->id_opcion;?>,0)">Eliminar Acceso</button>
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
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
</div>