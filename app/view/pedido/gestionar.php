
<div class="modal fade" id="reservas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 70% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reservar Mesa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div id="reservar">
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="">Mesa</label>
                                <input type="hidden" id="id_reserva" name="id_reserva">
                                <select class="form-control" id="id_mesa" name="id_mesa">
                                    <option value="">Seleccione Mesa</option>
                                    <?php
                                    foreach($mesas_ as $m){
                                        ?>
                                        <option value="<?php echo $m->id_mesa;?>"><?php echo $m->mesa_nombre;?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-8 col-xs-8 col-md-8 col-sm-8">
                                <label class="col-form-label">Nombre:</label>
                                <input type="text" class="form-control" id="reserva_nombre" name="reserva_nombre" placeholder="Ingrese Nombre...">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-xs-3 col-md-3 col-sm-3">
                                <label for="">Cantidad Personas</label>
                                <input type="number" id="reserva_cantidad" name="reserva_cantidad" class="form-control" value="1">
                            </div>
                            <div class="col-lg-3 col-xs-3 col-md-3 col-sm-3">
                                <label for="">Fecha Reserva</label>
                                <input type="date" class="form-control" id="reserva_fecha" name="reserva_fecha">
                            </div>
                            <div class="col-lg-3 col-xs-3 col-md-3 col-sm-3">
                                <label for="">Hora Reserva</label>
                                <input type="time" class="form-control" id="reserva_hora" name="reserva_hora">
                            </div>
                            <div class="col-lg-3 col-xs-3 col-sm-3 col-md-3">
                                <label for="">N° Contacto</label>
                                <input type="text" class="form-control" onkeyup="validar_numeros(this.id)" id="reserva_contacto" name="reserva_contacto" placeholder="Ingrese Numero...">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12" style="text-align: center; padding-bottom:5px; "><h4>Reservas Diarias</h4></div>
                            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                                <!-- DataTales Example -->
                                <div class="card shadow mb-4">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="text-capitalize">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Mesa</th>
                                                    <th>Nombre Reserva</th>
                                                    <th>N° Contacto</th>
                                                    <th>Cantidad</th>
                                                    <th>Fecha / Hora</th>
                                                    <th>Acción</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $a = 1;
                                                foreach ($reservas as $m){
                                                    ?>
                                                    <tr>
                                                        <td><?= $a;?></td>
                                                        <td><?= $m->mesa_nombre;?></td>
                                                        <td><?= $m->reserva_nombre;?></td>
                                                        <td><?= $m->reserva_contacto;?></td>
                                                        <td><?= $m->reserva_cantidad?></td>
                                                        <td><?= $m->reserva_fecha?> <?= $m->reserva_hora?></td>
                                                        <td>
                                                            <a onclick="preguntar('¿Esta Seguro que desea Eliminar esta reserva?','eliminar_reserva','SÍ','NO',<?= $m->id_reserva?>,<?= $m->id_mesa?>)" style="color: red" data-toggle='tooltip' title='Eliminar'><i class='fa fa-times eliminar margen'></i></a>
                                                            <a onclick="activar_edicion(<?php echo $m->id_reserva;?>,'<?php echo $m->id_mesa; ?>','<?php echo $m->reserva_nombre; ?>','<?php echo $m->reserva_cantidad; ?>','<?php echo $m->reserva_fecha; ?>','<?php echo $m->reserva_hora; ?>','<?php echo $m->reserva_contacto; ?>')" style="color: green" data-toggle='tooltip' title='Editar'><i class="fa fa-pencil"></i></a>
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
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="btn-agregar-reserva" onclick="guardar_reservas()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ocultar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 40% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reservar Mesa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div id="reservar">
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="">Mesa</label>
                                <input type="hidden" id="id_reserva" name="id_reserva">
                                <select class="form-control" id="id_mesa_oc" name="id_mesa_oc">
                                    <option value="">Seleccione Mesa</option>
                                    <?php
                                    foreach($mesas_junte as $m){
                                        ?>
                                        <option value="<?php echo $m->id_mesa;?>"><?php echo $m->mesa_nombre;?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="">Estado</label>
                                <select class="form-control" name="estado" id="estado">
                                    <option value="0">Deshabilitar</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12" style="text-align: center; padding-bottom:5px; "><h4>Mesas Ocultas</h4></div>
                            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                                <!-- DataTales Example -->
                                <div class="card shadow mb-4">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="text-capitalize">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Mesa</th>
                                                    <th>Acción</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $a = 1;
                                                foreach ($ocultas as $m){
                                                    ?>
                                                    <tr>
                                                        <td><?= $a;?></td>
                                                        <td><?= $m->mesa_nombre;?></td>
                                                        <td>
                                                            <a onclick="preguntar('¿Desea volver a mostrar esta mesa?','mostrar_mesa','SÍ','NO',<?= $m->id_mesa?>)" style="color:green" data-toggle='tooltip' title='Mostar'><i class='fa fa-check eliminar margen'></i></a>
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
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="btn-agregar-cambio" onclick="guardar_cambio()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
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
                <div class="row">
                    <div class="col-lg-2 col-xs-3 col-md-3 col-sm-3">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#reservas" ><i class="fa fa-calendar"></i> Reservar Mesa</button>
                    </div>
                    <div class="col-lg-2 col-xs-3 col-md-3 col-sm-3">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#ocultar"><i class="fa fa-history"></i> Ocultar Mesa</button>
                    </div>
                </div>
                <br>
                <div class="row">
                    <?php
                    foreach ($mesas as $m){
                        if($m->id_mesa == 0){
                            ?>
                            <div class="col-md-3 col-sm-3 col-xs-3">
                                <a style="background: green;margin: 1px;border-radius: 20px;padding: 60px 10px 60px 10px;text-align: center;width: 100%" class="text-white" href="<?php echo _SERVER_ . 'Pedido/delivery';?>"><?= $m->mesa_nombre;?></a>
                            </div>
                            <?php
                        }else{
                        if($m->mesa_estado_atencion == 0){
                            $fecha = date('Y-m-d');
                            $hora = date('H:i:s');
                            $buscar_reservas = $this->pedido->buscar_datos_reserva($m->id_mesa,$fecha);
                            if($buscar_reservas && $hora <= $buscar_reservas->reserva_hora){
                                $actualizar_mesa = $this->pedido->cambiar_estado_mesa_reserva($buscar_reservas->id_mesa);
                                echo "<script>
                                       location.reload();
                                      </script>";
                            }
                            ?>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                <a style="background: green;margin: 1px;border-radius: 20px;padding: 60px 10px 60px 10px;text-align: center;width: 100%" class="text-white" href="<?php echo _SERVER_ . 'Pedido/asignar/' . $m->id_mesa;?>"><?= $m->mesa_nombre;?>
                                </a>
                            </div>
                            <?php
                        }elseif($m->mesa_estado_atencion == 1){
                            $fecha = date('Y-m-d');
                            $buscar_reservas = $this->pedido->buscar_datos_reserva($m->id_mesa,$fecha);
                            if(!empty($buscar_reservas)){
                                $actualizar_mesa = $this->pedido->cambiar_estado_mesa_reserva($buscar_reservas->id_mesa);
                                ?>
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <a style="background: dodgerblue;margin: 1px;border-radius: 20px;padding: 18px 10px 18px 10px;text-align: center;width: 100%" class="text-white" href="<?php echo _SERVER_ . 'Pedido/detalle_pedido/' . $m->id_mesa;?>" ><?= $m->mesa_nombre;?> / RESERVADO
                                        <p>Por <?= $buscar_reservas->reserva_nombre?> / Cant. <?= $buscar_reservas->reserva_cantidad?> Pers.</p>
                                        <p>Dia: <?= $buscar_reservas->reserva_fecha?> / Hora: <?= $buscar_reservas->reserva_hora?></p>
                                    </a>
                                </div>
                                <?php
                            }else{
                                ?>
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <a style="background:  #f4b619;margin: 1px;border-radius: 20px;padding: 60px 10px 60px 10px;text-align: center;width: 100%" class="text-white" href="<?php echo _SERVER_ . 'Pedido/detalle_pedido/' . $m->id_mesa;?>"><?= $m->mesa_nombre;?></a>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                        }elseif($m->mesa_estado_atencion == 5){
                            $fecha = date('Y-m-d');
                            $buscar_reservas = $this->pedido->buscar_datos_reserva($m->id_mesa,$fecha);
                            if($buscar_reservas->reserva_contacto == NULL){
                                $numero = "--";
                            }else{
                                $numero = $buscar_reservas->reserva_contacto;
                            }
                            ?>
                            <div class="col-md-3 col-sm-3 col-xs-3">
                                <a style="background: dodgerblue;margin: 1px;border-radius: 20px;padding: 18px 10px 18px 10px;text-align: center;width: 100%" class="text-white" href="<?php echo _SERVER_ . 'Pedido/asignar/' . $m->id_mesa;?>" ><?= $m->mesa_nombre;?> / RESERVADO
                                    <p>Por <?= $buscar_reservas->reserva_nombre?> / Cant. <?= $buscar_reservas->reserva_cantidad?> Pers.</p>
                                    <p>Dia: <?= $buscar_reservas->reserva_fecha?> / Hora: <?= $buscar_reservas->reserva_hora?></p>
                                    <p>N° : <?=$numero ?></p>
                                </a>
                            </div>
                            <?php
                        }else{
                            ?>
                            <div class="col-md-3 col-sm-3 col-xs-3">
                                <a style="background: red;margin: 1px;border-radius: 20px;padding: 60px 10px 60px 10px;text-align: center;width: 100%" class="text-white"  onclick="preguntar('¿La mesa se encuentra lista para ser usada?','habilitar_mesa','SI','NO',<?= $m->id_mesa?>,0)"><?= $m->mesa_nombre;?></a>
                            </div>
                                <?php
                            }
                        }
                        ?>
                    <?php
                    }
                    ?>
                </div>
                <br>
                <p style="border-bottom: 3px solid black"></p>
                <br>
                <div class="row">
                    <?php
                    foreach ($mesas_tg as $m){
                    if($m->mesa_estado_atencion == 0){
                        ?>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <a style="background: green;margin: 1px;border-radius: 20px;padding: 40px 10px 40px 10px;text-align: center;width: 100%" class="text-white" href="<?php echo _SERVER_ . 'Pedido/asignar/' . $m->id_mesa;?>"><?= $m->mesa_nombre;?></a>
                    </div>
                    <?php
                        }else if($m->mesa_estado_atencion == 1){
                        ?>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <a style="background: #f4b619;margin: 1px;border-radius: 20px;padding: 40px 10px 40px 10px;text-align: center;width: 100%" class="text-white" href="<?php echo _SERVER_ . 'Pedido/detalle_pedido/' . $m->id_mesa;?>" ><?= $m->mesa_nombre;?>
                            </a>
                        </div>
                    <?php
                        }else{
                        ?>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <a style="background: red;margin: 1px;border-radius: 20px;padding: 40px 10px 40px 10px;text-align: center;width: 100%" class="text-white"  onclick="preguntar('¿La mesa se encuentra lista para ser usada?','habilitar_mesa','SI','NO',<?= $m->id_mesa?>,0)"><?= $m->mesa_nombre;?></a>
                        </div>
                    <?php
                    }
                    }
                    ?>
               </div>
        </div>
    </div>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>pedido.js"></script>
<script>
    function habilitar_mesa(id_mesa,estado){
        var valor = true;
        if(valor){
            var cadena = "id_mesa=" + id_mesa +
                "&estado=" + estado;
            $.ajax({
                type: "POST",
                url: urlweb + "api/Pedido/habilitar_mesa",
                data: cadena,
                dataType: 'json',
                success: function (r) {
                    switch (r.result.code) {
                        case 1:
                            respuesta('¡Mesa lista para atención!', 'success');
                            setTimeout(function () {
                                location.reload()
                            }, 400);
                            break;
                        case 2:
                            respuesta('Error, comuniquese con BufeoTec', 'error');
                            break;
                        default:
                            respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                            break;
                    }
                }
            });
        }
    }

    function reserva_completa(id_mesa,estado){
        var valor = true;
        if(valor){
            var cadena = "id_mesa=" + id_mesa +
                "&estado=" + estado;
            $.ajax({
                type: "POST",
                url: urlweb + "api/Pedido/habilitar_reserva",
                data: cadena,
                dataType: 'json',
                success: function (r) {
                    switch (r.result.code) {
                        case 1:
                            respuesta('¡Mesa completada y Habilitada!', 'success');
                            setTimeout(function () {
                                location.reload()
                            }, 400);
                            break;
                        case 2:
                            respuesta('Error al habilitar, comuniquese con BufeoTec', 'error');
                            break;
                        default:
                            respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                            break;
                    }
                }
            });
        }
    }

    function activar_edicion(id_reserva, id_mesa, reserva_nombre, reserva_cantidad, reserva_fecha, reserva_hora, reserva_contacto){
        $("#id_reserva").val(id_reserva);

        $("#id_mesa option[value="+ id_mesa +"]").attr("selected",true);

        $("#reserva_nombre").val(reserva_nombre);
        $("#reserva_cantidad").val(reserva_cantidad);
        $("#reserva_fecha").val(reserva_fecha);
        $("#reserva_hora").val(reserva_hora);
        $("#reserva_contacto").val(reserva_contacto);

    }


    function actualizar(){
        location.reload();
    }
    //Función para actualizar cada 90 segundos(60000 milisegundos)
    setInterval(actualizar, 90000);
</script>