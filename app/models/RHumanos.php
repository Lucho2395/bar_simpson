<?php

class RHumanos
{
    private $pdo;
    private $log;
    private $encriptar;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->log = new Log();
        $this->encriptar = new Encriptar();
    }

    public function listar_personas()
    {
        try {
            $sql = 'select * from personas p inner join persona_turno pt on p.id_persona = pt.id_persona 
                    where p.id_persona <> 1 and p.id_persona <> 0 and pt.persona_estado_turno = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            return [];
        }
    }

    public function listar_departamentos(){
        try{
            $sql = "select * from tipodepartamento where id_departamento <> 0 order by departamento_nombre asc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_sedes(){
        try{
            $sql = "select * from tiposede where id_sede <> 0 order by id_sede asc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_datos_generales($id)
    {
        try {
            $sql = 'select * from usuarios u inner join personas p on u.id_persona = p.id_persona where u.id_usuario = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $result = 0;
        }
        return $result;
    }

    public function listar_memos()
    {
        try {
            $sql = 'select * from memorandum m inner join personas p on m.id_persona = p.id_persona where memorandum_estado <> 9';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            return [];
        }
    }

    public function guardar_memo($model)
    {
        try {
            $sql = 'insert into memorandum (id_persona, memorandum_motivo, memorandum_otros, memorandum_fecha, memorandum_descripcion, 
                    id_usuario, memorandum_fecha_creacion, memorandum_estado) values (?,?,?,?,?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_persona,
                $model->memorandum_motivo,
                $model->memorandum_otros,
                $model->memorandum_fecha,
                $model->memorandum_descripcion,
                $model->id_usuario,
                $model->memorandum_fecha_creacion,
                $model->memorandum_estado
            ]);
            return 1;
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            return 2;
        }
    }

    public function guardar_edicion_memo($model)
    {
        try {
            $sql = 'update memorandum set
                        id_persona = ?,
                        id_usuario = ?,
                        memorandum_motivo = ?,
                        memorandum_otros = ?,
                        memorandum_fecha = ?,
                        memorandum_descripcion = ?,
                        memorandum_fecha_creacion = ?
                        where id_memorandum = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_persona,
                $model->id_usuario,
                $model->memorandum_motivo,
                $model->memorandum_otros,
                $model->memorandum_fecha,
                $model->memorandum_descripcion,
                $model->memorandum_fecha_creacion,
                $model->id_memorandum
            ]);
            return 1;
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            return 2;
        }
    }

    public function listar_ultimo_nro_memo()
    {
        try {
            $sql = "select * from memorandum where memorandum_estado <> 0 order by memorandum_numero desc limit 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetch();
        } catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function aprobar_memo($id, $user, $obligacion)
    {
        $fecha_aprobacion = date('Y-m-d H:i:s');
        try {
            $sql = 'update memorandum set memorandum_numero= ?, id_user_aprobacion = ?, memoradum_fecha_aprobacion = ? 
                    where id_memorandum = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$obligacion, $user, $fecha_aprobacion, $id]);
            $result = 1;
        } catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function listar_memo_pdf($id)
    {
        try {
            $sql = "select * from memorandum m inner join personas p on m.id_persona = p.id_persona where m.id_memorandum = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_empresa()
    {
        try {
            $sql = "select * from empresa";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetch();
        } catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_empresa_($id){
        try{
            $sql = "select * from empresa where id_empresa = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function eliminar_memo_totalmente($id)
    {
        try {
            $sql = 'delete from memorandum where id_memorandum = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            return 1;
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            return 2;
        }
    }

    public function eliminar_memo($id)
    {
        try {
            $sql2 = 'update memorandum set memorandum_estado = 9 where id_memorandum = ?';
            $stm2 = $this->pdo->prepare($sql2);
            $stm2->execute([$id]);
            $result = 1;
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function listar_busqueda($parametro)
    {
        try {
            $sql = "select * from personas where (persona_nombre like ? or persona_apellido_paterno like ? or persona_dni like ?) and id_persona > 2 and persona_estado = 1
                    order by persona_apellido_paterno, persona_apellido_materno asc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute(['%' . $parametro . '%', '%' . $parametro . '%', '%' . $parametro . '%']);
            $result = $stm->fetchAll();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $result = [];
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

    public function listar_turnos(){
        try {
            $sql = "select * from turno";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $result = [];
        }
        return $result;
    }


    public function listar_turnos_asistencia($id){
        try {
            $sql = "select * from personas p inner join persona_turno pt on p.id_persona = pt.id_persona inner join turno t on pt.id_turno = t.id_turno 
                    where p.persona_dni = ? and pt.persona_estado_turno = 1 limit 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_cargos()
    {
        try {
            $sql = "select * from tipocargo";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $result = [];
        }
        return $result;
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

    public function eliminar_personal($id)
    {
        try {
            $sql = "update personas set persona_estado = 0 where id_persona = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = 1;
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function listar_tipo_documento_nuevo($dni, $tipo, $id)
    {
        try {
            $sql = 'select * from personas where persona_dni = ? and persona_tipo_documento = ? and id_persona <> ? and persona_estado = 1 limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$dni, $tipo, $id]);
            $resultado = $stm->fetch();
            if (isset($resultado->id_persona)) {
                $result = true;
            } else {
                $result = false;
            }
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $result = false;
        }
        return $result;
    }

    public function listar_todo($id)
    {
        {
            try {
                $sql = 'select * from personas p inner join empresa e on p.id_empresa = e.id_empresa where p.id_persona = ? limit 1';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$id]);
                $result = $stm->fetch();
            } catch (Throwable $e) {
                $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
                $result = [];
            }
            return $result;
        }
    }

    public function list_all($id)
    {
        try {
            $sql = 'select * from personas where id_persona = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_tipo_documento($dni, $tipo)
    {
        try {
            $sql = 'select * from personas where persona_dni = ? and persona_tipo_documento = ? and persona_estado = 1 limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$dni, $tipo]);
            $resultado = $stm->fetch();
            if (isset($resultado->id_persona)) {
                $result = true;
            } else {
                $result = false;
            }
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $result = false;
        }
        return $result;
    }


    //PERIDO LABORAL
    public function verificar_periodo_activo($id_persona, $fecha)
    {
        $result = false;
        try {
            if (empty($fecha)) {
                $fecha = date('Y-m-d');
            }
            $sql = "select id_periodo from periodo_laboral where id_persona = ? and ? between periodo_fechainicio and periodo_fechafin limit 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_persona, $fecha]);
            $result = $stm->fetch();
            if (isset($result->id_periodo)) {
                $result = true;
            }
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
        }
        return $result;
    }

    public function listar_periodos_persona($id_persona)
    {
        try {
            $sql = "select * from periodo_laboral p inner join tipocontrato t on t.id_contrato = p.id_contrato inner join tipocargo tc 
                    on tc.id_cargo = p.id_cargo inner join tipodepartamento tp on tc.id_departamento = tp.id_departamento inner join empresa e 
                    on e.id_empresa = p.id_empresa inner join tiposede t2 on p.id_sede = t2.id_sede where p.id_persona = ? 
                    order by p.periodo_fechainicio desc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_persona]);
            $result = $stm->fetchAll();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_contratos()
    {
        try {
            $sql = "select * from tipocontrato where id_contrato = 2";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $result = [];
        }
        return $result;
    }

    //FUNCIONAS PARA PERIODOS
    public function listar_periodo($id){
        try{
            $sql = "select * from periodo_laboral p inner join persona_turno pt on p.id_persona = pt.id_persona inner join turno t2 on pt.id_turno = t2.id_turno 
                    inner join tipocontrato t on t.id_contrato = p.id_contrato inner join 
                    tipocargo tc on tc.id_cargo = p.id_cargo inner join empresa e on e.id_empresa = p.id_empresa where p.id_periodo = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_periodo_($id){
        try{
            $sql = "select * from periodo_laboral p inner join persona_turno pt on p.id_persona = pt.id_persona inner join turno t4 on pt.id_turno = t4.id_turno
                    inner join tipodepartamento t2 on p.id_departamento = t2.id_departamento inner join tiposede t3 on p.id_sede = t3.id_sede 
                    inner join tipocontrato t on t.id_contrato = p.id_contrato inner join tipocargo tc on tc.id_cargo = p.id_cargo inner join 
                    empresa e on e.id_empresa = p.id_empresa where p.id_periodo = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_periodo_fechas_sinrepeticion($inicio, $fin, $id_persona, $id_periodo){
        try{
            $sql = "select * from periodo_laboral where (periodo_fechainicio between ? and ? or periodo_fechafin between ? and ? or 
                    (? between periodo_fechainicio and periodo_fechafin) or (? between periodo_fechainicio and periodo_fechafin)) and id_persona = ? 
                    and periodo_estado = 1 and id_periodo <> ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$inicio, $fin, $inicio, $fin, $inicio, $fin, $id_persona, $id_periodo]);
            $resul = $stm->fetch();
            if(isset($resul->id_periodo)){
                $result = false;
            } else {
                $result = true;
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = false;
        }
        return $result;
    }

    public function listar_pendiente_aprobacion_persona($id){
        try{
            $sql = "select distinct pe.id_persona, pe.persona_nombre, pe.persona_apellido_paterno, pe.persona_apellido_materno, pe.persona_foto, pe.persona_dni, 
                    pe.persona_blacklist,pl.*,td.*,tc.*,ts.sede_nombre  from personas pe inner join periodo_laboral pl on pe.id_persona = pl.id_persona 
                    inner join tipodepartamento td on td.id_departamento=pl.id_departamento inner join tipocargo tc on tc.id_cargo=pl.id_cargo 
                    inner join tiposede ts on pl.id_sede = ts.id_sede where pl.periodo_estado = 0 and pl.id_persona = ? order by pe.persona_apellido_paterno asc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_usuario($id){
        try{
            $sql = "select * from usuarios u inner join personas p on u.id_persona = p.id_persona where u.id_usuario = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_pendiente_aprobacion(){
        try{
            $sql = "select distinct pe.id_persona, pe.persona_nombre, pe.persona_apellido_paterno, pe.persona_apellido_materno, pe.persona_foto, pe.persona_dni, 
                    pe.persona_blacklist,pl.*,td.*,tc.*,ts.sede_nombre from personas pe inner join periodo_laboral pl on pe.id_persona = pl.id_persona 
                    inner join tipodepartamento td on td.id_departamento=pl.id_departamento inner join tipocargo tc on tc.id_cargo=pl.id_cargo 
                    inner join tiposede ts on pl.id_sede = ts.id_sede where pl.periodo_estado = 0 and pe.id_persona <> 0 order by pe.persona_apellido_paterno asc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

   //FUNCION PARA GUARDAR EL PERIODO LABORAL
    public function guardar_periodo($model){
            try{
                if($model->accion == 0){
                    $sql = "update periodo_laboral set
                id_empresa = ?,
                id_contrato = ?,
                id_departamento =?,
                id_sede = ?,
                id_cargo = ?,
                periodo_fechainicio = ?,
                periodo_fechafin = ?,
                periodo_sueldo = ?,
                periodo_movilidad = ?,
                periodo_observa = ?,
                periodo_total = ?,
                periodo_bono = ?
                where id_periodo = ?
                ";
                    $stm = $this->pdo->prepare($sql);
                    $stm->execute([
                        $model->id_empresa,
                        $model->id_contrato,
                        $model->id_contrato,
                        $model->id_departamento,
                        $model->id_sede,
                        $model->periodo_fechainicio,
                        $model->periodo_fechafin,
                        $model->periodo_sueldo,
                        $model->periodo_movilidad,
                        $model->periodo_observa,
                        $model->periodo_total,
                        $model->periodo_bono,
                        $model->id_periodo
                    ]);
                } else if($model->accion == 1) {
                    $sql = "insert into periodo_laboral (id_persona, id_empresa, id_contrato,id_departamento,id_sede, id_cargo, periodo_fechainicio, 
                            periodo_fechafin, periodo_sueldo, periodo_movilidad, periodo_total,id_user_creacion,periodo_fecha_creacion,
                            periodo_hora_creacion,periodo_bono, periodo_estado) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                    $stm = $this->pdo->prepare($sql);
                    $stm->execute([
                        $model->id_persona,
                        $model->id_empresa,
                        $model->id_contrato,
                        $model->id_departamento,
                        $model->id_sede,
                        $model->id_cargo,
                        $model->periodo_fechainicio,
                        $model->periodo_fechafin,
                        $model->periodo_sueldo,
                        $model->periodo_movilidad,
                        $model->periodo_total,
                        $model->id_user_creacion,
                        $model->periodo_fecha_creacion,
                        $model->periodo_hora_creacion,
                        $model->periodo_bono,
                        $model->periodo_estado,
                    ]);
                } else if($model->accion == 2){
                    $sql = "update periodo_laboral set
                id_empresa = ?,
                id_contrato = ?,
                id_departamento = ?,
                id_sede = ?,
                id_cargo = ?,
                periodo_fechainicio = ?,
                periodo_fechafin = ?,
                periodo_sueldo = ?,
                periodo_movilidad = ?,
                periodo_total = ?,
                periodo_observa = ?
                where id_periodo = ?
                ";
                    $stm = $this->pdo->prepare($sql);
                    $stm->execute([
                        $model->id_empresa,
                        $model->id_contrato,
                        $model->id_departamento,
                        $model->id_sede,
                        $model->id_cargo,
                        $model->periodo_fechainicio,
                        $model->periodo_fechafin,
                        $model->periodo_sueldo,
                        $model->periodo_movilidad,
                        $model->periodo_total,
                        $model->periodo_observa,
                        $model->id_periodo
                    ]);
                } else {
                    $sql = "update periodo_laboral set
                periodo_fechafin = ?,
                periodo_observa = ?
                where id_periodo = ?";
                    $stm = $this->pdo->prepare($sql);
                    $stm->execute([
                        $model->periodo_fechafin,
                        $model->periodo_observa,
                        $model->id_periodo
                    ]);
                }
                $result = 1;
            } catch (Throwable $e){
                $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
                $result = 2;
            }
            return $result;
        }

    public function quitar_contrato($id){
        try{
            $sql = "update periodo_laboral set periodo_contrato = null where id_periodo = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function listar_periodo_fechas($inicio, $fin, $id_person){
        try{
            $sql = "select * from periodo_laboral where (periodo_fechainicio between ? and ? or periodo_fechafin between ? and ? or 
                    (? between periodo_fechainicio and periodo_fechafin) or (? between periodo_fechainicio and periodo_fechafin)) 
                    and id_persona = ? and periodo_estado = 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$inicio, $fin, $inicio, $fin, $inicio, $fin, $id_person]);
            $resul = $stm->fetch();
            if(isset($resul->id_periodo)){
                $result = false;
            } else {
                $result = true;
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = false;
        }
        return $result;
    }

    public function listar_adjuntos(){
        try{
            $sql = "select * from tipoadjuntos";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function guardar_archivo($model){
        try{
            $sql = "insert into documentos (id_persona, id_periodo, id_adjunto , documento_nombre, documento_fechainicio, documento_fechafin,
                    documento_fecha_registro,documento_estado) values (?,?,?,?,?,?,?,?)";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_persona,
                $model->id_periodo,
                $model->id_adjunto,
                $model->documento_nombre,
                $model->documento_fechainicio,
                $model->documento_fechafin,
                $model->documento_fecha_registro,
                $model->documento_estado
            ]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function listar_adjuntos_docs($id_periodo){
        try{
            $sql = "select * from documentos d inner join tipoadjuntos a on d.id_adjunto = a.id_adjunto where d.id_periodo = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_periodo]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_ultimo_nro_contrato(){
        try{
            $sql = "select * from periodo_laboral order by periodo_nro_contrato desc limit 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function eliminar_documento($id_documento){
        try{
            $sql = "delete from documentos where id_documento = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_documento]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function listar_feriados(){
        $fecha = date('Y-m-d');
        try{
            $sql = 'select * from feriados where feriado_dia > ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_asistencia_periodos_activos_departamento_sede($id_departamento, $id_sede,$fecha_actual){
        try{
            $sql = "select * from periodo_laboral pe inner join personas p on pe.id_persona = p.id_persona inner join 
                    asistencia aa on aa.id_persona_turno=p.id_persona inner join tipocargo t on pe.id_cargo = t.id_cargo inner join 
                    empresa e on e.id_empresa = pe.id_empresa where ? between periodo_fechainicio and periodo_fechafin and pe.id_departamento = ? 
                    and pe.id_sede = ? and aa.asistencia_fecha=? order by  p.persona_apellido_paterno asc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_actual, $id_departamento, $id_sede,$fecha_actual]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_sede($id){
        try{
            $sql = "select * from tiposede where id_sede = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_departamento($id){
        try{
            $sql = "select * from tipodepartamento where id_departamento = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_asistencia_periodos_activos_departamento($id_departamento,$fecha_actual){
        try{
            $sql = "select * from periodo_laboral pe inner join personas p on pe.id_persona = p.id_persona inner join asistencia aa on aa.id_persona=pe.id_persona 
                    inner join tipocargo t on pe.id_cargo = t.id_cargo inner join empresa e on e.id_empresa = pe.id_empresa where ? between periodo_fechainicio 
                    and periodo_fechafin and pe.id_departamento = ? and aa.asistencia_fecha=? order by  p.persona_apellido_paterno asc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_actual, $id_departamento,$fecha_actual]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_asistencia_periodos_activos_sede($id_sede,$fecha_actual){
        try{
            $sql = "select * from periodo_laboral pe inner join personas p on pe.id_persona = p.id_persona inner join persona_turno pt on p.id_persona = pt.id_persona 
                    inner join tipocargo t on pe.id_cargo = t.id_cargo inner join empresa e on e.id_empresa = pe.id_empresa where ? 
                    between periodo_fechainicio and periodo_fechafin and pe.id_sede = ? and pt.persona_estado_turno = 1 order by  p.persona_apellido_paterno asc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_actual, $id_sede]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function consultar_asistencia_persona($id_persona_turno,$fecha){
        try{
            $sql = 'select * from asistencia where id_persona_turno = ? and date(asistencia_fecha) = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_persona_turno, $fecha]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
    public function consultar_asistencia_persona_($id_persona_turno,$fecha){
        try{
            $sql = 'select * from asistencia where id_persona_turno = ? and date(asistencia_fecha) = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_persona_turno, $fecha]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_feriado($id_feriado){
        try{
            $sql = 'select * from feriados where id_feriado = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_feriado]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function agregar_feriado($model){
        try{
            $sql = 'insert into feriados (feriado_dia, feriado_motivo) values (?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->feriado_dia,
                $model->feriado_motivo
            ]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }


    public function eliminar_feriado($id_feriado){
        try{
            $sql = 'delete from feriados where id_feriado = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $id_feriado
            ]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function listAll_persona_periodo_activo(){
        try{
            $sql = 'select * from personas p inner join periodo_laboral p2 on p.id_persona = p2.id_persona where p.persona_empleado = 1 
                    and ? between p2.periodo_fechainicio and p2.periodo_fechafin';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([date('Y-m-d')]);
            $result = $stm->fetchAll();

        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_asistencia_persona_fecha_proyectada($id_person,$fecha){
        try{
            $sql = "select * from asistencia where id_persona_turno = ? and asistencia_fecha = ? and asistencia_proyectada = 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_person,$fecha]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function buscar_asistencia_persona_fecha_id($id,$fecha){
        try{
            $sql = 'select id_persona_turno, id_asistencia from asistencia where id_persona_turno = ? and asistencia_fecha = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id,$fecha]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function guardar_asistencia_aprobada($id_persona,$fecha,$valor, $tipo = "GENERADA POR CONTRATO LABORAL", $proyectada = 0){
        try{
            $sql = "insert into asistencia (id_persona_turno, asistencia_fecha, asistencia_valor, asistencia_estado, asistencia_proyectada) 
                    values (?,?,?,?,?)";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $id_persona,
                $fecha,
                $valor,
                1,
                $proyectada
            ]);
            $result = true;
            if($tipo != "NO"){
                $this->registrar_edicion_asistencia($id_persona,$fecha,$valor,$tipo);
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = false;
        }
        return $result;
    }

    public function registrar_edicion_asistencia($id_persona_turno,$fecha,$valor,$comentarios){
        $id_user = $this->encriptar->desencriptar($_SESSION['c_u'], _FULL_KEY_) ?? 0;
        try{
            $sql = "insert into registro_asistencias (id_persona_turno, asistencia_fecha, asistencia_valor, id_user, asistencia_cambio_fecha, asistencia_cambio_hora, asistencia_comentarios) values (?,?,?,?,?,?,?)";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $id_persona_turno,
                $fecha,
                $valor,
                $id_user,
                date('Y-m-d'),
                date('H:i:s'),
                $comentarios
            ]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function actualizar_asistencia_aprobada_proyectada($id_asistencia,$valor){
        try{
            $sql = "update asistencia set asistencia_valor = ?, asistencia_proyectada = 1, asistencia_estado = 1  where id_asistencia = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$valor,$id_asistencia]);
            $result = true;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = false;
        }
        return $result;
    }

    public function listar_asistencias_por_persona_rango($id_person,$fecha_i,$fecha_f){
        try{
            $sql = "select * from asistencia a inner join persona_turno pt on a.id_persona_turno = pt.id_persona_turno where pt.id_persona = ? and a.asistencia_fecha between ? and ? and asistencia_estado = 1 
                    order by a.asistencia_fecha asc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_person,$fecha_i,$fecha_f]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_periodo_persona_por_fecha($id_persona,$fecha){
        try{
            $sql = "select * from periodo_laboral p inner join tipocontrato t on t.id_contrato = p.id_contrato inner join tipocargo tc 
                    on tc.id_cargo = p.id_cargo inner join empresa e on e.id_empresa = p.id_empresa where p.id_persona = ? and ? 
                    between p.periodo_fechainicio and p.periodo_fechafin limit 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_persona,$fecha]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function actualizar_asistencia($id_persona,$fecha,$valor,$asitencia_estado){
        try{
            $sql = "update asistencia set asistencia_valor=? where id_persona_turno=? and asistencia_fecha=? and asistencia_estado = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $valor,
                $id_persona,
                $fecha,
                $asitencia_estado
            ]);
            $this->registrar_edicion_asistencia($id_persona,$fecha,$valor,'ASISTENCIA GENERAL');
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function actualizar_asistencia_($id_persona_turno,$fecha,$valor,$asistencia_observacion,$asistencia_estado){
        try{
            $sql = "update asistencia set asistencia_valor=?,asistencia_estado = ?,asistencia_observacion = ? where id_persona_turno=? and asistencia_fecha=?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $valor,
                $asistencia_estado,
                $asistencia_observacion,
                $id_persona_turno,
                $fecha
            ]);
            $this->registrar_edicion_asistencia($id_persona_turno,$fecha,$valor,'ASISTENCIA GENERAL');
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function listar_asistencia_periodos_activos($fecha_actual){
        try{
            $sql = "select * from periodo_laboral pe inner join personas p on pe.id_persona = p.id_persona inner join asistencia aa on aa.id_persona=pe.id_persona 
                    inner join tipocargo t on pe.id_cargo = t.id_cargo inner join empresa e on e.id_empresa = pe.id_empresa where ? 
                    between periodo_fechainicio and periodo_fechafin and aa.asistencia_fecha=? order by  p.persona_apellido_paterno asc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_actual,$fecha_actual]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function aprobar_asistencia($id_asistencia){
        try{
            $sql = "update asistencia set asistencia_estado = 1 where id_asistencia=?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_asistencia]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function listar_periodos_departamento_sede($id_departamento,$id_sede,$fecha_i,$fecha_f){
        try{
            $sql = "select distinct pe.id_periodo, p.persona_apellido_paterno from periodo_laboral pe inner join personas p on pe.id_persona = p.id_persona 
                    inner join tipocargo t on pe.id_cargo = t.id_cargo inner join empresa e on e.id_empresa = pe.id_empresa 
                    where 
                    pe.id_departamento = ? and pe.periodo_estado=1 and pe.id_sede=? and pe.periodo_fechainicio <= ? and pe.periodo_fechafin >= ? or
                    pe.id_departamento = ? and pe.periodo_estado=1 and pe.id_sede=? and pe.periodo_fechainicio >=? and pe.periodo_fechafin <=? or
                    pe.id_departamento = ? and pe.periodo_estado=1 and pe.id_sede=? and pe.periodo_fechainicio <=?  and pe.periodo_fechafin between ? and ? or
                    pe.id_departamento = ? and pe.periodo_estado=1 and pe.id_sede=? and pe.periodo_fechainicio between ? and ? and pe.periodo_fechafin >= ?
                    order by  p.persona_apellido_paterno asc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_departamento,$id_sede,$fecha_i,$fecha_f,/**/$id_departamento,$id_sede,$fecha_i,$fecha_f,/**/$id_departamento,$id_sede,$fecha_i,$fecha_i,$fecha_f,/**/$id_departamento,$id_sede,$fecha_i,$fecha_f,$fecha_f]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_periodos_departamento($id_departamento,$fecha_i,$fecha_f){
        try{
            $sql = "select distinct pe.id_periodo, p.persona_apellido_paterno from periodo_laboral pe inner join personas p on pe.id_persona = p.id_persona 
                    inner join tipocargo t on pe.id_cargo = t.id_cargo inner join empresa e on e.id_empresa = pe.id_empresa 
                    where 
                    pe.id_departamento = ? and pe.periodo_estado=1 and pe.periodo_fechainicio <= ? and pe.periodo_fechafin >= ? or
                    pe.id_departamento = ? and pe.periodo_estado=1 and pe.periodo_fechainicio >=? and pe.periodo_fechafin <=? or
                    pe.id_departamento = ? and pe.periodo_estado=1 and pe.periodo_fechainicio <=?  and pe.periodo_fechafin between ? and ? or
                    pe.id_departamento = ? and pe.periodo_estado=1 and pe.periodo_fechainicio between ? and ? and pe.periodo_fechafin >= ?
                    order by  p.persona_apellido_paterno asc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_departamento,$fecha_i,$fecha_f,/**/$id_departamento,$fecha_i,$fecha_f,/**/$id_departamento,$fecha_i,$fecha_i,$fecha_f,/**/$id_departamento,$fecha_i,$fecha_f,$fecha_f]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_periodos_sede($id_sede,$fecha_i,$fecha_f){
        try{
            $sql = "select distinct pe.id_periodo, p.persona_apellido_paterno from periodo_laboral pe inner join personas p  on pe.id_persona = p.id_persona 
                    inner join persona_turno pt on p.id_persona = pt.id_persona
                    inner join tipocargo t on pe.id_cargo = t.id_cargo inner join empresa e on e.id_empresa = pe.id_empresa 
                    where 
                    pe.id_sede = ? and pe.periodo_estado=1 and pe.periodo_fechainicio <= ? and pe.periodo_fechafin >= ? or
                    pe.id_sede = ? and pe.periodo_estado=1 and pe.periodo_fechainicio >=? and pe.periodo_fechafin <=? or
                    pe.id_sede = ? and pe.periodo_estado=1 and pe.periodo_fechainicio >=? and pe.periodo_fechafin between ? and ? or
                    pe.id_sede = ? and pe.periodo_estado=1 and pe.periodo_fechainicio between ? and ? and pe.periodo_fechafin >= ?
                    order by  p.persona_apellido_paterno asc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_sede,$fecha_i,$fecha_f,/**/$id_sede,$fecha_i,$fecha_f,/**/$id_sede,$fecha_i,$fecha_i,$fecha_f,/**/$id_sede,$fecha_i,$fecha_f,$fecha_f]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_periodos($fecha_i,$fecha_f){
        try{
            $sql = "select distinct pe.id_periodo, p.persona_apellido_paterno from periodo_laboral pe inner join personas p on pe.id_persona = p.id_persona 
                    inner join persona_turno pt on p.id_persona = pt.id_persona             
                    inner join tipocargo t on pe.id_cargo = t.id_cargo inner join empresa e on e.id_empresa = pe.id_empresa 
                    where 
                    pe.periodo_estado=1 and pe.periodo_fechainicio <= ? and pe.periodo_fechafin >= ? or
                    pe.periodo_estado=1 and pe.periodo_fechainicio >=? and pe.periodo_fechafin <=? or
                    pe.periodo_estado=1 and pe.periodo_fechainicio <=?  and pe.periodo_fechafin between ? and ? or
                    pe.periodo_estado=1 and pe.periodo_fechainicio between ? and ? and pe.periodo_fechafin >= ?
                    order by  p.persona_apellido_paterno asc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_i,$fecha_f,$fecha_i,$fecha_f,$fecha_i,$fecha_i,$fecha_f,$fecha_i,$fecha_f,$fecha_f]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_periodo_persona($id){
        try{
            $sql = "select * from periodo_laboral p inner join personas pe on p.id_persona = pe.id_persona where p.id_periodo = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function jalar_ultimo_periodo(){
        try{
            $sql = "select * from periodo_laboral p inner join personas p2 on p.id_persona = p2.id_persona inner join persona_turno pt on p.id_persona = pt.id_persona 
                    order by id_periodo desc limit 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function activar_periodo($id, $id_user_aprobacion){
        try{
            $sql = "update periodo_laboral set periodo_estado = 1, id_user_aprobacion = ? where id_periodo = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_user_aprobacion, $id]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function buscar_asistencia_persona_fecha($id,$fecha){
        try{
            $sql = 'select id_persona_turno, asistencia_proyectada from asistencia where id_persona_turno=? and asistencia_fecha=? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id,$fecha]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function guardar_asistencia($id_persona_turno,$fecha,$valor){
        try{
            $sql = "insert into asistencia (id_persona_turno, asistencia_fecha, asistencia_valor , asistencia_estado) values (?,?,?,?)";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $id_persona_turno,
                $fecha,
                $valor,
                0
            ]);
            $result = true;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = false;
        }
        return $result;
    }

    public function guardar_asistencia_($model){
        try{
            $sql = "insert into asistencia (id_persona_turno, asistencia_fecha,asistencia_hora, asistencia_valor , asistencia_observacion,asistencia_tipo, 
                    asistencia_estado, asistencia_proyectada) values (?,?,?,?,?,?,?,?)";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_persona_turno,
                $model->asistencia_fecha,
                $model->asistencia_hora,
                $model->asistencia_valor,
                $model->asistencia_observacion,
                $model->asistencia_tipo,
                $model->asistencia_estado,
                $model->asistencia_proyectada
            ]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function guardar_salida($asistencia_hora_salida,$fecha_hoy,$id_persona_turno){
        try{
            $sql = "update asistencia set asistencia_hora_salida = ? where date(asistencia_fecha) = ? and id_persona_turno = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $asistencia_hora_salida,$fecha_hoy,$id_persona_turno
            ]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function desactivar_periodo($id){
        try{
            $sql = "update periodo_laboral set periodo_estado = 0 where id_periodo = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function eliminar_asistencia($id_persona, $fi, $ff){
        try{
            $sql = "delete from asistencia where id_persona = ? and asistencia_fecha between ? and ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $id_persona, $fi, $ff
            ]);
            $result = true;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = false;
        }
        return $result;
    }

    public function listar_periodos_persona_($id_persona){
        try{
            $sql = "select * from periodo_laboral p inner join tipocontrato t on t.id_contrato = p.id_contrato inner join 
                    tipocargo tc on tc.id_cargo = p.id_cargo inner join tipodepartamento t2 on p.id_departamento = t2.id_departamento 
                    inner join empresa e on e.id_empresa = p.id_empresa inner join tiposede t3 on p.id_sede = t3.id_sede
                    where p.id_persona = ? order by p.periodo_fechainicio desc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_persona]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function guardar_obligacion_laboral($model){
        try{
            $sql = 'insert into obligacion_pagar (id_empresa,id_contrato,id_user_creacion,obligacion_fecha_creacion,obligacion_hora_creacion,
                    obligacion_fecha_inicio,obligacion_fecha_fin,obligacion_estado,obligacion_tipo,obligacion_activo,obligacion_documentacion,
                    obligacion_clase) values (?,?,?,?,?,?,?,?,?,?,?,1)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_empresa,
                $model->id_contrato,
                $model->id_user_creacion,
                $model->obligacion_fecha_creacion,
                $model->obligacion_hora_creacion,
                $model->obligacion_fecha_inicio,
                $model->obligacion_fecha_fin,
                0,
                $model->obligacion_tipo,
                1,
                0
            ]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function guardar_obligacion_tributaria($model){
        try{
            $sql = "insert into obligacion_pagar (id_empresa,id_contrato,id_user_creacion,obligacion_fecha_creacion,obligacion_hora_creacion,
                    obligacion_fecha_inicio,obligacion_fecha_fin,obligacion_estado,obligacion_tipo,obligacion_activo,obligacion_documentacion,
                    obligacion_clase,obligacion_concepto,obligacion_moneda,obligacion_id_persona,obligacion_importe) values (?,?,?,?,?,?,?,?,?,?,?,4,0,'SOLES',0,0)";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_empresa,
                $model->id_departamento,
                $model->id_contrato,
                $model->id_sede,
                $model->id_user_creacion,
                $model->obligacion_fecha_creacion,
                $model->obligacion_hora_creacion,
                $model->obligacion_fecha_inicio,
                $model->obligacion_fecha_fin,
                0,
                $model->obligacion_tipo,
                1,
                0
            ]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function listar_periodos_empresa($id_empresa,$fecha_i,$fecha_f){
        try{
            $sql = "select distinct pe.id_periodo,p.persona_apellido_paterno,p.persona_apellido_materno,p.persona_nombre, pe.periodo_fechainicio, pe.periodo_fechafin from periodo_laboral pe inner join personas p on pe.id_persona = p.id_persona 
                    inner join tipocargo t on pe.id_cargo = t.id_cargo inner join empresa e on e.id_empresa = pe.id_empresa 
                    where 
                    pe.id_empresa = ? and pe.periodo_estado=1 and pe.periodo_fechainicio <= ? and pe.periodo_fechafin >= ? or
                    pe.id_empresa = ? and pe.periodo_estado=1 and pe.periodo_fechainicio >=? and pe.periodo_fechafin <=? or
                    pe.id_empresa = ? and pe.periodo_estado=1 and pe.periodo_fechainicio <=? and pe.periodo_fechafin between ? and ? or
                    pe.id_empresa = ? and pe.periodo_estado=1 and pe.periodo_fechainicio between ? and ? and pe.periodo_fechafin >= ?
                    order by  p.persona_apellido_paterno,p.persona_apellido_materno,p.persona_nombre asc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_empresa,$fecha_i,$fecha_f,$id_empresa,$fecha_i,$fecha_f,$id_empresa,$fecha_i,$fecha_i,$fecha_f,$id_empresa,$fecha_i,$fecha_f,$fecha_f]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_asistencias_por_periodo_rango($id_periodo,$fecha_i,$fecha_f){
        try{
            $sql = "select * from asistencia a inner join persona_turno pt on a.id_persona_turno = pt.id_persona_turno 
                    inner join periodo_laboral pl on pt.id_persona = pl.id_persona where pl.id_periodo = ?
                    and a.asistencia_fecha between ? and ? and a.asistencia_estado = 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_periodo,$fecha_i,$fecha_f]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_periodos_empresa_person($id_person,$fecha_i,$fecha_f){
        try{
            $sql = "select distinct pe.id_periodo,p.persona_apellido_paterno from periodo_laboral pe inner join personas p on pe.id_persona = p.id_persona 
                    inner join tipocargo t on pe.id_cargo = t.id_cargo inner join empresa e on e.id_empresa = pe.id_empresa 
                    where 
                    pe.id_persona = ? and pe.periodo_estado=1 and pe.periodo_fechainicio <= ? and pe.periodo_fechafin >= ? or
                    pe.id_persona = ? and pe.periodo_estado=1 and pe.periodo_fechainicio >=? and pe.periodo_fechafin <=? or
                    pe.id_persona = ? and pe.periodo_estado=1 and pe.periodo_fechainicio <=? and pe.periodo_fechafin <=? and pe.periodo_fechafin >= ?
                    order by  p.persona_apellido_paterno asc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_person,$fecha_i,$fecha_f,$id_person,$fecha_i,$fecha_f,$id_person,$fecha_i,$fecha_f,$fecha_i]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function buscar_persona_x_dni($dni){
        try{
            $sql = "select * from personas p inner join persona_turno pt on p.id_persona = pt.id_persona 
                    inner join turno t on pt.id_turno = t.id_turno where persona_dni = ? and pt.persona_estado_turno = 1 limit 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$dni]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function jalar_id_memo(){
        try{
            $sql = "select * from memorandum order by id_memorandum desc limit 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function generar_contrato($nro,$id){
        try{
            $fecha=date('Y-m-d');
            $sql = "update periodo_laboral set periodo_contrato = 1,periodo_nro_contrato=?,periodo_fechafirma=? where id_periodo = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$nro,$fecha,$id]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function buscar_asistencia_persona_fecha_si_hay($id,$fecha){
        $result = true;
        try{
            $sql = 'select id_persona, id_asistencia from asistencia where id_persona = ? and asistencia_fecha = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id,$fecha]);
            $resulta = $stm->fetch();
            if(isset($resulta->id_persona)){
                $result = false;
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = false;
        }
        return $result;
    }

    public function listar_periodo_cargo_persona($id){
        try{
            $fecha_actual = date('Y-m-d');
            $sql = "select * from periodo_laboral p inner join tipocargo t on p.id_cargo=t.id_cargo inner join personas pe 
                    on p.id_persona = pe.id_persona where ? between periodo_fechainicio and periodo_fechafin and p.id_persona = ? limit 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_actual,$id]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_periodos_persona_ultimo($id_persona){
        try{
            $sql = "select * from periodo_laboral p inner join tipocontrato t on t.id_contrato = p.id_contrato inner join tipocargo tc on tc.id_cargo = p.id_cargo inner join 
                    tipodepartamento tp on tc.id_departamento = tp.id_departamento inner join empresa e on e.id_empresa = p.id_empresa 
                    where p.id_persona = ? order by p.periodo_fechainicio desc limit 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_persona]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function eliminar_periodo($id){
        try{
            $sql = "delete from periodo_laboral where id_periodo = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function guardar_departamento($departamento_nombre){
        try{
            $sql = "insert into tipodepartamento (departamento_nombre) values (?) ";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $departamento_nombre
            ]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function guardar_cargo($id_departamento,$cargo_nombre){
        try{
            $sql = "insert into tipocargo (id_departamento, cargo_nombre) values (?,?) ";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $id_departamento,
                $cargo_nombre
            ]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function eliminar_departamento($id){
        try{
            $sql = "delete from tipodepartamento where id_departamento = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function eliminar_cargo($id){
        try{
            $sql = "delete from tipocargo where id_cargo = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function guardar_turno_x_persona($model){
        try{
            $sql = 'insert into persona_turno (id_persona, id_turno, persona_turno_fecha_registro, persona_estado_turno) values (?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_persona,
                $model->id_turno,
                $model->persona_turno_fecha_registro,
                $model->persona_estado_turno
            ]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function guardar_turno_x_persona_actualizar($model){
        try{
            $sql = 'update persona_turno set 
                         id_turno = ?
                         where id_persona = ? and persona_estado_turno = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_turno,
                $model->id_persona
            ]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function actualizar_estado($id_persona){
        try {
            $sql = "update persona_turno set
                persona_estado_turno = 0
                where id_persona = ? ";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $id_persona
            ]);
            $result = 1;
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function consultar_turno($id_persona){
        try{
            $sql = 'select * from persona_turno where id_persona = ? and persona_estado_turno = 1 limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_persona]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_busqueda_persona_periodo($parametro)
    {
        try {
            $sql = "select * from personas p inner join periodo_laboral pl on p.id_persona = pl.id_persona where (p.persona_nombre like ? or p.persona_apellido_paterno like ? or p.persona_dni like ?) and p.persona_estado = 1
                    order by p.persona_apellido_paterno, p.persona_apellido_materno asc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute(['%' . $parametro . '%', '%' . $parametro . '%', '%' . $parametro . '%']);
            $result = $stm->fetchAll();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_turno($id){
        try{
            $sql = 'select * from personas p inner join persona_turno pt on p.id_persona = pt.id_persona inner join turno t on pt.id_turno = t.id_turno
                    where t.id_turno = ? and persona_estado_turno = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function actualizar_horas($id_persona_turno,$asistencia_horas,$fecha_elegida){
        try {
            $sql = "update asistencia set
                asistencia_horas = ?
                where id_persona_turno = ? and asistencia_fecha = ?";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $asistencia_horas,
                $id_persona_turno,
                $fecha_elegida
            ]);
            $result = 1;
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function jalar_horas($id){
        try{
            $sql = 'select sum(asistencia_horas) suma from asistencia where id_persona_turno = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function agregar_turnos($model){
        try{
            $sql = 'insert into turno (turno_nombre, turno_hora_entrada, turno_hora_tolerancia, turno_hora_salida, turno_estado, 
                    turno_fecha_registro,turno_usuario_registro) values (?,?,?,?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->turno_nombre,
                $model->turno_hora_entrada,
                $model->turno_hora_tolerancia,
                $model->turno_hora_salida,
                $model->turno_estado,
                $model->turno_fecha_registro,
                $model->turno_usuario_registro
            ]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function agregar_turnos_editado($model){
        try{
            $sql = 'update turno set
                turno_nombre = ?, turno_hora_entrada = ?, turno_hora_tolerancia = ?, turno_hora_salida = ?, turno_usuario_registro = ?
                where id_turno = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->turno_nombre,
                $model->turno_hora_entrada,
                $model->turno_hora_tolerancia,
                $model->turno_hora_salida,
                $model->turno_usuario_registro,
                $model->id_turno
            ]);
            $result = 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function buscar_registro($fecha_hoy, $dni){
        try{
            $sql = 'select * from asistencia a inner join persona_turno pt on a.id_persona_turno = pt.id_persona_turno inner join personas p on pt.id_persona = p.id_persona
                    where date(asistencia_fecha) = ? and p.persona_dni = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_hoy,$dni]);
            $result = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

}