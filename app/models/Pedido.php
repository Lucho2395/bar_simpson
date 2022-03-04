<?php

class Pedido
{
    private $pdo;
    private $log;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }


    public function listar_mesas($id){
        try {
            $sql = 'select * from mesas m inner join usuarios_sucursal us on m.id_sucursal = us.id_sucursal inner join sucursal s 
                    on us.id_sucursal = s.id_sucursal where id_usuario = ? and id_mesa <> 0';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }
    public function listar_mesas_(){
         try {
            $sql = 'select * from mesas where mesa_estado = 1 and id_mesa >= 0';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function listar_mesas_tg(){
        try {
            $sql = 'select * from mesas where mesa_estado = 1 and id_mesa < 0 order by id_mesa desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function listar_mesas_reserva(){
        try {
            $sql = 'select * from mesas where id_mesa > 0 and mesa_estado_atencion = 0';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function listar_mesas_junte(){
        try {
            $sql = 'select * from mesas where id_mesa > 0 and mesa_estado_atencion = 0 and mesa_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function listar_mesas_ocultas(){
        try {
            $sql = 'select * from mesas where id_mesa > 0 and mesa_estado_atencion = 0 and mesa_estado = 0';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function listar_productos(){
        try {
            $sql = 'select * from productos where producto_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function listar_familias(){
        try{
            $sql = "select * from producto_familia where producto_familia_estado = 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_productos_x_familia($id_producto_familia){
        try{
            $sql = "select * from productos p inner join producto_precio pp on p.id_producto = pp.id_producto 
                    where p.id_producto_familia = ? and p.producto_estado = 1 and pp.producto_precio_estado = 1
                    and pp.id_producto_precio<>-1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_producto_familia]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    public function listar_clienteventa_x_id_delivery($id_cliente){
        try{
            $sql = "select * from comanda c inner join clientes c2 on c.id_cliente = c2.id_cliente inner join tipo_documentos td on c2.id_tipodocumento = td.id_tipodocumento
                    where c.id_cliente = ? order by c.id_comanda desc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_cliente]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    public function jalar_datos_comanda($id_comanda){
        try{
            $sql = "select * from comanda c inner join comanda_detalle cd on c.id_comanda = cd.id_comanda inner join ventas_detalle vd on cd.id_comanda_detalle = vd.id_comanda_detalle
                    inner join ventas v on vd.id_venta = v.id_venta inner join mesas m on c.id_mesa = m.id_mesa where c.id_comanda = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function jalar($id){
        try {
            $sql = 'select * from comanda where id_mesa = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function listar_precio_producto($id_producto){
        try{
            $sql = 'select * from productos p inner join producto_precio pp on p.id_producto = pp.id_producto where p.id_producto = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_producto]);
            $result = $stm->fetchAll();

        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    //FUNCION PARA GUARDAR LA COMANDA
    public function guardar_comanda($model){
        try{
            $sql = 'insert into comanda (id_mesa, id_usuario,id_cliente, comanda_nombre_delivery, comanda_direccion_delivery, 
                     comanda_telefono_delivery,comanda_cantidad_personas, comanda_correlativo, comanda_total, 
                     comanda_fecha_registro, comanda_estado, comanda_codigo) values (?,?,?,?,?,?,?,?,?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_mesa,
                $model->id_usuario,
                $model->id_cliente,
                $model->cliente_nombre_d,
                $model->comanda_direccion_delivery,
                $model->comanda_telefono_delivery,
                $model->comanda_cantidad_personas,
                $model->comanda_correlativo,
                $model->comanda_total,
                $model->comanda_fecha_registro,
                $model->comanda_estado,
                $model->comanda_codigo
            ]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function guardar_reserva($model){
        try{
            if(empty($model->id_reserva)){
                $sql = 'insert into reservas (id_mesa, reserva_nombre, reserva_cantidad, reserva_fecha, reserva_hora,reserva_contacto, reserva_fecha_registro, 
                    reserva_estado) values (?,?,?,?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_mesa,
                    $model->reserva_nombre,
                    $model->reserva_cantidad,
                    $model->reserva_fecha,
                    $model->reserva_hora,
                    $model->reserva_contacto,
                    $model->reserva_fecha_registro,
                    $model->reserva_estado
                ]);
            }else{
                $sql = "update reservas
                set
                id_mesa = ?,
                reserva_nombre = ?,
                reserva_cantidad = ?,
                reserva_fecha = ?,
                reserva_hora = ?,
                reserva_contacto = ?
                where id_reserva = ?";

                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_mesa,
                    $model->reserva_nombre,
                    $model->reserva_cantidad,
                    $model->reserva_fecha,
                    $model->reserva_hora,
                    $model->reserva_contacto,
                    $model->id_reserva
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }
    public function listar_comanda_por_mt($micro){
        try{
            $sql = 'select * from comanda where comanda_codigo = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$micro]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_comanda_x_id($id_comanda){
        try{
            $sql = 'select * from comanda c inner join usuarios u on c.id_usuario = u.id_usuario inner join mesas m 
                    on c.id_mesa = m.id_mesa inner join personas p on u.id_persona = p.id_persona where c.id_comanda = ? 
                    limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function guardar_detalle_comanda($model){
        try {
            $sql = 'insert into comanda_detalle (id_comanda,id_usuario, id_producto, comanda_detalle_precio, comanda_detalle_cantidad, 
                    comanda_detalle_despacho, comanda_detalle_total, comanda_detalle_observacion, comanda_detalle_fecha_registro, 
                    comanda_detalle_estado) values(?,?,?,?,?,?,?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_comanda,
                $model->id_usuario,
                $model->id_producto,
                $model->comanda_detalle_precio,
                $model->comanda_detalle_cantidad,
                $model->comanda_detalle_despacho,
                $model->comanda_detalle_total,
                $model->comanda_detalle_observacion,
                $model->comanda_detalle_fecha_registro,
                $model->comanda_detalle_estado
            ]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function guardar_detalle_pago($model){
        try {
            $sql = 'insert into ventas_detalle_pagos (id_venta, id_tipo_pago, venta_detalle_pago_monto, venta_detalle_pago_estado) 
                    values(?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_venta,
                $model->id_tipo_pago,
                $model->venta_detalle_pago_monto,
                $model->venta_detalle_pago_estado
            ]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function jalar_valor($id_comanda){
        try{
            $sql = "select sum(comanda_detalle_total) total from comanda_detalle where id_comanda = ? and comanda_detalle_estado = 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_ultima_fecha($id_usuario){
        try{
            $sql = 'select * from caja where id_usuario_apertura = ? and caja_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_usuario]);
            $result = $stm->fetch();
            if(!empty($result)){
                $result = true;
            } else {
                $result = false;
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = false;
        }
        return $result;
    }

    public function jalar_id_caja_aperturada($id_usuario){
        try{
            $sql = 'select * from caja where id_usuario_apertura = ? and caja_estado = 1 limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_usuario]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }
    public function jalar_datos_caja_numero($id_caja_numero){
        try{
            $sql = 'select * from caja_numero where  
                    id_caja_numero = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja_numero]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }


    public function actualizar_nuevo_valor($id_comanda, $nuevo_valor){
        try{
            $sql = 'update comanda set comanda_total = ? where id_comanda = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$nuevo_valor, $id_comanda]);
            return 1;
        }  catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function actualizar_comanda_detalle_cantidad($id_comanda_detalle, $cantidad_detalle_nuevo, $total){
        try{
            $sql = 'update comanda_detalle set comanda_detalle_cantidad = ?, comanda_detalle_total = ? where id_comanda_detalle = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$cantidad_detalle_nuevo, $total, $id_comanda_detalle]);
            return 1;
        }  catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function eliminar_comanda_detalle($comanda_detalle_eliminacion,$fecha_eliminacion,$id_comanda_detalle){
        try{
            $sql = 'update comanda_detalle set comanda_detalle_eliminacion = ?, comanda_detalle_fecha_eliminacion = ?, comanda_detalle_estado = 0 where id_comanda_detalle = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$comanda_detalle_eliminacion,$fecha_eliminacion,$id_comanda_detalle]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function eliminar_comanda_detalle_delivery($id_comanda){
        try{
            $sql = 'delete from comanda_detalle where id_comanda = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function listar_grupos(){
        try{
            $sql = 'select * from grupos';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    public function listar_productos_cocina($id){
        try{
            $sql = 'select * from comanda c inner join comanda_detalle cd on c.id_comanda = cd.id_comanda inner join mesas m on c.id_mesa = m.id_mesa
                    inner join productos p on cd.id_producto = p.id_producto inner join grupos g on p.id_grupo = g.id_grupo 
                    where g.id_grupo = ? and comanda_detalle_estado <> 2 order by mesa_nombre asc ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_grupo_vistas($id){
        try{
            $sql = 'select * from grupos where id_grupo = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_pedidos_por_mesa($id_mesa, $id_comanda){
        try{
            $sql = 'select * from comanda c inner join comanda_detalle cd on c.id_comanda = cd.id_comanda inner join mesas m on c.id_mesa = m.id_mesa
                    inner join productos p on cd.id_producto = p.id_producto inner join grupos g on p.id_grupo = g.id_grupo 
                    inner join producto_precio pp on p.id_producto = pp.id_producto inner join usuarios u on cd.id_usuario = u.id_usuario
                    inner join personas p2 on u.id_persona = p2.id_persona
                    where c.id_mesa = ? and c.id_comanda = ? and pp.producto_precio_estado=1 and cd.comanda_detalle_estado = 1 
                    order by cd.comanda_detalle_fecha_registro asc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_mesa,$id_comanda]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_pedidos_eliminados($fecha_i,$fecha_f){
        try{
            $sql = 'select * from comanda c inner join comanda_detalle cd on c.id_comanda = cd.id_comanda inner join mesas m on c.id_mesa = m.id_mesa
                    inner join productos p on cd.id_producto = p.id_producto inner join grupos g on p.id_grupo = g.id_grupo 
                    inner join producto_precio pp on p.id_producto = pp.id_producto
                    where date(cd.comanda_detalle_fecha_eliminacion) between ? and ? and pp.producto_precio_estado=1 and cd.comanda_detalle_estado = 0
                    order by date(cd.comanda_detalle_fecha_eliminacion) desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_i,$fecha_f]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_pedidos($fecha_i, $fecha_f){
        try{
            $sql = 'select * from comanda c inner join mesas m on c.id_mesa = m.id_mesa inner join usuarios u on c.id_usuario = u.id_usuario
                    inner join personas p on u.id_persona = p.id_persona
                    where DATE(c.comanda_fecha_registro) between ? and ? order by c.comanda_fecha_registro desc ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_i,$fecha_f]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_pedidos_x_mesa($id_mesa,$fecha_i, $fecha_f){
        try{
            $sql = 'select * from comanda c inner join mesas m on c.id_mesa = m.id_mesa inner join usuarios u on c.id_usuario = u.id_usuario
                    inner join personas p on u.id_persona = p.id_persona
                    where c.id_mesa = ? and date(c.comanda_fecha_registro) between ? and ? order by c.comanda_fecha_registro desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_mesa,$fecha_i,$fecha_f]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_productos_venta($id_comanda){
        try{
            $sql = 'select * from comanda c inner join comanda_detalle cd on c.id_comanda = cd.id_comanda inner join mesas m on c.id_mesa = m.id_mesa
                    inner join productos p on cd.id_producto = p.id_producto inner join grupos g on p.id_grupo = g.id_grupo 
                    inner join producto_precio pp on p.id_producto = pp.id_producto
                    where c.id_comanda = ? and pp.producto_precio_estado=1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    public function listar_pedidos_delivery($id_mesa){
        try{
            $sql = 'select * from comanda c inner join clientes c2 on c.id_cliente = c2.id_cliente inner join comanda_detalle cd on c.id_comanda = cd.id_comanda inner join mesas m on c.id_mesa = m.id_mesa
                    inner join productos p on cd.id_producto = p.id_producto inner join grupos g on p.id_grupo = g.id_grupo 
                    inner join producto_precio pp on p.id_producto = pp.id_producto
                    where c.id_mesa = ? and pp.producto_precio_estado=1 and c.comanda_estado = 0 group by c.id_comanda';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_mesa]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_pedidos_delivery_entregados($id_mesa,$fecha_filtro,$fecha_filtro_fin){
        try{
            $sql = 'select * from comanda c inner join clientes c2 on c.id_cliente = c2.id_cliente inner join comanda_detalle cd on c.id_comanda = cd.id_comanda inner join mesas m on c.id_mesa = m.id_mesa
                    inner join productos p on cd.id_producto = p.id_producto inner join grupos g on p.id_grupo = g.id_grupo 
                    inner join producto_precio pp on p.id_producto = pp.id_producto
                    where c.id_mesa = ? and pp.producto_precio_estado=1 and comanda_detalle_estado_venta = 1 and c.comanda_estado = 1 and date(comanda_fecha_registro) between 
                    ? and ? group by c.id_comanda ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_mesa,$fecha_filtro,$fecha_filtro_fin]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_detalle_x_comanda($id_comanda){
        try{
            $sql = 'select * from comanda c inner join comanda_detalle cd on c.id_comanda = cd.id_comanda inner join productos p 
                    on cd.id_producto = p.id_producto where cd.id_comanda = ? and comanda_detalle_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_detalle_x_comanda_detalle($id_comanda_detalle){
        try{
            $sql = 'select * from comanda c inner join comanda_detalle cd on c.id_comanda = cd.id_comanda inner join productos p 
                    on cd.id_producto = p.id_producto inner join grupos g on p.id_grupo = g.id_grupo inner join usuarios u on c.id_usuario = u.id_usuario
                    inner join personas p2 on u.id_persona = p2.id_persona
                    where cd.id_comanda_detalle = ? and comanda_detalle_estado = 1 limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda_detalle]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_detalle_x_comanda_para_precuenta($id_comanda){
        try{
            $sql = 'select * from comanda c inner join comanda_detalle cd on c.id_comanda = cd.id_comanda inner join productos p 
                    on cd.id_producto = p.id_producto where cd.id_comanda = ? and cd.comanda_detalle_estado_venta = 0
                    and cd.comanda_detalle_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_detalle_x_comanda_x_fecha($id_comanda,$fecha){
        try{
            $sql = 'select * from comanda c inner join comanda_detalle cd on c.id_comanda = cd.id_comanda inner join productos p 
                    on cd.id_producto = p.id_producto where cd.id_comanda = ? and cd.comanda_detalle_fecha_registro=?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda, $fecha]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function datos_cliente($id_comanda){
        try{
            $sql = 'select * from comanda c inner join clientes c2 on c.id_cliente = c2.id_cliente inner join tipo_documentos td on c2.id_tipodocumento = td.id_tipodocumento
                    where c.id_comanda = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function jalar_fila($id_comanda){
        try{
            $sql = 'select * from comanda c inner join comanda_detalle cd on c.id_comanda = cd.id_comanda where cd.id_comanda = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_precio_x_producto($id_comanda,$id_producto){
        try{
            $sql = 'select count(cd.id_producto) total_producto, sum(comanda_detalle_total) suma_precio from comanda_detalle cd inner join productos p on cd.id_producto = p.id_producto inner join producto_precio pp on p.id_producto = pp.id_producto
                    where cd.id_producto = ? and cd.id_comanda = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_producto,$id_comanda]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    public function jalar_producto($id_comanda){
        try{
            $sql = "select * from comanda_detalle cd inner join productos p on cd.id_producto = p.id_producto inner join 
                    producto_precio pp on p.id_producto = pp.id_producto where id_comanda = ? and pp.producto_precio_estado = 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function cantidad_x_productos($id_producto, $id_comanda){
        try{
            $sql = "select count(id_producto) total from comanda_detalle where id_producto = ? and id_comanda = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_producto,$id_comanda]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listarSerie($tipo_venta){
        try{
            $sql = 'select * from serie where tipocomp = ? and estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$tipo_venta]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listarSerie_caja($tipo_venta, $id_caja){
        try{
            $sql = 'select * from serie where id_caja_numero = ? and tipocomp = ? and estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja,$tipo_venta]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listarSerie_NC_x_id($tipo_venta, $id){
        try{
            $sql = 'select * from serie where tipocomp = ? and id_serie=? and estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$tipo_venta, $id]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function jalar_comanda($id_mesa, $id_comanda){
        try{
            $sql = 'select * from comanda c inner join comanda_detalle cd on c.id_comanda = cd.id_comanda inner join mesas m on c.id_mesa = m.id_mesa
                    inner join productos p on cd.id_producto = p.id_producto inner join grupos g on p.id_grupo = g.id_grupo 
                    where c.id_mesa = ? and c.id_comanda = ? and cd.comanda_detalle_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_mesa,$id_comanda]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_detalles_x_id($id){
        try{
            $sql = 'select count(comanda_detalle_estado_venta) total from comanda_detalle where id_comanda = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function jalar_comanda_delivery($id_comanda){
        try{
            $sql = 'select * from comanda c inner join comanda_detalle cd on c.id_comanda = cd.id_comanda inner join mesas m on c.id_mesa = m.id_mesa
                    inner join productos p on cd.id_producto = p.id_producto inner join grupos g on p.id_grupo = g.id_grupo where c.id_comanda = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function ultimo_pedido($id){
        try{
            $sql = 'select * from comanda c inner join mesas m on c.id_mesa = m.id_mesa inner join comanda_detalle cd on c.id_comanda = cd.id_comanda
                    where c.id_mesa = ? and cd.comanda_detalle_estado_venta = 0
                    order by c.id_comanda desc limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    //FUNCION PARA CAMBIAR ESTADO DE LOS PEDIDOS
    public function cambiar_estado_pedido($id_comanda_detalle, $comanda_detalle_estado){
        try {
            $sql = "update comanda_detalle set
                comanda_detalle_estado = ?
                where id_comanda_detalle = ?";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $comanda_detalle_estado,$id_comanda_detalle
            ]);
            $result = 1;
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function listar_detallecomanda_x_id_comanda_detalle($id_detalle_comanda){
        try{
            $sql = 'select * from comanda c inner join comanda_detalle cd on c.id_comanda = cd.id_comanda inner join mesas m on c.id_mesa = m.id_mesa
                    inner join productos p on cd.id_producto = p.id_producto inner join grupos g on p.id_grupo = g.id_grupo
                    inner join usuarios u on c.id_usuario = u.id_usuario inner join personas p2 on u.id_persona = p2.id_persona
                    where cd.id_comanda_detalle = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_detalle_comanda]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function cambiar_estado_mesa($id_mesa){
        try {
            $sql = "update mesas set
                mesa_estado_atencion = 1
                where id_mesa = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $id_mesa
            ]);
            $result = 1;
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function mesa_estado_limpio($id_mesa){
        try {
            $sql = "update mesas set
                mesa_estado_atencion = 0
                where id_mesa = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $id_mesa
            ]);
            $result = 1;
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function cambiar_estado_mesa_reserva($id_mesa){
        try {
            $sql = "update mesas set
                mesa_estado_atencion = 5
                where id_mesa = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $id_mesa
            ]);
            $result = 1;
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function buscar_datos_reserva($id_mesa,$fecha){
        try{
            $sql = "select * from mesas m inner join reservas r on m.id_mesa = r.id_mesa where r.id_mesa = ? and date(reserva_fecha) = ? 
                    and reserva_estado = 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_mesa,$fecha]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_ultima_reserva(){
        try{
            $sql = "select * from reservas order by id_reserva desc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_busqueda_productos($parametro){
        try{
            $sql = "select * from productos p inner join grupos g on p.id_grupo = g.id_grupo inner join producto_precio pp on p.id_producto = pp.id_producto
                    where pp.producto_precio_estado = 1 and p.producto_nombre like ? and pp.id_producto_precio <> -1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute(['%'.$parametro.'%']);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_busqueda_productos_seleccion($id_producto){
        try{
            $sql = "select * from productos p inner join producto_precio pp on p.id_producto = pp.id_producto
                    where p.id_producto = ? and pp.producto_precio_estado = 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_producto]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    //FUNCION DE BUSQUEDA DE CLIENTE
    public function buscar_cliente($parametro){
        try{
            $sql = "select * from clientes where cliente_estado = 1 and cliente_nombre like ? or clientes.cliente_razonsocial like ? or cliente_numero like ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute(['%'.$parametro.'%', '%'.$parametro.'%', '%'.$parametro.'%']);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    public function direcciones($id_cliente){
        try{
            $sql = "select cliente_direccion as direccion, cliente_direccion_2 as direccion from clientes where id_cliente = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_cliente]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    //FUNCION PARA LISTAR LOS TIPOS DE IGV
    public function listar_igv(){
        try{
            $sql = 'select * from igv where igv_estado = 1 order by igv_codigoafectacion asc ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();

        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_tipo_afectacion(){
        try{
            $sql = 'select * from tipo_afectacion';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_mesa(){
        try{
            $sql = 'select * from mesas where mesa_estado_atencion = 0';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_mesas_pn($id){
        try{
            $sql = 'select * from mesas where id_mesa <> ? and mesa_estado_atencion = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    //FUNCION PARA LISTAR LOS TIPOS DE PAGOS
    public function listar_tipo_pago(){
        try{
            $sql = 'select * from tipo_pago where tipo_pago_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_correlativos(){
        try{
            $sql = 'select * from correlativos limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $return = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = [];
        }
        return $return;
    }
    public function listar_correlativos_x_serie($id_serie){
        try{
            $sql = 'select * from serie where id_serie = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_serie]);
            $return = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = [];
        }
        return $return;
    }

    public function listar_clientes(){
        try{
            $sql = 'select * from clientes';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $return = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = [];
        }
        return $return;
    }
    public function listar_empresa_1(){
        try{
            $sql = 'select * from empresa where id_empresa = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $return = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = [];
        }
        return $return;
    }

    public function listar_cliente_x_numero($numero){
        try{
            $sql = 'select * from clientes where cliente_numero = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$numero]);
            return $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            return [];
        }
    }

    public function jalar_id_venta($fecha ,$id_cliente){
        try{
            $sql = 'select id_venta from ventas where venta_fecha = ? and id_cliente = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha ,$id_cliente]);
            $result = $stm->fetch();
        }  catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function jalar_id_nota_venta($fecha ,$id_cliente){
        try{
            $sql = 'select id_nota_venta from nota_venta where nota_venta_fecha = ? and id_cliente = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha ,$id_cliente]);
            $result = $stm->fetch();
        }  catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    //FUNCION PARA GUARDAR UNA VENTA
    public function guardar_pedido_gratis($model){
        try {
            $sql = 'insert into pedidos_gratis (id_mesa, id_usuario, pedido_gratis_numero, pedido_gratis_nombre, pedido_gratis_direccion, pedido_gratis_total,
                           pedido_gratis_observacion, pedido_gratis_datetime, pedido_gratis_codigo) 
                    values (?,?,?,?,?,?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_mesa,
                $model->id_usuario,
                $model->cliente_numero,
                $model->cliente_nombre,
                $model->cliente_direccion,
                $model->venta_total,
                $model->observacion_cortesia,
                $model->fecha,
                $model->codigo
            ]);
            $result = 1;
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function guardar_venta($model){
        try {
            $sql = 'insert into ventas (id_caja_numero, id_usuario,id_mesa, id_cliente, id_tipo_pago, id_moneda, venta_direccion, venta_tipo, venta_serie,
                    venta_correlativo, venta_totalgratuita, venta_totalexonerada, venta_totalinafecta, venta_totalgravada, venta_totaligv, 
                    venta_icbper ,venta_total, venta_pago_cliente, venta_vuelto, venta_fecha, tipo_documento_modificar, 
                    correlativo_modificar, venta_codigo_motivo_nota, venta_fecha_de_baja) 
                    values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_caja_numero,
                $model->id_usuario,
                $model->id_mesa,
                $model->id_cliente,
                $model->id_tipo_pago,
                $model->id_moneda,
                $model->venta_direccion,
                $model->venta_tipo,
                $model->venta_serie,
                $model->venta_correlativo,
                $model->venta_totalgratuita,
                $model->venta_totalexonerada,
                $model->venta_totalinafecta,
                $model->venta_totalgravada,
                $model->venta_totaligv,
                $model->venta_icbper,
                $model->venta_total,
                $model->pago_cliente,
                $model->vuelto_,
                $model->venta_fecha,
                $model->tipo_documento_modificar,
                $model->correlativo_modificar,
                $model->tipo_nota_id,
                $model->venta_fecha_de_baja
            ]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }
    public function guardar_nota_venta($model){
        try {
            $sql = 'insert into nota_venta (id_usuario, id_mesa, id_cliente, id_tipo_pago, id_moneda, nota_venta_tipo, 
                        nota_venta_serie, nota_venta_correlativo, nota_venta_total, nota_venta_pago_cliente, nota_venta_vuelto,
                        nota_venta_fecha) 
                        value (?,?,?,?,?,?,?,?,?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_usuario,
                $model->id_mesa,
                $model->id_cliente,
                $model->id_tipo_pago,
                $model->id_moneda,
                $model->venta_tipo,
                $model->venta_serie,
                $model->venta_correlativo,
                $model->venta_total,
                $model->pago_cliente,
                $model->vuelto_,
                $model->venta_fecha
            ]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function  actualizarCorrelativo_x_id_Serie($id_serie, $correlativo){
        try {
            $sql = 'update serie set correlativo = ? where id_serie = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $correlativo, $id_serie
            ]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function guardar_venta_detalle($model){
        try {
            $sql = 'insert into ventas_detalle (id_venta,id_comanda_detalle, venta_detalle_valor_unitario, 
                    venta_detalle_precio_unitario, venta_detalle_nombre_producto, venta_detalle_cantidad, venta_detalle_total_igv,
                    venta_detalle_porcentaje_igv, venta_detalle_total_icbper, venta_detalle_valor_total, venta_detalle_importe_total
                    , id_producto_precio)
                    values(?,?,?,?,?,?,?,?,?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_venta,
                $model->id_comanda_detalle,
                $model->venta_detalle_valor_unitario,
                $model->venta_detalle_precio_unitario,
                $model->venta_detalle_nombre_producto,
                $model->venta_detalle_cantidad,
                $model->venta_detalle_total_igv,
                $model->venta_detalle_porcentaje_igv,
                $model->venta_detalle_total_icbper,
                $model->venta_detalle_valor_total,
                $model->venta_detalle_total_price,
                $model->id_producto_precio
            ]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }
    public function guardar_pedido_gratis_detalle($model){
        try {
            $sql = 'insert into pedidos_gratis_detalles (id_pedido_gratis, id_comanda_detalle)
                    values(?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_pedido_gratis,
                $model->id_comanda_detalle
            ]);
            $result = 1;
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }
    public function guardar_nota_venta_detalle($model){
        try {
            $sql = 'insert into nota_venta_detalle (id_nota_venta, id_comanda_detalle, 
                                nota_venta_detalle_valor_unitario, nota_venta_detalle_precio_valor, nota_venta_detalle_nombre_producto, 
                                nota_venta_detalle_cantidad, nota_venta_detalle_total_igv, nota_venta_detalle_porcentaje_igv, 
                                nota_venta_detalle_total_icbper, nota_venta_detalle_valor_total, nota_venta_detalle_importe_total, 
                                id_producto_precio) 
                                value (?,?,?,?,?,?,?,?,?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_venta,
                $model->id_comanda_detalle,
                $model->venta_detalle_valor_unitario,
                $model->venta_detalle_precio_unitario,
                $model->venta_detalle_nombre_producto,
                $model->venta_detalle_cantidad,
                $model->venta_detalle_total_igv,
                $model->venta_detalle_porcentaje_igv,
                $model->venta_detalle_total_icbper,
                $model->venta_detalle_valor_total,
                $model->venta_detalle_total_price,
                $model->id_producto_precio
            ]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    //FUNCION PARA JALAR DATOS DEL DETALLE Y PONERLO EN LA VENTA DETALLE
    public function jalar_datos($id_comanda_detalle){
        try{
            $sql = 'select * from comanda_detalle cd inner join productos p on cd.id_producto = p.id_producto 
                    inner join producto_precio pp on p.id_producto = pp.id_producto where cd.id_comanda_detalle = ? and pp.producto_precio_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda_detalle]);
            $result = $stm->fetch();
        }  catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_pedido_gratis_x_mt($mt){
        try{
            $sql = 'select * from pedidos_gratis where pedido_gratis_codigo = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$mt]);
            $result = $stm->fetch();
        }  catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_pedidos_x_mesa_gratis($id_mesa,$fecha_i, $fecha_f){
        try{
            $sql = 'select * from pedidos_gratis pg inner join mesas m on pg.id_mesa = m.id_mesa inner join usuarios u on pg.id_usuario = u.id_usuario
                    where pg.id_mesa = ? and DATE(pg.pedido_gratis_datetime) between ? and ? order by pg.pedido_gratis_datetime desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_mesa,$fecha_i,$fecha_f]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_pedidos_gratis($fecha_i, $fecha_f){
        try{
            $sql = 'select * from pedidos_gratis pg inner join mesas m on pg.id_mesa = m.id_mesa inner join usuarios u on pg.id_usuario = u.id_usuario
                    where DATE(pg.pedido_gratis_datetime) between ? and ? order by pg.pedido_gratis_datetime desc ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_i,$fecha_f]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function consultar($id_comanda_detalle){
        try{
            $sql = 'select * from ventas_detalle vd inner join comanda_detalle cd on vd.id_comanda_detalle = cd.id_comanda_detalle 
                    where cd.id_comanda_detalle = ? and cd.comanda_detalle_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda_detalle]);
            $result = $stm->fetchAll();
        }  catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function consultar_existe_en_nota_venta_detalle($id_comanda){
        try{
            $sql = 'select * from nota_venta_detalle vd inner join comanda_detalle cd on vd.id_comanda_detalle = cd.id_comanda_detalle 
                    where cd.id_comanda = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda]);
            $result = $stm->fetchAll();
        }  catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    public function cambiar_estado_comanda($id_comanda_detalle){
        try{
            $sql = 'update comanda_detalle set comanda_detalle_estado_venta = 1 where id_comanda_detalle = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda_detalle]);
            return 1;
        }  catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function cambiar_estado_comanda_principal($id_comanda){
        try{
            $sql = 'update comanda set comanda_estado = 2 where id_comanda = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda]);
            return 1;
        }  catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function actualizar_estado_mesa($id_mesa){
        try{
            $sql = 'update mesas set mesa_estado_atencion = 2 where id_mesa = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_mesa]);
            return 1;
        }  catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function ocultar_reserva($id_mesa){
        try{
            $sql = 'update reservas set reserva_estado = 2 where id_mesa = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_mesa]);
            return 1;
        }  catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function habilitar_mesa($mesa_estado_atencion,$id_mesa){
        try{
            $sql = 'update mesas set mesa_estado_atencion = ? where id_mesa = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$mesa_estado_atencion,$id_mesa]);
            return 1;
        }  catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }


    //FUNCION PARA CAMBIAR EL ESTADO DE LAS MESAS
    public function cambiar_mesa($id_mesa_nuevo, $id_comanda){
        try{
            $sql = 'update comanda set id_mesa = ? where id_comanda = ? ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_mesa_nuevo,$id_comanda]);
            return 1;
        }  catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function cambiar_cantidad_personas($id_comanda , $comanda_cantidad_personas){
        try{
            $sql = 'update comanda set comanda_cantidad_personas = ? where id_comanda = ? ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$comanda_cantidad_personas,$id_comanda]);
            return 1;
        }  catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function listar_ultima_comanda($fecha_buscar){
        try{
            $sql = "select * from comanda where date(comanda_fecha_registro) = ? order by id_comanda desc limit 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_buscar]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    public function listar_detalles_x_pedido($id_comanda){
        try{
            $sql = "select * from comanda_detalle where id_comanda = ? and comanda_detalle_estado = 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_detalles_x_pedido_pagados($id_comanda){
        try{
            $sql = "select * from comanda_detalle where id_comanda = ? and comanda_detalle_estado_venta = 0 and comanda_detalle_estado = 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    public function eliminar_comanda($id_comanda){
        try{
            $sql = 'delete from comanda where id_comanda = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function verificar_pago($id_comanda){
        try{
            $sql = "select * from comanda_detalle where id_comanda = ? and comanda_detalle_estado_venta = 0 and comanda_detalle_estado = 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function verificar_existencia_detalle_comanda($id_comanda_detalle){
        try{
            $sql = "select * from nota_venta_detalle where id_comanda_detalle = ? limit 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda_detalle]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function verificar_password($user, $pass){
        $result = false;
        try{
            $sql = "Select usuario_contrasenha from usuarios 
                    where id_rol = ? and usuario_estado = 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$user]);
            $info = $stm->fetchAll();
            foreach ($info as $i){
                if(password_verify($pass, $i->usuario_contrasenha)){
                    $result = true;
                }
            }
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = false;
        }
        return $result;
    }


    public function valor_insumos($id_comanda_detalle){
        try{
            $sql = "select * from comanda_detalle cd inner join productos p on cd.id_producto = p.id_producto inner join detalle_recetas dr on p.id_receta = dr.id_receta
                    inner join recursos_sede rs on dr.id_recursos_sede = rs.id_recurso_sede inner join recursos r on rs.id_recurso = r.id_recurso
                    inner join unidad_medida um on rs.id_medida = um.id_medida where cd.id_comanda_detalle = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda_detalle]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    public function capturar_cantidad($id_recurso_sede){
        try{
            $sql = "select * from recursos_sede where id_recurso_sede = ? limit 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_recurso_sede]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    public function saber_conversion($id_recurso_sede){
        try{
            $sql = "select * from conversiones c inner join recursos_sede rs on c.id_recurso_sede = rs.id_recurso_sede where c.id_recurso_sede = ? limit 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_recurso_sede]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function conversion_por_id($id){
        try{
            $sql = "select * from conversiones c where c.id_conversion = ? limit 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function actualizar_stock($monto, $id){
        try{
            $sql = 'update recursos_sede set recurso_sede_stock = recurso_sede_stock + ? where id_recurso_sede = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$monto, $id]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }


    public function guardar_grupos($model){
        try{
            $sql = 'insert into grupos (grupo_nombre, grupo_ticketera, grupo_fecha_registro, grupo_estado) 
                    values (?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->grupo_nombre,
                $model->grupo_ticketera,
                $model->grupo_fecha_registro,
                $model->grupo_estado
            ]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function listar_reservas($fecha_hoy){
        try{
            $sql = "select * from reservas r inner join mesas m on r.id_mesa = m.id_mesa where date(reserva_fecha) >= ? and r.reserva_estado = 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_hoy]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function eliminar_reserva($id_reserva){
        try{
            $sql = 'delete from reservas where id_reserva = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_reserva]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function mostrar_mesita($id_mesa){
        try{
            $sql = 'update mesas set mesa_estado = 1 where id_mesa = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_mesa]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function jalar_valor_puntos(){
        try{
            $sql = "select * from puntos where puntos_estado = 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function guardar_puntos_ventas($modelc){
        try{
            $sql = 'insert into puntos_cliente (id_cliente, id_puntos, puntos_cliente_acumulado, puntos_cliente_fecha_registro, puntos_cliente_estado) 
                    values (?,?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $modelc->id_cliente,
                $modelc->id_puntos,
                $modelc->puntos_cliente_acumulado,
                $modelc->puntos_cliente_fecha_registro,
                $modelc->puntos_cliente_estado
            ]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }
    public function listar_venta_x_comanda($id_comanda){
        try{
            $sql = "select * from comanda c inner join comanda_detalle cd on c.id_comanda = cd.id_comanda inner join ventas_detalle vd on cd.id_comanda_detalle = vd.id_comanda_detalle
                    inner join ventas v on vd.id_venta = v.id_venta where c.id_comanda = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function cambiar_estado_comanda_delivery($id){
        try{
            $sql = 'update comanda set comanda_estado = 1 where id_comanda = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $id
            ]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function guardar_cambio($estado, $id_mesa){
        try{
            $sql = 'update mesas set mesa_estado = ? where id_mesa = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $estado, $id_mesa
            ]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function jalar_pedidos_mesa_actual($id_comanda){
        try{
            $sql = "select * from comanda_detalle where id_comanda = ? and comanda_detalle_estado = 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function jalar_pedidos_mesa_destino($id_comanda){
        try{
            $sql = "select * from comanda_detalle where id_comanda = ? and comanda_detalle_estado = 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function extraer_id_comanda_destino($id_mesa_pn){
        try{
            $sql = "select * from comanda where id_mesa = ? order by id_comanda desc limit 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_mesa_pn]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function agregar_pedidos_mesa_destino($model){
        try {
            $sql = 'insert into comanda_detalle (id_comanda, id_producto, comanda_detalle_precio, comanda_detalle_cantidad, comanda_detalle_despacho, 
                    comanda_detalle_total, comanda_detalle_observacion, comanda_detalle_fecha_registro, comanda_detalle_estado,comanda_detalle_estado_venta) 
                    values(?,?,?,?,?,?,?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_comanda,
                $model->id_producto,
                $model->comanda_detalle_precio,
                $model->comanda_detalle_cantidad,
                $model->comanda_detalle_despacho,
                $model->comanda_detalle_total,
                $model->comanda_detalle_observacion,
                $model->comanda_detalle_fecha_registro,
                $model->comanda_detalle_estado,
                $model->comanda_detalle_estado_venta
            ]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function eliminar_detalles_transferidos($id_comanda_detalle){
        try{
            $sql = 'delete from comanda_detalle where id_comanda_detalle = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda_detalle]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function eliminar_comanda_transferida($id_comanda){
        try{
            $sql = 'delete from comanda where id_comanda = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function actializar_id_comanda($id_comanda_nuevo,$id_comanda_){
        try{
            $sql = 'update comanda_detalle set id_comanda = ? where id_comanda = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda_nuevo,$id_comanda_]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function sumar_valor_comandas($total_comanda,$id_comanda_nuevo){
        try{
            $sql = 'update comanda set comanda_total = comanda_total + ? where id_comanda = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$total_comanda,$id_comanda_nuevo]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

}