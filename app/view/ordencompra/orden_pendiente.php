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
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h4 class="m-0 font-weight-bold text-success">Listado de Solicitudes de Compra Pendientes</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-earning" id="dataTable1" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>#</th>
                                        <th>Sucursal</th>
                                        <th>Fecha de Solicitud</th>
                                        <th>Concepto de la Solicitud</th>
                                        <th>Proveedor</th>
                                        <th>Solicitante</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($orden as $m){
                                        ?>
                                        <tr>
                                            <td><?php echo $a;?></td>
                                            <td><?php echo $m->sucursal_nombre;?></td>
                                            <td><?php echo date("d-m-Y",strtotime($m->orden_compra_fecha));?></td>
                                            <td><?php echo $m->orden_compra_titulo;?></td>
                                            <td><?php echo $m->proveedor_nombre;?></td>
                                            <td><?php echo $m->persona_nombre;?> <?php echo $m->persona_apellido_paterno;?></td>
                                            <td>
                                                <a data-toggle="tooltip" title="Ver detalles" href="<?= _SERVER_ ?>Ordencompra/detalle_orden_compra/<?= $m->id_orden_compra; ?>" type="button" class="text-dark" ><i class="fa fa-eye ver_detalle"></i></a>

                                                <a onclick="preguntar('¿Está seguro que desea eliminar esta orden de compra?','eliminar_orden','Si','No',<?= $m->id_orden_compra;?>)" id="btn_deshabilitar" data-toggle="tooltip" title='Eliminar'><i class="fa fa-times text-danger eliminar margen"></i></a>
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
<script>

    function eliminar_orden(id_orden_compra){
        var cadena = "id_orden_compra=" + id_orden_compra;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Ordencompra/eliminar_orden",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                $("#aprobar").html("Cargando...");
            },
            success: function (r) {
                $("#aprobar").html("Aprobar");
                switch (r.result.code) {
                    case 1:
                        respuesta("¡Eliminado con Exito!",'success');
                        setTimeout(function () {
                            location.href = urlweb +  'Ordencompra/orden_pendiente';
                        }, 500);
                        break;
                    case 2:
                        respuesta('Error al eliminar registro', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
</script>
