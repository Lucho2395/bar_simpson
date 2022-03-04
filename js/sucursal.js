$("#gestionarsucursal").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-sucursal";
    //Extraemos las variable según los valores del campo consultado
    var sucursal_nombre = $('#sucursal_nombre').val();
    var id_ciudad = $('#id_ciudad').val();
    var id_negocio = $('#id_negocio').val();
    var sucursal_direccion = $('#sucursal_direccion').val();
    var sucursal_ruc = $('#sucursal_ruc').val();
    var sucursal_foto = $('#sucursal_foto').val();
    var sucursal_telefono = $('#sucursal_telefono').val();


    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_campo_vacio('sucursal_nombre', sucursal_nombre, valor);

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Negocio/guardar_sucursal",
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
                        respuesta('¡Sucursal guardado Exitosamente! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al guardar Sucursal, vuelva a intentarlo', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});


function editar_sucursal(id_sucursal,id_ciudad, id_negocio, sucursal_nombre, sucursal_direccion, sucursal_ruc, sucursal_foto, sucursal_telefono){
    $('#id_sucursal').val(id_sucursal);
    $('#id_ciudad_e').val(id_ciudad);
    $('#id_negocio_e').val(id_negocio);
    $('#sucursal_nombre_e').val(sucursal_nombre);
    $('#sucursal_direccion_e').val(sucursal_direccion);
    $('#sucursal_ruc_e').val(sucursal_ruc);
    $('#sucursa_el_foto').val(sucursal_foto);
    $('#sucursal_telefono_e').val(sucursal_telefono);

}


$("#editarsucursal").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-sucursal";
    //Extraemos las variable según los valores del campo consultado
    var sucursal_nombre_e = $('#sucursal_nombre_e').val();
    var id_ciudad_e = $('#id_ciudad_e').val();
    var id_negocio_e = $('#id_negocio_e').val();
    var id_sucursal = $('#id_sucursal').val();
    var sucursal_direccion_e = $('#sucursal_direccion_e').val();
    var sucursal_ruc_e = $('#sucursal_ruc_e').val();
    var sucursal_foto_e = $('#sucursal_foto_e').val();
    var sucursal_telefono_e = $('#sucursal_telefono_e').val();


    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_campo_vacio('id_sucursal', id_sucursal, valor);

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Negocio/editar_sucursal",
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
                        respuesta('¡Sucursal guardado Exitosamente! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al guardar Sucursal, vuelva a intentarlo', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});



$("#usuariosucursal").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-usuario";
    //Extraemos las variable según los valores del campo consultado
    var id_sucursal = $('#id_sucursal').val();
    var id_usuario = $('#id_usuario').val();
    var id_rol = $('#id_rol').val();


    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Negocio/guardar_usuario_sucursal",
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
                        respuesta('¡Usuario asignado Exitosamente! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al asignar usuario , vuelva a intentarlo', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});


function habilitar(id_sucursal, sucursal_estado){

    var cadena = "id_sucursal=" + id_sucursal +
        "&sucursal_estado=" + sucursal_estado;

    $.ajax({
        type:"POST",
        url: urlweb + "api/Negocio/cambiar_estado_sucursal",
        data : cadena,
        dataType: 'json',
        success:function (r) {
            switch (r.result.code) {
                case 1:
                    respuesta('¡Estado cambiado Exitosamente! Recargando...', 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                    break;
                case 2:
                    respuesta('Error al cambiar estado, vuelva a intentarlo', 'error');
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    break;
            }
        }
    });
}

function deshabilitar(id_sucursal, sucursal_estado){

    var cadena = "id_sucursal=" + id_sucursal +
        "&sucursal_estado=" + sucursal_estado;

    $.ajax({
        type:"POST",
        url: urlweb + "api/Negocio/cambiar_estado_sucursal",
        data : cadena,
        dataType: 'json',
        success:function (r) {
            switch (r.result.code) {
                case 1:
                    respuesta('¡Estado cambiado Exitosamente! Recargando...', 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                    break;
                case 2:
                    respuesta('Error al cambiar estado, vuelva a intentarlo', 'error');
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    break;
            }
        }
    });
}



function habilitar_usuario_sucursal(id_usuario_sucursal, usuario_sucursal_estado){

    var cadena = "id_usuario_sucursal=" + id_usuario_sucursal +
        "&usuario_sucursal_estado=" + usuario_sucursal_estado;

    $.ajax({
        type:"POST",
        url: urlweb + "api/Negocio/cambiar_estado_usuariosucursal",
        data : cadena,
        dataType: 'json',
        success:function (r) {
            switch (r.result.code) {
                case 1:
                    respuesta('¡Estado cambiado Exitosamente! Recargando...', 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                    break;
                case 2:
                    respuesta('Error al cambiar estado, vuelva a intentarlo', 'error');
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    break;
            }
        }
    });
}

function deshabilitar_usuario_sucursal(id_usuario_sucursal, usuario_sucursal_estado){

    var cadena = "id_usuario_sucursal=" + id_usuario_sucursal +
        "&usuario_sucursal_estado=" + usuario_sucursal_estado;

    $.ajax({
        type:"POST",
        url: urlweb + "api/Negocio/cambiar_estado_usuariosucursal",
        data : cadena,
        dataType: 'json',
        success:function (r) {
            switch (r.result.code) {
                case 1:
                    respuesta('¡Estado cambiado Exitosamente! Recargando...', 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                    break;
                case 2:
                    respuesta('Error al cambiar estado, vuelva a intentarlo', 'error');
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    break;
            }
        }
    });
}