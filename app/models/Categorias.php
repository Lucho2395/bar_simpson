<?php

class Categorias
{
    private $pdo;
    private $log;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }

    //LISTAR CATEGORIAS
    public function listar_categorias(){
        try {
            $sql = 'select * from categorias';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }


    public function guardar_categorias($model){
        try{
            if(isset($model->id_categoria)){
                $sql = 'update categorias set
                        categoria_nombre = ?
                        where id_categoria = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->categoria_nombre,
                    $model->id_categoria
                ]);
            } else {
                $sql = 'insert into categorias (categoria_nombre, categoria_fecha_registro,categoria_tipo, categoria_estado) values (?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->categoria_nombre,
                    $model->categoria_fecha_registro,
                    $model->categoria_tipo,
                    $model->categoria_estado
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function eliminar_categoria($id_categoria, $estado){
        try{
            $sql = 'update categorias set categoria_estado = ? where id_categoria = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$estado,$id_categoria]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

}