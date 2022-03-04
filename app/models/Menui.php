<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 10/10/2020
 * Time: 0:38
 */
class Menui{
    private $pdo;
    private $log;
    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }
    //Consultamos si el rol especificado tiene permisos para acceder al menu(controlador) y opcion consultada
    public function verificar_permiso_usuario($id_rol, $controlador, $opcion){
        //1 = habilitado, 0 = deshabilitado
        try{
            //Validamos la opcion y el rol según el controlador
            $sql = "select m.menu_estado, o.id_opcion, o.opcion_estado from roles r inner join roles_menus rl on r.id_rol = rl.id_rol inner join menus m on rl.id_menu = m.id_menu inner join opciones o on m.id_menu = o.id_menu where rl.id_rol = ? and m.menu_controlador = ? and o.opcion_funcion = ? and m.menu_estado = 1 and o.opcion_estado = 1 and r.rol_estado = 1 limit 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_rol, $controlador, $opcion]);
            $result = $stm->fetch();
            if(isset($result->opcion_estado) && $result->opcion_estado == 1){
                //Validamos si hay restriccion de acceso para el rol
                $sqlr = "select id_restriccion from restricciones where id_rol = ? and id_opcion = ?";
                $stmr = $this->pdo->prepare($sqlr);
                $stmr->execute([$id_rol, $result->id_opcion]);
                $resultr = $stmr->fetch();
                //Si no esta declarado id_restriccion, quiere decir que no hay restricción para el usuario
                if(!isset($resultr->id_restriccion)){
                    return 1;
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 0;
        }
    }
    //Consultamos si el rol especificado tiene permisos para acceder al menu(controlador) y permiso
    public function verificar_permiso_usuario_api($id_rol, $controlador, $permiso){
        try{
            $sql = "select m.menu_estado, o.opcion_estado, o.id_opcion, p.permiso_estado from roles r inner join roles_menus rl on r.id_rol = rl.id_rol inner join menus m on rl.id_menu = m.id_menu inner join opciones o on m.id_menu = o.id_menu inner join permisos p on o.id_opcion = p.id_opcion where rl.id_rol = ? and m.menu_controlador = ? and p.permiso_accion = ? and m.menu_estado = 1 and o.opcion_estado = 1 and p.permiso_estado = 1 and r.rol_estado = 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_rol, $controlador, $permiso]);
            $result = $stm->fetchAll();
            //Si $result es mayor a 0, quiere decir que hay opciones con acceso a verificar
            if(count($result) > 0) {
                //Listamos las restricciones por rol
                $restricciones = $this->listar_restricciones($id_rol);
                $bloqueos = 0;
                //Si el rol tiene restricciones de opciones, procedemos a evaluar cada restriccion con cada opcion
                foreach ($restricciones as $r){
                    foreach ($result as $m){
                        //Si la opcion y restriccion coinciden en alguna de las busquedas, se aumenta la variable de $bloqueos
                        if($m->id_opcion == $r->id_opcion){
                            $bloqueos++;
                        }
                    }
                }
                //Si $bloqueos es igual a la cantidad de opciones, quiere decir que el rol del usuario no puede acceder
                //a ese permiso y por lo tanto se le niega la función
                if($bloqueos >= count($result)){
                    return 0;
                } else {
                    return 1;
                }
            } else {
                return 0;
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 0;
        }
    }
    //Lista las restricciones de rol por usuario
    function listar_restricciones($id_rol){
        try{
            $sql = "select id_opcion from restricciones where id_rol = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_rol]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
}
