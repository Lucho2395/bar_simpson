<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 09/10/2020
 * Time: 12:08
 */
class Log{
    public function __construct()
    {
        //Ruta de carpeta(Con año)
        $this->ruta     = "log/" . date("Y");
        //Ruta de carpeta(Con año y mes)
        $this->ruta_completa = $this->ruta  . "/" . date("m") ;
        //Nonbre del archivo
        $this->nombre_archivo = "log-";
        //Fecha actual
        $this->fecha     = date("Y-m-d");
        //Hora actual
        $this->hora     = date('H:i:s');
        //IP donde se registra el error
        $this->ip       = ($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 0;
    }

    //Funcion para insertar texto en el archivo de log del dia
    public function insertar($texto, $ubicacion)
    {
        //Crea la linea de texto que se va a insertar en el archivo
        $log    = $this->fecha . " " . $this->hora . "[UTC -5] [ip] " . $this->ip . " [lugar] " . $ubicacion . " [texto] " . $texto . PHP_EOL;
        //If para verificar si la carpeta año y mes indicados existen
        if(is_dir($this->ruta_completa)){
            //Si existen, file_put_contents ingresa la informacion sobre el archivo del dia, y si no existe, lo crea
            $result = (file_put_contents($this->ruta_completa . "/" . $this->nombre_archivo . $this->fecha . ".txt", $log, FILE_APPEND)) ? 1 : 0;
        } else {
            //Si no existe el directorio completo, verifica si la carpeta del año correspondiente
            if(is_dir($this->ruta)){
                //Si existe, crea la carpeta del mes correspondiente, crea el archivo del dia y ingresa la información
                mkdir($this->ruta_completa, 0700);
                $result = (file_put_contents($this->ruta_completa . "/" . $this->nombre_archivo . $this->fecha . ".txt", $log, FILE_APPEND)) ? 1 : 0;
            } else {
                //Si no existe la carpeta del año, crea la carpeta del año correspondiente, del mes, el archivo del dia y ingresa la información
                mkdir($this->ruta, 0700);
                mkdir($this->ruta_completa, 0700);
                $result = (file_put_contents($this->ruta_completa . "/" . $this->nombre_archivo . $this->fecha . ".txt", $log, FILE_APPEND)) ? 1 : 0;
            }
        }
        return $result;
    }
}
