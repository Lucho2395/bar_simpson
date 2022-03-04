<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 14/10/2020
 * Time: 21:48
 */
?>
<body id="page-top">
<!-- Modal Restablecer Contraseña-->
<div class="modal fade" id="ContrasenhaUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar Contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">Nueva Contraseña</label>
                                <input class="form-control" type="password" id="contra1p" maxlength="16" placeholder="Ingrese Información...">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">Repetir Contraseña</label>
                                <input class="form-control" type="password" id="contra2p"  maxlength="16" placeholder="Ingrese Información...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                <button type="button" class="btn btn-success" id="btn-nueva_contra" onclick="guardar_contrasenha()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Editar Usuario-->
<div class="modal fade" id="DatosUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Editar Usuario Personal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="editarDatosDelUsuario">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="usuario">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Usuario</label>
                                        <input class="form-control" type="text" id="usuario_nicknamep" name="usuario_nicknamep" value="<?= $this->encriptar->desencriptar($_SESSION['_n'],_FULL_KEY_)?>" maxlength="16" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Email</label>
                                        <input class="form-control" type="text" id="usuario_emailp" name="usuario_emailp" value="<?= $this->encriptar->desencriptar($_SESSION['u_e'],_FULL_KEY_)?>" maxlength="40" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Foto de Perfil</label>
                                        <input class="form-control" type="file" id="usuario_imagenp" name="usuario_imagenp" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-editar-usuario-datos"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Editar Persona-->
<div class="modal fade" id="editarPersonaDatos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Datos Personales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="gestionarInfoDatosPersona">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="persona">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre Persona</label>
                                        <input class="form-control" type="text" id="persona_nombrep" name="persona_nombrep" value="<?= $this->encriptar->desencriptar($_SESSION['p_n'],_FULL_KEY_)?>" maxlength="20" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Apellido Paterno</label>
                                        <input class="form-control" type="text" id="persona_apellido_paternop" name="persona_apellido_paternop" value="<?= $this->encriptar->desencriptar($_SESSION['p_p'],_FULL_KEY_)?>" maxlength="30" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Apellido Materno</label>
                                        <input class="form-control" type="text" id="persona_apellido_maternop" name="persona_apellido_maternop" value="<?= $this->encriptar->desencriptar($_SESSION['p_m'],_FULL_KEY_)?>" maxlength="30" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Fecha de Nacimiento</label>
                                        <input class="form-control" type="date" id="persona_nacimientop" name="persona_nacimientop" value="<?= $this->encriptar->desencriptar($_SESSION['p_nc'],_FULL_KEY_)?>" maxlength="30" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Número de Teléfono</label>
                                        <input class="form-control" type="text" id="persona_telefonop" value="<?= $this->encriptar->desencriptar($_SESSION['p_t'],_FULL_KEY_)?>" onkeyup="return validar_numeros(this.id)" name="persona_telefonop" maxlength="30" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-editar-persona-datos"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Page Wrapper -->
<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= _SERVER_;?>">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fa fa-folder"></i>
            </div>
            <div class="sidebar-brand-text mx-3">EggPHP3 <sup><?= _VERSION_;?></sup></div>
        </a>
        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="<?= _SERVER_;?>">
                <i class="fa fa-fw fa-tachometer-alt"></i>
                <span>Inicio</span></a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">
            Menú
        </div>
        <?php
        //Variable usada como correlativo
        $raioz = 1;
        //Listamos las restricciones de opciones para el rol del usuario
        $restricciones = $this->nav->listar_restricciones($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
        foreach ($navs as $nav){
            //Clases necesarias para mostrar en el navbar
            $nav_link = "nav-link collapsed";
            $aria_expanded = "false";
            $collapse = "collapse";
            //Validamos si es controlador en el que estamos ingresando
            if($nav->menu_controlador == $_SESSION['controlador']){
                $nav_link = "nav-link";
                //$aria_expanded = "true";
                //$collapse = "collapse show";

                $_SESSION['controlador'] = $nav->menu_nombre;
                $_SESSION['icono'] = $nav->menu_icono;
                //Obtener el Nombre del Controlador y de la Funcion
                $name = $this->nav->listar_nombre_opcion($_SESSION['controlador'], $_SESSION['accion']);
                (isset($name->opcion_nombre)) ? $_SESSION['accion'] = $name->opcion_nombre : $_SESSION['accion'] = "";
                //Despues procedemos a llenar las las opciones del menú
            }?>
            <li class="nav-item">
                <a class="<?= $nav_link;?>" href="#" data-toggle="collapse" data-target="#collapseMenu<?= $raioz;?>" aria-expanded="<?= $aria_expanded;?>" aria-controls="collapseMenu<?= $raioz;?>">
                    <i class="<?= $nav->menu_icono;?>"></i>
                    <span><?= $nav->menu_nombre;?></span>
                </a>
                <div id="collapseMenu<?= $raioz;?>" class="<?= $collapse;?>" aria-labelledby="headingMenu<?= $raioz;?>" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Opciones:</h6>
                        <?php
                        $option = $this->nav->listar_opciones($nav->id_menu);
                        foreach ($option as $o){
                            //Validamos si la opcion no tiene restriccion por rol
                            $mostrar = true;
                            foreach ($restricciones as $r){
                                //Si entra al if, quiere decir que la opcion esta restringida para el rol del usuario
                                if($r->id_opcion == $o->id_opcion){
                                    //Si entra aquí, quiere decir que el usuario no puede acceder a la opción especificada
                                    $mostrar = false;
                                }
                            }
                            if($mostrar){
                                ?>
                                <a class="collapse-item" href="<?= _SERVER_. $nav->menu_controlador . '/'. $o->opcion_funcion;?>"><?= $o->opcion_nombre;?></a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </li>
            <?php
            $raioz++;
        }
        ?>
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
    <!-- End of Sidebar -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>
                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">
                    <div class="topbar-divider d-none d-sm-block"></div>
                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $this->encriptar->desencriptar($_SESSION['p_n'],_FULL_KEY_);?></span>
                            <img class="img-profile rounded-circle" src="<?= _SERVER_ . $this->encriptar->desencriptar($_SESSION['u_i'],_FULL_KEY_);?>">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" data-toggle="modal" data-target="#editarPersonaDatos" >
                                <i class="fa fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Datos Personales
                            </a>
                            <a class="dropdown-item" data-toggle="modal" data-target="#DatosUsuario">
                              <i class="fa fa-pencil-square-o fa-sm fa-fw mr-2 text-gray-400"></i>
                                Nombre de Usuario
                            </a>
                            <a class="dropdown-item" data-toggle="modal" data-target="#ContrasenhaUsuario">
                                <i class="fa fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Contraseña
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= _SERVER_;?>Admin/finalizar_sesion">
                                <i class="fa fa-sign-out fa-sm fa-fw mr-2 text-gray-400"></i>
                                Cerrar Sesión
                            </a>
                            <!--<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fa fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                          </a>-->
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- End of Topbar -->