<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 17/09/2020
 * Time: 18:08
 */
class Encriptar{
    function __construct()
    {

    }
    //Funcion que se encarga de ENCRIPTAR el texto entrante
    public function encriptar($string, $key) {
        $result = '';
        //Recorremos todo el string recibido
        for($i=0; $i < strlen($string); $i++) {
            //Extraemos el caracter del string que vamos a encriptar
            $char = substr($string, $i, 1);
            //Extraemos un caracter de nuestra llave
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            //Convertirmos $char y $keychar a un valor entre 0 y 255, y luego lo sumamos
            //para obtener un valor que usaremos con la funcion chr para obtener un valor ASCII especifico
            $char = chr(ord($char) + ord($keychar));
            //Aumentamos el valor de $char a nuestro result
            $result .= $char;
        }
        //Codificamos la cadena a base64 y la devolvemos
        return base64_encode($result);
    }
    //Funcion que se encarga de DESENCRIPTAR el texto entrante
    public function desencriptar($string, $key) {
        $result = '';
        //Verificamos que el string no este nulo
        if(!empty($string)){
            //Decodificamos el string que recibimos
            $string = base64_decode($string);
            //Recorremos todo el string decodificado
            for($i=0; $i<strlen($string); $i++) {
                //Extraemos un caracter de nuestro string
                $char = substr($string, $i, 1);
                //Extraemos un caracter de nuestra llave
                $keychar = substr($key, ($i % strlen($key)) - 1, 1);
                //Convertirmos $char y $keychar a un valor entre 0 y 255 inverso a la encriptacion, y luego lo sumamos
                //para obtener un valor que usaremos con la funcion chr para obtener un valor ASCII especifico
                $char = chr(ord($char)-ord($keychar));
                //Aumentamos el valor de $char a nuestro result
                $result .= $char;
            }
        }
        //Devolvemos la cadena obtenida
        return $result;
    }
    //Encriptacion triple de datos para creacion de tokens de usuarios
    public function encriptacion_triple($contrasenha, $usuario, $fecha){
        //Hacemos una encriptacion de la contraseña
        //Unimos la contraseña encriptada con el usuario
        //Encriptamos la contraseña con el código del usuario
        //Me achoré y lo hice en una linea
        return $this->encriptar($usuario . '|' . $this->encriptar(password_hash($contrasenha, PASSWORD_BCRYPT), $fecha), _FULL_KEY_);
    }
    //Desencriptacion triple de datos para creacion de tokens de usuarios
    public function desencriptacion_triple($hash){
        try{
            //Desencriptamos el hash, lo cual nos debe devolver un array.
            $hash = explode("|", $this->desencriptar($hash, _FULL_KEY_));
            //Validamos que $hash sea un array, caso contrario devolvemos falso
            if(is_array($hash)){
                //Obtenemos el valor entero del indice 0 y si es incorrecto, devolvemos $hash = false
                $int = intval($hash[0]);
                if(!is_int($int) || $int === 0){
                    $hash = false;
                }
            } else {
                $hash = false;
            }
        } catch (Exception $e){
            //Entra aquí si ocurre un error con la desencriptacion y retorna el valor de falso
            $hash = false;
        }
        return $hash;
    }
}