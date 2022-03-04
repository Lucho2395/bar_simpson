<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Recursos Humanos / Proyectar Asistencia</h1>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Proyectar Asistencias: </h4>

                            </div>
                        </div>
                        <div class="card-body">
                            <form class="form-row" method="post" action="<?= _SERVER_ . 'RHumanos/proyectar_asistencia';?>">
                                <input type="hidden" value="1" name="enviar">
                                <div class="form-group col-md-4">
                                    <label for="fecha_i">Persona</label>
                                    <select class="form-control" name="id_persona" id="id_persona" style="height: 44px; font-size: 12px;" required>
                                        <option style="font-size: 10pt;" value="">Seleccionar Persona</option>
                                        <?php
                                        foreach ($persons as $per){
                                            ?>
                                            <option style="font-size: 10pt;" value="<?= $per->id_persona;?>" <?php if(isset($persona)){if($per->id_persona == $persona){echo 'selected';}}?> ><?= $per->persona_apellido_paterno." ".$per->persona_apellido_materno." ".$per->persona_nombre;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="fecha_i">Fecha de Inicio</label>
                                    <input required name="fecha_inicio" type="date" value="<?= $fecha_inicio ;?>" onchange="validar_fechas()" class="form-control" id="fecha_inicio" >
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="fecha_f">Fecha de Término</label>
                                    <input required name="fecha_fin" type="date" value="<?= $fecha_fin ;?>" onchange="validar_fechas()" class="form-control" id="fecha_fin" >
                                </div>
                                <div class="form-group col-md-2" style="margin-top: 6px;">
                                    <button type="submit" class="btn btn-success" style="margin-top: 29px;"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                                <div class="form-group col-md-2" style="margin-top: 6px">
                                    <?php
                                    if($datos){
                                        ?>
                                        <a class="btn btn-info" id="generar_asistencia_proyectada" onclick="preguntar('¿Esta seguro de guardar?','preguntar_guardar','SÍ','NO',<?= $persona;?>)" style="margin-top: 29px;color: white"><i class="fa fa-check"></i> Generar</a>
                                        <?php
                                    }
                                    ?>
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
                                <h5>
                                    Rango de Fechas a Proyectar Asistencia: <span class='text-uppercase font-weight-bold'><?= date('d-m-Y',strtotime($fecha_inicio))?></span> a <span class='text-uppercase font-weight-bold'><?= date('d-m-Y',strtotime($fecha_fin))?></span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-striped table-earning" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                        <tr>
                                            <th style="font-weight: normal">#</th>
                                            <th style="font-weight: normal">Apellidos y Nombres</th>
                                            <th style="font-weight: normal">DNI</th>
                                            <th style="font-weight: normal">Fecha</th>
                                            <th style="font-weight: normal">Asistencia</th>
                                            <th style="font-weight: bold;color: black;">Acción</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $a = 1;
                                        $dias_efectivos_total = 0;
                                        $persona = $this->humanos->list_all($persona);
                                        foreach ($_SESSION['fechas'] as $m){
                                            switch ($m['asistencia']){
                                                case '1': $color_select= 'background: white;'; break;
                                                case '2': $color_select= 'background:red;'; break;
                                                case '6': $color_select= 'background: yellow'; break;
                                                case '9': $color_select= 'background: blue'; break;
                                                case '11': $color_select= 'background: maroon'; break;
                                                case '12': $color_select= 'background: #cd4660'; break;
                                                case '13': $color_select= 'background: #03124c'; break;
                                                case '14': $color_select= 'background: #1c88a7'; break;
                                                case '15': $color_select= 'background: #e0632b'; break;
                                            }
                                            $clase_select = 'readonly_select_asistencia';
                                            ?>
                                            <tr>
                                                <td><?php echo $a;?></td>
                                                <td><?php echo $persona->persona_apellido_paterno;?> <?php echo $persona->persona_apellido_materno;?>, <?php echo $persona->persona_nombre;?></td>
                                                <td><?php echo $persona->persona_dni;?></td>
                                                <td><?php echo date('d-m-Y',strtotime($m['fecha']));?></td>
                                                <td id="tr_<?= $m['id_fecha']; ?>" style="<?= $color_select; ?>">
                                                    <select style="font-size: 10pt;font-weight: bold;" onchange="cambiar_color_select_p(<?= $m['id_fecha'];?>)" class='form-control <?= $clase_select; ?>'  id='select_<?= $m['id_fecha'];?>'>
                                                        <option value='1' <?= ($m['asistencia'] == 1) ? 'selected' : ''; ?> style="color:black;font-weight: bold;">ASISTIO</option>
                                                        <option value='2' <?= ($m['asistencia'] == 2)?'selected':''; ?> style="color:red;font-weight: bold;">FALTO</option>
                                                        <option value='11' <?= ($m['asistencia'] == 11) ? 'selected' : ''; ?> style="color: maroon;font-weight: bold;">NEUTRO COVID</option>
                                                        <option value='6' <?= ($m['asistencia'] == 6) ? 'selected' : ''; ?> style="color: yellow;font-weight: bold;">DESCANSO MEDICO</option>
                                                        <option value='9' <?= ($m['asistencia'] == 9) ? 'selected' : ''; ?> style="color: blue;font-weight: bold;">VACACIONES</option>
                                                        <option value='12' <?= ($m['asistencia'] == 12) ? 'selected' : ''; ?> style="color: #cd4660;font-weight: bold;">LICENCIA POR PATERNIDAD</option>
                                                        <option value='13' <?= ($m['asistencia'] == 13) ? 'selected' : ''; ?> style="color: #03124c;font-weight: bold;">LICENCIA CON GOCE DE HABER</option>
                                                        <option value='14' <?= ($m['asistencia'] == 14) ? 'selected' : ''; ?> style="color: #1c88a7;font-weight: bold;">LICENCIA SIN GOCE DE HABER</option>
                                                        <option value='15' <?= ($m['asistencia'] == 15) ? 'selected' : ''; ?> style="color: #e0632b;font-weight: bold;">DESCANSO RENUMERADO</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <a onclick="editar_asistencia_p(<?= $m['id_fecha'];?>)" id="btn_editar_<?= $m['id_fecha'];?>" data-toggle="tooltip" title='Editar'>
                                                        <i class='fa fa-edit text-success editar margen'></i>
                                                    </a>
                                                    <a onclick="actualizar_asistencia_p(<?= $m['id_fecha'];?>)" class="no-show" style="font-size: 18px;" id="btn_actualizar_<?= $m['id_fecha'];?>" data-toggle="tooltip" title='Guardar'>
                                                        <i class='fa fa-check text-primary margen'></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                            $a++;
                                            $dias_efectivos_total++;
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
<script>
    $(document).ready( function () {
        $('#id_persona').select2();
    } );

    function validar_fechas() {
        var inicio = $('#fecha_inicio').val();
        var fin = $('#fecha_fin').val();

        if(inicio !== "" && fin !== ""){
            var f_inicial = new Date(inicio);
            var f_final = new Date(fin);

            if(f_inicial > f_final){
                $('#fecha_fin').val(inicio);
            }
        }
    }

    function cambiar_color_select_p(id) {
        var select_pe = $('#select_'+id).val();
        if (select_pe != ""){
            switch (select_pe) {
                case '1':
                    $('#select_'+id).css('color','black');
                    $('#tr_'+id).css('background','white');
                    break;
                case '2':
                    $('#select_'+id).css('color','red');
                    $('#tr_'+id).css('background','red');
                    break;
                case '3':
                    $('#select_'+id).css('color','#ff6b6b');
                    $('#tr_'+id).css('background','#ff6b6b');
                    break;
                case '4':
                    $('#select_'+id).css('color','limegreen');
                    $('#tr_'+id).css('background','limegreen');
                    break;
                case '5':
                    $('#select_'+id).css('color','#299344');
                    $('#tr_'+id).css('background','#299344');
                    break;
                case '6':
                    $('#select_'+id).css('color','yellow');
                    $('#tr_'+id).css('background','yellow');
                    break;
                case '7':
                    $('#select_'+id).css('color','maroon');
                    $('#tr_'+id).css('background','maroon');
                    break;
                case '8':
                    $('#select_'+id).css('color','purple');
                    $('#tr_'+id).css('background','purple');
                    break;
                case '9':
                    $('#select_'+id).css('color','blue');
                    $('#tr_'+id).css('background','blue');
                    break;
                case '10':
                    $('#select_'+id).css('color','#6dff95');
                    $('#tr_'+id).css('background','#6dff95');
                case '11':
                    $('#select_'+id).css('color','maroon');
                    $('#tr_'+id).css('background','maroon');
                    break;
                case '12':
                    $('#select_'+id).css('color','#cd4660');
                    $('#tr_'+id).css('background','#cd4660');
                    break;
                case '13':
                    $('#select_'+id).css('color','#03124c');
                    $('#tr_'+id).css('background','#03124c');
                    break;
                case '14':
                    $('#select_'+id).css('color','#1c88a7');
                    $('#tr_'+id).css('background','#1c88a7');
                    break;
                case '15':
                    $('#select_'+id).css('color','#e0632b');
                    $('#tr_'+id).css('background','#e0632b');
                    break;
            }
        }
    }

    function editar_asistencia_p(id) {
        $("#select_"+id).removeClass('readonly_select_asistencia');
        $("#btn_actualizar_"+id).removeClass('no-show');
        $("#btn_editar_"+id).addClass('no-show');
    }

    function actualizar_asistencia_p(id) {
        var valor = $('#select_'+id).val();
        var cadena = "id=" + id + "&valor=" + valor;
        $.ajax({
            type:"POST",
            url: urlweb + "api/RHumanos/guardar_asistencia_proyectada",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                $("#select_"+id).addClass('readonly_select_asistencia');
                $("#btn_editar_"+id).removeClass('no-show');
            },
            success:function (r) {
                if(r==1) {
                    respuesta("¡Guardado con exito...!",'success');
                    $("#select_" + id).addClass('readonly_select_asistencia');
                    $("#btn_actualizar_" + id).addClass('no-show');
                    $("#btn_editar_" + id).removeClass('no-show');
                }else{
                    $("#select_"+id).removeClass('readonly_select_asistencia');
                    $("#btn_actualizar_"+id).removeClass('no-show');
                    $("#btn_editar_"+id).addClass('no-show');
                    respuesta("Ocurrió Un Error",'error');
                }
            }
        });
    }


</script>