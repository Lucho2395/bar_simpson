

$("#gestionar_categoria").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-categoria";
    //Extraemos las variable según los valores del campo consultado
    var categoria_nombre = $('#categoria_nombre').val();

    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_campo_vacio('categoria_nombre', categoria_nombre, valor);

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Categorias/guardar_categoria",
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
                        respuesta('¡Categoria guardada Correctamente! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al guardar, Vuelva a Intentar', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});


function editar_categoria(id_categoria,categoria_nombre){
    $('#id_categoria').val(id_categoria);
    $('#categoria_nombre_e').val(categoria_nombre);
}


$("#editarcategoria").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-editar-categoria";
    //Extraemos las variable según los valores del campo consultado

    var id_categoria = $('#id_categoria').val();

    valor = validar_campo_vacio('id_categoria', id_categoria, valor);

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Categorias/editar_categoria",
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
                        respuesta('¡Editado con Exito, Recargando!', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al realizar la edicion', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});


function eliminar_categoria(id_categoria, categoria_estado){
    var valor = true;
    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_parametro_vacio(id_categoria, valor);
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Definimos el mensaje y boton a afectar
        var boton = "btn-eliminarcategoria" + id_categoria;
        //Cadena donde enviaremos los parametros por POST
        var cadena = "id_categoria=" + id_categoria +
            "&estado=" + categoria_estado;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Categorias/eliminar_categoria",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, "Espere...", true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "Espere...", false);
                switch (r.result.code) {
                    case 1:
                        $('#categoria' + id_categoria).remove();
                        respuesta('¡Estado Cambiado con Exito!', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al Eliminar', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}