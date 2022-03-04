//Se usa para agregar un nuevo menú al sistema
$("#gestionarInfoUsuario").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-usuario";
    //Extraemos las variable según los valores del campo consultado
    var persona_nombre = $('#persona_nombre').val();
    var persona_apellido_paterno = $('#persona_apellido_paterno').val();
    var persona_apellido_materno = $('#persona_apellido_materno').val();
    var persona_nacimiento = $('#persona_nacimiento').val();
    var persona_telefono = $('#persona_telefono').val();

    var usuario_nickname = $('#usuario_nickname').val();
    var usuario_contrasenha = $('#usuario_contrasenha').val();
    var usuario_contrasenha2 = $('#usuario_contrasenha2').val();
    var usuario_email = $('#usuario_email').val();
    var id_rol = $('#id_rol').val();
    var usuario_estado = $('#usuario_estado').val();

    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_campo_vacio('persona_nombre', persona_nombre, valor);
    valor = validar_campo_vacio('persona_apellido_paterno', persona_apellido_paterno, valor);
    //valor = validar_campo_vacio('persona_apellido_materno', persona_apellido_materno, valor);
    //valor = validar_campo_vacio('persona_nacimiento', persona_nacimiento, valor);
    //valor = validar_campo_vacio('persona_telefono', persona_telefono, valor);

    valor = validar_campo_vacio('usuario_nickname', usuario_nickname, valor);
    valor = validar_campo_vacio('usuario_contrasenha', usuario_nickname, valor);
    valor = validar_campo_vacio('usuario_contrasenha2', usuario_nickname, valor);
    if(valor){
        if(usuario_contrasenha !== usuario_contrasenha2) {
            respuesta('¡Las contraseñas no coinciden!', 'error');
            $('#usuario_contrasenha').css('border','solid red');
            $('#usuario_contrasenha2').css('border','solid red');
            valor = false;
        } else {
            $('#usuario_contrasenha').css('border','');
            $('#usuario_contrasenha2').css('border','');
        }
    }
    valor = validar_campo_vacio('usuario_email', usuario_email, valor);
    valor = validar_campo_vacio('id_rol', id_rol, valor);
    valor = validar_campo_vacio('usuario_estado', usuario_estado, valor);
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/usuario/guardar_nuevo_usuario",
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
                        respuesta('¡Usuario guardado! Recargando...', 'success');
                        $('#usuario_nickname').css('border','');
                        $('#usuario_email').css('border','');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al guardar usuario', 'error');
                        break;
                    case 3:
                        respuesta('El usuario ya se encuentra registrado', 'error');
                        $('#usuario_nickname').css('border','solid red');
                        break;
                    case 4:
                        respuesta('El correo ya se encuentra registrado', 'error');
                        $('#usuario_email').css('border','solid red');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});
//Se usa para agregar los campos a editar el usuario
function editar_usuario(id_usuario, usuario_nickname, usuario_email, id_rol, usuario_estado){
    $('#id_usuario').val(id_usuario);
    $('#usuario_nickname_e').val(usuario_nickname);
    $('#usuario_email_e').val(usuario_email);
    $('#usuario_imagen_e').val("");
    $('#id_rol_e').val(id_rol);
    $("#usuario_estado_e").val(usuario_estado);
    cambiar_color_estado('usuario_estado_e');
}
//Se usa para editar la informacion del usuario
$("#editarInformacionUsuario").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-editar-usuario";
    //Extraemos las variable según los valores del campo consultado

    var id_usuario = $('#id_usuario').val();
    var usuario_nickname_e = $('#usuario_nickname_e').val();
    var usuario_email_e = $('#usuario_email_e').val();
    var id_rol_e = $('#id_rol_e').val();
    var usuario_estado_e = $('#usuario_estado_e').val();


    valor = validar_campo_vacio('id_usuario', id_usuario, valor);
    valor = validar_campo_vacio('usuario_nickname_e', usuario_nickname_e, valor);
    valor = validar_campo_vacio('usuario_email_e', usuario_email_e, valor);
    valor = validar_campo_vacio('id_rol_e', id_rol_e, valor);
    valor = validar_campo_vacio('usuario_estado_e', usuario_estado_e, valor);
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/usuario/guardar_edicion_usuario",
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
                        $('#usuario_nickname_e').css('border','');
                        $('#usuario_email_e').css('border','');
                        $('#usuarionickname' + id_usuario).html(r.result.usuario.usuario_nickname);
                        $('#rolnombre' + id_usuario).html("<strong>" + r.result.usuario.rol_nombre + "</strong>");
                        //$('#usuarioemail' + id_usuario).html(r.result.usuario.usuario_email);
                        colocar_estado_texto(r.result.usuario.usuario_estado, 'usuarioestado' + id_usuario, 'HABILITADO', 'DESHABILITADO')
                        $('#botonusuario' + id_usuario).html("<button data-toggle=\"modal\" data-target=\"#editarDatosUsuario\" class=\"btn btn-xs btn-info btne\" onclick=\"editar_usuario(" + r.result.usuario.id_usuario + ", '" +r.result.usuario.usuario_nickname+"', '" + r.result.usuario.usuario_email + "', " + r.result.usuario.id_rol + ", " + r.result.usuario.usuario_estado + ")\" >Editar Usuario</button>");
                        $('#botoncontra' + id_usuario).html("<button data-toggle=\"modal\" data-target=\"#restablecerContra\" class=\"btn btn-xs btn-secondary btne\" onclick=\"nueva_contra(" + r.result.usuario.id_usuario + ", '" +r.result.usuario.usuario_nickname +"')\" >Resetear Contraseña</button>");
                        respuesta('¡Usuario Guardado!', 'success');
                        break;
                    case 2:
                        respuesta('Error al editar usuario', 'error');
                        break;
                    case 3:
                        respuesta('El nickname del usuario ya se encuentra en uso', 'error');
                        $('#usuario_nickname_e').css('border','solid red');
                        $('#usuario_email_e').css('border','');
                        break;
                    case 4:
                        respuesta('El correo del usuario ya se encuentra en uso', 'error');
                        $('#usuario_email_e').css('border','solid red');
                        $('#usuario_nickname_e').css('border','');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});
//Se usa para editar la informacion de la persona
$("#gestionarInfoPersona").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-editar_persona";
    //Extraemos las variable según los valores del campo consultado

    var id_persona = $('#id_persona').val();
    var persona_nombre_e = $('#persona_nombre_e').val();
    var persona_apellido_paterno_e = $('#persona_apellido_paterno_e').val();
    var persona_apellido_materno_e = $('#persona_apellido_materno_e').val();
    var persona_nacimiento_e = $('#persona_nacimiento_e').val();
    var persona_telefono_e = $('#persona_telefono_e').val();


    valor = validar_campo_vacio('id_persona', id_persona, valor);
    valor = validar_campo_vacio('persona_nombre_e', persona_nombre_e, valor);
    valor = validar_campo_vacio('persona_apellido_paterno_e', persona_apellido_paterno_e, valor);
    valor = validar_campo_vacio('persona_apellido_materno_e', persona_apellido_materno_e, valor);
    valor = validar_campo_vacio('persona_nacimiento_e', persona_nacimiento_e, valor);
    valor = validar_campo_vacio('persona_telefono_e', persona_telefono_e, valor);
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/usuario/guardar_edicion_persona",
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
                        $('#personanombre' + id_persona).html(r.result.persona.persona_nombre);
                        $('#personaapellidopaterno' + id_persona).html(r.result.persona.persona_apellido_paterno);
                        $('#personatelefono' + id_persona).html(r.result.persona.persona_telefono);
                        $('#botonpersona' + id_persona).html("<button data-toggle=\"modal\" data-target=\"#editarPersona\" class=\"btn btn-xs btn-primary btne\" onclick=\"editar_persona(" + r.result.persona.id_persona + ", '" +r.result.persona.persona_nombre+"', '" + r.result.persona.persona_apellido_paterno + "', '" + r.result.persona.persona_apellido_materno + "', '" + r.result.persona.persona_nacimiento + "', '" + r.result.persona.persona_telefono + "')\" >Editar Persona</button>");
                        respuesta('¡Persona Guardada!', 'success');
                        break;
                    case 2:
                        respuesta('Error al editar persona', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});
//Se usa para agregar los campos a editar de la persona
function editar_persona(id_persona, persona_nombre, persona_apellido_paterno, persona_apellido_materno, persona_nacimiento, persona_telefono){
    $('#id_persona').val(id_persona);
    $('#persona_nombre_e').val(persona_nombre);
    $('#persona_apellido_paterno_e').val(persona_apellido_paterno);
    $('#persona_apellido_materno_e').val(persona_apellido_materno);
    $('#persona_nacimiento_e').val(persona_nacimiento);
    $('#persona_telefono_e').val(persona_telefono);
}
//Se usa para agregar los campos del usuario a cambiar contraseña
function nueva_contra(id_usuario, nickname){
    $('#nickname_persona').html("Usuario: <strong>" + nickname + "</strong>");
    $('#id_usuario_contra').val(id_usuario);
}
//Funcion para generar una nueva contraseña
function generar_nueva_contrasenha(){
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-editar-contra";
    //Extraemos las variable según los valores del campo consultado
    var id_usuario_contra = $('#id_usuario_contra').val();
    var contra1 = $('#contra1').val();
    var contra2 = $('#contra2').val();

    valor = validar_campo_vacio('id_usuario_contra', id_usuario_contra, valor);
    valor = validar_campo_vacio('contra1', contra1, valor);
    valor = validar_campo_vacio('contra2', contra2, valor);
    if(valor){
        if(contra1 !== contra2) {
            respuesta('¡Las contraseñas no coinciden!', 'error');
            $('#contra1').css('border','solid red');
            $('#contra2').css('border','solid red');
            valor = false;
        } else {
            $('#contra1').css('border','');
            $('#contra2').css('border','');
        }
    }
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        var cadena = "id_usuario=" + id_usuario_contra +
            "&contrasenha=" + contra1;
        $.ajax({
            type: "POST",
            url: urlweb + "api/usuario/restablecer_contrasenha",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
                switch (r.result.code) {
                    case 1:
                        $('#contra1').val("");
                        $('#contra2').val("");
                        respuesta('¡Contraseña Cambiada!', 'success');
                        break;
                    case 2:
                        respuesta('Error al cambiar contraseña', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}
//Limpia el formulario de registro de usuario
function agregacion_usuario(){
    $('#id_persona').val("");
    $('#persona_nombre').val("");
    $('#persona_apellido_paterno').val("");
    $('#persona_apellido_materno').val("");
    $('#persona_nacimiento').val("");
    $('#persona_telefono').val("");

    $('#id_usuario').val("");
    $('#usuario_nickname').val("");
    $('#usuario_contrasenha').val("");
    $('#usuario_contrasenha2').val("");
    $('#usuario_email').val("");
    $('#usuario_imagen').val("");
    $('#id_rol').val(3);
    $("#usuario_estado").val(1);
    $("#usuario_estado").css('color','white');
    $("#usuario_estado").css('background','#17a673');
}