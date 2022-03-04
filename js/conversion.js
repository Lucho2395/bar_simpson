
function jalar_recursos(){
    var id_recurso_sede = $("#id_recurso_sede").val();
    $.ajax({
        type: "POST",
        url: urlweb + "api/Conversiones/jalar_recursos",
        data: "id_recurso_sede="+id_recurso_sede,
        dataType: 'json',
        success:function (r){
            $("#datos_recurso").html(r.datos_recursos);
            $("#datos_precio").html(r.datos_precio);
        }
    });
}


function guardar_nueva_conversion(){
    var valor = true;
    var id_recurso_sede = $('#id_recurso_sede').val();
    var conversion_unidad_medida = $('#conversion_unidad_medida').val();
    var conversion_cantidad = $('#conversion_cantidad').val();

    if(valor){
        var cadena = "id_recurso_sede=" + id_recurso_sede +
            "&conversion_unidad_medida=" + conversion_unidad_medida +
            "&conversion_cantidad=" + conversion_cantidad;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Conversiones/guardar_nueva_conversion",
            data: cadena,
            dataType: 'json',
            success:function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Conversion guardada Exitosamente! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al guardar conversion, vuelva a intentarlo', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}


function eliminar_conversion(id_conversion){
    var valor = true;
    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_parametro_vacio(id_conversion, valor);
    if(valor) {
        var cadena = "id_conversion=" + id_conversion;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Conversiones/eliminar_conversion",
            data: cadena,
            dataType: 'json',
            success: function (r) {
                switch (r.result.code) {
                    case 1:
                        $('#conversion' + id_conversion).remove();
                        respuesta('¡Conversion Eliminada, Recargando!', 'success');
                        location.reload();
                        break;
                    case 2:
                        respuesta('Error al eliminar conversion', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}
