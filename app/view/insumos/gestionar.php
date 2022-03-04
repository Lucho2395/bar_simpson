


<div class="modal fade" id="recursos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Insumo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div id="categoria">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label">Nombre:</label>
                                    <input class="form-control" type="text" id="recurso_nombre" name="recurso_nombre" placeholder="Ingrese Nombre...">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label">Categoria: </label>
                                    <select class="form-control"  id= "id_categoria" name="id_categoria">
                                        <option value="">Seleccionar Categoria</option>
                                        <?php
                                        foreach($categoria as $n){
                                            ?>
                                            <option value="<?php echo $n->id_categoria;?>"><?php echo $n->categoria_nombre;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="btn-agregar-recursos" onclick="guardar_insumo()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editar_recursos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Insumo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div id="categoria">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label">Nombre:</label>
                                    <input class="form-control" type="text" id="recurso_nombre_e" name="recurso_nombre_e" placeholder="Ingrese Nombre...">
                                    <input class="form-control" type="hidden" id="id_recurso" name="id_recurso" placeholder="Ingrese Nombre...">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label">Categoria: </label>
                                    <select class="form-control"  id= "id_categoria_e" name="id_categoria_e">
                                        <option value="">Seleccionar Categoria</option>
                                        <?php
                                        foreach($categoria as $n){
                                            ?>
                                            <option value="<?php echo $n->id_categoria;?>"><?php echo $n->categoria_nombre;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="btn-agregar-recursos" onclick="editar_insumos()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
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
            </div>
            <!-- /.row (main row) -->
            <div class="row">
                <div class="col-lg-10"></div>
                <div class="col-lg-2">
                    <button data-toggle="modal" data-target="#recursos" class="btn btn-sm btn-primary shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Nuevo</button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h2> Insumos</h2></div>
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-earning" id="dataTable2" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>ID</th>
                                        <th>Categoria</th>
                                        <th>Recurso</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($listar_insumos as $ar){
                                        ?>
                                        <tr>
                                            <td><?= $a;?></td>
                                            <td><?= $ar->categoria_nombre;?></td>
                                            <td><?= $ar->recurso_nombre;?></td>
                                            <td>
                                                <button class="btn btn-success" data-toggle="modal" data-target="#editar_recursos" onclick="editar_insumo(<?= $ar->id_recurso;?>,'<?= $ar->id_categoria;?>','<?= $ar->recurso_nombre?>')"><i class="fa fa-edit"></i> Editar</button>
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
    <!-- End of Main Content -->
    <script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
    <script src="<?php echo _SERVER_ . _JS_;?>insumos.js"></script>
