<?php
require 'app/models/Negocio.php';
require 'app/models/Archivo.php';
require 'app/models/Usuario.php';
require 'app/models/Rol.php';
class NegocioController
{
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $archivo;
    private $negocio;
    private $usuario;
    private $rol;


    public function __construct()
    {
        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
        $this->archivo = new Archivo();
        $this->negocio = new Negocio();
        $this->usuario = new Usuario();
        $this->rol = new Rol();

    }

    public function gestionar(){
        try{
            //Llamamos a la clase del Navbar, que sólo se usa
            // en funciones para llamar vistas y la instaciamos
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));

            $datos = false;
            if(isset($_GET['id'])){
                $exp = explode('0$parametro = "";20',$_GET['id']);
                $param="";
                for ($i=0;$i<count($exp);$i++){
                    ($i==count($exp)-1)?$param.=$exp[$i]:$param.=$exp[$i]." ";
                }
                $negocio = $this->negocio->listar($param);
                $parametro = $param;
                $datos = true;
            } else {
                $parametro = "";
            }
            $listaciudad = $this->negocio->listar_ciudad();

            //Hacemos el require de los archivos a usar en las vistas
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'negocio/gestionar.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }


    public function sucursal(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $id = $_GET['id'] ?? 0;
            if($id == 0){
                throw new Exception('ID Sin Declarar');
            }
            $listaciudad = $this->negocio->listar_ciudad();
            $sucursal = $this->negocio->listar_sucursal($id);
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'negocio/sucursal.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }


    public function usuarios_sucursal(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $id = $_GET['id'] ?? 0;
            if($id == 0){
                throw new Exception('ID Sin Declarar');
            }
            $sucursal = $this->negocio->datos_sucursal($id);
            $usuario = $this->usuario->listar();
            $rol = $this->rol->listar_roles();

            $usuario_sucursal = $this->negocio->listar_usuario_sucursal($id);
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'negocio/usuarios_sucursal.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }


    public function usuarios_negocio(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $id = $_GET['id'] ?? 0;
            if($id == 0){
                throw new Exception('ID Sin Declarar');
            }
            $negocio = $this->negocio->datos_negocio($id);
            $usuario = $this->usuario->listar();
            //$rol = $this->rol->listar_roles();

            $usuario_negocio = $this->negocio->listar_usuario_negcio($id);
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'negocio/usuarios_negocio.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }


    //FUNCIONES
    public function guardar_negocio(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('negocio_nombre', 'POST',true,$ok_data,200,'texto',0);

            //Validacion de datos
            if($ok_data) {
                $model = new Negocio();
                $fecha = date('Y-m-d H:i:s');
                $negocio_nombre = $_POST['negocio_nombre'];
                $model->negocio_nombre = $negocio_nombre;
                $model->id_ciudad = $_POST['id_ciudad'];
                $model->negocio_ruc = $_POST['negocio_ruc'];
                $model->negocio_direccion = $_POST['negocio_direccion'];
                $model->negocio_telefono = $_POST['negocio_telefono'];
                $model->negocio_fecha_registro = $fecha;
                $model->negocio_estado = 1;

                if($_FILES['negocio_foto']['name'] != null) {
                    //Conseguimos la extension del archivo y especificamos la ruta
                    $ext = pathinfo($_FILES['negocio_foto']['name'], PATHINFO_EXTENSION);
                    $file_path = "media/negocio/" . $negocio_nombre . '_' .date('dmYHis') . "." . $ext;
                    //Para subir archivos en general o imagenes sin comprimir
                    //if(move_uploaded_file($_FILES['usuario_imagenp']['tmp_name'], $file_path)){
                    //Para subir imagenes comprimidas
                    if($this->archivo->subir_imagen_comprimida($_FILES['negocio_foto']['tmp_name'], $file_path,false)){
                        $model->negocio_foto = $file_path;
                    } else {
                        $model->negocio_foto = 'media/negocio/default.jpg';
                    }
                } else {
                    $model->negocio_foto = 'media/negocio/default.png';
                }

                $result = $this->negocio->guardar_negocio($model);
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


    public function editar_negocio(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_negocio', 'POST',true,$ok_data,200,'texto',0);

            //Validacion de datos
            if($ok_data) {
                $model = new Negocio();
                $negocio_nombre = $_POST['negocio_nombre_e'];
                $model->negocio_nombre = $negocio_nombre;
                $model->id_ciudad = $_POST['id_ciudad_e'];
                $model->id_negocio = $_POST['id_negocio'];
                $model->negocio_ruc = $_POST['negocio_ruc_e'];
                $model->negocio_direccion = $_POST['negocio_direccion_e'];

                if($_FILES['negocio_foto_e']['name'] != null) {
                    //Conseguimos la extension del archivo y especificamos la ruta
                    $ext = pathinfo($_FILES['negocio_foto_e']['name'], PATHINFO_EXTENSION);
                    $file_path = "media/negocio/" . $negocio_nombre . '_' .date('dmYHis') . "." . $ext;
                    //Para subir archivos en general o imagenes sin comprimir
                    //if(move_uploaded_file($_FILES['usuario_imagenp']['tmp_name'], $file_path)){
                    //Para subir imagenes comprimidas
                    if($this->archivo->subir_imagen_comprimida($_FILES['negocio_foto_e']['tmp_name'], $file_path,false)){
                        $model->negocio_foto = $file_path;
                    } else {
                        $model->negocio_foto = 'media/negocio/default.jpg';
                    }
                } else {
                    $foto = $this->negocio->sacar_foto($_POST['id_negocio']);
                    $model->negocio_foto = $foto;
                }
                $model->negocio_telefono = $_POST['negocio_telefono_e'];
                $result = $this->negocio->guardar_negocio($model);
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


    public function guardar_sucursal(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('sucursal_nombre', 'POST',true,$ok_data,200,'texto',0);

            //Validacion de datos
            if($ok_data) {
                $model = new Negocio();
                $fecha = date('Y-m-d H:i:s');
                $sucursal_nombre = $_POST['sucursal_nombre'];
                $model->sucursal_nombre = $sucursal_nombre;
                $model->id_ciudad = $_POST['id_ciudad'];
                $model->id_negocio = $_POST['id_negocio'];
                $model->sucursal_ruc = $_POST['sucursal_ruc'];
                $model->sucursal_direccion = $_POST['sucursal_direccion'];
                $model->sucursal_telefono = $_POST['sucursal_telefono'];
                $model->sucursal_fecha_registro = $fecha;
                $model->sucursal_estado = 1;

                if($_FILES['sucursal_foto']['name'] != null) {
                    //Conseguimos la extension del archivo y especificamos la ruta
                    $ext = pathinfo($_FILES['sucursal_foto']['name'], PATHINFO_EXTENSION);
                    $file_path = "media/negocio/" . $sucursal_nombre . '_' .date('dmYHis') . "." . $ext;
                    //Para subir archivos en general o imagenes sin comprimir
                    //if(move_uploaded_file($_FILES['usuario_imagenp']['tmp_name'], $file_path)){
                    //Para subir imagenes comprimidas
                    if($this->archivo->subir_imagen_comprimida($_FILES['sucursal_foto']['tmp_name'], $file_path,false)){
                        $model->sucursal_foto = $file_path;
                    } else {
                        $model->sucursal_foto = 'media/sucursal/default.jpg';
                    }
                } else {
                    $model->sucursal_foto = 'media/sucursal/default.png';
                }

                $result = $this->negocio->guardar_sucursal($model);
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



    public function editar_sucursal(){
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
                $model = new Negocio();
                $sucursal_nombre = $_POST['sucursal_nombre_e'];
                $model->sucursal_nombre = $sucursal_nombre;
                $model->id_ciudad = $_POST['id_ciudad_e'];
                $model->id_negocio = $_POST['id_negocio_e'];
                $model->id_sucursal = $_POST['id_sucursal'];
                $model->sucursal_ruc = $_POST['sucursal_ruc_e'];
                $model->sucursal_direccion = $_POST['sucursal_direccion_e'];
                $model->sucursal_telefono = $_POST['sucursal_telefono_e'];

                if($_FILES['sucursal_foto_e']['name'] != null) {
                    //Conseguimos la extension del archivo y especificamos la ruta
                    $ext = pathinfo($_FILES['sucursal_foto_e']['name'], PATHINFO_EXTENSION);
                    $file_path = "media/negocio/" . $sucursal_nombre . '_' .date('dmYHis') . "." . $ext;
                    //Para subir archivos en general o imagenes sin comprimir
                    //if(move_uploaded_file($_FILES['usuario_imagenp']['tmp_name'], $file_path)){
                    //Para subir imagenes comprimidas
                    if($this->archivo->subir_imagen_comprimida($_FILES['sucursal_foto_e']['tmp_name'], $file_path,false)){
                        $model->sucursal_foto = $file_path;
                    } else {
                        $model->sucursal_foto = 'media/sucursal/default.jpg';
                    }
                } else {
                    $foto = $this->negocio->foto_sucursal($_POST['id_sucursal']);
                    $model->sucursal_foto = $foto;
                }

                $result = $this->negocio->guardar_sucursal($model);

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



    public function guardar_usuario_sucursal(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_sucursal', 'POST',true,$ok_data,11,'texto',0);
            $ok_data = $this->validar->validar_parametro('id_usuario', 'POST',true,$ok_data,11,'texto',0);
            $ok_data = $this->validar->validar_parametro('id_rol', 'POST',true,$ok_data,11,'texto',0);

            //Validacion de datos
            if($ok_data) {
                $model = new Negocio();
                $fecha = date('Y-m-d H:i:s');
                $model->id_sucursal = $_POST['id_sucursal'];
                $model->id_rol = $_POST['id_rol'];
                $model->id_usuario = $_POST['id_usuario'];
                $model->usuario_sucursal_fecha = $fecha;
                $model->usuario_sucursal_estado = 1;

                $result = $this->negocio->guardar_usuario_sucursal($model);

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


    public function guardar_usuario_negocio(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_negocio', 'POST',true,$ok_data,11,'texto',0);
            $ok_data = $this->validar->validar_parametro('id_usuario', 'POST',true,$ok_data,11,'texto',0);

            //Validacion de datos
            if($ok_data) {
                $model = new Negocio();
                $fecha = date('Y-m-d H:i:s');
                $model->id_negocio = $_POST['id_negocio'];
                $model->id_usuario = $_POST['id_usuario'];
                $model->usuario_negocio_fecha = $fecha;
                $model->usuario_negocio_estado = 1;

                $result = $this->negocio->guardar_usuario_negocio($model);

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

    //FUNCION PARA CAMBIAR ESTADO DEL NEGOCIO
    public function cambiar_estado_negocio(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_negocio', 'POST',true,$ok_data,11,'texto',0);
            $ok_data = $this->validar->validar_parametro('negocio_estado', 'POST',true,$ok_data,11,'numero',0);

            //Validacion de datos
            if($ok_data) {

                $id_negocio = $_POST['id_negocio'];
                $negocio_estado = $_POST['negocio_estado'];

                $result = $this->negocio->cambiar_estado($id_negocio, $negocio_estado);

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


    public function cambiar_estado_usuario_negocio(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_usuario_negocio', 'POST',true,$ok_data,11,'texto',0);
            $ok_data = $this->validar->validar_parametro('usuario_negocio_estado', 'POST',true,$ok_data,11,'numero',0);

            //Validacion de datos
            if($ok_data) {

                $id_usuario_negocio = $_POST['id_usuario_negocio'];
                $usuario_negocio_estado = $_POST['usuario_negocio_estado'];

                $result = $this->negocio->cambiar_estado_usuario_negocio($id_usuario_negocio, $usuario_negocio_estado);

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


    //FUNCION PARA CAMBIAR ESTADO DE LA SUCURSAL
    public function cambiar_estado_sucursal(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_sucursal', 'POST',true,$ok_data,11,'texto',0);
            $ok_data = $this->validar->validar_parametro('sucursal_estado', 'POST',true,$ok_data,11,'numero',0);

            //Validacion de datos
            if($ok_data) {

                $id_sucursal = $_POST['id_sucursal'];
                $sucursal_estado = $_POST['sucursal_estado'];

                $result = $this->negocio->cambiar_estado_sucursal($id_sucursal, $sucursal_estado);

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


    public function cambiar_estado_usuariosucursal(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_usuario_sucursal', 'POST',true,$ok_data,11,'texto',0);
            $ok_data = $this->validar->validar_parametro('usuario_sucursal_estado', 'POST',true,$ok_data,11,'numero',0);

            //Validacion de datos
            if($ok_data) {

                $id_usuario_sucursal = $_POST['id_usuario_sucursal'];
                $usuario_sucursal_estado = $_POST['usuario_sucursal_estado'];

                $result = $this->negocio->cambiar_estado_usuario_sucursal($id_usuario_sucursal, $usuario_sucursal_estado);

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