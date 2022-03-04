<?php

class Reporte
{
    private $pdo;
    private $log;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }


    public function listar_datos_egresos($dato,$id_caja_numero=null){
        try{
            if($id_caja_numero==null){
                $sql = 'select SUM(egreso_monto) total from movimientos where date(egreso_fecha_registro) = ? and egreso_estado = 1 and movimiento_tipo = 2';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato]);
            }else{
                $sql = 'select SUM(egreso_monto) total from movimientos where date(egreso_fecha_registro) = ? and id_caja_numero = ? and egreso_estado = 1 
                    and movimiento_tipo = 2';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato,$id_caja_numero]);
            }
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function listar_datos_ingresos_caja($dato,$id_caja_numero=null){
        try{
            if($id_caja_numero==null){
                $sql = 'select SUM(egreso_monto) total from movimientos where date(egreso_fecha_registro) = ? and egreso_estado = 1 
                        and movimiento_tipo = 1';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato]);
            }else{
                $sql = 'select SUM(egreso_monto) total from movimientos where date(egreso_fecha_registro) = ? and id_caja_numero = ? and egreso_estado = 1 
                        and movimiento_tipo = 1';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato,$id_caja_numero]);
            }
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }
    //FUNCION PARA INGRESOS TOTALES
    public function listar_datos_ingresos_($dato,$id_caja_numero=null){
        try{
            if($id_caja_numero==null){
                $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta 
                    where date(venta_fecha) = ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 3';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato]);
            }else{
                $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta 
                    where date(venta_fecha) = ? and id_caja_numero = ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 3';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato,$id_caja_numero]);
            }
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }
    public function listar_datos_ingresos_tarjeta_($dato,$id_caja_numero=null){
        try{
            if($id_caja_numero==null) {
                $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta 
                        where date(venta_fecha) = ? and venta_tipo <> 07 
                        and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 1';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato]);
            }else{
                $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta 
                        where date(venta_fecha) = ? and v.id_caja_numero = ? and venta_tipo <> 07 
                        and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 1';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato,$id_caja_numero]);
            }
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }
    public function listar_datos_ingresos_transferencia_($dato,$id_caja_numero=null){
        try{
            if($id_caja_numero==null) {
                $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta 
                        where date(venta_fecha) = ? and venta_tipo <> 07 
                        and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 2';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato]);
            }else{
                $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta 
                        where date(venta_fecha) = ? and v.id_caja_numero = ? and venta_tipo <> 07 
                        and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 2';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato,$id_caja_numero]);
            }
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    //FUNCIONES PARA INGRESOS POR PARTES
    public function listar_datos_ingresos($dato,$id_caja_numero=null){
        try{
            if($id_caja_numero==null){
                $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta 
                    where date(venta_fecha) = ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 3 and id_mesa <> 0';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato]);
            }else{
                $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta 
                    where date(venta_fecha) = ? and id_caja_numero = ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 3 and id_mesa <> 0';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato,$id_caja_numero]);
            }
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function listar_datos_ingresos_delivery($dato,$id_caja_numero=null){
        try{
            if($id_caja_numero==null){
                $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta 
                    where date(venta_fecha) = ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 3 and id_mesa = 0';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato]);
            }else{
                $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta 
                    where date(venta_fecha) = ? and id_caja_numero = ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 3 and id_mesa = 0';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato,$id_caja_numero]);
            }
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function listar_datos_ingresos_tarjeta($dato,$id_caja_numero=null){
        try{
            if($id_caja_numero==null) {
                $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta 
                        where date(venta_fecha) = ? and venta_tipo <> 07 
                        and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 1 and id_mesa <> 0';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato]);
            }else{
                $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta 
                        where date(venta_fecha) = ? and v.id_caja_numero = ? and venta_tipo <> 07 
                        and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 1 and id_mesa <> 0';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato,$id_caja_numero]);
            }
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function listar_datos_ingresos_tarjeta_delivery($dato,$id_caja_numero=null){
        try{
            if($id_caja_numero==null) {
                $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta 
                        where date(venta_fecha) = ? and venta_tipo <> 07 
                        and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 1 and id_mesa = 0';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato]);
            }else{
                $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta 
                        where date(venta_fecha) = ? and v.id_caja_numero = ? and venta_tipo <> 07 
                        and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 1 and id_mesa = 0';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato,$id_caja_numero]);
            }
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function listar_datos_ingresos_transferencia($dato,$id_caja_numero=null){
        try{
            if($id_caja_numero==null) {
                $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta 
                        where date(venta_fecha) = ? and venta_tipo <> 07 
                        and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 2 and id_mesa <> 0';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato]);
            }else{
                $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta 
                        where date(venta_fecha) = ? and v.id_caja_numero = ? and venta_tipo <> 07 
                        and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 2 and id_mesa <> 0';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato,$id_caja_numero]);
            }
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function listar_datos_ingresos_transferencia_delivery($dato,$id_caja_numero=null){
        try{
            if($id_caja_numero==null) {
                $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta 
                    where date(venta_fecha) = ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and v.id_tipo_pago = 2 and id_mesa = 0';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato]);
            }else{
                $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta 
                        where date(venta_fecha) = ? and v.id_caja_numero = ? and venta_tipo <> 07 
                        and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 2 and id_mesa = 0';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato,$id_caja_numero]);
            }
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function sumar_caja($dato,$id_caja_numero=null){
        try{
            if($id_caja_numero==null){
                $sql = 'select SUM(caja_apertura) total from caja where date(caja_fecha) = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato]);
            }else{
                $sql = 'select SUM(caja_apertura) total from caja where date(caja_fecha) = ? and id_caja_numero = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato,$id_caja_numero]);
            }
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function listar_monto_op($dato,$id_caja_numero=null){
        try{
            if($id_caja_numero==null){
                $sql = 'select SUM(detalle_compra_total_pagado) total from orden_compra oc inner join detalle_compra dc on oc.id_orden_compra = dc.id_orden_compra 
                    where date(orden_compra_fecha_aprob) = ? and orden_compra_estado = 1';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato]);
            }else{
                $sql = 'select SUM(detalle_compra_total_pagado) total from orden_compra oc inner join detalle_compra dc on oc.id_orden_compra = dc.id_orden_compra 
                    where id_caja_numero = ? and date(orden_compra_fecha_aprob) = ? and orden_compra_estado = 1';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato,$id_caja_numero]);
            }
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }


    public function clientes_sucursal_todo($dni_cliente,$fecha_i,$fecha_f){
        try{
            $sql = 'select count(v.id_venta) total,sum(v.venta_total) total_venta, v.venta_fecha, c. * from clientes c inner join ventas v 
                    on c.id_cliente = v.id_cliente where c.cliente_numero = ? and date(venta_fecha) between ? and ? and c.id_cliente <> 0 
                    and v.venta_tipo <> 07 and v.venta_estado_sunat = 1 and v.anulado_sunat = 0 and v.venta_cancelar = 1 group by v.id_cliente';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$dni_cliente,$fecha_i,$fecha_f]);
            $return = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function clientes_fechas($fecha_i,$fecha_f){
        try{
            $sql = 'select count(v.id_venta) total,sum(v.venta_total) total_venta, v.venta_fecha, c. * from clientes c inner join ventas v 
                    on c.id_cliente = v.id_cliente where date(venta_fecha) between ? and ? and c.id_cliente <> 0 group by v.id_cliente';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_i,$fecha_f]);
            $return = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function clientes_dni($dni_cliente){
        try{
            $sql = 'select count(v.id_venta) total,sum(v.venta_total) total_venta, v.venta_fecha, c. * from clientes c inner join ventas v 
                    on c.id_cliente = v.id_cliente where c.cliente_numero = ? and c.id_cliente <> 0 group by v.id_cliente';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$dni_cliente]);
            $return = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function datos_meseros($fecha_i,$fecha_f){
        try{
            $sql = 'select count(c.id_comanda) total, sum(comanda_total) total_comanda,p.persona_nombre from comanda c inner join usuarios u 
                    on c.id_usuario = u.id_usuario inner join personas p on u.id_persona = p.id_persona inner join roles r on u.id_rol = r.id_rol 
                    where date(c.comanda_fecha_registro) between ? and ? group by u.id_persona';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_i,$fecha_f]);
            $return = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function datos_proveedores($fecha_i,$fecha_f){
        try{
            $sql = 'select * from orden_compra oc inner join usuarios u on oc.id_solicitante = u.id_usuario inner join personas p2 on u.id_persona = p2.id_persona 
                    inner join detalle_compra dc on oc.id_orden_compra = dc.id_orden_compra inner join tipo_pago tp on oc.id_tipo_pago = tp.id_tipo_pago
                    inner join recursos_sede rs on dc.id_recurso_sede = rs.id_recurso_sede inner join recursos r on rs.id_recurso = r.id_recurso 
                    inner join proveedor p on oc.id_proveedor = p.id_proveedor where date(orden_compra_fecha_recibida) between ? and ? and oc.orden_compra_usuario_recibido = 1
                    group by oc.id_orden_compra';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_i,$fecha_f]);
            $return = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function datos_insumos($fecha_i,$fecha_f,$id_recurso_sede){
        try{
            $sql = 'select * from orden_compra oc inner join detalle_compra dc on oc.id_orden_compra = dc.id_orden_compra inner join recursos_sede rs 
                    on dc.id_recurso_sede = rs.id_recurso_sede inner join recursos r on rs.id_recurso = r.id_recurso 
                    inner join unidad_medida um on rs.id_medida = um.id_medida
                    where date(orden_compra_fecha_recibida) BETWEEN ? and ? and dc.id_recurso_sede = ? group by rs.id_recurso_sede ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_i,$fecha_f,$id_recurso_sede]);
            $return = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function datos_recurso($id_recurso_sede){
        try{
            $sql = 'select * from recursos r inner join recursos_sede rs on r.id_recurso = rs.id_recurso where rs.id_recurso_sede = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_recurso_sede]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_insumos($id){
        try{
            $sql = 'select * from detalle_compra dc inner join recursos_sede rs on dc.id_recurso_sede = rs.id_recurso_sede inner join recursos r on rs.id_recurso = r.id_recurso
                    where dc.id_orden_compra = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function calcular_total($id){
        try{
            $sql = 'select sum(detalle_compra_total_pagado) total from detalle_compra where id_orden_compra = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
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

    public function cantidad_compra($id_recurdo_sede){
        try{
            $sql = 'select count(id_detalle_compra) total from detalle_compra where id_recurso_sede = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_recurdo_sede]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function sumar_kilos($id_recurdo_sede){
        try{
            $sql = 'select sum(detalle_compra_cantidad_recibida) total from detalle_compra where id_recurso_sede = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_recurdo_sede]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_tipos_pago(){
        try{
            $sql = 'select * from tipo_pago';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_tipos_pagos($pago_tipo){
        try{
            $sql = 'select * from tipo_pago where id_tipo_pago = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$pago_tipo]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function ventas_tipo_pago($pago_tipo,$fecha_hoy, $fecha_fin){
        try{
            $sql = 'select * from ventas v inner join tipo_pago tp on v.id_tipo_pago = tp.id_tipo_pago inner join clientes c on v.id_cliente = c.id_cliente
                    where v.id_tipo_pago = ? and date(venta_fecha) between ? and ? order by venta_fecha desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$pago_tipo,$fecha_hoy, $fecha_fin]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function ventas_tipo_pago_fechas($fecha_hoy, $fecha_fin){
        try{
            $sql = 'select * from ventas v inner join tipo_pago tp on v.id_tipo_pago = tp.id_tipo_pago inner join clientes c on v.id_cliente = c.id_cliente
                    where date(venta_fecha) between ? and ? order by venta_fecha desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_hoy, $fecha_fin]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function restar_horas($horaini,$horafin){
        $f1 = new DateTime($horaini);
        $f2 = new DateTime($horafin);
        $d = $f1->diff($f2);
        return (($d->y * 365 * 24 * 60 * 60) + ($d->m * 30 * 24 * 60 * 60) + ($d->d * 24 * 60 * 60) + ($d->h * 60 * 60) + ($d->i * 60) + $d->s);
    }

    public function sumar_horas($horas) {
        $total = 0;
        foreach($horas as $h) {
            $parts = explode(":", $h);
            $total += $parts[2] + $parts[1]*60 + $parts[0]*3600;
        }
        return gmdate("H:i:s", $total);
    }

    public function listar_grupos(){
        try{
            $sql = 'select * from grupos where grupo_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function datos_comandas($fecha_i,$fecha_f){
        try{
            $sql = 'select * from comanda where comanda_estado = 1 and date(comanda_fecha_registro) between ? and ? ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_i,$fecha_f]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function datos_comanda_detalles($id_comanda , $id_grupo){
        try{
            $sql = 'select * from comanda_detalle cd inner join productos p on cd.id_producto = p.id_producto inner join grupos g 
                    on p.id_grupo = g.id_grupo where id_comanda = ? and p.id_grupo = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda, $id_grupo]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function cantidad_vendida(){
        try{
            $sql = '';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 0;
        }
        return $result;
    }

    public function jalar_id_caja_numero($fecha_hoy,$id_usuario){
        try{
            $sql = 'select * from caja where date(caja_fecha) = ? 
                    and id_usuario_apertura = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_hoy,$id_usuario]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function reporte_caja($fecha_hoy,$fecha_fin,$id_caja_numero){
        try{
            $sql = 'select * from caja where date(caja_fecha) = ? 
                    and id_usuario_apertura = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_hoy,$fecha_fin,$id_caja_numero]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function puntitos_x_cliente($id_cliente){
        try{
            $sql = 'select sum(puntos_cliente_acumulado) total from puntos_cliente where id_cliente = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_cliente]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function datos_por_apertura_caja($id_usuario,$fecha_i,$fecha_f){
        try{
            $sql = 'select id_caja from caja where id_usuario_apertura = ? and date(caja_fecha_apertura) between ? and ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_usuario,$fecha_i,$fecha_f]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function datitos_caja($id_caja){
        try{
            $sql = 'select * from caja where id_caja = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function reporte_productos($fecha_filtro,$fecha_filtro_fin,$id_caja){
        try{
            $sql = 'select sum(vd.venta_detalle_cantidad) total, p.producto_nombre from ventas v inner join ventas_detalle vd on v.id_venta = vd.id_venta
                    inner join caja c on v.id_caja_numero = c.id_caja_numero
                    inner join comanda_detalle cd on vd.id_comanda_detalle = cd.id_comanda_detalle inner join 
                    productos p on cd.id_producto = p.id_producto where v.venta_fecha between ? and ? and c.id_caja = ? group by p.id_producto ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_filtro,$fecha_filtro_fin,$id_caja]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 0;
        }
        return $result;
    }

    public function listar_egresos_descripcion($fecha_filtro,$fecha_filtro_fin){
        try{
            $sql = 'select * from movimientos where egreso_fecha_registro between ? and ? and movimiento_tipo = 2 
                    and egreso_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_filtro, $fecha_filtro_fin]);
            $return = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }


    //NUEVAS CONSULTAS PARA EL REPORTE

    public function reporte_ingresos_x_caja($id_usuario, $fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select sum(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta 
                    inner join caja c on v.id_caja_numero = c.id_caja_numero where v.id_usuario = ? and v.venta_fecha between ? and ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_usuario, $fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function reporte_caja_x_caja($id_caja, $fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select sum(caja_apertura) total from caja where id_caja = ? and caja_fecha_apertura between ? and ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja, $fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function ingreso_caja_chica_x_caja($id_caja,$fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select sum(egreso_monto) total from movimientos m inner join caja c on m.id_caja_numero = c.id_caja_numero
                    where c.id_caja =? and egreso_fecha_registro between ? and ? and movimiento_tipo = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja,$fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function ventas_efectivo($id_caja, $fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta
                    inner join caja c on v.id_caja_numero = c.id_caja_numero
                    where c.id_caja = ? and v.venta_fecha between ? and ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 3 and vdp.venta_detalle_pago_estado = 1 and v.id_mesa <> 0';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja, $fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function ventas_tarjeta($id_caja, $fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta
                    inner join caja c on v.id_caja_numero = c.id_caja_numero
                    where c.id_caja = ? and v.venta_fecha between ? and ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 1 and vdp.venta_detalle_pago_estado = 1 and v.id_mesa <> 0';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja, $fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function ventas_trans_plin($id_caja, $fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta
                    inner join caja c on v.id_caja_numero = c.id_caja_numero
                    where c.id_caja = ? and v.venta_fecha between ? and ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 5 and vdp.venta_detalle_pago_estado = 1 and v.id_mesa <> 0';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja, $fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function ventas_trans_yape($id_caja, $fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta
                    inner join caja c on v.id_caja_numero = c.id_caja_numero
                    where c.id_caja = ? and v.venta_fecha between ? and ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 4 and vdp.venta_detalle_pago_estado = 1 and v.id_mesa <> 0';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja, $fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function ventas_trans_otros($id_caja, $fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta
                    inner join caja c on v.id_caja_numero = c.id_caja_numero
                    where c.id_caja = ? and v.venta_fecha between ? and ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 6 and vdp.venta_detalle_pago_estado = 1 and v.id_mesa <> 0';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja, $fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function salida_caja_chica_x_caja($id_caja, $fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select sum(egreso_monto) total from movimientos m inner join caja c on m.id_caja_numero = c.id_caja_numero
                    where c.id_caja = ? and egreso_fecha_registro between ? and ? and movimiento_tipo = 2';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja, $fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function reporte_productos_($fecha_filtro,$fecha_filtro_fin){
        try{
            $sql = 'select sum(vd.venta_detalle_cantidad) total, p.producto_nombre from ventas v inner join ventas_detalle vd on v.id_venta = vd.id_venta 
                    inner join comanda_detalle cd on vd.id_comanda_detalle = cd.id_comanda_detalle inner join 
                    productos p on cd.id_producto = p.id_producto where v.id_caja_numero = 1 and v.venta_fecha between ? and ? group by p.id_producto ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_filtro,$fecha_filtro_fin]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 0;
        }
        return $result;
    }

    //CONSULTAS PARA DELIVERY

    public function listar_datos_ingresos_delivery_($id_caja, $fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta
                    inner join caja c on v.id_caja_numero = c.id_caja_numero
                    where c.id_caja = ? and v.venta_fecha between ? and ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 3 and vdp.venta_detalle_pago_estado = 1 and v.id_mesa = 0';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja, $fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function listar_datos_ingresos_tarjeta_delivery_($id_caja, $fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta
                    inner join caja c on v.id_caja_numero = c.id_caja_numero
                    where c.id_caja = ? and v.venta_fecha between ? and ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 1 and vdp.venta_detalle_pago_estado = 1 and v.id_mesa = 0';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja, $fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function listar_datos_ingresos_transferencia_delivery_plin($id_caja, $fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta
                    inner join caja c on v.id_caja_numero = c.id_caja_numero
                    where c.id_caja = ? and v.venta_fecha between ? and ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 5 and vdp.venta_detalle_pago_estado = 1 and v.id_mesa = 0';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja, $fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function listar_datos_ingresos_transferencia_delivery_yape($id_caja, $fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta
                    inner join caja c on v.id_caja_numero = c.id_caja_numero
                    where c.id_caja = ? and v.venta_fecha between ? and ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 4 and vdp.venta_detalle_pago_estado = 1 and v.id_mesa = 0';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja, $fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function listar_datos_ingresos_transferencia_delivery_otros($id_caja, $fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta
                    inner join caja c on v.id_caja_numero = c.id_caja_numero
                    where v.id_usuario = ? and v.venta_fecha between ? and ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 6 and vdp.venta_detalle_pago_estado = 1 and v.id_mesa = 0';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja, $fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function valores($id_gasto){
        try{
            $sql = 'select sum(gasto_personal_monto) total from gastos_personal gp inner join caja c on gp.id_caja_numero = c.id_caja 
                    where id_gasto_personal = ? and gasto_personal_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_gasto]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function datos_gastos_p($id_caja){
        try{
            $sql = 'SELECT gp.id_gasto_personal as id_gasto_personal, p.id_persona AS id_persona, p.persona_nombre AS nombre, p.persona_apellido_paterno AS apellido from gastos_personal gp 
                    inner join caja c on gp.id_caja_numero = c.id_caja
                    inner join personas p on gp.id_persona = p.id_persona where c.id_caja = ? and gp.gasto_personal_estado = 1 group by p.id_persona, p.persona_nombre, p.persona_apellido_paterno';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja]);
            $return = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function sumar_datos_p($id_caja){
        try{
            $sql = 'select sum(gasto_personal_monto) total from gastos_personal gp
                    inner join caja c on gp.id_caja_numero = c.id_caja
                    where c.id_caja = ? and gp.gasto_personal_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function n_ventas_delivery($id_usuario,$fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select count(id_venta) total from ventas where id_usuario = ? and date(venta_fecha) between ? and ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and id_mesa = 0';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_usuario,$fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function n_ventas_salon($id_caja,$fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select count(v.id_venta) total from ventas v inner join caja c on v.id_caja_numero = c.id_caja_numero 
                    where c.id_caja = ? and venta_fecha between ? and ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and id_mesa <> 0';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja,$fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    //FUNCIONES NUEVAS PARA EL REPORTE POR CAJAS ULTIMA CONCHITA DE PUNCHANA
    public function datos_por_apertura_caja_($fecha_i,$fecha_f){
        try{
            $sql = 'select id_caja from caja where date(caja_fecha_apertura) between ? and ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_i,$fecha_f]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }






}