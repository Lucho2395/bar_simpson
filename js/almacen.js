//Se usa para agregar un nuevo menú al sistema
$("#gestionarInfoAlmacen").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-almacen";
    //Extraemos las variable según los valores del campo consultado
    var almacen_nombre = $('#almacen_nombre').val();
    var almacen_capacidad = $('#almacen_capacidad').val();

    var id_negocio = $('#id_negocio').val();
    var id_sucursal = $('#id_sucursal').val();
    var almacen_estado = $('#almacen_estado').val();

    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_campo_vacio('almacen_nombre', almacen_nombre, valor);
    valor = validar_campo_vacio('almacen_capacidad', almacen_capacidad, valor);
    valor = validar_campo_vacio('id_negocio', id_negocio, valor);
    valor = validar_campo_vacio('id_sucursal', id_sucursal, valor);
    valor = validar_campo_vacio('almacen_estado', almacen_estado, valor);

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/almacen/guardar_nuevo_almacen",
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
                        respuesta('¡Almacen guardada! Recargando...', 'success');
                        $('#almacen_nombre').css('border','');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al guardar almacen', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});
//Se usa para agregar los campos a editar el almacen
function editar_almacen(id_almacen, id_negocio ,id_sucursal, almacen_nombre, almacen_capacidad, almacen_estado) {
    $('#id_almacen').val(id_almacen);
    $('#id_negocio_e').val(id_negocio);
    $('#id_sucursal_e').val(id_sucursal);
    $('#almacen_nombre_e').val(almacen_nombre);
    $('#almacen_capacidad_e').val(almacen_capacidad);
    $("#almacen_estado_e").val(almacen_estado);
}
//Se usa para editar la informacion del Almacen
$("#editarInformacionAlmacen").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-editar-almacen";
    //Extraemos las variable según los valores del campo consultado

    var id_almacen = $('#id_almacen').val();
    var almacen_nombre_e = $('#almacen_nombre_e').val();
    var almacen_capacidad_e = $('#almacen_capacidad_e').val();
    var id_negocio_e = $('#id_negocio_e').val();
    var id_sucursal_e = $('#id_sucursal_e').val();
    var almacen_estado_e = $('#almacen_estado_e').val();


    valor = validar_campo_vacio('id_almacen', id_almacen, valor);
    valor = validar_campo_vacio('almacen_nombre_e', almacen_nombre_e, valor);
    valor = validar_campo_vacio('almacen_capacidad_e', almacen_capacidad_e, valor);
    valor = validar_campo_vacio('id_negocio_e', id_negocio_e, valor);
    valor = validar_campo_vacio('id_sucursal_e', id_sucursal_e, valor);
    valor = validar_campo_vacio('almacen_estado_e', almacen_estado_e, valor);
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/almacen/guardar_edicion_almacen",
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
                        $('#almacen_nombre_e').css('border','');
                        $('#almacennombre' + id_almacen).html(r.result.almacen.almacen_nombre);
                        $('#sucursalnombre' + id_almacen).html("<strong>" + r.result.almacen.sucursal_nombre + "</strong>");
                        //$('#usuarioemail' + id_usuario).html(r.result.usuario.usuario_email);
                        colocar_estado_texto(r.result.almacen.almacen_estado, 'almacenestado' + id_almacen, 'HABILITADO', 'DESHABILITADO')
                        $('#botonalmacen' + id_almacen).html("<button data-toggle=\"modal\" data-target=\"#editarDatosAlmacen\" class=\"btn btn-xs btn-info btne\" onclick=\"editar_almacen(" + r.result.almacen.id_almacen + ", " + r.result.almacen.id_negocio + ", " + r.result.almacen.id_sucursal + ", '" +r.result.almacen.almacen_nombre+"', '" + r.result.almacen.almacen_capacidad + "', " + r.result.almacen.almacen_estado + ")\" >Editar Almacen</button>");
                        //$('#botoncontra' + id_usuario).html("<button data-toggle=\"modal\" data-target=\"#restablecerContra\" class=\"btn btn-xs btn-secondary btne\" onclick=\"nueva_contra(" + r.result.usuario.id_usuario + ", '" +r.result.usuario.usuario_nickname +"')\" >Resetear Contraseña</button>");
                        respuesta('¡Almacen Guardada!', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al editar Almacen', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});
//Limpia el formulario de registro de almacen
function agregacion_almacen(){
    $('#id_almacen').val("");
    $('#almacen_nombre').val("");
    $('#almacen_capacidad').val("");
    $("#almacen_estado").val(1);
    $("#almacen_estado").css('color','white');
    $("#almacen_estado").css('background','#17a673');
}
//Funcion para eliminar una almacen
function eliminar_almacen(id_almacen){
    var valor = true;
    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_parametro_vacio(id_almacen, valor);
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Definimos el mensaje y boton a afectar
        var boton = "btn-eliminaralmacen" + id_almacen;
        //Cadena donde enviaremos los parametros por POST
        var cadena = "id_almacen=" + id_almacen;
        $.ajax({
            type: "POST",
            url: urlweb + "api/almacen/eliminar_almacen",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, "Eliminando...", true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "Eliminar almacen", false);
                switch (r.result.code) {
                    case 1:
                        $('#almacen' + id_almacen).remove();
                        respuesta('¡Almacen Eliminado!', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al eliminar Almacen', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}
function actualizar_almacen(){
    var id_negocio = $("#id_negocio").val();
    $.ajax({
        type: "POST",
        url: urlweb + "api/Almacen/listar_negocio_por_id",
        data: "id_negocio="+id_negocio,
        dataType: 'json',
        success:function (r) {
            $("#datos_almacen").html(r);
        }

    });
}


//FUNCIONES NUEVAS PARA SALIDA DE ALMACEN

function salida(){
    var valor = true;
    var id_recurso_modal = $('#id_recurso_modal').val();
    var id_negocio_modal = $('#id_negocio_modal').val();
    var cantidad_salida = $('#cantidad_salida').val();
    if(valor) {
        var cadena = "id_recurso_modal=" + id_recurso_modal +
            "&id_negocio_modal=" + id_negocio_modal +
            "&cantidad_salida=" + cantidad_salida;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Almacen/guardar_salida",
            data: cadena,
            dataType: 'json',
            success: function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Realizado correctamente!', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 500);
                        break;
                    case 2:
                        respuesta('Error codigo 2, comuniquese con BufeoTec', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}