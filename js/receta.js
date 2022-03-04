//Se usa para agregar un nuevo menú al sistema
$("#gestionarInfoReceta").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-receta";
    //Extraemos las variable según los valores del campo consultado
    var receta_nombre = $('#receta_nombre').val();
    //var receta_fecha = $('#receta_fecha').val();

    var receta_estado = $('#receta_estado').val();

    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_campo_vacio('receta_nombre', receta_nombre, valor);
    //valor = validar_campo_vacio('receta_fecha', receta_fecha, valor);
    valor = validar_campo_vacio('receta_estado', receta_estado, valor);

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/receta/guardar_nuevo_receta",
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
                        respuesta('¡Receta guardada! Recargando...', 'success');
                        $('#receta_nombre').css('border','');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al guardar receta', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});

//Se usa para agregar los campos a editar el receta
function editar_receta(id_receta, id_usuario, receta_nombre, receta_estado) {
    $('#id_receta').val(id_receta);
    //$('#id_usuario_e').val(id_usuario);
    $('#receta_nombre_e').val(receta_nombre);
    //$('#receta_fecha_e').val(receta_fecha);
    $("#receta_estado_e").val(receta_estado);
}

//Se usa para editar la informacion del Receta
$("#editarInformacionReceta").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-editar-receta";
    //Extraemos las variable según los valores del campo consultado

    var id_receta = $('#id_receta').val();
    var receta_nombre_e = $('#receta_nombre_e').val();

    valor = validar_campo_vacio('id_receta', id_receta, valor);
    valor = validar_campo_vacio('receta_nombre_e', receta_nombre_e, valor);
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/receta/guardar_edicion_receta",
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
                        respuesta('¡Receta Editada Correctamente...Recargando!', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al editar Receta', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});

//Limpia el formulario de registro de receta
function agregacion_receta(){
    $('#id_receta').val("");
    $('#id_usuario').val(3);
    $('#receta_nombre').val("");
    //$('#receta_fecha').val("");
    $("#receta_estado").val(1);
    $("#receta_estado").css('color','white');
    $("#receta_estado").css('background','#17a673');
}

//Funcion para eliminar una receta
function eliminar_receta(id_receta){
    var valor = true;
    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_parametro_vacio(id_receta, valor);
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Definimos el mensaje y boton a afectar
        var boton = "btn-eliminarreceta" + id_receta;
        //Cadena donde enviaremos los parametros por POST
        var cadena = "id_receta=" + id_receta;
        $.ajax({
            type: "POST",
            url: urlweb + "api/receta/eliminar_receta",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, "Eliminando...", true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "Eliminar Receta", false);
                switch (r.result.code) {
                    case 1:
                        $('#receta' + id_receta).remove();
                        respuesta('¡Receta Eliminada correctamente...Recargando!', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al eliminar la Receta', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}


//Se usa para agregar un nuevo menú al sistema
$("#gestionarInfoDetalle_receta").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-detalle_receta";
    //Extraemos las variable según los valores del campo consultado
    var id_receta = $('#id_receta').val();
    var id_recursos_sede = $('#id_recursos_sede').val();
    var detalle_receta_cantidad = $('#detalle_receta_cantidad').val();
    var detalle_receta_precio = $('#detalle_receta_precio').val();
    var valor_conversion = $('#valor_conversion').val();
    //Validamos si los campos a usar no se encuentran vacios
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Receta/guardar_nuevo_detalle_receta",
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
                        respuesta('¡Detalle Receta guardada! Recargando...', 'success');
                        $('#detalle_receta_cantida').css('border','');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al guardar detalle receta', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});

//Se usa para agregar los campos a editar el detalle_receta
function editar_detalle_receta(id_detalle_receta, id_receta ,id_recursos_sede, detalle_receta_cantidad, detalle_receta_precio, detalle_receta_estado) {
    var recursos_sede = id_recursos_sede;
    $.ajax({
        type: "POST",
        url: urlweb + "api/Receta/listar_unidad_precio",
        data: "id_recurso_sede="+id_recursos_sede,
        dataType: 'json',
        success:function (r) {
            $("#mostrar_datos_e").html(r);
            $('#id_detalle_receta').val(id_detalle_receta);
            $('#id_receta_e').val(id_receta);
            $('#id_recursos_sede_e').val(recursos_sede);
            $('#detalle_receta_cantidad_e').val(detalle_receta_cantidad);
            $('#detalle_receta_precio_e').val(detalle_receta_precio);
            $("#detalle_receta_estado_e").val(detalle_receta_estado);
            jalar_medida_precio_e();
        }
    });


}
//Se usa para editar la informacion del Detalle_receta
$("#editarInformacionDetalle_receta").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-editar-detalle_receta";
    //Extraemos las variable según los valores del campo consultado

    var id_detalle_receta = $('#id_detalle_receta').val();
    var detalle_receta_cantidad_e = $('#detalle_receta_cantidad_e').val();
    var detalle_receta_unidad_e = $('#detalle_receta_unidad_e').val();
    var id_receta_e = $('#id_receta_e').val();
    var id_recursos_sede_e = $('#id_recursos_sede_e').val();
    var detalle_receta_estado_e = $('#detalle_receta_estado_e').val();


    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Receta/guardar_edicion_detalle_receta",
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
                        respuesta('¡Detalle Receta Guardada!', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al editar Detalle Receta', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});

//Limpia el formulario de registro de detalle_receta
function agregacion_detalle_receta(){
    $('#id_detalle_receta').val("");
    $('#id_recursos_sede').val("");
    $('#detalle_receta_cantidad').val("");
    $('#detalle_receta_unidad').val("");
    $("#detalle_receta_estado").val(1);
    $("#detalle_receta_estado").css('color','white');
    $("#detalle_receta_estado").css('background','#17a673');
}

//Funcion para eliminar una detalle_receta
function eliminar_detalle_receta(id_detalle_receta){
    var valor = true;
    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_parametro_vacio(id_detalle_receta, valor);
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Definimos el mensaje y boton a afectar
        var boton = "btn-eliminardetalle_receta" + id_detalle_receta;
        //Cadena donde enviaremos los parametros por POST
        var cadena = "id_detalle_receta=" + id_detalle_receta;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Receta/eliminar_detalle_receta",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, "Eliminando...", true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "Eliminar...", false);
                switch (r.result.code) {
                    case 1:
                        $('#detalle_receta' + id_detalle_receta).remove();
                        respuesta('¡Detalle Receta Eliminado!', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al eliminar Receta', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}

//FUNCION PARA ELIMINAR SUB RECETA
function eliminar_sub_receta(id_sub_receta){
    var valor = true;
    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_parametro_vacio(id_sub_receta, valor);
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Definimos el mensaje y boton a afectar
        var boton = "btn-eliminarsub_receta" + id_sub_receta;
        //Cadena donde enviaremos los parametros por POST
        var cadena = "id_sub_receta=" + id_sub_receta;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Receta/eliminar_sub_receta",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, "Eliminando...", true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "Eliminando...", false);
                switch (r.result.code) {
                    case 1:
                        $('#sub_receta' + id_sub_receta).remove();
                        respuesta('¡Sub Receta Eliminada con Exito!', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al eliminar Sub receta', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}


//FUNCION PARA JALAR UNIDAD DE MEDIDA Y PRECIO
function jalar_medida_precio(){

    var id_recurso_sede = $("#id_recursos_sede").val();
    $.ajax({
        type: "POST",
        url: urlweb + "api/Receta/listar_unidad_precio",
        data: "id_recurso_sede="+id_recurso_sede,
        dataType: 'json',
        success:function (r) {
            $("#mostrar_datos").html(r.mostrar_datos);
            $("#conversion").html(r.conversion);
        }
    });
}
function jalar_medida_precio_e(){

    var id_recurso_sede = $("#id_recursos_sede_e").val();
    $.ajax({
        type: "POST",
        url: urlweb + "api/Receta/listar_unidad_precio",
        data: "id_recurso_sede="+id_recurso_sede,
        dataType: 'json',
        success:function (r) {
            $("#mostrar_datos_e").html(r.mostrar_datos);
            $("#conversion_e").html(r.conversion);
        }
    });
}

function jalar_valor_preparacion(){

    var id_receta = $("#id_receta_").val();
    $.ajax({
        type: "POST",
        url: urlweb + "api/Receta/jalar_valor_preparacion",
        data: "id_receta="+id_receta,
        dataType: 'json',
        success:function (r) {
            $("#valor_preparacion").html(r);
        }
    });
}

function calcular_valor_preparacion(){

    var id_receta_ = $("#id_receta_").val();
    var sub_receta_cantidad = $("#sub_receta_cantidad").val() * 1;
    var precio = $("#idr_"+id_receta_).val() * 1;

    var cantidad_total = sub_receta_cantidad * precio;
    var cantidad_total_ = redondear(cantidad_total,2,false);

    $("#sub_receta_total").val(cantidad_total_);

}

function calcular_nuevo_precio(){
    var cantidad = 1;
    var id_rec_sede = $("#id_recursos_sede").val();
    var precio = $("#irs_"+id_rec_sede).val();

    var nueva_cantidad = $("#detalle_receta_cantidad").val() * 1;

    if($('#conversion_check').is(':checked')){
        var jaja = $("#detalle_receta_unidad_medida").val().split('-*-*');
        var conversion_cantidad = jaja[0] * 1;
        var nuevo_valor = nueva_cantidad / conversion_cantidad;
        var nuevo_precio = precio * nuevo_valor;
        var nuevo_precio_con = redondear(nuevo_precio,2,false);

        $("#detalle_receta_precio").val(nuevo_precio_con);
        $("#valor_conversion").val(jaja[1]);

    }else{
        var nuevo_precio_ = precio * nueva_cantidad;
        var nuevo_precio_o= redondear(nuevo_precio_,2,false);

        $("#detalle_receta_precio").val(nuevo_precio_o);
    }
}


function calcular_nuevo_precio_editar(){
    var cantidad = 1;
    var id_rec_sede = $("#id_recursos_sede_e").val();
    var nueva_cantidad_e = $("#detalle_receta_cantidad_e").val() *1;
    var precio = $("#irs_"+id_rec_sede).val();
    /*console.log(precio);
    console.log(nueva_cantidad_e);*/
    //var nuevo_precio_ = precio * nueva_cantidad_e;
    //var nuevo_precio= redondear(nuevo_precio_,2,false);
    //$("#detalle_receta_precio_e").val(nuevo_precio);
    if($('#conversion_check_e').is(':checked')){
        var jaja = $("#detalle_receta_unidad_medida").val().split('-*-*');
        var conversion_cantidad = jaja[0] * 1;
        var nuevo_valor = nueva_cantidad_e / conversion_cantidad;
        var nuevo_precio_ = precio * nuevo_valor;
        var nuevo_precio = redondear(nuevo_precio_,2,false);

        $("#detalle_receta_precio_e").val(nuevo_precio);
        $("#valor_conversion").val(jaja[1]);

    }else{
        var nuevo_precio__ = precio * nueva_cantidad_e;
        var nuevo_precio_o= redondear(nuevo_precio__,2,false);

        $("#detalle_receta_precio_e").val(nuevo_precio_o);
    }
}

$("#agregar_sub_receta").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-receta";
    //Extraemos las variable según los valores del campo consultado
    var receta_principal = $('#receta_principal').val();
    var id_receta_ = $('#id_receta_').val();
    var sub_receta_cantidad = $('#sub_receta_cantidad').val();
    var sub_receta_total = $('#sub_receta_total').val();

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Receta/guardar_sub_receta",
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
                        respuesta('¡Sub receta guardada! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al guardar Sub receta', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});