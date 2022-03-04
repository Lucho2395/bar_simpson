<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 29/10/2020
 * Time: 10:18
 */
require 'app/models/Usuario.php';
require 'app/models/Rol.php';
require 'app/models/Archivo.php';
class DatosController{
    //Variables especificas del controlador
    private $usuario;
    private $rol;
    private $archivo;
    //Variables fijas para cada llamada al controlador
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    public function __construct()
    {
        //Instancias especificas del controlador
        $this->usuario = new Usuario();
        $this->rol = new Rol();
        $this->archivo = new Archivo();
        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
    }
    //Funciones
    //Funcion para cambiar la contraseña del usuario
    public function guardar_contrasenha(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('contrasenha', 'POST',true,$ok_data,16,'texto',0);
            //Validacion de datos
            if($ok_data){
                //Ingresamos los datos para la nueva contraseña
                $result = $this->usuario->guardar_contrasenha($this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_), password_hash($_POST['contrasenha'], PASSWORD_BCRYPT));
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }
    //Funcion para guardar datos del usuario
    public function guardar_usuario(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('usuario_nicknamep', 'POST',true,$ok_data,16,'texto',0);
            $ok_data = $this->validar->validar_parametro('usuario_emailp', 'POST',false,$ok_data,60,'email',0);
            $ok_data = $this->validar->validar_parametro('usuario_imagenp', 'FILES',false,$ok_data,0,['jpg','png'],['jpg','png']);
            //Validacion de datos
            if($ok_data){
                //Creamos el modelo y ingresamos los datos a guardar
                $model = new Usuario();
                //Validamos la duplicidad del $_POST['rol_nombre'], para evitar duplicados
                if($this->usuario->validar_nickname_edicion(str_replace(" ", "",$_POST['usuario_nicknamep']), $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_))){
                    //Código 3: Controlador duplicado
                    $result = 3;
                    $message = "Ya existe un usuario con este nickname registrado";
                } else {
                    if($this->usuario->validar_correo_edicion($_POST['usuario_emailp'], $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_))){
                        //Código 3: Controlador duplicado
                        $result = 4;
                        $message = "Ya existe un usuario con este correo registrado";
                    } else {
                        //Ingresamos los datos a cambiar en el modelo
                        $usuario = $this->usuario->listar_usuario($this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_));
                        $model->id_usuario = $usuario->id_usuario;
                        $model->id_rol = $usuario->id_rol;
                        $model->usuario_nickname = $_POST['usuario_nicknamep'];
                        $model->usuario_email = $_POST['usuario_emailp'];
                        //Validamos si hay una nueva imagen, caso contrario ponemos la misma imagen del usuario
                        if($_FILES['usuario_imagenp']['name'] != null) {
                            //Conseguimos la extension del archivo y especificamos la ruta
                            $ext = pathinfo($_FILES['usuario_imagenp']['name'], PATHINFO_EXTENSION);
                            $file_path = "media/usuarios/" . $usuario->id_persona . '_' .date('dmYHis') . "." . $ext;
                            //Para subir archivos en general o imagenes sin comprimir
                            //if(move_uploaded_file($_FILES['usuario_imagenp']['tmp_name'], $file_path)){
                            //Para subir imagenes comprimidas
                            if($this->archivo->subir_imagen_comprimida($_FILES['usuario_imagenp']['tmp_name'], $file_path,false)){
                                $model->usuario_imagen = $file_path;
                            } else {
                                $model->usuario_imagen = $usuario->usuario_imagen;
                            }
                        } else {
                            $model->usuario_imagen = $usuario->usuario_imagen;
                        }
                        $model->usuario_estado = $usuario->usuario_estado;
                        $result = $this->usuario->guardar_usuario($model);
                    }
                }
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }
    //Funcion para guardar datos de la persona
    public function guardar_datos(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('persona_nombrep', 'POST',true,$ok_data,100,'texto',0);
            $ok_data = $this->validar->validar_parametro('persona_apellido_paternop', 'POST',true,$ok_data,30,'texto',0);
            $ok_data = $this->validar->validar_parametro('persona_apellido_maternop', 'POST',false,$ok_data,30,'texto',0);
            $ok_data = $this->validar->validar_parametro('persona_nacimientop', 'POST',false,$ok_data,100,'fecha','fecha');
            $ok_data = $this->validar->validar_parametro('persona_telefonop', 'POST',true,$ok_data,15,'texto',0);
            //Validacion de datos
            if($ok_data){
                //Creamos el modelo y ingresamos los datos a guardar
                $model = new Usuario();
                $model->id_persona = $this->encriptar->desencriptar($_SESSION['c_p'],_FULL_KEY_);
                $model->persona_nombre = $_POST['persona_nombrep'];
                $model->persona_apellido_paterno = $_POST['persona_apellido_paternop'];
                $model->persona_apellido_materno = $_POST['persona_apellido_maternop'];
                $model->persona_nacimiento = $_POST['persona_nacimientop'];
                $model->persona_telefono = $_POST['persona_telefonop'];
                //Guardamos el menú y recibimos el resultado
                $result = $this->usuario->guardar_persona($model);
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }
}
