<?php
/**
 * Created by PhpStorm
 * User: LuisSalazar
 * Date: 13/12/2020
 * Time: 10:00 p. m.
 */
//LLAMAMOS A LA LIBRERIA que está en la vista de report
//require 'app/view/report/pdf_base.php';
//llamamos a la clase pdf_base.php que esta en la vista sellgas
//require_once 'pdf_base_ticket.php';
//se llama directo a la libreria
require 'app/view/pdf/fpdf/fpdf.php';
//require 'app/view/report/pdf_base.php';
// creamos el objeto
$filas_detalle = count($detalle_venta);
if($filas_detalle==1 || $filas_detalle==2){
    $pdf = new FPDF('P','mm',array(80,220));
}elseif($filas_detalle==3 || $filas_detalle==4){
    $pdf = new FPDF('P','mm',array(80,240));
}elseif($filas_detalle==5 || $filas_detalle==6){
    $pdf = new FPDF('P','mm',array(80,260));
}else{
    $pdf = new FPDF('P','mm',array(80,300));
}
//Define el marcador de posición usado para insertar el número total de páginas en el documento
$pdf->AddPage();
//CABECERA DEL ARCHIVO
//Logo
$pdf->Image('media/logo/logo_simpson.png',30.5,6, '21', '21', 'PNG');
$pdf->Ln(15);

$pdf->SetFont('Helvetica','',9);
//$pdf->Cell(60,4, "$dato_pago->empresa_nombrecomercial",0,1,'C',0);
$pdf->Cell(60,4,"$dato_venta->empresa_nombre",0,1,'C');
//$pdf->Cell(60,4, "EMPRESA DE SERVICIOS PARA EL ",0,1,'C',0);
//$pdf->Cell(60,4, "DESARROLLO HUMANO",0,1,'C',0);
$pdf->SetFont('Helvetica','',7);
//$pdf->Cell(60,4,"$dato_pago->empresa_nombre",0,1,'C');
$pdf->Cell(60,4, "$dato_venta->empresa_nombrecomercial",0,1,'C',0);
//$pdf->Cell(60,4, "DESARROLLO HUMANO",0,1,'C',0);
$pdf->Cell(60,4,"RUC Nº $dato_venta->empresa_ruc",0,1,'C');
$pdf->SetFont('Helvetica','',7);
//$pdf->Cell(60,4,"$dato_pago->empresa_domiciliofiscal",0,1,'C');
$pdf->Cell(60,4,"$dato_venta->empresa_domiciliofiscal",0,1,'C');
$pdf->Cell(60,4,"$dato_venta->empresa_departamento - $dato_venta->empresa_provincia - $dato_venta->empresa_distrito",0,1,'C');
//$pdf->Cell(60,4,"Tel. $dato_venta->empresa_telefono1",0,1,'C');
//$pdf->Cell(60,4,"E-mail: $dato_venta->empresa_correo",0,1,'C');
$pdf->SetFont('Helvetica','',10);
$pdf->Ln(4);
$pdf->Cell(60,4, "$tipo_comprobante",0,1,'C',0);
$pdf->Cell(60,4, "$serie_correlativo",0,1,'C',false);
$pdf->SetFont('Helvetica','',8);
$pdf->Ln(1);
$pdf->Cell(60,4, "$fecha_hoy",0,1,'C',false);
//DATOS DEL CLIENTE;
$pdf->SetFont('Helvetica','',7);
$pdf->Ln(3);

$pdf->Cell(60,4,"DATOS DEL CLIENTE",1,1,'C');

$pdf->SetMargins(10,'');
if($dato_venta->id_tipodocumento != 4){
    $pdf->MultiCell(60,4,"RAZÓN SOCIAL:    ".$dato_venta->cliente_nombre,0,1,'');
}else{
    $pdf->MultiCell(60,4,"RAZÓN SOCIAL:    ".$dato_venta->cliente_razonsocial,0,1,'');
}
$pdf->Cell(60,4,"$documento",0,1,'');
$pdf->MultiCell(60,4,"DIRECCIÓN:          ".$dato_venta->cliente_direccion,0,1,'');
$pdf->Cell(60,4,"FECHA:                  ".date('d-m-Y', strtotime($dato_venta->venta_fecha)),0,1,'');
//$pdf->Cell(60,4,"$dato_grado",0,1,'');

//$pdf->Cell(60,4,"PADRES:   $padre1",0,1,'');
$pdf->SetMargins(10,'');
//$pdf->Cell(60,4,"                   $padre2",0,1,'');

$pdf->Cell(60,4,"$dato_impresion",1,1,'C');

// COLUMNAS
$pdf->SetFont('Helvetica','B',7);
$pdf->Cell(30, 10, 'Descripción', 0);
$pdf->Cell(5, 10, 'Cant',0,0,'R');
$pdf->Cell(10, 10, 'Precio',0,0,'R');
$pdf->Cell(15, 10, 'Total',0,0,'R');
$pdf->Ln(8);
$pdf->Cell(60,0,'','T');
$pdf->Ln(1);

//PRODUCTOS
foreach ($detalle_venta as $f){
    $pdf->SetFont('Helvetica', '', 7);
    $pdf->MultiCell(30,4,"$f->venta_detalle_nombre_producto",0,'L');
    $pdf->Cell(35, -5, "$f->venta_detalle_cantidad",0,0,'R');
    $pdf->Cell(10, -5, number_format(round("$f->venta_detalle_precio_unitario",2), 2, ',', ' '),0,0,'R');
    $pdf->Cell(15, -5, number_format(round("$f->venta_detalle_valor_total",2), 2, ',', ' '),0,0,'R');
    $pdf->Ln(2);
}

// SUMATORIO DE LOS PRODUCTOS Y EL IVA
$pdf->Ln(3);
$pdf->Cell(60,3,'','T');
$pdf->Ln();
$pdf->Cell(60, 1.5, "Op.Grat: $dato_venta->simbolo $dato_venta->venta_totalgratuita", 0,'1','R');
$pdf->Ln();
$pdf->Cell(60, 1.5, "Op.Exon: $dato_venta->simbolo $dato_venta->venta_totalexonerada", 0,'1','R');
$pdf->Ln();
$pdf->Cell(60, 1.5, "Op.Inaf: $dato_venta->simbolo $dato_venta->venta_totalinafecta", 0,'1','R');
$pdf->Ln();
$pdf->Cell(60, 1.5, "Op.Grav: $dato_venta->simbolo $dato_venta->venta_totalgravada", 0,'1','R');
$pdf->Ln();
$pdf->Cell(60, 1.5, "IGV: $dato_venta->simbolo $dato_venta->venta_totaligv", 0,'1','R');
$pdf->Ln();

$pdf->SetFont('Helvetica', 'B', 7);
$pdf->Ln();
$pdf->Cell(60, 1.5, "TOTAL: $dato_venta->simbolo $dato_venta->venta_total", 0,'1','R');
$pdf->Ln();
$pdf->Cell(60, 1.5, "$montoLetras", 0,'1','R');
// PIE DE PAGINA
$pdf->Ln(5);

if(count($detalle_venta)==1){
    $pdf->Image("$ruta_qr",'5','136', '20', '20', '', '');
}elseif(count($detalle_venta)==2){
    $pdf->Image("$ruta_qr",'5','141', '20', '20', '', '');
}elseif(count($detalle_venta)==3){
    $pdf->Image("$ruta_qr",'5','146', '20', '20', '', '');
}elseif(count($detalle_venta)==4){
    $pdf->Image("$ruta_qr",'5','157', '20', '20', '', '');
}elseif(count($detalle_venta)==5){
    $pdf->Image("$ruta_qr",'5','166', '20', '20', '', '');
}elseif(count($detalle_venta)==6){
    $pdf->Image("$ruta_qr",'5','171', '20', '20', '', '');
}elseif(count($detalle_venta)==7){
    $pdf->Image("$ruta_qr",'5','176', '20', '20', '', '');
}elseif(count($detalle_venta)==8){
    $pdf->Image("$ruta_qr",'5','181', '20', '20', '', '');
}elseif(count($detalle_venta)==9){
    $pdf->Image("$ruta_qr",'5','175', '20', '20', '', '');
}elseif(count($detalle_venta)==10){
    $pdf->Image("$ruta_qr",'5','191', '20', '20', '', '');
}
//$pdf->Cell(20, 10, '', 0);
//$pdf->Cell(15, 10, number_format(round((round(12.25,2)/1.21),2), 2, ',', ' ').EURO,0,0,'R');
/*$pdf->Ln(3);
$pdf->Cell(25, 10, 'I.V.A. 21%', 0);
$pdf->Cell(20, 10, '', 0);
$pdf->Cell(15, 10, number_format(round((round(12.25,2)),2)-round((round(2*3,2)/1.21),2), 2, ',', ' ').EURO,0,0,'R');
$pdf->Ln(3);
$pdf->Cell(25, 10, 'TOTAL', 0);
$pdf->Cell(20, 10, '', 0);
$pdf->Cell(15, 10, number_format(round(12.25,2), 2, ',', ' ').EURO,0,0,'R');*/

// PIE DE PAGINA
$pdf->Ln(3);
$pdf->SetFont('Helvetica', '', 6.5);
//$pdf->Cell(60,0,"$qrcode",0,1,'C');
$pdf->Cell(60,0,'BIENES TRANSFERIDOS EN LA',0,1,'R');
$pdf->Ln(3);
$pdf->Cell(60,0,' AMAZONIA PARA SER CONSUMIDOS',0,1,'R');
$pdf->Ln(3);
$pdf->Cell(60,0,'EN LA MISMA.',0,1,'R');
$pdf->Ln(3);
//$pdf->Cell(60,0,'comprobante en www.sunat.gob.pe',0,1,'R');
$pdf->Ln(10);
$pdf->Cell(60,0,'---------------------------------------------------',0,1,'C');
$pdf->Ln(3);
$pdf->Cell(60,0,'Digitaliza tu negocio, sistemas a medida con',0,1,'C');
$pdf->Ln(3);
$pdf->Cell(60,0,'Facturación Electrónica...',0,1,'C');
$pdf->Ln(3);
$pdf->Cell(60,0,'Whatsapp Business +51925642418',0,1,'C');
$pdf->Ln(3);
$pdf->Cell(60,0,'www.bufeotec.com',0,1,'C');

if(isset($guardar_localmente) && isset($ruta_guardado)){
    $ruta_guardado = 'media/comprobantes/'."$serie_correlativo-" .date('Y-m-d').'.pdf';
    $pdf->Output("F",$ruta_guardado);
} else {
    $pdf->Output('',"$serie_correlativo-" .date('Y-m-d'));
}

?>
