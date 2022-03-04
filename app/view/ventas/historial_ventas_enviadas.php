<?php
/**
 * Created by PhpStorm
 * User: LuisSalazar
 * Date: 25/04/2021
 * Time: 12:36 a. m.
 */
?>
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Consultar Comprobante de Pago Electrónico</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

            </div>
            <br>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <label>Tipo de Venta</label>
                            <select id="type_comprobante" class="form-control" >
                                <option value="03">BOLETA</option>
                                <option value="01">FACTURA</option>
                                <option value= "07">NOTA DE CRÉDITO</option>
                                <option value= "08">NOTA DE DÉBITO</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="comprobante_serie">Serie:</label>
                            <input class="form-control" type="text" id="comprobante_serie" ">
                        </div>
                        <div class="col-lg-3">
                            <label for="comprobante_numero">Numero:</label>
                            <input class="form-control" type="text" id="comprobante_numero" ">
                        </div>
                        <br>
                        <div class="col-lg-2">
                            <a class="btn btn-success" style="margin-top: 37px; color: white;" type="button" id="btn_buscar_comprobante" onclick="buscar_comprobante()" ><i class="fa fa-search"></i> Buscar</a>
                        </div>

                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <h4>RESULTADO:</h4><br>
                            <p id="resultado_consulta"></p>
                        </div>

                </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <form method="post" action="<?= _SERVER_ ?>Ventas/historial_ventas_enviadas">
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
                    <!--<div class="col-lg-3" style="text-align: right;">
                        <a class="btn btn-primary" style="margin-top: 34px; color: white;" type="button"  data-toggle="modal" data-target="#basicModal"><i class="fa fa-search"></i> Consutar CPE</a>
                    </div>-->
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
                                            <th>Tipo de Envío</th>
                                            <th>Comprobante</th>
                                            <th>Serie y Correlativo</th>
                                            <th>Cliente</th>
                                            <th>Forma de Pago</th>
                                            <th>Total</th>
                                            <th>PDF</th>
                                            <th>XML</th>
                                            <th>CDR</th>
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
                                                $stylee="style= 'text-align: center; background: #F98892'";
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
                                            if($al->venta_tipo_envio == 1){
                                                $tipo_envio = "DIRECTO";
                                            }else{
                                                $resumen = $this->ventas->listar_resumen_diario_x_id_venta($al->id_venta);
                                                $tipo_envio = "<a type=\"button\" target='_blank' href="._SERVER_.'Ventas/ver_detalle_resumen/'.$resumen->id_envio_resumen.">RESUMEN DIARIO</a>";
                                                //$tipo_envio = "RESUMEN DIARIO";
                                            }
                                            $estilo_mensaje = "";
                                            if($al->venta_estado_sunat == 1){
                                                if($al->venta_respuesta_sunat != ""){
                                                    $mensaje = $al->venta_respuesta_sunat;
                                                }else{
                                                    $mensaje = 'Aceptado por Resumen Diario';
                                                }

                                                $estilo_mensaje = "style= 'color: green; font-size: 14px;'";
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
                                                <td><?= $tipo_envio;?></td>
                                                <td><?= $tipo_comprobante;?></td>
                                                <td><?= $al->venta_serie. '-' .$al->venta_correlativo;?></td>
                                                <td>
                                                    <?= $al->cliente_numero;?><br>
                                                    <?= $cliente;?>
                                                </td>
                                                <td><?= $al->tipo_pago_nombre;?></td>
                                                <td>
                                                    <?= $al->simbolo;?>
                                                    <?= $al->venta_total;?>
                                                </td>
                                                <td><center><a type="button" target='_blank' href="<?= _SERVER_ . 'Ventas/imprimir_ticket_pdf/' . $al->id_venta ;?>" style="color: red" ><i class="fa fa-file-pdf-o"></i></a></center></td>
                                                <?php
                                                if($al->venta_tipo_envio == 1){?>
                                                    <td><center><a type="button" target='_blank' href="<?= _SERVER_.$al->venta_rutaXML;?>" style="color: blue;" ><i class="fa fa-file-text"></i></a></center></td>
                                                    <td><center><a type="button" target='_blank' href="<?= _SERVER_.$al->venta_rutaCDR;?>" style="color: green" ><i class="fa fa-file"></i></a></center></td>

                                                    <?php
                                                }else{ ?>
                                                    <td>--</td>
                                                    <td>--</td>
                                                <?php
                                                }
                                                ?>

                                                <td <?= $estilo_mensaje;?>><?= $mensaje;?></td>
                                                <td style="text-align: left">
                                                    <a target="_blank" type="button" title="Ver detalle" class="btn btn-sm btn-primary" style="color: white" href="<?php echo _SERVER_. 'Ventas/ver_detalle_venta/' . $al->id_venta;?>" ><i class="fa fa-eye ver_detalle"></i></a>
                                                    <a type="button" title="Enviar Correo" data-toggle="modal" data-target="#enviar_correo_al_cliente" onclick="poner_id_venta(<?= $al->id_venta ;?>);" class="btn btn-sm btn-success" style="color: white"  ><i class="fa fa-envelope-o ver_detalle"></i></a>
                                                    <?php

                                                    if($al->anulado_sunat == 0){
                                                        $date2 = new DateTime(date('Y-m-d H:i:s'));
                                                        $date1 = new DateTime($al->venta_fecha_envio);
                                                        $diff = $date2->diff($date1);
                                                        $dias= $diff->days;
                                                        if($dias <= 3){
                                                            if($al->venta_tipo != "03"){
                                                                if($al->tipo_documento_modificar != ""){
                                                                    if($al->tipo_documento_modificar == "01"){
                                                                        ?>
                                                                        <a target="_blank" type="button" title="Anular" id="btn_anular<?= $al->id_venta;?>" class="btn btn-sm btn-danger btne" style="color: white" onclick="preguntar('¿Está seguro que desea anular este Comprobante?','comunicacion_baja','Si','No',<?= $al->id_venta;?>)" ><i class="fa fa-ban"></i></a>
                                                                        <?php
                                                                    }
                                                                }else{
                                                                    ?>
                                                                    <a target="_blank" type="button" title="Anular" id="btn_anular<?= $al->id_venta;?>" class="btn btn-sm btn-danger btne" style="color: white" onclick="preguntar('¿Está seguro que desea anular este Comprobante?','comunicacion_baja','Si','No',<?= $al->id_venta;?>)" ><i class="fa fa-ban"></i></a>
                                                                    <?php
                                                                }
                                                            }
                                                            else{
                                                                if($al->venta_tipo_envio == "2"){
                                                                    ?>
                                                                    <a target="_blank" type="button" title="Anular" id="btn_anular<?= $al->id_venta;?>" class="btn btn-sm btn-danger btne" style="color: white" onclick="preguntar('¿Está seguro que desea anular este Comprobante?','anular_boleta_cambiarestado','Si','No',<?= $al->id_venta;?>, '3')" ><i class="fa fa-ban"></i></a>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                    }

                                                    if($al->anulado_sunat == 0 && ($al->venta_tipo == '01' || $al->venta_tipo == '03')){
                                                    ?>
                                                    <a type="button" style="color: white" class="btn btn-sm btn-success btne" title="GENERAR NOTA" href="<?= _SERVER_ ?>Ventas/generar_nota/<?= $al->id_venta; ?>" target="_blank" ><i class="fa fa-clipboard"></i></a>
                                                    <?php
                                                    } ?>
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
                    </div>
                    <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <a id="btnExportar" href="<?= _SERVER_ ; ?>index.php?c=Ventas&a=excel_ventas_enviadas&tipo_venta=<?= $_POST['tipo_venta']?>&fecha_inicio=<?= $_POST['fecha_inicio']?>&fecha_final=<?= $_POST['fecha_final']?>" target="_blank" class="btn btn-success" style="width: 100%"><i class="fa fa-download"></i> Generar Excel</a>
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
                        <input class="form-control" type="text" id="correo_del_cliente" name="correo_del_cliente"   >
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
<script type="text/javascript">
    $(document).ready(function(){
        var total_rs = <?= $total_soles; ?>;
        $("#total_soles").html("<b>"+total_rs+"</b>");
    });
    function buscar_comprobante(){
        var tipo_comprobate = $('#type_comprobante').val();
        var comprobante_serie = $('#comprobante_serie').val();
        var comprobante_numero = $('#comprobante_numero').val();
        var cadena = "tipo_comprobate=" + tipo_comprobate +
                     "&comprobante_serie=" + comprobante_serie+
                    "&comprobante_numero=" + comprobante_numero;
        var boton = "btn_buscar_comprobante";

        $.ajax({
            type: "POST",
            url: urlweb + "api/Ventas/consultar_comprobante",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Consultando...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class='fa fa-search'></i> Buscar", false);
                $("#resultado_consulta").html(r);
            }

        });
    }
</script>
