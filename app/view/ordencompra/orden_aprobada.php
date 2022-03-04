<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
            </div>
            <!-- /.row (main row) -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <input required name="parametro" type="text" value="<?= $parametro;?>" class="form-control" id="parametro" placeholder="Buscar Orden Compra">
                                </div>
                                <div></div>
                                <div class="form-group col-lg-3">
                                    <button type="submit" onkeyup="buscar()" class="btn btn-success" style="width: 80%"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                            <br>
                            <?php
                            if($datos){
                            ?>
                                <div class="table-responsive">
                                <table class="table table-borderless table-striped table-earning" id="dataTable2" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>#</th>
                                        <th>Numero</th>
                                        <th>Concepto de la Solicitud</th>
                                        <th>Proveedor</th>
                                        <th>Recursos</th>
                                        <th>Solicitante</th>
                                        <th>Sucursal</th>
                                        <th>Fecha de Solicitud</th>
                                        <th>Acción</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($orden_aprobada as $m){
                                        ?>
                                        <tr>
                                            <td><?php echo $a;?></td>
                                            <td><?php echo $m->orden_compra_numero;?></td>
                                            <td><?php echo $m->orden_compra_titulo;?></td>
                                            <td><?php echo $m->proveedor_nombre;?></td>
                                            <td>
                                            <?php
                                            $jalar_insumos = $this->ordencompra->insumos_en_oc($m->id_orden_compra);
                                            if(count($jalar_insumos)>0){
                                                foreach ($jalar_insumos as $jp){
                                                    ?>
                                                    - <?= $jp->recurso_nombre;?> <!--<?= $jp->detalle_compra_cantidad;?>-->
                                                    <br>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            </td>
                                            <td><?php echo $m->persona_nombre;?> <?php echo $m->persona_apellido_paterno;?></td>
                                            <td><?php echo $m->sucursal_nombre;?></td>
                                            <td><?php echo date("d-m-Y",strtotime($m->orden_compra_fecha));?></td>
                                            <td>
                                                <a data-toggle="tooltip" title="Ver detalles" href="<?= _SERVER_ ?>Ordencompra/detalle_orden_compra/<?= $m->id_orden_compra; ?>" type="button" class="text-dark" ><i class="fa fa-eye ver_detalle"></i></a>
                                                <?php
                                                if($m->orden_compra_usuario_recibido == 0){
                                                    ?>
                                                    <a data-toggle="tooltip" title="Recepcionar Orden" href="<?= _SERVER_ ?>Ordencompra/recepcion_orden/<?= $m->id_orden_compra; ?>" type="button" class="text-dark" ><i class="fa fa-exclamation-triangle ver_detalle" style="color: green;"></i></a>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <a data-toggle="tooltip" title="Orden Recepcionada con exito" type="button" class="text-dark" ><i class="fa fa-check ver_detalle" style="color: green;"></i></a>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $a++;
                                    }
                                    $a = 1;
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>orden_compra.js"></script>

<script>
    function buscar(){
        var param2 = $("#parametro").val();
        var param = param2.replace(/ /g,'020');
        location.href=urlweb+"Ordencompra/orden_aprobada/"+param;
    }

    $(document).ready(function (){
        $('#parametro').keypress(function(e){
            if(e.which === 13){
                buscar();
            }
        });
    });
</script>