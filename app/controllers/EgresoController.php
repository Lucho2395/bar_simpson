<?php
require 'app/models/Usuario.php';
require 'app/models/Rol.php';
require 'app/models/Menu.php';
require 'app/models/Archivo.php';
require 'app/models/Egresos.php';
require 'app/models/Negocio.php';
require 'app/models/Caja.php';

class EgresoController
{
    private $usuario;
    private $rol;
    private $archivo;
    private $egresos;
    private $negocio;
    private $caja;
    //Variables fijas para cada llamada al controlador
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $nav;

    public function __construct()
    {
        //Instancias especificas del controlador
        $this->usuario = new Usuario();
        $this->rol = new Rol();
        $this->archivo = new Archivo();
        $this->egresos = new Egresos();
        $this->negocio = new Negocio();
        $this->caja = new Caja();
        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
    }


    //Vista de Inicio de La Gestión de Menús
    public function gestionar()
    {
        try {
            //Llamamos a la clase del Navbar, que sólo se usa
            // en funciones para llamar vistas y la instaciamos
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'], _FULL_KEY_));
            //$empresa_registrada = $this->empresa->listar_empresas_modal();
            //Hacemos el require de los archivos a usar en las vistas
            $fecha_filtro = date('Y-m-d');
            $fecha_filtro_fin = date('Y-m-d');

            if(isset($_POST['enviar_fecha'])){
                $id_caja_numero = $_POST['id_caja_numero'];
                if($_POST['fecha_filtro']!="" && $_POST['fecha_filtro_fin']!="" && $_POST['id_caja_numero']!=""){
                    $fecha_filtro = $_POST['fecha_filtro'];
                    $fecha_filtro_fin = $_POST['fecha_filtro_fin'];
                    $egresos = $this->egresos->listar_egresos_filtro($id_caja_numero,$fecha_filtro,$fecha_filtro_fin);
                    $caja_ = $this->egresos->datos_caja($id_caja_numero);
                }elseif($_POST['fecha_filtro']!="" && $_POST['fecha_filtro_fin']!=""){
                    $fecha_filtro = $_POST['fecha_filtro'];
                    $fecha_filtro_fin = $_POST['fecha_filtro_fin'];
                    $egresos = $this->egresos->listar_egresos_filtro_fechas($fecha_filtro,$fecha_filtro_fin);
                    $caja_ = $this->egresos->datos_caja($id_caja_numero);
                }elseif($_POST['id_caja_numero']!=""){
                    $egresos = $this->egresos->listar_egresos_cajas($id_caja_numero);
                }
            }
            $caja = $this->caja->listar_cajas();
            $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
            $sucursal = $this->negocio->listar_sucursal_egresos();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'egresos/gestionar.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
    }


    public function gastos_personal(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'], _FULL_KEY_));
            $personal = $this->egresos->listar_personal();
            $empresas = $this->egresos->listar_empresas();
            $fecha_filtro = date('Y-m-d');
            $fecha_filtro_fin = date('Y-m-d');
            if(isset($_POST['enviar_fecha'])){
                if($_POST['fecha_filtro']!="" && $_POST['fecha_filtro_fin']!="" && $_POST['parametro']){
                    $fecha_filtro = $_POST['fecha_filtro'];
                    $fecha_filtro_fin = $_POST['fecha_filtro_fin'];
                    $parametro = $_POST['parametro'];
                    $gasto_personal = $this->egresos->listar_personal_deudas($fecha_filtro,$fecha_filtro_fin,$parametro);
                }elseif ($_POST['fecha_filtro']!="" && $_POST['fecha_filtro_fin']!=""){
                    $gasto_personal = $this->egresos->listar_personal_deudas_fechas($fecha_filtro,$fecha_filtro_fin);
                }
            }

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'egresos/gastos_personal.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
    }


    //FUNCIONES
    public function guardar_egresos(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validacion de datos
            if($ok_data){
                $model = new Egresos();
                $fecha_hoy = date('Y-m-d');
                $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                $buscar_caja = $this->caja->jalar_caja_movi($id_usuario);
                $fecha = date('Y-m-d H:i:s');
                $model->id_caja_numero = $buscar_caja->id_caja_numero;
                $model->id_usuario = $id_usuario;
                $model->id_sucursal = $_POST['id_sucursal'];
                $model->movimiento_tipo = $_POST['movimiento_tipo'];
                $model->egreso_descripcion = $_POST['egreso_descripcion'];
                $model->egreso_monto = $_POST['egreso_monto'];
                $model->egreso_fecha_registro = $fecha;
                $model->egreso_estado = 1;
                //Guardamos el menú y recibimos el resultado
                $result = $this->egresos->guardar_egresos($model);
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
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function editar_egresos(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validacion de datos
            if($ok_data){
                $model = new Egresos();
                $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                $fecha = date('Y-m-d H:i:s');
                $model->id_usuario = $id_usuario;
                $model->id_movimiento = $_POST['id_movimiento'];
                $model->id_sucursal = $_POST['id_sucursal_e'];
                $model->movimiento_tipo = $_POST['movimiento_tipo_e'];
                $model->egreso_descripcion = $_POST['egreso_descripcion_e'];
                $model->egreso_monto = $_POST['egreso_monto_e'];
                $model->egreso_fecha_registro = $fecha;
                //Guardamos el menú y recibimos el resultado
                $result = $this->egresos->guardar_egresos($model);
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
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function eliminar_egreso(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_movimiento', 'POST',true,$ok_data,11,'numero',0);
            //Validacion de datos
            if($ok_data) {
                $id_movimiento = $_POST['id_movimiento'];
                $result = $this->egresos->eliminar_egreso($id_movimiento);
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function guardar_personal(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if($ok_data) {
                $model = new Egresos();
                $microtime = microtime(true);
                $model->id_empresa = $_POST['id_empresa'];
                $model->persona_nombre = $_POST['persona_nombre'];
                $model->persona_apellido_paterno = $_POST['persona_apellido_paterno'];
                $model->persona_apellido_materno = $_POST['persona_apellido_materno'];
                $model->persona_email = $_POST['persona_email'];
                $model->persona_tipo_documento = $_POST['persona_tipo_documento'];
                $model->persona_dni = $_POST['persona_dni'];
                $model->persona_nacionalidad = $_POST['persona_nacionalidad'];
                $model->persona_estado_civil = $_POST['persona_estado_civil'];
                $model->persona_direccion = $_POST['persona_direccion'];
                $model->persona_discapacidad = $_POST['persona_discapacidad'];
                $model->persona_job = $_POST['persona_job'];
                $model->persona_nacimiento = $_POST['persona_nacimiento'];
                $model->persona_sexo = $_POST['persona_sexo'];
                $model->persona_telefono = $_POST['persona_telefono'];
                $model->persona_telefono_2 = $_POST['persona_telefono_2'];
                if($_FILES['persona_foto']['name'] != null) {
                    $path = $_FILES['persona_foto']['name'];
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $file_path = "media/persona/".$_POST['persona_dni'].".".$ext;
                    move_uploaded_file($_FILES['persona_foto']['tmp_name'],$file_path);
                    if($this->archivo->subir_imagen_comprimida($_FILES['persona_foto']['tmp_name'], $file_path,false)){
                        $model->persona_foto = $file_path;
                    } else {
                        $model->persona_foto = 'media/persona/default.png';
                    }
                } else {
                    $model->persona_foto = 'media/persona/default.png';
                }
                $model->persona_hijos = $_POST['persona_hijos'];
                $model->persona_departamento = $_POST['selectDepartamento'];
                $model->persona_provincia = $_POST['selectProvincia'];
                $model->persona_distrito = $_POST['selectDistrito'];
                $model->persona_adicional = $_POST['persona_adicional'];
                $model->persona_afp = $_POST['persona_afp'];
                $model->persona_cuspp = $_POST['persona_cuspp'];
                $model->persona_blacklist = 'NO';
                $model->persona_bank = $_POST['persona_bank'];
                $model->persona_number_account = $_POST['persona_number_account'];
                $model->persona_bank_alt = $_POST['persona_bank_alt'];
                $model->persona_number_account_alt = $_POST['persona_number_account_alt'];
                $model->persona_bank_cts = $_POST['persona_bank_cts'];
                $model->persona_account_cts = $_POST['persona_account_cts'];

                if($_FILES['persona_cv']['name'] !=null) {
                    $path = $_FILES['persona_cv']['name'];
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $file_path_cv = "media/cv/"."cv_".$_POST['persona_dni'].".".$ext;
                    move_uploaded_file($_FILES['persona_cv']['tmp_name'],$file_path_cv);
                    $model->persona_cv = $file_path_cv;
                }else{
                    $model->persona_cv ="";
                }
                $model->persona_creacion = date('Y-m-d H:i:s');
                $model->persona_modificacion = date('Y-m-d H:i:s');;
                $model->person_codigo = $microtime;
                $model->persona_estado = 1;

                $result = $this->egresos->guardar_personal($model);
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

    public function guardar_gasto_personal(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validacion de datos
            if($ok_data){
                $model = new Egresos();
                $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                $fecha = date('Y-m-d H:i:s');
                $buscar_caja = $this->caja->jalar_caja_movi($id_usuario);
                $model->id_caja_numero = $buscar_caja->id_caja;
                $model->id_persona = $_POST['id_persona'];
                $model->id_usuario = $id_usuario;
                $model->gasto_personal_concepto = $_POST['gasto_personal_concepto'];
                $model->gasto_personal_monto = $_POST['gasto_personal_monto'];
                $model->gasto_personal_fecha = $_POST['gasto_personal_fecha'];
                $model->gasto_personal_fecha_registro = $fecha;
                $model->gasto_personal_estado = 1;

                $result = $this->egresos->guardar_gastos_personal($model);

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

    public function guardar_gasto_personal_editado(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validacion de datos
            if($ok_data){
                $model = new Egresos();
                $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                $fecha = date('Y-m-d H:i:s');
                $model->id_gasto_personal = $_POST['id_gasto_personal'];
                $model->id_persona = $_POST['id_persona_e'];
                $model->gasto_personal_concepto = $_POST['gasto_personal_concepto_e'];
                $model->gasto_personal_monto = $_POST['gasto_personal_monto_e'];
                $model->gasto_personal_fecha = $_POST['gasto_personal_fecha_e'];
                $model->gasto_personal_fecha_registro = $fecha;
                $result = $this->egresos->guardar_gastos_personal($model);
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

    public function eliminar_gasto_personal(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_gasto_personal', 'POST',true,$ok_data,11,'numero',0);
            //Validacion de datos
            if($ok_data) {
                $id_gasto_personal = $_POST['id_gasto_personal'];
                $result = $this->egresos->eliminar_gasto_personal($id_gasto_personal);
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }


}