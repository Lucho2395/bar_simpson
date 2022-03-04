<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 26/10/2020
 * Time: 17:08
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
                        <h6 class="m-0 font-weight-bold text-primary">Menús con Relación al Rol: <strong><?= $rol->rol_nombre;?></strong></h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead class="text-capitalize">
                                <tr>
                                    <th>ID</th>
                                    <th>Menú</th>
                                    <th>¿Con Acceso?</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($menus as $m){
                                    $permiso_vista = "SIN ACCESO";
                                    $estilo_permiso = "class=\"texto-deshabilitado\"";

                                    $vista_habilitado = "";
                                    $vista_deshabilitado = "no-show";
                                    if($this->menu->buscar_relacion_rol_menu($rol->id_rol, $m->id_menu) === true){
                                        $permiso_vista = "CON ACCESO";
                                        $estilo_permiso = "class=\"texto-habilitado\"";

                                        $vista_habilitado = "no-show";
                                        $vista_deshabilitado = "";
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $m->id_menu;?></td>
                                        <td><?= $m->menu_nombre;?></td>
                                        <td <?= $estilo_permiso;?> id="accesorol<?= $m->id_menu;?>"><?= $permiso_vista;?></td>
                                        <td id="vista<?= $m->id_rol;?>">
                                            <button style='color: white;' id="btn-agregaraccesorol<?=$m->id_menu;?>" class="btn btn-sm btn-success <?= $vista_habilitado;?>" onclick="preguntar('¿Está seguro que desea permitir este acceso?','gestionar_acceso_rol','Si','No',<?= $m->id_menu;?>,<?=$rol->id_rol;?>,1)">Permitir Acceso</button>
                                            <button style='color: white;' id="btn-eliminaraccesorol<?=$m->id_menu;?>" class="btn btn-sm btn-danger <?= $vista_deshabilitado;?>" onclick="preguntar('¿Está seguro que desea eliminar este acceso?','gestionar_acceso_rol','Si','No',<?= $m->id_menu;?>,<?=$rol->id_rol;?>,0)">Eliminar Acceso</button>
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