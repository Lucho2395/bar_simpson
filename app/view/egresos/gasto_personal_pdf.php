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
$pdf->Cell(130,10,'ADELANTOS DEL PERSONAL',0,1,'C');
$pdf->Cell(30);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(130,10,'DESDE'." ".date('d-m-Y',strtotime($fecha_filtro))." ". 'HASTA'." ".date('d-m-Y',strtotime($fecha_filtro_fin)),0,1,'C');
$pdf->Ln();
$pdf->SetFillColor(232,232,232);
$pdf->SetFont('Arial','',10);
$pdf->Cell(60,6,'PERSONA',1,0,'C',1);
$pdf->Cell(60,6,'CONCEPTO',1,0,'C',1);
$pdf->Cell(20,6,'MONTO',1,0,'C',1);
$pdf->Cell(25,6,'F. ENTREGA',1,0,'C',1);
$pdf->Cell(30,6,'F. REGISTRO',1,0,'C',1);
$pdf->Ln();
$suma_montos = 0;
$pdf->SetFont('Arial','',10);
foreach ($gasto_personal as $m){
    $pdf->CellFitSpace(60,6,$m->persona_nombre." ".$m->persona_apellido_paterno." ".$m->persona_apellido_materno,1,0,'C',0);
    $pdf->CellFitSpace(60,6,$m->gasto_personal_concepto,1,0,'C',0);
    $pdf->CellFitSpace(20,6,"S/. ".$m->gasto_personal_monto,1,0,'C',0);
    $pdf->CellFitSpace(25,6,date('d-m-Y',strtotime($m->gasto_personal_fecha)),1,0,'C',0);
    $pdf->CellFitSpace(30,6,date('d-m-Y H:m:s',strtotime($m->gasto_personal_fecha_registro)),1,1,'C',0);
    $suma_montos = $suma_montos + $m->gasto_personal_monto;
}
$pdf->SetFont('Arial','',12);
$pdf->Cell(118,10,'MONTO TOTAL',0,0,'C',0);
$pdf->Cell(30,10,"S/. ".$suma_montos,0,1,'R',0);


$pdf->Ln();
$pdf->Ln();
$pdf->Output();
?>