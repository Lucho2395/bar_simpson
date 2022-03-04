<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 20/10/2020
 * Time: 16:50
 */
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
        <a href="<?php echo _SERVER_ . 'menu'?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-history fa-sm text-white-50"></i>  Volver Al Menú Anterior</a>
    </div>
    <!-- Content Row -->
    <!-- Main row -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5>Roles con Acceso a Menú: <strong><?= $menu->menu_nombre;?></strong></h5>
                </div>
            </div>
        </div>
        <!--<div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <input class="form-control" type="password" id="password"  placeholder="Ingrese su Contraseña AQUÍ para Permitir Cambios...">
                </div>
            </div>
        </div>-->
    </div>
    <br>
    <!-- /.row (main row) -->
    <div class="row">
        <div class="col-lg-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Roles con Acceso a Menú: <strong><?= $menu->menu_nombre;?></strong></h6>
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
                                $permiso_vista = "SIN ACCESO";
                                $estilo_permiso = "class=\"texto-deshabilitado\"";

                                $vista_habilitado = "";
                                $vista_deshabilitado = "no-show";
                                if($this->menu->buscar_relacion_rol_menu($m->id_rol, $menu->id_menu) === true){
                                    $permiso_vista = "CON ACCESO";
                                    $estilo_permiso = "class=\"texto-habilitado\"";

                                    $vista_habilitado = "no-show";
                                    $vista_deshabilitado = "";
                                }
                                ?>
                                <tr>
                                    <td><?= $m->id_rol;?></td>
                                    <td><?= $m->rol_nombre;?></td>
                                    <td><?= $m->rol_descripcion;?></td>
                                    <td <?= $estilo_permiso;?> id="acceso<?= $m->id_rol;?>"><?= $permiso_vista;?></td>
                                    <td id="vista<?= $m->id_rol;?>">
                                        <a type="button" style='color: white;' id="btn-agregarrelacion<?=$m->id_rol;?>" class="btn btn-sm btn-success <?= $vista_habilitado;?>" onclick="preguntar('¿Está seguro que desea permitir este acceso?','gestionar_relacion','Si','No',<?= $m->id_rol;?>,<?=$menu->id_menu;?>,1)">Permitir Acceso</a>
                                        <a type="button" style='color: white;' id="btn-eliminarrelacion<?=$m->id_rol;?>" class="btn btn-sm btn-danger <?= $vista_deshabilitado;?>" onclick="preguntar('¿Está seguro que desea eliminar este acceso?','gestionar_relacion','Si','No',<?= $m->id_rol;?>,<?=$menu->id_menu;?>,0)">Eliminar Acceso</a>
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
<script src="<?php echo _SERVER_ . _JS_;?>menu.js"></script>