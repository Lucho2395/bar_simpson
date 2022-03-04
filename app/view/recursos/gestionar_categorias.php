
<div class="modal fade" id="categoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Asignar Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="gestionarcategoria">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="categoria">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Negocio</label>
                                        <select class="form-control" id= "id_negocio" name="id_negocio">
                                            <option value="">Seleccionar Negocio</option>
                                            <?php
                                            foreach($negocio as $n){
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
                                        <label class="col-form-label">Categoria</label>
                                        <input class="form-control" type="text" id="categoria_nombre" name="categoria_nombre" maxlength="100" placeholder="Ingrese Categoria...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Tipo</label>
                                        <select class="form-control" name="categoria_tipo" id="categoria_tipo">
                                            <option value="">Seleccione...</option>
                                            <option value="1">Restara Stock</option>
                                            <option value="2">No restara stock</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="limpiar()" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-agregar-categoria"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Editar Categorias-->
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

            </div>
            <!-- /.row (main row) -->
            <div class="row">
                <div class="col-lg-10"></div>
                <div class="col-lg-2">
                    <button data-toggle="modal" data-target="#categoria" class="btn btn-sm btn-primary shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Nuevo</button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h2> Categorias Asignadas</h2></div>
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-earning" id="dataTable2" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>ID</th>
                                        <th>Negocio</th>
                                        <th>Categoria</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($nego_cate as $ar){
                                        $estilo = "";
                                        if($ar->negocio_estado == "0"){
                                            $estilo = "style=\"background-color: #FF6B70\"";
                                        }
                                        ?>
                                        <tr <?= $estilo;?>>
                                            <td><?= $a;?></td>
                                            <td><?= $ar->negocio_nombre;?></td>
                                            <td><?= $ar->categoria_nombre;?></td>
                                            <td>
                                                <?php
                                                if ($ar->recurso_categoria_estado == 0) {
                                                    ?>
                                                    <button class="btn btn-success" onclick="preguntar('¿Esta seguro que quiere habilitar esta categoria?','habilitar_categoria','Si','No',<?= $ar->id_categoria_negocio ?>,1)" title='Cambiar Estado'><i class='fa fa-check text-white editar margen'></i></button>

                                                    <?php
                                                }else{
                                                    ?>
                                                    <button class="btn btn-danger" onclick="preguntar('¿Esta seguro que quiere deshabilitar esta categoria?','deshabilitar_categoria','Si','No',<?= $ar->id_categoria_negocio ?>,0)" title='Cambiar Estado'><i class='fa fa-trash text-white editar margen'></i></button>
                                                    <button data-toggle="modal"  data-target="#editar_categoria" onclick="editar_categoria(<?= $ar->id_categoria;?>,'<?= $ar->categoria_nombre;?>')" class="btn btn-success"><i class="fa fa-pencil"></i></button>

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
    </div>
</div>
<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>recursos.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>categorias.js"></script>
