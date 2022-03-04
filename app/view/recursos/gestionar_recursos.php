

<div class="modal fade" id="recursos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 67% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Asignar Recurso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div id="categoria">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-form-label">Sucursal</label>
                                    <select class="form-control" onchange="jalar_categorias()" id= "id_sucursal" name="id_sucursal">
                                        <option value="">Seleccionar Negocio</option>
                                        <?php
                                        foreach($sucursal as $n){
                                            ?>
                                            <option value="<?php echo $n->id_sucursal;?>"><?php echo $n->sucursal_nombre;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-form-label">Categoria</label>
                                    <div id="datos_categoria"></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-form-label">Recurso</label>
                                    <div id="datos_recurso"></div>
                                    <input type="text" id="recurso_nombre" name="recurso_nombre" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-form-label">U. de medida: </label>
                                    <select id="id_medida" name="id_medida" class="form-control">
                                        <?php
                                        foreach($unidad_medida as $um){
                                            ($um->id_medida == 59)?$selec='selected':$selec='';
                                            ?>
                                            <option value="<?php echo $um->id_medida;?>" <?= $selec?>><?php echo $um->medida_nombre;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-2" id="fu">
                                <div class="form-group">
                                    <label for="">Factor Unidad</label>
                                    <input type="text" class="form-control" onblur="llenar_peso_inicial(this.value)" id="recurso_sede_factor_unidad" value="1" name="recurso_sede_factor_unidad">
                                </div>
                            </div>
                            <div class="col-lg-2" id="c">
                                <div class="form-group">
                                    <label for="">Cantidad</label>
                                    <input type="text" class="form-control" onchange="calcular_stock()" id="recurso_sede_cantidad" name="recurso_sede_cantidad">
                                </div>
                            </div>
                            <div class="col-lg-2" id="si">
                                <div class="form-group">
                                    <label class="col-form-label">Stock Inicial: </label>
                                    <input class="form-control" type="text" id="recurso_sede_stock" name="recurso_sede_stock" onkeyup="validar_numeros_decimales_dos(this.id)" placeholder="Stock Inicial...">
                                </div>
                            </div>
                            <div class="col-lg-2" id="sm">
                                <div class="form-group">
                                    <label class="col-form-label">Stock Minimo: </label>
                                    <input class="form-control" type="text" id="recurso_sede_stock_minimo" name="recurso_sede_stock_minimo" onkeyup="validar_numeros_decimales_dos(this.id)" placeholder="Stock Minimo...">
                                </div>
                            </div>
                            <div class="col-lg-2" id="u">
                                <div class="form-group">
                                    <label for="">P. Unitario</label>
                                    <input type="text" class="form-control" id="recurso_sede_precio_unit" onchange="calcular_precio()" name="recurso_sede_precio_unit" onkeyup="validar_numeros_decimales_dos(this.id)">
                                </div>
                            </div>
                            <div class="col-lg-2" id="t">
                                <div class="form-group">
                                    <label for="">P. Total</label>
                                    <input type="text" class="form-control" id="recurso_sede_precio_total" name="recruso_sede_precio_total" onkeyup="validar_numeros_decimales_dos(this.id)">
                                </div>
                            </div>
                            <div class="col-lg-2" id="tr">
                                <div class="form-group">
                                    <label for="historia_proxima_cita_fecha_p"><b>¿Tiene Rendimiento?</b></label>
                                    <input type="checkbox" onchange="mostrar_merma()" id="conversion_check" name="conversion_check">
                                </div>
                            </div>
                            <div class="col-lg-2" id="ini">
                                <div class="form-group">
                                    <label for="">Peso Inicial</label>
                                    <input type="text" class="form-control" id="recurso_sede_peso_inicial" name="recurso_sede_peso_inicial">
                                </div>
                            </div>
                            <div class="col-lg-2" id="fin">
                                <div class="form-group">
                                    <label for="">Peso Final</label>
                                    <input type="text" class="form-control" onchange="calcular_peso_merma()" id="recurso_sede_peso_final" name="recurso_sede_peso_final">
                                </div>
                            </div>
                            <div class="col-lg-2" id="rend">
                                <div class="form-group">
                                    <label for="">Rendimiento %</label>
                                    <input type="text" class="form-control" onchange="calcular_valor_merma()" id="recurso_sede_merma" name="recurso_sede_merma">
                                </div>
                            </div>
                            <div class="col-lg-2" id="pp">
                                <div class="form-group">
                                    <label class="col-form-label">Precio Procesado: </label>
                                    <input class="form-control" type="text" id="recurso_sede_precio" name="recurso_sede_precio" onkeyup="validar_numeros_decimales_dos(this.id)" placeholder="Ingrese Precio...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="btn-agregar-recursos" onclick="guardar()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editar_recurso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div id="categoria">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label">Recursos</label>
                                        <input type="text" class="form-control" id="id_recurso_e" name="id_recurso_e" readonly>
                                </div>
                            </div>
                            <input type="hidden" id="id_recurso_sede" name="id_recurso_sede" value="">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Categoria</label>
                                    <select id="id_medida_e" name="id_medida_e" class="form-control">
                                        <?php
                                        foreach($categoria as $c){
                                            ?>
                                            <option value="<?php echo $c->id_categoria;?>"><?php echo $c->categoria_nombre;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="btn-editar-recursos" onclick="guardar()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editar_stock_minimo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Stock Minimo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div id="categoria">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for=""> Stock Minimo</label>
                                <input class="form-control" type="text" id="recurso_sede_stock_minimo_e" name="recurso_sede_stock_minimo_e" value="">
                            </div>
                            <input type="hidden" id="id_recurso_sede" name="id_recurso_sede" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="btn-editar-recursos" onclick="guardar_stock_minimo_actializado()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
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
            <!-- /.row (main row) -->
            <div class="row">
                <div class="col-lg-10"></div>
                <div class="col-lg-2">
                    <button data-toggle="modal" data-target="#recursos" class="btn btn-sm btn-primary shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Nuevo</button>
                </div>
            </div>

            <form method="post" action="<?= _SERVER_ ?>Almacen/recursos">
                <input type="hidden" id="enviar_dato" name="enviar_dato" value="1">
                <div class="row">
                    <div class="col-lg-3 col-xs-6 col-md-6 col-sm-6">
                        <label for="">Por Sede</label>
                        <select class="form-control" name="id_sucursal" id="id_sucursal">
                            <option value="">Seleccione...</option>
                            <?php
                            (isset($sucursal_))?$familiaa=$sucursal_->id_sucursal:$familiaa=0;
                            foreach ($sucursall as $e){
                                ($e->id_sucursal == $familiaa)?$sele='selected':$sele='';
                                ?>
                                <option value="<?= $e->id_sucursal;?>" <?= $sele; ?>><?= $e->sucursal_nombre;?></option>
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
                <div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h2> Recursos Asignados</h2></div>
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-earning" id="dataTable2" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>ID</th>
                                        <th>Sucursal</th>
                                        <th>Recurso</th>
                                        <th>Categoria</th>
                                        <th>Unidad de Medida</th>
                                        <th>Merma</th>
                                        <th>Precio Procesado</th>
                                        <th>Stock Actual</th>
                                        <th>Stock Minimo</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($recurso_sede as $ar){
                                        $stock_actual = $ar->recurso_sede_stock;
                                        $stock_minimo = $ar->recurso_sede_stock_minimo;

                                        $estilo = "";
                                        $estilo_ = "";
                                        if($ar->negocio_estado == "0"){
                                            $estilo = "style=\"background-color: #FF6B70\"";
                                        }
                                        if($stock_actual <= $stock_minimo){
                                            $estilo_ = "style=\"background-color: #FF6B70\"";
                                        }

                                        if($ar->recurso_sede_merma == Null){
                                            $merma = "No tiene Merma";
                                        }else{
                                            $merma = $ar->recurso_sede_merma.' %';
                                        }

                                        ?>
                                        <tr <?= $estilo;?>>
                                            <td><?= $a;?></td>
                                            <td><?= $ar->sucursal_nombre;?></td>
                                            <td><?= $ar->recurso_nombre;?></td>
                                            <td><?= $ar->categoria_nombre;?></td>
                                            <td><?= $ar->medida_nombre;?></td>
                                            <td><?= $merma;?></td>
                                            <td><?= $ar->recurso_sede_precio;?></td>
                                            <td <?= $estilo_;?>><?= $ar->recurso_sede_stock;?></td>
                                            <td><?= $ar->recurso_sede_stock_minimo;?></td>
                                            <td>
                                                <!--<button class="btn btn-success" data-toggle="modal" data-target="#editar_recurso" onclick="editar_recurso(<?= $ar->id_recurso_sede;?>,'<?= $ar->recurso_nombre?>','<?= $ar->id_medida;?>')"><i class="fa fa-edit"></i> Editar</button> -->
                                                <?php
                                                if ($ar->recurso_sede_estado == 0) {
                                                    ?>
                                                    <button class="btn btn-success" onclick="preguntar('¿Esta seguro que quiere Habilitar este recurso?','habilitar','Si','No',<?= $ar->id_recurso_sede ?>,1)" title='Cambiar Estado'><i class='fa fa-check editar margen'></i></button>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <button class="btn btn-danger" onclick="preguntar('¿Esta seguro que quiere eliminar este recurso?','deshabilitar','Si','No',<?= $ar->id_recurso_sede ?>,0)" title='Cambiar Estado'><i class='fa fa-trash editar margen'></i></button>
                                                    <button class="btn btn-success" data-toggle="modal" data-target="#editar_stock_minimo" onclick="editar_stock_minimo(<?= $ar->id_recurso_sede;?>,'<?= $ar->recurso_sede_stock_minimo;?>')"><i class="fa fa-edit"></i></button>
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
<script src="<?php echo _SERVER_ . _JS_;?>recursos.js"></script>

<script>
    $(document).ready(function(){
        $("#rend").hide();
        $("#ini").hide();
        $("#fin").hide();
        $("#fu").hide();
        $("#c").hide();
        $("#si").hide();
        $("#sm").hide();
        $("#u").hide();
        $("#t").hide();
        $("#tr").hide();
        $("#pp").hide();
    })

    function mostrar_merma() {
        if(document.getElementById("conversion_check").checked===true){
            $("#rend").show();
            $("#ini").show();
            $("#fin").show();
        }else{
            $("#rend").hide();
            $("#ini").hide();
            $("#fin").hide();
        }
    }

    function cambiar_condicion(){
        var id_categoria = $('#id_categoria').val();
        if(id_categoria == 6){
            $("#fu").show();
            $("#c").show();
            $("#si").show();
            $("#sm").show();
            $("#u").show();
            $("#t").show();
            $("#tr").show();
            $("#pp").show();
        }else{
            $("#fu").hide();
            $("#c").show();
            $("#si").show();
            $("#sm").hide();
            $("#u").show();
            $("#t").show();
            $("#tr").hide();
            $("#pp").hide();
        }
    }

    function elegir_ne(){
        var eleccion = $("#id_ne").val();
        if(eleccion == 1){
            $("#recurso_nombre").show();
            $("#datos_recurso").hide();
        }else{
            $("#recurso_nombre").hide();
            $("#datos_recurso").show();
        }
    }

    function calcular_stock(){
        var recurso_sede_factor_unidad = $("#recurso_sede_factor_unidad").val();
        var recurso_sede_cantidad = $("#recurso_sede_cantidad").val();
        var subtotal = recurso_sede_factor_unidad * recurso_sede_cantidad;
        var total = subtotal.toFixed(2);
        $("#recurso_sede_stock").val(total);
    }

    function calcular_precio(){
        var recurso_sede_cantidad = $("#recurso_sede_cantidad").val();
        var recurso_sede_precio_unit = $("#recurso_sede_precio_unit").val();
        var subtotal = recurso_sede_cantidad * recurso_sede_precio_unit;
        var total = subtotal.toFixed(2);
        $("#recurso_sede_precio_total").val(total);
        calcular_monto_por_unidad();
    }

    function calcular_monto_por_unidad(){
        var recurso_sede_factor_unidad = $("#recurso_sede_factor_unidad").val();
        var recurso_sede_precio_unit = $("#recurso_sede_precio_unit").val();
        var subtotal = recurso_sede_precio_unit / recurso_sede_factor_unidad;
        subtotal.toFixed(2);
        $("#recurso_sede_precio").val(subtotal.toFixed(2));
    }

    function calcular_valor_merma(){
        var recurso_sede_precio_unit = $("#recurso_sede_precio_unit").val();
        var recurso_sede_merma = $("#recurso_sede_merma").val();
        var merma = recurso_sede_merma / 100;
        var subtotal = recurso_sede_precio_unit / merma;
        $("#recurso_sede_precio_total").val(subtotal.toFixed(2));
    }

    function calcular_peso_merma(){
        var recurso_sede_peso_inicial = $("#recurso_sede_peso_inicial").val();
        var recurso_sede_peso_final = $("#recurso_sede_peso_final").val();

        var subtotal = recurso_sede_peso_final / recurso_sede_peso_inicial;
        var mermita = subtotal * 100;
        subtotal.toFixed(2);
        mermita.toFixed(2);
        $("#recurso_sede_merma").val(mermita.toFixed(2));
        calcular_valor_merma();
        calcular_nuevo_valor_merma();
    }
    function calcular_nuevo_valor_merma(){
        var recurso_sede_precio_total = $("#recurso_sede_precio_total").val();
        var recurso_sede_factor_unidad = $("#recurso_sede_factor_unidad").val();

        var calculito = recurso_sede_precio_total / recurso_sede_factor_unidad;
        calculito.toFixed(2);
        $("#recurso_sede_precio").val(calculito.toFixed(2));
    }

    function llenar_peso_inicial(valor){
        //var recurso_sede_factor_unidad = $("#recurso_sede_factor_unidad").val();
        $("#recurso_sede_peso_inicial").val(valor);
    }

</script>