//Se usa para agregar un nuevo menú al sistema
    $("#gestionarInfoMesa").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-mesa";
    //Extraemos las variable según los valores del campo consultado
    var mesa_nombre = $('#mesa_nombre').val();
    var mesa_capacidad = $('#mesa_capacidad').val();

    var id_sucursal = $('#id_sucursal').val();

    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_campo_vacio('mesa_nombre', mesa_nombre, valor);
    valor = validar_campo_vacio('mesa_capacidad', mesa_capacidad, valor);
    valor = validar_campo_vacio('id_sucursal', id_sucursal, valor);

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Mesa/guardar_nuevo_mesa",
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
                        respuesta('¡Mesa guardada! Recargando...', 'success');
                        $('#mesa_nombre').css('border','');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al guardar mesa', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});


//Se usa para agregar los campos a editar el mesa
function editar_mesa(id_mesa,id_negocio, id_sucursal, mesa_nombre, mesa_capacidad) {
    $('#id_mesa').val(id_mesa);
    $('#id_negocio_e').val(id_negocio);
    $('#id_sucursal_e').val(id_sucursal);
    $('#mesa_nombre_e').val(mesa_nombre);
    $('#mesa_capacidad_e').val(mesa_capacidad);

}


//Se usa para editar la informacion del mesa
$("#editarInformacionMesa").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-editar-mesa";
    //Extraemos las variable según los valores del campo consultado

    var id_mesa = $('#id_mesa').val();
    var mesa_nombre_e = $('#mesa_nombre_e').val();
    var mesa_capacidad_e = $('#mesa_capacidad_e').val();
    var id_sucursal_e = $('#id_sucursal_e').val();


    valor = validar_campo_vacio('id_mesa', id_mesa, valor);

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Mesa/guardar_edicion_mesa",
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
                        $('#mesa_nombre_e').css('border','');
                        $('#mesanombre' + id_mesa).html(r.result.mesa.mesa_nombre);
                        $('#sucursalnombre' + id_mesa).html("<strong>" + r.result.mesa.sucursal_nombre + "</strong>");
                        //$('#usuarioemail' + id_usuario).html(r.result.usuario.usuario_email);
                        colocar_estado_texto(r.result.mesa.mesa_estado, 'mesaestado' + id_mesa, 'HABILITADO', 'DESHABILITADO')
                        $('#botonmesa' + id_mesa).html("<button data-toggle=\"modal\" data-target=\"#editarDatosMesa\" class=\"btn btn-xs btn-info btne\" onclick=\"editar_mesa(" + r.result.mesa.id_mesa + ", " + r.result.mesa.id_sucursal + ", '" +r.result.mesa.mesa_nombre +"', '" + r.result.mesa.mesa_capacidad + "', " + r.result.mesa.mesa_estado + ")\" >Editar Mesa</button>");
                        //$('#botoncontra' + id_usuario).html("<button data-toggle=\"modal\" data-target=\"#restablecerContra\" class=\"btn btn-xs btn-secondary btne\" onclick=\"nueva_contra(" + r.result.usuario.id_usuario + ", '" +r.result.usuario.usuario_nickname +"')\" >Resetear Contraseña</button>");
                        respuesta('¡Mesa Guardada!', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al editar mesa', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});

    //Limpia el formulario de registro de mesa
function agregacion_mesa(){
    $('#id_mesa').val("");
    $('#id_sucursal').val(3);
    $('#mesa_nombre').val("");
    $('#mesa_capacidad').val("");
    $("#mesa_estado").val(1);
    $("#mesa_estado").css('color','white');
    $("#mesa_estado").css('background','#17a673');
}

//Funcion para eliminar una mesa
function eliminar_mesa(id_mesa){
    var valor = true;
    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_parametro_vacio(id_mesa, valor);
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Definimos el mensaje y boton a afectar
        var boton = "btn-eliminarmesa" + id_mesa;
        //Cadena donde enviaremos los parametros por POST
        var cadena = "id_mesa=" + id_mesa;
        $.ajax({
            type: "POST",
            url: urlweb + "api/mesa/eliminar_mesa",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, "Eliminando...", true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "Eliminar mesa", false);
                switch (r.result.code) {
                    case 1:
                        $('#mesa' + id_mesa).remove();
                        respuesta('¡mesa Eliminado!', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al eliminar mesa', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}

function actualizar_mesa(){
    var id_negocio = $("#id_negocio").val();
    $.ajax({
        type: "POST",
        url: urlweb + "api/Mesa/listar_negocio_por_id",
        data: "id_negocio="+id_negocio,
        dataType: 'json',
        success:function (r) {
            $("#datos_mesa").html(r);
        }

    });
}



function actualizar_mesa_editar(){
    var id_negocio = $("#id_negocio_e").val();
    $.ajax({
        type: "POST",
        url: urlweb + "api/Mesa/listar_negocio_por_id_editar",
        data: "id_negocio_e="+id_negocio,
        dataType: 'json',
        success:function (r) {
            $("#datos_mesa_editar").html(r);
        }

    });
}


