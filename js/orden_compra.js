function recursos_(valor){
    console.log(valor);
    var id_sucursal = valor;
    $.ajax({
        type: "POST",
        url: urlweb + "api/Ordencompra/listar_recursos_x_sucursal",
        data: "id_sucursal="+id_sucursal,
        dataType: 'json',
        success:function (r) {
            console.log(r);
            $("#div_recurso").show();
            var datos_recurso = "<option value='' selected>Seleccione</option>";
            for(var j =0;j<r.result.length;j++){
                datos_recurso +="<option value='"+r.result[j].id_recurso_sede+"'>"+r.result[j].recurso_nombre+"</option>";
            }
            $("#id_recurso").html(datos_recurso);
        }
    });
}

var contenido = "";
var contenido_ = "";
var conteo = 1;
var suma_total = 0;
var suma_total_ = 0;
function show_table() {
    var llenar="";
    conteo=1;
    if (contenido.length>0){
        var filas=contenido.split('/./.');
        if(filas.length>0){
            var sum = 0;
            for(var i=0;i<filas.length - 1;i++){
                var celdas =filas[i].split('-.-.');
                llenar += "<tr><td>"+conteo+"</td>"+
                    "<td>"+celdas[1]+"</td>"+
                    "<td>"+celdas[2]+"</td>"+
                    "<td>"+celdas[3]+"</td>"+
                    "<td>"+celdas[4]+"</td>"+
                    "<td><a data-toggle=\"tooltip\" onclick='delete_detalle("+i+")' title=\"Eliminar\" type=\"button\" class=\"text-danger\" ><i class=\"fa fa-times ver_detalle\"></i></a></td>"+
                    "</tr>";
                conteo++;
                sum = sum + celdas[4] * 1;
            }
            suma_total = sum;
        }
    }else{
        suma_total = 0;
    }
    $("#contenido_detalle_compra").html(llenar);
    $("#conteo").html(conteo);
    $("#suma_total").val(suma_total);

}

function show_table_() {
    var llenar_="";
    conteo=1;
    if (contenido.length>0){
        var filas=contenido.split('/./.');
        if(filas.length>0){
            var sum = 0;
            for(var i=0;i<filas.length - 1;i++){
                var celdas =filas[i].split('-.-.');
                llenar_ += "<tr><td>"+conteo+"</td>"+
                    "<td>"+celdas[1]+"</td>"+
                    "<td>"+celdas[2]+"</td>"+
                    "<td>"+celdas[3]+"</td>"+
                    "<td>"+celdas[4]+"</td>"+
                    "<td>"+celdas[5]+"</td>"+
                    "<td>"+celdas[6]+"</td>"+
                    "<td>"+celdas[7]+"</td>"+
                    "<td>"+celdas[8]+"</td>"+
                    "<td>"+celdas[9]+"</td>"+
                    "<td>"+celdas[10]+"</td>"+
                    "<td><a data-toggle=\"tooltip\" onclick='delete_detalle_("+i+")' title=\"Eliminar\" type=\"button\" class=\"text-danger\" ><i class=\"fa fa-times ver_detalle\"></i></a></td>"+
                    "</tr>";
                conteo++;
                sum = sum + celdas[9] * 1;
            }
            suma_total_ = sum;
        }
    }else{
        suma_total_ = 0;
    }
    $("#contenido_detalle_compra").html(llenar_);
    $("#conteo").html(conteo);
    $("#suma_total_").val(suma_total_);
}

function show_table_o() {
    var llenar_="";
    conteo=1;
    if (contenido_.length>0){
        var filas=contenido_.split('/./.');
        if(filas.length>0){
            var sum = 0;
            for(var i=0;i<filas.length - 1;i++){
                var celdas =filas[i].split('-.-.');
                llenar_ += "<tr><td>"+conteo+"</td>"+
                    "<td>"+celdas[1]+"</td>"+
                    "<td>"+celdas[2]+"</td>"+
                    "<td>"+celdas[3]+"</td>"+
                    "<td>"+celdas[4]+"</td>"+
                    "<td><a data-toggle=\"tooltip\" onclick='delete_detalle_o("+i+")' title=\"Eliminar\" type=\"button\" class=\"text-danger\" ><i class=\"fa fa-times ver_detalle\"></i></a></td>"+
                    "</tr>";
                conteo++;
                sum = sum + celdas[4] * 1;
            }
            suma_total_ = sum;
        }
    }else{
        suma_total_ = 0;
    }
    $("#contenido_detalle_compra_o").html(llenar_);
    $("#conteo").html(conteo);
    $("#suma_total_").val(suma_total_);
}


function delete_detalle(ind) {
    var contenido_artificio ="";
    if (contenido.length>0){
        var filas=contenido.split('/./.');
        if(filas.length>0){
            for(var i=0;i<filas.length - 1;i++){
                if(i!=ind){
                    var celdas =filas[i].split('-.-.');
                    contenido_artificio += celdas[0] + "-.-."+celdas[1] + "-.-." + celdas[2] + "-.-." + celdas[3] + "-.-." +celdas[4] + "-.-."+ celdas[5] + "/./.";
                }
            }
        }
    }
    contenido = contenido_artificio;
    show_table();
}

function delete_detalle_(ind) {
    var contenido_artificio ="";
    if (contenido.length>0){
        var filas=contenido.split('/./.');
        if(filas.length>0){
            for(var i=0;i<filas.length - 1;i++){
                if(i!=ind){
                    var celdas =filas[i].split('-.-.');
                    contenido_artificio += celdas[0] + "-.-."+celdas[1] + "-.-." + celdas[2] + "-.-." + celdas[3] + "-.-." +celdas[4] + "-.-."+ celdas[5] +"-.-." + celdas[6] +"-.-." + celdas[7] +"-.-." + celdas[8] +"-.-." + celdas[9] +"-.-." + celdas[10] +"/./.";
                }
            }
        }
    }
    contenido = contenido_artificio;
    show_table_();
}

function delete_detalle_o(ind) {
    var contenido_artificio ="";
    if (contenido_.length>0){
        var filas=contenido_.split('/./.');
        if(filas.length>0){
            for(var i=0;i<filas.length - 1;i++){
                if(i!=ind){
                    var celdas =filas[i].split('-.-.');
                    contenido_artificio += celdas[0] + "-.-."+celdas[1] + "-.-." + celdas[2] + "-.-." + celdas[3] + "-.-."+ celdas[4] + "/./.";
                }
            }
        }
    }
    contenido_ = contenido_artificio;
    show_table_o();
}

function agregar(){

    var recurso_val = $("#id_recurso").val();
    if(recurso_val!=""){
        var id_recurso = $("select[name='id_recurso'] option:selected").text();
    }else{
        var id_recurso = "";
    }

    var detalle_compra_cantidad = $("#detalle_compra_cantidad").val() * 1;
    var detalle_compra_precio_compra = $("#detalle_compra_precio_compra").val() * 1;

    var subtotal = detalle_compra_cantidad * detalle_compra_precio_compra;
    subtotal.toFixed(2);
    subtotal = parseFloat(subtotal);

     //suma_total = suma_total + subtotal;
     //console.log(suma_total);

    if(id_recurso !="" && detalle_compra_cantidad!=""&& detalle_compra_precio_compra!="" && recurso_val!="" && subtotal!=""){
        contenido += recurso_val + "-.-." +id_recurso + "-.-." + detalle_compra_cantidad + "-.-." + detalle_compra_precio_compra +"-.-."+subtotal+"/./.";
        console.log(contenido);
        $("#contenido").val(contenido);
        $("#detalle_compra_total_pedido").val(subtotal);
        //$("#suma_total").val(suma_total);

        show_table();
        clean();
    }else{
        respuesta('Ingrese todos los campos');
    }
}

function agregar_fc(){

    var recurso_val = $("#id_recurso").val();
    if(recurso_val!=""){
        var id_recurso = $("select[name='id_recurso'] option:selected").text();
    }else{
        var id_recurso = "";
    }

    var recurso_sede_factor = $("#recurso_sede_factor").val();
    var recurso_sede_merma = $("#recurso_sede_merma").val();
    var recurso_sede_peso_inicial = $("#recurso_sede_peso_inicial").val();
    var recurso_sede_peso_final = $("#recurso_sede_peso_final").val();
    var dato_cantidad = $("#dato_cantidad").val();
    var detalle_compra_cantidad = $("#detalle_compra_cantidad").val();
    var detalle_compra_precio_compra = $("#detalle_compra_precio_compra").val();
    var detalle_compra_total_pedido = $("#detalle_compra_total_pedido").val();

    var total = $("#total").val();

     total = parseFloat(total);
     //suma_total_ = suma_total_ + total;
     //console.log(suma_total_);

    if(id_recurso !="" && detalle_compra_cantidad!=""&& detalle_compra_precio_compra!="" && recurso_val!="" && total!="" && recurso_sede_factor!="" && dato_cantidad!="" && recurso_sede_merma!="" && detalle_compra_total_pedido!=""){
        contenido += recurso_val + "-.-." +id_recurso + "-.-."+recurso_sede_factor+"-.-."+ dato_cantidad+"-.-."+ detalle_compra_cantidad + "-.-."+detalle_compra_precio_compra+"-.-."+recurso_sede_peso_inicial+"-.-."+recurso_sede_peso_final+"-.-."+recurso_sede_merma +"-.-."+total+"-.-."+detalle_compra_total_pedido+"/./.";
        //console.log(contenido);
        $("#contenido").val(contenido);
        //$("#total").val(total);
        //$("#suma_total_").val(suma_total_);

        show_table_();
        clean_();
    }else{
        respuesta('Ingrese todos los campos');
    }
}

function agregar_fc_o(){

    var recurso_val = $("#id_recurso_o").val();
    if(recurso_val!=""){
        var id_recurso = $("select[name='id_recurso_o'] option:selected").text();
    }else{
        var id_recurso = "";
    }

   // var recurso_sede_factor = $("#recurso_sede_factor_o").val();
    //var recurso_sede_merma = $("#recurso_sede_merma").val();
    //var recurso_sede_peso_inicial = $("#recurso_sede_peso_inicial").val();
    //var recurso_sede_peso_final = $("#recurso_sede_peso_final").val();
    var dato_cantidad = $("#dato_cantidad_o").val();
    //var detalle_compra_cantidad = $("#detalle_compra_cantidad_o").val();
    var detalle_compra_precio_compra = $("#detalle_compra_precio_compra_o").val();
    //var detalle_compra_total_pedido = $("#detalle_compra_total_pedido").val();

    var total = $("#total_o").val();

     total = parseFloat(total);
     //suma_total_ = suma_total_ + total;
     //console.log(suma_total_);

    if(id_recurso !="" && detalle_compra_precio_compra!="" && recurso_val!="" && total!="" && dato_cantidad!=""){
        contenido_ += recurso_val + "-.-." +id_recurso + "-.-."+ dato_cantidad+"-.-."+detalle_compra_precio_compra +"-.-."+total+"/./.";
        //console.log(contenido);
        $("#contenido_o").val(contenido_);
        //$("#total").val(total);
        //$("#suma_total_").val(suma_total_);

        show_table_o();
        clean_o();
    }else{
        respuesta('Ingrese todos los campos');
    }
}

function clean() {
    $("#detalle_compra_precio_compra").val("");
    $("#detalle_compra_cantidad").val("");

    $("#id_recurso option[value='']").attr('selected','selected');
    $("#id_recurso").val("");
    $("#id_recurso").select().trigger('change');
}
function clean_() {
    $("#detalle_compra_precio_compra").val("");
    $("#detalle_compra_cantidad").val("");
    $("#recurso_sede_factor").val("");
    $("#recurso_sede_peso_inicial").val("");
    $("#recurso_sede_peso_final").val("");
    $("#dato_cantidad").val(""); 
    //$("#recurso_sede_merma").val("");
    $("#total").val("");
    $("#detalle_compra_total_pedido").val("");

    $("#id_recurso option[value='']").attr('selected','selected');
    $("#id_recurso").val("");
    $("#id_recurso").select().trigger('change');
}

function clean_o() {
    $("#detalle_compra_precio_compra_o").val("");
    $("#detalle_compra_cantidad_o").val("");
    $("#recurso_sede_factor_o").val("");
    //$("#recurso_sede_peso_inicial").val("");
    //$("#recurso_sede_peso_final").val("");
    $("#dato_cantidad_o").val("");
    //$("#recurso_sede_merma").val("");
    $("#total_o").val("");
    //$("#detalle_compra_total_pedido").val("");

    $("#id_recurso_o option[value='']").attr('selected','selected');
    $("#id_recurso_o").val("");
    $("#id_recurso_o").select().trigger('change');
}

$("#fupForm").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var orden_compra_titulo = $('#orden_compra_titulo').val();
    var id_sucursal_ = $('#id_sucursal_').val();
    var id_proveedor = $('#id_proveedor').val();
    var contenido = $('#contenido').val();

    valor = validar_campo_vacio('contenido', contenido, valor);
    valor = validar_campo_vacio('orden_compra_titulo', orden_compra_titulo, valor);
    valor = validar_campo_vacio('id_sucursal_', id_sucursal_, valor);
    valor = validar_campo_vacio('id_proveedor', id_proveedor, valor);
    if (valor){
        $.ajax({
            type:"POST",
            url: urlweb + "api/Ordencompra/guardar_orden",
            dataType: 'json',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.submitBtn').attr("disabled","disabled");
                $('#fupForm').css("opacity",".5");
            },
            success:function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Guardado con Exito!','success');
                        setTimeout(function () {
                            location.href = urlweb +  'Ordencompra/orden_pendiente';
                        }, 1000);
                        break;
                    case 2:
                        respuesta("Fallo el envio, intentelo de nuevo", 'error');
                        break;
                    case 6:
                        respuesta("Algún dato fue ingresado de manera erronéa. Recargue la página por favor.",'error');
                        break;
                    default:
                        respuesta("ERROR DESCONOCIDO", 'error');
                }
                $('#fupForm').css("opacity","");
                $(".submitBtn").removeAttr("disabled");
            }
        });
    }
});

$("#facturas_sin_oc").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var orden_compra_titulo = $('#orden_compra_titulo').val();
    var id_proveedor = $('#id_proveedor').val();
    var contenido = $('#contenido').val();

    //valor = validar_campo_vacio('contenido', contenido, valor);
    valor = validar_campo_vacio('id_proveedor', id_proveedor, valor);
    if (valor){
        $.ajax({
            type:"POST",
            url: urlweb + "api/Ordencompra/guardar_compra_rapida",
            dataType: 'json',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.submitBtn').attr("disabled","disabled");
                $('#facturas_sin_oc').css("opacity",".5");
            },
            success:function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Guardado con Exito!','success');
                        setTimeout(function () {
                            location.reload()
                        }, 1000);
                        break;
                    case 2:
                        respuesta("Fallo el envio, intentelo de nuevo", 'error');
                        break;
                    case 5:
                        respuesta("El numero de factura ya se encuentra registrado", 'error');
                        break;
                    case 6:
                        respuesta("Algún dato fue ingresado de manera erronéa. Recargue la página por favor.",'error');
                        break;
                    default:
                        respuesta("ERROR DESCONOCIDO", 'error');
                }
                $('#facturas_sin_oc').css("opacity","");
                $(".submitBtn").removeAttr("disabled");
            }
        });
    }
});

function datos_sucursal(){
    var sucursal = $("#sucursal").val();
    $.ajax({
        type: "POST",
        url: urlweb + "api/Ordencompra/jalar_recursos",
        data: "sucursal="+sucursal,
        dataType: 'json',
        success:function (r) {
            console.log(r);
            $("#datos_recursos_ids").html(r);
        }
    });
}