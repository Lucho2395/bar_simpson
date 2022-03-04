<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <form method="post" action="<?= _SERVER_ ?>Reporte/tiempo_promedio_atencion">
                <input type="hidden" id="enviar_fecha" name="enviar_fecha" value="1">
                <div class="row">
                    <div class="col-lg-3 col-lg-6 col-xs-6 col-md-6 col-sm-6">
                        <label for="turno">Desde:</label>
                        <input type="date" class="form-control" id="fecha_filtro" name="fecha_filtro" value="<?php echo $fecha_filtro;?>">
                    </div>
                    <div class="col-lg-3 col-lg-6 col-xs-6 col-md-6 col-sm-6">
                        <label for="turno">Hasta:</label>
                        <input type="date" class="form-control" id="fecha_filtro_fin" name="fecha_filtro_fin" value="<?php echo $fecha_filtro_fin;?>">
                    </div>
                    <div class="col-lg-3 col-lg-12 col-xs-12 col-md-12 col-sm-12" style="text-align: center;">
                        <button style="margin-top: 34px;" class="btn btn-success" ><i class="fa fa-search"></i> Buscar Registro</button>
                    </div>
                </div>
            </form>
            <br>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row">
                                    <?php
                                    $a = 1;
                                    foreach ($grupos as $tp){
                                        $comandas = $this->reporte->datos_comandas($fecha_filtro,$fecha_filtro_fin);
                                        $suma_tiempo = 0;
                                        $suma_cantidad = 0;
                                        $dividir_cantidad = 0;
                                        $promedio_comandas = 0;
                                        foreach ($comandas as $c){
                                            $detalle_comandas = $this->reporte->datos_comanda_detalles($c->id_comanda, $tp->id_grupo);
                                            foreach ($detalle_comandas as $dc){
                                                $tiempo_inicio = $dc->comanda_detalle_fecha_registro;
                                                $tiempo_final = $dc->comanda_detalle_hora_entrega;
                                                $intervalo = $this->reporte->restar_horas($tiempo_inicio,$tiempo_final);
                                                $suma_tiempo = $suma_tiempo + $intervalo;
                                                $suma_cantidad++;
                                            }
                                        }
                                        $dividir_cantidad = $suma_tiempo / $suma_cantidad;
                                        $horas =  gmdate("H", $dividir_cantidad);
                                        $minutos =  gmdate("i", $dividir_cantidad);
                                        $segundos =  gmdate("s", $dividir_cantidad);
                                        if($horas!=0){
                                            $dividir_cantidad_convertida = $horas." h ".$minutos." min ". $segundos." s";
                                        }else{
                                            $dividir_cantidad_convertida = $minutos." min ". $segundos." s";
                                        }
                                        ?>
                                        <div class="col-md-4" style="border-right: 1px solid black">
                                            <h2 class="text-center"><?= $tp->grupo_nombre?></h2>
                                            <div class="row">
                                            <div class="col-md-6 text-center">
                                                <p>Atenciones</p>
                                                <p class="text-center"><?= $suma_cantidad?></p>
                                            </div>
                                            <div class="col-md-6 text-center">
                                                <p>Tiempo promedio</p>
                                                <p class="text-center"><?= $dividir_cantidad_convertida?></p>
                                            </div>
                                            </div>
                                        </div>
                                        <?php
                                        $a++;
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