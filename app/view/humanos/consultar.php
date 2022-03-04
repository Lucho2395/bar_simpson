<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Recursos Humanos / Consular por Periodo Determinado</h1>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Consulta de Asistencias: </h4>

                            </div>
                        </div>
                        <div class="card-body">
                            <form class="form-row" method="post" action="<?= _SERVER_ . 'RHumanos/consultar';?>">
                                <input type="hidden" value="1" name="enviar">
                                <div class="form-group col-md-4" style="display:none;">
                                    <label for="id_departamento">Departamento</label>
                                    <select class="form-control" name="id_departamento" id="id_departamento" style="height: 44px; font-size: 12px">
                                        <option style="font-size: 10pt;" value="">Seleccionar Departamento</option>
                                        <?php
                                        (isset($departamento))?$id_depa=$departamento->id_departamento:$id_depa=0;
                                        foreach ($departamentos as $d){
                                            ($d->id_departamento==$id_depa)?$sele='selected':$sele='';
                                            ?>
                                            <option style="font-size: 10pt;" value="<?= $d->id_departamento;?>" <?= $sele; ?>><?= $d->departamento_nombre;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="id_sede">Sede</label>
                                    <select class="form-control" <?= $requireed ?> name="id_sede" id="id_sede" style="height: 44px; font-size: 12px;">
                                        <option value="">Seleccionar Centro Laboral</option>
                                        <?php
                                        (isset($sede->id_sede))?$sedeeee=$sede->id_sede:$sedeeee=0;
                                        foreach ($sedes as $s){
                                            ($s->id_sede==$sedeeee)?$sele='selected':$sele='';
                                            ?>
                                            <option value="<?= $s->id_sede;?>" <?= $sele; ?>><?= $s->sede_nombre;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <?php (isset($fecha_elegida))?$fecha_v=$fecha_elegida:$fecha_v=date("Y-m-d"); ?>
                                    <label for="fecha_i">Fecha de Inicio</label>
                                    <input required name="fecha_i" type="date" onchange="validar_fechas()" value="<?= $fecha_v ;?>" class="form-control" id="fecha_i" >
                                </div>
                                <div class="form-group col-md-2">
                                    <?php (isset($fecha_elegida2))?$fecha_v2=$fecha_elegida2:$fecha_v2=date("Y-m-d"); ?>
                                    <label for="fecha_f">Fecha de Término</label>
                                    <input required name="fecha_f" type="date" onchange="validar_fechas()" value="<?= $fecha_v2 ;?>" class="form-control" id="fecha_f" >
                                </div>
                                <div class="form-group col-md-2" style="margin-top: 34px">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            if($datos){
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h5>Sede: <span class='text-uppercase font-weight-bold'><?= (isset($sede->sede_nombre))?$sede->sede_nombre:'TODOS'; ?></span> del Periodo: <span class='text-uppercase font-weight-bold'><?= $fecha_shit[2]."-".$fecha_shit[1]."-".$fecha_shit[0]; ?></span> al: <span class='text-uppercase font-weight-bold'><?= $fecha_shit2[2]."-".$fecha_shit2[1]."-".$fecha_shit2[0]; ?></span>
                                    <a style="display: none" class="btn btn-success" href="<?= _SERVER_ ?>index.php?c=Asistencia&a=excel_consulta_asistencias&id_departamento=&id_sede=<?= $_POST['id_sede']?>&fecha_i=<?= $_POST['fecha_i']?>&fecha_f=<?= $_POST['fecha_f']?>" target="_blank" role="button"><i class="fa fa-file-excel"></i> Excel</a>
                                    <a style="display: none" class="btn btn-primary" href="<?= _SERVER_ ?>index.php?c=Asistencia&a=imprimible_consulta_asistencias&id_departamento=&id_sede=<?= $_POST['id_sede']?>&fecha_i=<?= $_POST['fecha_i']?>&fecha_f=<?= $_POST['fecha_f']?>" target="_blank" role="button"><i class="fa fa-print"></i> Versión Imprimible</a>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-striped" id="dataTable">
                                        <thead>
                                        <tr>
                                            <th style="font-weight: normal">#</th>
                                            <th style="font-weight: normal">Apellidos y Nombres</th>
                                            <th style="font-weight: normal">DNI</th>
                                            <!--<th>Cargo</th>-->
                                            <th style="font-weight: bold;color: black;">Dias Efectivos</th>
                                            <th style="font-weight: bold;color: black;">Asistió</th>
                                            <th style="font-weight: bold;color: #6dff95;">Tardanza</th>
                                            <th style="font-weight: bold;color: red;">Faltó</th>
                                            <th style="font-weight: bold;color: #ff6b6b;">50% Asistió</th>
                                            <!--<th style="font-weight: bold;color: #6dff95;">Asistió + 25%</th>-->
                                            <!--<th style="font-weight: bold;color: limegreen;">Asistió + 50%</th>-->
                                            <!--<th style="font-weight: bold;color: #299344;">Asistió + 100%</th>-->
                                            <!--<th style="font-weight: bold;color: purple;">Asistió + 200%</th>-->
                                            <!--<th style="font-weight: bold;color: yellow;">Descanso Médico</th>-->
                                            <!--<th style="font-weight: bold;color: maroon;">Descanso Semanal</th>-->
                                            <!--<th style="font-weight: bold;color: maroon;">Neutro Covid</th>-->
                                            <!--<th style="font-weight: bold;color: blue;">Vacaciones</th>-->
                                            <!--<th style="font-weight: bold;color: #cd4660;">Licencia por Paternidad</th>-->
                                            <!--<th style="font-weight: bold;color: #03124c;">Licencia con Goce de Haber</th>-->
                                            <!--<th style="font-weight: bold;color: #1c88a7;">Licencia sin Goce de Haber</th>-->
                                            <th style="font-weight: bold;color: #e0632b;">Descanso</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $a = 1;
                                        $dias_efectivos_total=0;
                                        foreach ($persons as $m){
                                            $asistio = 0;
                                            $falto = 0;
                                            $medio_asistio = 0;
                                            $tardanza = 0;
                                            $asistio_medio = 0;
                                            $asistio_doble = 0;
                                            $asistio_triple = 0;
                                            $medico = 0;
                                            $neutro = 0;
                                            $neutro_covid = 0;
                                            $vacaciones = 0;
                                            $lactancia = 0;
                                            $con_goce = 0;
                                            $sin_goce = 0;
                                            $descanso_renum = 0;
                                            foreach ($m->asistencias as $j){
                                                switch($j->asistencia_valor){
                                                    case 1: $asistio++; break;
                                                    case 2: $falto++; break;
                                                    case 3: $medio_asistio++; break;
                                                    case 4: $asistio_medio++; break;
                                                    case 5: $asistio_doble++; break;
                                                    case 8: $asistio_triple++; break;
                                                    case 6: $medico++; break;
                                                    case 7: $neutro++; break;
                                                    case 9: $vacaciones++; break;
                                                    case 10: $tardanza++; break;
                                                    case 11: $neutro_covid++; break;
                                                    case 12: $lactancia++; break;
                                                    case 13: $con_goce++; break;
                                                    case 14: $sin_goce++; break;
                                                    case 15: $descanso_renum++; break;
                                                }
                                            }
                                            $dias_efectivos =
                                                $asistio * 1 +
                                                $tardanza * 1 +
                                                $medio_asistio * 0.5 +
                                                $asistio_medio * 1.5 +
                                                $asistio_doble * 2 +
                                                $medico * 1 +
                                                $neutro * 1 +
                                                $asistio_triple * 3 +
                                                $neutro_covid * 1 +
                                                $lactancia * 1 +
                                                $descanso_renum * 1 +
                                                $con_goce * 1;
                                            $dias_efectivos_total = $dias_efectivos_total + $dias_efectivos;
                                            ?>
                                            <tr>
                                                <td><?php echo $a;?></td>
                                                <td><?php echo $m->data->persona_apellido_paterno;?> <?php echo $m->data->persona_apellido_materno;?>, <?php echo $m->data->persona_nombre;?></td>
                                                <td><?php echo $m->data->persona_dni;?></td>
                                                <!--<td><?php //echo $m->data->cargo_nombre;?></td>-->
                                                <td style="font-size: 12pt;font-weight: bold"><?php echo $dias_efectivos;?></td>
                                                <td><?php echo $asistio;?></td>
                                                <td><?php echo $tardanza;?></td>
                                                <td><?php echo $falto;?></td>
                                                <td><?php echo $medio_asistio;?></td>

                                                <!--<td><?php echo $asistio_medio;?></td>-->
                                                <!-- <td><?php echo $asistio_doble;?></td>-->
                                                <!--<td><?php echo $asistio_triple;?></td>-->
                                                <!--<td><?php echo $medico;?></td>-->
                                                <!--<td><?php echo $neutro;?></td>-->
                                                <!--<td><?php echo $neutro_covid;?></td>-->
                                                <!--<td><?php echo $vacaciones;?></td>-->
                                                <!--<td><?php echo $lactancia;?></td>-->
                                                <!--<td><?php echo $con_goce;?></td>-->
                                                <!--<td><?php echo $sin_goce;?></td>-->
                                                <td><?php echo $descanso_renum;?></td>
                                            </tr>
                                            <?php
                                            $a++;
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3>TOTAL DE DIAS EFECTIVOS: <b><?= $dias_efectivos_total ?></b></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <?php
            }
            ?>


        </div>
    </div>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>humanos.js"></script>
<script type="text/javascript">
    //Llamar así onchange="validar_fechas()"
    function validar_fechas() {
        var inicio = $('#fecha_i').val();
        var fin = $('#fecha_f').val();

        if(inicio !== "" && fin !== ""){
            var f_inicial = new Date(inicio);
            var f_final = new Date(fin);

            if(f_inicial > f_final){
                $('#fecha_f').val(inicio);
            }
        }
    }
</script>
