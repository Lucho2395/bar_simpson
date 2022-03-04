
function guardar_insumo(){
    var valor = true;

    var id_categoria = $('#id_categoria').val();
    var recurso_nombre = $('#recurso_nombre').val();

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        var cadena = "id_categoria=" + id_categoria +
            "&recurso_nombre=" + recurso_nombre;
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Insumos/guardar_insumos",
            data: cadena,
            dataType: 'json',
            success:function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Insumo guardado Correctamente! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al guardar insumo, vuelva a intentarlo', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}

function editar_insumo(id_recurso,id_categoria,recurso_nombre){
    $('#id_recurso').val(id_recurso);
    $('#id_categoria_e').val(id_categoria);
    $('#recurso_nombre_e').val(recurso_nombre);
}

function editar_insumos(){
    var valor = true;

    var id_recurso = $('#id_recurso').val();
    var id_categoria_e = $('#id_categoria_e').val();
    var recurso_nombre_e = $('#recurso_nombre_e').val();

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        var cadena = "id_recurso=" + id_recurso +
            "&id_categoria_e=" + id_categoria_e +
            "&recurso_nombre_e=" + recurso_nombre_e;
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Insumos/editar_insumos",
            data: cadena,
            dataType: 'json',
            success:function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Insumo guardado Correctamente! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al guardar insumo, vuelva a intentarlo', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}