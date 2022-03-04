$("#gestionarInfoCliente").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-cliente";
    //Extraemos las variable según los valores del campo consultado
    var cliente_razonsocial = $('#cliente_razonsocial').val();
    var cliente_nombre = $('#cliente_nombre').val();
    var cliente_apellido_paterno = $('#cliente_apellido_paterno').val();
    var cliente_apellido_materno = $('#cliente_apellido_materno').val();
    var cliente_numero = $('#cliente_numero').val();
    var cliente_correo = $('#cliente_correo').val();
    var cliente_direccion = $('#cliente_direccion').val();
    var cliente_direccion_2 = $('#cliente_direccion_2').val();
    var cliente_telefono = $('#cliente_telefono').val();
    //var cliente_fecha = $('#cliente_fecha').val();
    var cliente_estado = $('#cliente_estado').val();

    //Validamos si los campos a usar no se encuentran vacios
    //valor = validar_campo_vacio('cliente_razonsocial', cliente_razonsocial, valor);
    //valor = validar_campo_vacio('cliente_nombre', cliente_nombre, valor);
    valor = validar_campo_vacio('cliente_numero', cliente_numero, valor);
    //valor = validar_campo_vacio('cliente_direccion', cliente_direccion, valor);
    //valor = validar_campo_vacio('cliente_telefono', cliente_telefono, valor);
    //valor = validar_campo_vacio('cliente_fecha', cliente_fecha, valor);
    //valor = validar_campo_vacio('cliente_estado', cliente_estado, valor);

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Cliente/guardar_cliente",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Cliente guardado! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al guardar Cliente, vuelva a intentarlo', 'error');
                        break;
                    case 5:
                        respuesta('El DNI ya se encuentra registrado', 'error');
                        $('#cliente_numero').css('border','solid red');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});


function agregar_cliente_nuevo(){
    var valor = true;
    var boton = "btn-agregar-cliente";
    //Extraemos las variable según los valores del campo consultado
    var id_tipodocumento = $('#id_tipodocumento').val();
    var cliente_razonsocial = $('#cliente_razonsocial').val();
    var cliente_nombre = $('#cliente_nombre').val();
    var cliente_apellido_paterno = $('#cliente_apellido_paterno').val();
    var cliente_apellido_materno = $('#cliente_apellido_materno').val();
    var cliente_numero = $('#cliente_numero').val();
    var cliente_correo = $('#cliente_correo').val();
    var cliente_direccion = $('#cliente_direccion').val();
    var cliente_direccion_2 = $('#cliente_direccion_2').val();
    var cliente_telefono = $('#cliente_telefono').val();
    //var cliente_fecha = $('#cliente_fecha').val();
    var cliente_estado = $('#cliente_estado').val();

    //Validamos si los campos a usar no se encuentran vacios
    //valor = validar_campo_vacio('cliente_nombre', cliente_nombre, valor);
    //valor = validar_campo_vacio('cliente_razonsocial', cliente_razonsocial, valor);
    //valor = validar_campo_vacio('cliente_numero', cliente_numero, valor);
    //valor = validar_campo_vacio('cliente_direccion', cliente_direccion, valor);
    //valor = validar_campo_vacio('cliente_telefono', cliente_telefono, valor);
    //valor = validar_campo_vacio('cliente_fecha', cliente_fecha, valor);
    //valor = validar_campo_vacio('cliente_estado', cliente_estado, valor);

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor) {
        var cadena = "id_tipodocumento=" + id_tipodocumento +
            "&cliente_razonsocial=" + cliente_razonsocial +
            "&cliente_nombre=" + cliente_nombre +
            "&cliente_numero=" + cliente_numero +
            "&cliente_apellido_paterno=" + cliente_apellido_paterno +
            "&cliente_apellido_materno=" + cliente_apellido_materno +
            "&cliente_correo=" + cliente_correo +
            "&cliente_direccion=" + cliente_direccion +
            "&cliente_direccion_2=" + cliente_direccion_2 +
            "&cliente_telefono=" + cliente_telefono;
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Cliente/guardar_cliente_nuevo",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success: function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
                switch (r.result.code) {
                    case 1:
                        var nombre = r.result.dato_ultimo_cliente.cliente_nombre + '' + r.result.dato_ultimo_cliente.cliente_razonsocial;
                        respuesta('¡Cliente guardado! Recargando...', 'success');
                        $('#id_cliente').val(r.result.dato_ultimo_cliente.id_cliente);
                        $('#cliente_nombre_d').val(nombre);
                        $('#cliente_numero_d').val(r.result.dato_ultimo_cliente.cliente_numero);
                        $('#cliente_direccion_d').val(r.result.dato_ultimo_cliente.cliente_direccion);
                        $('#cliente_telefono_d').val(r.result.dato_ultimo_cliente.cliente_telefono);
                        break;
                    case 2:
                        respuesta('Error al guardar Cliente, vuelva a intentarlo', 'error');
                        break;
                    case 5:
                        respuesta('El DNI ya se encuentra registrado', 'error');
                        $('#cliente_numero').css('border', 'solid red');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}

function guardar_puntos(){
    var valor = true;
    var boton = "btn-agregar-puntos";
    //Extraemos las variable según los valores del campo consultado
    var puntos_cantidad = $('#puntos_cantidad').val();
    var puntos_cantidad_soles = $('#puntos_cantidad_soles').val();

    validar_campo_vacio('puntos_cantidad', puntos_cantidad, valor);
    validar_campo_vacio('puntos_cantidad_soles', puntos_cantidad_soles, valor);
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor) {
        var cadena = "puntos_cantidad=" + puntos_cantidad +
            "&puntos_cantidad_soles=" + puntos_cantidad_soles;
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Cliente/guardar_puntos",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success: function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Guardado con exito! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 400);
                        break;
                    case 2:
                        respuesta('Error al guardar...', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}

function editar_cliente(id_cliente, cliente_razonsocial, cliente_nombre,cliente_apellido_paterno,cliente_apellido_materno, cliente_numero, cliente_correo, cliente_direccion,cliente_direccion_2,cliente_telefono, cliente_fecha, cliente_estado, id_tipodocumento){
    $('#id_cliente').val(id_cliente);
    $('#cliente_razonsocial_e').val(cliente_razonsocial);
    $('#cliente_nombre_e').val(cliente_nombre);
    $('#cliente_apellido_paterno_e').val(cliente_apellido_paterno);
    $('#cliente_apellido_materno_e').val(cliente_apellido_materno);
    $('#cliente_numero_e').val(cliente_numero);
    $('#cliente_correo_e').val(cliente_correo);
    $('#cliente_direccion_e').val(cliente_direccion);
    $('#cliente_direccion_2_e').val(cliente_direccion_2);
    $('#cliente_telefono_e').val(cliente_telefono);
    //$('#cliente_fecha_e').val(cliente_fecha);
    $("#cliente_estado_e").val(cliente_estado);
    $("#id_tipodocumento_e").val(id_tipodocumento);
    cambiar_color_estado('cliente_estado_e');
}

$("#gestionarInfoClienteEdit").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-editar-cliente";
    //Extraemos las variable según los valores del campo consultado
    var id_cliente = $('#id_cliente').val();var cliente_razonsocial_e = $('#cliente_razonsocial_e').val();
    var cliente_nombre_e = $('#cliente_nombre_e').val();
    var cliente_numero_e = $('#cliente_numero_e').val();
    var cliente_correo_e = $('#cliente_correo_e').val();
    var cliente_direccion_e = $('#cliente_direccion_e').val();
    var cliente_direccion_2_e = $('#cliente_direccion_2_e').val();
    var cliente_telefono_e = $('#cliente_telefono_e').val();
    //var cliente_fecha_e = $('#cliente_fecha_e').val();
    var cliente_estado_e = $('#cliente_estado_e').val();


    //Validamos si los campos a usar no se encuentran vacios
   // valor = validar_campo_vacio('id_cliente', id_cliente, valor);
    //valor = validar_campo_vacio('cliente_razonsocial_e', cliente_razonsocial_e, valor);
    //valor = validar_campo_vacio('cliente_nombre_e', cliente_nombre_e, valor);
    //valor = validar_campo_vacio('cliente_numero_e', cliente_numero_e, valor);
    //valor = validar_campo_vacio('cliente_correo_e', cliente_correo_e, valor);
    //valor = validar_campo_vacio('cliente_direccion_e', cliente_direccion_e, valor);
    //valor = validar_campo_vacio('cliente_telefono_e', cliente_telefono_e, valor);
    //valor = validar_campo_vacio('cliente_fecha_e', cliente_fecha_e, valor);
    //valor = validar_campo_vacio('cliente_estado_e', cliente_estado_e, valor);


    //valor = validar_campo_vacio('alumno_colegio_procedencia', alumno_colegio_procedencia, valor);


    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Cliente/guardar_edicion_cliente",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Cliente Editado! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al guardar Cliente, vuelva a intentarlo', 'error');
                        break;
                    case 5:
                        respuesta('El DNI ya se encuentra registrado', 'error');
                        $('#cliente_dni').css('border','solid red');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});

//Funcion para eliminar una mesa
function eliminar_cliente(id_cliente){
    var valor = true;
    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_parametro_vacio(id_cliente, valor);
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Definimos el mensaje y boton a afectar
        var boton = "btn-eliminar_cliente" + id_cliente;
        //Cadena donde enviaremos los parametros por POST
        var cadena = "id_cliente=" + id_cliente;
        $.ajax({
            type: "POST",
            url: urlweb + "api/cliente/eliminar_cliente",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, "Eliminando...", true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "Eliminar Cliente", false);
                switch (r.result.code) {
                    case 1:
                        $('#cliente' + id_cliente).remove();
                        respuesta('¡Cliente Eliminado!', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al eliminar cliente', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}





