

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <form method="post" action="<?= _SERVER_ ?>Pedido/historial_delivery_entregados">
                <input type="hidden" id="enviar_fecha" name="enviar_fecha" value="1">
                <div class="row">
                    <div class="col-lg-3">
                        <label for="turno">Seleccionar fecha a Filtrar Inicio:</label>
                        <input type="date" class="form-control" id="fecha_filtro" name="fecha_filtro" value="<?php echo $fecha_filtro;?>">
                    </div>
                    <div class="col-lg-3">
                        <label for="turno">Seleccionar fecha a Filtrar Fin:</label>
                        <input type="date" class="form-control" id="fecha_filtro_fin" name="fecha_filtro_fin" value="<?php echo $fecha_filtro_fin;?>">
                    </div>
                    <div class="col-lg-3">
                        <button style="margin-top: 34px;" class="btn btn-success" ><i class="fa fa-search"></i> Buscar Registro</button>
                    </div>
                </div>
            </form>
            <br>

            <div class="row">
                <!--<div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h2><b>Pedido # <?= $dato_pedido->comanda_correlativo;?></b></h2></div> -->
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha / Hora</th>
                                        <th>Nombre Persona</th>
                                        <th>Direccion</th>
                                        <th>Telefono</th>
                                        <th>Productos</th>
                                        <th>N° Pedido</th>
                                        <th>Total</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($pedidos as $p){
                                        $listar_detalle_comanda = $this->pedido->jalar_valor($p->id_comanda);
                                        $stylee="";
                                        if($p->comanda_estado == 0){
                                            $stylee="style= 'background: #FBF858'";
                                        }elseif($p->comanda_estado == 1){
                                            $stylee="style= 'background: #A0FB95'";
                                        }

                                        ?>
                                        <tr <?= $stylee;?> id="detalle<?= $p->id_comanda_detalle;?>">
                                            <td><?= $a;?></td>
                                            <td><?= date('d-m-Y H:i:s', strtotime($p->comanda_detalle_fecha_registro));?></td>
                                            <td><?= $p->cliente_nombre;?> <?= $p->cliente_apellido_paterno;?></td>
                                            <td><?= $p->comanda_direccion_delivery;?></td>
                                            <td><?= $p->comanda_telefono_delivery;?></td>
                                            <td>
                                                <?php
                                                $jalar_producto = $this->pedido->jalar_producto($p->id_comanda);
                                                if(count($jalar_producto)>0){
                                                    foreach ($jalar_producto as $jp){
                                                        ?>
                                                        - <?= $jp->producto_nombre;?> <b>X</b> <?= $jp->comanda_detalle_cantidad;?>
                                                        <br>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td><?= $p->comanda_correlativo;?></td>
                                            <td><?= $listar_detalle_comanda->total;?></td>
                                            <td>
                                                <?php
                                                //INICIO - OBTENER ID_VENTA PARA VER DETALLE
                                                $venta = $this->pedido->listar_venta_x_comanda($p->id_comanda);
                                                //FIN - OBTENER ID_VENTA PARA VER DETALLE
                                                ?>
                                                <a target="_blank" type="button" class="btn btn-xs btn-primary " href="<?php echo _SERVER_. 'Ventas/ver_detalle_venta/' . $venta->id_venta;?>" ><i class="fa fa-eye"></i></a>
                                                <!--<a type="button" style="color: white;" id="imprimir_ticket" onclick="ticket_venta(<?= $venta->id_venta; ?>)" class="btn btn-xs btn-success "><i class="fa fa-print"></i></a>-->
                                                <?php
                                                if($venta->comanda_estado == 0) {
                                                    ?>
                                                    <a type="button" id="estadito" style="color: white;" class="btn btn-xs btn-success" onclick="preguntar('¿El pedido ya se encuentra listo para la entrega?','cambiar_estado_comanda_delivery','SI','NO',<?= $venta->id_comanda;?>)" ><i class="fa fa-check"></i></a>
                                                    <?php
                                                }
                                                ?>
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
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script>
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

    function cambiar_estado_comanda_delivery(id){
        var boton = 'estadito';
        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/cambiar_estado_comanda_deliver",
            data: "id=" + id,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, '...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-print\"></i>", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Cambiado con exito!...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 400);
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
</script>