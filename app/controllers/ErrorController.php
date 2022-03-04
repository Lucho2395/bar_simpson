<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 12/10/2020
 * Time: 10:56
 */
//Vistas a llamar en caso de ocurrir errores en el sistema
class ErrorController{
    public function __construct()
    {

    }
    //Inicio: Para errores generales
    public function inicio(){
        require _VIEW_PATH_ . 'error/error.php';
    }
    //Mantenimiento: Para cuando el sistema entra en modo de mantenimiento
    public function mantenimiento(){
        require _VIEW_PATH_ . 'error/mantenimiento.php';
    }
    //Error critico: Para cuando suceden errores inesperado en el sistema (Ejemplo: conexion de base de datos)
    public function error_critico(){
        require _VIEW_PATH_ . 'error/error_critico.php';
    }
}
