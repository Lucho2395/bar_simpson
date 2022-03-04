


<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <form method="post" action="<?= _SERVER_ ?>Pedido/pedidos_eliminados">
                <input type="hidden" id="enviar_fecha" name="enviar_fecha" value="1">
                <div class="row">
                    <div class="col-lg-3 col-xs-3 col-md-3 col-sm-3">
                        <label for="turno">Desde:</label>
                        <input type="date" class="form-control" id="fecha_filtro" name="fecha_filtro" step="1" value="<?php echo $fecha_i;?>">
                    </div>
                    <div class="col-lg-3 col-xs-3 col-md-3 col-sm-3">
                        <label for="turno">Hasta:</label>
                        <input type="date" class="form-control" id="fecha_filtro_fin" name="fecha_filtro_fin" value="<?php echo $fecha_f;?>">
                    </div>
                    <div class="col-lg-3 col-xs-3 col-md-3 col-sm-3">
                        <button style="margin-top: 35px;" class="btn btn-success" ><i class="fa fa-search"></i> Buscar</button>
                    </div>
                </div>
            </form>
            <br>

            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                            <thead class="text-capitalize">
                            <tr>
                                <th>Mesa</th>
                                <th>Producto</th>
                                <th>Motivo Eliminación</th>
                                <th>Fecha Eliminación</th>
                                <th>Hora Eliminación</th>
                                <th>Precio Unitario</th>
                                <th style="width: 65px;">Cantidad</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($pedidos_eliminados as $p){
                                $estilo = "";
                                if($p->comanda_detalle_estado_venta == "0"){
                                    $estilo = "style=\"background-color: #ea817c\"";
                                }
                                ?>
                                <tr <?= $estilo;?>>
                                    <td><?= $p->mesa_nombre?></td>
                                    <td><?= $p->producto_nombre?></td>
                                    <td><?= $p->comanda_detalle_eliminacion?></td>
                                    <td><?= date('d-m-Y',strtotime($p->comanda_detalle_fecha_eliminacion))?></td>
                                    <td><?= date('H:i:s',strtotime($p->comanda_detalle_fecha_eliminacion))?></td>
                                    <td><?= $p->comanda_detalle_precio?></td>
                                    <td><?= $p->comanda_detalle_cantidad?></td>

                                </tr>
                                <?php
                                $a++;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-8"></div>
                        <div class="col-lg-3 col-sm-3 col-md-3" style="text-align: right">
                            <a class="btn btn-secondary" href="javascript:history.back()" role="button"><i class="fa fa-backward"></i> Regresar</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>