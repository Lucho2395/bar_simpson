<?php

class Producto
{
    private $pdo;
    private $log;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }


    public function guardar_producto($model){
        try{
            if(isset($model->id_producto)){
                $sql = 'update productos set
                        id_receta = ?,
                        id_grupo = ?,
                        id_producto_familia = ?,
                        producto_nombre = ?,
                        producto_descripcion = ?,
                        producto_foto = ?
                        where id_producto = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_receta,
                    $model->id_grupo,
                    $model->id_producto_familia,
                    $model->producto_nombre,
                    $model->producto_descripcion,
                    $model->producto_foto,
                    $model->id_producto
                ]);
            } else {
                $sql = 'insert into productos (id_receta,id_grupo, id_usuario,id_producto_familia, producto_nombre, producto_descripcion, producto_foto, 
                       producto_estado, producto_fecha_registro, producto_codigo) values (?,?,?,?,?,?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_receta,
                    $model->id_grupo,
                    $model->id_usuario,
                    $model->id_producto_familia,
                    $model->producto_nombre,
                    $model->producto_descripcion,
                    $model->producto_foto,
                    $model->producto_estado,
                    $model->producto_fecha_registro,
                    $model->producto_codigo
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function listar_productos(){
        try{
            $sql = 'select * from productos p inner join grupos g on p.id_grupo = g.id_grupo inner join producto_precio pp on p.id_producto = pp.id_producto 
                    inner join producto_familia pf on p.id_producto_familia = pf.id_producto_familia
                    where producto_precio_estado = 1 order by p.producto_fecha_registro, p.id_producto asc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_productos_familia($id_tipo_familia){
        try{
            $sql = 'select * from productos p inner join producto_precio pp on p.id_producto = pp.id_producto 
                    inner join producto_familia pf on p.id_producto_familia = pf.id_producto_familia
                    where p.id_producto_familia = ? and producto_precio_estado = 1 order by p.producto_fecha_registro, p.id_producto asc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_tipo_familia]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_grupos(){
        try{
            $sql = 'select * from grupos where grupo_estado = 1 ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_producto($microtime){
        try{
            $sql = 'select id_producto from productos where producto_codigo = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$microtime]);
            $result = $stm->fetch();
            return $result->id_producto;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 0;
        }
    }


    public function actualizar_estado($id_producto){
        try {
            $sql = "update producto_precio set
                producto_precio_estado = 0
                where id_producto = ? ";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $id_producto
            ]);
            $result = 1;
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }


    public function guardar_precio($model){
        try{
            if(isset($model->id_producto_precio)){
                $sql = 'update productos set
                        id_receta = ?,
                        producto_nombre = ?,
                        producto_descripcion = ?
                        where id_producto = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_receta,
                    $model->producto_nombre,
                    $model->producto_descripcion,
                    $model->id_producto
                ]);
            } else {
                $sql = 'insert into producto_precio (id_producto, id_unidad_medida, producto_precio_codigoafectacion, 
                        producto_precio_venta, producto_precio_fecha_registro, producto_precio_estado) values (?,?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_producto,
                    $model->id_medida,
                    $model->producto_precio_tipoafectaciona,
                    $model->producto_precio_venta,
                    $model->producto_precio_fecha_registro,
                    $model->producto_precio_estado,
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }


    public function listar_precios_producto($id_producto){
        try{
            $sql = 'select * from productos p inner join producto_precio pp on p.id_producto = pp.id_producto inner join usuarios u on p.id_usuario = u.id_usuario 
                    inner join personas pe on u.id_persona = pe.id_persona where p.id_producto = ? order by producto_precio_fecha_registro desc ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_producto]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    public function sacar_foto_producto($id){
        try{
            $sql = 'select producto_foto from productos where id_producto = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
            return $result->producto_foto;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 0;
        }
    }


    public function cambiar_estado_producto($id_producto,$producto_estado){
        try {
            $sql = "update productos set
                producto_estado = ?
                where id_producto = ?";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $producto_estado, $id_producto
            ]);
            $result = 1;
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }


    public function listar_recetas(){
        try{
            $sql = 'select * from recetas';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function valor_total($id_producto){
        try{
            $sql = 'select sum(venta_detalle_importe_total) total from ventas v inner join ventas_detalle vd on v.id_venta = vd.id_venta 
                    inner join comanda_detalle cd on vd.id_comanda_detalle = cd.id_comanda_detalle
                    inner join productos p on cd.id_producto = p.id_producto inner join producto_precio pp on p.id_producto = pp.id_producto
                    where pp.id_producto = ? and v.anulado_sunat = 0';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_producto]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function consultar_ventas($id_producto){
        try{
            $sql = 'select * from ventas pv inner join ventas_detalle vd on 
                    pv.id_venta = vd.id_venta inner join comanda_detalle cd on vd.id_comanda_detalle = cd.id_comanda_detalle 
                    inner join comanda c2 on cd.id_comanda = c2.id_comanda
                    inner join productos pp on cd.id_producto = pp.id_producto
                    inner join clientes c on pv.id_cliente = c.id_cliente inner join usuarios u on c2.id_usuario = u.id_usuario 
                    inner join personas p2 on u.id_persona = p2.id_persona where pp.id_producto = ?
                    and pv.venta_total <> 0 and pv.venta_cancelar <> 0 and pv.anulado_sunat = 0';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_producto]);
            $result = $stm->fetchAll();
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_familias(){
        try{
            $sql = 'select * from producto_familia where producto_familia_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_familias_($id_producto_familia){
        try{
            $sql = 'select * from producto_familia where id_producto_familia = ? and producto_familia_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_producto_familia]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    public function guardar_familia($model){
        try{
            $sql = "insert into producto_familia (producto_familia_nombre, producto_familia_fecha_registro, producto_familia_estado) values (?,?,?) ";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->producto_familia_nombre,
                $model->producto_familia_fecha_registro,
                $model->producto_familia_estado
            ]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function eliminar_familia($id_producto_familia){
        try{
            $sql = "delete from producto_familia where id_producto_familia = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_producto_familia]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function consultar_familiar($id){
        try{
            $sql = 'select * from productos where id_producto_familia = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function jalar_recurso_sede_desde_receta_todo($id_receta){
        try{
            $sql = 'select * from recetas r inner join detalle_recetas dr on r.id_receta = dr.id_receta inner join recursos_sede rs 
                    on dr.id_recursos_sede = rs.id_recurso_sede where r.id_receta = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_receta]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function jalar_recurso_sede_desde_receta($id_receta){
        try{
            $sql = 'select * from recetas r inner join detalle_recetas dr on r.id_receta = dr.id_receta inner join recursos_sede rs 
                    on dr.id_recursos_sede = rs.id_recurso_sede where r.id_receta = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_receta]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function sumar_stock_adicional($id_recurso_sede, $asignar_nuevo){
        try {
            $sql = "update recursos_sede set
                recurso_sede_stock = recurso_sede_stock + ?
                where id_recurso_sede = ?";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $asignar_nuevo, $id_recurso_sede
            ]);
            $result = 1;
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

}