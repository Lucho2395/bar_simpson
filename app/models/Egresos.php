<?php

class Egresos
{
    private $pdo;
    private $log;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }


    public function guardar_egresos($model){
        try{
            if(isset($model->id_movimiento)){
                $sql = 'update movimientos set
                        id_usuario = ?,
                        id_sucursal = ?,
                        movimiento_tipo = ?,
                        egreso_descripcion = ?,
                        egreso_monto = ?,
                        egreso_fecha_registro = ?
                        where id_movimiento = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_usuario,
                    $model->id_sucursal,
                    $model->movimiento_tipo,
                    $model->egreso_descripcion,
                    $model->egreso_monto,
                    $model->egreso_fecha_registro,
                    $model->id_movimiento
                ]);
            } else {
                $sql = 'insert into movimientos (id_caja_numero,id_usuario, id_sucursal,movimiento_tipo, egreso_descripcion, egreso_monto, egreso_fecha_registro, 
                        egreso_estado) values (?,?,?,?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_caja_numero,
                    $model->id_usuario,
                    $model->id_sucursal,
                    $model->movimiento_tipo,
                    $model->egreso_descripcion,
                    $model->egreso_monto,
                    $model->egreso_fecha_registro,
                    $model->egreso_estado
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }


    public function listar_egresos(){
        try{
            $sql = 'select * from movimientos e inner join caja_numero cn on e.id_caja_numero = cn.id_caja_numero 
                    inner join sucursal s on e.id_sucursal = s.id_sucursal where egreso_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function datos_caja($id_caja_numero){
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

    public function listar_egresos_filtro($id_caja_numero,$fecha_filtro,$fecha_filtro_fin){
        try{
            $sql = 'select * from movimientos e inner join caja_numero cn on e.id_caja_numero = cn.id_caja_numero inner join sucursal s 
                    on e.id_sucursal = s.id_sucursal where e.id_caja_numero = ? and date(egreso_fecha_registro) 
                    between  ? and  ? and egreso_estado = 1 order by egreso_fecha_registro desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja_numero,$fecha_filtro,$fecha_filtro_fin]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_egresos_filtro_fechas($fecha_filtro,$fecha_filtro_fin){
        try{
            $sql = 'select * from movimientos e inner join caja_numero cn on e.id_caja_numero = cn.id_caja_numero inner join sucursal s 
                    on e.id_sucursal = s.id_sucursal where date(egreso_fecha_registro) 
                    between  ? and  ? and egreso_estado = 1 order by egreso_fecha_registro desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_filtro,$fecha_filtro_fin]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_egresos_cajas($id_caja_numero){
        try{
            $sql = 'select * from movimientos e inner join caja_numero cn on e.id_caja_numero = cn.id_caja_numero inner join sucursal s 
                    on e.id_sucursal = s.id_sucursal where e.id_caja_numero = ? and egreso_estado = 1 order by egreso_fecha_registro desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja_numero]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }


    public function eliminar_egreso($id_movimiento){
        try {
            $sql = "update movimientos set
                egreso_estado = 0
                where id_movimiento = ?";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $id_movimiento
            ]);
            $result = 1;
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }


    public function listar_empresas()
    {
        try {
            $sql = "select * from empresa";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_personal(){
        try{
            $sql = 'select * from personas where id_persona > 20';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_personal_deudas($fecha_filtro,$fecha_filtro_fin,$parametro){
        try {
            $sql = "select * from gastos_personal gp inner join personas p on gp.id_persona = p.id_persona where gasto_personal_fecha between ? and ? and 
                    p.persona_nombre like ? and gp.gasto_personal_estado = 1 order by gp.gasto_personal_fecha_registro desc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_filtro,$fecha_filtro_fin,'%'.$parametro.'%']);
            $result = $stm->fetchAll();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_personal_deudas_fechas($fecha_filtro,$fecha_filtro_fin){
        try {
            $sql = "select * from gastos_personal gp inner join personas p on gp.id_persona = p.id_persona where gasto_personal_fecha between ? and ? and 
                    gp.gasto_personal_estado = 1 order by gp.gasto_personal_fecha_registro desc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_filtro,$fecha_filtro_fin]);
            $result = $stm->fetchAll();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function guardar_gastos_personal($model){
        try{
            if(isset($model->id_gasto_personal)){
                $sql = 'update gastos_personal set
                        id_persona = ?,
                        gasto_personal_concepto = ?,
                        gasto_personal_monto = ?,
                        gasto_personal_fecha = ?,
                        gasto_personal_fecha_registro = ?
                        where id_gasto_personal = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_persona,
                    $model->gasto_personal_concepto,
                    $model->gasto_personal_monto,
                    $model->gasto_personal_fecha,
                    $model->gasto_personal_fecha_registro,
                    $model->id_gasto_personal
                ]);
            } else {
                $sql = 'insert into gastos_personal (id_persona, id_usuario,id_caja_numero, gasto_personal_concepto, gasto_personal_monto,gasto_personal_fecha, gasto_personal_fecha_registro,
                        gasto_personal_estado) values (?,?,?,?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_persona,
                    $model->id_usuario,
                    $model->id_caja_numero,
                    $model->gasto_personal_concepto,
                    $model->gasto_personal_monto,
                    $model->gasto_personal_fecha,
                    $model->gasto_personal_fecha_registro,
                    $model->gasto_personal_estado
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function guardar_personal($model)
    {
        try {
            if (isset($model->id_persona)) {
                $sql = 'update personas set 
                id_empresa = ?, persona_nombre = ?, persona_apellido_paterno = ?, persona_apellido_materno = ?, persona_email = ?,
                persona_nacionalidad = ?, persona_job = ?, persona_telefono = ?,persona_telefono_2 = ?, persona_sexo = ?, persona_estado_civil = ?, persona_discapacidad = ?, 
                persona_direccion = ?, persona_distrito = ?, persona_provincia = ?, persona_departamento = ?, persona_adicional = ?, 
                persona_blacklist = ?,persona_bank = ?,persona_number_account = ?, persona_bank_alt = ?,persona_number_account_alt = ?, 
                persona_bank_cts = ?, persona_account_cts = ?, persona_foto = ?, persona_hijos = ?, persona_cv = ?, persona_dni = ?, 
                persona_tipo_documento = ?, persona_nacimiento = ?, persona_modificacion = ?
                where id_persona = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_empresa,
                    $model->persona_nombre,
                    $model->persona_apellido_paterno,
                    $model->persona_apellido_materno,
                    $model->persona_email,
                    $model->persona_nacionalidad,
                    $model->persona_job,
                    $model->persona_telefono,
                    $model->persona_telefono_2,
                    $model->persona_sexo,
                    $model->persona_estado_civil,
                    $model->persona_discapacidad,
                    $model->persona_direccion,
                    $model->persona_distrito,
                    $model->persona_provincia,
                    $model->persona_departamento,
                    $model->persona_adicional,
                    $model->persona_blacklist,
                    $model->persona_bank,
                    $model->persona_number_account,
                    $model->persona_bank_alt,
                    $model->persona_number_account_alt,
                    $model->persona_bank_cts,
                    $model->persona_account_cts,
                    $model->persona_foto,
                    $model->persona_hijos,
                    $model->persona_cv,
                    $model->persona_dni,
                    $model->persona_tipo_documento,
                    $model->persona_nacimiento,
                    $model->persona_modificacion,
                    $model->id_persona
                ]);
            } else {
                $sql = 'insert into personas (id_empresa, persona_nombre, persona_apellido_paterno, persona_apellido_materno, persona_email, 
                    persona_tipo_documento, persona_dni, persona_nacionalidad, persona_estado_civil, persona_direccion, persona_discapacidad, 
                    persona_job, persona_nacimiento, persona_sexo, persona_telefono,persona_telefono_2, persona_foto, persona_hijos, persona_departamento, 
                    persona_provincia, persona_distrito, persona_adicional, persona_blacklist,persona_bank,persona_number_account, persona_bank_alt,
                    persona_number_account_alt, persona_bank_cts, persona_account_cts,persona_cv,persona_empleado, persona_creacion, persona_modificacion, person_codigo,persona_estado) 
                    values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_empresa,
                    $model->persona_nombre,
                    $model->persona_apellido_paterno,
                    $model->persona_apellido_materno,
                    $model->persona_email,
                    $model->persona_tipo_documento,
                    $model->persona_dni,
                    $model->persona_nacionalidad,
                    $model->persona_estado_civil,
                    $model->persona_direccion,
                    $model->persona_discapacidad,
                    $model->persona_job,
                    $model->persona_nacimiento,
                    $model->persona_sexo,
                    $model->persona_telefono,
                    $model->persona_telefono_2,
                    $model->persona_foto,
                    $model->persona_hijos,
                    $model->persona_departamento,
                    $model->persona_provincia,
                    $model->persona_distrito,
                    $model->persona_adicional,
                    $model->persona_blacklist,
                    $model->persona_bank,
                    $model->persona_number_account,
                    $model->persona_bank_alt,
                    $model->persona_number_account_alt,
                    $model->persona_bank_cts,
                    $model->persona_account_cts,
                    $model->persona_cv,
                    $model->persona_empleado,
                    $model->persona_creacion,
                    $model->persona_modificacion,
                    $model->person_codigo,
                    $model->persona_estado
                ]);
            }
            return 1;
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            return 2;
        }
    }


    public function eliminar_gasto_personal($id_gasto_personal){
        try {
            $sql = "update gastos_personal set
                gasto_personal_estado = 0
                where id_gasto_personal = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $id_gasto_personal
            ]);
            $result = 1;
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }






}