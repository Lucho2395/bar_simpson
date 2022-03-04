<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
            </div>

            <form method="post" action="<?= _SERVER_ ?>Reporte/reporte_clientes">
                <input type="hidden" id="enviar_fecha" name="enviar_fecha" value="1">
                <div class="row">
                    <div class="col-lg-3">
                        <label for="turno">DNI Cliente:</label>
                        <input type="text" class="form-control" onkeyup="return validar_numeros(this.id)"  id="dni_cliente" name="dni_cliente" value="<?= $dni_cliente;?>">
                    </div>
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
                                            <th>Clientes</th>
                                            <th>Puntos Acumulados</th>
                                            <th>Cantidad de Consumo</th>
                                            <th>Total de Consumos</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $a = 1;
                                        foreach ($clientes as $al){
                                            $puntitos = $this->reporte->puntitos_x_cliente($al->id_cliente);
                                            $puntitos_ = $puntitos->total;
                                            ?>
                                            <tr>
                                                <td><?= $a;?></td>
                                                <td><?= $fecha_hoy;?> / <?= $fecha_fin;?></td>
                                                <td><?= $al->cliente_nombre;?></td>
                                                <td><?= $puntitos_ ?? 0 ?></td>
                                                <td><?= $al->total;?></td>
                                                <td>S/. <?= $al->total_venta;?></td>
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

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>