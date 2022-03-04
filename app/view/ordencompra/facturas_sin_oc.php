
<div class="modal fade" id="gestionProveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar/Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="gestionarInfoProveedor">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="proveedor">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Negocio</label>
                                        <select class="form-control" id= "id_negocio" name="id_negocio">
                                            <option value="">Seleccionar Negocio</option>
                                            <?php
                                            foreach($negocio as $n){
                                                ?>
                                                <option value="<?php echo $n->id_negocio;?>"><?php echo $n->negocio_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
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
                                        <input class="form-control" type="text" id="proveedor_ruc" onchange="consultar_documento(this.value)" onkeyup="return validar_numeros(this.id)" name="proveedor_ruc" maxlength="15" placeholder="Ingrese Numero...">
                                    </div>
                                </div>
                            </div>
                            <div id="div_razon_social">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Nombre Proveedor</label>
                                            <input class="form-control" type="text" id="proveedor_nombre" name="proveedor_nombre" maxlength="200" placeholder="Ingrese Información...">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Nombre Del Contacto</label>
                                            <input class="form-control" type="text" id="proveedor_nombre_contacto" name="proveedor_nombre_contacto" maxlength="200" placeholder="Ingrese Información...">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Cargo Del Contacto</label>
                                            <input class="form-control" type="text" id="proveedor_cargo_persona" name="proveedor_cargo_persona" maxlength="200" placeholder="Ingrese Información...">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Número de Teléfono</label>
                                            <input class="form-control" type="text" id="proveedor_numero" onkeyup="return validar_numeros(this.id)" name="proveedor_numero" maxlength="9" placeholder="Ingrese Información...">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Dirección</label>
                                            <textarea class="form-control" type="text" id="proveedor_direccion" name="proveedor_direccion" maxlength="200" placeholder="Ingrese Información..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="limpiar()" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-agregar-proveedor"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
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
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6"></div>
                <div class="col-lg-2">
                    <button style="width: 100%" onclick="recargar_recursos()" class="btn btn-primary"><i class="fa fa-refresh"></i> Actualizar</button>
                </div>
                <div class="col-lg-2 col-sm-3 col-md-3 col-xs-3">
                    <button style="width: 100%" data-toggle="modal" data-target="#gestionProveedor" class="btn btn-success"><i class="fa fa-plus"></i> Proveedor</button>
                </div>
                <div class="col-lg-2 col-sm-3 col-md-3 col-xs-3">
                    <a href="<?= _SERVER_ ?>Ordencompra/ver_facturas" type="button" class="btn btn-success" style="width: 100%"><i class="fa fa-eye"></i> Ver Facturas</a>
                </div>
            </div>
            <br>
            <form enctype="multipart/form-data" id="facturas_sin_oc">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h4 class="m-0 font-weight-bold text-primary">Iniciar solicitud para Orden de Compra</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" id="contenido" name="contenido">
                            <input type="hidden" id="contenido_o" name="contenido_o">
                            <div class="col-lg-3">
                                <label class="col-form-label ">Proveedor</label>
                                <select id="id_proveedor" class="form-control" name="id_proveedor">
                                    <option value="">Seleccione</option>
                                    <?php
                                    foreach ($proveedor as $p){
                                        ?><option class="show2_<?= $p->id_proveedor; ?>" value="<?php echo $p->id_proveedor;?>"><?php echo $p->proveedor_nombre; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label class="col-form-label ">Elegir</label>
                                <select class="form-control" name="seleccion" id="seleccion" onchange="elegir_tabla()">
                                    <option value="">Seleccione...</option>
                                    <option value="1">Insumos</option>
                                    <option value="2">Otros</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label class="col-form-label ">Sucursal</label>
                                <select class="form-control" name="sucursal" id="sucursal" onchange="recargar_recursos()">
                                    <option value="">Seleccione...</option>
                                    <?php
                                    foreach($sucursales as $s){
                                        ?>
                                        <option value="<?php echo $s->id_sucursal;?>"><?php echo $s->sucursal_nombre;?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-3" style="margin-top: 33px">
                                <label for="">TOTAL : </label>
                            </div>
                            <div class="col-lg-2" >
                                <input  style="margin-top: 33px; color: red" class="form-control" type="text" id="suma_total_" name="suma_total_" readonly value="">
                            </div>
                            <div class="col-md-12" style="display: none">
                                <label for="observaciones">Descripción de la Solicitud</label>
                                <input type="text" class="form-control" id="orden_compra_titulo" name="orden_compra_titulo">
                            </div>
                            <div class="col-md-12" id="tabla_i">
                                <div class="table-responsive">
                                    <br><br>
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>RECURSO</th>
                                            <th>FACTOR UNIDAD</th>
                                            <th>CANTIDAD</th>
                                            <th>STOCK AGREGAR</th>
                                            <th>PRECIO COMPRA</th>
                                            <th>PESO INICIAL</th>
                                            <th>PESO FINAL</th>
                                            <th>RENDIMIENTO %</th>
                                            <th>TOTAL S/.</th>
                                            <th>TOTAL PROCESADO</th>
                                            <th>ACCIÓN</th>
                                        </tr>
                                        </thead>
                                        <tbody id="contenido_detalle_compra">
                                        </tbody>
                                        <tr>
                                            <td id="conteo"></td>
                                            <td>
                                                <div id="select_recursos"></div>
                                            </td>
                                            <td><input type="text" class="form-control" id="recurso_sede_factor" name="recurso_sede_factor"></td>
                                            <td><input type="text" class="form-control" id="dato_cantidad" onchange="calcular_stock_agregar()" name="dato_cantidad"></td>
                                            <td><input id="detalle_compra_cantidad" type="text" class="form-control"></td>
                                            <td><input id="detalle_compra_precio_compra" onchange="calcular_total()" type="text" class="form-control"></td>
                                            <td><input type="text" class="form-control" id="recurso_sede_peso_inicial"></td>
                                            <td><input type="text" class="form-control" id="recurso_sede_peso_final" onblur="calcular_peso_merma()"></td>
                                            <td><input type="text" class="form-control" onchange="calcular_merma_fc()" value="100" id="recurso_sede_merma" name="recurso_sede_merma"></td>
                                            <td><input type="text" class="form-control" id="total" name="total"></td>
                                            <td><input id="detalle_compra_total_pedido" name="detalle_compra_total_pedido" type="text" class="form-control"></td>
                                            <td><a style="color:#fff;font-weight: bold;font-size: large" onclick="agregar_fc()" class="btn btn-success"><i class="fa fa-check"></i></a></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-12" id="tabla_o">
                                <div class="table-responsive">
                                    <br><br>
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>RECURSO</th>
                                            <!--<th>FACTOR UNIDAD</th>-->
                                            <th>CANTIDAD</th>
                                            <!--<th>STOCK AGREGAR</th>-->
                                            <th>PRECIO COMPRA</th>
                                            <th>TOTAL S/.</th>
                                            <th>ACCIÓN</th>
                                        </tr>
                                        </thead>
                                        <tbody id="contenido_detalle_compra_o">
                                        </tbody>
                                        <tr>
                                            <td id="conteo"></td>
                                            <td>
                                                <div id="select_recursos_o">
                                                </div>
                                            </td>
                                           <!-- <td><input type="text" onkeyup="validar_numeros(this.id)" class="form-control" id="recurso_sede_factor_o" name="recurso_sede_factor_o"></td>-->
                                            <td><input type="text" class="form-control" id="dato_cantidad_o" onchange="calcular_stock_agregar_o()" name="dato_cantidad_o"></td>
                                            <!--<td><input id="detalle_compra_cantidad_o" type="text" class="form-control"></td>-->
                                            <td><input id="detalle_compra_precio_compra_o" onchange="calcular_total_o()" type="text" class="form-control"></td>
                                            <td><input type="text" class="form-control" id="total_o" name="total"></td>
                                            <td><a style="color:#fff;font-weight: bold;font-size: large" onclick="agregar_fc_o()" class="btn btn-success"><i class="fa fa-check"></i></a></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-form-label">Tipo Documento</label>
                                    <select class="form-control" id= "orden_compra_tipo_doc" name="orden_compra_tipo_doc">
                                        <option value="">Elegir Tipo</option>
                                        <option value="boleta">BOLETA</option>
                                        <option value="factura">FACTURA</option>
                                        <option value="guia_remision">GUIA DE REMISION</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-form-label">N° Documento</label>
                                    <input class="form-control" type="text" id="orden_compra_numero_doc" onkeyup="" name="orden_compra_numero_doc" maxlength="100" placeholder="Ingrese Numero...">
                                    <input  type="hidden" id="datos" name="datos">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-form-label">Fecha Emisión</label>
                                    <input class="form-control" type="date" id="orden_compra_fecha_emision_doc" name="orden_compra_fecha_emision_doc">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-form-label">Adjuntar Archivo</label>
                                    <input class="form-control" type="file" id="orden_compra_doc_adjuntado" name="orden_compra_doc_adjuntado" maxlength="100">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Observaciones</label>
                                    <textarea rows="3" class="form-control" type="text" id="orden_compra_observacion" name="orden_compra_observacion" maxlength="500" placeholder="Ingrese Información..."></textarea>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-form-label">Tipo Pago</label>
                                    <select class="form-control" onchange="ver(this.value)" id= "id_tipo_pago" name="id_tipo_pago">
                                        <option value="">Seleccione</option>
                                        <?php
                                        foreach($tipo_pago as $tp){
                                            ?>
                                            <option value="<?php echo $tp->id_tipo_pago;?>"><?php echo $tp->tipo_pago_nombre;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3" id="cuotas">
                                <div class="form-group">
                                    <label class="col-form-label">Agregar Cuotas</label>
                                    <input class="form-control" type="text" id="orden_compra_doc_cuotas" name="orden_compra_doc_cuotas">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-sm-3 col-xs-3 col-md-3"></div>
                            <div class="col-lg-2 col-sm-3 col-xs-3 col-md-3" style="text-align: center">
                                <button type="submit" class="btn btn-primary submitBtn"><i class="fa fa-check"></i> Generar</button>
                            </div>
                            <div class="col-lg-2 col-sm-3 col-xs-3 col-md-3" style="text-align: center">
                                <a class="btn btn-secondary" href="javascript:history.back()" role="button"><i class="fa fa-backward"></i> Regresar</a>
                            </div>
                            <div class="col-lg-4 col-sm-3 col-xs-3 col-md-3"></div>
                        </div>
                        <br>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>orden_compra.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>proveedor.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $("#div_recurso").hide();
        $("#id_recurso").select2();
        $("#id_recurso_o").select2();
        $("#id_proveedor").select2();
        $('#div_razon_social').hide();
        $("#cuotas").hide();
        $("#tabla_i").hide();
        $("#tabla_o").hide();

        //$("#select_recursos").select2();
        //$("#select_recursos_o").select2();

    });

    function elegir_tabla(){
        var seleccion = $("#seleccion").val();
        recargar_recursos();
        if(seleccion == 1){
            $("#tabla_i").show();
            $("#tabla_o").hide();
        }else{
            $("#tabla_i").hide();
            $("#tabla_o").show();
        }
    }

    function calcular_valor_merma(){
        var detalle_compra_total_pedido = $("#detalle_compra_total_pedido").val();
        var recurso_sede_merma = $("#recurso_sede_merma").val();
        var merma = recurso_sede_merma / 100;
        var subtotal = detalle_compra_total_pedido / merma;
        $("#recurso_sede_precio_total").val(subtotal.toFixed(2));
    }

    function calcular_merma_fc(){
        var recurso_sede_merma = $('#recurso_sede_merma').val();
        var detalle_compra_precio_compra = $('#detalle_compra_precio_compra').val();
        var merma_d = recurso_sede_merma / 100;
        var merma = detalle_compra_precio_compra / merma_d;
        $('#detalle_compra_total_pedido').val(merma.toFixed(2));
    }

    function calcular_nuevo_valor_merma(){
        var recurso_sede_precio_total = $("#recurso_sede_precio_total").val();
        var recurso_sede_factor_unidad = $("#recurso_sede_factor_unidad").val();

        var calculito = recurso_sede_precio_total / recurso_sede_factor_unidad;
        calculito.toFixed(2);
        $("#recurso_sede_precio").val(calculito.toFixed(2));
    }

    function calcular_peso_merma(){
        var recurso_sede_peso_inicial = $("#recurso_sede_peso_inicial").val();
        var recurso_sede_peso_final = $("#recurso_sede_peso_final").val();

        var subtotal = recurso_sede_peso_final / recurso_sede_peso_inicial;
        var mermita = subtotal * 100;
        subtotal.toFixed(2);
        mermita.toFixed(2);
        $("#recurso_sede_merma").val(mermita.toFixed(2));
        calcular_merma_fc();
        //calcular_valor_procesado();
    }

    function calcular_stock_agregar(){
        var factor_unidad = $('#recurso_sede_factor').val();
        var cantidad = $('#dato_cantidad').val();

        var calculo = factor_unidad * cantidad;
        $('#detalle_compra_cantidad').val(calculo.toFixed(2));

    }

    function calcular_stock_agregar_o(){
        var factor_unidad = $('#recurso_sede_factor_o').val();
        var cantidad = $('#dato_cantidad_o').val();

        var calculo = factor_unidad * cantidad;
        $('#detalle_compra_cantidad_o').val(calculo.toFixed(2));

    }

    function calcular_total(){
        var dato_cantidad = $("#dato_cantidad").val() * 1;
        var detalle_compra_precio_compra = $("#detalle_compra_precio_compra").val() * 1;
        var subtotal = dato_cantidad * detalle_compra_precio_compra;
        $('#total').val(subtotal.toFixed(2));
        calcular_valor_procesado();
    }

    function calcular_total_o(){
        var dato_cantidad = $("#dato_cantidad_o").val() * 1;
        var detalle_compra_precio_compra = $("#detalle_compra_precio_compra_o").val() * 1;
        var subtotal = dato_cantidad * detalle_compra_precio_compra;
        $('#total_o').val(subtotal.toFixed(2));
    }

    function calcular_valor_procesado(){
        var factor_unidad = $('#recurso_sede_factor').val();
        var detalle_compra_precio_compra = $('#detalle_compra_precio_compra').val();
        var calcular = detalle_compra_precio_compra / factor_unidad;
        $('#detalle_compra_total_pedido').val(calcular.toFixed(2));
    }

    function limpiar(){
        $('#id_negocio').val('');
        $('#id_tipodocumento').val('');
        $('#proveedor_ruc').val('');
        $('#proveedor_nombre').val('');
        $('#proveedor_nombre_contacto').val('');
        $('#proveedor_cargo_persona').val('');
        $('#proveedor_numero').val('');
        $('#proveedor_direccion').val('');
    }

    function tipo_documento(){
        var tipo_doc = $('#id_tipodocumento').val();
        if(tipo_doc != ""){
            if(tipo_doc != "4"){
                $('#div_razon_social').show();
            }else{
                $('#div_razon_social').show();
            }
        }else{
            $('#div_razon_social').hide();
        }
    }

    function consultar_documento(valor){
        var tipo_doc = $('#id_tipodocumento').val();
        if(tipo_doc == "2"){
            ObtenerDatosDni(valor);
        }else if(tipo_doc == "4"){
            ObtenerDatosRuc(valor);
        }
    }

    function consultar_documento_e(valor){
        var tipo_doc = $('#id_tipodocumento_e').val();
        if(tipo_doc == "2"){
            ObtenerDatosDni_e(valor);
        }else if(tipo_doc == "4"){
            ObtenerDatosRuc_e(valor);
        }
    }

    function ObtenerDatosDni_e(valor){
        var numero_dni =  valor;

        $.ajax({
            type: "POST",
            url: urlweb + "api/Proveedor/obtener_datos_x_dni",
            data: "numero_dni="+numero_dni,
            dataType: 'json',
            success:function (r) {
                $("#proveedor_nombre_e").val(r.result.name+ ' ' + r.result.first_name+ ' ' + r.result.last_name);
            }
        });
    }

    function recargar_recursos(){
        var sucursal = $("#sucursal").val();
        $.ajax({
            type: "POST",
            url: urlweb + "api/Ordencompra/recargar_recursos",
            data : "sucursal=" + sucursal,
            dataType: 'json',
            success:function (r) {
                $("#select_recursos").html(r.result.datos_recursos);
                $("#select_recursos_o").html(r.result.datos_recursos_o);
                $("#id_recurso").select2();
                $("#id_recurso_o").select2();
                respuesta('¡Recargando..!', 'success');
            }
        });
    }

    function ObtenerDatosRuc_e(valor){
        var numero_ruc =  valor;

        $.ajax({
            type: "POST",
            url: urlweb + "api/Proveedor/obtener_datos_x_ruc",
            data: "numero_ruc="+numero_ruc,
            dataType: 'json',
            success:function (r) {
                $("#proveedor_nombre_e").val(r.result.razon_social);
            }
        });
    }

    function ObtenerDatosDni(valor){
        var numero_dni =  valor;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Proveedor/obtener_datos_x_dni",
            data: "numero_dni="+numero_dni,
            dataType: 'json',
            success:function (r) {
                $("#proveedor_nombre").val(r.result.name+ ' ' + r.result.first_name+ ' ' + r.result.last_name);
            }
        });
    }

    function ObtenerDatosRuc(valor){
        var numero_ruc =  valor;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Proveedor/obtener_datos_x_ruc",
            data: "numero_ruc="+numero_ruc,
            dataType: 'json',
            success:function (r) {
                $("#proveedor_nombre").val(r.result.razon_social);
            }
        });
    }

    function ver(id_tipo_pago){
        if(id_tipo_pago=="5"){
            $("#cuotas").show();
        }else{
            $("#cuotas").hide();
        }
    }

</script>