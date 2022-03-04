<?php
/**
 * Created by PhpStorm
 * User: LuisSalazar
 * Date: 29/04/2021
 * Time: 11:18 p. m.
 */

require 'app/models/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;



$nombre_impresora = "Ticketera";


$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);


/*
	Vamos a imprimir un logotipo
	opcional. Recuerda que esto
	no funcionará en todas las
	impresoras

	Pequeña nota: Es recomendable que la imagen no sea
	transparente (aunque sea png hay que quitar el canal alfa)
	y que tenga una resolución baja. En mi caso
	la imagen que uso es de 250 x 250
*/
/* Initialize */
$printer -> initialize();
# Vamos a alinear al centro lo próximo que imprimamos
$printer->setJustification(Printer::JUSTIFY_CENTER);

/*
	Intentaremos cargar e imprimir
	el logo
*/
/*try{
    $logo = EscposImage::load("media/logo/logo_ruta_ticket.png", false);
    $printer->bitImage($logo);
}catch(Exception $e){*//*No hacemos nada si hay error}*/
/*
	Ahora vamos a imprimir un encabezado
*/
$printer->setFont(Printer::FONT_B);
$printer->setTextSize(2,2);
$printer->text("REPORTE GENERAL" . "\n");
$printer->setFont(Printer::FONT_A);
$printer->setTextSize(1,1);
//$printer->text("$dato_pago->empresa_nombre" . "\n");
$printer->text("DEL DIA : " . "$nueva_fecha_i AL $nueva_fecha_f\n");//AQUI IRIA LA FECHA
//$printer->text("$empresa->empresa_domiciliofiscal" . "\n");
//$printer->text("CAL. YAVARI NRO. 1360" . "\n");
//$printer->text("LORETO - MAYNAS - PUNCHANA" . "\n");


//$printer->text("PADRES:       $padre1" . "\n" . "           $padre2" . "\n");
# Vamos a alinear al centro lo próximo que imprimamos
$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("------------------------------------------------" . "\n");
/*
	Ahora vamos a imprimir los
	productos
*/

# Para mostrar el total
//$caja_total = 0;
//$ingresos_total = 0;
//$egresos_totales = 0;
//$ingresos_tarjeta_total = 0;
//$ingresos_transferencias_total = 0;
//$ingresos_totales_salon = 0;
//$ingresos_totales_delivery = 0;
//$ingresos_generales = 0;
//$movimientos_caja_chica = 0;
//$salida_caja_chica = 0;
//$orden_pedido_total = 0;
//$ingresos_total_efectivo_delivery = 0;
//$ingresos_total_tarjeta_delivery = 0;
//$ingresos_total_transferencia_delivery = 0;
//$ingresos_total_de_ventas = 0;
//$diferencia = 0;
//    for($i=$fecha_filtro;$i<=$fecha_filtro_fin;$i+=86400){
//
//        $caja = $this->reporte->sumar_caja(date("Y-m-d",$i),$id_caja_numero);
//        $reporte_ingresos_movi = $this->reporte->listar_datos_ingresos_caja(date("Y-m-d",$i),$id_caja_numero);
//        $reporte_ingresos = $this->reporte->listar_datos_ingresos(date("Y-m-d",$i),$id_caja_numero);
//        $reporte_ingresos_tarjeta = $this->reporte->listar_datos_ingresos_tarjeta(date("Y-m-d",$i),$id_caja_numero);
//        $reporte_ingresos_transferencia = $this->reporte->listar_datos_ingresos_transferencia(date("Y-m-d",$i),$id_caja_numero);
//        $reporte_orden_pedido = $this->reporte->listar_monto_op(date("Y-m-d",$i),$id_caja_numero);
//        $reporte_egresos_movi = $this->reporte->listar_datos_egresos(date("Y-m-d",$i),$id_caja_numero);
//        //FUNCIONES PARA LOS INGRESOS DEL DELIVERY
//        $reporte_ingresos_delivery = $this->reporte->listar_datos_ingresos_delivery(date("Y-m-d",$i),$id_caja_numero);
//        $reporte_ingresos_tarjeta_delivery = $this->reporte->listar_datos_ingresos_tarjeta_delivery(date("Y-m-d",$i),$id_caja_numero);
//        $reporte_ingresos_transferencia_delivery = $this->reporte->listar_datos_ingresos_transferencia_delivery(date("Y-m-d",$i),$id_caja_numero);
//        //RESULTADO DE LAS FUNCIONES PARA SALON
//        $caja = $caja->total;
//        $reporte_ingresos_movi = $reporte_ingresos_movi->total;
//        $ingresos = $reporte_ingresos->total;
//        $reporte_ingresos_tarjeta = $reporte_ingresos_tarjeta->total;
//        $reporte_ingresos_transferencia = $reporte_ingresos_transferencia->total;
//        //$reporte_orden_pedido = $reporte_orden_pedido->total;
//        $reporte_egresos_movi = $reporte_egresos_movi->total;
//        //RESULTADO DE LAS FUNCIONES PARA DELIVERYS
//        $reporte_ingresos_delivery = $reporte_ingresos_delivery->total;
//        $reporte_ingresos_tarjeta_delivery = $reporte_ingresos_tarjeta_delivery->total;
//        $reporte_ingresos_transferencia_delivery = $reporte_ingresos_transferencia_delivery->total;
//
//        //SUMA DE TOTALES EN EL SALON
//        $caja_total = $caja_total + $caja;
//        $movimientos_caja_chica = $movimientos_caja_chica + $reporte_ingresos_movi;
//        $ingresos_total = $ingresos_total + $ingresos;
//        $ingresos_tarjeta_total = $ingresos_tarjeta_total + $reporte_ingresos_tarjeta;
//        $ingresos_transferencias_total = $ingresos_transferencias_total + $reporte_ingresos_transferencia;
//        //$orden_pedido_total = $orden_pedido_total + $reporte_orden_pedido;
//        $salida_caja_chica = $salida_caja_chica + $reporte_egresos_movi;
//        //SUMA DE TOTALES DEL DELIVERY
//        $ingresos_total_efectivo_delivery = $ingresos_total_efectivo_delivery + $reporte_ingresos_delivery;
//        $ingresos_total_tarjeta_delivery = $ingresos_total_tarjeta_delivery + $reporte_ingresos_tarjeta_delivery;
//        $ingresos_total_transferencia_delivery = $ingresos_total_transferencia_delivery + $reporte_ingresos_transferencia_delivery;
//    }
//    $ingresos_total_de_ventas = $ingresos_total_de_ventas + $ingresos_total + $ingresos_tarjeta_total + $ingresos_transferencias_total + $ingresos_total_efectivo_delivery + $ingresos_total_tarjeta_delivery + $ingresos_total_transferencia_delivery;
//    $ingresos_generales = $ingresos_generales + $ingresos_total + $ingresos_tarjeta_total + $ingresos_transferencias_total + $ingresos_total_efectivo_delivery +
//    $ingresos_total_tarjeta_delivery + $ingresos_total_transferencia_delivery + $caja_total + $movimientos_caja_chica - $salida_caja_chica;
//
//    $ingresos_totales_salon = $ingresos_totales_salon + $ingresos_tarjeta_total + $ingresos_total + $ingresos_transferencias_total;
//    $ingresos_totales_delivery = $ingresos_totales_delivery + $ingresos_total_efectivo_delivery + $ingresos_total_tarjeta_delivery + $ingresos_total_transferencia_delivery;
//    $egresos_totales = $egresos_totales + $salida_caja_chica;
//
//    $diferencia = $diferencia + $caja_total + $movimientos_caja_chica + $ingresos_total + $ingresos_total_efectivo_delivery - $salida_caja_chica;

foreach ($cajas_totales as $ct) {
    $datitos = $this->reporte->datitos_caja($ct->id_caja);

    $fecha_ini_caja = $datitos->caja_fecha_apertura;
    if ($datitos->caja_fecha_cierre == NULL) {
        $fecha_fin_caja = date('Y-m-d H:i:s');
    } else {
        $fecha_fin_caja = $datitos->caja_fecha_cierre;
    }

    $total = 0;
    $apertura = 1;
    //N° DE VENTAS POR TIPO
    $n_ventas_delivery = $this->reporte->n_ventas_delivery($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
    $n_ventas_salon = $this->reporte->n_ventas_salon($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
    //DATOS PARA LOS ADELANTOS AL PERSONAL
    $datos_gastos_p = $this->reporte->datos_gastos_p($ct->id_caja);
    $sumar_datos_p = $this->reporte->sumar_datos_p($ct->id_caja);
    //FUNCIONEAS PARA SACAR LOS DATOS DEL REPORTE GENERAL
    $monto_caja_apertura = $this->reporte->reporte_caja_x_caja($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
    $ingreso_caja_chica = $this->reporte->ingreso_caja_chica_x_caja($ct->id_caja,$fecha_ini_caja, $fecha_fin_caja);
    //REPORTE DE VENTAS POR SALON
    $ventas_efectivo_salon = $this->reporte->ventas_efectivo($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
    $ventas_tarjeta_salon = $this->reporte->ventas_tarjeta($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
    $ventas_trans = $this->reporte->ventas_trans_plin($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
    $ventas_trans_yape = $this->reporte->ventas_trans_yape($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
    $ventas_trans_otros = $this->reporte->ventas_trans_otros($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
    //SALIDA DE CAJA CHICA
    $salida_caja_chica = $this->reporte->salida_caja_chica_x_caja($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
    //FUNCIONES PARA LOS INGRESOS DEL DELIVERY
    $reporte_ingresos_delivery = $this->reporte->listar_datos_ingresos_delivery_($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
    $reporte_ingresos_tarjeta_delivery = $this->reporte->listar_datos_ingresos_tarjeta_delivery_($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
    $ventas_transferencia_delivery = $this->reporte->listar_datos_ingresos_transferencia_delivery_plin($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
    $ventas_transferencia_delivery_yape = $this->reporte->listar_datos_ingresos_transferencia_delivery_yape($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
    $ventas_transferencia_delivery_otros = $this->reporte->listar_datos_ingresos_transferencia_delivery_otros($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);


    $sumar_datos_p = $sumar_datos_p->total;
    //FUNCIONES DESGLOSADAS PARA SALON
    $monto_caja_apertura = $monto_caja_apertura->total;
    $ingreso_caja_chica = $ingreso_caja_chica->total;
    $ventas_efectivo = $ventas_efectivo_salon->total;
    $ventas_tarjeta = $ventas_tarjeta_salon->total;
    $ventas_trans = $ventas_trans->total;
    $ventas_trans_yape = $ventas_trans_yape->total;
    $ventas_trans_otros = $ventas_trans_otros->total;
    //FUNCIONES DESGLOSADAS PARA DELIVERY
    $ventas_efectivo_delivery = $reporte_ingresos_delivery->total;
    $ventas_tarjeta_delivery = $reporte_ingresos_tarjeta_delivery->total;
    $ventas_transferencia_delivery = $ventas_transferencia_delivery->total;
    $ventas_transferencia_delivery_yape = $ventas_transferencia_delivery_yape->total;
    $ventas_transferencia_delivery_otros = $ventas_transferencia_delivery_otros->total;
    //SALIDA DE CAJA CHICA
    $salida_caja_chica = $salida_caja_chica->total;


    $ingresos_total_de_ventas = $ventas_efectivo + $ventas_tarjeta + $ventas_trans + $ventas_trans_yape + $ventas_trans_otros + $ventas_efectivo_delivery +
        $ventas_tarjeta_delivery + $ventas_transferencia_delivery + $ventas_transferencia_delivery_yape + $ventas_transferencia_delivery_otros;

    $ingresos_totales_salon = $ventas_efectivo + $ventas_trans + $ventas_trans_yape + $ventas_trans_otros + $ventas_tarjeta;

    $ingresos_totales_delivery = $ventas_efectivo_delivery + $ventas_tarjeta_delivery + $ventas_transferencia_delivery +
        $ventas_transferencia_delivery_yape + $ventas_transferencia_delivery_otros;

    $ingresos_generales = $ventas_efectivo + $ventas_trans + $ventas_trans_yape + $ventas_trans_otros + $ventas_tarjeta +
        $ventas_efectivo_delivery + $ventas_tarjeta_delivery + $ventas_transferencia_delivery + $ventas_transferencia_delivery_yape + $ventas_transferencia_delivery_otros
        + $monto_caja_apertura + $ingreso_caja_chica - $salida_caja_chica - $sumar_datos_p;

    $egresos_totales = $salida_caja_chica;
    $diferencia = $monto_caja_apertura + $ingreso_caja_chica + $ventas_efectivo + $ventas_efectivo_delivery - $salida_caja_chica - $sumar_datos_p;


    /*Alinear a la izquierda para la cantidad y el nombre*/
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer->text('TOTAL DE VENTAS DEL DIA' . '            S/ ' . $ingresos_total_de_ventas . "\n");
    $printer->text('INGRESOS - EGRESOS' . '                 S/ ' . $ingresos_generales . "\n");
    $printer->text('APERTURA DE CAJA' . '                   S/ ' . $monto_caja_apertura . "\n");
    $printer->text('INGRESOS DE CAJA CHICA' . '             S/ ' . $ingreso_caja_chica . "\n");
    $printer->text("------------------------------------------------\n");
    $printer->text('VENTAS EN SALON' . '                     S/ ' . $ingresos_totales_salon . "\n");
    $printer->text('PAGOS EFECTIVO' . '                      S/ ' . $ventas_efectivo . "\n");
    $printer->text('PAGOS TARJETA' . '                       S/ ' . $ventas_tarjeta . "\n");
    $printer->text('PAGOS TRANSFERENCIA PLIN' . '            S/ ' . $ventas_trans . "\n");
    $printer->text('PAGOS TRANSFERENCIA YAPE' . '            S/ ' . $ventas_trans_yape . "\n");
    $printer->text('PAGOS TRANSFERENCIA OTROS' . '           S/ ' . $ventas_trans_otros . "\n");
    $printer->text("------------------------------------------------\n");
    $printer->text('VENTAS DELIVERY' . '                     S/ ' . $ingresos_totales_delivery . "\n");
    $printer->text('PAGOS EFECTIVO' . '                      S/ ' . $ventas_efectivo_delivery . "\n");
    $printer->text('PAGOS TARJETA' . '                       S/ ' . $ventas_tarjeta_delivery . "\n");
    $printer->text('PAGOS TRANSFERENCIA PLIN' . '            S/ ' . $ventas_transferencia_delivery . "\n");
    $printer->text('PAGOS TRANSFERENCIA YAPE' . '            S/ ' . $ventas_transferencia_delivery_yape . "\n");
    $printer->text('PAGOS TRANSFERENCIA OTROS' . '           S/ ' . $ventas_transferencia_delivery_otros . "\n");
    $printer->text("------------------------------------------------\n");
    $printer->text('EGRESOS' . '                             S/ ' . $egresos_totales . "\n");
    $printer->text('SALIDAS CAJA CHICA' . '                  S/ ' . $salida_caja_chica . "\n");
    $printer->text("------------------------------------------------\n");
    $printer->text('GASTOS PERSONAL' . '                     S/ ' . $sumar_datos_p . "\n");
    foreach ($datos_gastos_p as $dg) {
        $valores = $this->reporte->valores($dg->id_gasto_personal);
        $printer->text('- ' . $dg->nombre . '' . $dg->apellido . 'S/ ' . $valores->total . "\n");
    }
    $printer->text("------------------------------------------------\n");
    $printer->text('N° VENTAS SALON' . '                     ' . $n_ventas_salon->total . "\n");
    $printer->text('N° VENTAS DELIVERY' . '                  ' . $n_ventas_delivery->total . "\n");
    $printer->text("------------------------------------------------\n");
    $printer->text('TOTAL EFECTIVO' . '                      S/ ' . $diferencia . "\n");

    /*Y a la derecha para el importe*/
    //$printer->setJustification(Printer::JUSTIFY_CENTER);
    //$printer->text($dp->venta_detalle_cantidad . "   x   " .$dp->venta_detalle_valor_unitario.'  S/ ' . $dp->venta_detalle_valor_total . "\n");

    /*
        Terminamos de imprimir
        los productos, ahora va el total
    */
    $printer->text("------------------------------------------------\n");
    /*
        AHORA VAMOS A LISTAR LOS EGRESOS DETALLADOS
    */
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->setFont(Printer::FONT_B);
    $printer->setTextSize(2, 2);
    $printer->text("DETALLES DE EGRESOS" . "\n\n");
    $total_e = 0;
    $printer->setFont(Printer::FONT_A);
    $printer->setTextSize(1, 1);
    $fecha_ini_caja = $datitos->caja_fecha_apertura;
    if ($datitos->caja_fecha_cierre == NULL) {
        $fecha_fin_caja = date('Y-m-d H:i:s');
    } else {
        $fecha_fin_caja = $datitos->caja_fecha_cierre;
    }
    $listar_egresos = $this->reporte->listar_egresos_descripcion($fecha_ini_caja, $fecha_fin_caja);
    foreach ($listar_egresos as $dp) {

        /*Alinear a la izquierda para la cantidad y el nombre*/
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text($dp->egreso_descripcion . "\n");

        /*Y a la derecha para el importe*/
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text('S/ ' . $dp->egreso_monto . "\n");
        $total_e = $total_e + $dp->egreso_monto;

    }
    $printer->text("------------------------------------------------\n");
    $printer->text("               TOTAL: S/ " . $total_e . "\n");

    $printer->text("\n");
    $printer->text("\n");
}

/*Alinear a la izquierda para la cantidad y el nombre*/
//$printer->setJustification(Printer::JUSTIFY_LEFT);
//if($venta->venta_totalgratuita > 0){
//    $printer->text("   OP. GRAT: S/ ". $venta->venta_totalgratuita ."\n");
//
//}
//$printer->text("   OP. EXON: S/ ". $venta->venta_totalexonerada ."\n");
//if($venta->venta_totalinafecta > 0){
//    $printer->text("   OP. INAF: S/ ". $venta->venta_totalinafecta ."\n");
//}
//$printer->text("    OP. GRAV: S/ ". $venta->venta_totalgravada ."\n");
//$printer->text("    IGV: S/ ". $venta->venta_totaligv ."\n");
//if($venta->venta_icbper > 0){
//    $printer->text("    ICBPER: S/ ". $venta->venta_icbper ."\n");
//}
//
//$printer->text("    TOTAL: S/ ". $venta->venta_total ."\n");
//if($venta->venta_pago_cliente > 0){
//    $printer->setFont(Printer::FONT_B);
//    $printer->setTextSize(1,1);
//    $printer->text("    PAGÓ CON: S/ ". $venta->venta_pago_cliente ."\n");
//    $printer->text("    Vuelto: S/ ". $venta->venta_vuelto ."\n");
//}
//$printer->setFont(Printer::FONT_A);
//$printer->setTextSize(1,1);
//$printer->setJustification(Printer::JUSTIFY_CENTER);
//$printer->text(CantidadEnLetra($venta->venta_total) ."\n");
//$printer->text("------------------------------------------------" . "\n");
//if($venta->venta_tipo == "07" || $venta->venta_tipo == "08"){
//    if($venta->tipo_documento_modificar == "03"){
//        $documento = "BOLETA";
//    }else{
//        $documento = "FACTURA";
//    }
//    $printer->setJustification(Printer::JUSTIFY_LEFT);
//    $printer->text("DOCUMENTO:              $documento" . "\n");
//    $printer->text("SERIE MODIFICADA:       $venta->serie_modificar" . "\n");
//    $printer->text("CORRELATIVO MODIFICADO: $venta->correlativo_modificar" . "\n");
//    $printer->text("MOTIVO: $motivo->tipo_nota_descripcion" . "\n");
//}
//try{
//    $logo = EscposImage::load("$ruta_qr", false);
//    $printer->bitImage($logo);
//}catch(Exception $e){/*No hacemos nada si hay error*/}
//
//
///*
//	Podemos poner también un pie de página
//*/
//$printer->setJustification(Printer::JUSTIFY_CENTER);
//$printer->setFont(Printer::FONT_C);
//$printer->setTextSize(1,1);
//$printer->text("BIENES TRANSFERIDOS EN LA AMAZONIA PARA" . "\n");
//$printer->text("SER CONSUMIDOS EN LA MISMA" . "\n");
//$printer->setJustification(Printer::JUSTIFY_CENTER);
//$printer->text("------------------------------------------------" . "\n");
//$printer->setFont(Printer::FONT_B);
//$printer->setTextSize(1,1);
//$printer->text("Digitaliza tu negocio, sistemas a medida" . "\n");
//$printer->text("con Facturación Electrónica... Whatsapp" . "\n");
//$printer->text("Business +51925642418 / bufeotec.com" . "\n");


/*Alimentamos el papel 3 veces*/
$printer->feed(2);

/*
	Cortamos el papel. Si nuestra impresora
	no tiene soporte para ello, no generará
	ningún error
*/
$printer->cut();

/*
	Por medio de la impresora mandamos un pulso.
	Esto es útil cuando la tenemos conectada
	por ejemplo a un cajón
*/
$printer->pulse();

/*
	Para imprimir realmente, tenemos que "cerrar"
	la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
*/
$printer->close();

?>

