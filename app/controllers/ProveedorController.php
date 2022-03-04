<?php
/**
 * Created by PhpStorm.
 * User: KEVIN
 * Date: 3/03/2021
 * Time: 11:54
 */
require 'app/models/Proveedor.php';
require 'app/models/Menu.php';
require 'app/models/Recursos.php';
require 'app/models/Cliente.php';
class ProveedorController{
    //Variables especificas del controlador
    private $proveedor;
    private $recursos;
    private $cliente;
    //Variables fijas para cada llamada al controlador
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $nav;
    public function __construct()
    {
        //Instancias especificas del controlador
        $this->proveedor = new Proveedor();
        $this->recursos = new Recursos();
        $this->cliente = new Cliente();
        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
    }

    //Vista de Inicio de La Gestión de Menús
    public function inicio()
    {
        try {
            //Llamamos a la clase del Navbar, que sólo se usa
            // en funciones para llamar vistas y la instaciamos
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'], _FULL_KEY_));
            //Traemos los menus registrados
            $proveedor = $this->proveedor->listar_proveedores();
            $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
            $tipos_documento = $this->cliente->listar_tipos_documentos();
            $negocio = $this->recursos->listar_negocios_();
            //Hacemos el require de los archivos a usar en las vistas
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'proveedor/inicio.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
    }

    //Funciones
    //Agregar Nuevo Proveedor
    public function guardar_nuevo_proveedor()
    {
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('proveedor_nombre', 'POST', true, $ok_data, 200, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('proveedor_ruc', 'POST', true, $ok_data, 11, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('proveedor_direccion', 'POST', false, $ok_data, 200, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('proveedor_numero', 'POST', false, $ok_data, 9, 'texto', 0);
            //Validacion de datos
            if ($ok_data) {
                //Creamos el modelo y ingresamos los datos a guardar
                $model = new Proveedor();
                //Validamos la duplicidad del $_POST['proveedor_nombre'], para evitar duplicados
                if ($this->proveedor->validar_nombreproveedor(str_replace(" ", "", $_POST['proveedor_nombre']))) {
                    //Código 3: Controlador duplicado
                    $result = 3;
                    $message = "Ya existe un proveedor con este nombre registrado";
                } else {
                    if ($this->proveedor->validar_rucproveedor($_POST['proveedor_ruc'])) {
                        //Código 3: Controlador duplicado
                        $result = 4;
                        $message = "Ya existe un proveedor con este ruc registrado";
                    } else {
                        $microtime = microtime(true);
                        $model->id_negocio = $_POST['id_negocio'];
                        $model->id_tipodocumento = $_POST['id_tipodocumento'];
                        $model->proveedor_nombre = $_POST['proveedor_nombre'];
                        $model->proveedor_ruc = $_POST['proveedor_ruc'];
                        $model->proveedor_direccion = $_POST['proveedor_direccion'];
                        $model->proveedor_nombre_contacto = $_POST['proveedor_nombre_contacto'];
                        $model->proveedor_cargo_persona = $_POST['proveedor_cargo_persona'];
                        $model->proveedor_numero = $_POST['proveedor_numero'];
                        $model->proveedor_estado = 1;
                        $model->proveedor_codigo = $microtime;
                        //Guardamos el menú y recibimos el resultado
                        $result = $this->proveedor->guardar_proveedor($model);
                    }
                }
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    //Funcion usada para guardar la edicion del proveedor
    public function guardar_edicion_proveedor()
    {
        //Infomación del proveedor
        $proveedor = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('proveedor_nombre_e', 'POST', true, $ok_data, 200, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('proveedor_ruc_e', 'POST', true, $ok_data, 11, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('proveedor_direccion_e', 'POST', true, $ok_data, 200, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('proveedor_numero_e', 'POST', true, $ok_data, 9, 'texto', 0);
            //Validamos el id_menu y menu_estado, en caso este sea declarado para editar proveedor
            $ok_data = $this->validar->validar_parametro('id_proveedor', 'POST', true, $ok_data, 11, 'numero', 0);
            //Validacion de datos
            if ($ok_data) {
                //Creamos el modelo y ingresamos los datos a guardar
                $model = new Proveedor();
                //Validamos la duplicidad del $_POST['rol_nombre'], para evitar duplicados
                if ($this->proveedor->validar_proveedor_edicion(str_replace(" ", "", $_POST['proveedor_nombre_e']), $_POST['id_proveedor'])) {
                    //Código 3: Controlador duplicado
                    $result = 3;
                    $message = "Ya existe un proveedor con este nombre registrado";
                } else {
                    if ($this->proveedor->validar_rucproveedor_edicion($_POST['proveedor_ruc_e'], $_POST['id_proveedor'])) {
                        //Código 3: Controlador duplicado
                        $result = 4;
                        $message = "Ya existe un proveedor registrado con este ruc";
                    } else {
                        $proveedor = $this->proveedor->listar_proveedor($_POST['id_proveedor']);
                        $model->id_proveedor = $_POST['id_proveedor'];
                        $model->id_tipodocumento = $_POST['id_tipodocumento_e'];
                        $model->proveedor_nombre = $_POST['proveedor_nombre_e'];
                        $model->proveedor_ruc = $_POST['proveedor_ruc_e'];
                        $model->id_negocio = $_POST['id_negocio_e'];
                        $model->proveedor_direccion = $_POST['proveedor_direccion_e'];
                        $model->proveedor_cargo_persona = $_POST['proveedor_cargo_persona_e'];
                        $model->proveedor_nombre_contacto = $_POST['proveedor_nombre_contacto_e'];
                        $model->proveedor_numero = $_POST['proveedor_numero_e'];
                        $model->proveedor_estado = $_POST['proveedor_estado_e'];
                        $result = $this->proveedor->guardar_proveedor($model);

                    }
                }
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "proveedor" => $proveedor)));
    }

    //Funcion para Eliminar proveedor
    public function eliminar_proveedor()
    {
        //Array donde vamos a almacenar los cambios, en caso hagamos alguno
        $proveedor = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_proveedor', 'POST', true, $ok_data, 11, 'numero', 0);
            //Validacion de datos
            if ($ok_data) {
                //Eliminamos el proveedor

                $result = $this->proveedor->eliminar_proveedor($_POST['id_proveedor']);
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "proveedor" => $proveedor)));
    }
    public function obtener_datos_x_dni(){
        //Array donde vamos a recetar los cambios, en caso hagamos alguno
        $cliente = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            $dni = $_POST['numero_dni'];
            /*$ws = "https://dni.optimizeperu.com/api/persons/$dni?format=json";

            $header = array();

            $ch = curl_init();
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,1);
            curl_setopt($ch,CURLOPT_URL,$ws);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch,CURLOPT_HTTPAUTH,CURLAUTH_ANY);
            curl_setopt($ch,CURLOPT_TIMEOUT,30);
            curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
            //para ejecutar los procesos de forma local en windows
            //enlace de descarga del cacert.pem https://curl.haxx.se/docs/caextract.html
            curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__)."/../models/cacert.pem");

            $datos = curl_exec($ch);
            curl_close($ch);
            $datos = json_decode($datos);*/
            $result = json_decode(file_get_contents('https://consultaruc.win/api/dni/'.$dni),true);


            //var_dump($result);

            $dni	= $result['result']['DNI'];
            $nombre = $result['result']['Nombre'];
            $paterno = $result['result']['Paterno'];
            $materno = $result['result']['Materno'];
            //echo $result['result']['estado'];

            $datos = array(
                'dni' => $dni,
                'name' => $nombre,
                'first_name' => $paterno,
                'last_name' => $materno,
            );

            //$datos = json_decode($datos);

        } catch (Exception $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => $datos));
    }

    public function obtener_datos_x_ruc(){
        //Array donde vamos a recetar los cambios, en caso hagamos alguno
        $cliente = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            $ruc = $_POST['numero_ruc'];
            $result = json_decode(file_get_contents('https://consultaruc.win/api/ruc/'.$ruc),true);
            $datos = array(
                'razon_social' => $result['result']['razon_social'],
                'estado' => $result['result']['estado'],
                'condicion' => $result['result']['condicion'],
            );

        } catch (Exception $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
            $result= [];
        }
        //Retornamos el json
        echo json_encode(array("result" => $datos));
    }


}