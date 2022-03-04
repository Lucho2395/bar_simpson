<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Recursos Humanos / Adjuntar Documentos</h1>
            </div>

            <div class="card-body">
                <!-- Modal -->
                <form class="form" enctype="multipart/form-data" id="archivo">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Tipo de Documento</label>
                                <input type="hidden" id="id-periodo" name="id_periodo" value="<?= $id;?>">
                                <select class="form-control" id="id_adjunto" name="id_adjunto" style="height: 45px;" required>
                                    <option value="">Seleccionar ...</option>
                                    <?php
                                    foreach ($tipoadjuntos as $ad){
                                        ?>
                                        <option value="<?= $ad->id_adjunto;?>"><?= $ad->adjunto_nombre;?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Fecha Inicio</label>
                                <input type="date" class="form-control"  name="documento_fechainicio" id="documento_fechainicio" placeholder="Referencia" required>

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Fecha Fin (*)</label>
                                <input type="date" class="form-control" name="documento_fechafin" id="documento_fechafin" placeholder="Referencia" >
                                <small id="emailHelp" class="form-text text-muted">(*) Llenar si corresponde.</small>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Documento</label>
                                <input type="file" class="form-control-file" name="archivo" id="archivo" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success" id="subir_archivo">Subir</button>
                            <button type="button" class="btn btn-danger cancel-upload">Cancelar</button>
                            <a class="btn btn-secondary" href="javascript:history.back();" role="button">Regresar</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-header" style="font-size: 20px; font-weight: bold;">
                    Documentos Adjuntos
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless table-striped table-earning" id="dataTable" width="100%" cellspacing="0">
                            <thead class="text-capitalize">
                            <tr>
                                <th>#</th>
                                <th>Tipo Documento</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Ver</th>
                                <th>Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a = 1;
                            foreach ($adjuntos as $m){
                                $existe = true;
                                $archivo=explode('media_documentos/',$m->documento_nombre);
                                if(!file_exists($m->documento_nombre)){
                                    $existe = false;
                                }

                                $fecha_fin = $m->documento_fechafin;
                                if($m->documento_fechafin == '0000-00-00' || $m->documento_fechafin == null){
                                    $fecha_fin = '-';
                                }
                                ?>
                                <tr>
                                    <td><?php echo $a;?></td>
                                    <td><?php echo $m->adjunto_nombre;?></td>
                                    <td><?php echo $m->documento_fechainicio;?></td>
                                    <td><?php echo $fecha_fin;?></td>
                                    <td>
                                        <?php
                                        if($existe){
                                            ?>
                                            <a class="text-dark" href="<?php echo _SERVER_ . $m->documento_nombre;?>" data-toggle="tooltip" title="Ver Documento" target="_blank"><i class="fa fa-eye ver_detalle"></i></a>
                                            <a class="text-dark" download="<?= (isset($archivo[1]))?$archivo[1]:'';?>" href="<?php echo _SERVER_ . $m->documento_nombre;?>" data-toggle="tooltip" title="Descargar"><i class="fa fa-download pdf"></i></a>
                                            <?php
                                        } else {
                                            ?>
                                            <a class="text-dark" >No Existe Archivo</a>
                                            <?php
                                        }
                                        ?>

                                    </td>
                                    <td>
                                        <a onclick="preguntar('¿Estas Seguro de Eliminar este Documento','eliminar_documento','SÍ','NO',<?= $m->id_documento?>)" style="color: red;" data-toggle='tooltip' title='Eliminar'><i class='fa fa-times eliminar eliminar-margen'></i></a>
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
<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>humanos.js"></script>

<script>
    $("#archivo").on('submit', function(e){
        e.preventDefault();
        var valor = true;
        var id_adjunto = $('#id_adjunto').val();
        var archivo = $('#archivo').val();
        var docum_fechafin = $('#docum_fechafin').val();

        if (valor){
            $.ajax({
                type:"POST",
                url: urlweb + "api/RHumanos/guardar_archivo",
                dataType: 'json',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success:function (r) {
                    switch (r.result.code) {
                        case 1:
                            respuesta('¡Guardado con Exito...Recargando!','success');
                            setTimeout(function () {
                                location.reload()
                            }, 1000);
                            break;
                        case 2:
                            respuesta("Error al guardar...Intente nuevamente.", 'error');
                            break;
                        case 6:
                            respuesta("Algún dato fue ingresado de manera erronéa. Recargue la página por favor.",'error');
                            break;
                        default:
                            respuesta("ERROR DESCONOCIDO", 'error');
                    }
                }
            });
        }
    });
</script>