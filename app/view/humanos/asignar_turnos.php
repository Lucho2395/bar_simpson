
<div class="modal fade" id="turno_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Personal del Turno 1</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                        <div class="table-responsive">
                        <table class="table">
                            <thead  class="text-capitalize">
                            <tr>
                                <th>#</th>
                                <th>Persona</th>
                                <th>Turno</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a = 1;
                            foreach ($turno_1 as $m){
                               ?>
                                <tr>
                                    <td><?= $a;?></td>
                                    <td><?= $m->persona_apellido_paterno?> <?= $m->persona_apellido_materno?> <?= $m->persona_nombre?></td>
                                    <td><?= $m->turno_nombre;?></td>
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

<div class="modal fade" id="turno_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Personal Turno 2</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead  class="text-capitalize">
                            <tr>
                                <th>#</th>
                                <th>Persona</th>
                                <th>Turno</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a = 1;
                            foreach ($turno_2 as $m){
                                ?>
                                <tr>
                                    <td><?= $a;?></td>
                                    <td><?= $m->persona_apellido_paterno?> <?= $m->persona_apellido_materno?> <?= $m->persona_nombre?></td>
                                    <td><?= $m->turno_nombre;?></td>
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
<div class="modal fade" id="turno_3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Personal Turno 2</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead  class="text-capitalize">
                            <tr>
                                <th>#</th>
                                <th>Persona</th>
                                <th>Turno</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a = 1;
                            foreach ($turno_3 as $m){
                                ?>
                                <tr>
                                    <td><?= $a;?></td>
                                    <td><?= $m->persona_apellido_paterno?> <?= $m->persona_apellido_materno?> <?= $m->persona_nombre?></td>
                                    <td><?= $m->turno_nombre;?></td>
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
<div class="modal fade" id="turno_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Personal Turno 2</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead  class="text-capitalize">
                            <tr>
                                <th>#</th>
                                <th>Persona</th>
                                <th>Turno</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a = 1;
                            foreach ($turno_4 as $m){
                                ?>
                                <tr>
                                    <td><?= $a;?></td>
                                    <td><?= $m->persona_apellido_paterno?> <?= $m->persona_apellido_materno?> <?= $m->persona_nombre?></td>
                                    <td><?= $m->turno_nombre;?></td>
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

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Recursos Humanos / Asignar Turnos</h1>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h3 class="card-title">Buscar Personal</h3>
                                <div class="col-md-2"></div>
                                <div class="col-md-2">
                                    <button data-toggle="modal" data-target="#turno_1" class="btn btn-success"><i class="fa fa-eye"></i> Ver Turno 1</button>
                                </div>
                                <div class="col-md-2">
                                    <button data-toggle="modal" data-target="#turno_2" class="btn btn-success"><i class="fa fa-eye"></i> Ver Turno 2</button>
                                </div>
                                <div class="col-md-2">
                                    <button data-toggle="modal" data-target="#turno_3" class="btn btn-success"><i class="fa fa-eye"></i> Ver Turno 3</button>
                                </div>
                                <div class="col-md-2">
                                    <button data-toggle="modal" data-target="#turno_4" class="btn btn-success"><i class="fa fa-eye"></i> Ver Turno 4</button>
                                </div>

                            </div>
                        </div>
                        <div class="card-body">
                            <form class="form-row" method="post" action="<?= _SERVER_ . 'RHumanos/asignar_turnos';?>">
                                <div class="form-group col-md-3">
                                    <input required name="parametro" type="text" value="<?= $parametro;?>" class="form-control" id="parametro" placeholder="Nombre, Apellido Paterno o Documento de Identidad">
                                </div>
                                <div class="form-group col-md-2" >
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
                                <div class="tabla-responsive">
                                    <table class="table table-borderless table-striped table-earning" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="text-capitalize">
                                        <tr>
                                            <th>#</th>
                                            <th>Apellidos y Nombres</th>
                                            <th>DNI</th>
                                            <th>Foto</th>
                                            <th>Turno</th>
                                            <th>Acción</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $a = 1;
                                        foreach ($person as $m){
                                            $consultar_turno = $this->humanos->consultar_turno($m->id_persona);

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
                                                <td><?php echo $m->persona_apellido_paterno;?> <?php echo $m->persona_apellido_materno;?>, <?php echo $m->persona_nombre;?></td>
                                                <td><?php echo $m->persona_dni;?></td>
                                                <td><img class="rounded" src="<?= $foto;?>" alt="Foto de <?php echo $m->persona_nombre;?>" width="60"></td>
                                                <td>
                                                    <select class="form-control" name="id_turno<?= $m->id_persona?>" id="id_turno<?= $m->id_persona?>">
                                                        <option value="1" <?= ($consultar_turno->id_turno==1)?'selected':''; ?>>Turno 1</option>
                                                        <option value="2" <?= ($consultar_turno->id_turno==2)?'selected':''; ?>>Turno 2</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <button id="btn-guardar-turno" onclick="guardar_turno<?= $m->id_persona;?>(<?= $m->id_persona?>)" class="btn btn-success"><i class="fa fa-save"></i></button>
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
    <?php
    foreach ($person as $m){
    ?>
    function guardar_turno<?= $m->id_persona?>(id_persona){
        var valor = true;
        var id_turno = $('#id_turno<?= $m->id_persona?>').val();

        if(valor){
            //Cadena donde enviaremos los parametros por POST
            var cadena = "id_persona=" + id_persona +
                        "&id_turno=" + id_turno;
            $.ajax({
                type: "POST",
                url: urlweb + "api/RHumanos/guardar_turno",
                data: cadena,
                dataType: 'json',
                success:function (r) {
                    switch (r.result.code) {
                        case 1:
                            respuesta('¡Turno guardado exitosamente...!', 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                            break;
                        case 2:
                            respuesta('Error al eliminar turno', 'error');
                            break;
                        default:
                            respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                            break;
                    }
                }
            });
        }
    }
    <?php
    }
    ?>
</script>