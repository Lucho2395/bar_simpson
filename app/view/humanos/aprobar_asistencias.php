


<div class="modal fade" id="agregar_persona" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Administrar Horas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-5">
                            <label for="">Cantidad Horas</label>
                            <input type="hidden" id="id_persona_turno" name="id_persona_turno">
                            <input class="form-control" type="number" id="asistencia_horas" name="asistencia_horas" value="0">
                        </div>
                        <div class="col-lg-3" style="margin-top: 35px; width: 100%">
                            <button class="btn btn-success" onclick="guardar_horas()"><i class="fa fa-save"></i> Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Recursos Humanos / Aprobar Asistencias</h1>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Registro de Asistencia: </h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="form-row" method="post" action="<?= _SERVER_ . 'RHumanos/aprobar_asistencias';?>">
                                <input type="hidden" value="1" name="enviar">
                                <input type="hidden" value="<?= $fecha_elegida?>" name="fecha_elegida" id="fecha_elegida">
                                <?php
                                (isset($fecha_elegida)) ? $fecha_v = $fecha_elegida : $fecha_v = date("Y-m-d");
                                ?><input type="hidden" value="<?= $fecha_v ;?>" id="fecha_v"><?php
                                if($datos){
                                    (isset($departamento->id_departamento))?$depar=$departamento->id_departamento:$depar=0;
                                    (isset($sede->id_sede))?$sedeeee=$sede->id_sede:$sedeeee=0;
                                    ?>
                                    <input type="hidden" value="<?= $depar ;?>" id="id_Depa_">
                                    <input type="hidden" value="<?= $sedeeee ;?>" id="id_Sede_">
                                    <?php
                                }else{$depar=0;$sedeeee=0;}
                                ?>
                                <div class="form-group col-md-4">
                                    <select class="form-control" <?= $requireed; ?> name="id_sede" id="id_sede" style="height: 44px; font-size: 12px;">
                                        <?php
                                        foreach ($sedes as $s){
                                            ($s->id_sede==$sedeeee)?$sele='selected':$sele='';
                                            ?>
                                            <option value="<?= $s->id_sede;?>" <?= $sele; ?>><?= $s->sede_nombre;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2" style="height: 44px; font-size: 12px;">
                                    <input required name="fecha" type="date" value="<?= $fecha_v ;?>" class="form-control" id="fecha" >
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" style="width: 100px;padding-left: 5px;" class="btn btn-success"><i class="fa fa-search"></i> Buscar</button>
                                    <?php if($datos){
                                        ?>
                                        <a onclick="preguntar('¿Esta Seguro que desea Aprobar las Asistencias?','aprobar_asistencia','SÍ','NO')" style="width: 100px;padding-left: 3px;color: white" id="btnbtn-aprobar" class="btn btn-primary"><i class="fa fa-check"></i> Aprobar</a>
                                        <?php
                                    } ?>
                                </div>
                                <div class="col-md-9"></div>
                                <div class="col-md-3" style="text-align: right" id="hay_o_no_hay"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <?php
            $hay_uno = "no";
            if($datos){
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <?php $fecha_shit = explode('-',$fecha_elegida); ?>
                                <h4>Fecha: <span class='text-uppercase font-weight-bold'><?= $fecha_shit[2]."-".$fecha_shit[1]."-".$fecha_shit[0]; ?></span> | SEDE: <span class='text-uppercase font-weight-bold'><?= (isset($sede->sede_nombre))?$sede->sede_nombre:'TODOS'; ?></span></h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-striped table-earning" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="text-capitalize">
                                        <tr>
                                            <th>#</th>
                                            <th>Apellidos y Nombres</th>
                                            <th>DNI</th>
                                            <th>Cargo</th>
                                            <th>Foto</th>
                                            <th>Asistencia</th>
                                            <th>Observación</th>
                                            <th>Horas</th>
                                            <th>Acción</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $a = 1;
                                        $hay_uno = "no";$show_pe=false;
                                        foreach ($person as $m){
                                            $consultar_asistencia = $this->humanos->consultar_asistencia_persona($m->id_persona_turno,$fecha_elegida);

                                            if($hay_uno=="no"){
                                                if($consultar_asistencia->asistencia_estado==0){$hay_uno="si";}
                                            }
                                            ($consultar_asistencia->asistencia_estado==0)? $span_bolita="<div data-toggle='tooltip' style='background: red; border-radius: 50%;width: 10px;height: 10px;' title='Pendiente de Aprobación'></div>":$span_bolita="<div style='background: green; border-radius: 50%;width: 10px;height: 10px;' title='Aprobado' data-toggle='tooltip'></div>";;
                                            if($m->asistencia_proyectada == 1){
                                                if($id_role_u == 2 || $id_role_u == 3){
                                                    $show_pe = true;
                                                } else {
                                                    $show_pe = false;
                                                }
                                            } else {
                                                if(($id_role_u==2|| $id_role_u==3|| $id_role_u==6)){
                                                    $show_pe=true;
                                                }else{
                                                    if($m->asistencia_estado==0){
                                                        $show_pe=true;
                                                    }
                                                }
                                            }

                                            $estilo = "";
                                            $foto = _SERVER_ . 'media/persona/default.png';
                                            if($m->persona_foto != ""){
                                                if(file_exists($m->persona_foto)){
                                                    $foto = _SERVER_ . $m->persona_foto;
                                                }
                                            }
                                            if(empty($consultar_asistencia)){
                                                $color_select= 'background:red;';

                                            }else{
                                                switch ($consultar_asistencia->asistencia_valor){
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
                                            }
                                            $clase_select='readonly_select_asistencia';
                                            if($m->persona_blacklist == "SI"){ $estilo = "style=\"background-color: #FF6B70\""; }
                                            ?>
                                            <tr <?= $estilo;?>>
                                                <td><?php echo $span_bolita." ".$a;?></td>
                                                <td><?php echo $m->persona_apellido_paterno;?> <?php echo $m->persona_apellido_materno;?>, <?php echo $m->persona_nombre;?></td>
                                                <td><?php echo $m->persona_dni;?></td>
                                                <td><?php echo $m->cargo_nombre;?></td>
                                                <td><img class="rounded" src="<?= $foto;?>" alt="Foto de <?php echo $m->persona_nombre;?>" width="60"></td>
                                                <td id="tr_<?= $m->id_persona_turno; ?>" style="<?= $color_select; ?>">
                                                    <select style="font-size: 10pt;font-weight: bold;" onchange="cambiar_color_select(<?= $m->id_persona_turno ?>)" class='form-control <?= $clase_select; ?>'  id='select_<?= $m->id_persona_turno ?>'>

                                                            <option value='1' <?= ($consultar_asistencia->asistencia_valor==1)?'selected':''; ?> style="color:black;font-weight: bold;">ASISTIO</option>
                                                            <option value='10' <?= ($consultar_asistencia->asistencia_valor==10)?'selected':''; ?> style="color:#6dff95;font-weight: bold;">TARDANZA</option>
                                                            <?php
                                                            if(empty($consultar_asistencia)){
                                                                $cambiar = 2 ;
                                                                ?>
                                                                <option value='2' <?= ($cambiar==2)?'selected':''; ?> style="color:red;font-weight: bold;">FALTO</option>
                                                            <?php
                                                            }else{
                                                                ?>
                                                                <option value='2' <?= ($consultar_asistencia->asistencia_valor==2)?'selected':''; ?> style="color:red;font-weight: bold;">FALTO</option>
                                                                <?php
                                                            }
                                                            ?>
                                                            <option value='3' <?= ($consultar_asistencia->asistencia_valor==3)?'selected':''; ?> style="color: #ff6b6b;font-weight: bold;">50% ASISTIO</option>
                                                            <option value='7' <?= ($consultar_asistencia->asistencia_valor==7)?'selected':''; ?> style="color: maroon;font-weight: bold;">DESCANSO</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="asistencia_observacion<?= $m->id_persona_turno?>" name="asistencia_observacion<?= $m->id_persona_turno?>">
                                                </td>
                                                <td>
                                                    <?php
                                                    if(empty($consultar_asistencia)){
                                                            ?>
                                                        0 / <button data-toggle="modal" data-target="#agregar_persona" onclick="llenar_id(<?= $m->id_persona_turno;?>)" disabled ><i class="fa fa-pencil"></i></button>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <?= $consultar_asistencia->asistencia_horas;?> / <button data-toggle="modal" data-target="#agregar_persona" onclick="llenar_id(<?= $m->id_persona_turno;?>)" id="" name="" ><i class="fa fa-pencil"></i></button>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if($show_pe){
                                                        ?>
                                                        <a onclick="editar_asistencia(<?= $m->id_persona; ?>);mostrarboton()" id="btn_editar_<?= $m->id_persona; ?>" data-toggle="tooltip" title='Editar'>
                                                            <i class='fa fa-edit text-success editar margen'></i>
                                                        </a>
                                                        <a onclick="actualizar_asistencia(<?= $m->id_persona ?>)" class="no-show" style="font-size: 18px; display: none" id="btn_actualizar_<?= $m->id_persona ?>" data-toggle="tooltip" title='Guardar'>
                                                            <i class='fa fa-check text-primary margen'></i>
                                                        </a>
                                                    <?php } ?>
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
                <?php
            }
            ?>
        </div>
    </div>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>humanos.js"></script>
<script>
    window.onload=function () {
        if('<?= $hay_uno ?>'== "no"){
            document.getElementById("hay_o_no_hay").innerHTML="";
            $("#btnbtn-aprobar").hide();
        }else{
            document.getElementById("hay_o_no_hay").innerHTML="<p><i class='fa fa-exclamation-triangle' style='color: orange'></i> Pendiente de Aprobación</p>";
            $("#btnbtn-aprobar").show();
        }
    }

    function mostrarboton(){
        $('#btn_actualizar_<?= $m->id_persona ?>').show();
    }

    function aprobar_asistencia(){
        var fecha = $('#fecha_v').val();
        //var id_departamento = $('#id_Depa_').val();
        var id_sede = $('#id_Sede_').val();
        var cadenita_de_oracion = "";

        <?php
        foreach ($person as $m){
            ?>
        var asistencia_observacion = $("#asistencia_observacion<?= $m->id_persona_turno?>").val();
        var valorcito = $("#select_<?= $m->id_persona_turno ?>").val();
        cadenita_de_oracion += <?= $m->id_persona_turno ?>+"..**.."+valorcito+"--**--";
        <?php
        }
        ?>
        var cadena = "fecha="+fecha+"&id_sede="+id_sede + "&cadenita_de_oracion=" + cadenita_de_oracion + "&asistencia_observacion=" + asistencia_observacion;
        $.ajax({
            type:"POST",
            url: urlweb + "api/RHumanos/aprobar_asistencia",
            data : cadena,
            dataType: 'json',
            beforeSend: function () {
                $("#btnbtn-aprobar").html("Cargando...");
                $(".btn").attr("disabled", true);
                $("a").css("pointerEvents", 'none');
            },
            success:function (r) {
                $(".btn").attr("disabled", false);
                $("#btnbtn-aprobar").html("Redireccionando");
                switch (r) {
                    case 1:
                        respuesta("¡Guardado con Exito!",'success');
                        setTimeout(function () {
                            location.href = urlweb +  'Rhumanos/asistencia';
                        }, 1000);
                        break;
                    case 2:
                        respuesta("Ocurrió Un Error",'error');
                        break;
                    default:
                        respuesta("ERROR DESCONOCIDO",'error');
                }
            }
        });
    }

    function llenar_id(id){
        var id_persona_turno = $('#id_persona_turno').val(id);
    }
</script>