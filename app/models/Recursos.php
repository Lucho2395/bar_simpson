<?php

class Recursos
{
    private $pdo;
    private $log;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }


    public function listar_negocios($id){
        try{
            $sql = 'select * from usuarios_negocio un inner join negocios n on un.id_negocio = n.id_negocio where un.id_usuario = ? ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetchAll();

        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_negocios_(){
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

    public function listar_sucursales($id){
        try{
            $sql = 'select * from usuarios_sucursal us inner join sucursal s on us.id_sucursal = s.id_sucursal where us.id_usuario = ? ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetchAll();

        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_sucursales_(){
        try{
            $sql = 'select * from sucursal where sucursal_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
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



    public function guardar_categoria($model){
        try{
            $sql = 'insert into categorias_negocio (id_usuario_creacion, id_negocio, id_categoria, recurso_categoria_estado, recurso_categoria_fecha) values (?,?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_usuario_creacion,
                $model->id_negocio,
                $model->id_categoria,
                $model->recurso_categoria_estado,
                $model->recurso_categoria_fecha,

            ]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }


    public function listar_info(){
        try{
            $sql = 'select * from categorias_negocio cn inner join negocios n on cn.id_negocio = n.id_negocio inner join categorias c on cn.id_categoria = c.id_categoria';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();

        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_info_detalle_receta(){
        try{
            $sql = 'select * from recursos_sede rs inner join sucursal s on rs.id_sucursal = s.id_sucursal inner join 
                    recursos r on rs.id_recurso = r.id_recurso inner join categorias c on r.id_categoria = c.id_categoria where categoria_tipo = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_recursos_categoria($id){
        try{
            $sql = 'select * from recursos where id_categoria = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetchAll();

        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    public function jalar_categorias($id){
        try{
            $sql = 'select * from sucursal s inner join negocios n on s.id_negocio = n.id_negocio inner join categorias_negocio cn on n.id_negocio = cn.id_negocio
                    inner join categorias c on cn.id_categoria = c.id_categoria where id_sucursal = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function jalar_ultimo_id(){
        try{
            $sql = 'select * from recursos order by id_recurso desc limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function guardar_recurso($model){
        try{
            $sql = 'insert into recursos_sede (id_usuario_creacion, id_sucursal, id_recurso,id_medida, recurso_sede_factor_unidad, recurso_sede_cantidad,
                    recurso_sede_precio_unit,recurso_sede_peso_inicial,recurso_sede_peso_final, recurso_sede_precio_total, recurso_sede_merma, recurso_sede_precio, recurso_sede_stock, recurso_sede_stock_minimo, 
                    recurso_sede_estado,recurso_sede_fecha) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_usuario_creacion,
                $model->id_sucursal,
                $model->id_recurso,
                $model->id_medida,
                $model->recurso_sede_factor_unidad,
                $model->recurso_sede_cantidad,
                $model->recurso_sede_precio_unit,
                $model->recurso_sede_peso_inicial,
                $model->recurso_sede_peso_final,
                $model->recurso_sede_precio_total,
                $model->recurso_sede_merma,
                $model->recurso_sede_precio,
                $model->recurso_sede_stock,
                $model->recurso_sede_stock_minimo,
                $model->recurso_sede_estado,
                $model->recurso_sede_fecha
            ]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function recursos_por_id_sede($id_sucursal){
        try{
            $sql = 'select * from recursos_sede rs inner join sucursal s on rs.id_sucursal = s.id_sucursal inner join unidad_medida um 
                    on rs.id_medida = um.id_medida inner join recursos r on rs.id_recurso = r.id_recurso inner join categorias c 
                    on r.id_categoria = c.id_categoria where rs.id_sucursal = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_sucursal]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_sucursales_xid($id_sucursal){
        try{
            $sql = 'select * from sucursal where id_sucursal = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_sucursal]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    public function listar_recursos_sede(){
        try{
            $sql = 'select * from recursos_sede rs inner join sucursal s on rs.id_sucursal = s.id_sucursal inner join unidad_medida um 
                    on rs.id_medida = um.id_medida inner join recursos r on rs.id_recurso = r.id_recurso inner join categorias c 
                    on r.id_categoria = c.id_categoria';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    public function cambiar_estado_recurso($id_recurso_sede, $recurso_sede_estado){
        try {
            $sql = "update recursos_sede set
                recurso_sede_estado = ?
                where id_recurso_sede = ?";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $recurso_sede_estado, $id_recurso_sede
            ]);
            $result = 1;
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function cambiar_estado_categoria($id_categoria_negocio, $recurso_categoria_estado){
        try {
            $sql = "update categorias_negocio set
                recurso_categoria_estado = ?
                where id_categoria_negocio = ? ";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $recurso_categoria_estado, $id_categoria_negocio
            ]);
            $result = 1;
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function editar_stock_minimo($id_recurso_sede, $recurso_sede_stock_minimo){
        try {
            $sql = "update recursos_sede set
                recurso_sede_stock_minimo = ?
                where id_recurso_sede = ? ";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $recurso_sede_stock_minimo, $id_recurso_sede
            ]);
            $result = 1;
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function jalar_id_ultima_categoria(){
        try{
            $sql = 'select * from categorias where categoria_estado = 1 order by id_categoria desc limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

}