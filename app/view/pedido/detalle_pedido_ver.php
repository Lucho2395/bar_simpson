<?php
/**
 * Created by PhpStorm
 * User: LuisSalazar
 * Date: 18/08/2021
 * Time: 11:19 a. m.
 */
?>


<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h3><b>Pedido # <?= $dato_pedido->comanda_correlativo;?></b> // <?= $dato_pedido->mesa_nombre;?> // Personas: <?= $dato_pedido->comanda_cantidad_personas;?></h3></div>
                <div class="col-lg-12" style="text-align: center"><h3><?= date('d-m-Y H:i:s',strtotime($dato_pedido->comanda_fecha_registro))?></h3></div>

                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <!--<th>Mesa</th>-->
                                        <th>Producto</th>
                                        <th>Observación</th>
                                        <!--<th>N° Pedido</th>-->
                                        <th>Precio Unitario</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                        <!--<th>Fecha / Hora</th>-->
                                        <th>Estado</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $det = 0;
                                    $det_cero = 0;
                                    $a = 1;
                                    foreach ($pedidos as $p){
                                        $estilo = "";
                                        if($p->comanda_detalle_estado_venta == "0"){
                                            $estilo = "style=\"background-color: #ea817c\"";
                                        }
                                        ?>
                                        <tr id="detalle<?= $p->id_comanda_detalle;?>" <?= $estilo;?>>
                                            <!--<td><?= $p->mesa_nombre;?></td>-->
                                            <td><?= $p->producto_nombre;?></td>
                                            <td><?= $p->comanda_detalle_observacion?></td>
                                            <!--<td><?= $p->comanda_correlativo;?></td>-->
                                            <td><?= $p->comanda_detalle_precio;?></td>
                                            <td><?= $p->comanda_detalle_cantidad;?></td>
                                            <td><?= $p->comanda_detalle_total;?></td>
                                            <!--<td><?= $p->comanda_detalle_fecha_registro;?></td>-->


                                            <?php
                                            $consultar_estado = $this->pedido->consultar($p->id_comanda_detalle);
                                            (!empty($consultar_estado))?$det++:$det_cero++;
                                            ($p->comanda_detalle_estado_venta == 1)?$resultado=true:$resultado=false;
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
                                <div class="col-lg-3 col-sm-3 col-md-3" style="display: none">
                                    <a id="imprimir_ticket_comanda" style="color: white;" class="btn btn-warning" onclick="ticket_comanda_pedido(<?= $ultimo_valor_; ?>)"><i class="fa fa-print"></i> Comanda</a>
                                </div>
                                <div class="col-lg-3 col-sm-3 col-md-3" style="display: none">
                                    <a id="imprimir_ticket" style="color: white;" class="btn btn-success" onclick="ticket_pedido(<?= $id; ?>)"><i class="fa fa-print"></i> Pre Cuenta</a>
                                </div>
                                <div class="col-lg-8 col-md-8 col-xs-8 col-sm-8"></div>
                                <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3" style="text-align: right">
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
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>pedido.js"></script>

<script>
    $(document).ready(function (){
        $("#mostrar").hide();
        Consultar_serie();
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
    function consultar_documento(valor){
        var tipo_doc = $('#select_tipodocumento').val();
        if(tipo_doc == "2"){
            ObtenerDatosDni(valor);
        }else if(tipo_doc == "4"){
            ObtenerDatosRuc(valor);
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
                $("#cliente_nombre").val(r.result.name+ ' ' + r.result.first_name+ ' ' + r.result.last_name);
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
                $("#cliente_nombre").val(r.result.razon_social);
            }
        });
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
    $("#guardar_pedido_nuevo").on('submit', function(e){
        e.preventDefault();
        var valor = true;
        var boton = 'btn-guardar_nuevo';
        //var id_mesa = $('#id_mesa').val();
        var id_comanda = $('#id_comanda').val();
        var id_producto = $('#id_producto').val();
        var comanda_detalle_precio = $('#comanda_detalle_precio').val() * 1;
        var comanda_detalle_cantidad = $('#comanda_detalle_cantidad').val() * 1;
        var comanda_detalle_despacho = $('#comanda_detalle_despacho').val();

        var comanda_detalle_observacion = $('#comanda_detalle_observacion').val();
        var contenido_pedido = $('#contenido_pedido').val();


        var subtotal = comanda_detalle_cantidad * comanda_detalle_precio;
        subtotal.toFixed(2);
        subtotal = parseFloat(subtotal);

        var comanda_detalle_total = $('#comanda_detalle_total').val(subtotal);

        if (valor){
            $.ajax({
                type:"POST",
                url: urlweb + "api/Pedido/guardar_comanda_nuevo",
                dataType: 'json',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    cambiar_estado_boton(boton,'Guardando...',true);
                    //$('#btn-guardar_nuevo').attr("disabled",true);
                    //$('#btn-guardar_nuevo').css("opacity",".5");
                },
                success:function (r) {
                    cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
                    switch (r.result.code) {
                        case 1:
                            respuesta('¡Guardado con Exito!','success');
                            setTimeout(function () {
                                location.reload()
                            }, 500);
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