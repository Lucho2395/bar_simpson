<?php
require 'app/models/Pedido.php';
require 'app/models/Archivo.php';
require 'app/models/Usuario.php';
require 'app/models/Rol.php';
require 'app/models/Mesa.php';
require 'app/models/cantidad_en_letras.php';
require 'app/models/Ventas.php';
require 'app/models/Cliente.php';

class PedidoController
{
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $archivo;
    private $usuario;
    private $rol;
    private $mesa;

    private $pedido;
    private $venta;
    private $cliente;


    public function __construct()
    {
        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
        $this->archivo = new Archivo();
        $this->usuario = new Usuario();
        $this->rol = new Rol();
        $this->mesa = new Mesa();

        $this->pedido = new Pedido();
        $this->venta = new Ventas();
        $this->cliente = new Cliente();

    }

    public function gestionar(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
            //$mesas = $this->pedido->listar_mesas($id_usuario);
            $fecha_hoy = date('y-m-d');
            $mesas = $this->pedido->listar_mesas_();
            $mesas_ = $this->pedido->listar_mesas_reserva();
            $mesas_junte = $this->pedido->listar_mesas_junte();
            $mesas_tg = $this->pedido->listar_mesas_tg();
            $ocultas = $this->pedido->listar_mesas_ocultas();
            $reservas = $this->pedido->listar_reservas($fecha_hoy);
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'pedido/gestionar.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function pedidos_eliminados(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $fecha_filtro = date('Y-m-d');
            $fecha_filtro_fin = date('Y-m-d');
            $fecha_i = date('Y-m-d');
            $fecha_f = date('Y-m-d');
            if(isset($_POST['enviar_fecha'])){
                $fecha_i = $_POST['fecha_filtro'];
                $fecha_f = $_POST['fecha_filtro_fin'];
                $pedidos_eliminados = $this->pedido->listar_pedidos_eliminados($fecha_i,$fecha_f);
            }

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'pedido/pedidos_eliminados.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function delivery(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $tipos_documento = $this->cliente->listar_tipos_documentos();
            $familia = $this->pedido->listar_familias();
            $tipo_pago = $this->pedido->listar_tipo_pago();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'pedido/delivery.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function detalle_delivery(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $id = $_GET['id'] ?? 0;
            if($id == 0){
                throw new Exception('ID Sin Declarar');
            }
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);

            $id_mesa = 0;
            //$jalar_id_comanda = $this->pedido->jalar_fila($id);
            $pedidos = $this->pedido->listar_detalle_x_comanda($id);
            $venta_productos = $this->pedido->listar_productos_venta($id);
            $dato_pedido = $this->pedido->jalar_comanda_delivery($id);
            $tipo_pago = $this->pedido->listar_tipo_pago();
            $datos_cliente = $this->pedido->datos_cliente($id);
            if($datos_cliente->id_tipodocumento == 4){
                $cliente_nombre = $datos_cliente->cliente_razonsocial;
            }else{
                $cliente_nombre = $datos_cliente->cliente_nombre;
            }
            if($dato_pedido->comanda_nombre_delivery != ""){
                $cliente_nombre = $dato_pedido->comanda_nombre_delivery;
            }

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'pedido/detalle_delivery.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function historial_delivery(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $id = 0;
            $pedidos = $this->pedido->listar_pedidos_delivery($id);

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'pedido/historial_delivery.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function historial_delivery_entregados(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $id = 0;
            $fecha_filtro = date('Y-m-d');
            $fecha_filtro_fin = date('Y-m-d');
            if(isset($_POST['enviar_fecha'])){
                $fecha_filtro = $_POST['fecha_filtro'];
                $fecha_filtro_fin = $_POST['fecha_filtro_fin'];
                $pedidos = $this->pedido->listar_pedidos_delivery_entregados($id,$fecha_filtro,$fecha_filtro_fin);
            } else {
                $pedidos = $this->pedido->listar_pedidos_delivery_entregados($id,$fecha_filtro,$fecha_filtro_fin);
            }

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'pedido/historial_delivery_entregados.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function asignar(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $id = $_GET['id'] ?? 0;
            if($id == 0){
                throw new Exception('ID Sin Declarar');
            }
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            //$tipo_afectacion = $this->pedido->listar_tipo_afectacion();
            $data_mesa=$this->mesa->mesa($id);
            $producto = $this->pedido->listar_productos();
            $familia = $this->pedido->listar_familias();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'pedido/asignar.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function listar_grupos(){
        try {
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));

            $grupos = $this->pedido->listar_grupos();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'pedido/listar_grupos.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function listado_detalle_grupo(){
        try {
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $id = $_GET['id'] ?? 0;
            if($id == 0){
                throw new Exception('ID Sin Declarar');
            }
            $dato = $this->pedido->listar_grupo_vistas($id);
            $listar_pedidos = $this->pedido->listar_productos_cocina($id);
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'pedido/listado_detalle_grupo.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function detalle_pedido(){
        try {
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $id = $_GET['id'] ?? 0;
            if($id == 0){
                throw new Exception('ID Sin Declarar');
            }
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);

            $dato = $this->pedido->jalar($id);
            $ultimo_valor = $this->pedido->ultimo_pedido($id);
            $ultimo_valor_ = $ultimo_valor->id_comanda;
            $pedidos = $this->pedido->listar_pedidos_por_mesa($id,$ultimo_valor_);
            $dato_pedido = $this->pedido->jalar_comanda($id,$ultimo_valor_);
            $mesas = $this->pedido->listar_mesa();
            $igv = $this->pedido->listar_igv();
            $tipo_pago = $this->pedido->listar_tipo_pago();
            $cliente = $this->pedido->listar_clientes();
            $tipos_documento = $this->cliente->listar_tipos_documentos();
            $mesas_pn = $this->pedido->listar_mesas_pn($id);

            $producto = $this->pedido->listar_productos();
            $familia = $this->pedido->listar_familias();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'pedido/detalle_pedido.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function historial_pedidos(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));

            $filtro = false;
            $mesas = $this->mesa->listar_mesas();
            $fecha_ini = date('Y-m-d');
            $fecha_fin = date('Y-m-d');
            if(isset($_POST['enviar_registro'])){
                if($_POST['id_mesa']!=""){
                    $mesa = $_POST['id_mesa'];
                    $pedidos = $this->pedido->listar_pedidos_x_mesa($_POST['id_mesa'],$_POST['fecha_inicio'], $_POST['fecha_final']);
                }else{
                    $pedidos = $this->pedido->listar_pedidos($_POST['fecha_inicio'], $_POST['fecha_final']);
                }
                $fecha_ini = $_POST['fecha_inicio'];
                $fecha_fin = $_POST['fecha_final'];
                $filtro = true;
            }

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'pedido/historial_pedidos.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function historial_pedidos_gratis(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));

            $filtro = false;
            $mesas = $this->mesa->listar_mesas();
            $fecha_ini = date('Y-m-d');
            $fecha_fin = date('Y-m-d');
            if(isset($_POST['enviar_registro'])){
                if($_POST['id_mesa']!=""){
                    $pedidos = $this->pedido->listar_pedidos_x_mesa_gratis($_POST['id_mesa'],$_POST['fecha_inicio'], $_POST['fecha_final']);
                    $mesa = $_POST['id_mesa'];
                }else{
                    $pedidos = $this->pedido->listar_pedidos_gratis($_POST['fecha_inicio'], $_POST['fecha_final']);
                }
                $fecha_ini = $_POST['fecha_inicio'];
                $fecha_fin = $_POST['fecha_final'];
                $filtro = true;
            }

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'pedido/historial_pedidos_gratis.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function detalle_pedido_ver(){
        try {
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $id_mesa = $_GET['id_mesa'];
            $id_comanda = $_GET['id_comanda'];
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $dato = $this->pedido->jalar($id_mesa);
//            $ultimo_valor = $this->pedido->ultimo_pedido($id_mesa);
//            $ultimo_valor_ = $ultimo_valor->id_comanda;
            $pedidos = $this->pedido->listar_pedidos_por_mesa($id_mesa,$id_comanda);
            $dato_pedido = $this->pedido->jalar_comanda($id_mesa,$id_comanda);
            $mesas = $this->pedido->listar_mesa();
            $igv = $this->pedido->listar_igv();
            $tipo_pago = $this->pedido->listar_tipo_pago();
            $cliente = $this->pedido->listar_clientes();
            $tipos_documento = $this->cliente->listar_tipos_documentos();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'pedido/detalle_pedido_ver.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function ticket_pedido(){
        try{

            $id = $_POST['id'];
            /*$dato = $this->pedido->jalar($id);
            $ultimo_valor = $this->pedido->ultimo_pedido($id);*/
            $ultimo_valor_ = $id;
            $pedidos = $this->pedido->listar_detalle_x_comanda_para_precuenta($ultimo_valor_);
            $dato_pedido = $this->pedido->listar_comanda_x_id($ultimo_valor_);

            $fecha_hoy = date('Y-m-d');
            $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'], _FULL_KEY_);

            $jalar_id_caja = $this->pedido->jalar_id_caja_aperturada($id_usuario);
            $caja_dato = $this->pedido->jalar_datos_caja_numero($jalar_id_caja->id_caja_numero);//datos de la caja para la captura del nombre de la impresora
            
            require _VIEW_PATH_ . 'pedido/ticket_pedido.php';
            $result = 1;
        }catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
            $result = 2;
        }
        echo json_encode(array("result" => array("code" => $result, "message")));

    }

    public function ticket_comanda(){
        try{

            $id_comanda = $_POST['id'];
            $fecha_hoy = date('Y-m-d');
            $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'], _FULL_KEY_);

            $jalar_id_caja = $this->pedido->jalar_id_caja_aperturada($id_usuario);
            $caja_dato = $this->pedido->jalar_datos_caja_numero($jalar_id_caja->id_caja_numero);//datos de la caja para la captura del nombre de la impresora

            $comanda = $this->pedido->listar_comanda_x_id($id_comanda);
            $detalle_comanda =$this->pedido->listar_detalle_x_comanda($id_comanda);

            require _VIEW_PATH_ . 'pedido/ticket_comanda.php';

            $result = 1;
        }catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
            $result = 2;
        }
        echo json_encode(array("result" => array("code" => $result, "message")));

    }

    //FUNCION PARA TICKET VENTA
    public function ticket_venta(){
        try{

            $id = $_POST['id'];
            //INICIO - LISTAR COLUMNAS PARA TICKET DE VENTA
            include('libs/ApiFacturacion/phpqrcode/qrlib.php');

            $venta = $this->venta->listar_venta_x_id($id);
            $detalle_venta =$this->venta->listar_venta_detalle_x_id_venta($id);
            $comanda = $this->pedido->listar_detalle_x_comanda_detalle($detalle_venta[0]->id_comanda_detalle);
            $empresa = $this->venta->listar_empresa_x_id_empresa($venta->id_empresa);
            $cliente = $this->venta->listar_clienteventa_x_id($venta->id_cliente);
            //INICIO - CREACION QR
            $nombre_qr = $empresa->empresa_ruc. '-' .$venta->venta_tipo. '-' .$venta->venta_serie. '-' .$venta->venta_correlativo;
            $contenido_qr = $empresa->empresa_ruc.'|'.$venta->venta_tipo.'|'.$venta->venta_serie.'|'.$venta->venta_correlativo. '|'.
                $venta->venta_totaligv.'|'.$venta->venta_total.'|'.date('Y-m-d', strtotime($venta->venta_fecha)).'|'.
                $cliente->tipodocumento_codigo.'|'.$cliente->cliente_numero;
            $ruta = 'libs/ApiFacturacion/imagenqr/';
            $ruta_qr = $ruta.$nombre_qr.'.png';
            QRcode::png($contenido_qr, $ruta_qr, 'H - mejor', '3');
            //FIN - CREACION QR
            if($venta->venta_tipo == "03"){
                $venta_tipo = "BOLETA DE VENTA ELECTRÓNICA";
            }elseif($venta->venta_tipo == "01"){
                $venta_tipo = "FACTURA DE VENTA ELECTRÓNICA";
            }elseif($venta->venta_tipo == "20"){
                $venta_tipo = "NOTA DE VENTA";
            }
            if($cliente->id_tipodocumento == "4"){
                $cliente_nombre = $cliente->cliente_razonsocial;
            }else{
                $cliente_nombre = $cliente->cliente_nombre;
            }
            $fecha_hoy = date('Y-m-d');
            $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'], _FULL_KEY_);

            $jalar_id_caja = $this->pedido->jalar_id_caja_aperturada($id_usuario);
            $caja_dato = $this->pedido->jalar_datos_caja_numero($jalar_id_caja->id_caja_numero);//datos de la caja para la captura del nombre de la impresora
            require _VIEW_PATH_ . 'pedido/ticket_venta.php';
            //INICIO - TICKET DELIVERY
            //$venta = $this->venta->listar_venta_x_id($id);
            if($venta->id_mesa == 0){
//                $cliente = $this->pedido->listar_clienteventa_x_id_delivery($id_cliente);
                $id_comanda = $comanda->id_comanda;
                $datos_ticket = $this->pedido->jalar_datos_comanda($id_comanda);
                $cambiar_estado_comanda = $this->pedido->cambiar_estado_comanda_delivery($id_comanda);

                if($cliente->id_tipodocumento == "4"){
                    $cliente_nombre = $cliente->cliente_razonsocial;
                }else{
                    $cliente_nombre = $datos_ticket->comanda_nombre_delivery;
                }

                require _VIEW_PATH_ . 'pedido/ticket_venta_delivery.php';
                //echo "<script>window.open("._SERVER_."'Pedido/ticket_venta/".$id_venta."','_blank')</script>";
            }

            $result = 1;
        }catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
            $result = 2;
        }
        echo json_encode(array("result" => array("code" => $result, "message")));

    }

    public function ticket_venta_delivery(){
        try{

            $id = $_POST['id'];
            //INICIO - LISTAR COLUMNAS PARA TICKET DE VENTA
            include('libs/ApiFacturacion/phpqrcode/qrlib.php');

            $venta = $this->venta->listar_venta_x_id($id);
            $cliente = $this->pedido->listar_clienteventa_x_id_delivery($venta->id_cliente);

            if($cliente->id_tipodocumento == "4"){
                $cliente_nombre = $cliente->cliente_razonsocial;
            }else{
                $cliente_nombre = $cliente->cliente_nombre;
            }

            $dato = $this->pedido->jalar($id);
            $ultimo_valor = $this->pedido->ultimo_pedido($id);
            $ultimo_valor_ = $ultimo_valor->id_comanda;
            $pedidos = $this->pedido->listar_pedidos_por_mesa($id,$ultimo_valor_);
            $dato_pedido = $this->pedido->jalar_comanda($id,$ultimo_valor_);
            $fecha_hoy = date('Y-m-d');
            $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'], _FULL_KEY_);

            $jalar_id_caja = $this->pedido->jalar_id_caja_aperturada($id_usuario);
            $caja_dato = $this->pedido->jalar_datos_caja_numero($jalar_id_caja->id_caja_numero);//datos de la caja para la captura del nombre de la impresora


            require _VIEW_PATH_ . 'pedido/ticket_venta_delivery.php';
            $result = 1;
        }catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
            $result = 2;
        }
        echo json_encode(array("result" => array("code" => $result, "message")));
    }

    //FUNCIONES
    /*public function listar_precio_producto(){

        try{
            $id_producto = $_POST['id_producto'];
            $result = $this->pedido->listar_precio_producto($id_producto);

            $pedido = "<select class='form-control' id='producto_precio_venta' name='producto_precio_venta'>";
            foreach($result as $c) {
                $pedido .= "<option>" . $c->producto_precio_venta . "</option>";
            }
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode($pedido);
    }*/

    public function ver_productos(){
        try{
            //$id_producto = $_POST['id_producto'];
            //$result = $this->pedido->listar_precio_producto($id_producto);
            $parametro_ = $_POST['parametro'];
            $parametro=str_replace(".--","+",$parametro_);
            $result = $this->pedido->listar_busqueda_productos($parametro);

            $producto = "";
            $anho = date('Y');
            if($anho == "2021"){
                $icbper = 0.30;
            }elseif($anho == "2022"){
                $icbper = 0.40;
            }else{
                $icbper = 0.50;
            }
            foreach ($result as $r){
                $op_gravadas=0.00;
                $op_exoneradas=0.00;
                $op_inafectas=0.00;
                $op_gratuitas=0.00;
                $igv=0.0;
                $igv_porcentaje=0.18;
                if($r->producto_precio_codigoafectacion == 10){
                    $op_gravadas = $r->producto_precio_venta;
                    $igv = $op_gravadas * $igv_porcentaje;
                    $total = $op_gravadas + $igv;
                }else{
                    $total = $r->producto_precio_venta;
                }
                /*if($r->id_receta == "131"){
                    $total = $total + $icbper;
                }*/
                $producto .= " <tr>
                                <td>". $r->producto_nombre ."</td>
                                <td>". $total . "</td>
                                <td>
                                    <button class='btn btn-success' data-toggle='modal' onclick='guardar_pedido(".$r->id_producto. ",\"".$r->producto_nombre."\",\"".$total."\",\"".$r->producto_precio_codigoafectacion."\")' data-target='#asignar_pedido'><i class='fa fa-check'></i> </button>
                                    <a class='btn btn-primary' href='"._SERVER_ .$r->producto_foto."' target='_blank'><i class='fa fa-eye'></i></a>
                                    <input type='hidden' id='".$r->producto_precio_codigoafectacion."'>
                                <td>
                            </tr>";
            }
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode($producto);
    }

    //FUNCION PARA VER PRODUCTOS NUEVOS
    public function ver_productos_nuevo(){
        try{
            //$id_producto = $_POST['id_producto'];
            //$result = $this->pedido->listar_precio_producto($id_producto);
            $parametro_ = $_POST['parametro'];
            $parametro=str_replace(".--","+",$parametro_);
            $result = $this->pedido->listar_busqueda_productos($parametro);


            $producto_nuevo = " <table class='table table-bordered' width='100%'>
                                        <thead class='text-capitalize'>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                            <th>Acción</th>
                                        </tr>
                                        </thead>
                                        <tbody>";
            $anho = date('Y');
            if($anho == "2021"){
                $icbper = 0.30;
            }elseif($anho == "2022"){
                $icbper = 0.40;
            }else{
                $icbper = 0.50;
            }
            foreach ($result as $r){

                $op_gravadas=0.00;
                $op_exoneradas=0.00;
                $op_inafectas=0.00;
                $igv=0.0;
                $igv_porcentaje=0.18;
                if($r->producto_precio_codigoafectacion == 10){
                    $op_gravadas = $r->producto_precio_venta;
                    $igv = $op_gravadas * $igv_porcentaje;
                    $total = $op_gravadas + $igv;
                }else{
                    $total = $r->producto_precio_venta;
                }
                /*if($r->id_receta == "131"){
                    $total = $total + $icbper;
                }*/
                $producto_nuevo .= " <tr>
                                <td>". $r->producto_nombre ."</td>
                                <td>". $total . "</td>
                                <td><button class='btn btn-success' onclick='guardar_pedido_nuevo(".$r->id_producto. ",\"".$r->producto_nombre."\",\"".$total."\")' ><i class='fa fa-check'></i> Agregar</button><td>
                            </tr>";
                $resultado = $this->pedido->listar_busqueda_productos_seleccion($r->id_producto);
                $ver_seleccion = "<label>Precio por Producto ".$resultado->producto_nombre." : ".$resultado->producto_precio_venta."</label>
                                 <input type='hidden' id='pro_".$resultado->id_producto."' name='id_producto' value='".$resultado->producto_precio_venta."'>";
            }
            $producto_nuevo .= "</tbody></table>";





        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("producto_nuevo" => $producto_nuevo, "ver_seleccion" => $ver_seleccion));
    }

    public function ver_productos_x_delivery(){
        try{
            //$id_producto = $_POST['id_producto'];
            //$result = $this->pedido->listar_precio_producto($id_producto);
            $parametro_ = $_POST['parametro'];
            $parametro=str_replace(".--","+",$parametro_);
            $result = $this->pedido->listar_busqueda_productos($parametro);

            $producto = " <table class='table table-bordered' width='100%'>
                                        <thead class='text-capitalize'>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                            <th>Acción</th>
                                        </tr>
                                        </thead>
                                        <tbody>";
            $anho = date('Y');
            if($anho == "2021"){
                $icbper = 0.30;
            }elseif($anho == "2022"){
                $icbper = 0.40;
            }else{
                $icbper = 0.50;
            }
            foreach ($result as $r){
                $op_gravadas=0.00;
                $op_exoneradas=0.00;
                $op_inafectas=0.00;
                $op_gratuitas=0.00;
                $igv=0.0;
                $igv_porcentaje=0.18;
                if($r->producto_precio_codigoafectacion == 10){
                    /*$op_gravadas = $r->producto_precio_venta;
                    $igv = $op_gravadas * $igv_porcentaje;
                    $total = $op_gravadas + $igv;*/
                    $total = $r->producto_precio_venta;
                }else{
                    $total = $r->producto_precio_venta;
                }
                /*if($r->id_receta == "131"){
                    $total = $total + $icbper;
                }*/
                $producto .= " <tr>
                                <td>". $r->producto_nombre ."</td>
                                <td>". $total . "</td>
                                <td>
                                    <button class='btn btn-success' data-toggle='modal' onclick='guardar_pedido(".$r->id_producto. ",\"".$r->producto_nombre."\",\"".$total."\",\"".$r->producto_precio_codigoafectacion."\")' data-target='#asignar_pedido'><i class='fa fa-check'></i> </button>
                                    <a class='btn btn-primary' href='"._SERVER_ .$r->producto_foto."' target='_blank'><i class='fa fa-eye'></i></a>
                                    <input type='hidden' id='".$r->producto_precio_codigoafectacion."'>
                                <td>
                            </tr>";
            }
            $producto .= "</tbody></table>";
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode($producto);
    }

    //FUNCION PARA BUSCAR CLIENTE EN LA VISTA DE PEDIDOS POR MESA
    public function buscar_cliente(){
        try{
        $parametro = $_POST['parametro_c'];
        $result = $this->pedido->buscar_cliente($parametro);
        $cliente = " <table class='table table-bordered' width='100%'>
                                        <thead class='text-capitalize'>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>DNI / RUC</th>
                                            <th>Dirección</th>
                                            <th>Acción</th>
                                        </tr>
                                        </thead>
                                        <tbody>";
        foreach ($result as $r) {
            if($r->id_tipodocumento != 4){
                $nombre = $r->cliente_nombre;
            }else{
                $nombre = $r->cliente_razonsocial;
            }
            //$direcciones = $this->pedido->direcciones($r->id_cliente);
            $cliente .= " <tr>
                                <td>" . $nombre . "</td>
                                <td>" . $r->cliente_numero . "</td>
                                 
                                <td>" . $r->cliente_direccion . "
                                </td>
                                
                                <td><button class='btn btn-primary' onclick='guardar_cliente(" . $r->id_cliente . ",\"" . $nombre . "\",\"" . $r->cliente_numero . "\",\"" . $r->cliente_direccion . "\",\"" . $r->id_tipodocumento . "\")' ><i class='fa fa-check'></i></button><td>
                            </tr>";
        }
            $cliente .= "</tbody></table>";
        }catch (Exception $e){
                //Registramos el error generado y devolvemos el mensaje enviado por PHP
                $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
                $message = $e->getMessage();
            }
        //Retornamos el json
        echo json_encode($cliente);
    }

    //FUNCION PARA BUSCAR CLIENTE EN LA VISTA QUE SE REALIZA EL PEDIDO DEIVERY
    public function buscar_cliente_delivery(){
        try{
            $parametro = $_POST['parametro_delivery'];
            $result = $this->pedido->buscar_cliente($parametro);
            $cliente_delivery = " <table class='table table-bordered' width='100%'>
                                        <thead class='text-capitalize'>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>DNI / RUC</th>
                                            <th>Dirección</th>
                                            <th>Acción</th>
                                        </tr>
                                        </thead>
                                        <tbody>";
            foreach ($result as $r) {
                $nombre_del_cliente = $r->cliente_nombre.$r->cliente_razonsocial;

                //$direcciones = $this->pedido->direcciones($r->id_cliente);
                $cliente_delivery .= " <tr>
                                <td>" . $nombre_del_cliente . "</td>
                                <td>" . $r->cliente_numero . "</td>
                                 
                                <td>
                                    <select name='id_cliente_direccion".$r->id_cliente."' id='id_cliente_direccion".$r->id_cliente."' class='form-control'>";
                                    if($r->cliente_direccion != ""){
                                        $cliente_delivery .="<option >". $r->cliente_direccion."</option>";
                                    }
                                    if($r->cliente_direccion_2 != ""){
                                        $cliente_delivery .="<option >". $r->cliente_direccion_2."</option>";
                                    }
                                    $cliente_delivery .= "</select>
                                </td>
                                
                                <td><button class='btn btn-success' onclick='guardar_cliente_delivery(" . $r->id_cliente . ",\"" . $nombre_del_cliente . "\",\"" . $r->cliente_numero . "\",\"" . $r->cliente_direccion . "\",\"" . $r->cliente_telefono . "\")' ><i class='fa fa-check'></i> Agregar</button><td>
                            </tr>";
            }
            $cliente_delivery .= "</tbody></table>";
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode($cliente_delivery);
    }

    //FUNCION PARA BUSCAR CLIENTE EN LA VISTA DE LOS PAGOS DEL CLIENTE
    public function buscar_cliente_delivery_pagos(){
        try{
            $parametro = $_POST['parametro_delivery'];
            $result = $this->pedido->buscar_cliente($parametro);
            $cliente_delivery_pagos = " <table class='table table-bordered' width='100%'>
                                        <thead class='text-capitalize'>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>DNI / RUC</th>
                                            <th>Dirección</th>
                                            <th>Acción</th>
                                        </tr>
                                        </thead>
                                        <tbody>";
            foreach ($result as $r) {

                //$direcciones = $this->pedido->direcciones($r->id_cliente);
                $cliente_delivery_pagos .= " <tr>
                                <td>" . $r->cliente_nombre . "</td>
                                <td>" . $r->cliente_numero . "</td>
                                 
                                <td>
                                    <select name='id_cliente_direccion".$r->id_cliente."' id='id_cliente_direccion".$r->id_cliente."' class='form-control'>
                                    <option >". $r->cliente_direccion."</option>
                                    <option >". $r->cliente_direccion_2."</option>
                                    </select>
                                </td>
                                
                                <td><button class='btn btn-success' onclick='guardar_cliente_delivery_pagos(" . $r->id_cliente . ",\"" . $r->cliente_nombre . "\",\"" . $r->cliente_numero . "\",\"" . $r->cliente_direccion . "\",\"" . $r->cliente_telefono . "\")' ><i class='fa fa-check'></i> Agregar</button><td>
                            </tr>";
            }
            $cliente_delivery_pagos .= "</tbody></table>";
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode($cliente_delivery_pagos);
    }


    //FUNCION PARA GUARDAR UN PEDIDO O COMANDA
    public function guardar_comanda(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validacion de datos
            if($ok_data) {
                $model = new Pedido();
                $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                $fecha = date('Y-m-d H:i:s');
                $microtime = microtime(true);
                $id_mesa = $_POST['id_mesa'];
                $model->id_mesa = $id_mesa;
                $model->id_usuario = $id_usuario;
                $model->comanda_total = $_POST['comanda_total'];
                $model->comanda_fecha_registro = $fecha;
                $model->comanda_cantidad_personas = $_POST['comanda_cantidad_personas'];
                $model->comanda_estado = 1;
                $model->comanda_codigo = $microtime;

                $fecha_buscar = date('Y-m-d');
                $ultima_comanda = $this->pedido->listar_ultima_comanda($fecha_buscar);
                if(isset($ultima_comanda->id_comanda)){
                    $fila = explode('-',$ultima_comanda->comanda_correlativo);
                    if(count($fila)>0){
                        for($i=0;$i<count($fila)-1;$i++){
                            $suma = $fila[1] + 1;
                            $model->comanda_correlativo = $fila[0].'-'.$suma;
                        }
                    }
                }else{
                    $model->comanda_correlativo = date('dmy').'-'. + 1;
                }
                $guardar_comanda = $this->pedido->guardar_comanda($model);
                if($guardar_comanda == 1){
                    $contenido = $_POST['contenido'];
                    if(count_chars($contenido)>0){
                        $filas=explode('/./.',$contenido);
                        $datos = $this->pedido->listar_comanda_por_mt($microtime);
                        if(count($filas)>0){
                            for ($i=0;$i<count($filas)-1;$i++){
                                $modelDSI=new Pedido();
                                $celdas=explode('-.-.',$filas[$i]);
                                $modelDSI->id_comanda = $datos->id_comanda;
                                $modelDSI->id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                                $modelDSI->id_producto = $celdas[0];
                                $modelDSI->comanda_detalle_precio = $celdas[2];
                                $modelDSI->comanda_detalle_cantidad = $celdas[3];
                                $modelDSI->comanda_detalle_despacho = $celdas[4];
                                $modelDSI->comanda_detalle_total = $celdas[6];
                                $modelDSI->comanda_detalle_observacion = $celdas[5];
                                $modelDSI->comanda_detalle_fecha_registro = $fecha;
                                $modelDSI->comanda_detalle_estado = 1;
                                $result = $this->pedido->guardar_detalle_comanda($modelDSI);
                            }
                        }
                    }
                }
                if($result == 1){
                    $result = $this->pedido->cambiar_estado_mesa($id_mesa);
                    //INICIO - IMPRESION DE TICKET DE COMANDA
                    $id_comanda = $datos->id_comanda;
                    $comanda = $this->pedido->listar_comanda_x_id($id_comanda);
                    $detalle_comanda =$this->pedido->listar_detalle_x_comanda($id_comanda);
                    foreach ($detalle_comanda as $de){
                        $detalle = $this->pedido->listar_detalle_x_comanda_detalle($de->id_comanda_detalle);
                        if($detalle->id_grupo != 3){
                            $nombre_ticket = "$detalle->grupo_ticketera";
                            require _VIEW_PATH_ . 'pedido/ticket_comanda_detalle.php';
                        }else{
                            $nombre_ticket = "CALIENTE_2";
                            require _VIEW_PATH_ . 'pedido/ticket_comanda_detalle.php';
                            $nombre_ticket = "FRIOS_2";
                            require _VIEW_PATH_ . 'pedido/ticket_comanda_detalle.php';
                        }

                    }


                    //FIN - IPRESION DE TICKET DE COMANDA

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

    //FUNCION PARA GUARDAR COMANDA NUEVA
    public function guardar_comanda_nuevo()
    {
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validacion de datos
            if ($ok_data) {
                //$model = new Pedido();
                $fecha = date('Y-m-d H:i:s');
                $id_comanda = $_POST['id_comanda'];
                /*$model->id_comanda = $id_comanda;
                $model->id_producto = $_POST['id_producto'];
                $model->comanda_detalle_precio = $_POST['comanda_detalle_precio'];
                $model->comanda_detalle_cantidad = $_POST['comanda_detalle_cantidad'];
                $model->comanda_detalle_despacho = $_POST['comanda_detalle_despacho'];
                $model->comanda_detalle_total = $_POST['comanda_detalle_total'];
                $model->comanda_detalle_observacion = $_POST['comanda_detalle_observacion'];
                $model->comanda_detalle_fecha_registro = $fecha;
                $model->comanda_detalle_estado = 0;

                $result = $this->pedido->guardar_detalle_comanda($model);

                if ($result == 1) {
                    $jalar_valor = $this->pedido->jalar_valor($id_comanda);
                    $nuevo_valor = $jalar_valor->total;
                    $actualizar_precio = $this->pedido->actualizar_nuevo_valor($id_comanda, $nuevo_valor);
                }*/

                $contenido = $_POST['contenido_pedido'];
                if(count_chars($contenido)>0){
                    $filas=explode('/./.',$contenido);
                    if(count($filas)>0){
                        for ($i=0;$i<count($filas)-1;$i++){
                            $modelDSI=new Pedido();
                            $celdas=explode('-.-.',$filas[$i]);
                            $modelDSI->id_comanda = $id_comanda;
                            $modelDSI->id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                            $modelDSI->id_producto = $celdas[0];
                            $modelDSI->comanda_detalle_precio = $celdas[2];
                            $modelDSI->comanda_detalle_cantidad = $celdas[3];
                            $modelDSI->comanda_detalle_despacho = $celdas[4];
                            $modelDSI->comanda_detalle_total = $celdas[6];
                            $modelDSI->comanda_detalle_observacion = $celdas[5];
                            $modelDSI->comanda_detalle_fecha_registro = $fecha;
                            $modelDSI->comanda_detalle_estado = 1;
                            $result = $this->pedido->guardar_detalle_comanda($modelDSI);
                            if ($result == 1) {
                                $jalar_valor = $this->pedido->jalar_valor($id_comanda);
                                $nuevo_valor = $jalar_valor->total;
                                $actualizar_precio = $this->pedido->actualizar_nuevo_valor($id_comanda, $nuevo_valor);
                            }
                        }
                        //INICIO - IMPRESION DE TICKET DE COMANDA
//                        $id_comanda = $id_comanda;
                        $comanda = $this->pedido->listar_comanda_x_id($id_comanda);
                        $detalle_comanda =$this->pedido->listar_detalle_x_comanda_x_fecha($id_comanda, $fecha);
                        foreach ($detalle_comanda as $de){
                            $detalle = $this->pedido->listar_detalle_x_comanda_detalle($de->id_comanda_detalle);
                            if($detalle->id_grupo != 3){
                                $nombre_ticket = "$detalle->grupo_ticketera";
                                require _VIEW_PATH_ . 'pedido/ticket_comanda_detalle.php';
                            }else{
                                $nombre_ticket = "CALIENTE_2";
                                require _VIEW_PATH_ . 'pedido/ticket_comanda_detalle.php';
                                $nombre_ticket = "FRIOS_2";
                                require _VIEW_PATH_ . 'pedido/ticket_comanda_detalle.php';
                            }

                        }

//                        require _VIEW_PATH_ . 'pedido/ticket_comanda.php';
                        //FIN - IPRESION DE TICKET DE COMANDA
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


    //FUNCION PARA GUARDAR UN PEDIDO DEL DELIVERY
    public function guardar_delivery(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validacion de datos
            if($ok_data) {
                $model = new Pedido();
                $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                $fecha = date('Y-m-d H:i:s');
                $microtime = microtime(true);
                $id_mesa = $_POST['id_mesa'];
                $model->id_mesa = 0;
                $model->id_usuario = $id_usuario;
                $model->id_cliente = $_POST['id_cliente'];
                $model->comanda_direccion_delivery = $_POST['comanda_direccion_delivery'];
                $model->comanda_telefono_delivery = $_POST['comanda_telefono_delivery'];
                $model->comanda_total = $_POST['comanda_total'];
                $model->comanda_fecha_registro = $fecha;
                $model->comanda_cantidad_personas = 1;
                $model->comanda_estado = 1;
                $model->comanda_codigo = $microtime;

                $fecha_buscar = date('Y-m-d');
                $ultima_comanda = $this->pedido->listar_ultima_comanda($fecha_buscar);
                if(isset($ultima_comanda->id_comanda)){
                    $fila = explode('-',$ultima_comanda->comanda_correlativo);
                    if(count($fila)>0){
                        for($i=0;$i<count($fila)-1;$i++){
                            $suma = $fila[1] + 1;
                            $model->comanda_correlativo = $fila[0].'-'.$suma;
                        }
                    }
                }else{
                    $model->comanda_correlativo = date('dmy').'-'. + 1;
                }
                $guardar_comanda = $this->pedido->guardar_comanda($model);
                if($guardar_comanda == 1){
                    $contenido = $_POST['contenido'];
                    if(count_chars($contenido)>0){
                        $filas=explode('/./.',$contenido);
                        $datos = $this->pedido->listar_comanda_por_mt($microtime);
                        if(count($filas)>0){
                            for ($i=0;$i<count($filas)-1;$i++){
                                $modelDSI=new Pedido();
                                $celdas=explode('-.-.',$filas[$i]);
                                $modelDSI->id_comanda = $datos->id_comanda;
                                $modelDSI->id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                                $modelDSI->id_producto = $celdas[0];
                                $modelDSI->comanda_detalle_precio = $celdas[2];
                                $modelDSI->comanda_detalle_cantidad = $celdas[3];
                                $modelDSI->comanda_detalle_despacho = $celdas[4];
                                $modelDSI->comanda_detalle_total = $celdas[6];
                                $modelDSI->comanda_detalle_observacion = $celdas[5];
                                $modelDSI->comanda_detalle_fecha_registro = $fecha;
                                $modelDSI->comanda_detalle_estado = 1;
                                $result = $this->pedido->guardar_detalle_comanda($modelDSI);
                            }
                        }
                    }
                }
                if($result == 1){
                    $result = $this->pedido->cambiar_estado_mesa($id_mesa);
                    //INICIO - IMPRESION DE TICKET DE COMANDA
                    $id_comanda = $datos->id_comanda;
                    $comanda = $this->pedido->listar_comanda_x_id($id_comanda);
                    $detalle_comanda =$this->pedido->listar_detalle_x_comanda($id_comanda);
                    foreach ($detalle_comanda as $de){
                        $detalle = $this->pedido->listar_detalle_x_comanda_detalle($de->id_comanda_detalle);
                        if($detalle->id_grupo != 3){
                            $nombre_ticket = "$detalle->grupo_ticketera";
                            require _VIEW_PATH_ . 'pedido/ticket_comanda_detalle.php';
                        }else{
                            $nombre_ticket = "CALIENTE_2";
                            require _VIEW_PATH_ . 'pedido/ticket_comanda_detalle.php';
                            $nombre_ticket = "FRIOS_2";
                            require _VIEW_PATH_ . 'pedido/ticket_comanda_detalle.php';
                        }

                    }
//                    require _VIEW_PATH_ . 'pedido/ticket_comanda.php';
                    //FIN - IPRESION DE TICKET DE COMANDA
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

    public function guardar_delivery_venta(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validacion de datos
            if($ok_data) {
                $model = new Pedido();
                $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                $fecha = date('Y-m-d H:i:s');
                $microtime = microtime(true);
                $id_mesa = $_POST['id_mesa'];
                $model->id_mesa = 0;
                $model->id_usuario = $id_usuario;
                $model->id_cliente = $_POST['id_cliente'];
                $model->cliente_nombre_d = $_POST['cliente_nombre_d'];
                $model->comanda_direccion_delivery = $_POST['comanda_direccion_delivery'];
                $model->comanda_telefono_delivery = $_POST['comanda_telefono_delivery'];
                $model->comanda_total = $_POST['comanda_total'];
                $model->comanda_fecha_registro = $fecha;
                $model->comanda_cantidad_personas = 1;
                $model->comanda_estado = 1;
                $model->comanda_codigo = $microtime;

                $fecha_buscar = date('Y-m-d');
                $ultima_comanda = $this->pedido->listar_ultima_comanda($fecha_buscar);
                if(isset($ultima_comanda->id_comanda)){
                    $fila = explode('-',$ultima_comanda->comanda_correlativo);
                    if(count($fila)>0){
                        for($i=0;$i<count($fila)-1;$i++){
                            $suma = $fila[1] + 1;
                            $model->comanda_correlativo = $fila[0].'-'.$suma;
                        }
                    }
                }else{
                    $model->comanda_correlativo = date('dmy').'-'. + 1;
                }
                $guardar_comanda = $this->pedido->guardar_comanda($model);
                if($guardar_comanda == 1){
                    $contenido = $_POST['contenido'];
                    if(count_chars($contenido)>0){
                        $filas=explode('/./.',$contenido);
                        $datos = $this->pedido->listar_comanda_por_mt($microtime);
                        if(count($filas)>0){
                            for ($i=0;$i<count($filas)-1;$i++){
                                $modelDSI=new Pedido();
                                $celdas=explode('-.-.',$filas[$i]);
                                $modelDSI->id_comanda = $datos->id_comanda;
                                $modelDSI->id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                                $modelDSI->id_producto = $celdas[0];
                                $modelDSI->comanda_detalle_precio = $celdas[2];
                                $modelDSI->comanda_detalle_cantidad = $celdas[3];
                                $modelDSI->comanda_detalle_despacho = $celdas[4];
                                $modelDSI->comanda_detalle_total = $celdas[6];
                                $modelDSI->comanda_detalle_observacion = $celdas[5];
                                $modelDSI->comanda_detalle_fecha_registro = $fecha;
                                $modelDSI->comanda_detalle_estado = 1;
                                $result = $this->pedido->guardar_detalle_comanda($modelDSI);
                            }
                        }
                    }
                }
                if($result == 1){
                    //$result = $this->pedido->cambiar_estado_mesa($id_mesa);
                    //INICIO - IMPRESION DE TICKET DE COMANDA
                    $id_comanda = $datos->id_comanda;
                    $comanda = $this->pedido->listar_comanda_x_id($id_comanda);
                    $detalle_comanda =$this->pedido->listar_detalle_x_comanda($id_comanda);
                    foreach ($detalle_comanda as $de){
                        $detalle = $this->pedido->listar_detalle_x_comanda_detalle($de->id_comanda_detalle);
                        if($detalle->id_grupo != 3){
                            $nombre_ticket = "$detalle->grupo_ticketera";
                            require _VIEW_PATH_ . 'pedido/ticket_comanda_detalle.php';
                        }else{
                            $nombre_ticket = "CALIENTE_2";
                            require _VIEW_PATH_ . 'pedido/ticket_comanda_detalle.php';
                            $nombre_ticket = "FRIOS_2";
                            require _VIEW_PATH_ . 'pedido/ticket_comanda_detalle.php';
                        }

                    }
//                    require _VIEW_PATH_ . 'pedido/ticket_comanda.php';
                    //FIN - IPRESION DE TICKET DE COMANDA
                }
                if($_POST['gratis'] == 2) {
                    if ($result == 1) {
                        $modelv = new Pedido();
                        $fecha = date('Y-m-d H:i:s');
                        $tipo_pago = $_POST['id_tipo_pago'];
                        $fecha_hoy = date('Y-m-d');
                        $jalar_id_caja = $this->pedido->jalar_id_caja_aperturada($id_usuario);
                        if (empty($jalar_id_caja)) {
                            $caja_numero = 1;
                        } else {
                            $caja_numero = $jalar_id_caja->id_caja_numero;
                        }
                        $id_mesa = $_POST['id_mesa'];
                        $caja_dato = $this->pedido->jalar_datos_caja_numero($caja_numero);//datos de la caja para la captura del nombre de la impresora

                        $id_cliente = $_POST['id_cliente'];
                        $modelv->id_caja_numero = $caja_numero;
                        $modelv->id_cliente = $id_cliente;
                        $modelv->id_mesa = 0;
                        $modelv->id_usuario = $id_usuario;
                        $modelv->id_moneda = 1;
                        $modelv->venta_tipo = $_POST['tipo_venta'];
                        //obtener serie con el id
                        $serie_ = $this->pedido->listar_correlativos_x_serie($_POST['serie']);
                        $modelv->venta_serie = $serie_->serie;
                        if (isset($_POST['id_venta'])) {
                            if ($_POST['tipo_venta'] == "20") {
                                $correlativo = $_POST['correlativo'];
                            } else {
                                $correlativo = $serie_->correlativo + 1;
                            }
                        } else {
                            $correlativo = $serie_->correlativo + 1;
                        }
                        $modelv->venta_correlativo = $correlativo;
                        $modelv->venta_tipo_moneda = $_POST['tipo_moneda'];
                        $modelv->id_tipo_pago = $tipo_pago;
                        //AL HACER LA VENTA AUTOMATICAMENTE SE LLENA EL CORRELATIVO DE LA VENTA
                        $modelv->venta_totalgratuita = $_POST['op_gratuitas_'];
                        $modelv->venta_totalexonerada = $_POST['op_exoneradas_'];
                        $modelv->venta_totalinafecta = $_POST['op_inafectas_'];
                        $modelv->venta_totalgravada = $_POST['op_gravadas_'];
                        $modelv->venta_totaligv = $_POST['igv_'];
                        $modelv->venta_icbper = $_POST['icbper_'];
                        $modelv->venta_fecha = $fecha;
                        $modelv->tipo_documento_modificar = "";
                        $modelv->tipo_nota_id = 0;
                        $modelv->correlativo_modificar = "";
                        $modelv->venta_total = $_POST['venta_total'];
                        $modelv->pago_cliente = $_POST['pago_cliente'];
                        $modelv->vuelto_ = $_POST['vuelto_'];
                        $guardar_venta = 2;
                        if ($_POST['tipo_venta'] == '20') {
                            //$guardar_venta = $this->pedido->guardar_nota_venta($model);
                            $guardar_venta = $this->pedido->guardar_venta($modelv);

                        } else {
                            $guardar_venta = $this->pedido->guardar_venta($modelv);
                        }

                        if ($guardar_venta == 1) {
                            $model = new Pedido();
                            if ($_POST['tipo_venta'] == '20') {
                                /*$jalar_id_venta = $this->pedido->jalar_id_nota_venta($fecha,$id_cliente);
                                $id_venta = $jalar_id_venta->id_nota_venta;*/
                                $jalar_id_venta = $this->pedido->jalar_id_venta($fecha, $id_cliente);
                                $id_venta = $jalar_id_venta->id_venta;
                            } else {
                                $jalar_id_venta = $this->pedido->jalar_id_venta($fecha, $id_cliente);
                                $id_venta = $jalar_id_venta->id_venta;
                            }
                            $comanda_detalle = $this->pedido->listar_detalle_x_comanda($datos->id_comanda);
                            $ids_detalles_comanda = "";
                            foreach ($comanda_detalle as $cd) {
                                $ids_detalles_comanda .= $cd->id_comanda_detalle . "-.-.";
                            }
                            $datos_detalle_pedido = $ids_detalles_comanda;
                            if (count_chars($datos_detalle_pedido) > 0) {
                                $celdas = explode('-.-.', $datos_detalle_pedido);
                                if (count($celdas) > 0) {
                                    $igv_porcentaje = 0.18;
                                    for ($i = 0; $i < count($celdas) - 1; $i++) {
                                        $model->id_venta = $id_venta;
                                        $id_comanda_detalle = $celdas[$i];


                                        $jalar_datos = $this->pedido->jalar_datos($id_comanda_detalle);
                                        $cantidad = $jalar_datos->comanda_detalle_cantidad;
                                        $precio_unitario = $jalar_datos->comanda_detalle_precio;
                                        $codigo_afectacion = $jalar_datos->producto_precio_codigoafectacion;
                                        $igv_detalle = 0;
                                        $factor_porcentaje = 1;
                                        if ($codigo_afectacion == 10) {
                                            $igv_detalle = $precio_unitario * $cantidad * $igv_porcentaje;
                                            $factor_porcentaje = 1 + $igv_porcentaje;
                                        }

                                        $model->id_comanda_detalle = $id_comanda_detalle;
                                        $model->venta_detalle_valor_unitario = $precio_unitario;
                                        $model->venta_detalle_precio_unitario = $precio_unitario * $factor_porcentaje;
                                        $model->venta_detalle_nombre_producto = $jalar_datos->producto_nombre;
                                        $model->venta_detalle_cantidad = $cantidad;
                                        //$model->venta_total_selled = 1;
                                        $model->venta_detalle_total_igv = $igv_detalle;
                                        $model->venta_detalle_porcentaje_igv = $igv_porcentaje * 100;
                                        //$model->id_igv = 1;
                                        $model->venta_detalle_total_icbper = 0.00;
                                        $model->venta_detalle_valor_total = $precio_unitario * $cantidad;
                                        $model->venta_detalle_total_price = $precio_unitario * $cantidad * $factor_porcentaje;

                                        if ($_POST['tipo_venta'] == "20") {
                                            //$result = $this->pedido->guardar_nota_venta_detalle($model);
                                            $result = $this->pedido->guardar_venta_detalle($model);
                                        } else {
                                            $result = $this->pedido->guardar_venta_detalle($model);
                                        }
                                        if ($result == 1) {
                                            $this->pedido->cambiar_estado_comanda($id_comanda_detalle);
                                            $pago = 0;
                                            $id_comanda = $jalar_datos->id_comanda;
                                            $verificar = $this->pedido->verificar_pago($id_comanda);

                                            //VALIDAR PARA QUE NO DISMINUYA EL STOCK DE NUEVO
                                            /*$existe_detalle_comanda = $this->pedido->verificar_existencia_detalle_comanda($id_comanda_detalle);
                                            $existe = false;
                                            if(empty($existe_detalle_comanda)){
                                                $existe = true;
                                            }*/
                                            if (isset($_POST['id_venta'])) {
                                                $entr = false;
                                            } else {
                                                $entr = true; //cambiar a true cuando se deje de emitir las facturas antiguas para no restar stock
                                            }
                                            if ($entr) {
                                                //Aqui ira la disminucion de stock aunque no se como pocta lo hare
                                                $valor_insumos = $this->pedido->valor_insumos($id_comanda_detalle);
                                                foreach ($valor_insumos as $v) {
                                                    $capturar = $v->id_recurso_sede;
                                                    $unidad_medida = $v->id_medida;
                                                    $id_detalle_receta = $v->id_detalle_receta;
                                                    $monto_usado = $v->detalle_receta_cantidad;
                                                    $cantidad = $this->pedido->capturar_cantidad($capturar);
                                                    $valor_cantidad = $cantidad->recurso_sede_stock;
                                                    if ($v->detalle_receta_unidad_medida != 0) {
                                                        $detalle_conversion = $this->pedido->conversion_por_id($v->detalle_receta_unidad_medida);
                                                        $nuevo_monto = ($monto_usado / $detalle_conversion->conversion_cantidad) * (-1);
                                                        $actualizar_stock = $this->pedido->actualizar_stock($nuevo_monto, $capturar);
                                                    } else {
                                                        $montito = $monto_usado * (-1);
                                                        $actualizar_stock = $this->pedido->actualizar_stock($montito, $capturar);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                $contenido_tipopago = $_POST['contenido_tipopago'];
                                if (count_chars($contenido_tipopago) > 0) {
                                    $filas = explode('/-/-', $contenido_tipopago);
                                    if (count($filas) > 0) {
                                        for ($i = 0; $i < count($filas) - 1; $i++) {
                                            $modelDSI = new Pedido();
                                            $celdas = explode('-.-.', $filas[$i]);
                                            $modelDSI->id_venta = $id_venta;
                                            $modelDSI->id_tipo_pago = $celdas[0];
                                            $modelDSI->venta_detalle_pago_monto = $celdas[1];
                                            $modelDSI->venta_detalle_pago_estado = 1;
                                            $result__ = $this->pedido->guardar_detalle_pago($modelDSI);

                                        }
                                    }
                                }
                                if ($result == 1) {
                                    $result = $this->pedido->actualizarCorrelativo_x_id_Serie($_POST['serie'], $correlativo);
                                    if (!isset($_POST['id_venta'])) {
                                        if (empty($verificar)) {
                                            $result = $this->pedido->actualizar_estado_mesa($id_mesa);
                                            $this->pedido->ocultar_reserva($id_mesa);
                                            $pago = 1;
                                        }
                                    }
                                    if ($result == 1) {
                                        $result__ = $this->pedido->ocultar_reserva($id_mesa);
                                    }

                                    if ($_POST['tipo_venta'] == "20") {
                                        /*$venta = $this->venta->listar_nota_venta_x_id($id_venta);
                                        $detalle_venta =$this->venta->listar_nota_venta_detalle_x_id_venta($id_venta);
                                        $empresa = $this->venta->listar_empresa_x_id_empresa($venta->id_empresa);
                                        $cliente = $this->venta->listar_cliente_notaventa_x_id($venta->id_cliente);*/
                                        $venta = $this->venta->listar_venta_x_id($id_venta);
                                        $detalle_venta = $this->venta->listar_venta_detalle_x_id_venta($id_venta);
                                        $empresa = $this->venta->listar_empresa_x_id_empresa($venta->id_empresa);
                                        $cliente = $this->venta->listar_clienteventa_x_id($venta->id_cliente);
                                        $venta_tipo = "NOTA DE VENTA";
                                        if ($cliente->id_tipodocumento == "4") {
                                            $cliente_nombre = $cliente->cliente_razonsocial;
                                        } else {
                                            $cliente_nombre = $_POST['cliente_nombre'];
                                        }
                                        if ($_POST['imprimir'] == "1") {
                                            require _VIEW_PATH_ . 'pedido/ticket_nota_venta.php';
                                        }

                                    } else {
                                        //INICIO - LISTAR COLUMNAS PARA TICKET DE VENTA
                                        include('libs/ApiFacturacion/phpqrcode/qrlib.php');

                                        $venta = $this->venta->listar_venta_x_id($id_venta);
                                        $detalle_venta = $this->venta->listar_venta_detalle_x_id_venta($id_venta);
                                        $empresa = $this->venta->listar_empresa_x_id_empresa($venta->id_empresa);
                                        $cliente = $this->venta->listar_clienteventa_x_id($venta->id_cliente);
                                        //INICIO - CREACION QR
                                        $nombre_qr = $empresa->empresa_ruc . '-' . $venta->venta_tipo . '-' . $venta->venta_serie . '-' . $venta->venta_correlativo;
                                        $contenido_qr = $empresa->empresa_ruc . '|' . $venta->venta_tipo . '|' . $venta->venta_serie . '|' . $venta->venta_correlativo . '|' .
                                            $venta->venta_totaligv . '|' . $venta->venta_total . '|' . date('Y-m-d', strtotime($venta->venta_fecha)) . '|' .
                                            $cliente->tipodocumento_codigo . '|' . $cliente->cliente_numero;
                                        $ruta = 'libs/ApiFacturacion/imagenqr/';
                                        $ruta_qr = $ruta . $nombre_qr . '.png';
                                        QRcode::png($contenido_qr, $ruta_qr, 'H - mejor', '3');
                                        //FIN - CREACION QR
                                        if ($venta->venta_tipo == "03") {
                                            $venta_tipo = "BOLETA DE VENTA ELECTRÓNICA";
                                        } elseif ($venta->venta_tipo == "01") {
                                            $venta_tipo = "FACTURA DE VENTA ELECTRÓNICA";
                                        }
                                        if ($cliente->id_tipodocumento == "4") {
                                            $cliente_nombre = $cliente->cliente_razonsocial;
                                        } else {
                                            $cliente_nombre = $_POST['cliente_nombre'];
                                        }
                                        /*if($_POST['imprimir'] == "1"){
                                            require _VIEW_PATH_ . 'pedido/ticket_venta.php';
                                        }*/
                                    }


                                    //INICIO - TICKET DELIVERY
                                    //$venta = $this->venta->listar_venta_x_id($id);
                                    if ($id_mesa == 0) {
                                        $cliente = $this->pedido->listar_clienteventa_x_id_delivery($id_cliente);
                                        $id_comanda = $cliente->id_comanda;
                                        $datos_ticket = $this->pedido->jalar_datos_comanda($id_comanda);

                                        if ($cliente->id_tipodocumento == "4") {
                                            $cliente_nombre = $cliente->cliente_razonsocial;
                                        } else {
                                            $cliente_nombre = $_POST['cliente_nombre'];
                                        }

                                        /*require _VIEW_PATH_ . 'pedido/ticket_venta_delivery.php';*/
                                        //echo "<script>window.open("._SERVER_."'Pedido/ticket_venta/".$id_venta."','_blank')</script>";
                                    }

                                }

                            }

                            //$this->pedido->cambiar_estado_comanda_principal($id_comanda);
                        } else {
                            $result = 2;
                        }

                    }
                }else{
                    if($result == 1){
                        $id_mesa = $_POST['id_mesa'];
                        $fecha = date('Y-m-d H:i:s');
                        $model->id_mesa = $id_mesa;
                        $model->id_usuario = $id_usuario;
                        $model->cliente_numero = $_POST['cliente_numero'];
                        $model->cliente_nombre = $_POST['cliente_nombre'];
                        $model->cliente_direccion = $_POST['cliente_direccion'];
                        $model->venta_total = $_POST['venta_total'];
                        $model->observacion_cortesia = $_POST['observacion_cortesia'];
                        $model->fecha = $fecha;
                        $microtime = microtime(true);
                        $model->codigo = $microtime;
                        $result = $this->pedido->guardar_pedido_gratis($model);
                        if($result == 1){
                            $pedido_gratis = $this->pedido->listar_pedido_gratis_x_mt($microtime);
                            $datos_detalle_pedido = $_POST['datos_detalle_pedido'];
                            $id_pedido_gratis = $pedido_gratis->id_pedido_gratis;
                            if(count_chars($datos_detalle_pedido)>0){
                                $celdas=explode('-.-.',$datos_detalle_pedido);
                                if(count($celdas)>0){

                                    for ($i=0;$i<count($celdas)-1;$i++){

                                        $id_comanda_detalle = $celdas[$i];
                                        $jalar_datos = $this->pedido->jalar_datos($id_comanda_detalle);
                                        $model->id_pedido_gratis = $id_pedido_gratis;
                                        $model->id_comanda_detalle = $id_comanda_detalle;

                                        $result = $this->pedido->guardar_pedido_gratis_detalle($model);
                                        if($result == 1){
                                            $this->pedido->cambiar_estado_comanda($id_comanda_detalle);
                                            $pago = 0;
                                            $id_comanda = $jalar_datos->id_comanda;
                                            $verificar = $this->pedido->verificar_pago($id_comanda);

                                            //VALIDAR PARA QUE NO DISMINUYA EL STOCK DE NUEVO
                                            /*$existe_detalle_comanda = $this->pedido->verificar_existencia_detalle_comanda($id_comanda_detalle);
                                            $existe = false;
                                            if(empty($existe_detalle_comanda)){
                                                $existe = true;
                                            }*/
                                            if(isset($_POST['id_venta'])){
                                                $entr = false;
                                            }else{
                                                $entr = true; //cambiar a true cuando se deje de emitir las facturas antiguas para no restar stock
                                            }
                                            if ($entr){
                                                //Aqui ira la disminucion de stock aunque no se como pocta lo hare
                                                $valor_insumos = $this->pedido->valor_insumos($id_comanda_detalle);
                                                foreach ($valor_insumos as $v){
                                                    $capturar = $v->id_recurso_sede;
                                                    $unidad_medida = $v->id_medida;
                                                    $id_detalle_receta = $v->id_detalle_receta;
                                                    $monto_usado = $v->detalle_receta_cantidad;
                                                    $cantidad = $this->pedido->capturar_cantidad($capturar);
                                                    $valor_cantidad = $cantidad->recurso_sede_stock;
                                                    if($v->detalle_receta_unidad_medida != 0){
                                                        $detalle_conversion = $this->pedido->conversion_por_id($v->detalle_receta_unidad_medida);
                                                        $nuevo_monto = ($monto_usado / $detalle_conversion->conversion_cantidad) * (-1);
                                                        $actualizar_stock = $this->pedido->actualizar_stock($nuevo_monto,$capturar);
                                                    }else{
                                                        $montito = $monto_usado * (-1);
                                                        $actualizar_stock = $this->pedido->actualizar_stock($montito,$capturar);
                                                    }
                                                }
                                            }
                                        }


                                    }
                                }
                                if($result==1){
                                    if(empty($verificar)){
                                        $result = $this->pedido->actualizar_estado_mesa($id_mesa);
                                        $pago = 1;
                                    }
                                }
                            }
                        }
                        if($result==1){
                            $result__ = $this->pedido->ocultar_reserva($id_mesa);
                        }
                    }
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

    //FUNCION PARA CAMBIAR LOS ESTADOS DEL PEDIDO
    public function cambiar_estado_pedido(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_comanda_detalle', 'POST',true,$ok_data,11,'texto',0);
            $ok_data = $this->validar->validar_parametro('comanda_detalle_estado', 'POST',true,$ok_data,11,'numero',0);

            //Validacion de datos
            if($ok_data) {

                $id_comanda_detalle = $_POST['id_comanda_detalle'];
                $comanda_detalle_estado = $_POST['comanda_detalle_estado'];

                $result = $this->pedido->cambiar_estado_pedido($id_comanda_detalle, $comanda_detalle_estado);

                if($result == 1){
                    if ($comanda_detalle_estado == 2){
                        //INICIO - IMPRIMIR TICKET DE ATENCION
                        $detalle_comanda = $this->pedido->listar_detallecomanda_x_id_comanda_detalle($id_comanda_detalle);

                        require _VIEW_PATH_ . 'pedido/ticket_atencion.php';
                        require _VIEW_PATH_ . 'pedido/ticket_atencion.php';
                    }

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

    //FUNCION PARA GUARDAR VENTA
    public function guardar_venta(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validacion de datos
            if($ok_data) {
                $model = new Pedido();
                $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'], _FULL_KEY_);
                //$id_cliente = $this->pedido->listar_cliente_x_numero($_POST['cliente_numero']);
                //INICIO - VERIFICAR SI EL CLIENTE EXISTE, SI NO EXISTE PASAR A REGISTRAR
                if($this->cliente->validar_dni($_POST['cliente_numero'])){
                    //Código 5: DNI duplicado
                    $cliente = $this->cliente->listar_cliente_x_numero($_POST['cliente_numero']);
                    $id_cliente = $cliente->id_cliente;
                    $result = 1;
                    $message = "Ya existe un cliente con este DNI registrado";
                }else{
                    $microtime = microtime(true);

                    $model->id_tipodocumento = $_POST['select_tipodocumento'];
                    $model->cliente_razonsocial = "";
                    $model->cliente_nombre = "";
                    if($_POST['select_tipodocumento'] == 4){
                        $model->cliente_razonsocial = $_POST['cliente_nombre'];
                    }else{
                        $model->cliente_nombre = $_POST['cliente_nombre'];
                    }
                    $model->cliente_numero = $_POST['cliente_numero'];
                    $model->cliente_correo = "";
                    $model->cliente_direccion = $_POST['cliente_direccion'];
                    $model->cliente_direccion_2 = "";
                    $model->cliente_telefono = "";
                    $model->cliente_codigo = $microtime;
                    $model->cliente_estado = 1;
                    $result = $this->cliente->guardar_cliente($model);
                    if($result == 1){
                        $cliente = $this->cliente->listar_cliente_x_numero($_POST['cliente_numero']);
                        $id_cliente = $cliente->id_cliente;
                    }else{
                        $result = 5;
                    }
                }

                if($_POST['gratis'] == 2){
                    if($result == 1){
                        $tipo_pago = $_POST['id_tipo_pago'];
                        $fecha_hoy = date('Y-m-d');
                        $jalar_id_caja = $this->pedido->jalar_id_caja_aperturada($id_usuario);
                        $id_mesa = $_POST['id_mesa'];
                        $caja_dato = $this->pedido->jalar_datos_caja_numero($jalar_id_caja->id_caja_numero);//datos de la caja para la captura del nombre de la impresora

                        $fecha = date('Y-m-d H:i:s');
                        $model->id_caja_numero = $jalar_id_caja->id_caja_numero;
                        $model->id_usuario = $id_usuario;
                        $model->id_mesa = $id_mesa;
                        $model->id_moneda = 1;
                        //$model->id_cliente = $_POST['id_cliente'];
                        $model->id_cliente = $id_cliente;
                        $model->venta_tipo = $_POST['tipo_venta'];
                        //obtener serie con el id
                        $serie_ = $this->pedido->listar_correlativos_x_serie($_POST['serie']);
                        $model->venta_serie = $serie_->serie;
                        if (isset($_POST['id_venta'])){
                            if($_POST['tipo_venta']== "20"){
                                $correlativo = $_POST['correlativo'];
                            }else{
                                $correlativo = $serie_->correlativo + 1;
                            }
                        }else{
                            $correlativo = $serie_->correlativo + 1;
                        }
                        $model->venta_correlativo = $correlativo;
                        $model->venta_tipo_moneda = $_POST['tipo_moneda'];
                        $model->id_tipo_pago = $tipo_pago;


                        //$correlativo = $this->pedido->listar_correlativos();
                        //AL HACER LA VENTA AUTOMATICAMENTE SE LLENA EL CORRELATIVO DE LA VENTA
                        $model->venta_totalgratuita = $_POST['op_gratuitas_'];
                        $model->venta_totalexonerada = $_POST['op_exoneradas_'];
                        $model->venta_totalinafecta = $_POST['op_inafectas_'];
                        $model->venta_totalgravada = $_POST['op_gravadas_'];
                        $model->venta_totaligv = $_POST['igv_'];
                        $model->venta_icbper = $_POST['icbper_'];
                        $model->venta_fecha = $fecha;
                        $model->tipo_documento_modificar = "";
                        $model->tipo_nota_id = 0;
                        $model->correlativo_modificar = "";
                        $model->venta_total = $_POST['venta_total'];
                        if(empty($_POST['pago_cliente'])){
                            $model->pago_cliente = 0;
                        }else{
                            $model->pago_cliente = $_POST['pago_cliente'];
                        }
                        if(empty($_POST['vuelto_'])){
                            $model->vuelto_ = 0;
                        }else{
                            $model->vuelto_ = $_POST['vuelto_'];
                        }
                        //si la cajera escoge nota de venta se guardará en nota de venta - SINO SERÁ UUNA VENTA BOLETA O FACTURA
                        $guardar_venta = 2;
                        if($_POST['tipo_venta'] == '20'){
//                        $guardar_venta = $this->pedido->guardar_nota_venta($model);
                            $guardar_venta = $this->pedido->guardar_venta($model);

                        }else{
                            $guardar_venta = $this->pedido->guardar_venta($model);
                        }

                        if($guardar_venta == 1){
                            $model = new Pedido();
                            if($_POST['tipo_venta'] == '20'){
                                /*$jalar_id_venta = $this->pedido->jalar_id_nota_venta($fecha,$id_cliente);
                                $id_venta = $jalar_id_venta->id_nota_venta;*/
                                $jalar_id_venta = $this->pedido->jalar_id_venta($fecha,$id_cliente);
                                $id_venta = $jalar_id_venta->id_venta;
                            }else{
                                $jalar_id_venta = $this->pedido->jalar_id_venta($fecha,$id_cliente);
                                $id_venta = $jalar_id_venta->id_venta;
                            }

                            $datos_detalle_pedido = $_POST['datos_detalle_pedido'];
                            if(count_chars($datos_detalle_pedido)>0){
                                $celdas=explode('-.-.',$datos_detalle_pedido);
                                if(count($celdas)>0){
                                    $igv_porcentaje = 0.18;
                                    for ($i=0;$i<count($celdas)-1;$i++){
                                        $model->id_venta = $id_venta;
                                        $id_comanda_detalle = $celdas[$i];
                                        if($id_comanda_detalle != 1){
                                            $jalar_datos = $this->pedido->jalar_datos($id_comanda_detalle);
                                            $cantidad = $jalar_datos->comanda_detalle_cantidad;
                                            $precio_unitario = $jalar_datos->comanda_detalle_precio;
                                            $codigo_afectacion = $jalar_datos->producto_precio_codigoafectacion;
                                            $igv_detalle = 0;
                                            $factor_porcentaje = 1;
                                            if($codigo_afectacion == 10){
                                                $igv_detalle = $precio_unitario * $cantidad * $igv_porcentaje;
                                                $factor_porcentaje = 1 + $igv_porcentaje;
                                            }

                                            $model->id_comanda_detalle = $id_comanda_detalle;
                                            $model->venta_detalle_valor_unitario = $precio_unitario;
                                            $model->venta_detalle_precio_unitario = $precio_unitario * $factor_porcentaje;
                                            $model->venta_detalle_nombre_producto = $jalar_datos->producto_nombre;
                                            $model->venta_detalle_cantidad = $cantidad;
                                            //$model->venta_total_selled = 1;
                                            $model->venta_detalle_total_igv = $igv_detalle;
                                            $model->venta_detalle_porcentaje_igv = $igv_porcentaje * 100;
                                            //$model->id_igv = 1;
                                            $model->venta_detalle_total_icbper = 0.00;
                                            $model->venta_detalle_valor_total = $precio_unitario * $cantidad;
                                            $model->venta_detalle_total_price = $precio_unitario * $cantidad * $factor_porcentaje;

                                            if($_POST['tipo_venta']=="20"){
                                                //$result = $this->pedido->guardar_nota_venta_detalle($model);
                                                $result = $this->pedido->guardar_venta_detalle($model);
                                            }else{
                                                $result = $this->pedido->guardar_venta_detalle($model);
                                            }
                                            if($result == 1){
                                                $this->pedido->cambiar_estado_comanda($id_comanda_detalle);
                                                $pago = 0;
                                                $id_comanda = $jalar_datos->id_comanda;
                                                $verificar = $this->pedido->verificar_pago($id_comanda);

                                                //VALIDAR PARA QUE NO DISMINUYA EL STOCK DE NUEVO
                                                /*$existe_detalle_comanda = $this->pedido->verificar_existencia_detalle_comanda($id_comanda_detalle);
                                                $existe = false;
                                                if(empty($existe_detalle_comanda)){
                                                    $existe = true;
                                                }*/
                                                if(isset($_POST['id_venta'])){
                                                    $entr = false;
                                                }else{
                                                    $entr = true; //cambiar a true cuando se deje de emitir las facturas antiguas para no restar stock
                                                }
                                                if ($entr){
                                                    //Aqui ira la disminucion de stock aunque no se como pocta lo hare
                                                    $valor_insumos = $this->pedido->valor_insumos($id_comanda_detalle);
                                                    foreach ($valor_insumos as $v){
                                                        $capturar = $v->id_recurso_sede;
                                                        $unidad_medida = $v->id_medida;
                                                        $id_detalle_receta = $v->id_detalle_receta;
                                                        $monto_usado = $v->detalle_receta_cantidad;
                                                        $cantidad = $this->pedido->capturar_cantidad($capturar);
                                                        $valor_cantidad = $cantidad->recurso_sede_stock;
                                                        if($v->detalle_receta_unidad_medida != 0){
                                                            $detalle_conversion = $this->pedido->conversion_por_id($v->detalle_receta_unidad_medida);
                                                            $nuevo_monto = ($monto_usado / $detalle_conversion->conversion_cantidad) * (-1);
                                                            $actualizar_stock = $this->pedido->actualizar_stock($nuevo_monto,$capturar);
                                                        }else{
                                                            $montito = $monto_usado * (-1);
                                                            $actualizar_stock = $this->pedido->actualizar_stock($montito,$capturar);
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                    }
                                }
                                $contenido_tipopago = $_POST['contenido_tipopago'];
                                if(count_chars($contenido_tipopago)>0){
                                    $filas=explode('/-/-',$contenido_tipopago);
                                    if(count($filas)>0){
                                        for ($i=0;$i<count($filas)-1;$i++){
                                            $modelDSI=new Pedido();
                                            $celdas=explode('-.-.',$filas[$i]);
                                            $modelDSI->id_venta = $id_venta;
                                            $modelDSI->id_tipo_pago = $celdas[0];
                                            $modelDSI->venta_detalle_pago_monto = $celdas[1];
                                            $modelDSI->venta_detalle_pago_estado = 1;
                                            $result__ = $this->pedido->guardar_detalle_pago($modelDSI);

                                        }
                                    }
                                }

                                if($result == 1){
                                    $modelc = new Pedido();
                                    $id_puntos = $this->pedido->jalar_valor_puntos();
                                    if(!empty($id_puntos)){
                                        $valor_puntos = $id_puntos->puntos_cantidad_soles;
                                        $operacion  = $_POST['venta_total'] / $valor_puntos;
                                        $valor_final = intval($operacion);

                                        $modelc->id_cliente = $id_cliente;
                                        $modelc->id_puntos = $id_puntos->id_puntos;
                                        $modelc->puntos_cliente_acumulado = $valor_final;
                                        $modelc->puntos_cliente_fecha_registro = date('Y-m-d H:i:s');
                                        $modelc->puntos_cliente_estado = 1;

                                        $result = $this->pedido->guardar_puntos_ventas($modelc);
                                    }
                                }

                                if($result==1){
                                    $result = $this->pedido->actualizarCorrelativo_x_id_Serie($_POST['serie'],$correlativo);
                                    if (!isset($_POST['id_venta'])){
                                        if(empty($verificar)){
                                            $result = $this->pedido->actualizar_estado_mesa($id_mesa);
                                            $this->pedido->ocultar_reserva($id_mesa);
                                            $pago = 1;
                                        }
                                    }

                                    if($_POST['tipo_venta']=="20"){
                                        /*$venta = $this->venta->listar_nota_venta_x_id($id_venta);
                                        $detalle_venta =$this->venta->listar_nota_venta_detalle_x_id_venta($id_venta);
                                        $empresa = $this->venta->listar_empresa_x_id_empresa($venta->id_empresa);
                                        $cliente = $this->venta->listar_cliente_notaventa_x_id($venta->id_cliente);*/
                                        $venta = $this->venta->listar_venta_x_id($id_venta);
                                        $detalle_venta =$this->venta->listar_venta_detalle_x_id_venta($id_venta);
                                        $empresa = $this->venta->listar_empresa_x_id_empresa($venta->id_empresa);
                                        $cliente = $this->venta->listar_clienteventa_x_id($venta->id_cliente);
                                        $venta_tipo = "NOTA DE VENTA";
                                        if($cliente->id_tipodocumento == "4"){
                                            $cliente_nombre = $cliente->cliente_razonsocial;
                                        }else{
                                            $cliente_nombre = $_POST['cliente_nombre'];
                                        }
                                        if($_POST['imprimir'] == "1"){
                                            require _VIEW_PATH_ . 'pedido/ticket_nota_venta.php';
                                        }

                                    }else{
                                        //INICIO - LISTAR COLUMNAS PARA TICKET DE VENTA
                                        include('libs/ApiFacturacion/phpqrcode/qrlib.php');

                                        $venta = $this->venta->listar_venta_x_id($id_venta);
                                        $detalle_venta =$this->venta->listar_venta_detalle_x_id_venta($id_venta);
                                        $comanda = $this->pedido->listar_detalle_x_comanda_detalle($detalle_venta[0]->id_comanda_detalle);
                                        $empresa = $this->venta->listar_empresa_x_id_empresa($venta->id_empresa);
                                        $cliente = $this->venta->listar_clienteventa_x_id($venta->id_cliente);
                                        //INICIO - CREACION QR
                                        $nombre_qr = $empresa->empresa_ruc. '-' .$venta->venta_tipo. '-' .$venta->venta_serie. '-' .$venta->venta_correlativo;
                                        $contenido_qr = $empresa->empresa_ruc.'|'.$venta->venta_tipo.'|'.$venta->venta_serie.'|'.$venta->venta_correlativo. '|'.
                                            $venta->venta_totaligv.'|'.$venta->venta_total.'|'.date('Y-m-d', strtotime($venta->venta_fecha)).'|'.
                                            $cliente->tipodocumento_codigo.'|'.$cliente->cliente_numero;
                                        $ruta = 'libs/ApiFacturacion/imagenqr/';
                                        $ruta_qr = $ruta.$nombre_qr.'.png';
                                        QRcode::png($contenido_qr, $ruta_qr, 'H - mejor', '3');
                                        //FIN - CREACION QR
                                        if($venta->venta_tipo == "03"){
                                            $venta_tipo = "BOLETA DE VENTA ELECTRÓNICA";
                                        }elseif($venta->venta_tipo == "01"){
                                            $venta_tipo = "FACTURA DE VENTA ELECTRÓNICA";
                                        }
                                        if($cliente->id_tipodocumento == "4"){
                                            $cliente_nombre = $cliente->cliente_razonsocial;
                                        }else{
                                            $cliente_nombre = $_POST['cliente_nombre'];
                                        }
                                        if($_POST['imprimir'] == "1"){
                                            require _VIEW_PATH_ . 'pedido/ticket_venta.php';
                                        }
                                    }

                                    //INICIO - TICKET DELIVERY
                                    //$venta = $this->venta->listar_venta_x_id($id);
                                    if($id_mesa == 0){
                                        $cliente = $this->pedido->listar_clienteventa_x_id_delivery($id_cliente);
                                        $id_comanda = $cliente->id_comanda;
                                        $datos_ticket = $this->pedido->jalar_datos_comanda($id_comanda);

                                        if($cliente->id_tipodocumento == "4"){
                                            $cliente_nombre = $cliente->cliente_razonsocial;
                                        }else{
                                            $cliente_nombre = $_POST['cliente_nombre'];
                                        }

                                        require _VIEW_PATH_ . 'pedido/ticket_venta_delivery.php';
                                        //echo "<script>window.open("._SERVER_."'Pedido/ticket_venta/".$id_venta."','_blank')</script>";
                                    }

                                }

                            }

                            //$this->pedido->cambiar_estado_comanda_principal($id_comanda);
                        }else{
                            $result = 2;
                        }
                    }
                }else{
                    if($result == 1){
                        $id_mesa = $_POST['id_mesa'];
                        $fecha = date('Y-m-d H:i:s');
                        $model->id_mesa = $id_mesa;
                        $model->id_usuario = $id_usuario;
                        $model->cliente_numero = $_POST['cliente_numero'];
                        $model->cliente_nombre = $_POST['cliente_nombre'];
                        $model->cliente_direccion = $_POST['cliente_direccion'];
                        $model->venta_total = $_POST['venta_total'];
                        $model->fecha = $fecha;
                        $microtime = microtime(true);
                        $model->codigo = $microtime;
                        $result = $this->pedido->guardar_pedido_gratis($model);
                        if($result == 1){
                            $pedido_gratis = $this->pedido->listar_pedido_gratis_x_mt($microtime);
                            $datos_detalle_pedido = $_POST['datos_detalle_pedido'];
                            $id_pedido_gratis = $pedido_gratis->id_pedido_gratis;
                            if(count_chars($datos_detalle_pedido)>0){
                                $celdas=explode('-.-.',$datos_detalle_pedido);
                                if(count($celdas)>0){

                                    for ($i=0;$i<count($celdas)-1;$i++){

                                        $id_comanda_detalle = $celdas[$i];
                                        $jalar_datos = $this->pedido->jalar_datos($id_comanda_detalle);
                                        $model->id_pedido_gratis = $id_pedido_gratis;
                                        $model->id_comanda_detalle = $id_comanda_detalle;

                                        $result = $this->pedido->guardar_pedido_gratis_detalle($model);
                                        if($result == 1){
                                            $this->pedido->cambiar_estado_comanda($id_comanda_detalle);
                                            $pago = 0;
                                            $id_comanda = $jalar_datos->id_comanda;
                                            $verificar = $this->pedido->verificar_pago($id_comanda);

                                            //VALIDAR PARA QUE NO DISMINUYA EL STOCK DE NUEVO
                                            /*$existe_detalle_comanda = $this->pedido->verificar_existencia_detalle_comanda($id_comanda_detalle);
                                            $existe = false;
                                            if(empty($existe_detalle_comanda)){
                                                $existe = true;
                                            }*/
                                            if(isset($_POST['id_venta'])){
                                                $entr = false;
                                            }else{
                                                $entr = true; //cambiar a true cuando se deje de emitir las facturas antiguas para no restar stock
                                            }
                                            if ($entr){
                                                //Aqui ira la disminucion de stock aunque no se como pocta lo hare
                                                $valor_insumos = $this->pedido->valor_insumos($id_comanda_detalle);
                                                foreach ($valor_insumos as $v){
                                                    $capturar = $v->id_recurso_sede;
                                                    $unidad_medida = $v->id_medida;
                                                    $id_detalle_receta = $v->id_detalle_receta;
                                                    $monto_usado = $v->detalle_receta_cantidad;
                                                    $cantidad = $this->pedido->capturar_cantidad($capturar);
                                                    $valor_cantidad = $cantidad->recurso_sede_stock;
                                                    if($v->detalle_receta_unidad_medida != 0){
                                                        $detalle_conversion = $this->pedido->conversion_por_id($v->detalle_receta_unidad_medida);
                                                        $nuevo_monto = ($monto_usado / $detalle_conversion->conversion_cantidad) * (-1);
                                                        $actualizar_stock = $this->pedido->actualizar_stock($nuevo_monto,$capturar);
                                                    }else{
                                                        $montito = $monto_usado * (-1);
                                                        $actualizar_stock = $this->pedido->actualizar_stock($montito,$capturar);
                                                    }
                                                }
                                            }
                                        }


                                    }
                                }
                                if($result==1){
                                    if(empty($verificar)){
                                        $result = $this->pedido->actualizar_estado_mesa($id_mesa);
                                        $pago = 1;
                                    }
                                }
                            }
                        }
                        if($result==1){
                            $result__ = $this->pedido->ocultar_reserva($id_mesa);
                        }
                    }
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
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "pago"=>$pago)));
    }

    //FUNCION PARA ELIMINAR LOS DETALLES DE LA COMANDA
    public function eliminar_comanda_detalle(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validacion de datos
            if($ok_data) {
                $id_rol = 7;
                $id_rol = 5;
                if($this->pedido->verificar_password($id_rol, $_POST['password'])){
                    $id_comanda_detalle = $_POST['id_comanda_detalle'];
                    $comanda_detalle_eliminacion = $_POST['comanda_detalle_eliminacion'];
                    $fecha_eliminacion = date('Y-m-d H:i:s');
                    $id_comanda = $_POST['id_comanda'];
                    $id_mesa = $_POST['id_mesa'];
                    $result = $this->pedido->eliminar_comanda_detalle($comanda_detalle_eliminacion,$fecha_eliminacion,$id_comanda_detalle);
                    if($result == 1){
                        $jalar_valor = $this->pedido->jalar_valor($id_comanda);
                        $nuevo_valor = $jalar_valor->total;
                        $actualizar_precio = $this->pedido->actualizar_nuevo_valor($id_comanda, $nuevo_valor);
                        $mesa = 0;
                        //HACER UN CONTEO
                        $resultado = $this->pedido->listar_detalles_x_pedido($id_comanda);
                        $resultado_ventas = $this->pedido->listar_detalles_x_pedido_pagados($id_comanda);
                        if(empty($resultado)){
                            $result = $this->pedido->actualizar_estado_mesa($id_mesa);
                            $mesa = 1;

                        }
                        if(empty($resultado_ventas)){
                            $result = $this->pedido->actualizar_estado_mesa($id_mesa);
                            $mesa = 1;
                            }

                        }
                    }else{
                    $result = 5;
                    $message = 'Contraseña Incorrecta';
                }
            }else {
            //Código 6: Integridad de datos erronea
            $result = 6;
            $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
                }
        }catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "mesa" => $mesa)));
    }

    public function cambiar_comanda_detalle_cantid(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validacion de datos
            if ($ok_data) {

                $id_comanda = $_POST['id_comanda'];
                $id_comanda_detalle = $_POST['id_comanda_detalle'];
                $cantidad_detalle_nuevo = $_POST['cantidad_detalle_nuevo'];
                $total = $_POST['total'];
                $result = $this->pedido->actualizar_comanda_detalle_cantidad($id_comanda_detalle, $cantidad_detalle_nuevo, $total);
                if($result == 1){
                    $jalar_valor = $this->pedido->jalar_valor($id_comanda);
                    $nuevo_valor = $jalar_valor->total;
                    $result = $this->pedido->actualizar_nuevo_valor($id_comanda, $nuevo_valor);
                }
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result)));
    }

    //FUNCION PARA ELIMINAR COMANDA DEL DELIVERY
    public function eliminar_comanda_delivery(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validacion de datos
            if ($ok_data) {
                if($this->pedido->verificar_password($this->encriptar->desencriptar($_SESSION['_n'],_FULL_KEY_), $_POST['password'])) {
                    $id_comanda_detalle = $_POST['id_comanda_detalle'];
                    $id_comanda = $_POST['id_comanda'];
                    $result = $this->pedido->eliminar_comanda_detalle_delivery($id_comanda);
                    if($result == 1){
                        $result = $this->pedido->eliminar_comanda($id_comanda);
                    }
                }
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    //FUNCION PARA CAMBIAR MESA
    public function cambiar_mesa(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_mesa_nuevo', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('id_mesa', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('id_comanda', 'POST',true,$ok_data,11,'numero',0);
            //Validacion de datos
            if ($ok_data) {
                $id_mesa_nuevo = $_POST['id_mesa_nuevo'];
                $id_comanda = $_POST['id_comanda'];
                $result = $this->pedido->cambiar_mesa($id_mesa_nuevo, $id_comanda);
                $this->pedido->cambiar_estado_mesa($id_mesa_nuevo);
                $id_mesa = $_POST['id_mesa'];
                $this->pedido->actualizar_estado_mesa($id_mesa);
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function transferir_pedido_(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_mesa_pn', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('id_mesa', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('id_comanda', 'POST',true,$ok_data,11,'numero',0);
            //Validacion de datos
            if($ok_data) {
                $id_mesa_pn = $_POST['id_mesa_pn'];
                $id_comanda_ = $_POST['id_comanda'];
                $id_mesa = $_POST['id_mesa'];

                $jalar_pedidos_mesa_actual = $this->pedido->jalar_pedidos_mesa_actual($id_comanda_);
                $extraer_id_comanda = $this->pedido->extraer_id_comanda_destino($id_mesa_pn);
                $jalar_pedidos_mesa_destino = $this->pedido->jalar_pedidos_mesa_destino($extraer_id_comanda->id_comanda);
                foreach ($jalar_pedidos_mesa_actual as $jp) {
                    $model = new Pedido();
                    $model->id_comanda = $extraer_id_comanda->id_comanda;
                    /*foreach ($jalar_pedidos_mesa_destino as $md){
                        if($jp->id_producto == $md->id_producto){
                            if($jp->comanda_detalle_despacho == $md->comanda_detalle_despacho){
                                $cantidad_x_producto = $jp->comanda_detalle_cantidad + $md->comanda_detalle_cantidad;
                            }

                        }
                    }*/

                    $model->id_producto = $jp->id_producto;
                    $model->cantidad_x_producto = $jp->comanda_detalle_cantidad;
                    $model->comanda_detalle_precio = $jp->comanda_detalle_precio;
                    $model->comanda_detalle_cantidad = $jp->comanda_detalle_cantidad;
                    $model->comanda_detalle_despacho = $jp->comanda_detalle_despacho;
                    $model->comanda_detalle_total = $jp->comanda_detalle_total;
                    $model->comanda_detalle_observacion = $jp->comanda_detalle_observacion;
                    $model->comanda_detalle_fecha_registro = $jp->comanda_detalle_fecha_registro;
                    $model->comanda_detalle_estado = $jp->comanda_detalle_estado;
                    $model->comanda_detalle_estado_venta = $jp->comanda_detalle_estado_venta;

                    $agregar_pedidos = $this->pedido->agregar_pedidos_mesa_destino($model);
                    $eliminar_pedidos = $this->pedido->eliminar_detalles_transferidos($jp->id_comanda_detalle);

                }
                $eliminar_comanda = $this->pedido->eliminar_comanda_transferida($id_comanda_);
                if($eliminar_comanda == 1){
                    $cambiar_estado_mesa = $this->pedido->actualizar_estado_mesa($id_mesa);
                }


            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function transferir_pedido(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_mesa_pn', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('id_mesa', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('id_comanda', 'POST',true,$ok_data,11,'numero',0);
            //Validacion de datos
            if($ok_data) {
                $id_mesa_pn = $_POST['id_mesa_pn'];
                $id_comanda_ = $_POST['id_comanda'];
                $id_mesa = $_POST['id_mesa'];

                $jalar_pedidos_mesa_actual = $this->pedido->jalar_pedidos_mesa_actual($id_comanda_);
                $extraer_id_comanda = $this->pedido->extraer_id_comanda_destino($id_mesa_pn);
                $jalar_pedidos_mesa_destino = $this->pedido->jalar_pedidos_mesa_destino($extraer_id_comanda->id_comanda);

                $total_comanda = 0;
                foreach ($jalar_pedidos_mesa_actual as $jp) {
                    $total_comanda = $total_comanda + $jp->comanda_detalle_total;
                }
                //$valor_comanda_recepcion = $extraer_id_comanda->comanda_total;
                $sumar_comandas = $this->pedido->sumar_valor_comandas($total_comanda,$extraer_id_comanda->id_comanda);
                $actualizar_id_comanda = $this->pedido->actializar_id_comanda($extraer_id_comanda->id_comanda,$id_comanda_);
                $eliminar_comanda = $this->pedido->eliminar_comanda_transferida($id_comanda_);
                if($eliminar_comanda == 1){
                    $result = $this->pedido->actualizar_estado_mesa($id_mesa);
                }

            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    //FUNCION PARA CAMBIAR CANTIDAD DE PERSONAS EN UN MESA
    public function cambiar_cantidad_personas(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validacion de datos
            if ($ok_data) {
                $id_comanda = $_POST['id_comanda'];
                $comanda_cantidad_personas = $_POST['comanda_cantidad_personas'];

                $result = $this->pedido->cambiar_cantidad_personas($id_comanda,$comanda_cantidad_personas);

            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    //FUNCION PARA CONSULTAR SERIE
    public function consultar_serie(){
        try{
            $concepto = $_POST['concepto'];
            $series = "";
            $correlativo = "";
            $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'], _FULL_KEY_);

            $fecha_hoy = date('Y-m-d');
            $jalar_id_caja = $this->pedido->jalar_id_caja_aperturada($id_usuario);
            $id_caja = $jalar_id_caja->id_caja_numero;
            if($concepto == "LISTAR_SERIE"){
                if(isset($_POST['concepto'])){
                    $series = $this->pedido->listarSerie($_POST['tipo_venta']);
                }else{
                    $series = $this->pedido->listarSerie_caja($_POST['tipo_venta'], $id_caja);
                }
            }else{
                $correlativo_ = $this->pedido->listar_correlativos_x_serie($_POST['id_serie']);
                $correlativo = $correlativo_->correlativo + 1;
            }
            //$series = $this->pedido->listarSerie($_POST['tipo_venta']);
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        $respuesta = array("serie" => $series, "correlativo" =>$correlativo);
        echo json_encode($respuesta);
    }

    //FUNCION PARA AGREGAR GRUPOS NUEVOS
    public function agregar_grupo(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;

            if ($ok_data) {
                $model = new Pedido();
                $fecha = date('Y-m-d H:i:s');
                $model->grupo_nombre = $_POST['grupo_nombre'];
                $model->grupo_ticketera = $_POST['grupo_ticketera'];
                $model->grupo_fecha_registro = $fecha;
                $model->grupo_estado = 1;

                $result = $this->pedido->guardar_grupos($model);

            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function habilitar_mesa(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if ($ok_data) {
                $id_mesa = $_POST['id_mesa'];
                $mesa_estado_atencion = $_POST['estado'];

                $result = $this->pedido->habilitar_mesa($mesa_estado_atencion,$id_mesa);
            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function guardar_reserva(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if ($ok_data) {
                $model = new Pedido();
                $model->id_reserva = $_POST['id_reserva'];
                $fecha = date('Y-m-d H:i:s');
                $id_mesa = $_POST['id_mesa'];
                $model->id_mesa = $id_mesa;
                $model->reserva_nombre = $_POST['reserva_nombre'];
                $model->reserva_cantidad = $_POST['reserva_cantidad'];
                $model->reserva_fecha = $_POST['reserva_fecha'];
                $model->reserva_hora = $_POST['reserva_hora'];
                $model->reserva_contacto = $_POST['reserva_contacto'];
                $model->reserva_fecha_registro = $fecha;
                $model->reserva_estado = 1;

                $result = $this->pedido->guardar_reserva($model);

                if($result == 1){
                    $fecha_comparar = date('Y-m-d');
                    $listar_reservas = $this->pedido->listar_ultima_reserva();
                    $fecha_reserva = $listar_reservas->reserva_fecha;
                    if($fecha_reserva == $fecha_comparar){
                        $result = $this->pedido->cambiar_estado_mesa_reserva($id_mesa);
                    }

                }

            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function habilitar_reserva(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if ($ok_data) {
                $id_mesa = $_POST['id_mesa'];
                $mesa_estado_atencion = $_POST['estado'];
                $result = $this->pedido->habilitar_mesa($mesa_estado_atencion,$id_mesa);
            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function eliminar_reserva(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if ($ok_data) {
                $id_reserva = $_POST['id_reserva'];
                $id_mesa = $_POST['id_mesa'];

                $result = $this->pedido->eliminar_reserva($id_reserva);
                if($result == 1){
                    $result = $this->pedido->mesa_estado_limpio($id_mesa);
                }
            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function mesa_visible(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if ($ok_data) {
                $id_mesa = $_POST['id_mesa'];

                $result = $this->pedido->mostrar_mesita($id_mesa);
            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function cambiar_estado_comanda_deliver(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if ($ok_data) {
                $id_comanda = $_POST['id'];
                $result = $this->pedido->cambiar_estado_comanda_delivery($id_comanda);

            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function guardar_cambio(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if ($ok_data) {
                $id_mesa = $_POST['id_mesa_oc'];
                $estado = $_POST['estado'];

                $result = $this->pedido->guardar_cambio($estado,$id_mesa);
            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function listar_familias_productos(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $listar_familias = $this->pedido->listar_familias();
            foreach ($listar_familias as $lf){
                $productos_familia = $this->pedido->listar_productos_x_familia($lf->id_producto_familia);
                $lf->familias=$productos_familia;
            }
            if($listar_familias){
                $result = 1;
                $message = "Datos encontrados";
            }else{
                $result = 2;
                $message = "Vacio como tu corazón";
            }

        }catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "datos"=>$listar_familias)));
    }


}