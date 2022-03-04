//Funcion para guardar una nueva contrasenha
function guardar_contrasenha(){
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-nueva_contra";
    //Extraemos las variable según los valores del campo consultado
    var contra1p = $('#contra1p').val();
    var contra2p = $('#contra2p').val();

    valor = validar_campo_vacio('contra1p', contra1p, valor);
    valor = validar_campo_vacio('contra2p', contra2p, valor);
    if(valor){
        if(contra1p !== contra2p) {
            respuesta('¡Las contraseñas no coinciden!', 'error');
            $('#contra1p').css('border','solid red');
            $('#contra2p').css('border','solid red');
            valor = false;
        } else {
            $('#contra1p').css('border','');
            $('#contra2p').css('border','');
        }
    }
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        var cadena = "contrasenha=" + contra1p;
        $.ajax({
            type: "POST",
            url: urlweb + "api/datos/guardar_contrasenha",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
                switch (r.result.code) {
                    case 1:
                        $('#contra1p').val("");
                        $('#contra2p').val("");
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
//Se usa para editar la informacion del usuario
$("#editarDatosDelUsuario").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-editar-usuario-datos";
    //Extraemos las variable según los valores del campo consultado

    var usuario_nicknamep = $('#usuario_nicknamep').val();
    var usuario_emailp = $('#usuario_emailp').val();

    valor = validar_campo_vacio('usuario_nicknamep', usuario_nicknamep, valor);
    valor = validar_campo_vacio('usuario_emailp', usuario_emailp, valor);
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/datos/guardar_usuario",
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
                        $('#usuario_nicknamep').css('border','');
                        $('#usuario_emailp').css('border','');
                        respuesta('¡Usuario Guardado! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al editar usuario', 'error');
                        break;
                    case 3:
                        respuesta('El nickname del usuario ya se encuentra en uso', 'error');
                        $('#usuario_nicknamep').css('border','solid red');
                        $('#usuario_emailp').css('border','');
                        break;
                    case 4:
                        respuesta('El correo del usuario ya se encuentra en uso', 'error');
                        $('#usuario_emailp').css('border','solid red');
                        $('#usuario_nicknamep').css('border','');
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
$("#gestionarInfoDatosPersona").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-editar-persona-datos";
    //Extraemos las variable según los valores del campo consultado

    var persona_nombrep = $('#persona_nombrep').val();
    var persona_apellido_paternop = $('#persona_apellido_paternop').val();
    var persona_apellido_maternop = $('#persona_apellido_maternop').val();
    var persona_nacimientop = $('#persona_nacimientop').val();
    var persona_telefonop = $('#persona_telefonop').val();

    valor = validar_campo_vacio('persona_nombrep', persona_nombrep, valor);
    valor = validar_campo_vacio('persona_apellido_paternop', persona_apellido_paternop, valor);
    valor = validar_campo_vacio('persona_apellido_maternop', persona_apellido_maternop, valor);
    valor = validar_campo_vacio('persona_nacimientop', persona_nacimientop, valor);
    valor = validar_campo_vacio('persona_telefonop', persona_telefonop, valor);
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/datos/guardar_datos",
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
                        respuesta('¡Datos Guardados! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
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