<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 10/10/2020
 * Time: 0:45
 */
class Navbar{
    private $pdo;
    private $log;
    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }
    //Listar Los Menus Disponibles por Rol
    public function listar_menus($id_rol){
        $result = [];
        try{
            $sql = "select m.id_menu, m.menu_nombre, m.menu_controlador, m.menu_icono from roles r inner join roles_menus rm on r.id_rol = rm.id_rol inner join menus m on rm.id_menu = m.id_menu where r.id_rol = ? and m.menu_estado = 1 and m.menu_mostrar = 1 order by m.menu_orden asc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_rol]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
        }
        return $result;

    }
    //Listar las opciones del menú
    public function listar_opciones($id_menu){
        try{
            $sql = "select o.id_opcion, o.opcion_nombre, o.opcion_funcion from menus m inner join opciones o on m.id_menu = o.id_menu where m.id_menu = ? and o.opcion_estado = 1 and o.opcion_mostrar = 1 order by o.opcion_orden asc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_menu]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;

    }
    //Lista las restricciones de rol por usuario
    public function listar_restricciones($id_rol){
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
    //Listar el Nombre de la Funcion
    public function listar_nombre_opcion($menu_nombre, $opcion_funcion){
        try{
            $sql = "select o.opcion_nombre from menus m inner join opciones o on m.id_menu = o.id_menu where m.menu_nombre = ? and o.opcion_funcion = ? limit 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$menu_nombre, $opcion_funcion]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;

    }
}
