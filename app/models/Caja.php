<?php
class Caja
{
    private $pdo;
    private $log;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }

    public function listar_cajas(){
        try{
            $sql = 'select * from caja_numero where caja_numero_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function jalar_caja_movi($id_usuario){
        try{
            $sql = 'select * from caja where id_usuario_apertura = ? and caja_estado = 1 limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_usuario]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function datos_caja_($id_caja_numero){
        try{
            $sql = 'select * from caja_numero where id_caja_numero = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja_numero]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_all_users(){
        try{
            $sql = 'select * from personas p inner join usuarios u on p.id_persona = u.id_persona inner join roles r on u.id_rol = r.id_rol 
                    where r.id_rol = 5 and p.persona_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_usuarios_($id_usuario){
        try{
            $sql = 'select * from personas p inner join usuarios u on p.id_persona = u.id_persona where u.id_usuario = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_usuario]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function guardar_apertura_caja($model){
        try{
            $sql = 'insert into caja (id_turno,id_caja_numero, caja_fecha, id_usuario_apertura, caja_apertura, caja_fecha_apertura, caja_estado) 
                    values (?,?,?,?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_turno,
                $model->id_caja_numero,
                $model->caja_fecha,
                $model->id_usuario_apertura,
                $model->caja_apertura,
                $model->caja_fecha_apertura,
                $model->caja_estado
            ]);
            return 1;
        }catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function guardar_cierre_caja($id_usuario_cierre,$caja_cierre,$caja_fecha_cierre,$caja_estado,$id_caja){
        try{
            $sql = 'update caja set id_usuario_cierre = ?, caja_cierre = ?, caja_fecha_cierre = ?, caja_estado = ? where id_caja = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $id_usuario_cierre,$caja_cierre,$caja_fecha_cierre,$caja_estado,$id_caja
            ]);
            return 1;
        }catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function buscar_caja_disponible($id_caja_numero){
        try{
            $sql = 'select * from caja where id_caja_numero = ? and caja_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja_numero]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function mostrar_valor_apertura($id_usuario){
        try{
            $sql = 'select caja_apertura, turno_nombre,id_caja from caja c inner join turno t on c.id_turno = t.id_turno 
                    where c.id_usuario_apertura = ? and t.turno_estado = 1 and c.caja_estado = 1 limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_usuario]);
            $ret = $stm->fetch();
            $return = $ret->caja_apertura;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function valor_por_caja($id_usuario){
        try{
            $sql = 'select * from caja c inner join caja_numero cn on c.id_caja_numero = cn.id_caja_numero inner join usuarios u 
                    on c.id_usuario_apertura = u.id_usuario where c.id_usuario_apertura = ? and c.caja_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_usuario]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }
    public function id_por_caja($fecha_hoy,$id_usuario){
        try{
            $sql = 'select * from caja where date(caja_fecha) = ? and id_usuario_apertura = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_hoy,$id_usuario]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function buscar_cierre_caja($id_caja,$id_usuario){
        try{
            $sql = 'select * from caja where id_caja = ? and id_usuario_cierre = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja,$id_usuario]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function jalar_turno($fecha_hoy){
        try{
            $sql = 'select turno_nombre from caja c inner join turno t on c.id_turno = t.id_turno where date(caja_fecha_apertura) = ? and 
                    t.turno_estado = 1 limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_hoy]);
            $ret = $stm->fetch();
            $return = $ret->turno_nombre;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function jalar_turno_($id_usuario){
        try{
            $sql = 'select turno_nombre from caja c inner join turno t on c.id_turno = t.id_turno where
                    c.id_usuario_apertura = ? and t.turno_estado = 1 and c.caja_estado = 1 limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_usuario]);
            $ret = $stm->fetch();
            $return = $ret->turno_nombre;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }


    public function listar_ultima_fecha($id_usuario){
        try{
            $sql = 'select * from caja where id_usuario_apertura = ? and caja_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_usuario]);
            $result = $stm->fetchAll();
            if(count($result) == 1){
                $result = true;
            } else {
                $result = false;
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = false;
        }
        return $result;
    }

    public function listar_turnos(){
        try{
            $sql = 'select * from turno where turno_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_ultima_caja(){
        try{
            $sql = 'select id_caja from caja order by id_caja desc limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }


    public function listar_ultima_fecha_($id_caja){
        try{
            $sql = 'select * from caja where id_caja = ? and caja_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja]);
            $result = $stm->fetch();
            if(!empty($result)){
                $result = true;
            } else {
                $result = false;
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = false;
        }
        return $result;
    }

    public function buscar_caja_del_usuario($id_usuario){
        try{
            $sql = 'select * from caja where id_usuario_apertura = ? and caja_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_usuario]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }


}
