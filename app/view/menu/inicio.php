<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 19/10/2020
 * Time: 20:12
 */
?>
<!-- Modal Agregar Nuevo Menú-->
<div class="modal fade" id="gestionMenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <label class="col-form-label">Nombre del Menú</label>
                                <input class="form-control" type="hidden" id="id_menu" maxlength="11" readonly>
                                <input class="form-control" type="text" id="menu_nombre" maxlength="20" placeholder="Ingrese Información...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">Controlador</label>
                                <input class="form-control" type="text" id="menu_controlador" maxlength="20" placeholder="Ingrese Información...">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">Icono <a href="<?= _SERVER_;?>menu/iconos" target="_blank">(Iconos Aquí)</a></label>
                                <input class="form-control" type="text" id="menu_icono" maxlength="30" placeholder="Ingrese Información..." value="fa fa-">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">Orden de Aparación</label>
                                <input class="form-control" type="text" id="menu_orden" maxlength="11" onkeyup="validar_numeros(this.id)" placeholder="Ingrese Información...">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">¿Mostrar en Navegación?</label>
                                <select id="menu_mostrar" class="form-control" onchange="cambiar_color_estado('menu_mostrar')">
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
                                <select id="menu_estado" class="form-control" onchange="cambiar_color_estado('menu_estado')">
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
                <button type="button" class="btn btn-success" id="btn-agregar-menu" onclick="gestionar_menu()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
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
                <button data-toggle="modal" data-target="#gestionMenu" onclick="cambiar_texto_formulario('exampleModalLabel', 'Agregar Nuevo Menú'); agregacion_menu()" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Nuevo</button>
            </div>
            <!-- /.row (main row) -->
            <div class="row">
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Lista de Menús Registrados</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre Menu</th>
                                        <th>Código Icono</th>
                                        <th>Imagen Icono</th>
                                        <th>Controlador</th>
                                        <th>Orden de Aparación</th>
                                        <th>Estado</th>
                                        <th>Visibilidad</th>
                                        <th>Editar</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($menus as $m){
                                        //Estilos para mostrar el estado del menú de forma dinamica
                                        $estado = "DESHABILITADO";
                                        $estilo_estado = "class=\"texto-deshabilitado\"";
                                        if($m->menu_estado == 1){
                                            $estado = "HABILITADO";
                                            $estilo_estado = "class=\"texto-habilitado\"";
                                        }
                                        $mostrar = "NO";
                                        $estilo_mostrar = "class=\"texto-deshabilitado\"";
                                        if($m->menu_mostrar == 1){
                                            $mostrar = "SI";
                                            $estilo_mostrar = "class=\"texto-habilitado\"";
                                        }
                                        ?>
                                        <tr id="filamenu<?= $m->id_menu;?>">
                                            <td><?= $m->id_menu;?></td>
                                            <td id="menunombre<?= $m->id_menu;?>"><?= $m->menu_nombre;?></td>
                                            <td id="menuicono<?= $m->id_menu;?>"><?php echo $m->menu_icono;?></td>
                                            <td id="menuiconofigura<?= $m->id_menu;?>"><i class="<?= $m->menu_icono;?>"></i></td>
                                            <td id="menucontrolador<?= $m->id_menu;?>"><?= $m->menu_controlador;?></td>
                                            <td id="menuorden<?= $m->id_menu;?>"><?= $m->menu_orden?></td>
                                            <td <?= $estilo_estado;?> id="menuestado<?= $m->id_menu;?>"><?= $estado;?></td>
                                            <td <?= $estilo_mostrar;?> id="menumostrar<?= $m->id_menu;?>"><?= $mostrar;?></td>
                                            <td id="botonmenu<?= $m->id_menu;?>">
                                                <button data-toggle="modal" data-target="#gestionMenu" class="btn btn-sm btn-warning btne" onclick="cambiar_texto_formulario('exampleModalLabel', 'Editar Menú'); edicion_menu(<?= $m->id_menu;?>, '<?= $m->menu_nombre;?>', '<?= $m->menu_controlador;?>', '<?= $m->menu_icono;?>', <?= $m->menu_orden;?>, <?= $m->menu_mostrar;?>, <?= $m->menu_estado;?>)">Editar</button>
                                            </td>
                                            <td>
                                                <a type="button" class="btn btn-sm btn-primary btne" href="<?php echo _SERVER_ . 'Menu/roles/' . $m->id_menu;?>" >Ver Acceso de Roles</a>
                                                <a type="button" class="btn btn-sm btn-info btne" href="<?php echo _SERVER_ . 'Menu/opciones/' . $m->id_menu;?>" target="_blank">Ver Opciones</a>
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
<script src="<?php echo _SERVER_ . _JS_;?>menu.js"></script>