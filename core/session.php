<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 17/09/2020
 * Time: 18:05
 */
//Verifica si está declarada la sesión y que los datos a usar sean los correctos
//Verifica si esta declarada la variable de sesión
$actualizar_usuario = true;
$uso_cookie = false;
$sesion->habilitar_global();
//Validamos que la consulta no se haya hecho a traves de un web services
if(!isset($_POST['app'])){
    if($_POST['app'] != true){
        //Verificamos si esta declarada la variable de sesión
        if(!isset($_SESSION['c_u'])){
            //Si la variable no está declarada, entra aquí.
            //Validamos que este declarada la cookie
            if(isset($_COOKIE['c_u'])) {
                //Si existe cookie, cambiamos el valor de $uso_cookie a true y obtenemos los datos del usuario
                $uso_cookie = true;
                $usuario = $sesion->obtener_informacion($encriptar->desencriptar($_COOKIE['c_u'], _FULL_KEY_));
                //Si $usuario es false, no actualizamos la sesión
                if(!$usuario){
                    //Si $user = false, por seguridad elimina todas las variables de sesión y cookies
                    $actualizar_usuario = false;
                }
            } else {
                //Si no hay cookie declarada, no actualizamos los datos
                $actualizar_usuario = false;
            }
        } else {
            //Si entra aquí es porque la variable de sesión esta declarada
            //Verificamos si hay cookie declarada para el guardado de sesión
            if(isset($_COOKIE['c_u'])) {
                $uso_cookie = true;
            }
            $usuario = $sesion->obtener_informacion($encriptar->desencriptar($_SESSION['c_u'], _FULL_KEY_));
            //Si $usuario es false, no actualizamos la sesión
            if(!$usuario){
                //Si $user = false, por seguridad elimina todas las variables de sesión y cookies
                $actualizar_usuario = false;
            }
        }
        if($actualizar_usuario){
            //Si $actualizar_usuario es true, generamos/actualizamos la sesión
            $sesion->generar_sesion($usuario, $uso_cookie);
        } else {
            //Si $user = false, por seguridad elimina todas las variables de sesión y cookies
            $sesion->cerrar_sesion();
        }
    } else {
        unset($_SESSION['c_u']);
        unset($_SESSION['s_']);
        unset($_SESSION['ru']);
    }
} else {
    unset($_SESSION['c_u']);
    unset($_SESSION['s_']);
    unset($_SESSION['ru']);
}