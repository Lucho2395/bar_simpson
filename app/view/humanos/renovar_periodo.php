<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Recursos Humanos / Renovar Periodo</h1>
            </div>


            <div class="box box-primary">
                <div class="box-header with-border">
                    <h5 class="card-title"><strong>Datos: </strong><?php echo $person->persona_apellido_paterno; ?> <?php echo $person->persona_apellido_materno; ?>, <?php echo $person->persona_nombre; ?> | <?php echo $person->persona_tipo_documento; ?>: <?php echo $person->persona_dni; ?></h5>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header" style="font-size: 20px; font-weight: bold;">
                                    Datos Ubicación
                                </div>
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Seleccionar Empresa</label>
                                        <select class="form-control" name="id_empresa" id="id_empresa" style="height: 44px; font-size: 12px;" required>
                                            <option value="">Seleccionar ...</option>
                                            <?php
                                            foreach ($empresas as $em){
                                                ?>
                                                <option value="<?= $em->id_empresa;?>" <?php echo ($em->id_empresa == $periodo->id_empresa) ? 'selected' : '';?>><?= $em->empresa_razon_social;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Seleccionar Área</label>
                                        <select class="form-control" onchange="cambiaCargo()" name="id_departamento" id="id_departamento" style="height: 44px; font-size: 12px;" required>
                                            <option value="">Seleccionar ...</option>
                                            <?php
                                            foreach ($departamentos as $d){
                                                ?>
                                                <option value="<?= $d->id_departamento;?>" <?php echo ($d->id_departamento == $periodo->id_departamento) ? 'selected' : '';?>><?= $d->departamento_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Seleccionar Cargo</label>
                                        <select class="form-control" name="id_cargo" id="id_cargo" style="height: 44px; font-size: 12px;" required>
                                            <option value="">Seleccionar ...</option>
                                            <?php
                                            foreach ($cargos as $cg){
                                                if($cg->id_departamento == $periodo->id_departamento){
                                                    ?>
                                                    <option value="<?= $cg->id_cargo;?>" <?php echo ($cg->id_cargo == $periodo->id_cargo) ? 'selected' : '';?> ><?= $cg->cargo_nombre;?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Centro Laboral</label>
                                        <select class="form-control" name="id_sede" id="id_sede" style="height: 44px; font-size: 12px;" required>
                                            <option value="">Seleccionar ...</option>
                                            <?php
                                            foreach ($sedes as $s){
                                                ?>
                                                <option value="<?= $s->id_sede;?>" <?php echo ($s->id_sede == $periodo->id_sede) ? 'selected' : '';?>><?= $s->sede_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header" style="font-size: 20px; font-weight: bold;">
                                    Periodo Laboral
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Tipo de Contratación</label>
                                        <select class="form-control" name="id_contrato" id="id_contrato" onchange="cambiaCargo()" style="height: 45px; font-size: 12px;" required>
                                            <option value="">Seleccionar ...</option>
                                            <?php
                                            foreach ($contratos as $con){
                                                ?>
                                                <option value="<?= $con->id_contrato;?>" <?php echo ($con->id_contrato == $periodo->id_contrato) ? 'selected' : '';?>><?= $con->contrato_nombre;?></option>
                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="form-row ml-1 mr-1">
                                        <div class="form-group col-md-6">
                                            <label for="">Desde</label>
                                            <input type="date" class="form-control" placeholder="" name="periodo_fechainicio" id="periodo_fechainicio" value="<?= date('Y-m-d',strtotime($periodo->periodo_fechafin . "+ 1 days"))?>" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Hasta</label>
                                            <input type="date" class="form-control" placeholder="" name="periodo_fechafin" id="periodo_fechafin" value="" required>
                                        </div>

                                    </div>

                                    <div class="form-row ml-1 mr-1">
                                        <div class="form-group col-md-4">
                                            <label for="">Monto Mensual</label>
                                            <input type="number" step="0.01" class="form-control" onchange="total_ingresos()" value="<?= $periodo->periodo_sueldo;?>" id="periodo_sueldo" placeholder="" name="periodo_sueldo" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Otros Ingresos</label>
                                            <input type="number" step="0.01" class="form-control" onchange="total_ingresos()" value="<?= $periodo->periodo_movilidad;?>" id="periodo_movilidad" placeholder="" name="periodo_movilidad" >
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="">Total Mensual</label>
                                            <input type="number"  class="form-control" id="periodo_total" value="<?= $periodo->periodo_total;?>" placeholder="" name="periodo_total" readonly>
                                            <input type="hidden"  class="form-control" id="periodo_bono" value="<?= $periodo->periodo_bono;?>" placeholder="" name="periodo_bono" readonly>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <button class="btn btn-primary" id="btn-periodo" onclick="guardar_periodo(<?= $id?>, 1);">Confirmar</button>
                        <a class="btn btn-danger" href="<?= _SERVER_ ?>RHumanos/detalle_periodo_laboral/<?= $id;?>" role="button">Cancelar</a>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>

        </div>
    </div>
</div>

<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>humanos.js"></script>


<script>
    function total_ingresos() {
        var periodo_sueldo = $('#periodo_sueldo').val();
        var periodo_movilidad = $('#periodo_movilidad').val();
        total = parseFloat(periodo_movilidad) + parseFloat(periodo_sueldo);
        $('#periodo_total').val(total);
    }

</script>