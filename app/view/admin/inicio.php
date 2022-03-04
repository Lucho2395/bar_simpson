<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 09/03/2021
 * Time: 16:18
 */
?>
<!--CONTENIDO-->
<!-- MAIN CONTENT-->



    <div class="main-content">
        <div class="section__content section__content--p30">
        <?php
        if($role == 2 || $role == 3 || $role == 5){
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Datos de Ventas</h2>
                        </div>
                    </div>
                </div>
                <div class="row m-t-25">
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c1">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-shopping-cart"></i>
                                    </div>
                                    <div class="text">
                                        <h2><?= count($venta_dia);?></h2>
                                        <span>Ventas del Día</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart1"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c2">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-shopping-cart"></i>
                                    </div>
                                    <div class="text">
                                        <h2><?= number_format($total_dia, 2); ?></h2>
                                        <span>Ingresos del Día</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart2"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c3">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-calendar-note"></i>
                                    </div>
                                    <div class="text">
                                        <h2><?= $total_venta_mes;?></h2>
                                        <span>Ventas del Mes</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart3"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c4">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i style="font-size: 25px;">S/.</i>
                                    </div>
                                    <div class="text">
                                        <h2><?= number_format($total_mes, 2);?></h2>
                                        <span>Ingreso del Mes</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart4"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <?php if(!$fecha_open){ ?>
                        <div class="card-header py-3">
                            <h3 style="text-align: center;" class="font-weight-bold">APERTURA DE CAJA - DÍA DE HOY</h3>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-xs-6 col-sm-6 col-md-6">
                                <label>Turno:</label>
                                <select class="form-control" id= "id_turno" name="id_turno">
                                    <?php
                                    foreach($turnos as $l){
                                        ?>
                                        <option value="<?php echo $l->id_turno;?>"><?php echo $l->turno_nombre;?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-6 col-xs-6 col-sm-6 col-md-6">
                                <label>Caja:</label>
                                <select class="form-control" id= "id_caja_numero" name="id_caja_numero">
                                    <?php
                                    foreach($caja as $l){
                                        $fecha = date('Y-m-d');
                                        $buscar_caja = $this->caja->buscar_caja_disponible($l->id_caja_numero);
                                        if(empty($buscar_caja)){

                                            ?>
                                            <option value="<?php echo $l->id_caja_numero;?>"><?php echo $l->caja_numero_nombre;?></option>
                                                <?php

                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-6" style="text-align: center">
                                <label >MONTO APERTURA CAJA - Para HOY <?php echo date('Y-m-d');?></label>
                                <input type="text" class="form-control" id="caja_apertura" name="caja_apertura" onkeyup="validar_numeros_decimales_dos(this.id)" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3"></div>
                            <div class="col-lg-6 col-sm-6 col-md-6" >
                                <button id="btn-agregar-apertura" class="btn btn-primary" style="align-content: center;width: 100%" onclick="apertura()"><i class="fa fa-save fa-sm text-white-50"></i> APERTURAR CAJA</button>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-md-3"></div>
                        </div>
                        <?php
                        } else {
                            $monto_apertura = $this->caja->mostrar_valor_apertura($id_usuario);
                            $valor_por_caja = $this->caja->valor_por_caja($id_usuario);

                                //$nombre = $vc->caja_numero_nombre;
                            $jalar_turno = $this->caja->jalar_turno_($id_usuario);

                            ?>
                            <br>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-5">
                                    <h3>► CAJA :</h3>
                                </div>
                                <div class="col-md-2">
                                    <h3 style=""><?= $valor_por_caja->caja_numero_nombre;?></h3>
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-5">
                                    <h3>► TURNO :</h3>
                                </div>
                                <div class="col-md-2">
                                    <h3 style=""><?= $jalar_turno;?></h3>
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-5">
                                    <h3>► USUARIO :</h3>
                                </div>
                                <div class="col-md-2">
                                    <h3 style=""><?php echo $usuario->usuario_nickname;?></h3>
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-5">
                                    <h3 style="">► El Monto de Apertura para Hoy es :</h3>
                                </div>
                                <div class="col-md-2">
                                    <h3 style=""> S/.<?= $monto_apertura ?? 0?></h3>
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                            <br>
                            <?php
                            $buscar_cierre_caja = $this->caja->buscar_cierre_caja($listar_ultima_caja->id_caja,$id_usuario);
                            if(empty($buscar_cierre_caja)){
                                ?>
                                <div class="row">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-5">
                                        <h3>► Cierre de Caja :</h3>
                                    </div>
                                    <div class="col-lg-2">
                                        <input class="form-control" type="text" id="caja_monto_cierre" name="caja_monto_cierre" onkeyup="validar_numeros_decimales_dos(this.id)">
                                    </div>
                                    <div class="col-lg-4"></div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-12" style="text-align: center">
                                        <button id="btn-agregar-cierre"  class="btn btn-success" onclick="guardar_cierre_caja(<?= $id_usuario;?>)"><i class="fa fa-save"></i> Guardar Cierre</button>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>

                    <div class="col-lg-6" style="text-align: center; padding-bottom:5px; "><h2>Recordatorio de Insumos </h2>
                        <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable2">
                                        <thead class="text-capitalize">
                                        <tr>
                                            <th>Recurso</th>
                                            <th>Stock Actual</th>
                                            <th>Stock Minimo</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $nuevo_valor = 0;
                                        foreach ($recurso_sede as $ar){
                                                $recurso_actual = $ar->recurso_sede_stock;
                                                $recurso_limite = $ar->recurso_sede_stock_minimo;
                                                $nuevo_valor = $recurso_limite + 20;

                                                if($recurso_actual <= $recurso_limite){
                                                    $estilo_ = "style=\"background-color: lightcoral\"";
                                                }else{
                                                    $estilo_ = "style=\"background-color: yellow\"";
                                                }

                                                if($recurso_actual <= $nuevo_valor){

                                                    ?>
                                                    <tr <?= $estilo_;?>>
                                                        <td><?= $ar->recurso_nombre;?></td>
                                                        <td><?= $ar->recurso_sede_stock;?></td>
                                                        <td><?= $ar->recurso_sede_stock_minimo;?></td>
                                                    </tr>
                                                        <?php
                                                }
                                                ?>
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
        <?php
        }else{ ?>
            <div class="container-fluid">
                <div class="row">
                     <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12" style="text-align: center">
                         <h1 style="color: darkred">BIENVENID0(A) AL SISTEMA :</h1>
                         <h1 style="color: darkred"> <?= $usuario->persona_nombre;?> <?= $usuario->persona_apellido_paterno?></h1>
                         <br><br>
                         <h1 style="color: black">Su Rol es : <?=$usuario->rol_nombre?></h1>
                     </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
    <!-- END MAIN CONTENT-->
    <!-- END PAGE CONTAINER-->
<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script>
    function apertura(){
        var valor = true;
        //Extraemos las variable según los valores del campo consultado
        var caja_apertura = $('#caja_apertura').val();
        var id_caja_numero = $('#id_caja_numero').val();
        var id_turno = $('#id_turno').val();

        //Validamos si los campos a usar no se encuentran vacios
        valor = validar_campo_vacio('caja_apertura', caja_apertura, valor);
        valor = validar_campo_vacio('id_caja_numero', id_caja_numero, valor);
        valor = validar_campo_vacio('id_turno', id_turno, valor);

        if(valor){
            //Definimos el mensaje y boton a afectar
            var boton = "btn-agregar-apertura";
            //Cadena donde enviaremos los parametros por POST
            var cadena = "caja_apertura=" + caja_apertura +
                "&id_caja_numero=" + id_caja_numero +
                "&id_turno=" + id_turno;
            $.ajax({
                type: "POST",
                url: urlweb + "api/Admin/guardar_apertura_caja",
                data: cadena,
                dataType: 'json',
                beforeSend: function () {
                    cambiar_estado_boton(boton, "Guardando...", true);
                },
                success:function (r) {
                    cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i>  Aperturar Caja", false);
                    switch (r.result.code) {
                        case 1:
                            respuesta('¡Ingreso de Apertura Exitoso!', 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                            break;
                        case 2:
                            respuesta('Error al ingresar la apertura de la caja', 'error');
                            break;
                        default:
                            respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                            break;
                    }
                }
            });
        }
    }

    function guardar_cierre_caja(id){
        var valor = true;
        var caja_monto_cierre = $('#caja_monto_cierre').val();

        valor = validar_campo_vacio('caja_monto_cierre', caja_monto_cierre, valor);
        if(valor){
            //Definimos el mensaje y boton a afectar
            var boton = "btn-agregar-cierre";
            //Cadena donde enviaremos los parametros por POST
            var cadena = "caja_monto_cierre=" + caja_monto_cierre +
                "&id_usuario=" + id;
            $.ajax({
                type: "POST",
                url: urlweb + "api/Admin/guardar_cierre_caja",
                data: cadena,
                dataType: 'json',
                beforeSend: function () {
                    cambiar_estado_boton(boton, "Guardando...", true);
                },
                success:function (r) {
                    cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar Cierre", false);
                    switch (r.result.code) {
                        case 1:
                            respuesta('¡Cierre de caja Exitoso!', 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                            break;
                        case 2:
                            respuesta('Error al guardar, comuniquese con BufeoTec Company', 'error');
                            break;
                        default:
                            respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                            break;
                    }
                }
            });
        }
    }
</script>