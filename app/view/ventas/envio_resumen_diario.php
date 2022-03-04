<?php
/**
 * Created by PhpStorm
 * User: LuisSalazar
 * Date: 26/04/2021
 * Time: 10:37 a. m.
 */
?>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <form method="post" action="<?= _SERVER_ ?>Ventas/envio_resumenes_diario">
                <input type="hidden" id="enviar_registro" name="enviar_registro" value="1">
                <div class="row">
                    <!--<div class="col-lg-3">
                        <label>Tipo de Venta</label>
                        <select  id="tipo_venta" name="tipo_venta" class="form-control">
                            <option <?= ($tipo_venta == "")?'selected':''; ?> value="">Seleccionar...</option>
                            <option <?= ($tipo_venta == "03")?'selected':''; ?> value="03">BOLETA</option>
                            <option <?= ($tipo_venta == "01")?'selected':''; ?> value="01">FACTURA</option>
                            <option <?= ($tipo_venta == "07")?'selected':''; ?> value= "07">NOTA DE CRÉDITO</option>
                            <option <?= ($tipo_venta == "08")?'selected':''; ?> value= "08">NOTA DE DÉBITO</option>
                        </select>
                    </div>-->
                    <!--<div class="col-lg-3">
                        <label>Estado de Comprobante</label>
                        <select  id="estado_cpe" name="estado_cpe" class="form-control">
                            <option <?= ($estado_cpe == "")?'selected':''; ?> value="">Seleccionar...</option>
                            <option <?= ($estado_cpe == "0")?'selected':''; ?> value="0">Sin Enviar</option>
                            <option <?= ($estado_cpe == "1")?'selected':''; ?> value="1">Enviado Sunat</option>
                        </select>
                    </div>-->
                    <div class="col-lg-3">
                        <label for="">Fecha de Inicio</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" value="<?= $fecha_ini; ?>">
                    </div>
                    <!--<div class="col-lg-2">
                        <label for="">Fecha Final</label>
                        <input type="date" id="fecha_final" name="fecha_final" class="form-control" value="<?= $fecha_fin; ?>">
                    </div>-->
                    <div class="col-lg-2">
                        <button style="margin-top: 34px;" class="btn btn-success" ><i class="fa fa-search"></i> Buscar Registro</button>
                    </div>
                </div>
            </form>
            <br>
            <div class="row">
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
                                            <th>Fecha de Emision</th>
                                            <th>Comprobante</th>
                                            <th>Serie y Correlativo</th>
                                            <th>Cliente</th>
                                            <th>Total</th>
                                            <th>Estado</th>
                                            <th>Acción</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $a = 1;
                                        $total = 0;
                                        foreach ($ventas as $al){
                                            $stylee="style= 'text-align: center;'";
                                            if ($al->anulado_sunat == 1){
                                                $stylee="style= 'text-align: center; text-decoration: line-through'";
                                            }
                                            if($al->venta_tipo == "03"){
                                                $tipo_comprobante = "BOLETA";
                                            }elseif ($al->venta_tipo == "01"){
                                                $tipo_comprobante = "FACTURA";
                                            }elseif($al->venta_tipo == "07"){
                                                $tipo_comprobante = "NOTA DE CRÉDITO";
                                            }elseif($al->venta_tipo == "08"){
                                                $tipo_comprobante = "NOTA DE DÉBITO";
                                            }else{
                                                $tipo_comprobante = "--";
                                            }
                                            $estilo_mensaje = "style= 'color: red; font-size: 14px;'";
                                            if($al->venta_respuesta_sunat == NULL){
                                                $mensaje = "Sin Enviar a Sunat";

                                            }else{
                                                $mensaje = $al->venta_respuesta_sunat;
                                            }
                                            if($al->id_tipodocumento == 4){
                                                $cliente = $al->cliente_razonsocial;
                                            }else{
                                                $cliente = $al->cliente_nombre;
                                            }
                                            ?>
                                            <tr <?= $stylee?>>
                                                <td><?= $a;?></td>
                                                <td><?= date('d-m-Y H:i:s', strtotime($al->venta_fecha));?></td>
                                                <td><?= $tipo_comprobante;?></td>
                                                <td><?= $al->venta_serie. '-' .$al->venta_correlativo;?></td>
                                                <td>
                                                    <?= $al->cliente_numero;?><br>
                                                    <?= $cliente;?>
                                                </td>
                                                <td><?= $al->simbolo.' '.$al->venta_total;?></td>
                                                <td <?= $estilo_mensaje;?>><?= $mensaje;?></td>
                                                <td>
                                                    <a target="_blank" type="button" class="btn btn-sm btn-primary btne" title="Ver detalle" href="<?php echo _SERVER_. 'Ventas/ver_detalle_venta/' . $al->id_venta;?>" ><i class="fa fa-eye ver_detalle"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                            $a++;
                                            $total = $total + $al->pago_total;
                                        }
                                        ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12" style="text-align: right;">
                                        <input type="hidden" id="fecha_post" name="fecha_post" value="<?= $_POST['fecha_inicio']?>">
                                        <a type="button" style="margin-top: 10px; color: white;" id="boton_enviar_resumen" class="btn btn-xs btn-success btne" onclick="preguntar('¿Está seguro que desea enviar a la Sunat este Comprobante?','crear_enviar_resumen_sunat','Si','No')">Enviar Resumen Diario</a>

                                    </div>
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
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>venta.js"></script>
