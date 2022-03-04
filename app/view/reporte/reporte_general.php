

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <form method="post" action="<?= _SERVER_ ?>Reporte/reporte_general">
                <input type="hidden" id="enviar_fecha" name="enviar_fecha" value="1">
                <div class="row">
                    <div class="col-lg-3 col-xs-6 col-md-6 col-sm-6">
                        <label for="">Caja</label>
                        <select class="form-control" id="id_caja_numero" name="id_caja_numero">
                            <?php
                            (isset($caja_))?$cajita=$caja_->id_caja_numero:$cajita=0;
                            foreach($caja as $l){
                                ($l->id_caja_numero == $cajita)?$sele='selected':$sele='';
                                ?>
                                <option value="<?php echo $l->id_caja_numero;?>" <?= $sele; ?>><?php echo $l->caja_numero_nombre;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-3 col-xs-6 col-md-6 col-sm-6" style="display:none;">
                        <label for="">Usuario</label>
                        <select class="form-control" id="id_usuario" name="id_usuario">
                            <?php
                            (isset($usuario_))?$user=$usuario_->id_usuario:$user=0;
                            foreach($usuario as $l){
                                ($l->id_usuario == $user)?$sele='selected':$sele='';
                                ?>
                                <option value="<?php echo $l->id_usuario;?>" <?= $sele; ?>><?php echo $l->persona_nombre;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="turno">Desde:</label>
                        <input type="date" class="form-control" id="fecha_filtro" name="fecha_filtro" step="1" value="<?php echo $fecha_i;?>">
                    </div>
                    <div class="col-lg-3">
                        <label for="turno">Hasta:</label>
                        <input type="date" class="form-control" id="fecha_filtro_fin" name="fecha_filtro_fin" value="<?php echo $fecha_f;?>">
                    </div>
                    <div class="col-lg-3">
                        <button style="margin-top: 35px;" class="btn btn-success" ><i class="fa fa-search"></i> Buscar Registro</button>
                    </div>
                </div>
            </form>
            <br>

            <div class="row">
                <?php
                foreach ($cajas_totales as $ct){
                    $datitos = $this->reporte->datitos_caja($ct->id_caja);
                    ?>
                    <div class="col-lg-6">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="table">
                                        <p>Apertura : <?= $datitos->caja_fecha_apertura;?> // Cierre : <?= $datitos->caja_fecha_cierre?> // Monto Cierre : <?= $datitos->caja_cierre;?></p>
                                        <?php
                                        if($datos){
                                            $fecha_ini_caja = $datitos->caja_fecha_apertura;
                                            if($datitos->caja_fecha_cierre==NULL){
                                                $fecha_fin_caja = date('Y-m-d H:i:s');
                                            }else{
                                                $fecha_fin_caja = $datitos->caja_fecha_cierre;
                                            }
                                            //N° DE VENTAS POR TIPO
                                            $n_ventas_delivery = $this->reporte->n_ventas_delivery($ct->id_caja,$fecha_ini_caja, $fecha_fin_caja);
                                            $n_ventas_salon = $this->reporte->n_ventas_salon($ct->id_caja,$fecha_ini_caja, $fecha_fin_caja);

                                            $datos_gastos_p = $this->reporte->datos_gastos_p($ct->id_caja);
                                            $sumar_datos_p = $this->reporte->sumar_datos_p($ct->id_caja);
                                            //$reporte_ingresos = $this->reporte->reporte_ingresos_x_caja($id_usuario, $fecha_ini_caja, $fecha_fin_caja);
                                            $monto_caja_apertura = $this->reporte->reporte_caja_x_caja($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
                                            $ingreso_caja_chica = $this->reporte->ingreso_caja_chica_x_caja($ct->id_caja,$fecha_ini_caja, $fecha_fin_caja);
                                            //REPORTE DE VENTAS POR SALON
                                            $ventas_efectivo_salon = $this->reporte->ventas_efectivo($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
                                            $ventas_tarjeta_salon = $this->reporte->ventas_tarjeta($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
                                            $ventas_trans = $this->reporte->ventas_trans_plin($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
                                            $ventas_trans_yape = $this->reporte->ventas_trans_yape($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
                                            $ventas_trans_otros = $this->reporte->ventas_trans_otros($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
                                            //SALIDA DE CAJA CHICA
                                            $salida_caja_chica = $this->reporte->salida_caja_chica_x_caja($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
                                            //FUNCIONES PARA LOS INGRESOS DEL DELIVERY
                                            $reporte_ingresos_delivery = $this->reporte->listar_datos_ingresos_delivery_($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
                                            $reporte_ingresos_tarjeta_delivery = $this->reporte->listar_datos_ingresos_tarjeta_delivery_($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
                                            $ventas_transferencia_delivery = $this->reporte->listar_datos_ingresos_transferencia_delivery_plin($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
                                            $ventas_transferencia_delivery_yape = $this->reporte->listar_datos_ingresos_transferencia_delivery_yape($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
                                            $ventas_transferencia_delivery_otros = $this->reporte->listar_datos_ingresos_transferencia_delivery_otros($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);

                                            $sumar_datos_p = $sumar_datos_p->total;
                                            //FUNCIONES DESGLOSADAS PARA SALON
                                            $monto_caja_apertura = $monto_caja_apertura->total;
                                            $ingreso_caja_chica = $ingreso_caja_chica->total;
                                            //FUNCIONES PARA VENTAS SALON
                                            $ventas_efectivo  = $ventas_efectivo_salon->total;
                                            $ventas_tarjeta  = $ventas_tarjeta_salon->total;
                                            $ventas_trans  = $ventas_trans->total;
                                            $ventas_trans_yape  = $ventas_trans_yape->total;
                                            $ventas_trans_otros = $ventas_trans_otros->total;
                                            //FUNCIONES DESGLOSADAS PARA DELIVERY
                                            $ventas_efectivo_delivery = $reporte_ingresos_delivery->total;
                                            $ventas_tarjeta_delivery = $reporte_ingresos_tarjeta_delivery->total;
                                            $ventas_transferencia_delivery = $ventas_transferencia_delivery->total;
                                            $ventas_transferencia_delivery_yape = $ventas_transferencia_delivery_yape->total;
                                            $ventas_transferencia_delivery_otros = $ventas_transferencia_delivery_otros->total;
                                            //FUNCIONES PARA DESGLOSAR SALIDA DE CAJA
                                            $salida_caja_chica = $salida_caja_chica->total;


                                            $ingresos_total_de_ventas = $ventas_efectivo + $ventas_tarjeta + $ventas_trans + $ventas_trans_yape + $ventas_trans_otros + $ventas_efectivo_delivery +
                                                                        $ventas_tarjeta_delivery + $ventas_transferencia_delivery + $ventas_transferencia_delivery_yape + $ventas_transferencia_delivery_otros;
                                            //INGRESOS TOTAL DE VENTAS
                                            $ingresos_totales_salon = $ventas_efectivo + $ventas_trans + $ventas_trans_yape + $ventas_trans_otros + $ventas_tarjeta;
                                            //INGRESOS TOTAL DELIVERY
                                            $ingresos_totales_delivery = $ventas_efectivo_delivery + $ventas_tarjeta_delivery + $ventas_transferencia_delivery +
                                                $ventas_transferencia_delivery_yape + $ventas_transferencia_delivery_otros;
                                            //INGRESOS - EGRESOS
                                            $ingresos_generales = $ventas_efectivo + $ventas_trans + $ventas_trans_yape + $ventas_trans_otros  + $ventas_tarjeta +
                                                $ventas_efectivo_delivery + $ventas_tarjeta_delivery + $ventas_transferencia_delivery + $ventas_transferencia_delivery_yape + $ventas_transferencia_delivery_otros
                                                + $monto_caja_apertura + $ingreso_caja_chica - $salida_caja_chica - $sumar_datos_p;
                                            $egresos_totales = $salida_caja_chica;

                                            $diferencia = $monto_caja_apertura + $ingreso_caja_chica + $ventas_efectivo + $ventas_efectivo_delivery - $salida_caja_chica - $sumar_datos_p;

                                        }

                                        ?>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- TOTAL DE VENTAS DEL DIA:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right"> S/.<?= $ingresos_total_de_ventas ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- INGRESOS - EGRESOS:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right"> S/.<?= $ingresos_generales ?? 0?></label>
                                            </div>
                                        </div>
                                        <p style="border-bottom: 1px solid red"></p>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- Apertura de Caja</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right"> S/.<?= $monto_caja_apertura ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- Ingresos caja chica</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $ingreso_caja_chica ?? 0?></label>
                                            </div>
                                        </div>
                                        <p style="border-bottom: 1px solid red"></p>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- TOTAL VENTAS EN SALON:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $ingresos_totales_salon ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- Pagos Efectivo:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $ventas_efectivo ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- Pagos Tarjeta:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $ventas_tarjeta ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- Pagos Transferencia Plin:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $ventas_trans ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- Pagos Transferencia Yape:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $ventas_trans_yape ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- Pagos Transferencia Otros:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $ventas_trans_otros ?? 0?></label>
                                            </div>
                                        </div>
                                        <p style="border-bottom: 1px solid red"></p>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- TOTAL VENTAS DELIVERY:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $ingresos_totales_delivery ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- Pagos Efectivo:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $ventas_efectivo_delivery ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- Pagos Tarjeta:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $ventas_tarjeta_delivery ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- Pagos Transferencia Plin:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $ventas_transferencia_delivery ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- Pagos Transferencia Yape:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $ventas_transferencia_delivery_yape ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- Pagos Transferencia Otros:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $ventas_transferencia_delivery_otros ?? 0?></label>
                                            </div>
                                        </div>
                                        <p style="border-bottom: 1px solid red"></p>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- TOTAL EGRESOS :</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $egresos_totales ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row" style="display: none">
                                            <div class="col-md-8">
                                                <label>- Orden de Compras:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $orden_pedido_total ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- Salida caja chica :</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $salida_caja_chica ?? 0?></label>
                                            </div>
                                        </div>
                                        <p style="border-bottom: 1px solid red"></p>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- GASTOS PERSONAL</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $sumar_datos_p ?? 0?></label>
                                            </div>
                                        </div>
                                        <?php
                                        $fecha_ini_caja = $datitos->caja_fecha_apertura;
                                        if ($datitos->caja_fecha_cierre == NULL) {
                                            $fecha_fin_caja = date('Y-m-d H:i:s');
                                        } else {
                                            $fecha_fin_caja = $datitos->caja_fecha_cierre;
                                        }
                                        foreach ($datos_gastos_p as $dg){
                                            $valores = $this->reporte->valores($dg->id_gasto_personal);
                                            ?>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <label>- <?= $dg->nombre?> <?= $dg->apellido?></label>
                                                </div>
                                                <div class="col-md-3">
                                                    <label style="text-align: right;"> S/.<?= $valores->total ?? 0?></label>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <p style="border-bottom: 1px solid red"></p>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- N° VENTAS DELIVERY :</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> <?= $n_ventas_delivery->total ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- N° VENTAS SALON :</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> <?= $n_ventas_salon->total ?? 0?></label>
                                            </div>
                                        </div>
                                        <p style="border-bottom: 1px solid red"></p>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- TOTAL EFECTIVO :</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $diferencia ?? 0?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <h4 style="text-align: center;">DATOS EGRESOS</h4>
                            <?php
                            $egresos = 0;
                            ?>
                            <table class="table table-bordered table-hover" style="border-color: black">
                                <thead>
                                <tr style="background-color: #ebebeb">
                                    <th>Fecha</th>
                                    <th>Concepto</th>
                                    <th>Importe</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($datos){
                                    $fecha_ini_caja = $datitos->caja_fecha_apertura;
                                    if($datitos->caja_fecha_cierre==NULL){
                                        $fecha_fin_caja = date('Y-m-d H:i:s');
                                    }else{
                                        $fecha_fin_caja = $datitos->caja_fecha_cierre;
                                    }
                                    $listar_egresos = $this->reporte->listar_egresos_descripcion($fecha_ini_caja,$fecha_fin_caja);
                                    foreach ($listar_egresos as $le) {
                                        ?>
                                        <tr>
                                            <td><?php echo date('d-m-Y H:i:s',strtotime($le->egreso_fecha_registro));?></td>
                                            <td><?php echo $le->egreso_descripcion;?></td>
                                            <td>S/. <?php echo $le->egreso_monto;?></td>
                                        </tr>
                                        <?php
                                        $egresos = $egresos + $le->egreso_monto;
                                    }
                                    ?>
                                <tr><td colspan="2" style="text-align: right">Total Egresos:</td><td style="background-color: #f9f17f"><b> S/. <?php echo $egresos ?? 0;?></b></td></tr>
                                <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <br>
                    </div>
                    <br>
                    <div class="col-lg-6">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" style="border-color: black">
                                        <thead>
                                        <tr style="background-color: #ebebeb">
                                            <th>PRODUCTO</th>
                                            <th>FECHAS</th>
                                            <th>CANT.</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if($datos){
                                            $fecha_ini_caja = $datitos->caja_fecha_apertura;
                                            if($datitos->caja_fecha_cierre==NULL){
                                                $fecha_fin_caja = date('Y-m-d H:i:s');
                                            }else{
                                                $fecha_fin_caja = $datitos->caja_fecha_cierre;
                                            }
                                            $productos = $this->reporte->reporte_productos_($fecha_ini_caja,$fecha_fin_caja);
                                            foreach ($productos as $p){
                                                ?>
                                                <tr>
                                                    <td><?= $p->producto_nombre?></td>
                                                    <td><?= $fecha_i?> / <?= $fecha_f?></td>
                                                    <td><?= $p->total?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <br>
            </div>
            <div class="col-lg-12  text-center">
                <a id="imprimir_ticket" style="color: white;" class="btn btn-primary mr-5" target="_blank" onclick="ticket_venta('<?= $fecha_i; ?>','<?= $fecha_f?>','<?= $id_caja_numero?>')"><i class="fa fa-print"></i> Ticket</a>
                <a id="imprimir_ticket_productos" style="color: white;" class="btn btn-primary mr-5" target="_blank" onclick="ticket_productos('<?= $fecha_i; ?>','<?= $fecha_f?>','<?= $id_caja_numero?>')"><i class="fa fa-print"></i> Ticket Productos</a>
                <a href="<?= _SERVER_ ; ?>index.php?c=Reporte&a=reporte_general_pdf&fecha_filtro=<?= $_POST['fecha_filtro']?>&fecha_filtro_fin=<?= $_POST['fecha_filtro_fin']?>&id_usuario=<?= $_POST['id_usuario']?>" target="_blank" class="btn btn-primary ml-2"><i class="fa fa-print"></i> Exportar PDF</a>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script>
    function ticket_venta(fecha_i,fecha_f,id_caja_numero){
        var boton = 'imprimir_ticket';

        $.ajax({
            type: 'POST',
            url: urlweb + "api/Reporte/ticket_reporte",
            data: "fecha_i=" + fecha_i + "&fecha_f=" + fecha_f + "&id_caja_numero=" + id_caja_numero,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'imprimiendo...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-print\"></i> Imprimir", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Éxito!...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 400);
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }

    function ticket_productos(fecha_i,fecha_f,id_caja_numero){
        var boton = 'imprimir_ticket_productos';

        $.ajax({
            type: 'POST',
            url: urlweb + "api/Reporte/ticket_productos",
            data: "fecha_i=" + fecha_i + "&fecha_f=" + fecha_f + "&id_caja_numero=" + id_caja_numero,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'imprimiendo...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-print\"></i> Imprimir", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Éxito!...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 400);
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
</script>