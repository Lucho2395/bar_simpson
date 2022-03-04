function enviar_comprobante_sunat(id_venta) {
    var cadena = "id_venta=" + id_venta;
    var boton = 'btn_enviar'+id_venta;
    $.ajax({
        type: "POST",
        url: urlweb + "api/Ventas/crear_xml_enviar_sunat",
        data: cadena,
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'enviando...', true);
        },
        success:function (r) {
            cambiar_estado_boton(boton, "<i style=\"font-size: 16pt;\" class=\"fa fa-check margen\"></i>", false);
            switch (r.result.code) {
                case 1:
                    respuesta('¡Comprobante Enviado a Sunat!', 'success');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 2:
                    respuesta('Error al generar el comprobante electronico', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 3:
                    respuesta('Error, Sunat rechazó el comprobante', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 4:
                    respuesta('Error de comunicacion con Sunat', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 5:
                    respuesta('Error al guardar en base de datos', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
            }
        }

    });
}
/*function ver_detalle_venta(id){
    var id_venta = id;
    $.ajax({
        type: "POST",
        url: urlweb + "api/Ventas/consular_detalle_venta",
        data: "id_venta=" + id,
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

}*/
function crear_enviar_resumen_sunat(){
    var fecha_post = $('#fecha_post').val();
    var cadena = "fecha=" + fecha_post;
    var boton = 'boton_enviar_resumen';
    $.ajax({
        type: "POST",
        url: urlweb + "api/Ventas/crear_enviar_resumen_sunat",
        data: cadena,
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Enviando...', true);
        },
        success:function (r) {
            cambiar_estado_boton(boton, "Enviar Comprobantes", false);
            switch (r.result.code) {
                case 1:
                    respuesta('¡Resumen Creado y Enviado a Sunat!', 'success');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 2:
                    respuesta('Error al generar el Resumen Diario', 'error');
                    break;
                case 3:
                    respuesta('Error, Sunat rechazó el comprobante', 'error');
                    break;
                case 4:
                    respuesta(r.result.message, 'error');
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    break;
            }
        }

    });
}
function comunicacion_baja(id_venta){
    var cadena = "id_venta=" + id_venta;
    var boton = 'btn_anular'+id_venta;
    $.ajax({
        type: "POST",
        url: urlweb + "api/Ventas/comunicacion_baja",
        data: cadena,
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Anulando...', true);
        },
        success:function (r) {
            cambiar_estado_boton(boton, "ANULAR", false);
            switch (r.result.code) {
                case 1:
                    respuesta('¡Comprobante Enviado a Sunat!', 'success');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 2:
                    respuesta('Error al generar el comprobante electronico', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 3:
                    respuesta('Error, Sunat rechazó el comprobante', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 4:
                    respuesta('Error de comunicacion con Sunat', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 5:
                    respuesta('Error al guardar en base de datos', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    break;
            }
        }

    });
}
function anular_boleta_cambiarestado(id_venta, estado){
    var cadena = "id_venta=" + id_venta + "&estado=" + estado;
    var boton = 'btn_anular_boleta'+id_venta;
    $.ajax({
        type: "POST",
        url: urlweb + "api/Ventas/anular_boleta_cambiarestado",
        data: cadena,
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Anulando...', true);
        },
        success:function (r) {
            cambiar_estado_boton(boton, "ANULAR", false);
            switch (r.result.code) {
                case 1:
                    respuesta('¡Comprobante Anulado, listo para ser enviado por Resumen Diario!', 'success');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 2:
                    respuesta('Error al anular el comprobante electronico', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    break;
            }
        }

    });
}


function poner_id_venta(id){
    $("#id_venta_cliente").val(id);
}


function enviar_email_cliente(){
    var correo = $("#correo_del_cliente").val();
    var id_venta = $("#id_venta_cliente").val();
    if(correo == ""){
        respuesta('Debe introducir una dirección de correo electronico', 'error');
    } else {
        var cadena = "email=" + correo+"&id="+id_venta;

        $.ajax({
            type:"POST",
            url: urlweb + "api/Ventas/enviar_venta_correo",
            data : cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton('guardar_envio_mensajito', 'Enviando correo, espere un momento...', true);
                $('#cancelar_envio_mensajito').hide();
            },
            success:function (r) {
                cambiar_estado_boton('guardar_envio_mensajito', 'Guardar', true);
                $('#cancelar_envio_mensajito').show();
                switch (r.result) {
                    case 1:
                        $("#correo_del_cliente").val("");
                        respuesta('¡Correo Enviado!', 'success');
                        break;
                    case 2:
                        respuesta('Ocurrió Un Error al enviar correo', 'error');
                        break;
                    default:
                        respuesta('Ocurrió Un Error Desconocido', 'error');
                }
            }
        });
    }
}