<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form method="post" action="<?= _SERVER_ . 'Ordencompra/ver_facturas';?>">
                                <input type="hidden" id="enviar_fecha" name="enviar_fecha" value="1">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <label for="">Proveedor / RUC</label>
                                        <input class="form-control" name="parametro" type="text" value="<?= $parametro;?>" id="parametro" placeholder="Ingrese dato...">
                                    </div>
                                    <div class="col-lg-2 col-xs-6 col-md-6 col-sm-6">
                                        <label for="turno">Desde:</label>
                                        <input type="date" class="form-control" id="fecha_hoy" name="fecha_hoy" value="<?php echo $fecha_hoy;?>">
                                    </div>
                                    <div class="col-lg-2 col-xs-6 col-md-6 col-sm-6">
                                        <label for="turno">Hasta:</label>
                                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?php echo $fecha_fin;?>">
                                    </div>
                                    <div class="col-lg-2" >
                                        <button style="margin-top: 34px;" type="submit" class="btn btn-success">Buscar Ahora</button>
                                    </div>
                                </div>
                            </form>
                            <br>
                            <?php
                            if($datos){
                            ?>
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-earning" id="dataTable2" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha de Registro</th>
                                        <th>Proveedor</th>
                                        <th>Numero Comprobante</th>
                                        <!--<th>Recurso</th>-->
                                        <th>Comprobante</th>
                                        <th>Numero Orden</th>
                                        <th>Total</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($facturas as $f){
                                        $sumar_total = $this->ordencompra->sumar_total_oc($f->id_orden_compra);
                                        ?>

                                        <tr>
                                            <td><?= $a;?></td>
                                            <td><?= $f->orden_compra_fecha?></td>
                                            <td><?= $f->proveedor_nombre; ?></td>
                                            <td><?= $f->orden_compra_numero_doc?></td>
                                        
                                           <!-- <td>
                                                <?php
                                                $jalar_insumos = $this->ordencompra->insumos_en_oc($f->id_orden_compra);
                                                if(count($jalar_insumos)>0){
                                                    foreach ($jalar_insumos as $jp){
                                                        ?>
                                                        - <?= $jp->recurso_nombre;?> <?= $jp->detalle_compra_cantidad;?>
                                                        <br>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </td>-->
                                           
                                            <td>
                                                <?php
                                                $docs = $this->ordencompra->listar_detalle_($f->id_orden_compra);
                                                if(!empty($docs->orden_compra_doc_adjuntado)){
                                                    ?>
                                                    - <a href="<?= _SERVER_ . $docs->orden_compra_doc_adjuntado?>" target="_blank"><?= $docs->orden_compra_tipo_doc;?></a>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td><?= $f->orden_compra_numero?></td>
                                            <td><?= $sumar_total->total ?? 0?></td>
                                            <td>
                                                <a data-toggle="tooltip" title="Ver detalles" href="<?= _SERVER_ ?>Ordencompra/detalle_orden_compra/<?= $f->id_orden_compra; ?>" type="button" class="text-dark" ><i class="fa fa-eye ver_detalle"></i></a>
                                                <a onclick="preguntar('¿Está seguro que desea eliminar esta orden de compra?','eliminar_orden_cr','Si','No',<?= $f->id_orden_compra;?>)" id="btn_deshabilitar" data-toggle="tooltip" title='Eliminar'><i class="fa fa-times text-danger eliminar margen"></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                        $a++;
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
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

<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>orden_compra.js"></script>

<script>
        function eliminar_orden_cr(id_orden_compra){
            var cadena = "id_orden_compra=" + id_orden_compra;
            $.ajax({
                type: "POST",
                url: urlweb + "api/Ordencompra/eliminar_orden_cr",
                data: cadena,
                dataType: 'json',
                beforeSend: function () {
                    $("#aprobar").html("Cargando...");
                },
                success: function (r) {
                    $("#aprobar").html("Eliminar");
                    switch (r.result.code) {
                        case 1:
                            respuesta("¡Eliminado con Exito!",'success');
                            setTimeout(function () {
                                location.reload();
                            }, 500);
                            break;
                        case 2:
                            respuesta('Error al eliminar registro', 'error');
                            break;
                        default:
                            respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                            break;
                    }
                }
            });
        }
</script>