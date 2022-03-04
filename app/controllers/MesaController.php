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
require 'app/models/Mesa.php';
require 'app/models/Negocio.php';
require 'app/models/Archivo.php';
class MesaController
{
    private $mesa;
    private $negocio;
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
        $this->mesa = new Mesa();
        $this->negocio = new Negocio();
        $this->sucursal = new Negocio();
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
            $negocios = $this->negocio->listar_usuario();
            $sucursal = $this->negocio->listar_sucursal();
            $usuario = $this->usuario->listar_usuarios();
            $rol = $this->rol->listar_roles_usuario();
            $mesas = $this->mesa->listar_mesas();
            $datos = $this->mesa->mesa($id);
            //$empresa_registrada = $this->empresa->listar_empresas_modal();
            //Hacemos el require de los archivos a usar en las vistas
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'mesas/inicio.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
    }

    //Funciones
    //Agregar Nuevo mesa
    public function guardar_nuevo_mesa()
    {
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_sucursal', 'POST', true, $ok_data, 11, 'numero', 0);
            $ok_data = $this->validar->validar_parametro('mesa_nombre', 'POST', true, $ok_data, 100, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('mesa_capacidad', 'POST', true, $ok_data, 100, 'texto', 0);

            //Validacion de datos
            if ($ok_data) {
                //Creamos el modelo y ingresamos los datos a guardar
                $model = new Mesa();
                $microtime = microtime(true);
                $model->mesa_nombre = $_POST['mesa_nombre'];
                $model->mesa_capacidad = $_POST['mesa_capacidad'];
                $model->mesa_estado = $_POST['mesa_estado'];
                $model->id_sucursal = $_POST['id_sucursal'];
                $model->mesacodigo = $microtime;
                //Guardamos el menú y recibimos el resultado
                $model->mesa_estado = 1;
                $result = $this->mesa->guardar_mesa($model);

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

    //Funcion usada para guardar la edicion del mesa
    public function guardar_edicion_mesa(){
        //Infomación del mesa
        $mesa = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos el id_menu y menu_estado, en caso este sea declarado para editar personas
            $ok_data = $this->validar->validar_parametro('id_mesa', 'POST',false,$ok_data,11,'numero',0);
            //Validacion de datos
            if($ok_data){
                //Creamos el modelo y ingresamos los datos a guardar
                $model = new Mesa();
                $model->id_mesa = $_POST['id_mesa'];
                $model->id_sucursal = $_POST['id_sucursal_e'];
                $model->mesa_nombre = $_POST['mesa_nombre_e'];
                $model->mesa_capacidad = $_POST['mesa_capacidad_e'];
                $result = $this->mesa->guardar_mesa($model);
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
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "mesa" => $mesa)));
    }

    //Funcion para Eliminar mesa
    public function eliminar_mesa()
    {
        //Array donde vamos a almacenar los cambios, en caso hagamos alguno
        $mesa = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_mesa', 'POST', true, $ok_data, 11, 'numero', 0);
            //Validacion de datos
            if ($ok_data) {
                //Eliminamos el mesa

                $result = $this->mesa->eliminar_mesa($_POST['id_mesa']);
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
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "mesa" => $mesa)));
    }

    public function listar_negocio_por_id(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app

        try{
            $id_negocio = $_POST['id_negocio'];
            $result = $this->mesa->listar_sucursal_negocio($id_negocio);

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

    public function listar_negocio_por_id_editar(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app

        try{
            $id_negocio = $_POST['id_negocio_e'];
            $result = $this->mesa->listar_sucursal_negocio($id_negocio);

            $datos_editar = "<select class='form-control' id='id_sucursal_e' name='id_sucursal_e'>";
            foreach($result as $c){
                $datos_editar.="<option value='". $c->id_sucursal."'>". $c->sucursal_nombre."</option>";
            }
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode($datos_editar);
    }

    public function listar_mesas(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_sucursal', 'POST', true, $ok_data, 11, 'numero', 0);
            //Validacion de datos
            if ($ok_data) {
                $id_sucursal = $_POST['id_sucursal'];
                $mesas = $this->mesa->listar_mesa_ws($id_sucursal);
                foreach ($mesas as $m){
                    $buscar_ultima_comanda = $this->mesa->listar_ultima_comanda($m->id_mesa);
                    $ultima_comanda = $buscar_ultima_comanda->id_comanda;
                    $buscar_pedidos_x_mesa = $this->mesa->buscar_pedido_x_mesa($m->id_mesa,$ultima_comanda);
                    $m->comanda=$buscar_pedidos_x_mesa;
                }
                if($mesas){
                    $result = 1;
                    $message = "Datos encontrados";
                }else{
                    $result = 2;
                    $message = "Vacio como tu corazón";
                }
            } else {
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
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "datos"=>$mesas)));
    }

}