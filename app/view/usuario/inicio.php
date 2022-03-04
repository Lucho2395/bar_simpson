<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 26/10/2020
 * Time: 23:24
 */
?>
<!-- Modal Agregar Usuario-->
<div class="modal fade" id="gestionUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar/Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="gestionarInfoUsuario">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="persona">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre Persona</label>
                                        <input class="form-control" type="text" id="persona_nombre" name="persona_nombre" maxlength="20" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Apellido Paterno</label>
                                        <input class="form-control" type="text" id="persona_apellido_paterno" name="persona_apellido_paterno" maxlength="30" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Apellido Materno</label>
                                        <input class="form-control" type="text" id="persona_apellido_materno" name="persona_apellido_materno" maxlength="30" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="display: none;">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Fecha de Nacimiento</label>
                                        <input class="form-control" type="date" id="persona_nacimiento" name="persona_nacimiento" maxlength="30" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Número de Teléfono</label>
                                        <input class="form-control" type="text" id="persona_telefono" onkeyup="return validar_numeros(this.id)" name="persona_telefono" maxlength="30" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="usuario">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Usuario</label>
                                        <input class="form-control" type="text" id="usuario_nickname" name="usuario_nickname" maxlength="16" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Contraseña</label>
                                        <input class="form-control" type="password" id="usuario_contrasenha" name="usuario_contrasenha" maxlength="30" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Repita Contraseña</label>
                                        <input class="form-control" type="password" id="usuario_contrasenha2" name="usuario_contrasenha2" maxlength="30" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Email</label>
                                        <input class="form-control" type="text" id="usuario_email" name="usuario_email" maxlength="40" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Foto</label>
                                        <input class="form-control" type="file" id="usuario_imagen" name="usuario_imagen" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Rol</label>
                                        <select id="id_rol" name="id_rol" class="form-control">
                                            <?php
                                            foreach ($roles as $r){
                                                ?>
                                                <option value="<?= $r->id_rol;?>"><?= $r->rol_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Estado</label>
                                        <select id="usuario_estado" name="usuario_estado" class="form-control" onchange="cambiar_color_estado('usuario_estado')">
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
<!-- Modal Editar Usuario-->
<div class="modal fade" id="editarDatosUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Editar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="editarInformacionUsuario">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="usuario">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Usuario</label>
                                        <input class="form-control" type="hidden" id="id_usuario" name="id_usuario" maxlength="11" readonly>
                                        <input class="form-control" type="text" id="usuario_nickname_e" name="usuario_nickname_e" maxlength="16" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Email</label>
                                        <input class="form-control" type="text" id="usuario_email_e" name="usuario_email_e" maxlength="40" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Foto</label>
                                        <input class="form-control" type="file" id="usuario_imagen_e" name="usuario_imagen_e" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Rol</label>
                                        <select id="id_rol_e" name="id_rol_e" class="form-control">
                                            <?php
                                            foreach ($roles as $r){
                                                ?>
                                                <option value="<?= $r->id_rol;?>"><?= $r->rol_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Estado</label>
                                        <select id="usuario_estado_e" name="usuario_estado_e" class="form-control" onchange="cambiar_color_estado('usuario_estado_e')">
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
                    <button type="submit" class="btn btn-success" id="btn-editar-usuario"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Editar Persona-->
<div class="modal fade" id="editarPersona" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Datos Persona</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="gestionarInfoPersona">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="persona">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre Persona</label>
                                        <input class="form-control" type="hidden" id="id_persona" name="id_persona" maxlength="20" placeholder="Ingrese Información...">
                                        <input class="form-control" type="text" id="persona_nombre_e" name="persona_nombre_e" maxlength="20" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Apellido Paterno</label>
                                        <input class="form-control" type="text" id="persona_apellido_paterno_e" name="persona_apellido_paterno_e" maxlength="30" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Apellido Materno</label>
                                        <input class="form-control" type="text" id="persona_apellido_materno_e" name="persona_apellido_materno_e" maxlength="30" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Fecha de Nacimiento</label>
                                        <input class="form-control" type="date" id="persona_nacimiento_e" name="persona_nacimiento_e" maxlength="30" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Número de Teléfono</label>
                                        <input class="form-control" type="text" id="persona_telefono_e" onkeyup="return validar_numeros(this.id)" name="persona_telefono_e" maxlength="30" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-editar_persona"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Restablecer Contraseña-->
<div class="modal fade" id="restablecerContra" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Restablecer Contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div id="persona">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label" id="nickname_persona">Nombre Persona</label>
                                    <input class="form-control" type="hidden" id="id_usuario_contra" maxlength="20" readonly placeholder="Ingrese Información...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Nueva Contraseña</label>
                                    <input class="form-control" type="password" id="contra1" maxlength="16" placeholder="Ingrese Información...">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Repetir Contraseña</label>
                                    <input class="form-control" type="password" id="contra2"  maxlength="16" placeholder="Ingrese Información...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                <button type="button" class="btn btn-success" id="btn-editar-contra" onclick="generar_nueva_contrasenha()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="areas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 40% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gestionar Áreas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">Nombre del Área:</label>
                                <input class="form-control" type="text" id="departamento_nombre" name="departamento_nombre" maxlength="50" placeholder="Ingrese Área...">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" style="margin-top: 38px">
                                <button class="btn btn-success" onclick="guardar_departamento()" ><i class="fa fa-save"></i> Guardar</button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h4>Listado de Áreas</h4></div>
                        <div class="col-lg-12">
                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="text-capitalize">
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre del Área</th>
                                                <th>Acción</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $a = 1;
                                            foreach ($departamento as $m){
                                                ?>
                                                <tr>
                                                    <td><?= $a;?></td>
                                                    <td><?= $m->departamento_nombre;?></td>
                                                    <td>
                                                        <a onclick="preguntar('¿Esta Seguro que desea Eliminar esta Área?','eliminar_depa','SÍ','NO',<?= $m->id_departamento?>)" style="color: red" data-toggle='tooltip' title='Eliminar'><i class='fa fa-times eliminar margen'></i></a>
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
    </div>
</div>

<div class="modal fade" id="cargos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 40% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gestionar Cargos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">Nombre del Cargo:</label>
                                <input class="form-control" type="text" id="cargo_nombre" name="cargo_nombre" maxlength="50" placeholder="Ingrese Cargo...">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" style="margin-top: 38px">
                                <button class="btn btn-success" onclick="guardar_cargo()" ><i class="fa fa-save"></i> Guardar</button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h4>Listado de Cargos</h4></div>
                        <div class="col-lg-12">
                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="text-capitalize">
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre del Cargo</th>
                                                <th>Acción</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $a = 1;
                                            foreach ($cargo as $m){
                                                ?>
                                                <tr>
                                                    <td><?= $a;?></td>
                                                    <td><?= $m->cargo_nombre;?></td>
                                                    <td>
                                                        <a onclick="preguntar('¿Esta Seguro que desea Eliminar este Cargo?','eliminar_cargo','SÍ','NO',<?= $m->id_cargo?>)" style="color: red" data-toggle='tooltip' title='Eliminar'><i class='fa fa-times eliminar margen'></i></a>
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
    </div>
</div>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
                <button data-toggle="modal" data-target="#gestionUsuario" onclick="cambiar_texto_formulario('exampleModalLabel', 'Agregar Nuevo Usuario'); agregacion_usuario()" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Nuevo</button>
                <button data-toggle="modal" data-target="#areas" class="btn btn-success">Gestionar Áreas</button>
                <button data-toggle="modal" data-target="#cargos" class="btn btn-success">Gestionar Cargos</button>
            </div>
            <!-- /.row (main row) -->
            <div class="row">
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Lista de Usuarios Registrados</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>ID</th>
                                        <th>Usuario</th>
                                        <th>Rol</th>
                                        <th>Estado</th>
                                        <th>Correo</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Último Inicio Sesión</th>
                                        <!--<th>DNI</th>-->
                                        <!--<th>Fecha Nacimiento</th>-->
                                        <!--<th>N° Celular</th>-->
                                        <th>Editar</th>
                                        <th>Opciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($usuarios as $m){
                                        $estado = "DESHABILITADO";
                                        $estilo_estado = "class=\"texto-deshabilitado\"";
                                        if($m->usuario_estado == 1){
                                            $estado = "HABILITADO";
                                            $estilo_estado = "class=\"texto-habilitado\"";
                                        }
                                        ?>
                                        <tr>
                                            <td><?= $a;?></td>
                                            <td id="usuarionickname<?= $m->id_usuario;?>"><?= $m->usuario_nickname;?></td>
                                            <td id="rolnombre<?= $m->id_usuario;?>"><strong><?= $m->rol_nombre;?></strong></td>
                                            <td <?=$estilo_estado;?> id="usuarioestado<?= $m->id_usuario?>"><?= $estado;?></td>
                                            <td id="usuarioemail<?= $m->id_usuario;?>"><?= $m->usuario_email;?></td>
                                            <td id="personanombre<?= $m->id_persona;?>"><?= $m->persona_nombre;?></td>
                                            <td id="personaapellidopaterno<?= $m->id_persona;?>"><?= $m->persona_apellido_paterno;?></td>
                                            <td><?= date('d-m-Y H:i:s', strtotime($m->usuario_ultimo_login));?></td>
                                            <!--<td><?php //echo $m->person_dni;?></td>-->
                                            <!--<td><?php //echo $m->person_birth;?></td>-->
                                            <!--<td id="personatelefono<?php //echo $m->id_persona;?>"><?php //echo $m->persona_telefono;?></td>-->
                                            <td>
                                                <div id="botonpersona<?= $m->id_persona;?>">
                                                    <button data-toggle="modal" data-target="#editarPersona" onclick="editar_persona(<?= $m->id_persona;?>, '<?= $m->persona_nombre;?>', '<?= $m->persona_apellido_paterno;?>', '<?= $m->persona_apellido_materno;?>', '<?= $m->persona_nacimiento;?>','<?= $m->persona_telefono;?>')"  class="btn btn-xs btn-primary btne" >Editar Persona</button>
                                                </div>
                                                <div id="botonusuario<?= $m->id_usuario;?>">
                                                    <button data-toggle="modal" data-target="#editarDatosUsuario" onclick="editar_usuario(<?= $m->id_usuario;?>, '<?= $m->usuario_nickname;?>', '<?= $m->usuario_email;?>', <?= $m->id_rol;?>, <?= $m->usuario_estado;?>)" class="btn btn-xs btn-info btne" >Editar Usuario</button>
                                                </div>
                                            </td>
                                            <td id="botoncontra<?= $m->id_usuario;?>">
                                                <button data-toggle="modal" data-target="#restablecerContra" onclick="nueva_contra(<?= $m->id_usuario;?>, '<?= $m->usuario_nickname;?>')" class="btn btn-xs btn-secondary btne">Resetear Contraseña</button>
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
<script src="<?php echo _SERVER_ . _JS_;?>usuario.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>humanos.js"></script>