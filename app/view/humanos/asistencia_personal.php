<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Recursos Humanos / Registrar Asistencia</h1>
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
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="">Ingrese DNI</label>
                                    <input type="text" class="form-control" value="<?= $numero_dni;?>" id="numero_dni" name="numero_dni" onkeyup="validar_numeros(this.id)">
                                </div>
                                <div class="form-group col-md-4" style="margin-top: 35px;width: 100%;">
                                    <button class="btn btn-success" id="btn-buscar-persona" onclick="buscar_persona()"><i class="fa fa-search"></i> BUSCAR</button>
                                </div>
                                <div class="col-sm-3" style="margin-top: 35px;width: 100%; display: none">
                                    <button class="btn btn-success" id="btn-agregar-asistencia" onclick="registrar_asistencias()"><i class="fa fa-check"></i> Registrar Asistencia</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php
            if($datos){

                ?>
                <div class="row">
                   <div class="col-sm-2 col-lg-4 col-xs-2 col-md-2"></div>
                    <div class="col-sm-8 col-lg-4 col-xs-8 col-md-8">
                        <div class="card">
                            <div class="card-body" style="text-align: center">
                                <?php
                                if($persona){
                                    ?>
                                <img class="rounded" src="<?= _SERVER_. $persona->persona_foto;?>" alt="img" width="40%">
                                <h3 class="card-title"><strong><?= $persona->persona_nombre?> <?= $persona->persona_apellido_paterno?> <?= $persona->persona_apellido_materno?></strong></h3>
                                <h3 class="card-text"><?= $persona->persona_dni?></h3><br>
                                    <h3 class="card-text">Perteneces al <?= $persona->turno_nombre?></h3>
                                    <input type="hidden" id="asistencia_valor" name="asistencia_valor" value="<?= $valor;?>">

                                    <?php
                                        if(!empty($buscar_registro)){
                                            if($buscar_registro->asistencia_hora_salida == NULL){
                                                ?>
                                                <p><?=$respuesta;?></p>
                                                <button class="btn btn-primary" id="btn-agregar-salida" onclick="registrar_salida()"><i class="fa fa-check"></i> Registrar Salida</button>
                                                <?php
                                            }else{
                                                ?>
                                                <p style="color: darkred">Usted ya culminó su turno </p>
                                                <?php
                                            }
                                        }else{
                                            ?>
                                            <p><?=$respuesta;?></p>
                                            <button class="btn btn-success" id="btn-agregar-asistencia" onclick="registrar_asistencias()"><i class="fa fa-check"></i> Registrar Asistencia</button>
                                            <?php
                                        }
                                    ?>
                                    <?php
                                 }else{
                                    ?>
                                    <p style="color: darkred">EL DNI INGRESADO NO ES CORRECTO / NO ESTA REGISTRADO EN EL SISTEMA O NO TIENE UN PERIODO LABORAL ACTIVO</p>
                                <?php
                                }
                                ?>
                                </div>
                        </div>
                    </div>
                   <div class="col-sm-2 col-lg-4 col-xs-2 col-md-2"></div>
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
        }else{
            document.getElementById("hay_o_no_hay").innerHTML="<p><i class='fa fa-exclamation-triangle' style='color: orange'></i> Pendiente de Aprobación</p>";
        }
    }

    function mostrarboton(){
        $('#btn_actualizar_<?= $m->id_persona ?>').show();
    }

    function buscar_persona(){
        var numero_dni = $("#numero_dni").val();
        location.href=urlweb+"RHumanos/asistencia_personal/"+numero_dni;
    }


    function registrar_asistencias(){
        var valor = true;
        var boton = "btn-agregar-asistencia";
        var numero_dni = $('#numero_dni').val();
        var asistencia_valor = $('#asistencia_valor').val();
        if(valor) {
            var cadena = "numero_dni=" + numero_dni +
                        "&asistencia_valor=" + asistencia_valor;
            $.ajax({
                type: "POST",
                url: urlweb + "api/RHumanos/registrar_asistencia",
                data: cadena,
                dataType: 'json',
                beforeSend: function () {
                    cambiar_estado_boton(boton, 'Guardando...', true);
                },
                success: function (r) {
                    cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
                    switch (r) {
                        case 1:
                            respuesta('¡Asistencia registrada correctamente!', 'success');
                            setTimeout(function () {
                                location.href = urlweb +  'Rhumanos/asistencia_personal';
                            }, 1000);
                            break;
                        case 2:
                            respuesta('Error al registrar tu asistencia...Recargue la pagina', 'error');
                            break;
                        default:
                            respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                            break;
                    }
                }
            });
        }
    }

    function registrar_salida(){
        var valor = true;
        var boton = "btn-agregar-salida";
        var numero_dni = $('#numero_dni').val();
        var asistencia_valor = $('#asistencia_valor').val();
        if(valor) {
            var cadena = "numero_dni=" + numero_dni +
                "&asistencia_valor=" + asistencia_valor;
            $.ajax({
                type: "POST",
                url: urlweb + "api/RHumanos/registrar_salida",
                data: cadena,
                dataType: 'json',
                beforeSend: function () {
                    cambiar_estado_boton(boton, 'Guardando...', true);
                },
                success: function (r) {
                    cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
                    switch (r) {
                        case 1:
                            respuesta('¡Salida registrada correctamente!', 'success');
                            setTimeout(function () {
                                location.href = urlweb +  'Rhumanos/asistencia_personal';
                            }, 1000);
                            break;
                        case 2:
                            respuesta('Error al registrar tu asistencia...Recargue la pagina', 'error');
                            break;
                        default:
                            respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                            break;
                    }
                }
            });
        }
    }



</script>