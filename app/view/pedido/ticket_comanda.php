<?php
/**
 * Created by PhpStorm
 * User: LuisSalazar
 * Date: 16/08/2021
 * Time: 11:00 a. m.
 */

require_once('app/models/autoload.php'); //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

/*
	Este ejemplo imprime un
	ticket de venta desde una impresora térmica
*/

/*
	Aquí, en lugar de "Ticketera" (que es el nombre de mi impresora)
	escribe el nombre de la tuya. Recuerda que debes compartirla
	desde el panel de control
*/

$nombre_impresora = $caja_dato->caja_numero_impresora;
//$nombre_impresora = $detalle_comanda->grupo_ticketera; //ticketera individual por grupo - sacar comentario


$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);


/* Initialize */
$printer -> initialize();
# Vamos a alinear al centro lo próximo que imprimamos
$printer->setJustification(Printer::JUSTIFY_CENTER);


#La fecha también
$printer->setFont(Printer::FONT_B);
$printer->setTextSize(1,1);
#La fecha también
$printer->text(date("Y-m-d H:i:s") . "\n");
$printer->setFont(Printer::FONT_B);
$printer->setTextSize(2,2);
$printer->text("$comanda->mesa_nombre" . "\n");
$printer->text("NRO. TICKET $comanda->comanda_correlativo" . "\n\n");
/*
 Ahora datos del cliente
*/
$printer->setFont(Printer::FONT_A);
$printer->setTextSize(1,1);
$printer->text("------------------------------------------------" . "\n");

/*Alinear a la izquierda*/
$printer->setJustification(Printer::JUSTIFY_LEFT);
//nombre del mesero
$mesero = $comanda->persona_nombre. ' ' .$comanda->persona_apellido_paterno. ' ' .$comanda->persona_apellido_materno;
$printer->text("MESERO/A : $mesero" . "\n");
//$printer->text("PARA : $comanda->comanda_detalle_despacho" . "\n");
foreach ($detalle_comanda as $dc) {
	$printer->setJustification(Printer::JUSTIFY_LEFT);
	$printer->text($dc->comanda_detalle_cantidad . "  " .$dc->producto_nombre. "  " .$dc->comanda_detalle_despacho. "  " .$dc->comanda_detalle_observacion. "\n");
}


$printer->text("------------------------------------------------");

/*Alimentamos el papel 3 veces*/
$printer->feed(1);

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

