



<div class="modal fade" id="editarmemo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Memorandum</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Persona</label>
                                <input type="hidden" id="id_memorandum" name="id_memorandum" value="">
                                <select class="form-control" name="id_persona_" id="id_persona_" style="height: 44px; font-size: 12px;">
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
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
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
                        </div>
                        <div class="form-group col-md-12" id="div_otros">
                            <label for="otros">Otros</label>
                            <input style="height: 44px; font-size: 12px;" type="text" class="form-control" id="otros" name="otros">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="fecha">Fecha de Solicitud</label>
                            <input style="height: 44px; font-size: 12px;" type="date" class="form-control" id="fecha" name="fecha" value="">
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="descripcion">Descripción del Memorándum</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="guardar_edit()" id="btn-agregar"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
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
                <h1 class="h3 mb-0 text-gray-800">Recursos Humanos / Listar Memorandum</h1>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h4 class="m-0 font-weight-bold text-success">Listado de Memorandum al Personal</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="dataTable1" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha de Solicitud</th>
                                        <th>Motivo del Memorándum</th>
                                        <th>Descripción del Memorándum</th>
                                        <th>Personal</th>
                                        <th>Solicitado Por</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($memos as $m){
                                        $t= $this->humanos->listar_datos_generales($m->id_usuario);
                                        ?>
                                        <tr>
                                            <td><?php echo $a;?></td>
                                            <td><?php echo date("d-m-Y",strtotime($m->memorandum_fecha));?></td>
                                            <td><?php echo $m->memorandum_motivo;?></td>
                                            <td><?php echo $m->memorandum_descripcion;?></td>
                                            <td><?php echo $m->persona_nombre." ".$m->persona_apellido_paterno;?></td>
                                            <td><?php echo $t->persona_nombre." ".$t->persona_apellido_paterno;?></td>
                                            <td>
                                                <?php
                                                if($m->memorandum_estado == 0){
                                                    ?>
                                                    <a data-toggle="modal" data-target="#editarmemo" title="Editar" onclick="editar_memo(<?= $m->id_memorandum?>,'<?= $m->id_persona?>','<?= $m->memorandum_motivo?>','<?= $m->memorandum_descripcion?>','<?= $m->memorandum_otros?>','<?= $m->memorandum_fecha?>')" type="button" class="text-success" ><i class="fa fa-edit ver_detalle"></i></a>

                                                    <a onclick="preguntar('¿Esta Seguro que desea aprobar este Memorandum?','aprobar_memo','SÍ','NO',<?= $m->id_memorandum;?>)" style="font-size: 18px;" id="btn_habilitar" data-toggle="tooltip" title='Aprobar'>
                                                        <i class='fa fa-check text-warning aprobar margen'></i>
                                                    </a>
                                                    <a data-toggle="tooltip" type="button" onclick="preguntar('¿Esta Seguro que desea Eliminar este Memorandum?','eliminar_memo_p','SÍ','NO',<?= $m->id_memorandum;?>)" title='Eliminar'>
                                                        <i class='fa fa-times text-danger eliminar margen'></i>
                                                    </a>
                                                <?php
                                                }else{
                                                    ?>
                                                    <a data-toggle="tooltip" target="_blank" title="Ver" href="<?= _SERVER_ ?>RHumanos/ver_memo/<?= $m->id_memorandum; ?>" type="button" class="text-dark">
                                                        <i class='fa fa-eye ver_detalle'></i>
                                                    </a>
                                                    <a data-toggle="tooltip" type="button" onclick="preguntar('¿Esta Seguro que desea Deshabilitar este Memorandum?','eliminar_memo_g','SÍ','NO',<?= $m->id_memorandum;?>)" title='Deshabilitar'>
                                                        <i class='fa fa-times text-danger eliminar margen'></i>
                                                    </a>
                                                <?php
                                                }
                                                ?>

                                            </td>
                                        </tr>
                                        <?php
                                        $a++;
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-12" style="text-align: right; ">
                                <br><a class="btn btn-secondary" href="javascript:history.back()" role="button"><i class="fa fa-backward"></i> Regresar</a>
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

    function guardar_edit(){
        var valor = true;
        var id_persona = $('#id_persona_').val();
        var id_memorandum = $('#id_memorandum').val();
        var motivo = $('#motivo').val();
        var otros = $('#otros').val();
        var fecha = $('#fecha').val();
        var descripcion = $('#descripcion').val();

        var cadena = "id_persona="+id_persona+
            "&motivo="+motivo+
            "&fecha="+fecha+
            "&otros="+otros+
            "&descripcion="+descripcion+
            "&id_memorandum="+id_memorandum;
        if (valor) {
            $.ajax({
                type: "POST",
                url: urlweb + "api/RHumanos/editar_memo",
                dataType: 'json',
                data: cadena,
                success: function (r) {
                    switch (r.result.code) {
                        case 1:
                            respuesta('¡Editado con exito...Recargando!!','success');
                            setTimeout(function () {
                                location.reload()
                            }, 1000);
                            break;
                        case 2:
                            respuesta("Fallo la edición...Intentelo otra vez",'error');
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