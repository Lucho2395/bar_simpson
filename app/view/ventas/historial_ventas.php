<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <form method="post" action="<?= _SERVER_ ?>Ventas/historial_ventas">
                <input type="hidden" id="enviar_registro" name="enviar_registro" value="1">
                <div class="row">
                    <div class="col-lg-3">
                        <label>Tipo de Venta</label>
                        <select  id="tipo_venta" name="tipo_venta" class="form-control">
                            <option <?= ($tipo_venta == "")?'selected':''; ?> value="">Seleccionar...</option>
                            <option <?= ($tipo_venta == "03")?'selected':''; ?> value="03">BOLETA</option>
                            <option <?= ($tipo_venta == "01")?'selected':''; ?> value="01">FACTURA</option>
                            <option <?= ($tipo_venta == "07")?'selected':''; ?> value= "07">NOTA DE CRÉDITO</option>
                            <option <?= ($tipo_venta == "08")?'selected':''; ?> value= "08">NOTA DE DÉBITO</option>
                        </select>
                    </div>
                    <!--<div class="col-lg-3">
                        <label>Estado de Comprobante</label>
                        <select  id="estado_cpe" name="estado_cpe" class="form-control">
                            <option <?= ($estado_cpe == "")?'selected':''; ?> value="">Seleccionar...</option>
                            <option <?= ($estado_cpe == "0")?'selected':''; ?> value="0">Sin Enviar</option>
                            <option <?= ($estado_cpe == "1")?'selected':''; ?> value="1">Enviado Sunat</option>
                        </select>
                    </div>-->
                    <div class="col-lg-2 col-sm-6 col-md-6">
                        <label for="">Fecha de Inicio</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" value="<?= $fecha_ini; ?>">
                    </div>
                    <div class="col-lg-2 col-sm-6 col-md-6">
                        <label for="">Fecha Final</label>
                        <input type="date" id="fecha_final" name="fecha_final" class="form-control" value="<?= $fecha_fin; ?>">
                    </div>
                    <div class="col-lg-2 col-sm-12 col-md-12" style="text-align: center">
                        <button style="margin-top: 34px;" class="btn btn-success" ><i class="fa fa-search"></i> Buscar Registro</button>
                    </div>
                    <div class="col-lg-3">
                    </div>
                    <div class="col-lg-12" >

                        <label for="" style="margin-top: 20px;color: black;">COMPROBANTES SIN ENVIAR: <span style="color: red;"><?= count($ventas_cant);?></span><br>
                            <span style="font-size: 12px;">* ENVIAR MÁXIMO 3 DIAS DESPUES LA FECHA DE EMISIÓN</span></label>

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
                        <div class="card-header py-3">
                            <h5>TIPO COMPROBANTE: <span class='text-uppercase font-weight-bold'>
                                    <?php
                                    if($tipo_venta == "03"){
                                        echo "BOLETA";
                                    }elseif($tipo_venta == "01"){
                                        echo "FACTURA";
                                    }elseif($tipo_venta == "07"){
                                        echo "NOTA DE CRÉDITO";
                                    }elseif($tipo_venta == "08"){
                                        echo "NOTA DE DÉBITO";
                                    }else{
                                        echo 'TODOS';
                                    }
                                    ?></span>
                                | FECHA DEL: <span><?= (($fecha_ini != ""))?date('d-m-Y', strtotime($fecha_ini)):'--'; ?></span> AL <span><?= (($fecha_fin != ""))?date('d-m-Y', strtotime($fecha_fin)):'--'; ?></span>
                                | Total SOLES: <span id="total_soles"></span>
                            </h5>
                        </div>
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
                                        <th>Forma de Pago</th>
                                        <th>Total</th>
                                        <th>PDF</th>
                                        <th>Estado Sunat</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    $total = 0;
                                    $total_soles = 0;
                                    foreach ($ventas as $al){
                                        $stylee="style= 'text-align: center;'";
                                        if ($al->anulado_sunat == 1){
                                            $stylee="style= 'text-align: center; text-decoration: line-through'";
                                        }

                                        if($al->venta_tipo == "03"){
                                            $tipo_comprobante = "BOLETA";
                                            if($al->anulado_sunat == 0){
                                                $total_soles = round($total_soles + $al->venta_total, 2);
                                            }
                                        }elseif ($al->venta_tipo == "01"){
                                            $tipo_comprobante = "FACTURA";
                                            if($al->anulado_sunat == 0){
                                                $total_soles = round($total_soles + $al->venta_total, 2);
                                            }
                                        }elseif($al->venta_tipo == "07"){
                                            $tipo_comprobante = "NOTA DE CRÉDITO";
                                            /*if(($al->anulado_sunat == 0 AND $al->venta_codigo_motivo_nota != "01")){
                                                $total_soles = round($total_soles - $al->venta_total, 2);
                                            }*/
                                        }elseif($al->venta_tipo == "08"){
                                            $tipo_comprobante = "NOTA DE DÉBITO";
                                            if($al->anulado_sunat == 0){
                                                $total_soles = round($total_soles + $al->venta_total, 2);
                                            }
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
                                            <td><?= $al->tipo_pago_nombre;?></td>
                                            <td>
                                                <?= $al->simbolo.' '.$al->venta_total;?>
                                            </td>
                                            <td><center><a type="button" target='_blank' href="<?= _SERVER_ . 'Ventas/imprimir_ticket_pdf/' . $al->id_venta ;?>" style="color: red" ><i class="fa fa-file-pdf-o"></i></a></center></td>

                                            <td <?= $estilo_mensaje;?>><?= $mensaje;?></td>
                                            <td style="text-align: left">
                                                <a target="_blank" type="button" title="Ver detalle" class="btn btn-sm btn-primary" style="color: white" href="<?php echo _SERVER_. 'Ventas/ver_detalle_venta/' . $al->id_venta;?>" ><i class="fa fa-eye ver_detalle"></i></a>
                                                <a type="button" title="Enviar Correo" data-toggle="modal" data-target="#enviar_correo_al_cliente" onclick="poner_id_venta(<?= $al->id_venta ;?>);" class="btn btn-sm btn-success" style="color: white"  ><i class="fa fa-envelope-o ver_detalle"></i></a>
                                                <?php
                                                if($al->anulado_sunat == "0" && ($al->venta_tipo_envio == "0" || $al->venta_tipo_envio == "1") && $al->venta_tipo != '03'){ ?>
                                                    <a id="btn_enviar<?= $al->id_venta;?>" type="button" title="Enviar a Sunat" class="btn btn-sm btn-success btne" style="color: white" onclick="preguntar('¿Está seguro que desea enviar a la Sunat este Comprobante?','enviar_comprobante_sunat','Si','No',<?= $al->id_venta;?>)"><i class="fa fa-check margen"></i></a>
                                                    <?php
                                                }
                                                if($al->venta_tipo == "03" and $al->anulado_sunat == "0"){
                                                ?>
                                                    <a target="_blank" type="button" id="btn_anular_anular<?= $al->id_venta;?>" class="btn btn-sm btn-danger btne" style="color: white" onclick="preguntar('¿Está seguro que desea anular este Comprobante?','anular_boleta_cambiarestado','Si','No',<?= $al->id_venta;?>, '1')" ><i class="fa fa-ban"></i></a>
                                                <?php
                                                }else{
                                                    if($al->anulado_sunat == "1"){ ?>
                                                        <h5 style="color: red">ANULADO, ir a resumen diario para enviar a sunat</h5>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $a++;
                                        $total = $total + $al->venta_total;
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

<div class="modal fade" id="enviar_correo_al_cliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Enviar Comprobante al Correo</h4>
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>-->
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <input type="hidden" id="id_venta_cliente" value=""  readonly>
                        <input class="form-control" type="text" id="correo_del_cliente" name="correo_del_cliente">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div id="realizar_impugnacion">
                    <a onclick="enviar_email_cliente()" style="color: white;" class="btn btn-primary" id="guardar_envio_mensajito" >Guardar</a>
                    <a class="btn btn-danger" style="color: white;" data-dismiss="modal" id="cancelar_envio_mensajito" >Cerrar</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>venta.js"></script>
<script>
    $(document).ready(function(){
        var total_rs = <?= $total_soles; ?>;
        $("#total_soles").html("<b>"+total_rs+"</b>");
    });
</script>