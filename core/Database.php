<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 17/09/2020
 * Time: 22:00
 */
class Database{
    private static $db;

    public static function getConnection(){
        //Crea la conexion a la base de datos
        try{
            if(empty(self::$db)){
                $pdo = new PDO('mysql:host='._SERVER_DB_.';dbname='._DB_.';charset=utf8',_USER_DB_,_PASSWORD_DB_);
                //En caso de trabajar localmente, descomentar la siguiente linea y comentar la anterior

                //Sirve para indicar al PDO que todo lo que retorne sean objetos
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                //Sirve para indicar que si encuentra error, los muestre
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                self::$db = $pdo;
            }
            return self::$db;
            //Si existe algún error en la conexión entra al catch y detiene totalmente todo el sistema y corremos en circulos porque no sabemos que hacer :(
        } catch (Throwable $e){
            /*$error = array("result" => 'ERROR CRITICO');
            echo json_encode($error);*/
            //$this->log->insert($e->getMessage(), 'Database.php');
            /*echo "<script language=\"javascript\">window.location.href=\"error/error\";</script>";
            echo 'Error de Conexión con la Base de Datos. No pierda la calma, seguro se soluciona en un momento.';*/
            if($_SESSION['acceso'] == 1){
                require 'app/controllers/ErrorController.php';
                $clase = 'ErrorController';
                $accion = 'error_critico';
                $controller = new $clase;
                $controller->$accion();
                echo "<script language=\"javascript\">console.log(\"". $e->getMessage()."\");</script>";
            } else {
                echo json_encode(
                    array(
                        "result" => array(
                            "code" => 2,
                            "message" => 'Error de Conexión de Base de Datos')
                    ));
            }
            exit;
        }
    }
}
