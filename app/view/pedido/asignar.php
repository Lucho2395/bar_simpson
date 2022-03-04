


<div class="modal fade" id="asignar_pedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 70% !important;">
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
                                        <label class="col-form-label">Producto</label>
                                        <input type="text" readonly class="form-control" id="producto_nombre" name="producto_nombre">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Precio</label>
                                        <input type="text" readonly class="form-control" id="comanda_detalle_precio" name="comanda_detalle_precio">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Cantidad</label>
                                        <input type="number" value="1" class="form-control" id="comanda_detalle_cantidad" name="comanda_detalle_cantidad">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Tipo Entrega</label>
                                        <select class="form-control" id= "comanda_detalle_despacho" name="comanda_detalle_despacho">
                                            <option value="SALON">SALON</option>
                                            <option value="PARA LLEVAR">PARA LLEVAR</option>
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
                    <button type="button" onclick="agregar__()" class="btn btn-success" id="btn-agregar"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
        </div>
    </div>
</div>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?> / <?= $data_mesa->mesa_nombre; ?></h1>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-5">
                        
                            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" >
                                <div class="row">
                                    <div class="form-group col-lg-8">
                                        <input required autocomplete="off" name="parametro" type="text" value="<?= $parametro;?>" class="form-control" id="parametro" placeholder="Buscar Productos">
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <button type="submit" class="btn btn-success" onclick="productos()" style="width: 80%"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <table class='table table-responsive table-bordered' width='100%'>
                                        <thead class='text-capitalize'>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                            <th>Acción</th>
                                        </tr>
                                        </thead>
                                        <tbody id="producto">
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
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
                                                    $op_gravadas = $pf->producto_precio_venta;
                                                    $igv = $op_gravadas * $igv_porcentaje;
                                                    $total = $op_gravadas + $igv;
                                                }else{
                                                    $total = $pf->producto_precio_venta;
                                                }
                                                /*if($pf->id_receta == "0"){
                                                    $total = $total + $icbper;
                                                }*/
                                                ?>
                                                <tr>
                                                    <td><?=$pf->producto_nombre?></td>
                                                    <td><?=$total ?></td>
                                                    <td>
                                                        <button class='btn btn-success' data-toggle='modal' onclick="guardar_pedido(<?=$pf->id_producto?>,'<?=$pf->producto_nombre?>','<?=$total?>','<?= $pf->producto_precio_codigoafectacion?>')" data-target='#asignar_pedido'><i class='fa fa-check'></i></button>
                                                        <a class="btn btn-primary" href="<?= _SERVER_ . $pf->producto_foto?>" target="_blank"><i class="fa fa-eye"></i></a>
                                                    <td>
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
                        <div class="col-lg-7">
                            <div class="col-md-12 col-lg-12 col-xs-12">
                                <form class="" enctype="multipart/form-data" id="guardar_comanda">
                                    <input type="hidden" id="contenido" name="contenido">
                                    <input type="hidden" class="form-control" id="id_producto" name="id_producto">
                                    <input type="hidden" class="form-control" id="comanda_total" name="comanda_total">
                                    <input type="hidden" id="id_mesa" name="id_mesa" value="<?= $id;?>">


                                    <table class="table table-bordered" style="background: darksalmon;">
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

                                    <div class="row">
                                        <div class="col-lg-3 col-xs-4 col-md-4 col-sm-4">
                                            <label for="">Cant. de Personas</label>
                                            <input type="number" value="1" class="form-control" id="comanda_cantidad_personas" name="comanda_cantidad_personas">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-2 col-md-2 col-xs-2"></div>
                                        <div class="col-lg-2 col-sm-3 col-md-3 col-xs-3" style="margin-top: 12px">
                                            <button type="submit" class="btn btn-primary submitBtn"><i class="fa fa-check"></i> Generar</button>
                                        </div>
                                        <div class="col-lg-1 col-sm-2 col-md-2 col-xs-2"></div>
                                        <div class="col-lg-2 col-sm-3 col-md-3 col-xs-3" style="margin-top: 12px">
                                            <a class="btn btn-secondary" href="javascript:history.back()" role="button"><i class="fa fa-backward"></i> Regresar</a>
                                        </div>
                                    </div>
                                </form>
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
    $(document).ready(function(){
        $('#parametro').keypress(function(e){
            if(e.which === 13){
                productos();
            }
        });
    });
    var contenido = "";
    var conteo = 1;
    var total_total = 0;

    function productos(){
        var param_ = $("#parametro").val();
        var param = param_.replace("+",".--");
        $("#producto").html("");
        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/ver_productos/",
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
        var total = 0.00;
        if (contenido.length>0){
            var filas=contenido.split('/./.');
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
                    var monto_total = monto_total + celdas[6] * 1;
                    var total = monto_total.toFixed(2);
                }
            }
        }
        $("#contenido_detalle_compra").html(llenar);
        $("#conteo").html(conteo);
        $("#comanda_total").val(total);
        $("#comanda_total_").html("S/ " + total);
        $("#contenido").val(contenido);
    }

    function clean() {
        $('#asignar_pedido').modal('toggle');
        $("#comanda_detalle_cantidad").val("1");
        $("#comanda_detalle_precio").val("");
        $("#comanda_detalle_observacion").val("-");
        $("#producto_nombre").val("");

        $("#comanda_detalle_despacho option[value='SALON']").attr('selected','selected');
        $("#comanda_detalle_despacho").val("SALON");
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
    }

    function agregar__(){
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


        var subtotal = comanda_detalle_cantidad * comanda_detalle_precio;
        subtotal.toFixed(2);
        subtotal = subtotal.toFixed(2);;

        /*total_total = total_total + subtotal;
        total_total.toFixed(2);
        total_total = parseFloat(total_total);*/

        if(id_producto !="" && comanda_detalle_cantidad!="" && comanda_detalle_precio!="" && producto_nombre!="" && comanda_detalle_observacion !="" && subtotal!="" && comanda_detalle_despacho !="" ){
            contenido += id_producto + "-.-." + producto_nombre + "-.-."+ comanda_detalle_precio+"-.-." + comanda_detalle_cantidad +"-.-."+comanda_detalle_despacho+"-.-." + comanda_detalle_observacion+"-.-."+subtotal+"/./.";
            $("#contenido").val(contenido);
            //$("#comanda_total_pedido").val(subtotal);
            respuesta('Agregado', 'success');
            show_table();
            clean();
        }else{
            respuesta('Ingrese todos los campos');
        }
    }


    $("#guardar_comanda").on('submit', function(e){
        e.preventDefault();
        var valor = true;
        var id_mesa = $('#id_mesa').val();
        var contenido = $('#contenido').val();
        var comanda_cantidad_personas = $('#comanda_cantidad_personas').val();

        valor = validar_campo_vacio('contenido', contenido, valor);
        valor = validar_campo_vacio('id_mesa', id_mesa, valor);

        if (valor){
            $.ajax({
                type:"POST",
                url: urlweb + "api/Pedido/guardar_comanda",
                dataType: 'json',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('.submitBtn').attr("disabled","disabled");
                    $('#guardar_comanda').css("opacity",".5");
                },
                success:function (r) {
                    switch (r.result.code) {
                        case 1:
                            respuesta('¡Guardado con Exito!','success');
                            setTimeout(function () {
                                    location.href = urlweb +  'Pedido/gestionar';
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
                    $('#guardar_comanda').css("opacity","");
                    $(".submitBtn").removeAttr("disabled");
                }
            });
        }
    });


</script>