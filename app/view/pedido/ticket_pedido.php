<?php
require_once('app/models/autoload.php'); //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

/*
	Este ejemplo imprime un
	ticket de venta desde una impresora térmica
*/


/*
	Una pequeña clase para
	trabajar mejor con
	los productos
	Nota: esta clase no es requerida, puedes
	imprimir usando puro texto de la forma
	que tú quieras
*/
/*class Producto{

    public function __construct($nombre, $precio, $cantidad){
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->cantidad = $cantidad;
    }
}*/

/*
	Vamos a simular algunos productos. Estos
	podemos recuperarlos desde $_POST o desde
	cualquier entrada de datos. Yo los declararé
	aquí mismo
*/

/*$productos = array(
    new Producto("Papas fritas", 10, 1),
    new Producto("Pringles", 22, 2),
    /*
        El nombre del siguiente producto es largo
        para comprobar que la librería
        bajará el texto por nosotros en caso de
        que sea muy largo
    */
/*new Producto("Galletas saladas con un sabor muy salado y un precio excelente", 10, 1.5),
);*/

/*
	Aquí, en lugar de "POS-58" (que es el nombre de mi impresora)
	escribe el nombre de la tuya. Recuerda que debes compartirla
	desde el panel de control
*/

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

/*
	Intentaremos cargar e imprimir
	el logo
*/
/*
try{
    $logo = EscposImage::load("media/logo/logo_conchita.png", false);
    $printer->bitImage($logo);
}catch(Exception $e){/*No hacemos nada si hay error*//*}
/*
	Ahora vamos a imprimir un encabezado
*/
/*$printer->setFont(Printer::FONT_B);
$printer->setTextSize(2,2);
$printer->text("$empresa->empresa_razon_social" . "\n");
$printer->setFont(Printer::FONT_A);
$printer->setTextSize(1,1);
//$printer->text("$dato_pago->empresa_nombre" . "\n");
$printer->text("RUC Nº $empresa->empresa_ruc" . "\n");
$printer->text("$empresa->empresa_domiciliofiscal" . "\n");
//$printer->text("CAL. YAVARI NRO. 1360" . "\n");
//$printer->text("LORETO - MAYNAS - IQUITOS" . "\n");
if($empresa->empresa_telefono1 != NULL){
    $printer->text("Tel. $empresa->empresa_telefono1" . "\n");
}
if($empresa->empresa_correo != NULL){
    $printer->text("E-mail: $empresa->empresa_correo" . "\n");
}
#La fecha también
$printer->text(date("Y-m-d H:i:s") . "\n\n");*/
$printer->setFont(Printer::FONT_B);
$printer->setTextSize(2,2);
$printer->text("$dato_pedido->mesa_nombre" . "\n");
$printer->text("NRO. TICKET $dato_pedido->comanda_correlativo" . "\n\n");
/*
 Ahora datos del cliente
*/
$printer->setFont(Printer::FONT_A);
$printer->setTextSize(1,1);
$printer->text("------------------------------------------------" . "\n");
$printer->text("DATOS DEL CLIENTE" . "\n");
//$printer->text("------------------------------------------------" . "\n");
/*Alinear a la izquierda*/
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("Nombre:" . "\n\n");
$printer->text("Nª Documento:" . "\n");
$printer->text("Direccion:" . "\n");

//$printer->text("PADRES:       $padre1" . "\n" . "           $padre2" . "\n");
# Vamos a alinear al centro lo próximo que imprimamos
$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("------------------------------------------------" . "\n");
/*
	Ahora vamos a imprimir los
	productos
*/

# Para mostrar el total
$total = 0;
$anho = date('Y');
if($anho == '2021'){
    $icbper = 0.30;
}else if($anho == '2022'){
    $icbper = 0.40;
}else{
    $icbper = 0.50;
}
foreach ($pedidos as $dp) {

    $pre_uni = $dp->comanda_detalle_precio;
    if ($dp->id_receta == "131"){
        $pre_uni = $dp->comanda_detalle_precio + $icbper;
    }
    $total += $dp->comanda_detalle_cantidad * $pre_uni;
    $subtotal = $dp->comanda_detalle_cantidad * $pre_uni;

    /*Alinear a la izquierda para la cantidad y el nombre*/
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer->text($dp->producto_nombre . "\n");

    /*Y a la derecha para el importe*/
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->text($dp->comanda_detalle_cantidad . "         x         " .$pre_uni.'        S/ ' . $subtotal . "\n");
}

/*
	Terminamos de imprimir
	los productos, ahora va el total
*/
$printer->text("------------------------------------------------");
/*Alinear a la izquierda para la cantidad y el nombre*/
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("                             TOTAL: S/ ". number_format($total, 2) ."\n");
$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text(CantidadEnLetra($total) ."\n");
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
