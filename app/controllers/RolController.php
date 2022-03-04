<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 24/10/2020
 * Time: 10:25
 */
require 'app/models/Rol.php';
require 'app/models/Menu.php';
class RolController{
    //Variables especificas del controlador
    private $rol;
    private $menu;
    //Variables fijas para cada llamada al controlador
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    public function __construct()
    {
        //Instancias especificas del controlador
        $this->rol = new Rol();
        $this->menu = new Menu();
        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
    }
    //Vistas/Opciones
    //Vista de Inicio de La Gestión de Menús
    public function inicio(){
        try{
            //Llamamos a la clase del Navbar, que sólo se usa
            // en funciones para llamar vistas y la instaciamos
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            //Traemos los roles registrados
            $roles = $this->rol->listar_roles();
            //Hacemos el require de los archivos a usar en las vistas
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'rol/inicio.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    //Vista para los accesos del rol a las diferentes vistas del sistema
    public function accesos(){
        try{
            //Como es una vista que requiere validar un parametro ($_GET) para
            //acceder, primero validamos ese parametro
            if(!$this->validar->validar_parametro('id', 'GET',true,true,11,'numero',0)){
                throw new Exception('ID no declarado');
            }
            $menus = $this->menu->listar_menus();
            //Listamos el rol
            $rol = $this->rol->listar_rol($_GET['id']);
            require _VIEW_PATH_ . 'rol/accesos.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<br><br><div style='text-align: center'><h3>Ocurrió Un Error Al Cargar Los Permisos</h3></div>";
        }
    }
    //Funciones
    //Funcion para editar un rol
    public function guardar_rol(){
        //Array donde vamos a almacenar los cambios, en caso hagamos alguno
        $rol = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('rol_nombre', 'POST',true,$ok_data,20,'texto',0);
            $ok_data = $this->validar->validar_parametro('rol_descripcion', 'POST',true,$ok_data,100,'texto',0);
            $ok_data = $this->validar->validar_parametro('rol_estado', 'POST',true,$ok_data,11,'numero',0);
            //Validamos el id_menu y menu_estado, en caso este sea declarado para editar menus
            $ok_data = $this->validar->validar_parametro('id_rol', 'POST',false,$ok_data,11,'numero',0);

            //Validacion de datos
            if($ok_data){
                //Creamos el modelo y ingresamos los datos a guardar
                $model = new Rol();
                if(!empty($_POST['id_rol'])){
                    $model->id_rol = $_POST['id_rol'];
                    $validar_duplicados = false;
                } else {
                    $validar_duplicados = $this->rol->buscar_rol($_POST['rol_nombre']);
                }
                //Validamos la duplicidad del $_POST['rol_nombre'], para evitar duplicados
                if($validar_duplicados){
                    //Código 3: Controlador duplicado
                    $result = 3;
                    $message = "Ya existe un rol registrado con este nombre";
                } else {
                    $model->rol_nombre = $_POST['rol_nombre'];
                    $model->rol_descripcion = $_POST['rol_descripcion'];
                    $model->rol_estado = $_POST['rol_estado'];
                    //Guardamos el menú y recibimos el resultado
                    $result = $this->rol->guardar_rol($model);
                    if($result == 1){
                        //Validamos si result es igual a 1 y si esta declarado el id_menu,
                        //para devolver los datos que fueron editados
                        if(!empty($_POST['id_rol'])){
                            $rol = array(
                                "id_rol" => $_POST['id_rol'],
                                "rol_nombre" => $_POST['rol_nombre'],
                                "rol_descripcion" => $_POST['rol_descripcion'],
                                "rol_estado" => $_POST['rol_estado']
                            );
                        }
                    }
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
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "rol" => $rol)));
    }
    //Sirve para gestionar el acceso entre el rol y el menú
    public function gestionar_acceso_rol(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app o web
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            //Validamos el id_menu y menu_estado, en caso este sea declarado para editar menus
            $ok_data = $this->validar->validar_parametro('id_menu', 'POST',false,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('id_rol', 'POST',false,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('relacion', 'POST',false,$ok_data,11,'numero',0);

            //Validacion de datos
            if($ok_data){
                //Verificamos que relacion tenga los valores deseados
                if($_POST['relacion'] == 1 || $_POST['relacion'] == 0){
                    //Si $_POST['relacion'] es igual a 1, creamos la relacion. Si es 0, eliminamos la relación
                    switch (intval($_POST['relacion'])){
                        case 0:
                            $result = $this->menu->eliminar_relacion($_POST['id_rol'], $_POST['id_menu']);
                            break;
                        case 1:
                            $result = $this->menu->agregar_relacion($_POST['id_rol'], $_POST['id_menu']);
                            break;
                    }
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
}
