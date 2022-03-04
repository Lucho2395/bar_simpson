<?php
/**
 * Created by PhpStorm
 * User: LuisSalazar
 * Date: 14/08/2021
 * Time: 12:50 a. m.
 */
?>
<?php
/**
 * Created by PhpStorm
 * User: LuisSalazar
 * Date: 10/08/2021
 * Time: 09:39 a. m.
 */
?>

<!--Modal para Productos-->
<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 80% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Listado de Productos</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <table id="dataTable2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Código</th>
                            <th style="width: 200px;">Producto</th>
                            <!--<th>Stock</th>-->
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>SubTotal</th>
                            <th>Descuento</th>
                            <th>Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($productos as $p){
                            $productnamefull = $p->producto_nombre;
                            ?>
                            <tr>
                                <td><?php echo $p->producto_codigo_barra;?></td>
                                <td><?php echo $productnamefull;?></td>
                                <!--<td><?php echo $p->producto_stock;?></td>-->
                                <td>S/. <input type="text" class="form-control" onchange="onchangeundprice<?php echo $p->id_producto_precio;?>()"  style="width: 80px;" onkeypress="return valida(event)" id="product_price<?php echo $p->id_producto_precio;?>" value="<?php echo $p->producto_precio_venta;?>"> </td>
                                <td><input type="text" class="form-control" onchange="onchangeund<?php echo $p->id_producto_precio;?>()" style="width: 70px;" id="total_product<?php echo $p->id_producto_precio;?>" onkeypress="return valida(event)" value="1"></td>
                                <td>S/. <input type="text" class="form-control" onchange="onchangetotalprice<?php echo $p->id_producto_precio;?>()"  style="width: 80px;" id="total_price<?php echo $p->id_producto_precio;?>" onkeypress="return valida(event)" value="<?php echo $p->producto_precio_venta;?>">
                                    <input type="hidden" id="tipo_igv<?php echo $p->id_producto_precio;?>" name="tipo_igv<?php echo $p->id_producto_precio;?>" value="<?php echo $p->producto_precio_codigoafectacion;?>">
                                </td>
                                <td><input type="text" class="form-control" onkeyup="calcular_descuento_producto_<?php echo $p->id_producto_precio;?>(this.value)" style="width: 70px;" id="product_descuento<?php echo $p->id_producto_precio;?>" onkeypress="return valida(event)" value=""></td>

                                <td><button class="btn btn-success btn-xs" type="button" onclick="agregarProducto<?php echo $p->id_producto_precio;?>(<?php echo $p->id_producto_precio;?>, '<?php echo $productnamefull;?>',<?php echo $p->id_unidad_medida;?>)"><i class="fa fa-check-circle"></i> Elegir Producto</button></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!--Modal para Clientes-->
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 80% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Clientes Registrados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <a style="float: right;" href="<?php echo _SERVER_;?>Cliente/inicio" class="btn btn-success"><i class="fa fa-pencil"></i> Cliente Nuevo</a>
                    <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                        <thead class="text-capitalize">
                        <tr>
                            <th>Nombre</th>
                            <th>DNI ó RUC </th>
                            <th>Dirección</th>
                            <th>Telefono o Celular</th>
                            <th>Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $a = 1;
                        foreach ($clientes as $m){
                            ?>
                            <tr>
                                <td><?php echo $m->cliente_nombre.$m->cliente_razonsocial;?></td>
                                <td><?php echo $m->cliente_numero;?></td>
                                <td><?php echo $m->cliente_direccion;?></td>
                                <td><?php echo $m->cliente_telefono;?></td>
                                <td><button type="button" class="btn btn-xs btn-success btne" onclick="agregarPersona('<?php echo $m->cliente_nombre.$m->cliente_razonsocial;?>','<?php echo $m->cliente_numero;?>','<?php echo $m->cliente_direccion;?>','<?= $m->cliente_telefono;?>','<?= $m->id_tipodocumento;?>')" ><i class="fa fa-check-circle"></i> Elegir Cliente</button></td>
                            </tr>
                            <?php
                            $a++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para asignar las cuotas de la venta-->
<div class="modal fade" id="basicModal_cuota" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Medio de Pago - CRÉDITO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="callout columns border-yellow">
                    <div class="row" id="total_importe_cuotas">

                    </div>
                    <div class="row" id="cuotas">

                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">Importe</label>
                            <input type="text" class="form-control" id="importe_cuota" onkeyup="return validar_numeros_decimales_dos(this.id)">
                        </div>
                        <div class="col-lg-4">
                            <label for="">Fecha de Cuota</label>
                            <input type="date" class="form-control" id="fecha_cuota">
                        </div>
                        <div class="col-lg-2">
                            <a id="btn_agregar_cuota" type="button" title="Agregar Cuota" class="btn btn-success" style="color: white; margin-top: 30px;" onclick="agregar_cuota()"><i class="fa fa-check margen"></i> Agregar</a>
                        </div>
                    </div>
                    <input type="hidden" id="contenido_cuota">
                    <!--<table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                        <thead class="text-capitalize">
                        <tr>
                            <th>Nombre</th>
                            <th>DNI ó RUC </th>
                            <th>Dirección</th>
                            <th>Telefono o Celular</th>
                            <th>Acción</th>
                        </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><button type="button" class="btn btn-xs btn-success btne"  ><i class="fa fa-check-circle"></i> Elegir Cliente</button></td>
                            </tr>

                        </tbody>
                    </table>-->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="limpiar_cuotas()">Limpiar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
    </div>

    <!-- /.row (main row) -->
    <section class="content" style="background-color: white;box-shadow: 10px 10px 15px #888888;border-radius: 30px; padding: 15px; margin: 20px; min-height: 500px">
        <div class="col-lg-12 col-md-12">
            <div class="col-lg-12 col-md-12" >
                <br>
                <center><h3 class="m-0 text"><strong>EDICIÓN VENTA DE PRODUCTOS</strong></h3></center>
                <input type="hidden" id="id_venta" value="<?= $id;?>">
                <input type="hidden" id="id_mesa" value="<?= $venta->id_mesa;?>">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-6">
                <hr>
                <div class="row">
                    <div class="col-lg-4">
                        <label for="client_address">Código de Barra:</label>
                        <input class="form-control" type="text" id="product_barcode" onkeyup="buscar_producto_barcode()">
                    </div>
                    <div class="col-lg-5">
                        <button style="width: 80%; margin-left: 10px; margin-top: 32px" class="btn btn-success" type="button" data-toggle="modal" data-target="#largeModal"><i class="fa fa-search"></i> Buscar Producto</button>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="tipo_moneda">Moneda</label><br>
                            <select class="form-control" id="tipo_moneda" name="tipo_moneda">
                                <option value="1" <?= ($venta->id_moneda==1)?'selected':'';?>>SOLES</option>
                                <option value="2" <?= ($venta->id_moneda==2)?'selected':'';?>>DOLARES</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <div id="general">
                    <div class="row" id="busqueda">
                        <div class="col-lg-12" style="text-align: center; font-size: 1.5rem">BÚSQUEDA DE PRODUCTOS - CÓDIGO DE BARRA</div>
                    </div>
                    <br>
                    <div class="row" id="detalle">
                        <!--<div class="col-lg-1"></div>-->
                        <div class="col-lg-7">
                            <label for="product_nameb">Nombre Producto:</label>
                            <input class="form-control" type="text" id="product_nameb" readonly>
                        </div>
                        <div class="col-lg-3">
                            <label for="id_productforsaleb">Cód. Producto:</label>
                            <input class="form-control" type="text" id="id_productforsaleb" readonly>
                        </div>
                        <div class="col-lg-2">
                            <label for="product_stockb">Stock:</label>
                            <input class="form-control" type="text" id="product_stockb" readonly>
                        </div>

                    </div><br>

                    <div class="row" id="detalle_">
                        <!--<div class="col-lg-1"></div>-->

                        <div class="col-lg-2">
                            <label for="product_cantb">Cantidad:</label>
                            <input class="form-control" type="text" id="product_cantb" onchange="onchangeundZ()" value="1" onkeypress="return valida(event);">
                        </div>
                        <div class="col-lg-2">
                            <label for="product_priceb">Precio(S/.):</label><br>
                            <input class="form-control" type="text"  onchange="onchangeundpriceZ()" id="product_priceb">
                        </div>
                        <div class="col-lg-2">
                            <label for="product_totalb">Total(S/.):</label><br>
                            <input class="form-control" type="text" id="product_totalb" onchange="onchangetotalpriceZ()">
                            <input type="hidden" id="codigo_afectacion" name="codigo_afectacion">
                        </div>
                        <div class="col-lg-2">
                            <label for="product_descuento">Descuento(S/.):</label><br>
                            <input class="form-control" type="text" id="product_descuento" onkeyup="calcular_descuento_producto(this.value)">
                        </div>
                        <div class="col-lg-4">
                            <br>
                            <button style="margin-top: 8px; width: 100%" class="btn btn-primary" type="button" onclick="agregarProductoZ()" ><i class="fa fa-plus"></i> Agregar Producto</button>
                        </div>
                    </div><br>
                </div>
                <div id="tabla_productos"></div><br>
            </div>
            <div class="col-lg-6">
                <hr>
                <div class="row">
                    <div class="col-lg-5">
                        <label>Tipo de Comprobante</label>
                        <select id="tipo_venta" class="form-control" onchange = "selecttipoventa_(this.value)">
                            <!--<option value="03">BOLETA</option>
                            <option value="01">FACTURA</option>-->
                            <option value= "">Seleccionar...</option>
                            <option value="20" <?= ($venta->venta_tipo == "20")?'selected':'';?> >NOTA DE VENTA</option>
                            <option value="03" <?= ($venta->venta_tipo == "03")?'selected':'';?> >BOLETA</option>
                            <option value="01" <?= ($venta->venta_tipo == "01")?'selected':'';?>>FACTURA</option>
                            <!--<option value= "07">NOTA DE CREDITO</option>
                            <option value= "08">NOTA DE DEBITO</option>-->
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label>Serie</label>
                        <select name="serie" id="serie" class="form-control" onchange="ConsultarCorrelativo()">
                            <option value="">Seleccionar</option>
                            <option value="13" selected><?= $venta->venta_serie;?></option>
                            <input type="hidden" id="serie_correlativo_notaventa" value="<?= $venta->venta_serie.'-'.$venta->venta_correlativo;?>">
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label>Numero</label>
                        <input class="form-control" type="text" id="numero" value="<?= $venta->venta_correlativo;?>" readonly>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-12" style="text-align: center">
                        <h4><strong>Datos del Cliente</strong></h4>
                    </div>
                </div>
                <div class="row">
                    <!--<div class="col-lg-2"></div>-->
                    <div class="col-lg-4">
                        <label>Tipo de Pago</label>
                        <select class="form-control" id="id_tipo_pago" name="id_tipo_pago" onchange="tipo_pago_credito()">
                            <?php
                            foreach ($tipo_pago as $tp){
                                ?>
                                <option <?php echo ($tp->id_tipo_pago == $venta->id_tipo_pago) ? 'selected' : '';?> value="<?php echo $tp->id_tipo_pago;?>"><?php echo $tp->tipo_pago_nombre;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label>Tipo Documento</label>
                        <select  class="form-control" name="select_tipodocumento" id="select_tipodocumento" onchange="select_tipodocumento(this.value)">
                            <option value="">Seleccionar...</option>
                            <?php
                            foreach ($tipos_documento as $td){
                                ($td->id_tipodocumento == $venta->id_tipodocumento)?$sele='selected':$sele='';
                                echo "<option value='".$td->id_tipodocumento."' ".$sele.">".$td->tipodocumento_identidad."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-4" style="margin-top: 8px">
                        <br>
                        <button class="btn btn-success" type="button" data-toggle="modal" data-target="#basicModal" style="width: 100%"><i class="fa fa-search"></i> Buscar Cliente</button>
                    </div>
                </div>
                <div class="row">
                    <!--<div class="col-lg-2"></div>-->
                    <div class="col-lg-4">
                        <label for="client_number">DNI ó RUC:</label>
                        <input class="form-control" type="text" id="client_number" value="<?= $venta->cliente_numero;?>" placeholder="Ingrese Número..." onchange="consultar_documento(this.value)">
                    </div>
                    <div class="col-lg-8">
                        <label for="client_name">Nombre:</label>
                        <input class="form-control" type="text" id="client_name" value="<?= $venta->cliente_nombre;?>" placeholder="Ingrese Razón Social...">
                    </div>

                </div>
                <div class="row">
                    <!--<div class="col-lg-2"></div>-->
                    <div class="col-lg-8">
                        <label for="client_address">Direccion:</label>
                        <textarea class="form-control" name="client_address" id="client_address" rows="2" placeholder="Ingrese Dirección Fiscal..."><?= $venta->cliente_direccion;?></textarea>
                        <!--<input class="form-control" type="text" id="client_address">-->
                    </div>
                    <div class="col-lg-4">
                        <label for="client_address">Telefono:</label>
                        <input class="form-control" type="text" id="client_telefono" value="<?= $venta->cliente_telefono;?>" placeholder="Ingrese Número telefonico...">
                    </div>
                </div><hr>
                <div class="row" style="text-align: center">
                    <!--<div class="col-lg-4"></div>-->
                    <div class="col-lg-12">
                        <button type="button" id="btn_generarventa" class="btn btn-danger" style="padding: 1.0rem; font-size: 1.0rem; width: 40%" onclick="preguntar('¿Está seguro que desea Editar esta Venta?','realizar_venta_editar','Si','No')">
                            <i class="fa fa-money"></i> GENERAR VENTA</button>
                    </div>
                </div>
            </div>
        </div>


    </section>
    <!-- /.content -->
</div>
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>venta.js"></script>
<script type="text/javascript">
    var contenido_cuota = "";
    <?php
    if($cuotas != ""){
    foreach ($cuotas as $c){ ?>
    contenido_cuota += <?= $c->venta_cuota_importe;?> + "-.-." + <?= $c->venta_cuota_fecha;?> + "/./.";
    <?php
    }
    }
    ?>

    $(document).ready(function(){
        $('#tabla_productos').load('<?php echo _SERVER_;?>Ventas/tabla_productos_editar');
        $("#product_barcode").focus();
        $("#credito_debito").hide();
        $("#mostrar").hide();
        $("#detalle").hide();
        $("#detalle_").hide();
        $("#busqueda").hide();
        $("#general").hide();
        var valor = $('#tipo_venta').val();
        //selecttipoventa_(valor);
        show();
    });
    var productfull = "";
    var unid = "";
    //  INICIO - MODAL CUOTAS
    function tipo_pago_credito(){
        var tipo_pago = $('#id_tipo_pago').val();
        if(tipo_pago == 5){
            $('#basicModal_cuota').modal('show');
        }
    }
    function agregar_cuota(){
        var valor = true;
        var importe = $('#importe_cuota').val();
        var fecha = $('#fecha_cuota').val();
        valor = validar_campo_vacio('importe_cuota', importe, valor);
        valor = validar_campo_vacio('fecha_cuota', fecha, valor);
        if(valor){
            if(importe != "" & fecha != ""){
                contenido_cuota += importe + "-.-." + fecha + "/./.";
                $('#contenido_cuota').val(contenido_cuota);
                show();
                clean();
            }else{
                respuesta('Debe llenar todos los campos','error');
            }
        }
    }
    function show(){
        var llenar = "";
        var llenar_total = "";
        var conteo = 1;
        var total = 0;
        if (contenido_cuota.length > 0){
            var filas = contenido_cuota.split('/./.');
            if (filas.length>0){
                for(var i=0; i<filas.length - 1; i++){
                    var celdas = filas[i].split('-.-.');
                    llenar += "<div class='col-lg-2'>" +
                        "<label>Cuota 0"+conteo+"</label>" +
                        "       </div>" +
                        "<div class='col-lg-4'>" +
                        "<label>Importe</label>" +
                        "<input type='text' class='form-control' value = "+celdas[0]+" readonly></div>"+
                        "<div class='col-lg-4'>"+
                        "<label >Fecha de Cuota</label>"+
                        "<input type='date' class='form-control' value = "+celdas[1]+" readonly>"+
                        "</div>"+
                        "<div class='col-lg-2'>"+
                        "<a id='btn_eliminar_cuota' type='button' title='Eliminar Cuota' class='btn btn-danger' style='color: white; margin-top: 30px;' onclick='quitar_cuota("+i+")'><i class='fa fa-ban'></i> Eliminar</a>"+
                        "</div>";
                    total = total + celdas[0] * 1;
                    conteo++;
                }
                llenar_total = "<div class='col-lg-4'>" +
                    "<label>TOTAL IMPORTE DE CUOTAS:</label>" +
                    "       </div>" +
                    "<div class='col-lg-4'>" +
                    "<label>S/. <span id='total_cuota'>"+total.toFixed(2)+"</span></label>";
            }
            $("#cuotas").html(llenar);
            $("#total_importe_cuotas").html(llenar_total);
        }
    }
    function quitar_cuota(ind) {
        var contenido_artificio ="";
        if (contenido_cuota.length>0){
            var filas=contenido_cuota.split('/./.');
            if(filas.length>0){
                for(var i=0;i<filas.length - 1;i++){
                    if(i!=ind){
                        var celdas =filas[i].split('-.-.');
                        contenido_artificio += celdas[0] + "-.-."+celdas[1] + "/./.";
                    }else{
                        var celdas =filas[i].split('-.-.');
                    }
                }
            }
        }
        contenido_cuota = contenido_artificio;
        show();
    }
    function clean(){
        $('#importe_cuota').val('');
        $('#fecha_cuota').val('');
    }
    function limpiar_cuotas(){
        $("#cuotas").html('');
        $("#contenido_cuota").val('');
        $("#importe_cuota").val('');
        $("#fecha_cuota").val('');
        $("#contenido_cuota").val('');
        $("#total_importe_cuotas").html('');
        contenido_cuota = '';
    }
    //FIN - MODAL CUOTAS
    function selecttipoventa_(valor){
        selecttipoventa(valor);
        if (valor == "07" || valor == "08"){
            $('#credito_debito').show();

            if(valor == "07"){
                $('#notaCredito').show();
                $('#notaDebito').hide();
            }else{
                $('#notaCredito').hide();
                $('#notaDebito').show();
            }
            var tipo_comprobante =  valor;

        } else{
            $('#credito_debito').hide();
            if(valor == "01"){
                $('#select_tipodocumento').val(4);
                $('#client_number').val('');
                $('#client_name').val('');
                $('#client_address').val('');
                $('#client_telefono').val('');
            }else{
                if(valor == "20"){
                    $('#select_tipodocumento').val(2);
                    $('#client_number').val("<?= $venta->cliente_numero;?>");
                    $('#client_name').val("<?= $venta->cliente_nombre;?>");
                    $('#client_address').val("<?= $venta->cliente_direccion;?>");
                    $('#client_telefono').val("<?= $venta->cliente_telefono;?>");
                }else{
                    $('#select_tipodocumento').val(2);
                    $('#client_number').val('11111111');
                    $('#client_name').val('PÚBLICO EN GENERAL');
                    $('#client_address').val('');
                    $('#client_telefono').val('');
                }

            }

        }
    }

    function calcular_vuelto(valor){
        var monto_cliente = valor;
        var monto_total = $('#montototal').val();
        var vuelto_sin_ = monto_cliente - monto_total;
        var vuelto_sin = vuelto_sin_.toFixed(2);
        //$('#pago_con').html(monto_cliente);
        $('#pago_con_').val(monto_cliente);
        $('#vuelto').html(vuelto_sin);
        $('#vuelto_').val(vuelto_sin);
    }

    function calcular_descuento_producto(valor){
        var cantidad = $('#product_cantb').val();
        var precio_u = $('#product_priceb').val();
        var monto_total = cantidad * precio_u;
        var valor_descuento = valor * 1;
        var total_ = monto_total - valor_descuento;
        //var total = total_.toFixed(2);
        $('#product_totalb').val(total_);
    }

    function recargar_productos() {
        $('#tabla_productos').load('<?php echo _SERVER_;?>Ventas/tabla_productos_editar');
    }

    <?php
    foreach ($productos as $p){
    ?>
    function agregarProducto<?php echo $p->id_producto_precio;?>(cod, producto, unids){
        var cant = $("#total_product<?php echo $p->id_producto_precio;?>").val() * 1;
        var precio = $("#product_price<?php echo $p->id_producto_precio;?>").val() * 1;
        var product_descuento = $("#product_descuento<?php echo $p->id_producto_precio;?>").val() * 1;
        var tipo_igv = $("#tipo_igv<?php echo $p->id_producto_precio;?>").val() * 1;
        var cadena = "codigo=" + cod +
            "&producto=" + producto +
            "&unids=" + unids +
            "&precio=" + precio +
            "&product_descuento=" + product_descuento +
            "&tipo_igv=" + tipo_igv +
            "&cantidad=" + cant;
        if(cant > 0){
            $.ajax({
                type:"POST",
                url: urlweb + "api/Ventas/addproduct",
                data : cadena,
                success:function (r) {
                    switch (r) {
                        case "1":
                            respuesta('¡Producto Agregado!', 'success');
                            $('#tabla_productos').load(urlweb + 'Ventas/tabla_productos');
                            break;
                        case "2":
                            respuesta('Hubo Un Error');
                            break;
                        case "3":
                            respuesta('El Producto YA ESTA AGREGADO', 'error');
                            break;
                        default:
                            respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                            break;
                    }
                }
            });
        } else {
            respuesta('NO HAY STOCK DISPONIBLE','error');
        }

    }

    function onchangeund<?php echo $p->id_producto_precio;?>() {
        var cant = $("#total_product<?php echo $p->id_producto_precio;?>").val();
        var precio = $("#product_price<?php echo $p->id_producto_precio;?>").val();
        var subtotal = cant * precio;
        subtotal.toFixed(2);
        $("#total_price<?php echo $p->id_producto_precio;?>").val(subtotal);
    }

    function onchangeundprice<?php echo $p->id_producto_precio;?>() {
        var cant = $("#total_product<?php echo $p->id_producto_precio;?>").val();
        var precio = $("#product_price<?php echo $p->id_producto_precio;?>").val();
        var subtotal = cant * precio;
        subtotal.toFixed(2);
        subtotal = parseFloat(subtotal);
        $("#total_price<?php echo $p->id_producto_precio;?>").val(subtotal);
    }

    function onchangetotalprice<?php echo $p->id_producto_precio;?>() {
        var subtotal = $("#total_price<?php echo $p->id_producto_precio;?>").val();
        var cant = $("#total_product<?php echo $p->id_producto_precio;?>").val();
        var precio = subtotal / cant;
        precio.toFixed(2);
        $("#product_price<?php echo $p->id_producto_precio;?>").val(precio);
    }
    function calcular_descuento_producto_<?php echo $p->id_producto_precio;?>(valor){
        var cantidad = $('#total_product<?php echo $p->id_producto_precio;?>').val();
        var precio_u = $('#product_price<?php echo $p->id_producto_precio;?>').val();
        var monto_total = cantidad * precio_u;
        var valor_descuento = valor * 1;
        var total_ = monto_total - valor_descuento;
        //var total = total_.toFixed(2);
        $('#total_price<?php echo $p->id_producto_precio;?>').val(total_);
    }
    <?php
    }
    ?>

    function agregarPersona(nombre, numero, direccion, telefono, id_tipodocumento) {
        $("#client_number").val(numero);
        $("#client_name").val(nombre);
        $("#client_address").val(direccion);
        $("#client_telefono").val(telefono);
        $("#select_tipodocumento").val(id_tipodocumento);
        respuesta('El cliente se agregó correctamente!','success');

    }

    function onchangeundZ() {
        var cant = $("#product_cantb").val();
        var precio = $("#product_priceb").val();
        var subtotal = cant * precio;
        subtotal.toFixed(2);
        $("#product_totalb").val(subtotal);
    }

    function onchangeundpriceZ() {
        var cant = $("#product_cantb").val();
        var precio = $("#product_priceb").val();
        var subtotal = cant * precio;
        subtotal.toFixed(2);
        subtotal = parseFloat(subtotal);
        $("#product_totalb").val(subtotal);
    }

    function onchangetotalpriceZ() {
        var subtotal = $("#product_totalb").val();
        var cant = $("#product_cantb").val();
        var precio = subtotal / cant;
        precio.toFixed(2);
        $("#product_priceb").val(precio);
    }

    function buscar_producto_barcode() {
        var valor = "correcto";
        var product_barcode = $('#product_barcode').val();
        if(product_barcode == ""){
            alertify.error('El campo Código de Barra está vacío');
            $('#product_barcode').css('border','solid red');
            valor = "incorrecto";
        } else {
            $('#product_barcode').css('border','');
        }

        if (valor == "correcto"){
            var cadena = "product_barcode=" + product_barcode;
            $.ajax({
                type:"POST",
                url: urlweb + "api/Ventas/search_by_barcode",
                data: cadena,
                success:function (r) {
                    if(r=="2"){
                        alertify.error("ERROR O PRODUCTO NO REGISTRADO");
                        $('#product_nameb').val('');
                        $('#id_productforsaleb').val('');
                        $('#product_stockb').val('');
                        $('#product_priceb').val('');
                        $('#product_totalb').val('');
                        $('#codigo_afectacion').val('');
                        $('#product_cantb').val(1);
                        productfull = "";
                        unid = "";
                    } else {
                        var productoinfo = r.split('|');
                        var fullproductname = productoinfo[0];
                        productfull = fullproductname;
                        unid =  productoinfo[1];
                        $('#product_nameb').val(fullproductname);
                        $('#id_productforsaleb').val(productoinfo[3]);
                        $('#product_stockb').val(productoinfo[2]);
                        $('#product_priceb').val(productoinfo[5]);
                        $('#product_totalb').val(productoinfo[5]);
                        $('#product_cantb').val(1);
                        $('#codigo_afectacion').val(productoinfo[7]);
                        $("#busqueda").show();
                        $("#detalle").show();
                        $("#detalle_").show();
                        $("#general").show();
                        //$("#mostrar").show();
                        respuesta('PRODUCTO ENCONTRADO');
                    }
                }
            });
        }
    }

    function agregarProductoZ() {
        var cod = $('#id_productforsaleb').val();
        var cant = $("#product_cantb").val() * 1;
        var precio = $("#product_priceb").val() * 1;
        var stock = $("#product_stockb").val() * 1;
        var product_descuento = $("#product_descuento").val() * 1;
        var tipo_igv = $("#codigo_afectacion").val();
        var cadena = "codigo=" + cod +
            "&producto=" + productfull +
            "&unids=" + unid +
            "&precio=" + precio +
            "&cantidad=" + cant +
            "&product_descuento=" + product_descuento +
            "&tipo_igv=" + tipo_igv;

        if(stock >= cant){
            $.ajax({
                type:"POST",
                url: urlweb + "api/Ventas/addproduct",
                data : cadena,
                success:function (r) {
                    switch (r) {
                        case "1":
                            respuesta('Producto Agregado');
                            $('#tabla_productos').load(urlweb + 'Ventas/tabla_productos');
                            $('#product_nameb').val('');
                            $('#id_productforsaleb').val('');
                            $('#product_stockb').val('');
                            $('#product_priceb').val('');
                            $('#product_totalb').val('');
                            $('#product_barcode').val('');
                            $('#codigo_afectacion').val('');
                            $('#product_descuento').val('');
                            productfull = "";
                            unid = "";
                            $("#product_barcode").focus();
                            $("#general").hide();
                            break;
                        case "2":
                            respuesta('Hubo Un Error','error');
                            break;
                        case "3":
                            respuesta('El Producto YA ESTA AGREGADO','error');
                            break;
                        default:
                            respuesta('Hubo Un Error','error');
                            break;
                    }
                }
            });
        } else {
            respuesta('NO HAY STOCK DISPONIBLE','error');
        }

    }

    function selecttipoventa(valor){
        Consultar_serie();
        var tipo_comprobante =  valor;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Ventas/tipo_nota_descripcion",
            data: "tipo_comprobante="+tipo_comprobante,
            dataType: 'json',
            success:function (r) {
                $("#nota_descripcion").html(r);
            }
        });
    }
    function select_tipodocumento(valor){
        if (valor == "4"){
            $('#tipo_venta').val('01');
            selecttipoventa_('01');
        }else {
            $('#tipo_venta').val('03');
            selecttipoventa_('03');
        }
    }

    function Consultar_serie(){
        //var tipo_documento_modificar = $('#Tipo_documento_modificar').val();
        var tipo_venta =  $("#tipo_venta").val();
        var concepto = "LISTAR_SERIE";
        var cadena = "tipo_venta=" + tipo_venta +
            "&concepto=" + concepto;
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
            url: urlweb + "api/Ventas/consultar_serie",
            data: cadena,
            dataType: 'json',
            success:function (r) {
                if(id_serie !='13'){
                    $("#numero").val(r.correlativo);
                }else{
                    $("#numero").val(<?= $venta->venta_correlativo?>);
                }

            }

        });
    }

    function consultar_documento(valor){
        var tipo_doc = $('#select_tipodocumento').val();
        if(tipo_doc == "2"){
            if(valor.length == "8"){
                ObtenerDatosDni(valor);
            }else{
                respuesta('Tiene que tener 8 dígitos en total el DNI', 'error');
            }
        }else if(tipo_doc == "4"){
            if(valor.length == "11"){
                ObtenerDatosRuc(valor);
            }else{
                respuesta('Tiene que tener 11 dígitos en total el RUC', 'error');
            }

        }
    }

    function ObtenerDatosDni(valor){
        var numero_dni =  valor;

        $.ajax({
            type: "POST",
            url: urlweb + "api/Cliente/obtener_datos_x_dni",
            data: "numero_dni="+numero_dni,
            dataType: 'json',
            success:function (r) {
                $("#client_name").val(r.result.name+ ' ' + r.result.first_name+ ' ' + r.result.last_name);
            }
        });
    }

    function ObtenerDatosRuc(valor){
        var numero_ruc =  valor;

        $.ajax({
            type: "POST",
            url: urlweb + "api/Cliente/obtener_datos_x_ruc",
            data: "numero_ruc="+numero_ruc,
            dataType: 'json',
            success:function (r) {
                $("#client_name").val(r.result.razon_social);
            }
        });
    }

    function editar_cantidad_tabla(id){
        var valor_nueva_cantidad = $("#valor_nueva_cantidad").val();

        var cadena = "valor_nueva_cantidad=" + valor_nueva_cantidad + "&id=" + id;
        $.ajax({
            type:"POST",
            url: urlweb + "api/Ventas/editar_cantidad_tabla",
            data : cadena,
            success:function (r) {
                switch (r) {
                    case "1":
                        respuesta('¡Editado correctamente!', 'success');
                        $('#tabla_productos').load(urlweb + 'Ventas/tabla_productos_editar');
                        break;
                    case "2":
                        respuesta('Hubo Un Error al editar');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }

</script>