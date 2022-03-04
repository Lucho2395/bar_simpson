

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Recursos Humanos / Periodo Laboral</h1>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h3 class="card-title">Periodo Laboral</h3>

                            </div>
                        </div>
                        <div class="card-body">
                            <form class="form-row" method="post" action="<?= _SERVER_ . 'RHumanos/periodolaboral';?>">
                                <div class="form-group col-md-4">
                                    <input required name="parametro" type="text" value="<?= $parametro;?>" class="form-control" id="parametro" placeholder="Nombre, Apellido Paterno o Documento de Identidad">
                                </div>
                                <div class="form-group col-md-4" >
                                    <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Buscar Ahora</button>
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
                                <h3 class="m-0 font-weight-bold text-success">Resultados de Búsqueda: <?= $parametro;?></h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-striped table-earning" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="text-capitalize">
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>DNI</th>
                                            <th>Foto</th>
                                            <th>Acción</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $a = 1;
                                        foreach ($person as $m){
                                            $periodo_activo = "";
                                            if(!$this->humanos->verificar_periodo_activo($m->id_persona, "")){
                                                $periodo_activo = "<strong style=\"color: red\"> (Sin Periodo Activo)</strong>";
                                            }
                                            $estilo = "";
                                            $foto = _SERVER_ . 'media/persona/default.png';
                                            if($m->persona_foto != ""){
                                                if(file_exists($m->persona_foto)){
                                                    $foto = _SERVER_ . $m->persona_foto;
                                                }
                                            }

                                            if($m->person_blacklist == "SI"){
                                                $estilo = "style=\"background-color: #FF6B70\"";
                                            }
                                            ?>
                                            <tr <?= $estilo;?>>
                                                <td><?php echo $a;?></td>
                                                <td><?php echo $m->persona_apellido_paterno;?> <?php echo $m->persona_apellido_materno;?>, <?php echo $m->persona_nombre;?><?php echo $periodo_activo;?></td>
                                                <td><?php echo $m->persona_dni;?></td>
                                                <td><img class="rounded" src="<?= $foto;?>" alt="Foto de <?php echo $m->persona_nombre;?>" width="60"></td>
                                                <td>
                                                    <a class="text-dark" href="<?php echo _SERVER_ . 'RHumanos/detalle_periodo_laboral/' . $m->id_persona;?>" data-toggle="tooltip" title="Ver Periodos"><i class="fa fa-eye ver_detalle"></i></a>
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