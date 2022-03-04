<?php
/**
 * Created by PhpStorm.
 * User: KEVIN
 * Date: 3/03/2021
 * Time: 11:54
 */

class Proveedor{
    private $pdo;
    private $log;
    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }
    //Listamos todos los proveedores existentes en el sistema
    public function listar_proveedores(){
        try{
            $sql = 'select * from proveedor p inner join tipo_documentos td on p.id_tipodocumento = td.id_tipodocumento 
                    inner join negocios n on p.id_negocio = n.id_negocio';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    //Validarproveedor_nombre
    public function validar_nombreproveedor($proveedor_nombre){
        try{
            $sql = 'select id_proveedor from proveedor where proveedor_nombre = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$proveedor_nombre]);
            $result = $stm->fetch();
            return isset($result->id_proveedor);
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return true;
        }
    }
    //Validar proveedor_ruc
    public function validar_rucproveedor($proveedor_ruc){
        try{
            $sql = 'select id_proveedor from proveedor where proveedor_ruc = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$proveedor_ruc]);
            $result = $stm->fetch();
            return isset($result->id_proveedor);
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return true;
        }
    }
    //Validar proveedor edicion
    public function validar_proveedor_edicion($proveedor_nombre, $id_proveedor){
        try{
            $sql = 'select id_proveedor from proveedor where proveedor_nombre = ? and id_proveedor <> ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$proveedor_nombre, $id_proveedor]);
            $result = $stm->fetch();
            return isset($result->id_proveedor);
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return true;
        }
    }
    //Validar ruc edicion
    public function validar_rucproveedor_edicion($proveedor_ruc, $id_proveedor){
        try{
            $sql = 'select id_proveedor from proveedor where proveedor_ruc = ? and id_proveedor <> ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$proveedor_ruc, $id_proveedor]);
            $result = $stm->fetch();
            return isset($result->id_proveedor);
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return true;
        }
    }

    //Lista la información del proveedor según id
    public function listar_proveedor($id_proveedor){
        try{
            $sql =  'select * from proveedor where  id_proveedor = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_proveedor]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    //Listar proveedor por microtime
    public function listar_proveedor_microtime($proveedor_codigo){
        try{
            $sql = 'select id_proveedor from proveedor where proveedor_codigo = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$proveedor_codigo]);
            $result = $stm->fetch();
            return $result->id_proveedor;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 0;
        }
    }
    //Registrar proveedor nuevo al sistema
    public function guardar_proveedor($model){
        $fecha_actual = date('Y-m-d H:i:s');
        try{
            if(isset($model->id_proveedor)){
                $sql = 'update proveedor set
                        id_negocio = ?,
                        id_tipodocumento = ?,
                        proveedor_nombre = ?,
                        proveedor_ruc = ?,
                        proveedor_direccion = ?,
                        proveedor_nombre_contacto = ?,
                        proveedor_cargo_persona = ?,
                        proveedor_numero = ?
                        where id_proveedor = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_negocio,
                    $model->id_tipodocumento,
                    $model->proveedor_nombre,
                    $model->proveedor_ruc,
                    $model->proveedor_direccion,
                    $model->proveedor_nombre_contacto,
                    $model->proveedor_cargo_persona,
                    $model->proveedor_numero,
                    $model->id_proveedor
                ]);
            } else {
                $sql = 'insert into proveedor (id_negocio, id_tipodocumento, proveedor_nombre, proveedor_ruc, proveedor_direccion, 
                        proveedor_nombre_contacto, proveedor_cargo_persona, proveedor_numero, proveedor_estado, proveedor_codigo) 
                        values (?,?,?,?,?,?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_negocio,
                    $model->id_tipodocumento,
                    $model->proveedor_nombre,
                    $model->proveedor_ruc,
                    $model->proveedor_direccion,
                    $model->proveedor_nombre_contacto,
                    $model->proveedor_cargo_persona,
                    $model->proveedor_numero,
                    $model->proveedor_estado,
                    $model->proveedor_codigo
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }
    //Eliminar proveedor
    public function eliminar_proveedor($id_proveedor){
        try{
            $sql = 'delete from proveedor where id_proveedor = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_proveedor]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }
}
