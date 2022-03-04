<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 20/10/2020
 * Time: 17:03
 */
class Rol{
    private $pdo;
    private $log;
    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }
    //Listamos todos los roles existentes en el sistema
    public function listar_roles(){
        try{
            $sql = 'select * from roles';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    //Listamos todos los roles existentes en el sistema para superadmin
    public function listar_roles_superadmin(){
        try{
            $sql = 'select * from roles where id_rol <> 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    //Listamos todos los roles existentes en el sistema para admin
    public function listar_roles_usuario(){
        try{
            $sql = 'select * from roles where id_rol <> 1 and id_rol <> 2';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    //Listamos el rol segun el id recibido
    public function listar_rol($id_rol){
        try{
            $sql = 'select * from roles where id_rol = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_rol]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    //Busca si existe un rol repetido
    public function buscar_rol($rol_nombre){
        try{
            $sql = 'select id_rol from roles where rol_nombre = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$rol_nombre]);
            $result = $stm->fetch();
            if(isset($result->id_rol)){
                return true;
            } else {
                return false;
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    //Guardamos los cambios en el rol
    public function guardar_rol($model){
        try{
            if(isset($model->id_rol)){
                $sql = 'update roles set
                        rol_nombre = ?,
                        rol_descripcion = ?,
                        rol_estado = ?
                        where id_rol = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->rol_nombre,
                    $model->rol_descripcion,
                    $model->rol_estado,
                    $model->id_rol
                ]);
            } else {
                $sql = 'insert into roles (rol_nombre, rol_descripcion, rol_estado) values (?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->rol_nombre,
                    $model->rol_descripcion,
                    $model->rol_estado
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }
}
