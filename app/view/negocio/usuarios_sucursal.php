



<div class="modal fade" id="usuario_sucursal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Asignar Usuarios</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="usuariosucursal">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="persona">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="hidden" id="id_sucursal" name="id_sucursal" value="<?= $id;?>">
                                        <label class="col-form-label">USUARIO</label>
                                        <select class="form-control" id= "id_usuario" name="id_usuario">
                                            <option value="">Seleccionar Usuario</option>
                                            <?php
                                            foreach($usuario as $u){
                                                //$validaruser = $this->negocio->validarUserRol($id,$u->id_user);
                                                //if(!$validaruser){
                                                ?>
                                                <option value="<?php echo $u->id_usuario;?>"><?php echo $u->usuario_nickname;?></option>
                                                <?php
                                                //}
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">ROL</label>
                                        <select class="form-control" id= "id_rol" name="id_rol">
                                            <option value="">Seleccionar ROL</option>
                                            <?php
                                            foreach($rol as $r){
                                                ?>
                                                <option value="<?php echo $r->id_rol;?>"><?php echo $r->rol_nombre ;?></option>
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
                    <button type="button" class="btn btn-secondary" onclick="limpiar()" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-agregar-usuario"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
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
                <div class="col-lg-12" style="text-align: center;">
                    <h1><?php echo $sucursal->sucursal_nombre;?></h1>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-10"></div>
                <div class="col-lg-2">
                    <button data-toggle="modal" data-target="#usuario_sucursal" class="btn btn-sm btn-primary shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Usuario</button>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h2>Usuarios Registrados</h2></div>
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-earning" id="dataTable2" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>ID</th>
                                        <th>Usuario</th>
                                        <th>Rol</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($usuario_sucursal as $ar){
                                        $estilo = "";
                                        if($ar->usuario_sucursal_estado == "0"){
                                            $estilo = "style=\"background-color: #FF6B70\"";
                                        }
                                        ?>
                                        <tr <?= $estilo;?>>
                                            <td><?= $a;?></td>
                                            <td><?= $ar->persona_nombre;?></td>
                                            <td><?= $ar->rol_nombre;?></td>
                                            <td>
                                                <?php
                                                if ($ar->usuario_sucursal_estado == 0) {
                                                    ?>
                                                    <a class="btn btn-danger" onclick="preguntar('¿Esta seguro que quiere Habilitar este Usuario?','habilitar_usuario_sucursal','Si','No',<?= $ar->id_usuario_sucursal ?>,1)" title='Cambiar Estado'><i class='fa fa-check text-white editar margen'></i></a>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <a class="btn btn-danger" onclick="preguntar('¿Esta seguro que quiere Deshabilitar este Usuario?','deshabilitar_usuario_sucursal','Si','No',<?= $ar->id_usuario_sucursal ?>,0)" title='Cambiar Estado'><i class='fa fa-trash text-white editar margen'></i></a>
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
<script src="<?php echo _SERVER_ . _JS_;?>sucursal.js"></script>