<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <div class="row">
                <div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h2><b>Pedidos / <?= $dato->grupo_nombre;?></b></h2></div>
                <div class="col-lg-12" style="text-align: center; padding-bottom:5px; ">Ultima Actualización : <?= date('H:i:s d-m-Y')?></div>
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha / Hora</th>
                                        <th>Mesa</th>
                                        <th>Producto</th>
                                        <th>N° Pedido</th>
                                        <th>Precio Unitario</th>
                                        <th>Cantidad</th>
                                        <th>Observacion</th>
                                        <th>Total</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($listar_pedidos as $lc){
                                        $estilo = "";
                                        if($lc->comanda_detalle_estado == "0"){
                                            $estilo = "style=\"background-color: #ea817c\"";
                                        }else if($lc->comanda_detalle_estado == "1"){
                                            $estilo = "style=\"background-color: #f3ff33\"";
                                        }else if ($lc->comanda_detalle_estado == "2"){
                                            $estilo = "style=\"background-color: #82e591\"";
                                        }
                                        ?>
                                        <tr <?= $estilo;?>>
                                            <td><?= $a;?></td>
                                            <td><?= $lc->comanda_detalle_fecha_registro;?></td>
                                            <td><?= $lc->mesa_nombre;?></td>
                                            <td><?= $lc->producto_nombre;?></td>
                                            <td><?= $lc->comanda_correlativo;?></td>
                                            <td><?= $lc->comanda_detalle_precio;?></td>
                                            <td><?= $lc->comanda_detalle_cantidad;?></td>
                                            <td><?= $lc->comanda_detalle_observacion;?></td>
                                            <td><?= $lc->comanda_detalle_total;?></td>
                                            <td>
                                                <?php
                                                if ($lc->comanda_detalle_estado == 0) {
                                                ?>
                                                <a class="btn btn-primary" onclick="preguntar('¿Esta seguro que quiere atender este pedido?','atender','Si','No',<?= $lc->id_comanda_detalle;?>,1)"  title='Atender'><i class='fa fa-eye text-white editar margen'></i></a>
                                                    <?php
                                                }else if($lc->comanda_detalle_estado == 1){
                                                    ?>
                                                    <a class="btn btn-warning" onclick="preguntar('¿El pedido ya esta listo para entrega?','despachar','Si','No',<?= $lc->id_comanda_detalle;?>,2)" data-toggle="tooltip" title='En proceso de atención'><i class='fa fa-exclamation-triangle text-red eliminar margen'></i></a>

                                                    <?php
                                                }else if($lc->comanda_detalle_estado == 2){
                                                    ?>
                                                <a class="btn btn-success" data-toggle="tooltip" title='Pedido Entregado'><i class='fa fa-check text-white eliminar margen'></i></a>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $a++;
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


<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>pedido.js"></script>

<script>
    function actualizar(){
        location.reload();
    }
    //Función para actualizar cada 60 segundos(60000 milisegundos)
    setInterval(actualizar, 60000);
</script>