<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 23/10/2020
 * Time: 9:58
 */
?>
<div class="modal-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <h5>Permisos de la Opción: <strong><?= $opcion->opcion_nombre;?></strong></h5>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label class="col-form-label">Nombre de la Opción: </label>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <input class="form-control" type="hidden" id="id_permiso_opcion" value="<?= $opcion->id_opcion;?>" maxlength="11" readonly>
                    <input class="form-control" type="text" id="permiso_accion" maxlength="30" placeholder="Ingrese Información...">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <button type="button" style="width: 100%" class="btn btn-success" id="btn-agregar-permiso" onclick="agregar_permiso()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                                <thead class="text-capitalize">
                                <tr>
                                    <th>ID</th>
                                    <th>Permiso</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($permisos as $m){
                                    $permiso_vista = "DESHABILITADO";
                                    $estilo_permiso = "class=\"texto-deshabilitado\"";

                                    $vista_habilitado = "";
                                    $vista_deshabilitado = "no-show";
                                    if($m->permiso_estado == 1){
                                        $permiso_vista = "HABILITADO";
                                        $estilo_permiso = "class=\"texto-habilitado\"";

                                        $vista_habilitado = "no-show";
                                        $vista_deshabilitado = "";
                                    }
                                    ?>
                                    <tr id="permiso<?= $m->id_permiso;?>">
                                        <td><?= $m->id_permiso;?></td>
                                        <td><?= $m->permiso_accion;?></td>
                                        <td <?= $estilo_permiso;?> id="acceso<?= $m->id_permiso;?>"><?= $permiso_vista;?></td>
                                        <td id="vista<?= $m->id_permiso;?>">
                                            <!--<button id="btn-agregarrelacion<?=$m->id_permiso;?>" class="btn btn-sm btn-success <?= $vista_habilitado;?>" onclick="preguntar('¿Está seguro que desea habilitar este permiso?','edicion_permiso','Si','No',<?= $m->id_permiso;?>)">Permitir Acceso</button>-->
                                            <button id="btn-eliminarrelacion<?= $m->id_permiso;?>" class="btn btn-sm btn-danger <?= $vista_deshabilitado;?>" onclick="preguntar('¿Está seguro que desea eliminar este permiso?','eliminar_permiso','Si','No',<?= $m->id_permiso;?>)">Eliminar Permiso</button>
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