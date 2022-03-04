



<div class="modal fade" id="agregarproducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 60% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="agregar">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="persona">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Receta</label>
                                        <select class="form-control" id= "id_receta" name="id_receta" onchange="selec_receta()">
                                            <option value="">Elegir Receta</option>
                                            <?php
                                            foreach($receta as $r){
                                                ?>
                                                <option value="<?php echo $r->id_receta;?>"><?php echo $r->receta_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Grupo</label>
                                        <select class="form-control" id= "id_grupo" name="id_grupo">
                                            <option value="">Elegir Grupo</option>
                                            <?php
                                            foreach($grupo as $g){
                                                ?>
                                                <option value="<?php echo $g->id_grupo;?>"><?php echo $g->grupo_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Categoria</label>
                                        <select class="form-control" id= "id_producto_familia" name="id_producto_familia">
                                            <option value="">Elegir Categoria</option>
                                            <?php
                                            foreach($familia as $g){
                                                ?>
                                                <option value="<?php echo $g->id_producto_familia;?>"><?php echo $g->producto_familia_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre</label>
                                        <input class="form-control" type="text" id="producto_nombre" name="producto_nombre" placeholder="Ingrese Nombre  ...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Precio Venta</label>
                                        <input class="form-control" type="text" id="producto_precio_venta" name="producto_precio_venta" value="" placeholder="Ingrese Precio...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Unidad de medida: </label>
                                        <select id="id_medida" name="id_medida" class="form-control">
                                            <?php
                                            foreach($unidad_medida as $um){
                                                ?>
                                                <option value="<?php echo $um->id_medida;?>" <?= ($um->id_medida == 59)? 'selected':'';?>><?php echo $um->medida_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="tipo_afectacion">Tipo de Afectación</label><br>
                                        <select class="form-control" id="tipo_afectacion" name="tipo_afectacion">
                                            <?php
                                            foreach ($tipo_afectacion as $ig){
                                                ?>
                                                <option <?php echo ($ig->codigo == 20) ? 'selected' : '';?> value="<?php echo $ig->codigo;?>"><?php echo $ig->descripcion;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Descripción</label>
                                        <textarea rows="3" class="form-control" type="text" id="producto_descripcion" name="producto_descripcion" maxlength="500" placeholder="Ingrese Diagnostico..."></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Foto</label>
                                        <input class="form-control" type="file" id="producto_foto" name="producto_foto" maxlength="30" placeholder="Ingrese Foto...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="limpiar()" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-agregar-servicio"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="agregarfamilia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 50% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Categoria Carta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid"
                <div id="familia">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">Nombre:</label>
                                <input class="form-control" type="text" id="producto_familia_nombre" name="producto_familia_nombre" maxlength="200" placeholder="Ingrese Datos...">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" style="margin-top: 38px">
                                <button class="btn btn-success" onclick="guardar_familia()" ><i class="fa fa-save"></i> Guardar</button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h4>Listado de Categorias de la Carta</h4></div>
                        <div class="col-lg-12">
                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="text-capitalize">
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre Categoria</th>
                                                <th>Acción</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $a = 1;
                                            foreach ($familia as $m){
                                                ?>
                                                <tr>
                                                    <td><?= $a;?></td>
                                                    <td><?= $m->producto_familia_nombre;?></td>
                                                    <td>
                                                        <a onclick="preguntar('¿Esta Seguro que desea Eliminar esta Familia?','eliminar_familia','SÍ','NO',<?= $m->id_producto_familia?>)" style="color: red" data-toggle='tooltip' title='Eliminar'><i class='fa fa-times eliminar margen'></i></a>
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
    </div>
</div>

<div class="modal fade" id="editarproducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 40% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="editar">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="producto">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Receta</label>
                                        <select class="form-control" id= "id_receta_e" name="id_receta_e">
                                            <option value="">Elegir Receta</option>
                                            <?php
                                            foreach($receta as $r){
                                                ?>
                                                <option value="<?php echo $r->id_receta;?>"><?php echo $r->receta_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Grupo</label>
                                        <select class="form-control" id= "id_grupo_e" name="id_grupo_e">
                                            <option value="">Elegir Grupo</option>
                                            <?php
                                            foreach($grupo as $g){
                                                ?>
                                                <option value="<?php echo $g->id_grupo;?>"><?php echo $g->grupo_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Categoria</label>
                                        <select class="form-control" id= "id_producto_familia_e" name="id_producto_familia_e">
                                            <option value="">Elegir Categoria</option>
                                            <?php
                                            foreach($familia as $g){
                                                ?>
                                                <option value="<?php echo $g->id_producto_familia;?>"><?php echo $g->producto_familia_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre</label>
                                        <input class="form-control" type="text" id="producto_nombre_e" name="producto_nombre_e" placeholder="Ingrese Nombre  ...">
                                        <input type="hidden" id="id_producto" name="id_producto">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Unidad de medida: </label>
                                        <select id="id_medida_e" name="id_medida_e" class="form-control">
                                            <?php
                                            foreach($unidad_medida as $um){
                                                ?>
                                                <option value="<?php echo $um->id_medida;?>" ><?php echo $um->medida_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="tipo_afectacion_e">Tipo de Afectación</label><br>
                                        <select class="form-control" id="tipo_afectacion_e" name="tipo_afectacion_e">
                                            <?php
                                            foreach ($tipo_afectacion as $ig){
                                                ?>
                                                <option value="<?php echo $ig->codigo;?>"><?php echo $ig->descripcion;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Descripción</label>
                                        <textarea rows="3" class="form-control" type="text" id="producto_descripcion_e" name="producto_descripcion_e" maxlength="500" placeholder="Ingrese Diagnostico..."></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Foto Actual</label><br>
                                    <img src="" width="80" id="fotito_actual">
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Cambiar foto</label>
                                        <input class="form-control" type="file" id="producto_foto_e" name="producto_foto_e" placeholder="Ingrese Foto...">
                                    </div>
                                </div>
                            </div>
                            <br>
                                <div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h2>Precios de Venta</h2></div>
                                <div class="row">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Agregar precio</label>
                                            <input class="form-control" type="text" id="producto_precio_venta_a" name="producto_precio_venta_a" value="">
                                        </div>
                                    </div>
                                    <div class="col-lg-3" style="margin-top: 11px">
                                        <br><button class="btn btn-success" onclick="agregar_precios()"><i class="fa fa-save"></i> Agregar</button>
                                    </div>
                                </div>
                                <div id="tabla" class="table-responsive">

                                </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="limpiar()" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-editar_producto"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="ver_general" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 80% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="text-align: center"><div id="nombre_"></div></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <ul class="nav nav-tabs nav-justified">
                            <li class="active"><a data-toggle="tab" href="#ventas"><i class="fa fa-bar-chart"></i> Ventas</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div id="ventas" class="tab-pane fade in active show">
                    <div class="row">
                        <div class="col-sm-12 p-5">
                            <div id="detalle_ventas_"></div>
                            <div id="detalle_ventas" class="table-responsive"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="agregar_stock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 40% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <input type="hidden" id="id_receta_modal" name="id_receta_modal">
                        <div class="col-lg-12">
                            <h5><span id="nombre_producto_"></span></h5><br>
                        </div>

                        <div class="col-lg-6">
                            <input class="form-control" type="text" id="asignar_stock" name="asignar_stock" placeholder="Ingrese Cantidad...">
                        </div>
                        <div class="col-lg-3">
                            <button class="btn btn-success" onclick="sumar_stock()"><i class="fa fa-plus"></i>Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>
            <div class="row">
                <div class="col-lg-8 col-xs-4 col-md-4 col-sm-4"></div>
                <div class="col-lg-2 col-xs-4 col-md-4 col-sm-4">
                    <button data-toggle="modal" data-target="#agregarfamilia" class="btn btn-primary"><i class="fa fa-plus fa-sm text-white-50"></i> Gestionar Categorias</button>
                </div>
                <div class="col-lg-2 col-xs-4 col-md-4 col-sm-4">
                    <button data-toggle="modal" data-target="#agregarproducto" class="btn btn-primary"><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Producto</button>
                </div>
            </div>

            <form method="post" action="<?= _SERVER_ ?>Producto/gestionar">
                <input type="hidden" id="enviar_dato" name="enviar_dato" value="1">
                <div class="row">
                    <div class="col-lg-3 col-xs-6 col-md-6 col-sm-6">
                        <label for="">Por Categoria</label>
                        <select class="form-control" name="id_producto_familia" id="id_producto_familia">
                            <option value="">Seleccione...</option>
                            <?php
                            (isset($familia_))?$familiaa=$familia_->id_producto_familia:$familiaa=0;
                            foreach ($familia as $e){
                                ($e->id_producto_familia == $familiaa)?$sele='selected':$sele='';
                                ?>
                                <option value="<?= $e->id_producto_familia;?>" <?= $sele; ?>><?= $e->producto_familia_nombre;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-3 col-xs-6 col-md-6 col-sm-6">
                        <button style="margin-top: 34px;" class="btn btn-success" ><i class="fa fa-search"></i> Buscar</button>
                    </div>
                </div>
            </form>
            <br>

            <div class="row">
                <div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h2>Productos Registrados</h2></div>
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-earning" id="dataTable2" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Precio Venta</th>
                                        <th>Foto</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($producto as $ar){
                                        $estilo = "";
                                        $foto = _SERVER_ . 'media/producto/default.png';
                                        if($ar->producto_foto != ""){
                                            if(file_exists($ar->producto_foto)){
                                                $foto = _SERVER_ . $ar->producto_foto;
                                            }
                                        }
                                        if($ar->producto_estado == "0"){
                                            $estilo = "style=\"background-color: #FF6B70\"";
                                        }

                                        $validar_solo_una_receta = $this->producto->jalar_recurso_sede_desde_receta_todo($ar->id_receta);
                                        if(count($validar_solo_una_receta) == 1){
                                            $entr = true;
                                        }else{
                                            $entr = false;
                                        }
                                        ?>
                                        <tr <?= $estilo;?>>
                                            <td><?= $a;?></td>
                                            <td>
                                                <a style="color: blue; cursor: pointer;" class="button" data-toggle="modal" data-target="#ver_general" onclick="llenar_modal(<?= $ar->id_producto;?>)">
                                                <?= $ar->producto_nombre;?>
                                            </td>
                                            <td><?= $ar->producto_descripcion;?></td>
                                            <td><?= $ar->producto_precio_venta;?></td>
                                            <td><img class="rounded" src="<?= $foto;?>" alt="Foto de <?php echo $ar->producto_nombre;?>" width="120"></td>
                                            <td>
                                                <a class="btn btn-success" onclick="editar_producto(<?= $ar->id_producto?>,'<?= $ar->id_receta?>','<?= $ar->id_grupo?>','<?= $ar->id_producto_familia?>','<?= $ar->producto_nombre?>','<?= $ar->id_unidad_medida?>','<?= $ar->producto_precio_codigoafectacion?>','<?= $ar->producto_descripcion?>','<?= $ar->producto_precio_venta?>','<?= $ar->producto_foto?>')" data-target="#editarproducto" data-toggle="modal" title='Editar'><i class='fa fa-edit text-white editar margen'></i></a>
                                                <?php
                                                if($entr){ ?>
                                                    <a class="btn btn-primary" onclick="agregar_stock(<?= $ar->id_receta?>,'<?= $ar->producto_nombre?>')" data-target="#agregar_stock" data-toggle="modal" title='Agregar Stock'><i class='fa fa-plus text-white editar margen'></i></a>
                                                    <?php
                                                }
                                                if ($ar->producto_estado == 0) {
                                                    ?>
                                                    <a class="btn btn-success" onclick="preguntar('¿Esta seguro que quiere Habilitar este producto?','habilitar','Si','No',<?= $ar->id_producto ?>,1)" title='Habilitar producto'><i class='fa fa-check text-white editar margen'></i></a>

                                                    <?php
                                                }else{
                                                    ?>
                                                    <a class="btn btn-danger" onclick="preguntar('¿Esta seguro que quiere Deshabilitar este producto?','deshabilitar','Si','No',<?= $ar->id_producto ?>,0)" title='Deshabilitar producto'><i class='fa fa-trash text-white editar margen'></i></a>
                                                    <?php
                                                }
                                                ?>
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


<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>producto.js"></script>
<script>
    $(document).ready(function(){
        $("#id_receta").select2({
            dropdownParent: $("#agregarproducto")
        });
    })
    function agregar_stock(id,nombre){
        $("#id_receta_modal").val(id);
        $("#nombre_producto_").html(nombre);
    }
</script>
<script>
    function llenar_modal(id_producto){

        $.ajax({
            type: "POST",
            url: urlweb + "api/Producto/consultar_datos",
            data: "id_producto="+id_producto,
            dataType: 'json',
            success:function (r) {
                console.log(r.detalle_ventas);
                console.log(r.detalle_ventas_);
                $("#detalle_ventas").html(r.detalle_ventas);
                $("#detalle_ventas_").html(r.detalle_ventas_);
            }
        });
    }
    function selec_receta(){
        var receta = $("#id_receta option:selected").text();
        $('#producto_nombre').val(receta);
    }
</script>

<style>
    .nav-tabs.nav-justified {width: 100%;border-bottom: 0;}
    .panel .tabs {margin: 0;padding: 0; }
    .nav-tabs {background: #f2f3f2;border: 0; }
    .nav-tabs li a:hover {background: #fff; }
    .nav-tabs li a, .nav-tabs li a:hover, .nav-tabs li.active a, .nav-tabs li.active a:hover {border: 0;padding: 15px 20px; }
    .nav-tabs li.active a {color: #FFA233; }
    .nav-tabs li a {color: #999; }
    .nav-pills li a, .nav-pills li a:hover, .nav-pills li.active a, .nav-pills li.active a:hover {border: 0;padding: 7px 15px; }
    .nav-pills li.active a, .nav-pills li.active a:hover {background: #FFA233; }
    .tab-content {padding: 15px; }
    .nav>li>a {position: relative;display: block;padding: 10px 15px;}
    .nav-tabs.nav-justified>li {display: table-cell;width: 1%;}
    .nav-tabs.nav-justified>li {float: none;text-align: center;}
    .nav-tabs.nav-justified>li.active {background: white;}
    .nav>li {position: relative;display: block;}
    .nav {padding-left: 0;margin-bottom: 0;list-style: none;display: block !important;}
</style>
<script>
    (jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.tab");e||d.data("bs.tab",e=new c(this)),"string"==typeof b&&e[b]()})}var c=function(b){this.element=a(b)};c.VERSION="3.3.7",c.TRANSITION_DURATION=150,c.prototype.show=function(){var b=this.element,c=b.closest("ul:not(.dropdown-menu)"),d=b.data("target");if(d||(d=b.attr("href"),d=d&&d.replace(/.*(?=#[^\s]*$)/,"")),!b.parent("li").hasClass("active")){var e=c.find(".active:last a"),f=a.Event("hide.bs.tab",{relatedTarget:b[0]}),g=a.Event("show.bs.tab",{relatedTarget:e[0]});if(e.trigger(f),b.trigger(g),!g.isDefaultPrevented()&&!f.isDefaultPrevented()){var h=a(d);this.activate(b.closest("li"),c),this.activate(h,h.parent(),function(){e.trigger({type:"hidden.bs.tab",relatedTarget:b[0]}),b.trigger({type:"shown.bs.tab",relatedTarget:e[0]})})}}},c.prototype.activate=function(b,d,e){function f(){g.removeClass("active").find("> .dropdown-menu > .active").removeClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded",!1),b.addClass("active").find('[data-toggle="tab"]').attr("aria-expanded",!0),h?(b[0].offsetWidth,b.addClass("in")):b.removeClass("fade"),b.parent(".dropdown-menu").length&&b.closest("li.dropdown").addClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded",!0),e&&e()}var g=d.find("> .active"),h=e&&a.support.transition&&(g.length&&g.hasClass("fade")||!!d.find("> .fade").length);g.length&&h?g.one("bsTransitionEnd",f).emulateTransitionEnd(c.TRANSITION_DURATION):f(),g.removeClass("in")};var d=a.fn.tab;a.fn.tab=b,a.fn.tab.Constructor=c,a.fn.tab.noConflict=function(){return a.fn.tab=d,this};var e=function(c){c.preventDefault(),b.call(a(this),"show")};a(document).on("click.bs.tab.data-api",'[data-toggle="tab"]',e).on("click.bs.tab.data-api",'[data-toggle="pill"]',e)}
    (jQuery);
</script>