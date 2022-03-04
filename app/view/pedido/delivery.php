


<div class="modal fade" id="agregar_cliente_nuevo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Cliente Nuevo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div id="cliente">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Tipo de documento</label>
                                    <select class="form-control" id="id_tipodocumento" name="id_tipodocumento" onchange="tipo_documento()">
                                        <option value="">Seleccione</option>
                                        <?php
                                        foreach ($tipos_documento as $td){
                                            echo "<option value='".$td->id_tipodocumento."'>".$td->tipodocumento_identidad."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Nro Documento:</label>
                                    <input class="form-control" type="text" id="cliente_numero" onchange="consultar_documento(this.value)" onkeyup="return validar_numeros(this.id)" name="cliente_numero" maxlength="15" placeholder="Ingrese Numero...">
                                </div>
                            </div>
                            <div class="col-lg-12" id="div_nombre">
                                <div class="form-group">
                                    <label class="col-form-label">Nombre Completo:</label>
                                    <input class="form-control" type="text" id="cliente_nombre" name="cliente_nombre" maxlength="500" placeholder="Ingrese Nombre...">
                                </div>
                            </div>
                            <!--<div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Apellido Paterno:</label>
                                    <input class="form-control" type="text" id="cliente_apellido_paterno" name="cliente_apellido_paterno" maxlength="200" placeholder="Ingrese Apellido...">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Apellido Materno:</label>
                                    <input class="form-control" type="text" id="cliente_apellido_materno" name="cliente_apellido_materno" maxlength="200" placeholder="Ingrese Apellido...">
                                </div>
                            </div>-->
                        </div>
                        <div class="row">
                            <div class="col-lg-12" id="div_razon_social">
                                <div class="form-group">
                                    <label class="col-form-label">Razón Social:</label>
                                    <textarea rows="2" class="form-control" type="text" id="cliente_razonsocial" name="cliente_razonsocial" maxlength="500" placeholder="Ingrese Razón Social..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="div_direcciones">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label">Dirección:</label>
                                    <textarea rows="2" class="form-control" type="text" id="cliente_direccion" name="cliente_direccion" maxlength="500" placeholder="Ingrese Dirección..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="div_telefono_correo">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Teléfono:</label>
                                    <input class="form-control" type="text" id="cliente_telefono" onkeyup="return validar_numeros(this.id)" name="cliente_telefono" maxlength="30" placeholder="Ingrese Telefono...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="limpiar()" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                <button type="submit" class="btn btn-success" onclick="agregar_cliente_nuevo()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="asignar_pedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 40% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar</h5>
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
                                    <input type="hidden" id="codigo_afectacion_d" name="codigo_afectacion_d">
                                    <label class="col-form-label">Producto</label>
                                    <input type="text" readonly class="form-control" id="producto_nombre" name="producto_nombre">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Precio</label>
                                    <input type="text" readonly class="form-control" id="comanda_detalle_precio" name="comanda_detalle_precio">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Cantidad</label>
                                    <input type="number" value="1" class="form-control" id="comanda_detalle_cantidad" name="comanda_detalle_cantidad">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Tipo Entrega</label>
                                    <select class="form-control" id="comanda_detalle_despacho" name="comanda_detalle_despacho">
                                        <option value="DELIVERY">Delivery</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label">Observacion</label>
                                    <textarea rows="3" class="form-control" type="text" id="comanda_detalle_observacion" name="comanda_detalle_observacion" maxlength="200" placeholder="Ingrese Alguna Observacion...">-</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
<!--                <a type="button" onclick="agregar_deli()" class="btn btn-success" id="btn-agregar_" style="color: white"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</a>-->
                <button type="button" onclick="agregar_deli()" class="btn btn-success" id="btn-agregar"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
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
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" >
                                <div class="row">
                                    <div class="form-group col-lg-7">
                                        <input required autocomplete="off" name="parametro" type="text" value="<?= $parametro;?>" class="form-control" id="parametro" placeholder="Buscar Productos...">
                                    </div>
                                    <div class="form-group col-lg-5">
                                        <button type="submit" onclick="productos()" class="btn btn-success" style="width: 80%"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12">
                                    <div id="producto" class="table-responsive">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <?php
                                foreach ($familia as $f){
                                    $productos_familia = $this->pedido->listar_productos_x_familia($f->id_producto_familia);
                                    ?>
                                    <h3 data-toggle="collapse" href="#tipo_<?= $f->id_producto_familia;?>"><?= $f->producto_familia_nombre?><i class="fa fa-arrow-down" style="float: right"></i></h3><br>

                                    <div id="tipo_<?= $f->id_producto_familia;?>" class="collapse">
                                        <table class='table table-bordered' width='100%'>
                                            <thead class='text-capitalize'>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($productos_familia as $pf){
                                                $anho = date('Y');
                                                if($anho == "2021"){
                                                    $icbper = 0.30;
                                                }elseif($anho == "2022"){
                                                    $icbper = 0.40;
                                                }else{
                                                    $icbper = 0.50;
                                                }
                                                $op_gravadas=0.00;
                                                $op_exoneradas=0.00;
                                                $op_inafectas=0.00;
                                                $op_gratuitas=0.00;
                                                $igv=0.0;
                                                $igv_porcentaje=0.18;
                                                if($pf->producto_precio_codigoafectacion == 10){
                                                    /*$op_gravadas = $pf->producto_precio_venta;
                                                    $igv = $op_gravadas * $igv_porcentaje;
                                                    $total = $op_gravadas + $igv;*/
                                                    $total = $pf->producto_precio_venta;
                                                }else{
                                                    $total = $pf->producto_precio_venta;
                                                }
                                                /*if($pf->id_receta == "131"){
                                                    $total = $total + $icbper;
                                                }*/
                                                ?>
                                                <tr>
                                                    <td><?=$pf->producto_nombre?></td>
                                                    <td><?=$total ?></td>
                                                    <td><button class='btn btn-success' data-toggle='modal' onclick="guardar_pedido(<?=$pf->id_producto?>,'<?=$pf->producto_nombre?>','<?=$total?>','<?= $pf->producto_precio_codigoafectacion?>')" data-target='#asignar_pedido'><i class='fa fa-check'></i></button><td>
                                                    <a class="btn btn-primary" href="<?= _SERVER_ . $pf->producto_foto?>" target="_blank"><i class="fa fa-eye"></i></a>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                                <input type="hidden" id="contenido" name="contenido">
                                <input type="hidden" class="form-control" id="id_producto" name="id_producto">

                                <div class="form-group col-md-12">
                                    <table class="table table-bordered">
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
                                            <td id="conteo"></td>
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
                                        </tr>
                                    </table>
                                    <div class="row">
                                        <div class="col-lg-8" style="text-align: right" id="div_titulo_span">
                                            <!--<label for="" style="font-size: 14px;">OP. GRAVADAS</label><br>
                                            <label for="" style="font-size: 14px;">IGV(18%)</label><br>
                                            <label for="" style="font-size: 14px;">OP. EXONERADAS</label><br>
                                            <label for="" style="font-size: 14px;">OP. INAFECTAS</label><br>
                                            <label for="" style="font-size: 14px;">OP. GRATUITAS</label><br>
                                            <label for="" style="font-size: 14px;">ICBPER</label><br>-->
                                            <label for="" style="font-size: 17px;"><strong>TOTAL</strong></label><br>
                                            <label for="" style="font-size: 14px;">VUELTO</label>
                                        </div>
                                        <div class="col-lg-2" style="text-align: right" id="div_totales_span">
                                            <label for="" style="font-size: 17px;"><span id="venta_total">0.00</span></label><br>
                                            <label for="" style="font-size: 14px;"><span id="vuelto">0.00</span></label>

                                        </div>
                                        <div class="col-lg-2" style="text-align: right">
<!--                                            <label for="" style="font-size: 14px;"><span id="op_gravadas">0.00</span></label><br>-->
                                            <input type="hidden" id="op_gravadas_" name="op_gravadas_">
<!--                                            <label for="" style="font-size: 14px;"><span id="igv">0.00</span></label><br>-->
                                            <input type="hidden" id="igv_" name="igv_">
<!--                                            <label for="" style="font-size: 14px;"><span id="op_exoneradas">0.00</span></label><br>-->
                                            <input type="hidden" id="op_exoneradas_" name="op_exoneradas_">
<!--                                            <label for="" style="font-size: 14px;"><span id="op_inafectas">0.00</span></label><br>-->
                                            <input type="hidden" id="op_inafectas_" name="op_inafectas_">
<!--                                            <label for="" style="font-size: 14px;"><span id="op_gratuitas">0.00</span></label><br>-->
                                            <input type="hidden" id="op_gratuitas_" name="op_gratuitas_">
<!--                                            <label for="" style="font-size: 14px;"><span id="icbper">0.00</span></label><br>-->
                                            <input type="hidden" id="icbper_" name="icbper_">
                                            <input type="hidden" id="venta_total_" name="venta_total_">
                                            <input type="hidden" id="vuelto_" name="vuelto_">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-2">
                                        <label class="col-form-label">Partir Pago</label>
                                        <select class="form-control" id="partir_pago" name="partir_pago" onchange="partir_pago()">
                                            <option value="1">SI</option>
                                            <option value="2" selected>NO</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-3">
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
                                    <div class="form-group col-lg-2" id="div_monto_1">
                                        <label class="col-form-label">Monto 1</label>
                                        <input type="text" class="form-control" id="monto_1" onblur="monto_dividido(this.value)">
                                    </div>
                                    <div class="form-group col-lg-3" id="div_tipo_pago_2">
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
                                    <div class="form-group col-lg-2" id="div_monto_2">
                                        <label class="col-form-label">Monto 2</label>
                                        <input type="text" class="form-control" id="monto_2" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-2">
                                        <label for="">Pagó con:</label><br>
                                        <input type="text" class="form-control" name="pago_cliente" id="pago_cliente" onkeyup="calcular_vuelto()">
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label for="tipo_igv">Tipo Venta</label><br>
                                        <select class="form-control" id="tipo_venta" name="tipo_venta" onchange="Consultar_serie_delivery()">
                                            <option value="">Seleccionar...</option>
                                            <option value="20">NOTA DE VENTA</option>
                                            <option value="03" selected>BOLETA</option>
                                            <option value="01">FACTURA</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label for="serie">Serie</label><br>
                                        <select class="form-control" id="serie" name="serie" onchange="ConsultarCorrelativo()">
                                            <option value="">Seleccionar...</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label for="correlativo">Correlativo</label><br>
                                        <input type="text" class="form-control" id="correlativo" readonly>
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label for="tipo_moneda">Moneda</label><br>
                                        <select class="form-control" id="tipo_moneda" name="tipo_moneda">
                                            <option value="1">SOLES</option>
                                            <option value="2">DOLARES</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-lg-2">
                                        <label for="gratis">Cortesía</label><br>
                                        <select class="form-control" onchange="select_cortesia()" id="gratis" name="gratis">
                                            <option value="1">SI</option>
                                            <option value="2" selected>NO</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-7">
                                        <label for="">Buscar Cliente</label>
                                        <input required autocomplete="off" name="parametro_delivery" onkeyup="buscar_cliente_delivery()" type="text" class="form-control" id="parametro_delivery" placeholder="Buscar Cliente">
                                    </div>
                                    <div class="form-group col-lg-3" style="margin-top: 35px">
                                        <button data-toggle="modal" data-target="#agregar_cliente_nuevo" class="btn btn-success" style="width: 99%"> Cliente Nuevo</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="cliente_delivery" class="table-responsive">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5" id="div_observacion_cortesia">
                                        <label>Observación de Cortesía</label><br>
                                        <textarea class="form-control" name="observacion_cortesia" id="observacion_cortesia" cols="30" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="hidden" id="id_mesa" name="id_mesa" value="0">
                                            <label for="">Cliente</label><br>
                                            <!--<label for="" id="cliente_nombre"></label>-->
                                            <input class="form-control" id="cliente_nombre_d" name="cliente_nombre_d" value="ANONIMO">
                                            <input type="hidden" id="id_cliente" name="id_cliente" value="3">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">DNI / RUC </label><br>
                                            <input class="form-control" id="cliente_numero_d" name="cliente_numero_d" value="11111111">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Dirección</label><br>
                                            <textarea rows="3" class="form-control" id="cliente_direccion_d" name="cliente_direccion_d"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Telefono</label><br>
                                            <input class="form-control" id="cliente_telefono_d" name="cliente_telefono_d">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-3" style="margin-top: 12px">
                                        <button  type="button" id="btn_generarventa" class="btn btn-primary" onclick="guardar_comanda_delivery()">
                                            <i class="fa fa-money"></i> Guardar</button>
                                    </div>
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-2" style="margin-top: 12px; display: none" >
                                        <button onclick="guardar_comanda_delivery()" class="btn btn-primary"><i class="fa fa-check"></i> Generar</button>
                                    </div>
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-2" style="margin-top: 12px">
                                        <a class="btn btn-secondary" href="javascript:history.back()" role="button"><i class="fa fa-backward"></i> Regresar</a>
                                    </div>
                                </div>
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
<script src="<?php echo _SERVER_ . _JS_;?>cliente.js"></script>


<script>
    $(document).ready(function (){
        $("#mostrar").hide();
        $('#div_razon_social').hide();
        $('#div_nombre').hide();
        $("#div_direcciones").hide();
        $("#div_telefono_correo").hide();
        Consultar_serie_delivery();
        partir_pago();
        select_cortesia();

        $('#parametro').keypress(function(e){
            if(e.which === 13){
                productos();
            }
        });
    });

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

    function Consultar_serie_delivery(){
        var tipo_venta =  $("#tipo_venta").val();

        var concepto = "LISTAR_SERIE";
        var cadena = "tipo_venta=" + tipo_venta +
            "&concepto=" + concepto +
            "&delivery=1";
        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/consultar_serie",
            data: cadena,
            dataType: 'json',
            success:function (r) {
                var series = "";
                //var series = "<option value='' selected>Seleccione</option>";
                for (var i=0; i<r.serie.length; i++){
                    series += "<option value='"+r.serie[i].id_serie+"'>"+r.serie[i].serie+"</option>"
                }
                $("#serie").html(series);
                ConsultarCorrelativo();
            }

        });
    }

    function ConsultarCorrelativo(){
        var id_serie =  $("#serie").val();
        var concepto = "LISTAR_NUMERO";
        var cadena = "id_serie=" + id_serie +
            "&concepto=" + concepto;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/consultar_serie",
            data: cadena,
            dataType: 'json',
            success:function (r) {
                $("#correlativo").val(r.correlativo);
            }

        });
    }

    var contenido = "";
    var conteo = 1;
    var total_total = 0;

    function productos(){
        var param_ = $("#parametro").val();
        var param = param_.replace("+",".--");
        $("#producto").html("");
        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/ver_productos_x_delivery/",
            data:"&parametro=" + param,
            dataType: 'json',
            success:function (r) {
                $("#producto").html(r);
            }
        });
    }

    function show_table() {
        var llenar="";
        conteo=1;
        var monto_total = 0;
        if (contenido.length>0){
            var filas=contenido.split('/./.');
            if(filas.length>0){
                for(var i=0;i<filas.length - 1;i++){
                    var celdas =filas[i].split('-.-.');
                    llenar += "<tr>"+
                        "<td>"+celdas[1]+"</td>"+
                        "<td>"+celdas[2]+"</td>"+
                        "<td>"+celdas[3]+"</td>"+
                        "<td>"+celdas[4]+"</td>"+
                        "<td>"+celdas[5]+"</td>"+
                        "<td>"+celdas[6]+"</td>"+
                        "<td><a data-toggle=\"tooltip\" onclick='delete_detalle("+i+")' title=\"Eliminar\" type=\"button\" class=\"text-danger\" ><i class=\"fa fa-times ver_detalle\"></i></a></td>"+
                        "</tr>";
                    conteo++;
                    var monto_total = monto_total + celdas[6] * 1;
                    var total = monto_total.toFixed(2);
                }
            }
        }
        $("#contenido_detalle_compra").html(llenar);
        $("#conteo").html(conteo);
        $("#contenido").val(contenido);
        //$("#comanda_total").val(total);
        //$("#comanda_total_").html("S/ " + total);
        calcular_afectacion();


        //
        // $('#op_gravadas').html(gravada.toFixed(2));
        // $('#op_gravadas_').val(gravada.toFixed(2));
        // $('#igv').html(igv.toFixed(2));
        // $('#igv_').val(igv.toFixed(2));
        // $('#op_exoneradas').html(exonerado.toFixed(2));
        // $('#op_exoneradas_').val(exonerado.toFixed(2));
        // $('#op_inafectas').html(inafecto.toFixed(2));
        // $('#op_inafectas_').val(inafecto.toFixed(2));
        // $('#op_gratuitas').html(gratuito.toFixed(2));
        // $('#op_gratuitas_').val(gratuito.toFixed(2));
        // $('#icbper').html(total_icbper.toFixed(2));
        // $('#icbper_').val(total_icbper.toFixed(2));

    }

    function clean() {
        $('#asignar_pedido').modal('toggle');
        $("#comanda_detalle_cantidad").val("1");
        $("#comanda_detalle_precio").val("");
        $("#comanda_detalle_observacion").val("-");
        $("#producto_nombre").val("");

        $("#comanda_detalle_despacho option[value='']").attr('selected','selected');
        $("#comanda_detalle_despacho").val();
        $("#comanda_detalle_despacho").select().trigger('change');
        $("#parametro").val("");
        $("#producto").html("");
    }

    function delete_detalle(ind) {
        var contenido_artificio ="";
        if (contenido.length>0){
            var filas=contenido.split('/./.');
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
        contenido = contenido_artificio;
        show_table();
        calcular_afectacion();
    }

    function agregar_deli(){
        var comanda_detalle_despacho_val = $("#comanda_detalle_despacho").val();
        if(comanda_detalle_despacho_val!=""){
            var comanda_detalle_despacho = $("select[name='comanda_detalle_despacho'] option:selected").text();
        }else{
            var comanda_detalle_despacho = "";
        }

        var comanda_detalle_observacion = $("#comanda_detalle_observacion").val();
        var producto_nombre = $("#producto_nombre").val();
        var id_producto = $("#id_producto").val();
        var comanda_detalle_cantidad = $("#comanda_detalle_cantidad").val() * 1;
        var comanda_detalle_precio = $("#comanda_detalle_precio").val() * 1;

        var codigo_afectacion_d = $("#codigo_afectacion_d").val() * 1;

        var subtotal = comanda_detalle_cantidad * comanda_detalle_precio;
        subtotal.toFixed(2);
        subtotal = subtotal.toFixed(2);

        /*total_total = total_total + subtotal;
        total_total.toFixed(2);
        total_total = parseFloat(total_total);*/

        if(id_producto !="" && comanda_detalle_cantidad!="" && comanda_detalle_precio!="" && producto_nombre!="" && comanda_detalle_observacion !="" && subtotal!="" && comanda_detalle_despacho !="" && codigo_afectacion_d !=""){
            contenido += id_producto + "-.-." + producto_nombre + "-.-."+ comanda_detalle_precio+"-.-." + comanda_detalle_cantidad +"-.-."+comanda_detalle_despacho+"-.-." + comanda_detalle_observacion+"-.-."+subtotal+"-.-." + codigo_afectacion_d+"/./.";
            $("#contenido").val(contenido);
            //$("#comanda_total_pedido").val(subtotal);
            respuesta('¡Producto Agregado!','success');
            show_table();
            clean();
        }else{
            respuesta('Ingrese todos los campos');
        }
    }
    //INICIO - CALCULAR LAS AFECTACIONES Y TOTAL
    function calcular_afectacion(){
        var gravada = 0.00;
        var exonerado = 0.00;
        var inafecto = 0.00;
        var gratuito = 0.00;
        var total_icbper = 0.00;
        var igv = 0.00;
        var igv_porcentaje = 0.18;
        var total_pedido_detalle = 0;

        var fecha = new Date();
        var anho = fecha.getFullYear();
        if(anho == '2021'){
            var icbper = 0.30;
        }else if(anho == '2022'){
            var icbper = 0.40;
        }else{
            var icbper = 0.50;
        }
        if (contenido.length>0){
            var filas=contenido.split('/./.');
            if(filas.length>0){
                for(var i=0;i<filas.length - 1;i++){
                    var celdas =filas[i].split('-.-.');
                    var afectacion = celdas[7];
                    var cantidad = celdas[3];
                    var nombre_producto = celdas[1];
                    var precio_unitario = celdas[2];
                    var subtotal = precio_unitario * cantidad;

                    if(afectacion == "10"){
                        gravada = gravada + subtotal;
                        igv = igv + gravada * igv_porcentaje;

                        total_pedido_detalle = total_pedido_detalle + subtotal + igv;
                    }
                    if(afectacion == "20"){
                        exonerado = exonerado + subtotal;
                        total_pedido_detalle = total_pedido_detalle +  subtotal ;
                    }
                    if(afectacion == "30"){
                        inafecto = inafecto + subtotal;
                        total_pedido_detalle = total_pedido_detalle + subtotal;
                    }
                    if(afectacion == "21"){
                        gratuito = gratuito + subtotal;
                        //total_pedido_detalle = total_pedido_detalle + subtotal;
                    }
                    if(nombre_producto === "Bolsa Plastica"){
                        icbper = icbper * cantidad;
                        total_icbper = icbper;
                        total_pedido_detalle = total_pedido_detalle + icbper;
                    }

                }
            }
        }
        var llenar_span = "";
        var llenar_titulo_span = "";
        if(gravada > 0){
            llenar_span += "<label style=\"font-size: 14px;\"><span id='op_gravadas'>0.00</span></label><br>";
            llenar_span += "<label style=\"font-size: 14px;\"><span id='igv'>0.00</span></label><br>";
            llenar_titulo_span += "<label style=\"font-size: 14px;\">OP. GRAVADAS</label><br>";
            llenar_titulo_span += "<label style=\"font-size: 14px;\">IGV(18%)</label><br>";
        }
        if(exonerado > 0){
            llenar_span += "<label style=\"font-size: 14px;\"><span id='op_exoneradas'>0.00</span></label><br>";
            llenar_titulo_span += "<label style=\"font-size: 14px;\">OP. EXONERADAS</label><br>";
        }
        if(inafecto > 0){
            llenar_span += "<label style=\"font-size: 14px;\"><span id='op_inafectas'>0.00</span></label><br>";
            llenar_titulo_span += "<label style=\"font-size: 14px;\">OP. INAFECTAS</label><br>";
        }
        if(gratuito > 0){
            llenar_span += "<label style=\"font-size: 14px;\"><span id='op_gratuitas'>0.00</span></label><br>";
            llenar_titulo_span += "<label style=\"font-size: 14px;\">OP. GRATUITO</label><br>";
        }
        if(total_icbper > 0){
            llenar_span += "<label style=\"font-size: 14px;\"><span id='icbper'>0.00</span></label><br>";
            llenar_titulo_span += "<label style=\"font-size: 14px;\">ICBPER</label><br>";
        }
        llenar_span += "<label style=\"font-size: 14px;\"><span id='venta_total'>0.00</span></label><br>";
        llenar_span += "<label style=\"font-size: 14px;\"><span id='vuelto'>0.00</span></label><br>";
        llenar_titulo_span += "<label style=\"font-size: 14px;\">TOTAL</label><br>";
        llenar_titulo_span += "<label style=\"font-size: 14px;\">VUELTO</label><br>";
        $('#div_totales_span').html(llenar_span);
        $('#div_titulo_span').html(llenar_titulo_span);

        if(gravada > 0){
            $('#op_gravadas').html(gravada.toFixed(2));
            $('#igv').html(igv.toFixed(2));
        }
        if(exonerado > 0){
            $('#op_exoneradas').html(exonerado.toFixed(2));
        }
        if(inafecto > 0){
            $('#op_inafectas').html(inafecto.toFixed(2));
        }
        if(gratuito > 0){
            $('#op_gratuitas').html(gratuito.toFixed(2));
        }
        if(total_icbper > 0){
            $('#icbper').html(total_icbper.toFixed(2));
        }


        $('#op_gravadas_').val(gravada.toFixed(2));

        $('#igv_').val(igv.toFixed(2));

        $('#op_exoneradas_').val(exonerado.toFixed(2));
        $('#op_inafectas_').val(inafecto.toFixed(2));
        $('#op_gratuitas_').val(gratuito.toFixed(2));
        $('#icbper_').val(total_icbper.toFixed(2));
        $('#venta_total').html(total_pedido_detalle.toFixed(2));
        $('#venta_total_').val(total_pedido_detalle.toFixed(2));



    }
    //FIN - CALCULAR LAS AFECTACIONES Y TOTAL

    function guardar_comanda_delivery(){
        //DATOS PAR AGUARDAR LA COMANDA
        var valor = true;
        var valor_numero = true;
        var contenido = $('#contenido').val();
        var id_cliente = $('#id_cliente').val();
        var comanda_total = $('#venta_total_').val();
        var cliente_nombre_d = $('#cliente_nombre_d').val();
        var comanda_direccion_delivery = $('#cliente_direccion_d').val();
        var comanda_telefono_delivery = $('#cliente_telefono_d').val();
        //DATOS PARA GUARDAR LA VENTA
        var id_mesa = $('#id_mesa').val();
        var tipo_venta = $('#tipo_venta').val();
        var tipo_moneda = $('#tipo_moneda').val();
        var serie = $('#serie').val();
        var correlativo = $('#correlativo').val();
        var op_gravadas_ = $('#op_gravadas_').val();
        var igv_ = $('#igv_').val();
        var op_exoneradas_ = $('#op_exoneradas_').val();
        var op_inafectas_ = $('#op_inafectas_').val();
        var op_gratuitas_ = $('#op_gratuitas_').val();
        var icbper_ = $('#icbper_').val();
        var venta_total = $('#venta_total_').val();
        var pago_cliente = $('#pago_cliente').val();
        var vuelto_ = $('#vuelto_').val();
        var imprimir = "1";
        var gratis = $('#gratis').val();
        var observacion_cortesia = $('#observacion_cortesia').val();

        var partir_pago = $('#partir_pago').val();
        var contenido_tipopago = "";
        var id_tipo_pago = $('#id_tipo_pago').val();
        var monto_1 = $('#monto_1').val();

        if(partir_pago == 1){
            var id_tipo_pago_2 = $('#id_tipo_pago_2').val();
            var monto_2 = $('#monto_2').val();
            contenido_tipopago = id_tipo_pago + '-.-.' + monto_1 + '/-/-' + id_tipo_pago_2 + '-.-.' + monto_2 + '/-/-';
        }else{
            contenido_tipopago = id_tipo_pago + '-.-.' + venta_total + '/-/-';
        }
        var cliente_numero_d = $('#cliente_numero_d').val();
        if(tipo_venta == "01"){
            if(cliente_numero_d.length === 11){
                valor_numero = true;
            }else{
                valor_numero = false;
            }
        }

        if( valor_numero== true){
            valor = validar_campo_vacio('contenido', contenido, valor);
            valor = validar_campo_vacio('id_tipo_pago', id_tipo_pago, valor);
            valor = validar_campo_vacio('tipo_venta', tipo_venta, valor);
            valor = validar_campo_vacio('tipo_moneda', tipo_moneda, valor);
            valor = validar_campo_vacio('serie', serie, valor);
            valor = validar_campo_vacio('correlativo', correlativo, valor);
            valor = validar_campo_vacio('venta_total', venta_total, valor);
            if(gratis == 1){
                valor = validar_campo_vacio('observacion_cortesia', observacion_cortesia, valor);
            }
            if (valor){
                var cadena = "contenido=" + contenido +
                    "&comanda_total=" + comanda_total +
                    "&id_cliente=" + id_cliente +
                    "&cliente_nombre_d=" + cliente_nombre_d +
                    "&comanda_direccion_delivery=" + comanda_direccion_delivery +
                    "&comanda_telefono_delivery=" + comanda_telefono_delivery +
                    "&id_tipo_pago=" + id_tipo_pago +
                    "&tipo_venta=" + tipo_venta +
                    "&tipo_moneda=" + tipo_moneda +
                    "&serie=" + serie +
                    "&correlativo=" + correlativo +
                    "&tipo_moneda=" + tipo_moneda +
                    "&op_gravadas_=" + op_gravadas_ +
                    "&igv_=" + igv_ +
                    "&op_exoneradas_=" + op_exoneradas_ +
                    "&op_inafectas_=" + op_inafectas_ +
                    "&op_gratuitas_=" + op_gratuitas_ +
                    "&icbper_=" + icbper_ +
                    "&venta_total=" + venta_total +
                    "&pago_cliente=" + pago_cliente +
                    "&vuelto_=" + vuelto_ +
                    "&contenido_tipopago=" + contenido_tipopago +
                    "&partir_pago=" + partir_pago +
                    "&imprimir=" + imprimir +
                    "&gratis=" + gratis +
                    "&observacion_cortesia=" + observacion_cortesia +
                    "&id_mesa=" + id_mesa;

                $.ajax({
                    type:"POST",
                    url: urlweb + "api/Pedido/guardar_delivery_venta",
                    data: cadena,
                    dataType: 'json',
                    success:function (r) {
                        switch (r.result.code) {
                            case 1:
                                respuesta('¡Guardado con Exito!','success');
                                setTimeout(function () {
                                    location.href = urlweb +  'Pedido/historial_delivery';
                                }, 1000);
                                break;
                            case 2:
                                respuesta("Fallo el guardado, intentelo de nuevo", 'error');
                                break;
                            case 6:
                                respuesta("Algún dato fue ingresado de manera erronéa. Recargue la página por favor.",'error');
                                break;
                            default:
                                respuesta("ERROR DESCONOCIDO", 'error');
                        }
                    }
                });
            }
        }else{
            respuesta("El RUC debe tener 11 Dígitos", 'error');
        }

    }

    //INICIO - AGREGAR CLIENTE
    function tipo_documento(){
        var tipo_doc = $('#id_tipodocumento').val();
        if(tipo_doc != ""){
            if(tipo_doc != "4"){
                $('#div_razon_social').hide();
                $('#div_nombre').show();
                $('#cliente_razonsocial').val('');

            }else{
                $('#div_razon_social').show();
                $('#div_nombre').hide();
                $('#cliente_nombre').val('');
            }
            $("#div_direcciones").show();
            $("#div_telefono_correo").show();
        }else{
            $('#div_razon_social').hide();
            $('#div_nombre').hide();
            $("#div_direcciones").hide();
            $("#div_telefono_correo").hide();
        }
    }

    function consultar_documento(valor){
        var tipo_doc = $('#id_tipodocumento').val();

        if(tipo_doc == "2"){
            if(valor.length==8){
                ObtenerDatosDni(valor);
            }else{
                alert('El numero debe tener 8 digitos');
            }
        }else if(tipo_doc == "4"){
            if (valor.length==11){
                ObtenerDatosRuc(valor);
            }else{
                alert('El numero debe tener 11 digitos');
            }

        }
    }

    function consultar_documento_e(valor){
        var tipo_doc = $('#id_tipodocumento_e').val();
        if(tipo_doc == "2"){
            if(valor.length==8){
                ObtenerDatosDni_e(valor);
            }else{
                alert('El numero debe tener 8 digitos');
            }
        }else if(tipo_doc == "4"){
            if (valor.length==11){
                ObtenerDatosRuc_e(valor);
            }else{
                alert('El numero debe tener 11 digitos');
            }
        }
    }

    function ObtenerDatosDni(valor){
        var numero_dni =  valor;
        var cliente_nombre = 'cliente_nombre';

        $.ajax({
            type: "POST",
            url: urlweb + "api/Cliente/obtener_datos_x_dni",
            data: "numero_dni="+numero_dni,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(cliente_nombre, 'buscando...', true);
            },
            success:function (r) {
                cambiar_estado_boton(cliente_nombre, "", false);
                $("#cliente_nombre").val(r.result.name+ ' ' + r.result.first_name+ ' ' + r.result.last_name);
            }
        });
    }

    function ObtenerDatosRuc(valor){
        var numero_ruc =  valor;
        var cliente_razonsocial = 'cliente_razonsocial';

        $.ajax({
            type: "POST",
            url: urlweb + "api/Cliente/obtener_datos_x_ruc",
            data: "numero_ruc="+numero_ruc,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(cliente_razonsocial, 'buscando...', true);
            },
            success:function (r) {
                cambiar_estado_boton(cliente_razonsocial, "", false);
                $("#cliente_razonsocial").val(r.result.razon_social);
            }
        });
    }

    function ObtenerDatosDni_e(valor){
        var numero_dni =  valor;

        $.ajax({
            type: "POST",
            url: urlweb + "api/Cliente/obtener_datos_x_dni",
            data: "numero_dni="+numero_dni,
            dataType: 'json',
            success:function (r) {
                $("#cliente_nombre_e").val(r.result.name+ ' ' + r.result.first_name+ ' ' + r.result.last_name);
            }
        });
    }

    function ObtenerDatosRuc_e(valor){
        var numero_ruc =  valor;

        $.ajax({
            type: "POST",
            url: urlweb + "api/Cliente/obtener_datos_x_ruc",
            data: "numero_ruc="+numero_ruc,
            dataType: 'json',
            success:function (r) {
                $("#cliente_razonsocial_e").val(r.result.razon_social);
            }
        });
    }
    //FIN - AGREGAR CLIENTE
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
    function select_cortesia(){
        var  cortesia = $('#gratis').val();
        if(cortesia == 1){
            $('#div_observacion_cortesia').show();
        }else{
            $('#div_observacion_cortesia').hide();
        }
    }

</script>