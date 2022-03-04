<?php

require 'app/models/Archivo.php';
require 'app/models/Usuario.php';
require 'app/models/Rol.php';
require 'app/models/Conversiones.php';

class ConversionesController
{
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $archivo;
    private $usuario;
    private $rol;

    private $conversion;

    public function __construct()
    {
        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
        $this->archivo = new Archivo();
        $this->usuario = new Usuario();
        $this->rol = new Rol();
        $this->conversion = new Conversiones();

    }

    public function gestionar(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
            $recurso_sede = $this->conversion->recursos_sede($id_usuario);

            $conversiones = $this->conversion->listar_conversiones();
            $medida = $this->conversion->medidas();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'conversion/gestionar.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }


    //FUNCIONES
    public function jalar_recursos(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        try {
            $id_recurso_sede = $_POST['id_recurso_sede'];
            $result = $this->conversion->jalar_recursos($id_recurso_sede);
            $datos_recursos = "<select class='form-control' id='id_medida' name='id_medida'>";
            $datos_precio = "<select class='form-control' id='precio' name='precio'>";
            foreach($result as $c){
                $datos_recursos.="<option value='". $c->medida_nombre."'>". $c->medida_nombre."</option>";
                $datos_precio.= "<option value='". $c->recurso_sede_precio."'>". $c->recurso_sede_precio."</option>";
            }
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("datos_recursos" => $datos_recursos, "datos_precio" => $datos_precio));
    }


    public function guardar_nueva_conversion(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validacion de datos
            if($ok_data) {
                $model = new Conversiones();
                $fecha = date('Y-m-d H:i:s');
                $model->id_recurso_sede = $_POST['id_recurso_sede'];
                $model->conversion_cantidad = $_POST['conversion_cantidad'];
                $model->conversion_unidad_medida = $_POST['conversion_unidad_medida'];
                $model->conversion_fecha_registro = $fecha;
                $model->conversion_estado = 1;

                $result = $this->conversion->guardar_nueva_conversion($model);
            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function eliminar_conversion(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_conversion', 'POST',true,$ok_data,11,'numero',0);
            //Validacion de datos
            if($ok_data) {
                $id_conversion = $_POST['id_conversion'];
                $result = $this->conversion->eliminar_conversion($id_conversion);
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

}