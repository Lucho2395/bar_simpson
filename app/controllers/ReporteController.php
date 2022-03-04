<?php
require 'app/models/Usuario.php';
require 'app/models/Rol.php';
require 'app/models/Menu.php';
require 'app/models/Archivo.php';
require 'app/models/Reporte.php';
require 'app/models/Caja.php';

class ReporteController
{
    private $usuario;
    private $rol;
    private $archivo;
    private $reporte;
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
        $this->reporte = new Reporte();
        $this->caja = new Caja();

        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
    }


    //FUNCION PARA LA VISTA DEL REPORTE DE INGRESOS Y EGRESOS
    public function ingresos_egresos()
    {
        try {
            //Llamamos a la clase del Navbar, que sólo se usa
            // en funciones para llamar vistas y la instaciamos
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'], _FULL_KEY_));

            $fecha_filtro = date('Y-m-d');
            $fecha_filtro_fin = date('Y-m-d');
            $caja = $this->caja->listar_cajas();
            $fecha_i = date('Y-m-d');
            $fecha_f = date('Y-m-d');
            $datos = false;
            if(isset($_POST['enviar_fecha'])){
                $fecha_i = $_POST['fecha_filtro'];
                $fecha_f = $_POST['fecha_filtro_fin'];
                $id_caja_numero = $_POST['id_caja_numero'];
                $fecha_filtro = strtotime($_POST['fecha_filtro']);
                $fecha_filtro_fin = strtotime($_POST['fecha_filtro_fin']);
                $caja_ = $this->caja->datos_caja_($id_caja_numero);
                $datos = true;
            }
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'reporte/ingresos_egresos.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
    }

    public function reporte_por_caja(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'], _FULL_KEY_));
            $caja = $this->caja->listar_cajas();
            $fecha_hoy = date('Y-m-d');
            $fecha_fin = date('Y-m-d');
            if(isset($_POST['enviar_fecha'])){
                if($_POST['id_caja_numero']!="" && $_POST['fecha_hoy']!="" && $_POST['fecha_fin']!=""){
                    $fecha_hoy = $_POST['fecha_hoy'];
                    $fecha_fin = $_POST['fecha_fin'];
                    $id_caja_numero = $_POST['id_caja_numero'];
                    $reporte_caja = $this->reporte->reporte_caja($fecha_hoy,$fecha_fin,$id_caja_numero);
                }
            }

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'reporte/reporte_por_caja.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
    }

    public function reporte_general(){
        try {
            //Llamamos a la clase del Navbar, que sólo se usa
            // en funciones para llamar vistas y la instaciamos
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'], _FULL_KEY_));
            //$id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
            $fecha_filtro = date('Y-m-d');
            $fecha_filtro_fin = date('Y-m-d');
            $caja = $this->caja->listar_cajas();
            //$usuario = $this->caja->listar_all_users();
            $fecha_hoy = date('Y-m-d');
            $fecha_i = date('Y-m-d');
            $fecha_f = date('Y-m-d');
            $datos = false;
            if(isset($_POST['enviar_fecha'])){
                $id_caja_numero = $_POST['id_caja_numero'];
                $id_usuario = $_POST['id_usuario'];
                $fecha_hoy = date('Y-m-d');
                $fecha_i = $_POST['fecha_filtro'];
                $fecha_f = $_POST['fecha_filtro_fin'];
                $fecha_ini_caja = $_POST['fecha_filtro'];
                $fecha_fin_caja = $_POST['fecha_filtro_fin'];
                $fecha_filtro = strtotime($_POST['fecha_filtro']);
                $fecha_filtro_fin = strtotime($_POST['fecha_filtro_fin']);
                $productos = $this->reporte->reporte_productos($fecha_i,$fecha_f,$id_usuario);
                $listar_egresos = $this->reporte->listar_egresos_descripcion($fecha_i,$fecha_f,$id_usuario);
                //$caja_ = $this->caja->datos_caja_($id_caja_numero);
                $cajas_totales = $this->reporte->datos_por_apertura_caja_($fecha_i,$fecha_f);
                $caja_ = $this->caja->datos_caja_($id_caja_numero);

                $usuario_ = $this->caja->listar_usuarios_($id_usuario);
                //$cajas_totales = $this->reporte->datos_por_apertura_caja($id_usuario,$fecha_i,$fecha_f);
                $datos = true;
            }

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'reporte/reporte_general.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
    }

    public function ticket_reporte(){
        try{
            $fecha_i = $_POST['fecha_i'];
            $fecha_f = $_POST['fecha_f'];
            //$id_usuario = $_POST['id_usuario'];
            $id_caja_numero = $_POST['id_caja_numero'];
            $fecha_ini_caja = $_POST['fecha_i'];
            $fecha_fin_caja = $_POST['fecha_f'];

            $nueva_fecha_i = date('d-m-Y H:i:s',strtotime($fecha_i));
            $nueva_fecha_f = date('d-m-Y H:i:s',strtotime($fecha_f));
            $fecha_filtro = strtotime($_POST['fecha_i']);
            $fecha_filtro_fin = strtotime($_POST['fecha_f']);
            //$listar_egresos = $this->reporte->listar_egresos_descripcion($fecha_ini_caja,$fecha_fin_caja,$id_usuario);
            //$cajas_totales = $this->reporte->datos_por_apertura_caja($id_usuario,$fecha_i,$fecha_f);
            $cajas_totales = $this->reporte->datos_por_apertura_caja_($fecha_i,$fecha_f);
            require _VIEW_PATH_ . 'reporte/ticket_reporte.php';
            $result = 1;
        }catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
            $result = 2;
        }
        echo json_encode(array("result" => array("code" => $result, "message")));
    }

    public function reporte_general_pdf(){
        try{
            $fecha_filtro = date('Y-m-d');
            $fecha_filtro_fin = date('Y-m-d');

            $fecha_i = date('Y-m-d');
            $fecha_f = date('Y-m-d');

            if($_GET['fecha_filtro'] != "" && $_GET['fecha_filtro_fin'] != "" && $_GET['id_usuario']){
                $id_usuario = $_GET['id_usuario'];
                $fecha_i = $_GET['fecha_filtro'];
                $fecha_f = $_GET['fecha_filtro_fin'];
                $fecha_ini_caja = $_GET['fecha_filtro'];
                $fecha_fin_caja = $_GET['fecha_filtro_fin'];
                $fecha_filtro = strtotime($_GET['fecha_filtro']);
                $fecha_filtro_fin = strtotime($_GET['fecha_filtro_fin']);
                $productos = $this->reporte->reporte_productos($fecha_i,$fecha_f,$id_usuario);
                $fecha_hoy = $_GET['fecha_filtro'];
                $fecha_fin = $_GET['fecha_filtro_fin'];
                $listar_egresos = $this->reporte->listar_egresos_descripcion($fecha_hoy,$fecha_fin,$id_usuario);

            }

            require _VIEW_PATH_ . 'reporte/reporte_general_pdf.php';
        }catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
    }

    //FUNCION PARA LA VISTA DEL REPORTE DE CLIENTES
    public function reporte_clientes(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'], _FULL_KEY_));

            $fecha_hoy = date('Y-m-d');
            $fecha_fin = date('Y-m-d');
            $dni_cliente = "";
            if(isset($_POST['enviar_fecha'])){
                if($_POST['dni_cliente']!="" && $_POST['fecha_hoy']!="" && $_POST['fecha_fin']!=""){
                    $dni_cliente = $_POST['dni_cliente'];
                    $fecha_hoy = $_POST['fecha_hoy'];
                    $fecha_fin = $_POST['fecha_fin'];
                    $clientes = $this->reporte->clientes_sucursal_todo($dni_cliente, $fecha_hoy, $fecha_fin);
                }else if($_POST['fecha_hoy'] !="" && $_POST['fecha_fin'] !=""){
                    $fecha_hoy = $_POST['fecha_hoy'];
                    $fecha_fin = $_POST['fecha_fin'];
                    $clientes = $this->reporte->clientes_fechas($fecha_hoy, $fecha_fin);
                }
            }
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'reporte/reporte_clientes.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
    }

    //FUNCION PARA LA VISTA DEL REPORTE DE PROVEEDORES
    public function reporte_proveedores(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'], _FULL_KEY_));
            $fecha_hoy = date('Y-m-d');
            $fecha_fin = date('Y-m-d');
            if(isset($_POST['enviar_fecha'])){
                $fecha_hoy = $_POST['fecha_hoy'];
                $fecha_fin = $_POST['fecha_fin'];
                $proveedores = $this->reporte->datos_proveedores($fecha_hoy, $fecha_fin);
            }

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'reporte/reporte_proveedores.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
    }

    public function tiempo_promedio_atencion(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'], _FULL_KEY_));
            $fecha_filtro = date('Y-m-d');
            $fecha_filtro_fin = date('Y-m-d');

            if(isset($_POST['enviar_fecha'])){
                $fecha_filtro = $_POST['fecha_filtro'];
                $fecha_filtro_fin = $_POST['fecha_filtro_fin'];

                $grupos = $this->reporte->listar_grupos();
            }
            //$grupos = $this->reporte->listar_grupos();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'reporte/tiempo_promedio_atencion.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
    }

    public function ventas_tipo_pago(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'], _FULL_KEY_));
            $tipo_pagos = $this->reporte->listar_tipos_pago();

            $fecha_hoy = date('Y-m-d');
            $fecha_fin = date('Y-m-d');
            //$pago_tipo = "";
            if(isset($_POST['enviar_fecha'])){
                if($_POST['id_tipo_pago']!="" && $_POST['fecha_hoy']!="" && $_POST['fecha_fin']!=""){
                    $fecha_hoy = $_POST['fecha_hoy'];
                    $fecha_fin = $_POST['fecha_fin'];
                    $pago_tipo = $_POST['id_tipo_pago'];
                    $tipo_pago = $this->reporte->ventas_tipo_pago($pago_tipo,$fecha_hoy, $fecha_fin);
                    $tipo_pago_ = $this->reporte->listar_tipos_pagos($pago_tipo);
                }else if($_POST['fecha_hoy'] !="" && $_POST['fecha_fin'] !=""){
                    $fecha_hoy = $_POST['fecha_hoy'];
                    $fecha_fin = $_POST['fecha_fin'];
                    $tipo_pago = $this->reporte->ventas_tipo_pago_fechas($fecha_hoy, $fecha_fin);
                }

            }
            //$tipo_pago = $this->reporte->ventas_tipo_pago();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'reporte/ventas_tipo_pago.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
    }

    //FUNCION PARA LA VISTA DEL REPORTE DE MESEROS
    public function reporte_meseros(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'], _FULL_KEY_));
            $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
            $fecha_hoy = date('Y-m-d');
            $fecha_fin = date('Y-m-d');
            if(isset($_POST['enviar_fecha'])){
                $fecha_hoy = $_POST['fecha_hoy'];
                $fecha_fin = $_POST['fecha_fin'];
                $meseros = $this->reporte->datos_meseros($fecha_hoy, $fecha_fin);
            }

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'reporte/reporte_meseros.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
    }

    public function reporte_insumos(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'], _FULL_KEY_));
            $recurso = $this->reporte->listar_recursos();
            $fecha_hoy = date('Y-m-d');
            $fecha_fin = date('Y-m-d');
            if(isset($_POST['enviar_fecha'])){
                $fecha_hoy = $_POST['fecha_hoy'];
                $fecha_fin = $_POST['fecha_fin'];
                $id_recurso_sede = $_POST['id_recurso_sede'];
                $insumos = $this->reporte->datos_insumos($fecha_hoy, $fecha_fin,$id_recurso_sede);
                $recurso_ = $this->reporte->datos_recurso($id_recurso_sede);
            }

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'reporte/reporte_insumos.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
    }

    public function reporte_ventas_productos(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'], _FULL_KEY_));
            $fecha_filtro = date('Y-m-d');
            $fecha_filtro_fin = date('Y-m-d');
            $caja = $this->caja->listar_cajas();
            if(isset($_POST['enviar_fecha'])){
                $id_caja_numero = $_POST['id_caja_numero'];
                $fecha_filtro = $_POST['fecha_filtro'];
                $fecha_filtro_fin = $_POST['fecha_filtro_fin'];
                $productos = $this->reporte->reporte_productos($fecha_filtro,$fecha_filtro_fin,$id_caja_numero);
                $caja_ = $this->caja->datos_caja_($id_caja_numero);
            }

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'reporte/reporte_ventas_productos.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
    }

    public function reporte_ventas_productos_pdf(){
        try{
            $fecha_filtro = date('Y-m-d');
            $fecha_filtro_fin = date('Y-m-d');
            if($_GET['fecha_filtro'] != "" && $_GET['fecha_filtro_fin'] != "" && $_GET['id_caja_numero']){
                $id_caja_numero = $_GET['id_caja_numero'];
                $fecha_filtro = $_GET['fecha_filtro'];
                $fecha_filtro_fin = $_GET['fecha_filtro_fin'];
                $productos = $this->reporte->reporte_productos($fecha_filtro,$fecha_filtro_fin,$id_caja_numero);
            }

            require _VIEW_PATH_ . 'reporte/reporte_ventas_productos_pdf.php';
        }catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
    }

    public function ticket_productos(){
        try{
            $fecha_i = $_POST['fecha_i'];
            $fecha_f = $_POST['fecha_f'];
            //$id_usuario = $_POST['id_usuario'];
            $id_caja_numero = $_POST['id_caja_numero'];

            $fecha_ini_caja = $_POST['fecha_i'];
            $fecha_fin_caja = $_POST['fecha_f'];

            $nueva_fecha_i = date('d-m-Y H:i:s',strtotime($fecha_i));
            $nueva_fecha_f = date('d-m-Y H:i:s',strtotime($fecha_f));
            $fecha_filtro = strtotime($_POST['fecha_i']);
            $fecha_filtro_fin = strtotime($_POST['fecha_f']);
            $cajas_totales = $this->reporte->datos_por_apertura_caja_($fecha_i,$fecha_f);
            //$listar_productos = $this->reporte->reporte_productos($fecha_ini_caja,$fecha_fin_caja,$id_caja_numero);

            require _VIEW_PATH_ . 'reporte/ticket_productos.php';
            $result = 1;
        }catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
            $result = 2;
        }
        echo json_encode(array("result" => array("code" => $result, "message")));
    }


}