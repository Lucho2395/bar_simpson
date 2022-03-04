<?php
/**
 * Created by PhpStorm
 * User: Franz
 * Date: 12/03/2021
 * Time: 10:27
 */
require 'app/models/Usuario.php';
require 'app/models/Rol.php';
require 'app/models/Menu.php';
require 'app/models/Archivo.php';
require 'app/models/Almacen.php';
require 'app/models/Negocio.php';
require 'app/models/Recursos.php';
require 'app/models/Insumos.php';
require 'app/models/Categorias.php';
class AlmacenController
{
    private $almacen;
    private $negocio;
    private $sucursal;
    private $usuario;
    private $rol;
    private $archivo;
    private $recursos;
    private $insumos;
    private $categorias;
    //Variables fijas para cada llamada al controlador
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $nav;

    public function __construct()
    {
        //Instancias especificas del controlador
        $this->almacen = new Almacen();
        $this->negocio = new Negocio();
        $this->sucursal = new Negocio();
        $this->usuario = new Usuario();
        $this->rol = new Rol();
        $this->archivo = new Archivo();

        $this->recursos = new Recursos();
        $this->insumos = new Insumos();
        $this->categorias = new Categorias();
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
            //$categorias = $this->categoria->listar_categorias();
            $sucursal = $this->negocio->listar_sucursal($id_usuario);
            $usuario = $this->usuario->listar_usuarios();
            $fecha_filtro = date('Y-m-d');
            $fecha_filtro_fin = date('Y-m-d');

            $fecha_i = date('Y-m-d');
            $fecha_f = date('Y-m-d');
            $datos = false;
            if(isset($_POST['enviar_fecha'])){
                $fecha_i = $_POST['fecha_filtro'];
                $fecha_f = $_POST['fecha_filtro_fin'];

                $fecha_filtro = strtotime($_POST['fecha_filtro']);
                $fecha_filtro_fin = strtotime($_POST['fecha_filtro_fin']);
                $datos = true;
            }
            $productos = $this->almacen->listar_productos_almacen();
            //$empresa_registrada = $this->empresa->listar_empresas_modal();
            //Hacemos el require de los archivos a usar en las vistas
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'almacen/inicio.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
    }

    //nuvas vistas traidas desde Recursos
    public function categorias(){
        try{
            //Llamamos a la clase del Navbar, que sólo se usa
            // en funciones para llamar vistas y la instaciamos
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));

            $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);

            $negocio = $this->recursos->listar_negocios_();
            $categoria = $this->recursos->listar_categorias();
            $nego_cate = $this->recursos->listar_info();
            //Hacemos el require de los archivos a usar en las vistas
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'recursos/gestionar_categorias.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function recursos(){
        try{
            //Llamamos a la clase del Navbar, que sólo se usa
            // en funciones para llamar vistas y la instaciamos
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));

            $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);

            $sucursal = $this->recursos->listar_sucursales_();
            $sucursall = $this->recursos->listar_sucursales_();
            if(isset($_POST['enviar_dato'])){
                $id_sucursal = $_POST['id_sucursal'];
                $recurso_sede = $this->recursos->recursos_por_id_sede($id_sucursal);
                $sucursal_ = $this->recursos->listar_sucursales_xid($id_sucursal);
            }else{
                $recurso_sede = $this->recursos->listar_recursos_sede();
            }
            $categoria = $this->recursos->listar_categorias();

            $unidad_medida = $this->recursos->listar_unidad_medida();
            //Hacemos el require de los archivos a usar en las vistas
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'recursos/gestionar_recursos.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    //Funciones
    //Agregar Nuevo Almacen
    public function guardar_nuevo_almacen()
    {
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_negocio', 'POST', true, $ok_data, 11, 'numero', 0);
            $ok_data = $this->validar->validar_parametro('id_sucursal', 'POST', true, $ok_data, 11, 'numero', 0);
            $ok_data = $this->validar->validar_parametro('almacen_nombre', 'POST', true, $ok_data, 100, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('almacen_capacidad', 'POST', true, $ok_data, 100, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('almacen_estado', 'POST', true, $ok_data, 4, 'numero', 0);

            //Validacion de datos
            if ($ok_data) {
                //Creamos el modelo y ingresamos los datos a guardar
                $model = new Almacen();
                        $microtime = microtime(true);
                        $model->almacen_nombre = $_POST['almacen_nombre'];
                        $model->almacen_capacidad = $_POST['almacen_capacidad'];
                        $model->almacen_estado = $_POST['almacen_estado'];
                        $model->id_negocio = $_POST['id_negocio'];
                        $model->id_sucursal = $_POST['id_sucursal'];
                        $model->almacencodigo = $microtime;
                        //Guardamos el menú y recibimos el resultado
                        $model->almacen_estado = $_POST['almacen_estado'];
                        $result = $this->almacen->guardar_almacen($model);

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

    //Funcion usada para guardar la edicion del almacen
    public function guardar_edicion_almacen(){
        //Infomación del almacen
        $almacen = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_negocio_e', 'POST', true, $ok_data, 11, 'numero', 0);
            $ok_data = $this->validar->validar_parametro('id_sucursal_e', 'POST', true, $ok_data, 11, 'numero', 0);
            $ok_data = $this->validar->validar_parametro('almacen_nombre_e', 'POST', true, $ok_data, 100, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('almacen_capacidad_e', 'POST', true, $ok_data, 100, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('almacen_estado_e', 'POST', true, $ok_data, 4, 'numero', 0);

            //Validamos el id_menu y menu_estado, en caso este sea declarado para editar personas
            $ok_data = $this->validar->validar_parametro('id_almacen', 'POST',false,$ok_data,11,'numero',0);
            //Validacion de datos
            if($ok_data){
                //Creamos el modelo y ingresamos los datos a guardar
                $model = new Almacen();
                        $almacen = $this->almacen->listar_almacen($_POST['id_almacen']);
                        $model->id_almacen = $_POST['id_almacen'];
                        $model->id_negocio = $_POST['id_negocio_e'];
                        $model->id_sucursal = $_POST['id_sucursal_e'];
                        $model->almacen_nombre = $_POST['almacen_nombre_e'];
                        $model->almacen_capacidad = $_POST['almacen_capacidad_e'];
                        $model->almacen_estado = $_POST['almacen_estado_e'];
                        $result = $this->almacen->guardar_almacen($model);
                        if($result == 1){
                            $almacen = $this->almacen->listar_almacen($_POST['id_almacen']);

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
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "almacen" => $almacen)));
    }

    //Funcion para Eliminar almacen
    public function eliminar_almacen()
    {
        //Array donde vamos a almacenar los cambios, en caso hagamos alguno
        $almacen = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_almacen', 'POST', true, $ok_data, 11, 'numero', 0);
            //Validacion de datos
            if ($ok_data) {
                //Eliminamos el almacen

                $result = $this->almacen->eliminar_almacen($_POST['id_almacen']);
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
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "almacen" => $almacen)));
    }

    public function listar_negocio_por_id(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app

        try{
            $id_negocio = $_POST['id_negocio'];
            $result = $this->almacen->listar_sucursal_negocio($id_negocio);

            $datos = "<select class='form-control' id='id_sucursal' name='id_sucursal'>";
            foreach($result as $c){
                $datos.="<option value='". $c->id_sucursal."'>". $c->sucursal_nombre."</option>";
            }
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode($datos);
    }

    //FUNCIONES NUEVAS PARA GUARDAR LA SALIDA DE STOCK
    public function guardar_salida(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
            //Validacion de datos
            if ($ok_data) {
                $model = new Almacen();
                $id_recurso_sede = $_POST['id_recurso_modal'];
                $cantidad = $_POST['cantidad_salida'];
                $model->id_negocio = $_POST['id_negocio_modal'];
                $model->id_recurso_sede = $id_recurso_sede;
                $model->id_usuario = $id_usuario;
                $model->almacen_salida_cantidad = $cantidad;
                $model->almacen_salida_fecha_registro = date('Y-m-d H:i:s');
                $model->almacen_salida_estado = 1;

                $result = $this->almacen->guardar_salida_stock($model);
                if($result ==1){
                    $result = $this->almacen->disminuir_stock($cantidad,$id_recurso_sede);
                }
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


    //nuvas funciones para el cambiazo
    //FUNCIONES
    public function guardar_categoria(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_negocio', 'POST',true,$ok_data,11,'texto',0);
            //Validacion de datos
            if($ok_data) {
                $model = new Recursos();
                $fecha = date('Y-m-d H:i:s');
                $model->categoria_nombre = $_POST['categoria_nombre'];
                $model->categoria_fecha_registro = $fecha;
                $model->categoria_tipo = $_POST['categoria_tipo'];
                $model->categoria_estado = 1;

                $result = $this->categorias->guardar_categorias($model);

                if($result == 1){
                    $jalar_id_categoria = $this->recursos->jalar_id_ultima_categoria();
                    $id_categoria = $jalar_id_categoria->id_categoria;
                    $fecha = date('Y-m-d H:i:s');
                    $id_usuario_creacion = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                    $model->id_usuario_creacion = $id_usuario_creacion;
                    $model->id_negocio = $_POST['id_negocio'];
                    $model->id_categoria = $id_categoria;
                    $model->recurso_categoria_estado = 1;
                    $model->recurso_categoria_fecha = $fecha;

                    $result = $this->recursos->guardar_categoria($model);
                }

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

    public function jalar_categorias(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app

        try{
            $id_sucursal = $_POST['id_sucursal'];
            $result = $this->recursos->jalar_categorias($id_sucursal);

            $datos_categoria = "<select class='form-control' onchange='cambiar_condicion()'  id='id_categoria' name='id_categoria'>";
            $datos_categoria.="<option value=''>Seleccionar</option>";
            foreach($result as $c){
                $datos_categoria.="<option value='". $c->id_categoria."'>". $c->categoria_nombre."</option>";
            }
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode($datos_categoria);
    }

    public function listar_categoria_por_id(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        try{
            $id_categoria = $_POST['id_categoria'];
            $result = $this->recursos->listar_recursos_categoria($id_categoria);
            $datos = "<select class='form-control' id='id_recurso' name='id_recurso'>";
            if(empty($result)){
                $datos = "<option value=''>No hay Registros</option>";
            }else{
                foreach($result as $c){
                    $datos.="<option value='". $c->id_recurso."'>". $c->recurso_nombre."</option>";
                }
            }
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode($datos);
    }

    public function guardar_recursos(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_sucursal', 'POST',true,$ok_data,11,'texto',0);

            //Validacion de datos
            if($ok_data) {
                $model = new Recursos();
                $id_ne = 1;
                $id_categoria = $_POST['id_categoria'];
                $recurso_nombre = $_POST['recurso_nombre'];

                if($id_ne == 1){
                    $model = new Recursos();
                    $model->id_categoria = $id_categoria;
                    $model->recurso_nombre = $recurso_nombre;
                    $model->recurso_estado = 1;
                    $result = $this->insumos->guardar_insumos($model);
                    if($result == 1){
                        $ultomoid = $this->recursos->jalar_ultimo_id();
                        $model->id_recurso = $ultomoid->id_recurso;
                    }else{
                        $model->id_recurso = 0;
                    }
                }else{
                    $model->id_recurso = $_POST['id_recurso'];
                }
                if($model->id_recurso!=0){
                    $fecha = date('Y-m-d H:i:s');
                    $id_usuario_creacion = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                    $model->id_usuario_creacion = $id_usuario_creacion;
                    $model->id_sucursal = $_POST['id_sucursal'];
                    $model->id_medida = $_POST['id_medida'];
                    $model->recurso_sede_precio = $_POST['recurso_sede_precio'];
                    $model->recurso_sede_factor_unidad = $_POST['recurso_sede_factor_unidad'];
                    $model->recurso_sede_cantidad = $_POST['recurso_sede_cantidad'];
                    $model->recurso_sede_precio_unit = $_POST['recurso_sede_precio_unit'];
                    $model->recurso_sede_peso_inicial = $_POST['recurso_sede_peso_inicial'];
                    $model->recurso_sede_peso_final = $_POST['recurso_sede_peso_final'];
                    $model->recurso_sede_precio_total = $_POST['recurso_sede_precio_total'];
                    $model->recurso_sede_merma = $_POST['recurso_sede_merma'];
                    $model->recurso_sede_stock = $_POST['recurso_sede_stock'];
                    $model->recurso_sede_stock_minimo = $_POST['recurso_sede_stock_minimo'];
                    $model->recurso_sede_estado = 1;
                    $model->recurso_sede_fecha = $fecha;
                    $result = $this->recursos->guardar_recurso($model);
                }
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

    public function cambiar_estado_recurso(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_recurso_sede', 'POST',true,$ok_data,11,'texto',0);
            $ok_data = $this->validar->validar_parametro('recurso_sede_estado', 'POST',true,$ok_data,11,'numero',0);

            //Validacion de datos
            if($ok_data) {

                $id_recurso_sede = $_POST['id_recurso_sede'];
                $recurso_sede_estado = $_POST['recurso_sede_estado'];

                $result = $this->recursos->cambiar_estado_recurso($id_recurso_sede, $recurso_sede_estado);

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

    public function cambiar_estado_categoria(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_categoria_negocio', 'POST',true,$ok_data,11,'texto',0);
            $ok_data = $this->validar->validar_parametro('recurso_categoria_estado', 'POST',true,$ok_data,11,'numero',0);

            //Validacion de datos
            if($ok_data) {

                $id_categoria_negocio = $_POST['id_categoria_negocio'];
                $recurso_categoria_estado = $_POST['recurso_categoria_estado'];

                $result = $this->recursos->cambiar_estado_categoria($id_categoria_negocio, $recurso_categoria_estado);

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

    public function editar_stock_minimo(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if($ok_data) {
                $id_recurso_sede = $_POST['id_recurso_sede'];
                $recurso_sede_stock_minimo = $_POST['recurso_sede_stock_minimo_e'];

                $result = $this->recursos->editar_stock_minimo($id_recurso_sede, $recurso_sede_stock_minimo);
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

