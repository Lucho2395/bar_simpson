<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 26/10/2020
 * Time: 23:21
 */
require 'app/models/Usuario.php';
require 'app/models/Rol.php';
require 'app/models/Archivo.php';
require 'app/models/RHumanos.php';
class UsuarioController{
    //Variables especificas del controlador
    private $usuario;
    private $rol;
    private $archivo;
    //Variables fijas para cada llamada al controlador
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $humanos;

    public function __construct()
    {
        //Instancias especificas del controlador
        $this->usuario = new Usuario();
        $this->rol = new Rol();
        $this->archivo = new Archivo();
        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
        $this->humanos = new RHumanos();
    }
    //Vistas/Opciones
    //Vista de acceso al panel de inicio
    public function inicio(){
        try{
            //Llamamos a la clase del Navbar, que sólo se usa
            // en funciones para llamar vistas y la instaciamos
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            if($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_) == 2){
                //Listamos los usuarios del sistema
                $usuarios = $this->usuario->listar_usuarios_superadmin();
                //Listamos los roles del sistema según el nivel de usuario
                $roles = $this->rol->listar_roles_superadmin();
            } else {
                $usuarios = $this->usuario->listar_usuarios();
                //Listamos los roles del sistema según el nivel de usuario
                $roles = $this->rol->listar_roles_usuario();
            }
            $departamento = $this->humanos->listar_departamentos();
            $cargo = $this->humanos->listar_cargos();
            //Hacemos el require de los archivos a usar en las vistas
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'usuario/inicio.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    //Funciones
    //Agregar Nuevo Usuario
    public function guardar_nuevo_usuario(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('persona_nombre', 'POST',true,$ok_data,100,'texto',0);
            $ok_data = $this->validar->validar_parametro('persona_apellido_paterno', 'POST',true,$ok_data,30,'texto',0);

            $ok_data = $this->validar->validar_parametro('id_rol', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('usuario_nickname', 'POST',true,$ok_data,16,'texto',0);
            $ok_data = $this->validar->validar_parametro('usuario_contrasenha', 'POST',true,$ok_data,70,'texto',0);
            $ok_data = $this->validar->validar_parametro('usuario_email', 'POST',false,$ok_data,60,'email',0);
            $ok_data = $this->validar->validar_parametro('usuario_imagen', 'FILES',false,$ok_data,0,['jpg','png'],['jpg','png']);
            $ok_data = $this->validar->validar_parametro('usuario_estado', 'POST',true,$ok_data,1,'numero',0);
            //Validacion de datos
            if($ok_data){
                //Creamos el modelo y ingresamos los datos a guardar
                $model = new Usuario();
                //Validamos la duplicidad del $_POST['rol_nombre'], para evitar duplicados
                if($this->usuario->validar_nickname(str_replace( " ", "",$_POST['usuario_nickname']))){
                    //Código 3: Controlador duplicado
                    $result = 3;
                    $message = "Ya existe un usuario con este nickname registrado";
                } else {
                    if($this->usuario->validar_correo($_POST['usuario_email'])){
                        //Código 3: Controlador duplicado
                        $result = 4;
                        $message = "Ya existe un usuario con este correo registrado";
                    } else {
                        $microtime = microtime(true);
                        $model->persona_nombre = $_POST['persona_nombre'];
                        $model->persona_apellido_paterno = $_POST['persona_apellido_paterno'];
                        $model->persona_apellido_materno = $_POST['persona_apellido_materno'];
                        $model->persona_nacimiento = $_POST['persona_nacimiento'];
                        $model->persona_telefono = $_POST['persona_telefono'];
                        $model->person_codigo = $microtime;
                        //Guardamos el menú y recibimos el resultado
                        $guardar_persona = $this->usuario->guardar_persona($model);
                        if($guardar_persona == 1){
                            $id_persona = $this->usuario->listar_persona_microtime($microtime);
                            $model->id_persona = $id_persona;
                            $model->id_rol = $_POST['id_rol'];
                            $model->usuario_nickname = str_replace( " ", "",$_POST['usuario_nickname']);
                            $model->usuario_contrasenha = password_hash($_POST['usuario_contrasenha'], PASSWORD_BCRYPT);
                            $model->usuario_email = $_POST['usuario_email'];
                            //Si la imagen recibida no es null, la actualizamos. Caso contrario, colocamos la imagen por defecto
                            if($_FILES['usuario_imagen']['name'] != null) {
                                //Conseguimos la extension del archivo y especificamos la ruta
                                $ext = pathinfo($_FILES['usuario_imagen']['name'], PATHINFO_EXTENSION);
                                $file_path = "media/usuarios/" . $id_persona . '_' .date('dmYHis') . "." . $ext;
                                //Para subir archivos en general o imagenes sin comprimir
                                //if(move_uploaded_file($_FILES['usuario_imagenp']['tmp_name'], $file_path)){
                                //Para subir imagenes comprimidas
                                if($this->archivo->subir_imagen_comprimida($_FILES['usuario_imagen']['tmp_name'], $file_path,false)){
                                    $model->usuario_imagen = $file_path;
                                } else {
                                    $model->usuario_imagen = 'media/usuarios/usuario.jpg';
                                }
                            } else {
                                $model->usuario_imagen = 'media/usuarios/usuario.jpg';
                            }
                            $model->usuario_estado = $_POST['usuario_estado'];
                            $result = $this->usuario->guardar_usuario($model);
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
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }
    //Funcion usada para guardar la edicion del usuario
    public function guardar_edicion_usuario(){
        //Infomación del usuario
        $usuario = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_rol_e', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('usuario_nickname_e', 'POST',true,$ok_data,16,'texto',0);
            $ok_data = $this->validar->validar_parametro('usuario_email_e', 'POST',false,$ok_data,60,'email',0);
            $ok_data = $this->validar->validar_parametro('usuario_imagen_e', 'FILES',false,$ok_data,0,['jpg','png'],['jpg','png']);
            $ok_data = $this->validar->validar_parametro('usuario_estado_e', 'POST',true,$ok_data,1,'numero',0);
            //Validamos el id_menu y menu_estado, en caso este sea declarado para editar personas
            $ok_data = $this->validar->validar_parametro('id_usuario', 'POST',false,$ok_data,11,'numero',0);
            //Validacion de datos
            if($ok_data){
                //Creamos el modelo y ingresamos los datos a guardar
                $model = new Usuario();
                //Validamos la duplicidad del $_POST['rol_nombre'], para evitar duplicados
                if($this->usuario->validar_nickname_edicion(str_replace(" ", "",$_POST['usuario_nickname_e']), $_POST['id_usuario'])){
                    //Código 3: Controlador duplicado
                    $result = 3;
                    $message = "Ya existe un usuario con este nickname registrado";
                } else {
                    if($this->usuario->validar_correo_edicion($_POST['usuario_email_e'], $_POST['id_usuario'])){
                        //Código 3: Controlador duplicado
                        $result = 4;
                        $message = "Ya existe un usuario con este correo registrado";
                    } else {
                        $usuario = $this->usuario->listar_usuario($_POST['id_usuario']);
                        $model->id_usuario = $_POST['id_usuario'];
                        $model->id_rol = $_POST['id_rol_e'];
                        $model->usuario_nickname = $_POST['usuario_nickname_e'];
                        $model->usuario_email = $_POST['usuario_email_e'];
                        //Si la imagen recibida no es null, la actualizamos. Caso contrario, dejamos la imagen anterior
                        if($_FILES['usuario_imagen_e']['name'] != null) {
                            //Conseguimos la extension del archivo y especificamos la ruta
                            $ext = pathinfo($_FILES['usuario_imagen_e']['name'], PATHINFO_EXTENSION);
                            $file_path = "media/usuarios/" . $usuario->id_persona . '_' .date('dmYHis') . "." . $ext;
                            //Para subir archivos en general o imagenes sin comprimir
                            //if(move_uploaded_file($_FILES['usuario_imagenp']['tmp_name'], $file_path)){
                            //Para subir imagenes comprimidas
                            if($this->archivo->subir_imagen_comprimida($_FILES['usuario_imagen_e']['tmp_name'], $file_path,false)){
                                $model->usuario_imagen = $file_path;
                            } else {
                                $model->usuario_imagen = $usuario->usuario_imagen;
                            }
                        } else {
                            $model->usuario_imagen = $usuario->usuario_imagen;
                        }
                        $model->usuario_estado = $_POST['usuario_estado_e'];
                        $result = $this->usuario->guardar_usuario($model);
                        if($result == 1){
                            $usuario = $this->usuario->listar_usuario($_POST['id_usuario']);
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
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "usuario" => $usuario)));
    }
    //Funcion para guardar los datos de la edicion de la persona
    public function guardar_edicion_persona(){
        //Array para datos de la persona
        $persona = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('persona_nombre_e', 'POST',true,$ok_data,100,'texto',0);
            $ok_data = $this->validar->validar_parametro('persona_apellido_paterno_e', 'POST',true,$ok_data,30,'texto',0);
            $ok_data = $this->validar->validar_parametro('persona_apellido_materno_e', 'POST',false,$ok_data,30,'texto',0);
            $ok_data = $this->validar->validar_parametro('persona_nacimiento_e', 'POST',false,$ok_data,100,'fecha','fecha');
            $ok_data = $this->validar->validar_parametro('persona_telefono_e', 'POST',true,$ok_data,15,'texto',0);
            $ok_data = $this->validar->validar_parametro('id_persona', 'POST',true,$ok_data,11,'numero',0);
            //Validacion de datos
            if($ok_data){
                //Creamos el modelo y ingresamos los datos a guardar
                $model = new Usuario();
                $model->id_persona = $_POST['id_persona'];
                $model->persona_nombre = $_POST['persona_nombre_e'];
                $model->persona_apellido_paterno = $_POST['persona_apellido_paterno_e'];
                $model->persona_apellido_materno = $_POST['persona_apellido_materno_e'];
                $model->persona_nacimiento = $_POST['persona_nacimiento_e'];
                $model->persona_telefono = $_POST['persona_telefono_e'];
                //Guardamos el menú y recibimos el resultado
                $result = $this->usuario->guardar_persona($model);
                if($result == 1){
                    //Mandamos el array de datos cambiados del usuario
                    $persona = array(
                        "id_persona" => $_POST['id_persona'],
                        "persona_nombre" => $_POST['persona_nombre_e'],
                        "persona_apellido_paterno" => $_POST['persona_apellido_paterno_e'],
                        "persona_apellido_materno" => $_POST['persona_apellido_materno_e'],
                        "persona_nacimiento" => $_POST['persona_nacimiento_e'],
                        "persona_telefono" => $_POST['persona_telefono_e']
                    );
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
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "persona" => $persona)));
    }
    //Funcion para restablecer la contraseña de un usuario
    public function restablecer_contrasenha(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('contrasenha', 'POST',true,$ok_data,16,'texto',0);
            $ok_data = $this->validar->validar_parametro('id_usuario', 'POST',true,$ok_data,11,'numero',0);
            //Validacion de datos
            if($ok_data){
                //Ingresamos los datos para la nueva contraseña
                $result = $this->usuario->guardar_contrasenha($_POST['id_usuario'], password_hash($_POST['contrasenha'], PASSWORD_BCRYPT));
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

    public function guardar_departamento(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if($ok_data){
                $departamento_nombre = $_POST['departamento_nombre'];
                $result = $this->humanos->guardar_departamento($departamento_nombre);
            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Throwable $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function guardar_cargo(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if($ok_data){
                $cargo_nombre = $_POST['cargo_nombre'];
                $id_departamento = 0;
                $result = $this->humanos->guardar_cargo($id_departamento,$cargo_nombre);
            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Throwable $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function eliminar_departamento(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('id_departamento', 'POST', true, $ok_data, 11, 'numero', 0);
            //Validacion de datos
            if ($ok_data) {
                $id_departamento = $_POST['id_departamento'];
                $result = $this->humanos->eliminar_departamento($id_departamento);
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Throwable $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function eliminar_cargo(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('id_cargo', 'POST', true, $ok_data, 11, 'numero', 0);
            //Validacion de datos
            if ($ok_data) {
                $id_cargo = $_POST['id_cargo'];
                $result = $this->humanos->eliminar_cargo($id_cargo);
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Throwable $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

}
