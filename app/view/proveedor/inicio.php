<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 26/10/2020
 * Time: 23:24
 */
?>
<!-- Modal Agregar Proveedor-->
<div class="modal fade" id="gestionProveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar/Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="gestionarInfoProveedor">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="proveedor">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Negocio</label>
                                        <select class="form-control" id= "id_negocio" name="id_negocio">
                                            <option value="">Seleccionar Negocio</option>
                                            <?php
                                            foreach($negocio as $n){
                                                ?>
                                                <option value="<?php echo $n->id_negocio;?>"><?php echo $n->negocio_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Tipo de documento</label>
                                        <select class="form-control" id="id_tipodocumento" name="id_tipodocumento" onchange="tipo_documento()">
                                            <option value="">Seleccione</option>
                                            <?php
                                            foreach ($tipos_documento as $td){
                                                echo "<option value='".$td->id_tipodocumento."'>".$td->tipodocumento_identidad."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Nro Documento:</label>
                                        <input class="form-control" type="text" id="proveedor_ruc" onchange="consultar_documento(this.value)" onkeyup="return validar_numeros(this.id)" name="proveedor_ruc" maxlength="15" placeholder="Ingrese Numero...">
                                    </div>
                                </div>
                            </div>
                        <div id="div_razon_social">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre Proveedor</label>
                                        <input class="form-control" type="text" id="proveedor_nombre" name="proveedor_nombre" maxlength="200" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre Del Contacto</label>
                                        <input class="form-control" type="text" id="proveedor_nombre_contacto" name="proveedor_nombre_contacto" maxlength="200" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Cargo Del Contacto</label>
                                        <input class="form-control" type="text" id="proveedor_cargo_persona" name="proveedor_cargo_persona" maxlength="200" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Número de Teléfono</label>
                                        <input class="form-control" type="text" id="proveedor_numero" onkeyup="return validar_numeros(this.id)" name="proveedor_numero" maxlength="9" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Dirección</label>
                                        <textarea class="form-control" type="text" id="proveedor_direccion" name="proveedor_direccion" maxlength="200" placeholder="Ingrese Información..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="limpiar()" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-agregar-proveedor"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Editar Proveedor-->
<div class="modal fade" id="editarDatosProveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Editar Proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="editarInformacionProveedor">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="proveedor">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Negocio</label>
                                        <select class="form-control" id= "id_negocio_e" name="id_negocio_e">
                                            <option value="">Seleccionar Negocio</option>
                                            <?php
                                            foreach($negocio as $n){
                                                ?>
                                                <option value="<?php echo $n->id_negocio;?>"><?php echo $n->negocio_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Tipo de documento</label>
                                        <select class="form-control" id="id_tipodocumento_e" name="id_tipodocumento_e">
                                            <option value="">Seleccione</option>
                                            <?php
                                            foreach ($tipos_documento as $td){
                                                echo "<option value='".$td->id_tipodocumento."'>".$td->tipodocumento_identidad."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Nro Documento:</label>
                                        <input class="form-control" type="text" id="proveedor_ruc_e" onchange="consultar_documento_e(this.value)" onkeyup="return validar_numeros(this.id)" name="proveedor_ruc_e" maxlength="15" placeholder="Ingrese Numero...">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Proveedor</label>
                                        <input class="form-control" type="hidden" id="id_proveedor" name="id_proveedor" maxlength="11" readonly>
                                        <input class="form-control" type="text" id="proveedor_nombre_e" name="proveedor_nombre_e" maxlength="200" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre Del Contacto</label>
                                        <input class="form-control" type="text" id="proveedor_nombre_contacto_e" name="proveedor_nombre_contacto_e" maxlength="200" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Cargo Del Contacto</label>
                                        <input class="form-control" type="text" id="proveedor_cargo_persona_e" name="proveedor_cargo_persona_e" maxlength="200" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Número de Teléfono</label>
                                        <input class="form-control" type="text" id="proveedor_numero_e" onkeyup="return validar_numeros(this.id)" name="proveedor_numero_e" maxlength="9" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Direccion</label>
                                        <textarea class="form-control" type="text" id="proveedor_direccion_e" name="proveedor_direccion_e" placeholder="Ingrese Información..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-editar-proveedor"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
                <button data-toggle="modal" data-target="#gestionProveedor" onclick="cambiar_texto_formulario('exampleModalLabel', 'Agregar Nuevo Proveedor'); agregacion_proveedor()" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Nuevo</button>
            </div>
            <!-- /.row (main row) -->
            <div class="row">
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h4 class="m-0 font-weight-bold text-primary">Lista de Proveedores Registrados</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-earning" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>ID</th>
                                        <th>Negocio</th>
                                        <th>Tipo Documento</th>
                                        <th>Proveedor</th>
                                        <th>RUC / DNI</th>
                                        <th>Dirección</th>
                                        <th>Nombre Contacto</th>
                                        <th>Cargo</th>
                                        <th>Telefono</th>
                                        <th>Opciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($proveedor as $m){
                                        ?>
                                        <tr>
                                            <td><?= $a;?></td>
                                            <td><?= $m->negocio_nombre;?></td>
                                            <td><?= $m->tipodocumento_identidad;?></td>
                                            <td><?= $m->proveedor_nombre;?></td>
                                            <td><?= $m->proveedor_ruc;?></td>
                                            <td><?= $m->proveedor_direccion;?></td>
                                            <td><?= $m->proveedor_nombre_contacto;?></td>
                                            <td><?= $m->proveedor_cargo_persona;?></td>
                                            <td><?php echo $m->proveedor_numero;?></td>
                                            <td>
                                                <button id="botonproveedor<?= $m->id_proveedor;?>" data-toggle="modal" data-target="#editarDatosProveedor" onclick="editar_proveedor(<?= $m->id_proveedor;?>,'<?= $m->id_negocio;?>','<?= $m->id_tipodocumento;?>','<?= $m->proveedor_nombre;?>', '<?= $m->proveedor_ruc;?>', '<?= $m->proveedor_direccion;?>', '<?= $m->proveedor_nombre_contacto;?>', '<?= $m->proveedor_cargo_persona;?>', '<?= $m->proveedor_numero;?>', <?= $m->proveedor_estado;?>)" class="btn btn-info " ><i class="fa fa-pencil"></i></button>
                                                <button id="btn-eliminarproveedor<?= $m->id_proveedor;?>" class="btn btn-danger" onclick="preguntar('¿Está seguro que desea eliminar este proveedor?','eliminar_proveedor','Si','No',<?= $m->id_proveedor;?>)"><i class="fa fa-trash"></i></button>
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
<script src="<?php echo _SERVER_ . _JS_;?>proveedor.js"></script>

<script type="text/javascript">
    $(document).ready(function (){
        $('#div_razon_social').hide();
    });

    function limpiar(){
        $('#id_negocio').val('');
        $('#id_tipodocumento').val('');
        $('#proveedor_ruc').val('');
        $('#proveedor_nombre').val('');
        $('#proveedor_nombre_contacto').val('');
        $('#proveedor_cargo_persona').val('');
        $('#proveedor_numero').val('');
        $('#proveedor_direccion').val('');
    }
    function tipo_documento(){
        var tipo_doc = $('#id_tipodocumento').val();
        if(tipo_doc != ""){
            if(tipo_doc != "4"){
                $('#div_razon_social').show();
            }else{
                $('#div_razon_social').show();
            }
        }else{
            $('#div_razon_social').hide();
        }
    }

    function consultar_documento(valor){
        var tipo_doc = $('#id_tipodocumento').val();
        if(tipo_doc == "2"){
            ObtenerDatosDni(valor);
        }else if(tipo_doc == "4"){
            ObtenerDatosRuc(valor);
        }
    }

    function consultar_documento_e(valor){
        var tipo_doc = $('#id_tipodocumento_e').val();
        if(tipo_doc == "2"){
            ObtenerDatosDni_e(valor);
        }else if(tipo_doc == "4"){
            ObtenerDatosRuc_e(valor);
        }
    }

    function ObtenerDatosDni_e(valor){
        var numero_dni =  valor;

        $.ajax({
            type: "POST",
            url: urlweb + "api/Proveedor/obtener_datos_x_dni",
            data: "numero_dni="+numero_dni,
            dataType: 'json',
            success:function (r) {
                $("#proveedor_nombre_e").val(r.result.name+ ' ' + r.result.first_name+ ' ' + r.result.last_name);
            }
        });
    }

    function ObtenerDatosRuc_e(valor){
        var numero_ruc =  valor;

        $.ajax({
            type: "POST",
            url: urlweb + "api/Proveedor/obtener_datos_x_ruc",
            data: "numero_ruc="+numero_ruc,
            dataType: 'json',
            success:function (r) {
                $("#proveedor_nombre_e").val(r.result.razon_social);
            }
        });
    }

    function ObtenerDatosDni(valor){
        var numero_dni =  valor;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Proveedor/obtener_datos_x_dni",
            data: "numero_dni="+numero_dni,
            dataType: 'json',
            success:function (r) {
                $("#proveedor_nombre").val(r.result.name+ ' ' + r.result.first_name+ ' ' + r.result.last_name);
            }
        });
    }

    function ObtenerDatosRuc(valor){
        var numero_ruc =  valor;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Proveedor/obtener_datos_x_ruc",
            data: "numero_ruc="+numero_ruc,
            dataType: 'json',
            success:function (r) {
                $("#proveedor_nombre").val(r.result.razon_social);
            }
        });
    }

</script>