//Se usa para agregar un nuevo menú al sistema
$("#gestionarInfoProveedor").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-proveedor";
    //Extraemos las variable según los valores del campo consultado
    var id_negocio = $('#id_negocio').val();
    var proveedor_nombre = $('#proveedor_nombre').val();
    var proveedor_ruc = $('#proveedor_ruc').val();
    var proveedor_direccion = $('#proveedor_direccion').val();
    var proveedor_numero = $('#proveedor_numero').val();

    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_campo_vacio('proveedor_nombre', proveedor_nombre, valor);
    valor = validar_campo_vacio('proveedor_ruc', proveedor_ruc, valor);
    valor = validar_campo_vacio('proveedor_direccion', proveedor_direccion, valor);
    valor = validar_campo_vacio('proveedor_numero', proveedor_numero, valor);
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/proveedor/guardar_nuevo_proveedor",
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
                        respuesta('¡Proveedor guardado Exitosamente! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al guardar proveedor', 'error');
                        break;
                    case 3:
                        respuesta('El proveedor ya se encuentra registrado', 'error');
                        $('#proveedor_nombre').css('border','solid red');
                        break;
                    case 4:
                        respuesta('El ruc ya se encuentra registrado', 'error');
                        $('#proveedor_ruc').css('border','solid red');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});

//Se usa para agregar los campos a editar al proveedor
function editar_proveedor(id_proveedor,id_negocio,id_tipodocumento, proveedor_nombre, proveedor_ruc, proveedor_direccion,proveedor_nombre_contacto,
                          proveedor_cargo_persona, proveedor_numero){
    $('#id_proveedor').val(id_proveedor);
    $('#id_negocio_e').val(id_negocio);
    $('#id_tipodocumento_e').val(id_tipodocumento);
    $('#proveedor_nombre_e').val(proveedor_nombre);
    $('#proveedor_ruc_e').val(proveedor_ruc);
    $('#proveedor_direccion_e').val(proveedor_direccion);
    $('#proveedor_nombre_contacto_e').val(proveedor_nombre_contacto);
    $('#proveedor_cargo_persona_e').val(proveedor_cargo_persona);
    $("#proveedor_numero_e").val(proveedor_numero);
}

//Se usa para editar la informacion del usuario
$("#editarInformacionProveedor").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-editar-proveedor";
    //Extraemos las variable según los valores del campo consultado

    var id_proveedor = $('#id_proveedor').val();
    var id_negocio_e = $('#id_negocio_e').val();
    var proveedor_nombre_e = $('#proveedor_nombre_e').val();
    var proveedor_ruc_e = $('#proveedor_ruc_e').val();
    var proveedor_direccion_e = $('#proveedor_direccion_e').val();

    valor = validar_campo_vacio('id_proveedor', id_proveedor, valor);
    valor = validar_campo_vacio('proveedor_nombre_e', proveedor_nombre_e, valor);
    valor = validar_campo_vacio('proveedor_ruc_e', proveedor_ruc_e, valor);
    valor = validar_campo_vacio('proveedor_direccion_e', proveedor_direccion_e, valor);

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/proveedor/guardar_edicion_proveedor",
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
                       respuesta('¡Proveedor Editado Correctamente!', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al editar proveedor', 'error');
                        break;
                    case 3:
                        respuesta('El nombre del proveedor ya se encuentra en uso', 'error');
                        $('#proveedor_nombre_e').css('border','solid red');
                        $('#proveedor_ruc_e').css('border','');
                        break;
                    case 4:
                        respuesta('El ruc del proveedor ya se encuentra en uso', 'error');
                        $('#proveedor_nombre_e').css('border','solid red');
                        $('#proveedor_ruc_e').css('border','');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});

//Limpia el formulario de registro de proveedor
function agregacion_proveedor() {
    $('#id_proveedor').val("");
    $('#proveedor_nombre').val("");
    $('#proveedor_ruc').val("");
    $('#proveedor_direccion').val("");
    $('#proveedor_numero').val("");
    $("#proveedor_estado").val(1);
    $("#proveedor_estado").css('color', 'white');
    $("#proveedor_estado").css('background', '#17a673');
}

//Funcion para eliminar una proveedor
function eliminar_proveedor(id_proveedor){
    var valor = true;
    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_parametro_vacio(id_proveedor, valor);
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Definimos el mensaje y boton a afectar
        var boton = "btn-eliminarproveedor" + id_proveedor;
        //Cadena donde enviaremos los parametros por POST
        var cadena = "id_proveedor=" + id_proveedor;
        $.ajax({
            type: "POST",
            url: urlweb + "api/proveedor/eliminar_proveedor",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, "Eliminando...", true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "Eliminar proveedor", false);
                switch (r.result.code) {
                    case 1:
                        $('#proveedor' + id_proveedor).remove();
                        respuesta('¡proveedor Eliminada!', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al eliminar proveedor', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}