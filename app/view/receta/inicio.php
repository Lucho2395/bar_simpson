<?php
/**
 * Created by PhpStorm
 * User: Franz
 * Date: 15/03/2021
 * Time: 13:41
 */
?>
<!-- Modal Agregar Receta-->
<div class="modal fade" id="gestionReceta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar/Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="gestionarInfoReceta">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="receta">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Título de la Receta: </label>
                                        <input class="form-control" type="text" id="receta_nombre" name="receta_nombre" maxlength="200" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Estado: </label>
                                        <select id="receta_estado" name="receta_estado" class="form-control" onchange="cambiar_color_estado('receta_estado')">
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
                    <button type="submit" class="btn btn-success" id="btn-agregar-usuario"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Receta-->
<div class="modal fade" id="editarDatosReceta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Editar Receta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="editarInformacionReceta">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="receta">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Título de la Receta: </label>
                                        <input class="form-control" type="hidden" id="id_receta" name="id_receta" maxlength="11" readonly>
                                        <input class="form-control" type="text" id="receta_nombre_e" name="receta_nombre_e" maxlength="200" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-editar-receta"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
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
                <button data-toggle="modal" data-target="#gestionReceta" onclick="cambiar_texto_formulario('exampleModalLabel', 'Agregar Nueva Receta'); agregacion_receta()" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Nuevo</button>
            </div>
            <!-- /.row (main row) -->
            <div class="row">
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h4 class="m-0 font-weight-bold text-primary">Lista de Recetas Registradas</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-earning" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>ID</th>
                                        <th>Receta</th>
                                        <th>Ver</th>
                                        <th>Total</th>
                                        <th>Usuario</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Accion</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($recetas as $m){
                                        $estado = "DESHABILITADO";
                                        $estilo_estado = "class=\"texto-deshabilitado\"";
                                        if($m->receta_estado == 1){
                                            $estado = "HABILITADO";
                                            $estilo_estado = "class=\"texto-habilitado\"";
                                        }
                                        $suma = $this->receta->suma_sub_receta($m->id_receta);
                                        $listar_total = $this->receta->monto_total_receta($m->id_receta);
                                        $total_todo = $suma->total + $listar_total->total;

                                        //if(empty($m->receta_fecha)){
                                            //$cita = "--";
                                        //}else{
                                          //  $cita = "$m->receta_fecha";
                                        //}

                                        ?>
                                        <tr>
                                            <td><?= $a;?></td>
                                            <td id="recetanombre<?= $m->id_receta;?>"><strong><?= $m->receta_nombre;?></strong></td>
                                            <td>
                                                <a class="btn btn-primary" href="<?php echo _SERVER_ . 'Receta/detalle_receta/' . $m->id_receta;?>" data-toggle="tooltip" title='Ver/Agregar Detalle Receta'><i class="fa fa-eye"></i></a>
                                            </td>
                                            <td><?= $total_todo;?></td>
                                            <td id="usuarionickname<?= $m->id_receta;?>"><?= $m->usuario_nickname;?></td>
                                            <td><?= date('d-m-Y h:i a', strtotime($m->receta_fecha));?></td>
                                            <td <?=$estilo_estado;?> id="recetaestado<?= $m->id_receta?>"><?= $estado;?></td>
                                            <td>
                                                <div id="botonreceta<?= $m->id_receta;?>">
                                                    <button data-toggle="modal"  data-target="#editarDatosReceta" onclick="editar_receta(<?= $m->id_receta;?>,'<?= $m->id_usuario;?>','<?= $m->receta_nombre;?>','<?= $m->receta_estado;?>')" class="btn btn-sm btn-info btne" ><i class="fa fa-pencil"></i></button>
                                                </div>
                                                <?php
                                                $validar_contenido = $this->receta->validar_contenido($m->id_receta);
                                                if(empty($validar_contenido)){
                                                    ?>
                                                    <button id="btn-eliminarreceta<?= $m->id_receta;?>" class="btn btn-sm btn-secondary btn-danger" onclick="preguntar('¿Está seguro que desea eliminar esta receta?','eliminar_receta','Si','No',<?= $m->id_receta;?>)"><i class="fa fa-trash"></i></button>
                                                <?php
                                                }
                                                ?>
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
        <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
    <script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
    <script src="<?php echo _SERVER_ . _JS_;?>receta.js"></script>

