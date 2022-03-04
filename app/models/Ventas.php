<?php

class Ventas
{
    private $pdo;
    private $log;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }

    /*public function listar_ventas_filtro_todo($tipo, $estado, $f_i, $f_f){
        try{
            $sql = 'select * from ventas v inner join clientes c on v.id_cliente = c.id_cliente inner join monedas m on v.id_moneda = m.id_moneda
                    where v.enviar_facturador = ? and date(v.venta_fecha) between ? and ? order by v.venta_fecha desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$tipo, $estado, $f_i, $f_f]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 0;
        }
    }

    public function listar_ventas_filtro_tipo($tipo, $f_i, $f_f){
        try{
            $sql = 'select * from ventas v inner join clientes c on v.id_cliente = c.id_cliente inner join monedas m on v.id_moneda = m.id_moneda
                    where date(v.venta_fecha) between ? and ? order by v.venta_fecha desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$tipo, $f_i, $f_f]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 0;
        }
    }

    public function listar_ventas_filtro_estado($estado, $f_i, $f_f){
        try{
            $sql = 'select * from ventas v inner join clientes c on v.id_cliente = c.id_cliente inner join monedas m on v.id_moneda = m.id_moneda
                    where v.enviar_facturador = ? and date(v.venta_fecha) between ? and ? order by v.venta_fecha desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$estado, $f_i, $f_f]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 0;
        }
    }*/

    public function listar_ventas_sin_enviar(){
        try{
            $sql = 'SELECT * FROM ventas v inner join clientes c on v.id_cliente = c.id_cliente inner join monedas mo
                        on v.id_moneda = mo.id_moneda INNER JOIN usuarios u on v.id_usuario = u.id_usuario inner join mesas m 
                        on v.id_mesa = m.id_mesa inner join tipo_pago tp on v.id_tipo_pago = tp.id_tipo_pago 
                        where v.venta_estado_sunat = 0';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    public function listar_notas_ventas_x_fecha($fecha_i, $fecha_f){
        try{
            $sql = 'SELECT * FROM ventas v inner join clientes c on v.id_cliente = c.id_cliente inner join monedas mo
                        on v.id_moneda = mo.id_moneda INNER JOIN usuarios u on v.id_usuario = u.id_usuario inner join mesas m 
                        on v.id_mesa = m.id_mesa inner join tipo_pago tp on v.id_tipo_pago = tp.id_tipo_pago 
                        where v.venta_estado_sunat = 0 and DATE(v.venta_fecha) between ? and ? and v.venta_tipo = 20 order by v.venta_fecha desc ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_i, $fecha_f]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    public function listar_notas_ventas(){
        try{
            $sql = 'SELECT * FROM ventas v inner join clientes c on v.id_cliente = c.id_cliente inner join monedas mo
                        on v.id_moneda = mo.id_moneda INNER JOIN usuarios u on v.id_usuario = u.id_usuario inner join mesas m 
                        on v.id_mesa = m.id_mesa inner join tipo_pago tp on v.id_tipo_pago = tp.id_tipo_pago 
                        where v.venta_estado_sunat = 0 and v.venta_tipo = 20';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_ventas($sql){
        try{
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_cuotas_x_venta($id){
        try {
            $sql = "select * from ventas_cuotas vc inner join tipo_pago tp on vc.id_tipo_pago = tp.id_tipo_pago where vc.id_ventas = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetchAll();
        }catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }
    public function listar_venta_x_id($id){
        try{
            $sql = "SELECT * FROM ventas v inner join clientes c on v.id_cliente = c.id_cliente inner join monedas mo
                        on v.id_moneda = mo.id_moneda INNER JOIN usuarios u on v.id_usuario = u.id_usuario inner join mesas m 
                        on v.id_mesa = m.id_mesa inner join tipo_pago tp on v.id_tipo_pago = tp.id_tipo_pago 
                        where v.id_venta = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_nota_venta_x_id($id){
        try{
            $sql = "SELECT * FROM nota_venta v inner join clientes c on v.id_cliente = c.id_cliente inner join monedas mo
                        on v.id_moneda = mo.id_moneda INNER JOIN usuarios u on v.id_usuario = u.id_usuario inner join mesas m 
                        on v.id_mesa = m.id_mesa inner join tipo_pago tp on v.id_tipo_pago = tp.id_tipo_pago 
                        where v.id_nota_venta = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_descripcion_segun_nota_credito(){
        try{
            $sql = "select * from tipo_ncreditos where estado = 0";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_descripcion_segun_nota_debito(){
        try{
            $sql = "select * from tipo_ndebitos where estado = 0";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_venta_x_id_pdf($id){
        try{
            $sql = "select * from ventas v inner join empresa e on v.id_empresa = e.id_empresa inner join clientes c on v.id_cliente = c.id_cliente inner join monedas mo
                        on v.id_moneda = mo.id_moneda inner join usuarios u on v.id_usuario = u.id_usuario inner join mesas m 
                        on v.id_mesa = m.id_mesa inner join tipo_pago tp on v.id_tipo_pago = tp.id_tipo_pago inner join monedas m2 
                        on v.id_moneda = m2.id_moneda
                        where v.id_venta = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_venta_x_fecha($fecha, $tipo_venta){
        try{
            $sql = "SELECT * FROM ventas v inner join clientes c on v.id_cliente = c.id_cliente inner join monedas mo
                        on v.id_moneda = mo.id_moneda INNER JOIN usuarios u on v.id_usuario = u.id_usuario inner join mesas m 
                        on v.id_mesa = m.id_mesa inner join tipo_pago tp on v.id_tipo_pago = tp.id_tipo_pago inner join
                        tipo_documentos td on c.id_tipodocumento = td.id_tipodocumento
                        where DATE(v.venta_fecha) = ? and v.venta_tipo <> ? and v.venta_tipo <> '20' and v.venta_estado_sunat = 0 
                          and v.tipo_documento_modificar <> '01' and v.venta_tipo_envio <> 1 ORDER by v.id_venta ASC limit 350";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha, $tipo_venta]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_serie_resumen($codigo){
        try{
            $sql = "SELECT * FROM serie where tipocomp = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$codigo]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_soloventa_x_id($id){
        try{
            $sql = "SELECT * FROM ventas v inner join monedas mo
                        on v.id_moneda = mo.id_moneda inner join mesas m 
                        on v.id_mesa = m.id_mesa inner join tipo_pago tp on v.id_tipo_pago = tp.id_tipo_pago 
                        where v.id_venta = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_clienteventa_x_id($id_cliente){
        try{
        $sql = "SELECT * FROM  clientes c inner join tipo_documentos td on c.id_tipodocumento = td.id_tipodocumento
                        where id_cliente = ?";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([$id_cliente]);
        $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_cliente_notaventa_x_id($id_cliente){
        try{
            $sql = "SELECT * FROM  clientes c inner join tipo_documentos td on c.id_tipodocumento = td.id_tipodocumento
                            where id_cliente = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_cliente]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_producto_x_id($id_producto){
        try{
            $sql = "SELECT * FROM productos where id_producto = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_producto]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_venta_detalle_x_id_venta($id){
        try{
            $sql = "SELECT * FROM ventas_detalle vd inner join comanda_detalle cd on vd.id_comanda_detalle = cd.id_comanda_detalle 
                    INNER JOIN producto_precio pp on cd.id_producto = pp.id_producto inner join unidad_medida um on 
                    pp.id_unidad_medida = um.id_medida inner join tipo_afectacion ta on pp.producto_precio_codigoafectacion = ta.codigo
                    inner join productos p on cd.id_producto = p.id_producto where vd.id_venta = ? and pp.producto_precio_estado = 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    /*public function listar_venta_detalle_x_id_venta_corto($id){
        try{
            $sql = "SELECT * FROM ventas_detalle vd where vd.id_venta = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }*/
    public function listar_nota_venta_detalle_x_id_venta($id){
        try{
            $sql = "SELECT * FROM nota_venta_detalle vd inner join comanda_detalle cd on vd.id_comanda_detalle = cd.id_comanda_detalle 
                    INNER JOIN producto_precio pp on cd.id_producto = pp.id_producto inner join unidad_medida um on 
                    pp.id_unidad_medida = um.id_medida inner join tipo_afectacion ta on pp.producto_precio_codigoafectacion = ta.codigo
                    inner join productos p on cd.id_producto = p.id_producto where vd.id_nota_venta = ? and pp.producto_precio_estado = 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_venta_detalle_x_id_venta_venta($id){
        try{
            $sql = "SELECT * FROM ventas_detalle vd inner join producto_precio pp on vd.id_producto_precio = pp.id_producto_precio
            inner join unidad_medida um on pp.id_unidad_medida = um.id_medida inner join tipo_afectacion ta on 
            pp.producto_precio_codigoafectacion = ta.codigo inner join productos p on pp.id_producto = p.id_producto 
            where vd.id_venta = ? ";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_venta_detalle_x_id_venta_pdf($id){
        try{
            $sql = "SELECT * FROM ventas_detalle vd inner join comanda_detalle cd on vd.id_comanda_detalle = cd.id_comanda_detalle 
                    INNER JOIN producto_precio pp on cd.id_producto = pp.id_producto inner join unidad_medida um on 
                    pp.id_unidad_medida = um.id_medida inner join tipo_afectacion ta on pp.producto_precio_codigoafectacion = ta.codigo
                        where vd.id_venta = ? and pp.producto_precio_estado = 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

//FUNCION PARA GUARDAR UNA VENTA
    public function guardar_nota($model){
        try {
            $sql = 'insert into ventas (id_usuario,id_mesa, id_cliente, id_tipo_pago, id_moneda, venta_tipo_envio, 
                    venta_tipo, venta_serie, venta_correlativo, 
                    venta_totalgratuita, venta_totalexonerada, venta_totalinafecta, venta_totalgravada, venta_totaligv, 
                    venta_icbper ,venta_total, venta_pago_cliente, venta_vuelto, venta_fecha, venta_observacion, tipo_documento_modificar, 
                    serie_modificar, correlativo_modificar, venta_codigo_motivo_nota) 
                    values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_usuario,
                $model->id_mesa,
                $model->id_cliente,
                $model->id_tipo_pago,
                $model->id_moneda,
                $model->venta_tipo_envio,
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
                $model->venta_observacion,
                $model->tipo_documento_modificar,
                $model->serie_modificar,
                $model->correlativo_modificar,
                $model->notatipo_descripcion
            ]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function listar_tipo_notaC_x_codigo($venta_codigo_motivo_nota){
        try{
            $sql = "select * from tipo_ncreditos where codigo = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$venta_codigo_motivo_nota]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_tipo_notaD_x_codigo($venta_codigo_motivo_nota){
        try{
            $sql = "select * from tipo_ndebitos where codigo = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$venta_codigo_motivo_nota]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function guardar_ruta_xml_venta($id_venta,$ruta_xml){
        try{
            $sql = "UPDATE ventas SET venta_rutaXML = ? where id_venta = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$ruta_xml,$id_venta]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }
    public function guardar_ruta_cdr_venta($id_venta,$ruta_cdr){
        try{
            $sql = "UPDATE ventas SET venta_rutaCDR = ? where id_venta = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$ruta_cdr,$id_venta]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }
    public function guardar_repuesta_venta($id_venta, $estado_sunat){
        try{
            $sql = "UPDATE ventas SET venta_respuesta_sunat = ? where id_venta = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$estado_sunat,$id_venta]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }
    public function guardar_estado_de_envio_venta($id_venta, $tipo_envio, $estado){
        try{
            $date = date('Y-m-d H:i:s');
            $sql = "UPDATE ventas SET venta_tipo_envio = ?, venta_estado_sunat = ?, venta_fecha_envio=? where id_venta = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$tipo_envio, $estado, $date,$id_venta]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 5;
        }
        return $result;
    }
    public function editar_venta_condicion_resumen_anulado_x_venta($id_venta, $venta_condicion){
        try{
            $date = date('Y-m-d H:i:s');
            $sql = "UPDATE ventas SET venta_condicion_resumen = ? where id_venta = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$venta_condicion,$id_venta]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 5;
        }
        return $result;
    }
    public function listar_empresa_x_id_empresa($id_empresa){
        try{
            $sql = "SELECT * FROM empresa where id_empresa = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_empresa]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function actualizar_serie_resumen($codigo, $serie){
        try{
            $sql = "UPDATE serie SET serie = ? where tipocomp = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$serie,$codigo]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }
    public function actualizar_correlativo_resumen($codigo, $correlativo){
        try{
            $sql = "UPDATE serie SET correlativo = ? where tipocomp = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$correlativo,$codigo]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }
    public function guardar_resumen_diario($fecha,$serie,$correlativo,$ruta_xml,$estado,$mensaje,$ticket){
        try{
            $sql = "insert into envio_resumen (envio_resumen_fecha, envio_resumen_serie, envio_resumen_correlativo, envio_resumen_nombreXML,
                                                envio_resumen_estado, envio_resumen_estadosunat, envio_resumen_ticket) value (?,?,?,?,?,?,?)";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha,$serie,$correlativo,$ruta_xml,$estado,$mensaje,$ticket]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }
    public function guardar_venta_anulacion($fecha,$serie,$correlativo,$ruta_xml,$mensaje,$id_venta,$id_user,$ticket){
        try{
            $sql = "insert into ventas_anulados (venta_anulado_fecha, venta_anulado_serie, venta_anulado_correlativo, 
                    venta_anulacion_ticket, venta_anulado_rutaXML, venta_anulado_estado_sunat, id_venta, id_user) 
                    value (?,?,?,?,?,?,?,?)";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha,$serie,$correlativo,$ticket,$ruta_xml,$mensaje,$id_venta,$id_user]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }
    public function listar_envio_resumen_x_ticket($ticket){
        try{
            $sql = "select * from envio_resumen where envio_resumen_ticket = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$ticket]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function guardar_resumen_diario_detalle($id_envio_resumen,$id_venta){
        try{
            $sql = "insert into envio_resumen_detalle (id_envio_resumen, id_venta, envio_resumen_detalle_condicion) value (?,?,1)";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_envio_resumen,$id_venta]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }
    public function actualizar_estadoconsulta_x_ticket($ticket,$nombre_ruta_cdr,$mensaje_consulta){
        try{
            $sql = "UPDATE envio_resumen SET envio_resumen_nombreCDR = ?,
                                             envio_resumen_estadosunat_consulta = ?
                                             where envio_resumen_ticket = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$nombre_ruta_cdr,$mensaje_consulta,$ticket]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }
    public function listar_resumen_diario_fecha($fechaini, $fechafin){
        try{
            $sql = "select * from envio_resumen where DATE(envio_sunat_datetime) between ? and ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fechaini, $fechafin]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_comunicacion_baja_fecha($fechaini, $fechafin){
        try{
            $sql = "select * from ventas_anulados va inner join ventas v on va.id_venta = v.id_venta";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fechaini, $fechafin]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_resumen_diario_x_id($id_resumen){
        try{
            $sql = "select * from envio_resumen where id_envio_resumen = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_resumen]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_resumen_diario_detalle_x_id($id_resumen){
        try{
            $sql = "select * from envio_resumen_detalle er inner join ventas v on er.id_venta = v.id_venta where er.id_envio_resumen = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_resumen]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_resumen_diario_x_id_venta($id_venta){
        try{
            $sql = "select * from envio_resumen_detalle er inner join ventas v on er.id_venta = v.id_venta where er.id_venta = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_venta]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_venta_anulacion_x_ticket($ticket){
        try{
            $sql = "select * from ventas_anulados where venta_anulacion_ticket = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$ticket]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function editar_estado_venta_anulado($id_venta){
        try{
            $sql = "UPDATE ventas SET anulado_sunat = ?, venta_cancelar = ? where id_venta = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([1, 0,$id_venta]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 5;
        }
        return $result;
    }
    public function actualizar_estadoconsulta_x_ticket_anulado($ticket,$nombre_ruta_cdr,$mensaje_consulta){
        try{
            $sql = "UPDATE ventas_anulados SET venta_anulado_rutaCDR = ?,
                                             venta_anulado_estado_sunat = ?
                                             where venta_anulacion_ticket = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$nombre_ruta_cdr,$mensaje_consulta,$ticket]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }
    public function actualizar_venta_anulado($id_venta, $estado){
        try{
            $sql = "UPDATE ventas SET venta_condicion_resumen = ?,
                                             venta_tipo_envio = ?,
                    anulado_sunat = ?, venta_cancelar = ?, venta_estado_sunat = ?
                                             where id_venta = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$estado,2,1,0,0,$id_venta]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }
    public function listar_productos_(){
        try {
            $sql = 'select * from productos p inner join producto_precio pp on p.id_producto = pp.id_producto where pp.producto_precio_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }
    public function anular_comprobante_relacionado($serie,$correlativo){
        try {
            $sql = 'update ventas set anulado_sunat = ?, venta_cancelar = ? where venta_serie = ? and venta_correlativo = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                1,0,$serie, $correlativo
            ]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }
    public function listar_ventas_enviadas_activos(){
        try{
            $sql = 'select * from ventas where venta_tipo <> 07 and anulado_sunat = 0 and venta_cancelar = 1';

            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function listar_ventas_enviadas_activos_dia(){
        $date = date('Y-m-d');
        try{
            $sql = 'select * from ventas where venta_tipo <> 07 and anulado_sunat = 0 and 
                           venta_cancelar = 1 and DATE(venta_fecha) = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$date]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function search_by_barcode($product_barcode){
        try {
            $sql = 'select * from productos p inner join producto_precio pp on p.id_producto = pp.id_producto inner join 
                    unidad_medida m on pp.id_unidad_medida = m.id_medida
                    where p.producto_codigo_barra = ? and pp.producto_precio_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$product_barcode]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }
    public function listar_recurso_sede_x_producto($product){
        try {
            $sql = 'select rs.recurso_sede_stock from productos p inner join recetas r on p.id_receta = r.id_receta inner join detalle_recetas dr 
                    on r.id_receta = dr.id_receta inner join recursos_sede rs on dr.id_recursos_sede = rs.id_recurso_sede
                    where p.id_producto = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$product]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }
}