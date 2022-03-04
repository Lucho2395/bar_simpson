<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Recursos Humanos / Vacaciones</h1>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="align-items-center">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h4 class="card-title">Generar Obligación Laboral: </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="form-row" method="post" action="<?= _SERVER_ . 'RHumanos/vacaciones';?>">
                                <input type="hidden" value="1" name="enviar">
                                <div class="form-group col-md-4">
                                    <label for="id_empresa">Empresa Contratante</label>
                                    <select class="form-control" <?= $requireed ?> name="id_empresa" id="id_empresa" style="height: 44px; font-size: 12px;" required>
                                        <option style="font-size: 10pt;" value="">Seleccionar Empresa</option>
                                        <?php
                                        (isset($empresa))?$id_empre=$empresa->id_empresa:$id_empre=0;
                                        foreach ($empresas as $d){
                                            ($d->id_empresa==$id_empre)?$sele='selected':$sele='';
                                            ?>
                                            <option style="font-size: 10pt;" value="<?= $d->id_empresa;?>" <?= $sele; ?>><?= $d->empresa_razon_social;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <?php (isset($fecha_elegida))?$fecha_v=$fecha_elegida:$fecha_v=date("Y-m-d"); ?>
                                    <label for="fecha_i">Fecha de Inicio</label>
                                    <input name="fecha_i" onchange="validar_fechas()" type="date" value="<?= $fecha_v ;?>" class="form-control" id="fecha_i" required >
                                </div>
                                <div class="form-group col-md-3">
                                    <?php (isset($fecha_elegida2))?$fecha_v2=$fecha_elegida2:$fecha_v2=date("Y-m-d"); ?>
                                    <label for="fecha_f">Fecha de Término</label>
                                    <input name="fecha_f" onchange="validar_fechas()" type="date" value="<?= $fecha_v2 ;?>" class="form-control" id="fecha_f" required >
                                </div>
                                <div class="form-group col-md-2" style="text-align: center;">
                                    <br><button type="submit" style="margin-top: 10px;" class="btn btn-success"><i class="fa fa-search"></i> Buscar</button>
                                    <?php if($datos){
                                            ?>
                                            <a onclick="preguntarGenerarObligacion('VACACIONES')" style="width: 104px;color: white; margin-top: 10px;" id="btn-aprobar-obligacion" class="btn btn-primary"><i class="fa fa-check"></i> Generar</a>
                                            <?php
                                        }?>
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
                                <h5>Empresa Contratante: <span class='text-uppercase font-weight-bold'><?= (isset($empresa))?$empresa->empresa_nombre:'TODOS'; ?></span> del Periodo: <span class='text-uppercase font-weight-bold'><?= $fecha_shit[2]."-".$fecha_shit[1]."-".$fecha_shit[0]; ?></span> al: <span class='text-uppercase font-weight-bold'><?= $fecha_shit2[2]."-".$fecha_shit2[1]."-".$fecha_shit2[0]; ?></span></h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-striped table-earning" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="text-capitalize">
                                        <tr>
                                            <th>#</th>
                                            <th>Apellidos y Nombres</th>
                                            <th>DNI</th>
                                            <th>Dias Vacaciones/Dias del Mes</th>
                                            <th>Monto Mensual (S/.)</th>
                                            <th>Total Mensual (S/.)</th>
                                            <th>Neto a Pagar (S/.)</th>
                                            <th>Accion</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $a = 1;
                                        $dias_efectivos_total=0;
                                        foreach ($persons as $m){
                                            $vacaciones = true;
                                            //Verificamos que la persona no se este ya registrada en el array (para evitar duplicidad de datos)
                                            if (!array_key_exists($m->data->id_persona , $_SESSION['pagos_vacaciones'])) {
                                                //Validamos si el usuario no tiene 2 periodos activos en el rango de fechas buscado
                                                $periodos = $this->humanos->listar_periodos_empresa_person($m->data->id_persona, $_POST['fecha_i'], $_POST['fecha_f']);
                                                if(count($periodos) > 1){
                                                    //Calculamos los días totales del mes, en base al mes de consulta
                                                    $dias_totales = date('t', strtotime($fecha_v2));

                                                    //Si entra aqui, es porque tiene más de un periodo activo
                                                    $datos_totales = [];

                                                    $dias_contables_total = 0;
                                                    $total_periodo = 0;
                                                    $total_pago_periodo = 0;
                                                    //Recorremos los array del periodo
                                                    foreach ($periodos as $p){
                                                        //Listamos los datos del periodo
                                                        $periodo_usuario = $this->humanos->listar_periodo($p->id_periodo);
                                                        //Listamos las asistencias del periodo
                                                        $asistencias_periodo = $this->humanos->listar_asistencias_por_periodo_rango($p->id_periodo, $periodo_usuario->periodo_fechainicio, $periodo_usuario->periodo_fechafin);

                                                        //Creamos las variables para listar asistencia
                                                        $asistio = 0;
                                                        $falto = 0;
                                                        $medio_asistio = 0;
                                                        $asistio_veinti = 0;
                                                        $asistio_medio = 0;
                                                        $asistio_doble = 0;
                                                        $asistio_triple = 0;
                                                        $medico = 0;
                                                        $neutro = 0;
                                                        $vacaciones = 0;
                                                        $neutro_covid = 0;
                                                        $lactancia = 0;

                                                        $dias_del_periodo = 0;
                                                        //Contabilizamos la asistencia de la persona en el periodo transcurrido
                                                        foreach ($asistencias_periodo as $j){
                                                            $dias_del_periodo++;
                                                            //Contamos los valores de asistencia
                                                            switch($j->asistencia_valor){
                                                                //Falto
                                                                case 2: $falto++; break;
                                                                //50% Asistió
                                                                case 3: $medio_asistio++; break;
                                                                //Asistió
                                                                case 1: $asistio++; break;
                                                                //Asistió + 25%
                                                                case 10: $asistio_veinti++;break;
                                                                //Asistió + 50%
                                                                case 4: $asistio_medio++; break;
                                                                //Asistió + 100%
                                                                case 5: $asistio_doble++; break;
                                                                //Asistió + 200%
                                                                case 8: $asistio_triple++; break;
                                                                //Neutro Covid
                                                                case 11: $neutro_covid++;break;
                                                                //Neutro
                                                                case 7: $neutro++; break;
                                                                //Descanso Medico
                                                                case 6: $medico++; break;
                                                                //Vacaciones
                                                                case 9: $vacaciones++; break;
                                                                //Vacaciones
                                                                case 12: $lactancia++; break;
                                                            }
                                                        }
                                                        if($vacaciones > 0){
                                                            //Con el conteo total de asistencia anterior, calculamos los días efectivos:
                                                            $dias_efectivos_periodo = $vacaciones * 1;
                                                            $monto_partido_periodo = round(floatval((floatval($periodo_usuario->periodo_total)/$dias_totales) * $dias_del_periodo), 2);
                                                            $monto_pagar_periodo = round(floatval((floatval($periodo_usuario->periodo_total)/$dias_totales) * $dias_efectivos_periodo), 2);

                                                            $datos_totales[] = array("monto_periodo" => $monto_partido_periodo, "dias_contables" => $dias_efectivos_periodo, "monto_pagar_periodo" => $monto_pagar_periodo);
                                                        } else {
                                                            $vacaciones = false;
                                                        }
                                                    }
                                                    if($vacaciones){
                                                        //Calculamos el valor total del periodo
                                                        $dias_efectivos = 0;
                                                        $periodo_total = 0;
                                                        $pago_total = 0;
                                                        foreach ($datos_totales as $d){
                                                            $dias_efectivos = round(floatval($dias_efectivos + $d['dias_contables']),2);
                                                            $periodo_total = round(floatval($periodo_total + $d['monto_periodo']),2);
                                                            $pago_total = round(floatval($pago_total + $d['monto_pagar_periodo']),2);
                                                        }
                                                        //Ingresamos los datos al array respectivo
                                                        //Cargamos los datos del periodo
                                                        $_SESSION['pagos_vacaciones'][$m->data->id_persona] =
                                                            array(
                                                                "id_persona" => $m->data->id_persona,
                                                                "id_periodo" => $m->data2->id_periodo,
                                                                "pago_total" => $pago_total,
                                                                "dias_efectivos" => $dias_efectivos,
                                                                "dias_laborales" => $dias_totales,
                                                                "monto_mensual" => $periodo_total,
                                                                "total_mensual" => $pago_total,
                                                                "activo" => 1);
                                                    }
                                                } else {
                                                    //Creamos las variables para listar asistencia
                                                    $asistio = 0;
                                                    $falto = 0;
                                                    $medio_asistio = 0;
                                                    $asistio_veinti = 0;
                                                    $asistio_medio = 0;
                                                    $asistio_doble = 0;
                                                    $asistio_triple = 0;
                                                    $medico = 0;
                                                    $neutro = 0;
                                                    $vacaciones = 0;
                                                    $neutro_covid = 0;

                                                    //$dias_totales_conteo = 0;
                                                    //Contabilizamos la asistencia de la persona en el periodo transcurrido
                                                    foreach ($m->asistencias as $j){
                                                        /*if(!$this->obligacion->listar_obligacion_laboral_persona_fecha($j->id_person,$j->asistencia_fecha)){

                                                        }*/
                                                        //$dias_totales_conteo++;
                                                        //Contamos los valores de asistencia
                                                        switch($j->asistencia_valor){
                                                            //Falto
                                                            case 2: $falto++; break;
                                                            //50% Asistió
                                                            case 3: $medio_asistio++; break;
                                                            //Asistió
                                                            case 1: $asistio++; break;
                                                            //Asistió + 25%
                                                            case 10: $asistio_veinti++;break;
                                                            //Asistió + 50%
                                                            case 4: $asistio_medio++; break;
                                                            //Asistió + 100%
                                                            case 5: $asistio_doble++; break;
                                                            //Asistió + 200%
                                                            case 8: $asistio_triple++; break;
                                                            //Neutro Covid
                                                            case 11: $neutro_covid++;break;
                                                            //Neutro
                                                            case 7: $neutro++; break;
                                                            //Descanso Medico
                                                            case 6: $medico++; break;
                                                            //Vacaciones
                                                            case 9: $vacaciones++; break;
                                                            //Lactancia
                                                            case 12: $lactancia++; break;
                                                        }
                                                    }
                                                    if($vacaciones > 0){
                                                        //Con el conteo total de asistencia anterior, calculamos los días efectivos:
                                                        $dias_efectivos = $vacaciones * 1;
                                                        //$dias_efectivos_total = $dias_efectivos_total + $dias_efectivos;
                                                        //Para prevenir división entre 0 (que matematicamente, no existe)
                                                        //Calculamos los días totales del mes, en base al mes de consulta
                                                        $dias_totales = date('t', strtotime($fecha_v2));
                                                        //Calculamos el valor total del periodo
                                                        $periodo_total = $m->data2->periodo_total;
                                                        $pago_total = round(floatval((floatval($periodo_total)/$dias_totales) * $dias_efectivos), 2);
                                                        //Ingresamos los datos al array respectivo
                                                        $_SESSION['pagos_vacaciones'][$m->data->id_persona] =
                                                            array(
                                                                "id_persona" => $m->data->id_persona,
                                                                "id_periodo" => $m->data2->id_periodo,
                                                                "pago_total" => $pago_total,
                                                                "dias_efectivos" => $dias_efectivos,
                                                                "dias_laborales" => $dias_totales,
                                                                "monto_mensual" => $m->data2->periodo_total,
                                                                "total_mensual" => $pago_total,
                                                                "activo" => 1);
                                                        //Cargamos los datos para mostrarlos en HTML
                                                    } else {
                                                        $vacaciones = false;
                                                    }
                                                }
                                                if($vacaciones){
                                                    ?>
                                                    <tr id="fila_<?= $m->data->id_persona;?>">
                                                        <td><?php echo $a;?></td>
                                                        <td><?php echo $m->data->persona_apellido_paterno;?> <?php echo $m->data->persona_apellido_materno;?>, <?php echo $m->data->persona_nombre;?></td>
                                                        <td><?php echo $m->data->persona_dni;?></td>
                                                        <td style="font-size: 12pt;font-weight: bold"><?php echo $dias_efectivos . '/' . $dias_totales;?></td>
                                                        <td><?php echo $periodo_total;?></td>
                                                        <td><?php echo $pago_total;?></td>
                                                        <td><input type="text" class="form-control readonly_select_asistencia" id="input_<?= $m->data->id_persona; ?>" value="<?php echo $pago_total;?>"></td>
                                                        <td>
                                                            <a onclick="editar_obligacion(<?= $m->data->id_persona; ?>)" id="btn_editar_<?= $m->data->id_persona; ?>" data-toggle="tooltip" title='Editar'>
                                                                <i class='fa fa-edit text-success editar margen'></i>
                                                            </a>
                                                            <a onclick="actualizar_obligacion(<?= $m->data->id_persona ?>,'VACACIONES')" class="no-show" style="font-size: 18px;" id="btn_actualizar_<?= $m->data->id_persona ?>" data-toggle="tooltip" title='Guardar'>
                                                                <i class='fa fa-check text-primary margen'></i>
                                                            </a>
                                                            <a onclick="preguntardesHabilitar(<?= $m->data->id_persona; ?>,'VACACIONES')" id="btn_deshabilitar_<?= $m->data->id_persona; ?>" data-toggle="tooltip" title='Deshabilitar'>
                                                                <i class='fas fa-ban text-danger eliminar margen'></i>
                                                            </a>
                                                            <a onclick="preguntarHabilitar(<?= $m->data->id_persona ?>,'VACACIONES')" class="no-show" style="font-size: 18px;" id="btn_habilitar_<?= $m->data->id_persona ?>" data-toggle="tooltip" title='Habilitar'>
                                                                <i class='fa fa-check-double text-warning aprobar margen'></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $a++;
                                                }
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <!--<div class="row">
                                        <div class="col-md-6">
                                            <h3>TOTAL DE DIAS EFECTIVOS: <b><?= $dias_efectivos_total ?></b></h3>
                                        </div>
                                    </div>-->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <?php
            }
            ?>
            <div class="row">
                <div class="col-lg-6" style="text-align: right; ">
                </div>
                <div class="col-lg-6" style="text-align: right; ">
                    <a class="btn btn-secondary" href="javascript:History.back()" role="button"><i class="fa fa-backward"></i> Regresar</a>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function  validar_fechas(){
        var fecha_inicio = $('#fecha_i').val();
        var fecha_fin = $('#fecha_f').val();

        var fecha_inicial = new Date(fecha_inicio);
        var fecha_final = new Date(fecha_fin);

        if(fecha_inicial > fecha_final){
            //alertify.warning('Las Fecha de Inicio No Puede Ser Mayor a la Fecha Final');
            $('#fecha_f').val(fecha_inicio);
        } else {
            var fi = fecha_inicio.split("-");
            var ff = fecha_fin.split("-");
            if(fi[1] !== ff[1]){
                //alertify.warning('Las Fechas No Puede Ser de Diferente Mes');
                $('#fecha_f').val(fecha_inicio);
            }
        }
    }

    function actualizar_obligacion(id,tipo) {
        var valor = $('#input_'+id).val();
        var cadena = "id=" + id+"&monto_total="+valor+"&tipo="+tipo;
        $.ajax({
            type:"POST",
            url: urlweb + "api/RHumanos/actualizar_obligacion",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                $("#input_"+id).addClass('readonly_select_asistencia');
            },
            success:function (r) {
                console.log(r);
                if(r==1) {
                    respuesta("¡Guardado!",'success');
                    $("#input_" + id).addClass('readonly_select_asistencia');
                    $("#btn_actualizar_" + id).addClass('no-show');
                    $("#btn_editar_" + id).removeClass('no-show');
                }else{
                    $("#input_"+id).removeClass('readonly_select_asistencia');
                    $("#btn_actualizar_"+id).removeClass('no-show');
                    $("#btn_editar_"+id).addClass('no-show');
                    respuesta("Ocurrió Un Error",'error');
                }
            }
        });
    }
</script>