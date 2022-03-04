<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 10/10/2020
 * Time: 0:46
 */
class Sesion{
    private $pdo;
    private $log;
    private $encriptar;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->log = new Log();
        $this->encriptar = new Encriptar();
    }
    //Obtiene datos del usuario actual consultado
    public function habilitar_global(){
        try{
            //$sql = "set global sql_mode=(select replace(@@sql_mode,'ONLY_FULL_GROUP_BY',''));";
            $sql = "SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));";
            //$sql = "set global sql_mode=(select replace(@@sql_mode,'only_full_group_by',''));";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = true;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = false;
        }
        return $result;
    }

    public function obtener_informacion($id_usuario){
        try{
            $sql = 'select u.id_usuario, u.id_persona, u.usuario_contrasenha, u.usuario_creacion , u.usuario_nickname, u.usuario_imagen, u.usuario_email, u.usuario_estado, p.persona_nombre, p.persona_apellido_paterno, p.persona_apellido_materno, p.persona_nacimiento, p.persona_telefono, u.id_rol, r.rol_nombre from usuarios u inner join personas p on u.id_persona = p.id_persona inner join roles r on r.id_rol = u.id_rol where u.id_usuario = ? and u.usuario_estado = 1 limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_usuario]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = false;
        }
        return $result;
    }
    //Obtiene datos del usuario segun el usuario_nickname enviado
    public function consultar_usuario($usuario_nickname){
        try{
            $sql = 'select u.id_usuario, u.id_persona, u.usuario_contrasenha, u.usuario_creacion , u.usuario_nickname, u.usuario_imagen, u.usuario_estado, u.usuario_email, p.persona_nombre, p.persona_apellido_paterno, p.persona_apellido_materno, p.persona_nacimiento, p.persona_telefono, u.id_rol, r.rol_nombre from usuarios u inner join personas p on u.id_persona = p.id_persona inner join roles r on u.id_rol = r.id_rol where u.usuario_nickname = ? and usuario_estado = 1 limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$usuario_nickname]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = false;
        }
        return $result;
    }

    //Obtiene datos del usuario segun el usuario_nickname enviado
    public function consultar_usuario_app($usuario_nickname){
        try{
            $sql = 'select u.id_usuario,u.usuario_contrasenha,u.usuario_creacion,u.usuario_nickname,u.usuario_imagen, 
                    p.persona_nombre, p.persona_apellido_paterno, p.persona_apellido_materno,
                    u.id_rol, r.rol_nombre, n.id_negocio,n.negocio_nombre, n.negocio_foto,n.negocio_ruc , s.id_sucursal
                    from usuarios u inner join personas p on u.id_persona = p.id_persona inner join roles r on u.id_rol = r.id_rol 
                    inner join usuarios_sucursal un on u.id_usuario = un.id_usuario
                    inner join sucursal s on un.id_sucursal = s.id_sucursal inner join negocios n on s.id_negocio = n.id_negocio
                    where u.usuario_nickname = ? and usuario_estado = 1 limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$usuario_nickname]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = false;
        }
        return $result;
    }

    //Actualizar la variable $_SESSION del usuario en su sesion local
    public function generar_sesion($usuario, $uso_cookies = false){
        //Si $user trae datos, actualiza las variables de sesión
        $_SESSION['c_u'] = $this->encriptar->encriptar($usuario->id_usuario,_FULL_KEY_);
        $_SESSION['c_p'] = $this->encriptar->encriptar($usuario->id_persona,_FULL_KEY_);
        $_SESSION['_n'] = $this->encriptar->encriptar($usuario->usuario_nickname,_FULL_KEY_);
        $_SESSION['u_e'] = $this->encriptar->encriptar($usuario->usuario_email,_FULL_KEY_);
        $_SESSION['u_i'] = $this->encriptar->encriptar($usuario->usuario_imagen,_FULL_KEY_);
        $_SESSION['s_'] = $this->encriptar->encriptar($usuario->usuario_estado,_FULL_KEY_);
        $_SESSION['p_n'] = $this->encriptar->encriptar($usuario->persona_nombre,_FULL_KEY_);
        $_SESSION['p_p'] = $this->encriptar->encriptar($usuario->persona_apellido_paterno,_FULL_KEY_);
        $_SESSION['p_m'] = $this->encriptar->encriptar($usuario->persona_apellido_materno,_FULL_KEY_);
        $_SESSION['p_nc'] = $this->encriptar->encriptar($usuario->persona_nacimiento,_FULL_KEY_);
        $_SESSION['p_t'] = $this->encriptar->encriptar($usuario->persona_telefono,_FULL_KEY_);
        $_SESSION['ru'] = $this->encriptar->encriptar($usuario->id_rol,_FULL_KEY_);
        $_SESSION['rn'] = $this->encriptar->encriptar($usuario->rol_nombre,_FULL_KEY_);
        $_SESSION['tn'] = $this->encriptar->encriptacion_triple($usuario->usuario_contrasenha, $usuario->id_usuario, $usuario->usuario_creacion);
        if($uso_cookies){
            setcookie('c_u', $this->encriptar->encriptar($usuario->id_user,_FULL_KEY_), time() + _TIEMPO_COOKIE, "/; samesite=strict");
        }
    }
    //Guarda el último inicio de sesión del usuario
    public function ultimo_logueo($id_usuario){
        try{
            $fecha = date("Y-m-d H:i:s");
            $sql = 'update usuarios set usuario_ultimo_login = ? where id_usuario = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $fecha,
                $id_usuario
            ]);
            $result = true;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = false;
        }
        return $result;
    }
    //Cierra la sesión local del usuario
    public function cerrar_sesion(){
        unset($_SESSION['c_u']);
        unset($_SESSION['c_p']);
        unset($_SESSION['_n']);
        unset($_SESSION['u_e']);
        unset($_SESSION['u_i']);
        unset($_SESSION['s_']);
        unset($_SESSION['p_n']);
        unset($_SESSION['p_p']);
        unset($_SESSION['p_m']);
        unset($_SESSION['p_nc']);
        unset($_SESSION['p_t']);
        unset($_SESSION['ru']);
        unset($_SESSION['rn']);
        unset($_SESSION['tn']);

        setcookie('c_u', '1', time() - _TIEMPO_COOKIE, "/; samesite=strict");
        session_destroy();
        session_start();
    }
    //Cierra la sesión del usuario e redirecciona a la página principal del sistema
    public function finalizar_sesion(){
        $this->cerrar_sesion();
        header('Location: ' . _SERVER_);
    }
}
