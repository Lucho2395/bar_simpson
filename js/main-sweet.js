//Documentación:
//https://sweetalert2.github.io/
//Función de sweetalert para devolver mensaje de respuesta
//Tipos de Icono:
//success: Exitoso
//error: Error
//warning: Advertencia
function respuesta(mensaje, tipo,tiempo = 3000){
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: tiempo,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
    Toast.fire({
        icon: tipo,
        title: mensaje
    })
}
//Función para preguntar antes de realizar una operación
function preguntar(mensaje, funcion_usar, confirmar, denegar, id, id2 = '', id3 = ''){
    Swal.fire({
        title: mensaje,
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: confirmar,
        denyButtonText: denegar,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            //Swal.fire('Saved!', '', 'success')
            if(id3 !== ''){
                window[funcion_usar].apply(this, [id,id2,id3]);
            } else {
                if(id2 !== ''){
                    window[funcion_usar].apply(this, [id,id2]);
                } else {
                    window[funcion_usar].apply(this, [id]);
                }
            }
        } else if (result.isDenied) {
            respuesta('Operacion Cancelada', 'error');
        }
    })
}