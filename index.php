<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 17/09/2020
 * Time: 18:03
 */
//Gestión de Acceso a Vistas
//Declaracion de Variables Globales
require 'core/globals.php';
//Inicio de Sesion
session_start();
//Levantamiento del Log para registro de errores
require 'app/models/Log.php';
$log = new Log();
//Variable para definir el tipo de acceso
$_SESSION['acceso'] = 1;
//Variable para correr o no el sistema si no está en mantenimiento
$correr = true;
//Valida si el sistema está en mantenimento o no
//Para acceder al modo de superadmin en mantenimiento es lo siguiente:
//index.php?c=Login&a=inicio&(nombre_parametro_get)=superadmin
//Se puede modificar el nombre de la variable de $_GET['mod'], por seguridad
if(
    isset($_GET['c']) &&
    isset($_GET['a']) &&
    isset($_GET['mod'])
    && $_GET['c'] == "Login"
    && $_GET['a'] == "inicio"
    && $_GET['mod'] == "superadmin"){
    $_SESSION['superadmin'] = true;
}
if(_MANTENIMIENTO_WEB == 1){
    $correr = $_SESSION['superadmin'] ?? false;
}
//Variables a usar para inicializar los controladores y funciones
$function_action = "Desconocido";
$archivo = "";
$controlador = "";
$accion = "";
//Array para validar situacion de accesos a vista
//("estado" => 'error' para reporta que algo salio, 'ok' para inicializar el sistema, 'login' para mandar a la vista de login.)
//("accion" => La acción (funcion del controlador) que usará el sistema)
//("mensaje" => En caso de ocurrir un error, aqui se almacena el mensaje)
$validacion = array("estado" => 'error',"accion" => 'inicio',"mensaje" => 'Error General');
if($correr){
    try{
        //Para Mostrar o No Errores (Comentado Para SI, Descomentado Para NO)
        //error_reporting(E_ALL);

        //LLamada a archivo gestor de base de datos
        require 'core/Database.php';
        //LLamada a archivo para limpieza y validación de datos
        require 'app/models/Validar.php';
        //Inicio clase para la encriptacion de contenido
        require 'app/models/Encriptar.php';
        //Levantamiento de registro de roles y permisos para acceso a vistas
        require 'app/models/Menui.php';
        //Inicio Clase Para Generación de Menus Dinamicos
        require 'app/models/Navbar.php';
        //Inicio Clase Para Actualización de Datos de Usuario
        require 'app/models/Sesion.php';

        //Inicialización de clases necesarias en Index
        $menui = new Menui();
        $encriptar = new Encriptar();
        $sesion = new Sesion();

        //Para manejo de caracteres
        header("Content-Type: text/html;charset=utf-8");
        //Especificar el manejo de errores personalizados
        set_error_handler("exception_error_handler");

        //Verificación de Variables de Sesion y Cookies
        require 'core/session.php';

        //Inicio de Código de Verificación de Permisos

        //Captura de Datos para Obtener el Controlador y la Accion
        //Por Aquí Pasan Todas Las Funciones Para La Lectura de Vistas
        if(isset($_GET['c'])){
            //Aqui se recibe el controlador, si es que no está declarado
            $controlador = $_GET['c'];
        } else {
            //Si No Hay Controlador Declarado, Se Hace Validación

            //Esta Parte Del Código Es Para Software Que Sólo Funcionan Con Usuarios Registrados
            if(isset($_SESSION['ru'])){
                //Si Entra Aquí, Es Porque Hay Una Sesión Iniciada
                $controlador = "Admin";
            } else {
                $controlador = "Login";
            }
            //Esta Parte Del Código Es Para Software Que Tienes Varias Vistas Libres Para Varios Usuarios (Reemplazar en Login)
            //$controlador = "Inicio";
        }
        $controlador = trim(ucfirst($controlador));

        //Validar que la sesión es desde una web
        $_SESSION['web'] = true;

        //Obtencion de Datos de Accion, Si No Hay Una Declarada, Se Pone "Inicio" Por Defecto
        $accion = $_GET['a'] ?? "inicio";
        $accion = trim(strtolower($accion));
        //Variable Usada Para Declarar La Funcion En Caso De Error
        $function_action = $controlador . "|" . $accion;

        //Verificar existencia de los archivos
        $archivo = 'app/controllers/' . $controlador . 'Controller.php';
        //Verifica Si El Archivo Existe
        if(file_exists($archivo)){
            //Variable Para Determinar Si Procede o No La Petición
            $autorizado = false;
            //Validamos si existe una $_SESSION iniciada para saber que mostrar en el usuario
            if(isset($_SESSION['ru'])){
                //Validamos los accesos del rol
                $autorizado = $menui->verificar_permiso_usuario($encriptar->desencriptar($_SESSION['ru'], _FULL_KEY_), $controlador, $accion);
                //Validamos si usuario se encuentra habilitado para usar el sistema
                $permiso = $encriptar->desencriptar($_SESSION['s_'],_FULL_KEY_);
            } else {
                //Validamos los accesos del rol libre (código 1)
                $autorizado = $menui->verificar_permiso_usuario(1, $controlador, $accion);
                //Como el usuario es libre, damos por habilitado el acceso del usuario
                $permiso = 1;
            }
            //Si se desea probar alguna función sin validar accesos, sólo descomentar las siguientes lineas
            //$autorizado = 1;
            //$permiso = 1;
            //Si ambas variables tiene valor de 1, se permite el acceso
            if($autorizado && $permiso == 1){
                //Entra Aquí Si La Clase Y La Funcion Existen
                $validacion['estado'] = 'ok';
                $validacion['accion'] = '';
                $validacion['mensaje'] = '';
            } else {
                //Entramos aquí para validar el tipo de acceso que esta mal
                if($permiso == 0){
                    //LLEGA AQUI SI EL USUARIO FUE INHABILITADO
                    $validacion['estado'] = 'error';
                    $validacion['accion'] = 'inicio';
                } else {
                    //Si Permiso == 1, entra aquí porque autorizado = 0
                    if(isset($_SESSION['ru'])){
                        //Si entra aquí, es porque el usuario esta logueado pero su usuario
                        // no tiene permiso de acceso a esta vista.
                        $validacion['estado'] = 'error';
                        $validacion['accion'] = 'inicio';
                    } else {
                        //Si entra aquí, es porque no hay usuario logueado, por lo que
                        // no tiene permiso de acceso a esta vista.
                        $validacion['estado'] = 'login';
                        $validacion['accion'] = '';
                    }
                }
                $validacion['mensaje'] = 'SIN PERMISOS SUFICIENTES DE ACCESO';
            }
        } else {
            //Si el Archivo No Existe, Genera El Error Y Notifica En La Pantalla
            $validacion['estado'] = 'error';
            $validacion['accion'] = 'inicio';
            $validacion['mensaje'] = 'El archivo consultado ' . $archivo . ' no existe';
        }
    } catch (Exception $e){
        //Error en Try/Catch
        //Acciones si ocurre un error durante la ejecución del código
        $validacion['estado'] = 'error';
        $validacion['accion'] = 'inicio';
        $validacion['mensaje'] = $e->getMessage();
    }
} else {
    //Entra aquí si el sistema se encuentra en mantenimiento
    session_destroy();
    $validacion['estado'] = 'error';
    $validacion['accion'] = 'mantenimiento';
    $validacion['mensaje'] = 'Sistema en Mantenimiento';
}
//Validamos el array de $validacion para saber que vista mostrar al usuario
switch ($validacion['estado']){
    case 'ok':
        try{
            //Entra Aquí Si La Clase Y La Funcion Existen
            //Para usar en el menú y navbar
            $_SESSION['accion'] = $accion;
            $_SESSION['controlador'] = $controlador;
            //Hacemos require del archivo a usar en el controlador
            require $archivo;
            $clase = sprintf('%sController', $controlador);
            //Instaciamos el controlador
            $controller = new $clase;
            //Llamamos a la función a usar
            $controller->$accion();
            //Eliminación de Variables de Sesión Para Manejo de Menú
            unset($_SESSION['accion']);
            unset($_SESSION['controlador']);
            unset($_SESSION['icono']);
        } catch (Throwable $e){
            //Si La Funcion No Existe, Entra Aquí.
            //Hacemos require del archivo a usar en el controlador de Errores,
            // luego lo instaciamos y llamamos a la funcion de error a usar
            require 'app/controllers/ErrorController.php';
            $clase = sprintf('%sController', 'Error');
            $accion = 'inicio';
            $controller = new $clase;
            $controller->$accion();
            //Insertamos el código de error generado
            $log->insertar($e->getMessage(), $function_action);
        }
        break;
    case 'login':
        //Ingresa aqui cuando se intenta acceder a una vista sin permisos
        $sesion->cerrar_sesion();
        require 'app/controllers/LoginController.php';
        $clase = 'LoginController';
        $accion = 'inicio';
        $controller = new $clase;
        $controller->$accion();
        //$log->insertar($validacion['mensaje'], $function_action);
        break;
    default:
        //Ingresa aquí cuando existe un error de acceso a alguna vista
        require 'app/controllers/ErrorController.php';
        $clase = 'ErrorController';
        $accion = $validacion['accion'];
        $controller = new $clase;
        $controller->$accion();
        //Mostramos el error en la consola del navegador, para tener mayor información al respecto
        echo "<script language=\"javascript\">console.log(\"". $validacion['mensaje']."\");</script>";
        if($validacion['accion'] != "mantenimiento"){
            //Automaticamente, notificar error
            $log->insertar($validacion['mensaje'], $function_action);
        }
        break;
}