<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <form method="post" action="<?= _SERVER_ ?>Reporte/ventas_tipo_pago">
                <input type="hidden" id="enviar_fecha" name="enviar_fecha" value="1">
                <div class="row">
                    <div class="col-lg-2 ">
                        <label for="">Tipo Pago</label>
                        <select class="form-control" name="id_tipo_pago" id="id_tipo_pago">
                            <option value="">Seleccione...</option>
                            <?php
                            (isset($tipo_pago_))?$pago=$tipo_pago_->id_tipo_pago:$pago=0;
                            foreach ($tipo_pagos as $e){
                                ($e->id_tipo_pago == $pago)?$sele='selected':$sele='';
                                ?>
                                <option value="<?= $e->id_tipo_pago;?>" <?= $sele; ?>><?= $e->tipo_pago_nombre;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-3 col-xs-6 col-md-6 col-sm-6">
                        <label for="turno">Seleccionar fecha Inicio:</label>
                        <input type="date" class="form-control" id="fecha_hoy" name="fecha_hoy" value="<?php echo $fecha_hoy;?>">
                    </div>
                    <div class="col-lg-3 col-xs-6 col-md-6 col-sm-6">
                        <label for="turno">Seleccionar fecha Fin:</label>
                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?php echo $fecha_fin;?>">
                    </div>
                    <div class="col-lg-3 col-xs-12 col-md-12 col-sm-12" style="text-align: center;">
                        <button style="margin-top: 34px;" class="btn btn-success" ><i class="fa fa-search"></i> Buscar Registro</button>
                    </div>
                </div>
            </form>
            <br>


            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h5>TIPO COMPROBANTE: <span class='text-uppercase font-weight-bold'>
                                    <?php
                                    if(empty($tipo_pago_->tipo_pago_nombre)){
                                        echo 'TODO';
                                    }else{
                                        echo $tipo_pago_->tipo_pago_nombre;
                                    }
                                    ?></span>
                                | FECHA DEL: <span><?= (($fecha_hoy != ""))?date('d-m-Y', strtotime($fecha_hoy)):'--'; ?></span> AL <span><?= (($fecha_fin != ""))?date('d-m-Y', strtotime($fecha_fin)):'--'; ?></span>
                                | Total SOLES: <span id="total_soles"></span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless" id="dataTable2" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha</th>
                                        <th>Tipo Pago</th>
                                        <th>Tipo Comprobante</th>
                                        <th>N° Comprobante</th>
                                        <th>Cliente</th>
                                        <th>Monto Total</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    $total = 0;
                                    $total_soles = 0;
                                    foreach ($tipo_pago as $tp){

                                        $stylee="style= 'text-align: center;'";
                                        if ($tp->anulado_sunat == 1){
                                            $stylee="style= 'text-align: center; text-decoration: line-through'";
                                        }

                                        if($tp->venta_tipo == "03"){
                                            $tipo_comprobante = "BOLETA";
                                            if($tp->anulado_sunat == 0){
                                                $total_soles = round($total_soles + $tp->venta_total, 2);
                                            }
                                        }elseif ($tp->venta_tipo == "01"){
                                            $tipo_comprobante = "FACTURA";
                                            if($tp->anulado_sunat == 0){
                                                $total_soles = round($total_soles + $tp->venta_total, 2);
                                            }
                                        }elseif($tp->venta_tipo == "07"){
                                            $tipo_comprobante = "NOTA DE CRÉDITO";
                                            /*if(($al->anulado_sunat == 0 AND $al->venta_codigo_motivo_nota != "01")){
                                                $total_soles = round($total_soles - $al->venta_total, 2);
                                            }*/
                                        }elseif($tp->venta_tipo == "08"){
                                            $tipo_comprobante = "NOTA DE DÉBITO";
                                            if($tp->anulado_sunat == 0){
                                                $total_soles = round($total_soles + $tp->venta_total, 2);
                                            }
                                        }else{
                                            $tipo_comprobante = "--";
                                        }
                                        ?>
                                        <tr>
                                            <td><?= $a;?></td>
                                            <td><?= $tp->venta_fecha;?></td>
                                            <td><?= $tp->tipo_pago_nombre?></td>
                                            <td><?= $tipo_comprobante?></td>
                                            <td><?= $tp->venta_serie?>-<?= $tp->venta_correlativo?></td>
                                            <td><?= $tp->cliente_nombre?> <?= $tp->cliente_razonsocial?></td>
                                            <td>S/. <?= $tp->venta_total?></td>
                                            <td>
                                                <a target="_blank" type="button" title="Ver detalle" class="btn btn-sm btn-primary" style="color: white" href="<?php echo _SERVER_. 'Ventas/ver_detalle_venta/' . $tp->id_venta;?>" ><i class="fa fa-eye ver_detalle"></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                        $a++;
                                        $total = $total + $tp->venta_total;
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        var total_rs = <?= $total_soles; ?>;
        $("#total_soles").html("<b>"+total_rs+"</b>");
    });
</script>