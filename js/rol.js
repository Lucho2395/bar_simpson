//Limpia el formulario antes de agregar un nuevo menú
function agregacion_rol(){
    $('#id_rol').val("");
    $('#rol_nombre').val("");
    $('#rol_descripcion').val("");

    $("#rol_estado").css('color','white');
    $("#rol_estado").css('background','#17a673');
}
//Funcion para colocar datos a editar
function edicion_rol(id_rol, rol_nombre, rol_descripcion, rol_estado){
    $('#id_rol').val(id_rol);
    $('#rol_nombre').val(rol_nombre);
    $('#rol_descripcion').val(rol_descripcion);
    $('#rol_estado').val(rol_estado);
    cambiar_color_estado('rol_estado');
    cambiar_color_estado('rol_estado');
}
//Se usa para agregar un rol al sistema
function gestionar_rol(){
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-rol";
    //Extraemos las variable según los valores del campo consultado
    var id_rol = $('#id_rol').val();
    var rol_nombre = $('#rol_nombre').val();
    var rol_descripcion = $('#rol_descripcion').val();
    var rol_estado = $('#rol_estado').val();
    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_campo_vacio('rol_nombre', rol_nombre, valor);
    valor = validar_campo_vacio('rol_descripcion', rol_descripcion, valor);
    valor = validar_campo_vacio('rol_estado', rol_estado, valor);

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        var cadena = "id_rol=" + id_rol +
            "&rol_nombre=" + rol_nombre +
            "&rol_descripcion=" + rol_descripcion +
            "&rol_estado=" + rol_estado;
        $.ajax({
            type: "POST",
            url: urlweb + "api/rol/guardar_rol",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
                switch (r.result.code) {
                    case 1:
                        if(id_rol != ""){
                            respuesta('¡Rol Editado Exitosamente', 'success');
                            $('#rolnombre' + id_rol).html(r.result.rol.rol_nombre);
                            $('#roldescripcion' + id_rol).html(r.result.rol.rol_descripcion);
                            $('#botonrol' + id_rol).html("<button data-toggle=\"modal\" data-target=\"#gestionRol\" class=\"btn btn-sm btn-warning btne\" onclick=\"cambiar_texto_formulario('exampleModalLabel', 'Editar Rol'); edicion_rol(" + r.result.rol.id_rol + ", '" +r.result.rol.rol_nombre+"', '" + r.result.rol.rol_descripcion + "', " + r.result.rol.rol_estado + ")\" >Editar</button>");
                            colocar_estado_texto(r.result.rol.rol_estado, 'rolestado' + id_rol, 'HABILITADO', 'DESHABILITADO')
                        } else {
                            respuesta('¡Rol guardado! Recargando...', 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                        break;
                    case 2:
                        respuesta('Error al guardar rol', 'error');
                        break;
                    case 3:
                        respuesta('Este rol ya se encuentra registrado', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}
//Funcion para cargar los accesos del rol
function cargar_accesos(id){
    $('#accesos_gestionar').load(urlweb + 'rol/accesos/' + id);
}
//Se usa para gestionar la relacion entre un menu y un rol
function gestionar_acceso_rol(id_menu, id_rol, relacion){
    var valor = true;
    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_parametro_vacio(id_rol, valor);
    valor = validar_parametro_vacio(id_menu, valor);
    valor = validar_parametro_vacio(relacion, valor);
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Definimos el mensaje y boton a afectar
        var mensaje_previo = "Eliminando...";
        var mensaje_posterior = "Eliminar Acceso";
        var boton = "btn-eliminaraccesorol" + id_menu;
        //Definimos el botón que activa la función
        if(relacion == 1){
            boton = "btn-agregaraccesorol" + id_menu;
            mensaje_previo = "Agregando...";
            mensaje_posterior = "Permitir Acceso";
        }
        //Cadena donde enviaremos los parametros por POST
        var cadena = "id_rol=" + id_rol +
            "&id_menu=" + id_menu +
            "&relacion=" + relacion;
        $.ajax({
            type: "POST",
            url: urlweb + "api/rol/gestionar_acceso_rol",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, mensaje_previo, true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, mensaje_posterior, false);
                switch (r.result.code) {
                    case 1:
                        if(relacion == 1){
                            //Si relacion es 0, mostramos el botón de permitir
                            $('#btn-agregaraccesorol' + id_menu).addClass('no-show');
                            $('#btn-eliminaraccesorol' + id_menu).removeClass('no-show');
                        } else {
                            //Si relacion es 1, mostramos el botón de eliminar
                            $('#btn-agregaraccesorol' + id_menu).removeClass('no-show');
                            $('#btn-eliminaraccesorol' + id_menu).addClass('no-show');
                        }
                        colocar_estado_texto(relacion, 'accesorol' + id_menu, 'CON ACCESO', 'SIN ACCESO')
                        respuesta('¡Relación Editada Exitosamente!', 'success');
                        break;
                    case 2:
                        respuesta('Error al modificar relación', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}