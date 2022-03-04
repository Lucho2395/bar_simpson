<?php
require 'app/view/pdf/fpdf/fpdf.php';

class PDF extends FPDF{

    //Cabecera de pagina
    function Header(){
        //Arial bold 15
        $this->SetFont('Arial','B',16);
        //Mover
        $this->Cell(30);
        //Titulo
        $this->Cell(130,10,'RESTOBAR LA ULTIMA CONCHITA S.R.L.',0,1,'C');
        $this->SetFont('Arial','B',12);
        $this->Cell(190,10,'AV. JOSE ABELARDO QUIÑONES NRO 4757',0,1,'C');
        $this->SetFont('Arial','B',12);
        //$this->Cell(190,10,'(ALTURA SOMBRERO DE PAJA)',0,1,'C');
        $this->Ln();
        $this->SetFont('Arial','B',12);
        //$this->Cell(190,10,'YAVARI # 1360 - Telf. 23-4348',0,1,'C');
        $this->SetFont('Arial','B',12);
        $this->Cell(190,10,'----------------------------------------------------------------------------------------------------------------------',0,0,'C');
        $this->Image('media/logo/logo_conchita.png',10,10,32);
        //Salto de linea
        $this->Ln();
    }

    //Pie de pagina
    function Footer(){
        //Posicion: a 1.5 cm del final
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Arial','I',8);
        //Numero de Ipagina
        $fecha = date('d-m-Y h:i:s');
        $this->Cell(0,10,'Pagina ' . $this->PageNo().'/{nb}'." "."|| Hora y fecha de descarga"." ".$fecha,0,0,'C');
    }
}
?>