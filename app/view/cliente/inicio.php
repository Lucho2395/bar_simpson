<?php
/**
 * Created by PhpStorm
 * User: Franz
 * Date: 22/03/2021
 * Time: 10:38
 */
?>
<div class="modal fade" id="gestionCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Cliente Nuevo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="gestionarInfoCliente">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="cliente">
                            <div class="row">
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
                                        <input class="form-control" type="text" id="cliente_numero" onchange="consultar_documento(this.value)" onkeyup="return validar_numeros(this.id)" name="cliente_numero" maxlength="15" placeholder="Ingrese Telefono...">
                                    </div>
                                </div>
                                <div class="col-lg-12" id="div_nombre">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre Completo:</label>
                                        <input class="form-control" type="text" id="cliente_nombre" name="cliente_nombre" maxlength="500" placeholder="Ingrese Nombre...">
                                    </div>
                                </div>
                                <!--<div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Apellido Paterno:</label>
                                        <input class="form-control" type="text" id="cliente_apellido_paterno" name="cliente_apellido_paterno" maxlength="200" placeholder="Ingrese Apellido...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Apellido Materno:</label>
                                        <input class="form-control" type="text" id="cliente_apellido_materno" name="cliente_apellido_materno" maxlength="200" placeholder="Ingrese Apellido...">
                                    </div>
                                </div>-->
                            </div>
                            <div class="row">
                                <div class="col-lg-12" id="div_razon_social">
                                    <div class="form-group">
                                        <label class="col-form-label">Razón Social:</label>
                                        <textarea rows="2" class="form-control" type="text" id="cliente_razonsocial" name="cliente_razonsocial" maxlength="500" placeholder="Ingrese Razón Social..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="div_direcciones">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Dirección:</label>
                                        <textarea rows="2" class="form-control" type="text" id="cliente_direccion" name="cliente_direccion" maxlength="500" placeholder="Ingrese Dirección..."></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">2° Dirección :</label>
                                        <textarea rows="2" class="form-control" type="text" id="cliente_direccion_2" name="cliente_direccion_2" maxlength="500" placeholder="Ingrese Dirección..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="div_telefono_correo">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Correo:</label>
                                        <input class="form-control" type="text" id="cliente_correo" name="cliente_correo" maxlength="500" placeholder="Ingrese Correo...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Teléfono:</label>
                                        <input class="form-control" type="text" id="cliente_telefono" onkeyup="return validar_numeros(this.id)" name="cliente_telefono" maxlength="30" placeholder="Ingrese Telefono...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="limpiar()" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-agregar-cliente"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editarCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Datos del Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="gestionarInfoClienteEdit">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="cliente">
                            <div class="row">
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
                                        <input class="form-control" type="text" id="cliente_numero_e" onchange="consultar_documento_e(this.value)" onkeyup="return validar_numeros(this.id)" name="cliente_numero_e" maxlength="15" placeholder="Ingrese Telefono...">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre Cliente</label>
                                        <input class="form-control" type="hidden" id="id_cliente" name="id_cliente" maxlength="20">
                                        <input class="form-control" type="text" id="cliente_nombre_e" name="cliente_nombre_e" maxlength="500" placeholder="Ingrese Nombre...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Razón Social:</label>
                                        <textarea rows="2" class="form-control" type="text" id="cliente_razonsocial_e" name="cliente_razonsocial_e" maxlength="500" placeholder="Ingrese Razón Social..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                    <label class="col-form-label">Dirección</label>
                                        <textarea rows="2" class="form-control" type="text" id="cliente_direccion_e" name="cliente_direccion_e" maxlength="500" placeholder="Ingrese Dirección..."></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">2° Dirección</label>
                                        <textarea rows="2" class="form-control" type="text" id="cliente_direccion_2_e" name="cliente_direccion_2_e" maxlength="500" placeholder="Ingrese Dirección..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label class="col-form-label">Teléfono</label>
                                        <input class="form-control" type="text" id="cliente_telefono_e" onkeyup="return validar_numeros(this.id)" name="cliente_telefono_e" maxlength="30" placeholder="Ingrese Telefono...">
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="form-group">
                                        <label class="col-form-label">Correo:</label>
                                        <textarea rows="2" class="form-control" type="email" id="cliente_correo_e" name="cliente_correo_e" maxlength="500" placeholder="Ingrese Correo..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-editar-cliente"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="puntos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 50% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Puntos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid"
                <div id="familia">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="col-form-label">Cantidad Puntos :</label>
                                <input class="form-control" type="text" id="puntos_cantidad" name="puntos_cantidad" onkeyup="validar_numeros_decimales_dos(this.id)" placeholder="Ingrese Datos...">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="col-form-label">Valor S/. :</label>
                                <input class="form-control" type="text" id="puntos_cantidad_soles" name="puntos_cantidad_soles" onkeyup="validar_numeros_decimales_dos(this.id)" placeholder="Ingrese Datos...">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group" style="margin-top: 38px">
                                <button class="btn btn-success" id="btn-agregar-puntos" onclick="guardar_puntos()" ><i class="fa fa-save"></i> Guardar</button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h4>Listado de Puntos </h4></div>
                        <div class="col-lg-12">
                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="text-capitalize">
                                            <tr>
                                                <th>Cantidad de Puntos</th>
                                                <th>Valor en S/.</th>
                                                <th>Acción</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $a = 1;
                                            foreach ($puntos as $m){
                                                ?>
                                                <tr>
                                                    <td><?= $m->puntos_cantidad;?></td>
                                                    <td><?= $m->puntos_cantidad_soles;?></td>
                                                    <td></td>
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

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <div class="row">
                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-6"></div>
                <div class="col-lg-2 col-md-3 col-xs-3 col-sm-3">
                    <button type="submit" data-toggle="modal" data-target="#puntos" class="btn btn-primary"><i class="fa fa-circle-o"></i> Gestionar Puntos</button>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-3">
                    <button type="submit" data-toggle="modal" data-target="#gestionCliente" class="btn btn-primary"><i class="fa fa-plus"></i> Agregar Nuevo</button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h2><b><u>Clientes Registrados</u></b></h2></div>
                <div class="col-lg-12 col-xs-12 col-md-12 col-sm-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless" id="dataTable2" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr style="background-color: lightblue">
                                        <th>ID</th>
                                        <th>Nombre / Razón Social</th>
                                        <th>DNI/RUC</th>
                                        <th>Dirección</th>
                                        <th>Teléfono</th>
                                        <th>Correo</th>
                                        <th>Fecha de Registro</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($clientes as $m){
                                        $estado = "DESHABILITADO";
                                        $estilo_estado = "class=\"texto-deshabilitado\"";
                                        if($m->cliente_estado == 1){
                                            $estado = "HABILITADO";
                                            $estilo_estado = "class=\"texto-habilitado\"";
                                        }
                                        if($m->id_tipodocumento != "4"){
                                            $nombre = $m->cliente_nombre;
                                        }else{
                                            $nombre = $m->cliente_razonsocial;
                                        }

                                        ?>

                                        <tr>
                                            <td><?= $a;?></td>
                                            <td id="clientenombre<?= $m->id_cliente;?>"><?= $nombre;?></td>
                                            <td id="clientenumero<?= $m->id_cliente;?>"><?= $m->cliente_numero;?></td>
                                            <td id="clientedireccion<?= $m->id_cliente;?>">
                                                <?php
                                                if($m->cliente_direccion != ""){
                                                    echo "- $m->cliente_direccion <br>";
                                                }
                                                if($m->cliente_direccion_2 != ""){
                                                    echo "- $m->cliente_direccion_2";
                                                }
                                                ?>
                                            </td>
                                            <td id="clientetelefono<?= $m->id_cliente;?>"><?= $m->cliente_telefono;?></td>
                                            <td id="clientecorreo<?= $m->id_cliente;?>"><?= $m->cliente_correo;?></td>
                                            <td><?= date('d-m-Y', strtotime($m->cliente_fecha));?></td>
                                            <td>
                                                <div id="botoncliente<?= $m->id_cliente;?>">
                                                    <button data-toggle="modal" data-target="#editarCliente" onclick="editar_cliente(<?= $m->id_cliente;?>, '<?= $m->cliente_razonsocial;?>', '<?= $m->cliente_nombre;?>', '<?= $m->cliente_apellido_paterno;?>', '<?= $m->cliente_apellido_materno;?>', '<?= $m->cliente_numero;?>', '<?= $m->cliente_correo;?>','<?= $m->cliente_direccion;?>','<?= $m->cliente_direccion_2;?>','<?= $m->cliente_telefono;?>','<?= $m->cliente_fecha;?>','<?= $m->cliente_estado;?>',<?= $m->id_tipodocumento;?>)"  class="btn btn-sm btn-primary btne" ><i class="fa fa-pencil"></i></button>
                                                </div>
                                                <div id="">
                                                    <button id="btn-eliminar_cliente<?= $m->id_cliente;?>" class="btn btn-sm btn-danger btne" onclick="preguntar('¿Está seguro que desea eliminar este registro?','eliminar_cliente','Si','No',<?= $m->id_cliente;?>)"><i class="fa fa-trash"></i></button>
                                                </div>
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
<script src="<?php echo _SERVER_ . _JS_;?>cliente.js"></script>
<script type="text/javascript">
    $(document).ready(function (){
        $('#div_razon_social').hide();
        $('#div_nombre').hide();
        $("#div_direcciones").hide();
        $("#div_telefono_correo").hide();
    });
    function limpiar(){
        $('#id_tipodocumento').val('');
        $('#cliente_numero').val('');
        $('#cliente_nombre').val('');
        $('#cliente_razonsocial').val('');
        $('#cliente_direccion').val('');
        $('#cliente_direccion_2').val('');
        $('#cliente_telefono').val('');
        $('#cliente_correo').val('');
    }
    function tipo_documento(){
        var tipo_doc = $('#id_tipodocumento').val();
        if(tipo_doc != ""){
            if(tipo_doc != "4"){
                $('#div_razon_social').hide();
                $('#div_nombre').show();
                $('#cliente_razonsocial').val('');

            }else{
                $('#div_razon_social').show();
                $('#div_nombre').hide();
                $('#cliente_nombre').val('');
            }
            $("#div_direcciones").show();
            $("#div_telefono_correo").show();
        }else{
            $('#div_razon_social').hide();
            $('#div_nombre').hide();
            $("#div_direcciones").hide();
            $("#div_telefono_correo").hide();
        }
    }

    function consultar_documento(valor){
        var tipo_doc = $('#id_tipodocumento').val();

        if(tipo_doc == "2"){
            if(valor.length==8){
                ObtenerDatosDni(valor);
            }else{
                alert('El numero debe tener 8 digitos');
            }
        }else if(tipo_doc == "4"){
            if (valor.length==11){
                ObtenerDatosRuc(valor);
            }else{
                alert('El numero debe tener 11 digitos');
            }

        }
    }

    function consultar_documento_e(valor){
        var tipo_doc = $('#id_tipodocumento_e').val();
        if(tipo_doc == "2"){
            if(valor.length==8){
                ObtenerDatosDni_e(valor);
            }else{
                alert('El numero debe tener 8 digitos');
            }
        }else if(tipo_doc == "4"){
            if (valor.length==11){
            ObtenerDatosRuc_e(valor);
            }else{
                alert('El numero debe tener 11 digitos');
            }
        }
    }

    function ObtenerDatosDni(valor){
        var numero_dni =  valor;
        var cliente_nombre = 'cliente_nombre';

        $.ajax({
            type: "POST",
            url: urlweb + "api/Cliente/obtener_datos_x_dni",
            data: "numero_dni="+numero_dni,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(cliente_nombre, 'buscando...', true);
            },
            success:function (r) {
                cambiar_estado_boton(cliente_nombre, "", false);
                $("#cliente_nombre").val(r.result.name+ ' ' + r.result.first_name+ ' ' + r.result.last_name);
            }
        });
    }

    function ObtenerDatosRuc(valor){
        var numero_ruc =  valor;
        var cliente_razonsocial = 'cliente_razonsocial';

        $.ajax({
            type: "POST",
            url: urlweb + "api/Cliente/obtener_datos_x_ruc",
            data: "numero_ruc="+numero_ruc,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(cliente_razonsocial, 'buscando...', true);
            },
            success:function (r) {
                cambiar_estado_boton(cliente_razonsocial, "", false);
                $("#cliente_razonsocial").val(r.result.razon_social);
            }
        });
    }

    function ObtenerDatosDni_e(valor){
        var numero_dni =  valor;

        $.ajax({
            type: "POST",
            url: urlweb + "api/Cliente/obtener_datos_x_dni",
            data: "numero_dni="+numero_dni,
            dataType: 'json',
            success:function (r) {
                $("#cliente_nombre_e").val(r.result.name+ ' ' + r.result.first_name+ ' ' + r.result.last_name);
            }
        });
    }

    function ObtenerDatosRuc_e(valor){
        var numero_ruc =  valor;

        $.ajax({
            type: "POST",
            url: urlweb + "api/Cliente/obtener_datos_x_ruc",
            data: "numero_ruc="+numero_ruc,
            dataType: 'json',
            success:function (r) {
                $("#cliente_razonsocial_e").val(r.result.razon_social);
            }
        });
    }

</script>


