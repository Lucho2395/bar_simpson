



<div class="modal fade" id="agregar_pedido_nuevo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 70% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="" enctype="multipart/form-data" id="guardar_pedido_nuevo">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="form-group col-lg-9">
                                <input autocomplete="off" name="parametro" onkeyup="productos_nuevo()" type="text" value="<?= $parametro;?>" class="form-control" id="parametro" placeholder="Buscar Productos">
                            </div>
                            <div class="form-group col-lg-3" style="display: none">
                                <button type="submit" class="btn btn-success" style="width: 80%"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                        <div class="row">
                            <div id="producto_nuevo" class="table-responsive">
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-6 col-md-6 col-xs-6">
                            <div id="ver_seleccion">
                                <label>Precio por Producto <span id ="producto_nombre_"></span><!-- : <span id ="comanda_detalle_precio_"></span>--></label>
                            </div>
                        </div>

                        <div id="mostrar">
                            <div class="row">
                                <div class="col-lg-2  col-sm-6 col-md-6 col-xs-6">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="id_producto" name="id_producto">
                                        <input type="hidden" class="form-control" id="id_comanda" name="id_comanda" value="<?= $id;?>">
                                        <input type="hidden" class="form-control" id="producto_nombre" name="producto_nombre">
                                        <!--<input type="hidden" class="form-control" id="comanda_detalle_precio" name="comanda_detalle_precio">-->
                                        <input type="hidden" class="form-control" id="comanda_detalle_total" name="comanda_detalle_total">
                                        <input type="hidden" class="form-control" id="id_mesa" name="id_mesa" value="<?= $id_mesa;?>">
                                        <input type="hidden" id="contenido_pedido" name="contenido_pedido">
                                        <label class="col-form-label">Cantidad</label>
                                        <input type="number" value="1" class="form-control" id="comanda_detalle_cantidad" name="comanda_detalle_cantidad">
                                    </div>
                                </div>
                                <div class="col-lg-2  col-sm-6 col-md-6 col-xs-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Tipo Entrega</label>
                                        <select class="form-control" id= "comanda_detalle_despacho" name="comanda_detalle_despacho">
                                            <!--<option value="Salon">Salon</option>-->
                                            <option value="Para llevar">Para llevar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-md-6 col-xs-6">
                                    <label for="">Precio</label>
                                    <input type="text" class="form-control" id="comanda_detalle_precio" name="comanda_detalle_precio">
                                </div>
                                <div class="col-lg-4 col-sm-8 col-md-8 col-xs-8">
                                    <div class="form-group">
                                        <label class="col-form-label">Observacion</label>
                                        <textarea rows="3" class="form-control" type="text" id="comanda_detalle_observacion" name="comanda_detalle_observacion" maxlength="200" placeholder="Ingrese Alguna Observacion...">-</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-3 col-md-3 col-xs-3">
                                    <a style="margin-top: 50px; color: white" class='btn btn-primary' data-toggle='modal' onclick='add_pedido_nuevo()' data-target='#asignar_pedido'><i class='fa fa-check'></i> Agregar</a>
                                </div>
                                <div class="container-fluid">
                                    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                                        <div class="table-responsive">
                                            <table id="" class="table table-bordered" style="background: antiquewhite;">
                                                <thead>
                                                <tr style="font-weight: bold;text-align: center">
                                                    <td>PRODUCTO</td>
                                                    <td>PU</td>
                                                    <td>CANT</td>
                                                    <td>ENTR</td>
                                                    <td>OBS</td>
                                                    <td>TOTAL</td>
                                                    <td>ACCIÓN</td>
                                                </tr>
                                                </thead>
                                                <tbody id="contenido_detalle_compra">
                                                </tbody>
                                                <!--<tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>-->
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td><span id="comanda_total_">S/ 0.00</span></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-guardar_nuevo"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="ventas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 80% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generar Venta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div id="persona">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label><b>Productos :</b></label>
                                    <hr>
                                    <div class="row">
                                        <?php
                                        foreach($venta_productos as $ls){
                                            if($ls->comanda_detalle_estado_venta == 0){
                                                //$tipo_afectacion = $this->pedido->tipo_afectacion_x_producto
                                                ?>
                                                <div class="col-md-12" style="font-weight: bold;">
                                                    <input  type="checkbox" onchange="calcular_total(<?= $ls->id_comanda_detalle;?>)" id="id_comanda_detalle_<?= $ls->id_comanda_detalle;?>" name="id_comanda_detalle_<?= $ls->id_comanda_detalle;?>" value="<?= $ls->id_comanda_detalle;?>">
                                                    <label for="id_comanda_detalle_<?= $ls->id_comanda_detalle;?>"> <?php echo $ls->producto_nombre;?> // S/.<?php echo $ls->comanda_detalle_precio;?> // Cant. <?php echo $ls->comanda_detalle_cantidad?> // Total: <?php echo $ls->comanda_detalle_total;?> // Para: <?php echo $ls->comanda_detalle_despacho;?></label>
                                                    <input type="hidden" id="precio_total_detalle<?= $ls->id_comanda_detalle;?>" name="precio_total_detalle<?= $ls->id_comanda_detalle;?>" value="<?= $ls->comanda_detalle_total;?>">
                                                    <input type="hidden" id="tipo_afectacion_producto<?= $ls->id_comanda_detalle;?>" name="tipo_afectacion_producto<?= $ls->id_comanda_detalle;?>" value="<?= $ls->producto_precio_codigoafectacion;?>">
                                                    <input type="hidden" id="producto_precio_venta<?= $ls->id_comanda_detalle;?>" name="producto_precio_venta<?= $ls->id_comanda_detalle;?>" value="<?= $ls->comanda_detalle_precio;?>">
                                                    <input type="hidden" id="comanda_detalle_cantidad<?= $ls->id_comanda_detalle;?>" name="comanda_detalle_cantidad<?= $ls->id_comanda_detalle;?>" value="<?= $ls->comanda_detalle_cantidad;?>">
                                                    <input type="hidden" id="id_receta<?= $ls->id_comanda_detalle;?>" name="id_receta<?= $ls->id_comanda_detalle;?>" value="<?= $ls->id_receta;?>">
                                                </div>
                                                <?php
                                            }else{
                                                ?>
                                                <div class="col-md-12" style="color: lightgray">
                                                    <input type="checkbox" disabled  id="id_comanda_detalle_<?= $ls->id_comanda_detalle;?>">
                                                    <label for="id_comanda_detalle_<?= $ls->id_comanda_detalle;?>"> <?php echo $ls->producto_nombre;?> // S/.<?php echo $ls->comanda_detalle_precio;?> // Cant. <?php echo $ls->comanda_detalle_cantidad?> // Total: <?php echo $ls->comanda_detalle_total;?> // Para: <?php echo $ls->comanda_detalle_despacho;?></label>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-8" style="text-align: right">
                                                    <label for="" style="font-size: 14px;">OP. GRAVADAS</label><br>
                                                    <label for="" style="font-size: 14px;">IGV(18%)</label><br>
                                                    <label for="" style="font-size: 14px;">OP. EXONERADAS</label><br>
                                                    <label for="" style="font-size: 14px;">OP. INAFECTAS</label><br>
                                                    <label for="" style="font-size: 14px;">OP. GRATUITAS</label><br>
                                                    <label for="" style="font-size: 14px;">ICBPER</label><br>
                                                    <label for="" style="font-size: 17px;"><strong>TOTAL</strong></label><br>
                                                    <label for="" style="font-size: 14px;">VUELTO</label>
                                                </div>
                                                <div class="col-lg-2" style="text-align: right">
                                                    <label for="" style="font-size: 14px;"><span id="op_gravadas">0.00</span></label><br>
                                                    <input type="hidden" id="op_gravadas_" name="op_gravadas_">
                                                    <label for="" style="font-size: 14px;"><span id="igv">0.00</span></label><br>
                                                    <input type="hidden" id="igv_" name="igv_">
                                                    <label for="" style="font-size: 14px;"><span id="op_exoneradas">0.00</span></label><br>
                                                    <input type="hidden" id="op_exoneradas_" name="op_exoneradas_">
                                                    <label for="" style="font-size: 14px;"><span id="op_inafectas">0.00</span></label><br>
                                                    <input type="hidden" id="op_inafectas_" name="op_inafectas_">
                                                    <label for="" style="font-size: 14px;"><span id="op_gratuitas">0.00</span></label><br>
                                                    <input type="hidden" id="op_gratuitas_" name="op_gratuitas_">
                                                    <label for="" style="font-size: 14px;"><span id="icbper">0.00</span></label><br>
                                                    <input type="hidden" id="icbper_" name="icbper_">
                                                    <label for="" style="font-size: 17px;"><span id="venta_total">0.00</span></label><br>
                                                    <input type="hidden" id="venta_total_" name="venta_total_">
                                                    <label for="" style="font-size: 14px;"><span id="vuelto">0.00</span></label>
                                                    <input type="hidden" id="vuelto_" name="vuelto_">
                                                </div>
                                            </div>
                                            <!--<div class="form-group">
                                                <label for="">Monto Total</label>
                                                <input class="form-control" type="text" id="venta_total" name="venta_total" readonly>
                                                <label for=""><span id="igv_total">0.00</span></label>

                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label class="col-form-label">Partir Pago</label>
                                        <select class="form-control" id="partir_pago" name="partir_pago" onchange="partir_pago()">
                                            <option value="1">SI</option>
                                            <option value="2" selected>NO</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="col-form-label">Tipo de Pago</label>
                                        <select class="form-control" id="id_tipo_pago" name="id_tipo_pago">
                                            <?php
                                            foreach ($tipo_pago as $tp){
                                                ?>
                                                <option <?php echo ($tp->id_tipo_pago == 3) ? 'selected' : '';?> value="<?php echo $tp->id_tipo_pago;?>"><?php echo $tp->tipo_pago_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4" id="div_monto_1">
                                        <label class="col-form-label">Monto 1</label>
                                        <input type="text" class="form-control" id="monto_1" onblur="monto_dividido(this.value)">
                                    </div>
                                    <div class="col-lg-4">
                                    </div>
                                    <div class="col-lg-4" id="div_tipo_pago_2">
                                        <label class="col-form-label">Tipo de Pago 2</label>
                                        <select class="form-control" id="id_tipo_pago_2" name="id_tipo_pago_2">
                                            <?php
                                            foreach ($tipo_pago as $tp){
                                                ?>
                                                <option <?php echo ($tp->id_tipo_pago == 3) ? 'selected' : '';?> value="<?php echo $tp->id_tipo_pago;?>"><?php echo $tp->tipo_pago_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4" id="div_monto_2">
                                        <label class="col-form-label">Monto 2</label>
                                        <input type="text" class="form-control" id="monto_2" readonly>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="tipo_igv">Tipo Venta</label><br>
                                            <select class="form-control" id="tipo_venta" name="tipo_venta" onchange="Consultar_serie_delivery()">
                                                <option value="">Seleccionar...</option>
                                                <option value="20">NOTA DE VENTA</option>
                                                <option value="03" selected>BOLETA</option>
                                                <option value="01">FACTURA</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="serie">Serie</label><br>
                                            <select class="form-control" id="serie" name="serie" onchange="ConsultarCorrelativo()">
                                                <option value="">Seleccionar...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="correlativo">Correlativo</label><br>
                                            <input type="text" class="form-control" id="correlativo" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="">Pagó con:</label><br>
                                        <input type="text" class="form-control" name="pago_cliente" id="pago_cliente" onkeyup="calcular_vuelto()">
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="tipo_moneda">Moneda</label><br>
                                            <select class="form-control" id="tipo_moneda" name="tipo_moneda">
                                                <option value="1">SOLES</option>
                                                <option value="2">DOLARES</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="gratis">Cortesía</label><br>
                                            <select class="form-control" id="gratis" name="gratis">
                                                <option value="1">SI</option>
                                                <option value="2" selected>NO</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tipo de Documento</label>
                                            <input type="text" id="select_tipodocumento" class="form-control" value="<?= $datos_cliente->tipodocumento_identidad;?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label for="">Cliente</label><br>
                                                    <textarea class="form-control" name="" id="cliente_nombre" cols="30" rows="2"><?= $cliente_nombre;?></textarea>

                                                    <input type="hidden" id="id_cliente">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="">DNI / RUC </label><br>
                                                    <input type="text" class="form-control" id="cliente_numero" value="<?= $datos_cliente->cliente_numero;?>" readonly>

                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="">Dirección Fiscal</label><br>
                                                    <textarea class="form-control" readonly name="cliente_direccion" id="cliente_direccion" cols="30" rows="3"><?= $datos_cliente->cliente_direccion;?></textarea>
                                                    <label for="" id="cliente_direccion"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row" style="display: none">
                                    <div class="form-group col-lg-9">
                                        <input required autocomplete="off" name="parametro_delivery" onkeyup="buscar_cliente_delivery_pagos()" type="text" class="form-control" id="parametro_delivery" placeholder="Buscar Cliente">
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <button class="btn btn-success" style="width: 80%"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="cliente_delivery_pagos" class="table-responsive">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="form-group col-lg-12" style="text-align: right;">
                                        <input type="hidden" id="datos_detalle_pedido" name="datos_detalle_pedido">
                                        <input type="hidden" id="id_mesa" name="id_mesa" value="0">
                                        <button type="button" onclick="agregar_()" class="btn btn-danger" id="btn-agregar"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!--<button type="button" onclick="agregar()" class="btn btn-success" id="btn-agregar"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>-->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="eliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 60% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input type="hidden" id="id_comanda_detalle_eliminar" name="id_comanda_detalle_eliminar">
                                <input type="hidden" id="id_comanda_eliminar" name="id_comanda_eliminar">
                                <input type="hidden" id="id_mesa_eliminar" name="id_mesa_eliminar">
                                <label class="col-form-label">Motivo</label>
                                <textarea class="form-control" name="comanda_detalle_eliminacion" id="comanda_detalle_eliminacion" cols="30" rows="2" placeholder="Ingrese Motivo..."></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="">Contraseña</label>
                            <input class="form-control" type="password" id="password" name="password" placeholder="Contraseña...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" onclick="preguntar('¿Está seguro que desea eliminar este pedido?','eliminar_comanda_detalle','Si','No')" id="btn-cambiar_mesa"><i class="fa fa-save fa-sm text-white-50"></i> Eliminar</button>
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
            <?php
            $canti_detalle = 0;
            $canti_detalle_ = 0;
            $contador = $this->pedido->listar_detalles_x_id($id);
            $valor_contado = $contador->total;
            foreach ($pedidos as $p) {
                $precio_producto = $this->pedido->listar_precio_x_producto($p->id_comanda, $p->id_producto);

                if ($p->comanda_detalle_estado_venta == 1) {
                    $canti_detalle++;
                } else {
                    $canti_detalle_++;
                }
            }
            if($canti_detalle == $valor_contado){
                ?>
            <?php
                }else{
            ?>
                <div class="row">
                <div class="col-lg-9"></div>
                    <div class="col-lg-2 col-sm-2">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#agregar_pedido_nuevo"><i class="fa fa-pencil"></i> Agregar Nuevo Pedido</button>
                    </div>
                </div>
            <br>
            <?php
            }
            ?>
            <div class="row">
                <div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h2><b>Pedido # <?= $dato_pedido->comanda_correlativo;?></b></h2></div>
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-12" style="text-align: center;">
                                                <h4>TOTAL DEL PEDIDO s/. <span style="color: black; font-size: 20pt;"><?= $dato_pedido->comanda_total; ?></span></h4>
                                                <h5>Falta cancelar s/. <span id="total_por_cancelar" style="color: red; font-size: 15pt;"></span></h5>
                                                <!--<input class="form-control" type="password" id="password"  placeholder="Ingrese su Contraseña AQUÍ para Permitir Cambios...">-->
                                            </div>
                                        </div>
                                    </div>
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>Fecha / Hora</th>
                                        <th>Producto</th>
                                        <th>Observacion</th>
                                        <th>Precio Unitario</th>
                                        <th style="width: 65px;">Cantidad</th>
                                        <th>Total</th>
                                        <th>Acción</th>
                                        <th>Estado</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $canti_detalle = 0;
                                    $canti_detalle_ = 0;
                                    $contador = $this->pedido->listar_detalles_x_id($id);
                                    $valor_contado = $contador->total;
                                    $a = 1;
                                    $total_x_cancelar = 0;
                                    foreach ($pedidos as $p){
                                        $estilo = "";
                                        if($p->comanda_detalle_estado_venta == "0"){
                                            $estilo = "style=\"background-color: #ea817c\"";
                                            $total_x_cancelar = $total_x_cancelar + $p->comanda_detalle_total;
                                        }

                                        $precio_producto = $this->pedido->listar_precio_x_producto($p->id_comanda,$p->id_producto);

                                        if($p->comanda_detalle_estado_venta == 1){
                                            $canti_detalle ++;
                                        }else{
                                            $canti_detalle_ ++;
                                        }

                                        ?>
                                        <tr id="detalle<?= $p->id_comanda_detalle;?>" <?= $estilo;?>>
                                            <td><?= $p->comanda_detalle_fecha_registro;?></td>
                                            <td><?= $p->producto_nombre;?></td>
                                            <td><?= $p->comanda_detalle_observacion;?></td>
                                            <input type="hidden" id="comanda_detalle_precio<?= $p->id_comanda_detalle;?>" value="<?= $p->comanda_detalle_precio;?>">
                                            <td><?= $p->comanda_detalle_precio;?></td>
                                            <?php
                                            if($p->comanda_detalle_estado_venta == "0"){ ?>
                                                <td><input class="form-control" type="number" id="cantidad_detalle_cantidad<?= $p->id_comanda_detalle;?>" value="<?= $p->comanda_detalle_cantidad;?>" onchange="cambiar_comanda_detalle_cantidad(<?= $p->id_comanda_detalle;?>, <?= $p->id_comanda;?>)"></td>
                                                <?php
                                            }else{ ?>
                                                <td><?= $p->comanda_detalle_cantidad;?></td>
                                                <?php
                                            }
                                            ?>
                                            <td><span id="span_comanda_detalle_total<?= $p->id_comanda_detalle;?>"><?= $p->comanda_detalle_total;?></span></td>
                                            <td>
                                                <?php
                                                if($p->comanda_detalle_estado_venta == 0){
                                                    ?>
                                                    <a class="btn btn-danger" type="button" id="btn-eliminar_pedido" onclick="cargar_valores_(<?= $p->id_comanda_detalle;?>,'<?= $p->id_comanda?>','<?= $p->id_mesa?>')" data-toggle="modal" data-target="#eliminar" title='Eliminar'><i class='fa fa-times text-white eliminar margen'></i></a>
                                                    <?php
                                                }
                                                else{
                                                    ?>
                                                    ---
                                                    <?php
                                                }
                                                ?>
                                            </td>

                                            <?php
                                            $consultar_estado = $this->pedido->consultar($p->id_comanda_detalle);
                                            (!empty($consultar_estado))?$resultado=true:$resultado=false;
                                            if($resultado){
                                                ?>
                                                <td>PAGADO</td>
                                                <?php
                                            }else{
                                                ?>
                                                <td>Pendiente de Pago</td>
                                                <?php
                                            }
                                            ?>
                                        </tr>
                                        <?php
                                        $a++;
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div class="row">
                                <?php
                                if($canti_detalle == $valor_contado){
                                    ?>
                                    <div class="col-lg-10"></div>
                                    <div class="col-lg-1">
                                        <a class="btn btn-secondary" href="javascript:history.back()" role="button"><i class="fa fa-backward"></i> Regresar</a>
                                    </div>
                                <?php
                                }else{
                                    ?>
                                    <div class="col-lg-3 col-sm-3 col-md-3" style="display: none">
                                        <a id="imprimir_ticket_comanda" style="color: white;" class="btn btn-warning" onclick="ticket_comanda_pedido(<?= $id; ?>)"><i class="fa fa-print"></i> Comanda</a>
                                    </div>
                                    <div class="col-lg-3 col-sm-3 col-md-3" style="display: none">
                                        <a id="imprimir_ticket" style="color: white;" class="btn btn-success" onclick="ticket_pedido(<?= $id; ?>)"><i class="fa fa-print"></i> Pre Cuenta</a>
                                    </div>
                                    <?php
                                    $entre=true;
                                    if($id_rol == 2 || $id_rol == 3 || $id_rol ==5){
                                        ?>
                                        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3"></div>
                                        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                                            <button  type="button" id="btn_generarventa" class="btn btn-primary" data-toggle="modal" data-target="#ventas">
                                                <i class="fa fa-money"></i> Cobrar</button>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3" style="text-align: right;">
                                        <a class="btn btn-secondary" href="javascript:history.back()" role="button"><i class="fa fa-backward"></i> Regresar</a>
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
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>pedido.js"></script>


<script>
    $(document).ready(function (){
        $("#mostrar").hide();
        Consultar_serie_delivery();
        var por_cancelar_ = <?= $total_x_cancelar;?>;
        var por_cancelar = por_cancelar_.toFixed(2);
        $("#total_por_cancelar").html(por_cancelar);
        partir_pago();
    });
    var contenido_pedido = "";
    function ticket_pedido(id){
        var boton = 'imprimir_ticket';
        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/ticket_pedido",
            data: "id=" + id,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'imprimiendo...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-print\"></i> Pre Cuenta", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Éxito!...', 'success');
                        setTimeout(function () {
                            //location.reload();
                        }, 800);
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }

    function cargar_valores_(id_comanda_detalle,id_comanda,id_mesa){
        $("#id_comanda_detalle_eliminar").val(id_comanda_detalle);
        $("#id_comanda_eliminar").val(id_comanda);
        $("#id_mesa_eliminar").val(id_mesa);

    }

    //INICIO - AGREGAR NUEVOS PEDIDOS
    function add_pedido_nuevo(){
        var comanda_detalle_observacion = $("#comanda_detalle_observacion").val();
        var producto_nombre = $("#producto_nombre").val();
        var id_producto = $("#id_producto").val();
        var comanda_detalle_cantidad = $("#comanda_detalle_cantidad").val() * 1;
        var comanda_detalle_precio = $("#comanda_detalle_precio").val() * 1;
        var comanda_detalle_despacho = $("#comanda_detalle_despacho").val();


        var subtotal = comanda_detalle_cantidad * comanda_detalle_precio;
        subtotal.toFixed(2);
        subtotal = subtotal.toFixed(2);

        /*total_total = total_total + subtotal;
        total_total.toFixed(2);
        total_total = parseFloat(total_total);*/

        if(id_producto !="" && comanda_detalle_cantidad!="" && comanda_detalle_precio!="" && producto_nombre!="" && subtotal!="" && comanda_detalle_despacho !="" ){
            contenido_pedido += id_producto + "-.-." + producto_nombre + "-.-."+ comanda_detalle_precio+"-.-." + comanda_detalle_cantidad +"-.-."+comanda_detalle_despacho+"-.-." + comanda_detalle_observacion+"-.-."+subtotal+"/./.";
            $("#contenido_pedido").val(contenido_pedido);
            //$("#comanda_total_pedido").val(subtotal);
            show_table();
            clean();
        }else{
            respuesta('Ingrese todos los campos');
        }
    }
    function show_table() {
        var llenar="";
        conteo=1;
        var monto_total = 0;
        var total = 0.00;
        if (contenido_pedido.length>0){
            var filas=contenido_pedido.split('/./.');
            if(filas.length>0){
                for(var i=0;i<filas.length - 1;i++){
                    var celdas =filas[i].split('-.-.');
                    llenar +="<tr>" +
                        "<td>"+celdas[1]+"</td>"+
                        "<td>"+celdas[2]+"</td>"+
                        "<td>"+celdas[3]+"</td>"+
                        "<td>"+celdas[4]+"</td>"+
                        "<td>"+celdas[5]+"</td>"+
                        "<td>"+celdas[6]+"</td>"+
                        "<td><a data-toggle=\"tooltip\" onclick='delete_detalle("+i+")' title=\"Eliminar\" type=\"button\" class=\"text-danger\" ><i class=\"fa fa-times ver_detalle\"></i></a></td>"+
                        "</tr>";
                    conteo++;
                    monto_total = monto_total + celdas[6] * 1;
                    total = monto_total.toFixed(2);
                }
            }
        }
        $("#contenido_detalle_compra").html(llenar);
        $("#conteo").html(conteo);
        $("#comanda_total").val(total);
        $("#comanda_total_").html("S/ " + total);
        //$("#contenido_pedido").val(contenido_pedido);
    }
    function delete_detalle(ind) {
        var contenido_artificio ="";
        if (contenido_pedido.length>0){
            var filas=contenido_pedido.split('/./.');
            if(filas.length>0){
                for(var i=0;i<filas.length - 1;i++){
                    if(i!=ind){
                        var celdas =filas[i].split('-.-.');
                        contenido_artificio += celdas[0] + "-.-."+celdas[1] + "-.-." + celdas[2] + "-.-." + celdas[3] + "-.-." +celdas[4] + "-.-."+ celdas[5] + "-.-."+ celdas[6] + "/./.";
                    }else{
                        var celdas =filas[i].split('-.-.');
                    }
                }
            }
        }
        contenido_pedido = contenido_artificio;
        show_table();
    }
    function clean() {
        $("#comanda_detalle_observacion").val("-");
        $("#producto_nombre").val("");
        $("#id_producto").val("");
        $("#comanda_detalle_cantidad").val("1");

        $("#comanda_detalle_despacho option[value='salon']").attr('selected','selected');
        $("#comanda_detalle_precio").val("");
        $("#producto_nombre_").html("");
        $("#comanda_detalle_precio_").html("");
        $("#parametro").val("");
    }
    //FIN - AGREGAR NUEVOS PEDIDOS
    function ticket_comanda_pedido(id_comanda){
        var boton = 'imprimir_ticket_comanda';
        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/ticket_comanda",
            data: "id=" + id_comanda,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'imprimiendo...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-print\"></i> Comanda", false);
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

    function partir_pago(){
        var partir = $('#partir_pago').val();
        if(partir == 1){
            $('#div_monto_1').show();
            $('#div_tipo_pago_2').show();
            $('#div_monto_2').show();
        }else {
            $('#div_monto_1').hide();
            $('#monto_1').val('');
            $('#monto_2').val('');
            $('#div_tipo_pago_2').hide();
            $('#div_monto_2').hide();
        }

    }
    function monto_dividido(valor){
        var total = $('#venta_total_').val();
        if(valor <= total){
            var resta = total - valor;
            $('#monto_2').val(resta.toFixed(2));
        }else{
            respuesta('Monto ' + valor + ' tiene que ser menor que ' + total);
            $('#monto_2').val('');

        }
    }

</script>