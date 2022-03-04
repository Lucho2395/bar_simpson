<?php
//Llamamos a la libreria
require_once 'app/view/pdf/pdf_base.php';
//creamos el objeto
$pdf=new PDF();

//Añadimos una pagina
$pdf->AddPage();
//Define el marcador de posición usado para insertar el número total de páginas en el documento
$pdf->AliasNbPages();
$pdf->SetFont('Arial','BU',14);
//Mover
$pdf->Cell(30);
$pdf->Cell(130,10,'REPORTE DE CANTIDAD VENDIDA POR PRODUCTO SEGUN FILTRO',0,1,'C');

$pdf->Ln();
$pdf->SetFillColor(232,232,232);
$pdf->SetFont('Arial','',10);
$pdf->Cell(25);
$pdf->Cell(60,6,'PRODUCTO',1,0,'C',1);
$pdf->Cell(47,6,'RANGO DE FECHAS',1,0,'C',1);
$pdf->Cell(43,6,'CANTIDAD VENDIDA',1,0,'C',1);
$pdf->Ln();
$cantidad_vendida = 0;
$pdf->SetFont('Arial','',9);
foreach ($productos as $p){
    $pdf->Cell(25);
    $pdf->CellFitSpace(60,6,$p->producto_nombre,1,0,'C',0);
    $pdf->CellFitSpace(47,6,$fecha_filtro.' / '.$fecha_filtro_fin,1,0,'C',0);
    $pdf->CellFitSpace(43,6,$p->total,1,1,'C',0);
    $cantidad_vendida = $cantidad_vendida +$p->total;

}
$pdf->SetFont('Arial','',12);
$pdf->Cell(118,10,'TOTAL DE PRODUCTOS VENDIDOS',0,0,'C',0);
$pdf->Cell(30,10,$cantidad_vendida,0,1,'R',0);

$pdf->Ln();
$pdf->Ln();
$pdf->Output();
?>