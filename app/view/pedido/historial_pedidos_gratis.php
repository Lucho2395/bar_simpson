<?php
/**
 * Created by PhpStorm
 * User: LuisSalazar
 * Date: 26/10/2021
 * Time: 09:14 a. m.
 */
?>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <form method="post" action="<?= _SERVER_ ?>Pedido/historial_pedidos_gratis">
                <input type="hidden" id="enviar_registro" name="enviar_registro" value="1">
                <div class="row">
                    <div class="col-lg-3">
                        <label>Mesa</label>
                        <select  id="id_mesa" name="id_mesa" class="form-control">
                            <option value="">Seleccionar...</option>
                            <?php
                            foreach ($mesas as $m){ ?>
                                <option value="<?= $m->id_mesa; ?>" <?= ($m->id_mesa==$mesa)?'selected':'';?>><?= $m->mesa_nombre; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-2 col-sm-6 col-md-6 col-xs-6">
                        <label for="">Fecha de Inicio</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" value="<?= $fecha_ini; ?>">
                    </div>
                    <div class="col-lg-2 col-sm-6 col-md-6 col-xs-6">
                        <label for="">Fecha Final</label>
                        <input type="date" id="fecha_final" name="fecha_final" class="form-control" value="<?= $fecha_fin; ?>">
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12" style="text-align: center">
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
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-earning" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha de Pedido</th>
                                        <th>Mesa</th>
                                        <th>Cliente</th>
                                        <th>Total</th>
                                        <th>Atendido por</th>

                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    $total = 0;
                                    $total_soles = 0;
                                    foreach ($pedidos as $al){
                                        $stylee="style= 'text-align: center;'";
                                        $detalle_gratis = $this->pedido->listar_pedido_gratis_detalle_x_id($al->id_pedido_gratis);

                                        ?>
                                        <tr <?= $stylee?>>
                                            <td><?= $a;?></td>
                                            <td><?= date('d-m-Y H:i:s', strtotime($al->pedido_gratis_datetime));?></td>
                                            <td><?= $al->mesa_nombre;?></td>
                                            <td>
                                                <?= "$al->pedido_gratis_nombre" ;?><br>
                                                <?= $al->pedido_gratis_numero; ?>
                                            </td>
                                            <td><?= $al->pedido_gratis_total;?></td>

                                            <?php
                                            $atendido_por = $detalle_gratis[0]->persona_nombre . ' ' . $detalle_gratis[0]->persona_apellido_paterno;
                                            ?>
                                            <td><?= $atendido_por;?></td>
                                            <td style="text-align: left">
                                                <a type="button" title="Ver Pedido" class="btn btn-sm btn-primary" style="color: white" href="<?= _SERVER_ . 'index.php?c=Pedido&a=detalle_pedido_ver&id_mesa='. $al->id_mesa . '&id_comanda=' .$detalle_gratis[0]->id_comanda;?>" ><i class="fa fa-eye ver_detalle"></i></a>
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

                    <?php
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>pedido.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var total_rs = <?= $total_soles; ?>;
        $("#total_soles").html("<b>"+total_rs+"</b>");
    });
    function detalle_pedido_ver(id_comanda, id_mesa){
        var cadena = "id_comanda=" + id_comanda + "&id_mesa=" + id_mesa;

        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/detalle_pedido_ver",
            data: cadena,
            dataType: 'json',

        });
    }
</script>
