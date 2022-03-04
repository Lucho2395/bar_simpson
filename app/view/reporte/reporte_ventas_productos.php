


<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <form method="post" action="<?= _SERVER_ ?>Reporte/reporte_ventas_productos">
                <input type="hidden" id="enviar_fecha" name="enviar_fecha" value="1">
                <div class="row">
                    <div class="col-lg-3 col-xs-6 col-md-6 col-sm-6">
                        <label for="">N° de Caja</label>
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
                    <div class="col-lg-3">
                        <label for="turno">Desde:</label>
                        <input type="date" class="form-control" id="fecha_filtro" name="fecha_filtro" step="1" value="<?php echo $fecha_filtro;?>">
                    </div>
                    <div class="col-lg-3">
                        <label for="turno">Hasta:</label>
                        <input type="date" class="form-control" id="fecha_filtro_fin" name="fecha_filtro_fin" value="<?php echo $fecha_filtro_fin;?>">
                    </div>
                    <div class="col-lg-3">
                        <button style="margin-top: 35px;" class="btn btn-success" ><i class="fa fa-search"></i> Buscar Registro</button>
                    </div>
                </div>
            </form>
            <br>

            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" style="border-color: black">
                                <thead>
                                <tr style="background-color: #ebebeb">
                                    <th>PRODUCTO</th>
                                    <th>FECHAS</th>
                                    <th>CANTIDAD VENDIDA</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $ingresos_productos = 0;
                                $sumasa = 0;
                                $nuevo_valor_inicial = 0;
                                foreach ($productos as $p){
                                    ?>
                                    <tr>
                                        <td><?= $p->producto_nombre?></td>
                                        <td><?= $fecha_filtro?> / <?= $fecha_filtro_fin?></td>
                                        <td><?= $p->total?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2"></div>
            </div>

            <div class="row">
                <div class="col-lg-12" style="text-align: center">
                    <a href="<?= _SERVER_ ; ?>index.php?c=Reporte&a=reporte_ventas_productos_pdf&fecha_filtro=<?= $_POST['fecha_filtro']?>&fecha_filtro_fin=<?= $_POST['fecha_filtro_fin']?>&id_caja_numero=<?= $_POST['id_caja_numero']?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Imprimir</a>
                </div>
            </div>

        </div>
    </div>
</div>