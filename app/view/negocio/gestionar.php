


<div class="modal fade" id="negocio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Negocio Nuevo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="gestionarnegocio">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="persona">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Ciudad</label>
                                        <select class="form-control" id= "id_ciudad" name="id_ciudad">
                                            <option value="">Elegir ciudad</option>
                                            <?php
                                            foreach($listaciudad as $l){
                                                ?>
                                                <option value="<?php echo $l->id_ciudad;?>"><?php echo $l->ciudad_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">RUC</label>
                                        <input class="form-control" type="text" id="negocio_ruc" onkeyup="return validar_numeros(this.id)" name="negocio_ruc" maxlength="30" placeholder="Ingrese RUC...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre Negocio</label>
                                        <input class="form-control" type="text" id="negocio_nombre" onkeyup="" name="negocio_nombre" maxlength="200" placeholder="Ingrese Nombre...">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Dirección</label>
                                        <textarea rows="3" class="form-control" type="text" id="negocio_direccion" name="negocio_direccion" maxlength="200" placeholder="Ingrese Dirección..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Número de Teléfono</label>
                                        <input class="form-control" type="text" id="negocio_telefono" onkeyup="return validar_numeros(this.id)" name="negocio_telefono" maxlength="30" placeholder="Ingrese Telefono...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Foto</label>
                                        <input class="form-control" type="file" id="negocio_foto" name="negocio_foto" placeholder="Ingrese Foto...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="limpiar()" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-agregar-negocio"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="negocio_editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Negocio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="editar_negocio">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="persona">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Ciudad</label>
                                        <select class="form-control" id= "id_ciudad_e" name="id_ciudad_e">
                                            <option value="">Elegir ciudad</option>
                                            <?php
                                            foreach($listaciudad as $l){
                                                ?>
                                                <option value="<?php echo $l->id_ciudad;?>"><?php echo $l->ciudad_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">RUC</label>
                                        <input class="form-control" type="text" id="negocio_ruc_e" onkeyup="return validar_numeros(this.id)" name="negocio_ruc_e" maxlength="30" placeholder="Ingrese RUC...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre Negocio</label>
                                        <input type="hidden" id="id_negocio" name="id_negocio">
                                        <input class="form-control" type="text" id="negocio_nombre_e" onkeyup="" name="negocio_nombre_e" maxlength="200" placeholder="Ingrese Nombre...">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Dirección</label>
                                        <textarea rows="3" class="form-control" type="text" id="negocio_direccion_e" name="negocio_direccion_e" maxlength="200" placeholder="Ingrese Dirección..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Número de Teléfono</label>
                                        <input class="form-control" type="text" id="negocio_telefono_e" onkeyup="return validar_numeros(this.id)" name="negocio_telefono_e" maxlength="30" placeholder="Ingrese Telefono...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Foto</label>
                                        <input class="form-control" type="file" id="negocio_foto_e" name="negocio_foto_e" placeholder="Ingrese Foto...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="limpiar()" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-editar-negocio"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="container-fluid">
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>

            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <input required name="parametro" type="text" value="<?= $parametro;?>" class="form-control" id="parametro" placeholder="Buscar Negocio">
                        </div>
                        <div class="form-group col-lg-3">
                            <button type="submit" onclick="buscar_negocio()" class="btn btn-success" style="width: 80%"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                        <div class="form-group col-lg-3">
                            <button data-toggle="modal" data-target="#negocio" class="btn btn-primary"><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Nuevo</button>
                        </div>
                    </div>

            <?php
            if($datos){
                ?>
                <div class="row">
                    <div class="col-lg-12"><p>Resultados</p></div>
                    <div class="col-lg-12">
                        <!-- DataTales Example -->
                                <div class="table-responsive">
                                    <table class="table table-borderless table-striped table-earning" id="dataTable2" width="100%" cellspacing="0">
                                        <thead class="text-capitalize">
                                        <tr>
                                            <th>ID</th>
                                            <th>Negocio</th>
                                            <th>Ciudad</th>
                                            <th>Dirección</th>
                                            <th>RUC</th>
                                            <th>Teléfono</th>
                                            <th>Foto</th>
                                            <th>Acción</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $a = 1;
                                        foreach ($negocio as $ar){
                                            $estilo = "";
                                            $foto = _SERVER_ . 'media/negocio/default.png';
                                            if($ar->negocio_foto != ""){
                                                if(file_exists($ar->negocio_foto)){
                                                    $foto = _SERVER_ . $ar->negocio_foto;
                                                }
                                            }
                                            if($ar->negocio_estado == "0"){
                                                $estilo = "style=\"background-color: #FF6B70\"";
                                            }
                                            ?>
                                            <tr <?= $estilo;?>>
                                                <td><?= $a;?></td>
                                                <td><?= $ar->negocio_nombre;?></td>
                                                <td><?= $ar->ciudad_nombre;?></td>
                                                <td><?= $ar->negocio_direccion;?></td>
                                                <td><?= $ar->negocio_ruc;?></td>
                                                <td><?= $ar->negocio_telefono;?></td>
                                                <td><img class="rounded" src="<?= $foto;?>" alt="Foto de <?php echo $ar->negocio_nombre;?>" width="60"></td>
                                                <td>
                                                    <a class="btn btn-success" onclick="editar_negocio(<?= $ar->id_negocio?>,'<?= $ar->id_ciudad?>','<?= $ar->negocio_nombre?>','<?= $ar->negocio_direccion?>','<?= $ar->negocio_ruc?>','<?= $ar->negocio_foto?>','<?= $ar->negocio_telefono?>')" data-target="#negocio_editar" data-toggle="modal" title='Editar'><i class='fa fa-pencil text-white editar margen'></i></a>
                                                    <a class="btn btn-primary" href="<?php echo _SERVER_ . 'Negocio/sucursal/' . $ar->id_negocio;?>" title='Agregar Sucursal'><i class='fa fa-save text-white editar margen'></i></a>
                                                    <a class="btn btn-warning" href="<?php echo _SERVER_ . 'Negocio/usuarios_negocio/' . $ar->id_negocio;?>" title='Asignar Usuarios'><i class='fa fa-user text-white editar margen'></i></a>
                                                    <?php
                                                    if ($ar->negocio_estado == 0) {
                                                        ?>
                                                        <a class="btn btn-danger" onclick="preguntar('¿Esta seguro que quiere Habilitar este negocio?','habilitar','Si','No',<?= $ar->id_negocio ?>,1)" title='Cambiar Estado'><i class='fa fa-check text-white editar margen'></i></a>

                                                        <?php
                                                    }else{
                                                        ?>
                                                        <a class="btn btn-danger" onclick="preguntar('¿Esta seguro que quiere Deshabilitar este negocio?','deshabilitar','Si','No',<?= $ar->id_negocio ?>,0)" title='Cambiar Estado'><i class='fa fa-trash text-white editar margen'></i></a>

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
                <?php
            }
            ?>
        </div>
    </div>
</div>
<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>negocio.js"></script>

<script>
    function buscar_negocio(){
        var param2 = $("#parametro").val();
        var param = param2.replace(/ /g,'020');
        location.href=urlweb+"Negocio/gestionar/"+param;
    }

    $(document).ready(function (){
        $('#parametro').keypress(function(e){
            if(e.which === 13){
                buscar_negocio();
            }
        });
    });
</script>