

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <form method="post" action="<?= _SERVER_ ?>Reporte/ingresos_egresos">
                <input type="hidden" id="enviar_fecha" name="enviar_fecha" value="1">
                <div class="row">
                    <div class="col-lg-3 col-xs-6 col-md-6 col-sm-6">
                        <label for="">Caja</label>
                        <select class="form-control" id="id_caja_numero" name="id_caja_numero">
                            <option value="">Seleccione...</option>
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
                    <div class="col-lg-3 col-xs-6 col-md-6 col-sm-6">
                        <label for="turno">Desde:</label>
                        <input type="date" class="form-control" id="fecha_filtro" name="fecha_filtro" value="<?php echo $fecha_i;?>">
                    </div>
                    <div class="col-lg-3 col-xs-6 col-md-6 col-sm-6">
                        <label for="turno">Hasta:</label>
                        <input type="date" class="form-control" id="fecha_filtro_fin" name="fecha_filtro_fin" value="<?php echo $fecha_f;?>">
                    </div>
                    <div class="col-lg-3 col-sm-12 col-md-12 col-xs-12" style="text-align: center">
                        <button style="margin-top: 30px;" class="btn btn-success" ><i class="fa fa-search"></i> Buscar</button>
                    </div>
                </div>
            </form>
            <br>
            <div class="row">
                <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-striped table-earning" id="" width="100%" cellspacing="0">
                                        <thead class="text-capitalize">
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Caja</th>
                                            <th>Ingreso Caja</th>
                                            <th>Efectivo</th>
                                            <th>Tarjeta</th>
                                            <th>Transferencia</th>
                                            <th>Salida Caja</th>
                                            <th>Orden de Compras</th>
                                            <th>Utilidad</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if($datos){
                                                $caja_total = 0;
                                                $ingresos_total = 0;
                                                $egresos_total = 0;
                                                $diferencia = 0;
                                                for($i=$fecha_filtro;$i<=$fecha_filtro_fin;$i+=86400){

                                                    $caja = $this->reporte->sumar_caja(date("Y-m-d",$i),$id_caja_numero);
                                                    $reporte_ingresos_movi = $this->reporte->listar_datos_ingresos_caja(date("Y-m-d",$i),$id_caja_numero);
                                                    $reporte_ingresos = $this->reporte->listar_datos_ingresos_(date("Y-m-d",$i),$id_caja_numero);
                                                    $reporte_ingresos_tarjeta = $this->reporte->listar_datos_ingresos_tarjeta_(date("Y-m-d",$i),$id_caja_numero);
                                                    $reporte_ingresos_transferencia = $this->reporte->listar_datos_ingresos_transferencia_(date("Y-m-d",$i),$id_caja_numero);
                                                    $reporte_orden_pedido = $this->reporte->listar_monto_op(date("Y-m-d",$i),$id_caja_numero);
                                                    $reporte_egresos_movi = $this->reporte->listar_datos_egresos(date("Y-m-d",$i),$id_caja_numero);

                                                    //RESULTADO DE LAS FUNCIONES PARA TODO
                                                    $caja = $caja->total;
                                                    $reporte_ingresos_movi = $reporte_ingresos_movi->total;
                                                    $ingresos = $reporte_ingresos->total;
                                                    $reporte_ingresos_tarjeta = $reporte_ingresos_tarjeta->total;
                                                    $reporte_ingresos_transferencia = $reporte_ingresos_transferencia->total;
                                                    $reporte_orden_pedido = $reporte_orden_pedido->total;
                                                    $reporte_egresos_movi = $reporte_egresos_movi->total;
                                                    $egresos = $egresos + $reporte_egresos_movi + $reporte_orden_pedido;

                                                    $sumar_caja_ingresos = $caja + $reporte_ingresos_movi;
                                                    $ingresos_efectivo = $ingresos;
                                                    $diferencia = $diferencia + $caja + $reporte_ingresos_movi + $ingresos - $reporte_egresos_movi - $reporte_orden_pedido;

                                                    $ingresos_total = $ingresos_total + $caja+ $reporte_ingresos_movi + $ingresos;
                                                    $egresos_total = $reporte_egresos_movi + $reporte_orden_pedido;
                                                    $fecha = date("d-m-Y",$i);
                                                    ?>
                                                    <tr>
                                                        <td><?= $fecha;?></td>
                                                        <td><?= $caja ?? 0?></td>
                                                        <td><?= $reporte_ingresos_movi ?? 0?></td>
                                                        <td><?= $ingresos ?? 0;?></td>
                                                        <td><?= $reporte_ingresos_tarjeta ?? 0;?></td>
                                                        <td><?= $reporte_ingresos_transferencia ?? 0;?></td>
                                                        <td><?= $reporte_egresos_movi ?? 0;?></td>
                                                        <td><?= $reporte_orden_pedido ?? 0;?></td>
                                                        <?php
                                                        $estilo = "";
                                                        if($diferencia < 0){
                                                            $estilo = "style=\"background-color: lightpink\"";
                                                        }
                                                        ?>
                                                        <td <?= $estilo;?>><?= $diferencia;?></td>
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
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <p>Ingresos: <?= $ingresos_total; ?></p>
                                <p style="border-bottom: 1px solid red">Egresos: <?= $egresos_total; ?></p>
                                <p>Utilidad: <?= $ingresos_total - $egresos_total; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>