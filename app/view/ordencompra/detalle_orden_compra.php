<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>

            </div>
            <!-- /.row (main row) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div class="col-md-3">
                                    <img alt="logo" src="<?= _SERVER_;?>media/logo/logo_conchita.png" width="100px">
                                </div>
                                <div class="col-md-5">
                                    <h3 style="text-align: center"><?= $datos->orden_compra_titulo?></h3>
                                </div>
                                <div class="col-md-5">
                                    <?php
                                    if($datos->orden_compra_estado==1){
                                        ?>
                                        <h1 style="text-align: center">OC <?= $datos->orden_compra_numero; ?></h1>
                                        <?php
                                        if($op->op_activo==1){
                                            echo "<h2 style='color:red;text-align: center'>ANULADA</h2>";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php
                                if($datos->orden_compra_estado==0){
                                    ?>
                                    <h5 class="card-title">Detalle de Orden de Compra: Solicitante: <b><?= $datos->persona_nombre." ".$datos->persona_apellido_paterno." ".$datos->persona_apellido_materno; ?></b> | Fecha de Solicitud: <b><?= date("d-m-Y",strtotime($datos->orden_compra_fecha)); ?></b>
                                        <br> | Descripción de la Solicitud: <?= $datos->orden_compra_titulo?> | Total: <?= $listar_total->total?></h5>
                                    <?php
                                }else{
                                    ?>
                                    <h3 class="card-title">Solicitante: <b><?= $datos->persona_nombre." ".$datos->persona_apellido_paterno." ".$datos->persona_apellido_materno; ?></b> |  <b>Sucursal: <?= $datos->sucursal_nombre;?></b> | <b>N° de Comprobante: <?= $datos->orden_compra_numero_doc;?></b>
                                        <br> Fecha de Aprobación: <b><?= date("d-m-Y",strtotime($datos->orden_compra_fecha_aprob)); ?></b> | <b>Proveedor: <?= $datos->proveedor_nombre;?></b> | <b>Ver Comprobante: - <a href="<?= _SERVER_ . $datos->orden_compra_doc_adjuntado?>"><?= $datos->orden_compra_tipo_doc;?></a> </b>
                                        <br> Total: <label style="color: red"><?= $listar_total->total?></h3>
                                    <?php
                                }
                                ?>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table" id="">
                                        <thead>
                                        <tr style="font-weight: bold;">
                                            <td>ITEM</td>
                                        <!--<td>NUMERO</td>-->
                                            <td>RECURSO</td>
                                        <!--<td>PROVEEDOR</td>-->
                                            <td>CANTIDAD SOLICITADA</td>
                                            <td>PRECIO COMPRA</td>
                                            <td>OBSERVACION</td>
                                            <!--<td>COMPROBANTE</td>-->
                                            <td>TOTAL</td>
                                        </tr>
                                        </thead>
                                        <?php
                                        $detalle_orden = $this->ordencompra->listar_detalle($datos->id_orden_compra);
                                        $conteo=1;
                                        $conteo_NO=0;
                                        foreach ($detalle_orden as $ds){
                                            if($ds->orden_compra_numero == 0){
                                                $numero = "--";
                                            }else{
                                                $numero = "$ds->orden_compra_numero";
                                            }
                                            if($ds->orden_compra_observacion){
                                                $observacion = $ds->orden_compra_observacion;
                                            }else{
                                                $observacion = "------";
                                            }
                                            ?>
                                            <tr>
                                                <td><?= $conteo; ?></td>
                                                <!--<td><?= $numero; ?></td>-->
                                                <td><?= $ds->recurso_nombre; ?></td>
                                                <!--<td><?= $ds->proveedor_nombre; ?></td>-->
                                                <td><?= $ds->detalle_compra_cantidad; ?></td>
                                                <td><?= $ds->detalle_compra_precio_compra; ?></td>
                                                <td><?= $observacion;?></td>
                                                <!--<td>
                                                    <?php
                                                    $docs = $this->ordencompra->listar_detalle_($ds->id_orden_compra);
                                                        if(!empty($docs->orden_compra_doc_adjuntado)){
                                                            ?>
                                                            - <a href="<?= _SERVER_ . $docs->orden_compra_doc_adjuntado?>" target="_blank"><?= $docs->orden_compra_tipo_doc;?></a>
                                                            <?php
                                                    }else{
                                                            echo "------";
                                                    }
                                                    ?>
                                                </td>-->
                                                <td><?= $ds->detalle_compra_total_pedido ?? 0?></td>
                                            </tr>
                                            <?php
                                            $conteo++;
                                        }
                                        ?>
                                    </table>
                                </div>
                                <div class="col-md-12" style="text-align: right">
                                    <?php
                                    if($datos->orden_compra_estado == 0){
                                        ?>
                                        <button onclick="aprobar_orden(1)" class='btn btn-primary'><i class='fa fa-check'></i> Aprobar</button>
                                        <a href="<?= _SERVER_?>Ordencompra/orden_editar/<?= $datos->id_orden_compra;?>" class="btn btn-success"><i class='fa fa-edit'></i> Editar</a>
                                        <a class="btn btn-secondary" href="javascript:history.back()" role="button"><i class="fa fa-backward"></i> Regresar</a>
                                        <?php
                                    }else{
                                        ?>
                                        <a class="btn btn-secondary" href="javascript:history.back()" role="button"><i class="fa fa-backward"></i> Regresar</a>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script>
    function aprobar_orden(ind) {
        var id_orden_compra = <?= $datos->id_orden_compra;?>;
        var cadena= 'id_orden_compra=' + id_orden_compra + "&ind=" + ind;
        $.ajax({
            type:"POST",
            url: urlweb + "api/Ordencompra/aprobar_orden",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                $(".btn").attr("disabled", true);
            },
            success:function (r) {
                $(".btn").attr("disabled", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Aprobado con Exito!', 'success');
                        setTimeout(function () {
                            location.href = urlweb +  'Ordencompra/orden_aprobada';
                        }, 1000);
                        break;
                    case 2:
                        respuesta("Fallo la aprobación",'error');
                        break;
                    default:
                        respuesta("ERROR DESCONOCIDO", 'error');
                }
            }
        });
    }
</script>