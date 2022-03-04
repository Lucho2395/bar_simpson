<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
            </div>


            <form method="post" action="<?= _SERVER_ ?>Reporte/reporte_proveedores">
                <input type="hidden" id="enviar_fecha" name="enviar_fecha" value="1">
                <div class="row">
                    <div class="col-lg-3">
                        <label for="turno">Desde:</label>
                        <input type="date" class="form-control" id="fecha_hoy" name="fecha_hoy" value="<?php echo $fecha_hoy;?>">
                    </div>
                    <div class="col-lg-3">
                        <label for="turno">Hasta:</label>
                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?php echo $fecha_fin;?>">
                    </div>
                    <div class="col-lg-3">
                        <button style="margin-top: 34px;" class="btn btn-success" ><i class="fa fa-search"></i> Buscar Registro</button>
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
                                        <th>#</th>
                                        <th>Fecha</th>
                                        <th>Proveedor</th>
                                        <th>Solicitante</th>
                                        <th>Descripción</th>
                                        <th>Insumos</th>
                                        <th>Factura</th>
                                        <th>Tipo Pago</th>
                                        <th>Total de la Compra</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($proveedores as $p){

                                        ?>
                                        <tr>
                                            <td><?= $a;?></td>
                                            <td><?= $p->orden_compra_fecha_recibida;?></td>
                                            <td><?= $p->proveedor_nombre?></td>
                                            <td><?= $p->persona_nombre?></td>
                                            <td><?= $p->orden_compra_titulo?></td>
                                            <td>
                                                <?php
                                                $insumos = $this->reporte->listar_insumos($p->id_orden_compra);
                                                if(count($insumos) > 0){
                                                    foreach ($insumos as $i) {
                                                        ?>
                                                        - <a><?= $i->recurso_nombre;?></a>
                                                        <br>
                                                <?php
                                                    }
                                                }else{
                                                    echo "--";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="<?= _SERVER_ . $p->orden_compra_doc_adjuntado;?>" target="_blank">Ver Factura</a>
                                            </td>
                                            <td><?= $p->tipo_pago_nombre?></td>
                                            <?php
                                            $total = $this->reporte->calcular_total($p->id_orden_compra);
                                            ?>
                                            <td>
                                               S/. <?= $total->total;?>
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