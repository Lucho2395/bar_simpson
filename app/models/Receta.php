<?php
/**
 * Created by PhpStorm
 * User: Franz
 * Date: 15/03/2021
 * Time: 12:47
 */

class Receta{
    private $pdo;
    private $log;
    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }

    public function listar_recetas(){
        try{
            $sql = 'select * from recetas r inner join usuarios u on r.id_usuario = u.id_usuario order by receta_nombre asc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    //FUNCION PARA VALIDAR SI HAY DETALLE EN UNA RECETA PARA PODER ELIMINAR
    public function validar_contenido($id_receta){
        try{
            $sql = 'select * from detalle_recetas where id_receta = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_receta]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function receta($id){
        try{
            $sql = 'select * from recetas where id_receta = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar(){
        try{
            $sql = 'select * from recetas order by receta_nombre asc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_unidad_medida(){
        try{
            $sql = 'select * from unidad_medida where medida_activo = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    //FUNCIO PARA LA JUGADA
    public function listar_unidad_precio($id_recurso_sede){
        try{
            $sql = 'select * from recursos_sede rs inner join unidad_medida um on rs.id_medida = um.id_medida where id_recurso_sede = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_recurso_sede]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_conversiones($id_recurso_sede){
        try{
            $sql = 'select * from conversiones c inner join recursos_sede rs on c.id_recurso_sede = rs.id_recurso_sede inner join unidad_medida um on c.conversion_unidad_medida = um.id_medida
                    where c.id_recurso_sede = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_recurso_sede]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    //Validar receta_nombre
    public function validar_receta_nombre($receta_nombre)
    {
        try {
            $sql = 'select id_receta from recetas where receta_nombre = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$receta_nombre]);
            $result = $stm->fetch();
            return isset($result->id_receta);
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            return true;
        }
    }
    //Registrar nuevo receta
    public function guardar_receta($model){
        $fecha_actual = date('Y-m-d H:i:s');
        try{
            if(isset($model->id_receta)){
                $sql = 'update recetas set
                        receta_nombre = ?
                        where id_receta = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->receta_nombre,
                    $model->id_receta
                ]);
            } else {
                $sql = 'insert into recetas (id_usuario, receta_nombre, receta_fecha, receta_estado) values (?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_usuario,
                    $model->receta_nombre,
                    $fecha_actual,
                    $model->receta_estado
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    //Registrar nuevo detalle_receta
    public function guardar_detalle_receta($model){
        try{
            if(isset($model->id_detalle_receta)){
                $sql = 'update detalle_recetas set
                        id_receta = ?,
                        id_recursos_sede = ?,
                        detalle_receta_cantidad = ?,
                        detalle_receta_precio = ?
                        where id_detalle_receta = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_receta,
                    $model->id_recursos_sede,
                    $model->detalle_receta_cantidad,
                    $model->detalle_receta_precio,
                    $model->id_detalle_receta
                ]);
            } else {
                $sql = 'insert into detalle_recetas (id_receta, id_recursos_sede, detalle_receta_unidad_medida, detalle_receta_cantidad, detalle_receta_precio,
                        detalle_receta_estado) values (?,?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_receta,
                    $model->id_recursos_sede,
                    $model->detalle_receta_unidad_medida,
                    $model->detalle_receta_cantidad,
                    $model->detalle_receta_precio,
                    $model->detalle_receta_estado
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function listar_detalle_recetas($id){
        try{
            $sql = 'select * from recetas r inner join detalle_recetas dr on r.id_receta = dr.id_receta inner join recursos_sede rs on dr.id_recursos_sede = rs.id_recurso_sede 
                    inner join recursos re on rs.id_recurso = re.id_recurso inner join unidad_medida um on rs.id_medida = um.id_medida where r.id_receta = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    public function listar_detalle_recetas_conversion($id){
        try{
            $sql = 'select * from detalle_recetas dc inner join conversiones c on dc.detalle_receta_unidad_medida = c.id_conversion inner join unidad_medida um on c.conversion_unidad_medida = um.id_medida where dc.id_detalle_receta = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function monto_total_receta($id){
        try{
            $sql = 'select SUM(detalle_receta_precio) total from detalle_recetas where id_receta = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function suma_sub_receta($id){
        try{
            $sql = 'select SUM(sub_receta_total) total from sub_recetas where id_receta = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function detalle_receta($id){
        try{
            $sql = 'select * from detalle_recetas WHERE id_detalle_receta = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    //Lista la información del receta según id
    public function listar_receta($id_receta){
        try{
            $sql = 'select * from recetas r inner join usuarios u on r.id_usuario = u.id_usuario where r.id_receta = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_receta]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    //Lista la información del detalle_receta según id
    public function listar_detalle_receta($id_detalle_receta){
        try{
            $sql = 'select * from detalle_recetas d inner join recetas r on d.id_receta = r.id_receta inner join recursos_sede re on d.id_recursos_sede = re.id_recursos_sede where d.id_detalle_receta = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_detalle_receta]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }



    //Eliminar receta
    public function eliminar_receta($id_receta){
        try{
            $sql = 'delete from recetas where id_receta = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_receta]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    //Eliminar detalle_receta
    public function eliminar_detalle_receta($id_detalle_receta){
        try{
            $sql = 'delete from detalle_recetas where id_detalle_receta = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_detalle_receta]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function eliminar_sub_receta($id_sub_receta){
        try{
            $sql = 'delete from sub_recetas where id_sub_receta = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_sub_receta]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }


    public function guardar_sub_receta($model){
        try{
            $sql = 'insert into sub_recetas (id_medida, id_receta, id_receta_2, sub_receta_cantidad, sub_receta_total, sub_receta_fecha_registro, sub_receta_estado) values (?,?,?,?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_medida,
                $model->id_receta,
                $model->id_receta_2,
                $model->sub_receta_cantidad,
                $model->sub_receta_total,
                $model->sub_receta_fecha_registro,
                $model->sub_receta_estado
            ]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }


    public function listar_sub_recetas($id){
        try{
            $sql = 'select * from sub_recetas sr inner join recetas r on sr.id_receta_2 = r.id_receta inner join unidad_medida um on sr.id_medida = um.id_medida where sr.id_receta = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

}