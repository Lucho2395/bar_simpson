<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 22/10/2020
 * Time: 17:53
 */
?>
<!-- Modal Gestión Opciones-->
<div class="modal fade" id="gestionOpciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <label class="col-form-label">Nombre de la Opción</label>
                                <input class="form-control" type="hidden" id="id_menu" value="<?= $_GET['id'];?>"  maxlength="11" readonly>
                                <input class="form-control" type="hidden" id="id_opcion"  maxlength="11" readonly>
                                <input class="form-control" type="text" id="opcion_nombre" maxlength="30" placeholder="Ingrese Información...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="col-form-label">Nombre de la Función</label>
                                <input class="form-control" type="text" id="opcion_funcion" maxlength="35" placeholder="Ingrese Información...">
                            </div>
                        </div>
                        <div class="col-lg-6" style="display: none;">
                            <div class="form-group">
                                <label class="col-form-label">Icono <a href="<?= _SERVER_;?>menu/iconos" target="_blank">(Iconos Aquí)</a></label>
                                <input class="form-control" type="text" id="opcion_icono" maxlength="30" placeholder="Ingrese Información..." value="fa fa-">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">Orden de Aparación</label>
                                <input class="form-control" type="text" id="opcion_orden" maxlength="11" onkeyup="validar_numeros(this.id)" placeholder="Ingrese Información...">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">¿Mostrar en Navegación?</label>
                                <select id="opcion_mostrar" class="form-control" onchange="cambiar_color_estado('opcion_mostrar')">
                                    <option value="1" style="background-color: #17a673; color: white;" selected>SI</option>
                                    <option value="0" style="background-color: #e74a3b; color: white;">NO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="col-form-label">Estado</label>
                                <select id="opcion_estado" class="form-control" onchange="cambiar_color_estado('opcion_estado')">
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
                <button type="button" class="btn btn-success" id="btn-agregar-opcion" onclick="gestionar_opcion()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>
<!--Modal para gestionar permisos-->
<div class="modal fade" id="gestionPermisos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 80% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Gestión de Permisos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="permiso_gestionar">

            </div>
        </div>
    </div>
</div>
<!--Modal para gestionar restricciones-->
<div class="modal fade" id="gestionRestricciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 80% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Gestión de Restricciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="restricciones_gestionar">

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
                <button data-toggle="modal" data-target="#gestionOpciones" onclick="cambiar_texto_formulario('exampleModalLabel', 'Agregar Nueva Opción'); agregacion_opcion()" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Nuevo</button>
            </div>
            <!-- /.row (main row) -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5>Roles con Acceso a Menú: <strong><?= $menu->menu_nombre;?></strong></h5>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Opciones del Menú: <?= $menu->menu_nombre;?></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>Orden</th>
                                        <th>ID Interno</th>
                                        <th>Nombre</th>
                                        <th>Función</th>
                                        <th>¿Mostrar en Opciones?</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
                                        <th>Opciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($opciones as $m){
                                        $estado = "DESHABILITADO";
                                        $estilo_estado = "class=\"texto-deshabilitado\"";
                                        if($m->opcion_estado == 1){
                                            $estado = "HABILITADO";
                                            $estilo_estado = "class=\"texto-habilitado\"";
                                        }
                                        $mostrar = "NO";
                                        $estilo_mostrar = "class=\"texto-deshabilitado\"";
                                        if($m->opcion_mostrar == 1){
                                            $mostrar = "SI";
                                            $estilo_mostrar = "class=\"texto-habilitado\"";
                                        }
                                        ?>
                                        <tr>
                                            <td id="opcionorden<?= $m->id_opcion;?>"><?= $m->opcion_orden;?></td>
                                            <td><?= $m->id_opcion;?></td>
                                            <td id="opcionnombre<?= $m->id_opcion;?>"><?= $m->opcion_nombre;?></td>
                                            <td id="opcionfuncion<?= $m->id_opcion;?>"><?= $m->opcion_funcion;?></td>
                                            <td id="opcionmostrar<?=$m->id_opcion;?>" <?= $estilo_mostrar;?>><?= $mostrar;?></td>
                                            <td id="opcionestado<?=$m->id_opcion;?>" <?= $estilo_estado;?>><?= $estado;?></td>
                                            <td id="botonopcion<?=$m->id_opcion;?>">
                                                <button data-toggle="modal" data-target="#gestionOpciones" class="btn btn-xs btn-warning btne" onclick="cambiar_texto_formulario('exampleModalLabel', 'Editar Opción'); edicion_opcion(<?= $m->id_opcion;?>, '<?= $m->opcion_nombre;?>', '<?= $m->opcion_funcion;?>', '<?= $m->opcion_icono;?>', <?= $m->opcion_orden;?>, <?= $m->opcion_mostrar;?>, <?= $m->opcion_estado;?>)" >Editar</button>
                                            </td>
                                            <td>
                                                <button data-toggle="modal" data-target="#gestionPermisos" onclick="cargar_permisos(<?= $m->id_opcion;?>)" class="btn btn-xs btn-success btne">Ver Permisos</button>
                                                <button data-toggle="modal" data-target="#gestionRestricciones" onclick="cargar_restricciones(<?= $m->id_opcion;?>)"  class="btn btn-xs btn-warning btne">Ver Restricciones</button>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table><br>
                                <a href="<?php echo _SERVER_ . 'Menu'?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-history fa-sm text-white-50"></i> Volver Al Menú Anterior</a>
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
<script src="<?php echo _SERVER_ . _JS_;?>menu.js"></script>