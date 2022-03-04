<?php


require 'app/models/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;


$nombre_impresora = $caja_dato->caja_numero_impresora;

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



$printer->setFont(Printer::FONT_B);
$printer->setTextSize(2,2);
$printer->text("$datos_ticket->mesa_nombre" . "\n");
$printer->text("NRO. TICKET $datos_ticket->venta_serie-$datos_ticket->venta_correlativo" . "\n\n");

/*
 Ahora datos del cliente
*/
$printer->setFont(Printer::FONT_B);
$printer->setTextSize(1,1);
#La fecha también
$printer->text(date("Y-m-d H:i:s") . "\n");
$printer->setFont(Printer::FONT_A);
$printer->setTextSize(1,1);
$printer->text("------------------------------------------------" . "\n");
$printer->text("DATOS DEL DELIVERY" . "\n");
//$printer->text("------------------------------------------------" . "\n");
/*Alinear a la izquierda*/
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("CLIENTE     : $cliente_nombre" . "\n");
$printer->text("TELEFONO    : $datos_ticket->comanda_telefono_delivery" . "\n");
$printer->text("DIRECCIÓN   : $datos_ticket->comanda_direccion_delivery" . "\n");
$printer->text("FECHA       : " .date('d-m-Y', strtotime($venta->venta_fecha)) . "\n");

//$printer->text("PADRES:       $padre1" . "\n" . "           $padre2" . "\n");
# Vamos a alinear al centro lo próximo que imprimamos
$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("------------------------------------------------" . "\n");


/*
	Ahora vamos a imprimir los
	productos
*/

/*
	Terminamos de imprimir
	los productos, ahora va el total
*/

/*Alinear a la izquierda para la cantidad y el nombre*/
$printer->setJustification(Printer::JUSTIFY_LEFT);
//$printer->text("                             TOTAL: S/ ". $dato_pedido->comanda_total ."\n");
$printer->setJustification(Printer::JUSTIFY_CENTER);
//$printer->text(CantidadEnLetra($dato_pedido->comanda_total) ."\n");
/*$printer->text("------------------------------------------------" . "\n");

/*try{
    $logo = EscposImage::load("$ruta_qr", false);
    $printer->bitImage($logo);
}catch(Exception $e){/*No hacemos nada si hay error*//*}


/*
	Podemos poner también un pie de página
*/
/*$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->setFont(Printer::FONT_B);
$printer->setTextSize(1,1);
$printer->text("Comprobante Electrónico generado por el Facturador Sunat, consulte su comprobante en www.sunat.gob.pe" . "\n\n");
$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("------------------------------------------------" . "\n");
$printer->text("Si necesitas un software contactanos en www.bufeotec.com" . "\n");






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














