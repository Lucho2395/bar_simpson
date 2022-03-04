<?php

class Negocio
{
    private $pdo;
    private $log;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }


    public function listar($parametro){
        try{
            $sql = 'select * from negocios n inner join ciudad c on n.id_ciudad = c.id_ciudad where n.negocio_nombre like ? order by negocio_nombre asc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute(['%'.$parametro.'%']);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listarnegocio(){
        try{
            $sql = 'select * from negocios';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_negocio($id){
        try{
            $sql = 'select * from usuarios_negocio un inner join negocios n on un.id_negocio = n.id_negocio where un.id_usuario = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_ciudad(){
        try{
            $sql = 'select * from ciudad';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();

        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    public function guardar_negocio($model){
        try{
            if(isset($model->id_negocio)){
                $sql = 'update negocios set
                        id_ciudad = ?,
                        negocio_nombre = ?,
                        negocio_direccion = ?,
                        negocio_foto = ?,
                        negocio_ruc = ?,
                        negocio_telefono = ?
                        where id_negocio = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_ciudad,
                    $model->negocio_nombre,
                    $model->negocio_direccion,
                    $model->negocio_foto,
                    $model->negocio_ruc,
                    $model->negocio_telefono,
                    $model->id_negocio
                ]);
            } else {
                $sql = 'insert into negocios (id_ciudad, negocio_nombre, negocio_direccion, negocio_ruc, negocio_foto, negocio_telefono, negocio_estado, negocio_fecha_registro) values (?,?,?,?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_ciudad,
                    $model->negocio_nombre,
                    $model->negocio_direccion,
                    $model->negocio_ruc,
                    $model->negocio_foto,
                    $model->negocio_telefono,
                    $model->negocio_estado,
                    $model->negocio_fecha_registro
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }


    public function sacar_foto($id){
        try{
            $sql = 'select negocio_foto from negocios where id_negocio = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
            return $result->negocio_foto;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 0;
        }
    }


    public function guardar_sucursal($model){
        try{
            if(isset($model->id_sucursal)){
                $sql = 'update sucursal set
                        id_ciudad = ?,
                        id_negocio = ?,
                        sucursal_nombre = ?,
                        sucursal_direccion = ?,
                        sucursal_ruc = ?,
                        sucursal_foto = ?,
                        sucursal_telefono = ?
                        where id_sucursal = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_ciudad,
                    $model->id_negocio,
                    $model->sucursal_nombre,
                    $model->sucursal_direccion,
                    $model->sucursal_ruc,
                    $model->sucursal_foto,
                    $model->sucursal_telefono,
                    $model->id_sucursal
                ]);
            } else {
                $sql = 'insert into sucursal (id_ciudad, id_negocio, sucursal_nombre, sucursal_direccion, sucursal_ruc, sucursal_foto, sucursal_telefono, sucursal_estado, sucursal_fecha_registro) values (?,?,?,?,?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_ciudad,
                    $model->id_negocio,
                    $model->sucursal_nombre,
                    $model->sucursal_direccion,
                    $model->sucursal_ruc,
                    $model->sucursal_foto,
                    $model->sucursal_telefono,
                    $model->sucursal_estado,
                    $model->sucursal_fecha_registro
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }


    public function listar_sucursal(){
        try {

            $sql = 'select * from sucursal s inner join negocios n  on s.id_negocio = n.id_negocio inner join ciudad c on n.id_ciudad = c.id_ciudad'  ;
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();

        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }



    public function datos_sucursal($id){
        try {
            $sql = 'select * from sucursal where id_sucursal = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }


    public function foto_sucursal($id){
        try{
            $sql = 'select sucursal_foto from sucursal where id_sucursal = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
            return $result->sucursal_foto;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 0;
        }
    }


    public function guardar_usuario_sucursal($model){
        try{
            if(isset($model->id_usuario_sucursal)){
                $sql = 'update usuarios_sucursal set
                        id_sucursal = ?,
                        id_usuario = ?,
                        id_rol = ?
                        where id_usuario_sucursal = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_sucursal,
                    $model->id_usuario,
                    $model->id_rol,
                    $model->id_usuario_sucursal
                ]);
            } else {
                $sql = 'insert into usuarios_sucursal (id_sucursal, id_usuario, id_rol, usuario_sucursal_fecha, usuario_sucursal_estado) values (?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_sucursal,
                    $model->id_usuario,
                    $model->id_rol,
                    $model->usuario_sucursal_fecha,
                    $model->usuario_sucursal_estado
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }


    public function listar_usuario_sucursal($id){
        try {
            $sql = 'select * from usuarios_sucursal us inner join roles r on us.id_rol = r.id_rol inner join usuarios u on us.id_usuario = u.id_usuario inner join personas p on u.id_persona = p.id_persona where us.id_sucursal = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }


    public function guardar_usuario_negocio($model){
        try{
            if(isset($model->id_usuario_negocio)){
                $sql = 'update usuarios_negocio set
                        id_negocio = ?,
                        id_usuario = ?
                        where id_usuario_negocio = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_negocio,
                    $model->id_usuario,
                    $model->id_usuario_negocio
                ]);
            } else {
                $sql = 'insert into usuarios_negocio (id_negocio, id_usuario, usuario_negocio_fecha, usuario_negocio_estado) values (?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_negocio,
                    $model->id_usuario,
                    $model->usuario_negocio_fecha,
                    $model->usuario_negocio_estado
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }


    public function listar_usuario_negcio($id){
        try {
            $sql = 'select * from usuarios_negocio un inner join usuarios u on un.id_usuario = u.id_usuario inner join personas p 
                    on u.id_persona = p.id_persona where un.id_negocio = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }


    public function listar_sucursal_egresos(){
        try {
            $sql = 'select * from sucursal where sucursal_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function listar_usuario(){
        try {
            $sql = 'select * from negocios';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function datos_negocio($id){
        try {
            $sql = 'select * from negocios where id_negocio = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }


    public function cambiar_estado($id_negocio, $negocio_estado){
        try {
            $sql = "update negocios set
                negocio_estado = ?
                where id_negocio = ?";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $negocio_estado, $id_negocio
            ]);
            $result = 1;
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }


    public function cambiar_estado_sucursal($id_sucursal, $sucursal_estado){
        try {
            $sql = "update sucursal set
                sucursal_estado = ?
                where id_sucursal = ?";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $sucursal_estado, $id_sucursal
            ]);
            $result = 1;
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }


    public function cambiar_estado_usuario_negocio($id_usuario_negocio, $usuario_negocio_estado){
        try {
            $sql = "update usuarios_negocio set
                usuario_negocio_estado = ?
                where id_usuario_negocio = ?";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $usuario_negocio_estado, $id_usuario_negocio
            ]);
            $result = 1;
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }


    public function cambiar_estado_usuario_sucursal($id_usuario_sucursal, $usuario_sucursal_estado){
        try {
            $sql = "update usuarios_sucursal set
                usuario_sucursal_estado = ?
                where id_usuario_sucursal = ?";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $usuario_sucursal_estado, $id_usuario_sucursal
            ]);
            $result = 1;
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }


}