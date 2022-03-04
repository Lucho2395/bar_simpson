<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Recursos Humanos / Consular por persona</h1>
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
                            <form class="form-row" method="post" action="<?= _SERVER_ . 'RHumanos/por_persona';?>">
                                <input type="hidden" id="fecha_v">
                                <input type="hidden" value="1" name="enviar">
                                <div class="form-group col-md-4">
                                    <label for="id_persona">Persona</label>
                                    <select class="form-control" name="id_persona" id="id_persona" style="height: 44px; font-size: 12px;" required>
                                        <option style="font-size: 10pt;" value="">Seleccionar Persona</option>
                                        <?php
                                        (isset($data))?$id_pers=$data->id_persona:$id_pers=0;
                                        foreach ($persons as $d){
                                            ($d->id_persona == $id_pers) ? $sele = 'selected' : $sele = '';
                                            ?>
                                            <option style="font-size: 10pt;" value="<?= $d->id_persona;?>" <?= $sele; ?>><?= $d->persona_apellido_paterno." ".$d->persona_apellido_materno." ".$d->persona_nombre;?></option>
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
                                    <input required name="fecha_f" onchange="validar_fechas()" type="date" value="<?= $fecha_v2 ;?>" class="form-control" id="fecha_f" >
                                </div>
                                <div class="form-group col-md-2" style="text-align: right">
                                    <br><button type="submit" style="margin-top: 7px; width: 100%;" class="btn btn-success"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                                <div class="form-group col-md-2" style="text-align: right">
                                    <br><a class="btn btn-secondary" style="margin-top: 7px; width: 100%;" href="<?= _SERVER_ . 'RHumanos/opciones';?>" role="button"><i class="fa fa-backward"></i> Regresar</a>
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
                                <h5>Persona: <span class='text-uppercase font-weight-bold'><?= (isset($data->persona_apellido_paterno))?$data->persona_apellido_paterno." ".$data->persona_apellido_materno." ".$data->persona_nombre:'TODOS'; ?></span> del Periodo: <span class='text-uppercase font-weight-bold'><?= $fecha_shit[2]."-".$fecha_shit[1]."-".$fecha_shit[0]; ?></span> al: <span class='text-uppercase font-weight-bold'><?= $fecha_shit2[2]."-".$fecha_shit2[1]."-".$fecha_shit2[0]; ?></span>
                                    <?php
                                    if(isset($_POST['id_persona'])){
                                        ?>
                                        <a style="display:none;" class="btn btn-success" href="<?= _SERVER_ ?>index.php?c=Asistencia&a=excel_por_persona_asistencias&id_persona=<?= $_POST['id_persona']?>&fecha_i=<?= $_POST['fecha_i']?>&fecha_f=<?= $_POST['fecha_f']?>" target="_blank" role="button"><i class="fa fa-file-excel"></i> Excel</a>
                                        <a style="display:none;" class="btn btn-primary" href="<?= _SERVER_ ?>index.php?c=Asistencia&a=imprimible_por_persona_asistencias&id_persona=<?= $_POST['id_persona']?>&fecha_i=<?= $_POST['fecha_i']?>&fecha_f=<?= $_POST['fecha_f']?>" target="_blank" role="button"><i class="fa fa-print"></i> Versión Imprimible</a>
                                        <?php
                                    }
                                    ?>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-striped table-earning" id="dataTable">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Apellidos y Nombres</th>
                                            <th>DNI</th>
                                            <th>Puesto</th>
                                            <th>Fecha</th>
                                            <th>Hora Entrada</th>
                                            <th>Hora Salida</th>
                                            <th>Asistencia</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $a = 1;
                                        //Creamos las variables para listar asistencia
                                        $asistio = 0;
                                        $falto = 0;
                                        $medio_asistio = 0;
                                        $tardanza = 0;
                                        $asistio_medio = 0;
                                        $asistio_doble = 0;
                                        $asistio_triple = 0;
                                        $medico = 0;
                                        $neutro = 0;
                                        $vacaciones = 0;
                                        $neutro_covid = 0;
                                        $lactancia = 0;
                                        $con_goce = 0;
                                        $sin_goce = 0;
                                        $descanso_renum = 0;

                                        $dias_del_periodo = 0;
                                        foreach ($asistencias as $m){
                                            $jalar_horas = $this->humanos->jalar_horas($m->id_persona_turno);
                                            $dias_del_periodo++;
                                            switch($m->asistencia_valor){
                                                //Asistió
                                                case 1: $asistio++; break;
                                                //Falto
                                                case 2: $falto++; break;
                                                //50% Asistió
                                                case 3: $medio_asistio++; break;
                                                //Asistió + 50%
                                                case 4: $asistio_medio++; break;
                                                //Asistió + 100%
                                                case 5: $asistio_doble++; break;
                                                //Descanso Medico
                                                case 6: $medico++; break;
                                                //Neutro
                                                case 7: $neutro++; break;
                                                //Asistió + 200%
                                                case 8: $asistio_triple++; break;
                                                //Vacaciones
                                                case 9: $vacaciones++; break;
                                                //Asistió + 25%
                                                case 10: $tardanza++;break;
                                                //Neutro Covid
                                                case 11: $neutro_covid++;break;
                                                //Lactancia
                                                case 12: $lactancia++; break;
                                                //Licencia con Goce de Haber
                                                case 13: $con_goce++; break;
                                                //Licencia sin Goce de Haber
                                                case 14: $sin_goce++; break;
                                                //Descanso Renumerado
                                                case 15: $descanso_renum++; break;
                                            }

                                            switch ($m->asistencia_valor){
                                                case '1': $color_select= 'background: white;'; break;
                                                case '2': $color_select= 'background:red;'; break;
                                                case '3': $color_select= 'background: #ff6b6b;'; break;
                                                case '4': $color_select= 'background: limegreen'; break;
                                                case '5': $color_select= 'background: #299344'; break;
                                                case '6': $color_select ='background: yellow'; break;
                                                case '7': $color_select= 'background: maroon'; break;
                                                case '8': $color_select= 'background: purple'; break;
                                                case '9': $color_select= 'background: blue'; break;
                                                case '10': $color_select= 'background: #6dff95'; break;
                                                case '11': $color_select= 'background: maroon'; break;
                                                case '12': $color_select= 'background: #cd4660'; break;
                                                case '13': $color_select= 'background: #03124c'; break;
                                                case '14': $color_select= 'background: #1c88a7'; break;
                                                case '15': $color_select= 'background: #e0632b'; break;
                                            }
                                            $clase_select='readonly_select_asistencia';
                                            ($m->asistencia_estado==0)? $span_bolita="<div data-toggle='tooltip' style='background: red; border-radius: 50%;width: 10px;height: 10px;' title='Pendiente de Aprobación'></div>":$span_bolita="<div style='background: green; border-radius: 50%;width: 10px;height: 10px;' title='Aprobado' data-toggle='tooltip'></div>";;
                                            ?>
                                            <tr>
                                                <td><?php echo $span_bolita." ".$a;?></td>
                                                <td><?php echo $data->persona_apellido_paterno." ". $data->persona_apellido_materno." ". $data->persona_nombre;?></td>
                                                <td><?php echo $data->persona_dni;?></td>
                                                <td><?php echo $m->cargo->cargo_nombre;?></td>
                                                <td id="celda_<?= $m->id_asistencia; ?>"><?php echo $m->asistencia_fecha;?></td>
                                                <td><?= $m->asistencia_hora?></td>
                                                <td><?= $m->asistencia_hora_salida?></td>
                                                <td id="tr_<?= $m->id_asistencia; ?>" style="<?= $color_select; ?>">
                                                    <select style="font-size: 10pt;font-weight: bold;" onchange="cambiar_color_select(<?= $m->id_asistencia ?>)" class='form-control <?= $clase_select; ?>'  id='select_<?= $m->id_asistencia ?>'>
                                                            <option value='1' <?= ($m->asistencia_valor==1)?'selected':''; ?> style="color:black;font-weight: bold;">ASISTIO</option>
                                                            <option value='10' <?= ($m->asistencia_valor==10)?'selected':''; ?> style="color: #6dff95;font-weight: bold;">TARDANZA</option>
                                                            <option value='2' <?= ($m->asistencia_valor==2)?'selected':''; ?> style="color:red;font-weight: bold;">FALTO</option>
                                                            <option value='3' <?= ($m->asistencia_valor==3)?'selected':''; ?> style="color: #ff6b6b;font-weight: bold;">50% ASISTIO</option>
                                                            <!--<option value='4' <?= ($m->asistencia_valor==4)?'selected':''; ?> style="color: limegreen;font-weight: bold;">ASISTIO + 50%</option>-->
                                                            <!--<option value='5' <?= ($m->asistencia_valor==5)?'selected':''; ?> style="color: #299344;font-weight: bold;">ASISTIO + 100%</option>-->
                                                            <!--<option value='8' <?= ($m->asistencia_valor==8)?'selected':''; ?> style="color: purple;font-weight: bold;">ASISTIO + 200%</option>-->
                                                            <!--<option value='7' <?= ($m->asistencia_valor==7)?'selected':''; ?> style="color: maroon;font-weight: bold;">DESCANSO SEMANAL</option>-->
                                                            <option value='15' <?= ($m->asistencia_valor==15) ? 'selected' : ''; ?> style="color: #e0632b;font-weight: bold;">DESCANSO</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <?php
                                            $a++;
                                        }

                                        $dias_efectivos_periodo =
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
                                        ?>
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-md-6"><input type="hidden" id="id_pers" value="<?= $data->id_persona; ?>"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <?php
            }
            ?>

            <?php
            if($datos){
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h2>Resumen de Asistencias</h2>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-striped" id="dataTable" style="background: white !important; ">
                                        <thead>
                                        <tr>
                                            <th style="font-weight: bold;color: black;">Dias Efectivos</th>
                                            <th style="font-weight: bold;color: black;">Asistió</th>
                                            <th style="font-weight: bold;color: #6dff95;">Tardanza</th>
                                            <th style="font-weight: bold;color: red;">Faltó</th>
                                            <th style="font-weight: bold;color: #ff6b6b;">50% Asistió</th>
                                            <th style="font-weight: bold;color: #299344;">Horas</th>
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
                                            <th style="font-weight: bold;color: #e0632b;">Descanzo</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $estilo_lista = "style=\"font-size: 12pt;font-weight: bold\"";
                                        ?>
                                        <tr>
                                            <td style="font-size: 15pt;font-weight: bold"><?php echo $dias_efectivos_periodo;?></td>
                                            <td <?= $estilo_lista;?>><?php echo $asistio;?></td>
                                            <td <?= $estilo_lista;?>><?php echo $tardanza;?></td>
                                            <td <?= $estilo_lista;?>><?php echo $falto;?></td>
                                            <td <?= $estilo_lista;?>><?php echo $medio_asistio;?></td>
                                            <td <?= $estilo_lista;?>><?php echo $jalar_horas->suma;?></td>
                                            <!--<td <?= $estilo_lista;?>><?php echo $asistio_medio;?></td>-->
                                            <!--<td <?= $estilo_lista;?>><?php echo $asistio_doble;?></td>-->
                                            <!--<td <?= $estilo_lista;?>><?php echo $asistio_triple;?></td>-->
                                            <!--<td <?= $estilo_lista;?>><?php echo $medico;?></td>-->
                                            <!--<td <?= $estilo_lista;?>><?php echo $neutro;?></td>-->
                                            <!--<td <?= $estilo_lista;?>><?php echo $neutro_covid;?></td>-->
                                            <!--<td <?= $estilo_lista;?>><?php echo $vacaciones;?></td>-->
                                            <!--<td <?= $estilo_lista;?>><?php echo $lactancia;?></td>-->
                                            <!--<td <?= $estilo_lista;?>><?php echo $con_goce;?></td>-->
                                            <!--<td <?= $estilo_lista;?>><?php echo $sin_goce;?></td>-->
                                            <td <?= $estilo_lista;?>><?php echo $descanso_renum;?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3>TOTAL DE DIAS CONTABILIZADOS: <b><?= $dias_del_periodo ?></b></h3>
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
<script>
    $(document).ready( function () {
        $('#id_persona').select2();
    } );
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