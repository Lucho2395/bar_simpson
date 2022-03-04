<?php
/**
 * Created by PhpStorm
 * User: Franz
 * Date: 12/03/2021
 * Time: 12:24
 */
?>
<!-- Modal Agregar Mesa-->
<div class="modal fade" id="agregarcategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="gestionar_categoria">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="mesa">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre Categoria: </label>
                                        <input class="form-control" type="text" id="categoria_nombre" name="categoria_nombre" maxlength="100" placeholder="Ingrese Categoria...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btn-agregar-categoria"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Editar Mesa-->
<div class="modal fade" id="editar_categoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Editar Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="editarcategoria">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="mesa">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre Categoria: </label>
                                        <input type="hidden" id="id_categoria" name="id_categoria">
                                        <input class="form-control" type="text" id="categoria_nombre_e" name="categoria_nombre_e" maxlength="100" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btn-editar-categoria"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
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
                <button data-toggle="modal" data-target="#agregarcategoria" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Nuevo</button>
            </div>
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
                                        <th>Categoria</th>
                                        <th>Fecha de Registro</th>
                                        <th>Estado</th>
                                        <th>Accion</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($categorias as $m){
                                        $estado = "DESHABILITADO";
                                        $estilo_estado = "class=\"texto-deshabilitado\"";
                                        if($m->categoria_estado == 1){
                                            $estado = "HABILITADO";
                                            $estilo_estado = "class=\"texto-habilitado\"";
                                        }
                                        ?>
                                        <tr>
                                            <td><?= $a;?></td>
                                            <td><strong><?= $m->categoria_nombre;?></strong></td>
                                            <td><?= date('d-m-Y', strtotime($m->categoria_fecha_registro))?></td>
                                            <td <?=$estilo_estado;?> id="mesaestado<?= $m->id_categoria?>"><?= $estado;?></td>
                                            <td>
                                                <?php
                                                if ($m->categoria_estado == 0) {
                                                ?>
                                                <button id="btn-eliminarcategoria<?= $m->id_categoria;?>" class="btn btn-sm btn-secondary btn-success" onclick="preguntar('¿Está seguro que desea habilitar esta categoria?','eliminar_categoria','Si','No',<?= $m->id_categoria;?>,1)"><i class="fa fa-check"></i></button>
                                                    <?php
                                                }else{
                                                ?>
                                                <div id="botoncategoria<?= $m->id_categoria;?>">
                                                    <button data-toggle="modal"  data-target="#editar_categoria" onclick="editar_categoria(<?= $m->id_categoria;?>,'<?= $m->categoria_nombre;?>')" class="btn btn-sm btn-info btne"><i class="fa fa-pencil"></i></button>
                                                </div>
                                                <button id="btn-eliminarcategoria<?= $m->id_categoria;?>" class="btn btn-sm btn-secondary btn-danger" onclick="preguntar('¿Está seguro que desea deshabilitar esta categoria?','eliminar_categoria','Si','No',<?= $m->id_categoria;?>,0)"><i class="fa fa-trash"></i></button>
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
    <script src="<?php echo _SERVER_ . _JS_;?>categorias.js"></script>
