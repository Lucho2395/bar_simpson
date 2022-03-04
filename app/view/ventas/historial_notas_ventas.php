<?php
/**
 * Created by PhpStorm
 * User: LuisSalazar
 * Date: 13/08/2021
 * Time: 04:11 p. m.
 */
?>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <form method="post" action="<?= _SERVER_ ?>Ventas/historial_notas_ventas">
                <input type="hidden" id="enviar_registro" name="enviar_registro" value="1">
                <div class="row">

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
                                        echo 'NOTA DE VENTA';

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
                                        <th>Vendido por</th>
                                        <th>Comprobante</th>
                                        <th>Serie y Correlativo</th>
                                        <th>Cliente</th>
                                        <th>Forma de Pago</th>
                                        <th>Total</th>
                                        <th>PDF</th>
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
                                        }else{
                                            $total = $total + $al->venta_total;
                                        }

                                        $tipo_comprobante = "NOTA DE VENTA";

                                        if($al->id_tipodocumento == 4){
                                            $cliente = $al->cliente_razonsocial;
                                        }else{
                                            $cliente = $al->cliente_nombre;
                                        }

                                        ?>
                                        <tr <?= $stylee?>>
                                            <td><?= $a;?></td>
                                            <td><?= date('d-m-Y H:i:s', strtotime($al->venta_fecha));?></td>
                                            <td><?= ($al->id_mesa !="-2")?'RESTAURANT':'MARKET';?></td>
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

                                            <td style="text-align: left">
                                                <a target="_blank" type="button" title="Ver detalle" class="btn btn-sm btn-primary" style="color: white" href="<?php echo _SERVER_. 'Ventas/ver_detalle_venta/' . $al->id_venta;?>" ><i class="fa fa-eye ver_detalle"></i></a>
                                                <?php
                                                $hoy = date('Y-m-d');
                                                $fecha_venta = date('Y-m-d', strtotime($al->venta_fecha));
                                                if($fecha_venta == $hoy ){
                                                    if($al->id_mesa != "-2"){ ?>
                                                        <a  type="button" title="Editar Nota de Venta" class="btn btn-sm btn-success" style="color: white" href="<?php echo _SERVER_. 'Ventas/editar_nota_venta/' . $al->id_venta;?>" ><i class="fa fa-edit ver_editar"></i></a>
                                                        <?php
                                                    }/*else{*/?><!--
                                                        <a target="_blank" type="button" title="Editar Nota de Venta por pedido" class="btn btn-sm btn-success" style="color: white" href="<?php /*echo _SERVER_. 'Ventas/editar_nota_venta_x_comanda/' . $al->id_venta;*/?>" ><i class="fa fa-edit ver_editar"></i></a>
                                                    --><?php
/*                                                    }*/
                                                    ?>
                                                    <?php
                                                }
                                                ?>
                                                <a target="_blank" type="button" title="Anular" id="btn_anular<?= $al->id_venta;?>" class="btn btn-sm btn-danger btne" style="color: white" onclick="preguntar('¿Está seguro que desea anular este Comprobante?','anular_boleta_cambiarestado','Si','No',<?= $al->id_venta;?>, '1')" ><i class="fa fa-ban"></i></a>

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
                    <?php
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>venta.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var total_rs = <?= $total; ?>;
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
