
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>

            </div>
            <!-- /.row (main row) -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="card-body">
                        <form class="" enctype="multipart/form-data" id="fupForm">
                            <input type="hidden" name="id_orden_compra" id="id_orden_compra" value="<?= $datos->id_orden_compra; ?>">
                            <input type="hidden" id="contenido" name="contenido">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="observaciones">Descripción de la Solicitud</label>
                                    <input type="text" class="form-control" id="orden_compra_titulo" name="orden_compra_titulo" value="<?= $datos->orden_compra_titulo;?>">
                                </div>

                                <div class="col-lg-3">
                                    <label class="col-form-label ">Sucursal</label>
                                    <select onchange="recursos()" id="id_sucursal" class="form-control" name="id_sucursal" >
                                        <option value="">Seleccione</option>
                                        <?php
                                        foreach ($sucursal as $s){
                                            ?>
                                            <option <?php echo ($datos->id_sucursal == $s->id_sucursal) ? 'selected':'';?> value="<?php echo $s->id_sucursal;?>"><?php echo $s->sucursal_nombre; ?></option>
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
                                            ?>
                                            <option <?php echo ($datos->id_proveedor == $p->id_proveedor) ? 'selected':'';?> value="<?php echo $p->id_proveedor;?>"><?php echo $p->proveedor_nombre; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr style="font-weight: bold;text-align: center">
                                            <td>ITEM</td>
                                            <td>RECURSO</td>
                                            <td>CANTIDAD</td>
                                            <td>PRECIO COMPRA</td>
                                            <td>TOTAL</td>
                                            <td>ACCIÓN</td>
                                        </tr>
                                        </thead>
                                        <tbody id="contenido_detalle_compra">
                                        <?php
                                        $detalle_orden = $this->ordencompra->listar_detalle($datos->id_orden_compra);
                                        $conteo=1;
                                        ?>
                                        </tbody>
                                        <tr>
                                            <td id="conteo"></td>
                                            <td>
                                                <div id="datos_recurso"></div>
                                                <select class="form-control" name="id_recurso" id="id_recurso" >
                                                </select>
                                            </td>
                                            <td><input id="detalle_compra_cantidad" type="text" class="form-control"></td>
                                            <td><input id="detalle_compra_precio_compra" type="text" class="form-control"></td>
                                            <td><input id="detalle_compra_total_pedido" type="hidden" class="form-control"></td>

                                            <td><a style="color:#fff;font-weight: bold;font-size: large" onclick="agregar()" class="btn btn-success"><i class="fa fa-check"></i></a></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group col-md-12" style="text-align: right">
                                <br><button type="submit" class="btn btn-primary submitBtn"><i class="fa fa-check"></i> Guardar Cambios</button>
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
    var contenido = "";
    var conteo = 1;
    <?php
    foreach ($detalle_orden as $dc){
    ?>
    contenido+="<?= $dc->id_recurso_sede;?>-.-.<?= $dc->recurso_nombre;?>-.-.<?= $dc->detalle_compra_cantidad;?>-.-.<?= $dc->detalle_compra_precio_compra;?>-.-.<?= $dc->detalle_compra_total_pedido?>/./.";
    <?php
    }
    ?>

    $(document).ready(function(){
        show_table();
        recursos();
        $("#id_recurso").select2();
    });

    function show_table() {
        var llenar="";
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
                        "<td>" +
                        "<a data-toggle=\"tooltip\" onclick='delete_detalle("+i+")' title=\"Eliminar\" type=\"button\" class=\"text-danger\" ><i class=\"fa fa-times ver_detalle\"></i></a>" +
                        "</td>"+
                        "</tr>";
                    conteo++;
                }
            }
        }
        $("#contenido_detalle_compra").html(llenar);
        $("#conteo").html(conteo);
        $("#contenido").val(contenido);
    }

    function delete_detalle(ind) {
        var contenido_artificio ="";
        if (contenido.length>0){
            var filas=contenido.split('/./.');
            if(filas.length>0){
                for(var i=0;i<filas.length - 1;i++){
                    if(i!=ind){
                        var celdas =filas[i].split('-.-.');
                        contenido_artificio += celdas[0] + "-.-."+celdas[1] + "-.-." + celdas[2] + "-.-." + celdas[3] + "-.-." +celdas[4] + "-.-."+ celdas[5] +"-.-."+celdas[6] +"/./.";
                    }
                }
            }
        }
        contenido = contenido_artificio;
        show_table();
    }

    function recursos(){
        var id_sucursal =  $("#id_sucursal").val();
        $.ajax({
            type: "POST",
            url: urlweb + "api/Ordencompra/listar_recursos_x_sucursal",
            data: "id_sucursal="+id_sucursal,
            dataType: 'json',
            success:function (r) {
                //$("#datos_recurso").show();
                var datos_recurso_ = "<option value='' selected>Seleccione</option>";
                for(var j =0;j<r.result.length;j++){
                    datos_recurso_ +="<option value='"+r.result[j].id_recurso+"'>"+r.result[j].recurso_nombre+"</option>";
                }
                $("#id_recurso").html(datos_recurso_);
            }

        });
    }

    function agregar(){

        var recurso_val = $("#id_recurso").val();
        if(recurso_val!=""){
            var id_recurso = $("select[name='id_recurso'] option:selected").text();
        }else{
            var id_recurso = "";
        }

        var detalle_compra_cantidad = $("#detalle_compra_cantidad").val() * 1;
        var detalle_compra_precio_compra = $("#detalle_compra_precio_compra").val() * 1;

        var subtotal = detalle_compra_cantidad * detalle_compra_precio_compra;
        subtotal.toFixed(2);
        subtotal = parseFloat(subtotal);

        if(id_sucursal!="" && detalle_compra_cantidad!=""&& detalle_compra_precio_compra!="" && recurso_val!=""  && subtotal !=""){
            contenido += recurso_val +"-.-."+id_recurso + "-.-." + detalle_compra_cantidad + "-.-." +detalle_compra_precio_compra +"-.-."+subtotal+"/./.";
            $("#contenido").val(contenido);
            show_table();
            clean();
        }else{
            respuesta('Ingrese todos los campos');
        }

    }

    function clean() {
        $("#detalle_compra_precio_compra").val("");
        $("#detalle_compra_cantidad").val("");

        $("#id_recurso option[value='']").attr('selected','selected');
        $("#id_recurso").val("");
        $("#id_recurso").select().trigger('change');
    }


    $("#fupForm").on('submit', function(e){
        e.preventDefault();
        var valor = true;
        var orden_compra_titulo = $('#orden_compra_titulo').val();
        var id_sucursal = $('#id_sucursal').val();
        var id_proveedor = $('#id_proveedor').val();
        var contenido = $('#contenido').val();

        valor = validar_campo_vacio('contenido', contenido, valor);
        valor = validar_campo_vacio('orden_compra_titulo', orden_compra_titulo, valor);
        valor = validar_campo_vacio('id_sucursal', id_sucursal, valor);
        valor = validar_campo_vacio('id_proveedor', id_proveedor, valor);
        if (valor){
            $.ajax({
                type:"POST",
                url: urlweb + "api/Ordencompra/editar_orden",
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
                            respuesta('¡Editado con Exito!','success');
                            setTimeout(function () {
                                location.href = urlweb +  'Ordencompra/orden_pendiente';
                            }, 1000);
                            break;
                        case 2:
                            respuesta("Fallo el envio", 'error');
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