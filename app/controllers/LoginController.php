<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 12/10/2020
 * Time: 17:28
 */

class LoginController{
    //Variables fijas para cada llamada al controlador
    private $log;
    private $sesion;
    private $encriptar;
    private $validar;
    public function __construct()
    {
        //Instancias fijas para cada llamada al controlador
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->encriptar = new Encriptar();
        $this->validar = new Validar();
    }
    //Vistas/Opciones
    //Vista de acceso al login
    public function inicio(){
        require _VIEW_PATH_ . 'login/inicio.php';
    }
    //Funciones/Permisos
    //Funcion para validar la sesión del usuario y generar las variables de $_SESSION o enviar el array de datos del usuario
    public function validar_sesion(){
        //Array donde irán los datos del usuario en caso de que el inicio de sesión sea desde una app
        $usuario = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('usuario_nickname', 'POST',true,$ok_data,16,'texto',0);
            $ok_data = $this->validar->validar_parametro('usuario_contrasenha', 'POST',true,$ok_data,32,'texto',0);
            //Validacion de datos
            if($ok_data){
                //Consultamos los datos del usuario en base al nickname enviado
                $usuario = $this->sesion->consultar_usuario($_POST['usuario_nickname']);
                //Verificamos si existe algún usuario con el nickname consultado,
                //caso contrario devolvemos error de validacion
                if(isset($usuario->id_usuario)){
                    //Validamos el hash de contraseña con la que envió el usuario. Si devuelve true, quiere decir que la validación fue exitosa
                    if(password_verify($_POST['usuario_contrasenha'], $usuario->usuario_contrasenha)){
                        //Registramos el inicio de sesión del usuario
                        $this->sesion->ultimo_logueo($usuario->id_usuario);
                        //Verificamos si la consulta se hizo desde una app
                        if(isset($_POST['app']) && $_POST['app'] == true){
                            $usuario = array(
                                "c_u" => $usuario->id_usuario,
                                "c_p" => $usuario->id_persona,
                                "_n" => $usuario->usuario_nickname,
                                "u_e" => $usuario->usuario_email,
                                "u_i" => _SERVER_ . $usuario->usuario_imagen,
                                "p_n" => $usuario->persona_nombre,
                                "p_p" => $usuario->persona_apellido_paterno,
                                "p_m" => $usuario->persona_apellido_materno,
                                "ru" => $usuario->id_rol,
                                "rn" => $usuario->rol_nombre,
                                "tn" => $this->encriptar->encriptacion_triple($usuario->usuario_contrasenha, $usuario->id_usuario, $usuario->usuario_creacion)
                            );
                        } else {
                            //Validamos si el usuario seleccionó la opción de recordar contraseña
                            if(isset($_POST['recordar']) && $_POST['recordar'] == "true"){
                                //Generamos la sesión del usuario usando cookies
                                $this->sesion->generar_sesion($usuario, true);
                            } else {
                                //Generamos la sesión del usuario sin usar cookies
                                $this->sesion->generar_sesion($usuario);
                            }
                        }
                        //Devolvemos 1 para indicar que todo salió bien
                        $result = 1;
                    } else {
                        //Código 3: Usuario o contraseña incorrectos
                        $usuario = [];
                        $result = 3;
                        $message = "Usuario o contraseña incorrectos";
                    }
                } else {
                    //Código 3: Usuario o contraseña incorrectos
                    $usuario = [];
                    $result = 3;
                    $message = "Usuario o contraseña incorrectos";
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
        //Si esta declarada la variable $_POST['app'], devolvemos el json que será consumido como ws,
        // caso contrario, sólo retornamos los códigos
        if(isset($_POST['app']) && $_POST['app'] == true){
            $data = array(
                "result" => array("code" => $result, "message" => $message),
                "data" => $usuario);
        } else {
            $data = array("result" => array("code" => $result, "message" => $message));
        }
        //Retornamos el json
        echo json_encode($data);
    }

    public function validar_sesion_app(){
        //Array donde irán los datos del usuario en caso de que el inicio de sesión sea desde una app
        $usuario = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('usuario_nickname', 'POST',true,$ok_data,16,'texto',0);
            $ok_data = $this->validar->validar_parametro('usuario_contrasenha', 'POST',true,$ok_data,32,'texto',0);
            //Validacion de datos
            if($ok_data){
                //Consultamos los datos del usuario en base al nickname enviado
                $usuario = $this->sesion->consultar_usuario_app($_POST['usuario_nickname']);
                //Verificamos si existe algún usuario con el nickname consultado,
                //caso contrario devolvemos error de validacion
                if(isset($usuario->id_usuario)){
                    //Validamos el hash de contraseña con la que envió el usuario. Si devuelve true, quiere decir que la validación fue exitosa
                    if(password_verify($_POST['usuario_contrasenha'], $usuario->usuario_contrasenha)){
                        //Registramos el inicio de sesión del usuario
                        $this->sesion->ultimo_logueo($usuario->id_usuario);
                        //Verificamos si la consulta se hizo desde una app
                        if(isset($_POST['app']) && $_POST['app'] == true){
                            $usuario = array(
                                "c_u" => $usuario->id_usuario,
                                "c_p" => $usuario->id_persona,
                                "_n" => $usuario->usuario_nickname,
                                "u_e" => $usuario->usuario_email,
                                "u_i" => _SERVER_ . $usuario->usuario_imagen,
                                "p_n" => $usuario->persona_nombre,
                                "p_p" => $usuario->persona_apellido_paterno,
                                "p_m" => $usuario->persona_apellido_materno,
                                "ru" => $usuario->id_rol,
                                "rn" => $usuario->rol_nombre,
                                "n_i" => $usuario->id_negocio,
                                "n_n" => $usuario->negocio_nombre,
                                "n_f" => $usuario->negocio_foto,
                                "n_r" => $usuario->negocio_ruc,
                                "i_d" => $usuario->id_sucursal,
                                "tn" => $this->encriptar->encriptacion_triple($usuario->usuario_contrasenha, $usuario->id_usuario, $usuario->usuario_creacion)
                            );
                        } else {
                            //Validamos si el usuario seleccionó la opción de recordar contraseña
                            if(isset($_POST['recordar']) && $_POST['recordar'] == "true"){
                                //Generamos la sesión del usuario usando cookies
                                $this->sesion->generar_sesion($usuario, true);
                            } else {
                                //Generamos la sesión del usuario sin usar cookies
                                $this->sesion->generar_sesion($usuario);
                            }
                        }
                        //Devolvemos 1 para indicar que todo salió bien
                        $result = 1;
                    } else {
                        //Código 3: Usuario o contraseña incorrectos
                        $usuario = [];
                        $result = 3;
                        $message = "Usuario o contraseña incorrectos";
                    }
                } else {
                    //Código 3: Usuario o contraseña incorrectos
                    $usuario = [];
                    $result = 3;
                    $message = "Usuario o contraseña incorrectos";
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
        //Si esta declarada la variable $_POST['app'], devolvemos el json que será consumido como ws,
        // caso contrario, sólo retornamos los códigos
        if(isset($_POST['app']) && $_POST['app'] == true){
            $data = array(
                "result" => array("code" => $result, "message" => $message),
                "data" => $usuario);
        } else {
            $data = array("result" => array("code" => $result, "message" => $message));
        }
        //Retornamos el json
        echo json_encode($data);
    }
}
