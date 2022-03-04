



<div class="modal fade" id="gestion_turnos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 35% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Administrar Turnos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">Nombre Turno</label>
                            <input class="form-control" type="text" id="turno_nombre" name="turno_nombre" placeholder="Ingrese Nombre del Turno...">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Hora Entrada</label>
                            <input class="form-control" type="time" id="turno_hora_entrada" name="turno_hora_entrada">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Hora Tolerancia</label>
                            <input type="time" class="form-control" id="turno_hora_tolerancia" name="turno_hora_tolerancia">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Hora Salida</label>
                            <input type="time" class="form-control" id="turno_hora_salida" name="turno_hora_salida">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn-turno" onclick="agregar_turnos()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editar_turnos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 35% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Turnos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">Nombre Turno</label>
                            <input type="hidden" id="id_turno" name="id_turno">
                            <input class="form-control" type="text" id="turno_nombre_e" name="turno_nombre_e" placeholder="Ingrese Nombre del Turno...">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Hora Entrada</label>
                            <input class="form-control" type="time" id="turno_hora_entrada_e" name="turno_hora_entrada_e">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Hora Tolerancia</label>
                            <input type="time" class="form-control" id="turno_hora_tolerancia_e" name="turno_hora_tolerancia_e">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Hora Salida</label>
                            <input type="time" class="form-control" id="turno_hora_salida_e" name="turno_hora_salida_e">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn-turno-editado" onclick="agregar_turnos_editado()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Recursos Humanos / Gestionar Turnos</h1>
            </div>
            <div class="row">
                <div class="col-lg-10"></div>
                <div class="col-lg-2">
                    <button data-toggle="modal" data-target="#gestion_turnos" class="btn btn-success"><i class="fa fa-save"></i> Agregar Turno</button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h3 class="m-0 font-weight-bold text-success">Registro de Turnos</h3>
                        </div>
                        <div class="card-body">
                            <div class="tabla-responsive">
                                <table class="table table-borderless table-striped table-earning" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>#</th>
                                        <th>Turno</th>
                                        <th>Hora Entrada</th>
                                        <th>Hora Tolerancia</th>
                                        <th>Hora Salida</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($turnos as $t){
                                        ?>
                                        <tr>
                                            <td><?= $a;?></td>
                                            <td><?= $t->turno_nombre;?></td>
                                            <td><?= $t->turno_hora_entrada;?></td>
                                            <td><?= $t->turno_hora_tolerancia;?></td>
                                            <td><?= $t->turno_hora_salida;?></td>
                                            <td>
                                                <a class="btn btn-success" onclick="editar_turno(<?= $t->id_turno?>,'<?= $t->turno_nombre?>','<?= $t->turno_hora_entrada?>','<?= $t->turno_hora_tolerancia?>','<?= $t->turno_hora_salida?>')" data-target="#editar_turnos" data-toggle="modal" title='Editar'><i class='fa fa-edit text-white editar margen'></i></a>
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

        </div>
    </div>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>humanos.js"></script>

<script>
    function agregar_turnos(){
        var boton = "btn-turno";
        var valor = true;
        var turno_nombre = $('#turno_nombre').val();
        var turno_hora_entrada = $('#turno_hora_entrada').val();
        var turno_hora_tolerancia = $('#turno_hora_tolerancia').val();
        var turno_hora_salida = $('#turno_hora_salida').val();
        if (valor){
            var cadena = "turno_nombre=" + turno_nombre +
                "&turno_hora_entrada=" + turno_hora_entrada +
                "&turno_hora_tolerancia=" + turno_hora_tolerancia +
                "&turno_hora_salida=" + turno_hora_salida;
            $.ajax({
                type:"POST",
                url: urlweb + "api/RHumanos/agregar_turnos",
                data: cadena,
                dataType: 'json',
                beforeSend: function () {
                    $("#" + boton + "").html("Cargando...");
                    $("#" + boton + "").attr("disabled", true);
                },
                success:function (r) {
                    $("#" + boton + "").attr("disabled", false);
                    $("#" + boton + "").html("Confirmar");
                    switch (r.result.code) {
                        case 1:
                            respuesta("¡Guardado con exito...!",'success');
                            setTimeout(function () {
                                location.reload()
                            }, 1000);
                            break;
                        case 2:
                            respuesta("Ocurrió Un Error",'error');
                            break;
                        case 6:
                            respuesta("Algún dato fue ingresado de manera erronéa. Recargue la página por favor.",'error');
                            break;
                        default:
                            respuesta("ERROR DESCONOCIDO",'error');
                    }
                }
            });
        }
    }

    function agregar_turnos_editado(){
        var boton = "btn-turno-editado";
        var valor = true;
        var id_turno = $('#id_turno').val();
        var turno_nombre = $('#turno_nombre_e').val();
        var turno_hora_entrada = $('#turno_hora_entrada_e').val();
        var turno_hora_tolerancia = $('#turno_hora_tolerancia_e').val();
        var turno_hora_salida = $('#turno_hora_salida_e').val();
        if (valor){
            var cadena = "id_turno=" + id_turno +
                "&turno_nombre=" + turno_nombre +
                "&turno_hora_entrada=" + turno_hora_entrada +
                "&turno_hora_tolerancia=" + turno_hora_tolerancia +
                "&turno_hora_salida=" + turno_hora_salida;
            $.ajax({
                type:"POST",
                url: urlweb + "api/RHumanos/agregar_turnos_editado",
                data: cadena,
                dataType: 'json',
                beforeSend: function () {
                    $("#" + boton + "").html("Cargando...");
                    $("#" + boton + "").attr("disabled", true);
                },
                success:function (r) {
                    $("#" + boton + "").attr("disabled", false);
                    $("#" + boton + "").html("Confirmar");
                    switch (r.result.code) {
                        case 1:
                            respuesta("¡Guardado con exito...!",'success');
                            setTimeout(function () {
                                location.reload()
                            }, 1000);
                            break;
                        case 2:
                            respuesta("Ocurrió Un Error",'error');
                            break;
                        case 6:
                            respuesta("Algún dato fue ingresado de manera erronéa. Recargue la página por favor.",'error');
                            break;
                        default:
                            respuesta("ERROR DESCONOCIDO",'error');
                    }
                }
            });
        }
    }
</script>
