var total_pedido_detalle = 0;
var pedido_check_ = "";

var gravada = 0.00;
var exonerado = 0.00;
var inafecto = 0.00;
var gratuito = 0.00;
var total_icbper = 0.00;
var igv = 0.00;
var igv_porcentaje = 0.18;

var fecha = new Date();
var anho = fecha.getFullYear();
if(anho == '2021'){
    var icbper = 0.30;
}else if(anho == '2022'){
    var icbper = 0.40;
}else{
    var icbper = 0.50;
}

function guardar_reservas(){
    var boton = 'btn-agregar-reserva';
    var valor = true;
    var id_mesa = $('#id_mesa').val();
    var reserva_nombre = $('#reserva_nombre').val();
    var reserva_cantidad = $('#reserva_cantidad').val();
    var reserva_fecha = $('#reserva_fecha').val();
    var reserva_hora = $('#reserva_hora').val();
    var reserva_contacto = $('#reserva_contacto').val();

    var id_reserva = $('#id_reserva').val();

    if(valor){
        var cadena = "id_mesa=" + id_mesa +
            "&reserva_nombre=" + reserva_nombre +
            "&reserva_cantidad=" + reserva_cantidad +
            "&reserva_fecha=" + reserva_fecha +
            "&reserva_hora=" + reserva_hora +
            "&reserva_contacto=" + reserva_contacto +
            "&id_reserva=" + id_reserva;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/guardar_reserva",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'guardando...', true);
            },
            success: function (r){
                cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Reserva guardada exitosamente...!', 'success');
                        setTimeout(function () {
                            location.reload()
                        }, 300);
                        break;
                    case 2:
                        respuesta('Error al reservar. Comuniquese con BufeoTec', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}

function guardar_cambio(){
    var boton = 'btn-agregar-cambio';
    var valor = true;
    var id_mesa_oc = $('#id_mesa_oc').val();
    var estado = $('#estado').val();

    if(valor){
        var cadena = "id_mesa_oc=" + id_mesa_oc +
            "&estado=" + estado;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/guardar_cambio",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'guardando...', true);
            },
            success: function (r){
                cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Realizado correctamente...!', 'success');
                        setTimeout(function () {
                            location.reload()
                        }, 200);
                        break;
                    case 2:
                        respuesta('Error. Comuniquese con BufeoTec', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}

function calcular_total(id){
    var che = $('#id_comanda_detalle_'+ id);
    var pre = $('#precio_total_detalle'+ id);
    var afectacion = $('#tipo_afectacion_producto'+ id).val();
    var cantidad = $('#comanda_detalle_cantidad'+ id).val() * 1;
    var precio_unitario = $('#producto_precio_venta'+ id).val() * 1;
    var id_receta = $('#id_receta'+ id).val() * 1;
    var tot = pre.val() * 1;
    var subtotal = precio_unitario * cantidad;
        if(che.is(':checked')) {
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
            if(id_receta == "131"){
                icbper = icbper * cantidad;
                total_icbper = icbper;
                total_pedido_detalle = total_pedido_detalle + icbper;
            }



            //total_pedido_detalle = total_pedido_detalle + tot;
        }else{
            if(afectacion == "10"){
                gravada = gravada - subtotal;
                igv = igv - (subtotal * igv_porcentaje);

                total_pedido_detalle = total_pedido_detalle - subtotal - (subtotal * igv_porcentaje);
            }
            if(afectacion == "20"){
                exonerado = exonerado - subtotal;
                total_pedido_detalle = total_pedido_detalle - subtotal ;
            }
            if(afectacion == "30"){
                inafecto = inafecto - subtotal;
                total_pedido_detalle = total_pedido_detalle - subtotal;
            }
            if(afectacion == "21"){
                gratuito = gratuito - subtotal;
                //total_pedido_detalle = total_pedido_detalle - subtotal;
            }
            if(id_receta == "131"){
                icbper = icbper * cantidad;
                total_icbper = total_icbper - icbper;
                total_pedido_detalle = total_pedido_detalle - icbper;
            }
            //total_pedido_detalle = total_pedido_detalle - tot;
        }

    $('#op_gravadas').html(gravada.toFixed(2));
    $('#op_gravadas_').val(gravada.toFixed(2));
    $('#igv').html(igv.toFixed(2));
    $('#igv_').val(igv.toFixed(2));
    $('#op_exoneradas').html(exonerado.toFixed(2));
    $('#op_exoneradas_').val(exonerado.toFixed(2));
    $('#op_inafectas').html(inafecto.toFixed(2));
    $('#op_inafectas_').val(inafecto.toFixed(2));
    $('#op_gratuitas').html(gratuito.toFixed(2));
    $('#op_gratuitas_').val(gratuito.toFixed(2));
    $('#icbper').html(total_icbper.toFixed(2));
    $('#icbper_').val(total_icbper.toFixed(2));
    $('#venta_total').html(total_pedido_detalle.toFixed(2));
    $('#venta_total_').val(total_pedido_detalle.toFixed(2));

   // var calcular_igv = tot * 0.18 ;
    //igv = calcular_igv;
    //$('#igv_total').html(igv);
}
function obtener_total(){
    var gravada = $('#op_gravadas_').val() * 1;
    var exonerada = $('#op_exoneradas_').val() * 1;
    var total_consumo = gravada + exonerada;
    var che = $('#por_consumo');
    if(che.is(':checked')){
        $('#por_consumo_precio').html(total_consumo.toFixed(2));
        $('#por_consumo_precio_valor').val(total_consumo.toFixed(2));
        $('#por_consumo_total').html(total_consumo.toFixed(2));
        $('#por_consumo_total_valor').val(total_consumo.toFixed(2));
    }else{
        $('#por_consumo_precio').html('0.00');
        $('#por_consumo_precio_valor').val('0');
        $('#por_consumo_total').html('0.00');
        $('#por_consumo_total_valor').val('0');
    }
}

function agregar(){
    var boton = 'btn-agregar';
    var valor = true;
    var id_cliente = $('#id_cliente').val();
    var select_tipodocumento = $('#select_tipodocumento').val();
    var cliente_numero = $('#cliente_numero').val();
    var cliente_nombre = $('#cliente_nombre').val();
    var cliente_direccion = $('#cliente_direccion').val();
    var id_mesa = $('#id_mesa').val();
    var id_tipo_pago = $('#id_tipo_pago').val();
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
    var imprimir = $('#imprimir').val();
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
    //obtenemos valores si la venta es por consumo - INICIO
    var por_consumo_total_valor = $('#por_consumo_total_valor').val();
    //obtenemos valores si la venta es por consumo - FIN

    $("input:checkbox:checked").each(function() {
        pedido_check_ += $(this).val() + "-.-.";
    });
    $('#datos_detalle_pedido').val(pedido_check_);
    var datos_detalle_pedido = $('#datos_detalle_pedido').val();
    //validar campos vacios
    //valor = validar_campo_vacio('cliente_numero', cliente_numero, valor);
    //valor = validar_campo_vacio('select_tipodocumento', select_tipodocumento, valor);
    valor = validar_campo_vacio('id_tipo_pago', id_tipo_pago, valor);
    valor = validar_campo_vacio('tipo_venta', tipo_venta, valor);
    valor = validar_campo_vacio('tipo_moneda', tipo_moneda, valor);
    valor = validar_campo_vacio('serie', serie, valor);
    valor = validar_campo_vacio('correlativo', correlativo, valor);
    valor = validar_campo_vacio('cliente_numero', cliente_numero, valor);
    if(venta_total === "0.00"){
        var temporal_total = "";
        valor = validar_campo_vacio('venta_total_', temporal_total, valor);
    }
    if(gratis == 1){
        valor = validar_campo_vacio('observacion_cortesia', observacion_cortesia, valor);
    }

    if(valor){
        var cadena = "id_cliente=" + id_cliente +
            "&select_tipodocumento=" + select_tipodocumento +
            "&cliente_numero=" + cliente_numero +
            "&cliente_nombre=" + cliente_nombre +
            "&cliente_direccion=" + cliente_direccion +
            "&datos_detalle_pedido=" + datos_detalle_pedido +
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
            "&por_consumo_total_valor=" + por_consumo_total_valor +
            "&id_mesa=" + id_mesa;

        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/guardar_venta",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'cobrando...', true);
            },
            success: function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Venta realizada correctamente!', 'success');
                        if(r.result.pago == 0){
                            setTimeout(function () {
                                location.reload()
                            }, 1000);
                        }else{
                            setTimeout(function () {
                                location.href = urlweb +  'Pedido/gestionar';
                            }, 1000);
                        }
                        break;
                    case 2:
                        respuesta('Error al generar Venta', 'error');
                        break;
                    case 5:
                        respuesta('Error al generar Venta, revisar Cliente', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}

function agregar_(){
    var valor = true;
    var id_cliente = $('#id_cliente').val();
    var select_tipodocumento = $('#select_tipodocumento').val();
    var cliente_numero = $('#cliente_numero').val();
    var cliente_nombre = $('#cliente_nombre').val();
    var cliente_direccion = $('#cliente_direccion').val();
    var id_mesa = $('#id_mesa').val();
    var id_tipo_pago = $('#id_tipo_pago').val();
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

    $("input:checkbox:checked").each(function() {
        pedido_check_ += $(this).val() + "-.-.";
    });
    $('#datos_detalle_pedido').val(pedido_check_);
    var datos_detalle_pedido = $('#datos_detalle_pedido').val();

    //validar campos vacios
    //valor = validar_campo_vacio('cliente_numero', cliente_numero, valor);
    //valor = validar_campo_vacio('select_tipodocumento', select_tipodocumento, valor);
    valor = validar_campo_vacio('id_tipo_pago', id_tipo_pago, valor);
    valor = validar_campo_vacio('tipo_venta', tipo_venta, valor);
    valor = validar_campo_vacio('tipo_moneda', tipo_moneda, valor);
    valor = validar_campo_vacio('serie', serie, valor);
    valor = validar_campo_vacio('correlativo', correlativo, valor);
    valor = validar_campo_vacio('venta_total', venta_total, valor);

    if(valor){
        var cadena = "id_cliente=" + id_cliente +
            "&select_tipodocumento=" + select_tipodocumento +
            "&cliente_numero=" + cliente_numero +
            "&cliente_nombre=" + cliente_nombre +
            "&cliente_direccion=" + cliente_direccion +
            "&datos_detalle_pedido=" + datos_detalle_pedido +
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
            "&id_mesa=" + id_mesa;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/guardar_venta",
            data: cadena,
            dataType: 'json',
            success: function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Venta realizada correctamente!', 'success');
                        if(r.result.pago == 0){
                            setTimeout(function () {
                                location.reload()
                            }, 300);
                        }else{
                            setTimeout(function () {
                                location.href = urlweb +  'Pedido/delivery';
                            }, 300);
                        }
                        break;
                    case 2:
                        respuesta('Error al generar Venta', 'error');
                        break;
                    case 5:
                        respuesta('Error al generar Venta, revisar Cliente', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}

function cambiar_cantidad(){
    var valor = true;
    var comanda_cantidad_personas = $('#comanda_cantidad_personas').val();
    var id_comanda = $('#id_comanda').val();

    if(valor){
        var cadena = "comanda_cantidad_personas=" + comanda_cantidad_personas +
                    "&id_comanda=" + id_comanda;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/cambiar_cantidad_personas",
            data: cadena,
            dataType: 'json',
            success: function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Capacidad de Personas cambiada correctamente!', 'success');
                        setTimeout(function () {
                            location.reload()
                        }, 300);
                        break;
                    case 2:
                        respuesta('Error al cambiar capacidad', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}

function agregar_grupo(){
    var valor = true;
    var grupo_nombre = $('#grupo_nombre').val();
    var grupo_ticketera = $('#grupo_ticketera').val();

    if(valor){
        var cadena = "grupo_nombre=" + grupo_nombre +
            "&grupo_ticketera=" + grupo_ticketera;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/agregar_grupo",
            data: cadena,
            dataType: 'json',
            success: function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Agregado correctamente!', 'success');
                        setTimeout(function () {
                            location.reload()
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al agregar', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}

function atender(id_comanda_detalle, comanda_detalle_estado){

    var cadena = "id_comanda_detalle=" + id_comanda_detalle +
        "&comanda_detalle_estado=" + comanda_detalle_estado;

    $.ajax({
        type:"POST",
        url: urlweb + "api/Pedido/cambiar_estado_pedido",
        data : cadena,
        dataType: 'json',
        success:function (r) {
            switch (r.result.code) {
                case 1:
                    respuesta('¡Pasar pedido para atención! Recargando...', 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 300);
                    break;
                case 2:
                    respuesta('Error al pasar para atencion, vuelva a intentarlo', 'error');
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    break;
            }
        }
    });
}

function guardar_pedido(id,producto_nombre, precio,afectacion){
    $('#id_producto').val(id);
    $('#producto_nombre').val(producto_nombre);
    $('#comanda_detalle_precio').val(precio);
    $('#codigo_afectacion_d').val(afectacion);

}

function guardar_cliente_delivery(id,cliente_nombre,cliente_numero, cliente_direccion,cliente_telefono){
    $('#id_cliente').val(id);
    $('#cliente_nombre_d').val(cliente_nombre);
    $('#cliente_numero_d').val(cliente_numero);
    $('#cliente_telefono_d').val(cliente_telefono);

    cliente_direccion = $('#id_cliente_direccion' + id).val();
    $('#cliente_direccion_d').val(cliente_direccion);
    $('#cliente_delivery').html('');
}

function guardar_cliente_delivery_pagos(id,cliente_nombre,cliente_numero, cliente_direccion,cliente_telefono){
    $('#id_cliente').val(id);
    $('#cliente_nombre').html(cliente_nombre);
    $('#cliente_numero').html(cliente_numero);
    $('#cliente_telefono').html(cliente_telefono);

    cliente_direccion = $('#id_cliente_direccion' + id).val();
    $('#cliente_direccion').html(cliente_direccion);
}

function guardar_cliente(id,cliente_nombre,cliente_numero, cliente_direccion, id_tipodocumento){
    $('#id_cliente').val(id);
    $('#cliente_nombre').val(cliente_nombre);
    $('#cliente_numero').val(cliente_numero);

    //cliente_direccion = $('#id_cliente_direccion'+id).val();
    $('#cliente_direccion').val(cliente_direccion);
    $('#select_tipodocumento').val(id_tipodocumento);
    $('#cliente').html('');
}

function guardar_pedido_nuevo(id,producto_nombre, precio){
    $('#id_producto').val(id);
    $('#producto_nombre').val(producto_nombre);
    $('#comanda_detalle_precio').val(precio);
    $("#mostrar").show();
    $("#producto_nuevo").html('');
    $("#producto_nombre_").html(producto_nombre);
    $("#comanda_detalle_precio_").html(precio);

}

function despachar(id_comanda_detalle, comanda_detalle_estado){

    var cadena = "id_comanda_detalle=" + id_comanda_detalle +
        "&comanda_detalle_estado=" + comanda_detalle_estado;

    $.ajax({
        type:"POST",
        url: urlweb + "api/Pedido/cambiar_estado_pedido",
        data : cadena,
        dataType: 'json',
        success:function (r) {
            switch (r.result.code) {
                case 1:
                    respuesta('¡Pedido entregado correctamente! Recargando...', 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 300);
                    break;
                case 2:
                    respuesta('Error, vuelva a intentarlo', 'error');
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    break;
            }
        }
    });
}

function productos(){
    var id_producto =  $("#id_producto").val();
    $.ajax({
        type: "POST",
        url: urlweb + "api/Pedido/ver_productos",
        data: "id_producto="+id_producto,
        dataType: 'json',
        success:function (r) {
            $("#producto").html(r);
        }

    });
}

function productos_nuevo(){
    var parametro_ =  $("#parametro").val();
    var parametro=parametro_.replace("+",".--");
    $.ajax({
        type: "POST",
        url: urlweb + "api/Pedido/ver_productos_nuevo",
        data: "parametro="+parametro,
        dataType: 'json',
        success:function (r) {
            $("#producto_nuevo").html(r.producto_nuevo);
            //$("#ver_seleccion").html(r.ver_seleccion);

        }

    });
}

function buscar_cliente(){
    var parametro_c =  $("#parametro_c").val();

   $.ajax({
        type: "POST",
        url: urlweb + "api/Pedido/buscar_cliente",
        data: "parametro_c="+parametro_c,
        dataType: 'json',
        success:function (r) {
            $("#cliente").html(r);
        }
    });
}

function buscar_cliente_delivery(){
    var parametro_delivery =  $("#parametro_delivery").val();

    $.ajax({
        type: "POST",
        url: urlweb + "api/Pedido/buscar_cliente_delivery",
        data: "parametro_delivery="+parametro_delivery,
        dataType: 'json',
        success:function (r) {
            $("#cliente_delivery").html(r);
        }
    });
}

function buscar_cliente_delivery_pagos(){
    var parametro_delivery =  $("#parametro_delivery").val();

    $.ajax({
        type: "POST",
        url: urlweb + "api/Pedido/buscar_cliente_delivery_pagos",
        data: "parametro_delivery="+parametro_delivery,
        dataType: 'json',
        success:function (r) {
            $("#cliente_delivery_pagos").html(r);
        }
    });
}

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

function eliminar_comanda_detalle(){
    var valor = true;
    //var password = "";
    var password = $('#password').val();
    var id_comanda_detalle = $('#id_comanda_detalle_eliminar').val();
    var id_comanda = $('#id_comanda_eliminar').val();
    var id_mesa = $('#id_mesa_eliminar').val();
    var comanda_detalle_eliminacion = $('#comanda_detalle_eliminacion').val();
    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_parametro_vacio('id_comanda_detalle',id_comanda_detalle, valor);
    valor = validar_parametro_vacio('id_comanda',id_comanda, valor);
    valor = validar_parametro_vacio('id_mesa',id_mesa, valor);
    valor = validar_parametro_vacio('password',password, valor);
    valor = validar_parametro_vacio('comanda_detalle_eliminacion',comanda_detalle_eliminacion, valor);
    //var password = $('#password').val();

    if(valor) {
        var cadena = "id_comanda_detalle=" + id_comanda_detalle +
                    "&id_mesa=" + id_mesa +
                    "&id_comanda=" + id_comanda +
                    "&comanda_detalle_eliminacion=" + comanda_detalle_eliminacion +
                    "&password=" + password;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/eliminar_comanda_detalle",
            data: cadena,
            dataType: 'json',
            success: function (r) {
                switch (r.result.code) {
                    case 1:
                        $('#detalle' + id_comanda_detalle).remove();
                        respuesta('¡Detalle del Pedido Eliminado!', 'success');
                        if(r.result.mesa == 0){
                            setTimeout(function () {
                                location.reload()
                            }, 300);
                        }else{
                            setTimeout(function () {
                                location.href = urlweb +  'Pedido/gestionar';
                            }, 1000);
                        }
                        break;
                    case 2:
                        respuesta('Error al eliminar el detalle del pedido', 'error');
                        break;
                    case 5:
                        respuesta("La Contraseña de Usuario no es Correcta", 'error');
                        $('#password').css('border','solid red');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}

function eliminar_reserva(id_reserva,id_mesa){
    var valor = true;
    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_parametro_vacio(id_reserva, valor);
    valor = validar_parametro_vacio(id_mesa, valor);
    if(valor) {
        var cadena = "id_reserva=" + id_reserva +
                    "&id_mesa=" + id_mesa;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/eliminar_reserva",
            data: cadena,
            dataType: 'json',
            success: function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Reserva Eliminada...!', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 400);
                        break;
                    case 2:
                        respuesta('Error al eliminar, comuniquese con BufeoTec', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}

function mostrar_mesa(id_mesa){
    var valor = true;
    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_parametro_vacio(id_mesa, valor);
    if(valor) {
        var cadena = "id_mesa=" + id_mesa;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/mesa_visible",
            data: cadena,
            dataType: 'json',
            success: function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Cambiado exitosamente...!', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 300);
                        break;
                    case 2:
                        respuesta('Error, comuniquese con BufeoTec', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}

function cambiar_mesa(){
    var valor = true;
    var id_mesa_nuevo = $('#id_mesa_nuevo').val();
    var id_comanda = $('#id_comanda').val();
    var id_mesa = $('#id_mesa').val();

    if(valor) {
        var cadena = "id_mesa_nuevo=" + id_mesa_nuevo +
                    "&id_comanda=" + id_comanda +
                    "&id_mesa=" + id_mesa;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/cambiar_mesa",
            data: cadena,
            dataType: 'json',
            success: function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Mesa Cambiada correctamente!', 'success');
                        setTimeout(function () {
                            location.href = urlweb +  'Pedido/gestionar';
                        }, 300);
                        break;
                    case 2:
                        respuesta('Error al cambiar mesa', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }

}

function transferir_pedido(){
    var valor = true;
    var id_mesa_pn = $('#id_mesa_pn').val();
    var id_comanda = $('#id_comanda').val();
    var id_mesa = $('#id_mesa').val();

    if(valor) {
        var cadena = "id_mesa_pn=" + id_mesa_pn +
            "&id_comanda=" + id_comanda +
            "&id_mesa=" + id_mesa;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/transferir_pedido",
            data: cadena,
            dataType: 'json',
            success: function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Cambiado correctamente!', 'success');
                        setTimeout(function () {
                            location.href = urlweb +  'Pedido/gestionar';
                        }, 300);
                        break;
                    case 2:
                        respuesta('Error al transferir pedidos. Llame a BufeoTec Company', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }

}

function Consultar_serie_delivery(){
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

function Consultar_serie(){
    var tipo_venta =  $("#tipo_venta").val();
    if(tipo_venta == "01"){
        $("#select_tipodocumento").val('4');
        $("#cliente_numero").val('');
        $("#cliente_nombre").val('');
    }else{
        $("#cliente_numero").val('11111111');
        $("#cliente_nombre").val('ANONIMO');
    }
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
        url: urlweb + "api/Pedido/consultar_serie",
        data: cadena,
        dataType: 'json',
        success:function (r) {
            $("#correlativo").val(r.correlativo);
        }

    });
}

function calcular_vuelto(){
    var pago = $('#pago_cliente').val();
    var venta_total_ = $('#venta_total_').val();
    var vuelto = pago - venta_total_;
    $('#vuelto').html(vuelto.toFixed(2));
    $('#vuelto_').val(vuelto.toFixed(2));
}

function seleccionar_tipodocumento(){
    var tipo_documento = $('#select_tipodocumento').val();
    if(tipo_documento == "4"){
        $("#tipo_venta").val('01');
    }else{
        $("#tipo_venta").val('03');
    }
    Consultar_serie();
}

function eliminar_comanda_delivery(id_comanda_detalle, id_comanda){
    var valor = true;
    var password = $('#password').val();
    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_parametro_vacio(id_comanda_detalle, valor);
    valor = validar_parametro_vacio(id_comanda, valor);
    valor = validar_campo_vacio('password',password, valor);

    if(valor) {
        var cadena = "id_comanda_detalle=" + id_comanda_detalle +
            "&id_comanda=" + id_comanda +
            "&password=" + password;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/eliminar_comanda_delivery",
            data: cadena,
            dataType: 'json',
            success: function (r) {
                switch (r.result.code) {
                    case 1:
                        $('#comanda' + id_comanda).remove();
                        respuesta('¡Pedido Eliminado!', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al eliminar el detalle del pedido', 'error');
                        break;
                    case 3:
                        respuesta("La Contraseña de Usuario no es Correcta", 'error');
                        $('#password').css('border','solid red');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}

function cambiar_comanda_detalle_cantidad(id, id_comanda){
    var valor = true;
    var cantidad_detalle_nuevo = $('#cantidad_detalle_cantidad' + id).val() * 1;
    var comanda_detalle_precio = $('#comanda_detalle_precio' + id).val() * 1;
    var total_ = cantidad_detalle_nuevo * comanda_detalle_precio;
    var total = total_.toFixed(2);
    $('#span_comanda_detalle_total' + id).html(total);
    //Validamos si los campos a usar no se encuentran vacios

    if(valor) {
        var cadena = "cantidad_detalle_nuevo=" + cantidad_detalle_nuevo +
                    "&id_comanda_detalle=" + id +
                    "&id_comanda=" + id_comanda +
                    "&total=" + total;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/cambiar_comanda_detalle_cantid",
            data: cadena,
            dataType: 'json',
            success: function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Cantidad Actualizada!', 'success');
                        location.reload();
                        /*setTimeout(function () {
                            location.reload();
                        }, 900);*/
                        break;
                    case 2:
                        respuesta('Error al cambiar la cantidad', 'error');
                        break;

                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}
