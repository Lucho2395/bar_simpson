<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 09/10/2020
 * Time: 12:25
 */
//Clase para Limpieza y Tratamiento de Datos
//Creada Por: César José Ruiz
class Validar{
    public function __construct(){}
    //Función única para validar la integridad de un parametro
    //$parametro = Nombre del parametro
    //$forma_envio = Si fue enviado por GET, POST o FILES
    //$vacio = true para validar si el parametro esta vacio, false para ignorar esa validacion
    //$ok = valor de la anterior validacion (si es false, no se valida nada)
    //$tamanho_maximo = Numero de caracteres maximo del parametro
    //$tipo de parametro = Para indicar si es texto, solo_texto, numero, email, fecha o archivo
    //$tipo_validacion = Subindicador del tipo de parametro (ej: archivo tiene tipo de archivos)
    public function validar_parametro($parametro, $forma_envio, $vacio, $ok, $tamanho_maximo, $tipo_parametro, $tipo_validacion = 0){
        //Verificamos si las validaciones siguen en pie o están caidas
        if($ok){
            //Primero hay que validar si está declarado el $parametro como $_POST o $_GET
            switch ($forma_envio){
                //De ahí, ver si la variable existe y si esta declarada
                case 'GET':
                    if(isset($_GET[$parametro])){
                        //Luego hay que limpiar el $parametro según el $tipo_parametro especificado
                        //Finalmente, validar si $parametro coincide con el las validaciones de $vacio, $tamanho_maximo y $tipo_parametro
                        //($tipo_validacion se usa en caso de que el $tipo_parametro tenga varias validaciones, como en el caso de fecha)
                        switch ($tipo_parametro){
                            case 'texto':
                                $_GET[$parametro] = $this->limpiar_string($_GET[$parametro]);
                                return $this->validar_texto($_GET[$parametro],$vacio,$tamanho_maximo);
                            case 'solo_texto':
                                $_GET[$parametro] = $this->limpiar_string($_GET[$parametro]);
                                return $this->validar_solo_texto($_GET[$parametro],$vacio,$tamanho_maximo);
                            case 'email':
                                $_GET[$parametro] = $this->limpiar_string($_GET[$parametro]);
                                return $this->validar_email($_GET[$parametro],$vacio,$tamanho_maximo);
                            case 'fecha':
                                $_GET[$parametro] = $this->limpiar_string($_GET[$parametro]);
                                return $this->validar_fechas($_GET[$parametro],$vacio,$tamanho_maximo, $tipo_validacion);
                            case 'numero':
                                if($tipo_validacion == 1){
                                    $_GET[$parametro] = $this->limpiar_float($_GET[$parametro]);
                                } else {
                                    $_GET[$parametro] = $this->limpiar_int($_GET[$parametro]);
                                }
                                return $this->validar_numeros($_GET[$parametro],$vacio,$tamanho_maximo);
                        }
                    } else {
                        if($vacio){
                            return true;
                        } else {
                            return false;
                        }
                    }
                    break;
                case 'POST':
                    if(isset($_POST[$parametro])){
                        //Luego hay que limpiar el $parametro según el $tipo_parametro especificado
                        //Finalmente, validar si $parametro coincide con el las validaciones de $vacio, $tamanho_maximo y $tipo_parametro
                        //($tipo_validacion se usa en caso de que el $tipo_parametro tenga varias validaciones, como en el caso de fecha)
                        switch ($tipo_parametro){
                            case 'texto':
                                $_POST[$parametro] = $this->limpiar_string($_POST[$parametro]);
                                return $this->validar_texto($_POST[$parametro],$vacio,$tamanho_maximo);
                            case 'solo_texto':
                                $_POST[$parametro] = $this->limpiar_string($_POST[$parametro]);
                                return $this->validar_solo_texto($_POST[$parametro],$vacio,$tamanho_maximo);
                            case 'email':
                                $_POST[$parametro] = $this->limpiar_string($_POST[$parametro]);
                                return $this->validar_email($_POST[$parametro],$vacio,$tamanho_maximo);
                            case 'fecha':
                                $_POST[$parametro] = $this->limpiar_string($_POST[$parametro]);
                                return $this->validar_fechas($_POST[$parametro],$vacio,$tamanho_maximo,$tipo_validacion);
                            case 'numero':
                                if($tipo_validacion == 1){
                                    $_POST[$parametro] = $this->limpiar_float($_POST[$parametro]);
                                } else {
                                    $_POST[$parametro] = $this->limpiar_int($_POST[$parametro]);
                                }
                                return $this->validar_numeros($_POST[$parametro],$vacio,$tamanho_maximo);
                        }
                    } else {
                        if($vacio){
                            return true;
                        } else {
                            return false;
                        }
                    }
                    break;
                case 'FILES':
                    if(isset($_FILES[$parametro])){
                        //Validar si $parametro coincide con el las validaciones de $vacio, $tamanho_maximo y $tipo_parametro
                        //($tipo_validacion se usa en caso de que el $tipo_parametro tenga varias validaciones, como en el caso de fecha)
                        return $this->validar_archivo($parametro, $vacio, $tipo_validacion);
                    } else {
                        if($vacio){
                            return true;
                        } else {
                            return false;
                        }
                    }
                default:
                    return false;
                    break;
            }
        } else {
            return false;
        }
    }
    //Limpieza de Variables Tipo String para evitar ataques XSS
    function limpiar_string($value){
        try{
            $value = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
        } catch (Exception $e){
            $value = "";
        }
        return $value;
    }
    //Limpieza de Variables Tipo Int para evitar ataques XSS
    function limpiar_int($value){
        try{
            $value = filter_var(filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS), FILTER_SANITIZE_NUMBER_INT);
        } catch (Exception $e){
            $value = "";
        }
        return $value;
    }
    //Limpieza de Variables Tipo Int para evitar ataques XSS
    function limpiar_float($value){
        try{
            $value = filter_var(filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        } catch (Exception $e){
            $value = "";
        }
        return $value;
    }
    //Funciones para Validar la Correcta Estructura de una Variable

    //validar_texto (Valida si el dato cumple con la estructura indicada)
    //$valor = La cadena de texto a validar
    //$vacio = Indica si se debe validar si la cadena está vacia o no
    //$tamaho = Indica la longitud máxima que debe tener la variable
    function validar_texto($valor, $vacio, $tamaho){
        try{
            if($vacio){
                //Si $vacio es true, validará el valor de la cadena
                if(!empty($valor)){
                    //Acá validamos que la cadena tenga el tamaño correcto
                    if(strlen($valor) <= $tamaho){
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                //Acá validamos que la cadena tenga el tamaño correcto
                if(strlen($valor) <= $tamaho){
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e){
            return false;
        }
    }
    //validar_solo_texto (Valida si el dato cumple con la estructura indicada y Que Sólo Tenga Texto)
    //$valor = La cadena de texto a validar
    //$vacio = Indica si se debe validar si la cadena está vacia o no
    //$tamanho = Indica la longitud máxima que debe tener la variable
    function validar_solo_texto($valor, $vacio, $tamanho){
        try{
            if($vacio){
                //Si $valor es true, validará que la cadena no este vacia
                if(!empty($valor)){
                    //Validamos que $valor tenga el tamaño correcto
                    if(strlen($valor) <= $tamanho){
                        //$patron = '/^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/';
                        //Función que valida que sólo se haya texto.
                        $patron = '/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*$/';
                        if(preg_match($patron,$valor)){
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                //Validamos que $valor tenga el tamaño correcto
                if(strlen($valor) <= $tamanho){
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e){
            return false;
        }
    }
    //validar_fechas (Valida que el texto ingresado tenga el forma de fecha correcto)
    //$valor = La cadena de texto a validar
    //$vacio = Indica si se debe validar si la cadena está vacia o no
    //$tamanho = Indica la longitud máxima que debe tener la variable
    //$tipo = Indica el tipo de fecha a validar (1: Fecha, 2: Fecha y Hora)
    function validar_fechas($valor, $vacio, $tamanho, $tipo){
        try{
            if($vacio){
                //Si $vacio es true, se validará que $valor no este $vacio
                if(!empty($valor)){
                    //Validamos que $valor tenga el tamaño correcto
                    //yyyy-mm-dd = 10 caracteres
                    //yyyy-mm-dd hh:mm:ss = 19 caracteres
                    if(strlen($valor) <= $tamanho){
                        //$patron = '/^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/';
                        switch ($tipo){
                            case 'fecha':
                                //Fecha: dd/mm/yyyy o dd-mm-yyyy
                                //$patron = '/^([0-2][0-9]|3[0-1])(\/|-)(0[1-9]|1[0-2])\2(\d{4})$/';
                                $patron = '/^(19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01])$/';
                                break;
                            case 'fecha-hora':
                                //Fecha, hora, minutos y segundos: dd/mm/yyyy hh:mm:ss o dd-mm-yyyy hh:mm:ss
                                //$patron = '/^([0-2][0-9]|3[0-1])(\/|-)(0[1-9]|1[0-2])\2(\d{4})(\s)([0-1][0-9]|2[0-3])(:)([0-5][0-9])(:)([0-5][0-9])$/';
                                $patron = '/^(19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01])(\s)([0-1][0-9]|2[0-3])(:)([0-5][0-9])(:)([0-5][0-9])$/';
                                break;
                            default:
                                return false;
                        }
                        if(preg_match($patron,$valor)){
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                //Validamos que $valor tenga el tamaño correcto
                if(strlen($valor) <= $tamanho){
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e){
            return false;
        }
    }
    //validar_numeros (Valida que el texto ingresado sea un número)
    //$valor = La cadena de texto a validar
    //$vacio = Indica si se debe validar si la cadena está vacia o no
    //$tamanho = Indica la longitud máxima que debe tener la variable
    function validar_numeros($valor, $vacio, $tamanho){
        try{
            if($vacio){
                //Si $vacio es true, validará que $valor no este vacio
                if($valor != ""){
                    //Validamos que $valor tenga el tamaño correcto
                    if(strlen($valor) <= $tamanho){
                        //Validamos que $valor sea numerico
                        return $this->es_numero($valor);
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                //Validamos que $valor tenga el tamaño correcto
                if(strlen($valor) <= $tamanho){
                    if(strlen($valor) > 0){
                        //Validamos que $valor sea numerico
                        return is_numeric($valor);
                    } else {
                        return true;
                    }
                } else {
                    return false;
                }
            }
        } catch (Exception $e){
            return false;
        }
    }
    //validar_email (Valida que el texto ingresado sea un correo)
    //$valor = La cadena de texto a validar
    //$vacio = Indica si se debe validar si la cadena está vacia o no
    //$tamanho = Indica la longitud máxima que debe tener la variable
    function validar_email($valor, $vacio, $tamanho){
        try{
            if($vacio){
                //Si $vacio es true, validará que $valor no este vacio
                if(!empty($valor)){
                    //Validamos que $valor tenga el tamaño correcto
                    if(strlen($valor) <= $tamanho){
                        //Validamos que $valor tenga el valor correcto para email
                        if(filter_var($valor, FILTER_VALIDATE_EMAIL) !== false){
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                //Validamos que $valor tenga el tamaño correcto
                if(strlen($valor) <= $tamanho){
                    //Validamos que $valor tenga el valor correcto para email
                    if(strlen($valor) > 0){
                        if(filter_var($valor, FILTER_VALIDATE_EMAIL) !== false){
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return true;
                    }
                } else {
                    return false;
                }
            }
        } catch (Exception $e){
            return false;
        }
    }
    //validar_archivo (Valida que el archivo ingresado sea el formato deseado)
    //$valor = El archivo a validar
    //$tipo = Tipo de Archivo (pdf, word, excel, jpg, png)
    //Se puede modificar la función para que acepte más valores
    function validar_archivo($valor, $vacio, $tipo){
        try{
            //Validamos que el archivo tenga tamaño
            if($_FILES[$valor]['size'] > 0){
                $ext = strtolower(pathinfo($_FILES[$valor]['name'], PATHINFO_EXTENSION));
                //Valimos que el archivo tenga la correcta extension
                foreach ($tipo as $t){
                    switch ($t){
                        case 'pdf':
                            //Archivos PDF
                            if($ext == 'pdf'){ return true; } break;
                        case 'word':
                            //Archivos Word
                            if($ext == 'doc' || $ext == 'docx'){ return true; } break;
                        case 'excel':
                            //Archivos Excel
                            if($ext == 'xls' || $ext == 'xlsx'){ return true; } break;
                        case 'jpg':
                            //Archivos JPG
                            if($ext == 'jpg' || $ext == 'jpeg'){ return true; } break;
                        case 'png':
                            //Archivos PNG
                            if($ext == 'png'){ return true; } break;
                        default:
                            return false;
                    }
                }
                return false;
            } else {
                if($vacio){
                    return false;
                } else {
                    return true;
                }
            }
        } catch (Exception $e){
            return false;
        }
    }
    //Función para validar si es un numero o no
    function es_numero($var)
    {
        if ($var == (string) (float) $var) {
            return (bool) is_numeric($var);
        }
        if ($var >= 0 && is_string($var) && !is_float($var)) {
            return (bool) ctype_digit($var);
        }
        return (bool) is_numeric($var);
    }
}
