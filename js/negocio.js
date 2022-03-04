$("#gestionarnegocio").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-negocio";
    //Extraemos las variable según los valores del campo consultado
    var negocio_nombre = $('#negocio_nombre').val();
    var id_ciudad = $('#id_ciudad').val();
    var negocio_direccion = $('#negocio_direccion').val();
    var negocio_ruc = $('#negocio_ruc').val();
    var negocio_foto = $('#negocio_foto').val();
    var negocio_telefono = $('#negocio_telefono').val();


    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_campo_vacio('negocio_nombre', negocio_nombre, valor);

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Negocio/guardar_negocio",
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
                        respuesta('¡Negocio guardado Exitosamente! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al guardar Negocio, vuelva a intentarlo', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});


function editar_negocio(id_negocio, id_ciudad, negocio_nombre, negocio_direccion, negocio_ruc, negocio_foto, negocio_telefono){
    $('#id_negocio').val(id_negocio);
    $('#id_ciudad_e').val(id_ciudad);
    $('#negocio_nombre_e').val(negocio_nombre);
    $('#negocio_direccion_e').val(negocio_direccion);
    $('#negocio_ruc_e').val(negocio_ruc);
    $('#negocio_foto_e').val(negocio_foto);
    $('#negocio_telefono_e').val(negocio_telefono);

}


$("#editar_negocio").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-negocio";
    //Extraemos las variable según los valores del campo consultado
    var negocio_nombre_e = $('#negocio_nombre').val();
    var id_ciudad_e = $('#id_ciudad_e').val();
    var id_negocio = $('#id_negocio').val();
    var negocio_direccion_e = $('#negocio_direccion_e').val();
    var negocio_ruc_e = $('#negocio_ruc_e').val();
    var negocio_foto_e = $('#negocio_foto_e').val();
    var negocio_telefono_e = $('#negocio_telefono_e').val();


    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_campo_vacio('id_negocio', id_negocio, valor);

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Negocio/editar_negocio",
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
                        respuesta('¡Negocio editado Exitosamente! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al editar Negocio, vuelva a intentarlo', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});


$("#usuarionegocio").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-usuario-negocio";
    //Extraemos las variable según los valores del campo consultado
    var id_negocio = $('#id_negocio').val();
    var id_usuario = $('#id_usuario').val();

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Negocio/guardar_usuario_negocio",
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


function habilitar(id_negocio, negocio_estado){

    var cadena = "id_negocio=" + id_negocio +
            "&negocio_estado=" + negocio_estado;

    $.ajax({
        type:"POST",
        url: urlweb + "api/Negocio/cambiar_estado_negocio",
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

function deshabilitar(id_negocio, negocio_estado){

    var cadena = "id_negocio=" + id_negocio +
        "&negocio_estado=" + negocio_estado;

    $.ajax({
        type:"POST",
        url: urlweb + "api/Negocio/cambiar_estado_negocio",
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



function habilitar_usuario_negocio(id_usuario_negocio, usuario_negocio_estado){

    var cadena = "id_usuario_negocio=" + id_usuario_negocio +
        "&usuario_negocio_estado=" + usuario_negocio_estado;

    $.ajax({
        type:"POST",
        url: urlweb + "api/Negocio/cambiar_estado_usuario_negocio",
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

function deshabilitar_usuario_negocio(id_usuario_negocio, usuario_negocio_estado){

    var cadena = "id_usuario_negocio=" + id_usuario_negocio +
        "&usuario_negocio_estado=" + usuario_negocio_estado;

    $.ajax({
        type:"POST",
        url: urlweb + "api/Negocio/cambiar_estado_usuario_negocio",
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