<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 14/10/2020
 * Time: 11:19
 */
class Token{
    private $pdo;
    private $log;
    private $encriptar;
    function __construct()
    {
        $this->log = new Log();
        $this->pdo = Database::getConnection();
        $this->encriptar = new Encriptar();
    }
    //Funcion para validar si el token es valido
    public function validar_token($token){
        try{
            //Desencriptamos el token para obtener el codigo de usuario y el hash de la contraseña
            $simple_token = $this->encriptar->desencriptacion_triple($token);
            if(!$simple_token){
                $result = false;
            } else {
                //Obtenemos los datos del usuario en base a su id
                $datos_usuario = $this->obtener_datos_usuario($simple_token[0]);
                if(!isset($datos_usuario->usuario_estado)){
                    $result = false;
                } else {
                    //Desencriptamos la contraseña del usuario usando la fecha de creacion
                    //$original_pass = $this->obtener_contrasenha($simple_token[0]);
                    $hash = $this->encriptar->desencriptar($simple_token[1], $datos_usuario->usuario_creacion);
                    //Verificamos el password
                    if(password_verify($datos_usuario->usuario_contrasenha, $hash)){
                        //Si es correcto, creamos la variable de sesion a usar
                        $_SESSION['c_u'] = $this->encriptar->encriptar($simple_token[0],_FULL_KEY_);
                        $_SESSION['s_'] = $this->encriptar->encriptar($datos_usuario->usuario_estado,_FULL_KEY_);
                        $_SESSION['ru'] = $this->encriptar->encriptar($datos_usuario->id_rol,_FULL_KEY_);
                        $result = true;
                    } else {
                        $result = false;
                    }
                }
            }

        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = false;
        }
        return $result;
    }
    //Funcion para obtener fecha usuario
    function obtener_fecha_usuario($id_usuario){
        try{
            $sql = 'select usuario_creacion from usuarios where id_usuario = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_usuario]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = '1995-01-01';
        }
        return $result->usuario_creacion;
    }
    //Funcion para obtener datos del usuario
    function obtener_datos_usuario($id_usuario){
        try{
            $sql = 'select usuario_creacion, id_rol, usuario_contrasenha, usuario_estado from usuarios where id_usuario = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_usuario]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    //Funcion para obtener rol del usuario
    function obtener_rol_usuario($id_usuario){
        try{
            $sql = 'select id_rol from usuarios where id_usuario = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_usuario]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 0;
        }
        return $result->id_rol;
    }
    //Funcion para obtener estado del usuario
    function obtener_estado_usuario($id_usuario){
        try{
            $sql = 'select usuario_estado from usuarios where id_usuario = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_usuario]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 0;
        }
        return $result->usuario_estado;
    }
    //Funcion para obtener pass
    function obtener_contrasenha($id_usuario){
        try{
            $sql = 'select usuario_contrasenha from usuarios where id_usuario = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_usuario]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = '';
        }
        return $result->usuario_contrasenha;
    }
}