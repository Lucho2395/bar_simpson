<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                    <h5 class="card-title">Solicitud de Orden de Compra N° <b><?= $datos->orden_compra_numero ?></b> | Solicitante: <b><?= $datos->persona_nombre." ".$datos->persona_apellido_paterno." ".$datos->persona_apellido_materno; ?></b> | Fecha de Aprobación: <b><?= date("d-m-Y",strtotime($datos->orden_compra_fecha_aprob)); ?></b>
                                        <br> Descripción de la Solicitud: <?= $datos->orden_compra_titulo?></h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table" width="100%" cellspacing="0">
                                            <thead class="text-capitalize">
                                            <tr>
                                                <td>Numero</td>
                                                <td>RECURSO</td>
                                                <td>PROVEEDOR</td>
                                                <td>CANTIDAD SOLICITADA</td>
                                                <td>FACTOR UNIDAD</td>
                                                <td>CANT. RECIBIDA</td>
                                                <td>RENDIMIENTO %</td>
                                                <td>P. COMPRA</td>
                                                <td>STOCK AGREGAR</td>
                                                <td>TIPO MONEDA</td>
                                                <td>TIPO CAMBIO</td>
                                                <td>TOTAL PAGADO $.</td>
                                                <td>TOTAL PAGADO S/.</td>
                                                <td>TOTAL PROCESADO S/.</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $detalle_orden = $this->ordencompra->listar_detalle($datos->id_orden_compra);
                                            $conteo=1;
                                            $conteo_NO=0;
                                            foreach ($detalle_orden as $ds){
                                                if($ds->orden_compra_numero == 0){
                                                    $numero = "--";
                                                }else{
                                                    $numero = "$ds->orden_compra_numero";
                                                }
                                                ?>
                                                <tr>
                                                    <td><?= $numero; ?></td>
                                                    <td><?= $ds->recurso_nombre; ?></td>
                                                    <td><?= $ds->proveedor_nombre; ?></td>
                                                    <td><?= $ds->detalle_compra_cantidad; ?></td>
                                                    <td><input type="text" class="form-control"  onkeyup="validar_numeros(this.id)" id="recurso_sede_factor_unidad<?php echo $ds->id_detalle_compra;?>" name="recurso_sede_factor_unidad<?php echo $ds->id_detalle_compra;?>" value="1"></td>
                                                    <td><input type="text" class="form-control" onkeyup="validar_numeros(this.id)" onchange="multiplicar_para_stock<?php echo $ds->id_detalle_compra;?>()" id="dato_cantidad<?php echo $ds->id_detalle_compra;?>" name="dato_cantidad<?php echo $ds->id_detalle_compra;?>"></td>
                                                    <td><input type="text" class="form-control" onkeyup="validar_numeros(this.id)" onchange="calcular_merma<?php echo $ds->id_detalle_compra;?>()" id="recurso_sede_merma<?php echo $ds->id_detalle_compra;?>" name="recurso_sede_merma<?php echo $ds->id_detalle_compra;?>" value=""></td>
                                                    <td><input type="text" class="form-control" id="detalle_compra_precio_compra<?php echo $ds->id_detalle_compra;?>" value="<?php echo $ds->detalle_compra_precio_compra;?>"></td>
                                                    <td>
                                                        <input type="text" onchange="calcular<?php echo $ds->id_detalle_compra;?>()" onkeyup="return validar_numeros_decimales_dos(this.id)" class="form-control" id="detalle_compra_cantidad_recibida_<?php echo $ds->id_detalle_compra?>" name="detalle_compra_cantidad_recibida_<?php echo $ds->id_detalle_compra?>">
                                                    </td>
                                                    <td>
                                                        <select onchange="calcular<?php echo $ds->id_detalle_compra;?>()" class="form-control" name="elegir<?php echo $ds->id_detalle_compra;?>" id="elegir<?php echo $ds->id_detalle_compra;?>">
                                                            <option value="1">Soles</option>
                                                            <option  value="2">Dólares</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" onchange="calcular_tipocambio_totaldolares<?= $ds->id_detalle_compra;?>()" name="dolares<?= $ds->id_detalle_compra;?>" id="dolares<?= $ds->id_detalle_compra;?>" type="text" onkeyup="return validar_numeros_decimales_dos(this.id)">
                                                    </td>
                                                    <td>
                                                        <input readonly class="form-control" type="text" id="precio_dolares<?php echo $ds->id_detalle_compra;?>" name="precio_dolares<?php echo $ds->id_detalle_compra;?>">
                                                    </td>
                                                    <td>
                                                        <input readonly type="text" class="form-control" id="detalle_compra_total_pagado<?php echo $ds->id_detalle_compra;?>" name="detalle_compra_total_pagado<?php echo $ds->id_detalle_compra;?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="precio_procesado<?php echo $ds->id_detalle_compra;?>" name="precio_procesado<?php echo $ds->id_detalle_compra;?>">
                                                    </td>
                                                </tr>
                                                <?php
                                                $conteo++;
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form class="form-row" enctype="multipart/form-data" id="fupForm">
                            <input type="hidden" id="id_orden_compra" name="id_orden_compra" value="<?= $id;?>">
                                <br>
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
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="col-form-label">Agregar Cuotas</label>
                                            <input class="form-control" type="text" id="orden_compra_doc_cuotas" name="orden_compra_doc_cuotas">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4"></div>
                                    <div class="col-lg-2" style="text-align: center">
                                        <button type="submit" class="btn btn-primary submitBtn"><i class="fa fa-check"></i> Generar</button>
                                    </div>
                                    <div class="col-lg-2" style="text-align: center">
                                        <a class="btn btn-secondary" href="javascript:history.back()" role="button"><i class="fa fa-backward"></i> Regresar</a>
                                    </div>
                                    <div class="col-lg-4"></div>
                                </div>
                                <br>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script>
    var sumatoria_soles = 0;
    var sumatoria_dolares = 0;
    $(document).ready(function (){
        $("#dolares").hide();
        $("#precio_dolares").hide();
        $("#orden_compra_doc_cuotas").hide();

        <?php
            foreach ($detalle_orden as $do){ ?>
                var total_soles = $("#detalle_compra_total_pagado"+<?= $do->id_detalle_compra;?>).val();
                var total_dolar = $("#precio_dolares"+<?= $do->id_detalle_compra;?>).val();
                sumatoria_soles = sumatoria_soles + total_soles;
                sumatoria_dolares = sumatoria_dolares + total_dolar;
           <?php
            }
        ?>
        $("#sumatoria_Soles").html(parseFloat(sumatoria_soles));
        $("#sumatoria_Dolares").html(parseFloat(sumatoria_dolares));
    });


    function ver(id_tipo_pago){
        if(id_tipo_pago=="5"){
            $("#orden_compra_doc_cuotas").show();
        }else{
            $("#orden_compra_doc_cuotas").hide();
        }
    }


    <?php
    foreach ($detalle_orden as $ds){
    ?>
        function calcular<?php echo $ds->id_detalle_compra?>(){

            var cant = $("#dato_cantidad"+<?= $ds->id_detalle_compra;?>).val() * 1;
            var precio = $("#detalle_compra_precio_compra"+<?= $ds->id_detalle_compra;?>).val() * 1;
            var tipo_moneda = $("#elegir"+<?= $ds->id_detalle_compra;?>).val();

            if(tipo_moneda=="1"){
                var subtotal_ = cant * precio;
                var subtotal_soles = subtotal_.toFixed(2);
                var subtotal_dolares = parseFloat("0.00");
                //subtotal = parseFloat(subtotal);
                $("#detalle_compra_total_pagado"+<?= $ds->id_detalle_compra;?>).val(subtotal_soles);
                $("#precio_dolares"+<?= $ds->id_detalle_compra;?>).val(subtotal_dolares);
                $("#dolares"+<?= $ds->id_detalle_compra;?>).hide();
            }else{
                var subtotal_ = cant * precio;
                var subtotal_dolares = subtotal_.toFixed(2);
                var subtotal_soles = parseFloat("0.00")
                //subtotal = parseFloat(subtotal);
                $("#detalle_compra_total_pagado"+<?= $ds->id_detalle_compra;?>).val(subtotal_soles);
                $("#precio_dolares"+<?= $ds->id_detalle_compra;?>).val(subtotal_dolares);

                $("#dolares"+<?= $ds->id_detalle_compra;?>).show();
            }

        }
        function calcular_tipocambio_totaldolares<?= $ds->id_detalle_compra;?>(){
            var tipo_cambio = $("#dolares"+<?= $ds->id_detalle_compra;?>).val() * 1;
            var total_dolares = $("#precio_dolares"+<?= $ds->id_detalle_compra;?>).val() * 1;
            var total_soles = tipo_cambio * total_dolares;
            $("#detalle_compra_total_pagado"+<?= $ds->id_detalle_compra;?>).val(total_soles.toFixed(2));
        }

        function multiplicar_para_stock<?= $ds->id_detalle_compra;?>(){
            var factor_unidad = $("#recurso_sede_factor_unidad"+<?= $ds->id_detalle_compra;?>).val() * 1;
            var cantidad = $("#dato_cantidad"+<?= $ds->id_detalle_compra;?>).val() * 1;

            var subtotal = factor_unidad * cantidad;

            $("#detalle_compra_cantidad_recibida_"+<?= $ds->id_detalle_compra;?>).val(subtotal);
            calcular<?php echo $ds->id_detalle_compra?>();
        }

        function calcular_merma<?= $ds->id_detalle_compra;?>(){
            var merma = $("#recurso_sede_merma"+<?= $ds->id_detalle_compra;?>).val() * 1;
            var precio = $("#detalle_compra_precio_compra"+<?= $ds->id_detalle_compra;?>).val() * 1;
            var valor_merma = merma / 100 ;
            var total = precio / valor_merma;
            $("#precio_procesado"+<?= $ds->id_detalle_compra;?>).val(total.toFixed(2));
        }

    <?php
    }
    ?>

    $("#fupForm").on('submit', function(e){
        e.preventDefault();
        var valor = true;
        var id_orden_compra = $('#id_orden_compra').val();
        var orden_compra_tipo_doc = $('#orden_compra_tipo_doc').val();
        var orden_compra_numero_doc = $('#orden_compra_numero_doc').val();
        var orden_compra_doc_adjuntado = $('#orden_compra_doc_adjuntado').val();

        var orden_compra_fecha_emision_doc = $('#orden_compra_fecha_emision_doc').val();
        var orden_compra_doc_cuotas = $('#orden_compra_doc_cuotas').val();


        var id_tipo_pago = $('#id_tipo_pago').val();
        var orden_compra_observacion = $('#orden_compra_observacion').val();

        var datos = "";

        <?php
        foreach ($detalle_orden as $do){
            ?>
        var detalle_compra_total_pagado = $('#detalle_compra_total_pagado<?php echo $do->id_detalle_compra;?>').val();
        var elegir = $('#elegir<?php echo $do->id_detalle_compra;?>').val();
        var precio_dolares = $('#precio_dolares<?php echo $do->id_detalle_compra;?>').val();
        var dolares = $('#dolares<?= $do->id_detalle_compra;?>').val();
        var detalle_compra_precio_compra = $('#detalle_compra_precio_compra<?php echo $do->id_detalle_compra;?>').val();
        var recurso_sede_merma = $("#recurso_sede_merma"+<?= $do->id_detalle_compra;?>).val();
        var recurdso
        var precio_procesado = $("#precio_procesado<?= $do->id_detalle_compra;?>").val();

        var detalle_compra_cantidad_recibida = $('#detalle_compra_cantidad_recibida_<?= $do->id_detalle_compra?>').val();
        datos += <?= $do->id_detalle_compra;?>+"-.-."+detalle_compra_cantidad_recibida+"-.-."+elegir+"-.-."+precio_dolares+"-.-."+detalle_compra_total_pagado+"-.-."+detalle_compra_precio_compra+"-.-."+dolares+"-.-."+recurso_sede_merma+"-.-."+precio_procesado+"---,";
        <?php
        }
        ?>
        $('#datos').val(datos);

        valor = validar_campo_vacio('id_tipo_pago', id_tipo_pago, valor);
        valor = validar_campo_vacio('detalle_compra_total_pagado<?php echo $do->id_detalle_compra;?>', detalle_compra_total_pagado, valor);
        valor = validar_campo_vacio('detalle_compra_cantidad_recibida_<?= $do->id_detalle_compra?>', detalle_compra_cantidad_recibida, valor);

        if (valor){
            $.ajax({
                type:"POST",
                url: urlweb + "api/Ordencompra/actualizar_recepcion",
                dataType: 'json',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('.submitBtn').attr("disabled","disabled");
                    $('#fupForm').css("opacity",".5");
                },
                success:function (r) {
                    switch (r.result.code) {
                        case 1:
                            respuesta('¡Guardado con Exito!','success');
                            setTimeout(function () {
                                location.href = urlweb +  'Ordencompra/orden_aprobada';
                            }, 1000);
                            break;
                        case 2:
                            respuesta("Fallo el envio, intentelo de nuevo", 'error');
                            break;
                        case 6:
                            respuesta("Algún dato fue ingresado de manera erronéa. Recargue la página por favor.",'error');
                            break;
                        default:
                            respuesta("ERROR DESCONOCIDO", 'error');
                    }
                    $('#fupForm').css("opacity","");
                    $(".submitBtn").removeAttr("disabled");
                }
            });
        }
    });

</script>