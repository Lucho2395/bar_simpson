$("#agregar").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = "btn-agregar-producto";

    var producto_nombre = $('#producto_nombre').val();
    var producto_descripcion = $('#producto_descripcion').val();
    var id_receta = $('#id_receta').val();
    var id_grupo = $('#id_grupo').val();
    var id_producto_familia = $('#id_producto_familia').val();
    var producto_foto = $('#producto_foto').val();
    var producto_precio_venta = $('#producto_precio_venta').val();
    var id_medida = $('#id_medida').val();
    var tipo_afectacion = $('#tipo_afectacion').val();

    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_campo_vacio('producto_nombre', producto_nombre, valor);
    valor = validar_campo_vacio('producto_precio_venta', producto_precio_venta, valor);

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Producto/guardar_producto",
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
                        respuesta('¡Producto Registrado! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al guardar Producto, vuelva a intentarlo', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});


function editar_producto(id_producto, id_receta,id_grupo,id_producto_familia, producto_nombre, id_medida, producto_precio_codigoafectacion, producto_descripcion, producto_precio_venta, producto_foto){

    $.ajax({
        type: "POST",
        url: urlweb + "api/Producto/listar_precios",
        data: "id_producto="+id_producto,
        dataType: 'json',
        success:function (r) {
            $("#tabla").html(r);
            $('#id_producto').val(id_producto);
            $('#id_receta_e').val(id_receta);
            $('#id_grupo_e').val(id_grupo);
            $('#id_producto_familia_e').val(id_producto_familia);
            $("#id_receta_e option[value='"+id_receta+"']").attr("selected", true);
            $("#id_medida_e option[value='"+id_medida+"']").attr("selected", true);
            $("#tipo_afectacion_e option[value='"+producto_precio_codigoafectacion+"']").attr("selected", true);
            $('#producto_nombre_e').val(producto_nombre);
            $('#producto_descripcion_e').val(producto_descripcion);
            //$('#producto_precio_venta_e').val(producto_precio_venta);
            $('#fotito_actual').attr("src",urlweb+producto_foto);
        }
    });
}

function agregar_precios(){
    var valor = true;
    var id_producto = $('#id_producto').val();
    var id_medida_e = $('#id_medida_e').val();
    var tipo_afectacion_e = $('#tipo_afectacion_e').val();
    var producto_precio_venta_a = $('#producto_precio_venta_a').val();
    if(valor) {
        var cadena = "producto_precio_venta_a=" + producto_precio_venta_a + "&id_producto=" + id_producto + "&id_medida_e=" + id_medida_e +"&tipo_afectacion_e=" + tipo_afectacion_e;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Producto/agregar_nuevo_precio",
            data: cadena,
            dataType: 'json',
            success: function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Precio Agregado!', 'success');
                        break;
                    case 2:
                        respuesta('Error al eliminar mascota', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}

$("#editar").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = "btn-editar_producto";

    var producto_nombre_e = $('#producto_nombre_e').val();
    var producto_descripcion_e = $('#producto_descripcion_e').val();
    var id_receta_e = $('#id_receta_e').val();
    var id_producto = $('#id_producto').val();
    var producto_foto_e = $('#producto_foto_e').val();


    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Producto/editar_producto",
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
                        respuesta('¡Producto Editado! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 600);
                        break;
                    case 2:
                        respuesta('Error al editar Producto, vuelva a intentarlo', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});



function habilitar(id_producto, producto_estado){

    var cadena = "id_producto=" + id_producto +
        "&producto_estado=" + producto_estado;

    $.ajax({
        type:"POST",
        url: urlweb + "api/Producto/cambiar_estado_producto",
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

function deshabilitar(id_producto, producto_estado){

    var cadena = "id_producto=" + id_producto +
        "&producto_estado=" + producto_estado;

    $.ajax({
        type:"POST",
        url: urlweb + "api/Producto/cambiar_estado_producto",
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

function guardar_familia(){
    var valor = true;
    //Extraemos las variable según los valores del campo consultado
    var producto_familia_nombre = $('#producto_familia_nombre').val();

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        var cadena = "producto_familia_nombre=" + producto_familia_nombre;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Producto/guardar_familia",
            data: cadena,
            dataType: 'json',
            success:function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Familia Agregada Correctamente...!', 'success');
                        setTimeout(function () {
                            location.reload()
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al agregar, comuniquese con BufeoTec Company', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}

function eliminar_familia(id_producto_familia){
    var valor = true;
    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_parametro_vacio(id_producto_familia, valor);
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        var cadena = "id_producto_familia=" + id_producto_familia;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Producto/eliminar_familia",
            data: cadena,
            dataType: 'json',
            success:function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Registro Eliminado Exitosamente...!', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al eliminar, comuniquese con BufeoTec Company', 'error');
                        break;
                    case 3:
                        respuesta('No se puede eliminar porque existen productos vinculados a esta familia', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}
function sumar_stock(){
    var valor = true;
    var id_receta_modal = $('#id_receta_modal').val();
    var asignar_stock = $('#asignar_stock').val();
    var boton = 'btn_stock';
    if(valor) {
        var cadena = "id_receta_modal=" + id_receta_modal +
            "&asignar_stock=" + asignar_stock;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Producto/sumar_stock_nuevo",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Agregando...', true);
            },
            success: function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Stock Agregado correctamente!', 'success');
                        setTimeout(function () {
                            location.href = urlweb +  'Producto/gestionar';
                        }, 500);
                        break;
                    case 2:
                        cambiar_estado_boton(boton, 'Agregar', false);
                        respuesta('Error al agregar, comuniquese con BufeoTec', 'error');
                        break;
                    default:
                        cambiar_estado_boton(boton, 'Agregar', false);
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}