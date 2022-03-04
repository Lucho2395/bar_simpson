<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
                <a href="<?= _SERVER_ ?>RHumanos/listar_memo" type="button" class="btn btn-success"><i class="fa fa-search"></i> Ver Memorandums</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Generar Memorandum al Personal</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="id_persona">Personal</label>
                                    <select class="form-control" name="id_persona" id="id_persona" style="height: 44px; font-size: 12px;">
                                        <option value="">Seleccionar Persona</option>
                                        <?php
                                        foreach ($persona as $d){
                                            ?>
                                            <option style="font-size: 10pt;" value="<?= $d->id_persona;?>"><?= $d->persona_nombre." ".$d->persona_apellido_paterno." ".$d->persona_apellido_materno;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="motivo">Motivo del Memorándum</label>
                                    <select class="form-control" onchange="check_otros()" name="motivo" id="motivo" style="height: 44px; font-size: 12px;">
                                        <option value="">Seleccionar</option>
                                        <option value="VACACIONES">VACACIONES</option>
                                        <option value="LACTANCIA PATERNA">LACTANCIA PATERNA</option>
                                        <option value="DESCANSO MÉDICO">DESCANSO MÉDICO</option>
                                        <option value="PERMISO CON GOCE DE HABER">PERMISO CON GOCE DE HABER</option>
                                        <option value="PERMISO SIN GOCE DE HABER">PERMISO SIN GOCE DE HABER</option>
                                        <option value="SANCIONES Y/O AMONESTACIONES">SANCIONES Y/O AMONESTACIONES</option>
                                        <option value="CAMBIO DE PUESTO">CAMBIO DE PUESTO</option>
                                        <option value="CAMBIO DE MODALIDAD DE TRABAJO">CAMBIO DE MODALIDAD DE TRABAJO</option>
                                        <option value="RENUNCIA">RENUNCIA</option>
                                        <option value="ENTREGA EQUIPOS EPP">ENTREGA EQUIPOS EPP</option>
                                        <option value="CAMBIO EQUIPO EPP">CAMBIO EQUIPO EPP</option>
                                        <option value="ENTREGA EQUIPO DE COMPUTO">ENTREGA EQUIPO DE COMPUTO</option>
                                        <option value="CAMBIO EQUIPO DE COMPUTO">CAMBIO EQUIPO DE COMPUTO</option>
                                        <option value="OTROS">OTROS</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3" id="div_otros">
                                    <label for="otros">Otros</label>
                                    <input style="height: 44px; font-size: 12px;" type="text" class="form-control" id="otros" name="otros">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="fecha">Fecha de Solicitud</label>
                                    <input style="height: 44px; font-size: 12px;" type="date" class="form-control" id="fecha" name="fecha" value="<?= date('Y-m-d'); ?>">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="descripcion">Descripción del Memorándum</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="10"></textarea>
                                </div>
                                <div class="form-group col-md-12" style="text-align: right">
                                    <br><button onclick="guardar_memo()" type="submit" class="btn btn-primary submitBtn"><i class="fa fa-check"></i> Generar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>

<script>
    $(document).ready(function(){
        $('#div_otros').hide();
        $('#id_persona').select2();
    });
    function check_otros() {
        var motivo=$('#motivo').val();
        if(motivo=="OTROS"){
            $('#div_otros').show();
        }else{
            $('#div_otros').hide();
        }
    }

    function guardar_memo(){
        var valor = true;
        var id_persona = $('#id_persona').val();
        var motivo = $('#motivo').val();
        var otros = $('#otros').val();
        var fecha = $('#fecha').val();
        var descripcion = $('#descripcion').val();

        var cadena = "id_persona="+id_persona+
            "&motivo="+motivo+
            "&otros="+otros+
            "&descripcion="+descripcion+
            "&fecha="+fecha;
        if (valor) {
            $.ajax({
                type: "POST",
                url: urlweb + "api/RHumanos/guardar_memo",
                dataType: 'json',
                data: cadena,
                success: function (r) {
                    switch (r.result.code) {
                        case 1:
                            respuesta('¡Guardado con exito...Recargando!!','success');
                            setTimeout(function () {
                                location.href = urlweb + 'RHumanos/listar_memo';
                            }, 1000);
                            break;
                        case 2:
                            respuesta("Fallo el envio...Intentelo otra vez",'error');
                            break;
                        case 6:
                            respuesta('Algún dato fue ingresado de manera erronéa. Recargue la página por favor.','error');
                            break;
                        default:
                            respuesta('ERROR DESCONOCIDO','error');
                    }
                }
            });
        }
    }
</script>