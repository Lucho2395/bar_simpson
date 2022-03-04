<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 17/09/2020
 * Time: 18:04
 */
//En caso el sistema sea consumido por app móviles, se puede inhabilitar
//el acceso a los WS por este medio
define('_MANTENIMIENTO_WS', 0);
//Si el sistema se encuentra en mantenimiento, habilitamos
//aqui para que nadie pueda acceder a la misma
define('_MANTENIMIENTO_WEB', 0);

//Variables globales de uso en todo el sistema
//Establecer Zona Horaria
date_default_timezone_set('America/Lima');
//Definicion de servidor del aplicativo
define('_SERVER_', 'http://127.0.0.1:81/simpson/');
//Definicion de variables para conexion de base de datos
define('_SERVER_DB_', 'localhost');
define('_DB_', 'simpsonbd');
define('_USER_DB_', 'root');
define('_PASSWORD_DB_', '');

//Definicion de clave de desencriptacion
define('_FULL_KEY_','ñklmqz');
//Titulo
define('_TITLE_', 'SIMPSON');
//Rutas de Archivos
define('_STYLES_ALL_', 'styles/');
define('_STYLES_ADMIN_', 'styles/pollitoconpapas/');
define('_STYLES_LOGIN_', 'styles/login/');
define('_STYLES_INDEX_', 'styles/inicio/');
define('_ICON_', 'styles/logo_simpson.png');
define('_JS_','js/');
define('_VIEW_PATH_', 'app/view/');
define('_LIBS_', 'libs/');
//Tiempo de Cookies
//$tiempo_cookie = dias * horas * minutos * segundos;
define('_TIEMPO_COOKIE',1 * 1 * 60 * 60);
//Version
define('_VERSION_','0.1');
define('_MYSITE_','https://bufeotec.com');

// Manejo de Errores Personalizado de PHP a Try/Catch
function exception_error_handler($severidad, $mensaje, $fichero, $linea) {
    $cadena =  '[LEVEL]: ' . $severidad . ' IN ' . $fichero . ': ' . $linea . '[MESSAGGE]' . $mensaje . "\n";
    $log = new Log();
    $log->insertar($cadena, "Excepcion No Manejada");
    //echo $cadena;
}