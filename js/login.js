//Función usada para validar la sesión del usuario
function validar_usuario(){
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-iniciar-sesion";
    //Extraemos las variable según los valores del campo consultado
    var usuario_nickname = $('#usuario_nickname').val();
    var usuario_contrasenha = $('#usuario_contrasenha').val();
    var recordar = document.getElementById("recordar").checked;
    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_campo_vacio('usuario_nickname', usuario_nickname, valor);
    valor = validar_campo_vacio('usuario_contrasenha', usuario_contrasenha, valor);
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        var cadena = "usuario_nickname=" + usuario_nickname +
            "&usuario_contrasenha=" + usuario_contrasenha +
            "&recordar=" + recordar;
        $.ajax({
            type: "POST",
            url: urlweb + "api/login/validar_sesion",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Validando...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, 'Iniciar Sesión', false);
                switch (r.result.code) {
                    case 1:
                        respuesta('Ingreso exitoso, redireccionando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al validar inicio de sesión', 'error');
                        break;
                    case 3:
                        respuesta('Usuario y/o Contraseña Incorrectos', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}