<?php
require 'app/models/Archivo.php';
require 'app/models/RHumanos.php';
require 'app/models/Rol.php';
require 'app/models/Usuario.php';
class RHumanosController
{
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $archivo;
    private $humanos;
    private $rol;
    private $usuario;

    public function __construct()
    {
        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
        $this->archivo = new Archivo();
        $this->humanos = new RHumanos();
        $this->rol = new Rol();
        $this->usuario = new Usuario();
    }

    public function convocatoria(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/convocatoria.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function gestion_personal(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $datos = false;
            if(isset($_POST['parametro'])){
                $person = $this->humanos->listar_busqueda($_POST['parametro']);
                $parametro = $_POST['parametro'];
                $datos = true;
            } else {
                $parametro = "";
            }
            $empresas = $this->humanos->listar_empresas();
            $roles = $this->rol->listar_roles_usuario();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/gestion_personal.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function editar_personal(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            } else {
                throw new Exception('ID NO DECLARADO');
            }
            $person = $this->humanos->listar_todo($id);
            $empresas = $this->humanos->listar_empresas();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/editar_personal.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);;
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function periodolaboral(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $datos = false;
            if(isset($_POST['parametro'])){
                $person = $this->humanos->listar_busqueda($_POST['parametro']);
                $parametro = $_POST['parametro'];
                $datos = true;
            } else {
                $parametro = "";
            }

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/periodolaboral.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function aprobar(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            if(isset($_GET['id'])){
                $person = $this->humanos->listar_pendiente_aprobacion_persona($_GET['id']);
            } else {
                $person = $this->humanos->listar_pendiente_aprobacion();
            }
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/pendiente_aprobar.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function editar(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            } else {
                throw new Exception('ID sin declarar');
            }
            $periodo = $this->humanos->listar_periodo($id);
            $turnos = $this->humanos->listar_turnos();
            $person = $this->humanos->list_all($periodo->id_persona);
            $departamentos = $this->humanos->listar_departamentos();
            $cargos = $this->humanos->listar_cargos();
            $sedes = $this->humanos->listar_sedes();
            $empresas = $this->humanos->listar_empresas();
            $contratos = $this->humanos->listar_contratos();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/editar.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);;
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function modificar(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            } else {
                throw new Exception('ID sin declarar');
            }
            $periodo = $this->humanos->listar_periodo($id);
            $person = $this->humanos->list_all($periodo->id_persona);
            $departamentos = $this->humanos->listar_departamentos();
            $cargos = $this->humanos->listar_cargos();
            $sedes = $this->humanos->listar_sedes();
            $empresas = $this->humanos->listar_empresas();
            $contratos = $this->humanos->listar_contratos();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/modificar.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);;
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function ver_periodo(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            } else {
                throw new Exception('ID sin declarar');
            }
            $periodo = $this->humanos->listar_periodo_($id);
            $person = $this->humanos->list_all($periodo->id_persona);
            $departamentos = $this->humanos->listar_departamentos();
            $cargos = $this->humanos->listar_cargos();
            $sedes = $this->humanos->listar_sedes();
            $empresas = $this->humanos->listar_empresas();
            $contratos = $this->humanos->listar_contratos();
            $adjuntos = $this->humanos->listar_adjuntos_docs($id);
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/ver_periodo.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);;
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function detalle_periodo_laboral(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            } else {
                throw new Exception('ID sin declarar');
            }
            $person = $this->humanos->listar_todo($id);
            $periodos = $this->humanos->listar_periodos_persona($id);
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/detalle_periodo_laboral.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);;
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function agregar_periodo(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $departamentos = $this->humanos->listar_departamentos();
            $sedes = $this->humanos->listar_sedes();
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            } else {
                throw new Exception('ID sin declarar');
            }
            $turnos = $this->humanos->listar_turnos();
            $person = $this->humanos->listar_todo($id);
            $contratos = $this->humanos->listar_contratos();
            $empresas = $this->humanos->listar_empresas();
            $cargo = $this->humanos->listar_cargos();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/agregar_periodo.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);;
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function renovar_periodo(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));

            if(isset($_GET['id'])){
                $id = $_GET['id'];
            } else {
                throw new Exception('ID sin declarar');
            }
            $person = $this->humanos->list_all($id);
            $periodo = $this->humanos->listar_periodos_persona_ultimo($id);

            $departamentos = $this->humanos->listar_departamentos();
            $sedes = $this->humanos->listar_sedes();
            $empresas = $this->humanos->listar_empresas();
            $contratos = $this->humanos->listar_contratos();
            $cargos = $this->humanos->listar_cargos();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/renovar_periodo.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);;
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function adjuntar(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            } else {
                throw new Exception('ID sin declarar');
            }
            $periodo = $this->humanos->listar_periodo($id);
            $person = $this->humanos->listar_todo($periodo->id_persona);
            $tipoadjuntos = $this->humanos->listar_adjuntos();
            $adjuntos = $this->humanos->listar_adjuntos_docs($id);
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/adjuntar.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);;
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function asistencia(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $role = $this->encriptar->desencriptar($_SESSION['ru'], _FULL_KEY_);
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/asistencia.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function aprobar_asistencias(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $sedes = $this->humanos->listar_sedes();
            if(isset($_POST['enviar'])) {
                if ($_POST['enviar'] == "1") {
                    $fecha_elegida = $_POST['fecha'];
                    if ($_POST['id_departamento'] != "" && $_POST['id_sede'] != "") {
                        $person = $this->humanos->listar_asistencia_periodos_activos_departamento_sede($_POST['id_departamento'], $_POST['id_sede'], $fecha_elegida);
                        $sede = $this->humanos->listar_sede($_POST['id_sede']);
                        $departamento = $this->humanos->listar_departamento($_POST['id_departamento']);
                        $datos = true;
                    } else {
                        if ($_POST['id_departamento'] != "") {
                            $person = $this->humanos->listar_asistencia_periodos_activos_departamento($_POST['id_departamento'], $fecha_elegida);
                            $departamento = $this->humanos->listar_departamento($_POST['id_departamento']);
                            $datos = true;
                        } else if ($_POST['id_sede'] != "") {
                            $person = $this->humanos->listar_asistencia_periodos_activos_sede($_POST['id_sede'], $fecha_elegida);
                            $sede = $this->humanos->listar_sede($_POST['id_sede']);
                            $datos = true;
                        } else {
                            $person = $this->humanos->listar_asistencia_periodos_activos($fecha_elegida);
                            $datos = true;
                        }
                    }
                }
            }
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/aprobar_asistencias.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);;
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function asistencia_personal(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $departamentos = $this->humanos->listar_departamentos();
            $sedes = $this->humanos->listar_sedes();
            $datos = false;
            if(isset($_GET['id'])){
                $fecha_hoy = date('Y-m-d');
                $persona = $this->humanos->buscar_persona_x_dni($_GET['id']);
                $jalar_turnos = $this->humanos->listar_turnos_asistencia($_GET['id']);
                $buscar_registro = $this->humanos->buscar_registro($fecha_hoy,$_GET['id']);
                $hora_tolerancia = $jalar_turnos->turno_hora_tolerancia;
                $hora_salida = $jalar_turnos->turno_hora_salida;
                $hora_sistema = date('H:i:s');
                if(!empty($buscar_registro)){
                    $respuesta = "Registre su salida por favor!";
                }else{
                    if($hora_sistema < $hora_tolerancia){
                        $respuesta = "Bienvenido. LLegó puntual al trabajo. Que tenga un buen día";
                        $valor = 1;
                    } else{
                        $respuesta = "Usted llegó tarde. Por favor, la próxima debes de ser más puntual. Gracias";
                        $valor = 10;
                    }
                }
                $numero_dni = $_GET['id'];
                $datos = true;
            } else {
                $numero_dni = "";
            }
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/asistencia_personal.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function asignar_turnos(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $turno_1 = $this->humanos->listar_turno(1);
            $turno_2 = $this->humanos->listar_turno(2);
            $turno_3 = $this->humanos->listar_turno(3);
            $turno_4 = $this->humanos->listar_turno(4);
            $datos = false;
            if(isset($_POST['parametro'])){
                $person = $this->humanos->listar_busqueda_persona_periodo($_POST['parametro']);
                $parametro = $_POST['parametro'];
                $datos = true;
            } else {
                $parametro = "";
            }

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/asignar_turnos.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function gestionar_turnos(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $turnos = $this->humanos->listar_turnos();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/gestionar_turnos.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function feriados(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $feriados = $this->humanos->listar_feriados();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/feriados.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function proyectar_asistencia(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $persons = $this->humanos->listAll_persona_periodo_activo();
            $datos = false;
            $_SESSION['fechas'] = [];
            if(isset($_POST['id_persona']) && isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin'])) {
                $f1 = strtotime($_POST['fecha_inicio']);
                $f2 = strtotime($_POST['fecha_fin']);
                $id_fecha = 1;
                for($i=$f1;$i<=$f2;$i+=86400){
                    $fecha = date('Y-m-d',$i);
                    //Buscar si ya hay una asistencia proyectada en esa fecha
                    $asistencia_proyectada = $this->humanos->listar_asistencia_persona_fecha_proyectada($_POST['id_persona'], $fecha);
                    if(isset($asistencia_proyectada->id_asistencia)){
                        $_SESSION['fechas'][$id_fecha] =
                            array(
                                "id_fecha" => $id_fecha,
                                "fecha" => $fecha,
                                "asistencia" => $asistencia_proyectada->asistencia_valor
                            );
                    } else {
                        $_SESSION['fechas'][$id_fecha] =
                            array(
                                "id_fecha" => $id_fecha,
                                "fecha" => $fecha,
                                "asistencia" => 1
                            );
                    }
                    $id_fecha++;
                }
                $persona = $_POST['id_persona'];
                $fecha_inicio = $_POST['fecha_inicio'];
                $fecha_fin = $_POST['fecha_fin'];
                $datos = true;

            } else {
                $fecha_inicio = date('Y-m-d');
                $fecha_fin = date('Y-m-d');
            }
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/proyectar_asistencia.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function opciones(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/opciones.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function consultar(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $departamentos = $this->humanos->listar_departamentos();
            $sedes = $this->humanos->listar_sedes();
            $datos=false;
            if(isset($_POST['enviar']) && $_POST['enviar'] == "1") {
                if ($_POST['id_departamento'] != "" && $_POST['id_sede'] != "") {
                    $persons = $this->humanos->listar_periodos_departamento_sede($_POST['id_departamento'], $_POST['id_sede'], $_POST['fecha_i'], $_POST['fecha_f']);
                    $sede = $this->humanos->listar_sede($_POST['id_sede']);
                    $departamento = $this->humanos->listar_departamento($_POST['id_departamento']);
                    $datos = true;
                } else {
                    if ($_POST['id_departamento'] != "") {
                        $persons = $this->humanos->listar_periodos_departamento($_POST['id_departamento'], $_POST['fecha_i'], $_POST['fecha_f']);
                        $departamento = $this->humanos->listar_departamento($_POST['id_departamento']);
                        $datos = true;
                    } else if ($_POST['id_sede'] != "") {
                        $persons = $this->humanos->listar_periodos_sede($_POST['id_sede'], $_POST['fecha_i'], $_POST['fecha_f']);
                        $sede = $this->humanos->listar_sede($_POST['id_sede']);
                        $datos = true;
                    } else {
                        $persons = $this->humanos->listar_periodos($_POST['fecha_i'], $_POST['fecha_f']);
                        $datos = true;
                    }
                }
                foreach ($persons as $i) {
                    $asistencias = $this->humanos->listar_asistencias_por_periodo_rango($i->id_periodo, $_POST['fecha_i'], $_POST['fecha_f']);
                    $data2 = $this->humanos->listar_periodo($i->id_periodo);
                    $data = $this->humanos->list_all($data2->id_persona);
                    $i->asistencias = $asistencias;
                    $i->data = $data;
                }
                $fecha_elegida = $_POST['fecha_i'];
                $fecha_elegida2 = $_POST['fecha_f'];
                $fecha_shit = explode('-', $fecha_elegida);
                $fecha_shit2 = explode('-', $fecha_elegida2);
            }
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/consultar.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function por_persona(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $persons = $this->humanos->listar_personas();
            $datos=false;
            if (isset($_POST['id_persona']) && $_POST['id_persona'] != "") {
                $asistencias = $this->humanos->listar_asistencias_por_persona_rango($_POST['id_persona'], $_POST['fecha_i'], $_POST['fecha_f']);
                $data = $this->humanos->list_all($_POST['id_persona']);
                if (count($asistencias)>0){
                    foreach ($asistencias as $a){
                        $data2 = $this->humanos->listar_periodo_persona_por_fecha($_POST['id_persona'],$a->asistencia_fecha);
                        $a->cargo=$data2;
                    }
                }
                $datos = true;
            }
            if(isset($_POST['fecha_i']) && $_POST['fecha_i'] != "" && isset($_POST['fecha_f']) && $_POST['fecha_f'] != ""){
                $fecha_elegida = $_POST['fecha_i'];
                $fecha_elegida2 = $_POST['fecha_f'];
            } else {
                $fecha_elegida = date('Y-m-d');
                $fecha_elegida2 = date('Y-m-d');
            }
            $fecha_shit = explode('-', $fecha_elegida);
            $fecha_shit2 = explode('-', $fecha_elegida2);
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/por_persona.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function memorandum(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));

            $persona = $this->humanos->listar_personas();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/memorandum.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function listar_memo(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));

            $memos = $this->humanos->listar_memos();
            $persona = $this->humanos->listar_personas();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/listar_memo.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function ver_memo(){
        try{
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            } else {
                throw new Exception('ID NO DECLARADO');
            }
            $memo = $this->humanos->listar_memo_pdf($id);
            $cargo_a= $this->humanos->listar_periodo_cargo_persona($memo->id_persona);
            $empresa = $this->humanos->listar_empresa();
            $_SESSION['nombre_empresa'] = $empresa->empresa_razon_social;
            $_SESSION['ruc'] = $empresa->empresa_ruc;
            $nombre_empresa = $empresa->empresa_razon_social;
            $ruc_empresa = $empresa->empresa_ruc;

            if($memo->memorandum_motivo == "OTROS"){
                $detalle_motivo = $memo->memorandum_motivo. ": " .$memo->memorandum_otros;
            }else{
                $detalle_motivo = $memo->memorandum_motivo;
            }
            require 'app/models/plantilla.php';

            $fechita=$memo->memorandum_fecha;
            $fe=explode("-",$fechita);
            switch ($fe[1]){
                case 1:$mes="enero";break;
                case 2:$mes="febrero";break;
                case 3:$mes="marzo";break;
                case 4:$mes="abril";break;
                case 5:$mes="mayo";break;
                case 6:$mes="junio";break;
                case 7:$mes="julio";break;
                case 8:$mes="agosto";break;
                case 9:$mes="setiembre";break;
                case 10:$mes="octubre";break;
                case 11:$mes="noviembre";break;
                case 12:$mes="diciembre";break;
            }
            $pdf=new PDF_WriteTag();
            $pdf->SetMargins(20, 15, 20);
            $pdf->SetFont('arial', '', 11);
            $pdf->AddPage();
            $pdf->SetStyle("p", "arial", "N", 9, "0, 0, 0", 0);
            $pdf->SetStyle("h1", "arial", "BU", 11, "0, 0, 0", 0);
            $pdf->SetStyle("vb", "arial", "B", 0, "0, 0, 0");
            $pdf->SetFont('Arial','BU',11);
            $pdf->Cell(180,2,'MEMORANDUM N° '.$memo->memorandum_numero."-".$fe[0]."/".$nombre_empresa,0,1,'C',0);
            $pdf->Ln('10');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(50,5,"A",0,0,'L',0);
            $pdf->Cell(50,5,$memo->persona_nombre." ".$memo->persona_apellido_paterno." ".$memo->persona_apellido_materno,0,1,'L',0);
            $pdf->Cell(50,5,"",0,0,'L',0);
            $pdf->Cell(50,5,$cargo_a->cargo_nombre,0,1,'L',0);
            $pdf->Ln('5');
            $pdf->Cell(50,5,"DE",0,0,'L',0);
            $pdf->Cell(50,5,"NOMBRE DEL GERENTE GENERAL",0,1,'L',0);
            $pdf->Cell(50,5,"",0,0,'L',0);
            $pdf->Cell(50,5,"GERENTE GENERAL",0,1,'L',0);
            $pdf->Ln('5');
            $pdf->Cell(50,5,"ASUNTO",0,0,'L',0);
            $pdf->Cell(50,5,$detalle_motivo.",",0,1,'L',0);
            $pdf->Cell(50,5,"",0,1,'L',0);
            $pdf->Ln('5');
            $pdf->Cell(50,5,"FECHA",0,0,'L',0);
            $pdf->Cell(50,5,"Iquitos, ".$fe[2]." de ".$mes." del ".$fe[0],0,1,'L',0);
            $pdf->Ln('5');
            $pdf->Cell(180,5,"========================================================================================",0,1,'J',0);
            $salto = "\n";
            $pdf->MultiCell(180,5,str_replace('&#10;', "$salto" , $memo->memorandum_descripcion),0,'J',0);
            $pdf->Ln('10');
            $pdf->Cell(180,5,"Atentamente, ",0,1,'J',0);
            $pdf->Ln('5');
            //$pdf->Image(_SERVER_.$memo->empresa_firma,null,null,40);
            $pdf->Cell(50,0,'----------------------------------------------',0,1,'C',0);
            $pdf->Cell(100,5,"NOMBRE DEL GERENTE",0,1,'L',0);
            $pdf->Cell(115,5,"GERENTE GENERAL",0,1,'L',0);
            $pdf->Cell(115,5,$nombre_empresa,0,1,'L',0);
            $pdf->Output();

        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
        }
    }

    public function obligacion_laboral(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/obligacion_laboral.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function vacaciones(){
        try{
            $_SESSION['pagos_vacaciones'] = [];
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $empresas = $this->humanos->listar_empresas();

            if(isset($_POST['enviar'])){
                if($_POST['enviar'] == "1") {
                    $persons = $this->humanos->listar_periodos_empresa($_POST['id_empresa'], $_POST['fecha_i'], $_POST['fecha_f']);
                    $empresa = $this->humanos->listar_empresa_($_POST['id_empresa']);
                    $datos = true;

                    foreach ($persons as $i) {
                        $asistencias = $this->humanos->listar_asistencias_por_periodo_rango($i->id_periodo, $_POST['fecha_i'], $_POST['fecha_f']);
                        $data2 = $this->humanos->listar_periodo($i->id_periodo);
                        $data = $this->humanos->list_all($data2->id_person);
                        $i->asistencias = $asistencias;
                        $i->data = $data;
                        $i->data2 = $data2;
                    }

                    $fecha_elegida = $_POST['fecha_i'];
                    $fecha_elegida2 = $_POST['fecha_f'];
                    $fecha_shit = explode('-', $fecha_elegida);
                    $fecha_shit2 = explode('-', $fecha_elegida2);
                }
            }
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'humanos/vacaciones.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }


    //FUNCIONES

    //FUNCIONES PARA MEMORANDUM
    //FUNCION PARA GUARDAR MEMORANDUM
    public function guardar_memo(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if($ok_data) {
                $model = new RHumanos();
                $model->id_persona = $_POST['id_persona'];
                $model->memorandum_motivo = $_POST['motivo'];
                $model->memorandum_fecha = $_POST['fecha'];
                $model->memorandum_descripcion = $_POST['descripcion'];
                $model->memorandum_otros = $_POST['otros'];
                $model->id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                $model->memorandum_fecha_creacion = date('Y-m-d H:i:s');
                $model->memorandum_estado = 1;

                $result = $this->humanos->guardar_memo($model);

                if($result == 1){
                    $obligacion_numero = $this->humanos->listar_ultimo_nro_memo();
                    $jalar_id_memo = $this->humanos->jalar_id_memo();
                    $id_memo = $jalar_id_memo->id_memorandum;
                    if(isset($obligacion_numero->id_memorandum)){
                        $obligacion = $obligacion_numero->memorandum_numero + 1;
                    } else {
                        $obligacion = 100001;
                    }
                    $result = $this->humanos->aprobar_memo($id_memo, $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_),$obligacion);
                }
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
    //FUNCION PARA EDITAR MEMORANDUM
    public function editar_memo(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if($ok_data) {
                $model = new RHumanos();
                $model->id_memorandum = $_POST['id_memorandum'];
                $model->id_persona = $_POST['id_persona'];
                $model->memorandum_motivo = $_POST['motivo'];
                $model->memorandum_fecha = $_POST['fecha'];
                $model->memorandum_descripcion = $_POST['descripcion'];
                $model->memorandum_otros = $_POST['otros'];
                $model->id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                $model->memorandum_fecha_creacion = date('Y-m-d H:i:s');

                $result = $this->humanos->guardar_edicion_memo($model);

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
    //FUNCION PARA APROBAR MEMORANDUM
    public function aprobar_memo(){
        try{
            if(isset($_POST['id_memo'])){
                $obligacion_numero = $this->humanos->listar_ultimo_nro_memo();
                if(isset($obligacion_numero->id_memorandum)){
                    $obligacion = $obligacion_numero->memorandum_numero + 1;
                } else {
                    $obligacion = 100001;
                }
                $result = $this->humanos->aprobar_memo($_POST['id_memo'], $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_),$obligacion);
            } else {
                $result = 2;
            }
        }catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        echo json_encode($result);
    }
    //FUNCION PAA ELIMINAR MEMORANDUM
    public function eliminar_memo(){
        try{
            if(isset($_POST['id_memo'])){
                if(isset($_POST['eliminar'])){
                    $result=$this->humanos->eliminar_memo_totalmente($_POST['id_memo']);
                }else{
                    $result=$this->humanos->eliminar_memo($_POST['id_memo']);
                }
            } else {
                $result = 2;
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        echo json_encode($result);
    }


    //FUNCIONES PARA GESTION DE PERSONAL
    //FUNCIONES PARA GUARDAR EL PERSONAL
    public function guardar_personal(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if($ok_data) {
                $model = new RHumanos();
                if(isset($_POST['id_persona'])){
                    if($this->humanos->listar_tipo_documento_nuevo($_POST['persona_dni'], $_POST['persona_tipo_documento'],$_POST['id_persona'])){
                        $result = 3;
                    }else{
                        $id_persona = $_POST['id_persona'];
                        $model->id_persona = $id_persona;
                        $model->id_empresa = $_POST['id_empresa'];
                        $model->persona_nombre = $_POST['persona_nombre'];
                        $model->persona_apellido_paterno = $_POST['persona_apellido_paterno'];
                        $model->persona_apellido_materno = $_POST['persona_apellido_materno'];
                        $model->persona_email = $_POST['persona_email'];
                        $model->persona_nacionalidad = $_POST['persona_nacionalidad'];
                        $model->persona_job = $_POST['persona_job'];
                        $model->persona_telefono = $_POST['persona_telefono'];
                        $model->persona_telefono_2 = $_POST['persona_telefono_2'];
                        $model->persona_sexo = $_POST['persona_sexo'];
                        $model->persona_estado_civil = $_POST['persona_estado_civil'];
                        $model->persona_discapacidad = $_POST['persona_discapacidad'];
                        $model->persona_direccion = $_POST['persona_direccion'];
                        $model->persona_distrito = $_POST['selectDistrito'];
                        $model->persona_provincia = $_POST['selectProvincia'];
                        $model->persona_departamento = $_POST['selectDepartamento'];
                        $model->persona_adicional = $_POST['persona_adicional'];
                        $model->persona_afp = $_POST['persona_afp'];
                        $model->persona_cuspp = $_POST['persona_cuspp'];
                        $model->persona_blacklist = $_POST['persona_blacklist'];
                        $model->persona_bank = $_POST['persona_bank'];
                        $model->persona_number_account = $_POST['persona_number_account'];
                        $model->persona_bank_alt = $_POST['persona_bank_alt'];
                        $model->persona_number_account_alt = $_POST['persona_number_account_alt'];
                        $model->persona_bank_cts = $_POST['persona_bank_cts'];
                        $model->persona_account_cts = $_POST['persona_account_cts'];

                        if($_FILES['persona_foto']['name'] != null) {
                            $path = $_FILES['persona_foto']['name'];
                            $ext = pathinfo($path, PATHINFO_EXTENSION);
                            $file_path = "media/persona/".$_POST['persona_dni'].".".$ext;
                            move_uploaded_file($_FILES['persona_foto']['tmp_name'],$file_path);
                            $model->persona_foto = $file_path;
                        } else {
                            $datos= $this->humanos->listar_todo($_POST['id_persona']);
                            $model->persona_foto =$datos->persona_foto;
                        }
                        $model->persona_hijos = $_POST['persona_hijos'];
                        if($_FILES['persona_cv']['name'] !=null) {
                            $path = $_FILES['persona_cv']['name'];
                            $ext = pathinfo($path, PATHINFO_EXTENSION);
                            $file_path_cv = "media/cv/"."cv_".$_POST['persona_dni'].".".$ext;
                            move_uploaded_file($_FILES['persona_cv']['tmp_name'],$file_path_cv);
                            $model->persona_cv = $file_path_cv;
                        }else{
                            $datos= $this->humanos->listar_todo($_POST['id_persona']);
                            $model->persona_cv =$datos->persona_cv;
                        }
                        $model->persona_empleado = 1;
                        $model->persona_dni = $_POST['persona_dni'];
                        $model->persona_tipo_documento = $_POST['persona_tipo_documento'];
                        $model->persona_nacimiento = $_POST['persona_nacimiento'];
                        $model->persona_modificacion = date('Y-m-d H:i:s');

                        $result = $this->humanos->guardar_personal($model);
                    }
                }else{
                    if($this->humanos->listar_tipo_documento($_POST['persona_dni'], $_POST['persona_tipo_documento'])){
                        $result = 3;
                    }else{
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
                            $file_path = "media/persona/" . $_POST['persona_dni'] . "." . $ext;
                            move_uploaded_file($_FILES['persona_foto']['tmp_name'], $file_path);
                            $model->persona_foto = $file_path;
                        }else {
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

                        $result = $this->humanos->guardar_personal($model);
                        if($result == 1){
                            $id_persona = $this->usuario->listar_persona_microtime_($microtime);
                            $model->id_persona = $id_persona->id_persona;
                            $model->id_rol = $_POST['id_rol'];
                            $model->usuario_nickname = str_replace( " ", "",$_POST['usuario_nickname']);
                            $model->usuario_contrasenha = password_hash($_POST['usuario_contrasenha'], PASSWORD_BCRYPT);
                            $model->usuario_email = $_POST['persona_email'];
                            $model->usuario_imagen = $id_persona->persona_foto;
                            $model->usuario_estado = 1;

                            $result = $this->usuario->guardar_usuario($model);
                        }
                    }
                }
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

    //FUNCION PARA ELIMINAR EL PERSONAL
    public function eliminar_personal(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('id_persona', 'POST', true, $ok_data, 11, 'numero', 0);
            //Validacion de datos
            if ($ok_data) {
                $id_persona = $_POST['id_persona'];
                $result = $this->humanos->eliminar_personal($id_persona);
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

    //FUNCIONES PARA PERIODO LABORAL
    //GUARDAR PERIODO LABORAL
    public function guardar_periodo(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if($ok_data){
                $model = new RHumanos();
                if($_POST['accion'] == 0){
                    //Para Editar el Periodo
                    $periodo_activo = $this->humanos->listar_periodo($_POST['id_periodo']);
                    $model->id_periodo = $_POST['id_periodo'];
                    if($this->humanos->listar_periodo_fechas_sinrepeticion($_POST['periodo_fechainicio'], $_POST['periodo_fechafin'],$_POST['id_persona'], $_POST['id_periodo'])){
                        $model->id_empresa = $_POST['id_empresa'];
                        $model->id_cargo = $_POST['id_cargo'];
                        $model->id_sede = $_POST['id_sede'];
                        $model->id_departamento = $_POST['id_departamento'];
                        $model->id_contrato = $_POST['id_contrato'];
                        $model->periodo_fechainicio = $_POST['periodo_fechainicio'];
                        $model->periodo_fechafin = $_POST['periodo_fechafin'];
                        $model->periodo_sueldo = $_POST['periodo_sueldo'];
                        $model->periodo_movilidad = $_POST['periodo_movilidad'];
                        $model->periodo_total = $_POST['periodo_total'];
                        $model->periodo_observa = $_POST['periodo_observa'];
                        $model->periodo_bono = $_POST['periodo_bono'];
                        $model->accion = $_POST['accion'];
                        $result = $this->humanos->guardar_periodo($model);
                        if($result == 1){
                            $model = new RHumanos();
                            $id_persona = $_POST['id_persona'];
                            $model->id_persona = $id_persona;
                            $model->id_turno = $_POST['id_turno'];

                            $result = $this->humanos->guardar_turno_x_persona_actualizar($model);
                        }
                        if(isset($periodo_activo->periodo_num_contrato)){
                            unlink('media/contratos/'. $periodo_activo->periodo_num_contrato);
                        }
                        $this->humanos->quitar_contrato($_POST['id_periodo']);
                    } else {
                        $result = 4;
                    }
                } else if ($_POST['accion'] == 1) {
                    //Para Guardar el Periodo
                    $model->id_persona = $_POST['id_persona'];
                    if($this->humanos->listar_periodo_fechas($_POST['periodo_fechainicio'], $_POST['periodo_fechafin'],$_POST['id_persona'])){
                        $model->id_empresa = $_POST['id_empresa'];
                        $model->id_cargo = $_POST['id_cargo'];
                        $model->id_departamento = $_POST['id_departamento'];
                        $model->id_sede = $_POST['id_sede'];
                        $model->id_contrato = $_POST['id_contrato'];
                        $model->periodo_fechainicio = $_POST['periodo_fechainicio'];
                        $model->periodo_fechafin = $_POST['periodo_fechafin'];
                        $model->periodo_sueldo = $_POST['periodo_sueldo'];
                        $model->periodo_movilidad = $_POST['periodo_movilidad'];
                        $model->periodo_total = $_POST['periodo_total'];
                        $model->id_user_creacion = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                        //$model->id_user_aprobacion = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                        $model->periodo_fecha_creacion = date('Y-m-d');
                        $model->periodo_hora_creacion = date('H:i:s');
                        if(isset($_POST['periodo_bono'])){
                            if(is_numeric($_POST['periodo_bono'])){
                                $model->periodo_bono = $_POST['periodo_bono'];
                            } else {
                                $model->periodo_bono = 0;
                            }
                        } else {
                            $model->periodo_bono = 0;
                        }
                        $model->periodo_estado = 0;
                        $model->accion = $_POST['accion'];
                        $result = $this->humanos->guardar_periodo($model);
                        if($result == 1){
                            $model = new RHumanos();
                            $id_persona = $_POST['id_persona'];
                            $model->id_persona = $id_persona;
                            $model->id_turno = $_POST['id_turno'];
                            $model->persona_turno_fecha_registro = date('Y-m-d H:i:s');
                            $model->persona_estado_turno = 1;

                            $result = $this->humanos->guardar_turno_x_persona($model);
                        }
                    } else {
                        $result = 4;
                    }
                    if($result == 1){
                        $pe = $this->humanos->jalar_ultimo_periodo();
                        if($pe->periodo_estado == 0){
                            $id_user_aprobacion = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                            $result = $this->humanos->activar_periodo($pe->id_periodo, $id_user_aprobacion);
                            if($result == 1){
                                $f1=strtotime($pe->periodo_fechainicio);
                                $f2=strtotime($pe->periodo_fechafin);

                                //$fecha_inicial = "2020/01/01";
                                $fecha_inicio = strtotime($pe->periodo_fechainicio);
                                $fecha_hoy = date("Y/m/d");
                                $fecha_limite=strtotime($fecha_hoy);

                                //Calcular Diferencia de Fechas

                                if($f1 < $fecha_inicio){
                                    $date1 = new DateTime($pe->periodo_fechainicio);
                                } else {
                                    $date1 = new DateTime($pe->periodo_fechainicio);
                                }

                                if($f2 > $fecha_limite){
                                    $date2 = new DateTime($fecha_hoy);
                                } else {
                                    $date2 = new DateTime($pe->periodo_fechafin);
                                }
                                $diff = $date1->diff($date2);
                                if($diff->invert == 1){
                                    $result = 1;
                                } else {
                                    $diferencia = ($diff->days) + 1;
                                    //Fin Diferencia de Fechas
                                    $registros = 0;
                                    for($i=$f1;$i<=$f2;$i+=86400){
                                        if($i >= $fecha_inicio && $i <= $fecha_limite){
                                            $fecha = date('Y-m-d',$i);
                                            $valor=1;
                                            $dia = date('N',$i);
                                            if($dia==7){
                                                $valor=7;
                                            }
                                            $caja_iniciada = $this->humanos->buscar_asistencia_persona_fecha($pe->id_persona_turno, $fecha);
                                            if(count($caja_iniciada) == 0){
                                                $this->humanos->guardar_asistencia($pe->id_persona_turno, $fecha, $valor);
                                                $registros++;
                                            }
                                        }
                                    }
                                    if($diferencia == $registros){
                                        $result = 1;
                                    } else {
                                        $result = 7;
                                        $this->humanos->desactivar_periodo($pe->id_periodo);
                                        $this->humanos->eliminar_asistencia($pe->id_persona,$pe->periodo_fechainicio,$pe->periodo_fechafin);
                                    }
                                }
                            }
                        }
                    }
                } else if ($_POST['accion'] == 2){
                    //Para Modificar el Periodo
                    $periodo_activo = $this->humanos->listar_periodo($_POST['id_periodo']);
                    $model->id_periodo = $_POST['id_periodo'];
                    if($this->humanos->listar_periodo_fechas_sinrepeticion($_POST['periodo_fechainicio'], $_POST['periodo_fechafin'],$_POST['id_persona'], $_POST['id_periodo'])){
                        $model->id_empresa = $_POST['id_empresa'];
                        $model->id_cargo = $_POST['id_cargo'];
                        $model->id_sede = $_POST['id_sede'];
                        $model->id_departamento = $_POST['id_departamento'];
                        $model->id_contrato = $_POST['id_contrato'];
                        $model->periodo_fechainicio = $_POST['periodo_fechainicio'];
                        $model->periodo_fechafin = $_POST['periodo_fechafin'];
                        $model->periodo_sueldo = $_POST['periodo_sueldo'];
                        $model->periodo_movilidad = $_POST['periodo_movilidad'];
                        $model->periodo_total = $_POST['periodo_total'];
                        $model->periodo_observa = $_POST['periodo_observa'];
                        $model->accion = $_POST['accion'];
                        $result = $this->humanos->guardar_periodo($model);
                        if($result == 1){
                            $model = new RHumanos();
                            $id_persona = $_POST['id_persona'];
                            $model->id_persona = $id_persona;
                            $model->id_turno = $_POST['id_turno'];

                            $result = $this->humanos->guardar_turno_x_persona_actualizar($model);
                        }
                        unlink('media/contratos/'. $periodo_activo->periodo_num_contrato);
                        $this->humanos->quitar_contrato($_POST['id_periodo']);
                    } else {
                        $result = 4;
                    }
                } else {
                    //Para Modificar Fecha de Fin Periodo Laboral
                    $periodo_activo = $this->humanos->listar_periodo($_POST['id_periodo']);
                    $model->id_periodo = $_POST['id_periodo'];
                    if($this->humanos->listar_periodo_fechas_sinrepeticion($_POST['periodo_fechainicio'], $_POST['periodo_fechafin'],$_POST['id_persona'], $_POST['id_periodo'])){
                        $model->periodo_fechafin = $_POST['periodo_fechafin'];
                        $model->periodo_observa = $_POST['periodo_observa'];
                        $model->accion = $_POST['accion'];
                        $result = $this->humanos->guardar_periodo($model);
                        unlink('media/contratos/'. $periodo_activo->periodo_num_contrato);
                        $this->humanos->quitar_contrato($_POST['id_periodo']);
                    } else {
                        $result = 4;
                    }
                }

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

    public function eliminar_periodo(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('id_periodo', 'POST', true, $ok_data, 11, 'numero', 0);
            //Validacion de datos
            if ($ok_data) {
                $id_periodo = $_POST['id_periodo'];
                $result = $this->humanos->eliminar_periodo($id_periodo);
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Throwable $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function guardar_archivo(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if($ok_data){
                $periodo = $this->humanos->listar_periodo($_POST['id_periodo']);
                $persona = $this->humanos->listar_todo($periodo->id_persona);
                $model = new RHumanos();
                $model->id_persona = $periodo->id_persona;
                $model->id_adjunto = $_POST['id_adjunto'];
                $model->id_periodo = $_POST['id_periodo'];
                if($_FILES['archivo']['name'] != null) {
                    //Conseguimos la extension del archivo y especificamos la ruta
                    $ext = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
                    $file_path = "media/documentos/". $persona->persona_dni.'_'.$persona->persona_nombre.'_'.$persona->persona_apelido_paterno.'_'.date('dmYHis') . "." . $ext;
                    //Para subir archivos en general o imagenes sin comprimir
                    //if(move_uploaded_file($_FILES['usuario_imagenp']['tmp_name'], $file_path)){
                    //Para subir imagenes comprimidas
                    if($this->archivo->subir_imagen_comprimida($_FILES['archivo']['tmp_name'], $file_path,false)){
                        $model->documento_nombre = $file_path;
                    } else {
                        $model->documento_nombre = " ";
                    }
                }
                $model->documento_fechainicio = $_POST['documento_fechainicio'];
                $model->documento_fechafin = $_POST['documento_fechafin'];
                $model->documento_fecha_registro = date('Y-m-d H:i:s');
                $model->documento_estado = 1;

                $result = $this->humanos->guardar_archivo($model);
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

    public function eliminar_documento(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('id_documento', 'POST', true, $ok_data, 11, 'numero', 0);
            //Validacion de datos
            if ($ok_data) {
                $id_documento = $_POST['id_documento'];
                $result = $this->humanos->eliminar_documento($id_documento);
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

    public function aprobar_periodo(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if($ok_data){
                $model = new RHumanos();
                $model->id_periodo = $_POST['id_periodo'];
                $pe = $this->humanos->listar_periodo_persona($_POST['id_periodo']);
                if($pe->periodo_estado == 0){
                    $id_user_aprobacion = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                    $result = $this->humanos->activar_periodo($model->id_periodo, $id_user_aprobacion);
                    if($result == 1){
                        $f1=strtotime($pe->periodo_fechainicio);
                        $f2=strtotime($pe->periodo_fechafin);

                        //$fecha_inicial = "2020/01/01";
                        $fecha_inicio = strtotime($pe->periodo_fechainicio);
                        $fecha_hoy = date("Y/m/d");
                        $fecha_limite=strtotime($fecha_hoy);

                        //Calcular Diferencia de Fechas

                        if($f1 < $fecha_inicio){
                            $date1 = new DateTime($pe->periodo_fechainicio);
                        } else {
                            $date1 = new DateTime($pe->periodo_fechainicio);
                        }

                        if($f2 > $fecha_limite){
                            $date2 = new DateTime($fecha_hoy);
                        } else {
                            $date2 = new DateTime($pe->periodo_fechafin);
                        }
                        $diff = $date1->diff($date2);
                        if($diff->invert == 1){
                            $result = 1;
                        } else {
                            $diferencia = ($diff->days) + 1;
                            //Fin Diferencia de Fechas
                            $registros = 0;
                            for($i=$f1;$i<=$f2;$i+=86400){
                                if($i >= $fecha_inicio && $i <= $fecha_limite){
                                    $fecha = date('Y-m-d',$i);
                                    $valor=1;
                                    $dia = date('N',$i);
                                    if($dia==7){
                                        $valor=7;
                                    }
                                    $caja_iniciada = $this->humanos->buscar_asistencia_persona_fecha($pe->id_persona, $fecha);
                                    if(count($caja_iniciada) == 0){
                                        $this->humanos->guardar_asistencia($pe->id_persona, $fecha, $valor);
                                        $registros++;
                                    }
                                }
                            }
                            if($diferencia == $registros){
                                $result = 1;
                            } else {
                                $result = 7;
                                $this->humanos->desactivar_periodo($_POST['id_periodo']);
                                $this->humanos->eliminar_asistencia($pe->id_persona,$pe->periodo_fechainicio,$pe->periodo_fechafin);
                            }
                        }
                    }
                } else {
                    $result = 1;
                }
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
        //Result
        if($result === true){
            $result = 1;
        }
        $response = array("code" => $result,"message" => $message);
        $data = array("result" => $response);
        echo json_encode($data);
    }

    public function guardar_cargo(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if($ok_data){
                $id_departamento = $_POST['id_departamento'];
                $cargo_nombre = $_POST['cargo_nombre'];

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

    //PARA ASISTENCIA
    public function agregar_feriado(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if ($ok_data) {
                $model = new RHumanos();
                $fecha_actual = strtotime(date('Y-m-d'));
                $fecha_agregar = strtotime($_POST['feriado_dia']);
                if($fecha_actual < $fecha_agregar){
                    $model->feriado_dia = $_POST['feriado_dia'];
                    $model->feriado_motivo = $_POST['feriado_motivo'];
                    $result = $this->humanos->agregar_feriado($model);
                } else {
                    $result = 3;
                    $message = "Code 3: Fecha Eliminar";
                }
            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Throwable $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function eliminar_feriado(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('id_feriado', 'POST', true, $ok_data, 11, 'numero', 0);
            //Validacion de datos
            if ($ok_data) {
                $feriado = $this->humanos->listar_feriado($_POST['id_feriado']);
                $fecha_actual = strtotime(date('Y-m-d'));
                $fecha_eliminar = strtotime($feriado->feriado_dia);
                if($fecha_actual < $fecha_eliminar){
                    $result = $this->humanos->eliminar_feriado($_POST['id_feriado']);
                } else {
                    $result = 3;
                    $message = "Code 3: Fecha Eliminar";
                }
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

    public function registrar_asistencia_proyectada(){
        try{
            if(isset($_POST['id_persona'])){
                foreach ($_SESSION['fechas'] as $m){
                    $fecha = $m['fecha'];
                    $verificar_asistencia = $this->humanos->buscar_asistencia_persona_fecha_id($_POST['id_persona'], $fecha);
                    if(count($verificar_asistencia) == 0){
                        $this->humanos->guardar_asistencia_aprobada($_POST['id_persona'], $m['fecha'], $m['asistencia'],'NO',1);
                    } else {
                        $ida = $verificar_asistencia[0]->id_asistencia;
                        $this->humanos->actualizar_asistencia_aprobada_proyectada($ida, $m['asistencia']);
                    }
                    $this->humanos->registrar_edicion_asistencia($_POST['id_persona'], $fecha ,$m['asistencia'],'ASISTENCIA PROYECTADA');
                }
                $result = 1;
            } else {
                $result = 2;
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        $response = array("code" => $result);
        $data = array("result" => $response);
        echo json_encode($data);
    }

    public function guardar_asistencia_proyectada(){
        try{
            $valor = $_POST['valor'];
            $id = $_POST['id'];
            $_SESSION['fechas'][$id]['asistencia'] = $valor;
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        echo json_encode($result);
    }

    public function guardar_asistencia(){
        try{
            $fecha = $_POST['fecha'];
            $valor = $_POST['valor'];
            $id = $_POST['id'];
            $asistencia_estado = 0;
            $result = $this->humanos->actualizar_asistencia($id,$fecha,$valor,$asistencia_estado);
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        echo json_encode($result);
    }

    public function registrar_asistencia(){
        try{
            $numero_dni = $_POST['numero_dni'];
            $buscar_persona = $this->humanos->buscar_persona_x_dni($numero_dni);
            $id_persona_turno = $buscar_persona->id_persona_turno;
            $model = new RHumanos();
            $model->id_persona_turno = $id_persona_turno;
            $model->asistencia_fecha = date('Y-m-d');
            $model->asistencia_hora = date('H:i:s');
            $model->asistencia_tipo = 0;
            $valor = $_POST['asistencia_valor'];
            if($valor == 1){
                $model->asistencia_valor = 0;
            }else{
                $model->asistencia_valor = 10;
            }
            $model->asistencia_estado = 0;
            $model->asistencia_proyectada = 0;

            $result = $this->humanos->guardar_asistencia_($model);

        }catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        echo json_encode($result);
    }

    public function registrar_salida(){
        try{
            $numero_dni = $_POST['numero_dni'];
            $buscar_persona = $this->humanos->buscar_persona_x_dni($numero_dni);
            $id_persona_turno = $buscar_persona->id_persona_turno;

            $asistencia_hora_salida = date('H:i:s');
            $fecha_hoy = date('Y-m-d');

            $result = $this->humanos->guardar_salida($asistencia_hora_salida,$fecha_hoy,$id_persona_turno);

        }catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        echo json_encode($result);
    }

    public function aprobar_asistencia(){
        try{
            $id_departamento =$_POST['id_departamento'];
            $id_sede =$_POST['id_sede'];
            $fecha_elegida = $_POST['fecha'];
            $asistencia_observacion = $_POST['asistencia_observacion'];
            $cadenita_de_oracion = $_POST['cadenita_de_oracion'];
            $cadena_separada = explode('--**--',$cadenita_de_oracion);
            if(count($cadena_separada)>0){
                for ($i=0;$i<count($cadena_separada)-1;$i++){
                    $separar_x_valor = explode('..**..',$cadena_separada[$i]);
                    $id_persona_turno = $separar_x_valor[0];
                    $asistencia_valor= $separar_x_valor[1];
                    $fecha_elegida = $_POST['fecha'];
                    $asistencia_estado = 1;
                    $consultar = $this->humanos->consultar_asistencia_persona_($id_persona_turno,$fecha_elegida);
                    if(empty($consultar)){
                        $model = new RHumanos();
                        $model->id_persona_turno = $id_persona_turno;
                        $model->asistencia_fecha = $fecha_elegida;
                        $model->asistencia_hora = date('H:i:s');
                        $model->asistencia_valor = $asistencia_valor;
                        $model->asistencia_observacion = $asistencia_observacion;
                        $model->asistencia_estado= 1;
                        $model->asistencia_proyectada = 0;
                        $result = $this->humanos->guardar_asistencia_($model);
                    }else{
                        $result = $this->humanos->actualizar_asistencia_($id_persona_turno,$fecha_elegida,$asistencia_valor,$asistencia_observacion,$asistencia_estado);
                    }
                }
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        echo json_encode($result);
    }

    public function guardar_horas(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $id_persona_turno = $_POST['id_persona_turno'];
            $asistencia_horas = $_POST['asistencia_horas'];
            $fecha_elegida = $_POST['fecha_elegida'];

            $result = $this->humanos->actualizar_horas($id_persona_turno,$asistencia_horas,$fecha_elegida);
        }catch (Throwable $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function constancia_trabajo(){
        try{
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            } else {
                throw new Exception('ID sin declarar');
            }
            $person = $this->humanos->list_all($id);
            $periodos = $this->humanos->listar_periodos_persona_($id);
            $empresas=[];
            foreach ($periodos as $p){
                if($p->id_contrato!=8){
                    if(!in_array($p->id_empresa,$empresas)){
                        $empresas[]=$p->id_empresa;
                    }
                }
            }

            require 'app/models/plantilla.php';
            require 'app/models/conversor.php';
            $day=date('d');
            $mes=get_mes(date('m'));
            $year=date('Y');
            $pdf=new PDF_MC_Table();
            $pdf->SetMargins(20, 15, 20);
            foreach ($empresas as $e){
                $data_empresa = $this->humanos->listar_empresa_($e);
                $pdf->AddPage();
                $pdf->SetStyle("p", "arial", "N", 11, "0, 0, 0", 0);
                $pdf->SetStyle("h1", "arial", "BU", 11, "0, 0, 0", 0);
                $pdf->SetStyle("vb", "arial", "B", 0, "0, 0, 0");
                $pdf->SetFont('Arial','BU',14);
                $pdf->Cell(180,2,'CERTIFICADO DE TRABAJO',0,1,'C',0);
                $pdf->Ln('2');
                $pdf->SetFont('Arial','',11);
                $pdf->Ln('5');
                $txt = "<p>El que suscribe Gerente Central de ".$data_empresa->empresa_razon_social." con RUC ".$data_empresa->empresa_ruc." y con domicilio fiscal en ".$data_empresa->empresa_domiciliofiscal." Distrito de ".$data_empresa->empresa_distrito.", Provincia de ".$data_empresa->empresa_provincia.", Departamento de ".$data_empresa->empresa_departamento."</p>";
                $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);

                //$pdf->MultiCell(180,5,"El que suscribe Gerente Central de ".$data_empresa->empresa_nombre." con RUC ".$data_empresa->empresa_ruc." y con domicilio fiscal en ".$data_empresa->empresa_direccion." Distrito de ".$data_empresa->empresa_distrito.", Provincia de ".$data_empresa->empresa_provincia.", Departamento de ".$data_empresa->empresa_departamento,0,'J',0);
                $pdf->Ln('5');
                if($person->persona_sexo=="M"){
                    $aa = " el Sr. ";
                    $iden = " identificado ";
                }else{
                    $aa = " la Sra. ";
                    $iden = " identificada ";
                }
                $txt = "<p>CONSTA: Que ".$aa." ".strtoupper($person->persona_nombre." ".$person->persona_apellido_paterno." ".$person->persona_apellido_materno)." ".$iden." con DNI ".$person->persona_dni.", con domicilio en ".$person->persona_direccion.", Distrito de ".$person->persona_distrito.", Provincia de ".$person->persona_provincia.", Departamento de ".$person->persona_departamento.", ha trabajado en nuestra empresa en los siguientes periodos:</p>";
                $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                //$pdf->MultiCell(180, 5, "CONSTA: Que ".$aa." ".strtoupper($person->person_name." ".$person->person_surname." ".$person->person_surname2)." ".$iden." con DNI ".$person->person_dni.", con domicilio en ".$person->person_address.", Distrito de ".$person->person_city.", Provincia de ".$person->person_region.", Departamento de ".$person->person_country.", ha trabajado en nuestra empresa en los siguientes periodos:", 0, "J", 0);
                $pdf->Ln('5');
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(15,5,"Inicio",1,0,'C',0);
                $pdf->Cell(15,5,"Término",1,0,'C',0);
                $pdf->Cell(33,5,"Tipo de Contrato",1,0,'C',0);
                $pdf->Cell(54,5,"Departamento",1,0,'C',0);
                $pdf->Cell(60,5,"Puesto",1,1,'C',0);
                $pdf->SetFont('Arial','',7);
                $pdf->SetWidths(array(15,15,33,54,60));
                foreach ($periodos as $p){
                    if($p->id_empresa==$e){
                        if($p->id_contrato!=8) {
                            $fecha_ini = date("d-m-Y", strtotime($p->periodo_fechainicio));
                            $fecha_fini = date("d-m-Y", strtotime($p->periodo_fechafin));
                            $pdf->Row(array($fecha_ini, $fecha_fini, $p->contrato_nombre, $p->departamento_nombre, $p->cargo_nombre));
                        }
                    }
                }
                $pdf->Ln(10);
                $pdf->SetFont('Arial','',11);
                $pdf->Cell(180,5,"Se expide el presente certificado para los fines que estime conveniente.",0,2,'J',0);
                $pdf->Cell(180,5,"Iquitos, ".$day." de ".$mes." del ".$year,0,1,'R',0);
                $pdf->Ln(10);
                $pdf->Image(_SERVER_.'media/logo/firma.jpg',null,null,40);
                $pdf->Cell(50,0,'----------------------------------------------------',0,1,'C',0);
                $pdf->Cell(100,5,'REYES VARGAS SHARON GIANELA',0,1,'L',0);
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(115,5,'Gerente Central',0,1,'L',0);
                $pdf->Cell(115,5,$data_empresa->empresa_razon_social,0,1,'L',0);
            }
            $pdf->Output('','Certificado_de_Trabajo_'.$person->persona_nombre.' '.$person->persona_apellido_paterno.' '.$person->persona_apellido_materno);
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
        }
    }

    public function generar_contrato(){
        try{
            $periodo = $this->humanos->listar_periodo_($_GET['id']);
            require 'app/models/plantilla.php';
            require 'app/models/conversor.php';
            $day=date('d');
            $mes=get_mes(date('m'));
            $year=date('Y');
            $persona = $this->humanos->list_all($periodo->id_persona);
            $_SESSION["nombre_empresa"]= $periodo->empresa_razon_social;
            $_SESSION["ruc"]= $periodo->empresa_ruc;
            $dire = 'media/contratos/';
            if($periodo->periodo_contrato== null){
                if($periodo->periodo_nro_contrato==null){
                    $last_periodo = $this->humanos->listar_ultimo_nro_contrato();
                    if(isset($last_periodo->id_periodo)){
                        $nro=$last_periodo->periodo_nro_contrato * 1 + 1;
                    }else{
                        $nro=1000001;
                    }
                }else{
                    $nro=$periodo->periodo_nro_contrato;
                }
                if($periodo->id_contrato==2) {
                    $monto=$periodo->periodo_total;
                    $num_ = explode(".",$monto);
                    $dec = round($num_[1],2);
                    if(strlen($dec)==1){
                        $dec = $dec ."0";
                        ($dec==0) ? $monto = $monto.".00": $monto = $monto."0";
                    }
                    $resultado = convertir($num_[0]);
                    $fecha_ini=explode("-",$periodo->periodo_fechainicio);
                    $fecha_fini=explode("-",$periodo->periodo_fechafin);
                    ($periodo->periodo_fechafirma!="0000-00-00" &&$periodo->periodo_fechafirma!=null)?$fecha_firma =$periodo->periodo_fechafirma : $fecha_firma="0000-00-00";
                    $fecha_firmi=explode("-",$fecha_firma);
                    $pdf=new PDF_WriteTag();
                    $pdf->SetMargins(20, 15, 20);
                    $pdf->SetFont('arial', '', 11);
                    $pdf->AddPage();
                    $pdf->SetStyle("p", "arial", "N", 9, "0, 0, 0", 0);
                    $pdf->SetStyle("h1", "arial", "BU", 11, "0, 0, 0", 0);
                    $pdf->SetStyle("h2", "arial", "U", 11, "0, 0, 0", 0);
                    $pdf->SetStyle("vb", "arial", "B", 0, "0, 0, 0");
                    $pdf->SetFont('Arial','BU',11);
                    $pdf->Cell(180,2,'CONTRATO DE TRABAJO SUJETO A MODALIDAD',0,1,'C',0);
                    $pdf->Ln('2');
                    $pdf->SetFont('Arial','',9);
                    $pdf->Cell(180,5,"Contrato Laboral N° ".$nro." - ".$year." - ".$_SESSION['nombre_empresa'],0,1,'C',0);
                    $pdf->Ln('5');
                    $txt="<p>Conste por el presente documento el Contrato Sujeto a modalidad de Naturaleza Temporal por <vb>Necesidad del Mercado</vb> que celebran, de conformidad con la <vb>Ley de Promoción de la Competitividad, Formalización y Desarrollo de la Micro y Pequeña Empresa y del Acceso al empleo decente, Decreto Legislativo N° 1086, aprobado por D.S N°007-2008-TR y su Reglamento aprobado por el Decreto Supremo N° 008-2008,</vb> que celebran de una parte la empresa <vb>".$_SESSION['nombre_empresa']."</vb> con R.U.C. Nº ".$_SESSION['ruc']." y domicilio fiscal en ".$periodo->empresa_domiciliofiscal.", debidamente representada por <vb>COLLAZOS VARGAS CLAUDIA ANGELICA</vb> identificada con D.N.I. Nº <vb>76062022</vb>, quien se desempeña como Gerente General, a quien en adelante se le denominará <vb>EL EMPLEADOR</vb>; y de la otra parte <vb>".$persona->persona_nombre." ".$persona->persona_apellido_paterno." ".$persona->persona_apellido_materno."</vb> con D.N.I. Nº <vb>".$persona->persona_dni."</vb>, de nacionalidad <vb>".$persona->persona_nacionalidad."</vb>, domiciliado en ".$persona->persona_direccion." ,".$persona->persona_distrito.", ".$persona->persona_provincia.", ".$persona->persona_departamento.", a quien en adelante se le denominará <vb>EL TRABAJADOR</vb>; en los términos y condiciones siguientes:</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>PRIMERO:</vb> DE LA ACTIVIDAD DE LA EMPRESA.- <vb>EL EMPLEADOR</vb> es una empresa dedicada a la actividad empresarial de <vb>RESTAURANTES Y SERVICIO MOVIL DE COMIDA. LA EMPRESA</vb> requiere para el desarrollo de actividades las labores de personal para <vb>ATENCION AL CLIENTE</vb>, cumpliendo <vb>EL TRABAJADOR</vb> las condiciones necesarias para la prestación de los servicios.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>SEGUNDO:</vb> En función de lo expuesto en el párrafo precedente,<vb>EL EMPLEADOR</vb> requiere contratar personal idóneo a plazo determinado para cumplir con las actividades expuestas.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>TERCERO:</vb>DEL OBJETO DEL CONTRATO.- Por el presente contrato y de conformidad con la <vb>Ley de Promoción de la Competitividad, Formalización y Desarrollo de la Micro y Pequeña Empresa y del Acceso al empleo decente, Decreto Legislativo N° 1086, aprobado por D.S. N° 007-2008-TR y su Reglamento aprobado por el Decreto Supremo N° 008-2008, EL EMPLEADOR</vb> contrata a <vb>EL TRABAJADOR</vb> bajo la modalidad de Contrato por Necesidad del Mercado para que desarrolle las labores de <vb>ATENCION AL CLIENTE</vb>.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>CUARTA:</vb> DE LA PRESTACION DE SERVICIOS.- <vb>EL TRABAJADOR</vb> desempeñara sus laborales en el cargo de <vb>".$periodo->cargo_nombre."</vb>; <vb>EL EMPLEADOR</vb> esta facultado a efectuar modificaciones razonables en función de la capacidad y aptitud de <vb>EL TRABAJADOR</vb> y a las necesidades y requerimientos de este, sin que dichas variaciones signifiquen menoscabo de categoria y/o remuneración. Queda entendido que la prestación de servicios deberá ser efectuada de manera personal, no pudiendo <vb>EL TRABAJADOR</vb> ser reemplazado ni ayudado por tercera persona.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>QUINTA:</vb> DE LA JORNADA Y HORARIO DE TRABAJO.- Las partes estipulan que la jornada y el horario laboral de <vb>EL TRABAJADOR</vb> acuerdan de común acuerdo que la jornada máxima de trabajo será de cuarentiocho (48) horas semanales, de lunes a domingo, estableciendo <vb>EL EMPLEADOR</vb> turnos rotativos, además del dia de descanzo obligatorio durante la semana. <vb>EL EMPLEADOR</vb> esta facultado a efectuar modificaciones en la jornada de trabao, de acuerdo con el procedimiento establecido en el articulo 2 del Texto Único Ordenado del Decreto Legislativo N° 854, Ley de Jornada de Trabajo, Horario y Trabajo de Sobretiempo, aprobado por Decreto Supremo N° 007-2002-TR, respetando el máximo legal de 48 horas semanales.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>SEXTA:</vb> DE LA REMUNERACION.- <vb>EL TRABAJADOR</vb> percibirá como contraprestación por sus servicios una remuneración mensual ascendente a la suma de <vb>S/. ".$periodo->periodo_total." ($resultado CON $dec/00 Nuevos Soles)</vb>; durante el tiempo de duración de la relación laboral, así como los beneficios que por ley corresponden. Las ausencias injustificadas de la por parte de <vb>EL TRABAJADOR</vb> implican la perdida de la remuneración proporcionalmente a la duración de dicha ausencia, sin perjuicio del ejercicio de las facultades disciplinarias propias de <vb>EL EMPLEADOR</vb> previstas en la legislación laboral y normas internas de <vb>EL EMPLEADOR</vb>.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>SEPTIMA:</vb> DE LA VIGENCIA DEL CONTRATO.- El presente contrato <vb>SE RENUEVA</vb> y tendrá una vigencia desde <vb>".$fecha_ini[2]."-".$fecha_ini[1]."-".$fecha_ini[0]."</vb> y vencerá el <vb>".$fecha_fini[2]."-".$fecha_fini[1]."-".$fecha_fini[0]."</vb>, sin que exista comunicación previa de su extinción. A la conclusión del contrato <vb>EL EMPLEADOR</vb> abonara a <vb>EL TRABAJADOR</vb>, los beneficios sociales que le corresponde de acuerdo con la legislación laboral vigente. No obstante lo antes mencionado el presente contrato podrá prorrogarse de común acuerdo. La suspención del contrato de trabajo por alguna de las causales previstas en la ley, no interrumpirá el plazo de duración de este.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>OCTAVO:</vb> DE LAS VACACIONES DEL TRABAJADOR.- <vb>EL TRABAJADOR</vb> tendrá derecho a un mínimo de 15 (quince) días de descanzo vacacional por año de trabajo o su parte proporcional.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>NOVENA:</vb> DE LAS OBLIGACIONES DEL TRABAJADOR.- <vb>EL TRABAJADOR</vb> se compromete a cumplir con lealtad y eficiencia las labores principales, conexas y complementarias inherentes a su puesto de trabajo, aplicando para tal fin toda su experiencia y capacidad, y velando por los intereses de <vb>EL EMPLEADOR</vb>. Asimismo, deberá ejercer las funciones propias de su cargo con la mayor diligencia y responsabilidad.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>DECIMO:</vb> DE LA CONFIDENCIALIDAD.- <vb>EL TRABAJADOR</vb> se compromete a guardar confidencialidad del caso, en el desempeño de sus funciones, ante su incumplimiento <vb>EL EMPLEADOR</vb> podrá prescindir de sus servicios.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>DECIMO PRIMERO:</vb> DE LA RESCISIÓN DEL CONTRATO.- Las partes pactan que este contrato podrá ser rescindido por las causales establecidas en el articulo 16 de la LPCL.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>DECIMO SEGUNDO:</vb> DE LA JURISDICCIÓN Y COMPETENCIA.- Las partes acuerdan que en caso de existir conflictos sobre la aplicación de la legislación aplicable, se somete a la jurisdicción y competencia de los jueces de la Provincia de Maynas.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>DECIMO TERCERO:</vb> El presente contrato será puesto en conocimiento de la Autoridad Administrativa de Trabajo, para su registro y fines legales, establecidos en la LPFMYPE.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p>Ambas partes declaran estar de acuerdo en todas las cláusulas del presente contrato y proceden a suscribirlos y autorizarlos en señal de conformidad, en la Ciudad de Iquitos, a los $day días del mes $mes del año $year.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    //$pdf->Image(_SERVER_.'styles/brunner/img/firma.jpg',null,null,40);
                    $pdf->Cell(50,0,'----------------------------------------------',0,0,'C',0);
                    $pdf->Cell(110,0,'-------------------------------------------------------',0,1,'R',0);
                    $pdf->Cell(100,5,'Collazos Vargas Claudia Angélica',0,0,'L',0);
                    $pdf->Cell(80,5,$persona->persona_apellido_paterno." ".$persona->persona_apellido_materno." ".$persona->persona_nombre,0,1,'L',0);
                    $pdf->SetFont('Arial','B',9);
                    $pdf->Cell(100,5,'DNI : 70078191',0,0,'L',0);
                    $pdf->Cell(80,5,'DNI:'.$persona->persona_dni,0,1,'L',0);
                    $pdf->Cell(115,5,'EL EMPLEADOR',0,0,'L',0);
                    $pdf->Cell(80,5,'EL TRABAJADOR',0,1,'L',0);
                    $nombre="$nro.pdf";
                    $pdf->Output("F",$dire.$nombre);
                    $this->humanos->generar_contrato($nro,$_GET['id']);
                    //$pdf->Output();
                    $name_download= $nro."_".$persona->persona_apellido_paterno."_".$fecha_firmi[2]."-".$fecha_firmi[1]."-".$fecha_firmi[0];
                    header("Content-type: application/pdf");
                    header("Content-Disposition: inline; filename=$name_download");
                    readfile($dire.$nombre);
                }elseif($periodo->id_contrato==3)
                {
                    $monto=$periodo->periodo_sueldo;
                    $monto2=$periodo->periodo_movilidad;
                    $num_ = explode(".",$monto);
                    $num_2 = explode(".",$monto2);
                    $dec = round($num_[1],2);
                    $dec2 = round($num_2[1],2);
                    if(strlen($dec)==1){
                        $dec = $dec ."0";
                        ($dec==0) ? $monto = $monto.".00": $monto = $monto."0";
                    }
                    if(strlen($dec2)==1){
                        $dec2 = $dec2 ."0";
                        ($dec2==0) ? $monto2 = $monto2.".00": $monto2 = $monto2."0";
                    }
                    $dx=$_GET['dedx'];$dy=$_GET['dedy'];
                    $resultado = convertir($num_[0]);
                    $resultado2 = convertir($num_2[0]);
                    $fecha_ini=explode("-",$periodo->periodo_fechainicio);
                    $fecha_fini=explode("-",$periodo->periodo_fechafin);
                    ($periodo->periodo_fechafirma!="0000-00-00" &&$periodo->periodo_fechafirma!=null)?$fecha_firma =$periodo->periodo_fechafirma : $fecha_firma="0000-00-00";
                    $fecha_firmi=explode("-",$fecha_firma);
                    $pdf=new PDF_WriteTag();
                    $pdf->SetMargins(20, 15, 20);
                    $pdf->SetFont('arial', '', 11);
                    $pdf->AddPage();
                    $pdf->SetStyle("p", "arial", "N", 9, "0, 0, 0", 0);
                    $pdf->SetStyle("h1", "arial", "BU", 11, "0, 0, 0", 0);
                    $pdf->SetStyle("vb", "arial", "B", 0, "0, 0, 0");
                    $pdf->SetFont('Arial','BU',11);
                    $pdf->Cell(180,2,'CONTRATO DE TRABAJO DE OBRA DETERMINADA O SERVICIO ESPECÍFICO',0,1,'C',0);
                    $pdf->Ln('2');
                    $pdf->SetFont('Arial','',9);
                    $pdf->Cell(180,5,"Contrato Laboral N° ".$nro." - ".$year." - ".$_SESSION['nombreempresa'],0,1,'C',0);
                    $pdf->Ln('5');
                    // Text
                    $txt="<p>Conste por el presente documento el Contrato de Trabajo a plazo fijo bajo la modalidad de \"Contrato para Obra Determinada\" o \"Servicio Específico\", que celebran al amparo del Art. 63º de la Ley de Productividad y Competitividad Laboral aprobado por D. S. Nº 003-97-TR, y normas complementarias, de una parte <vb>".$_SESSION['nombre_empresa']."</vb> con R.U.C. Nº ".$_SESSION['ruc']." y  domicilio fiscal en ".$periodo->empresa_domiciliofiscal." debidamente representada por <vb>NOMBRE DEL REPRESENTANTE</vb> con D.N.I. Nº <vb>SU DNI</vb>, quien se desempeña como Gerente Central, a quien en adelante se le denominará <vb>EL EMPLEADOR</vb>; y de la otra parte <vb>".$persona->persona_nombre." ".$persona->persona_apellido_paterno." ".$persona->persona_apellido_materno."</vb> con D.N.I. Nº <vb>".$persona->persona_dni."</vb>, domiciliado en ".$persona->persona_direccion." ,".$persona->persona_distrito.", ".$persona->persona_provincia.", ".$persona->persona_departamento.", correo electrónico ".$persona->persona_email.", y teléfono celular ".$persona->persona_telefono." a quien en adelante se le denominará <vb>EL TRABAJADOR</vb>; en los términos y condiciones siguientes: </p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>PRIMERO: EL EMPLEADOR</vb> es una sociedad cuyo objeto social es dedicarse a las actividad de gestión de residuos de sólidos, desde su acondicionamiento, recolección, transporte, tratamiento, comercialización y disposición final tanto peligroso y no peligrosos del ámbito municipal y no municipal, Limpieza y Remediacion de contingencias ambientales generados por el derrame de hidrocarburos y otros materiales peligrosos entre otras actividades derivadas o conexas permitidas por ley, para lo cual cuenta con la infraestructura, equipos y recursos necesarios para realizar estas labores, y requiere de los servicios del <vb>TRABAJADOR</vb> para el cumplimiento de un servicio específico.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>SEGUNDO:</vb> Por el presente documento <vb>EL EMPLEADOR</vb> contrata a <vb>plazo fijo de Obra determinada o Servicio Especifico</vb>, los servicios de <vb>EL TRABAJADOR</vb> quien desempeñará el cargo de <vb>".$periodo->cargo_nombre."</vb> bajo la dependencia del Departamento de <vb>".$periodo->departamento_nombre."</vb>  asignadas en una de las actividades señaladas en la cláusula primera. El centro laboral asignado para <vb>EL TRABAJADOR</vb> es en el/la <vb>".$periodo->sede_nombre."</vb>.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>TERCERO:</vb> El presente contrato se iniciará el <vb>".$fecha_ini[2]."-".$fecha_ini[1]."-".$fecha_ini[0]."</vb> y vencerá el <vb>".$fecha_fini[2]."-".$fecha_fini[1]."-".$fecha_fini[0]."</vb>. El régimen laboral será de <vb>$dx días de trabajo por $dy días de descanso.</vb> </p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>CUARTO: EL TRABAJADOR</vb> conviene y acepta en brindar los servicios a que se contrae la presente contratación, con sujeción a los horarios fijos y/o rotativos que pudiera establecer <vb>EL EMPLEADOR</vb> de acuerdo a la naturaleza y requerimientos de sus actividades operativas, encontrándose en consecuencia, facultada a través de una comunicación escrita variar el Centro Laboral de <vb>EL TRABAJADOR</vb> en atención a sus necesidades operativas.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>QUINTO: EL TRABAJADOR</vb> deberá cumplir con las normas propias del Centro de Trabajo, así como las contenidas en el Reglamento Interno de Trabajo, Manual de Organización y Funciones, y en las demás normas laborales, y las que se impartan por necesidades del servicio en ejercicio de las facultades de administración de la empresa, de conformidad con el Art. 9º TUO del D. Leg. Nº 728 aprobado por D. S. Nº 00397-TR Ley de Productividad y Competitividad Laboral. </p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>SEXTO: EL EMPLEADOR</vb> abonará al <vb>TRABAJADOR</vb> la cantidad de <vb>S/. ".$periodo->periodo_sueldo." ($resultado CON $dec/00 Nuevos Soles)</vb> como remuneración mensual, de la cual se deducirá las aportaciones y descuentos por tributos establecidos en la ley que le resulten aplicables. ";
                    if($periodo->periodo_movilidad>0){
                        $txt.="<vb>EL EMPLEADOR</vb> abonará también al <vb> TRABAJADOR </vb> la cantidad de <vb>S/. ".$periodo->periodo_movilidad."</vb> ($resultado2 CON $dec2/00 Nuevos Soles), a modo de bonificación extraordinaria, de forma excepcional, por concepto de trabajo en zona y/o localidad alejada (campamento en zona indígena). Esta bonificación no tiene carácter remunerativo por su carencia de regularidad.";
                    }
                    $txt.="</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>SÉPTIMO:</vb> Queda entendido que <vb>EL EMPLEADOR</vb> no está obligado a dar aviso alguno adicional referente al término del presente contrato, operando su extinción en la fecha de su vencimiento conforme la cláusula tercera, oportunidad en la cual se abonará al <vb>TRABAJADOR</vb> los beneficios sociales que le pudieran corresponder de acuerdo a ley. </p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>OCTAVO:</vb> Este contrato queda sujeto a las disposiciones que contiene el TUO del D. Leg. Nº 728 aprobado por D. S. Nº 003-97-TR Ley de Productividad y Competitividad Laboral, y demás normas legales que lo regulen o que sean dictadas durante la vigencia del contrato. </p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>NOVENO:</vb> En cumplimiento con el inciso \"c\" del artículo 35 de la Ley 29783 Ley de Seguridad y Salud en el Trabajo y su reglamento DS-005-2012-TR, se indican los riesgos a los que estará expuesto el trabajador:</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>-   Riesgo de accidente de tránsito, durante sus desplazamientos.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>-  Riesgos disergonómicos que puedan ocasionar disturbios músculo - esqueléticos.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>-  Riesgos relacionados a las condiciones ambientales y climáticas de su zona de trabajo.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p><vb>DÉCIMO:</vb> Son causales de despido inmediato las faltas graves siguientes:</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- El incumplimiento de las obligaciones de trabajo que supone el quebrantamiento de la buena fe laboral.</p>";
                    $pdf->WriteTag(0, 3, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- La reiterada resistencia a las órdenes relacionadas con las labores encomendadas por el empleador.</p>";
                    $pdf->WriteTag(0, 3, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- La reiterada paralización intempestiva de labores y la inobservancia del Reglamento Interno de Trabajo o del Reglamento de Seguridad e Higiene Industrial gravedad, que revistan de gravedad.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- La disminución deliberada y reiterada en el rendimiento de las labores o del volumen o de la calidad de producción.</p>";
                    $pdf->WriteTag(0, 3, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- La apropiación consumada o frustrada de bienes o servicios del empleador o que se encuentran bajo su custodia, así como la retención o utilización indebidas de los mismos, en beneficio propio o de terceros, con prescindencia de su valor.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- El uso o entrega a terceros de información reservada del empleador.</p>";
                    $pdf->WriteTag(0, 3, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- La sustracción o utilización no autorizada de documentos de la empresa.</p>";
                    $pdf->WriteTag(0, 3, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- La información falsa al empleador con la intención de causarle perjuicio u obtener una ventaja.</p>";
                    $pdf->WriteTag(0, 3, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- La competencia desleal.</p>";
                    $pdf->WriteTag(0, 3, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- La concurrencia reiterada en estado de embriaguez o bajo influencia de drogas o sustancias estupefacientes, y aunque no sea reiterada cuando por la naturaleza de la función o del trabajo revista excepcional gravedad.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- Los actos de violencia, grave indisciplina, injuria y falta de palabra verbal o escrita en agravio del empleador, de sus representantes, del personal jerárquico o de otros trabajadores, sea que se cometan dentro del centro de trabajo o fuera de él cuando los hechos se deriven directamente de la relación laboral. </p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- El daño intencional a los edificios, instalaciones, obras, maquinarias, instrumentos, documentación, materias primas y demás bienes de propiedad de la empresa -   o en posesión de ésta. </p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- El abandono de trabajo por más de tres (3) días consecutivos.</p>";
                    $pdf->WriteTag(0, 3, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- La impuntualidad reiterada, si ha sido acusada por el empleador, siempre que se hayan aplicado sanciones disciplinarias previas de amonestaciones escritas y suspensiones.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- El hostigamiento sexual cometido por los representantes del empleador o quien ejerza autoridad sobre el trabajador, así como el cometido por un trabajador cualquiera sea la ubicación de la víctima del hostigamiento en la estructura jerárquica del centro de trabajo</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- A solicitud del cliente u organismo relacionados al servicio.</p>";
                    $pdf->WriteTag(0, 3, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- El incumplimiento de las obligaciones de trabajo que supone el quebrantamiento de la buena fe laboral.</p>";
                    $pdf->WriteTag(0, 3, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p><vb>DECIMO PRIMERO:</vb> En el anexo 01 se le informa sobre su régimen atípico (Los días de Trabajo y los días de Descanso) durante su periodo laboral. Si por razones operativas y previa aprobación de Gerencia, se le aprueba laborar el día de descanso, se le retribuirá un sobrecargo del 100% sobre la remuneración diaria, en el caso de ser feriado, será un sobrecargo del 200% de la remuneración diaria.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p><vb>DECIMO SEGUNDO:</vb> Para los efectos de las comunicaciones que las partes tengan a bien realizarse, se tendrán como válidas las comunicaciones que, de forma indistinta, se remitan y sean recibidas en cualquiera de los domicilios y/o lugares, teléfonos o correo electrónico que aparecen descritos en el exordio del presente contrato.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>Conforme con todas las cláusulas anteriores, firman las partes, por triplicado a los $day días del mes $mes del año $year</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    //$pdf->Image(_SERVER_.'styles/brunner/img/firma.jpg',null,null,40);
                    $pdf->Cell(50,0,'----------------------------------------------',0,0,'C',0);
                    $pdf->Cell(110,0,'-------------------------------------------------------',0,1,'R',0);
                    $pdf->Cell(100,5,'NOMBRE DEL GERENTE GENERAL',0,0,'L',0);
                    $pdf->Cell(80,5,$persona->persona_apellido_paterno." ".$persona->persona_apellido_materno." ".$persona->persona_nombre,0,1,'L',0);
                    $pdf->SetFont('Arial','B',9);
                    $pdf->Cell(115,5,'EL EMPLEADOR',0,0,'L',0);
                    $pdf->Cell(80,5,'EL TRABAJADOR',0,1,'L',0);
                    $pdf->AddPage();
                    $pdf->SetFont('Arial','BU',11);
                    $pdf->Cell(180,2,'ANEXO 01',0,1,'C',0);
                    $pdf->Ln('5');
                    $pdf->SetFont('Arial','',10);
                    $pdf->Cell(50,5,"Apellidos y Nombres:",0,1,'L',0);
                    $pdf->SetFont('Arial','B',10);
                    $pdf->Cell(50,5,$persona->persona_apellido_paterno." ".$persona->persona_apellido_materno." ".$persona->persona_nombre,0,1,'L',0);
                    $pdf->SetFont('Arial','',10);
                    $pdf->Cell(15,5,"DNI",0,1,'L',0);
                    $pdf->SetFont('Arial','B',10);
                    $pdf->Cell(15,5,$persona->persona_dni,0,1,'L',0);
                    $pdf->SetFont('Arial','',9);
                    $pdf->Cell(10,5,"#",1,0,'C',0);
                    $pdf->Cell(115,5,"Puesto",1,0,'C',0);
                    $pdf->Cell(25,5,"Fecha",1,0,'C',0);
                    $pdf->Cell(30,5,"Asistencia",1,1,'C',0);
                    $f1=strtotime($periodo->periodo_fechainicio);
                    $f2=strtotime($periodo->periodo_fechafin);
                    $a=1;
                    $cond=1;
                    $ass=1;
                    //$asistencia = new Asistencia();
                    $pdf->SetFont('Arial','',8);
                    //$asist = "ASISTIO";
                    for($i=$f1;$i<=$f2;$i+=86400) {
                        $fecha_ap = date('Y-m-d', $i);
                        if($ass==1){
                            if($cond==$dx){
                                $cond = 1;
                                $ass = 0;
                            }else{
                                if($asistencia->es_feriado($fecha_ap)){
                                    //$asist="ASISTIO + 100%";
                                    $asist="DIA TRAB + 100%";
                                    $valor_asist = 5;
                                }else{
                                    $asist="DIA TRABAJADO";
                                    $valor_asist = 1;
                                }
                                $cond++;
                            }
                        }else{
                            if($cond==$dy){
                                $cond = 1;
                                $ass = 1;
                            }else{
                                $asist="DESCANSO REM.";
                                $valor_asist = 15;
                                $cond++;
                            }
                        }
                        if($this->humanos->buscar_asistencia_persona_fecha_si_hay($persona->id_persona,$fecha_ap)){
                            $this->humanos->guardar_asistencia_aprobada($persona->id_persona, $fecha_ap, $valor_asist);
                        }
                        $pdf->CellFitSpace(10,5,$a,0,0,'C',0);
                        $pdf->CellFitSpace(115,5,$periodo->cargo_nombre,0,0,'C',0);
                        $pdf->CellFitSpace(25,5,$fecha_ap,0,0,'C',0);
                        $pdf->CellFitSpace(30,5,$asist,0,1,'C',0);
                        $a++;
                    }
                    $pdf->Ln('5');
                    $nombre="$nro.pdf";
                    $pdf->Output("F",$dire.$nombre);
                    $this->humanos->generar_contrato($nro,$_GET['id']);
                    //$pdf->Output();
                    $name_download= $nro."_".$persona->persona_apellido_paterno."_".$fecha_firmi[2]."-".$fecha_firmi[1]."-".$fecha_firmi[0];
                    header("Content-type: application/pdf");
                    header("Content-Disposition: inline; filename=$name_download");
                    readfile($dire.$nombre);
                }elseif ($periodo->id_contrato==7){
                    $fecha_ini=explode("-",$periodo->periodo_fechainicio);
                    $fecha_fini=explode("-",$periodo->periodo_fechafin);
                    $fecha_ini_1= new DateTime($periodo->periodo_fechainicio);
                    $fecha_fin_1= new DateTime($periodo->periodo_fechafin);
                    ($periodo->periodo_fechafirma!="0000-00-00" &&$periodo->periodo_fechafirma!=null)?$fecha_firma =$periodo->periodo_fechafirma : $fecha_firma="0000-00-00";
                    $fecha_firmi=explode("-",$fecha_firma);
                    $diferencia =$fecha_ini_1->diff($fecha_fin_1);
                    $meses = ($diferencia->y * 12) + $diferencia->m;
                    if($meses<6){
                        $grati = 0;
                    }elseif($meses<12){
                        $grati = $periodo->periodo_total;
                    }else{
                        $grati = $periodo->periodo_total * 2;
                    }
                    $monto=$periodo->periodo_total + $grati;

                    $num_ = explode(".",$monto);
                    $dec = round($num_[1],2);
                    if(strlen($dec)==1){
                        $dec = $dec ."0";
                        ($dec==0) ? $monto = $monto.".00": $monto = $monto."0";
                    }
                    $resultado = convertir($num_[0]);
                    $pdf=new PDF_WriteTag();
                    $pdf->SetMargins(20, 15, 20);
                    $pdf->SetFont('arial', '', 11);
                    $pdf->AddPage();
                    $pdf->SetStyle("p", "arial", "N", 9, "0, 0, 0", 0);
                    $pdf->SetStyle("h1", "arial", "BU", 11, "0, 0, 0", 0);
                    $pdf->SetStyle("vb", "arial", "B", 0, "0, 0, 0");
                    $pdf->SetFont('Arial','BU',11);
                    $pdf->Cell(180,2,'CONTRATO DE TRABAJO DEL PERSONAL EXTRANJERO',0,1,'C',0);
                    $pdf->Ln('2');
                    $pdf->SetFont('Arial','',9);
                    $pdf->Cell(180,5,"Contrato Laboral N° ".$nro." - ".$year." - ".$_SESSION['nombre_empresa'],0,1,'C',0);
                    $pdf->Ln('5');
// Text
                    $txt="<p>Conste por el presente documento el Contrato de Trabajo a plazo fijo bajo la modalidad de \"Contrato para Obra Determinada\" o \"Servicio Específico\", que celebran al amparo del Art. 63º de la Ley de Productividad y Competitividad Laboral aprobado por D. S. Nº 003-97-TR, y normas complementarias, de una parte <vb>".$_SESSION['nombre_empresa']."</vb> con R.U.C. Nº ".$_SESSION['ruc']." y  domicilio fiscal en ".$periodo->empresa_domiciliofiscal." debidamente representada por <vb>NOMBRE DEL REPRESENTANTE</vb> con D.N.I. Nº <vb>SU DNI</vb>, quien se desempeña como Gerente Central, a quien en adelante se le denominará <vb>EL EMPLEADOR</vb>; y de la otra parte <vb>".$persona->persona_nombre." ".$persona->persona_apellido_paterno." ".$persona->persona_apellido_materno."</vb> con ".$persona->persona_tipo_documento." Nº <vb>".$persona->persona_dni."</vb>, domiciliado en ".$persona->persona_direccion." ,".$persona->persona_distrito.", ".$persona->persona_provincia.", ".$persona->persona_departamento.", de Nacionalidad ".$persona->persona_nacionalidad." a quien en adelante se le denominará <vb>EL TRABAJADOR</vb>; en los términos y condiciones siguientes: </p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>PRIMERO: EL EMPLEADOR</vb> es una sociedad cuyo objeto social es dedicarse a las actividad de gestión de residuos de sólidos, desde su acondicionamiento, recolección, transporte, tratamiento, comercialización y disposición final tanto peligroso y no peligrosos del ámbito municipal y no municipal, Limpieza y Remediacion de contingencias ambientales generados por el derrame de hidrocarburos y otros materiales peligrosos entre otras actividades derivadas o conexas permitidas por ley, para lo cual cuenta con la infraestructura, equipos y recursos necesarios para realizar estas labores, y requiere de los servicios del <vb>TRABAJADOR</vb> para el cumplimiento de un servicio específico.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>SEGUNDO:</vb> Por el presente documento <vb>EL EMPLEADOR</vb> contrata a <vb>plazo fijo de Obra determinada o Servicio Especifico</vb>, los servicios de <vb>EL TRABAJADOR</vb> quien desempeñará el cargo de <vb>".$periodo->cargo_nombre."</vb> bajo la dependencia del Departamento de <vb>".$periodo->departamento_nombre."</vb>  asignadas en una de las actividades señaladas en la cláusula primera. El centro laboral asignado para <vb>EL TRABAJADOR</vb> es en el/la <vb>".$periodo->sede_nombre."</vb>.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>TERCERO:</vb> El presente contrato se iniciará el <vb>".$fecha_ini[2]."-".$fecha_ini[1]."-".$fecha_ini[0]."</vb> y vencerá el <vb>".$fecha_fini[2]."-".$fecha_fini[1]."-".$fecha_fini[0]."</vb> </p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>CUARTO: EL TRABAJADOR</vb> conviene y acepta en brindar los servicios a que se contrae la presente contratación, con sujeción a los horarios fijos y/o rotativos que pudiera establecer <vb>EL EMPLEADOR</vb> de acuerdo a la naturaleza y requerimientos de sus actividades operativas, encontrándose en consecuencia, facultada a través de una comunicación escrita variar el Centro Laboral de <vb>EL TRABAJADOR</vb> en atención a sus necesidades operativas.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>QUINTO: EL TRABAJADOR </vb>deberá cumplir con las normas propias del Centro de Trabajo, así como las contenidas en el Reglamento Interno de Trabajo, Manual de Organización y Funciones, y en las demás normas laborales, y las que se impartan por necesidades del servicio en ejercicio de las facultades de administración de la empresa, de conformidad con el Art. 9º TUO del D. Leg. Nº 728 aprobado por D. S. Nº 00397-TR Ley de Productividad y Competitividad Laboral. </p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>SEXTO: EL EMPLEADOR</vb> abonará al <vb>TRABAJADOR</vb> la cantidad dineraria de <vb>S/. ".$periodo->periodo_total."</vb> como remuneración mensual por <vb>$meses</vb> meses haciendo un total de <vb>S/. ".$periodo->periodo_total."</vb> más <vb>S/. $grati </vb> por concepto de gratificaciones haciendo una Remuneración Total de <vb> S/. $monto ($resultado CON $dec/00 Nuevos Soles)</vb>.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>SEPTIMO:</vb> Queda entendido que <vb>EL EMPLEADOR</vb> no está obligado a dar aviso alguno adicional referente al término del presente contrato, operando su extinción en la fecha de su vencimiento conforme la cláusula tercera, oportunidad en la cual se abonará al <vb>TRABAJADOR</vb> los beneficios sociales que le pudieran corresponder de acuerdo a ley. </p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>OCTAVO:</vb> Este contrato queda sujeto a las disposiciones que contiene el TUO del D. Leg. Nº 728 aprobado por D. S. Nº 003-97-TR Ley de Productividad y Competitividad Laboral, y demás normas legales que lo regulen o que sean dictadas durante la vigencia del contrato. </p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    $txt="<p><vb>NOVENO:</vb> En cumplimiento con el inciso \"c\" del artículo 35 de la Ley 29783 Ley de Seguridad y Salud en el Trabajo y su reglamento DS-005-2012-TR, se indican los riesgos a los que estará expuesto el trabajador:</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>-   Riesgo de accidente de tránsito, durante sus desplazamientos.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>-  Riesgos disergonómicos que puedan ocasionar disturbios músculo - esqueléticos.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>-  Riesgos relacionados a las condiciones ambientales y climáticas de su zona de trabajo.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p><vb>DECIMO:</vb> Son causales de despido inmediato las faltas graves siguientes:</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- El incumplimiento de las obligaciones de trabajo que supone el quebrantamiento de la buena fe laboral.</p>";
                    $pdf->WriteTag(0, 3, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- La reiterada resistencia a las órdenes relacionadas con las labores encomendadas por el empleador.</p>";
                    $pdf->WriteTag(0, 3, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- La reiterada paralización intempestiva de labores y la inobservancia del Reglamento Interno de Trabajo o del Reglamento de Seguridad e Higiene Industrial gravedad, que revistan de gravedad.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- La disminución deliberada y reiterada en el rendimiento de las labores o del volumen o de la calidad de producción.</p>";
                    $pdf->WriteTag(0, 3, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- La apropiación consumada o frustrada de bienes o servicios del empleador o que se encuentran bajo su custodia, así como la retención o utilización indebidas de los mismos, en beneficio propio o de terceros, con prescindencia de su valor.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- El uso o entrega a terceros de información reservada del empleador.</p>";
                    $pdf->WriteTag(0, 3, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- La sustracción o utilización no autorizada de documentos de la empresa.</p>";
                    $pdf->WriteTag(0, 3, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- La información falsa al empleador con la intención de causarle perjuicio u obtener una ventaja.</p>";
                    $pdf->WriteTag(0, 3, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- La competencia desleal.</p>";
                    $pdf->WriteTag(0, 3, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- La concurrencia reiterada en estado de embriaguez o bajo influencia de drogas o sustancias estupefacientes, y aunque no sea reiterada cuando por la naturaleza de la función o del trabajo revista excepcional gravedad.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- Los actos de violencia, grave indisciplina, injuria y falta de palabra verbal o escrita en agravio del empleador, de sus representantes, del personal jerárquico o de otros trabajadores, sea que se cometan dentro del centro de trabajo o fuera de él cuando los hechos se deriven directamente de la relación laboral. </p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- El daño intencional a los edificios, instalaciones, obras, maquinarias, instrumentos, documentación, materias primas y demás bienes de propiedad de la empresa -   o en posesión de ésta. </p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- El abandono de trabajo por más de tres (3) días consecutivos.</p>";
                    $pdf->WriteTag(0, 3, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- La impuntualidad reiterada, si ha sido acusada por el empleador, siempre que se hayan aplicado sanciones disciplinarias previas de amonestaciones escritas y suspensiones.</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- El hostigamiento sexual cometido por los representantes del empleador o quien ejerza autoridad sobre el trabajador, así como el cometido por un trabajador cualquiera sea la ubicación de la víctima del hostigamiento en la estructura jerárquica del centro de trabajo</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>- A solicitud del cliente u organismo relacionados al servicio.</p>";
                    $pdf->WriteTag(0, 3, $txt, 0, "J", 0, 0);
                    $pdf->Ln('2');
                    $txt="<p>Conforme con todas las cláusulas anteriores, firman las partes, por triplicado a los $day días del mes $mes del año $year</p>";
                    $pdf->WriteTag(0, 5, $txt, 0, "J", 0, 0);
                    $pdf->Ln('5');
                    //$pdf->Image(_SERVER_.'styles/brunner/img/firma.jpg',null,null,40);
                    $pdf->Cell(50,0,'----------------------------------------------',0,0,'C',0);
                    $pdf->Cell(110,0,'-------------------------------------------------------',0,1,'R',0);
                    $pdf->Cell(100,5,'NOMBRE DEL GERENTE GENERAL',0,0,'L',0);
                    $pdf->Cell(80,5,$persona->persona_apellido_paterno." ".$persona->persona_apellido_materno." ".$persona->persona_nombre,0,1,'L',0);
                    $pdf->SetFont('Arial','B',9);
                    $pdf->Cell(115,5,'EL EMPLEADOR',0,0,'L',0);
                    $pdf->Cell(80,5,'EL TRABAJADOR',0,1,'L',0);
                    $nombre="$nro.pdf";
                    $pdf->Output("F",$dire.$nombre);
                    $this->humanos->generar_contrato($nro,$_GET['id']);
                    //$pdf->Output();
                    $name_download= $nro."_".$persona->persona_apellido_paterno."_".$fecha_firmi[2]."-".$fecha_firmi[1]."-".$fecha_firmi[0];
                    header("Content-type: application/pdf");
                    header("Content-Disposition: inline; filename=$name_download");
                    readfile($dire.$nombre);
                }
            }else{
                ($periodo->periodo_fechafirma!="0000-00-00" &&$periodo->periodo_fechafirma!=null)?$fecha_firma =$periodo->periodo_fechafirma : $fecha_firma="0000-00-00";
                $fecha_firmi=explode("-",$fecha_firma);
                $nombre=$periodo->periodo_nro_contrato.".pdf";
                $name_download= $periodo->periodo_nro_contrato."_".$persona->persona_apellido_paterno."_".$fecha_firmi[2]."-".$fecha_firmi[1]."-".$fecha_firmi[0];
                header("Content-type: application/pdf");
                header("Content-Disposition: inline; filename=$name_download");
                readfile($dire.$nombre);
            }
        } catch (Exception $e){
            //$this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo 'Ta caido';
        }
    }

    public function guardar_turno(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if ($ok_data) {
                $model = new RHumanos();
                $id_persona = $_POST['id_persona'];
                $model->id_persona = $_POST['id_persona'];
                $model->id_turno = $_POST['id_turno'];
                $model->persona_turno_fecha_registro = date('Y-m-d H:i:s');
                $model->persona_estado_turno = 1;

                $this->humanos->actualizar_estado($id_persona);
                $result = $this->humanos->guardar_turno_x_persona($model);

            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Throwable $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function agregar_turnos(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if($ok_data) {
                $model = new RHumanos();
                $model->turno_nombre = $_POST['turno_nombre'];
                $model->turno_hora_entrada = $_POST['turno_hora_entrada'];
                $model->turno_hora_tolerancia = $_POST['turno_hora_tolerancia'];
                $model->turno_hora_salida = $_POST['turno_hora_salida'];
                $model->turno_estado = 1;
                $model->turno_fecha_registro = date('Y-m-d H:i:s');
                $model->turno_usuario_registro = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);

                $result = $this->humanos->agregar_turnos($model);
            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Throwable $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function agregar_turnos_editado(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if($ok_data) {
                $model = new RHumanos();
                $model->id_turno = $_POST['id_turno'];
                $model->turno_nombre = $_POST['turno_nombre'];
                $model->turno_hora_entrada = $_POST['turno_hora_entrada'];
                $model->turno_hora_tolerancia = $_POST['turno_hora_tolerancia'];
                $model->turno_hora_salida = $_POST['turno_hora_salida'];
                $model->turno_usuario_registro = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);

                $result = $this->humanos->agregar_turnos_editado($model);
            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Throwable $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function registrar_asistencia_app(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if($ok_data) {
                $numero_dni = $_POST['numero_dni'];
                $fecha_hoy = date('Y-m-d');
                $persona = $this->humanos->buscar_persona_x_dni($numero_dni);
                $jalar_turnos = $this->humanos->listar_turnos_asistencia($numero_dni);
                $buscar_registro = $this->humanos->buscar_registro($fecha_hoy,$numero_dni);
                $hora_tolerancia = $jalar_turnos->turno_hora_tolerancia;
                $hora_salida = $jalar_turnos->turno_hora_salida;
                $hora_sistema = date('H:i:s');
                if(!empty($buscar_registro)){
                    $respuesta = "Registre su salida por favor!";
                }else{
                    if($hora_sistema < $hora_tolerancia){
                        $respuesta = "Bienvenido. LLegó puntual al trabajo. Que tenga un buen día";
                        $valor = 1;
                    } else{
                        $respuesta = "Usted llegó tarde. Por favor, la próxima debes de ser más puntual. Gracias";
                        $valor = 10;
                    }
                }
            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Throwable $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

}