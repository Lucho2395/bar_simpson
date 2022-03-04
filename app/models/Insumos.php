<?php

class Insumos
{
    private $pdo;
    private $log;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }


    public function guardar_insumos($model){
        try{
            $sql = 'insert into recursos (id_categoria, recurso_nombre, recurso_estado) values (?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_categoria,
                $model->recurso_nombre,
                $model->recurso_estado,
            ]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }


    public function listar_insumos(){
        try{
            $sql = 'select * from recursos r inner join categorias c on r.id_categoria = c.id_categoria';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_categorias(){
        try{
            $sql = 'select * from categorias';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    public function editar_insumos($model){
        try {
            $sql = 'update recursos set
            id_categoria = ?,
            recurso_nombre = ?
            where id_recurso = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_categoria,
                $model->recurso_nombre,
                $model->id_recurso
            ]);
            return 1;
        } catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $result = false;
        }
        return 2;
    }

}