<?php
/**
 * Created by PhpStorm
 * User: LuisSalazar
 * Date: 29/04/2021
 * Time: 11:45 a. m.
 */
?>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <form method="post" action="<?= _SERVER_ ?>Ventas/historial_resumen_diario">
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
                                                <th>Estado XML</th>
                                                <th>CDR</th>
                                                <th>Estado Sunat</th>
                                                <th>Acción</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $a = 1;
                                            $total = 0;
                                            foreach ($resumen as $al){
                                                $stylee="style= 'text-align: center;'";

                                                $estilo_mensaje = "style= 'color: red; font-size: 14px;'";
                                                if($al->envio_resumen_estadosunat == NULL){
                                                    $mensaje = "Sin Enviar a Sunat";
                                                }else{
                                                    $mensaje = $al->envio_resumen_estadosunat;
                                                    $estilo_mensaje = "style= 'color: green; font-size: 14px;'";
                                                }
                                                if($al->envio_resumen_estadosunat_consulta == NULL){
                                                    $mensaje_consulta = "";
                                                }else{
                                                    $mensaje_consulta = $al->envio_resumen_estadosunat_consulta;
                                                    $estilo_mensaje_consulta = "style= 'color: green; font-size: 14px;'";
                                                }
                                                ?>
                                                <tr <?= $stylee?>>
                                                    <td><?= $a;?></td>
                                                    <td><?= date('d-m-Y H:i:s', strtotime($al->envio_sunat_datetime));?></td>
                                                    <td><?= date('d-m-Y', strtotime($al->envio_resumen_fecha));?></td>
                                                    <td><?= $al->envio_resumen_serie. '-' .$al->envio_resumen_correlativo;?></td>
                                                    <?php
                                                    if(file_exists($al->envio_resumen_nombreXML)){ ?>
                                                        <td><center><a type="button" target='_blank' href="<?= _SERVER_.$al->envio_resumen_nombreXML;?>" style="color: blue" ><i class="fa fa-file-text"></i></a></center></td>
                                                        <?php
                                                    }else{ ?>
                                                        <td>--</td>
                                                    <?php
                                                    }
                                                    ?>
                                                    <td <?= $estilo_mensaje;?>><?= $mensaje;?></td>
                                                    <?php
                                                    if(file_exists($al->envio_resumen_nombreCDR)){ ?>
                                                        <td><center><a type="button" target='_blank' href="<?= _SERVER_.$al->envio_resumen_nombreCDR;?>" style="color: green" ><i class="fa fa-file"></i></a></center></td>
                                                        <?php
                                                    }else{ ?>
                                                        <td>--</td>
                                                        <?php
                                                    }
                                                    ?>
                                                    <td <?= $estilo_mensaje_consulta;?>><?= $mensaje_consulta;?></td>
                                                    <td>
                                                        <a id="btn_consultar<?= $al->id_envio_resumen;?>" type="button" title="Consultar Resumen Diario" class="btn btn-sm btn-success btne" style="color: white" onclick="preguntar('¿Está seguro que desea enviar Consultar este Resumen Diario?','consultar_ticket_resumen','Si','No',<?= $al->id_envio_resumen;?>)"><i class="fa fa-cloud-download"></i></a>
                                                        <a target="_blank" type="button" title="Ver Comprobates" class="btn btn-sm btn-primary btne" href="<?php echo _SERVER_. 'Ventas/ver_detalle_resumen/' . $al->id_envio_resumen;?>" ><i class="fa fa-eye ver_detalle"></i></a>
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
<script>
    function consultar_ticket_resumen(id_resumen_diario){
        var cadena = "id_resumen_diario=" + id_resumen_diario;
        var boton = 'btn_consultar'+id_resumen_diario;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Ventas/consultar_ticket_resumen",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'enviando...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i style=\"font-size: 16pt;\" class=\"fa fa-check margen\"></i>", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡CDR descargado con Éxito!', 'success');
                        setTimeout(function () {
                            location.reload();
                            //location.href = urlweb +  'Pedido/gestionar';
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al Consultar', 'error');
                        setTimeout(function () {
                            location.reload();
                            //location.href = urlweb +  'Pedido/gestionar';
                        }, 1000);
                        break;
                    case 3:
                        respuesta('Error, Sunat rechazó el comprobante', 'error');
                        setTimeout(function () {
                            location.reload();
                            //location.href = urlweb +  'Pedido/gestionar';
                        }, 1000);
                        break;
                    case 4:
                        respuesta('Error de comunicacion con Sunat', 'error');
                        setTimeout(function () {
                            location.reload();
                            //location.href = urlweb +  'Pedido/gestionar';
                        }, 1000);
                        break;
                    case 5:
                        respuesta('Error al guardar en base de datos', 'error');
                        setTimeout(function () {
                            location.reload();
                            //location.href = urlweb +  'Pedido/gestionar';
                        }, 1000);
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        setTimeout(function () {
                            location.reload();
                            //location.href = urlweb +  'Pedido/gestionar';
                        }, 1000);
                        break;
                }
            }

        });
    }
</script>