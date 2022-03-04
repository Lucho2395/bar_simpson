<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 29/10/2020
 * Time: 22:30
 */
class Archivo{
    private $log;
    public function __construct()
    {
        $this->log = new Log();
    }

    /**
     * Funcion para redimensionar imagenes
     *
     * @param string $origen Imagen origen en el disco duro ($_FILES["image1"]["tmp_name"])
     * @param string $destino Imagen destino en el disco duro ($destino = tempnam("tmp/","tmp");)
     * @return boolean true = Se ha redimensionada|false = La imagen es mas pequeña que el nuevo tamaño
     */

    /*integer $acbo Anchura máxima de la nueva imagen
    integer $alto Altura máxima de la nueva imagen
    integer $calidad (opcional) Calidad para la imagen jpg*/
    function subir_imagen_comprimida($origen, $destino, $guardar_temporal, $ancho = 850, $alto = 850, $calidad = 100)
    {
        try {
            // getimagesize devuelve un array con: anchura,altura,tipo,cadena de
            // texto con el valor correcto height="yyy" width="xxx"
            $datos = getimagesize($origen);

            // comprobamos que la imagen sea superior a los tamaños de la nueva imagen
            if($datos[0]>$ancho || $datos[1]>$alto)
            {
                // creamos una nueva imagen desde el original dependiendo del tipo
                if($datos[2] == 1)
                    $img = imagecreatefromgif($origen);
                if($datos[2] == 2)
                    $img = imagecreatefromjpeg($origen);
                if($datos[2] == 3)
                    $img = imagecreatefrompng($origen);

                // Redimensionamos proporcionalmente
                if(rad2deg(atan($datos[0] / $datos[1])) > rad2deg(atan($ancho/$alto)))
                {
                    $anchura=$ancho;
                    $altura=round(($datos[1] * $ancho)/$datos[0]);
                }else{
                    $altura=$alto;
                    $anchura=round(($datos[0] * $alto)/$datos[1]);
                }

                // creamos la imagen nueva
                $newImage = imagecreatetruecolor($anchura,$altura);

                // redimensiona la imagen original copiandola en la imagen
                imagecopyresampled($newImage, $img, 0, 0, 0, 0, $anchura, $altura, $datos[0], $datos[1]);

                // guardar la nueva imagen redimensionada donde indicia $destino
                if($datos[2]==1)
                    imagegif($newImage ,$destino);
                if($datos[2]==2)
                    imagejpeg($newImage ,$destino ,$calidad);
                if($datos[2]==3)
                    imagepng($newImage ,$destino);

                // eliminamos la imagen temporal
                imagedestroy($newImage);

                // Si savet es "true", elimina la imagen original
                if(!$guardar_temporal){
                    unlink($origen);
                }
                return true;
            } else {
                return move_uploaded_file($origen,$destino);
            }
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return false;
        }
    }
}
