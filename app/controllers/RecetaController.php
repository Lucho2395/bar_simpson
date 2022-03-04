<?php
/**
 * Created by PhpStorm
 * User: Franz
 * Date: 15/03/2021
 * Time: 12:36
 */

require 'app/models/Usuario.php';
require 'app/models/Rol.php';
require 'app/models/Menu.php';
require 'app/models/Archivo.php';
require 'app/models/Receta.php';
require 'app/models/Negocio.php';
require 'app/models/Recursos.php';

class RecetaController{
    private $receta;
    private $detalle_receta;
    private $negocio;
    private $recurso;
    private $sucursal;
    private $usuario;
    private $rol;
    private $archivo;
    //Variables fijas para cada llamada al controlador
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $nav;

    public function __construct()
    {
        //Instancias especificas del controlador
        $this->receta = new Receta();
        $this->detalle_receta = new Receta();
        $this->negocio = new Negocio();
        $this->recurso = new Recursos();
        $this->usuario = new Usuario();
        $this->rol = new Rol();
        $this->archivo = new Archivo();
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
            $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
            $id = $_GET['id'];
            $usuarios = $this->negocio->listar_negocio($id_usuario);
            $usuarios = $this->usuario->listar_usuarios();
            $rol = $this->rol->listar_roles_usuario();
            $recetas = $this->receta->listar_recetas();
            $datos = $this->receta->receta($id);
            //$empresa_registrada = $this->empresa->listar_empresas_modal();
            //Hacemos el require de los archivos a usar en las vistas
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'receta/inicio.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
    }

    //Vista de Inicio de La Gestión de Menús
    public function detalle_receta()
    {
        try {
            //Llamamos a la clase del Navbar, que sólo se usa
            // en funciones para llamar vistas y la instaciamos
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'], _FULL_KEY_));
            $id = $_GET['id'];
            $recursos_sedes = $this->recurso->listar_info_detalle_receta();
            $data_receta = $this->receta->receta($id);
            $recetas = $this->receta->listar();
            $detalle_recetas = $this->receta->listar_detalle_recetas($id);

            $subrecetas = $this->receta->listar_sub_recetas($id);
            $suma = $this->receta->suma_sub_receta($id);
            $listar_total = $this->receta->monto_total_receta($id);
            $total_todo = $suma->total + $listar_total->total;
            $unidad_medida = $this->receta->listar_unidad_medida();
            //Hacemos el require de los archivos a usar en las vistas
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'receta/detalle_receta.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
    }

    //Funciones
    //Agregar Nuevo Receta
    public function guardar_nuevo_receta(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('receta_nombre', 'POST', true, $ok_data, 200, 'texto', 0);
            //$ok_data = $this->validar->validar_parametro('receta_fecha', 'POST',false,$ok_data,100,'fecha','fecha');
            $ok_data = $this->validar->validar_parametro('receta_estado', 'POST', true, $ok_data, 4, 'numero', 0);
            //Validacion de datos
            if($ok_data){
                //Creamos el modelo y ingresamos los datos a guardar
                $model = new Receta();
                //Validamos la duplicidad del $_POST['rol_nombre'], para evitar duplicados
                if($this->receta->validar_receta_nombre(str_replace( " ", "",$_POST['receta_nombre']))){
                    //Código 3: Controlador duplicado
                    $result = 3;
                    $message = "Ya existe una receta con este nombre registrado";
                } else {$microtime = microtime(true);
                    $model->receta_nombre = $_POST['receta_nombre'];
                    //$model->receta_fecha = $_POST['receta_fecha'];
                    $model->receta_estado = $_POST['receta_estado'];
                    $model->id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                    $model->recetacodigo = $microtime;
                    //Guardamos el menú y recibimos el resultado
                    $model->receta_estado = $_POST['receta_estado'];
                    $result = $this->receta->guardar_receta($model);
                }
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    //Funciones
    //Agregar Nuevo Almacen
    public function guardar_nuevo_detalle_receta()
    {
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_receta', 'POST', true, $ok_data, 11, 'numero', 0);
            $ok_data = $this->validar->validar_parametro('id_recursos_sede', 'POST', true, $ok_data, 11, 'numero', 0);
            $ok_data = $this->validar->validar_parametro('detalle_receta_cantidad', 'POST', true, $ok_data, 100, 'texto', 0);

            //Validacion de datos
            if ($ok_data) {
                //Creamos el modelo y ingresamos los datos a guardar
                $model = new Receta();
                $model->id_receta = $_POST['id_receta'];
                $model->id_recursos_sede = $_POST['id_recursos_sede'];
                $model->detalle_receta_unidad_medida = $_POST['valor_conversion'];

                $model->detalle_receta_cantidad = $_POST['detalle_receta_cantidad'];
                $model->detalle_receta_precio = $_POST['detalle_receta_precio'];
                $model->detalle_receta_estado = 1;
                $result = $this->receta->guardar_detalle_receta($model);

            }else {
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

    //FUNCION PARA HACER LA JUGADA DE LA UNIDAD Y DEL PRECIO
    public function listar_unidad_precio(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        try{
            $id_recurso_sede = $_POST['id_recurso_sede'];
            $result = $this->receta->listar_unidad_precio($id_recurso_sede);
            $resultado = $this->receta->listar_conversiones($id_recurso_sede);
            $mostrar_datos="<label>Precio por 1 ".$result->medida_nombre." : ".$result->recurso_sede_precio."</label>
                                 <input type='hidden' id='irs_".$result->id_recurso_sede."' name='id_recurso_sede' value='".$result->recurso_sede_precio."'>";

            $conversion = "<select class='form-control' id='detalle_receta_unidad_medida' name='detalle_receta_unidad_medida'>";
            foreach ($resultado as $c){
                $conversion.="<option value='". $c->conversion_cantidad."-*-*".$c->id_conversion."'>". $c->medida_nombre."</option>";
            }

        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("mostrar_datos" => $mostrar_datos,"conversion" => $conversion));
    }

    public function jalar_valor_preparacion(){
        try{
            $id_receta = $_POST['id_receta'];
            $result = $this->receta->monto_total_receta($id_receta);
            $precio_preparacion="<label>Precio preparacion S/.  ".$result->total."</label>
                                 <input type='hidden' id='idr_".$id_receta."' name='idr_".$id_receta."' value='".$result->total."'>";
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode($precio_preparacion);
    }

    //Funcion usada para guardar la edicion del receta
    public function guardar_edicion_receta(){
        //Infomación del receta
        $receta = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('receta_nombre_e', 'POST', true, $ok_data, 100, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('id_receta', 'POST',false,$ok_data,11,'numero',0);
            //Validacion de datos
            if($ok_data){
                //Creamos el modelo y ingresamos los datos a guardar
                $model = new Receta();
                $receta = $this->receta->listar_receta($_POST['id_receta']);
                $model->id_receta = $_POST['id_receta'];
                $model->receta_nombre = $_POST['receta_nombre_e'];
                $result = $this->receta->guardar_receta($model);
                if($result == 1){
                    $receta = $this->receta->listar_receta($_POST['id_receta']);

                }
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "receta" => $receta)));
    }


    //Funcion usada para guardar la edicion del detalle_receta
    public function guardar_edicion_detalle_receta(){
        //Infomación del detalle_receta
        $detalle_receta = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_receta_e', 'POST', true, $ok_data, 11, 'numero', 0);
            $ok_data = $this->validar->validar_parametro('id_recursos_sede_e', 'POST', true, $ok_data, 11, 'numero', 0);
            $ok_data = $this->validar->validar_parametro('detalle_receta_cantidad_e', 'POST', true, $ok_data, 100, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('detalle_receta_unidad_e', 'POST', true, $ok_data, 100, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('detalle_receta_estado_e', 'POST', true, $ok_data, 4, 'numero', 0);

            //Validamos el id_menu y menu_estado, en caso este sea declarado para editar personas
            $ok_data = $this->validar->validar_parametro('id_detalle_receta', 'POST',false,$ok_data,11,'numero',0);
            //Validacion de datos
            if($ok_data){
                //Creamos el modelo y ingresamos los datos a guardar
                $model = new Receta();
                $detalle_receta = $this->receta->listar_detalle_receta($_POST['id_detalle_receta']);
                $model->id_detalle_receta = $_POST['id_detalle_receta'];
                $model->id_receta = $_POST['id_receta_e'];
                $model->id_recursos_sede = $_POST['id_recursos_sede_e'];
                $model->detalle_receta_cantidad = $_POST['detalle_receta_cantidad_e'];
                $model->detalle_receta_precio = $_POST['detalle_receta_precio_e'];
                $model->detalle_receta_estado = $_POST['detalle_receta_estado_e'];
                $result = $this->receta->guardar_detalle_receta($model);
                if($result == 1){
                    $detalle_receta = $this->receta->listar_detalle_receta($_POST['id_detalle_receta']);

                }
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "detalle_receta" => $detalle_receta)));
    }


    //Funcion para Eliminar receta
    public function eliminar_receta()
    {
        //Array donde vamos a recetar los cambios, en caso hagamos alguno
        $receta = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_receta', 'POST', true, $ok_data, 11, 'numero', 0);
            //Validacion de datos
            if ($ok_data) {
                //Eliminamos el receta

                $result = $this->receta->eliminar_receta($_POST['id_receta']);
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
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "receta" => $receta)));
    }

    //Funcion para Eliminar detalle_receta
    public function eliminar_detalle_receta()
    {
        //Array donde vamos a almacenar los cambios, en caso hagamos alguno
        $receta = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_detalle_receta', 'POST', true, $ok_data, 11, 'numero', 0);
            //Validacion de datos
            if ($ok_data) {
                //Eliminamos el detalle_receta

                $result = $this->receta->eliminar_detalle_receta($_POST['id_detalle_receta']);
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
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "receta" => $receta)));
    }


    public function eliminar_sub_receta(){
        //Array donde vamos a almacenar los cambios, en caso hagamos alguno
        $receta = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_sub_receta', 'POST', true, $ok_data, 11, 'numero', 0);
            //Validacion de datos
            if ($ok_data) {
                //Eliminamos el detalle_receta

                $result = $this->receta->eliminar_sub_receta($_POST['id_sub_receta']);
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
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "receta" => $receta)));
    }

    public function guardar_sub_receta(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validacion de datos
            if($ok_data) {
                $model = new Receta();
                $fecha = date('Y-m-d H:i:s');
                $model->id_medida = 58;
                $model->id_receta = $_POST['receta_principal'];
                $model->id_receta_2 = $_POST['id_receta_'];
                $model->sub_receta_cantidad = $_POST['sub_receta_cantidad'];
                $model->sub_receta_total = $_POST['sub_receta_total'];
                $model->sub_receta_fecha_registro = $fecha;
                $model->sub_receta_estado = 1;

                $result = $this->receta->guardar_sub_receta($model);

            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

}