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

$nombre_impresora = "Ticketera_2";

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
$printer->text("REPORTE DE ADELANTOS" . "\n");
$printer->setFont(Printer::FONT_A);
$printer->setTextSize(1,1);
//$printer->text("$dato_pago->empresa_nombre" . "\n");
$printer->text("DEL DIA : " . "$nueva_fecha_i AL $nueva_fecha_f\n");//AQUI IRIA LA FECHA


$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("--------------------------------" . "\n");
/*
	Ahora vamos a imprimir los
	productos
*/
$printer->setFont(Printer::FONT_B);
$printer->setTextSize(2,2);
$printer->text("DETALLES ADELANTO" . "\n\n");
$suma_monto = 0;
$printer->setFont(Printer::FONT_A);
$printer->setTextSize(1,1);
foreach ($gasto_personal as $dp) {

    /*Alinear a la izquierda para la cantidad y el nombre*/
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer->text($dp->persona_nombre." ".$dp->persona_apellido_paterno." ".$dp->persona_apellido_materno . "\n");

    /*Y a la derecha para el importe*/
    $printer->setJustification(Printer::JUSTIFY_RIGHT);
    $printer->text('S/ ' . $dp->gasto_personal_monto . "\n");
    $suma_monto = $suma_monto + $dp->gasto_personal_monto;

}
$printer->text("-----------------------------------------------\n");
$printer->text("                             TOTAL: S/. ". $suma_monto ."\n");




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
