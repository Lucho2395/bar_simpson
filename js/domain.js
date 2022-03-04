var urlweb = "http://127.0.0.1:81/simpson/";
var ruta_web = "http://127.0.0.1:81/simpson/";
//var ruta_web = "http://localhost:8081/mesita/";
//var ruta_web = "http://192.168.43.54:8081/mesita/";

//Función que hizo Carlitos que no sé bien para que sirve pero la dejo ahí por si las moscas
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ?
        "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

//Llamar así: onchange="return validar_correo(this.id)"
function validar_correo(id) {
    var text = document.getElementById(id).value;
    var expreg = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
    if(expreg.test(text)){
        return true;
    } else {
        error("Formato de Correo Inválido");
        document.getElementById(id).value = '';
        return false;
    }
}

//Llamar así: onchange="return validar_solo_texto(this.id)"
function validar_solo_texto(id) {
    var text = document.getElementById(id).value;
    var expreg = new RegExp(/^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/);
    if(expreg.test(text)){
        return true;
    } else {
        error("El texto contiene carácteres no válidos.");
        document.getElementById(id).value = '';
        return false;
    }
}
//Función para que todo el texto de un cuadro sea en mayuscula
//Llamar así: onkeyup="mayuscula(this.id)"
function mayuscula(id) {
    var texto = document.getElementById(id).value;
    document.getElementById(id).value = texto.toUpperCase();
}
//Función para validar que sólo se ingresen 2 numeros decimales en un campo numerico
//Llamar así: onkeyup="return validar_numeros_decimales_dos(this.id)"
function validar_numeros_decimales_dos(id) {
    var text = document.getElementById(id).value;
    var expreg = new RegExp(/^[+-]?[0-9]*$/);
    var expreg2 = new RegExp(/^[+-]?[0-9]+([.]+)?$/);
    var expreg3 = new RegExp(/^[+-]?[0-9]+([.][0-9]{1,3})?$/);
    if(expreg.test(text)){
        return true;
    } else {
        if(expreg2.test(text)){
            return true;
        } else {
            if (expreg3.test(text)){
                return true;
            } else {
                //alertify.error("Carácter Inválido");
                var re = /[a-zA-ZñáéíóúÁÉÍÓÚ´,*+?^$&!¡¿#%/{}()='|[\]\\"]/g;
                document.getElementById(id).value = text.replace(re, '');
                text = document.getElementById(id).value;
                var long1 = text.length;
                var count = 1;
                if(long1 !== 0){
                    while (!expreg3.test(text)){
                        if(count !== 5){
                            var long = text.length;
                            var text_to_extract = long - 1;
                            document.getElementById(id).value = text.substring(0, text_to_extract);
                            text = document.getElementById(id).value;
                            count++;
                        } else {
                            document.getElementById(id).value = '0';
                            return false;
                        }
                    }
                }
                return false;
            }
        }

    }
}
//Función para validar que sólo se ingresen números en un campo de texto
//Llamar así: onkeyup="return validar_numeros(this.id)"
function validar_numeros(id) {
    var text = document.getElementById(id).value;
    var expreg = new RegExp(/^[0-9]*$/);
    if(expreg.test(text)){
        return true;
    } else {
        //alertify.error("Carácter Inválido");
        //var long = text.length;
        //var text_to_extract = long - 1;
        //document.getElementById(id).value = text.substring(0, text_to_extract);
        var re = /[a-zA-ZñáéíóúÁÉÍÓÚ´.*+?^$&!¡¿#%/{}()='|[\]\\"]/g;
        document.getElementById(id).value = text.replace(re, '');
        return false;
    }
}
//Función para validar campos vacios
function validar_campo_vacio(campo, valor, estado) {
    //var variable = "#" + campo;
    var objeto = document.getElementById(campo);
    if(valor == ""){
        respuesta('El siguiente Campo Resaltado no puede estar vacío', 'error');
        objeto.style.border = 'solid #ff4d4d';
        estado = false;
        console.log('Campo vacio: ' + campo + " Valor: " + valor);
    } else {
        objeto.style.border = '';
    }
    return estado;
}
//Función para validar parametros vacios
function validar_parametro_vacio(valor, estado) {
    if(valor === ""){
        estado = false;
        respuesta('Parametro vacío', 'error');
    }
    return estado;
}
//Función para redondear decimales
function redondear (numero, decimales = 2, usarComa = false) {
    //Esta respuesta
    var opciones = {
        maximumFractionDigits: decimales,
        useGrouping: false
    };
    return new Intl.NumberFormat((usarComa ? "es" : "en"), opciones).format(numero);
}
//Funcion para jugar con el color de un estado
function cambiar_color_estado(id) {
    var select_pe = $("#" + id).val();
    if (select_pe !== ""){
        switch (select_pe) {
            case '1':
                $("#" + id).css('color','white');
                $("#" + id).css('background','#17a673');
                break;
            case '0':
                $("#" + id).css('color','white');
                $("#" + id).css('background','#e74a3b');
                break;
        }
    }
}
//Función para cambiar el encabezado de un formulario
function cambiar_texto_formulario(id, texto){
    $("#" + id).html(texto);
}
//Función para deshabilitar o habilitar un botón
function cambiar_estado_boton(id, texto, deshabilitado){
    $("#" + id).html(texto);
    $("#" + id).attr("disabled", deshabilitado);
}
//Funcion para cambiar el estado y texto de una etiqueta
function colocar_estado_texto(estado, elemento, texto_si, texto_no){
    if(estado == 1){
        $('#' + elemento).removeClass('texto-deshabilitado');
        $('#' + elemento).addClass('texto-habilitado');
        $('#' + elemento).html(texto_si);
    } else {
        $('#' + elemento).removeClass('texto-habilitado');
        $('#' + elemento).addClass('texto-deshabilitado');
        $('#' + elemento).html(texto_no);
    }
}
$.ajaxSetup({
    beforeSend: function () {
        $("<div class='loader' id='loading'></div>").appendTo("body");
    },complete:function() {
        $("#loading").remove();
    }
});