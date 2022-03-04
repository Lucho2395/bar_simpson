<div class="modal fade" id="sucursal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Sucursal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="gestionarsucursal">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="persona">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre Sucursal</label>
                                        <input type="hidden" id="id_negocio" name="id_negocio" value="<?= $id; ?>">
                                        <input class="form-control" type="text" id="sucursal_nombre" onkeyup="" name="sucursal_nombre" maxlength="200" placeholder="Ingrese Nombre...">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Dirección</label>
                                        <textarea rows="3" class="form-control" type="text" id="sucursal_direccion" name="sucursal_direccion" maxlength="200" placeholder="Ingrese Dirección..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Ciudad</label>
                                        <select class="form-control" id= "id_ciudad" name="id_ciudad">
                                            <option value="">Elegir ciudad</option>
                                            <?php
                                            foreach($listaciudad as $l){
                                                ?>
                                                <option value="<?php echo $l->id_ciudad;?>"><?php echo $l->ciudad_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">RUC</label>
                                        <input class="form-control" type="text" id="sucursal_ruc" onkeyup="return validar_numeros(this.id)" name="sucursal_ruc" maxlength="30" placeholder="Ingrese RUC...">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Número de Teléfono</label>
                                        <input class="form-control" type="text" id="sucursal_telefono" onkeyup="return validar_numeros(this.id)" name="sucursal_telefono" maxlength="30" placeholder="Ingrese Telefono...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Foto</label>
                                        <input class="form-control" type="file" id="sucursal_foto" name="sucursal_foto" placeholder="Ingrese Foto...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="limpiar()" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-agregar-sucursal"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="sucursal_editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Sucursal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="editarsucursal">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="persona">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre Sucursal</label>
                                        <input type="hidden" id="id_negocio_e" name="id_negocio_e" value="">
                                        <input type="hidden" id="id_sucursal" name="id_sucursal" value="">
                                        <input class="form-control" type="text" id="sucursal_nombre_e" onkeyup="" name="sucursal_nombre_e" maxlength="200" placeholder="Ingrese Nombre...">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Dirección</label>
                                        <textarea rows="3" class="form-control" type="text" id="sucursal_direccion_e" name="sucursal_direccion_e" maxlength="200" placeholder="Ingrese Dirección..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Ciudad</label>
                                        <select class="form-control" id= "id_ciudad_e" name="id_ciudad_e">
                                            <option value="">Elegir ciudad</option>
                                            <?php
                                            foreach($listaciudad as $l){
                                                ?>
                                                <option value="<?php echo $l->id_ciudad;?>"><?php echo $l->ciudad_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">RUC</label>
                                        <input class="form-control" type="text" id="sucursal_ruc_e" onkeyup="return validar_numeros(this.id)" name="sucursal_ruc_e" maxlength="30" placeholder="Ingrese RUC...">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Número de Teléfono</label>
                                        <input class="form-control" type="text" id="sucursal_telefono_e" onkeyup="return validar_numeros(this.id)" name="sucursal_telefono_e" maxlength="30" placeholder="Ingrese Telefono...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Foto</label>
                                        <input class="form-control" type="file" id="sucursal_foto_e" name="sucursal_foto_e" placeholder="Ingrese Foto...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="limpiar()" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-editar-sucursal"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
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
                    <button data-toggle="modal" data-target="#sucursal" class="btn btn-sm btn-primary shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Sucursal</button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h2>Sucursales Registradas</h2></div>
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
                                        <th>Ciudad</th>
                                        <th>Dirección</th>
                                        <th>RUC</th>
                                        <th>Teléfono</th>
                                        <th>Foto</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($sucursal as $ar){
                                        $estilo = "";
                                        $foto = _SERVER_ . 'media/sucursal/default.png';
                                        if($ar->sucursal_foto != ""){
                                            if(file_exists($ar->sucursal_foto)){
                                                $foto = _SERVER_ . $ar->sucursal_foto;
                                            }
                                        }
                                        if($ar->sucursal_estado == "0"){
                                            $estilo = "style=\"background-color: #FF6B70\"";
                                        }
                                        ?>
                                        <tr <?= $estilo;?>>
                                            <td><?= $a;?></td>
                                            <td><?= $ar->sucursal_nombre;?></td>
                                            <td><?= $ar->ciudad_nombre;?></td>
                                            <td><?= $ar->sucursal_direccion;?></td>
                                            <td><?= $ar->sucursal_ruc;?></td>
                                            <td><?= $ar->sucursal_telefono;?></td>
                                            <td><img class="rounded" src="<?= $foto;?>" alt="Foto de <?php echo $ar->sucursal_nombre;?>" width="60"></td>
                                            <td>
                                                <a class="btn btn-success" onclick="editar_sucursal(<?= $ar->id_sucursal?>,'<?= $ar->id_ciudad?>','<?= $ar->id_negocio?>','<?= $ar->sucursal_nombre?>','<?= $ar->sucursal_direccion?>','<?= $ar->sucursal_ruc?>','<?= $ar->sucursal_foto?>','<?= $ar->sucursal_telefono?>')" data-target="#sucursal_editar" data-toggle="modal" title='Editar'><i class='fa fa-edit text-white editar margen'></i></a>
                                                <a class="btn btn-warning" href="<?php echo _SERVER_ . 'Negocio/usuarios_sucursal/' . $ar->id_sucursal;?>" title='Asignar Usuarios'><i class='fa fa-user text-white editar margen'></i></a>
                                                <?php
                                                if ($ar->sucursal_estado == 0) {
                                                    ?>
                                                    <a class="btn btn-danger" onclick="preguntar('¿Esta seguro que quiere Habilitar esta sucursal?','habilitar','Si','No',<?= $ar->id_sucursal ?>,1)" title='Cambiar Estado'><i class='fa fa-check text-white editar margen'></i></a>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <a class="btn btn-danger" onclick="preguntar('¿Esta seguro que quiere Deshabilitar esta sucursal?','deshabilitar','Si','No',<?= $ar->id_sucursal ?>,0)" title='Cambiar Estado'><i class='fa fa-trash text-white editar margen'></i></a>
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
<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>sucursal.js"></script>
