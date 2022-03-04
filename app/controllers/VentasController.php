<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'libs/PHPMailer/Exception.php';
require 'libs/PHPMailer/PHPMailer.php';
require 'libs/PHPMailer/SMTP.php';

require 'app/models/Archivo.php';
require 'app/models/Usuario.php';
require 'app/models/Rol.php';
require 'app/models/Ventas.php';
require 'app/models/GeneradorXML.php';
require 'app/models/ApiFacturacion.php';
require  'app/models/Nmletras.php';
require  'app/models/Pedido.php';
require  'app/models/Cliente.php';

class VentasController
{
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $archivo;
    private $usuario;
    private $rol;
    private $ventas;
    private $generadorXML;
    private $apiFacturacion;
    private $numLetra;
    private $pedido;
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

        $this->ventas = new Ventas();
        $this->generadorXML= new GeneradorXML();
        $this->apiFacturacion= new ApiFacturacion();
        $this->numLetra = new Nmletras();
        $this->pedido = new Pedido();
        $this->cliente = new Cliente();

    }

    //VISTA PARA REALIZAR VENTAS
    public function historial_ventas(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));

            $filtro = false;
            $fecha_ini = date('Y-m-d');
            $fecha_fin = date('Y-m-d');
            $ventas_cant = $this->ventas->listar_ventas_sin_enviar();

            if(isset($_POST['enviar_registro'])){
                $query = "SELECT * FROM ventas v inner join clientes c on v.id_cliente = c.id_cliente inner join monedas mo
                        on v.id_moneda = mo.id_moneda INNER JOIN usuarios u on v.id_usuario = u.id_usuario inner join mesas m 
                        on v.id_mesa = m.id_mesa inner join tipo_pago tp on v.id_tipo_pago = tp.id_tipo_pago 
                        where v.venta_estado_sunat = 0";
                $select = "";
                $where = true;
                if($_POST['tipo_venta']!=""){
                    $where = true;
                    $select = $select . " and v.venta_tipo = '" . $_POST['tipo_venta'] . "'";
                    $tipo_venta = $_POST['tipo_venta'];
                }

                if($_POST['fecha_inicio'] != "" AND $_POST['fecha_final'] != ""){
                    $where = true;
                    $select = $select . " and DATE(v.venta_fecha) between '" . $_POST['fecha_inicio'] ."' and '" . $_POST['fecha_final'] ."'";
                    $fecha_ini = $_POST['fecha_inicio'];
                    $fecha_fin = $_POST['fecha_final'];
                }

                if($where){
                    $datos = true;
                    $order = " order by v.venta_fecha asc";
                    $query = $query . $select . $order;
                    $ventas = $this->ventas->listar_ventas($query);
                }

                /*if($_POST['tipo_venta']!="" && $_POST['estado_cpe']!=""){
                    $ventas = $this->ventas->listar_ventas_filtro_todo($_POST['tipo_venta'],$_POST['estado_cpe'],$_POST['fecha_inicio'], $_POST['fecha_final']);
                    $tipo_venta = $_POST['tipo_venta'];
                    $estado_cpe = $_POST['estado_cpe'];
                }elseif($_POST['tipo_venta']!=""){
                    $ventas = $this->ventas->listar_ventas_filtro_tipo($_POST['tipo_venta'],$_POST['fecha_inicio'], $_POST['fecha_final']);
                    $tipo_venta = $_POST['tipo_venta'];
                }elseif($_POST['estado_cpe']!=""){
                    $ventas = $this->ventas->listar_ventas_filtro_estado($_POST['estado_cpe'],$_POST['fecha_inicio'], $_POST['fecha_final']);
                    $tipo_venta = $_POST['tipo_venta'];
                    $estado_cpe = $_POST['estado_cpe'];
                }else{
                    $ventas = $this->ventas->listar_ventas_filtro_fecha($_POST['fecha_inicio'], $_POST['fecha_final']);
                }*/
                $fecha_ini = $_POST['fecha_inicio'];
                $fecha_fin = $_POST['fecha_final'];
                $filtro = true;
            }

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ventas/historial_ventas.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    public function historial_ventas_enviadas(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));

            $filtro = false;
            $fecha_ini = date('Y-m-d');
            $fecha_fin = date('Y-m-d');
            if(isset($_POST['enviar_registro'])){
                $query = "SELECT * FROM ventas v inner join clientes c on v.id_cliente = c.id_cliente inner join monedas mo
                        on v.id_moneda = mo.id_moneda INNER JOIN usuarios u on v.id_usuario = u.id_usuario inner join mesas m 
                        on v.id_mesa = m.id_mesa inner join tipo_pago tp on v.id_tipo_pago = tp.id_tipo_pago 
                        where v.venta_estado_sunat = 1";
                $select = "";
                $where = true;
                if($_POST['tipo_venta']!=""){
                    $where = true;
                    $select = $select . " and v.venta_tipo = '" . $_POST['tipo_venta'] . "'";
                    $tipo_venta = $_POST['tipo_venta'];
                }

                if($_POST['fecha_inicio'] != "" AND $_POST['fecha_final'] != ""){
                    $where = true;
                    $select = $select . " and DATE(v.venta_fecha) between '" . $_POST['fecha_inicio'] ."' and '" . $_POST['fecha_final'] ."'";
                    $fecha_ini = $_POST['fecha_inicio'];
                    $fecha_fin = $_POST['fecha_final'];
                }

                if($where){
                    $datos = true;
                    $order = " order by v.venta_fecha asc";
                    $query = $query . $select . $order;
                    $ventas = $this->ventas->listar_ventas($query);
                }

                /*if($_POST['tipo_venta']!="" && $_POST['estado_cpe']!=""){
                    $ventas = $this->ventas->listar_ventas_filtro_todo($_POST['tipo_venta'],$_POST['estado_cpe'],$_POST['fecha_inicio'], $_POST['fecha_final']);
                    $tipo_venta = $_POST['tipo_venta'];
                    $estado_cpe = $_POST['estado_cpe'];
                }elseif($_POST['tipo_venta']!=""){
                    $ventas = $this->ventas->listar_ventas_filtro_tipo($_POST['tipo_venta'],$_POST['fecha_inicio'], $_POST['fecha_final']);
                    $tipo_venta = $_POST['tipo_venta'];
                }elseif($_POST['estado_cpe']!=""){
                    $ventas = $this->ventas->listar_ventas_filtro_estado($_POST['estado_cpe'],$_POST['fecha_inicio'], $_POST['fecha_final']);
                    $tipo_venta = $_POST['tipo_venta'];
                    $estado_cpe = $_POST['estado_cpe'];
                }else{
                    $ventas = $this->ventas->listar_ventas_filtro_fecha($_POST['fecha_inicio'], $_POST['fecha_final']);
                }*/
                $fecha_ini = $_POST['fecha_inicio'];
                $fecha_fin = $_POST['fecha_final'];
                $filtro = true;
            }

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ventas/historial_ventas_enviadas.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    public function historial_notas_ventas(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));

            $filtro = false;
            $fecha_ini = date('Y-m-d');
            $fecha_fin = date('Y-m-d');
            if(isset($_POST['enviar_registro'])){
                if($_POST['fecha_inicio'] != "" AND $_POST['fecha_final'] != ""){
                    $ventas = $this->ventas->listar_notas_ventas_x_fecha($_POST['fecha_inicio'], $_POST['fecha_final']);
                    $fecha_ini = $_POST['fecha_inicio'];
                    $fecha_fin = $_POST['fecha_final'];
                }else{
                    $ventas = $this->ventas->listar_notas_ventas();
                }
                $filtro = true;
            }

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ventas/historial_notas_ventas.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    public function historial_resumen_diario(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));

            $filtro = false;
            $fecha_ini = date('Y-m-d');
            $fecha_fin = date('Y-m-d');
            if(isset($_POST['enviar_registro'])){

                $resumen = $this->ventas->listar_resumen_diario_fecha($_POST['fecha_inicio'], $_POST['fecha_final']);

                $fecha_ini = $_POST['fecha_inicio'];
                $fecha_fin = $_POST['fecha_final'];
                $filtro = true;
            }

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ventas/historial_resumen_diario.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    public function historial_bajas_facturas(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));

            $filtro = false;
            $fecha_ini = date('Y-m-d');
            $fecha_fin = date('Y-m-d');
            if(isset($_POST['enviar_registro'])){

                $bajas = $this->ventas->listar_comunicacion_baja_fecha($_POST['fecha_inicio'], $_POST['fecha_final']);

                $fecha_ini = $_POST['fecha_inicio'];
                $fecha_fin = $_POST['fecha_final'];
                $filtro = true;
            }

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ventas/historial_bajas_facturas.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    public function generar_nota(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $id = $_GET['id'] ?? 0;
            if($id == 0){
                throw new Exception('ID Sin Declarar');
            }
            $venta = $this->ventas->listar_venta_x_id($id);
            $detalle_venta = $this->ventas->listar_venta_detalle_x_id_venta($id);
            $tipo_pago = $this->pedido->listar_tipo_pago();
            $productos = $this->ventas->listar_productos_();
            $cliente = $this->cliente->listar_cliente();

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ventas/generar_nota.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    public function tipo_nota_descripcion(){
        try{
            //$id_producto = $_POST['id_producto'];
            //$result = $this->pedido->listar_precio_producto($id_producto);
            $tipo_comprobante = $_POST['tipo_comprobante'];
            if($tipo_comprobante != ""){
                if($tipo_comprobante == "07"){
                    $dato_nota = $this->ventas->listar_descripcion_segun_nota_credito();
                    $nota = "Tipo Nota de Crédito";
                }else{
                    $dato_nota = $this->ventas->listar_descripcion_segun_nota_debito();
                    $nota = "Tipo Nota de Débito";
                }

                $nota_descripcion = "<label>".$nota."</label>";
                $nota_descripcion .= "<select class='form-control' id='notatipo_descrpcion'>";
                foreach ($dato_nota as $dn){
                    $nota_descripcion.= "<option value='".$dn->codigo."'>".$dn->tipo_nota_descripcion."</option>";
                }
                $nota_descripcion .= "</select>";
            }

        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode($nota_descripcion);
    }
    public function envio_resumenes_diario(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));

            $filtro = false;
            $fecha_ini = date('Y-m-d');
            $fecha_fin = '';
            if(isset($_POST['enviar_registro'])){
                $query = "SELECT * FROM ventas v inner join clientes c on v.id_cliente = c.id_cliente inner join monedas mo
                        on v.id_moneda = mo.id_moneda INNER JOIN usuarios u on v.id_usuario = u.id_usuario inner join mesas m 
                        on v.id_mesa = m.id_mesa inner join tipo_pago tp on v.id_tipo_pago = tp.id_tipo_pago 
                        where v.venta_estado_sunat = 0 and v.venta_tipo <> '01' and v.venta_tipo <> '20' and v.tipo_documento_modificar <> '01'
                        and v.venta_tipo_envio <> 1";
                $select = "";
                $where = true; $tipo_venta = $_POST['tipo_venta'];

                if($_POST['fecha_inicio'] != "" ){
                    $where = true;
                    $select = $select . " and DATE(v.venta_fecha) = '" . $_POST['fecha_inicio'] ."'";
                    $fecha_ini = $_POST['fecha_inicio'];
                    //$fecha_fin = $_POST['fecha_final'];
                }

                if($where){
                    $datos = true;
                    $order = " order by v.venta_fecha asc";
                    $query = $query . $select . $order;
                    $ventas = $this->ventas->listar_ventas($query);
                }

                /*if($_POST['tipo_venta']!="" && $_POST['estado_cpe']!=""){
                    $ventas = $this->ventas->listar_ventas_filtro_todo($_POST['tipo_venta'],$_POST['estado_cpe'],$_POST['fecha_inicio'], $_POST['fecha_final']);
                    $tipo_venta = $_POST['tipo_venta'];
                    $estado_cpe = $_POST['estado_cpe'];
                }elseif($_POST['tipo_venta']!=""){
                    $ventas = $this->ventas->listar_ventas_filtro_tipo($_POST['tipo_venta'],$_POST['fecha_inicio'], $_POST['fecha_final']);
                    $tipo_venta = $_POST['tipo_venta'];
                }elseif($_POST['estado_cpe']!=""){
                    $ventas = $this->ventas->listar_ventas_filtro_estado($_POST['estado_cpe'],$_POST['fecha_inicio'], $_POST['fecha_final']);
                    $tipo_venta = $_POST['tipo_venta'];
                    $estado_cpe = $_POST['estado_cpe'];
                }else{
                    $ventas = $this->ventas->listar_ventas_filtro_fecha($_POST['fecha_inicio'], $_POST['fecha_final']);
                }*/
                $filtro = true;
            }

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ventas/envio_resumen_diario.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function editar_nota_venta(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $id = $_GET['id'] ?? 0;
            if($id == 0){
                throw new Exception('ID Sin Declarar');
            }

            $venta = $this->ventas->listar_venta_x_id($id);
            $detalle_venta = $this->ventas->listar_venta_detalle_x_id_venta($id);
            $tipo_pago = $this->pedido->listar_tipo_pago();
            $productos = $this->ventas->listar_productos_();
            $clientes = $this->cliente->listar_cliente();
            $tipos_documento = $this->cliente->listar_tipos_documentos();
            $cuotas = "";
            if($venta->id_tipo_pago == 5){
                $cuotas = $this->ventas->listar_cuotas_x_venta($id);
            }

            $_SESSION['productos'] = array();
            foreach ($detalle_venta as $de) {
                array_push($_SESSION['productos'], [$de->id_producto_precio, $de->venta_detalle_nombre_producto, $de->id_unidad_medida, round($de->venta_detalle_valor_unitario, 2), $de->venta_detalle_cantidad, $de->producto_precio_codigoafectacion, $de->venta_detalle_descuento, $de->id_comanda_detalle]);
            }
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ventas/editar_nota_venta.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    public function tabla_productos_editar(){
        try{
            require _VIEW_PATH_ . 'ventas/tabla_productos_editar.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<br><br><div style='text-align: center'><h3>Ocurrió Un Error Al Cargar La Informacion</h3></div>";
        }
    }
    public function search_by_barcode(){
        try{
            if(isset($_POST['product_barcode'])){
                $product = $this->ventas->search_by_barcode($_POST['product_barcode']);
                $result = $product;
                if(empty($result)){
                    $result = 2;
                } else {
                    $stock = $this->ventas->listar_recurso_sede_x_producto($result->id_producto);
                    $result = $result->producto_nombre . '|' . $result->id_medida . '|' . $stock->recurso_sede_stock . '|' . $result->id_producto_precio . '|' . $result->producto_precio_venta . '|' . $result->producto_precio_venta . '|' . $result->medida_codigo_unidad . '|' . $result->producto_precio_codigoafectacion;
                }
            } else {
                $result = 2;
            }
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        echo $result;
    }
    public function addproduct(){
        try{
            if(isset($_POST['codigo']) && isset($_POST['producto']) && isset($_POST['unids']) && isset($_POST['precio']) && isset($_POST['cantidad']) && isset($_POST['tipo_igv'])){
                $repeat = false;
                foreach($_SESSION['productos'] as $p){
                    if($_POST['codigo'] == $p[0]){
                        $repeat = true;
                    }
                }
                if(!$repeat){
                    array_push($_SESSION['productos'], [$_POST['codigo'], $_POST['producto'], $_POST['unids'], round($_POST['precio'], 2), $_POST['cantidad'], $_POST['tipo_igv'], $_POST['product_descuento'], '0']);
                    $result = 1;
                } else {
                    $result = 3;
                }
            } else {
                $result = 2;
            }
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        echo $result;
    }
    public function editar_cantidad_tabla(){
        try{
            if(isset($_POST['id'])){
                $buscar = $_POST['id'];
                $valor_nueva_cantidad = $_POST['valor_nueva_cantidad'];
                $editar = count($_SESSION['productos']);
                for($i=0; $i < $editar; $i++){
                    if($_SESSION['productos'][$i][0] == $buscar){
                        $_SESSION['productos'][$i][4] = $valor_nueva_cantidad;
                    }
                }
                $_SESSION['productos'] = array_values($_SESSION['productos']);
                $result = 1;
            }

        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        echo json_encode($result);
    }
    public function ver_detalle_venta(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $id = $_GET['id'] ?? 0;
            if($id == 0){
                throw new Exception('ID Sin Declarar');
            }
            $venta = $this->ventas->listar_venta_x_id($id);
            $detalle_venta = $this->ventas->listar_venta_detalle_x_id_venta($id);
            if($venta->venta_tipo == "07" || $venta->venta_tipo == "08"){
                $detalle_venta = $this->ventas->listar_venta_detalle_x_id_venta_venta($id);
            }


            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ventas/ver_detalle_venta.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    public function ver_detalle_resumen(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $id = $_GET['id'] ?? 0;
            if($id == 0){
                throw new Exception('ID Sin Declarar');
            }
            $resumen = $this->ventas->listar_resumen_diario_x_id($id);
            $detalle_resumen = $this->ventas->listar_resumen_diario_detalle_x_id($id);


            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ventas/ver_detalle_resumen.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function crear_xml_enviar_sunat(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_comanda_detalle', 'POST',true,$ok_data,11,'texto',0);

            //Validacion de datos
            if($ok_data) {
                $id_venta = $_POST['id_venta'];
                $venta = $this->ventas->listar_soloventa_x_id($id_venta);
                $detalle_venta = $this->ventas->listar_venta_detalle_x_id_venta($id_venta);
                $empresa = $this->ventas->listar_empresa_x_id_empresa($venta->id_empresa);
                $cliente = $this->ventas->listar_clienteventa_x_id($venta->id_cliente);
                //$producto = $this->ventas->listar_producto_x_id($detalle_venta->id_producto);
                //ASIGAMOS NOMBRE AL ARCHIVO XML
                $nombre = $empresa->empresa_ruc.'-'.$venta->venta_tipo.'-'.$venta->venta_serie.'-'.$venta->venta_correlativo;
                $ruta = "libs/ApiFacturacion/xml/";
                //validamos el tipo de comprobante para crear su archivo XML
                if($venta->venta_tipo == '01' || $venta->venta_tipo == '03'){
                    $this->generadorXML->CrearXMLFactura($ruta.$nombre, $empresa, $cliente, $venta, $detalle_venta);
                }else{
                    $detalle_venta = $this->ventas->listar_venta_detalle_x_id_venta_venta($id_venta);
                    if ($venta->venta_tipo == '07'){

                        $descripcion_nota = $this->ventas->listar_tipo_notaC_x_codigo($venta->venta_codigo_motivo_nota);
                        $this->generadorXML->CrearXMLNotaCredito($ruta.$nombre, $empresa, $cliente, $venta, $detalle_venta,$descripcion_nota);
                    }else{
                        $descripcion_nota = $this->ventas->listar_tipo_notaD_x_codigo($venta->venta_codigo_motivo_nota);
                        $this->generadorXML->CrearXMLNotaDebito($ruta.$nombre, $empresa, $cliente, $venta, $detalle_venta,$descripcion_nota);
                    }
                }
                //SE PROCEDE A FIRMAR EL XML CREADO
                $result = $this->apiFacturacion->EnviarComprobanteElectronico($empresa,$nombre,"libs/ApiFacturacion/","libs/ApiFacturacion/xml/","libs/ApiFacturacion/cdr/", $id_venta);
                //FIN FACTURACION ELECTRONICA
                if($result == 1){
                    $result = $this->ventas->guardar_estado_de_envio_venta($id_venta, '1', '1');
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

    public function crear_enviar_resumen_sunat(){
        //Código de error general
        $result = 1;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            //$ok_data = $this->validar->validar_parametro('id_comanda_detalle', 'POST',true,$ok_data,11,'texto',0);

            //Validacion de datos
            if($ok_data) {
                $fecha = $_POST['fecha'];
                $ventas = $this->ventas->listar_venta_x_fecha($fecha, '01');
                //CONTROLAMOS VARIOS ENVIOS EL MISMO DIAS
                $serie = date('Ymd');
                $fila_serie = $this->ventas->listar_serie_resumen('RC');

                //$correlativo = 1;
                if($fila_serie->serie != $serie){
                    //$result = $this->ventas->actualizar_serie_resumen('RC', $serie);
                    $correlativo = 1;
                }else{
                    $correlativo = $fila_serie->correlativo + 1;
                }

                if($result == 1){
                    //$result = $this->ventas->actualizar_correlativo_resumen('RC', $correlativo);
                    if($result == 1){
                        $cabecera = array(
                            "tipocomp"		=>"RC",
                            "serie"			=>$serie,
                            "correlativo"	=>$correlativo,
                            "fecha_emision" =>date('Y-m-d'),
                            "fecha_envio"	=>date('Y-m-d')
                        );
                        //$cabecera = $this->ventas->listar_serie_resumen('RC');
                        $items = $ventas;
                        $ruta = "libs/ApiFacturacion/xml/";
                        $emisor = $this->ventas->listar_empresa_x_id_empresa('1');
                        $nombrexml = $emisor->empresa_ruc.'-'.$cabecera['tipocomp'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'];

                        //CREAMOS EL XML DEL RESUMEN
                        $this->generadorXML->CrearXMLResumenDocumentos($emisor, $cabecera, $items, $ruta.$nombrexml, $fecha);

                        $result = $this->apiFacturacion->EnviarResumenComprobantes($emisor,$nombrexml,"libs/ApiFacturacion/","libs/ApiFacturacion/xml/");
                        $ticket = $result['ticket'];
                        if($result['result'] == 1){
                            $ruta_xml = $ruta.$nombrexml.'.XML';
                            $guardar_resumen =$this->ventas->guardar_resumen_diario($fecha,$cabecera['serie'],$cabecera['correlativo'],$ruta_xml,'1',$result['mensaje'],$result['ticket']);
                            if($guardar_resumen == 1){
                                if($fila_serie->serie != $serie){
                                    $this->ventas->actualizar_serie_resumen('RC', $serie);
                                    //$correlativo = 1;
                                }
                                //$this->ventas->actualizar_serie_resumen('RC', $serie);
                                $this->ventas->actualizar_correlativo_resumen('RC', $correlativo);
                                $id_resumen = $this->ventas->listar_envio_resumen_x_ticket($result['ticket']);
                                foreach ($items as $i) {
                                    $guardar_resumen_detalle = $this->ventas->guardar_resumen_diario_detalle($id_resumen->id_envio_resumen,$i->id_venta);

                                    if ($guardar_resumen_detalle == 1){
                                        if($i->anulado_sunat == "1" && $i->venta_condicion_resumen == "1"){
                                            $result = $this->ventas->guardar_estado_de_envio_venta($i->id_venta, '2', '0');
                                            $this->ventas->editar_venta_condicion_resumen_anulado_x_venta($i->id_venta, '3');
                                        }else{
                                            $result = $this->ventas->guardar_estado_de_envio_venta($i->id_venta, '2', '1');
                                        }
                                    }
                                }
                                if($result == 1){
                                    $result = $this->apiFacturacion->ConsultarTicket($emisor, $cabecera, $ticket,"libs/ApiFacturacion/cdr/", 1);
                                }

                            }
                        }elseif($result['result'] == 4){
                            $result = 4;
                            $message = $result['mensaje'];
                        }elseif($result['result'] == 3){
                            $result = 3;
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

//FUNCION PARA GUARDAR VENTA
    public function consultar_ticket_resumen(){
        //Código de error general
        $result = 1;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            //$ok_data = $this->validar->validar_parametro('id_comanda_detalle', 'POST',true,$ok_data,11,'texto',0);

            //Validacion de datos
            if($ok_data) {
                $id_resumen = $_POST['id_resumen_diario'];
                $resumen_diario = $this->ventas->listar_resumen_diario_x_id($id_resumen);
                $serie = $resumen_diario->envio_resumen_serie;
                $correlativo = $resumen_diario->envio_resumen_correlativo;
                $ticket = $resumen_diario->envio_resumen_ticket;

                if(!empty($resumen_diario)){
                    //$result = $this->ventas->actualizar_correlativo_resumen('RC', $correlativo);
                    if($result == 1){
                        $cabecera = array(
                            "tipocomp"		=>"RC",
                            "serie"			=>$serie,
                            "correlativo"	=>$correlativo,
                            "fecha_emision" =>date('Y-m-d'),
                            "fecha_envio"	=>date('Y-m-d')
                        );
                        //$cabecera = $this->ventas->listar_serie_resumen('RC');

                        $ruta = "libs/ApiFacturacion/xml/";
                        $emisor = $this->ventas->listar_empresa_x_id_empresa('1');
                        $nombrexml = $emisor->empresa_ruc.'-'.$cabecera['tipocomp'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'];

                        $result = $this->apiFacturacion->ConsultarTicket($emisor, $cabecera, $ticket,"libs/ApiFacturacion/cdr/", 1);

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
    public function guardar_nota(){
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
                $id_venta_ = $_POST['id_venta'];
                $dato_venta = $this->ventas->listar_venta_x_id($id_venta_);


                $tipo_pago = $_POST['id_tipo_pago'];
                $id_mesa = $_POST['id_mesa'];

                $fecha = date('Y-m-d H:i:s');
                $model->id_usuario = $id_usuario;
                $model->id_mesa = $id_mesa;
                $model->id_cliente = $_POST['id_cliente'];
                $model->id_tipo_pago = $tipo_pago;
                $model->id_moneda = $_POST['tipo_moneda'];
                $model->venta_tipo_envio= $dato_venta->venta_tipo_envio;

                $model->venta_tipo = $_POST['tipo_venta'];
                //obtener serie con el id
                $serie_ = $this->pedido->listar_correlativos_x_serie($_POST['serie']);
                $model->venta_serie = $serie_->serie;
                $model->venta_correlativo = $_POST['correlativo'];


                //AL HACER LA VENTA AUTOMATICAMENTE SE LLENA EL CORRELATIVO DE LA VENTA
                $model->venta_totalgratuita = $_POST['op_gratuitas_'];
                $model->venta_totalexonerada = $_POST['op_exoneradas_'];
                $model->venta_totalinafecta = $_POST['op_inafectas_'];
                $model->venta_totalgravada = $_POST['op_gravadas_'];
                $model->venta_totaligv = $_POST['igv_'];
                $model->venta_icbper = $_POST['icbper_'];
                $model->venta_fecha = $fecha;
                $model->venta_total = $_POST['venta_total'];

                $model->venta_observacion = $_POST['pago_observacion'];
                $model->tipo_documento_modificar = $_POST['documento_mod'];
                $model->serie_modificar = $_POST['serie_modificar'];
                $model->correlativo_modificar = $_POST['numero_modificar'];
                $model->notatipo_descripcion = $_POST['notatipo_descripcion'];

                $model->pago_cliente = 0;
                $model->vuelto_ = 0;
                $guardar_venta = $this->ventas->guardar_nota($model);

                if($guardar_venta == 1){
                    $model = new Pedido();
                    $id_cliente = $_POST['id_cliente'];
                    $jalar_id_venta = $this->pedido->jalar_id_venta($fecha,$id_cliente);
                    $id_venta = $jalar_id_venta->id_venta;

                    $datos_detalle_pedido = $_POST['contenido'];
                    if(count_chars($datos_detalle_pedido)>0){
                        $fila = explode('/./.', $datos_detalle_pedido);

                        if(count($fila)>0){
                            $igv_porcentaje = 0.18;
                            for ($i=0;$i<count($fila)-1;$i++){
                                $celdas=explode('-.-.',$fila[$i]);
                                $model->id_venta = $id_venta;
                                $id_comanda_detalle = 0;
                                $id_producto_precio =$celdas[0];

                                //$jalar_datos = $this->pedido->jalar_datos($id_comanda_detalle);
                                $cantidad = $celdas[3];
                                $precio_unitario = $celdas[2];
                                $codigo_afectacion = $celdas[5];
                                $igv_detalle = 0;
                                $factor_porcentaje = 1;
                                if($codigo_afectacion == 10){
                                    $igv_detalle = $precio_unitario * $cantidad * $igv_porcentaje;
                                    $factor_porcentaje = 1 + $igv_porcentaje;
                                }

                                $model->id_comanda_detalle = $id_comanda_detalle;
                                $model->id_producto_precio = $id_producto_precio;
                                $model->venta_detalle_valor_unitario = $precio_unitario;
                                $model->venta_detalle_precio_unitario = $precio_unitario * $factor_porcentaje;
                                $model->venta_detalle_nombre_producto = $celdas[1];
                                $model->venta_detalle_cantidad = $cantidad;
                                //$model->venta_total_selled = 1;
                                $model->venta_detalle_total_igv = $igv_detalle;
                                $model->venta_detalle_porcentaje_igv = $igv_porcentaje * 100;
                                //$model->id_igv = 1;
                                $model->venta_detalle_total_icbper = 0.00;
                                $model->venta_detalle_valor_total = $precio_unitario * $cantidad;
                                $model->venta_detalle_total_price = $precio_unitario * $cantidad * $factor_porcentaje;

                                $result = $this->pedido->guardar_venta_detalle($model);
                                //$this->pedido->cambiar_estado_comanda($id_comanda_detalle);
                                //$pago = 0;
                                /*$id_comanda = $jalar_datos->id_comanda;
                                $verificar = $this->pedido->verificar_pago($id_comanda);*/
                            }
                        }
                        if($result==1){
                            $result = $this->pedido->actualizarCorrelativo_x_id_Serie($_POST['serie'],$_POST['correlativo']);
                            //ANULAR COMPROBANTE SI SE HACE NOTA DE CREDITO tipo 01 o 02
                            if($_POST['tipo_venta'] == "07" && ($_POST['notatipo_descripcion'] == "01" || $_POST['notatipo_descripcion'] == "02")){
                                $this->ventas->anular_comprobante_relacionado($_POST['serie_modificar'],$_POST['numero_modificar']);
                            }

                            //INICIO - LISTAR COLUMNAS PARA TICKET DE VENTA
                            include('libs/ApiFacturacion/phpqrcode/qrlib.php');

                            $venta = $this->ventas->listar_venta_x_id($id_venta);
                            $detalle_venta =$this->ventas->listar_venta_detalle_x_id_venta($id_venta);
                            $empresa = $this->ventas->listar_empresa_x_id_empresa($venta->id_empresa);
                            $cliente = $this->ventas->listar_clienteventa_x_id($venta->id_cliente);
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
                            }elseif($venta->venta_tipo == "07"){
                                $venta_tipo = "NOTA DE CRÉDITO ELECTRÓNICO";
                                $motivo = $this->ventas->listar_tipo_notaC_x_codigo($venta->venta_codigo_motivo_nota);

                            }elseif($venta->venta_tipo == "08"){
                                $venta_tipo = "NOTA DE DÉBITO ELECTRÓNICO";
                                $motivo = $this->ventas->listar_tipo_notaD_x_codigo($venta->venta_codigo_motivo_nota);
                            }
                            if($cliente->id_tipodocumento == "4"){
                                $cliente_nombre = $cliente->cliente_razonsocial;
                            }else{
                                $cliente_nombre = $cliente->cliente_nombre. ' ' .$cliente->cliente_apellido_paterno. ' ' .$cliente->cliente_apellido_materno;
                            }

                            require _VIEW_PATH_ . 'pedido/ticket_venta.php';

                        }

                    }
                    //$this->pedido->cambiar_estado_comanda_principal($id_comanda);
                }else{
                    $result = 2;
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

    public function imprimir_ticket_pdf(){
        try{
            //include('libreria/phpqrcode/qrlib.php');
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'], _FULL_KEY_));
            $id = $_GET['id'] ?? 0;
            if ($id == 0) {
                throw new Exception('ID Sin Declarar');
            }
            $dato_venta = $this->ventas->listar_venta_x_id_pdf($id);
            $detalle_venta = $this->ventas->listar_venta_detalle_x_id_venta_pdf($id);
            $fecha_hoy = date('d-m-Y H:i:s');

            //codigo QR
            //$tiempo_fecha = explode(" ", $dato_venta->pago_fecha_emitida);
            //$ruta = _SERVER_ .'media/codigo_qr/'.$dato_pago->pago_seriecorrelativo.'-'.$tiempo_fecha[0].'.png';
            $ruta_qr = "libs/ApiFacturacion/imagenqr/$dato_venta->empresa_ruc-$dato_venta->venta_tipo-$dato_venta->venta_serie-$dato_venta->venta_correlativo.png";

            if (!file_exists($ruta_qr)) {
                include('libs/ApiFacturacion/phpqrcode/qrlib.php');
                $nombre_qr = $dato_venta->empresa_ruc. '-' .$dato_venta->venta_tipo. '-' .$dato_venta->venta_serie. '-' .$dato_venta->venta_correlativo;
                $contenido_qr = $dato_venta->empresa_ruc.'|'.$dato_venta->venta_tipo.'|'.$dato_venta->venta_serie.'|'.$dato_venta->venta_correlativo. '|'.
                    $dato_venta->venta_totaligv.'|'.$dato_venta->venta_total.'|'.date('Y-m-d', strtotime($dato_venta->venta_fecha)).'|'.
                    $dato_venta->tipodocumento_codigo.'|'.$dato_venta->cliente_numero;
                $ruta = 'libs/ApiFacturacion/imagenqr/';
                $ruta_qr = $ruta.$nombre_qr.'.png';
                QRcode::png($contenido_qr, $ruta_qr, 'H - mejor', '3');
            }

            if ($dato_venta->venta_tipo == "03") {
                $tipo_comprobante = "BOLETA DE VENTA ELECTRONICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $documento = "DNI:                        $dato_venta->cliente_numero";
            } else if ($dato_venta->venta_tipo == "01") {
                $tipo_comprobante = "FACTURA DE VENTA ELECTRONICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $documento = "RUC:                      $dato_venta->cliente_numero";
            } else if ($dato_venta->venta_tipo == "07") {
                $tipo_comprobante = "NOTA DE CRÉDITO DE VENTA ELECTRONICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $documento = "DOCUMENTO: $dato_venta->cliente_numero";
            } else if($dato_venta->venta_tipo == "08") {
                $tipo_comprobante = "NOTA DE DÉBITO DE VENTA ELECTRONICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $documento = "DOCUMENTO: $dato_venta->cliente_numero";
            }else if($dato_venta->venta_tipo == "20") {
                $tipo_comprobante = "NOTA DE VENTA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $documento = "DOCUMENTO: $dato_venta->cliente_numero";

            }
            //$fecha_comprobante = $tiempo_fecha[0];
            //$hora_comprobante = $tiempo_fecha[1];
            $importe_letra = $this->numLetra->num2letras(intval($dato_venta->venta_total));
            $arrayImporte = explode(".", $dato_venta->venta_total);
            $montoLetras = $importe_letra . ' con ' . $arrayImporte[1] . '/100 ' . $dato_venta->moneda;
            //$qrcode = $dato_venta->pago_seriecorrelativo . '-' . $tiempo_fecha[0] . '.png';
            $dato_impresion = 'DATOS DE IMPRESIÓN:';
            require _VIEW_PATH_ . 'ventas/imprimir_ticket_pdf.php';
        } catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
    }


    public function comunicacion_baja(){
        //Código de error general
        $result = 1;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            //$ok_data = $this->validar->validar_parametro('id_comanda_detalle', 'POST',true,$ok_data,11,'texto',0);

            //Validacion de datos
            if($ok_data) {
                $id_venta = $_POST['id_venta'];

                //$fecha = $_POST['fecha'];
                //$ventas = $this->ventas->listar_venta_x_fecha($fecha, '03');
                //CONTROLAMOS VARIOS ENVIOS EL MISMO DIAS
                $serie = date('Ymd');
                $fila_serie = $this->ventas->listar_serie_resumen('RA');
                $venta = $this->ventas->listar_venta_x_id($id_venta);

                //$correlativo = 1;
                if($fila_serie->serie != $serie){
                    //$result = $this->ventas->actualizar_serie_resumen('RA', $serie);
                    $correlativo = 1;
                }else{
                    $correlativo = $fila_serie->correlativo + 1;
                }

                if($result == 1){
                    //$result = $this->ventas->actualizar_correlativo_resumen('RA', $correlativo);
                    if($result == 1){
                        $cabecera = array(
                            "tipocomp"		=>"RA",
                            "serie"			=>$serie,
                            "correlativo"	=>$correlativo,
                            "fecha_emision" =>date('Y-m-d'),
                            "fecha_envio"	=>date('Y-m-d')
                        );
                        //$cabecera = $this->ventas->listar_serie_resumen('RA');
                        $items = $venta;
                        $ruta = "libs/ApiFacturacion/xml/";
                        $emisor = $this->ventas->listar_empresa_x_id_empresa('1');
                        $nombrexml = $emisor->empresa_ruc.'-'.$cabecera['tipocomp'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'];

                        //CREAMOS EL XML DEL RESUMEN
                        $this->generadorXML->CrearXmlBajaDocumentos($emisor, $cabecera, $items, $ruta.$nombrexml);

                        $result = $this->apiFacturacion->EnviarResumenComprobantes($emisor,$nombrexml,"libs/ApiFacturacion/","libs/ApiFacturacion/xml/");
                        $ticket = $result['ticket'];
                        if($result['result'] == 1){
                            $id_user = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                            $ruta_xml = $ruta.$nombrexml.'.XML';
                            $guardar_anulacion =$this->ventas->guardar_venta_anulacion(date('Y-m-d', strtotime($venta->venta_fecha)),$cabecera['serie'],$cabecera['correlativo'],$ruta_xml,$result['mensaje'],$id_venta,$id_user,$result['ticket']);
                            if($guardar_anulacion == 1){
                                if($fila_serie->serie != $serie){
                                    $result = $this->ventas->actualizar_serie_resumen('RA', $serie);
                                }
                                $this->ventas->actualizar_correlativo_resumen('RA', $correlativo);
                                $result = $this->ventas->editar_estado_venta_anulado($id_venta);
                                if($result == 1){
                                    $result = $this->apiFacturacion->ConsultarTicket($emisor, $cabecera, $ticket,"libs/ApiFacturacion/cdr/",2);
                                }

                            }
                        }elseif($result['result'] == 4){
                            $result = 4;
                            $message = $result['mensaje'];
                        }elseif($result['result'] == 3){
                            $result = 3;
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
    public function anular_boleta_cambiarestado(){
        //Código de error general
        $result = 1;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            //$ok_data = $this->validar->validar_parametro('id_comanda_detalle', 'POST',true,$ok_data,11,'texto',0);

            //Validacion de datos
            if($ok_data) {
                $id_venta = $_POST['id_venta'];
                $estado = $_POST['estado'];
                $result = $this->ventas->actualizar_venta_anulado($id_venta,$estado);


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

    public function excel_ventas_enviadas(){
        try{
            $usuario_nombre = $this->encriptar->desencriptar($_SESSION['p_n'],_FULL_KEY_);
            $usuario_apellido = $this->encriptar->desencriptar($_SESSION['p_p'],_FULL_KEY_);
            $usuario_materno = $this->encriptar->desencriptar($_SESSION['p_m'],_FULL_KEY_);
            $usuario = $usuario_nombre. ' ' .$usuario_apellido. ' ' .$usuario_materno;

            $tipo_venta = $_GET['tipo_venta'];
            $fecha_ini = $_GET['fecha_inicio'];
            $fecha_fin = $_GET['fecha_final'];

            if($fecha_ini != "" && $fecha_fin != ""){
                $fecha_vacio = "Desde el ".date('m-d-Y', strtotime($fecha_ini))." hasta el ".date('m-d-Y', strtotime($fecha_fin));
            }else{
                $fecha_vacio = utf8_decode("FECHA SIN LÍMITE");
            }

                $query = "SELECT * FROM ventas v inner join clientes c on v.id_cliente = c.id_cliente inner join monedas mo
                        on v.id_moneda = mo.id_moneda INNER JOIN usuarios u on v.id_usuario = u.id_usuario inner join mesas m 
                        on v.id_mesa = m.id_mesa inner join tipo_pago tp on v.id_tipo_pago = tp.id_tipo_pago 
                        where v.venta_estado_sunat = 1";
                $select = "";
                $where = true;
                if ($tipo_venta != "") {
                    $where = true;
                    $select = $select . " and v.venta_tipo = '" . $tipo_venta . "'";
                    $tipo_venta_a = $_GET['tipo_venta'];
                }

                if ($fecha_ini != "" and $fecha_fin != "") {
                    $where = true;
                    $select = $select . " and DATE(v.venta_fecha) between '" . $_GET['fecha_inicio'] . "' and '" . $_GET['fecha_final'] . "'";
                    $fecha_ini = $_GET['fecha_inicio'];
                    $fecha_fin = $_GET['fecha_final'];
                }

                if ($where) {
                    $datos = true;
                    $order = " order by v.venta_fecha asc";
                    $query = $query . $select . $order;
                    $ventas = $this->ventas->listar_ventas($query);
                }

                $fecha_ini = $_GET['fecha_inicio'];
                $fecha_fin = $_GET['fecha_final'];
                $filtro = true;

            if($tipo_venta_a == "03"){
                $tipo_comprobante = "BOLETA";
            }elseif ($tipo_venta_a == "01"){
                $tipo_comprobante = "FACTURA";
            }elseif($tipo_venta_a == "07"){
                $tipo_comprobante = "NOTA DE CRÉDITO";
            }elseif($tipo_venta_a == "08"){
                $tipo_comprobante = "NOTA DE DÉBITO";
            }else{
                $tipo_comprobante = "TODOS";
            }

            $fecha_hoy = date("d-m-y");
            $nombre_excel = 'historial_de_ventas_enviadas' . '_' . $fecha_hoy;

            //creamos el archivo excel
            header( "Content-Type: application/vnd.ms-excel;charset=utf-8");
            header("Content-Disposition: attachment; filename=".$nombre_excel.".xls");
            require _VIEW_PATH_ . 'ventas/excel_ventas_enviadas.php';
        } catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
//FUNCION PARA CONSULTAR SERIE
    public function consultar_serie(){
        try{
            $concepto = $_POST['concepto'];
            $series = "";
            $correlativo = "";
            if($concepto == "LISTAR_SERIE"){
                $tipo_documento_modificar = $_POST['tipo_documento_modificar'];
                if($tipo_documento_modificar == "01" && $_POST['tipo_venta'] == "07"){
                    $id_serie = 5;
                }elseif($tipo_documento_modificar == "03" && $_POST['tipo_venta'] == "07"){
                    $id_serie = 6;
                }elseif($tipo_documento_modificar == "01" && $_POST['tipo_venta'] == "08"){
                    $id_serie = 7;
                }elseif($tipo_documento_modificar == "03" && $_POST['tipo_venta'] == "08"){
                    $id_serie = 8;
                }
                $series = $this->pedido->listarSerie_NC_x_id($_POST['tipo_venta'], $id_serie);
                /*if($_POST['tipo_venta'] == "07"){
                    $series = $this->pedido->listarSerie_NC_factura($_POST['tipo_venta']);

                    if($tipo_documento_modificar == "01"){
                        $id =
                        $series = $this->pedido->listarSerie_NC_factura($_POST['tipo_venta']);
                    }else{
                        $series = $this->pedido->listarSerie($_POST['tipo_venta']);
                    }
                }else{

                }*/

                //$series = $this->pedido->listarSerie($_POST['tipo_venta']);
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
    public function consultar_comprobante(){
        try{
            $tipo_comprobate = $_POST['tipo_comprobate'];
            $serie = $_POST['comprobante_serie'];
            $correlativo = $_POST['comprobante_numero'];
            $emisor = $this->ventas->listar_empresa_x_id_empresa('1');

            $comprobante = array(
                'tipo_comprobante' => $tipo_comprobate,
                'serie'            => $serie,
                'correlativo'      => $correlativo
            );

            $result = $this->apiFacturacion->consultarComprobante($emisor, $comprobante);


        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
            $result = "error";
        }
        //Retornamos el json
        $respuesta = array("result" => $result);
        echo json_encode($respuesta);
    }

    public function enviar_venta_correo(){
        $result = 2;
        try{
            $modelo = new Ventas();
            $modelo->email = $_POST['email'];
            $modelo->archivo = $this->imprimir_ticket_pdf_local($_POST['id']);
            $modelo->titulo = 'Tu comprobante de Venta de Bar Simpson';
            $result = $this->enviar_comprobantes_facheritos($modelo);
            if($result == 1){
                unlink($modelo->archivo);
            }
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            //$message = $e->getMessage();
        }
        //Retornamos el json
        $respuesta = array("result" => $result);
        echo json_encode($respuesta);
    }

    function imprimir_ticket_pdf_local($id){
        $guardar_localmente = true;
        $ruta_guardado = "";
        try{
            //include('libreria/phpqrcode/qrlib.php');
            //$this->nav = new Navbar();
            //$navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'], _FULL_KEY_));
            if ($id == 0) {
                throw new Exception('ID Sin Declarar');
            }
            $dato_venta = $this->ventas->listar_venta_x_id_pdf($id);
            if($dato_venta->id_mesa != "-02"){
                $detalle_venta = $this->ventas->listar_venta_detalle_x_id_venta_pdf($id);
            }else{
                $detalle_venta = $this->ventas->listar_venta_detalle_x_id_venta_venta($id);
            }
            $fecha_hoy = date('d-m-Y H:i:s');

            //codigo QR
            $tiempo_fecha = explode(" ", $dato_venta->pago_fecha_emitida);
            //$ruta = _SERVER_ .'media/codigo_qr/'.$dato_pago->pago_seriecorrelativo.'-'.$tiempo_fecha[0].'.png';
            $ruta_qr = "libs/ApiFacturacion/imagenqr/$dato_venta->empresa_ruc-$dato_venta->venta_tipo-$dato_venta->venta_serie-$dato_venta->venta_correlativo.png";

            if (!file_exists($ruta_qr)) {
                include('libs/ApiFacturacion/phpqrcode/qrlib.php');
                $nombre_qr = $dato_venta->empresa_ruc. '-' .$dato_venta->venta_tipo. '-' .$dato_venta->venta_serie. '-' .$dato_venta->venta_correlativo;
                $contenido_qr = $dato_venta->empresa_ruc.'|'.$dato_venta->venta_tipo.'|'.$dato_venta->venta_serie.'|'.$dato_venta->venta_correlativo. '|'.
                    $dato_venta->venta_totaligv.'|'.$dato_venta->venta_total.'|'.date('Y-m-d', strtotime($dato_venta->venta_fecha)).'|'.
                    $dato_venta->tipodocumento_codigo.'|'.$dato_venta->cliente_numero;
                $ruta = 'libs/ApiFacturacion/imagenqr/';
                $ruta_qr = $ruta.$nombre_qr.'.png';
                QRcode::png($contenido_qr, $ruta_qr, 'H - mejor', '3');
            }

            if ($dato_venta->venta_tipo == "03") {
                $tipo_comprobante = "BOLETA DE VENTA ELECTRONICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $documento = "DNI:                        $dato_venta->cliente_numero";
            } else if ($dato_venta->venta_tipo == "01") {
                $tipo_comprobante = "FACTURA DE VENTA ELECTRONICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $documento = "RUC:                      $dato_venta->cliente_numero";
            } else if ($dato_venta->venta_tipo == "07") {
                $tipo_comprobante = "NOTA DE CRÉDITO DE VENTA ELECTRONICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $documento = "DOCUMENTO: $dato_venta->cliente_numero";
            } else if($dato_venta->venta_tipo == "08") {
                $tipo_comprobante = "NOTA DE DÉBITO DE VENTA ELECTRONICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $documento = "DOCUMENTO: $dato_venta->cliente_numero";
            }else if($dato_venta->venta_tipo == "20") {
                $tipo_comprobante = "NOTA DE VENTA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $documento = "DOCUMENTO: $dato_venta->cliente_numero";

            }
            //$fecha_comprobante = $tiempo_fecha[0];
            //$hora_comprobante = $tiempo_fecha[1];
            $importe_letra = $this->numLetra->num2letras(intval($dato_venta->venta_total));
            $arrayImporte = explode(".", $dato_venta->venta_total);
            $montoLetras = $importe_letra . ' con ' . $arrayImporte[1] . '/100 ' . $dato_venta->moneda;
            //$qrcode = $dato_venta->pago_seriecorrelativo . '-' . $tiempo_fecha[0] . '.png';
            $dato_impresion = 'DATOS DE IMPRESIÓN:';
            require _VIEW_PATH_ . 'ventas/imprimir_ticket_pdf.php';
        } catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
        }
        return $ruta_guardado;
    }

    function enviar_comprobantes_facheritos($modelo){
        $result = 2;

        //Codigo para enviar correo
        //Inicio de Correo
        $mail = new PHPMailer(true);
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'mail.guabba.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'notificaciones.bufeotec@guabba.com';                     //SMTP username
        $mail->Password   = 'HuevitoElCanrgy';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('notificaciones.bufeotec@guabba.com', 'SIMPSON RESTOBAR: Comprobante de Venta');
        //$mail->addAddress($_POST['correo']);     //Add a recipient
        //$this->log->insert('PHPMAILPRE: EMAIL DE ENVIO :' . strtolower($persona_impugnacion->user_email), date('d-m-Y H:i:s'));
        $mail->addAddress(strtolower($modelo->email));   //Add a recipient
        //$mail->addCC('test_bufeotec@brunner.com.pe');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        $mail->addAttachment($modelo->archivo);    //Optional name
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = utf8_decode($modelo->titulo);
        $correo_atendido = "";
        require 'app/view/ventas/correo_venta.php';
        $mail->Body    = utf8_decode($correo_atendido);
        if($mail->send()){
            $result = 1;
        }
        return $result;
    }

}