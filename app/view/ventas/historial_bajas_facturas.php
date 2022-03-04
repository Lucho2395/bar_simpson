<?php
/**
 * Created by PhpStorm
 * User: LuisSalazar
 * Date: 06/05/2021
 * Time: 01:19 p. m.
 */
?>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <form method="post" action="<?= _SERVER_ ?>Ventas/historial_bajas_facturas">
                <input type="hidden" id="enviar_registro" name="enviar_registro" value="1">
                <div class="row">
                    <!--<div class="col-lg-3">
                        <label>Estado de Comprobante</label>
                        <select  id="estado_cpe" name="estado_cpe" class="form-control">
                            <option <?= ($estado_cpe == "")?'selected':''; ?> value="">Seleccionar...</option>
                            <option <?= ($estado_cpe == "0")?'selected':''; ?> value="0">Sin Enviar</option>
                            <option <?= ($estado_cpe == "1")?'selected':''; ?> value="1">Enviado Sunat</option>
                        </select>
                    </div>-->
                    <div class="col-lg-2">
                        <label for="">Fecha de Inicio</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" value="<?= $fecha_ini; ?>">
                    </div>
                    <div class="col-lg-2">
                        <label for="">Fecha Final</label>
                        <input type="date" id="fecha_final" name="fecha_final" class="form-control" value="<?= $fecha_fin; ?>">
                    </div>
                    <div class="col-lg-2">
                        <button style="margin-top: 34px;" class="btn btn-success" ><i class="fa fa-search"></i> Buscar Registro</button>
                    </div>
                </div>
            </form>
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <?php
                            if($filtro) {
                                ?>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">
                                            <thead class="text-capitalize">
                                            <tr>
                                                <th>#</th>
                                                <th>Fecha de Emisión</th>
                                                <th>Fecha de Comprobantes</th>
                                                <th>Serie Y Correlativo</th>
                                                <th>XML</th>
                                                <th>CDR</th>
                                                <th>Estado Sunat</th>
                                                <th>Datos del Comprobante Anulado</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $a = 1;
                                            $total = 0;
                                            foreach ($bajas as $al){
                                                $stylee="style= 'text-align: center;'";

                                                if($al->venta_anulado_estado_sunat == NULL){
                                                    $mensaje_consulta = "";
                                                }else{
                                                    $mensaje_consulta = $al->venta_anulado_estado_sunat;
                                                    $estilo_mensaje_consulta = "style= 'color: green; font-size: 14px;'";
                                                }
                                                ?>
                                                <tr <?= $stylee?>>
                                                    <td><?= $a;?></td>
                                                    <td><?= date('d-m-Y H:i:s', strtotime($al->venta_anulado_datetime));?></td>
                                                    <td><?= date('d-m-Y', strtotime($al->venta_anulado_fecha));?></td>
                                                    <td><?= $al->venta_anulado_serie. '-' .$al->venta_anulado_correlativo;?></td>
                                                    <?php
                                                    if(file_exists($al->venta_anulado_rutaXML)){ ?>
                                                        <td><center><a type="button" target='_blank' href="<?= _SERVER_.$al->venta_anulado_rutaXML;?>" style="color: blue" ><i class="fa fa-file-text"></i></a></center></td>
                                                        <?php
                                                    }else{ ?>
                                                        <td>--</td>
                                                        <?php
                                                    }
                                                    if(file_exists($al->venta_anulado_rutaCDR)){ ?>
                                                        <td><center><a type="button" target='_blank' href="<?= _SERVER_.$al->venta_anulado_rutaCDR;?>" style="color: green" ><i class="fa fa-file"></i></a></center></td>
                                                        <?php
                                                    }else{ ?>
                                                        <td>--</td>
                                                        <?php
                                                    }
                                                    ?>
                                                    <td <?= $estilo_mensaje_consulta;?>><?= $mensaje_consulta;?></td>
                                                    <td>
                                                        <a target="_blank" type="button" href="<?php echo _SERVER_. 'Ventas/ver_detalle_venta/' . $al->id_venta;?>"><?= $al->venta_serie.'-'.$al->venta_correlativo;?></a>
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
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>venta.js"></script>
