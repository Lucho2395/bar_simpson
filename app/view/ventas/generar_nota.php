<?php
/**
 * Created by PhpStorm
 * User: LuisSalazar
 * Date: 07/05/2021
 * Time: 01:05 p. m.
 */
?>
<div class="modal fade" id="basicModal_cliente" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="modal-title" id="myModalLabel">Clientes Registrados</h4>
                        </div>
                        <div class="col-lg-6">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <a style="float: right" href="<?php echo _SERVER_;?>Cliente/inicio" class="btn btn-danger"><i class="fa fa-pencil"></i> Cliente Nuevo</a>
                    <br>
                    <table id="example2" class="table table-bordered table-hover">
                        <thead class="text-capitalize">
                        <tr>
                            <th>Nombre</th>
                            <th>DNI ó RUC </th>
                            <th>Dirección</th>
                            <th>Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $a = 1;
                        foreach ($cliente as $m){
                            if($m->id_tipodocumento == 4){
                                $nombre = $m->cliente_razonsocial;
                            }else{
                                $nombre = $m->cliente_nombre. ' ' .$m->cliente_apellido_paterno. ' ' .$m->cliente_apellido_materno;
                            }
                            ?>
                            <tr>
                                <td><?php echo $nombre;?></td>
                                <td><?php echo $m->cliente_numero;?></td>
                                <td><?php echo $m->cliente_direccion;?></td>
                                <td><a type="button" class="btn btn-xs btn-success btne" style="color: white;" onclick="agregarPersona('<?php echo $nombre;?>','<?php echo $m->cliente_numero;?>','<?php echo $m->cliente_direccion;?>', <?= $m->id_cliente;?>)" ><i class="fa fa-check-circle"></i> Elegir Cliente</a></td>
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
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
    </div>

    <!-- /.row (main row) -->
    <section class="content" style="background-color: white;box-shadow: 10px 10px 15px #888888;border-radius: 30px; padding: 15px; margin: 50px; min-height: 500px">
        <div class="col-lg-12 col-md-12">
            <div class="col-lg-12 col-md-12" >
                <center><h3 class="m-0 text"><strong>Notas de Crédito/Débito</strong></h3></center>
                <br>
            </div>
        </div>
        <div class="row" id="credito_debito">
            <div class="col-lg-1"></div>
            <div class="col-lg-3">
                <label>Tipo de Comprobante</label>
                <select id="tipo_venta" class="form-control" onchange = "selecttipoventa(this.value)">
                    <!--<option value="03">BOLETA</option>
                    <option value="01">FACTURA</option>-->
                    <option value= "">Seleccionar...</option>
                    <option value= "07">NOTA DE CREDITO</option>
                    <option value= "08">NOTA DE DEBITO</option>
                </select>
            </div>
            <div class="col-lg-2">
                <label>Serie</label>
                <select name="serie_nota" id="serie_nota" class="form-control" onchange="ConsultarCorrelativo()">
                    <option value="">Seleccionar</option>
                </select>
            </div>
            <div class="col-lg-2">
                <label>Numero</label>
                <input class="form-control" type="text" id="numero_nota" readonly>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="tipo_moneda">Moneda</label><br>
                    <select class="form-control" id="tipo_moneda" name="tipo_moneda">
                        <option value="1">SOLES</option>
                        <option value="2">DOLARES</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" style="text-align: center">
                <h5><strong>Datos del Cliente</strong></h5>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-2">
                <input type="hidden" id="id_cliente" value="<?= $venta->id_cliente;?>">
                <input type="hidden" id="id_mesa" value="<?= $venta->id_mesa;?>">
                <input type="hidden" id="id_venta" value="<?= $venta->id_venta;?>">
                <label for="cliente_documento">DNI ó RUC:</label>
                <input class="form-control" type="text" id="cliente_documento" value="<?= $venta->cliente_numero?>">
            </div>
            <div class="col-lg-5">
                <label for="cliente_nombre">Nombre:</label>
                <textarea class="form-control" id="cliente_nombre"><?= (($venta->id_tipodocumento == 2)? $venta->cliente_nombre : $venta->cliente_razonsocial); ?></textarea>
                <!--<input class="form-control" type="text" id="cliente_nombre" value="<?= (($venta->id_tipodocumento == 2)? $venta->cliente_nombre.' '.$venta->cliente_apellido_paterno.' '.$venta->cliente_apellido_materno : $venta->cliente_razonsocial); ?>">-->
            </div>
            <div class="col-lg-2" style="margin-top: 10px;">
                <br>
                <a class="btn btn-success" type="button"  data-toggle="modal" data-target="#basicModal_cliente" style="color: white"><i class="fa fa-search"></i> Buscar Cliente</a>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-7">
                <label for="cliente_direccion">Direccion:</label>
                <textarea class="form-control" id="cliente_direccion"><?= $venta->cliente_direccion;?></textarea>
            </div>
            <div class="col-lg-2" >
                <div class="form-group">
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
            </div>

        </div>

        <!-- fila del servicio -->
        <br>
        <div class="row" >
            <div class="col-lg-1"></div>
            <div class="col-lg-3" >
                <label>Documento a modificar</label>
                <select name="" class="form-control" id="Tipo_documento_modificar" disabled>
                    <option <?= (($venta->venta_tipo == '03')?$selec='selected':$selec=''); ?> value="03">BOLETA</option>
                    <option <?= (($venta->venta_tipo == '01')?$selec='selected':$selec=''); ?> value="01">FACTURA</option>
                </select>
            </div>
            <div class="col-lg-2" id="serie">
                <label>Serie</label>
                <input class="form-control" type="text" id="serie_modificar" value="<?= $venta->venta_serie;?>" readonly>
            </div>
            <div class="col-lg-2" id="numero">
                <label>Numero</label>
                <input class="form-control" type="text" id="numero_modificar" value="<?= $venta->venta_correlativo;?>" readonly>
            </div>
            <div class="col-lg-3" id="nota_descripcion">
            </div>
            <div class="col-lg-1"></div>
        </div>
        <br>
        <dvi class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-7">
                <label for="pago_observacion">Observación</label><br>
                <textarea name="pago_observacion" class="form-control" id="pago_observacion" rows="2"></textarea>
            </div>
            <!--<div class="col-lg-2" style="margin-top: 30px">
                <a class="btn btn-success btn-xs" type="button"  data-toggle="modal" data-target="#basicModal_servicios" style="color: white"><i class="fa fa-search"></i> Buscar Servicio</a>
            </div><br><br>-->
        </dvi>
        <br>
        <!-- /.row (main row) de la tabla -->
        <div class="row">
            <div class="col-lg-1">
                <input type="hidden" id="contenido" name="contenido">
            </div>
            <div class="form-group col-md-10">
                <table class="table table-bordered table-hover" style="border-color: black">
                    <thead>
                    <tr style="font-weight: bold;text-align: center; background-color: #ebebeb">
                        <td>#</td>
                        <td>PRODUCTO</td>
                        <td>VALOR U.</td>
                        <td>CANT</td>
                        <td>SUB TOTAL</td>
                        <td>ACCIÓN</td>
                    </tr>
                    </thead>
                    <tbody id="contenido_detalle_compra">
                    </tbody>
                    <tr>
                        <td id="conteo">1</td>
                        <td>
                            <select name="id_producto" id="id_producto" class="form-control" onchange="select_producto()">
                                <option value="">Seleccionar...</option>
                                <?php
                                foreach ($productos as $p){ ?>
                                    <option value="<?= $p->id_producto_precio;?>"><?= $p->producto_nombre. ' | '.$p->producto_precio_venta. ' | ' .$p->producto_precio_codigoafectacion. ' | ' .$p->id_receta;?></option>
                                <?php
                                }
                                ?>

                            </select>
                            <input type="hidden" name="tipo_afectacion">
                        </td>
                        <td>
                            <input type="text" class="form-control" id="valor_u" onkeyup="calcular_subtotal()">
                        </td>
                        <td>
                            <input type="text" class="form-control" id="cant" value="1" onkeyup="calcular_subtotal()">
                        </td>
                        <td>
                            <input type="text" class="form-control" id="sub_total" readonly>
                        </td>
                        <td>
                            <a style="color:#fff;font-weight: bold;font-size: large" onclick="add_carrito()" class="btn btn-success"><i class="fa fa-check"></i></a>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-8" style="text-align: right">
                <label for="" style="font-size: 14px;">OP. GRAVADAS</label><br>
                <label for="" style="font-size: 14px;">IGV(18%)</label><br>
                <label for="" style="font-size: 14px;">OP. EXONERADAS</label><br>
                <label for="" style="font-size: 14px;">OP. INAFECTAS</label><br>
                <label for="" style="font-size: 14px;">OP. GRATUITAS</label><br>
                <label for="" style="font-size: 14px;">ICBPER</label><br>
                <label for="" style="font-size: 17px;"><strong>TOTAL</strong></label><br>
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
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8"></div>
            <div class="col-lg-4">
                <a type="button" id = "btn_generarventa" class="btn btn-danger" style="color: white; margin-top: 8px" onclick="preguntar('¿Está seguro que desea generar esta Nota?','generar_nota','Si','No');">
                    <i class="fa fa-money"></i> Generar Pago</a>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>venta.js"></script>
<script type="text/javascript">
    var contenido = "";
    var conteo = 1;
    $(document).ready(function(){
        $("#id_producto").select2();
    });

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
    function Consultar_serie(){
        var tipo_documento_modificar = $('#Tipo_documento_modificar').val();
        var tipo_venta =  $("#tipo_venta").val();
        var concepto = "LISTAR_SERIE";
        var cadena = "tipo_venta=" + tipo_venta +
            "&concepto=" + concepto +
            "&tipo_documento_modificar=" + tipo_documento_modificar;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Ventas/consultar_serie",
            data: cadena,
            dataType: 'json',
            success:function (r) {
                var series = "";
                //var series = "<option value='' selected>Seleccione</option>";
                for (var i=0; i<r.serie.length; i++){
                    series += "<option value='"+r.serie[i].id_serie+"'>"+r.serie[i].serie+"</option>"
                }
                $("#serie_nota").html(series);
                ConsultarCorrelativo();
            }

        });
    }
    function ConsultarCorrelativo(){
        var id_serie =  $("#serie_nota").val();
        var concepto = "LISTAR_NUMERO";
        var cadena = "id_serie=" + id_serie +
            "&concepto=" + concepto;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Ventas/consultar_serie",
            data: cadena,
            dataType: 'json',
            success:function (r) {
                $("#numero_nota").val(r.correlativo);
            }

        });
    }
    function select_producto(){
        var id_producto = $('#id_producto').val();
        if(id_producto != ""){
            var producto = $("select[name='id_producto'] option:selected").text();
            var producto_ = producto.split(' | ');
            $('#valor_u').val(producto_[1]);
            //$('#tipo_afectacion').val(producto_[2]);
            calcular_subtotal();

        }
    }
    function calcular_subtotal(){
        var valor_u = $('#valor_u').val();
        var cant = $('#cant').val();
        var total = valor_u * cant;
        $('#sub_total').val(total.toFixed(2));
    }
    function add_carrito(){
        var id_producto = $('#id_producto').val();
        if(id_producto != ""){
            var producto = $("select[name='id_producto'] option:selected").text();
            var producto_ = producto.split(' | ');
            var nombre_producto = producto_[0];
            var tipo_afectacion = producto_[2];
            var receta_bolsa = producto_[3];
        }
        var cant = $("#cant").val();
        var precio_unit = $("#valor_u").val();
        var sub_total = $("#sub_total").val();
        //var tipo_afectacion = $("#tipo_afectacion").val();
        if(cant > 0){
            if(cant != "" && precio_unit != "" && sub_total != ""){
                contenido += id_producto + "-.-." + nombre_producto+ "-.-." + precio_unit+ "-.-." + cant+ "-.-." + sub_total + "-.-." + tipo_afectacion + "-.-." + receta_bolsa +"/./.";
                show_table();
                clean();
            }else{
                respuesta('Ingrese todos los campos', 'error');
            }

        }else{
            respuesta('La cantidad debe ser mayor que 0', 'error');
        }
    }
    function show_table(){
        var llenar="";
        var monto_gravada = 0;
        var monto_exonerada = 0;
        var monto_inafecta = 0;
        var monto_gratuita = 0;
        var monto_igv = 0;
        var mon_igv = 0;
        var igv_porcentaje = 0.18;
        var total_pedido_detalle = 0;
        var fecha = new Date();
        var total_icbper = 0.00;
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
                conteo=1;
                for(var i=0;i<filas.length - 1;i++){
                    var celdas =filas[i].split('-.-.');
                    llenar += "<tr><td>"+conteo+"</td>"+
                        "<td>"+celdas[1]+"</td>"+
                        "<td>"+celdas[2]+"</td>"+
                        "<td>"+celdas[3]+"</td>"+
                        "<td>"+celdas[4]+"</td>"+
                        "<td><a data-toggle=\"tooltip\" onclick='delete_detallesi("+i+")' title=\"Eliminar\" type=\"button\" class=\"text-danger\" ><i class=\"fa fa-times ver_detalle\"></i></a></td>"+
                        "</tr>";
                    conteo++;
                    var subtotal = celdas[3] * celdas[2] * 1;
                    var cantidad = celdas[3] * 1;
                    if(celdas[5] == "10"){
                        monto_gravada = monto_gravada + subtotal;
                        mon_igv = mon_igv + monto_gravada * igv_porcentaje * 1;

                        total_pedido_detalle = total_pedido_detalle + subtotal + mon_igv;
                    }
                    if(celdas[5] == "20"){
                        monto_exonerada = monto_exonerada + subtotal * 1;
                        total_pedido_detalle = total_pedido_detalle + subtotal * 1;
                    }
                    if(celdas[5] == "30"){
                        monto_inafecta = monto_inafecta + subtotal;
                        total_pedido_detalle = total_pedido_detalle + subtotal;
                    }
                    if(celdas[5] == "21"){
                        monto_gratuita = monto_gratuita + subtotal;
                        //total_pedido_detalle = total_pedido_detalle + subtotal;
                    }
                    if(celdas[6] == "131"){
                        icbper = icbper * cantidad;
                        total_icbper = icbper;
                        total_pedido_detalle = total_pedido_detalle + icbper;
                    }

                }
            }
            $('#op_gravadas').html(monto_gravada.toFixed(2));
            $('#op_gravadas_').val(monto_gravada.toFixed(2));
            $('#igv').html(mon_igv.toFixed(2));
            $('#igv_').val(mon_igv.toFixed(2));
            $('#op_exoneradas').html(monto_exonerada.toFixed(2));
            $('#op_exoneradas_').val(monto_exonerada.toFixed(2));
            $('#op_inafectas').html(monto_inafecta.toFixed(2));
            $('#op_inafectas_').val(monto_inafecta.toFixed(2));
            $('#op_gratuitas').html(monto_gratuita.toFixed(2));
            $('#op_gratuitas_').val(monto_gratuita.toFixed(2));
            $('#icbper').html(total_icbper.toFixed(2));
            $('#icbper_').val(total_icbper.toFixed(2));
            $('#venta_total').html(total_pedido_detalle.toFixed(2));
            $('#venta_total_').val(total_pedido_detalle.toFixed(2));
            $('#contenido_detalle_compra').html(llenar);
            $('#contenido').val(contenido);
        }
    }
    function clean() {
        $("#cant").val("1");
        $("#id_producto").val("");
        $("#valor_u").val("");
        $("#sub_total").val("");

        $("#id_producto option[value='']").attr('selected','selected');
        $("#id_producto").val("");
        $("#id_producto").select2().trigger('change');
    }
    function delete_detallesi(ind) {
        var contenido_artificio ="";
        var id_producto =0;
        if (contenido.length>0){
            var filas=contenido.split('/./.');
            if(filas.length>0){
                for(var i=0;i<filas.length - 1;i++){
                    if(i!=ind){
                        var celdas =filas[i].split('-.-.');
                        contenido_artificio += celdas[0] + "-.-."+celdas[1] + "-.-." + celdas[2] + "-.-." + celdas[3] + "-.-."  + celdas[4] + "-.-." + celdas[5] + "-.-." + celdas[6] + "/./.";
                    }else{
                        var celdas =filas[i].split('-.-.');
                        id_producto=celdas[0];
                    }
                }
            }
        }
        contenido = contenido_artificio;
        show_table();
    }
    function agregarPersona(nombre, numero, direccion, id_cliente){
        $('#cliente_documento').val(numero);
        $('#cliente_nombre').val(nombre);
        $('#cliente_direccion').val(direccion);
        $('#id_cliente').val(id_cliente);
        respuesta('El Cliente fue agregado', 'success')
    }
    function generar_nota(){
        var valor = true;
        var id_cliente = $('#id_cliente').val();
        var id_mesa = $('#id_mesa').val();
        var id_venta = $('#id_venta').val();
        var id_tipo_pago = $('#id_tipo_pago').val();
        var tipo_venta = $('#tipo_venta').val();
        var tipo_moneda = $('#tipo_moneda').val();
        var serie = $('#serie_nota').val();
        var correlativo = $('#numero_nota').val();
        var documento_mod = $('#Tipo_documento_modificar').val();
        var serie_modificar = $('#serie_modificar').val();
        var numero_modificar = $('#numero_modificar').val();
        var notatipo_descripcion = $('#notatipo_descrpcion').val();
        var op_gravadas_ = $('#op_gravadas_').val();
        var igv_ = $('#igv_').val();
        var op_exoneradas_ = $('#op_exoneradas_').val();
        var op_inafectas_ = $('#op_inafectas_').val();
        var op_gratuitas_ = $('#op_gratuitas_').val();
        var icbper_ = $('#icbper_').val();
        var venta_total = $('#venta_total_').val();
        var pago_observacion = $('#pago_observacion').val();
        var contenido = $('#contenido').val();

        valor = validar_campo_vacio('id_cliente', id_cliente, valor);
        valor = validar_campo_vacio('id_mesa', id_mesa, valor);
        valor = validar_campo_vacio('tipo_venta', tipo_venta, valor);
        valor = validar_campo_vacio('serie_nota', serie, valor);
        valor = validar_campo_vacio('numero_nota', correlativo, valor);
        valor = validar_campo_vacio('notatipo_descrpcion', notatipo_descripcion, valor);
        valor = validar_campo_vacio('contenido', contenido, valor);
        valor = validar_campo_vacio('venta_total_', venta_total, valor);

        if(valor){
            var cadena = "id_cliente=" + id_cliente +
                "&contenido=" + contenido +
                "&id_tipo_pago=" + id_tipo_pago +
                "&tipo_venta=" + tipo_venta +
                "&tipo_moneda=" + tipo_moneda +
                "&serie=" + serie +
                "&correlativo=" + correlativo +
                "&documento_mod=" + documento_mod +
                "&serie_modificar=" + serie_modificar +
                "&numero_modificar=" + numero_modificar +
                "&notatipo_descripcion=" + notatipo_descripcion +
                "&op_gravadas_=" + op_gravadas_ +
                "&igv_=" + igv_ +
                "&op_exoneradas_=" + op_exoneradas_ +
                "&op_inafectas_=" + op_inafectas_ +
                "&op_gratuitas_=" + op_gratuitas_ +
                "&icbper_=" + icbper_ +
                "&venta_total=" + venta_total +
                "&pago_observacion=" + pago_observacion +
                "&id_venta=" + id_venta +
                "&id_mesa=" + id_mesa;
            $.ajax({
                type: "POST",
                url: urlweb + "api/Ventas/guardar_nota",
                data: cadena,
                dataType: 'json',
                success: function (r) {
                    switch (r.result.code) {
                        case 1:
                            respuesta('¡Venta realizada correctamente!', 'success');
                            setTimeout(function () {
                                location.href = urlweb +  'Ventas/historial_ventas';
                            }, 1000);
                            break;
                        case 2:
                            respuesta('Error al generar Venta', 'error');
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