<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-primary">Conversiones</h4>
                </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-5">
                                <label for="">Recurso</label>
                                <select class="form-control" onchange="jalar_recursos()" name="id_recurso_sede" id="id_recurso_sede">
                                    <option value="">Seleccionar Recurso</option>
                                    <?php
                                    foreach($recurso_sede as $rs){
                                        ?>
                                        <option value="<?php echo $rs->id_recurso_sede;?>"><?php echo $rs->recurso_nombre;?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-form-label">Categoria</label>
                                    <div id="datos_recurso"></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-form-label">Precio</label>
                                    <div id="datos_precio"></div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="">Nueva Unidad de Medida</label>
                                <select class="form-control" onchange="convertir()" name="conversion_unidad_medida" id="conversion_unidad_medida">
                                    <option value="">Seleccionar Unidad</option>
                                    <?php
                                    foreach($medida as $m){
                                        ?>
                                        <option value="<?php echo $m->id_medida;?>"><?php echo $m->medida_nombre;?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="">Cantidad Convertida</label>
                                <input class="form-control" type="text" id="conversion_cantidad" name="conversion_cantidad">
                            </div>
                            <div class="col-lg-3" style="margin-top: 35px">
                                <button class="btn btn-success" onclick="guardar_nueva_conversion()"><i class="fa fa-save"></i> Guardar</button>
                            </div>
                            <br>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-striped table-earning" id="" width="100%" cellspacing="0">
                                        <thead class="text-capitalize">
                                        <tr>
                                            <th>ID</th>
                                            <th>Recurso</th>
                                            <th>Cantidad</th>
                                            <th>Unidad Medida</th>
                                            <th>Accion</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $a = 1;
                                        foreach ($conversiones as $m){
                                            ?>
                                            <tr>
                                                <td><?= $a;?></td>
                                                <td><?= $m->recurso_nombre?></td>
                                                <td><?= $m->conversion_cantidad?></td>
                                                <td><?= $m->medida_nombre?></td>
                                                <td>
                                                    <a class="btn btn-danger" onclick="preguntar('¿Esta seguro de eliminar esta conversión?','eliminar_conversion','SI','NO',<?= $m->id_conversion;?>)" title='Eliminar'><i class='fa fa-trash text-white eliminar margen'></i></a>
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

<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>conversion.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $("#id_recurso_sede").select2();
    });
</script>