<?php

class Ordencompra
{
    private $pdo;
    private $log;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }


    public function listar_sucursal($id_usuario){
        try{
            $sql = 'select * from sucursal s inner join usuarios_negocio un on s.id_negocio = un.id_negocio inner join usuarios u on un.id_usuario = u.id_usuario
                    where un.id_usuario = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_usuario]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    public function listar_recursos_sucursal($id_sucursal){
        try{
            $sql = 'select * from recursos r inner join recursos_sede rs on r.id_recurso = rs.id_recurso where id_sucursal = ? and recurso_sede_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_sucursal]);
            $result = $stm->fetchAll();

        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_recursos(){
        try{
            $sql = 'select * from recursos r inner join recursos_sede rs on r.id_recurso = rs.id_recurso where r.recurso_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();

        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function insumos_en_oc($id_orden_compra){
        try{
            $sql = "select * from detalle_compra dc inner join recursos_sede rs on dc.id_recurso_sede = rs.id_recurso_sede inner join 
                    recursos r on rs.id_recurso = r.id_recurso where dc.id_orden_compra = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_orden_compra]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_proveedores(){
        try{
            $sql = 'select * from proveedor p inner join negocios n on p.id_negocio = n.id_negocio where proveedor_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_proveedor($id_proveedor){
        try{
            $sql = 'select * from negocios n inner join proveedor p on n.id_negocio = p.id_negocio inner join usuarios_negocio un on n.id_negocio = un.id_negocio
                    where un.id_usuario = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_proveedor]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    //FUNCION PARA GUARDAR ORDEN COMPRA
    public function guardar_orden_compra($model){
        try{
            if(isset($model->id_orden_compra)){
                $sql = 'update orden_compra set
                        id_solicitante = ?,
                        id_sucursal = ?,
                        id_proveedor = ?,
                        orden_compra_titulo = ?
                        where id_orden_compra = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_solicitante,
                    $model->id_sucursal,
                    $model->id_proveedor,
                    $model->orden_compra_titulo,
                    $model->id_orden_compra
                ]);
            } else {
                $sql = 'insert into orden_compra (id_caja_numero,id_solicitante, id_aprobacion, id_proveedor, id_sucursal, orden_compra_fecha_aprob, orden_compra_titulo, 
                        orden_compra_activo,orden_compra_numero, orden_compra_estado, orden_compra_fecha, orden_compra_codigo) 
                        values (?,?,?,?,?,?,?,?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_caja_numero,
                    $model->id_solicitante,
                    $model->id_aprobacion,
                    $model->id_proveedor,
                    $model->id_sucursal,
                    $model->orden_compra_fecha_aprob,
                    $model->orden_compra_titulo,
                    $model->orden_compra_activo,
                    $model->orden_compra_numero,
                    $model->orden_compra_estado,
                    $model->orden_compra_fecha,
                    $model->orden_compra_codigo
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function listar_orden_por_mt($micro){
        try{
            $sql = 'select * from orden_compra where orden_compra_codigo = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$micro]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    public function guardar_detalle_compra($model){
        try {
            $sql = 'insert into detalle_compra (id_orden_compra, id_recurso_sede, detalle_compra_cantidad,detalle_compra_cantidad_recibida,detalle_compra_precio_compra,
                    detalle_compra_total_pedido,detalle_compra_total_pagado,detalle_compra_estado) values(?,?,?,?,?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_orden_compra,
                $model->id_recurso_sede,
                $model->detalle_compra_cantidad,
                $model->detalle_compra_cantidad_recibida,
                $model->detalle_compra_precio_compra,
                $model->detalle_compra_total_pedido,
                $model->detalle_compra_total_pagado,
                $model->detalle_compra_estado
            ]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    //FUNCION PARA LISTAR LA INFORMACION DE LOS PENDIENTES
    public function listar_info(){
        try{
            $sql = 'select * from orden_compra oc inner join usuarios u on oc.id_solicitante = u.id_usuario inner join personas p on u.id_persona = p.id_persona 
               inner join sucursal s on oc.id_sucursal = s.id_sucursal inner join proveedor p2 on oc.id_proveedor = p2.id_proveedor 
               where orden_compra_estado = 0 order by orden_compra_fecha desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_datos($id){
        try{
            $sql = 'select * from orden_compra oc inner join sucursal s on oc.id_sucursal = s.id_sucursal inner join proveedor p2 on oc.id_proveedor = p2.id_proveedor 
                    inner join usuarios u on oc.id_solicitante = u.id_usuario inner join 
                    personas p on u.id_persona = p.id_persona 
              where oc.id_orden_compra = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function datos_facturas($parametro){
        try{
            $sql = 'select * from orden_compra oc inner join usuarios u on oc.id_solicitante = u.id_usuario inner join personas p on u.id_persona = p.id_persona 
                inner join detalle_compra dc on oc.id_orden_compra = dc.id_orden_compra inner join proveedor p2 on oc.id_proveedor = p2.id_proveedor inner join
                recursos_sede rs on dc.id_recurso_sede = rs.id_recurso_sede inner join recursos r on rs.id_recurso = r.id_recurso inner join sucursal s 
                on rs.id_sucursal = s.id_sucursal where orden_compra_estado = 1 and detalle_compra_estado = 1 and orden_compra_numero_doc like ? order by oc.orden_compra_fecha desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute(['%' . $parametro . '%']);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function datos_facturas_fp($fecha_hoy,$fecha_fin,$parametro){
        try{
            $sql = 'select * from orden_compra oc inner join usuarios u on oc.id_solicitante = u.id_usuario inner join personas p on u.id_persona = p.id_persona 
                inner join detalle_compra dc on oc.id_orden_compra = dc.id_orden_compra inner join proveedor p2 on oc.id_proveedor = p2.id_proveedor inner join
                recursos_sede rs on dc.id_recurso_sede = rs.id_recurso_sede inner join recursos r on rs.id_recurso = r.id_recurso inner join sucursal s 
                on rs.id_sucursal = s.id_sucursal where orden_compra_estado = 1 and detalle_compra_estado = 1 
                and date(orden_compra_fecha) between ? and ? and p2.proveedor_nombre like ? or p2.proveedor_ruc like ?
                order by oc.orden_compra_fecha desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_hoy,$fecha_fin,'%' . $parametro . '%','%' . $parametro . '%']);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function datos_facturas_para($parametro){
        try{
            $sql = 'select * from orden_compra oc inner join usuarios u on oc.id_solicitante = u.id_usuario inner join personas p on u.id_persona = p.id_persona 
                inner join detalle_compra dc on oc.id_orden_compra = dc.id_orden_compra inner join proveedor p2 on oc.id_proveedor = p2.id_proveedor inner join
                recursos_sede rs on dc.id_recurso_sede = rs.id_recurso_sede inner join recursos r on rs.id_recurso = r.id_recurso inner join sucursal s 
                on rs.id_sucursal = s.id_sucursal where orden_compra_estado = 1 and detalle_compra_estado = 1 and p2.proveedor_nombre like ? 
                or p2.proveedor_ruc like ? order by oc.orden_compra_fecha desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute(['%' . $parametro . '%','%' . $parametro . '%']);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function datos_facturas_fechas($fecha_hoy,$fecha_fin){
        try{
            $sql = 'select * from orden_compra oc inner join usuarios u on oc.id_solicitante = u.id_usuario inner join personas p on u.id_persona = p.id_persona 
                    inner join sucursal s on oc.id_sucursal = s.id_sucursal inner join proveedor p2 on oc.id_proveedor = p2.id_proveedor 
                    where orden_compra_estado = 1 and date(orden_compra_fecha) between ? and ? order by oc.orden_compra_fecha desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_hoy,$fecha_fin]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function datos_facturas_todo(){
        try{
            $sql = 'select * from orden_compra oc inner join usuarios u on oc.id_solicitante = u.id_usuario inner join personas p on u.id_persona = p.id_persona 
                inner join detalle_compra dc on oc.id_orden_compra = dc.id_orden_compra inner join proveedor p2 on oc.id_proveedor = p2.id_proveedor inner join
                recursos_sede rs on dc.id_recurso_sede = rs.id_recurso_sede inner join recursos r on rs.id_recurso = r.id_recurso inner join sucursal s 
                on rs.id_sucursal = s.id_sucursal where orden_compra_estado = 1 and detalle_compra_estado = 1 order by oc.orden_compra_fecha desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function sumar_total_oc($id){
        try{
            $sql = 'select SUM(detalle_compra_total_pedido) total from detalle_compra where id_orden_compra = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function jalar_detalle($id){
        try{
            $sql = 'select * from detalle_compra where id_detalle_compra = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function actualizar_precio_recurso($id_recurso_sede,$recurso_sede_precio){
        try {
            $sql = 'update recursos_sede set recurso_sede_precio = ?
                    where id_recurso_sede = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$recurso_sede_precio,$id_recurso_sede]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function total($id){
        try{
            $sql = 'select SUM(detalle_compra_total_pedido) total from detalle_compra where id_orden_compra = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_datos_detalle(){
        try{
            $sql = 'select * from orden_compra oc inner join usuarios u on oc.id_solicitante = u.id_usuario inner join personas p on u.id_persona = p.id_persona 
                inner join detalle_compra dc on oc.id_orden_compra = dc.id_orden_compra inner join sucursal s on dc.id_sucursal = s.id_sucursal 
                inner join negocios n on s.id_negocio = n.id_negocio inner join proveedor pr on n.id_negocio = pr.id_negocio where orden_compra_estado = 0';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_detalle($id){
        try{
            $sql = 'select * from orden_compra oc inner join usuarios u on oc.id_solicitante = u.id_usuario inner join personas p on u.id_persona = p.id_persona 
                inner join detalle_compra dc on oc.id_orden_compra = dc.id_orden_compra inner join proveedor p2 on oc.id_proveedor = p2.id_proveedor inner join
                recursos_sede rs on dc.id_recurso_sede = rs.id_recurso_sede inner join recursos r on rs.id_recurso = r.id_recurso inner join sucursal s 
                on rs.id_sucursal = s.id_sucursal where dc.id_orden_compra = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_detalle_($id){
        try{
            $sql = 'select * from orden_compra oc inner join usuarios u on oc.id_solicitante = u.id_usuario inner join personas p on u.id_persona = p.id_persona 
                inner join detalle_compra dc on oc.id_orden_compra = dc.id_orden_compra inner join proveedor p2 on oc.id_proveedor = p2.id_proveedor inner join
                recursos_sede rs on dc.id_recurso_sede = rs.id_recurso_sede inner join recursos r on rs.id_recurso = r.id_recurso inner join sucursal s 
                on rs.id_sucursal = s.id_sucursal where dc.id_orden_compra = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function eliminar_detalle_compra($id){
        try {
            $sql = 'delete from detalle_compra where id_orden_compra = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function eliminar_detalle_compra_cr($id){
        try {
            $sql = 'update detalle_compra set detalle_compra_estado = 0 where id_orden_compra = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function eliminar_detalle_compra_cr_oc($id){
        try {
            $sql = 'update orden_compra set orden_compra_estado = 0 where id_orden_compra = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function eliminar_orden($id){
        try {
            $sql = 'delete from orden_compra where id_orden_compra = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function obtener_id_recurso($id_detalle_compra){
        try{
            $sql = 'select * from detalle_compra where id_orden_compra = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_detalle_compra]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function restar_stock_eliminado($jalar_cantidad_restada,$id_recurso_sede){
        try{
            $sql = 'update recursos_sede set recurso_sede_stock = recurso_sede_stock - ? where id_recurso_sede = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$jalar_cantidad_restada,$id_recurso_sede]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }


    public function listar_orden_numero(){
        try{
            $sql = "select * from orden_compra where orden_compra_estado <> 0 order by orden_compra_numero desc limit 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    public function aprobar_orden($id_usuario,$ind,$numero,$id_orden_compra){
        try {
            $fecha = date('Y-m-d H:i:s');
            $sql = 'update orden_compra set id_aprobacion = ?,orden_compra_estado = ?, orden_compra_numero = ?, orden_compra_fecha_aprob = ? 
                    where id_orden_compra = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_usuario,$ind,$numero,$fecha,$id_orden_compra]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }


    public function listar_aprobados($parametro){
        try{
            $sql = 'select * from orden_compra oc inner join usuarios u on oc.id_solicitante = u.id_usuario inner join personas p on u.id_persona = p.id_persona 
                    inner join sucursal s on oc.id_sucursal = s.id_sucursal inner join proveedor p2 on oc.id_proveedor = p2.id_proveedor 
                    where (p2.proveedor_nombre like ? or oc.orden_compra_numero like ? or oc.orden_compra_fecha like ?) and orden_compra_estado = 1 order by orden_compra_numero desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute(['%' . $parametro . '%', '%' . $parametro . '%', '%' . $parametro . '%']);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_aprobados_(){
        try{
            $sql = 'select * from orden_compra oc inner join usuarios u on oc.id_solicitante = u.id_usuario inner join personas p on u.id_persona = p.id_persona 
                    inner join sucursal s on oc.id_sucursal = s.id_sucursal inner join proveedor p2 on oc.id_proveedor = p2.id_proveedor 
                    where orden_compra_estado = 1 order by orden_compra_numero desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    public function guardar_recepcion($id_tipo_pago,$orden_compra_observacion,$orden_compra_tipo_doc,$orden_compra_numero_doc,$orden_compra_fecha_recibida,
                                      $orden_compra_usuario_recibido,$orden_compra_doc_adjuntado,$orden_compra_fecha_emision_doc,$orden_compra_doc_cuotas,
                                      $id_orden_compra){
        try {
            $sql = 'update orden_compra set 
                    id_tipo_pago = ?, 
                    orden_compra_observacion = ?, 
                    orden_compra_tipo_doc = ?, 
                    orden_compra_numero_doc = ?, 
                    orden_compra_fecha_recibida = ?, 
                    orden_compra_usuario_recibido = ?,
                    orden_compra_doc_adjuntado = ?,
                    orden_compra_fecha_emision_doc = ?,
                    orden_compra_doc_cuotas = ?
                    where id_orden_compra = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_tipo_pago,$orden_compra_observacion,$orden_compra_tipo_doc,$orden_compra_numero_doc,$orden_compra_fecha_recibida,
                $orden_compra_usuario_recibido,$orden_compra_doc_adjuntado,$orden_compra_fecha_emision_doc,$orden_compra_doc_cuotas, $id_orden_compra]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function actualizar_cantidad($detalle_compra_cantidad_recibida,$detalle_compra_tipo_moneda,$detalle_compra_tipo_cambio,$detalle_compra_total_dolares,$detalle_compra_total_pagado, $id_detalle_compra){
        try {
            $sql = 'update detalle_compra set detalle_compra_cantidad_recibida = ?, detalle_compra_tipo_moneda = ?,detalle_compra_tipo_cambio = ?, detalle_compra_total_dolares = ?, 
                    detalle_compra_total_pagado = ? where id_detalle_compra = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$detalle_compra_cantidad_recibida,$detalle_compra_tipo_moneda,$detalle_compra_tipo_cambio,$detalle_compra_total_dolares,$detalle_compra_total_pagado,$id_detalle_compra]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function jalar_precio($id){
        try{
            $sql = 'select * from detalle_compra where id_detalle_compra = ? ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_tipo_pago(){
        try{
            $sql = 'select * from tipo_pago ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_busqueda_facturas($parametro)
    {
        try {
            $sql = "select * from personas where (persona_nombre like ? or persona_apellido_paterno like ? or persona_dni like ?) and persona_estado = 1
                    order by persona_apellido_paterno, persona_apellido_materno asc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute(['%' . $parametro . '%', '%' . $parametro . '%', '%' . $parametro . '%']);
            $result = $stm->fetchAll();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function guardar_orden_compra_rapida($model){
        try{
            if(isset($model->id_orden_compra)){
                $sql = 'update orden_compra set
                        id_solicitante = ?,
                        id_sucursal = ?,
                        id_proveedor = ?,
                        orden_compra_titulo = ?
                        where id_orden_compra = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_solicitante,
                    $model->id_sucursal,
                    $model->id_proveedor,
                    $model->orden_compra_titulo,
                    $model->id_orden_compra
                ]);
            } else {
                $sql = 'insert into orden_compra (id_solicitante,id_aprobacion, id_proveedor, id_sucursal, id_tipo_pago, orden_compra_observacion, 
                        orden_compra_fecha_aprob, orden_compra_titulo, orden_compra_activo, orden_compra_numero, orden_compra_estado, 
                        orden_compra_fecha, orden_compra_tipo_doc, orden_compra_numero_doc, orden_compra_doc_adjuntado, orden_compra_fecha_emision_doc, 
                        orden_compra_doc_cuotas, orden_compra_fecha_recibida, orden_compra_usuario_recibido, orden_compra_codigo)
                        values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_solicitante,
                    $model->id_aprobacion,
                    $model->id_proveedor,
                    $model->id_sucursal,
                    $model->id_tipo_pago,
                    $model->orden_compra_observacion,
                    $model->orden_compra_fecha_aprob,
                    $model->orden_compra_titulo,
                    $model->orden_compra_activo,
                    $model->orden_compra_numero,
                    $model->orden_compra_estado,
                    $model->orden_compra_fecha,
                    $model->orden_compra_tipo_doc,
                    $model->orden_compra_numero_doc,
                    $model->orden_compra_doc_adjuntado,
                    $model->orden_compra_fecha_emision_doc,
                    $model->orden_compra_doc_cuotas,
                    $model->orden_compra_fecha_recibida,
                    $model->orden_compra_usuario_recibido,
                    $model->orden_compra_codigo
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function sumar_stock($detalle_compra_cantidad_recibida , $id_recurso_sede){
        try {
            $sql = 'update recursos_sede set recurso_sede_stock = recurso_sede_stock + ? where id_recurso_sede = ? ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$detalle_compra_cantidad_recibida, $id_recurso_sede]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function actualizar_valor_merma($recurso_sede_merma,$recurso_sede_peso_inicial, $recurso_sede_peso_final,$id_recurso_sede){
        try {
            $sql = 'update recursos_sede set recurso_sede_merma = ?, recurso_sede_peso_inicial = ?, recurso_sede_peso_final = ? where id_recurso_sede = ? ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$recurso_sede_merma,$recurso_sede_peso_inicial,$recurso_sede_peso_final, $id_recurso_sede]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function actualizar_valor_merma_($recurso_sede_merma,$id_recurso_sede){
        try {
            $sql = 'update recursos_sede set recurso_sede_merma = ? where id_recurso_sede = ? ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$recurso_sede_merma,$id_recurso_sede]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    //Validar dni
    public function validar_numero_factura($numero_factura){
        try{
            $sql = 'select * from orden_compra where orden_compra_numero_doc = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$numero_factura]);
            $resultado = $stm->fetch();
            (isset($resultado->id_orden_compra))?$result=true:$result=false;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_sucursales(){
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

    public function jalar_recursitos($id_sucursal){
        try{
            $sql = 'select * from recursos_sede rs inner join recursos r on rs.id_recurso = r.id_recurso 
                    where rs.id_sucursal = ? and r.recurso_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_sucursal]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

}