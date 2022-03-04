<?php
/**
 * Created by PhpStorm
 * User: Franz
 * Date: 17/03/2021
 * Time: 10:28
 */
?>

<!-- Modal Agregar Detalle_receta-->
<div class="modal fade" id="gestiondetalle_receta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Insumo a Receta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="gestionarInfoDetalle_receta">
                <input type="hidden" id="id_receta" name="id_receta" value="<?= $id;?>">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="detalle_receta">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Insumo:</label>
                                        <select id="id_recursos_sede" class="form-control" onchange="jalar_medida_precio()" name="id_recursos_sede">
                                            <option selected value="">Elegir Insumo</option>
                                            <?php
                                            foreach($recursos_sedes as $re){
                                                ?>
                                                <option value="<?php echo $re->id_recurso_sede;?>"><?php echo $re->recurso_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div id="mostrar_datos"></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="historia_proxima_cita_fecha_p"><b>¿Realizar Conversión?</b></label>
                                        <input type="checkbox" onchange="mostrar()" id="conversion_check" name="conversion_check">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group ver" style="display: none;">
                                        <label class="col-form-label">Conversiones</label>
                                        <div id="conversion"></div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="valor_conversion" name="valor_conversion"value="0">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Cantidad: </label>
                                        <input class="form-control" type="text" onblur="calcular_nuevo_precio()" onkeyup="validar_numeros_decimales_dos(this.id)" id="detalle_receta_cantidad" name="detalle_receta_cantidad" maxlength="100" placeholder="Ingrese Cantidad...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Precio: </label>
                                        <input class="form-control" readonly type="text" id="detalle_receta_precio" name="detalle_receta_precio" onkeyup="validar_numeros(this.id)" placeholder="Precio calculado...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-agregar-detalle_receta"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="subreceta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar/Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="agregar_sub_receta">
                <input type="hidden" id="receta_principal" name="receta_principal" value="<?= $id;?>">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="detalle_receta">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Recetas:</label>
                                        <select class="form-control" onchange="jalar_valor_preparacion()" id= "id_receta_" name="id_receta_">
                                            <option selected value="">Elegir Receta</option>
                                            <?php
                                            foreach($recetas as $r){
                                                ?>
                                                <option value="<?php echo $r->id_receta;?>"><?php echo $r->receta_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div id="valor_preparacion"></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                            <label class="col-form-label">Cantidad:</label>
                                        <input class="form-control" type="text" onblur="calcular_valor_preparacion()" id="sub_receta_cantidad" name="sub_receta_cantidad" onkeyup="validar_numeros_decimales_dos(this.id)">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Precio: </label>
                                        <input class="form-control" readonly type="text" id="sub_receta_total" name="sub_receta_total" onkeyup="validar_numeros(this.id)" placeholder="Precio calculado...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-agregar-detalle_receta"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Editar Detalle_receta-->
<div class="modal fade" id="editarDatosDetalle_receta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Editar Receta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="editarInformacionDetalle_receta">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="detalle_receta">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Insumo:</label>
                                        <select class="form-control" onchange="jalar_medida_precio_e()" id="id_recursos_sede_e" name="id_recursos_sede_e">
                                            <option value="">Elegir insumo</option>
                                            <?php
                                            foreach($recursos_sedes as $re){
                                                ?>
                                                <option value="<?php echo $re->id_recurso_sede;?>"><?php echo $re->recurso_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-12">
                                        <div id="mostrar_datos_e"></div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="historia_proxima_cita_fecha_p"><b>¿Realizar Conversión?</b></label>
                                            <input type="checkbox" onchange="mostrar_e()" id="conversion_check_e" name="conversion_check">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group ver" style="display: none;">
                                            <label class="col-form-label">Conversiones</label>
                                            <div id="conversion_e"></div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="valor_conversion_e" name="valor_conversion_e">
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Cantidad: </label>
                                        <input class="form-control" type="hidden" id="id_detalle_receta" name="id_detalle_receta" maxlength="11" readonly>
                                        <input class="form-control" type="hidden" id="id_receta_e" name="id_receta_e" maxlength="11" readonly>
                                        <input class="form-control" onblur="calcular_nuevo_precio_editar()" type="text" id="detalle_receta_cantidad_e" name="detalle_receta_cantidad_e" maxlength="100" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Precio: </label>
                                        <input class="form-control" readonly type="text" id="detalle_receta_precio_e" name="detalle_receta_precio_e" maxlength="100" placeholder="Ingrese Precio...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-editar-detalle_receta"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--begin-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
            </div>
            <!-- /.row (main row) -->
            <div class="row">
                <div class="col-lg-2">
                    <button data-toggle="modal" data-target="#gestiondetalle_receta" onclick="" class="btn btn-primary shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Insumo</button>
                </div>
                <div class="col-lg-2">
                    <button data-toggle="modal" data-target="#subreceta" class="btn btn-success"><i class="fa fa-save"></i> Agregar Sub Receta</button>
                </div>
                <div class="col-lg-7"></div>

            </div>
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h4 class="m-0">Lista de insumos de la receta "<?= $data_receta->receta_nombre; ?>" // Total de la preparación: <?= $total_todo;?></h4>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-earning" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>ID</th>
                                        <th>Insumo</th>
                                        <th>Cantidad</th>
                                        <th>Unidad de Medida</th>
                                        <th>Precio</th>
                                        <th>Estado</th>
                                        <th>Accion</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($detalle_recetas as $m){

                                        if($m->detalle_receta_unidad_medida!=0){
                                            $medi=$this->receta->listar_detalle_recetas_conversion($m->id_detalle_receta);
                                            $med=$medi->medida_nombre;
                                        }else{
                                            $med=$m->medida_nombre;
                                        }
                                        $estado = "DESHABILITADO";
                                        $estilo_estado = "class=\"texto-deshabilitado\"";
                                        if($m->detalle_receta_estado == 1){
                                            $estado = "HABILITADO";
                                            $estilo_estado = "class=\"texto-habilitado\"";
                                        }
                                        ?>
                                        <tr>
                                            <td><?= $a;?></td>
                                            <td id="id_recursos_sede<?= $m->id_recursos_sede;?>"><strong><?= $m->recurso_nombre;?></strong></td>
                                            <td id="detalle_recetacantidad<?= $m->id_detalle_receta;?>"><?= $m->detalle_receta_cantidad;?></td>
                                            <td id="detalle_recetaunidad<?= $m->id_detalle_receta;?>"><?= $med;?></td>
                                            <td><?= $m->detalle_receta_precio;?></td>
                                            <td <?=$estilo_estado;?> id="detalle_recetaestado<?= $m->id_detalle_receta?>"><?= $estado;?></td>
                                            <td>
                                                <div id="botondetalle_receta<?= $m->id_detalle_receta;?>">
                                                    <button data-toggle="modal" data-target="#editarDatosDetalle_receta" onclick="editar_detalle_receta(<?= $m->id_detalle_receta;?>,'<?= $m->id_receta;?>',<?= $m->id_recursos_sede;?>,'<?= $m->detalle_receta_cantidad;?>','<?= $m->detalle_receta_precio;?>','<?= $m->detalle_receta_estado;?>')" class="btn btn-sm btn-info btne" ><i class="fa fa-pencil"></i></button>
                                                </div>
                                                <button id="btn-eliminardetalle_receta<?= $m->id_detalle_receta;?>" class="btn btn-sm btn-secondary btn-danger" onclick="preguntar('¿Está seguro que desea eliminar esta detalle receta?','eliminar_detalle_receta','Si','No',<?= $m->id_detalle_receta;?>)"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        <?php
                                        $a++;
                                    }
                                    foreach ($subrecetas as $m){

                                        $estado = "DESHABILITADO";
                                        $estilo_estado = "class=\"texto-deshabilitado\"";
                                        if($m->sub_receta_estado == 1){
                                            $estado = "HABILITADO";
                                            $estilo_estado = "class=\"texto-habilitado\"";
                                        }
                                            ?>
                                    <tr>
                                        <td><?= $a;?></td>
                                        <td><strong><?= $m->receta_nombre;?></strong></td>
                                        <td><?= $m->sub_receta_cantidad;?></td>
                                        <td><?= $m->medida_nombre;?></td>
                                        <td><?= $m->sub_receta_total;?></td>
                                        <td <?=$estilo_estado;?> id="detalle_recetaestado<?= $m->id_sub_receta?>"><?= $estado;?></td>
                                        <td>
                                            <div id="botondetalle_receta<?= $m->id_sub_receta;?>">
                                                <!--<button data-toggle="modal" data-target="#editarDatosDetalle_receta" onclick="editar_sub_receta(<?= $m->id_detalle_receta;?>,'<?= $m->id_receta;?>',<?= $m->id_recursos_sede;?>,'<?= $m->detalle_receta_cantidad;?>','<?= $m->detalle_receta_precio;?>','<?= $m->detalle_receta_estado;?>')" class="btn btn-sm btn-info btne" ><i class="fa fa-pencil"></i></button>-->
                                            </div>
                                            <button id="btn-eliminarsub_receta<?= $m->id_sub_receta;?>" class="btn btn-sm btn-secondary btn-danger" onclick="preguntar('¿Está seguro que desea eliminar esta detalle receta?','eliminar_sub_receta','Si','No',<?= $m->id_sub_receta;?>)"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php
                                    $a++;
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>receta.js"></script>

<script type="text/javascript">
    $(document).ready(function (){
        $("#id_recursos_sede").select2({
            dropdownParent: $("#gestiondetalle_receta")
        });
        $("#id_receta_").select2({
            dropdownParent: $("#subreceta")
        });
        /*$("#id_recursos_sede_e").select2({
            dropdownParent: $("#editarDatosDetalle_receta")
        });*/
    });


    function mostrar() {
        if(document.getElementById("conversion_check").checked===true){
        $(".ver").show();
        }else{
            $(".ver").hide();
        }
    }
    function mostrar_e() {
        if(document.getElementById("conversion_check_e").checked===true){
            $(".ver").show();
        }else{
            $(".ver").hide();
        }
    }

</script>
