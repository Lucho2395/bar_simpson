<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Recursos Humanos / Pendientes de Aprobación</h1>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h5 class="m-0 font-weight-bold text-success">Pendientes de Aprobación</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-earning" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>#</th>
                                        <th>Apellidos y Nombres</th>
                                        <th>DNI</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha de Término</th>
                                        <th>Departamento</th>
                                        <th>Centro Laboral</th>
                                        <th>Puesto</th>
                                        <th>Foto</th>
                                        <th>Solicitado Por:</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($person as $m){
                                        $estilo = "";
                                        $foto = _SERVER_ . 'media/persona/default.png';
                                        if($m->persona_foto != ""){
                                            if(file_exists($m->persona_foto)){
                                                $foto = _SERVER_ . $m->persona_foto;
                                            }
                                        }

                                        if($m->persona_blacklist == "SI"){
                                            $estilo = "style=\"background-color: #FF6B70\"";
                                        }
                                        $fecha_i=explode('-',$m->periodo_fechainicio);
                                        $fecha_f=explode('-',$m->periodo_fechafin);

                                        //Para poner Solicitado Por:
                                        if($m->id_user_creacion != ""){
                                            if(is_numeric($m->id_user_creacion)){
                                                $usuario = $this->humanos->listar_usuario($m->id_user_creacion);
                                                $usuario_nombre = explode(" ", $usuario->persona_nombre);
                                                $solicitador = $usuario_nombre[0] . ' ' . $usuario->persona_apellido_paterno;
                                            } else {
                                                $solicitador = "--";
                                            }
                                        } else {
                                            $solicitador = "--";
                                        }
                                        ?>
                                        <tr <?= $estilo;?>>
                                            <td><?php echo $a;?></td>
                                            <td><?php echo $m->persona_apellido_paterno;?> <?php echo $m->persona_apellido_materno;?>, <?php echo $m->persona_nombre;?></td>
                                            <td><?php echo $m->persona_dni;?></td>
                                            <td><?php echo $fecha_i[2]."-".$fecha_i[1]."-".$fecha_i[0];?></td>
                                            <td><?php echo $fecha_f[2]."-".$fecha_f[1]."-".$fecha_f[0];?></td>
                                            <td><?php echo $m->departamento_nombre;?></td>
                                            <td><?php echo $m->sede_nombre;?></td>
                                            <td><?php echo $m->cargo_nombre;?></td>
                                            <td><img class="rounded" src="<?= $foto;?>" alt="Foto de <?php echo $m->persona_nombre;?>" width="60"></td>
                                            <td><?= $solicitador;?></td>
                                            <td>
                                                <a class="text-dark" href="<?php echo _SERVER_ . 'RHumanos/detalle_periodo_laboral/' . $m->id_persona;?>" data-toggle="tooltip" title="Ver Periodos"><i class="fa fa-eye"></i></a>
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

            <div class="row">
                <div class="col-lg-6" style="text-align: left; ">
                    <?php
                    if(!isset($_GET['id'])){
                        ?>
                        <a class="btn btn-success" href="<?= _SERVER_ ?>RHumanos/excel_aprobar" target="_blank" role="button"><i class="fa fa-file-excel"></i> Exportar Excel</a>
                        <a class="btn btn-primary" href="<?= _SERVER_ ?>RHumanos/imprimible_aprobar" target="_blank" role="button"><i class="fa fa-print"></i> Versión Imprimible</a>
                        <?php
                    }
                    ?>
                </div>
                <div class="col-lg-6" style="text-align: right; ">
                    <?php
                    if(isset($_GET['id'])){
                        ?>
                        <a class="btn btn-secondary" href="<?= _SERVER_ ?>RHumanos/detalle_periodo_laboral/<?= $_GET['id']?>" role="button"><i class="fa fa-backward"></i> Regresar</a>
                        <?php
                    } else {
                        ?>
                        <a class="btn btn-secondary" href="<?= _SERVER_ ?>RHumanos/consultar" role="button"><i class="fa fa-backward"></i> Regresar</a>
                        <?php
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>humanos.js"></script>