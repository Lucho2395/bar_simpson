<?php
/**
 * Created by PhpStorm
 * User: Franz
 * Date: 22/03/2021
 * Time: 09:56
 */

class Cliente
{
    private $pdo;
    private $log;
    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->log = new Log();

    }

    //Listar Los Clientes Registrados en el Sistema
    public function listar_cliente(){
        try{
            $sql = 'select * from clientes where cliente_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            return [];
        }
    }

    public function listar_puntos(){
        try{
            $sql = 'select * from puntos where puntos_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            return [];
        }
    }

    public function listar_tipos_documentos(){
        try{
            $sql = 'select * from tipo_documentos where tipodocumento_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            return [];
        }
    }

    //Validar dni
    public function validar_dni($cliente_numero){
        try{
            $sql = 'select id_cliente from clientes where cliente_numero = ? and cliente_estado = 1 limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$cliente_numero]);
            $result = $stm->fetch();
            return isset($result->id_cliente);
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return true;
        }
    }

    public function listar_cliente_x_numero($cliente_numero){
        try{
            $sql = 'select * from clientes where cliente_numero = ? and cliente_estado = 1 limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$cliente_numero]);
            $result = $stm->fetch();
            return $result;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    //FUNCION PARA GAURDAR CLIENTE
    public function guardar_cliente($model){
        $fecha_actual = date('Y-m-d H:i:s');
        try{
            if(isset($model->id_cliente)){
                $sql = 'update clientes set
                        cliente_razonsocial = ?,
                        cliente_nombre = ?,
                        cliente_numero = ?,
                        cliente_correo = ?,
                        cliente_direccion = ?,
                        cliente_direccion_2 = ?,
                        cliente_telefono = ?,
                        id_tipodocumento = ?
                        where id_cliente = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->cliente_razonsocial,
                    $model->cliente_nombre,
                    $model->cliente_numero,
                    $model->cliente_correo,
                    $model->cliente_direccion,
                    $model->cliente_direccion_2,
                    $model->cliente_telefono,
                    $model->id_tipodocumento,
                    $model->id_cliente
                ]);
            } else {
                $sql = 'insert into clientes (id_tipodocumento, cliente_razonsocial, cliente_nombre, 
                      cliente_numero, cliente_correo, cliente_direccion, cliente_direccion_2 ,cliente_telefono, cliente_fecha, cliente_estado) 
                      values (?,?,?,?,?,?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_tipodocumento,
                    $model->cliente_razonsocial,
                    $model->cliente_nombre,
                    $model->cliente_numero,
                    $model->cliente_correo,
                    $model->cliente_direccion,
                    $model->cliente_direccion_2,
                    $model->cliente_telefono,
                    $fecha_actual,
                    $model->cliente_estado
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function guardar_puntos($model){
        try{
            $sql = 'insert into puntos (id_usuario, puntos_cantidad, puntos_cantidad_soles, puntos_fecha_registro, puntos_estado) 
                      values (?,?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_usuario,
                $model->puntos_cantidad,
                $model->puntos_cantidad_soles,
                $model->puntos_fecha_registro,
                $model->puntos_estado
            ]);
            return 1;
        }catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    //Eliminar cliente
    public function eliminar_cliente($id_cliente){
        try{
            $sql = 'delete from clientes where id_cliente = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_cliente]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function jalar_ultimo_cliente(){
        try{
            $sql = 'select id_cliente, cliente_nombre, cliente_numero,cliente_direccion, cliente_telefono,cliente_razonsocial from clientes order by id_cliente desc limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


}