<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Recursos Humanos / Periodo Laboral</h1>
            </div>

            <div class="box box-primary">
                <?php
                $periodo_activo = "";
                if(!$this->humanos->verificar_periodo_activo($person->id_persona, "")){
                    $periodo_activo = "<strong style=\"color: red\"> (Sin Periodo Activo)</strong>";
                }
                ?>
                <div class="box-header with-border">
                    <h3 class="card-title"><strong>Datos: </strong><?php echo $person->persona_apellido_paterno; ?> <?php echo $person->persona_apellido_materno; ?>, <?php echo $person->persona_nombre; ?> | <?php echo $person->persona_tipo_documento; ?>: <?php echo $person->persona_dni; ?> <?php echo $periodo_activo; ?></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h3 class="m-0 font-weight-bold text-success ">Periodos Laborales</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-striped table-earning" id="dataTable" width="100%" cellspacing="0">
                                            <thead class="text-capitalize">
                                            <tr>
                                                <th>#</th>
                                                <th>Inicio</th>
                                                <th>Termino</th>
                                                <th>Tipo de Contrato</th>
                                                <th>Departamento</th>
                                                <th>Centro Laboral(Sede)</th>
                                                <th>Puesto</th>
                                                <th>Empresa</th>
                                                <th>Acción</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            //$id_rol_usuario = $this->encriptar->decrypt($_SESSION['ru'],_FULL_KEY_);
                                            $a = 1;
                                            foreach ($periodos as $m){
                                                $fecha_ini=explode("-",$m->periodo_fechainicio);
                                                $fecha_fini=explode("-",$m->periodo_fechafin);
                                                ?>
                                                <tr>
                                                    <td><?php echo $a;?></td>
                                                    <td><?php echo $fecha_ini[2]."-".$fecha_ini[1]."-".$fecha_ini[0];?></td>
                                                    <td><?php echo $fecha_fini[2]."-".$fecha_fini[1]."-".$fecha_fini[0];?></td>
                                                    <td><?php echo $m->contrato_nombre;?></td>
                                                    <td><?php echo $m->departamento_nombre;?></td>
                                                    <td><?php echo $m->sede_nombre;?></td>
                                                    <td><?php echo $m->cargo_nombre;?></td>
                                                    <td><?php echo $m->empresa_razon_social;?></td>
                                                    <td>
                                                        <?php
                                                            if($m->periodo_estado == 1){
                                                                ?>
                                                                <!--<a href="<?php echo _SERVER_ . 'RHumanos/modificar/' . $m->id_periodo;?>" data-toggle="tooltip" title="Modificar"><i class="fa fa-edit editar margen"></i></a>-->
                                                                <a href="<?php echo _SERVER_ . 'RHumanos/editar/' . $m->id_periodo;?>" data-toggle="tooltip" title="Editar"><i class="fa fa-user margen"></i></a>
                                                                <a href='<?php echo _SERVER_ . 'RHumanos/adjuntar/' . $m->id_periodo;?>' data-toggle='tooltip' title='Adjuntar'><i class='fa fa-paperclip adjuntar margen'></i></a>
                                                                <a onclick="preguntar('¿Esta Seguro que desea Eliminar este Periodo?','eliminar_periodo','SÍ','NO',<?= $m->id_periodo?>)" style="color: red" data-toggle='tooltip' title='Eliminar'><i class='fa fa-times eliminar margen'></i></a>
                                                                <a class="text-dark" href="<?php echo _SERVER_ . 'RHumanos/ver_periodo/' . $m->id_periodo;?>" data-toggle='tooltip' title='Ver' ><i class="fa fa-eye ver_detalle"></i></a>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <a href='#' data-toggle='tooltip' title='Pendiente de Aprobación'><i class='fa fa-exclamation-triangle pendiente' ></i></a>
                                                                <a onclick="preguntar('¿Esta Seguro de Aprobar el Periodo?','aprobar_periodo','SÍ','NO',<?= $m->id_periodo;?>,'aprobar<?= $a;?>')" style="color: green;" data-toggle='tooltip' id="aprobar<?= $a;?>" title='Aprobar'><i class='fa fa-check aprobar margen'></i></a>
                                                                <a onclick="preguntar('¿Esta Seguro que desea Eliminar este Periodo?','eliminar_periodo','SÍ','NO',<?= $m->id_periodo?>)" style="color: red;" data-toggle='tooltip' title='Eliminar'><i class='fa fa-times eliminar margen'></i></a>

                                                                <a href="<?php echo _SERVER_ . 'RHumanos/editar/' . $m->id_periodo;?>" style="color: green;" data-toggle="tooltip" title="Editar"><i class="fa fa-user editar margen"></i></a>

                                                                <!--<a href='<?php echo _SERVER_ . 'RHumanos/adjuntar/' . $m->id_periodo;?>' data-toggle='tooltip' title='Adjuntar'><i class='fa fa-paperclip adjuntar margen'></i></a>-->
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
                                </div>
                            </div>
                            <div style="text-align: right; ">
                                    <a class="btn btn-primary" target="_blank" href="<?= _SERVER_;?>RHumanos/constancia_trabajo/<?= $id;?>" role="button">Certificado de Trabajo</a>
                                    <!--<a class="btn btn-warning" href="<?= _SERVER_;?>RHumanos/aprobar/" role="button" style="color: white">Pendiente de Aprobación</a>-->
                                    <a class="btn btn-success" href="<?= _SERVER_;?>RHumanos/renovar_periodo/<?= $id;?>" role="button">Renovar Periodo</a>
                                    <a class="btn btn-success" href="<?= _SERVER_;?>RHumanos/agregar_periodo/<?= $id;?>" role="button">Agregar Periodo</a>
                                    <a class="btn btn-secondary" href="javascript:History.back();" role="button">Regresar</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>

        </div>
    </div>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>humanos.js"></script>