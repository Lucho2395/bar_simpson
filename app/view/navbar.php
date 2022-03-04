<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 09/03/2021
 * Time: 12:16
 */
?>
<!--Inicio Nabvar-->
<body class="animsition">

<div class="page-wrapper">
    <!-- Modal Restablecer Contraseña-->
    <div class="modal fade" id="ContrasenhaUsuario" tabindex="-1" role="dialog" aria-labelledby="ContrasenhaUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ContrasenhaUsuarioLabel">Cambiar Contraseña</h5>
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
    <div class="modal fade" id="DatosUsuario" tabindex="-1" role="dialog" aria-labelledby="DatosUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="DatosUsuarioLabel">Editar Usuario Personal</h5>
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
    <div class="modal fade" id="editarPersonaDatos" tabindex="-1" role="dialog" aria-labelledby="editarPersonaDatosLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarPersonaDatosLabel">Editar Datos Personales</h5>
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
    <!-- HEADER MOBILE-->
    <header class="header-mobile d-block d-lg-none">
        <div class="header-mobile__bar">
            <div class="container-fluid">
                <div class="header-mobile-inner">
                    <a class="logo" href="<?= _SERVER_;?>">
                        <img src="<?= _SERVER_;?>media/logo/logo_simpson.png" style="width: 100px;" alt="Logo" />
                    </a>
                    <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                    </button>
                </div>
            </div>
        </div>
        <nav class="navbar-mobile">
            <div class="container-fluid">
                <ul class="navbar-mobile__list list-unstyled">
                    <?php
                    //Variable usada como correlativo
                    $raioz = 1;
                    //Listamos las restricciones de opciones para el rol del usuario
                    $restricciones = $this->nav->listar_restricciones($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
                    foreach ($navs as $nav){
                        //Clases necesarias para mostrar en el navbar
                        /*$nav_link = "nav-link collapsed";
                        $aria_expanded = "false";
                        $collapse = "collapse";*/
                        $active = "";
                        //Validamos si es controlador en el que estamos ingresando
                        if($nav->menu_controlador == $_SESSION['controlador']){
                            $active = "active";
                            //$nav_link = "nav-link";
                            //$aria_expanded = "true";
                            //$collapse = "collapse show";

                            $_SESSION['controlador'] = $nav->menu_nombre;
                            $_SESSION['icono'] = $nav->menu_icono;
                            //Obtener el Nombre del Controlador y de la Funcion
                            $name = $this->nav->listar_nombre_opcion($_SESSION['controlador'], $_SESSION['accion']);
                            (isset($name->opcion_nombre)) ? $_SESSION['accion'] = $name->opcion_nombre : $_SESSION['accion'] = "";
                            //Despues procedemos a llenar las las opciones del menú
                        }?>
                        <li class="<?= $active;?> has-sub">
                            <a class="js-arrow" href="#">
                                <i class="<?= $nav->menu_icono;?>"></i><?= $nav->menu_nombre;?></a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
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
                                        <li> <a href="<?= _SERVER_. $nav->menu_controlador . '/'. $o->opcion_funcion;?>"><?= $o->opcion_nombre;?></a> </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                        $raioz++;
                    }
                    ?>
                    <li class="has-sub">
                        <a class="js-arrow" href="#" style="color: #0f6848;">
                            <i class="fa fa-pencil-square"></i>Datos Personales</a>
                        <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                            <li>
                                <a href="#" data-toggle="modal" data-target="#editarPersonaDatos">
                                    <i class="fa fa-user"></i>Información Personal</a>
                            </li>
                            <li>
                                <a href="#" data-toggle="modal" data-target="#DatosUsuario">
                                    <i class="fa fa-pencil"></i>Nombre de Usuario</a>
                            </li>
                            <li>
                                <a href="#" data-toggle="modal" data-target="#ContrasenhaUsuario">
                                    <i class="fa fa-wrench"></i>Contraseña</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- END HEADER MOBILE-->

    <!-- MENU SIDEBAR-->
    <aside class="menu-sidebar d-none d-lg-block">
        <div class="logo">
            <a href="#">
                <img src="<?= _SERVER_;?>media/logo/logo_simpson.png" style="width: 75px; margin-top: 5px; margin-left: 60px" alt="<?= _TITLE_;?>" />
            </a>
        </div>
        <div class="menu-sidebar__content js-scrollbar1">
            <nav class="navbar-sidebar">
                <ul class="list-unstyled navbar__list">
                    <?php
                    //Variable usada como correlativo
                    $raioz = 1;
                    //Listamos las restricciones de opciones para el rol del usuario
                    $restricciones = $this->nav->listar_restricciones($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
                    foreach ($navs as $nav){
                        //Clases necesarias para mostrar en el navbar
                        /*$nav_link = "nav-link collapsed";
                        $aria_expanded = "false";
                        $collapse = "collapse";*/
                        $active = "";
                        //Validamos si es controlador en el que estamos ingresando
                        if($nav->menu_controlador == $_SESSION['controlador']){
                            $active = "active";
                            //$nav_link = "nav-link";
                            //$aria_expanded = "true";
                            //$collapse = "collapse show";

                            $_SESSION['controlador'] = $nav->menu_nombre;
                            $_SESSION['icono'] = $nav->menu_icono;
                            //Obtener el Nombre del Controlador y de la Funcion
                            //$name = $this->nav->listar_nombre_opcion($_SESSION['controlador'], $_SESSION['accion']);
                            //(isset($name->opcion_nombre)) ? $_SESSION['accion'] = $name->opcion_nombre : $_SESSION['accion'] = "";
                            //Despues procedemos a llenar las las opciones del menú
                        }?>
                        <li class="<?= $active;?> has-sub">
                            <a class="js-arrow" href="#">
                                <i class="<?= $nav->menu_icono;?>"></i><?= $nav->menu_nombre;?></a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
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
                                        <li><a style="font-size: 17px; !important;" href="<?= _SERVER_. $nav->menu_controlador . '/'. $o->opcion_funcion;?>"><i class="fa fa-arrow-circle-o-right"></i><?= $o->opcion_nombre;?></a> </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                        $raioz++;
                    }
                    ?>
                    <li class="has-sub">
                        <a class="js-arrow" href="#" style="color: #0f6848;">
                            <i class="fa fa-pencil-square"></i>Datos Personales</a>
                        <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                            <li>
                                <a href="#" data-toggle="modal" data-target="#editarPersonaDatos">
                                    <i class="fa fa-user"></i>Información Personal</a>
                            </li>
                            <li>
                                <a href="#" data-toggle="modal" data-target="#DatosUsuario">
                                    <i class="fa fa-pencil"></i>Nombre de Usuario</a>
                            </li>
                            <li>
                                <a href="#" data-toggle="modal" data-target="#ContrasenhaUsuario">
                                    <i class="fa fa-wrench"></i>Contraseña</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    <!-- END MENU SIDEBAR-->
    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <!-- HEADER DESKTOP-->
        <header class="header-desktop">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="header-wrap">
                        <form class="form-header" action="" method="POST">
                            <!--<input class="au-input au-input--xl" type="text" name="search" placeholder="Buscador que no busca..." />
                            <button class="au-btn--submit" data-toggle="modal" data-target="#exampleModal">
                                <i class="zmdi zmdi-search"></i>
                            </button>-->
                        </form>
                        <div class="header-button">
                            <div class="noti-wrap">
                                <!--<div class="noti__item js-item-menu">
                                    <i class="zmdi zmdi-comment-more"></i>
                                    <span class="quantity">1</span>
                                    <div class="mess-dropdown js-dropdown">
                                        <div class="mess__title">
                                            <p>You have 2 news message</p>
                                        </div>
                                        <div class="mess__item">
                                            <div class="image img-cir img-40">
                                                <img src="images/icon/avatar-06.jpg" alt="Michelle Moreno" />
                                            </div>
                                            <div class="content">
                                                <h6>Michelle Moreno</h6>
                                                <p>Have sent a photo</p>
                                                <span class="time">3 min ago</span>
                                            </div>
                                        </div>
                                        <div class="mess__item">
                                            <div class="image img-cir img-40">
                                                <img src="images/icon/avatar-04.jpg" alt="Diane Myers" />
                                            </div>
                                            <div class="content">
                                                <h6>Diane Myers</h6>
                                                <p>You are now connected on message</p>
                                                <span class="time">Yesterday</span>
                                            </div>
                                        </div>
                                        <div class="mess__footer">
                                            <a href="#">View all messages</a>
                                        </div>
                                    </div>
                                </div>-->
                                <!--<div class="noti__item js-item-menu">
                                    <i class="zmdi zmdi-email"></i>
                                    <span class="quantity">1</span>
                                    <div class="email-dropdown js-dropdown">
                                        <div class="email__title">
                                            <p>You have 3 New Emails</p>
                                        </div>
                                        <div class="email__item">
                                            <div class="image img-cir img-40">
                                                <img src="images/icon/avatar-06.jpg" alt="Cynthia Harvey" />
                                            </div>
                                            <div class="content">
                                                <p>Meeting about new dashboard...</p>
                                                <span>Cynthia Harvey, 3 min ago</span>
                                            </div>
                                        </div>
                                        <div class="email__item">
                                            <div class="image img-cir img-40">
                                                <img src="images/icon/avatar-05.jpg" alt="Cynthia Harvey" />
                                            </div>
                                            <div class="content">
                                                <p>Meeting about new dashboard...</p>
                                                <span>Cynthia Harvey, Yesterday</span>
                                            </div>
                                        </div>
                                        <div class="email__item">
                                            <div class="image img-cir img-40">
                                                <img src="images/icon/avatar-04.jpg" alt="Cynthia Harvey" />
                                            </div>
                                            <div class="content">
                                                <p>Meeting about new dashboard...</p>
                                                <span>Cynthia Harvey, April 12,,2018</span>
                                            </div>
                                        </div>
                                        <div class="email__footer">
                                            <a href="#">See all emails</a>
                                        </div>
                                    </div>
                                </div>-->
                                <!--<div class="noti__item js-item-menu">
                                    <i class="zmdi zmdi-notifications"></i>
                                    <span class="quantity">3</span>
                                    <div class="notifi-dropdown js-dropdown">
                                        <div class="notifi__title">
                                            <p>You have 3 Notifications</p>
                                        </div>
                                        <div class="notifi__item">
                                            <div class="bg-c1 img-cir img-40">
                                                <i class="zmdi zmdi-email-open"></i>
                                            </div>
                                            <div class="content">
                                                <p>You got a email notification</p>
                                                <span class="date">April 12, 2018 06:50</span>
                                            </div>
                                        </div>
                                        <div class="notifi__item">
                                            <div class="bg-c2 img-cir img-40">
                                                <i class="zmdi zmdi-account-box"></i>
                                            </div>
                                            <div class="content">
                                                <p>Your account has been blocked</p>
                                                <span class="date">April 12, 2018 06:50</span>
                                            </div>
                                        </div>
                                        <div class="notifi__item">
                                            <div class="bg-c3 img-cir img-40">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="content">
                                                <p>You got a new file</p>
                                                <span class="date">April 12, 2018 06:50</span>
                                            </div>
                                        </div>
                                        <div class="notifi__footer">
                                            <a href="#">All notifications</a>
                                        </div>
                                    </div>
                                </div>-->
                            </div>
                            <div class="account-wrap">
                                <div class="account-item clearfix js-item-menu">
                                    <div class="image">
                                        <img style="border-radius: 25px;" src="<?= _SERVER_ . $this->encriptar->desencriptar($_SESSION['u_i'],_FULL_KEY_);?>" alt="John Doe" />
                                    </div>
                                    <div class="content">
                                        <a class="js-acc-btn" href="#"><?= $this->encriptar->desencriptar($_SESSION['p_n'],_FULL_KEY_);?></a>
                                    </div>
                                    <div class="account-dropdown js-dropdown">
                                        <div class="info clearfix">
                                            <div class="image">
                                                <a href="#">
                                                    <img style="border-radius: 25px;" src="<?= _SERVER_ . $this->encriptar->desencriptar($_SESSION['u_i'],_FULL_KEY_);?>" alt="John Doe" />
                                                </a>
                                            </div>
                                            <div class="content">
                                                <h5 class="name">
                                                    <a href="#"><?= $this->encriptar->desencriptar($_SESSION['p_n'],_FULL_KEY_);?></a>
                                                </h5>
                                                <span class="email"><?= $this->encriptar->desencriptar($_SESSION['rn'],_FULL_KEY_);?></span>
                                            </div>
                                        </div>
                                        <div class="account-dropdown__body">
                                            <!--<div class="account-dropdown__item" >
                                                <a href="#" data-toggle="modal" data-target="#editarPersonaDatos">
                                                    <i class="fa fa-user"></i>Datos Personales</a>
                                            </div>
                                            <div class="account-dropdown__item">
                                                <a href="#" data-toggle="modal" data-target="#DatosUsuario">
                                                    <i class="fa fa-pencil"></i>Nombre de Usuario</a>
                                            </div>
                                            <div class="account-dropdown__item" >
                                                <a href="#" data-toggle="modal" data-target="#ContrasenhaUsuario">
                                                    <i class="fa fa-wrench"></i>Contraseña</a>
                                            </div>-->
                                            <div class="account-dropdown__item">
                                                <a href="<?= _SERVER_;?>Admin/finalizar_sesion">
                                                    <i class="fa fa-power-off"></i>Cerrar Sesión</a>
                                            </div>
                                        </div>
                                        <div class="account-dropdown__footer">
                                            <a href="https://bufeotec.com" target="_blank" style="text-align: center;">BufeoTEC <?= date('Y');?> &copy; Hecho con ♥</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- HEADER DESKTOP-->
        <!--FIN NAVBAR-->