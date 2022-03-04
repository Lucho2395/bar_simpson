<?php
/**
 * Created by PhpStorm
 * User: LuisSalazar
 * Date: 21/04/2021
 * Time: 10:39 p. m.
 */
?>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Content Header (Page header) -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <!-- Main content -->
            <section class="content" style="background-color: white;box-shadow: 10px 10px 15px #888888;border-radius: 30px; padding: 5px; margin: 10px; margin-top: 20px; min-height: 500px">
                <!-- /.row -->
                <!-- Main row --><br>
                <div class="row" style="margin-top: 8px;">
                    <div class="col-lg-12 col-sm-12 col-md-12" style="text-align: center;">
                        <?php
                        //$id_turn = $this->active->getTurnactive();
                        $idroleUsuario = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
                        if($venta->venta_cancelar == 1){
                            ?>
                            <p style="color: green; "><i class="fa fa-check-circle"></i> Pago Realizado Correctamente</p>
                            <?php
                            $fecha_hoy = date('Y-m-d');
                            $fecha_creacion = date('Y-m-d', strtotime($venta->venta_fecha));
                            /*if ($idroleUsuario == 2 || $idroleUsuario == 3){
                                if($fecha_hoy == $fecha_creacion || $idroleUsuario == 2 || $idroleUsuario == 3){ //si la venta no es del dia actual no se genera la anulacion
                                    $id = $pago->id_pago;
                                    ?>
                                    <a type="button" class="btn btn-xs btn-danger" style="float: right; color: white" onclick="preguntar('¿Está seguro que desea ANULAR esta venta?','anular_venta','Si','No',<?= $id;?>)"><i class="fa fa-times-circle"></i> Anular Venta</a>
                                    <?php
                                }
                            }*/
                        } else {
                            ?>
                            <p style="color: red; float: right;"><i class="fa fa-times-circle"></i> Esta Venta fue ANULADA</p>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-4">
                        <p><i class="fa fa-calendar"></i> Fecha de Pago: <?= date("d-m-Y", strtotime($venta->venta_fecha));?></p>
                        <p><i class="fa fa-user"></i> Nombre Del Cliente:
                            <?php
                            if($venta->id_tipodocumento == 4){
                                echo $venta->cliente_razonsocial;
                            }else{
                                echo $venta->cliente_nombre;
                            }
                            ?>
                        </p>
                    </div>
                    <div class="col-lg-3">
                        <p>Serie y Correlativo: <?= $venta->venta_serie. "-" .$venta->venta_correlativo; ?></p>
                        <p>RUC ó DNI: <?= $venta->cliente_numero;?></p>
                    </div>
                    <div class="col-lg-3">
                        <p><?= $venta->mesa_nombre; ?></p>
                        <p>DIRECCIÓN: <?= $venta->cliente_direccion;?></p>
                    </div>
                    <div class="col-lg-1">
                    </div>
                </div>
                <br>
                <!-- /.row (main row) -->
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <table class="table table-bordered" width="100%" cellspacing="0" style="border-color: black">
                            <thead class="text-capitalize">
                            <tr style="background-color: #ebebeb">
                                <th><strong>Cant</strong></th>
                                <th><strong>Descripción</strong></th>
                                <th><strong>Precio Unitario</strong></th>
                                <th><strong>Total</strong></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $totales = count($detalle_venta);
                            $monto = 0;
                            if($totales == 0){
                                ?>
                                <center><h2>Aún no hay productos</h2></center>
                                <?php
                            } else {
                                foreach ($detalle_venta as $p){
                                    $subtotal = 0;
                                    $subtotal = $p->detalle_pago_total;
                                    $monto = $monto + $subtotal;
                                    ?>
                                    <tr>
                                        <!--<td><?php //echo $p->id_productforsale;?></td>-->
                                        <td><?php echo $p->venta_detalle_cantidad;?></td>
                                        <td><?php echo $p->venta_detalle_nombre_producto;?></td>
                                        <td>S/. <?php echo $p->venta_detalle_valor_unitario;?></td>
                                        <td>S/. <?php echo $p->venta_detalle_valor_total;?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                        <br>
                        <div class="row">
                            <?php
                            if($venta->venta_tipo == "07" || $venta->venta_tipo == "08"){
                                if($venta->venta_tipo == "07"){
                                    $descripcion_nota = $this->ventas->listar_tipo_notaC_x_codigo($venta->venta_codigo_motivo_nota);
                                }else{
                                    $descripcion_nota = $this->ventas->listar_tipo_notaD_x_codigo($venta->venta_codigo_motivo_nota);
                                }
                                if($venta->tipo_documento_modificar == "03"){
                                    $tipo = "BOLETA";
                                }else{
                                    $tipo = "FACTURA";
                                }
                                ?>
                                <div id="espacio" class = "col-lg-6 col-sm-6 col-md-6" style="font-size: 12px;">
                                    <label for="">TIPO DE COMPROBANTE AFECTADA: <span><?= $tipo;?></span></label><br>
                                    <label for="">SERIE AFECTADA: <span><?= $venta->serie_modificar;?></span></span></label><br>
                                    <label for="">CORRELATIVO AFECTADO: <span><?= $venta->correlativo_modificar;?></span></span></label><br>
                                    <label for="">MOTIVO: <span><?= $descripcion_nota->tipo_nota_descripcion;?></span></label>
                                </div>
                                <?php
                            }else{ ?>
                                <div id="espacio" class = "col-lg-6">
                                    <label for=""></label>
                                </div>
                            <?php
                            }
                            ?>

                            <div class="col-lg-3 col-md-4 col-sm-4">
                                <?php
                                if ($venta->venta_totalgratuita > 0){ ?>
                                    <h4>OP. GRATUITA:</h4>
                                <?php
                                }
                                if ($venta->venta_totalinafecta > 0){ ?>
                                    <h4>OP. INAFECTA:</h4>
                                    <?php
                                }
                                if ($venta->venta_totalgravada > 0){ ?>
                                    <h4>OP. GRAVADA:</h4>
                                    <h4>IGV:</h4>
                                    <?php
                                }
                                ?>
                                <h4>OP. EXONERADA:</h4>

                                <?php
                                if ($venta->venta_icbper > 0){ ?>
                                    <h4>ICBPER:</h4>
                                <?php }
                                ?>
                                <h3>PRECIO TOTAL:</h3>
                                <?php
                                if ($venta->venta_pago_cliente > 0){ ?>
                                    <h5>PAGÓ CON:</h5>
                                    <h5>VUELTO:</h5>
                                <?php }
                                ?>
                            </div>

                            <div class="col-lg-3 col-md-4 col-sm-4" style="text-align: left">
                                <?php
                                if ($venta->venta_totalgratuita > 0){ ?>
                                    <h4>S/. <?php echo number_format($venta->venta_totalgratuita ,2);?></h4>
                                    <?php
                                }
                                if ($venta->venta_totalinafecta > 0){ ?>
                                    <h4>S/. <?php echo number_format($venta->venta_totalinafecta ,2);?></h4>
                                    <?php
                                }
                                if ($venta->venta_totalgravada > 0) { ?>
                                    <h4>S/. <?php echo number_format($venta->venta_totalgravada , 2);?></h4>
                                    <h4>S/. <?php echo number_format($venta->venta_totaligv , 2);?></h4>
                                    <?php
                                }?>

                                <h4>S/. <?php echo number_format($venta->venta_totalexonerada ,2);?></h4>

                                <?php
                                if ($venta->venta_icbper > 0){ ?>
                                    <h4>S/. <?php echo number_format($venta->venta_icbper , 2);?></h4>
                                <?php }
                                ?>
                                <h3>S/. <?php echo number_format($venta->venta_total , 2);?></h3>
                                <?php
                                if ($venta->venta_pago_cliente > 0){ ?>
                                    <h5>S/. <?php echo number_format($venta->venta_pago_cliente , 2);?></h5>
                                    <h5>S/. <?php echo number_format($venta->venta_vuelto , 2);?></h5>
                                <?php }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-lg-12 col-sm-12 col-md-12" style="text-align: center;">
                        <a id="imprimir_ticket" style="color: white;" class="btn btn-primary" target="_blank" onclick="ticket_venta(<?= $id; ?>)"><i class="fa fa-print"></i> Imprimir Ticket</a>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
    </div>
</div>
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>venta.js"></script>
<script type="text/javascript">
    function ticket_venta(id){
        var boton = 'imprimir_ticket';
        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/ticket_venta",
            data: "id=" + id,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'imprimiendo...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-print\"></i> Imprimir Ticket", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Éxito!...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 800);
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
</script>
