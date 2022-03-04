


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


<div class="modal fade" id="gestion_insumos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 50% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Insumos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div id="categoria">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="col-form-label">Sucursal</label>
                                    <select class="form-control" onchange="jalar_categorias()" id="id_sucursal" name="id_sucursal">
                                        <option value="">Seleccionar Negocio</option>
                                        <?php
                                        foreach($sucursal as $n){
                                            ?>
                                            <option value="<?php echo $n->id_sucursal;?>"><?php echo $n->sucursal_nombre;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-form-label">Categoria</label>
                                    <div id="datos_categoria"></div>
                                </div>
                            </div>
                            <div class="col-lg-6" style="display: none">
                                <div class="form-group">
                                    <label class="col-form-label">Seleccionar </label>
                                    <select id="id_ne" name="id_ne" class="form-control">
                                        <option value="1">Nuevo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label class="col-form-label">Recurso</label>
                                    <div id="datos_recurso"></div>
                                    <input type="text" id="recurso_nombre" name="recurso_nombre" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-form-label">U. de medida: </label>
                                    <select id="id_medida" name="id_medida" class="form-control">
                                        <?php
                                        foreach($unidad_medida as $um){
                                            ?>
                                            <option value="<?php echo $um->id_medida;?>"><?php echo $um->medida_nombre;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Factor Unidad</label>
                                    <input type="text" class="form-control" id="recurso_sede_factor_unidad" name="recurso_sede_factor_unidad">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Cantidad</label>
                                    <input type="text" class="form-control" onchange="calcular_stock()" id="recurso_sede_cantidad" name="recurso_sede_cantidad">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-form-label">Stock Inicial: </label>
                                    <input class="form-control" type="text" id="recurso_sede_stock" name="recurso_sede_stock" onkeyup="validar_numeros_decimales_dos(this.id)" placeholder="Stock Inicial...">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-form-label">Stock Minimo: </label>
                                    <input class="form-control" type="text" id="recurso_sede_stock_minimo" name="recurso_sede_stock_minimo" onkeyup="validar_numeros_decimales_dos(this.id)" placeholder="Stock Minimo...">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">P. Unitario</label>
                                    <input type="text" class="form-control" id="recurso_sede_precio_unit" onchange="calcular_precio()" name="recurso_sede_precio_unit" onkeyup="validar_numeros_decimales_dos(this.id)">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">P. Total</label>
                                    <input type="text" class="form-control" id="recurso_sede_precio_total" name="recruso_sede_precio_total" onkeyup="validar_numeros_decimales_dos(this.id)">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-form-label">Precio: </label>
                                    <input class="form-control" type="text" id="recurso_sede_precio" name="recurso_sede_precio" onkeyup="validar_numeros_decimales_dos(this.id)" placeholder="Ingrese Precio...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="btn-agregar-recursos" onclick="guardar()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>


<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
            </div>
            <div class="row">
                <div class="col-lg-8"></div>
                <div class="col-lg-2">
                    <button data-toggle="modal" data-target="#gestionProveedor" class="btn btn-success"><i class="fa fa-plus"></i> Agregar Proveedor</button>
                </div>
                <div class="col-lg-2">
                    <button data-toggle="modal" data-target="#gestion_insumos" class="btn btn-success"><i class="fa fa-plus"></i> Agregar Insumos</button>
                </div>
            </div>
            <br>
            <!-- /.row (main row) -->
            <form enctype="multipart/form-data" id="fupForm">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h4 class="m-0 font-weight-bold text-primary">Iniciar solicitud para Orden de Compra</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" id="contenido" name="contenido">
                            <div class="col-lg-3">
                                <label class="col-form-label ">Sucursal</label>
                                <select onchange="recursos_(this.value)" id="id_sucursal_" class="form-control" name="id_sucursal_">
                                    <option value="">Seleccione</option>
                                    <?php
                                    foreach ($sucursal as $s){
                                        ?><option class="show2_<?= $s->id_sucursal; ?>" value="<?= $s->id_sucursal;?>"><?php echo $s->sucursal_nombre; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
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
                            <div class="col-lg-3" style="margin-top: 33px">
                                <label for="">TOTAL : </label>
                            </div>
                            <div class="col-lg-2" >
                                <input  style="margin-top: 33px; color: red" class="form-control" type="text" id="suma_total" name="suma_total" readonly value="">
                            </div>
                            <div class="col-md-12">
                                <label for="observaciones">Descripción de la Solicitud</label>
                                <input type="text" class="form-control" id="orden_compra_titulo" name="orden_compra_titulo">
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <br><br>
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>RECURSO</th>
                                            <th>CANTIDAD</th>
                                            <th>PRECIO COMPRA</th>
                                            <th>TOTAL</th>
                                            <th>ACCIÓN</th>
                                        </tr>
                                        </thead>
                                        <tbody id="contenido_detalle_compra">
                                        </tbody>
                                        <tr>
                                            <td id="conteo"></td>
                                            <td>
                                                <div id="div_recurso">
                                                <select class="form-control" name="id_recurso" id="id_recurso">
                                                </select>
                                                </div>
                                            </td>
                                            <td><input id="detalle_compra_cantidad" onkeyup="validar_numeros_decimales_dos(this.id)" type="text" class="form-control"></td>
                                            <td><input id="detalle_compra_precio_compra" type="text" class="form-control"></td>
                                            <td><input id="detalle_compra_total_pedido" type="hidden" class="form-control"></td>
                                            <td><a style="color:#fff;font-weight: bold;font-size: large" onclick="agregar()" class="btn btn-success"><i class="fa fa-check"></i></a></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="form-group col-md-12" style="text-align: right">
                                    <br><button type="submit" class="btn btn-primary submitBtn"><i class="fa fa-check"></i> Generar</button>
                                </div>
                            </div>
                        </div>
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
<script src="<?php echo _SERVER_ . _JS_;?>recursos.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $("#div_recurso").hide();
        $("#id_recurso").select2();
        $('#div_razon_social').hide();
    });

    function elegir_ne(){
        var eleccion = $("#id_ne").val();
        if(eleccion == 1){
            $("#recurso_nombre").show();
            $("#datos_recurso").hide();
        }else{
            $("#recurso_nombre").hide();
            $("#datos_recurso").show();
        }
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

</script>