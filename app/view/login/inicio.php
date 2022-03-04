<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 13/10/2020
 * Time: 12:56
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title><?=_TITLE_;?> - Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="<?=_SERVER_ . _ICON_;?>"/>
    <!--Estilos de CSS-->
    <link rel="stylesheet" type="text/css" href="<?=_SERVER_ . _STYLES_LOGIN_;?>vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?=_SERVER_ . _STYLES_LOGIN_;?>fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?=_SERVER_ . _STYLES_LOGIN_;?>fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="<?=_SERVER_ . _STYLES_LOGIN_;?>vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="<?=_SERVER_ . _STYLES_LOGIN_;?>vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="<?=_SERVER_ . _STYLES_LOGIN_;?>vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?=_SERVER_ . _STYLES_LOGIN_;?>css/util.css">
    <link rel="stylesheet" type="text/css" href="<?=_SERVER_ . _STYLES_LOGIN_;?>css/main.css">
    <link rel="stylesheet" href="<?=_SERVER_ . _LIBS_;?>sweetalert/sweetalert2.min.css">
</head>
<body>
<div class="limiter">
    <div class="container-login100" style="background-image: url('<?=_SERVER_ . _STYLES_LOGIN_;?>images/fondo_gaia.jpg');">
        <div class="wrap-login100 p-t-190 p-b-30">
            <div class="login100-form validate-form">
                <div class="login100-form-avatar">
                    <img src="<?=_SERVER_;?>media/logo/logo_simpson.png" alt="Logo de Proyecto">
                </div>

                <span class="login100-form-title p-t-20 p-b-45"><?=_TITLE_;?></span>

                <div class="wrap-input100 validate-input m-b-10">
                    <input class="input100" type="text" name="usuario_nickname" id="usuario_nickname" placeholder="Usuario">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100"><i class="fa fa-user"></i></span>
                </div>

                <div class="wrap-input100 validate-input m-b-10">
                    <input class="input100" type="password" name="usuario_contrasenha" id="usuario_contrasenha" placeholder="Contraseña">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100"><i class="fa fa-lock"></i></span>
                </div>

                <div class="container-login100-form-btn p-t-10">
                    <button class="login100-form-btn" id="btn-iniciar-sesion" onclick="validar_usuario()">Iniciar Sesión</button>
                </div>

                <div class="container-login100-form-btn p-t-10" style="display: none;">
                    <input type="checkbox" class="input100" id="recordar"><label class="txt1" for="recordar">Recordarme</label>
                </div>

                <!--<div class="text-center w-full p-t-25 p-b-230">
                    <a href="#" class="txt1">
                        ¿Olvidaste tu Usuario o Contraseña?
                    </a>
                </div>-->

                <!--<div class="text-center w-full">
                    <a class="txt1" href="#">
                        Crear Cuenta Nueva
                        <i class="fa fa-long-arrow-right"></i>
                    </a>
                </div>-->
            </div>
        </div>
    </div>
</div>
<!--Importacion de Javascript-->
<script src="<?=_SERVER_ . _STYLES_LOGIN_;?>vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="<?=_SERVER_ . _STYLES_LOGIN_;?>vendor/bootstrap/js/popper.js"></script>
<script src="<?=_SERVER_ . _STYLES_LOGIN_;?>vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="<?=_SERVER_ . _STYLES_LOGIN_;?>vendor/select2/select2.min.js"></script>
<script src="<?=_SERVER_ . _LIBS_;?>sweetalert/sweetalert2.min.js"></script>
<script src="<?=_SERVER_ . _JS_;?>main-sweet.js"></script>
<script src="<?=_SERVER_ . _JS_;?>domain.js"></script>
<script src="<?=_SERVER_ . _JS_;?>login.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#usuario_contrasenha').keypress(function(e){
            if(e.which === 13){
                validar_usuario();
            }
        });
        $('#usuario_nickname').keypress(function(e){
            if(e.which === 13){
                validar_usuario();
            }
        });
    });
</script>
</body>
</html>