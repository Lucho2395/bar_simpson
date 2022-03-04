<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 24/10/2020
 * Time: 10:26
 */
?>
<!--Modal Gestion Roles-->
<div class="modal fade" id="gestionRol" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar/Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="col-form-label">Nombre del Rol</label>
                                <input class="form-control" type="hidden" id="id_rol"  maxlength="11" readonly>
                                <input class="form-control" type="text" id="rol_nombre" maxlength="20" placeholder="Ingrese Información...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="col-form-label">Descripción del Rol</label>
                                <input class="form-control" type="text" id="rol_descripcion" maxlength="100" placeholder="Ingrese Información...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="col-form-label">Estado</label>
                                <select id="rol_estado" class="form-control" onchange="cambiar_color_estado('rol_estado')">
                                    <option value="1" style="background-color: #17a673; color: white;" selected>HABILITADO</option>
                                    <option value="0" style="background-color: #e74a3b; color: white;">DESHABILITADO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                <button type="button" class="btn btn-success" id="btn-agregar-rol" onclick="gestionar_rol()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>
<!--Modal para gestionar accesos-->
<div class="modal fade" id="gestionAccesos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 80% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Gestión de Accesos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="accesos_gestionar">

            </div>
        </div>
    </div>
</div>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
                <button data-toggle="modal" data-target="#gestionRol" onclick="cambiar_texto_formulario('exampleModalLabel', 'Agregar Nuevo Rol'); agregacion_rol()" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Nuevo</button>
            </div>
            <!-- /.row (main row) -->
            <div class="row">
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Lista de Roles Registrados</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Descripcion</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
                                        <th>Opciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($roles as $m){
                                        $estado = "DESHABILITADO";
                                        $estilo_estado = "class=\"texto-deshabilitado\"";
                                        if($m->rol_estado == 1){
                                            $estado = "HABILITADO";
                                            $estilo_estado = "class=\"texto-habilitado\"";
                                        }
                                        ?>
                                        <tr>
                                            <td><?= $m->id_rol;?></td>
                                            <td id="rolnombre<?= $m->id_rol;?>"><?= $m->rol_nombre;?></td>
                                            <td id="roldescripcion<?= $m->id_rol;?>"><?= $m->rol_descripcion;?></td>
                                            <td <?= $estilo_estado;?> id="rolestado<?= $m->id_rol;?>"><?= $estado;?></td>
                                            <td id="botonrol<?= $m->id_rol;?>">
                                                <button class="btn btn-xs btn-warning btne" data-toggle="modal" data-target="#gestionRol" onclick="cambiar_texto_formulario('exampleModalLabel', 'Editar Rol'); edicion_rol(<?= $m->id_rol;?>, '<?= $m->rol_nombre;?>', '<?= $m->rol_descripcion;?>', <?= $m->rol_estado;?>)" >Editar</button>
                                            </td>
                                            <td>
                                                <button data-toggle="modal" data-target="#gestionAccesos" onclick="cargar_accesos(<?= $m->id_rol;?>)" class="btn btn-xs btn-success btne" >Ver Accesos</button>
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
</div>
<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>rol.js"></script>