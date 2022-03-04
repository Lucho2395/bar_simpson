<?php
require 'app/models/Producto.php';
require 'app/models/Archivo.php';
require 'app/models/Usuario.php';
require 'app/models/Rol.php';
require 'app/models/Pedido.php';
require 'app/models/Recursos.php';
class ProductoController
{
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $archivo;
    private $usuario;
    private $rol;

    private $producto;
    private $pedido;
    private $recursos;

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
        $this->pedido = new Pedido();

        $this->producto = new Producto();
        $this->recursos = new Recursos();

    }

    public function gestionar(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));

            $familia = $this->producto->listar_familias();
            if(isset($_POST['enviar_dato'])){
                $id_producto_familia = $_POST['id_producto_familia'];
                $producto = $this->producto->listar_productos_familia($id_producto_familia);
                $familia_ = $this->producto->listar_familias_($id_producto_familia);
            }else{
                $producto = $this->producto->listar_productos();
            }

            $grupo = $this->producto->listar_grupos();
            $receta = $this->producto->listar_recetas();
            $tipo_afectacion = $this->pedido->listar_tipo_afectacion();
            $unidad_medida = $this->recursos->listar_unidad_medida();


            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'producto/gestionar.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }


    //FUNCUONES
    public function guardar_producto(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validacion de datos
            if($ok_data) {
                $model = new Producto();
                $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                $fecha = date('Y-m-d H:i:s');
                $microtime = microtime(true);
                $producto_nombre = $_POST['producto_nombre'];
                $model->producto_nombre = $producto_nombre;
                $model->producto_descripcion = $_POST['producto_descripcion'];
                $model->id_usuario = $id_usuario;
                $model->id_producto_familia = $_POST['id_producto_familia'];
                $model->id_receta = $_POST['id_receta'];
                $model->id_grupo = $_POST['id_grupo'];
                $model->producto_estado = 1;
                $model->producto_fecha_registro = $fecha;
                $model->producto_codigo = $microtime;

                if($_FILES['producto_foto']['name'] != null) {
                    //Conseguimos la extension del archivo y especificamos la ruta
                    $ext = pathinfo($_FILES['producto_foto']['name'], PATHINFO_EXTENSION);
                    $file_path = "media/producto/" . $producto_nombre . '_' .date('dmYHis') . "." . $ext;
                    //Para subir archivos en general o imagenes sin comprimir
                    //if(move_uploaded_file($_FILES['usuario_imagenp']['tmp_name'], $file_path)){
                    //Para subir imagenes comprimidas
                    if($this->archivo->subir_imagen_comprimida($_FILES['producto_foto']['tmp_name'], $file_path,false)){
                        $model->producto_foto = $file_path;
                    } else {
                        $model->producto_foto = 'media/producto/default.jpg';
                    }
                } else {
                    $model->producto_foto = 'media/producto/default.png';
                }

                $result = $this->producto->guardar_producto($model);
                if($result == 1){
                    $id_producto = $this->producto->listar_producto($microtime);
                    $model = new Producto();
                    $model->id_producto = $id_producto;
                    $model->producto_precio_venta = $_POST['producto_precio_venta'];
                    $model->producto_precio_fecha_registro = $fecha;
                    $model->id_medida = $_POST['id_medida'];
                    $model->producto_precio_tipoafectaciona = $_POST['tipo_afectacion'];
                    $model->producto_precio_estado = 1;
                    //$this->producto->actualizar_estado($id_producto);
                    $result = $this->producto->guardar_precio($model);
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


    public function listar_precios(){
        try{
            $id_producto = $_POST['id_producto'];
            $result = $this->producto->listar_precios_producto($id_producto);

            $tabla = " <table class='table table-bordered' width='100%'>
                                        <thead class='text-capitalize'>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Precio</th>
                                            <th>Usuario</th>
                                        </tr>
                                        </thead>
                                        <tbody>";
            foreach($result as $c) {
                $tabla .= " <tr>
                                <td>". date("d-m-Y h:i a",strtotime($c->producto_precio_fecha_registro)) ."</td>
                                <td>". $c->producto_precio_venta . "</td>
                                <td>". $c->persona_nombre . "</td>
                            </tr>";
            }
            $tabla .= "</tbody></table>";

        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode($tabla);
    }


    public function editar_producto(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validacion de datos
            if ($ok_data) {
                $model = new Producto();
                $producto_nombre = $_POST['producto_nombre_e'];
                $model->id_producto = $_POST['id_producto'];
                $model->id_receta = $_POST['id_receta_e'];
                $model->id_grupo = $_POST['id_grupo_e'];
                $model->id_producto_familia = $_POST['id_producto_familia_e'];
                $model->producto_descripcion = $_POST['producto_descripcion_e'];
                $model->producto_nombre = $producto_nombre;

                if($_FILES['producto_foto_e']['name'] != null) {
                    $path = $_FILES['producto_foto_e']['name'];
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $file_path = "media/producto/".$producto_nombre . '_' .date('dmYHis') . "." . $ext;
                    move_uploaded_file($_FILES['producto_foto_e']['tmp_name'],$file_path);
                    $model->producto_foto = $file_path;
                } else {
                    $foto = $this->producto->sacar_foto_producto($_POST['id_producto']);
                    $model->producto_foto = $foto;
                }

                $result = $this->producto->guardar_producto($model);

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


    public function agregar_nuevo_precio(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            if ($ok_data) {
                $model = new Producto();
                $fecha = date('Y-m-d H:i:s');

                $id_producto = $_POST['id_producto'];

                $model->producto_precio_venta = $_POST['producto_precio_venta_a'];
                $model->producto_precio_estado = 1;
                $model->producto_precio_fecha_registro = $fecha;
                $model->id_producto = $id_producto;
                $model->id_medida = $_POST['id_medida_e'];
                $model->producto_precio_tipoafectaciona = $_POST['tipo_afectacion_e'];

                $this->producto->actualizar_estado($id_producto);
                $result = $this->producto->guardar_precio($model);

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

    //FUNCION PARA CAMBIAR EL ESTADO DE LOS PRODUCTOS
    public function cambiar_estado_producto(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_producto', 'POST',true,$ok_data,11,'texto',0);
            $ok_data = $this->validar->validar_parametro('producto_estado', 'POST',true,$ok_data,11,'numero',0);

            //Validacion de datos
            if($ok_data) {

                $id_producto = $_POST['id_producto'];
                $producto_estado = $_POST['producto_estado'];

                $result = $this->producto->cambiar_estado_producto($id_producto, $producto_estado);

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

    public function consultar_datos(){
        try{
            $id_producto = $_POST['id_producto'];
            $jalar_ventas = $this->producto->consultar_ventas($id_producto);
            $valor_total = $this->producto->valor_total($id_producto);
            if($valor_total->total == NULL){
                $total = 0;
            }else{
                $total = $valor_total->total;
            }
            $detalle_ventas_ = "<label class='form-control' style='color: red'>TOTAL: S/. ".$total."</label>";
            $detalle_ventas = " <table class='table table-bordered' width='100%'>
                                    <thead class='text-capitalize'>
                                    <tr>
                                        <th>Vendedor</th>
                                        <th>Producto</th>
                                        <th>Documento</th>
                                        <th>Serie y Correlativo</th>
                                        <th>Nombre</th>
                                        <th>Cantidad</th>
                                        <th>P. Unit</th>
                                        <th>Monto</th>
                                        <th>Fecha Venta</th>
                                    </tr>
                                    </thead>
                                    <tbody>";

            foreach ($jalar_ventas as $r){
                if($r->venta_tipo == "03"){
                    $venta_ = "BOLETA";
                }elseif($r->venta_tipo == "01"){
                    $venta_ = "FACTURA";
                }elseif($r->venta_tipo == "07"){
                    $venta_ = "NOTA DE CREDITO";
                }elseif($r->venta_tipo == "08"){
                    $venta_ = "FALTA DEFINIR";
                }
                $detalle_ventas .= "<tr>
                            <td>". $r->persona_nombre.' '.$r->persona_apellido_paterno."</td>
                            <td>". $r->producto_nombre ."</td>
                            <td>". $venta_ ."</td>
                            <td>". $r->venta_serie.'-'.$r->venta_correlativo ."</td>
                            <td>". $r->cliente_nombre ."</td>
                            <td>". $r->venta_detalle_cantidad ."</td>
                            <td>". $r->venta_detalle_precio_unitario ."</td>
                            <td>". $r->venta_detalle_importe_total ."</td>
                            <td>". $r->venta_fecha ."</td>
                        </tr>";
            }
            $detalle_ventas .= "</tbody></table>";

        }catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
        //Retornamos el json
        echo json_encode(array("detalle_ventas"=>$detalle_ventas,"detalle_ventas_"=>$detalle_ventas_));
    }

    public function guardar_familia(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if($ok_data){
                $model = new Producto();
                $model->producto_familia_nombre = $_POST['producto_familia_nombre'];
                $model->producto_familia_fecha_registro = date('Y-m-d H:i:s');
                $model->producto_familia_estado = 1;
                $result = $this->producto->guardar_familia($model);
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

    public function eliminar_familia(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('id_producto_familia', 'POST', true, $ok_data, 11, 'numero', 0);
            //Validacion de datos
            if ($ok_data) {
                $id_producto_familia = $_POST['id_producto_familia'];
                $consultar = $this->producto->consultar_familiar($id_producto_familia);
                if($consultar){
                    $result = 3;
                    $message = 'No se puede eliminar porque existen productos vinculados a esta familia';
                }else{
                    $result = $this->producto->eliminar_familia($id_producto_familia);
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

    public function sumar_stock_nuevo(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validacion de datos
            if($ok_data) {

                $id_receta = $_POST['id_receta_modal'];
                $asignar_nuevo = $_POST['asignar_stock'];
                //INICIO - OBTENEMOS INFORMACION
                $lista_recurso = $this->producto->jalar_recurso_sede_desde_receta($id_receta);
                $id_recurso_sede = $lista_recurso->id_recurso_sede;
                $result = $this->producto->sumar_stock_adicional($id_recurso_sede, $asignar_nuevo);
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