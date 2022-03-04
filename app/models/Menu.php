<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 19/10/2020
 * Time: 20:01
 */
class Menu{
    private $pdo;
    private $log;
    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }
    //Listamos todos los menus creados en el sistema
    public function listar_menus(){
        try{
            $sql = 'select * from menus';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    //Listamos los datos del menú según el id enviado
    public function listar_menu($id_menu){
        try{
            $sql = 'select * from menus where id_menu = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_menu]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    //Listamos las opciones de un menú en especifico
    public function listar_opciones($id_menu){
        try{
            $sql = 'select * from opciones where id_menu = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_menu]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    //Busca si existe un menu con el mismo controlador
    public function buscar_menu_controlador($menu_controlador){
        try{
            $sql = 'select id_menu from menus where menu_controlador = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$menu_controlador]);
            $result = $stm->fetch();
            if(isset($result->id_menu)){
                return true;
            } else {
                return false;
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    //Busca si existe una opcion repetida en el menu
    public function buscar_opcion_menu($id_menu, $opcion_funcion){
        try{
            $sql = 'select id_opcion from opciones where id_menu = ? and opcion_funcion = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_menu, $opcion_funcion]);
            $result = $stm->fetch();
            if(isset($result->id_opcion)){
                return true;
            } else {
                return false;
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    //Busca si existe un permiso repetido en la opción
    public function buscar_permiso_opcion($id_opcion, $permiso_accion){
        try{
            $sql = 'select id_permiso from permisos where id_opcion = ? and permiso_accion = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_opcion, $permiso_accion]);
            $result = $stm->fetch();
            if(isset($result->id_permiso)){
                return true;
            } else {
                return false;
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    //Busca la relacion entre el rol y el menu
    public function buscar_relacion_rol_menu($id_rol, $id_menu){
        try{
            $sql = 'select id_rol_menu from roles_menus where id_rol = ? and id_menu = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_rol, $id_menu]);
            $relacion = $stm->fetch();
            return isset($relacion->id_rol_menu);
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return false;
        }
    }
    //Busca la restricción entre la opcion y el rol
    public function buscar_restriccion_rol_opcion($id_rol, $id_opcion){
        try{
            $sql = 'select id_restriccion from restricciones where id_rol = ? and id_opcion = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_rol, $id_opcion]);
            $relacion = $stm->fetch();
            return isset($relacion->id_restriccion);
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return false;
        }
    }
    //Agrega la relacion entre el rol y el menu
    public function agregar_relacion($id_rol, $id_menu){
        try{
            $sql = 'insert into roles_menus (id_rol, id_menu) values (?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_rol, $id_menu]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }
    //Eliminar la relacion entre el rol y el menu
    public function eliminar_relacion($id_rol, $id_menu){
        try{
            $sql = 'delete from roles_menus where id_rol = ? and id_menu = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_rol, $id_menu]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }
    //Agrega la restriccion entre el rol y la opcion
    public function agregar_restriccion($id_rol, $id_opcion){
        try{
            $sql = 'insert into restricciones (id_rol, id_opcion) values (?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_rol, $id_opcion]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }
    //Eliminar la restriccion entre el rol y la opcion
    public function eliminar_restriccion($id_rol, $id_opcion){
        try{
            $sql = 'delete from restricciones where id_rol = ? and id_opcion = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_rol, $id_opcion]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }
    //Lista la opcion según el id consultado
    public function listar_opcion($id_opcion){
        try{
            $sql = 'select * from opciones where id_opcion = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_opcion]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    //Lista los permisos creados por opcion
    public function listar_permisos($id_opcion){
        try{
            $sql = 'select * from permisos where id_opcion = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_opcion]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    //Eliminar permiso
    public function eliminar_permiso($id_permiso){
        try{
            $sql = 'delete from permisos where id_permiso = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_permiso]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }
    //Funcion para guardar los menus creados o editarlos
    public function guardar_menu($model){
        try{
            if(isset($model->id_menu)){
                $sql = 'update menus set
                        menu_nombre = ?,
                        menu_controlador = ?,
                        menu_icono = ?,
                        menu_orden = ?,
                        menu_mostrar = ?,
                        menu_estado = ?
                        where id_menu = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->menu_nombre,
                    $model->menu_controlador,
                    $model->menu_icono,
                    $model->menu_orden,
                    $model->menu_mostrar,
                    $model->menu_estado,
                    $model->id_menu
                ]);
            } else {
                $sql = 'insert into menus (menu_nombre, menu_controlador, menu_icono, menu_orden, menu_mostrar, menu_estado) values (?,?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->menu_nombre,
                    $model->menu_controlador,
                    $model->menu_icono,
                    $model->menu_orden,
                    $model->menu_mostrar,
                    $model->menu_estado
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }
    //Funcion para guardar las opciones creadas o editarlas
    public function guardar_opcion($model){
        try{
            if(isset($model->id_opcion)){
                $sql = 'update opciones
                set 
                opcion_nombre = ?,
                opcion_funcion = ?,
                opcion_icono = ?,
                opcion_mostrar = ?,
                opcion_orden = ?,
                opcion_estado = ?
                where id_opcion = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->opcion_nombre,
                    $model->opcion_funcion,
                    $model->opcion_icono,
                    $model->opcion_mostrar,
                    $model->opcion_orden,
                    $model->opcion_estado,
                    $model->id_opcion
                ]);
            } else {
                $sql = 'insert into opciones (id_menu, opcion_nombre, opcion_funcion, opcion_icono, opcion_mostrar, opcion_orden, opcion_estado) values (?,?,?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_menu,
                    $model->opcion_nombre,
                    $model->opcion_funcion,
                    $model->opcion_icono,
                    $model->opcion_mostrar,
                    $model->opcion_orden,
                    $model->opcion_estado
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }
    //Funcion para guardar los permisos creados o editarlos
    public function guardar_permiso($model){
        try{
            if(isset($model->id_permiso)){
                $sql = 'update permisos
                set 
                permiso_accion = ?,
                permiso_estado = ?
                where id_permiso = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->permiso_accion,
                    $model->permiso_estado,
                    $model->id_permiso
                ]);
            } else {
                $sql = 'insert into permisos (id_opcion, permiso_accion, permiso_estado) values (?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_opcion,
                    $model->permiso_accion,
                    $model->permiso_estado
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }
}
