$("#gestionarcategoria").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-categoria";
    //Extraemos las variable según los valores del campo consultado
    var id_negocio = $('#id_negocio').val();

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Recursos/guardar_categoria",
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
                        respuesta('¡Categoria Asignada Exitosamente! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al asignar categoria, vuelva a intentarlo', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});


$("#gestionar_recursos").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-categoria";
    //Extraemos las variable según los valores del campo consultado
    var id_sucursal = $('#id_sucursal').val();
    var id_recurso = $('#id_recurso').val();


    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Recursos/guardar_recursos",
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
                        respuesta('¡Recurso Asignado Exitosamente! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al asignar Recurso, vuelva a intentarlo', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});


function actualizar_recursos(){
    var id_categoria = $("#id_categoria").val();
    $.ajax({
        type: "POST",
        url: urlweb + "api/Recursos/listar_categoria_por_id",
        data: "id_categoria="+id_categoria,
        dataType: 'json',
        success:function (r) {
            $("#datos_recurso").html(r);
        }
    });
}


function jalar_categorias(){
    var id_sucursal = $("#id_sucursal").val();
    $.ajax({
        type: "POST",
        url: urlweb + "api/Recursos/jalar_categorias",
        data: "id_sucursal="+id_sucursal,
        dataType: 'json',
        success:function (r) {
            $("#datos_categoria").html(r);
        }
    });
}

function guardar(){
    var valor = true;
    var id_categoria = $('#id_categoria').val();
    var recurso_nombre = $('#recurso_nombre').val();
    var id_ne = $('#id_ne').val();
    var id_sucursal = $('#id_sucursal').val();
    var id_recurso = $('#id_recurso').val();
    var id_medida = $('#id_medida').val();
    var recurso_sede_factor_unidad = $('#recurso_sede_factor_unidad').val();
    var recurso_sede_cantidad = $('#recurso_sede_cantidad').val();
    var recurso_sede_precio_unit = $('#recurso_sede_precio_unit').val();
    var recurso_sede_peso_inicial = $('#recurso_sede_peso_inicial').val();
    var recurso_sede_peso_final = $('#recurso_sede_peso_final').val();
    var recurso_sede_precio_total = $('#recurso_sede_precio_total').val();
    var recurso_sede_merma = $('#recurso_sede_merma').val();
    var recurso_sede_precio = $('#recurso_sede_precio').val();
    var recurso_sede_stock = $('#recurso_sede_stock').val();
    var recurso_sede_stock_minimo = $('#recurso_sede_stock_minimo').val();
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    valor = validar_campo_vacio('recurso_sede_stock', recurso_sede_stock, valor);
    if(valor){
        var cadena = "id_sucursal=" + id_sucursal +
        "&id_ne=" + id_ne +
        "&recurso_nombre=" + recurso_nombre +
        "&id_categoria=" + id_categoria +
        "&id_recurso=" + id_recurso +
        "&id_medida=" + id_medida +
        "&recurso_sede_factor_unidad=" + recurso_sede_factor_unidad +
        "&recurso_sede_cantidad=" + recurso_sede_cantidad +
        "&recurso_sede_precio_unit=" + recurso_sede_precio_unit +
        "&recurso_sede_peso_inicial=" + recurso_sede_peso_inicial +
        "&recurso_sede_peso_final=" + recurso_sede_peso_final +
        "&recurso_sede_precio_total=" + recurso_sede_precio_total +
        "&recurso_sede_merma=" + recurso_sede_merma +
        "&recurso_sede_precio=" + recurso_sede_precio +
        "&recurso_sede_stock=" + recurso_sede_stock +
        "&recurso_sede_stock_minimo=" + recurso_sede_stock_minimo;
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Recursos/guardar_recursos",
            data: cadena,
            dataType: 'json',
            success:function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Recurso guardado Exitosamente! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al guardar recurso, vuelva a intentarlo', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}

function habilitar(id_recurso_sede, recurso_sede_estado){

    var cadena = "id_recurso_sede=" + id_recurso_sede +
        "&recurso_sede_estado=" + recurso_sede_estado;

    $.ajax({
        type:"POST",
        url: urlweb + "api/Recursos/cambiar_estado_recurso",
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

function deshabilitar(id_recurso_sede, recurso_sede_estado){

    var cadena = "id_recurso_sede=" + id_recurso_sede +
        "&recurso_sede_estado=" + recurso_sede_estado;

    $.ajax({
        type:"POST",
        url: urlweb + "api/Recursos/cambiar_estado_recurso",
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

function habilitar_categoria(id_categoria_negocio, recurso_categoria_estado){

    var cadena = "id_categoria_negocio=" + id_categoria_negocio +
        "&recurso_categoria_estado=" + recurso_categoria_estado;

    $.ajax({
        type:"POST",
        url: urlweb + "api/Recursos/cambiar_estado_categoria",
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

function deshabilitar_categoria(id_categoria_negocio, recurso_categoria_estado){

    var cadena = "id_categoria_negocio=" + id_categoria_negocio +
        "&recurso_categoria_estado=" + recurso_categoria_estado;

    $.ajax({
        type:"POST",
        url: urlweb + "api/Recursos/cambiar_estado_categoria",
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


function editar_stock_minimo(id_recurso_sede,recurso_sede_stock_minimo){
    $('#id_recurso_sede').val(id_recurso_sede);
    $('#recurso_sede_stock_minimo_e').val(recurso_sede_stock_minimo);
}


function guardar_stock_minimo_actializado(){
    var valor = true;

    var id_recurso_sede = $('#id_recurso_sede').val();
    var recurso_sede_stock_minimo_e = $('#recurso_sede_stock_minimo_e').val();
    if(valor){
        var cadena = "id_recurso_sede=" + id_recurso_sede +
            "&recurso_sede_stock_minimo_e=" + recurso_sede_stock_minimo_e;
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Recursos/editar_stock_minimo",
            data: cadena,
            dataType: 'json',
            success:function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Editado Exitosamente! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al editar, vuelva a intentarlo', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}