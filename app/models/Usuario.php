<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 26/10/2020
 * Time: 23:21
 */
class Usuario{
    private $pdo;
    private $log;
    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }
    //Listamos todos los menus creados en el sistema, excepto los superadmin
    public function listar_usuarios(){
        try{
            $sql = 'select * from usuarios u inner join personas p on u.id_persona = p.id_persona inner join roles r on u.id_rol = r.id_rol where u.id_rol <> 2';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    //Lista la información del usuario según id
    public function listar_usuario($id_usuario){
        try{
            $sql = 'select u.id_usuario, u.id_persona, u.id_rol, u.usuario_nickname, u.usuario_email, u.usuario_imagen, u.usuario_estado, p.persona_nombre, p.persona_apellido_paterno, p.persona_apellido_materno, p.persona_nacimiento, p.persona_telefono, r.rol_nombre from usuarios u inner join personas p on u.id_persona = p.id_persona inner join roles r on u.id_rol = r.id_rol where u.id_usuario = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_usuario]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    //Listamos todos los menus creados en el sistema
    public function listar_usuarios_superadmin(){
        try{
            $sql = 'select * from usuarios u inner join personas p on u.id_persona = p.id_persona inner join roles r on u.id_rol = r.id_rol';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    //Validar nickanme
    public function validar_nickname($usuario_nickname){
        try{
            $sql = 'select id_usuario from usuarios where usuario_nickname = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$usuario_nickname]);
            $result = $stm->fetch();
            return isset($result->id_usuario);
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return true;
        }
    }


    public function listar(){
        try{
            $sql = 'select * from usuarios where id_usuario <> 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    //Validar correo
    public function validar_correo($usuario_email){
        try{
            $sql = 'select id_usuario from usuarios where usuario_email = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$usuario_email]);
            $result = $stm->fetch();
            return isset($result->id_usuario);
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return true;
        }
    }
    //Validar nickanme edicion
    public function validar_nickname_edicion($usuario_nickname, $id_usuario){
        try{
            $sql = 'select id_usuario from usuarios where usuario_nickname = ? and id_usuario <> ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$usuario_nickname, $id_usuario]);
            $result = $stm->fetch();
            return isset($result->id_usuario);
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return true;
        }
    }
    //Validar correo edicion
    public function validar_correo_edicion($usuario_email, $id_usuario){
        try{
            $sql = 'select id_usuario from usuarios where usuario_email = ? and id_usuario <> ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$usuario_email, $id_usuario]);
            $result = $stm->fetch();
            return isset($result->id_usuario);
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return true;
        }
    }
    //Listar persona por microtime
    public function listar_persona_microtime($persona_codigo){
        try{
            $sql = 'select id_persona from personas where person_codigo = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$persona_codigo]);
            $result = $stm->fetch();
            return $result->id_persona;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 0;
        }
    }
    //Registrar persona nueva al sistema
    public function guardar_persona($model){
        $fecha_actual = date('Y-m-d H:i:s');
        try{
            if(isset($model->id_persona)){
                $sql = 'update personas set
                        persona_nombre = ?,
                        persona_apellido_paterno = ?,
                        persona_apellido_materno = ?,
                        persona_nacimiento = ?,
                        persona_telefono = ?,
                        persona_modificacion = ?
                        where id_persona = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->persona_nombre,
                    $model->persona_apellido_paterno,
                    $model->persona_apellido_materno,
                    $model->persona_nacimiento,
                    $model->persona_telefono,
                    $fecha_actual,
                    $model->id_persona
                ]);
            } else {
                $sql = 'insert into personas (persona_nombre, persona_apellido_paterno, persona_apellido_materno, persona_nacimiento, persona_telefono, persona_creacion, persona_modificacion, person_codigo) values (?,?,?,?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->persona_nombre,
                    $model->persona_apellido_paterno,
                    $model->persona_apellido_materno,
                    $model->persona_nacimiento,
                    $model->persona_telefono,
                    $fecha_actual,
                    $fecha_actual,
                    $model->person_codigo
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }
    //Registrar usuario nuevo al sistema
    public function guardar_usuario($model){
        $fecha_actual = date('Y-m-d H:i:s');
        try{
            if(isset($model->id_usuario)){
                $sql = 'update usuarios set
                        usuario_nickname = ?,
                        usuario_email = ?,
                        usuario_imagen = ?,
                        usuario_estado = ?,
                        id_rol = ?,
                        usuario_ultima_modificacion = ?
                        where id_usuario = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->usuario_nickname,
                    $model->usuario_email,
                    $model->usuario_imagen,
                    $model->usuario_estado,
                    $model->id_rol,
                    $fecha_actual,
                    $model->id_usuario
                ]);
            } else {
                $sql = 'insert into usuarios (id_persona, id_rol, usuario_nickname, usuario_contrasenha, usuario_email, usuario_imagen, usuario_estado, usuario_creacion, usuario_ultimo_login, usuario_ultima_modificacion) values (?,?,?,?,?,?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_persona,
                    $model->id_rol,
                    $model->usuario_nickname,
                    $model->usuario_contrasenha,
                    $model->usuario_email,
                    $model->usuario_imagen,
                    $model->usuario_estado,
                    $fecha_actual,
                    $fecha_actual,
                    $fecha_actual
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }
    //Funcion para guardar una nueva contraseña
    public function guardar_contrasenha($id_usuario, $contrasenha){
        try{
            $sql = 'update usuarios set
                        usuario_contrasenha = ?
                        where id_usuario = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $contrasenha,$id_usuario
            ]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function listar_persona_microtime_($persona_codigo){
        try{
            $sql = 'select * from personas where person_codigo = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$persona_codigo]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function jalar_usuario($id_usuario){
        try{
            $sql = 'select * from personas p inner join usuarios u on p.id_persona = u.id_persona inner join roles r on u.id_rol = r.id_rol
                    where u.id_usuario = ? limit 1 ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_usuario]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

}
