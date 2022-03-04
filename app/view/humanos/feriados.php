

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Recursos Humanos / Gestionar Feriados</h1>
            </div>

            <!-- Main row -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <input class="form-control" type="date" id="feriado_dia">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <input class="form-control" type="text" id="feriado_motivo"  placeholder="Motivo Feriado">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <button onclick="agregar_feriado()" id="btn-feriado" style="width: 100%" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Feriado</button>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Lista de Feriados Registrados</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-earning" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>ID</th>
                                        <th>Día</th>
                                        <th>Motivo</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($feriados as $m){
                                        $fecha = explode("-", $m->feriado_dia)
                                        ?>
                                        <tr>
                                            <td><?php echo $a?></td>
                                            <td><?php echo $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0];?></td>
                                            <td><?php echo $m->feriado_motivo;?></td>
                                            <td><a type="button" class="btn btn-xs btn-danger btne" style="color:white;" onclick="preguntar('¿Estas seguro de Eliminar este registro?','eliminar_feriado','SÍ','NO',<?php echo $m->id_feriado;?>)">Eliminar</a></td>
                                        </tr>
                                        <?php
                                        $a++;
                                    }
                                    ?>
                                    </tbody>
                                </table><br>
                                <a href="javascript:history.back();" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-history fa-sm text-white-50"></i> Volver Al Menú Anterior</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>humanos.js"></script>

<script>
    function agregar_feriado(){
        var valor = true;
        var feriado_dia = $('#feriado_dia').val();
        var feriado_motivo = $('#feriado_motivo').val();

        valor = validar_campo_vacio('feriado_dia', feriado_dia, valor);
        valor = validar_campo_vacio('feriado_motivo', feriado_motivo, valor);

        if(valor){
            var cadena = "feriado_dia=" + feriado_dia +
                "&feriado_motivo=" + feriado_motivo;
            $.ajax({
                type:"POST",
                url: urlweb + "api/RHumanos/agregar_feriado",
                data : cadena,
                dataType: 'json',
                success:function (r) {
                    switch (r.result.code) {
                        case 1:
                            respuesta("¡Guardado con Exito!",'success');
                            location.reload();
                            break;
                        case 2:
                            respuesta("Ocurrió Un Error",'error');
                            break;
                        case 3:
                            respuesta("Solicitud Fuera de Fecha",'error');
                            $('#password').css('border','solid red');
                            break;
                        case 6:
                            respuesta("Integridad De Datos Comprometida. Recargue la página por favor.",'error');
                            break;
                        default:
                            respuesta("ERROR DESCONOCIDO",'error');
                    }
                }
            });
        }
    }
</script>