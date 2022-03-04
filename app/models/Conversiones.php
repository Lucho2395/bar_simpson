<?php

class Conversiones
{
    private $pdo;
    private $log;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }

    public function jalar_recursos($id_recurso_sede){
        try{
            $sql = 'select * from recursos_sede rs inner join recursos r on rs.id_recurso = r.id_recurso inner join unidad_medida um on rs.id_medida = um.id_medida
                    where rs.id_recurso_sede = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_recurso_sede]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function recursos_sede($id_usuario){
        try{
            $sql = 'select * from recursos_sede rs inner join sucursal s on rs.id_sucursal = s.id_sucursal inner join negocios n on s.id_negocio = n.id_negocio
                    inner join recursos r on rs.id_recurso = r.id_recurso where rs.id_usuario_creacion = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_usuario]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_conversiones(){
        try{
            $sql = 'select * from conversiones c inner join recursos_sede rs on c.id_recurso_sede = rs.id_recurso_sede inner join recursos r on rs.id_recurso = r.id_recurso
                    inner join unidad_medida um on c.conversion_unidad_medida = um.id_medida';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function medidas(){
        try{
            $sql = 'select * from unidad_medida where medida_activo = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function guardar_nueva_conversion($model){
        try{
            $sql = 'insert into conversiones (id_recurso_sede, conversion_cantidad, conversion_unidad_medida, conversion_fecha_registro, conversion_estado)
                    values (?,?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_recurso_sede,
                $model->conversion_cantidad,
                $model->conversion_unidad_medida,
                $model->conversion_fecha_registro,
                $model->conversion_estado
            ]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function eliminar_conversion($id_conversion){
        try{
            $sql = 'delete from conversiones where id_conversion = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_conversion]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

}