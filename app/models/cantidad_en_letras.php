<?php
/**
 * Created by PhpStorm
 * User: LuisSalazar
 * Date: 23/04/2021
 * Time: 12:54 p. m.
 */

function CantidadEnLetra($tyCantidad){
    $enLetras = new EnLetras;
    return $enLetras->ValorEnLetras($tyCantidad,"SOLES");
}

class EnLetras
{
    var $Void = "";
    var $SP = " ";
    var $Dot = ".";
    var $Zero = "0";
    var $Neg = "Menos";

    function ValorEnLetras($x, $Moneda )
    {
        $s="";
        $Ent="";
        $Frc="";
        $Signo="";

        if(floatVal($x) < 0)
            $Signo = $this->Neg . " ";
        else
            $Signo = "";

        if(intval(number_format($x,2,'.','') )!=$x) //<- averiguar si tiene decimales
            $s = number_format($x,2,'.','');
        else
            $s = number_format($x,2,'.','');

        $Pto = strpos($s, $this->Dot);

        if ($Pto === false)
        {
            $Ent = $s;
            $Frc = $this->Void;
        }
        else
        {
            $Ent = substr($s, 0, $Pto );
            $Frc =  substr($s, $Pto+1);
        }

        if($Ent == $this->Zero || $Ent == $this->Void)
            $s = "CERO ";
        elseif( strlen($Ent) > 7)
        {
            $s = $this->SubValLetra(intval( substr($Ent, 0,  strlen($Ent) - 6))) .
                "MILLONES " . $this->SubValLetra(intval(substr($Ent,-6, 6)));
        }
        else
        {
            $s = $this->SubValLetra(intval($Ent));
        }

        if (substr($s,-9, 9) == "MILLONES " || substr($s,-7, 7) == "MILLÓN ")
            $s = $s . "DE ";

        $s = $s ;

        if($Frc != $this->Void)
        {
            $s = $s . " CON " . $Frc. "/100";
            //$s = $s . " " . $Frc . "/100";
        }
        $letrass=$Signo . $s ." ".$Moneda;
        return ($Signo . $s ." ".$Moneda);

    }


    function SubValLetra($numero)
    {
        $Ptr="";
        $n=0;
        $i=0;
        $x ="";
        $Rtn ="";
        $Tem ="";

        $x = trim("$numero");
        $n = strlen($x);

        $Tem = $this->Void;
        $i = $n;

        while( $i > 0)
        {
            $Tem = $this->Parte(intval(substr($x, $n - $i, 1).
                str_repeat($this->Zero, $i - 1 )));
            If( $Tem != "CERO" )
                $Rtn .= $Tem . $this->SP;
            $i = $i - 1;
        }


        //--------------------- GoSub FiltroMil ------------------------------
        $Rtn=str_replace(" MIL MIL", " UN MIL", $Rtn );
        while(1)
        {
            $Ptr = strpos($Rtn, "MIL ");
            If(!($Ptr===false))
            {
                If(! (strpos($Rtn, "MIL ",$Ptr + 1) === false ))
                    $this->ReplaceStringFrom($Rtn, "MIL ", "", $Ptr);
                Else
                    break;
            }
            else break;
        }

        //--------------------- GoSub FiltroCiento ------------------------------
        $Ptr = -1;
        do{
            $Ptr = strpos($Rtn, "CIEN ", $Ptr+1);
            if(!($Ptr===false))
            {
                $Tem = substr($Rtn, $Ptr + 5 ,1);
                if( $Tem == "M" || $Tem == $this->Void)
                    ;
                else
                    $this->ReplaceStringFrom($Rtn, "CIEN", "CIENTO", $Ptr);
            }
        }while(!($Ptr === false));

        //--------------------- FiltroEspeciales ------------------------------
        $Rtn=str_replace("DIEZ UNO", "ONCE", $Rtn );
        $Rtn=str_replace("DIEZ UNO", "ONCE", $Rtn );
        $Rtn=str_replace("DIEZ DOS", "DOCE", $Rtn );
        $Rtn=str_replace("DIEZ TRES", "TRECE", $Rtn );
        $Rtn=str_replace("DIEZ CUATRO", "CATORCE", $Rtn );
        $Rtn=str_replace("DIEZ CINCO", "QINCE", $Rtn );
        $Rtn=str_replace("DIEZ SEIS", "DIECISEIS", $Rtn );
        $Rtn=str_replace("DIEZ SIETE", "DIECISIETE", $Rtn );
        $Rtn=str_replace("DIEZ OCHO", "DIECIOCHO", $Rtn );
        $Rtn=str_replace("DIEZ NUEVE", "DIECINUEVE", $Rtn );
        $Rtn=str_replace("VEINTE UN", "VEINTIUN", $Rtn );
        $Rtn=str_replace("VEINTE DOS", "VEINTIDOS", $Rtn );
        $Rtn=str_replace("VEINTE TRES", "VEINTITRES", $Rtn );
        $Rtn=str_replace("VEINTE CUATRO", "VEINTICUATRO", $Rtn );
        $Rtn=str_replace("VEINTE CINCO", "VEINTICINCO", $Rtn );
        $Rtn=str_replace("VEINTE SEIS", "VEINTISEIS", $Rtn );
        $Rtn=str_replace("VEINTE SIETE", "VEINTISIETE", $Rtn );
        $Rtn=str_replace("VEINTE OCHO", "VEINTIOCHO", $Rtn );
        $Rtn=str_replace("VEINTE NUEVE", "VEINTINUEVE", $Rtn );

        //--------------------- FiltroUn ------------------------------
        If(substr($Rtn,0,1) == "M") $Rtn = " " . $Rtn;
        //--------------------- Adicionar Y ------------------------------
        for($i=65; $i<=88; $i++)
        {
            If($i != 77)
                $Rtn=str_replace("A " . Chr($i), "* Y " . Chr($i), $Rtn);
        }
        $Rtn=str_replace("*", "A" , $Rtn);
        return($Rtn);
    }


    function ReplaceStringFrom(&$x, $OldWrd, $NewWrd, $Ptr)
    {
        $x = substr($x, 0, $Ptr)  . $NewWrd . substr($x, strlen($OldWrd) + $Ptr);
    }


    function Parte($x)
    {
        $Rtn='';
        $t='';
        $i='';
        Do
        {
            switch($x)
            {
                Case 0:  $t = "CERO";break;
                Case 1:  $t = "UNO";break;
                Case 2:  $t = "DOS";break;
                Case 3:  $t = "TRES";break;
                Case 4:  $t = "CUATRO";break;
                Case 5:  $t = "CINCO";break;
                Case 6:  $t = "SEIS";break;
                Case 7:  $t = "SIETE";break;
                Case 8:  $t = "OCHO";break;
                Case 9:  $t = "NUEVE";break;
                Case 10: $t = "DIEZ";break;
                Case 20: $t = "VEINTE";break;
                Case 30: $t = "TREINTA";break;
                Case 40: $t = "CUARENTA";break;
                Case 50: $t = "CINCUENTA";break;
                Case 60: $t = "SESENTA";break;
                Case 70: $t = "SETENTA";break;
                Case 80: $t = "OCHENTA";break;
                Case 90: $t = "NOVENTA";break;
                Case 100: $t = "CIEN";break;
                Case 200: $t = "DOSCIENTOS";break;
                Case 300: $t = "TRESCIENTOS";break;
                Case 400: $t = "CUATROCIENTOS";break;
                Case 500: $t = "QUINIENTOS";break;
                Case 600: $t = "SEISCIENTOS";break;
                Case 700: $t = "SETECIENTOS";break;
                Case 800: $t = "OCHOCIENTOS";break;
                Case 900: $t = "NOVECIENTOS";break;
                Case 1000: $t = "MIL";break;
                Case 1000000: $t = "MILLÓN";break;
            }

            If($t == $this->Void)
            {
                $i = $i + 1;
                $x = $x / 1000;
                If($x== 0) $i = 0;
            }
            else
                break;

        }while($i != 0);

        $Rtn = $t;
        Switch($i)
        {
            Case 0: $t = $this->Void;break;
            Case 1: $t = " MIL";break;
            Case 2: $t = " MILLONES";break;
            Case 3: $t = " BILLONES";break;
        }
        return($Rtn . $t);
    }

}